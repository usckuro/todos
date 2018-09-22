<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ResponseController;
use App\Http\Requests\Api\StoreCommentRequest;
use App\Http\Requests\Api\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentController extends ResponseController
{
	/**
	 * @return mixed
	 */
    public function index(){
		$task_comments = Comment::whereNotNull('task_id')
			->with('task', 'user')
			->get();

		$todo_comments = Comment::whereNotNull('todo_id')
			->with('todo', 'user')
			->get();

		$all_comments = $task_comments->merge($todo_comments)->sortby('id')->values()->all();

		return ResponseController::Response($all_comments);
	}

	public function show(Comment $comment){
		$related_model = ($comment->task_id) ? 'task': 'todo';

		$comment->load('user', $related_model);

		return ResponseController::Response($comment);
	}

	/**
	 * @param StoreCommentRequest $request
	 * @return $this
	 */
	public function store(StoreCommentRequest $request){
		$user = JWTAuth::parseToken()->authenticate();

		$request->merge(['user_id' => $user->id]);

		if($request->has('task_id') && $request->has('todo_id'))
			return ResponseController::CustomError('Invalid properties');

		$comment = Comment::create($request->all());

		return ResponseController::Response($comment);
	}

	/**
	 * @param UpdateCommentRequest $request
	 * @param Comment $comment
	 * @return mixed
	 */
	public function update(UpdateCommentRequest $request, Comment $comment){
		$comment->update($request->except('user_id', 'task_id', 'todo_id'));

		return ResponseController::Response($comment);
	}

	/**
	 * @param Comment $comment
	 * @return mixed
	 * @throws \Exception
	 */
	public function destroy(Comment $comment){
		$comment->delete();

		return ResponseController::Response();
	}
}
