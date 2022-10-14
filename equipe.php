<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$detect = new Mobile_Detect();

$js_head = <<<JAVASCRIPT
   
    <script src="./scripts/jquery-1.12.3.min.js" type="text/javascript"></script>
        
JAVASCRIPT;

/* * ***************************************************************************
 * CONTEÚDO
 * *************************************************************************** */

$vetor_conteudo = Array();


$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > Galeria de Ex-Presidentes";


$vetor_conteudo['nome_link'] = 'Galeria de Ex-Presidentes';

$ctr_gestao = new Gestao_Control($post_request);

$gestoes = $ctr_gestao->Lista_Gestoes(9999, 0, 'desc_gestao DESC', "AND destaque_gestao = '0'");

$ctr_colaborador = new Colaborador_Control($post_request);

$html_gestores = "";
foreach ($gestoes as $gestao) {
    $html_gestores .= "
        <div class='titulo_gestao'>Gestão ".$gestao['desc_gestao']."</div>
        <div class='gestores'>
            ";
    
    $colaboradores = $ctr_colaborador->Lista_Colaboradores(9999, 0, 'ordem ASC', ' AND id_gestao=' . $gestao['id_gestao'] . '');
    
    foreach ($colaboradores as $colaborador){
        $html_gestores .= "
            <div class='colaborador'>
                <div class='foto_colaborador' style='background-image: url(\"./sistema/sys/arquivos/img_colaborador/".$colaborador['foto'].".".$colaborador['ext_foto']."\")'></div>
                <div class='funcao'>".$colaborador['funcao']."</div>
                <div class='nome'>".$colaborador['nome']."</div>
                <div class='ver_gestao' id='".$colaborador['id_colaborador']."'>Ver mais</div>
            </div>
            ";
    }
    $html_gestores .= "</div>";
}


$vetor_conteudo['conteudo'] = "<div class='colaboradores'>$html_gestores</div>
        <div class='fundo_escuro'>
            <div id='outros_colaboradores'>
                <div id='close_outros_colaboradores'></div>
                <div id='texto_outros_colaboradores'></div>
            </div>
        </div>
        ";


TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template2.php', $js_head, "", "", $vetor_conteudo);
} else {
    TemplateManager::show('template2.php', $js_head, "", "", $vetor_conteudo);
}
?>