<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facebook extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'username',
        'access_token',
        'userid',
        'name',
        'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
      'created_at',
      'updated_at'
    ];
}
