$(document).ready(function(){
 // Variáveis globais
    var confNome = false;
    var confEmail = false;
    var confLogin = false;
    var confSenha = false;
    var confRepitaSenha = false;

    $('#formCadastrar').submit(function(){
     // Métodos principais
        nome();
        email();
        login();
        senha();
        repitaSenha();
        
     // Enviar dados do formulário
        if(confNome && confEmail && confLogin && confSenha && confRepitaSenha && captchar){
           formulario();
        }
        
      // Erro reCaptcher
        if(!captchar){
            caixaReCaptchar.addClass('alertCaptchar');
        }
        
        return false;
    });
    
    // Ação campo nome
    $('#nome').focusout(function(){
        nome();  
    });

    // Ação campo email
    $('#email').focusout(function(){
        email();   
    });
    
    // Ação campo login
    $('#login').focusout(function(){
        login();
    });
    
    // Ação campo senha
    $('#senha').focusout(function(){
        senha();  
    });
    
    // Ação campo repita senha
    $('#repitasenha').focusout(function(){
        repitaSenha();  
    });
 
    // Ação formulário
    function formulario(){
        var url = 'requisicoes/cadastrar.php';
        var dadosForm = $('#formCadastrar').serialize();
        var btn = $('#btnCadastrar');
        var novoToken = $('#token');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: dadosForm,
            cache: false,
            dataType: 'JSON',
            beforeSend: function(){
               btn.attr('disabled', 'disabled');
               btn.val('Cadastrando...');
               btn.css({"color":"#FF8C00"});
            },
            success: function(resultado){
                
                if(resultado.status){
                   btn.removeAttr('disabled');
                   alert('Usuário cadastrado com sucesso');
                   $("#formCadastrar").trigger("reset");
                   btn.val('Cadastrar');
                   btn.css({"color":"black"});
                   
                   // Resetar reCaptcha
                   resetar();
                   
                   // Resetar Campos
                   resetarCampos();
                   
                   // Gerar novo token
                   novoToken.val(resultado.novoToken);
                   
                }else{
                   btn.removeAttr('disabled');
                   $("#formCadastrar").trigger("reset"); 
                   btn.val('Cadastrar');
                   btn.css({"color":"black"});
                   
                   switch(resultado.erro){
                        case 1: alert('Altentificação do token inválida'); break;
                        case 2: alert('ReCaptcha inválido'); break; 
                        case 3: alert('Erro ao cadastrar usuário'); break;    
                   }
                   
                   // Resetar reCaptcha
                   resetar();
                   
                   // Resetar Campos
                   resetarCampos();
                   
                   // Atualizar página
                   window.location = "http://localhost/treinar/";
                   
                }
            },
            error: function(){ 
                alert('Erro ao processar dados');
                btn.val('Cadastrar');
                btn.css({"color":"black"});
                
                // Resetar reCaptcha
                   resetar();
                
                // Resetar Campos
                   resetarCampos();
                
                // Atualizar página
                window.location = "http://localhost/treinar/";
            }
            
        });
    }
 
    // Função campo nome
    function nome(){
       var nome = $('#nome');
        nome.val(nome.val().trim());
        
        var caixaNome =  $('#msgNome');
        if(nome.val() === ""){
            caixaNome.html('Campo nome obrigatório');
            nome.removeClass("imgCerto");
            confNome = false;
        }else{
            caixaNome.empty();
            nome.addClass("imgCerto");
            confNome = true;
        } 
    }

    // Função campo email
    var emailGlobal = "";
    function email(){
        var email = $('#email');
        email.val(email.val().trim());
        var filtro = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        
        var caixaEmail = $('#msgEmail');
        if(email.val() === ""){
            email.removeClass("gifLoader");
            email.removeClass("imgCerto"); 
            
            caixaEmail.html('Campo e-mail obrigatório'); 
            confEmail = false;
        
        }else if(!filtro.test(email.val())){
            email.removeClass("gifLoader");
            email.removeClass("imgCerto");  
            
            caixaEmail.html('E-mail inválido'); 
            confEmail = false;
           
        }else if(email.val() !== emailGlobal){
           var url = "requisicoes/consultaremail.php";
           var btn = $('#btnCadastrar');
           
            $.ajax({
                url: url,
                type: 'POST',
                data: {email: email.val()},
                cache: false,
                dataType: 'JSON',
                beforeSend: function(){
                    email.addClass("gifLoader");
                    email.removeClass("imgCerto");
                    
                    caixaEmail.empty();
                    btn.val('Aguarde...');
                    btn.attr('disabled', 'disabled');
                    confEmail = false;
                },
                success: function(resultado){
                 
                    if(resultado.status){
                        email.removeClass("gifLoader");
                        email.removeClass("imgCerto");
                        
                        caixaEmail.html('E-mail já cadastrado');
                        confEmail = false;
                        btn.val('Cadastrar');
                        btn.removeAttr('disabled');
                    }else{
                        email.removeClass("gifLoader");
                        email.addClass("imgCerto");
                        
                        caixaEmail.empty();
                        confEmail = true;
                        btn.val('Cadastrar');
                        btn.removeAttr('disabled');
                    } 
                },
                error: function(){
                    email.removeClass("gifLoader");
                    email.removeClass("imgCerto");
                    
                    alert('Erro ao processar dados'); 
                    confEmail = false;
                    btn.val('Cadastrar');
                    btn.removeAttr('disabled');
               }
           }); 
        }
        emailGlobal = email.val();
    }
    
    // Função campo login
    var loginGlobal = "";
    function login(){
        var login = $('#login');
        login.val(login.val().trim());
        
        var caixaLogin = $('#msgLogin');
        if(login.val() === ""){
            login.removeClass("gifLoader");
            login.removeClass("imgCerto");
            
            caixaLogin.html('Campo login obrigatório');
            login.removeClass("imgCerto");
            confLogin = false;
           
        }else if(login.val() !== loginGlobal){
            var url = "requisicoes/consultarlogin.php";
            var btn = $('#btnCadastrar');
            
            $.ajax({
                url: url,
                type: 'POST',
                data: {login: login.val()},
                cache: false,
                dataType: 'JSON',
                beforeSend: function(){
                    login.addClass("gifLoader");
                    login.removeClass("imgCerto");
                    
                    caixaLogin.empty();
                    btn.val('Aguarde...');
                    btn.attr('disabled', 'disabled');
                    confLogin = false;
                },
                success: function(resultado){
                    
                    if(resultado.status){
                        login.removeClass("gifLoader");
                        login.removeClass("imgCerto");
                        
                        caixaLogin.html("Login já cadastrado");
                        confLogin = false;
                        btn.val('Cadastrar');
                        btn.removeAttr('disabled');
                        
                    }else{
                        login.removeClass("gifLoader");
                        login.addClass("imgCerto");
                        
                        caixaLogin.empty();
                        confLogin = true;
                        btn.val('Cadastrar');
                        btn.removeAttr('disabled');
                    }
                },
                error: function(){
                   login.removeClass("gifLoader");
                   login.removeClass("imgCerto");
                   
                   alert('Erro ao processar dados'); 
                   confLogin = false;
                   btn.val('Cadastrar');
                   btn.removeAttr('disabled');
                }
                
            });
        }
        loginGlobal = login.val();
    }
    
    // Função campo senha
    function senha(){
        var senha = $('#senha');
        
        senha.val(senha.val().trim());
        
        var caixaSenha = $('#msgSenha');
        if(senha.val() === ""){
            caixaSenha.html('Campo senha obrigatório');
            senha.removeClass("imgCerto");
            confSenha = false;
            
        }else if(senha.val().length < 6){
            caixaSenha.html('A senha deve conter no mínimo 6 dígitos');
            senha.removeClass("imgCerto");
            confSenha = false;
            
        }else{
            caixaSenha.empty();
            senha.addClass("imgCerto");
            confSenha = true;
        } 
    }
    
    // Função campo repita senha
    function repitaSenha(){
        var repitaSenha = $('#repitasenha');
        var senha = $('#senha');
        
        repitaSenha.val(repitaSenha.val().trim());
        
        var caixaRepitaSenha = $('#msgRepitasenha');
        if(repitaSenha.val() === ""){
            caixaRepitaSenha.html('Campo repita senha obrigatório');
            repitaSenha.removeClass("imgCerto");
            confRepitaSenha = false;
            
        }else if(repitaSenha.val().length < 6){
            caixaRepitaSenha.html('A senha deve conter no mínimo 6 dígitos');
            repitaSenha.removeClass("imgCerto");
            confRepitaSenha = false;
            
        }else if(senha.val() !== "" && repitaSenha.val() !== "" &&  senha.val() === repitaSenha.val()){
            caixaRepitaSenha.empty();
            repitaSenha.addClass("imgCerto");
            confRepitaSenha = true;
            
        }else{
            caixaRepitaSenha.html('As senhas são diferenteres');
            repitaSenha.removeClass("imgCerto");
            confRepitaSenha = false;
        } 
    }

    function resetarCampos(){
        $('#nome').removeClass("imgCerto");
        $('#email').removeClass("imgCerto");
        $('#login').removeClass("imgCerto");
        $('#senha').removeClass("imgCerto");
        $('#repitasenha').removeClass("imgCerto");
    }

});

// Ação reCaptcha
var captchar = false;
var caixaReCaptchar = $('#caixa-capche');

var onLoadCallback = function () {
    grecaptcha.render('recaptchaContainer', {
    'sitekey': '6LfARUMUAAAAAN96-NSEDHVvgqtbYnUQfAOTgqYm',
    'theme' : 'light',
    'expired-callback': resetar,
    'callback': liberar
    });
};
            
function resetar(){
    grecaptcha.reset();
    captchar = false;
}
            
 function liberar(){
    captchar = true;
    caixaReCaptchar.removeClass('alertCaptchar');
}