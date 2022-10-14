<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Conteudo, filho de Control
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 04/04/2014 por Marcio Figueredo
 *
 * @package Control
 *
 */
class Conteudo_Control extends Control {

    private $conteudo_dao;

    /**
     * Carrega o contrutor do pai.
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $post_request Parâmetros de _POST e _REQUEST
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *       parent::__construct();
     *       $config = new Config();
     *       $this->usuario_dao = $config->get_DAO("Usuario");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->conteudo_dao = $this->config->get_DAO("Conteudo");
    }

    /**
     * Chama View de Gerenciamento de Páginas
     */
    public function Conteudo_Gerencia() {

        /* CONFIGURE FILTRO DE PESQUISA */
        $condicao .= ($this->post_request['pesquisa'] != "") ? " AND status_conteudo = \"A\" AND nome_link LIKE '%" . $this->post_request['pesquisa'] . "%' " : " AND status_conteudo = \"A\" ";
        $condicao .= ($this->post_request['selecao01'] == 1) ? " AND menu = " . $this->post_request['selecao01'] . "" : "";

        $total_reg = $this->conteudo_dao->get_Total("$condicao");

        /* INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE */
        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        /* CONFIGURE O NUMERO DE REGISTROS POR PAGINA */
        $pag_views = 200; // número de registros por página

        /* CALCULA OS PARAMETROS DE PAGINACAO */
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /* CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS */
        $ordem = "ordem_menu";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->conteudo_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);        
        $descricoes = $this->conteudo_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Conteudo_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama View para Inclusão de Nova Página
     */
    public function Conteudo_Add_V() {

        /* PEGA DESCRIÇÕES */
        $descricoes = $this->conteudo_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Conteudo_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Adiciona Nova Página
     */
    public function Conteudo_Add() {

        $objeto = new Conteudo();

        $objeto->set_nome_link($this->post_request['nome_link']);
        $objeto->set_conteudo("");
        $objeto->set_ordem_menu($this->conteudo_dao->proxima_ordem());
        $objeto->set_status_conteudo('A');
        $objeto->set_menu($this->post_request['menu']);
        $objeto->set_keywords($this->post_request['keywords']);
        $objeto->set_title_url($this->post_request['title_url']);
        $objeto->set_url_amigavel($this->limpaString($this->post_request['url_amigavel']));
        $objeto->set_arquivo_pagina($this->post_request['arquivo_pagina']);
        
        $id_conteudo_new = $this->conteudo_dao->Save($objeto);

        $this->traducao->loadTraducao("3051", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->post_request['id'] = $id_conteudo_new;

        $this->Conteudo_htaccess();
        $this->Conteudo_Add_V();
    }

    /**
     * Chama View para Alteração de Dados da Página
     */
    public function Conteudo_Altera_V() {

        /* PEGA OBJETO E DESCRIÇÕES */
        $objeto = $this->conteudo_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->conteudo_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Conteudo_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera Dados da Página
     */
    public function Conteudo_Altera() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->conteudo_dao->loadObjeto($this->post_request['id']);

        $objeto->set_nome_link($this->post_request['nome_link']);
        $objeto->set_menu($this->post_request['menu']);
        $objeto->set_keywords($this->post_request['keywords']);
        $objeto->set_title_url($this->post_request['title_url']);
        $objeto->set_url_amigavel($this->limpaString($this->post_request['url_amigavel']));
        $objeto->set_arquivo_pagina($this->post_request['arquivo_pagina']);

        $this->conteudo_dao->Save($objeto);

        $this->traducao->loadTraducao("3053", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->Conteudo_htaccess();
        $this->Conteudo_Gerencia();
    }

    /**
     * Apaga Página
     */
    public function Conteudo_Apaga() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->conteudo_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_conteudo("D");
        $objeto->set_ordem_menu(0);
        $objeto->set_menu(0);

        $this->conteudo_dao->Save($objeto);
        $this->conteudo_dao->corrige_ordem_faltante();

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("3052", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Conteudo_Gerencia();
    }

    
    /**
     * Chama View para Edição de Conteudo das Páginas 
     */
    public function Conteudo_Edit_V() {

        /* CONFIGURE FILTRO DE PESQUISA */
        $condicao = " AND status_conteudo = \"A\"";
        $total_reg = $this->conteudo_dao->get_Total($condicao);

        /* CONFIGURE O NUMERO DE REGISTROS POR PAGINA */
        $pag_views = 1000; // número de registros por página

        /* CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS */
        $ordem = "nome_link ASC";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->conteudo_dao->get_Objs($condicao, $ordem, 0, $pag_views);
        $descricoes = $this->conteudo_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $this->post_request['id_conteudo'] = $this->post_request['id'];
        $vw = new Conteudo_Edit_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Edita Conteudo da Página
     */
    public function Conteudo_Edit() {

        /* SETA DADOS e SALVA */
        $objeto2 = $this->conteudo_dao->loadObjeto($this->post_request['id']);
        $objeto2->set_conteudo($this->post_request['conte']);

        $this->conteudo_dao->Save($objeto2);

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("3030", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Conteudo_Edit_V();
    }

    public function LinkConteudo_Acima() {
        $id_conteudo = $this->post_request['id'];
        $this->conteudo_dao->move_Obj($id_conteudo, 'acima');
        $this->Conteudo_Gerencia();
    }

    public function LinkConteudo_Abaixo() {
        $id_conteudo = $this->post_request['id'];
        $this->conteudo_dao->move_Obj($id_conteudo, 'abaixo');
        $this->Conteudo_Gerencia();
    }

    public function limpaString($texto) {
        $aFind = array(' ', '&', 'á', 'à', 'ã', 'â', 'é', 'ê', 'í', 'ó', 'ô', 'õ', 'ú', 'ü', 'ç', 'Á', 'À', 'Ã', 'Â', 'É', 'Ê', 'Í', 'Ó', 'Ô', 'Õ', 'Ú', 'Ü', 'Ç');
        $aSubs = array('-', 'e', 'a', 'a', 'a', 'a', 'e', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'c', 'A', 'A', 'A', 'A', 'E', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'C');
        $novoTexto = str_replace($aFind, $aSubs, $texto);
        return $novoTexto;
    }

    public function Conteudo_htaccess() {
        $dominio = $this->config->get_dominio();
        $modulos = $this->config->get_modulos();

        $cabecalho = "<IfModule mod_rewrite.c> 
            RewriteEngine On 
			RewriteCond %{HTTPS} off    
		    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
            RewriteCond %{REQUEST_URI} ^.+$  
            RewriteCond %{REQUEST_FILENAME} \.(gif|jpe?g|png|js|css|swf|php|ico|txt|pdf|xml)$ [OR]  
            RewriteCond %{REQUEST_FILENAME} -f [OR]   
            RewriteCond %{REQUEST_FILENAME} -d [OR] 
            RewriteCond %{REQUEST_FILENAME} -l  
            RewriteRule ^ - [L] \n";

        $inicial = "RewriteRule ^inicio/?$ /index.php [NC,L] \n";
        
        $todos = $this->conteudo_dao->get_Total("");
        //componentes com ordem > 0
        $lista = $this->conteudo_dao->get_Objs(" AND status_conteudo = 'A'", "nome_link", 0, $todos);

        foreach ($lista as $objCon) {

            $nome = $objCon->get_nome_link();
            $title = $objCon->get_url_amigavel();
            $id = $objCon->get_id_conteudo();
            $arquivo = $objCon->get_arquivo_pagina();

            $jsBd .= "RewriteRule ^$title/?$ /$arquivo?id_conteudo=$id [NC] \n";
        }

        //modulos
        if (array_key_exists("NOTICIAS", $modulos)) {
            $nome = $modulos['NOTICIAS'];
            $jsModulos .= "RewriteRule ^noticia/?$ /noticias.php [NC,L] \n";
            $jsModulos .= "RewriteRule ^noticia/([a-zA-Z0-9-]+)/?$ /noticias.php?url_amigavel=$1 [NC,L] \n";
            $jsModulos .= "RewriteRule ^noticias/?$ /noticias_historico.php [NC,L] \n";
        }
        if (array_key_exists("GALERIAS", $modulos)) {
            $nome = $modulos['GALERIAS'];
            $jsModulos .= "RewriteRule ^galeria/?$ /galerias.php [NC,L] \n";
//            $jsModulos .= "RewriteRule ^galeria/([a-z0-9-]+)/?$ /galerias_2.php?id_galeria=$1 [NC] \n";
        }
        if (array_key_exists("VIDEOS", $modulos)) {
            $nome = $modulos['VIDEOS'];
            $jsModulos .= "RewriteRule ^videos/?$ /videos.php [NC,L] \n";
        }

        
        $nome = $modulos['CONTATOS'];
        if ($nome == "") {
            $nome == "Contatos";
        }

        $mod_padrao = array('NOTICIAS', 'GALERIAS', 'VIDEOS', 'TWITTER', 'CONTATOS');
        foreach ($modulos as $chave => $item) {
            if (!in_array($chave, $mod_padrao)) {
                $jsModulos .= "RewriteRule ^$item/?$ /$chave [NC,L] \n";
            }
        }
        $contatos = "RewriteRule ^contatos/?$ /contatos.php [NC,L] \n";
        
        $extra = "RewriteRule ^login/?$ /login.php [NC,L]
    RewriteRule ^area-restrita/?$ /area_restrita.php [NC,L]
    RewriteRule ^alterar-dados/?$ /alterar_dados.php [NC,L]
    RewriteRule ^alterar-senha/?$ /alterar_senha.php [NC,L]
    RewriteRule ^perdeu-senha/?$ /esqueceu_senha.php [NC,L]
    RewriteRule ^redefinir-senha/?$ /redefinir_senha.php [NC,L]";
        
        $js = $cabecalho . $inicial . $jsBd . $jsModulos . $contatos . $extra;
//        $arquivos = $partes[1];        

        if ($file = fopen("../../.htaccess", "w")) {
            fputs($file, $js . "</IfModule>");
        }
        fclose($file);
    }

    /*
     * *************************************************************************
     * Funcionalidades para o Site
     * *************************************************************************
     */

    public function Conteudo_Exibe() {
        $conteudo = $this->conteudo_dao->loadObjeto($this->post_request['id_conteudo']);
        $dados = $conteudo->get_all_dados();
        return $dados;
    }

    public function Pega_Conteudo($id_conteudo) {
        $conteudo = $this->conteudo_dao->loadObjeto($id_conteudo);
        $dados = $conteudo->get_all_dados();
        return $dados;
    }

    public function Pega_Title_URL($id_conteudo) {
        $conteudo = $this->conteudo_dao->loadObjeto($id_conteudo);
        $dados = $conteudo->get_title_url();
        return $dados;
    }

    public function Pega_Keywords($id_conteudo) {
        $conteudo = $this->conteudo_dao->loadObjeto($id_conteudo);
        $dados = $conteudo->get_keywords();
        return $dados;
    }

    public function Conteudo_Exibe_Menu() {
        $links = Array(Array());
        $lista = $this->conteudo_dao->get_Objs(" and status_conteudo = 'A' and ordem_menu > 0 and menu = 1", "ordem_menu ASC", 0, $todos);
        $i = 0;

        foreach ($lista as $objCon) {

            $links[$i]['id_conteudo'] = $objCon->get_id_conteudo();
            $links[$i]['nome_link'] = $objCon->get_nome_link();
            $i++;
        }
        return $links;
    }

}

// fim da classe
?>
