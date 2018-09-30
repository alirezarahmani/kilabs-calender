<?php
declare(strict_types=1);
namespace App\Infrastructure\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiJsonResponse extends JsonResponse implements ApiResponseInterface
{
    public function error(string $errors)
    {
        if (($message = json_decode($errors, true)) != null) {
            $errors = $message;
        }

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
