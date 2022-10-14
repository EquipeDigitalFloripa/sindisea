<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$post_request = array_merge($_POST, $_REQUEST);

$detect = new Mobile_Detect();

$js_head = <<<JAVASCRIPT
   
    <script src="scripts/jquery-1.12.3.min.js" type="text/javascript"></script>
    <script src="/scripts/jquery.validate.js" type="text/javascript"></script>        
    <script src="/scripts/jquery.mask.js" type="text/javascript"></script>
        
JAVASCRIPT;

/* * ***************************************************************************
 * CONTEÚDO
 * *************************************************************************** */
$ctr_conteudo = new Conteudo_Control($post_request);
//$vetor_conteudo = $ctr_conteudo->Conteudo_Exibe();

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > O Sindisea";

$vetor_conteudo['nome_link'] = "O Sindisea";


$conteudo_a_empresa = $ctr_conteudo->Pega_Conteudo(2);
$conteudo_missao = $ctr_conteudo->Pega_Conteudo(4);
$conteudo_visao = $ctr_conteudo->Pega_Conteudo(5);
$conteudo_valores = $ctr_conteudo->Pega_Conteudo(6);
$conteudo_diretoria = $ctr_conteudo->Pega_Conteudo(7);

$ctr_gestao = new Gestao_Control($post_request);
$gestao_destaque = $ctr_gestao->Pega_Gestao_Destaque();
$ctr_colaborador = new Colaborador_Control($post_request);
$lista_colaboradores = $ctr_colaborador->Lista_Colaboradores(99999, 0, 'ordem ASC', ' AND id_gestao='.$gestao_destaque['id_gestao']);
$colaboradores = "";
foreach ($lista_colaboradores as $colaborador){
    $colaboradores .= "
            <div class='colaborador'>
                <div class='foto_colaborador' style='background-image: url(\"./sistema/sys/arquivos/img_colaborador/".$colaborador['foto'].".".$colaborador['ext_foto']."\")'></div>
                <div class='funcao'>".$colaborador['funcao']."</div>
                <div class='nome'>".$colaborador['nome']."</div>
                <div class='ver_gestao' id='".$colaborador['id_colaborador']."'>Ver mais</div>
            </div>
            ";
}

$vetor_conteudo['conteudo'] = "
    <div class='o_sindiasea'>
        <div class='foto_a_empresa'></div>
        <div class='conteudo_a_empresa'>".$conteudo_a_empresa['conteudo']."</div>

        <div class='divisao_2nivel'></div>

        <div class='mvv'>
            <div class='item'>
                <div class='icone missao'></div>
                <div class='titulo_item'>MISSÃO</div>
                <div class='conteudo_item'>".$conteudo_missao['conteudo']."</div>
            </div>
            <div class='item'>
                <div class='icone visao'></div>
                <div class='titulo_item'>VISÃO</div>
                <div class='conteudo_item'>".$conteudo_visao['conteudo']."</div>
            </div>
            <div class='item'>
                <div class='icone valores'></div>
                <div class='titulo_item'>VALORES</div>
                <div class='conteudo_item'>".$conteudo_valores['conteudo']."</div>
            </div>
        </div>

        <div class='divisao_2nivel_cinza'></div>

        <div class='diretoria'>
            <div class='titulo'>DIRETORIA SINDISEA</div>
            <div class='conteudo_diretoria'>
                <h1>Gestão ".$gestao_destaque['desc_gestao']."</h1>
                <div class='colaboradores'>
                    $colaboradores
                </div>
                <div class='fundo_escuro'>
                    <div id='outros_colaboradores'>
                        <div id='close_outros_colaboradores'></div>
                        <div id='texto_outros_colaboradores'></div>
                    </div>
                </div>
            </div>
            <a href='/ex-presidentes'><div class='veja_mais' style='background-color: #ccc; height: 40px; line-height: 40px; color: #000; width: 280px; margin: 0; float: left; margin-top: 10px;'>Veja as gestões anteriores</div></a>
            <a href='/diretoria-sindiasea'><div class='veja_mais veja_mais_empresa' style='background-color: #ccc; height: 40px; line-height: 40px; color: #000; width: 280px; margin: 0; margin-top: 10px;float: left;'>Veja a diretoria atual completa</div></a>
        </div>

        <div class='estatuto'>
            <div class='titulo'>ESTATUTO DO SINDISEA</div>
            <div class='conteudo_estatuto'>Baixe o nosso estatuto e leia-o onde quiser.</div>
            <a href='/sistema/sys/arquivos/estatuto/estatuto.pdf' download><div class='download_estatuto'><div class='pdf_icon'></div><p>CLIQUE AQUI PARA BAIXAR O PDF</p></div></a>
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