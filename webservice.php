<?php

session_start();

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');


require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");
$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$json = array();

$data = new Data();

if (isset($post_request['acao']) && $post_request['acao'] == 'noticias') {
    $ctr_noticia = new Noticia_Control($post_request);
    $html_noticias = "";
    $json['total'] = 0;
    if (isset($post_request['ac']) && $post_request['ac'] == "busca") {
        $condicao = " AND data_publicacao_noticia <= now() AND (titulo_noticia LIKE '%" . $post_request['busca'] . "% OR texto_noticia LIKE '%" . $post_request['busca'] . "%)' AND status_noticia = 'A'";
        $array_noticias = $ctr_noticia->Listar_Noticias($condicao, "data_noticia DESC", 0, 9);
    } else {
        $array_noticias = $ctr_noticia->Listar_Noticias(" AND status_noticia = 'A' AND data_publicacao_noticia <= now()", "data_noticia DESC", $post_request['offset'], $post_request['limit']);
        $total = count($ctr_noticia->Listar_Noticias(" AND status_noticia = 'A' AND data_publicacao_noticia <= now()", "data_noticia DESC", 0, 999999));
        if ($total < ($post_request['offset'] + $post_request['limit'])) {
            $json['total'] = 1;
        }
    }

    foreach ($array_noticias as $noticia) {
        $destaque = $ctr_noticia->Pega_Foto_Destaque($noticia['id_noticia']);
        $foto_destaque = $destaque[0]['id_foto'] . "." . $destaque[0]['ext_foto'];
        $html_noticias .= '
            <div class="noticia">
                <a href="noticia/' . $noticia['url_amigavel'] . '">
                    <div class="imagem_noticia" style="background-image: url(\'/sistema/sys/arquivos/img_noticias/' . $foto_destaque . '\')"></div>
                    <div class="publicado_em">Publicado em: ' . $data->get_dataFormat('BD', $noticia["data_noticia"], 'DMA') . '</div>
                    <div class="titulo_noticia">' . $noticia["titulo_noticia"] . '</div>
                    <div class="linha_fina_noticia">' . $noticia["description_noticia"] . '</div>
                 </a>
            </div>
            ';
    }
    $json["conteudo"] = utf8_encode($html_noticias);
} else if (isset($post_request['acao']) && $post_request['acao'] == 'galeria_carrega') {
    $ctr_galeria = new Galeria_Control($post_request);
    $html_galerias = "";
    $json['total'] = 0;
    $array_galerias = $ctr_galeria->Lista_Galerias($post_request['limit'], $post_request['offset'], 'id_galeria DESC', 1);
    $total = count($ctr_galeria->Lista_Galerias(99999999, 0, 'id_galeria DESC', 1));
    if ($total < ($post_request['offset'] + $post_request['limit'])) {
        $json['total'] = 1;
    }

    $num_galeria = $post_request['offset'] + 1;

    foreach ($array_galerias as $galeria) {

        $foto_destaque = $ctr_galeria->Pega_Foto_Destaque($galeria['id_galeria']);

        $foto = $foto_destaque['id_foto'] . "." . $foto_destaque['ext_img'];

        $fotos = $ctr_galeria->Lista_Fotos($galeria['id_galeria']);

        $imagens_galeria = "";

        foreach ($fotos as $foto_galeria) {
            $imagens_galeria .= "
                <li data-exthumbimage=\"/sistema/sys/arquivos/img_galerias/" . $foto_galeria['id_foto'] . "." . $foto_galeria['ext_img'] . "\" style=\"display: none;\" data-src=\"/sistema/sys/arquivos/img_galerias/" . $foto_galeria['id_foto'] . "." . $foto_galeria['ext_img'] . "\" data-sub-html=\"" . $foto_galeria['leg'] . "\">                
                    
                </li>
            ";
        }

        $html_galerias .= "
        <div class='box_galeria'>
            <ul class='galeria lightgallery$num_galeria'>
                <li data-exthumbimage=\"/sistema/sys/arquivos/img_galerias/$foto\" data-src=\"/sistema/sys/arquivos/img_galerias/$foto\" data-sub-html=\"" . $foto_destaque['leg'] . "\">                
                    <a href=\"/sistema/sys/arquivos/img_galerias/$foto\"  title=\"" . $foto_destaque['leg'] . "\">
                        <div class='destaque_galeria' style='background-image: url(\"/sistema/sys/arquivos/img_galerias/$foto\")'></div>
                    </a>
                </li>
                $imagens_galeria
            </ul>
            <div class='titulo_galeria'>" . $galeria['titulo'] . "</div>
        </div>
        ";

        $num_galeria++;
    }
    $json["conteudo"] = utf8_encode($html_galerias);
} else if (isset($post_request['acao']) && $post_request['acao'] == 'listar_arquivos') {

    $html_arquivos = "";
    $condicao = "";

    if ($post_request['aba'] == "Balancetes") {


        $ctr_balancetes = new Balancete_Control($post_request);

        //LISTAR ANOS DOS BALANCETES
        $balancete_mais_antigo = $ctr_balancetes->Lista_Balancetes(1, 0, 'data ASC');
        $balancete_mais_novo = $ctr_balancetes->Lista_Balancetes(1, 0, 'data DESC');

        $lista_anos = range(gmdate('Y', strtotime($balancete_mais_antigo[0]['data'])), gmdate('Y', strtotime($balancete_mais_novo[0]['data'])));

        $opcoes = "";

        foreach ($lista_anos as $ano) {
            $opcoes .= "
        <option value=\"$ano\">$ano</option>
        ";
        }

        $select_ano = "<select onchange='menu_selecao()' name='ano_balancete' id='ano_balancete'>
                <option value=\"0\">Selecione o ano</option>
                $opcoes
               </select>
        ";


        $select_mes = '<select onchange="menu_selecao()" name="mes_balancete" id="mes_balancete">
                    <option value="0">Escolha o mês</option>
                    <option value="01">Janeiro</option>
                    <option value="02">Fevereiro</option>
                    <option value="03">Março</option>
                    <option value="04">Abril</option>
                    <option value="05">Maio</option>
                    <option value="06">Junho</option>
                    <option value="07">Julho</option>
                    <option value="08">Agosto</option>
                    <option value="09">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
            </select>';


        $html_arquivos .= "
            <form id='selecao'>
                $select_mes
                $select_ano
            </form>
            ";

        if (isset($post_request['ano_balancete']) && $post_request['ano_balancete'] != '0') {
            $condicao .= " AND year(data) = '" . $post_request['ano_balancete'] . "'";
        }
        if (isset($post_request['mes_balancete']) && $post_request['mes_balancete'] != '0') {
            $condicao .= " AND month(data) = '" . $post_request['mes_balancete'] . "'";
        }

        $html_arquivos .= "
            <div class='arquivos_l'>
            ";

        $balancetes = $ctr_balancetes->Lista_Balancetes(12, 0, 'data DESC', $condicao);
        foreach ($balancetes as $balancete) {
            $html_arquivos .= "
                <div class='balancete'>
                    <div class='data_balancete'>" . utf8_decode(ucfirst(strftime('%B de %Y', strtotime($balancete['data'])))) . "</div>
                    <a href='/sistema/sys/arquivos/arquivo_balancete/balancete_" . $balancete['id_balancete'] . "/" . $balancete['completo'] . "' download><div class='arquivo'><span>Completo</span></div></a>
                    <!--<a href='/sistema/sys/arquivos/arquivo_balancete/balancete_" . $balancete['id_balancete'] . "/" . $balancete['movimento_caixa'] . "' download><div class='arquivo'><span>Movimento caixa</span></div></a>-->
                    <a href='/sistema/sys/arquivos/arquivo_balancete/balancete_" . $balancete['id_balancete'] . "/" . $balancete['resumido'] . "' download><div class='arquivo_img'><span>Resumido</span></div></a>
                </div>
                ";
        }
        $html_arquivos .= "</div>";

        $total = count($ctr_balancetes->Lista_Balancetes(99999999, 0, 'data DESC', $condicao));
        if ($total > 12) {
            $html_arquivos .= '<div onclick="carrega_bal()" id="ver_mais_balancetes">Ver mais balancetes</div>';
        }
    } else {
        $ctr_categoria_arquivo = new CategoriaArquivo_Control($post_request);
        $categoria = $ctr_categoria_arquivo->Pega_Categoria(0, $post_request['aba']);

        $ctr_arquivo = new Arquivo_Control($post_request);
        $arquivos = $ctr_arquivo->Lista_Arquivos(25, 0, 'data_upload DESC', " AND id_categoria_arquivo = " . $categoria['id_categoria'] . "");
        $data = new Data();
        $html_arquivos .= "
            <div class='arquivos_l'>
            ";
        foreach ($arquivos as $arquivo) {
            $html_arquivos .= "
                    <a href='/sistema/sys/arquivos/arquivos/" . $arquivo['nome_arquivo'] . "' download>
                        <div class='arquivo_download'>
                            <span>" . $data->get_dataFormat('BD', $arquivo['data_upload'], 'DMA') . " - " . $arquivo['desc_arquivo'] . "</span>
                            <br>
                            <div class='nome_arquivo'><span>" . $arquivo['nome_arquivo'] . "</span></div>
                        </div>
                    </a>
                ";
        }
        $html_arquivos .= "</div>";
    }

    $json["lista_arquivos"] = utf8_encode($html_arquivos);
} else if (isset($post_request['acao']) && $post_request['acao'] == 'alterardados') {
    $ctr_associado = new Associado_Control($post_request);
    $ctr_associado->Associado_Altera_Site();
} else if (isset($post_request['acao']) && $post_request['acao'] == 'alterarsenha') {
    $ctr_associado = new Associado_Control($post_request);
    if ($ctr_associado->Associado_Altera_Senha_Site()) {
        $json['sucesso'] = 1;
    } else {
        $json['sucesso'] = 0;
    }
} else if (isset($post_request['acao']) && $post_request['acao'] == 'logout') {
    unset($_SESSION['id_associado']);
} else if (isset($post_request['acao']) && $post_request['acao'] == 'redefinirsenha') {
    $ctr_associado = new Associado_Control($post_request);
    $ctr_associado->Associado_Redefinir_Senha($post_request['id_associado'], $post_request['senha_1']);
} else if (isset($post_request['acao']) && $post_request['acao'] == 'listar_colaboradores') {
    $ctr_colaborador = new Colaborador_Control($post_request);
    $colaborador = $ctr_colaborador->Pega_Colaborador($post_request['id_colaborador']);
    $json['html_colaborador'] = utf8_encode($colaborador['info']);
} else if (isset($post_request['acao']) && $post_request['acao'] = 'carrega_balancetes') {
    $ctr_balancetes = new Balancete_Control($post_request);
    $html_arquivos = "";
    $condicao = "";

    if (isset($post_request['ano_balancete']) && $post_request['ano_balancete'] != '0') {
        $condicao .= " AND year(data) = '" . $post_request['ano_balancete'] . "'";
    }
    if (isset($post_request['mes_balancete']) && $post_request['mes_balancete'] != '0') {
        $condicao .= " AND month(data) = '" . $post_request['mes_balancete'] . "'";
    }

    $balancetes = $ctr_balancetes->Lista_Balancetes($post_request['limit'], $post_request['offset'], 'data DESC', $condicao);
    foreach ($balancetes as $balancete) {
        $html_arquivos .= "
                <div class='balancete'>
                    <div class='data_balancete'>" . utf8_decode(ucfirst(strftime('%B de %Y', strtotime($balancete['data'])))) . "</div>
                    <a href='/sistema/sys/arquivos/arquivo_balancete/balancete_" . $balancete['id_balancete'] . "/" . $balancete['completo'] . "' download><div class='arquivo'><span>Completo</span></div></a>
                    <!--<a href='/sistema/sys/arquivos/arquivo_balancete/balancete_" . $balancete['id_balancete'] . "/" . $balancete['movimento_caixa'] . "' download><div class='arquivo'><span>Movimento caixa</span></div></a>-->
                    <a href='/sistema/sys/arquivos/arquivo_balancete/balancete_" . $balancete['id_balancete'] . "/" . $balancete['resumido'] . "' download><div class='arquivo_img'><span>Resumido</span></div></a>
                </div>
                ";
    }

    $json['total'] = 0;
    $total = count($ctr_balancetes->Lista_Balancetes(99999999, 0, 'data DESC', $condicao));
    if ($total <= ($post_request['offset'] + $post_request['limit'])) {
        $json['total'] = 1;
    }

    $json["conteudo"] = utf8_encode($html_arquivos);
}

echo json_encode($json);
?>