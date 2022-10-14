<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Classe de textos e traduções
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
 * @package Libs
 *
 */
class Traducao {

    private $conexao;
    private $id_arquivo;
    private $id_modelo;
    private $lingua;
    private $nome_arquivo;
    private $titulo_formulario01;
    private $titulo_formulario02;
    private $titulo_formulario03;
    private $titulo_formulario04;
    private $titulo_formulario05;
    private $titulo_formulario06;
    private $titulo_formulario07;
    private $titulo_formulario08;
    private $titulo_formulario09;
    private $titulo_formulario10;
    private $leg01;
    private $leg02;
    private $leg03;
    private $leg04;
    private $leg05;
    private $leg06;
    private $leg07;
    private $leg08;
    private $leg09;
    private $leg10;
    private $leg11;
    private $leg12;
    private $leg13;
    private $leg14;
    private $leg15;
    private $leg16;
    private $leg17;
    private $leg18;
    private $leg19;
    private $leg20;
    private $leg21;
    private $leg22;
    private $leg23;
    private $leg24;
    private $leg25;
    private $leg26;
    private $leg27;
    private $leg28;
    private $leg29;
    private $leg30;
    private $leg31;
    private $leg32;
    private $leg33;
    private $leg34;
    private $leg35;
    private $leg36;
    private $leg37;
    private $leg38;
    private $leg39;
    private $leg40;
    private $leg41;
    private $leg42;
    private $leg43;
    private $leg44;
    private $leg45;
    private $leg46;
    private $leg47;
    private $leg48;
    private $leg49;
    private $leg50;

    /**
     * Carrega a conexão com o banco de dados.
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *       $config        = new Config();
     *       $factory       = $config->get_banco();
     *       $banco         = new $factory();
     *       $this->conexao = $banco->getInstance();
     *   }
     *
     * </code>
     *
     */
    public function __construct() {

        $config = new Config();
        $factory = $config->get_banco();
        $banco = new $factory();
        $this->conexao = $banco->getInstance();
    }

