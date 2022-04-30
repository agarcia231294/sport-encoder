<?php

namespace App\Http\Share;

use Illuminate\Http\JsonResponse as HttpJsonResponse;

class JsonResponse
{
    
    const STATUS_SUCCESS = "success";
    const STATUS_ERROR = "error";
    const STATUS_REFUSED = "refused";
    const STATUS_NOT_FOUND = "not found";

    static public function response(string $status, string $message = "", array $data = null, int $code = 200): HttpJsonResponse
    {
        $dataResponse = [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
        $dataResponse['message'] = $message;
        $dataResponse['data'] = $data;
        return response()->json($dataResponse,$code);
    }
}