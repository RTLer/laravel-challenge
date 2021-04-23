<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{

    /**
     * @param $data
     * @param string $message
     * @param int $code
     *
     * @return JsonResponse
     */
    public function successResponse($data, $message = '', $code = Response::HTTP_OK): JsonResponse
    {
        $return = [
            'data'    => $data,
            'message' => $message
        ];
        if (is_null($data)) {
            unset($return['data']);
        }

        return response()->json($return, $code);
    }

    public function errorResponse($errors, $message = '', $code = 400, $description = ''): JsonResponse
    {
        $return = [
            'code'        => $code,
            'message'     => $message,
            'errors'      => $errors,
            'description' => $description
        ];
        if (is_null($errors)) {
            unset($return['errors']);
        }

        return response()->json($return, $code);
    }

    public function errorAuthorization($message)
    {
        return $this->errorResponse([], $message, 403);
    }
}
