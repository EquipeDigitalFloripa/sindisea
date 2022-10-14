<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de controle da entidade Associado, filho de Control
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
class Associado_Control extends Control {

    private $associado_dao;

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
     *       $this->associado_dao = $config->get_DAO("Associado");
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request) {

        parent::__construct($post_request);
        $this->associado_dao = $this->config->get_DAO("Associado");
    }

    /**
     *
     * Mostra a lista de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Gerencia() {



        /* CONFIGURE FILTRO DE PESQUISA */
        $condicao = (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] != 0) ? ' AND status_associado = ' . $this->post_request['selecao01'] . '' : '';
        $condicao .= isset($this->post_request['pesquisa']) ? ' AND (status_associado = "A" OR status_associado = "I") AND (nome LIKE "%' . $this->post_request['pesquisa'] . '%" OR cpf="' . $this->post_request['pesquisa'] . '")' : '';
        $condicao .= (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 3) ? ' AND categoria LIKE "%aposentado%"' : "";

        /* CALCULA TOTAL DE REGISTROS */
        $total_reg = $this->associado_dao->get_Total("$condicao");


        /* INICIALIZA A PAGINA NA PRIMEIRA VEZ QUE A VIEW EH MOSTRADA // NAO MODIFIQUE */
        if (!isset($this->post_request['pagina'])) {
            $this->post_request['pagina'] = 1;
        }

        /* CONFIGURE O NUMERO DE REGISTROS POR PAGINA */
        $pag_views = 50;

        /* CALCULA OS PARAMETROS DE PAGINACAO */
        $mat = $this->post_request['pagina'] - 1; // NAO MODIFIQUE ESTA LINHA
        $inicio = $mat * $pag_views; // NAO MODIFIQUE ESTA LINHA

        /* CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS */
        $ordem = "nome";

        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->associado_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->associado_dao->get_Descricao();



        /* CARREGA A VIEW E MOSTRA */
        if (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 1) {
            $vw = new RelatorioAssociado_Email_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        } else if (isset($this->post_request['selecao02']) && $this->post_request['selecao02'] == 2) {
            $vw = new RelatorioAssociado_Endereco_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        } else {
            $vw = new Associado_Gerencia_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        }
        $vw->showView();
    }

    public function Associado_Lista_Download() {

        $array = $this->Lista_Associados(" AND status_associado != 'N'");

        $titulo[] = "ID";
        $titulo[] = "Nome";
        $titulo[] = "E-mail - Empresarial";
        $titulo[] = "E-mail - Pessoal";
        $titulo[] = "CPF";
        $titulo[] = "Data de Nascimento";
        $titulo[] = "Matrícula";
        $titulo[] = "Unidade Organizacional";
        $titulo[] = "Categoria";
        $titulo[] = "Telefone Residencial";
        $titulo[] = "Telefone Empresarial";
        $titulo[] = "Telefone Celular";
        $titulo[] = "CEP";
        $titulo[] = "Endereço";
        $titulo[] = "Número";
        $titulo[] = "Complemento";
        $titulo[] = "Bairro";
        $titulo[] = "Cidade";
        $titulo[] = "Estado";
        $titulo[] = "Data de Cadastro";
        $titulo[] = "Status";
        $titulo[] = "Data Início";
        $titulo[] = "Data Fim";
        $titulo[] = "Observações";

        unlink("./arquivos/Filiados.xls");

        $out = fopen("./arquivos/Filiados.xls", 'w');

        chmod("./arquivos/Filiados.xls", 0777);

        fputcsv($out, $titulo, "\t");

        foreach ($array as $data) {
            unset($data["senha"]);
            unset($data["token"]);
            fputcsv($out, $data, "\t");
        }
        fclose($out);
    }

    /**
     *
     * Mostra a lista de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Ger_Solicitante_V() {
        /*
         * ******************************************************************************************
         * CONFIGURE FILTRO DE PESQUISA
         * ***************INICIO
         */
        $pesquisa = $this->post_request['pesquisa'];
        if ($pesquisa != "") {
            $condicao .= " and status_associado = \"E\" and nome LIKE '%$pesquisa%' ";
        } else {
            $condicao .= " and status_associado = \"E\"";
        }

        $total_reg = $this->associado_dao->get_Total("$condicao");
        /*
         * ******************************************************************************************
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
        $pag_views = 15; // número de registros por página
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
        $ordem = "id_associado DESC";
        /*
         * ******************************************************************************************
         * CONFIGURE O CAMPO QUE DEVE ORDENAR A PESQUISA DOS ELEMENTOS
         * ***************FIM
         */

        // PEGA OBJETOS E DESCRICOES
        $objetos = $this->associado_dao->get_Objs($condicao, $ordem, $inicio, $pag_views);
        $descricoes = $this->associado_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Associado_Ger_Solicitante_View($this->post_request, $objetos, $descricoes, $total_reg, $pag_views);
        $vw->showView();
    }

    /**
     *
     * Desativa Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Desativa() {

        $data = new Data();

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->associado_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_associado("I");
        $objeto->set_data_fim_filiacao($this->data->get_dataFormat("NOW", "", "BD"));
        $this->associado_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5083", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg38());
        $this->Associado_Gerencia();
    }

    /**
     *
     * Ativa Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Ativa() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->associado_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_associado("A");
        $this->associado_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5083", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Associado_Gerencia();
    }

    /**
     *
     * Deleta Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Apaga() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->associado_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_associado("D");
        $this->associado_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5083", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Associado_Gerencia();
    }

    /**
     *
     * Altera senha de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Pass() {

        // CARREGA DAO, SETA SENHA e SALVA
        $objeto = $this->associado_dao->loadObjeto($this->post_request['id']);
        $objeto->set_senha(base64_encode($this->post_request['senha1']));

        $this->associado_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5084", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Associado_Gerencia();
    }

    /**
     *
     * Chama a View de Alteração de senha de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Pass_V() {

        // PEGA OBJETO
        $objeto = $this->associado_dao->loadObjeto($this->post_request['id']);

        //CARREGA A VIEW E MOSTRA
        $vw = new Associado_Pass_View($this->post_request, $objeto);
        $vw->showView();
    }

    /**
     *
     * Altera dados de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Altera() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = $this->associado_dao->loadObjeto($this->post_request['id']);
        $objeto->set_nome($this->post_request['nome']);
        $objeto->set_email_trabalho($this->post_request['email_trabalho']);
        $objeto->set_email_pessoal($this->post_request['email_pessoal']);
        $objeto->set_cpf($this->post_request['cpf_associado']);
        $objeto->set_data_nascimento($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data_nascimento'], "BD"));
        $objeto->set_matricula($this->post_request['matricula']);
        $objeto->set_unidade_organizacional($this->post_request['unidade_organizacional']);
        $objeto->set_categoria($this->post_request['categoria']);
        $objeto->set_telefone_residencial($this->post_request['telefone_residencial']);
        $objeto->set_telefone_trabalho($this->post_request['telefone_trabalho']);
        $objeto->set_telefone_celular($this->post_request['telefone_celular']);
        $objeto->set_cep($this->post_request['cep']);
        $objeto->set_endereco($this->post_request['endereco']);
        $objeto->set_numero($this->post_request['numero']);
        $objeto->set_complemento($this->post_request['complemento']);
        $objeto->set_bairro($this->post_request['bairro']);
        $objeto->set_cidade($this->post_request['cidade']);
        $objeto->set_estado($this->post_request['estado']);
        $objeto->set_observacoes($this->post_request['observacoes']);
        $objeto->set_data_inicio_filiacao($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data_inicio_filiacao'], "BD"));
        $objeto->set_data_fim_filiacao($this->data->get_dataFormat("CALENDARINICIO", $this->post_request['data_fim_filiacao'], "BD"));

        $this->associado_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5082", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg47());
        $this->Associado_Gerencia();
    }

    /**
     *
     * Chama a View de Alteração de dados de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Altera_V() {

        // PEGA OBJETO
        $objeto = $this->associado_dao->loadObjeto($this->post_request['id']);
        $descricoes = $this->associado_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Associado_Altera_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     *
     * Chama a View de Inclusão de Usuários
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Add_V() {

        // Pega as descrições
        $descricoes = $this->associado_dao->get_Descricao();

        //CARREGA A VIEW E MOSTRA
        $vw = new Associado_Add_View($this->post_request, $objeto, $descricoes);
        $vw->showView();
    }

    /**
     *
     * Inclui novo Usuário
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Add() {

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Associado();
        $objeto->set_nome($this->post_request['nome']);
        $objeto->set_email_trabalho($this->post_request['email_trabalho']);
        $objeto->set_email_pessoal($this->post_request['email_pessoal']);
        $objeto->set_cpf($this->post_request['cpf_associado']);
        $objeto->set_data_nascimento($this->post_request['data_nascimento']);
        $objeto->set_categoria($this->post_request['categoria']);
        $objeto->set_matricula($this->post_request['matricula']);
        $objeto->set_unidade_organizacional($this->post_request['unidade_organizacional']);
        $objeto->set_telefone_residencial($this->post_request['telefone_residencial']);
        $objeto->set_telefone_trabalho($this->post_request['telefone_trabalho']);
        $objeto->set_telefone_celular($this->post_request['telefone_celular']);
        $objeto->set_cep($this->post_request['cep']);
        $objeto->set_endereco($this->post_request['endereco']);
        $objeto->set_numero($this->post_request['numero']);
        $objeto->set_complemento($this->post_request['complemento']);
        $objeto->set_bairro($this->post_request['bairro']);
        $objeto->set_cidade($this->post_request['cidade']);
        $objeto->set_estado($this->post_request['estado']);
        $objeto->set_senha(base64_encode($this->post_request['senha']));
        $objeto->set_data_cadastro($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_data_inicio_filiacao($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_data_fim_filiacao($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_associado("A");

        $id_associado_new = $this->associado_dao->Save($objeto);

        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("5081", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg47());
        $this->Associado_Add_V();
    }

    /**
     *
     * Autoriza Solicitações
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Autoriza() {


        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->associado_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_associado("A");
        $objeto->set_data_inicio_filiacao($this->data->get_dataFormat("NOW", "", "BD"));
        $this->associado_dao->Save($objeto);

        $config = new Config();

        $email = $objeto->get_email_pessoal();
        $cliente = $config->get_cliente();


        /* CONFIGURA LISTA DE EMAIL PARA DESTINATÁRIO */
        $lista = array();
        $lista[0] = $email;

        /* CONFIGURA VARIÁVEIS RECEBIDA DO FROMULÁRIO VIA POST */


        $nome_cliente = $objeto->get_nome();

        /* CONFIGURA O ASSUNTO DO E-MAIL */
        $assunto = 'Filiação SINDIASEA';

        /* CONFIGURA HTML DO CORPO DO E-MAIL */
        $mesg = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /></head>
    <body>
        Prezado(a) ' . $nome_cliente . ',<br><br>Sua filiação, tão importante para a representatividade e força da categoria, foi efetivada.<br><br>

