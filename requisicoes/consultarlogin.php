<?php
require_once '../classes/Bd.class.php';

if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "http://localhost/treinar/"){
    header('location: http://localhost/treinar/');
}else{
    // Inicializar Objeto
    $bd = new Bd();
    sleep(2);
    if($bd->consultarLogin()){
        $resultado['status'] = true;
        
    }else{
        $resultado['status'] = false;
    }
    
    echo json_encode($resultado);
}

