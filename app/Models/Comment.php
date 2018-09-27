<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use SoftDeletes;

	protected $fillable = ['comment', 'user_id', 'commentable_id', 'commentable_type'];

	protected $visible = ['id', 'comment', 'user', 'commentable'];

	public $timestamps = false;

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(){
		return $this->belongsTo(User::class);
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
	public function commentable(){
	    return $this->morphTo('commentable', 'commentable_type', 'commentable_id', 'id');
    }

    /**
     * @param $type
     * @return null|string
     */
    public  static function getCommentableClass($type){
	    switch ($type){
            case 'task':
                return Task::class;
                break;
            case 'todo':
                return Todo::class;
                break;
            default:
                return null;
        }
    }
}

