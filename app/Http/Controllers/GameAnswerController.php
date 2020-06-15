<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GameAnswer;
use App\Answer;
use App\Game;
use App\Trivia;

class GameAnswerController extends Controller
{
  /**Método para validar si una respuesta es correcta
  */
  public function valid(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      //Declaramos el nombre con el nombre enviado en el request
      $gameAnswer = new GameAnswer;

      $gameAnswer->game_id = $reqst->game->id;
      $gameAnswer->answer_id = $reqst->answer->id;
      // verificamos si la respuesta es correcta o incorrecta
      $answer = Answer::find($reqst->answer->id);
      $correct = $answer->correct == 1 ? true : false;
      $gameAnswer->correct = $correct;

      $gameAnswer->save();
      if(empty($gameAnswer->id)){
        return response()->json([
          "transaction" => "ok",
          "object" => $gameAnswer,
          "message" =>  "El registro se creo correctamente",
          "code" => "gameAnswer:validate:001"
        ], 201);
      }else{
        return response()->json([
          "transaction" => "ok",
          "object" => $gameAnswer,
          "message" =>  "El registro se actualizo correctamente",
          "code" => "gameAnswer:validate:002"
        ], 200);
      }

    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:gameAnswer:validate:001"
      ], 500);
    }
  }

  /**Metodo para obtener cuantas respuesta correctas se obtuvieron por correct
  */
  public function findTotalsByGame(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      //Declaramos el nombre con el nombre enviado en el request
      $game = Game::find($reqst->id);
      $trivia = Trivia::find($game->trivia_id);
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

      if(empty($gameAnswer->id)){
        return response()->json([
          "transaction" => "ok",
          "object" => [
            "totalCorrect"=>$totalCorrect,
            "totalIncorrect"=>$totalIncorrect,
            "totalQuestions"=>$totalQuestions
          ],
          "message" =>  "El registro se creo correctamente",
          "code" => "gameAnswer:findTotalsByGame:001"
        ], 201);
      }else{
        return response()->json([
          "transaction" => "ok",
          "object" => $gameAnswer,
          "message" =>  "El registro se actualizo correctamente",
          "code" => "gameAnswer:findTotalsByGame:002"
        ], 200);
      }

    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:gameAnswer:findTotalsByGame:001"
      ], 500);
    }
  }
}
