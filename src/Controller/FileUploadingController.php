<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class FileUploadingController
 * @package App\Controller
 */
class FileUploadingController extends AbstractController
{
    /**
     * @Route("/api/load", name="loadFile", methods={"POST"})
     */
    function uploadFile(Request $request): JsonResponse
    {
        $file = $request->files->get('userpic');

        if (! $file || array_search($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif']) === false) {
            return new JsonResponse(json_encode([
                'status' => 'success',
                'error' => 'Unexpected file type ' . $file->getMimeType()
            ]));
        }

        try {
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $this->getParameter('filedir'),
                $fileName
            );
        } catch (\Exception $e) {
            return new JsonResponse(json_encode([
                'status' => 'success',
                'error' => 'Error'
            ]));
        }

        return new JsonResponse(json_encode([
            'status' => 'success',
            'path' => $fileName
        ]));
    }
}