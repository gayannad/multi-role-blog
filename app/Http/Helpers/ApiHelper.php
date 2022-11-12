<?php


namespace App\Http\Helpers;


trait ApiHelper
{
    protected function apiSuccess($data, string $message = '', int $code = 200)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function apiError(int $code = 422, string $message = '')
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
        ], $code);
    }
}
