<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
  public function list(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      $instanceListAux = Role::all()->forPage($reqst->page,$reqst->max);
      $total = sizeof(Role::all());

      $length = sizeof($instanceListAux);
      $instanceList = array();
      for ($i = 0; $i < $length; $i++) {
        $status = ($instanceListAux[$i]->status == 1) ? true : false;
        $instanceList[] = array(
          "id"=>$instanceListAux[$i]->id,
          "name"=>$instanceListAux[$i]->name,
          "description"=>$instanceListAux[$i]->description,
          "status"=>$status
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
        "message" =>  "El listado se obtuvo exitosamente",
        "code" => "role:list:001"
      ], 200);
    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:role:list:001"
      ], 500);
    }
  }

  public function findByName(Request $request)
  {
    $reqst = json_decode($request->getContent());
    try{
      $role = Role::where('name','like',$reqst->name.'%')->where('status', true)->first();
      
      $status = ($role->status == 1) ? true : false;
      $role->status = $status;

      return response()->json([
        "transaction" => "ok",
        "object" => $role,
        "message" =>  "objecto encontrado satisfactoriamente",
        "code" => "role:findByName:001"
      ], 200);
    }catch (Exception $e){
      return response()->json([
        "transaction" => "bad",
        "message" =>  $e->getMessage(),
        "code" => "system:error:role:findByName:001"
      ], 500);
    }
  }
}
