<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class UpdateTodoRequest extends Request
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
            'target_date' => 'date_format:Y-m-d'
        ];
    }
}
