<?php
require_once 'classes/Funcoes.class.php';
$funcoes = new Funcoes();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Site Teste</title>
        <link rel="stylesheet" type="text/css" href="estilo.css"/>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js?hl=pt-BR&onload=onLoadCallback&render=explicit" async defer></script>
    </head>
    
    <body style="font-family: sans-serif;">
        <form id="formCadastrar" method="POST" action="">
            <fieldset class="caixa_cadastro"><legend>Cadastrar</legend>
                <p><legend for="nome">Nome</legend>
                   <input class="campo" type="text" name="nome" id="nome" placeholder="Digite seu nome"/><br/>
                   <span id="msgNome" style="color:red;"></span>
                </p>
                
                <p><legend for="email">E-mail</legend>
                   <input class="campo" type="text" name="email" id="email" placeholder="Digite seu e-mail"/><br/>
                   <span id="msgEmail" style="color:red;"></span>
                </p>
                
                <fieldset class="caixa_login"><legend>Cadastrar login</legend>
                
                <p><legend for="login">Login</legend>
                   <input class="campoLogin" type="text" name="login" id="login" placeholder="Digite seu login"/><br/>
                   <span id="msgLogin" style="color:red;"></span>
                </p>
                
                <p><legend for="senha">Senha</legend>
                   <input class="campoLogin" type="password" name="senha" id="senha" placeholder="Digite sua senha"/><br/>
                   <span id="msgSenha" style="color:red;"></span>
                </p>
                
                <p><legend for="repitasenha">Repita sua senha</legend>
                   <input class="campoLogin" type="password" name="repitasenha" id="repitasenha" placeholder="Repita sua senha"/><br/>
                   <span id="msgRepitasenha" style="color:red;"></span>
                </p>
                </fieldset>
                
                <span style="font-size: 14px; margin-left: 3px; font-weight: bold; color:#808080;">Verificação</span>
                
                <div class="caixa-capche" id="caixa-capche">
                    <div class="g-recaptcha" id="recaptchaContainer"></div>   
                </div>
                
                <input type="hidden" name="token" id="token" value="<?=$funcoes->tokenCadastro();?>"/>
                
                <p><input class="btnCadastrar" type="submit" name="cadastrar" id="btnCadastrar" value="Cadastrar"/></p>
            </fieldset>
        </form>
        <script type="text/javascript" src="js/script.js"></script>
    </body>
</html>
