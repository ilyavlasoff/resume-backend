<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Document\Resume;

/**
 * Class ApiController
 * @package App\Controller
 */
class ApiController
{
    private $dm;
    private $serializer;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
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
                [AbstractNormalizer::ATTRIBUTES => ['id', 'firstName', 'lastName', 'patronymic', 'birthday', 'desiredPost']]);
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
            $resumeData = $this->serializer->serialize($resume, 'json');
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
                'data' => 'Wrong object structure'
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
}