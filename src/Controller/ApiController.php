<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use App\Document\Resume;
use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpKernel\HttpCache\Store;

/**
 * Class ApiController
 * @package App\Controller
 */
class ApiController extends AbstractController
{
    private $dm;
    private $serializer;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/api/cv", name="getResumeList", methods={"GET"})
     */
    public function getResumeList(Request $request)
    {
        /** @var Resume[] $data */
        $data = $this->dm->getRepository(Resume::class)->findAll();

        $serializedItemsArray = [];
        foreach ($data as $item)
        {
            $serializedItem = $this->serializer->normalize($item, null,
                [AbstractNormalizer::ATTRIBUTES => ['id', 'firstName', 'lastName', 'patronymic', 'birthday', 'desiredPost', 'status', 'photo'],
                    DateTimeNormalizer::FORMAT_KEY => 'Y-m-d']);
            $serializedItemsArray[] = $serializedItem;
        }

        return new JsonResponse(json_encode([
            'status' => 'success',
            'data' => $serializedItemsArray
        ]));
    }

    /**
     * @Route("/api/cv/{id}", name="getResume", methods={"GET"})
     */
    public function getResume($id, Request $request): JsonResponse
    {
        $resume = $this->dm->getRepository(Resume::class)->find($id);

        if (! $resume) {
            return new JsonResponse(json_encode([
                'status' => 'error',
                'error' => 'Not found'
            ]));
        }

        try
        {
            $resumeData = $this->serializer->normalize($resume);
        }
        catch (\Exception $e)
        {
            return new JsonResponse(json_encode([
                'status' => 'error',
                'error' => 'Serialization failed'
            ]));
        }

        return new JsonResponse(json_encode([
            'status' => 'success',
            'data' => $resumeData
        ]));
    }

    /**
     * @Route("/api/cv/add", name="createResume", methods={"POST"})
     */
    public function createResume(Request $request): JsonResponse
    {
        $data = $request->getContent();

        try
        {
            /** @var Resume $resume */
            $resume = $this->serializer->deserialize($data, Resume::class, 'json');
        }
        catch (\Exception $e)
        {
            return new JsonResponse(json_encode([
                'status' => 'error',
                'error' => 'Wrong object structure'
            ]));
        }

        $this->dm->persist($resume);
        $this->dm->flush();

        return new JsonResponse(json_encode([
            'status' => 'success',
            'id' => $resume->getId()
        ]));
    }

    /**
     * @Route("/api/cv/{id}/edit", name="editResume", methods={"POST"})
     */
    public function editResume($id, Request $request): JsonResponse
    {
        $data = $request->getContent();

        $resume = $this->dm->getRepository(Resume::class)->find($id);
        if (! $resume) {
            return new JsonResponse(json_encode([
                'status' => 'error',
                'error' => 'Not found'
            ]));
        }

        try {
            $this->serializer->deserialize($data, Resume::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $resume]);
        }
        catch (\Exception $e)
        {
            return new JsonResponse(json_encode([
                'status' => 'error',
                'error' => 'Wrong object structure'
            ]));
        }
        $this->dm->flush();

        return new JsonResponse(json_encode([
            'status' => 'success'
        ]));
    }

    /**
     * @Route("/api/cv/{id}/status/update", name="updateResumeStatus", methods={"POST"})
     */
    public function updateResumeStatus($id, Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $updatedStatus = isset($data['status']) ? $data['status']: null;

        /** @var Resume $resume */
        $resume = $this->dm->getRepository(Resume::class)->find($id);
        if (! ($resume && $updatedStatus)) {
            return new JsonResponse(json_encode([
                'status' => 'error',
                'error' => 'Invalid request'
            ]));
        }

        $resume->setStatus($updatedStatus);
        $this->dm->flush();

        return new JsonResponse(json_encode([
            'status' => 'success'
        ]));
    }

    /**
     * @Route("/api/vk/countries-list", name="getCountriesList", methods={"GET"})
     */
    public function getCountries(Request $request)
    {
        $q = $request->query->get('q');
        $count = $request->query->get('count');

        if (! $q)
        {
            return new JsonResponse(json_encode([
                'status' => 'error',
                'error' => 'incorrect request parameter'
            ]));
        }

        $store = new Store($this->getParameter('client-storage'));
        $client = HttpClient::create();
        $client = new CachingHttpClient($client, $store);

        $parameters = [
            'need_all' => '1',
            'count' => '1000',
            'access_token' => $this->getParameter('vk-access-token'),
            'v' => $this->getParameter('vk-api-version'),
            'lang' => 'ru'
        ];
        $p = implode('&', array_map(
            function($v, $k) {
                return $v . '=' . $k;
            }, array_keys($parameters), $parameters
        ));
        $url = 'https://api.vk.com/method/database.getCountries?' . $p;
        $response = $client->request('GET', $url);

        if (strval($response->getStatusCode()) !== '200') {
            return new JsonResponse(json_encode([
                'status' => 'error',
                'error' => 'host didn\'t get response'
            ]));
        }

        $data = $response->toArray();

        $countries = $data['response']['items'];
        $filteredArray = array_filter($countries, function ($el) use ($q) {
            return (isset($el['title']) && str_contains(strtolower($el['title']), strtolower($q)));
        },ARRAY_FILTER_USE_BOTH);

        if ($count)
        {
            $filteredArray = array_slice($filteredArray, 0, $count);
        }

        return new JsonResponse(json_encode([
            'status' => 'success',
            'data' => $filteredArray
        ]));
    }
}