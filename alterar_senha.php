<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$detect = new Mobile_Detect();

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$js_head = <<<JAVASCRIPT
        

JAVASCRIPT;

$ctr_associado = new Associado_Control($post_request);
$associado = $ctr_associado->Pega_Associado($_SESSION['id_associado']);
$data = new Data();

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > <a href='/area-restrita'>Área Restrita</a> > Alterar Senha";

$vetor_conteudo['nome_link'] = "ALTERAR MINHA SENHA";


/* * ***************************************************************************
 * MONTA FORMULÁRIO
 * *************************************************************************** */


$vetor_conteudo['conteudo'] = '
        
        <div id="formulario_alterar_senha">
            <form id="formAlterarSenha" name="formAlterarSenha" onSubmit="return false">	
            
                <input type="hidden" name="id_associado" id="id_associado" value="'.$associado['id_associado'].'" />

                <div class="box_item_form">
                    <label>Senha atual*</label>
                    <input name="senha_atual" type="password" id="senha_atual" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Nova senha*</label>
                    <input name="nova_senha" type="password" id="nova_senha" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Confirmação de nova senha*</label>
                    <input name="nova_senha2" type="password" id="nova_senha2" value="" />						
                </div>
               

                <div class="form_botao">					
                    <input id="botao-enviar" type="submit" value="ALTERAR" name="enviar" class="botao-enviar" />	
                    <div id="msg_formulario"></div>				
                </div>
            </form>
            
        </div>
        ';
?>

<?php

TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template2.php', $js_head, "", "", $vetor_conteudo);
} else {
    TemplateManager::show('template2.php', $js_head, "", "", $vetor_conteudo);
}
?>