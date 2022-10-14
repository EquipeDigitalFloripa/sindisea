<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

class Generic_DAO {

    /**
     * 
     * 
     */
    protected $conexao;
    private $objeto_atual;
    private $chave;
    private $tabela;
    private $associacoes;

    public function get_conexao() {
        return $this->conexao;
    }

    public function set_conexao($conexao) {
        $this->conexao = $conexao;
    }

    public function get_objeto_atual() {
        return $this->objeto_atual;
    }

    public function set_objeto_atual($objeto_atual) {
        $this->objeto_atual = $objeto_atual;
    }

    public function get_chave() {
        return $this->chave;
    }

    public function set_chave($chave) {
        $this->chave = $chave;
    }

    public function get_tabela() {
        return $this->tabela;
    }

    public function set_tabela($tabela) {
        $this->tabela = $tabela;
    }

    public function get_associacoes() {
        return $this->associacoes;
    }

    public function set_associacoes($associacoes) {
        $this->associacoes = $associacoes;
    }

    public function __construct($factory, $chave, $tabela) {
        $banco = new $factory();
        $this->conexao = $banco->getInstance();
        $objeto = strtok(get_class($this), "_");
        $this->objeto_atual = $objeto;
        $this->chave = $chave;
        $this->tabela = $tabela;
    }

    public function Save($objeto) {

        $arr_update = array();

        //Pega métodos get e set
        $metodos = get_class_methods($objeto);
        $get_id = $metodos[0];
        $set_id = $metodos[1];

        //Array de dados
        $dados = array_map("addslashes", $objeto->get_all_dados());

        //Array de [0 - n] com campos
        $campos = array_keys($dados);

        //String com os dados para inserir ou alteraR
        $limite = count($dados);
        $str_insert = "";
        for ($i = 1; $i < $limite; $i++) {
            $str_insert .= ", \"" . $dados[$campos[$i]] . "\"";
            $arr_update[] = $campos[$i] . " = \"" . $dados[$campos[$i]] . "\"";
        }

        if ($objeto->$get_id() == "") { // Cadastra novo usuário
            $sql = "LOCK TABLES $this->tabela WRITE";
            $this->conexao->consulta("$sql");

            $sql = "select max($this->chave) $this->chave from $this->tabela where $this->chave < 999990";
            $result = $this->conexao->consulta("$sql");
            $row = $this->conexao->criaArray($result);

            $id_new = $row[0][0];
            $id_new++;

            $objeto->$set_id($id_new);
            $insert = $id_new . $str_insert;

            $sql = "INSERT INTO $this->tabela values($insert);";
//            return $sql;
            $this->conexao->consulta("$sql");
            $sql = "UNLOCK TABLES";
            $this->conexao->consulta("$sql");
            return $id_new;
        } else {
            $str_update = implode(",", $arr_update);
            $sql = "UPDATE $this->tabela SET $str_update where $this->chave = " . $dados[$this->chave] . "";
//            print_r($sql);die();
            $this->conexao->consulta("$sql");
            return true;
        }
    }

    // fim do Save

    public function Delete($id) {
        $sql = "DELETE FROM $this->tabela where $this->chave = $id";
        $this->conexao->consulta("$sql");
    }

    public function loadObjeto($id) {

        $objeto = new $this->objeto_atual();
        $dados = $objeto->get_all_dados();
        $campos = array_keys($dados);
        $str_campos = implode(",", $campos);
        $limite = count($campos);
        $sql = "SELECT $str_campos FROM $this->tabela WHERE $this->chave = $id;";
//        print_r($sql);die();
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArray($result);
        $metodos = get_class_methods($objeto);
        $j = 1;
        for ($i = 0; $i < $limite; $i++) {
            $invoque = $metodos[$j];
            if (isset($row[0])) {
                $param = $row[0][$campos[$i]];
            } else {
                $param = null;
            }
            $objeto->$invoque($param);
            $j = $j + 2;
        }
        return $objeto;
    }

    public function get_Total($condicao) {

        $status = $this->pega_campo_status();

        $sql = "SELECT count($this->chave) FROM $this->tabela WHERE $status <> \"D\" $condicao";
//        echo $sql;
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArray($result);
        return $ret[0][0];
    }

