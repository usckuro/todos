<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
	protected $primaryKey = null;

	public $incrementing = false;

	protected $fillable = ['task_id', 'user_id'];
}
