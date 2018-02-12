<?php
require_once 'Conexao.class.php';
require_once 'Usuario.class.php';

class Bd {
    // Atributos
    private $con;
    
    // Construtor
    public function __construct(){
        $this->con = new Conexao();
    }
    
    // Métodos para fazer um CRUD
    public function inserir($usuario){
        try{
           $query = "INSERT INTO `usuarios`(`nome`,`email`,`login`,`senha`,`status`,`data`, token) VALUES (:nome, :email, :login, :senha, :status, :data, :token);";
           $cst = $this->con->conectar()->prepare($query);
           $cst->bindValue(":nome", $usuario->getNome(), PDO::PARAM_STR);
           $cst->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR);
           $cst->bindValue(":login", $usuario->getLogin(), PDO::PARAM_STR);
           $cst->bindValue(":senha", $usuario->getSenha(), PDO::PARAM_STR);
           $cst->bindValue(":status", $usuario->getStatus(), PDO::PARAM_STR);
           $cst->bindValue(":data", $usuario->getData(), PDO::PARAM_STR);
           $cst->bindValue(":token", $usuario->getToken(), PDO::PARAM_STR);
           $cst->execute();
           
           if($cst->rowCount() > 0){
               return true;
           }else{
               return false;
           }
           
        } catch (PDOException $ex) {
          echo "Erro gerado ".$ex->getMessage();
        }
    }
    
    public function consultarEmail(){        
        try{
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

            $query = "SELECT `email` FROM `usuarios` WHERE `email` = :email;";
            $cst = $this->con->conectar()->prepare($query);
            $cst->bindValue(":email", $email, PDO::PARAM_STR);
            $cst->execute();
            
            if($cst->rowCount() > 0){
                return true;
                
            }else{
                return false;
            }          
            
        } catch (PDOException $ex) {
            echo "Erro gerado ".$ex->getMessage();
        }  
    }
    
    public function consultarLogin(){
        try{
            $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
            
            $query = ("SELECT `login` FROM `usuarios` WHERE `login` = :login;");
            $cst = $this->con->conectar()->prepare($query);
            $cst->bindValue(":login", $login, PDO::PARAM_STR);
            $cst->execute();
            
            if($cst->rowCount() > 0){
                return true;
                
            }else{
                return false;
            }
            
        } catch (PDOException $ex) {
            echo "Erro gerado ".$ex->getMessage();
        }
    }
}