    /**
     *
     * Carrega a tradução do arquivo no objeto.
     *
     * @author Ricardo Ribeiro Assink
     * @param int $id_arquivo ID do arquivo.
     * @param String $idioma Idioma para carregamento
     * @return void
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Traducao.class.php");
     *
     *  $objeto = new Traducao();
     *  $objeto->loadTraducao(2001,"PT");
     *
     * ?>
     * </code>
     *
     */
    public function loadTraducao($id_arquivo, $idioma) {

        if ($idioma == "") {
            $idioma = "PT";
        }
        $idioma = strtoupper($idioma);
        $this->set_id_arquivo($id_arquivo);
        $this->set_lingua($idioma);
        $sql = "
        SELECT
              nome_arquivo,
              titulo_formulario01,
              titulo_formulario02,
              titulo_formulario03,
              titulo_formulario04,
              titulo_formulario05,
              titulo_formulario06,
              titulo_formulario07,
              titulo_formulario08,
              titulo_formulario09,
              titulo_formulario10,
              leg01,
              leg02,
              leg03,
              leg04,
              leg05,
              leg06,
              leg07,
              leg08,
              leg09,
              leg10,
              leg11,
              leg12,
              leg13,
              leg14,
              leg15,
              leg16,
              leg17,
              leg18,
              leg19,
              leg20,
              leg21,
              leg22,
              leg23,
              leg24,
              leg25,
              leg26,
              leg27,
              leg28,
              leg29,
              leg30,
              leg31,
              leg32,
              leg33,
              leg34,
              leg35,
              leg36,
              leg37,
              leg38,
              leg39,
              leg40,
              leg41,
              leg42,
              leg43,
              leg44,
              leg45,
              leg46,
              leg47,
              leg48,
              leg49,
              leg50
          FROM
              tb_traducao
         WHERE
              id_arquivo = $id_arquivo
              and lingua = \"$idioma\"
       ";

        $result = $this->conexao->consulta("$sql");
        $res = $this->conexao->criaArray($result);
        
        $this->set_nome_arquivo($res[0]['nome_arquivo']);
        $this->set_titulo_formulario01($res[0]['titulo_formulario01']);
        $this->set_titulo_formulario02($res[0]['titulo_formulario02']);
        $this->set_titulo_formulario03($res[0]['titulo_formulario03']);
        $this->set_titulo_formulario04($res[0]['titulo_formulario04']);
        $this->set_titulo_formulario05($res[0]['titulo_formulario05']);
        $this->set_titulo_formulario06($res[0]['titulo_formulario06']);
        $this->set_titulo_formulario07($res[0]['titulo_formulario07']);
        $this->set_titulo_formulario08($res[0]['titulo_formulario08']);
        $this->set_titulo_formulario09($res[0]['titulo_formulario09']);
        $this->set_titulo_formulario10($res[0]['titulo_formulario10']);
        $this->set_leg01($res[0]['leg01']);
        $this->set_leg02($res[0]['leg02']);
        $this->set_leg03($res[0]['leg03']);
        $this->set_leg04($res[0]['leg04']);
        $this->set_leg05($res[0]['leg05']);
        $this->set_leg06($res[0]['leg06']);
        $this->set_leg07($res[0]['leg07']);
        $this->set_leg08($res[0]['leg08']);
        $this->set_leg09($res[0]['leg09']);
        $this->set_leg10($res[0]['leg10']);
        $this->set_leg11($res[0]['leg11']);
        $this->set_leg12($res[0]['leg12']);
        $this->set_leg13($res[0]['leg13']);
        $this->set_leg14($res[0]['leg14']);
        $this->set_leg15($res[0]['leg15']);
        $this->set_leg16($res[0]['leg16']);
        $this->set_leg17($res[0]['leg17']);
        $this->set_leg18($res[0]['leg18']);
        $this->set_leg19($res[0]['leg19']);
        $this->set_leg20($res[0]['leg20']);
        $this->set_leg21($res[0]['leg21']);
        $this->set_leg22($res[0]['leg22']);
        $this->set_leg23($res[0]['leg23']);
        $this->set_leg24($res[0]['leg24']);
        $this->set_leg25($res[0]['leg25']);
        $this->set_leg26($res[0]['leg26']);
        $this->set_leg27($res[0]['leg27']);
        $this->set_leg28($res[0]['leg28']);
        $this->set_leg29($res[0]['leg29']);
        $this->set_leg30($res[0]['leg30']);
        $this->set_leg31($res[0]['leg31']);
        $this->set_leg32($res[0]['leg32']);
        $this->set_leg33($res[0]['leg33']);
        $this->set_leg34($res[0]['leg34']);
        $this->set_leg35($res[0]['leg35']);
        $this->set_leg36($res[0]['leg36']);
        $this->set_leg37($res[0]['leg37']);
        $this->set_leg38($res[0]['leg38']);
        $this->set_leg39($res[0]['leg39']);
        $this->set_leg40($res[0]['leg40']);
        $this->set_leg41($res[0]['leg41']);
        $this->set_leg42($res[0]['leg42']);
        $this->set_leg43($res[0]['leg43']);
        $this->set_leg44($res[0]['leg44']);
        $this->set_leg45($res[0]['leg45']);
        $this->set_leg46($res[0]['leg46']);
        $this->set_leg47($res[0]['leg47']);
        $this->set_leg48($res[0]['leg48']);
        $this->set_leg49($res[0]['leg49']);
        $this->set_leg50($res[0]['leg50']);
    }

