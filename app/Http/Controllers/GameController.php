<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Game;

class GameController extends Controller
{
  /**Metodo para crear un juego
  */
  public function create(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      //Declaramos el nombre con el nombre enviado en el request
      // verificamos si no hay un juego en curso antes de crear uno
      $list = Game::where('profile_id',$reqst->profile->id)->where('trivia_id',$reqst->trivia->id)->first();
      if(empty($list)){
        // creamos el juego
        $game = new Game;
        $game->time = 0;
        $game->start = Carbon::parse()->format('Y-m-d H:i:s');
        $game->end = null;
        $game->status = 'Iniciado';
        $game->trivia_id = $reqst->trivia->id;
        $game->profile_id = $reqst->profile->id;
        $game->last_position = 1;

        $game->save();
        if(empty($game->id)){
          return response()->json([
            "transaction" => "ok",
            "object" => $game,
            "message" =>  "El registro se creo correctamente",
            "code" => "game:update:001"
          ], 201);
        }else{
          return response()->json([
            "transaction" => "ok",
            "object" => $game,
            "message" =>  "El registro se actualizo correctamente",
            "code" => "game:update:002"
          ], 200);
        }
      }else{
        $game = $list;
        return response()->json([
          "transaction" => "ok",
          "object" => $game,
          "message" =>  "El registro ya existe.",
          "code" => "game:create:002"
        ], 200);
      }

    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:game:update:001"
      ], 500);
    }
  }

  /**Método para cerrar un juego
  */
  public function endGame(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      //Declaramos el nombre con el nombre enviado en el request
      $game = Game::find($reqst->id);
      $game->status = 'Terminado';
      $game->time = $game->time + $reqst->time;
      $game->end = Carbon::parse()->format('Y-m-d H:i:s');
      $game->save();
      return response()->json([
        "transaction" => "ok",
        "object" => $game,
        "message" =>  "El juego ha terminado, muchas gracias por participar.",
        "code" => "game:endGame:002"
      ], 200);

    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:game:endGame:001"
      ], 500);
    }
  }

  /**Método para actualizar el timepo de juego
  */
  public function updateTime(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      //Declaramos el nombre con el nombre enviado en el request
      $game = Game::find($reqst->id);
      $game->time = $game->time + $reqst->time;
      $game->last_position = $reqst->lastPosition;
      $game->save();
      $object = array(
        "id"=>$game->id,
        "time"=>$game->time,
        "start"=>$game->start,
        "end"=>$game->end,
        "status"=>$game->status,
        "trivia"=>["id"=>$game->trivia_id],
        "profile"=>["id"=>$game->profile_id],
        "lastPosition"=>$game->last_position,
      );
      return response()->json([
        "transaction" => "ok",
        "object" => $object,
        "message" =>  "Timepo actualizado.",
        "code" => "game:updateTime:002"
      ], 200);

    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:game:updateTime:001"
      ], 500);
    }
  }

  /**Método para obetner un juego por perfil y trivia
  */
  public function findByProfileAndTrivia(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      //Declaramos el nombre con el nombre enviado en el request
      $gameL = Game::where('profile_id',$reqst->profile->id)->where('trivia_id',$reqst->trivia->id)->first();
      $object = array();
      $t = "Found";
      if(empty($gameL)){
        $t = "NotFound";
        $object = array(
          "id"=>"",
          "time"=>0,
          "start"=>"",
          "end"=>"",
          "status"=>"",
          "lastPosition"=>0,
          "trivia"=>["id"=>""],
          "profile"=>["id"=>""]
        );
      }else{
        $game = $gameL->first();
        $object = array(
          "id"=>$game->id,
          "time"=>$game->time,
          "start"=>$game->start,
          "end"=>$game->end,
          "status"=>$game->status,
          "lastPosition"=>$game->last_position,
          "trivia"=>["id"=>$game->trivia_id],
          "profile"=>["id"=>$game->profile_id]
        );
      }

      return response()->json([
        "transaction" => "ok",
        "object" => $object,
        "message" =>  "El registro se obtuvo exitosamente",
        "code" => "game:findByProfileAndTrivia:001:".$t
      ], 200);

    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:game:findByProfileAndTrivia:001"
      ], 500);
    }
  }

  /**Método para obtener una juego por id
  */
  public function get (Request $request){
    try{
      $reqst = json_decode($request->getContent());
      $game = Game::find($reqst->id);

      $object = array(
        "id"=>$game->id,
        "time"=>$game->time,
        "start"=>$game->start,
        "end"=>$game->end,
        "status"=>$game->status,
        "trivia"=>["id"=>$game->trivia_id],
        "profile"=>["id"=>$game->profile_id],
        "lastPosition"=>$game->last_position,
      );

      return response()->json([
        "transaction" => "ok",
        "object" => $object,
        "message" =>  "El registro se obtuvo exitosamente",
        "code" => "game:get:001"
      ], 200);
    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:game:get:001"
      ], 500);
    }
  }


}
