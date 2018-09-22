<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;


abstract class Request extends FormRequest
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpException(400, $validator->errors()->first(), null, []);
    }

    public function failedAuthorization(){
        throw new HttpException(400, 'not authorized', null, [], 403);
    }
}
