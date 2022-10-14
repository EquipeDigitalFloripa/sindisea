<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade EnvioSMS, filho de Control
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2019-2022, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 12/03/2019
 * @package Control
 */
class EnvioSMS_Control extends Control {

    private $envio_sms_dao;
    private $sms;

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
     *       $this->envio_sms_dao = $config->get_DAO("Post");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);

        $this->envio_sms_dao = $this->config->get_DAO("EnvioSMS");
        $this->sms = new SMS();
    }

    /**
     * Mostra a lista de EnvioSMSs
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function EnvioSMS_Gerencia() {

        /* CONFIGURA FILTRO DE PESQUISA */
        $condicao = ' AND (status_aviso = "A" OR status_aviso = "I")';

        /* CALCULA TOTAL DE REGISTRO */
        $total_reg = $this->envio_sms_dao->get_Total("$condicao");

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
        $ordem = "data_aviso DESC";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->envio_sms_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->envio_sms_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new EnvioSMS_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     * Carrega View para envio de SMS ao Grupo
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function EnvioSMS_Grupo_V() {

        /* PEGA OBJETOS E DESCRIÇÕES */
        $descricoes = $this->envio_sms_dao->get_Descricoes();

        /* CARREGA A VIEW E MOSTRA */
        $vw = new EnvioSMS_Grupo_View($this->post_request, "", $descricoes);
        $vw->showView();
    }

    /**
     * Envia SMS a um Grupo
     *
     * @author Marcio Figueredo
     * @return void
     */
    public function EnvioSMS_Grupo($nome_regiao = '') {
        if(isset($nome_regiao)){
            $id_regiao = $this->envio_sms_dao->get_Regiao($nome_regiao);

            $objeto = new EnvioSMS();
            $objeto->set_id_grupo_sms($id_regiao);
            $objeto->set_texto_envio($this->post_request['texto_envio']);
            $objeto->set_data_envio($this->data->get_dataFormat("NOW", "", "BD"));
            $this->envio_sms_dao->Save($objeto);

            $array_contato = $this->envio_sms_dao->get_Contatos_Regiao($id_regiao);

            $i = 0;
            while ($i < count($array_contato)) {

                $this->sms->Send(preg_replace("/[^0-9]/", "", $array_contato[$i]['celular']), $this->post_request['texto_envio']);
                $i++;
            }
            
        }
        if ($this->post_request['ids_grupo_sms'] != NULL) {

            foreach ($this->post_request['ids_grupo_sms'] as $id_grupo_sms) {

                $objeto = new EnvioSMS();

                $objeto->set_id_grupo_sms($id_grupo_sms);
                $objeto->set_texto_envio($this->post_request['texto_envio']);
                $objeto->set_data_envio($this->data->get_dataFormat("NOW", "", "BD"));

                //SALVA OBJETO
                $this->envio_sms_dao->Save($objeto);


                $array_contato = $this->envio_sms_dao->get_Contatos_Grupo($id_grupo_sms);

                $i = 0;
                
                //print_r($array_contato);
                while ($i < count($array_contato)) {
                    $this->sms->Send(preg_replace("/[^0-9]/", "", $array_contato[$i]['telefone_contato']), $this->post_request['texto_envio']);

                    $i++;
                }
            }
            //die;
        }
        if(isset($this->post_request['return']) && $this->post_request['return'] == 1){

            
            $this->traducao->loadTraducao("4013", $this->post_request['idioma']);
            $this->post_request['msg_tp'] = "sucesso";
            $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
            
            $this->EnvioSMS_Grupo_V();
        }
    }

}

?>
