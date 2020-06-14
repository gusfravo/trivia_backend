<?php
namespace App\Http\Controllers;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\Profile;
use App\Facebook;

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

    /**Método para que un usuario se regitre en el sistema
    */
    public function newsignup(Request $request)
    {
      try{
        $request->validate([
          'name'     => 'required|string',
          'email'    => 'required|string|email|unique:users',
          'password' => 'required|string',
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
          //creamos el perfil del usuario
          $profile = new Profile;
          $profile->name = $request->name;
          $profile->lastname = $request->lastname;
          $profile->phone = $request->phone;
          $profile->origin = $request->origin;
          $profile->img = "";
          $profile->user_id = $user->id;
          $profile->save();
          return response()->json([
            "transaction" => "ok",
            "message" =>  "Usuario registrado exitosamente",
            "code" => "newsignup:001"
          ], 200);
        }else{
          return response()->json([
            "transaction" => "bad",
            "message" =>  'Error verifique su información',
            "code" => "system:error:newsignup:002"
          ], 500);
        }

      }catch (Exception $e){
        return response()->json([
          "transaction" => "bad",
          "message" =>  $e->getMessage(),
          "code" => "system:error:newsignup:001"
        ], 500);
      }
    }


    /**función para realizar logueo con facebook
    */
    public function loginWithFacebook(Request $request)
    {
      try{
        $request->validate([
          'name'     => 'required|string',
          'email'    => 'required|string',
          'userid' => 'required|string',
          'role'     => 'required|string'
        ]);
        $user = User::where('email',$request->email)->get();
        if(self::emptyObj($user)){
          // usuario no existe;
          // Si el usuario no existe entonces lo creamos
          $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->userid),
          ]);
          $user->save();
          if($request->role !=''){
            $role = Role::where('name','like',$request->role.'%')->where('status', true)->first();
            $user->roles()->attach($role);
            //ahora guadramos los datos de facebook
            $facebook = new Facebook([
              'username'  =>  $request->email,
              'access_token'     =>  $request->accessToken,
              'userid'       =>  $request->userid,
              'name'       =>  $request->name,
              'user_id'       =>  $user->id,
            ]);

            $facebook->save();
            //creamos el perfil del usuario
            $profile = new Profile;
            $profile->name = $request->name;
            $profile->lastname = ".";
            $profile->phone = "---";
            $profile->origin = '---';
            $profile->img = "";
            $profile->user_id = $user->id;
            $profile->save();
            // Obetenemos el token de acceso y respondemos acceso exitoso
            $tokenResult = self::getTokenAcces($user);
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

          }else{
            return response()->json([
              "transaction" => "bad",
              "message" =>  'Error verifique su información',
              "code" => "system:error:loginWithFaceboook:002"
            ], 500);
          }
        }else{
          // El usuario si existe; obtenemos el usuario
          $user = $user->first();
          // Obetenemos el token de acceso y respondemos acceso exitoso
          $tokenResult = self::getTokenAcces($user);
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
        return response()->json([
          "object"=> $user,
          "text"=>$text,
          "transaction" => "ok",
          "message" =>  "wiii",
          "code" => "system:success:loginWithFaceboook:001"
        ], 200);

      }catch (Exception $e){
        return response()->json([
          "transaction" => "bad",
          "message" =>  $e->getMessage(),
          "code" => "system:error:loginWithFaceboook:001"
        ], 500);
      }
    }

    /** funcón para obtener l token de usuario
    */
    function getTokenAcces($user){
      $tokenResult = $user->createToken('Personal Access Token');
      $token = $tokenResult->token;
      $token->expires_at = Carbon::now()->addWeeks(1);
      $token->save();
      return $tokenResult;
    }
    
    /** función para determinar si un obejto es vacio
    */
            function emptyObj( $obj ) {
                foreach ( $obj AS $prop ) {
                    return FALSE;
                }

                return TRUE;
            }

}
