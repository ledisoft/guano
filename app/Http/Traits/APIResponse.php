<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait APIResponse
{
    /**
     * Create a new JSON response instance.
     *
     * @param array $data
     * @param array $errors
     * @param int $status
     * @return JsonResponse
     */
    public function response($data = [], $errors = [], $status = Response::HTTP_OK): JsonResponse
    {
        /** @var boolean $success */
        $success = empty($errors) ? true : false;

        return response()->json(compact('data', 'errors', 'success'), $status);
    }
}
