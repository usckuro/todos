<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
	use SoftDeletes;

	protected $fillable = ['title', 'description', 'status'];

	protected $visible = ['id', 'title', 'description', 'status', 'users', 'comments'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users(){
		return $this->belongsToMany(User::class, 'task_users', 'task_id', 'user_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function comments(){
		return $this->hasMany(Comment::class);
	}

	public function task_users(){
		return $this->hasMany(TaskUser::class);
	}

	/**
	 * @param $query
	 * @param $user_id
	 * @return mixed
	 */
	public function scopeByUser($query, $user_id){
		if($user_id)
			return $query->join('task_users', 'tasks.id', '=', 'task_users.task_id')
				->where('user_id', $user_id);

		return $query;
	}

	/**
	 * @param $query
	 * @param $with
	 * @return mixed
	 */
	public function scopeWithUsers($query, $with){
		if($with)
			return $query->with('users');

		return $query;
	}

	/**
	 * @param $query
	 * @param $with
	 * @return mixed
	 */
	public function scopeWithComments($query, $with){
		if($with)
			return $query->with('comments');

		return $query;
	}

	/**
	 * @param $query
	 * @param $paginate
	 * @param $limit
	 * @return mixed
	 */
	public function scopeGetOption($query, $paginate, $limit){
		if($paginate){
			return $query->paginate($limit);
		}

		return $query->get();
	}

	/**
	 * @param $users
	 */
	public function addUsers($users){
		foreach($users as $user_id){
			$this->task_users()->save(new TaskUser(['user_id' => $user_id]));
		}
	}

	/***
	 * @param $users
	 */
	public function removeUsers($users){
		foreach($users as $user_id){
			$this->task_users()->where('user_id', $user_id)->delete();
		}
	}
}