    /**
     * Retornar todos os dados da Tradução. O objeto já deve ter sido carregado.
     *
     * @author Ricardo Ribeiro Assink
     * @return Array Array contendo todos os dados da sessão carregada
     * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Traducao.class.php");
     *
     *  $objeto = new Traducao();
     *  $objeto->loadTraducao(2001,"PT");
     *  print_r(get_all_dados());
     *
     * ?>
     * </code>
     *
     */
    public function get_all_dados() {
        $classe = new ReflectionClass($this);
        $props = $classe->getProperties();
        $props_arr = array();
        foreach ($props as $prop) {
            $f = $prop->getName();
            // pra nao voltar a conexao
            if ($f != "conexao") {
                $exec = '$valor = $this->get_' . $f . '();';
                eval($exec);
                $props_arr[$f] = $valor;
            }
        }
        return $props_arr;
    }

    /**
     * @ignore
     */
    public function get_id_modelo() {
        return $this->id_modelo;
    }

    /**
     * @ignore
     */
    public function set_id_modelo($id_modelo) {
        $this->id_modelo = $id_modelo;
    }

    /**
     * @ignore
     */
    public function get_id_arquivo() {
        return $this->id_arquivo;
    }

    /**
     * @ignore
     */
    public function set_id_arquivo($id_arquivo) {
        $this->id_arquivo = $id_arquivo;
    }

    /**
     * @ignore
     */
    public function get_lingua() {
        return $this->lingua;
    }

    /**
     * @ignore
     */
    public function set_lingua($lingua) {
        $this->lingua = $lingua;
    }

    /**
     * @ignore
     */
    public function get_nome_arquivo() {
        return $this->nome_arquivo;
    }

    /**
     * @ignore
     */
    public function set_nome_arquivo($nome_arquivo) {
        $this->nome_arquivo = $nome_arquivo;
    }

    /**
     * @ignore
     */
    public function get_titulo_formulario01() {
        return $this->titulo_formulario01;
    }

    /**
     * @ignore
     */
    public function set_titulo_formulario01($titulo_formulario01) {
        $this->titulo_formulario01 = $titulo_formulario01;
    }

    /**
     * @ignore
     */
    public function get_titulo_formulario02() {
        return $this->titulo_formulario02;
    }

    /**
     * @ignore
     */
    public function set_titulo_formulario02($titulo_formulario02) {
        $this->titulo_formulario02 = $titulo_formulario02;
    }

    /**
     * @ignore
     */
    public function get_titulo_formulario03() {
        return $this->titulo_formulario03;
    }

    /**
     * @ignore
     */
    public function set_titulo_formulario03($titulo_formulario03) {
        $this->titulo_formulario03 = $titulo_formulario03;
    }

    /**
     * @ignore
     */
    public function get_titulo_formulario04() {
        return $this->titulo_formulario04;
    }

    /**
     * @ignore
     */
    public function set_titulo_formulario04($titulo_formulario04) {
        $this->titulo_formulario04 = $titulo_formulario04;
    }

    /**
     * @ignore
     */
    public function get_titulo_formulario05() {
        return $this->titulo_formulario05;
    }

    /**
     * @ignore
     */
    public function set_titulo_formulario05($titulo_formulario05) {
        $this->titulo_formulario05 = $titulo_formulario05;
    }

    /**
     * @ignore
     */
    public function get_titulo_formulario06() {
        return $this->titulo_formulario06;
    }

    /**
     * @ignore
     */
    public function set_titulo_formulario06($titulo_formulario06) {
        $this->titulo_formulario06 = $titulo_formulario06;
    }

    /**
     * @ignore
     */
    public function get_titulo_formulario07() {
        return $this->titulo_formulario07;
    }

    /**
     * @ignore
     */
    public function set_titulo_formulario07($titulo_formulario07) {
        $this->titulo_formulario07 = $titulo_formulario07;
    }

    /**
     * @ignore
     */
    public function get_titulo_formulario08() {
        return $this->titulo_formulario08;
    }

    /**
     * @ignore
     */
    public function set_titulo_formulario08($titulo_formulario08) {
        $this->titulo_formulario08 = $titulo_formulario08;
    }

