# laravel-jwt-auth
Projeto laravel com implementação de autenticação por JWT e documentação usando Swagger

Instalando o Laravel Swagger Package , para documentação de API

Comando para instalação:

composer require darkaonline/l5-swagger

publicar config/views no Service Provider:

php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

alterando titulo da api no config/l5-swagger.php:

'title' => 'titulo da api'

adicionando ao arquivo .APP_ENV

L5_SWAGGER_CONST_HOST = http://localhost/api


Comando para gerar documentação

php artisan l5-swagger:generate

Inserir anotation no controler principal

/**
* @OA\Info(title="Teste API", version="0.1")
*/

Inserir anotation em método do controler que deseja gerar a documentação:

Exemplo:

 /**
* @OA\Get(
*     path="/api/teste",
*     @OA\Response(response="200", description="Lista de teste obtida com sucesso."),
*     @OA\Response(response = 400, description = "Não autenticado"),
* )
*/

/**
* @OA\Post(
*     path="/api/teste/cadastrar",
*     @OA\Response(response="200", description="Teste cadastrado com sucesso."),
*     @OA\Response(response = 400, description = "Não autenticado"),
* )
*/

/**
* @OA\Delete(
*     path="/api/teste/excluir",
*     @OA\Response(response="200", description="Teste removído com sucesso."),
*     @OA\Response(response = 400, description = "Não autenticado"),
*     @OA\Parameter(name = "id", description = "id teste",in="query"),
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

Implementando autorização por jwt na documentação

no arquivo config/l5-swagger.php inserir em 

'securityDefinitions' => [
            'securitySchemes' => [

                'bearer' => [
                    'type' => 'http',
                    'description' => 'Authorization token obtained from logging in.',
                    'name' => 'Authorization',
                    'in' => 'header',
                    'scheme' => 'bearer',
                ],

inserir em 

'security' => [

    'bearer' => []