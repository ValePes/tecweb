<?php
    use Psr\Http\Message\ResponseInterface as Response; 
    use Psr\Http\Message\ServerRequestInterface as Request; 
    use Slim\Factory\AppFactory; 

    require_once __DIR__ .'/vendor/autoload.php'; 

    $app = AppFactory::create(); 
    $app->setBasepath("/tecweb/practicas/p17"); 

    $app->get('/', function($request, $response, $args) {

        $response->getBody()->write("Hola Mundo Slim!!!");
        return $response;  
    });
 

    $app->get("/hola[/{nombre}]", function($request, $response, $args){
        $response->getBody()->write("Hola, ". $args["nombre"]); 
        return $response; 
    }); 

    $app->post("/pruebapost", function($request, $response, $args){
        $reqPost = $request->getParsedBody(); 
        $val1 = $reqPost["val1"]; 
        $val2 = $reqPost["val2"];

        $response->getBody()->write("Valores: ". $val1." ".$val2);
        return $response;  
    }); 

    #testjson con get
    $app->get("/testjson1", function($request, $response, $args){
        $data[0]["nombre"]="Valeria";
        $data[0]["apellidos"]="Pestaña Marquez";
        $data[1]["nombre"]="Mafer";
        $data[1]["apellidos"]="Ruiz Santiago";
        $data[2]["nombre"]="Jossette";
        $data[2]["apellidos"]="Romero Lagunes";

        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        return $response; 
    }); 

    #testjson con post
    $app->post("/testjson", function($request, $response, $args){
        $reqPost = $request->getParsedBody(); 
        $data[0]["nombre"]= $reqPost["nombre1"];
        $data[0]["apellidos"]= $reqPost["apellidos1"];
        $data[1]["nombre"]= $reqPost["nombre2"];
        $data[1]["apellidos"]= $reqPost["apellidos2"];

        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
        return $response; 
    });


    $app->run(); 
?>