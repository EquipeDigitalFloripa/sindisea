<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Traducao, filho de Control
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package Control
 *
 */
class Traducao_control extends Control {

    private $traducao_dao;

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
     *       $this->usuario_dao = $config->get_DAO("Traducao");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->traducao_dao = $this->config->get_DAO("Traducao");
    }

    /**
     *
     * Mostra a lista de Traducoes
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Traducao_Gerencia() {
        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $condicao = isset($this->post_request['pesquisa']) ? " nome_arquivo LIKE '%" . $this->post_request['pesquisa'] . "%' or id_arquivo LIKE '%" . $this->post_request['pesquisa'] . "%'" : "";
        $total_reg = $this->traducao_dao->get_Total("$condicao");

        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************FIM
         */

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if (!isset($this->post_request['pagina'])) {
            $this->post_request['pagina'] = 1;
        }

        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************INICIO
         */
        $pag_views = 100; // número de registros por página
        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************FIM
         */

        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************INICIO
         */
        $ordem = "id_arquivo desc";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->traducao_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->traducao_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Traducao_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     *
     * Chama a View de Alteração de dados de Traducao
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Traducao_Altera_VPT() {

        // PEGA OBJETO
        $objeto1 = new Traducao();
        $objeto1->loadTraducao($this->post_request['id'], "PT");
        $objeto2 = new Traducao();
        $objeto2->loadTraducao($this->post_request['id'], "EN");
        $objetos[0] = $objeto1;
        $objetos[1] = $objeto2;

        //CARREGA A VIEW E MOSTRA
        $vw = new Traducao_Altera_View_PT($this->post_request, $objetos);
        $vw->showView();
    }

    /**
     *
     * Altera dados de Traducao PT
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Traducao_Altera_PT() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Traducao();
        $objeto->loadTraducao($this->post_request['id'], 'PT');
        $objeto->set_id_arquivo($this->post_request['id']);
        $objeto->set_lingua('PT');

        $objeto->set_titulo_formulario01($this->post_request['titulo_formulario01']);
        $objeto->set_titulo_formulario02($this->post_request['titulo_formulario02']);
        $objeto->set_titulo_formulario03($this->post_request['titulo_formulario03']);
        $objeto->set_titulo_formulario04($this->post_request['titulo_formulario04']);
        $objeto->set_titulo_formulario05($this->post_request['titulo_formulario05']);
        $objeto->set_titulo_formulario06($this->post_request['titulo_formulario06']);
        $objeto->set_titulo_formulario07($this->post_request['titulo_formulario07']);
        $objeto->set_titulo_formulario08($this->post_request['titulo_formulario08']);
        $objeto->set_titulo_formulario09($this->post_request['titulo_formulario09']);
        $objeto->set_titulo_formulario10($this->post_request['titulo_formulario10']);
        $objeto->set_leg01($this->post_request['leg01']);
        $objeto->set_leg02($this->post_request['leg02']);
        $objeto->set_leg03($this->post_request['leg03']);
        $objeto->set_leg04($this->post_request['leg04']);
        $objeto->set_leg05($this->post_request['leg05']);
        $objeto->set_leg06($this->post_request['leg06']);
        $objeto->set_leg07($this->post_request['leg07']);
        $objeto->set_leg08($this->post_request['leg08']);
        $objeto->set_leg09($this->post_request['leg09']);
        $objeto->set_leg10($this->post_request['leg10']);
        $objeto->set_leg11($this->post_request['leg11']);
        $objeto->set_leg12($this->post_request['leg12']);
        $objeto->set_leg13($this->post_request['leg13']);
        $objeto->set_leg14($this->post_request['leg14']);
        $objeto->set_leg15($this->post_request['leg15']);
        $objeto->set_leg16($this->post_request['leg16']);
        $objeto->set_leg17($this->post_request['leg17']);
        $objeto->set_leg18($this->post_request['leg18']);
        $objeto->set_leg19($this->post_request['leg19']);
        $objeto->set_leg20($this->post_request['leg20']);
        $objeto->set_leg21($this->post_request['leg21']);
        $objeto->set_leg22($this->post_request['leg22']);
        $objeto->set_leg23($this->post_request['leg23']);
        $objeto->set_leg24($this->post_request['leg24']);
        $objeto->set_leg25($this->post_request['leg25']);
        $objeto->set_leg26($this->post_request['leg26']);
        $objeto->set_leg27($this->post_request['leg27']);
        $objeto->set_leg28($this->post_request['leg28']);
        $objeto->set_leg29($this->post_request['leg29']);
        $objeto->set_leg30($this->post_request['leg30']);
        $objeto->set_leg31($this->post_request['leg31']);
        $objeto->set_leg32($this->post_request['leg32']);
        $objeto->set_leg33($this->post_request['leg33']);
        $objeto->set_leg34($this->post_request['leg34']);
        $objeto->set_leg35($this->post_request['leg35']);
        $objeto->set_leg36($this->post_request['leg36']);
        $objeto->set_leg37($this->post_request['leg37']);
        $objeto->set_leg38($this->post_request['leg38']);
        $objeto->set_leg39($this->post_request['leg39']);
        $objeto->set_leg40($this->post_request['leg40']);
        $objeto->set_leg41($this->post_request['leg41']);
        $objeto->set_leg42($this->post_request['leg42']);
        $objeto->set_leg43($this->post_request['leg43']);
        $objeto->set_leg44($this->post_request['leg44']);
        $objeto->set_leg45($this->post_request['leg45']);
        $objeto->set_leg46($this->post_request['leg46']);
        $objeto->set_leg47($this->post_request['leg47']);
        $objeto->set_leg48($this->post_request['leg48']);
        $objeto->set_leg49($this->post_request['leg49']);
        $objeto->set_leg50($this->post_request['leg50']);

        $this->traducao_dao->Save2($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2029", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Traducao_Altera_VPT();
    }

    /**
     *
     * Altera dados de Traducao EN
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Traducao_Altera_EN() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Traducao();
        $objeto->loadTraducao($this->post_request['id'], 'EN');
        $objeto->set_id_arquivo($this->post_request['id']);
        $objeto->set_lingua('EN');

        $objeto->set_titulo_formulario01($this->post_request['titulo_formulario01']);
        $objeto->set_titulo_formulario02($this->post_request['titulo_formulario02']);
        $objeto->set_titulo_formulario03($this->post_request['titulo_formulario03']);
        $objeto->set_titulo_formulario04($this->post_request['titulo_formulario04']);
        $objeto->set_titulo_formulario05($this->post_request['titulo_formulario05']);
        $objeto->set_titulo_formulario06($this->post_request['titulo_formulario06']);
        $objeto->set_titulo_formulario07($this->post_request['titulo_formulario07']);
        $objeto->set_titulo_formulario08($this->post_request['titulo_formulario08']);
        $objeto->set_titulo_formulario09($this->post_request['titulo_formulario09']);
        $objeto->set_titulo_formulario10($this->post_request['titulo_formulario10']);
        $objeto->set_leg01($this->post_request['leg01']);
        $objeto->set_leg02($this->post_request['leg02']);
        $objeto->set_leg03($this->post_request['leg03']);
        $objeto->set_leg04($this->post_request['leg04']);
        $objeto->set_leg05($this->post_request['leg05']);
        $objeto->set_leg06($this->post_request['leg06']);
        $objeto->set_leg07($this->post_request['leg07']);
        $objeto->set_leg08($this->post_request['leg08']);
        $objeto->set_leg09($this->post_request['leg09']);
        $objeto->set_leg10($this->post_request['leg10']);
        $objeto->set_leg11($this->post_request['leg11']);
        $objeto->set_leg12($this->post_request['leg12']);
        $objeto->set_leg13($this->post_request['leg13']);
        $objeto->set_leg14($this->post_request['leg14']);
        $objeto->set_leg15($this->post_request['leg15']);
        $objeto->set_leg16($this->post_request['leg16']);
        $objeto->set_leg17($this->post_request['leg17']);
        $objeto->set_leg18($this->post_request['leg18']);
        $objeto->set_leg19($this->post_request['leg19']);
        $objeto->set_leg20($this->post_request['leg20']);
        $objeto->set_leg21($this->post_request['leg21']);
        $objeto->set_leg22($this->post_request['leg22']);
        $objeto->set_leg23($this->post_request['leg23']);
        $objeto->set_leg24($this->post_request['leg24']);
        $objeto->set_leg25($this->post_request['leg25']);
        $objeto->set_leg26($this->post_request['leg26']);
        $objeto->set_leg27($this->post_request['leg27']);
        $objeto->set_leg28($this->post_request['leg28']);
        $objeto->set_leg29($this->post_request['leg29']);
        $objeto->set_leg30($this->post_request['leg30']);
        $objeto->set_leg31($this->post_request['leg31']);
        $objeto->set_leg32($this->post_request['leg32']);
        $objeto->set_leg33($this->post_request['leg33']);
        $objeto->set_leg34($this->post_request['leg34']);
        $objeto->set_leg35($this->post_request['leg35']);
        $objeto->set_leg36($this->post_request['leg36']);
        $objeto->set_leg37($this->post_request['leg37']);
        $objeto->set_leg38($this->post_request['leg38']);
        $objeto->set_leg39($this->post_request['leg39']);
        $objeto->set_leg40($this->post_request['leg40']);
        $objeto->set_leg41($this->post_request['leg41']);
        $objeto->set_leg42($this->post_request['leg42']);
        $objeto->set_leg43($this->post_request['leg43']);
        $objeto->set_leg44($this->post_request['leg44']);
        $objeto->set_leg45($this->post_request['leg45']);
        $objeto->set_leg46($this->post_request['leg46']);
        $objeto->set_leg47($this->post_request['leg47']);
        $objeto->set_leg48($this->post_request['leg48']);
        $objeto->set_leg49($this->post_request['leg49']);
        $objeto->set_leg50($this->post_request['leg50']);

        $teste = $this->traducao_dao->Save2($objeto);
        echo $teste;

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2013", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Traducao_Altera_VEN();
    }

    /**
     *
     * Chama a View de Alteração de dados de Traducao
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Traducao_Altera_VEN() {

        // PEGA OBJETO
        $objeto1 = new Traducao();
        $objeto1->loadTraducao($this->post_request['id'], "PT");
        $objeto2 = new Traducao();
        $objeto2->loadTraducao($this->post_request['id'], "EN");
        $objetos[0] = $objeto1;
        $objetos[1] = $objeto2;

        //CARREGA A VIEW E MOSTRA
        $vw = new Traducao_Altera_View_EN($this->post_request, $objetos);
        $vw->showView();
    }

    /**
     *
     * Chama a View de Inclusão de Traducoes
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Traducao_Add_V() {

        // Pega as descrições
        $descricoes = $this->traducao_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Traducao_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     *
     * Inclui nova Traducao
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Traducao_Add() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Traducao();
        $objeto->set_id_arquivo($this->post_request['id_arquivo']);
        $objeto->set_nome_arquivo($this->post_request['nome_arquivo']);
        $objeto->set_id_modelo($this->post_request['id_modelo']);


        $this->traducao_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA
        $this->traducao->loadTraducao("2027", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Traducao_Add_V();
    }

    public function Traducao_Altera_ES() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Traducao();
        $objeto->loadTraducao($this->post_request['id'], 'ES');
        $objeto->set_id_arquivo($this->post_request['id']);
        $objeto->set_lingua('ES');

        $objeto->set_titulo_formulario01($this->post_request['titulo_formulario01']);
        $objeto->set_titulo_formulario02($this->post_request['titulo_formulario02']);
        $objeto->set_titulo_formulario03($this->post_request['titulo_formulario03']);
        $objeto->set_titulo_formulario04($this->post_request['titulo_formulario04']);
        $objeto->set_titulo_formulario05($this->post_request['titulo_formulario05']);
        $objeto->set_titulo_formulario06($this->post_request['titulo_formulario06']);
        $objeto->set_titulo_formulario07($this->post_request['titulo_formulario07']);
        $objeto->set_titulo_formulario08($this->post_request['titulo_formulario08']);
        $objeto->set_titulo_formulario09($this->post_request['titulo_formulario09']);
        $objeto->set_titulo_formulario10($this->post_request['titulo_formulario10']);
        $objeto->set_leg01($this->post_request['leg01']);
        $objeto->set_leg02($this->post_request['leg02']);
        $objeto->set_leg03($this->post_request['leg03']);
        $objeto->set_leg04($this->post_request['leg04']);
        $objeto->set_leg05($this->post_request['leg05']);
        $objeto->set_leg06($this->post_request['leg06']);
        $objeto->set_leg07($this->post_request['leg07']);
        $objeto->set_leg08($this->post_request['leg08']);
        $objeto->set_leg09($this->post_request['leg09']);
        $objeto->set_leg10($this->post_request['leg10']);
        $objeto->set_leg11($this->post_request['leg11']);
        $objeto->set_leg12($this->post_request['leg12']);
        $objeto->set_leg13($this->post_request['leg13']);
        $objeto->set_leg14($this->post_request['leg14']);
        $objeto->set_leg15($this->post_request['leg15']);
        $objeto->set_leg16($this->post_request['leg16']);
        $objeto->set_leg17($this->post_request['leg17']);
        $objeto->set_leg18($this->post_request['leg18']);
        $objeto->set_leg19($this->post_request['leg19']);
        $objeto->set_leg20($this->post_request['leg20']);
        $objeto->set_leg21($this->post_request['leg21']);
        $objeto->set_leg22($this->post_request['leg22']);
        $objeto->set_leg23($this->post_request['leg23']);
        $objeto->set_leg24($this->post_request['leg24']);
        $objeto->set_leg25($this->post_request['leg25']);
        $objeto->set_leg26($this->post_request['leg26']);
        $objeto->set_leg27($this->post_request['leg27']);
        $objeto->set_leg28($this->post_request['leg28']);
        $objeto->set_leg29($this->post_request['leg29']);
        $objeto->set_leg30($this->post_request['leg30']);
        $objeto->set_leg31($this->post_request['leg31']);
        $objeto->set_leg32($this->post_request['leg32']);
        $objeto->set_leg33($this->post_request['leg33']);
        $objeto->set_leg34($this->post_request['leg34']);
        $objeto->set_leg35($this->post_request['leg35']);
        $objeto->set_leg36($this->post_request['leg36']);
        $objeto->set_leg37($this->post_request['leg37']);
        $objeto->set_leg38($this->post_request['leg38']);
        $objeto->set_leg39($this->post_request['leg39']);
        $objeto->set_leg40($this->post_request['leg40']);
        $objeto->set_leg41($this->post_request['leg41']);
        $objeto->set_leg42($this->post_request['leg42']);
        $objeto->set_leg43($this->post_request['leg43']);
        $objeto->set_leg44($this->post_request['leg44']);
        $objeto->set_leg45($this->post_request['leg45']);
        $objeto->set_leg46($this->post_request['leg46']);
        $objeto->set_leg47($this->post_request['leg47']);
        $objeto->set_leg48($this->post_request['leg48']);
        $objeto->set_leg49($this->post_request['leg49']);
        $objeto->set_leg50($this->post_request['leg50']);

        $teste = $this->traducao_dao->Save2($objeto);
        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2014", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Traducao_Altera_VES();
    }

    /**
     *
     * Chama a View de Alteração de dados de Traducao
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Traducao_Altera_VES() {

        // PEGA OBJETO
        $objeto1 = new Traducao();
        $objeto1->loadTraducao($this->post_request['id'], "PT");
        $objeto2 = new Traducao();
        $objeto2->loadTraducao($this->post_request['id'], "ES");
        $objetos[0] = $objeto1;
        $objetos[1] = $objeto2;

        //CARREGA A VIEW E MOSTRA
        $vw = new Traducao_Altera_View_ES($this->post_request, $objetos);
        $vw->showView();
    }

}

// fim da classe
?>
