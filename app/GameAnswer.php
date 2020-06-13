<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Game;
use App\Answer;

class GameAnswer extends Model
{
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = [
      'id',
      'correct',
      'game_id',
      'answer_id'
  ];

  /**
   * The attributes that should be hidden for arrays.
   */
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /** Relación - Una respuesta del jugador le pertenece a un juego
  */
  public function game()
  {
    return $this->belongsTo(Game::class);
  }

  /**Relación - Una respuesta de un jugador le pertenece a un respuesta de la trivia
  */
  public function answer()
  {
    return $this->belongsTo(Answer::class);
  }
}
