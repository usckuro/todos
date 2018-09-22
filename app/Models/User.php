<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todos(){
        return $this->hasMany(Todo::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function tasks(){
        return $this->hasManyThrough(Task::class, TaskUser::class, 'task_id', 'id', null, 'task_id');
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
