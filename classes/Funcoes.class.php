<?php
session_start();

require_once 'Usuario.class.php';
class Funcoes {
    
    // Gerar Data
    public function data(){
        $data = date("d/m/Y H:i:s");
        return $data;
    }
    
    // Gerar Token
    public function gerarToken(){
        $token = password_hash(rand(100, 1000), PASSWORD_DEFAULT);
        return $token;
    }
    
    // Gerar Senha Criptografada
    public function criptSenha($password){
        $senhaCriptografada = password_hash($password, PASSWORD_DEFAULT);
        
        return $senhaCriptografada;
    }
    
    // Descriptografar Senha
    public function DescripSenha($password, $hash){
        
        if(password_verify($password, $hash)){
            return true;
        }else{
            return false;
        }

    }
    
    // Filtrar Usuário
    public function usuario(){
        $usuario = new Usuario();
        
        $usuario->setNome(addslashes(trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING))));
        $usuario->setEmail(addslashes(trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL))));
        $usuario->setLogin(addslashes(trim(filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING))));
        $usuario->setSenha($this->criptSenha(addslashes(trim(filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING)))));
        $usuario->setStatus("false");
        $usuario->setData($this->data());
        $usuario->setToken($this->gerarToken());
        
        return $usuario;
    }
    
    public function tokenCadastro(){
        
        // Gerar token
        $token = $this->gerarToken();
        
        // Criar sessão
        $_SESSION['tokenCadastro'] = $token;
        
        return $token;
    }
    
    public function consultarTokenCadastro(){
        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
                
        if(isset($_SESSION['tokenCadastro']) && $_SESSION['tokenCadastro'] == $token){
            unset($_SESSION['tokenCadastro']);
            return true;
            
        }else{
            return false;
        }
    }
    
    public function consultarReCaptcha(){
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POST => true,
            CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
            CURLOPT_POSTFIELDS => [
                'secret' => '6LfARUMUAAAAANksf-z5CA-iXZEW_G2Z1pSjvoJw',
                'response' => filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_STRING),
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ]
        ]);
        
        $response = json_decode(curl_exec($curl));
        
        curl_close($curl);
        
        if($response->success && $response->hostname == "localhost"){
            return true;
        }else{
            return false;
        }
    }
}
