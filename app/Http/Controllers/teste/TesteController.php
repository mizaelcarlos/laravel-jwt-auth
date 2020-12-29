<?php

namespace App\Http\Controllers\teste;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teste;

class TesteController extends Controller
{
    //
   

    public function __construct()
    {
        $this->middleware('api');
        
    }

        /**
        * @OA\Get(
        *     path="/api/teste",
        *     @OA\Response(response="200", description="Lista de teste obtida com sucesso."),
        *     @OA\Response(response = 400, description = "Não autenticado"),
        * )
        */
    public function index(Request $request)
    {

        if (Auth::check())
        {
             //return csrf_token(); 
            $testes = Teste::all();
            return response()->json($testes,200);
        }
        else{

            return response()->json([
                "message" => "Usuário não autenticado"
            ],400);
        }
    }

    /**
        * @OA\Post(
        *     path="/api/teste/cadastrar",
        *     @OA\Response(response="200", description="Teste cadastrado com sucesso."),
        *     @OA\Response(response = 400, description = "Não autenticado"),
        * )
    */

    public function cadastrar(Request $request){

        if (Auth::check())
        {
            $teste = new Teste();
            $teste->nome = $request->nome;
            $teste->idade = intval($request->idade);
            $teste->save();
    
            return response()->json([
                "message" => "Teste cadastrado com sucesso!"
            ], 201);
        }
        else{

            return response()->json([
                "message" => "Usuário não autenticado"
            ],400);
        }

    }
    /**
        * @OA\Delete(
        *     path="/api/teste/excluir",
        *     @OA\Response(response="200", description="Teste removído com sucesso."),
        *     @OA\Response(response = 400, description = "Não autenticado"),
        *     @OA\Parameter(name = "id", description = "id teste",in="query"),
        * )
    */
    public function excluir(Request $request){




    }
}