    public function get_Ids($condicao, $ordem, $inicio = "", $pag_views = "") {

        $status = $this->pega_campo_status();

        $limite = "LIMIT $inicio,500";
        if ($pag_views != NULL) {
            $limite = "LIMIT $inicio,$pag_views";
        }
        $sql = "SELECT $this->chave FROM $this->tabela WHERE $status <> \"D\" $condicao ORDER BY $ordem $limite";
        //echo $sql;
        $result = $this->conexao->consulta("$sql");
        $ret = $this->conexao->criaArrayOnce($result);

        return $ret;
    }

    public function get_Objs($condicao, $ordem, $inicio, $pag_views, $assoc = false) {

        $ret = $this->get_Ids($condicao, $ordem, $inicio, $pag_views);

        $objs = Array();
        $chaves_assoc = Array();
        if (count($ret) > 0) {
            foreach ($ret as $valor) {
                $o = $this->loadObjeto($valor);
                if ($assoc) {
                    $fun = "get_" . $this->chave;
                    $chaves_assoc[] = $o->$fun();
                    $this->set_associacoes($chaves_assoc);
                }
                Array_push($objs, $o);
            }
        }
        return $objs;
    }

    public function get_Assoc($condicao, $ordem, $indice, $chaves) {
        sort($chaves);
        $pag_views = $this->get_Total($condicao);
        $ret = Array();
        $objs = Array();
        $n_chaves = count($chaves);
        for ($i = 0; $i < $n_chaves; $i++) {
            $ret[$chaves[$i]] = $this->get_Ids("AND $indice = $chaves[$i]", $indice, 0, $pag_views);
            foreach ($ret[$chaves[$i]] as $valor) {
                $o = $this->loadObjeto($valor);
                $fun = "get_" . $this->chave;
                $chave2 = $o->$fun();
                $objs[$chaves[$i]][$chave2] = $o;
            }
        }
        return $objs;
    }

    /**
     *
     * Faz o relacionamento de dados entre duas tabelas.
     * Este método deve ser chamado dentro da classe objeto_DAO que estende o Generic_DAO.
     *
     *
     * @author Marcela Santana
     * @return Array[String]
     * @param String $tabela Tabela na qual deseja pegar os valores relacionados
     * @param String $index Valor usado para fazer a indexação do array de retorno, deve ser um dos campos da tabela relacionada($tabela)
     * @param String $campo_solicitado Valores do array de retorno deve ser um dos campos da tabela relacionada($tabela)
     * @param String $condicao Se for necessário adicionar alguma condição ao comando SQL, deve ser precedido do operador lógico.
     * @Exemplo
     * <code>
     *  public function get_Descricoes() {
     *      $desc = Array();
     *      $desc['evento_relacionado'] = parent::get_Descricoes('tb_evento', 'id_evento', 'nome', "OR status_usuario = \"I\"");
     *      return $desc;
     *  }
     * </code>
     *
     */
    public function get_Descricoes($tabela = "", $index = 0, $campo_solicitado = 1, $condicao = "") {

        $sql = "SHOW COLUMNS FROM $tabela";
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArrayOnce($result);
        $n = count($row);
        $campos = implode(" , ", $row);
        $status = $this->pega_campo_status($tabela);

        if (!$status) {
            $status = "";
        } else {
            $status = " WHERE $status = \"A\"";
        }

        $desc = Array();
        $sql = "SELECT $campos FROM $tabela $status $condicao";
        //echo $sql;
        $result = $this->conexao->consulta("$sql");
        $desc_tipo = $this->conexao->criaArray($result);
        $n_desc = count($desc_tipo);
        $i = 0;
        while ($i < $n_desc) {
            $desc_tipo_compact[$desc_tipo[$i][$index]] = $desc_tipo[$i][$campo_solicitado];
            $i++;
        }
        return $desc_tipo_compact;
    }

    private function pega_campo_status($table = null) {

        if (is_null($table)) {
            $table = $this->tabela;
        }
        $sql = "SHOW COLUMNS FROM $table";
        $result = $this->conexao->consulta("$sql");
        $row = $this->conexao->criaArrayOnce($result);
        foreach ($row as $campo) {
            if (preg_match("/^status_/", $campo)) {
                return $campo;
            }
        }
        return false;
    }

}

?>
