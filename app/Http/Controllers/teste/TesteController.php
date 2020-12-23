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
        $this->middleware('auth:api');
        
        if (Auth::check())
        {
            return redirect()->route('teste.index');
        }
        else{

            return response()->json([
                "message" => "Usuário não autenticado"
            ]);
        }
    }

    public function index()
    {
        //return csrf_token(); 
        $testes = Teste::all();
        return response()->json($testes);
    }

    public function cadastrar(Request $request){

        $teste = new Teste();
        $teste->nome = $request->nome;
        $teste->idade = $request->idade.
        $teste->save();

        return response()->json([
            "message" => "Teste cadastrado com sucesso!"
        ], 201);

    }
}