    /**
     * @ignore
     */
    public function get_titulo_formulario09() {
        return $this->titulo_formulario09;
    }

    /**
     * @ignore
     */
    public function set_titulo_formulario09($titulo_formulario09) {
        $this->titulo_formulario09 = $titulo_formulario09;
    }

    /**
     * @ignore
     */
    public function get_titulo_formulario10() {
        return $this->titulo_formulario10;
    }

    /**
     * @ignore
     */
    public function set_titulo_formulario10($titulo_formulario10) {
        $this->titulo_formulario10 = $titulo_formulario10;
    }

    /**
     * @ignore
     */
    public function get_leg01() {
        return $this->leg01;
    }

    /**
     * @ignore
     */
    public function set_leg01($leg01) {
        $this->leg01 = $leg01;
    }

    /**
     * @ignore
     */
    public function get_leg02() {
        return $this->leg02;
    }

    /**
     * @ignore
     */
    public function set_leg02($leg02) {
        $this->leg02 = $leg02;
    }

    /**
     * @ignore
     */
    public function get_leg03() {
        return $this->leg03;
    }

    /**
     * @ignore
     */
    public function set_leg03($leg03) {
        $this->leg03 = $leg03;
    }

    /**
     * @ignore
     */
    public function get_leg04() {
        return $this->leg04;
    }

    /**
     * @ignore
     */
    public function set_leg04($leg04) {
        $this->leg04 = $leg04;
    }

    /**
     * @ignore
     */
    public function get_leg05() {
        return $this->leg05;
    }

    /**
     * @ignore
     */
    public function set_leg05($leg05) {
        $this->leg05 = $leg05;
    }

    /**
     * @ignore
     */
    public function get_leg06() {
        return $this->leg06;
    }

    /**
     * @ignore
     */
    public function set_leg06($leg06) {
        $this->leg06 = $leg06;
    }

    /**
     * @ignore
     */
    public function get_leg07() {
        return $this->leg07;
    }

    /**
     * @ignore
     */
    public function set_leg07($leg07) {
        $this->leg07 = $leg07;
    }

    /**
     * @ignore
     */
    public function get_leg08() {
        return $this->leg08;
    }

    /**
     * @ignore
     */
    public function set_leg08($leg08) {
        $this->leg08 = $leg08;
    }

    /**
     * @ignore
     */
    public function get_leg09() {
        return $this->leg09;
    }

    /**
     * @ignore
     */
    public function set_leg09($leg09) {
        $this->leg09 = $leg09;
    }

    /**
     * @ignore
     */
    public function get_leg10() {
        return $this->leg10;
    }

    /**
     * @ignore
     */
    public function set_leg10($leg10) {
        $this->leg10 = $leg10;
    }

    /**
     * @ignore
     */
    public function get_leg11() {
        return $this->leg11;
    }

    /**
     * @ignore
     */
    public function set_leg11($leg11) {
        $this->leg11 = $leg11;
    }

    /**
     * @ignore
     */
    public function get_leg12() {
        return $this->leg12;
    }

    /**
     * @ignore
     */
    public function set_leg12($leg12) {
        $this->leg12 = $leg12;
    }

    /**
     * @ignore
     */
    public function get_leg13() {
        return $this->leg13;
    }

    /**
     * @ignore
     */
    public function set_leg13($leg13) {
        $this->leg13 = $leg13;
    }

    /**
     * @ignore
     */
    public function get_leg14() {
        return $this->leg14;
    }

    /**
     * @ignore
     */
    public function set_leg14($leg14) {
        $this->leg14 = $leg14;
    }

    /**
     * @ignore
     */
    public function get_leg15() {
        return $this->leg15;
    }

    /**
     * @ignore
     */
    public function set_leg15($leg15) {
        $this->leg15 = $leg15;
    }

    /**
     * @ignore
     */
    public function get_leg16() {
        return $this->leg16;
    }

