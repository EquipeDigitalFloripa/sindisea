<?php

if(isset($_SESSION['id_associado']) && $_SESSION['id_associado'] > 0){
    
    $ctr_associado = new Associado_Control($post_request);
    $associado = $ctr_associado->Pega_Associado($_SESSION['id_associado']);
    
    $nome_associado = explode(" ", $associado['nome']);
    
    
    $html = ' 
        <div class="titulo_area_restrita_logado">Área restrita<br> do sindicalizado</div>
            
        <div class="informacoes">
            <div class="nome">Olá, '.$nome_associado[0].'</div>
        </div>
        <ul id="opcoes">
                <a href="/area-restrita"><li>Área restrita</li></a>
                <a href="/alterar-dados"><li>Alterar meus dados</li></a>
                <a href="/alterar-senha"><li>Alterar senha</li></a>
                <li id="sair">Sair</li>
            </ul>
        ';
}else{
    $html = '
            <div class="titulo_area_restrita">Área restrita do sindicalizado</div>
            <form name="form_login" id="form_login" method="post" action=""  onSubmit="return validar_form_login();">
                <div class="icone icone_login"></div><input name="cpf" type="text" id="cpf" placeholder="CPF" />
                <div class="icone icone_pass"></div><input type="password" name="senha" id="senha" placeholder="Senha" />
                <input type="submit" value="Entrar" name="entrar" id="entrar" class="botao-entrar" />
            </form>
            <div class="infos"><a href="/filie-se">Filie-se</a> | <div id="perdeu_sua_senha"><a href="/perdeu-senha">Perdeu sua senha?</a></div></div>
        ';
}

echo $html;