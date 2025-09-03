<?php

namespace App\Http\Resources;

class ApiResponse
{
    public static function success($data = null, string $message = 'Success', int $statusCode = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }

    public static function error(string $message = 'Error', $errors = null, int $statusCode = 400)
    {
        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'errors'  => $errors,
        ], $statusCode);
    }

    public static function notFound(string $message = 'Not Found',  int $statusCode = 404)
    {
        return response()->json([
            'status'  => 'not found',
            'message' => $message,
        ], $statusCode);
    }
}
