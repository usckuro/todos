<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;

	protected $fillable = ['title', 'description', 'target_date', 'user_id'];

	protected $visible = ['id', 'title', 'description', 'target_date', 'user', 'comments'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(){
		return $this->belongsTo(User::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function comments(){
		return $this->hasMany(Comment::class);
	}

	/**
	 * @param $query
	 * @param $user_id
	 * @return mixed
	 */
	public function scopeByUser($query, $user_id){
		if($user_id)
			return $query->where('user_id', $user_id);

		return $query;
	}

	/**
	 * @param $query
	 * @param $with
	 * @return mixed
	 */
	public function scopeWithUser($query, $with){
		if($with)
			return $query->with('user');

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

}
