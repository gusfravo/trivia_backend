<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GameAnswer;
use App\Answer;

class GameAnswerController extends Controller
{
  /**Método para validar si una respuesta es correcta
  */
  public function validate(Request $request)
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
}
