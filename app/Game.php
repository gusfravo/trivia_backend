<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Trivia;
use App\Profile;
use App\GameAnswer;

class Game extends Model
{
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = [
      'id',
      'time',// timepo en milisegundos de juego en la trivia
      'start',
      'end',
      'status', // Iniciada, Terminada, Ganador
      'trivia_id',
      'profile_id'
  ];

  /**
   * The attributes that should be hidden for arrays.
   */
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  /**Relación - Un juego le pertenece a un trivia
  */
  public function trivia()
  {
        return $this->belongsTo(Trivia::class);
  }

  /**Relación - Un juego le pertenece a un perfil de usuario
  */
  public function profile()
  {
        return $this->belongsTo(Profile::class);
  }

  /**Relación - Un juego tiene muchas respuestas
  */
  public function gameAnswers()
  {
    return $this->hasMany(GameAnswer::class);
  }

}
