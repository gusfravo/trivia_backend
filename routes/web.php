<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/felicitaciones/{id}', function ($id) {
  $profile = App\Profile::where('user_id',$id)->first();
  $trivia = App\Trivia::find('1');
  $game = App\Game::where('profile_id',$profile->id)->where('trivia_id',$trivia->id)->first();

  $listGA = $game->gameAnswers;
  $listQ = $trivia->questions;
  $totalCorrect = 0;
  $totalIncorrect = 0;
  $totalQuestions =  sizeof($listQ);

  foreach ($listGA as &$item) {
      if($item->correct == 1){
        $totalCorrect++;
      }else{
        $totalIncorrect++;
      }
  }
  $hour = floor($game->time/1000/60/60);
  $minute = floor(($game->time/1000/60/60 - $hour)*60);
  if($profile->img != ''){
    $img = "/st/rally/server/public/uploads/".$profile->img;
  }else{
    $img = "/st/rally/server/public/assets/img/circulo-usuariofinal.png";
  }

  $requestAux = array(
    "profile" =>$profile,
    "trivia" => $trivia,
    "game" => $game,
    "score" => [
      "totalCorrect"=>$totalCorrect,
      "totalIncorrect"=>$totalIncorrect,
      "totalQuestions"=>$totalQuestions
    ],
    "time" =>[
      "hour"=>$hour,
      "minute"=>$minute
      ],
    "img" => $img
  );
    return view('congrats',['request'=>$requestAux]);
});
