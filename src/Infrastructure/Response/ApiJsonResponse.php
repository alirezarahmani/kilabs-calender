<?php

namespace App\Infrastructure\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiJsonResponse extends JsonResponse implements ApiResponseInterface
{
    public function error(array $errors)
    {
        return (new JsonResponse(
            [
                'Data' => [],
                'Status' => false,
                'Message' => $errors
            ]
        ))->send();
    }
    public function success($data = [])
    {
        return (new JsonResponse(
            [
                'Data' => $data,
                'Status' => true,
                'Message' => ''
            ]
        ))->send();
    }
}