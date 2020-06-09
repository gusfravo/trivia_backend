<?php
namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Role;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
      try{
        $request->validate([
          'name'     => 'required|string',
          'email'    => 'required|string|email|unique:users',
          'password' => 'required|string|confirmed',
          'role'     => 'required|string'
        ]);
        $user = new User([
          'name'     => $request->name,
          'email'    => $request->email,
          'password' => bcrypt($request->password),
        ]);

        $user->save();
        if($request->role !=''){
          $role = Role::where('name','like',$request->role.'%')->where('status', true)->first();
          $user->roles()->attach($role);
          return response()->json([
            "transaction" => "ok",
            "message" =>  "Usuario registrado exitosamente",
            "code" => "signup:001"
          ], 200);
        }else{
          return response()->json([
            "transaction" => "bad",
            "message" =>  'Error verifique su información',
            "code" => "system:error:signup:002"
          ], 500);
        }

      }catch (Exception $e){
        return response()->json([
          "transaction" => "bad",
          "message" =>  $e->getMessage(),
          "code" => "system:error:signup:001"
        ], 500);
      }
    }
    public function login(Request $request)
    {
      $request->validate([
        'email'       => 'required|string|email',
        'password'    => 'required|string',
        'remember_me' => 'boolean',
      ]);
      $credentials = request(['email', 'password']);
      if (!Auth::attempt($credentials)) {
        return response()->json([
          "transaction" => "bad",
          "message" =>  'Error verifique su información',
          "code" => "system:error:login:001"
        ], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
          $token->expires_at = Carbon::now()->addWeeks(1);
        }else{
          $token->expires_at = Carbon::now()->addHours(24);
        }
        $token->save();
        // metood par encontrar el usuario y acceder a los roles
        $userF = User::find($user->id);
        $roles = $user->roles;
        // recorremos los roles para obtener solo el indicador
        $length = sizeof($roles);
        $roleInstanceList = array();
        for ($i = 0; $i < $length; $i++) {
          $roleInstanceList[] = $roles[$i]->name;
        }
        // enviamos los parametro de logueo
        return response()->json([
          'access_token' => $tokenResult->accessToken,
          'token_type'   => 'Bearer',
          'expires_at'   => Carbon::parse(
            $tokenResult->token->expires_at)
            ->toDateTimeString(),
          'roles'        => $roleInstanceList
          ]);
    }

    public function logout(Request $request)
    {
      $request->user()->token()->revoke();
      return response()->json(['message' =>
      'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
