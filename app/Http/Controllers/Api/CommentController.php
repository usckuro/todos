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
		$comments = Comment::with('commentable', 'user')
			->get();

		return ResponseController::Response($comments);
	}

	public function show(Comment $comment){
		$comment->load('user', 'commentable');

		return ResponseController::Response($comment);
	}

	/**
	 * @param StoreCommentRequest $request
	 * @return $this
	 */
	public function store(StoreCommentRequest $request){
		$user = JWTAuth::parseToken()->authenticate();

		$request->merge([
		    'user_id' => $user->id,
            'commentable_type' => Comment::getCommentableClass($request->type)
        ]);

		$comment = Comment::create($request->except('type'));

		return ResponseController::Response($comment);
	}

	/**
	 * @param UpdateCommentRequest $request
	 * @param Comment $comment
	 * @return mixed
	 */
	public function update(UpdateCommentRequest $request, Comment $comment){
		$comment->update($request->except('user_id', 'commentable_id', 'commentable_type'));

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