    /**
     * @ignore
     */
    public function set_leg16($leg16) {
        $this->leg16 = $leg16;
    }

    /**
     * @ignore
     */
    public function get_leg17() {
        return $this->leg17;
    }

    /**
     * @ignore
     */
    public function set_leg17($leg17) {
        $this->leg17 = $leg17;
    }

    /**
     * @ignore
     */
    public function get_leg18() {
        return $this->leg18;
    }

    /**
     * @ignore
     */
    public function set_leg18($leg18) {
        $this->leg18 = $leg18;
    }

    /**
     * @ignore
     */
    public function get_leg19() {
        return $this->leg19;
    }

    /**
     * @ignore
     */
    public function set_leg19($leg19) {
        $this->leg19 = $leg19;
    }

    /**
     * @ignore
     */
    public function get_leg20() {
        return $this->leg20;
    }

    /**
     * @ignore
     */
    public function set_leg20($leg20) {
        $this->leg20 = $leg20;
    }

    /**
     * @ignore
     */
    public function get_leg21() {
        return $this->leg21;
    }

    /**
     * @ignore
     */
    public function set_leg21($leg21) {
        $this->leg21 = $leg21;
    }

    /**
     * @ignore
     */
    public function get_leg22() {
        return $this->leg22;
    }

    /**
     * @ignore
     */
    public function set_leg22($leg22) {
        $this->leg22 = $leg22;
    }

    /**
     * @ignore
     */
    public function get_leg23() {
        return $this->leg23;
    }

    /**
     * @ignore
     */
    public function set_leg23($leg23) {
        $this->leg23 = $leg23;
    }

    /**
     * @ignore
     */
    public function get_leg24() {
        return $this->leg24;
    }

    /**
     * @ignore
     */
    public function set_leg24($leg24) {
        $this->leg24 = $leg24;
    }

    /**
     * @ignore
     */
    public function get_leg25() {
        return $this->leg25;
    }

    /**
     * @ignore
     */
    public function set_leg25($leg25) {
        $this->leg25 = $leg25;
    }

    /**
     * @ignore
     */
    public function get_leg26() {
        return $this->leg26;
    }

    /**
     * @ignore
     */
    public function set_leg26($leg26) {
        $this->leg26 = $leg26;
    }

    /**
     * @ignore
     */
    public function get_leg27() {
        return $this->leg27;
    }

    /**
     * @ignore
     */
    public function set_leg27($leg27) {
        $this->leg27 = $leg27;
    }

    /**
     * @ignore
     */
    public function get_leg28() {
        return $this->leg28;
    }

    /**
     * @ignore
     */
    public function set_leg28($leg28) {
        $this->leg28 = $leg28;
    }

    /**
     * @ignore
     */
    public function get_leg29() {
        return $this->leg29;
    }

    /**
     * @ignore
     */
    public function set_leg29($leg29) {
        $this->leg29 = $leg29;
    }

    /**
     * @ignore
     */
    public function get_leg30() {
        return $this->leg30;
    }

    /**
     * @ignore
     */
    public function set_leg30($leg30) {
        $this->leg30 = $leg30;
    }

    /**
     * @ignore
     */
    public function get_leg31() {
        return $this->leg31;
    }

    /**
     * @ignore
     */
    public function set_leg31($leg31) {
        $this->leg31 = $leg31;
    }

    /**
     * @ignore
     */
    public function get_leg32() {
        return $this->leg32;
    }

    /**
     * @ignore
     */
    public function set_leg32($leg32) {
        $this->leg32 = $leg32;
    }

    /**
     * @ignore
     */
    public function get_leg33() {
        return $this->leg33;
    }

    /**
     * @ignore
     */
    public function set_leg33($leg33) {
        $this->leg33 = $leg33;
    }

    /**
     * @ignore
     */
    public function get_leg34() {
        return $this->leg34;
    }

