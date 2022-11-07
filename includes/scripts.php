<?php

/**
 * Inclusão de Scripts JavaScript nos Templates do site
 * 
 * OBS 1 : Para ativá-los basta descomentar os códigos abaixo
 * 
 * OBS 2 : Caso precise adicionar novos scripts, adicionar no final.
 * Não esqueça de comentar a utilizade do mesmo
 */

$html_js = "\n";

//FORMULÁRIO DE CONTATOS
$html_js .= '  <script type="text/javascript">
        jQuery(document).ready(function ($) {
        
            $(\'#data_nascimento\').mask(\'00/00/0000\');
            $(\'#cpf_form\').mask(\'000.000.000-00\');
            $(\'#telefone\').mask(SPMaskBehavior, spOptions);
            $(\'#telefone_trabalho\').mask(SPMaskBehavior, spOptions);
            $(\'#telefone_celular\').mask(SPMaskBehavior, spOptions);
            $(\'#telefone_residencial\').mask(SPMaskBehavior, spOptions);
            $(\'#cep\').mask(\'00000-000\');

            $(".scroll").click(function (event) {
                event.preventDefault();
                $(\'html,body\').animate({scrollTop: $(this.hash).offset().top}, 800);
            });
        
            jQuery(\'#formContato\').submit(function () {
                var nome = $(\'#nome\');
                var telefone = $(\'#telefone\');
                var email = $(\'#email\');
                var mensagem = $(\'#mensagem\');

                if (nome.val() == "") {
                    nome.focus();
                    msg = "Preencha o nome corretamente";
                    $("#msg_formulario").text(msg);
                } else if (email.val() == "") {
                    email.focus();
                    msg = "Preencha o email corretamente";
                    $("#msg_formulario").text(msg);
                } else if (!checkMail(email.val())) {
                    email.focus();
                    msg = "Email inválido. Preencha o email corretamente";
                    $("#msg_formulario").text(msg);
                } else if (telefone.val() == "") {
                    telefone.focus();
                    msg = "Preencha o telefone corretamente";
                    $("#msg_formulario").text(msg);
                } else if (mensagem.val() == "") {
                    mensagem.focus();
                    msg = "Campo Mensagem não preenchido";
                    $("#msg_formulario").text(msg);
                }  else {
                    var dados = jQuery(this).serialize(); 
                    
                    $(\'#msg_formulario\').text("Enviando...");
                    jQuery.ajax({
                        type: "POST",
                        url: "contato_02.php",
                        data: dados,
                        dataType: \'json\',
                        success: function (data){                                
                            if (data[\'sucesso\'] == 1){
                                $(\'#formContato\')[0].reset();
                                msg = "Mensagem enviada com sucesso.";
                                $("#msg_formulario").text(msg);
                            } else {
                                msg = "Falha no envio de email. Tente novamente!";
                                $("#msg_formulario").text(data);
                            }
                        }
                    });
                }
                return false;
            });
        });
    </script>';

//FORMULÁRIO FILIAÇÃO
$html_js .= '  <script type="text/javascript">
        jQuery(document).ready(function ($) {        
            jQuery("#formFiliacao").submit(function () {
                var nome = $("#nome");
                var email_pessoal = $("#email_pessoal");
                var email_trabalho = $("#email_trabalho");
                var cpf = $("#cpf_form");
                var data_nascimento = $("#data_nascimento");
                var matricula = $("#matricula");
                var unidade_organizacional = $("#unidade_organizacional");
                var categoria = $("select[name=categoria]");
                var telefone_residencial = $("#telefone_residencial");
                var telefone_trabalho = $("#telefone_trabalho");
                var celular = $("#telefone_celular");
                var cep = $("#cep");
                var endereco = $("#endereco");
                var numero = $("#numero");
                var bairro = $("#bairro");
                var cidade = $("#cidade");
                var estado = $("select[name=estado]");
                var senha = $("#senha_form");
                var senha2 = $("#senha2");
                var termos = $("#termos_checkbox");
                
               
                if (nome.val() == "") {
                    msg = "Preencha o nome corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (email_pessoal.val() == "") {
                    msg = "Preencha o Email Pessoal corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (!checkMail(email_pessoal.val())) {
                    msg = "Email Pessoal inválido. Preencha o email corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (cpf.val() == "") {
                    msg = "Preencha o CPF corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (data_nascimento.val() == "") {
                    msg = "Data de Nascimento não preenchida";
                    $("#msg_formulario2").text(msg);
                } else if (matricula.val() == "") {
                    msg = "Preencha a matrícula corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (categoria.val() == 0) {
                    msg = "Selecione uma categoria";
                    $("#msg_formulario2").text(msg);
                } else if (celular.val() == "") {
                    msg = "Preencha o telefone celular corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (celular.val().length != 15) {
                    msg = "Preencha os 9 digitos do celular";
                    $("#msg_formulario2").text(msg);
                } else if (cep.val() == "") {
                    msg = "Preencha o CEP corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (endereco.val() == "") {
                    msg = "Preencha o endereco corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (numero.val() == "") {
                    msg = "Preencha o número corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (bairro.val() == "") {
                    msg = "Preencha o bairro corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (cidade.val() == "") {
                    msg = "Preencha a cidade corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (estado.val() == 0) {
                    msg = "Selecione o estado corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (senha.val() == "") {
                    msg = "Informe a senha corretamente";
                    $("#msg_formulario2").text(msg);
                } else if (senha.val() != senha2.val()) {
                    msg = "As duas senhas não conferem";
                    $("#msg_formulario2").text(msg);
                } else if(!termos.is(":checked")){
                    msg = "Aceite os termos de uso para continuar."
                    $("#msg_formulario2").text(msg);
                } else {
                    var dados = jQuery(this).serialize();        
                    
                    $("#msg_formulario2").text("Enviando...");
                    jQuery.ajax({
                        type: "POST",
                        url: "filiacao_02.php",
                        data: dados,
                        dataType: "json",
                        success: function (data){
                            console.log(data.sucesso, data["sucesso"]);
                            if (data["sucesso"] == 1 || data.sucesso == 1){
                                $("#formFiliacao")[0].reset();
                                msg = "Obrigado! Enviamos seu pedido para avaliação.";
                                $("#msg_formulario2").text(msg);
                            } else {
                                if (data["sucesso"] == 2 || data.sucesso == 2){
                                    $("#formFiliacao")[0].reset();
                                    msg = "CPF já cadastrado. Por favor, entre em contato com um administrador.";
                                    $("#msg_formulario2").text(msg);
                                } else {
                                    msg = "Falha no envio de email. Tente novamente!";
                                    $("#msg_formulario2").text(data);
                                }
                            }
                        }
                    });
                }
                return false;
            });
        });
    </script>';

//FORMULÁRIO LOGIN
$html_js .= '  <script type="text/javascript">
        jQuery(document).ready(function ($) {
        
            $(\'#cpf\').mask(\'000.000.000-00\');
        
            jQuery(\'#form_login\').submit(function () {
                var cpf = $(\'#cpf\');
                var senha = $(\'#senha\');

                if (cpf.val() == "") {
                    cpf.focus();
                    msg = "Preencha o CPF corretamente";
                } else if (senha.val() == "") {
                    senha.focus();
                    msg = "Campo Senha não preenchido";
                } else {
                    var dados = jQuery(this).serialize();        
                    $(\'#msg_formulario\').text("Enviando...");
                    jQuery.ajax({
                        type: "POST",
                        url: "login_02.php",
                        data: dados,
                        dataType: \'json\',
                        success: function (data){
                            if (data[\'sucesso\'] == 1){
                                window.location = "/area-restrita";
                            } else {
                                window.location = "/login";
                            }
                        }
                    });
                }
                return false;
            });
        });
    </script>';


//FORMULÁRIO ALTERAR DADOS
$html_js .= '  <script type="text/javascript">
        jQuery(document).ready(function ($) {        
            jQuery(\'#formAlterarDados\').submit(function () {
                var nome = $(\'#nome\');
                var email_pessoal = $(\'#email_pessoal\');
                var cpf = $(\'#cpf_form\');
                var data_nascimento = $(\'#data_nascimento\');
                var matricula = $(\'#matricula\');
                var unidade_organizacional = $(\'#unidade_organizacional\');
                var categoria = $(\'select[name=categoria]\');
                var telefone = $(\'#telefone\');
                var celular = $(\'#telefone_celular\');
                var cep = $(\'#cep\');
                var endereco = $(\'#endereco\');
                var numero = $(\'#numero\');
                var bairro = $(\'#bairro\');
                var cidade = $(\'#cidade\');
                var estado = $(\'select[name=estado]\');
                
                if (nome.val() == "") {
                    nome.focus();
                    msg = "Preencha o nome corretamente";
                    $("#msg_formulario").text(msg);
                } else if (email_pessoal.val() == "") {
                    email_pessoal.focus();
                    msg = "Preencha o Email Pessoal corretamente";
                    $("#msg_formulario").text(msg);
                } else if (!checkMail(email_pessoal.val())) {
                    email_pessoal.focus();
                    msg = "Email inválido. Preencha o Email Pessoal corretamente";
                    $("#msg_formulario").text(msg);
                } else if (cpf.val() == "") {
                    cpf.focus();
                    msg = "Preencha o CPF corretamente";
                    $("#msg_formulario").text(msg);
                } else if (data_nascimento.val() == "") {
                    data_nascimento.focus();
                    msg = "Data de Nascimento não preenchida";
                    $("#msg_formulario").text(msg);
                } else if (matricula.val() == "") {
                    matricula.focus();
                    msg = "Preencha a matrícula corretamente";
                    $("#msg_formulario").text(msg);
                } else if (unidade_organizacional.val() == "") {
                    unidade_organizacional.focus();
                    msg = "Unidade organizacional não preenchida";
                    $("#msg_formulario").text(msg);
                } else if (categoria.val() == 0) {
                    categoria.focus();
                    msg = "Selecione uma categoria";
                    $("#msg_formulario").text(msg);
                } else if (telefone.val() == "") {
                    telefone.focus();
                    msg = "Preencha o telefone corretamente";
                    $("#msg_formulario").text(msg);
                } else if (celular.val() == "") {
                    msg = "Preencha o telefone celular corretamente";
                    $("#msg_formulario").text(msg);
                } else if (celular.val().length != 15) {
                    msg = "Preencha os 9 digitos do celular";
                    $("#msg_formulario").text(msg);
                } else if (cep.val() == "") {
                    cep.focus();
                    msg = "Preencha o CEP corretamente";
                    $("#msg_formulario").text(msg);
                } else if (endereco.val() == "") {
                    endereco.focus();
                    msg = "Preencha o endereco corretamente";
                    $("#msg_formulario").text(msg);
                } else if (numero.val() == "") {
                    numero.focus();
                    msg = "Preencha o número corretamente";
                    $("#msg_formulario").text(msg);
                } else if (bairro.val() == "") {
                    bairro.focus();
                    msg = "Preencha o bairro corretamente";
                    $("#msg_formulario").text(msg);
                } else if (cidade.val() == "") {
                    cidade.focus();
                    msg = "Preencha a cidade corretamente";
                    $("#msg_formulario").text(msg);
                } else if (estado.val() == 0) {
                    estado.focus();
                    msg = "Selecione o estado corretamente";
                    $("#msg_formulario").text(msg);
                } else {
                    var dados = jQuery(this).serialize();        
                    $(\'#msg_formulario\').text("Enviando...");
                    jQuery.ajax({
                        type: "POST",
                        url: "webservice.php?acao=alterardados",
                        data: dados,
                        dataType: "json",
                        success: function (data){
                            msg = "Informações alteradas com sucesso.";
                            $("#msg_formulario").text(msg);
                        }
                    });
                }
                return false;
            });
        });
    </script>';


//FORMULÁRIO ALTERAR SENHA
$html_js .= '  <script type="text/javascript">
        jQuery(document).ready(function ($) {        
            jQuery(\'#formAlterarSenha\').submit(function () {
                var senha_atual = $(\'#senha_atual\');
                var nova_senha = $(\'#nova_senha\');
                var nova_senha2 = $(\'#nova_senha2\');
                
                if (senha_atual.val() == "") {
                    senha_atual.focus();
                    msg = "Preencha a senha atual";
                    $("#msg_formulario").text(msg);
                } else if (nova_senha.val() == "") {
                    nova_senha.focus();
                    msg = "Preencha a nova senha";
                    $("#msg_formulario").text(msg);
                } else if (nova_senha2.val() == "") {
                    nova_senha2.focus();
                    msg = "Preencha a confirmação de senha";
                    $("#msg_formulario").text(msg);
                } else if (nova_senha.val() != nova_senha2.val()) {
                    msg = "A senha e a confirmação de senha não conferem.";
                    $("#msg_formulario").text(msg);
                } else {
                    var dados = jQuery(this).serialize();        
                    $(\'#msg_formulario\').text("Enviando...");
                    jQuery.ajax({
                        type: "POST",
                        url: "webservice.php?acao=alterarsenha",
                        data: dados,
                        dataType: "json",
                        success: function (data){
                            if(data[\'sucesso\'] == 1){
                                msg = "Senha alterada com sucesso.";
                                $("#msg_formulario").text(msg);
                            }else{
                                msg = "Senha atual incorreta.";
                                senha_atual.focus();
                            }
                            $("#msg_formulario").text(msg);
                        }
                    });
                }
                return false;
            });
        });
    </script>';


//FORMULÁRIO ESQUECEU SENHA
$html_js .= '  <script type="text/javascript">
        jQuery(document).ready(function ($) {      
            jQuery(\'#formEsqueceuSenha\').submit(function () {
                var cpf = $(\'#cpf_form\');
                
                if (cpf.val() == "") {
                    cpf.focus();
                    msg = "Por favor, preencha o CPF.";
                    $("#msg_formulario").text(msg);
                } else {
                    var dados = jQuery(this).serialize();        
                    $(\'#msg_formulario\').text("Enviando...");
                    jQuery.ajax({
                        type: "POST",
                        url: "esqueceu_senha_02.php",
                        data: dados,
                        dataType: "json",
                        success: function (data){
                            console.log(data);
                            if(data[\'sucesso\'] == 1){
                                msg = "Enviamos sua solicitação de senha por email.";
                                $("#msg_formulario").text(msg);
                            }else{
                                msg = "Desculpe, não encontramos este CPF em nosso cadastro.";
                                cpf.focus();
                                alert(msg);
                            }
                            $("#msg_formulario").text(msg);
                        }
                    });
                }
                return false;
            });
        });
    </script>';


//FORMULÁRIO REDEFINIR SENHA
$html_js .= '  <script type="text/javascript">
        jQuery(document).ready(function ($) {      
            jQuery(\'#formRedefinirSenha\').submit(function () {
                var nova_senha = $(\'#senha_1\');
                var confirmacao = $(\'#senha_2\');
                
                if (nova_senha.val() == "") {
                    nova_senha.focus();
                    msg = "Por favor, preencha o campo senha.";
                    $("#msg_formulario").text(msg);
                } else if (nova_senha.val() != confirmacao.val()) {
                    msg = "As duas senhas não conferem.";
                    $("#msg_formulario").text(msg);
                } else{
                    var dados = jQuery(this).serialize();        
                    $(\'#msg_formulario\').text("Enviando...");
                    jQuery.ajax({
                        type: "POST",
                        url: "webservice.php?acao=redefinirsenha",
                        data: dados,
                        dataType: "json",
                        success: function (data){
                            msg = "Senha alterada com sucesso!";
                            $("#msg_formulario").text(msg);
                            
                            window.setTimeout( function(){
                                window.location = "/inicio";
                            }, 400 );
                        }
                    });
                }
                return false;
            });
        });
    </script>';


//FORMULÁRIO PÁGINA LOGIN
$html_js .= '  <script type="text/javascript">
        jQuery(document).ready(function ($) {      
            jQuery(\'#formLogin\').submit(function () {
                var cpf = $(\'#cpf_form\');
                var senha = $(\'#senha_form\');
                
                if (cpf.val() == "") {
                    nova_senha.focus();
                    msg = "Por favor, informe o CPF.";
                    $("#msg_formulario").text(msg);
                } else if (senha.val() == "") {
                    msg = "Por favor, informe a senha.";
                    $("#msg_formulario").text(msg);
                } else{
                    var dados = jQuery(this).serialize();        
                    $(\'#msg_formulario\').text("Enviando...");
                    jQuery.ajax({
                        type: "POST",
                        url: "login_02.php?tela=login",
                        data: dados,
                        dataType: \'json\',
                        success: function (data){
                            if (data[\'sucesso\'] == 1){
                                window.location = "/area-restrita";
                            } else {
                                msg = "CPF ou senha incorretos.";
                                $("#msg_formulario").text(msg);
                            }
                        }
                    });
                }
                return false;
            });
        });
    </script>';

//FORMULÁRIO ALTERAR SENHA
$html_js .= '  <script type="text/javascript">
        jQuery(document).ready(function ($) {        
            $("#sair").click(function (event) {
                jQuery.ajax({
                    type: "POST",
                    url: "webservice.php?acao=logout",
                    success: function (data){
                        window.location = "/inicio";
                    }
                });
            });
            
            $("select").change(function () {
                var str = "";
                $("select option:selected").each(function() {
                  str += $(this).text() + "";
                });
                jQuery.ajax({
                    type: "POST",
                    url: "webservice.php?acao=listar_arquivos&aba=" + str,
                    dataType: "json",
                    success: function (data) {
                        $("#lista_arquivos").html(data["lista_arquivos"]);
                        
                    }
                });
            });
            
            $(".ver_gestao").click(function (event) {
                var id_colaborador = $(this).attr("id");
                jQuery.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "webservice.php?acao=listar_colaboradores&id_colaborador="+id_colaborador,
                    success: function (data) {
                        $("#texto_outros_colaboradores").html(data["html_colaborador"]);
                        $(".fundo_escuro").css("display", "block");
                    }
                });
            });
            
            $("#close_outros_colaboradores").click(function (event) {
                $(".fundo_escuro").css("display", "none");
            });

        });
    </script>';

echo $html_js;
