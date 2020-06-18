<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;

class ProfileController extends Controller
{
  /**Método para crear un perfil
  */
  public function update(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      //Declaramos el nombre con el nombre enviado en el request
      if(empty($reqst->id)){
        $profile = new Profile;
      }else{
        $profile = Profile::find($reqst->id);
        $profile->id = $reqst->id;
      }
      $profile->name = $reqst->name;
      $profile->lastname = $reqst->lastname;
      $profile->phone = $reqst->phone;
      $profile->origin = $reqst->origin;
      $profile->img = "";
      $profile->user_id = $reqst->user->id;

      $profile->save();
      if(empty($profile->id)){
        return response()->json([
          "transaction" => "ok",
          "object" => $profile,
          "message" =>  "El registro se creo correctamente",
          "code" => "profile:update:001"
        ], 201);
      }else{
        return response()->json([
          "transaction" => "ok",
          "object" => $profile,
          "message" =>  "El registro se actualizo correctamente",
          "code" => "profile:update:002"
        ], 200);
      }

    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:profile:update:001"
      ], 500);
    }
  }

  /**Método para obtener un perfil por usuario
  */
  public function findByUser(Request $request){
    $reqst = json_decode($request->getContent());
    try{
      $profile = Profile::where('user_id',$reqst->user->id)->first();
      $object = array(
        "id"=>$profile->id,
        "name"=>$profile->name,
        "lastname"=>$profile->lastname,
        "phone"=>$profile->phone,
        "origin"=>$profile->origin,
        "img"=>$profile->img,
        "user"=>array(
          "id"=>$profile->user_id
        )
      );

      return response()->json([
        "transaction" => "ok",
        "object" => $object,
        "message" =>  "El registro se encontro correctamente",
        "code" => "profile:findByUser:002"
      ], 200);

    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:profile:findByUser:001"
      ], 500);
    }
  }

  /**Método para obtener una juego por id
  */
  public function get (Request $request){
    try{
      $reqst = json_decode($request->getContent());
      $profile = Profile::find($reqst->id);

      $object = array(
        "id"=>$profile->id,
        "name"=>$profile->name,
        "lastname"=>$profile->lastname,
        "phone"=>$profile->phone,
        "origin"=>$profile->origin,
        "img"=>$profile->img,
        "user"=>array(
          "id"=>$profile->user_id
        )
      );

      return response()->json([
        "transaction" => "ok",
        "object" => $object,
        "message" =>  "El registro se obtuvo exitosamente",
        "code" => "profile:get:001"
      ], 200);
    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:profile:get:001"
      ], 500);
    }
  }

  /**Método para obtener una imagen
  */
  public function upload(Request $request)
  {
    if(!$request->hasFile('file')) {
      return response()->json([
          "transaction" => "bad",
          "message" =>  "Archivo a subir no encontrado",
          "code" => "system:error:profile:upload:001"
        ],400);
    }
    $file = $request->file('file');
    if(!$file->isValid()) {
      return response()->json([
          "transaction" => "bad",
          "message" =>  "El archivo a subir no es valido",
          "code" => "system:error:profile:upload:001"
        ],400);
    }
    $path = _DIR_.'/../../../../htdocs/public/uploads/';
    $nameFile = $file->getClientOriginalName();
    $file->move($path, $file->getClientOriginalName() );
    // return response()->json(compact('path'));
    return response()->json([
        "transaction" => "ok",
        "message" =>  "El archivo se subio exitosamente",
        "object" => [
          "path" => compact('path'),
          "name" => $nameFile
        ],
        "code" => "success:profile:upload:001"
      ],200);
  }

  /**Método para obtener una juego por id
  */
  public function updateImg (Request $request){
    try{
      $reqst = json_decode($request->getContent());
      $profile = Profile::find($reqst->id);
      $profile->img = $reqst->img;
      $profile->save();
      $object = array(
        "id"=>$profile->id,
        "name"=>$profile->name,
        "lastname"=>$profile->lastname,
        "phone"=>$profile->phone,
        "origin"=>$profile->origin,
        "img"=>$profile->img,
        "user"=>array(
          "id"=>$profile->user_id
        )
      );

      return response()->json([
        "transaction" => "ok",
        "object" => $object,
        "message" =>  "El registro se obtuvo exitosamente",
        "code" => "profile:updateImg:001"
      ], 200);
    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:profile:updateImg:001"
      ], 500);
    }
  }

}
