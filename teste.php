<?php
session_start();

if(!empty($_SESSION['tokenCadastro'])){
    echo "Existe uma sessão token: ".$_SESSION['tokenCadastro'];
}else{
    echo "Não existe uma sessão token";
}

