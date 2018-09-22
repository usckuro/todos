<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ResponseController;
use App\Http\Requests\Api\IndexTaskRequest;
use App\Http\Requests\Api\ShowTaskRequest;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Http\Requests\Api\UpdateTaskRequest;
use App\Models\Task;
use App\Models\TaskUser;

class TaskController extends ResponseController
{
	/**
	 * @param IndexTaskRequest $request
	 * @return mixed
	 */
	public function index(IndexTaskRequest $request){
		$paginate = $request->input('paginate', 0);

		$limit = $request->input('limit', 10);

		$with_user = $request->input('with_user', 1);

		$with_comments = $request->input('with_comments', 1);

		$tasks = Task::byUser($request->user_id)
			->withUsers($with_user)
			->withComments($with_comments)
			->getOption($paginate, $limit);

		return ResponseController::Response($tasks);
	}

	/**
	 * @param ShowTaskRequest $request
	 * @param Task $task
	 * @return mixed
	 */
	public function show(ShowTaskRequest $request, Task $task){
		if($request->with_user)
			$task->load('users');

		if($request->with_comments)
			$task->load('comments');

		return ResponseController::Response($task);
	}

	/**
	 * @param StoreTaskRequest $request
	 * @return mixed
	 */
	public function store(StoreTaskRequest $request){
		$task = Task::create($request->except('status', 'users'));

		foreach($request->input('users', []) as $user_id){
			$task->task_users()->save(new TaskUser(['user_id' => $user_id]));
		}

		return ResponseController::Response($task);
	}

	/**
	 * @param UpdateTaskRequest $request
	 * @param Task $task
	 * @return mixed
	 */
	public function update(UpdateTaskRequest $request, Task $task){
		$task->addUsers($request->input('users.add', []));
		$task->removeUsers($request->input('users.remove', []));
		$task->update($request->except('users'));

		return ResponseController::Response($task);
	}

	/**
	 * @param Task $task
	 * @return mixed
	 * @throws \Exception
	 */
	public function destroy(Task $task){
		$task->delete();

		return ResponseController::Response();
	}
}
