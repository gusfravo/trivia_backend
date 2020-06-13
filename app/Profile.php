<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Game;

class Profile extends Model
{
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = [
      'id',
      'name',
      'lastname',
      'phone',
      'origin',
      'img',
      'user_id'
  ];

  /**
   * The attributes that should be hidden for arrays.
   */
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public function user()
    {
        return $this->belongsTo(User::class);
    }

  /** Relación - Un perfil de usuario tiene muchos juegos
  */
  public function games()
  {
    return $this->hasMany(Game::class);
  }
}
