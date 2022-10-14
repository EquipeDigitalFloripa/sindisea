<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * DAO da entidade Traducao, acessa todas as operações de banco de dados referentes ao Model Traducao que está em Libs
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
 * @package DAO
 *
 */
class Traducao_DAO extends Generic_DAO {

    public $chave = 'id_arquivo';
    public $tabela = 'tb_traducao';

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

        $id_arquivo = $objeto->get_id_arquivo();
        $nome_arquivo = $objeto->get_nome_arquivo();
        $id_modelo = $objeto->get_id_modelo();


        $sql = "LOCK TABLES tb_traducao WRITE";
        $this->conexao->consulta("$sql");

        $sql = "INSERT INTO tb_traducao (id_arquivo,lingua,nome_arquivo) values("
                . $id_arquivo . ",
                          \"PT\",
                          \"" . $nome_arquivo . "\"
                            );";
        $this->conexao->consulta("$sql");

        $sql = "INSERT INTO tb_traducao (id_arquivo,lingua,nome_arquivo) values("
                . $id_arquivo . ",
                          \"EN\",
                          \"" . $nome_arquivo . "\"
                            );";
        $this->conexao->consulta("$sql");

        $sql = "INSERT INTO tb_traducao (id_arquivo,lingua,nome_arquivo) values("
                . $id_arquivo . ",
                          \"ES\",
                          \"" . $nome_arquivo . "\"
                            );";
        $this->conexao->consulta("$sql");

        $sql = "UNLOCK TABLES";
        $this->conexao->consulta("$sql");


        if ($id_modelo > 0) {

            $objeto_modelo = new Traducao();
            $objeto_modelo->loadTraducao($id_modelo, "PT");
            $dados = $objeto_modelo->get_all_dados();
            $sql = "UPDATE tb_traducao SET
                                titulo_formulario01 = \"" . $dados['titulo_formulario01'] . "\",
                                titulo_formulario02 = \"" . $dados['titulo_formulario02'] . "\",
                                titulo_formulario03 = \"" . $dados['titulo_formulario03'] . "\",
                                titulo_formulario04 = \"" . $dados['titulo_formulario04'] . "\",
                                titulo_formulario05 = \"" . $dados['titulo_formulario05'] . "\",
                                titulo_formulario06 = \"" . $dados['titulo_formulario06'] . "\",
                                titulo_formulario07 = \"" . $dados['titulo_formulario07'] . "\",
                                titulo_formulario08 = \"" . $dados['titulo_formulario08'] . "\",
                                titulo_formulario09 = \"" . $dados['titulo_formulario09'] . "\",
                                titulo_formulario10 = \"" . $dados['titulo_formulario10'] . "\",
                                leg01               = \"" . $dados['leg01'] . "\",
                                leg02               = \"" . $dados['leg02'] . "\",
                                leg03               = \"" . $dados['leg03'] . "\",
                                leg04               = \"" . $dados['leg04'] . "\",
                                leg05               = \"" . $dados['leg05'] . "\",
                                leg06               = \"" . $dados['leg06'] . "\",
                                leg07               = \"" . $dados['leg07'] . "\",
                                leg08               = \"" . $dados['leg08'] . "\",
                                leg09               = \"" . $dados['leg09'] . "\",
                                leg10               = \"" . $dados['leg10'] . "\",
                                leg11               = \"" . $dados['leg11'] . "\",
                                leg12               = \"" . $dados['leg12'] . "\",
                                leg13               = \"" . $dados['leg13'] . "\",
                                leg14               = \"" . $dados['leg14'] . "\",
                                leg15               = \"" . $dados['leg15'] . "\",
                                leg16               = \"" . $dados['leg16'] . "\",
                                leg17               = \"" . $dados['leg17'] . "\",
                                leg18               = \"" . $dados['leg18'] . "\",
                                leg19               = \"" . $dados['leg19'] . "\",
                                leg20               = \"" . $dados['leg20'] . "\",
                                leg21               = \"" . $dados['leg21'] . "\",
                                leg22               = \"" . $dados['leg22'] . "\",
                                leg23               = \"" . $dados['leg23'] . "\",
                                leg24               = \"" . $dados['leg24'] . "\",
                                leg25               = \"" . $dados['leg25'] . "\",
                                leg26               = \"" . $dados['leg26'] . "\",
                                leg27               = \"" . $dados['leg27'] . "\",
                                leg28               = \"" . $dados['leg28'] . "\",
                                leg29               = \"" . $dados['leg29'] . "\",
                                leg30               = \"" . $dados['leg30'] . "\",
                                leg31               = \"" . $dados['leg31'] . "\",
                                leg32               = \"" . $dados['leg32'] . "\",
                                leg33               = \"" . $dados['leg33'] . "\",
                                leg34               = \"" . $dados['leg34'] . "\",
                                leg35               = \"" . $dados['leg35'] . "\",
                                leg36               = \"" . $dados['leg36'] . "\",
                                leg37               = \"" . $dados['leg37'] . "\",
                                leg38               = \"" . $dados['leg38'] . "\",
                                leg39               = \"" . $dados['leg39'] . "\",
                                leg40               = \"" . $dados['leg40'] . "\",
                                leg41               = \"" . $dados['leg41'] . "\",
                                leg42               = \"" . $dados['leg42'] . "\",
                                leg43               = \"" . $dados['leg43'] . "\",
                                leg44               = \"" . $dados['leg44'] . "\",
                                leg45               = \"" . $dados['leg45'] . "\",
                                leg46               = \"" . $dados['leg46'] . "\",
                                leg47               = \"" . $dados['leg47'] . "\",
                                leg48               = \"" . $dados['leg48'] . "\",
                                leg49               = \"" . $dados['leg49'] . "\",
                                leg50               = \"" . $dados['leg50'] . "\"
                                    where id_arquivo = " . $id_arquivo . " and lingua = \"PT\"
                                ";
            $this->conexao->consulta("$sql");

            $objeto_modelo = new Traducao();
            $objeto_modelo->loadTraducao($id_modelo, "EN");
            $dados = $objeto_modelo->get_all_dados();
            $sql = "UPDATE tb_traducao SET
                                titulo_formulario01 = \"" . $dados['titulo_formulario01'] . "\",
                                titulo_formulario02 = \"" . $dados['titulo_formulario02'] . "\",
                                titulo_formulario03 = \"" . $dados['titulo_formulario03'] . "\",
                                titulo_formulario04 = \"" . $dados['titulo_formulario04'] . "\",
                                titulo_formulario05 = \"" . $dados['titulo_formulario05'] . "\",
                                titulo_formulario06 = \"" . $dados['titulo_formulario06'] . "\",
                                titulo_formulario07 = \"" . $dados['titulo_formulario07'] . "\",
                                titulo_formulario08 = \"" . $dados['titulo_formulario08'] . "\",
                                titulo_formulario09 = \"" . $dados['titulo_formulario09'] . "\",
                                titulo_formulario10 = \"" . $dados['titulo_formulario10'] . "\",
                                leg01               = \"" . $dados['leg01'] . "\",
                                leg02               = \"" . $dados['leg02'] . "\",
                                leg03               = \"" . $dados['leg03'] . "\",
                                leg04               = \"" . $dados['leg04'] . "\",
                                leg05               = \"" . $dados['leg05'] . "\",
                                leg06               = \"" . $dados['leg06'] . "\",
                                leg07               = \"" . $dados['leg07'] . "\",
                                leg08               = \"" . $dados['leg08'] . "\",
                                leg09               = \"" . $dados['leg09'] . "\",
                                leg10               = \"" . $dados['leg10'] . "\",
                                leg11               = \"" . $dados['leg11'] . "\",
                                leg12               = \"" . $dados['leg12'] . "\",
                                leg13               = \"" . $dados['leg13'] . "\",
                                leg14               = \"" . $dados['leg14'] . "\",
                                leg15               = \"" . $dados['leg15'] . "\",
                                leg16               = \"" . $dados['leg16'] . "\",
                                leg17               = \"" . $dados['leg17'] . "\",
                                leg18               = \"" . $dados['leg18'] . "\",
                                leg19               = \"" . $dados['leg19'] . "\",
                                leg20               = \"" . $dados['leg20'] . "\",
                                leg21               = \"" . $dados['leg21'] . "\",
                                leg22               = \"" . $dados['leg22'] . "\",
                                leg23               = \"" . $dados['leg23'] . "\",
                                leg24               = \"" . $dados['leg24'] . "\",
                                leg25               = \"" . $dados['leg25'] . "\",
                                leg26               = \"" . $dados['leg26'] . "\",
                                leg27               = \"" . $dados['leg27'] . "\",
                                leg28               = \"" . $dados['leg28'] . "\",
                                leg29               = \"" . $dados['leg29'] . "\",
                                leg30               = \"" . $dados['leg30'] . "\",
                                leg31               = \"" . $dados['leg31'] . "\",
                                leg32               = \"" . $dados['leg32'] . "\",
                                leg33               = \"" . $dados['leg33'] . "\",
                                leg34               = \"" . $dados['leg34'] . "\",
                                leg35               = \"" . $dados['leg35'] . "\",
                                leg36               = \"" . $dados['leg36'] . "\",
                                leg37               = \"" . $dados['leg37'] . "\",
                                leg38               = \"" . $dados['leg38'] . "\",
                                leg39               = \"" . $dados['leg39'] . "\",
                                leg40               = \"" . $dados['leg40'] . "\",
                                leg41               = \"" . $dados['leg41'] . "\",
                                leg42               = \"" . $dados['leg42'] . "\",
                                leg43               = \"" . $dados['leg43'] . "\",
                                leg44               = \"" . $dados['leg44'] . "\",
                                leg45               = \"" . $dados['leg45'] . "\",
                                leg46               = \"" . $dados['leg46'] . "\",
                                leg47               = \"" . $dados['leg47'] . "\",
                                leg48               = \"" . $dados['leg48'] . "\",
                                leg49               = \"" . $dados['leg49'] . "\",
                                leg50               = \"" . $dados['leg50'] . "\"
                                    where id_arquivo = " . $id_arquivo . " and lingua = \"EN\"
                                ";
            $this->conexao->consulta("$sql");


            return true;
        } else {
            return true;
        }
    }

