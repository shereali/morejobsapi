<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

trait ApiResponse
{
    protected function successResponse($message, $data = null, $code = Response::HTTP_OK, $options = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'status' => $code,
            'options' => $options
        ], $code);
    }

    protected function errorResponse($message = 'Something went wrong', $errors = [], $code = 500)
    {
        return response()->json(
            [
                'success' => false,
                'message' => $message,
                'errors' => $errors,
                'status' => $code
            ]);
    }

    protected function response($data, $message = null, $code = Response::HTTP_OK): JsonResponse
    {
        $isSuccess = false;

        if (is_array($data) && count($data) > 0) {
            $isSuccess = true;
        } elseif (!is_array($data) && $data) {
            $data = $data->toArray();
            $isSuccess = true;
        } else {
            $message = 'No records found!';
        }

        return response()->json([
            'success' => $isSuccess,
            'message' => $message,
            'data' => $data,
            'status' => $code
        ], $code);
    }

    protected function exception(\Exception $e): JsonResponse
    {
        if (env('APP_DEBUG') == true) {
            $log = 'Error: ' . $e->getMessage();
            $log .= ' Line: ' . $e->getLine();
            $log .= ' File: ' . $e->getFile();
        } else {
            $log = [];
        }
        return $this->errorResponse('Something went wrong', $log);
    }

    protected function validators($request, $rules)
    {
        $validator = Validator::make($request, $rules);
        if ($validator->fails()) {
            return $this->errorResponse('Please enter correct data', $validator->errors());
        }
        return true;
    }
}
