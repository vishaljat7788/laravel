<?php

namespace App\Traits;

use App\Models\JsonResponse as ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Http\ResponseFactory;
use Illuminate\Http\Response as ResponseAlias;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{

    /**
     * Build success response
     * @param string|array $data
     * @param int $code
     * @return JsonResponse|ResponseAlias|ResponseFactory
     */
    public function successResponse($data, int $code =  Response::HTTP_OK)
    {
        // die("hey");
        return response($data,$code)->header("Content-Type","application/json");
    }

    /**
     * Build error response
     * @param $errors
     * @param int $code
     * @param string $status
     * @param String $message
     * @return JsonResponse
     */
    public function failureResponse($errors, int $code, String $status="ERROR", String $message = "Request Processing Failed"): JsonResponse
    {
        $response = new ApiJsonResponse;
        $response->data = null;
        $response->status = $status;
        $response->code = $code;
        $response->message = $message;
        $response->errors = $errors;
        return response()->json(['response' => $response], $code);
    }

    /**
     * Build error response
     * @param $messages
     * @param int $code
     * @return JsonResponse|ResponseAlias|ResponseFactory
     */
    public function errorResponse($messages, int $code)
    {
        return response($messages,$code)->header("Content-Type","application/json");
    }
}
