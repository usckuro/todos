<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ResponseController;
use App\Http\Requests\Api\IndexUserRequest;
use App\Http\Requests\Api\StoreUserRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends ResponseController
{
	/**
	 * @param IndexUserRequest $request
	 * @return mixed
	 */
	public function index(IndexUserRequest $request){
		$paginate = $request->input('paginate', 0);

		$limit = $request->input('limit', 10);

		$users = User::with('tasks', 'todos')
			->orderBy('name')
			->getOption($paginate, $limit);

		return ResponseController::Response($users);
	}

	/**
	 * @param User $user
	 * @return mixed
	 */
	public function show(User $user){
		$user->load('tasks', 'todos');

		return ResponseController::Response($user);
	}

	/**
	 * @param StoreUserRequest $request
	 * @return mixed
	 */
	public function store(StoreUserRequest $request){
		$request->merge(['password' => Hash::make($request->password)]);
		$user = User::create($request->all());
		return ResponseController::Response($user);
	}

	/**
	 * @param UpdateUserRequest $request
	 * @param User $user
	 * @return mixed
	 */
	public function update(UpdateUserRequest $request, User $user){
		if($request->has('password'))
			$request->merge(['password' => Hash::make($request->password)]);

		$user->update($request->except('email'));

		return ResponseController::Response($user);
	}

	/**
	 * @param User $user
	 * @return $this
	 * @throws \Exception
	 */
	public function destroy(User $user){
		$auth_user = JWTAuth::parseToken()->authenticate();

		if($auth_user->id == $user->id)
			return ResponseController::CustomError('You cannot delete yourself!');

		$user->delete();

		return ResponseController::Response();
	}
}
