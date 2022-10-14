
<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Conteúdo, acessa todas as operações de banco de dados referentes ao Model Conteúdo
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 04/04/2014 por Marcio Figueredo
 *
 *
 * @package DAO
 *
 */
class Conteudo_DAO extends Generic_DAO {

    public $chave = 'id_conteudo';
    public $tabela = 'tb_conteudo';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    /**
     * Salva o objeto, se tiver id setado executa update, se não tiver executa insert
     *
     * @author Ricardo Ribeiro Assink
     * @param Objeto $objeto Objeto
     * @return mixed int id_usuario no caso de cadastro e Boolean true no caso de update
     * @Exemplo
     * <code>
     *
     * <?php
     *
     *  // dentro do controller, operação de cadastro de novo Artigo
     *
     *  $meuObjetoDAO    = new DAO_Objeto("AF_Bd_Mysql");
     *  $meuObjetoArtigo = new Artigo();
     *     ... popula o objeto só faltando o id
     *  $meuObjetoDAO->Save($meuObjetoArtigo);
     *
     * ?>
     * </code>
     *
     */
    public function Save($objeto) {

        if ($objeto->get_id_conteudo() == "") { // Cadastra novo
            $sql = "LOCK TABLES tb_conteudo WRITE";
            $this->conexao->consulta("$sql");


            $sql = "select max(id_conteudo) id_conteudo from tb_conteudo";
            $result = $this->conexao->consulta("$sql");
            $row = $this->conexao->criaArray($result);

            $id_conteudo_new = $row[0][0];
            $id_conteudo_new++;
            $objeto->set_id_conteudo($id_conteudo_new);

            $dados = array_map("addslashes", $objeto->get_all_dados());
            $sql = "INSERT INTO tb_conteudo values(
                            " . $dados['id_conteudo'] . ",                            
                            \"" . $dados['nome_link'] . "\",
                            \"" . $dados['conteudo'] . "\",
                            \"" . $dados['ordem_menu'] . "\",
                            \"" . $dados['status_conteudo'] . "\",
                            \"" . $dados['menu'] . "\",
                            \"" . $dados['keywords'] . "\",
                            \"" . $dados['title_url'] . "\",
                            \"" . $dados['url_amigavel'] . "\",
                            \"" . $dados['arquivo_pagina'] . "\"
                            );";
            $this->conexao->consulta("$sql");

            $sql = "UNLOCK TABLES";
            $this->conexao->consulta("$sql");

            return $id_conteudo_new;
        } else { // já tem ID então é UPDATE
            $dados = array_map("addslashes", $objeto->get_all_dados());
            $sql = "UPDATE tb_conteudo SET                                   
                                   nome_link         = \"" . $dados['nome_link'] . "\",
                                   conteudo          = \"" . $dados['conteudo'] . "\",
                                   ordem_menu        = \"" . $dados['ordem_menu'] . "\",
                                   status_conteudo   = \"" . $dados['status_conteudo'] . "\",
                                   menu              = \"" . $dados['menu'] . "\",
                                   keywords          = \"" . $dados['keywords'] . "\",
                                   title_url         = \"" . $dados['title_url'] . "\",
                                   url_amigavel         = \"" . $dados['url_amigavel'] . "\",
                                   arquivo_pagina = \"" . $dados['arquivo_pagina'] . "\"
                                   where id_conteudo = " . $dados['id_conteudo'] . "
                            ";
            $this->conexao->consulta("$sql");
            return true;
        }
    }

    public function move_Obj($id_conteudo, $direcao) {
        //Carrega o objeto selecionado
        $objeto_selecionado = $this->loadObjeto($id_conteudo);
        $ordem_antiga_selecionado = $objeto_selecionado->get_ordem_menu();
        //Carrega o próximo objeto
        if ($direcao == 'acima') {
            $sql = "SELECT id_conteudo, ordem_menu FROM tb_conteudo WHERE ordem_menu < " . $ordem_antiga_selecionado . " AND menu = 1 ORDER BY ordem_menu DESC LIMIT 1";
        } elseif ($direcao == 'abaixo') {
            $sql = "SELECT id_conteudo, ordem_menu FROM tb_conteudo WHERE ordem_menu > " . $ordem_antiga_selecionado . " AND menu = 1 ORDER BY ordem_menu ASC LIMIT 1";
        }
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArray($result);

        $sql = "UPDATE tb_conteudo SET ordem_menu = " . $ordem_antiga_selecionado . " WHERE id_conteudo = " . $ret[0]['id_conteudo'] . "";
        $result = $this->conexao->consulta("$sql");

        $sql2 = "UPDATE tb_conteudo SET ordem_menu = " . $ret[0]['ordem_menu'] . " WHERE id_conteudo = " . $id_conteudo . "";
        $result2 = $this->conexao->consulta("$sql2");

        $this->corrige_ordem_duplicada();
    }

    //Se houver dois registros com a mesma ordem_menu, modifica a ordem do segundo registro (ordenado pelo id_conteudo) para a última ordem.
    public function corrige_ordem_duplicada() {

        $sql = "SELECT ordem_menu, COUNT( * ) AS ocorrencias FROM tb_conteudo GROUP BY ordem_menu";
        $result = $this->conexao->consulta("$sql");
        $ordens = $this->conexao->criaArray($result);

        foreach ($ordens as $reg) {
            if ($reg['ocorrencias'] > 1) {

                $sql1 = "SELECT id_conteudo FROM tb_conteudo WHERE ordem_menu = " . $reg['ordem_menu'] . " ORDER BY id_conteudo DESC LIMIT 1";
                $result = $this->conexao->consulta("$sql1");
                $ret1 = $this->conexao->criaArrayOnce($result);

                $nova_ordem = $this->proxima_ordem();

                $sql3 = "UPDATE tb_conteudo SET ordem_menu = " . $nova_ordem . " WHERE id_conteudo = " . $ret1[0] . "";
                $result = $this->conexao->consulta("$sql3");
                break; //termina a execução
            }
        }
        $this->corrige_ordem_faltante();
    }

    //modifica a ordem de todos os registros, a partir do registro faltante.
    public function corrige_ordem_faltante() {

        $sql = "SELECT ordem_menu FROM tb_conteudo ORDER BY ordem_menu";
        $result = $this->conexao->consulta("$sql");
        $ordens = $this->conexao->criaArrayOnce($result);

        $maior_ordem = end($ordens);

        for ($i = 1; $i <= $maior_ordem; $i++) {
            if (!in_array($i, $ordens)) {
                $sql = "UPDATE tb_conteudo SET ordem_menu = ordem_menu - 1 WHERE ordem_menu > $i";
                $result = $this->conexao->consulta("$sql");
                break; //termina a execução
            }
        }
    }

    public function proxima_ordem() {
        $sql = "SELECT max(ordem_menu) from tb_conteudo";
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArrayOnce($result);
        return $ret[0] + 1;
    }

    /**
     *
     * Retorna as descrições de campos
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return Array Array com as descrições de campos
     *
     * @exemplo
     * <code>
     *
     * Array
     *      (
     *          [desc_perm_usuario] => Array
     *              (
     *                  [R] => Root
     *                  [W] => Webmaster
     *                  [A] => Autor
     *                  [D] => Diretor do Portal
     *                  [C] => Consultor
     *                  [S] => Salva Vidas
     *              )
     *
     *          [desc_status_usuario] => Array
     *              (
     *                  [P] => Aguardando aprovação
     *                  [N] => Negada a entrada na Comunidade
     *                  [A] => Ativo
     *                  [I] => Inativo
     *              )
     *
     *      )
     *
     *
     * </code>
     *
     */
    public function get_Descricao() {

        $desc = Array();
        $sql = "SELECT max(ordem_menu) from tb_conteudo where menu = 1";
        $result = $this->conexao->consulta("$sql");
        $total = $this->conexao->criaArrayOnce($result);
        $desc['total_links'] = $total[0];

//        $sql2 = "SELECT title_url, url_amigavel FROM tb_conteudo WHERE menu = 1";
        $sql2 = "SELECT title_url, url_amigavel FROM tb_conteudo WHERE status_conteudo=\"A\" AND menu = 2";
        $result2 = $this->conexao->consulta("$sql2");
        $total2 = $this->conexao->criaArray($result2);
        $desc['urls'] = $total2;

//        $sql3 = "SELECT nome_arquivo FROM tb_arquivo";
//        $result3 = $this->conexao->consulta("$sql3");
//        $total3 = $this->conexao->criaArray($result3);
//        $desc['arquivos'] = $total3;

        return $desc;
    }

}

?>