    /**
     * @ignore
     */
    public function set_leg34($leg34) {
        $this->leg34 = $leg34;
    }

    /**
     * @ignore
     */
    public function get_leg35() {
        return $this->leg35;
    }

    /**
     * @ignore
     */
    public function set_leg35($leg35) {
        $this->leg35 = $leg35;
    }

    /**
     * @ignore
     */
    public function get_leg36() {
        return $this->leg36;
    }

    /**
     * @ignore
     */
    public function set_leg36($leg36) {
        $this->leg36 = $leg36;
    }

    /**
     * @ignore
     */
    public function get_leg37() {
        return $this->leg37;
    }

    /**
     * @ignore
     */
    public function set_leg37($leg37) {
        $this->leg37 = $leg37;
    }

    /**
     * @ignore
     */
    public function get_leg38() {
        return $this->leg38;
    }

    /**
     * @ignore
     */
    public function set_leg38($leg38) {
        $this->leg38 = $leg38;
    }

    /**
     * @ignore
     */
    public function get_leg39() {
        return $this->leg39;
    }

    /**
     * @ignore
     */
    public function set_leg39($leg39) {
        $this->leg39 = $leg39;
    }

    /**
     * @ignore
     */
    public function get_leg40() {
        return $this->leg40;
    }

    /**
     * @ignore
     */
    public function set_leg40($leg40) {
        $this->leg40 = $leg40;
    }

    /**
     * @ignore
     */
    public function get_leg41() {
        return $this->leg41;
    }

    /**
     * @ignore
     */
    public function set_leg41($leg41) {
        $this->leg41 = $leg41;
    }

    /**
     * @ignore
     */
    public function get_leg42() {
        return $this->leg42;
    }

    /**
     * @ignore
     */
    public function set_leg42($leg42) {
        $this->leg42 = $leg42;
    }

    /**
     * @ignore
     */
    public function get_leg43() {
        return $this->leg43;
    }

    /**
     * @ignore
     */
    public function set_leg43($leg43) {
        $this->leg43 = $leg43;
    }

    /**
     * @ignore
     */
    public function get_leg44() {
        return $this->leg44;
    }

    /**
     * @ignore
     */
    public function set_leg44($leg44) {
        $this->leg44 = $leg44;
    }

    /**
     * @ignore
     */
    public function get_leg45() {
        return $this->leg45;
    }

    /**
     * @ignore
     */
    public function set_leg45($leg45) {
        $this->leg45 = $leg45;
    }

    /**
     * @ignore
     */
    public function get_leg46() {
        return $this->leg46;
    }

    /**
     * @ignore
     */
    public function set_leg46($leg46) {
        $this->leg46 = $leg46;
    }

    /**
     * @ignore
     */
    public function get_leg47() {
        return $this->leg47;
    }

    /**
     * @ignore
     */
    public function set_leg47($leg47) {
        $this->leg47 = $leg47;
    }

    /**
     * @ignore
     */
    public function get_leg48() {
        return $this->leg48;
    }

    /**
     * @ignore
     */
    public function set_leg48($leg48) {
        $this->leg48 = $leg48;
    }

    /**
     * @ignore
     */
    public function get_leg49() {
        return $this->leg49;
    }

    /**
     * @ignore
     */
    public function set_leg49($leg49) {
        $this->leg49 = $leg49;
    }

    /**
     * @ignore
     */
    public function get_leg50() {
        return $this->leg50;
    }

    /**
     * @ignore
     */
    public function set_leg50($leg50) {
        $this->leg50 = $leg50;
    }

}

//TESTES
/*
  $obj = new Traducao();
  $obj->loadTraducao(2001, "PT");
  $traducao = $obj->get_all_dados();

  foreach($traducao as $chave => $valor){

  echo "$chave : $valor \n";

  }

  echo "lklaksdlkasjd: ". $obj->get_titulo_formulario01();
 */
?>
