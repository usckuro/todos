<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Request;

class StoreCommentRequest extends Request
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
            'comment' => 'max:255',
            'task_id' => 'required_without:todo_id|exists:tasks,id',
            'todo_id' => 'required_without:task_id|exists:todos,id'
        ];
    }
}
