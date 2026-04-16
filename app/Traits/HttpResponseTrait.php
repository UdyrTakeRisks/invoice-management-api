<?php

namespace App\Traits;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait HttpResponseTrait
{
    protected function success($message, $data = [], $status = ResponseAlias::HTTP_OK): JsonResponse
    {
        $response = [
            'message' => $message,
            'data' => $data,
        ];

        if (!is_array($data) && $data?->additional) // if data is not array, e.g Json collection
            $response['meta'] = $data->additional;

        return response()->json($response, $status);
    }
    protected function created($message, $data = [], $status = ResponseAlias::HTTP_CREATED): Response
    {
        $response = [
            'message' => $message,
            'data' => $data,
        ];

        if (!is_array($data) && $data?->additional) // if data is not array, e.g Json Resource Collection
            $response['meta'] = $data->additional;

        return response($response, $status);
    }
    protected function unAuthorizedError($message, $errors, $status = ResponseAlias::HTTP_UNAUTHORIZED): Response
    {
        return response([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
    protected function forbiddenError($message, $errors, $status = ResponseAlias::HTTP_FORBIDDEN): Response
    {
        return response([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
    protected function validationError($message, $errors, $status = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY): Response
    {
        return response([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
    protected function serverError($message, $status = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR): Response
    {
        return response([
            'message' => $message,
        ], $status);
    }
    protected function notFoundError($message, $errors=[], $status = ResponseAlias::HTTP_NOT_FOUND): Response
    {
        return response([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
    protected function badRequest($message, $errors=[], $status = ResponseAlias::HTTP_BAD_REQUEST): Response
    {
        return response([
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}