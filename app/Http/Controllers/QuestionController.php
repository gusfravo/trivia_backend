<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Trivia;

class QuestionController extends Controller
{

  /**Metodo para crear una pregunta
  */
  public function update(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      //Declaramos el nombre con el nombre enviado en el request
      if(empty($reqst->id)){
        $question = new Question;
      }else{
        $question = Question::find($reqst->id);
        $question->id = $reqst->id;
      }
      //obtenemos la ultima posición
      $trivia =  Trivia::find($reqst->trivia->id);
      $questions = $trivia->questions;
      $totalQ =  sizeof($trivia->questions);
      $question->quetion = $reqst->question;
      $question->position = $totalQ+1;
      $question->img = $reqst->img;
      $question->trivia_id = $reqst->trivia->id;

      $question->save();
      if(empty($question->id)){
        return response()->json([
          "transaction" => "ok",
          "object" => $question,
          "message" =>  "El registro se creo correctamente",
          "code" => "question:update:001"
        ], 201);
      }else{
        return response()->json([
          "transaction" => "ok",
          "object" => $question,
          "message" =>  "El registro se actualizo correctamente",
          "code" => "question:update:002"
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

  /**Método para obtener una pregunta por id
  */
  public function get (Request $request){
    try{
      $reqst = json_decode($request->getContent());
      $question = Question::find($reqst->id);

      $object = array(
        "id"=>$question->id,
        "question"=>$question->question,
        "position"=>$question->position,
        "img"=>$question->img,
        "trivia"=>$question->trivia,
      );

      return response()->json([
        "transaction" => "ok",
        "object" => $object,
        "message" =>  "El registro se obtuvo exitosamente",
        "code" => "question:get:001"
      ], 200);
    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:question:get:001"
      ], 500);
    }
  }

  /**Metodo para obtene las preguntas de una trivia sin paginado
  */
  public function findAllByTrivia(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{

      $trivia = Trivia::find($reqst->id);
      $list = $trivia->questions;
      $total = sizeof($list);
      $instanceList = array();

      foreach ($list as $element) {

        $instanceList[] = array(
          "id"=>$element->id,
          "question"=>$element->question,
          "position"=>$element->position,
          "img"=>$element->img,
          "trivia"=>["id"=>$trivia->id],
        );

      }

      return response()->json([
        "transaction" => "ok",
        "object" => [
          "total"=>$total,
          "instanceList"=>$instanceList
        ],
        "message" =>  "El registro se encontro correctamente",
        "code" => "question:findAllByTrivia:002"
      ], 200);
    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:question:findAllByTrivia:001"
      ], 500);
    }
  }

  /**Método para eliminar una pregunta
  */
  public function delete(Request $request)
  {
    try{
      $reqst = json_decode($request->getContent());
      $question = Question::find($reqst->id);
      $question->delete();

      return response()->json([
        "transaction" => "ok",
        "message" =>  "El registro se eliminó exitosamente",
        "code" => "question:delete:001"
      ], 200);
    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:question:delete:001"
      ], 500);
    }
  }

}
