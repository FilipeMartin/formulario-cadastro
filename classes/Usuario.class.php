<?php
class Usuario {
    // Atributos
    private $id;
    private $nome;
    private $email;
    private $login;
    private $senha;
    private $status;
    private $data;
    private $token;
    
    // Métodos Especiais
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getLogin() {
        return $this->login;
    }

    function getSenha() {
        return $this->senha;
    }

    function getStatus() {
        return $this->status;
    }

    function getData() {
        return $this->data;
    }

    function getToken() {
        return $this->token;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setToken($token) {
        $this->token = $token;
    }
}
