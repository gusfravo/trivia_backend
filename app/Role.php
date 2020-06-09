<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
  /**
   * The attributes that are mass assignable.
   */
  protected $fillable = [
      'id',
      'name',
      'description',
      'status',
  ];

  /**
   * The attributes that should be hidden for arrays.
   */
  protected $hidden = [
    'created_at',
    'updated_at'
  ];

  public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
