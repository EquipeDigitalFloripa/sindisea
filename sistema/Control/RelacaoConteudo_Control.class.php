<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade RelacaoConteudo, filho de Control
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
class RelacaoConteudo_Control extends Control {

    private $relacao_conteudo_dao;

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
     *       $this->relacao_conteudo_dao = $config->get_DAO("RelacaoConteudo");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->relacao_conteudo_dao = $this->config->get_DAO("RelacaoConteudo");
    }

    /**
     * Inclui um Post Relacionado
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function RelacaoConteudo_Add($id_noticia, $id_conteudo) {

        if ($this->relacao_conteudo_dao->Existe_Relacao($id_noticia, $id_conteudo) == FALSE) {
            $objeto = new RelacaoConteudo();

            $objeto->set_id_noticia($id_noticia);
            $objeto->set_id_conteudo($id_conteudo);
            $objeto->set_status_rel_conteudo("A");

            $this->relacao_conteudo_dao->Save($objeto);
        }
    }

    /**
     * Apaga um Post Relacionado
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function RelacaoConteudo_Apaga() {

        /* CARREGA DAO, SETA STATUS e SALVA */
        $objeto = $this->relacao_conteudo_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_rel_conteudo("D");

        $this->relacao_conteudo_dao->Save($objeto);
    }

    /**
     * Retorna os objetos referente ao ID do Post
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Pega_Objets($id_noticia, $qtde = 1000) {
        $condicao = " AND status_rel_conteudo = \"A\" AND id_noticia = $id_noticia";

        $ordem = "id_rel_conteudo ASC";

        $objetos = $this->relacao_conteudo_dao->get_Objs($condicao, $ordem, 0, $qtde);
        return $objetos;
    }

    public function Lista_Paginas() {
        return $this->relacao_conteudo_dao->list_Pages();
    }

    public function Pega_Pagina($id_conteudo) {
        return $this->relacao_conteudo_dao->ger_Page($id_conteudo);
    }

    /*
     * *************************************************************************
     * Funcionalidades para o Site
     * *************************************************************************
     */

    public function Lista_Relacao_Conteudo($condicao) {

        $objetos = $this->relacao_conteudo_dao->get_Objs("$condicao", " id_noticia DESC", 0, 4);

        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

}

?>
