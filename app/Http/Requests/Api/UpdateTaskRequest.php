<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class UpdateTaskRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'max:120',
            'status' => 'in:pending,complete',
            'users' => 'array',
            'users.add.*' => 'exists:users,id',
            'users.remove.*' => 'exists:users,id'
        ];
    }
}