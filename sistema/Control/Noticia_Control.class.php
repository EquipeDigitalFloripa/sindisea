<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Noticia, filho de Control
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2016-2019, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 11/07/2016
 * @package Control
 */
class Noticia_Control extends Control {

    private $noticia_dao;
    private $categoria_noticia_dao;
    private $foto_noticia_dao;
    private $ctr_relacao_conteudo;

    /**
     * Carrega o contrutor do pai.
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $id_noticia_request Parâmetros de _POST e _REQUEST
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *       parent::__construct();
     *       $config = new Config();
     *       $this->noticia_dao = $config->get_DAO("Post");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);

        $this->noticia_dao = $this->config->get_DAO("Noticia");
        $this->categoria_noticia_dao = $this->config->get_DAO("CategoriaNoticia");
        $this->foto_noticia_dao = $this->config->get_DAO("FotoNoticia");
        $this->ctr_relacao_conteudo = new RelacaoConteudo_Control($post_request);
    }

    /**
     * Mostra a lista de Noticia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Gerencia() {

        /* CONFIGURA FILTRO DE PESQUISA */
        $condicao = " AND (status_noticia = \"A\" OR status_noticia = \"I\")";
        $condicao .= (isset($this->post_request['pesquisa']) && $this->post_request['pesquisa'] != "") ? ' AND titulo_noticia LIKE "%' . $this->post_request['pesquisa'] . '%"' : '';
        $condicao .= (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] != 0) ? ' AND id_categoria_noticia  = ' . $this->post_request['selecao01'] . '' : '';

        /* CALCULA TOTAL DE REGISTRO */
        $total_reg = $this->noticia_dao->get_Total("$condicao");

        /* INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA - NAO MODIFIQUE */
        if (!isset($this->post_request['pagina'])) {
            $this->post_request['pagina'] = 1;
        }

        /* CONFIGURE O NUMERO DE REGISTROS POR PAGINA */
        $pag_views = 100; // número de registros por página

        /* CALCULA OS PARAMETROS DE PAGINACAO */
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /* CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS */
        $ordem = "data_cadastro_noticia DESC";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->noticia_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->noticia_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Noticia_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Chama View para inclusão de uma nova Noticia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Add_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $descricoes = $this->noticia_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Noticia_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Inclui uma nova Notícia
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Add() {

        /* CRIA OBJETO E SALVA DADOS */
        $objeto = new Noticia();

        $objeto->set_id_categoria_noticia($this->post_request['id_categoria_noticia']);
        $objeto->set_titulo_noticia($this->post_request['titulo_noticia']);
        $objeto->set_url_amigavel($this->post_request['url_amigavel']);
        $objeto->set_description_noticia($this->post_request['description_noticia']);
        $objeto->set_texto_noticia($this->post_request['texto_noticia']);
        $objeto->set_data_noticia($this->data->get_dataFormat("NOW", $this->post_request['data_noticia'], "BD"));
        $objeto->set_data_cadastro_noticia($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_data_atualizacao_noticia($this->data->get_dataFormat("NOW", $this->post_request['data_publicacao_noticia'], "BD"));
        $objeto->set_data_publicacao_noticia($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data_publicacao_noticia'], "BD"));
        $objeto->set_data_expiracao_noticia($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_destaque_slider(0);

        $objeto->set_contador_noticia(0);
        $objeto->set_status_noticia('A');

        $this->post_request['id_noticia_corrente'] = $this->noticia_dao->Save($objeto);

        /* SALVANDO A RELAÇAO ENTRE NOTICIA E CONTEUDO */
        if (isset($this->post_request['id_conteudo']) && $this->post_request['id_conteudo'] != NULL) {
            $i = 0;
            while ($i < count($this->post_request['id_conteudo'])) {
                $this->ctr_relacao_conteudo->RelacaoConteudo_Add($this->post_request['id_noticia_corrente'], $this->post_request['id_conteudo'][$i]);
                $i++;
            }
        }

        $this->post_request['ac'] = base64_encode('Noticia_Tag_V');
        $this->Noticia_Tag_V();
    }

    /**
     * Chama View para alteração de dados da Notícias
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Altera_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $objeto = $this->noticia_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->noticia_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Noticia_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Altera dados da Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Altera() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->noticia_dao->loadObjeto($this->post_request['id']);

        $objeto->set_id_categoria_noticia($this->post_request['id_categoria_noticia']);
        $objeto->set_titulo_noticia($this->post_request['titulo_noticia']);
        $objeto->set_url_amigavel($this->post_request['url_amigavel']);
        $objeto->set_description_noticia($this->post_request['description_noticia']);
        $objeto->set_texto_noticia($this->post_request['texto_noticia']);
        $objeto->set_data_noticia($this->data->get_dataFormat("CALENDARHORA", $this->post_request['data_noticia'], "BD"));
        $objeto->set_data_publicacao_noticia($this->data->get_dataFormat("CALENDARHORA", $this->post_request['data_publicacao_noticia'], "BD"));
        if (($this->post_request['data_expiracao_noticia'] != NULL) || ($this->post_request['data_expiracao_noticia'] != "")) {
            $objeto->set_data_expiracao_noticia($this->data->get_dataFormat("CALENDARHORA", $this->post_request['data_expiracao_noticia'], "BD"));
        }

        $objeto->set_data_atualizacao_noticia($this->data->get_dataFormat("NOW", "", "BD"));

        $this->noticia_dao->Save($objeto);

        /* SALVANDO A RELAÇAO ENTRE NOTICIA E CONTEUDO */
        if ($this->post_request['id_conteudo'] != NULL) {
            $i = 0;
            while ($i < count($this->post_request['id_conteudo'])) {
                $this->ctr_relacao_conteudo->RelacaoConteudo_Add($this->post_request['id'], $this->post_request['id_conteudo'][$i]);
                $i++;
            }
        }

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("3012", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->post_request['ac'] = base64_encode("Noticia_Gerencia");
        $this->Noticia_Gerencia($this->post_request['id']);
    }

    /**
     * Ativa uma Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Ativa() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->noticia_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_noticia("A");

        $this->noticia_dao->Save($objeto);

        /* CARREGA TRADUÇÃO */
        $this->traducao->loadTraducao("3010", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->post_request['ac'] = base64_encode("Noticia_Gerencia");
        $this->Noticia_Gerencia();
    }

    /**
     * Desativa uma Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Desativa() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->noticia_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_noticia("I");

        $this->noticia_dao->Save($objeto);

        /* CARREGA TRADUÇÃO */
        $this->traducao->loadTraducao("3010", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->post_request['ac'] = base64_encode("Noticia_Gerencia");
        $this->Noticia_Gerencia();
    }

    /**
     * Apaga uma Notícia
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Apaga() {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->noticia_dao->loadObjeto($this->post_request['id']);

        $objeto->set_status_noticia("D");

        $this->noticia_dao->Save($objeto);

        /* CARREGA TRADUÇÃO */
        $this->traducao->loadTraducao("3010", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->post_request['ac'] = base64_encode("Noticia_Gerencia");
        $this->Noticia_Gerencia();
    }

    /**
     * Chama View para incluçao de Tags da Noticia
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Tag_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $descricoes = $this->noticia_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Noticia_Tag_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Inclui Tags na Notícia
     * Função bypass
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Tag() {

        $this->traducao->loadTraducao("3013", $this->post_request['idioma']);

        /* CRIA UMA INSTANCIA PARA TagsNoticia_Control */
        $ctr_tags_noticia = new TagNoticia_Control($this->post_request);
        if (!$ctr_tags_noticia->TagNoticia_Add($this->post_request['id_noticia_corrente'])) {

            /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
            $this->post_request['ac'] = base64_encode('Noticia_Tag_V');
            $this->Noticia_Tag_V();
        } else {
            /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
            $this->post_request['ac'] = base64_encode('Noticia_Foto_Add_V');
            $this->Noticia_Foto_Add_V();
        }
    }

    /**
     * Chama View de inclução de Noticias Relacionadas
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Relacionada_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $descricoes = $this->noticia_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Noticia_Relacionada_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Inclui Noticia Relacionada
     * Função bypass
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Relacionada() {

        if (isset($this->post_request['relacao']) && count($this->post_request['relacao']) > 0) {

            $ctr_relacao_noticia = new RelacaoNoticia_Control($this->post_request);

            $i = 0;
            while ($i < count($this->post_request['relacao'])) {
                $ctr_relacao_noticia->RelacaoNoticia_Add($this->post_request['id_noticia_corrente'], $this->post_request['relacao'][$i]);
                $i++;
            }

            /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
            $this->traducao->loadTraducao("3014", $this->post_request['idioma']);
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        }

        $this->post_request['ac'] = base64_encode("Noticia_Relacionada_V");
        $this->Noticia_Relacionada_V();
    }

    /**
     * Apaga Noticia Relacionada
     * Função bypass
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Relacionada_Apaga() {

        $ctr_relacao_noticia = new RelacaoNoticia_Control($this->post_request);
        $ctr_relacao_noticia->RelacaoNoticia_Apaga();

        /* CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO */
        $this->traducao->loadTraducao("3014", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->post_request['ac'] = base64_encode("Noticia_Relacionada_V");
        $this->Noticia_Relacionada_V();
    }

    /**
     * Apaga Relacionamento entre Notícia 
     */
    public function Noticia_Conteudo_Apaga() {

        $this->ctr_relacao_conteudo->RelacaoConteudo_Apaga();

        $this->post_request['ac'] = base64_encode("Noticia_Gerencia");
        $this->Noticia_Gerencia();
    }

    /**
     * Chama View de Gerenciamento das fotos da Noticia
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Foto_Gerencia() {

        /* CONFIGURA CONDIÇÃO */
        $condicao = " AND status_foto = \"A\" AND id_noticia = " . $this->post_request['id'] . "";

        $total_reg = $this->foto_noticia_dao->get_Total("$condicao");

        if (!isset($this->post_request['pagina'])) {
            $this->post_request['pagina'] = 1;
        }

        $pag_views = 100;

        $mat = $this->post_request['pagina'] - 1;

        $inicio = $mat * $pag_views;

        $ordem = "ordem_foto";

        $objetos = $this->foto_noticia_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->foto_noticia_dao->get_Descricao();

        $vw = new Noticia_Foto_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    public function Noticia_Foto_Altera_V() {
        $descricoes = $this->foto_noticia_dao->get_Descricoes();
        $objeto = $this->foto_noticia_dao->loadObjeto($this->post_request['foto_capa']);

        $vw = new Noticia_Foto_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     * Executa a alteração do Crop da foto destaque
     * 
     * @return void
     */
    public function Noticia_Foto_Altera() {

        $img = new Imagem();
        $obj = $this->foto_noticia_dao->loadObjeto($this->post_request['id']);
        $objeto = $this->noticia_dao->loadObjeto($obj->get_id_noticia());
        $objeto->set_status_noticia('A');

        $this->noticia_dao->Save($objeto);

        $ext = $obj->get_ext_foto();
        $nome = $this->post_request['id'] . "." . $ext;

        $img->crop('arquivos/img_noticias/', "$nome", $this->post_request['x1'], $this->post_request['y1'], $this->post_request['w'], $this->post_request['h']);

        $this->post_request['id'] = $obj->get_id_foto();

        $this->traducao->loadTraducao("3023", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());

        $this->Noticia_Gerencia();
    }

    /**
     * Salva alteração das Fotos na Noticia
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Foto_Salva_Alteracoes() {

        $objeto = $this->noticia_dao->loadObjeto(isset($this->post_request['id_noticia_corrente']) ? $this->post_request['id_noticia_corrente'] : $this->post_request['id']);
        $dest = $this->Pega_Foto_Destaque($objeto->get_id_noticia());

        foreach ($this->post_request['leg_foto'] as $id_foto => $leg) {
            $obj_foto = $this->foto_noticia_dao->loadObjeto($id_foto);
            $obj_foto->set_leg_foto($leg);
            if (isset($this->post_request['apagar_foto'][$id_foto])) {
                $obj_foto->set_ordem_foto(0);
                $obj_foto->set_status_foto('D');
            }

            $this->foto_noticia_dao->Save($obj_foto);

            if ($this->post_request['foto_capa'] == $id_foto) {
                $this->foto_noticia_dao->set_capa($id_foto);
            }

            if (($obj_foto->get_status_foto() == 'D') && $obj_foto->get_destaque_foto()) {
                $this->foto_noticia_dao->corrige_ordem_faltante($obj_foto->get_id_noticia());

                if ($obj_foto->get_destaque_foto()) {
                    $this->foto_noticia_dao->set_capa_excluido($id_foto);
                }
            }
            $this->foto_noticia_dao->corrige_ordem_faltante($obj_foto->get_id_noticia());
        }

        if (!isset($dest[0]) & isset($this->post_request['foto_capa']) || $this->post_request['foto_capa'] != $dest[0]['id_foto']) {
            $this->Noticia_Foto_Altera_V();
        } else {
            $this->post_request['ac'] = base64_encode("Noticia_Gerencia");
            $this->Noticia_Gerencia();
        }
    }

    /**
     * Chama View de inclusão de Fotos na Noticia
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Foto_Add_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $descricoes = $this->foto_noticia_dao->get_Descricao();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new Noticia_Foto_Add_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Chama View de Ordenaçao de Fotos da Noticia
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Foto_Ordena_V() {
        $id_noticia = $this->post_request['id'];
        $condicao = " AND status_foto = \"A\" AND id_noticia = " . $id_noticia . "";
        $total_reg = $this->foto_noticia_dao->get_Total("$condicao");

        if ($this->post_request['pagina'] == "") {
            $this->post_request['pagina'] = 1;
        }

        $objetos = $this->foto_noticia_dao->get_Objs($condicao, "ordem_foto", 0, 100);
        $descricoes = $this->foto_noticia_dao->get_Descricao();

        $vw = new Noticia_Foto_Ordena_View($this->post_request, $objetos, $descricoes, $total_reg, "");
        $vw->showView();
    }

    /**
     * Ordena Fotos da Noticia
     * 
     * @author Marcio Figueredo
     * @return void
     */
    public function Noticia_Foto_Ordena() {
        $id = $this->post_request['id'];
        $ordem = $this->post_request['campooculto'];
        $ordem2 = str_replace('li_', '', $ordem);
        $chars = preg_split('/,/', $ordem2, -1, PREG_SPLIT_NO_EMPTY);

        $this->foto_noticia_dao->ordene_foto($chars, $id);

        $this->post_request['ac'] = base64_encode("Noticia_Foto_Gerencia");
        $this->Noticia_Foto_Gerencia();
    }

    public function Produto_Destacar_Slider() {

        $this->traducao->loadTraducao("3010", $this->post_request['idioma']);

        $objeto = $this->noticia_dao->loadObjeto($this->post_request['id']);
        $destacadas = $this->noticia_dao->get_Total("AND status_noticia = 'A' and destaque_slider = 1");
        if ($destacadas == $this->config->get_noticias_destaque()) {
            $this->post_request['msg_tp'] = "erro";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg41());
        } else {
            $objeto->set_destaque_slider(1);
            $this->noticia_dao->Save($objeto);
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg39());
        }
        $this->Noticia_Gerencia();
    }

    public function Produto_Reverter_Destaque_Slider() {
        $this->traducao->loadTraducao("3010", $this->post_request['idioma']);
        $objeto = $this->noticia_dao->loadObjeto($this->post_request['id']);
        $objeto->set_destaque_slider(0);
        $this->noticia_dao->Save($objeto);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg40());
        $this->Noticia_Gerencia();
    }

    /**
     * Retorna dados de uma Notícia com base no ID informado no parametro
     * 
     * @author Marcio Figueredo
     * @return Array
     */
    public function Pega_Dados_Noticia($id_noticia) {

        $objeto = $this->noticia_dao->loadObjeto($id_noticia);

        return $objeto->get_all_dados();
    }

    /* ---------------------------------------------------------------------- */
    /* ------------------- FUNCIONALIDADE PARA O SITE------------------------ */
    /* ---------------------------------------------------------------------- */

    public function Atualiza_Contado($id_noticia) {

        /* PEGA OBJETOS E SALVA DADOS */
        $objeto = $this->noticia_dao->loadObjeto($id_noticia);

        $objeto->set_contador_noticia($objeto->get_contador_noticia() + 1);

        $this->noticia_dao->Save($objeto);
    }

    public function Pega_Noticia($condicao, $ordem) {

        $objeto = $this->noticia_dao->get_Objs("$condicao", "$ordem", 0, 1);
        if (isset($objeto[0])) {
            return $objeto[0]->get_all_dados();
        } else {
            return NULL;
        }
    }

    public function Listar_Noticias($condicao, $ordem, $inicio = 0, $qtde = 1) {
        $condicao = " AND id_categoria_noticia != 3 ".$condicao;
        $objetos = $this->noticia_dao->get_Objs("$condicao", "$ordem", $inicio, $qtde);

        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

    public function Pega_Foto_Destaque($id_noticia) {

        $foto = $this->foto_noticia_dao->get_Foto_Destaque($id_noticia);

        return $foto;
    }

    public function Lista_Fotos_Noticia($id_noticia, $inicio = 0, $qtde = 100) {

        $objetos = $this->foto_noticia_dao->get_Objs(" AND id_noticia = $id_noticia AND status_foto = \"A\"", "ordem_foto ASC", $inicio, $qtde);

        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

    public function Verificar_URL($string) {
        return $this->noticia_dao->Verificar($string);
    }

    public function Importar_Noticias($ac) {
        return $this->noticia_dao->Importar($ac);
    }

}

?>
