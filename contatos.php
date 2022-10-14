<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$detect = new Mobile_Detect();

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$js_head = <<<JAVASCRIPT
        

JAVASCRIPT;

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > Fale conosco";

$vetor_conteudo['nome_link'] = "FALE CONOSCO";


/* * ***************************************************************************
 * MONTA FORMULÁRIO
 * *************************************************************************** */

if($detect->isMobile() && !$detect->isTablet()){
    $iframe_mapa = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1767.9853821447446!2d-48.55175112422894!3d-27.594435995688656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x952738231359f95b%3A0xc7cca0f15da848a8!2sR.+Pres.+Nereu+Ramos%2C+69+-+Centro%2C+Florian%C3%B3polis+-+SC%2C+88015-010!5e0!3m2!1spt-BR!2sbr!4v1541607248538" width="100%" height="220" frameborder="0" style="border:0" allowfullscreen></iframe>';
}else{
    $iframe_mapa = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1767.9853821447446!2d-48.55175112422894!3d-27.594435995688656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x952738231359f95b%3A0xc7cca0f15da848a8!2sR.+Pres.+Nereu+Ramos%2C+69+-+Centro%2C+Florian%C3%B3polis+-+SC%2C+88015-010!5e0!3m2!1spt-BR!2sbr!4v1541607248538" width="100%" height="425" frameborder="0" style="border:0" allowfullscreen></iframe>';
}


$vetor_conteudo['conteudo'] = '
        
        <div id="formulario_contato">
            <form id="formContato" name="formContato" onSubmit="return false">	
            
                <label>Nome*</label>
                <input name="nome" type="text" id="nome" maxlength="60" value="" onKeyPress="Mascara(this, Letra);"/>							
                
                <label>Email*</label>
                <input name="email" type="text" id="email" maxlength="110" value="" />							

                <label>Telefone*</label>
                <input name="telefone" onkeypress="Mascara(this, Telefone);" type="text" id="telefone" maxlength="15" value="" />							

                <label>Assunto*</label>
                <input name="assunto" type="text" id="assunto" value=""/>							

                <label>Mensagem*</label>
                <textarea name="mensagem" id="mensagem"></textarea>							

                <div class="form_botao">					
                    <input id="botao-enviar" type="submit" value="ENVIAR" name="enviar" class="botao-enviar" />	
                    <div id="msg_formulario"></div>				
                </div>
            </form>
            
        </div>
        
        <div class="onde_estamos">
            <div class="titulo">ONDE ESTAMOS</div>
            <div class="endereco"><p>R. Presidente Nereu Ramos, 69 - Edifício Bello Empresarial, Sala 204 - Centro, Florianópolis - SC, 88015-010</p></div>
            <div class="mapa">
                '.$iframe_mapa.'
            </div>
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