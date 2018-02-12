<?php

require_once '../classes/Bd.class.php';
require_once '../classes/Funcoes.class.php';
sleep(3);

if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "http://localhost/treinar/"){
    header('location: http://localhost/treinar/');
  
}else{
    // Inicializar
    $funcoes = new Funcoes();
    
    if($funcoes->consultarTokenCadastro()){
        
        if($funcoes->consultarReCaptcha()){
            // Inicializar
            $bd = new Bd();
            $funcoes = new Funcoes();
    
            if($bd->inserir($funcoes->usuario())){
                $resultado['status'] = true;
                $resultado['novoToken'] = $funcoes->tokenCadastro();
            
            }else{
                $resultado['status'] = false;
                $resultado['erro'] = 3;
            } 
            
        }else{
            $resultado['status'] = false;
            $resultado['erro'] = 2;
        }

    }else{
        $resultado['status'] = false;
        $resultado['erro'] = 1;
    }

    echo json_encode($resultado);
}

