<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;

class Trivia extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'img',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
      'created_at',
      'updated_at'
    ];

    public function questions()
      {
        return $this->hasMany(Question::class);
      }
}
