<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade RelacaoNoticia, filho de Control
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2016-2019, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 11/07/2016
 * @package Control
 *
 */
class RelacaoNoticia_Control extends Control {

    private $relacao_noticia_dao;

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
     *       $this->relacao_noticia_dao = $config->get_DAO("RelacaoNoticia");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->relacao_noticia_dao = $this->config->get_DAO("RelacaoNoticia");
    }

    /**
     * Inclui um Post Relacionado
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function RelacaoNoticia_Add($id_noticia, $id_noticia_relacionado) {

        if (!$this->relacao_noticia_dao->Verifica_Relacao($id_noticia, $id_noticia_relacionado)) {
            $objeto = new RelacaoNoticia();

            $objeto->set_id_noticia($id_noticia);
            $objeto->set_id_noticia_relacionado($id_noticia_relacionado);
            $objeto->set_status_relacao("A");

            $this->relacao_noticia_dao->Save($objeto);
        }
    }

    /**
     * Apaga um Post Relacionado
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function RelacaoNoticia_Apaga() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->relacao_noticia_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_relacao("D");

        $this->relacao_noticia_dao->Save($objeto);
    }

    /**
     * Retorna os objetos referente ao ID do Post
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Pega_Objets($id_noticia, $qtde = 1000) {

        $condicao = " AND status_relacao = \"A\" AND id_noticia = $id_noticia";

        $ordem = "id_relacao ASC";

        $objetos = $this->relacao_noticia_dao->get_Objs($condicao, $ordem, 0, $qtde);

        return $objetos;
    }

    /*
     * *************************************************************************
     * Funcionalidades para o Site
     * *************************************************************************
     */
}

?>
