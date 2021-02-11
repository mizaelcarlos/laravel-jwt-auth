<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


use JWTAuth;
use AppHttpRequestsRegisterAuthRequest;
use TymonJWTAuthExceptionsJWTException;
use SymfonyComponentHttpFoundationResponse;




class AuthController extends Controller
{
    public $token = true;

    public function valida_requisicao(){

        return response()->json('Usuário não autenticado');

    }
    public function register(Request $request)
    {

         $validator = Validator::make($request->all(), 
                      [ 
                      'name' => 'required',
                      'email' => 'required|email',
                      'password' => 'required',  
                      'c_password' => 'required|same:password', 
                     ]);  

         if ($validator->fails()) {  

               return response()->json(['error'=>$validator->errors()], 401); 

            }   


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if ($this->token) {
            return $this->login($request);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], Response::HTTP_OK);
    }

    /**
    * @OA\Post(
    *     path="/api/login",
    *     tags={"login"},
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"email","password"},
    *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
    *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
    *    ),
    * ),
    *     @OA\Response(response = 401, description = "Email ou senha inválida"),
    * )
    */

    public function login(Request $request)
    {
        
        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Email ou senha inválida',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }

}