<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class IndexTodoRequest extends Request
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
            'with_comments' => 'boolean',
            'with_user' => 'boolean',
            'page' => 'numeric|min:1',
            'limit' => 'numeric|min:1',
            'paginate' => 'boolean',
            'user_id' => 'exists:users,id'
        ];
    }
}
