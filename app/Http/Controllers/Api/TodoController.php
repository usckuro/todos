<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ResponseController;
use App\Http\Requests\Api\IndexTodoRequest;
use App\Http\Requests\Api\ShowTodoRequest;
use App\Http\Requests\Api\StoreTodoRequest;
use App\Http\Requests\Api\UpdateTodoRequest;
use App\Models\Todo;
use Tymon\JWTAuth\Facades\JWTAuth;

class TodoController extends ResponseController
{
	public function index(IndexTodoRequest $request){
		$paginate = $request->input('paginate', 0);

		$limit = $request->input('limit', 10);

		$with_user = $request->input('with_user', 1);

		$with_comments = $request->input('with_comments', 1);

		$todo = Todo::byUser($request->user_id)
			->withUser($with_user)
			->withComments($with_comments)
			->getOption($paginate, $limit);

		return ResponseController::Response($todo);
	}

	/**
	 * @param ShowTodoRequest $request
	 * @param Todo $todo
	 * @return mixed
	 */
	public function show(ShowTodoRequest $request, Todo $todo){
		if($request->with_user)
			$todo->load('user');

		if($request->with_comments)
			$todo->load('comments');

		return ResponseController::Response($todo);
	}

	/**
	 * @param StoreTodoRequest $request
	 * @return mixed
	 */
	public function store(StoreTodoRequest $request){
		$user = JWTAuth::parseToken()->authenticate();

		$request->merge(['user_id' => $user->id]);

		$todo = Todo::create($request->all());

		return ResponseController::Response($todo);
	}

	/**
	 * @param UpdateTodoRequest $request
	 * @param Todo $todo
	 * @return mixed
	 */
	public function update(UpdateTodoRequest $request, Todo $todo){
		$todo->update($request->except('user_id'));

		return ResponseController::Response($todo);
	}

	/**
	 * @param Todo $todo
	 * @return mixed
	 * @throws \Exception
	 */
	public function destroy(Todo $todo){
		$todo->delete();

		return ResponseController::Response();
	}
}
