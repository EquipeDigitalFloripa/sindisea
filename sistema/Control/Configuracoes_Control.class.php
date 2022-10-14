<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

class Configuracoes_Control extends Control {

    private $configuracoes_dao;
    private $conteudo_dao;

    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->configuracoes_dao = $this->config->get_DAO("Configuracoes");
        $this->conteudo_dao = $this->config->get_DAO("Conteudo");
    }

    public function Configuracoes_Gerencia() {        
        $objetos = $this->configuracoes_dao->loadObjeto(1);        
        $descricoes = $this->configuracoes_dao->get_Descricao();
        
        $vw = new Configuracoes_Gerencia_View($this->post_request, $objetos, $descricoes);
        $vw->showView();
    }

    public function Configuracoes_Analytics_V() {
        $objeto = $this->configuracoes_dao->loadObjeto(1);
        $descricoes = $this->configuracoes_dao->get_Descricao();

        $vw = new Configuracoes_Analytics_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Configuracoes_Analytics() {
        $objeto = $this->configuracoes_dao->loadObjeto(1);

        if ($objeto->get_id_config() == NULL) {
            $objeto = new Configuracoes();
            $objeto->set_id_config(1);
        }
        $objeto->set_analytics($this->post_request['analytics']);

        $id_config_new = $this->configuracoes_dao->Save($objeto);
        $this->Configuracoes_Gerencia();
    }

    public function Configuracoes_Metatags_V() {        
        $objeto = $this->configuracoes_dao->loadObjeto(1);
        $descricoes = $this->configuracoes_dao->get_Descricao();

        $vw = new Configuracoes_Metatags_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Configuracoes_Metatags() {
        $objeto = $this->configuracoes_dao->loadObjeto(1);

        if ($objeto->get_id_config() == NULL) {
            $objeto = new Configuracoes($this->post_request);
            $objeto->set_id_config(1);
        }

        $objeto->set_title($this->post_request['title']);
        $objeto->set_content_type($this->post_request['content_type']);
        $objeto->set_pragma($this->post_request['pragma']);
        $objeto->set_cache_control($this->post_request['cache_control']);
        $objeto->set_author($this->post_request['author']);
        $objeto->set_content_language($this->post_request['content_language']);
        $objeto->set_reply_to($this->post_request['reply_to']);
        $objeto->set_url($this->post_request['url']);
        $objeto->set_copyright($this->post_request['copyright']);
        $objeto->set_owner($this->post_request['owner']);
        $objeto->set_rating($this->post_request['rating']);
        $objeto->set_robots($this->post_request['robots']);
        $objeto->set_googlebot($this->post_request['googlebot']);
        $objeto->set_classification($this->post_request['classification']);
        $objeto->set_revisit_after($this->post_request['revisit_after']);
        $objeto->set_geo_placename($this->post_request['geo_placename']);
        $objeto->set_geo_country($this->post_request['geo_country']);
        $objeto->set_dc_language($this->post_request['dc_language']);
        $objeto->set_description($this->post_request['description']);
        $objeto->set_keywords($this->post_request['keywords']);
        $objeto->set_status_config("A");

        $id_config_new = $this->configuracoes_dao->Save($objeto);
        $this->Configuracoes_Gerencia();
    }

    public function Configuracoes_Favicon_V() {
        $objeto = $this->configuracoes_dao->loadObjeto(1);
        $descricoes = $this->configuracoes_dao->get_Descricao();

        $vw = new Configuracoes_Favicon_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    public function Configuracoes_Favicon() {
        $this->traducao->loadTraducao("2003", $this->post_request['idioma']);

        $diretorio = "./../../";
        $ext = trim(strtolower(substr($this->post_request['favicon']['name'], -3)));
        if (($ext <> 'ico') && ($ext != NULL)) {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
            $this->Configuracoes_Favicon_V();
        } else {
            if (($ext != NULL) && (file_exists($diretorio . ".favicon" . $ext))) {
                unlink($diretorio . "favicon." . $ext);
            }
            if ($ext != NULL) {
                $nome_atual = "favicon" . "." . $ext;
                if (!copy($this->post_request['favicon']['tmp_name'], $diretorio . $nome_atual)) {
                    $this->post_request['msg_tp'] = "erro";
                    $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
                }
            }
            $this->Configuracoes_Gerencia();
        }
    }

    public function Pega_Metatags() {
        $config = $this->configuracoes_dao->loadObjeto(1);
        $dados = $config->get_all_dados();
        return $dados;
    }

    public function Pega_Analytics() {
        $config = $this->configuracoes_dao->loadObjeto(1);
        $dados = $config->get_all_dados();
        return $dados['analytics'];
    }

}

?>