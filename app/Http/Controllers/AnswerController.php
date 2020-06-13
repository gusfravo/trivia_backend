<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\Question;

class AnswerController extends Controller
{

    /**Metodo para crear una respuesta
    */
    public function update(Request $request)
    {
      $reqst = json_decode($request->getContent());
      try{
        //Declaramos el nombre con el nombre enviado en el request
        if(empty($reqst->id)){
          $answer = new Answer;
        }else{
          $answer = Answer::find($reqst->id);
          $answer->id = $reqst->id;
        }
        $answer->answer = $reqst->answer;
        $answer->correct = $reqst->correct;
        $answer->question_id = $reqst->question->id;

        $answer->save();
        if(empty($answer->id)){
          return response()->json([
            "transaction" => "ok",
            "object" => $answer,
            "message" =>  "El registro se creo correctamente",
            "code" => "answer:update:001"
          ], 201);
        }else{
          return response()->json([
            "transaction" => "ok",
            "object" => $answer,
            "message" =>  "El registro se actualizo correctamente",
            "code" => "answer:update:002"
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

    /**Método para obtener una respuesta por id
    */
    public function get (Request $request){
      try{
        $reqst = json_decode($request->getContent());
        $answer = Answer::find($reqst->id);

        $correct = $answer->correct == 1 ? true : false;

        $object = array(
          "id"=>$answer->id,
          "answer"=>$answer->answer,
          "correct"=>$correct,
          "question"=>$answer->question,
        );

        return response()->json([
          "transaction" => "ok",
          "object" => $object,
          "message" =>  "El registro se obtuvo exitosamente",
          "code" => "answer:get:001"
        ], 200);
      }catch (Exception $e){
        return response()->json([
          "transaction" => "bad",
          "message" =>  $e->getMessage(),
          "code" => "system:error:answer:get:001"
        ], 500);
      }
    }

    /**Metodo para obtene las respuestas de una pregunta sin paginado
    */
    public function findAllByQuestion(Request $request)
    {
      $reqst = json_decode($request->getContent());
      try{

        $question = Question::find($reqst->id);
        $list = $question->answers;
        $total = sizeof($list);
        $instanceList = array();

        foreach ($list as $element) {
          $correct = $element->correct == 1 ? true : false;
          $instanceList[] = array(
            "id"=>$element->id,
            "answer"=>$element->answer,
            "correct"=>$correct,
            "question"=>["id"=>$question->id],
          );

        }

        return response()->json([
          "transaction" => "ok",
          "object" => [
            "total"=>$total,
            "instanceList"=>shuffle($instanceList)
          ],
          "message" =>  "El registro se encontro correctamente",
          "code" => "answer:findAllByQuestion:002"
        ], 200);
      }catch (Exception $e){
        return response()->json([
          "transaction" => "bad",
          "message" =>  $e->getMessage(),
          "code" => "system:error:answer:findAllByQuestion:001"
        ], 500);
      }
    }

    /**Método para eliminar una respuesta
    */
    public function delete(Request $request)
    {
      try{
        $reqst = json_decode($request->getContent());
        $answer = Answer::find($reqst->id);
        $answer->delete();

        return response()->json([
          "transaction" => "ok",
          "message" =>  "El registro se eliminó exitosamente",
          "code" => "answer:delete:001"
        ], 200);
      }catch (Exception $e){
        return response()->json([
          "transaction" => "bad",
          "message" =>  $e->getMessage(),
          "code" => "system:error:answer:delete:001"
        ], 500);
      }
    }

    /**Metodo para obtener las respuestas de una pregunta sin paginado y para el juego
    */
    public function findAllByQuestionToPlay(Request $request)
    {
      $reqst = json_decode($request->getContent());
      try{

        $question = Question::find($reqst->id);
        $list = $question->answers;
        $total = sizeof($list);
        $instanceList = array();

        foreach ($list as $element) {
          $correct = $element->correct == 1 ? true : false;
          $instanceList[] = array(
            "id"=>$element->id,
            "answer"=>$element->answer,
            "question"=>["id"=>$question->id],
          );

        }

        return response()->json([
          "transaction" => "ok",
          "object" => [
            "total"=>$total,
            "instanceList"=>shuffle($instanceList)
          ],
          "message" =>  "El registro se encontro correctamente",
          "code" => "answer:findAllByQuestionToPlay:002"
        ], 200);
      }catch (Exception $e){
        return response()->json([
          "transaction" => "bad",
          "message" =>  $e->getMessage(),
          "code" => "system:error:answer:findAllByQuestionToPlay:001"
        ], 500);
      }
    }

}
