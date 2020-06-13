<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;

class Answer extends Model
{
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = [
      'id',
      'answer',
      'correct',
      'question_id',
  ];

  /**
   * The attributes that should be hidden for arrays.
   */
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**función para relaciónar - Una respuesta le pertenece a una pregunta.
  */
  public function question()
  {
        return $this->belongsTo(Question::class);
  }
}
