<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Trivia;

class Question extends Model
{
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = [
      'id',
      'question',
      'position',
      'img',
      'trivia_id',
  ];

  /**
   * The attributes that should be hidden for arrays.
   */
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public function trivia()
  {
        return $this->belongsTo(Trivia::class);
  }
}