Seja bem-vindo(a) ao SINDISEA.
    </body>
</html>
    ';


        //----------------------------- PHPMAILER --------------------------------------
        $obj_mail = new Email();
        $obj_mail->send_mail($cliente, $lista, $assunto, $mesg, $email);


        // GRAVA LOG
        //$this->log->gravaLog(10,$this->post_request['id_sessao'],$this->post_request['id']);
        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2048", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg36());
        $this->Associado_Ger_Solicitante_V();
    }

    /**
     *
     * Autoriza Solicitações
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Nega() {

        // CARREGA DAO, SETA STATUS e SALVA
        $objeto = $this->associado_dao->loadObjeto($this->post_request['id']);
        $objeto->set_status_associado("N");
        $this->associado_dao->Save($objeto);

        // GRAVA LOG
        //$this->log->gravaLog(10,$this->post_request['id_sessao'],$this->post_request['id']);
        // CONFIGURA MENSAGEM DE SUCESSO E RETORNA PARA O GERENCIAMENTO
        $this->traducao->loadTraducao("2048", $this->post_request['idioma']);
        $this->post_request['msg_tp'] = "sucesso";
        $this->post_request['msg'] = $this->preparaTransporte($this->traducao->get_leg37());
        $this->Associado_Ger_Solicitante_V();
    }

    public function loadAssociado($id_associado) {
        $objeto[0] = $this->associado_dao->loadObjeto($id_associado);
        $objeto[1] = $this->associado_dao->get_Descricao();
        return $objeto;
    }

    public function Pega_Associado($id_associado) {
        $objeto = $this->associado_dao->loadObjeto($id_associado);
        $dados = $objeto->get_all_dados();

        return $dados;
    }

    public function Pega_Associado_Condicao($condicao) {

        $objeto = $this->associado_dao->get_Objs("$condicao", "id_associado", 0, 1);

        if (count($objeto) > 0) {
            return $objeto[0]->get_all_dados();
        } else {
            return NULL;
        }
    }

    public function Lista_Associados($condicao = "") {

        $objetos = $this->associado_dao->get_Objs("$condicao", "nome ASC", 0, 9999999);

        $dados = Array();
        $i = 0;
        while ($i < count($objetos)) {
            $dados[$i] = $objetos[$i]->get_all_dados();
            $i++;
        }
        return $dados;
    }

    /**
     *
     * Inclui novo Usuário
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Solicita_Inclusao() {

        $data = new Data();

        $data_nascimento = $data->get_dataFormat("CALENDARINICIO", $this->post_request['data_nascimento'], "BD");

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = new Associado();
        $objeto->set_nome(utf8_decode($this->post_request['nome']));
        $objeto->set_email_trabalho($this->post_request['email_trabalho']);
        $objeto->set_email_pessoal($this->post_request['email_pessoal']);
        $objeto->set_cpf($this->post_request['cpf_form']);
        $objeto->set_data_nascimento($data_nascimento);
        $objeto->set_categoria($this->post_request['categoria']);
        $objeto->set_matricula($this->post_request['matricula']);
        $objeto->set_unidade_organizacional(utf8_decode($this->post_request['unidade_organizacional']));
        $objeto->set_telefone_residencial($this->post_request['telefone_residencial']);
        $objeto->set_telefone_trabalho($this->post_request['telefone_trabalho']);
        $objeto->set_telefone_celular($this->post_request['telefone_celular']);
        $objeto->set_cep($this->post_request['cep']);
        $objeto->set_endereco(utf8_decode($this->post_request['endereco']));
        $objeto->set_numero($this->post_request['numero']);
        $objeto->set_complemento(utf8_decode($this->post_request['complemento']));
        $objeto->set_bairro(utf8_decode($this->post_request['bairro']));
        $objeto->set_cidade(utf8_decode($this->post_request['cidade']));
        $objeto->set_estado($this->post_request['estado']);
        $objeto->set_senha(base64_encode($this->post_request['senha_form']));
        $objeto->set_data_cadastro($this->data->get_dataFormat("NOW", "", "BD"));
        $objeto->set_status_associado("E"); //ESPERA

        $this->associado_dao->Save($objeto);
    }

    public function Associado_Login($cpf, $senha) {

        $condicao = " AND status_associado = \"A\" AND cpf = '$cpf' AND senha = '" . base64_encode($senha) . "' ";

        $total_reg = $this->associado_dao->get_Total($condicao);

        $dados = NULL;

        // PEGA OBJETOS E DESCRICOES
        if ($total_reg > 0) {
            $objetos = $this->associado_dao->get_Objs($condicao, 'nome', 0, 1);
            $dados = $objetos[0]->get_all_dados();
        }
        $retorno['id_associado'] = $dados['id_associado'];
        return $retorno;
    }

    public function Verifica_Cpf($cpf) {

        $condicao = " AND cpf = '$cpf' ";

        $total_reg = $this->associado_dao->get_Total($condicao);

        return $total_reg;
    }

    /**
     *
     * Altera dados de Associados
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     *
     */
    public function Associado_Altera_Site() {

        $data = new Data();

        // CARREGA DAO, SETA DADOS e SALVA
        $objeto = $this->associado_dao->loadObjeto($this->post_request['id_associado']);

        $data_nascimento = $data->get_dataFormat("CALENDARINICIO", $this->post_request['data_nascimento'], "BD");

        $objeto->set_nome(utf8_decode($this->post_request['nome']));
        $objeto->set_email_trabalho($this->post_request['email_trabalho']);
        $objeto->set_email_pessoal($this->post_request['email_pessoal']);
        $objeto->set_cpf($this->post_request['cpf_form']);
        $objeto->set_categoria($this->post_request['categoria']);
        $objeto->set_data_nascimento($data_nascimento);
        $objeto->set_matricula($this->post_request['matricula']);
        $objeto->set_unidade_organizacional(utf8_decode($this->post_request['unidade_organizacional']));
        $objeto->set_telefone_residencial($this->post_request['telefone_residencial']);
        $objeto->set_telefone_trabalho($this->post_request['telefone_trabalho']);
        $objeto->set_telefone_celular($this->post_request['telefone_celular']);
        $objeto->set_cep($this->post_request['cep']);
        $objeto->set_endereco(utf8_decode($this->post_request['endereco']));
        $objeto->set_numero($this->post_request['numero']);
        $objeto->set_complemento(utf8_decode($this->post_request['complemento']));
        $objeto->set_bairro(utf8_decode($this->post_request['bairro']));
        $objeto->set_cidade(utf8_decode($this->post_request['cidade']));
        $objeto->set_estado($this->post_request['estado']);

        $this->associado_dao->Save($objeto);
    }

    //ALTERAR SENHA PELO SITE
    public function Associado_Altera_Senha_Site() {

        $objeto = $this->associado_dao->loadObjeto($this->post_request['id_associado']);

        $dados = $objeto->get_all_dados();

        if ($dados['senha'] == base64_encode($this->post_request['senha_atual'])) {

            $objeto->set_senha(base64_encode($this->post_request['nova_senha']));
            $this->associado_dao->Save($objeto);

            return true;
        }
        return false;
    }

    //ALTERAR SENHA PELO SITE
    public function Associado_Esqueceu_Senha($id_associado) {

        $objeto = $this->associado_dao->loadObjeto($id_associado);

        $token = $this->gerarCaracteres(16);

        $objeto->set_token($token);
        $this->associado_dao->Save($objeto);

        return $token;
    }

    function gerarCaracteres($tamanho = 8, $maiusculas = true, $numeros = true) {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $retorno = '';
        $caracteres = '';

        $caracteres .= $lmin;
        if ($maiusculas)
            $caracteres .= $lmai;
        if ($numeros)
            $caracteres .= $num;

        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }

    //ALTERAR SENHA PELO SITE
    public function Associado_Redefinir_Senha($id_associado, $nova_senha) {

        $objeto = $this->associado_dao->loadObjeto($id_associado);
        $objeto->set_senha(base64_encode($nova_senha));
        $objeto->set_token("");
        $this->associado_dao->Save($objeto);
    }

    public function Associado_Imprimir() {

        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        date_default_timezone_set("America/Sao_Paulo");

        require_once("../Libs/tcpdf/tcpdf.php");
        require_once("../Libs/tcpdf/mypdf.php");

        unlink('../sys/arquivos/file.pdf');

        /* CONFIGURE FILTRO DE PESQUISA */
        $condicao = (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 0 ) ? ' AND (status_associado = "A" OR status_associado = "I")' : (
                (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 1 ) ? ' AND status_associado = "A"' : (
                (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 2 ) ? ' AND status_associado = "I"' : ' AND status_associado = "A"'));

        $condicao .= (isset($this->post_request['pesquisa']) && $this->post_request['pesquisa'] != "") ? ' AND (status_associado = "A" OR status_associado = "I") AND (nome LIKE "%' . $this->post_request['pesquisa'] . '%" OR cpf=' . $this->post_request['pesquisa'] . ')' : '';

        /* CALCULA TOTAL DE REGISTROS */
        $total_reg = $this->associado_dao->get_Total("$condicao");


        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->associado_dao->get_Objs($condicao, "nome ASC", 0, $total_reg);

        $i = 0;
        $tr_impressao = '';
        while ($i < count($objetos)) {

            $dados = $objetos[$i]->get_all_dados();

            /* LINHAS PARA TABELA DE IMPRESSÃO */
            $bgcolor = ($i % 2 == 0) ? '#F0F0F0' : '#FFFFFF';
            $tr_impressao .= '<tr bgcolor="' . $bgcolor . '">
                    <td><strong>CPF: </strong><font size="7">' . $dados['cpf'] . '</font><br /><strong>Nome: </strong><font size="7">' . $dados['nome'] . '</font><br /><strong>Nascimento: </strong><font size="7">' . $this->data->get_dataFormat("BD", $dados['data_nascimento'], "DMA") . '</font></td>        
                    <td><strong>Pessoal: </strong><font size="7">' . $dados['email_pessoal'] . '</font><br /><strong>Trabalho: </strong><font size="7">' . $dados['email_trabalho'] . '</font><br /></td>
                    <td><strong>Residencial: </strong><font size="7">' . $dados['telefone_residencial'] . '</font><br /><strong>Celular: </strong><font size="7">' . $dados['telefone_celular'] . '</font><br /><br /><strong>Trabalho: </strong><font size="7">' . $dados['telefone_trabalho'] . '</font></td>
                    <td><strong>Endereço: </strong><font size="7">' . $dados['endereco'] . ', ' . $dados['numero'] . ' - ' . $dados['complemento'] . '</font><br /><strong>Bairro: </strong><font size="7">' . $dados['bairro'] . '</font><br /><strong>Cidade: </strong><font size="7">' . $dados['cidade'] . ' / ' . $dados['estado'] . '</font><br /><strong>CEP: </strong><font size="7">' . $dados['cep'] . '</font><br /></td>
                    <td><strong>Matrícula: </strong><font size="7">' . $dados['matricula'] . '</font><br /><strong>Unidade: </strong><font size="7">' . $dados['unidade_organizacional'] . '</font><br /><strong>Categoria: </strong><font size="7">' . $dados['categoria'] . '</font></td>
                </tr>';

            $i++;
        }


        $table = '<table width="100%" align="left" border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td colspan="5" align="center"><font size="11" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">Relatório de Filiados</font></td>
                            </tr>                            
                            <tr bgcolor="#666666">                                            
                                <th width="20%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">Dados Pessoais</font></th>
                                <th width="20%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">E-mails</font></th>
                                <th width="15%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">Telefones</font></th>
                                <th width="20%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">Endereço</font></th>
                                <th width="25%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">Dados Filiados</font></th>                                            
                            </tr>
                            ' . $tr_impressao . '
                        </table>';

        $pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
                <html>
                    <head><meta http-equiv=Content-Type content=text/html charset=ISO-8859-1/></head>                    
                    <body>' . $table . '</body>
                </html>';

        $pdf->SetHeaderData("logo.png", 50, utf8_encode(PDF_HEADER_TITLE), utf8_encode(PDF_HEADER_STRING), array(0, 0, 0), array(0, 0, 0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
        $pdf->SetHeaderMargin(5);
        $pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 7));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(1);
        $pdf->SetFont('dejavusans', '', 7, '', true);
        $pdf->AddPage('L', '', FALSE, TRUE);
        $pdf->writeHTML(utf8_encode($html), true, false, true, false, '');

        $pdf->Output('../sys/arquivos/file.pdf', 'F'); //F salva, D download, I abre no navegador  
        chmod('../sys/arquivos/file.pdf', 0777);

        echo "fim";
    }

    public function Imprimir_Relatorioa_Email() {

        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        date_default_timezone_set("America/Sao_Paulo");

        require_once("../Libs/tcpdf/tcpdf.php");
        require_once("../Libs/tcpdf/mypdf.php");

        unlink('../sys/arquivos/fileRelatorioEmail.pdf');

        /* CONFIGURE FILTRO DE PESQUISA */
        $condicao = (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 0 ) ? ' AND (status_associado = "A" OR status_associado = "I")' : (
                (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 1 ) ? ' AND status_associado = "A"' : (
                (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 2 ) ? ' AND status_associado = "I"' : ' AND status_associado = "A"'));

        $condicao .= (isset($this->post_request['pesquisa']) && $this->post_request['pesquisa'] != "") ? ' AND (status_associado = "A" OR status_associado = "I") AND (nome LIKE "%' . $this->post_request['pesquisa'] . '%" OR cpf=' . $this->post_request['pesquisa'] . ')' : '';

        /* CALCULA TOTAL DE REGISTROS */
        $total_reg = $this->associado_dao->get_Total("$condicao");


        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->associado_dao->get_Objs($condicao, "nome ASC", 0, $total_reg);

        $i = 0;
        $tr_impressao = '';
        while ($i < count($objetos)) {

            $dados = $objetos[$i]->get_all_dados();

            /* LINHAS PARA TABELA DE IMPRESSÃO */
            $bgcolor = ($i % 2 == 0) ? '#F0F0F0' : '#FFFFFF';
            $tr_impressao .= '<tr bgcolor="' . $bgcolor . '">
                                <td><font size="7">' . $dados['cpf'] . '</font></td>
                                <td><font size="7">' . $dados['nome'] . '</font></td>
                                <td><font size="7">' . $dados['email_trabalho'] . '</font></td>
                                <td><font size="7">' . $dados['email_pessoal'] . '</font></td>
                            </tr>';
            $i++;
        }

        $table = '<table width="100%" align="left" border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td colspan="5" align="center"><font size="11" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">Relatório de Filiados</font></td>
                            </tr>                            
                            <tr bgcolor="#666666">                                            
                                <th width="10%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">CPF</font></th>
                                <th width="30%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">Nome</font></th>
                                <th width="30%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">E-mail Trabalho</font></th>
                                <th width="30%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">E-mail Pessoal</font></th>                                
                            </tr>
                            ' . $tr_impressao . '
                        </table>';

        $pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html><head><meta http-equiv=Content-Type content=text/html charset=ISO-8859-1/></head><body>' . $table . '</body></html>';

        $pdf->SetHeaderData("logo.png", 50, utf8_encode(PDF_HEADER_TITLE), utf8_encode(PDF_HEADER_STRING), array(0, 0, 0), array(0, 0, 0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
        $pdf->SetHeaderMargin(5);
        $pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 7));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(1);
        $pdf->SetFont('dejavusans', '', 7, '', true);
        $pdf->AddPage('L', '', FALSE, TRUE);
        $pdf->writeHTML(utf8_encode($html), true, false, true, false, '');

        $pdf->Output('../sys/arquivos/fileRelatorioEmail.pdf', 'F'); //F salva, D download, I abre no navegador  
        chmod('../sys/arquivos/fileRelatorioEmail.pdf', 0777);

        echo "fim";
    }

    public function Imprimir_Relatorioa_Endereco() {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        date_default_timezone_set("America/Sao_Paulo");

        require_once("../Libs/tcpdf/tcpdf.php");
        require_once("../Libs/tcpdf/mypdf.php");

        unlink('../sys/arquivos/fileRelatorioEndereco.pdf');

        /* CONFIGURE FILTRO DE PESQUISA */
        $condicao = (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 0 ) ? ' AND (status_associado = "A" OR status_associado = "I")' : (
                (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 1 ) ? ' AND status_associado = "A"' : (
                (isset($this->post_request['selecao01']) && $this->post_request['selecao01'] == 2 ) ? ' AND status_associado = "I"' : ' AND status_associado = "A"'));

        $condicao .= (isset($this->post_request['pesquisa']) && $this->post_request['pesquisa'] != "") ? ' AND (status_associado = "A" OR status_associado = "I") AND (nome LIKE "%' . $this->post_request['pesquisa'] . '%" OR cpf=' . $this->post_request['pesquisa'] . ')' : '';

        /* CALCULA TOTAL DE REGISTROS */
        $total_reg = $this->associado_dao->get_Total("$condicao");


        /* PEGA OBJETOS E DESCRICOES */
        $objetos = $this->associado_dao->get_Objs($condicao, "nome ASC", 0, $total_reg);

        $i = 0;
        $tr_impressao = '';
        while ($i < count($objetos)) {

            $dados = $objetos[$i]->get_all_dados();

            /* LINHAS PARA TABELA DE IMPRESSÃO */
            $bgcolor = ($i % 2 == 0) ? '#F0F0F0' : '#FFFFFF';
            $tr_impressao .= '<tr bgcolor="' . $bgcolor . '">
                                <td><font size="7">' . $dados['cpf'] . '</font></td>
                                <td><font size="7">' . $dados['nome'] . '</font></td>
                                <td><font size="7">' . $dados['endereco'] . ', ' . $dados['numero'] . ' - ' . $dados['complemento'] . '</font></td>
                                <td><font size="7">' . $dados['bairro'] . '</font></td>
                                <td><font size="7">' . $dados['cidade'] . '</font></td>
                            </tr>';
            $i++;
        }

        $table = '<table width="100%" align="left" border="0" cellspacing="0" cellpadding="2">
                            <tr>
                                <td colspan="5" align="center"><font size="11" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">Relatório de Filiados</font></td>
                            </tr>                            
                            <tr bgcolor="#666666">                                            
                                <th width="10%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">CPF</font></th>
                                <th width="25%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">Nome</font></th>
                                <th width="45%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">Endereço</font></th>
                                <th width="10%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">Bairro</font></th>
                                <th width="10%"><font size="9" color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif">Cidade</font></th>                                
                            </tr>
                            ' . $tr_impressao . '
                        </table>';

        $pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html><head><meta http-equiv=Content-Type content=text/html charset=ISO-8859-1/></head><body>' . $table . '</body></html>';

        $pdf->SetHeaderData("logo.png", 50, utf8_encode(PDF_HEADER_TITLE), utf8_encode(PDF_HEADER_STRING), array(0, 0, 0), array(0, 0, 0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
        $pdf->SetHeaderMargin(5);
        $pdf->setFooterData(array(0, 0, 0), array(0, 0, 0));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 7));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetMargins(5, PDF_MARGIN_TOP, 5);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(1);
        $pdf->SetFont('dejavusans', '', 7, '', true);
        $pdf->AddPage('L', '', FALSE, TRUE);
        $pdf->writeHTML(utf8_encode($html), true, false, true, false, '');

        $pdf->Output('../sys/arquivos/fileRelatorioEndereco.pdf', 'F'); //F salva, D download, I abre no navegador  
        chmod('../sys/arquivos/fileRelatorioEndereco.pdf', 0777);

        echo "fim";
    }

}

?>