// fim do Save

    /**
     * Apaga o registro através do id passado por parâmetro
     *
     * @author Ricardo Ribeiro Assink
     * @param int $id ID do registro que deve ser apagado
     * @return void
     */
    public function Delete($id) {

        $sql = "DELETE FROM tb_traducao where id_arquivo = $id";
        $this->conexao->consulta("$sql");
    }

    /**
     *
     * LoadObjeto não implementado para a entidade Traducao, usar loadTraducao da propria entidade.
     *
     * @author Ricardo Ribeiro Assink
     * @param int $id ID do registro que deve popular o objeto
     * @return Objeto Objeto populado
     */
    public function loadObjeto($id) {

    }

    /**
     * Pega o total de registros da tabela através da condição enviada.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $condicao Condição para cálculo do total de registros
     * @return int Total de Registros
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * $meuObjetoDAO    = new DAO_Objeto("AF_Bd_Mysql");
     * $total_registro  = $meuObjetoDAO->get_Total("status_usuario = 'A'");
     *
     *     // pega o total de usuários ativos
     *
     * ?>
     * </code>
     *
     */
    public function get_Total($condicao) {

        if ($condicao != "") {
            $condicao = "where $condicao";
        }

        $sql = "SELECT count(id_arquivo) from tb_traducao $condicao";
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArray($result);
        return $ret[0][0] / 2;
    }

    /**
     *
     * Pega um Array com o todos os ids de registro conforme parâmetros.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $condicao Instrução SQL
     * @param String $ordem Condição Instrução SQL
     * @param int $iniciao Registro inicial
     * @param int $fim Registro Final
     * @return Array Array com os ids dos registros
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * $meuObjetoDAO    = new DAO_Objeto("AF_Bd_Mysql");
     * $ids_de_usuarios = Array();
     * $ids_de_usuarios = $meuObjetoDAO->get_Ids("status_usuario = 'A'","nome_usuario",0,15);
     *
     *  // pega os 15 primeiros ids ordenados pelo nome, dos registros no banco onde o usuário está ativo
     *
     * ?>
     * </code>
     *
     */
    public function get_Ids($condicao, $ordem, $inicio = "", $pag_views = "") {

        if (!isset($inicio) or !isset($pag_views)) {
            $limite = "";
        } else {
            $limite = "LIMIT $inicio,$pag_views";
        }

        if ($condicao != "") {
            $condicao = "where $condicao";
        }

        $sql = "SELECT DISTINCT(id_arquivo) id_arquivo from tb_traducao $condicao order by $ordem $limite";
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArrayOnce($result);
        return $ret;
    }

    /**
     *
     * Retorna um Array com o todos os objetos carregados conforme parâmetros.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $condicao Instrução SQL
     * @param String $ordem Condição Instrução SQL
     * @param int $iniciao Registro inicial
     * @param int $fim Registro Final
     * @return Array Array com o todos os objetos carregados conforme parâmetros.
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * $meuObjetoDAO    = new DAO_Objeto("AF_Bd_Mysql");
     * $objs_de_usuarios = Array();
     * $objs_de_usuarios = $meuObjetoDAO->get_Objs("status_usuario = 'A'","nome_usuario",0,15);
     *
     *
     * ?>
     * </code>
     *
     */
    public function get_Objs($condicao, $ordem, $inicio, $pag_views, $assoc = false) {

        $ret = $this->get_Ids($condicao, $ordem, $inicio, $pag_views);
        $objs = Array();
        if (count($ret) > 0) {
            foreach ($ret as $valor) {
                $ob = new Traducao();
                $ob->loadTraducao($valor, "PT");
                Array_push($objs, $ob);
            }
        }
        return $objs;
    }

    /**
     *
     * Descrições serão os nomes de todos os aquivos cadastrados
     *
     * @author Ricardo Ribeiro Assink
     * @param Classe $className Nome do arquivo da classe
     * @return Array Array com as descrições de campos
     *
     *
     */
    public function get_Descricao() {

        $desc = Array();
        $sql = "SELECT id_arquivo,nome_arquivo from tb_traducao order by id_arquivo";
        $result = $this->conexao->consulta("$sql");
        $nome_arquivo = $this->conexao->criaArray($result);
        $i = 0;
        while ($i < count($nome_arquivo)) {
            $nome_arquivo_compact[$nome_arquivo[$i]['id_arquivo']] = $nome_arquivo[$i]['id_arquivo'] . " - " . $nome_arquivo[$i]['nome_arquivo'];
            $i++;
        }
        $desc['nome_arquivo'] = $nome_arquivo_compact;
        return $desc;
    }

    public function Save2($objeto) {

        $id_arquivo = $objeto->get_id_arquivo();
        $lingua = $objeto->get_lingua();
        $dados = array_map("addslashes", $objeto->get_all_dados());
        $sql = "UPDATE tb_traducao SET
                                titulo_formulario01 = \"" . $dados['titulo_formulario01'] . "\",
                                titulo_formulario02 = \"" . $dados['titulo_formulario02'] . "\",
                                titulo_formulario03 = \"" . $dados['titulo_formulario03'] . "\",
                                titulo_formulario04 = \"" . $dados['titulo_formulario04'] . "\",
                                titulo_formulario05 = \"" . $dados['titulo_formulario05'] . "\",
                                titulo_formulario06 = \"" . $dados['titulo_formulario06'] . "\",
                                titulo_formulario07 = \"" . $dados['titulo_formulario07'] . "\",
                                titulo_formulario08 = \"" . $dados['titulo_formulario08'] . "\",
                                titulo_formulario09 = \"" . $dados['titulo_formulario09'] . "\",
                                titulo_formulario10 = \"" . $dados['titulo_formulario10'] . "\",
                                leg01               = \"" . $dados['leg01'] . "\",
                                leg02               = \"" . $dados['leg02'] . "\",
                                leg03               = \"" . $dados['leg03'] . "\",
                                leg04               = \"" . $dados['leg04'] . "\",
                                leg05               = \"" . $dados['leg05'] . "\",
                                leg06               = \"" . $dados['leg06'] . "\",
                                leg07               = \"" . $dados['leg07'] . "\",
                                leg08               = \"" . $dados['leg08'] . "\",
                                leg09               = \"" . $dados['leg09'] . "\",
                                leg10               = \"" . $dados['leg10'] . "\",
                                leg11               = \"" . $dados['leg11'] . "\",
                                leg12               = \"" . $dados['leg12'] . "\",
                                leg13               = \"" . $dados['leg13'] . "\",
                                leg14               = \"" . $dados['leg14'] . "\",
                                leg15               = \"" . $dados['leg15'] . "\",
                                leg16               = \"" . $dados['leg16'] . "\",
                                leg17               = \"" . $dados['leg17'] . "\",
                                leg18               = \"" . $dados['leg18'] . "\",
                                leg19               = \"" . $dados['leg19'] . "\",
                                leg20               = \"" . $dados['leg20'] . "\",
                                leg21               = \"" . $dados['leg21'] . "\",
                                leg22               = \"" . $dados['leg22'] . "\",
                                leg23               = \"" . $dados['leg23'] . "\",
                                leg24               = \"" . $dados['leg24'] . "\",
                                leg25               = \"" . $dados['leg25'] . "\",
                                leg26               = \"" . $dados['leg26'] . "\",
                                leg27               = \"" . $dados['leg27'] . "\",
                                leg28               = \"" . $dados['leg28'] . "\",
                                leg29               = \"" . $dados['leg29'] . "\",
                                leg30               = \"" . $dados['leg30'] . "\",
                                leg31               = \"" . $dados['leg31'] . "\",
                                leg32               = \"" . $dados['leg32'] . "\",
                                leg33               = \"" . $dados['leg33'] . "\",
                                leg34               = \"" . $dados['leg34'] . "\",
                                leg35               = \"" . $dados['leg35'] . "\",
                                leg36               = \"" . $dados['leg36'] . "\",
                                leg37               = \"" . $dados['leg37'] . "\",
                                leg38               = \"" . $dados['leg38'] . "\",
                                leg39               = \"" . $dados['leg39'] . "\",
                                leg40               = \"" . $dados['leg40'] . "\",
                                leg41               = \"" . $dados['leg41'] . "\",
                                leg42               = \"" . $dados['leg42'] . "\",
                                leg43               = \"" . $dados['leg43'] . "\",
                                leg44               = \"" . $dados['leg44'] . "\",
                                leg45               = \"" . $dados['leg45'] . "\",
                                leg46               = \"" . $dados['leg46'] . "\",
                                leg47               = \"" . $dados['leg47'] . "\",
                                leg48               = \"" . $dados['leg48'] . "\",
                                leg49               = \"" . $dados['leg49'] . "\",
                                leg50               = \"" . $dados['leg50'] . "\"
                                    where id_arquivo = " . $id_arquivo . " and lingua = \"$lingua\"
                                ";

        $this->conexao->consulta("$sql");
    }

}

?>
