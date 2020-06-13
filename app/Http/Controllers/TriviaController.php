<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trivia;

class TriviaController extends Controller
{
  /**Metodo para crear una trivia
  */
  public function update(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      //Declaramos el nombre con el nombre enviado en el request
      if(empty($reqst->id)){
        $trivia = new Trivia;
      }else{
        $trivia = Trivia::find($reqst->id);
        $trivia->id = $reqst->id;
      }
      $trivia->name = $reqst->name;
      $trivia->description = $reqst->description;
      $trivia->img = "";
      $trivia->status = $reqst->status;

      $trivia->save();
      if(empty($trivia->id)){
        return response()->json([
          "transaction" => "ok",
          "object" => $trivia,
          "message" =>  "El registro se creo correctamente",
          "code" => "trivia:update:001"
        ], 201);
      }else{
        return response()->json([
          "transaction" => "ok",
          "object" => $trivia,
          "message" =>  "El registro se actualizo correctamente",
          "code" => "trivia:update:002"
        ], 200);
      }

    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:trivia:update:001"
      ], 500);
    }
  }

  /**Método para obtener un trivia por id
  */
  public function get (Request $request){
    try{
      $reqst = json_decode($request->getContent());
      $trivia = Trivia::find($reqst->id);

      $object = array(
        "id"=>$trivia->id,
        "name"=>$trivia->name,
        "description"=>$trivia->description,
        "img"=>$trivia->img,
        "status"=>$trivia->status,
      );

      return response()->json([
        "transaction" => "ok",
        "object" => $object,
        "message" =>  "El registro se obtuvo exitosamente",
        "code" => "trivia:get:001"
      ], 200);
    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:trivia:get:001"
      ], 500);
    }
  }

  /**Método para listar todas las trivias
  */
  public function findAll(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      $list = Trivia::paginate($reqst->max,['*'],'page',$reqst->page);
      $total = $list->total();
      $length = sizeof($list);
      $instanceList = array();
      foreach ($list as $element) {

        $instanceList[] = array(
          "id"=>$element->id,
          "name"=>$element->name,
          "description"=>$element->description,
          "status"=>$element->status,
          "img"=>$element->status
        );

      }

      return response()->json([
        "transaction" => "ok",
        "object" => [
          "currentPage"=>$reqst->page,
          "perPage"=>$reqst->max,
          "total"=>$total,
          "instanceList"=>$instanceList
        ],
        "message" =>  "El registro se encontro correctamente",
        "code" => "trivia:findAll:002"
      ], 200);
    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:trivia:findAll:001"
      ], 500);
    }
  }

}
