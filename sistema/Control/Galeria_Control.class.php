<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Galeria
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 20/05/2016 por Jean Barcellos
 *
 * @package Control
 *
 */
class Galeria_Control extends Control {

    private $galeria_dao;
    private $foto_dao;
    private $cgaleria_dao;

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
     *       $this->mailing_dao = $config->get_DAO("Galeria");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->galeria_dao = $this->config->get_DAO("Galeria");
        $this->foto_dao = $this->config->get_DAO("FotoGaleria");
        $this->cgaleria_dao = $this->config->get_DAO("CategoriaGaleria");
    }

    /**
     * Mostra a lista de Galerias
     *
     * @return void
     */
    public function Galeria_Gerencia() {

        $mostrar = 0;
        $pesquisa = $this->post_request['pesquisa'];
        $categorias = $this->post_request['selecao02'];
        $mostrar = $this->post_request['selecao01'];

        if ($categorias > 0) {
            $condicao = " AND id_categoria_galeria = " . $categorias . "";
        }

        if (is_null($mostrar)) {
            $mostrar = 0;
        }

        switch ($mostrar) {
            case '0':
                $ord = " and status_galeria = \"A\"";
                break;
            case '1':
                $ord = " and status_galeria = \"I\"";
                break;
            case '2':
                $ord = " and destaque = 1";
                break;
        }
        $condicao .= $ord;


        if ($pesquisa != "") {
            $condicao .= $ord . " and titulo LIKE '%$pesquisa%' ";
        }

        $total_reg = $this->galeria_dao->get_Total("$condicao");

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        $pag_views = 15; // número de registros por página
        // CALCULA OS PARAMETROS DE PAGINACAO
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        $ordem = "data_cadastro_galeria DESC";

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->galeria_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->galeria_dao->get_Descricoes();

        //CARREGA A VIEW E MOSTRA
        $vw = new Galeria_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama a View de inclusão de uma galeria
     *
     * @return void
     */
    public function Galeria_Add_V() {

        $descricoes = $this->galeria_dao->get_Descricoes();
        $vw = new Galeria_Add_View($this->post_request, null, $descricoes);
        $vw->showView();
    }

    /**
     * Executa a inclusão de uma galeria
     *
     * @return void
     */
    public function Galeria_Add() {

        $objeto = new Galeria();

        $objeto->set_id_categoria_galeria($this->post_request['id_categoria_galeria']);
        $objeto->set_titulo($this->post_request['titulo']);
        $objeto->set_texto($this->post_request['texto']);
        $objeto->set_chamada($this->post_request['chamada']);
        $objeto->set_tags($this->post_request['tags']);
        $objeto->set_data_galeria($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data_galeria'], "BD"));
        $objeto->set_data_cadastro_galeria($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_galeria('A');
                
        if ($this->post_request['destaque'] == null) {
            $objeto->set_destaque(0);
        } else {
            $objeto->set_destaque($this->post_request['destaque']);
        }
        
        $this->galeria_dao->Save($objeto);
        
        $this->traducao->loadTraducao("3041", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->Galeria_Add_V();
    }

    /**
     * Chama a View de alteração das informação de uma galeria
     *
     * @return void
     */
    public function Galeria_Altera_V() {

        $objeto = $this->galeria_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->galeria_dao->get_Descricoes();

        $vw = new Galeria_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa a alteração dos dados de uma galeria
     *
     * @return void
     */
    public function Galeria_Altera() {

        $objeto = $this->galeria_dao->loadObjeto($this->post_request['id']);
        
        $objeto->set_id_categoria_galeria($this->post_request['id_categoria_galeria']);
        $objeto->set_titulo($this->post_request['titulo']);
        $objeto->set_chamada($this->post_request['chamada']);
        $objeto->set_texto($this->post_request['texto']);
        $objeto->set_data_galeria($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data_galeria'], "BD"));

        $this->galeria_dao->Save($objeto);

        $this->traducao->loadTraducao("3047", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Galeria_Gerencia();
    }

    /**
     * Ativa uma galeria desativada
     * 
     * @return void
     */
    public function Galeria_Ativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->galeria_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_galeria("A");
        $this->galeria_dao->Save($objeto);

        // GRAVA LOG
        //$this->log->gravaLog(10,$this->post_request['id_sessao'],$this->post_request['id']);
        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("3042", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Galeria_Gerencia();
    }

    /**
     * Desativa uma galeria ativada
     * 
     * @return void
     */
    public function Galeria_Desativa() {

        $this->traducao->loadTraducao("3042", $this->post_request['idioma']);
        $objeto = $this->galeria_dao->loadObjeto($this->post_request['id']);

        if ($objeto->get_destaque() == 1) {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg45());
        } else {
            $objeto->set_status_galeria("I");
            $this->galeria_dao->Save($objeto);
            $this->traducao->loadTraducao("3042", $this->post_request['idioma']);
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        }
        $this->Galeria_Gerencia();
    }

    /**
     * Destacar galeria na capa do site
     * 
     * @return void
     */
    public function Galeria_Destacar() {
        $this->traducao->loadTraducao("3042", $this->post_request['idioma']);
        $destacadas = $this->galeria_dao->get_Total("and status_galeria = \"A\" and destaque = 1");
        if ($destacadas == $this->config->get_galerias_destaques()) {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg40());
        } else {
            $objeto = $this->galeria_dao->loadObjeto($this->post_request['id']);
            $objeto->set_destaque(1);
            $this->galeria_dao->Save($objeto);
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        }
        $this->Galeria_Gerencia();
    }

    /**
     * Reverte o destque feito em uma galeria na capa do site
     * 
     * @return void
     */
    public function Galeria_Reverter_Destaque() {
        $this->traducao->loadTraducao("3042", $this->post_request['idioma']);
        $objeto = $this->galeria_dao->loadObjeto($this->post_request['id']);
        $objeto->set_destaque(0);
        $this->galeria_dao->Save($objeto);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());
        $this->Galeria_Gerencia();
    }

    
    
    
    /**
     * Mostra a lista de fotos de uma galeria
     *
     * @return void
     */
    public function Foto_Gerencia() {
        /*         * ************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $galeria = $this->post_request['id'];
//        echo $galeria;
        $condicao = " and status_foto = \"A\" and id_galeria = " . $galeria . "";
        $total_reg = $this->foto_dao->get_Total("$condicao");

        /*
         * ****************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************FIM
         */

        // INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE
        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        /*
         * ******************************************************************************************
         * CONFIGURE O NUMERO DE REGISTROS POR PAGINA
         * ***************INICIO
         */
        $pag_views = 100; // nï¿½mero de registros por pï¿½gina
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
        $ordem = "ordem";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */



        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->foto_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        
        $descricoes = $this->foto_dao->get_Descricoes();

        //CARREGA A VIEW E MOSTRA
        $vw = new Foto_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Salva as alterações realizadas nos dados das imagens
     * 
     * @return void
     */
    public function Foto_Salva_Alteracoes() {
        //print_r($this->post_request);
        foreach ($this->post_request['leg'] as $id => $leg) {
            $obj = $this->foto_dao->loadObjeto($id);
            $obj->set_leg($leg);

            if (isset($this->post_request['apagar'][$id])) {
                $obj->set_ordem(0);
                $obj->set_status_foto('D');
            }

            $this->foto_dao->Save($obj);

            if ($this->post_request['capa'] == $id) {
                $this->foto_dao->set_capa($id);
            }

            if (($obj->get_status_foto() == 'D') && $obj->get_destaque()) {
                $this->foto_dao->corrige_ordem_faltante($obj->get_id_galeria());
                if ($obj->get_destaque()) {
                    $this->foto_dao->set_capa_excluido($id);
                }
            }

            $this->foto_dao->corrige_ordem_faltante($obj->get_id_galeria());
        }
        $this->Foto_Gerencia();
    }

    
    /**
     * Chama a view de inserção de fotos na galeria
     * 
     * @return void
     */
    public function Foto_Add_V() {        
        $descricoes = $this->foto_dao->get_Descricoes();
        $vw = new Foto_Add_View($this->post_request, null, $descricoes);
        $vw->showView();
    }

    /**
     * Chama a View de ordenação das fotos
     * 
     * @return void
     */
    public function Foto_Ordena_V() {
        $galeria = $this->post_request['id'];
        $condicao = " and status_foto = \"A\" and id_galeria = " . $galeria . "";
        $total_reg = $this->foto_dao->get_Total("$condicao");

        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        $pag_views = 100; // nï¿½mero de registros por pï¿½gina

        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = 0; //$mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        $ordem = "ordem";

        $objetos = $this->foto_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->foto_dao->get_Descricoes();

        $vw = new Foto_Ordena_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }
   
    /**
     * Salva a ordenação realizadas nas fotos
     * 
     * @return void
     */
    public function Foto_Ordena() {
        $id = $this->post_request['id'];
        $ordem = $this->post_request['campooculto'];
        $ordem2 = str_replace('li_', '', $ordem);
        $chars = preg_split('/,/', $ordem2, -1, PREG_SPLIT_NO_EMPTY);
        $update = $this->foto_dao->ordene_foto($chars, $id);
        $this->Foto_Gerencia();
    }

    /**
     * @ignore
     */
    public function Foto_Acima() {
        $id_foto = $this->post_request['id'];
        $this->foto_dao->move_Obj($id_foto, 'acima');
        //Regenerar o id da galeria
        $objFoto = $this->foto_dao->loadObjeto($id_foto);
        $this->post_request['id'] = $objFoto->get_id_galeria();
        $this->Foto_Gerencia();
    }
    
    /**
     * @ignore
     */
    public function Foto_Abaixo() {
        $id_foto = $this->post_request['id'];
        $this->foto_dao->move_Obj($id_foto, 'abaixo');
        //Regenerar o id da galeria
        $objFoto = $this->foto_dao->loadObjeto($id_foto);
        $this->post_request['id'] = $objFoto->get_id_galeria();
        $this->Foto_Gerencia();
    }

//-------------------------------- Site ----------------------------------------

    /**
     * Retorna o total de galerias ativas
     * 
     * @param type $id_categoria ID da Categoria (opicional)
     * @return type
     */
    public function Numero_Registros($id_categoria = 0) {
        if ($id_categoria > 0) {
            $cond = "AND id_categoria_galeria = $id_categoria";
        }
        return $this->galeria_dao->get_Total("$cond AND status_galeria = 'A'");
    }

    /**
     * Retorna lista de Galeria gerais
     * 
     * @param int $qtde Quantidade de Galeria por página
     * @param int $inicio Posição de inicio da listagem
     * @param String $ordem Parâmetro de Ordenadção
     * @param int $id_categoria ID da Categoria (Opcional)
     * @param int $retira ID do Post a ser retirado da listada (Opcional)
     * @return Array Array com a listagem de Galeria
     */
    public function Lista_Galerias($qtde, $inicio, $ordem, $id_categoria = 0, $retira = 0) {

        $condicao = "";

        if ($id_categoria > 0) {
            $condicao .= " AND id_categoria_galeria = $id_categoria";
        }
        if ($retira != 0) {
            $condicao .= " AND id_galeria <> $retira";
        }

        $objetos = $this->galeria_dao->get_Objs(" AND status_galeria = 'A' $condicao", $ordem, $inicio, $qtde);

        $dados = array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }

        return $dados;
    }

    /**
     * Exibe a galeria selecionada
     * 
     * @param int $id_galeria ID da Galeria
     * @param int $id_categoria ID da Categoria (opicional)
     * @return Array Vetor com os dados da galeria selecionado
     */
    public function Exibe_Galerias($id_galeria, $id_categoria) {
        
        if (($id_galeria != 0) && ($id_categoria != 0)) {
            $objetos = $this->galeria_dao->get_Objs(" AND status_galeria = 'A' AND id_galeria = '$id_galeria' AND id_categoria_galeria = $id_categoria", "data_galeria DESC", 0, 1);
        } else if (($id_galeria <> 0)) {
            $objetos = $this->galeria_dao->get_Objs(" AND status_galeria = 'A' AND id_galeria = '$id_galeria'", "data_galeria DESC", 0, 1);
        }

        if (count($objetos) > 0) {
            $dados = $objetos[0]->get_all_dados();
        } else {
            $dados = null;
        }

        return $dados;
    }
    
        
    /**
     * Descrições das galerias listadas
     * 
     * @param int $pag_views Quantidade de galerias por página
     * @param int $inicio Posição de inicio da listagem
     * @param String $ordem Parâmetro de Ordenadção
     * @param int $id_categoria ID da Categoria (Opcional)
     * @param int $retira ID da Galeria a ser retirada da listada (Opcional)
     * @return Array Array com a listagem de galerias
     */
    public function get_Descricoes($pag_views = 0, $inicio = 0, $ordem = null, $id_categoria = 0, $retira = 0) {
        return $this->galeria_dao->get_Descricoes($pag_views, $inicio, $ordem, $id_categoria, $retira);
    }

    /**
     * Retorna todas as fotos de uma galeria
     * 
     * @param int $id_galeria ID da galeria
     * @param int $qtd Quantidade de fotos por página
     * @param int $inicio Posição de inicio da listagem
     * @return Array Vetor com as fotos da galeria
     */
    public function Lista_Fotos($id_galeria, $qtd = 0, $inicio = 0) {

        $order = " ordem, id_foto";
        $condicao = " AND id_galeria = $id_galeria";

        $objetos = $this->foto_dao->get_Objs(" and status_foto = 'A' $condicao", $order, $inicio, $qtd);
        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }    
    
    /**
     * Pega a foto destaque de uma galeria
     * 
     * @param int $id_galeria ID da galeria
     * @return Array Array com os dados da foto destaque
     */
    public function Pega_Foto_Destaque($id_galeria) {

        $objetos = $this->foto_dao->get_Objs(" and id_galeria = $id_galeria and destaque = 1 and status_foto = \"A\"", "ordem ASC", 0, 1);

        $dados = array();
        if (count($objetos) > 0) {
            $dados = $objetos[0]->get_all_dados();
        } else {
            $dados = null;
        }
        return $dados;
    }    
    
    /**
     * Retorna o número total de fotos de uma galeria
     * 
     * @param int $id_galeria ID do post
     * @return int Número total de fotos
     */
    public function Numero_Registros_Fotos($id_galeria = 0) {
        if ($id_galeria == 0) {
            $id_galeria = (int) $this->post_request['id_galeria'];
        }
        return $this->foto_dao->get_Total(" AND id_galeria = $id_galeria AND status_foto = 'A'");
    }
    
 
}
