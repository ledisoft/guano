<?php

namespace App\Http\Requests;

use App\Http\Traits\APIResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class APIRequests extends FormRequest
{
    use APIResponse;

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException($this->response([], $validator->errors(), 422)));
    }
}
