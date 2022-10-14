<?php

/**
 * Operações e Formatação de Datas
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
// se precisar de calculo de datas consultar funcao date PHP


class Data {

    public $seg;
    public $min;
    public $hora;
    public $dia;
    public $mes;
    public $ano;
    public $ts;

    /**
     * Carrega a data e hora atual na instanciação.
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *      $this->carregaDataAtual();
     *   }
     *
     * </code>
     *
     */
    public function __construct() {
        $this->carregaDataAtual();
    }

    /**
     * Carrega a data e hora atual no objeto.
     * 
     * @author Ricardo Ribeiro Assink 
     * @return void 
     * @Exemplo 
     * <code> 
     * 
     * <?php 
     * 
     *    private function carregaDataAtual() {
     *       $agora = getdate();
     *       $this->set_seg($agora["seconds"]);
     *       $this->set_min($agora["minutes"]);
     *       $this->set_hora($agora["hours"]);
     *       $this->set_dia($agora["mday"]);
     *       $this->set_mes($agora["mon"]);
     *       $this->set_ano($agora["year"]);
     *       $this->set_ts($agora["0"]);
     *   }
     * 
     * ?> 
     * </code> 
     * 
     */
    private function carregaDataAtual() {
        date_default_timezone_set("America/Sao_Paulo");
        $agora = getdate();
        $this->set_seg($agora["seconds"]);
        $this->set_min($agora["minutes"]);
        $this->set_hora($agora["hours"]);
        $this->set_dia($agora["mday"]);
        $this->set_mes($agora["mon"]);
        $this->set_ano($agora["year"]);
        $this->set_ts($agora["0"]);
    }

    /**
     * Carrega a data vinda do banco de dados no objeto.
     *
     * @author Ricardo Ribeiro Assink
     * @param Datetime $data_bd Data e Hora vinda do banco de dados
     * @return void
     * @Exemplo
     * <code>
     *
     * <?php
     *
     *     private function carregaDataBD($data_bd){
     *
     *       $time  = strtotime($data_bd);
     *
     *       $se = date('s',$time);
     *       $mi = date('i',$time);
     *       $ho = date('H',$time);
     *       $di = date('d',$time);
     *       $me = date('m',$time);
     *       $an = date('Y',$time);
     *
     *       $this->set_seg($se);
     *       $this->set_min($mi);
     *       $this->set_hora($ho);
     *       $this->set_dia($di);
     *       $this->set_mes($me);
     *       $this->set_ano($an);
     *
     *       $this->set_ts($time);
     *
     *   }
     *
     * ?>
     * </code>
     *
     */
    private function carregaDataBD($data_bd) {

        $time = strtotime($data_bd);

        $se = date('s', $time);
        $mi = date('i', $time);
        $ho = date('H', $time);
        $di = date('d', $time);
        $me = date('m', $time);
        $an = date('Y', $time);

        $this->set_seg($se);
        $this->set_min($mi);
        $this->set_hora($ho);
        $this->set_dia($di);
        $this->set_mes($me);
        $this->set_ano($an);

        $this->set_ts($time);
    }

    /**
     * Carrega a data vinda de componente de calendario.
     *
     * @author Ricardo Ribeiro Assink
     * @param Datetime $data_bd Data e Hora vinda do calendario
     * @return void
     *
     */
    private function carregaDataCalendarInicio($data) {

        $di = substr($data, 0, 2);
        $me = substr($data, 3, 2);
        $an = substr($data, 6, 4);

        $time = mktime("00", "00", "01", $me, $di, $an);
        $this->set_ts($time);
    }

    /*
     *
     * 
     */

    private function carregaDataCalendarHora($data) {

        $di = substr($data, 0, 2);
        $me = substr($data, 3, 2);
        $an = substr($data, 6, 4);

        date_default_timezone_set("America/Sao_Paulo");
        $agora = getdate();

        $s = $this->get_seg($agora["seconds"]);
        $m = $this->get_min($agora["minutes"]);
        $h = $this->get_hora($agora["hours"]);

        $time = mktime($h, $m, $s, $me, $di, $an);
        $this->set_ts($time);
    }

    /**
     * Carrega a data vinda de componente de calendario.
     *
     * @author Ricardo Ribeiro Assink
     * @param Datetime $data_bd Data e Hora vinda do calendario
     * @return void
     *
     */
    private function carregaDataCalendarFim($data) {

        $di = substr($data, 0, 2);
        $me = substr($data, 3, 2);
        $an = substr($data, 6, 4);

        $time = mktime("23", "59", "59", $me, $di, $an);

        $this->set_ts($time);
    }

    /**
     *
     * Formata uma data.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $tipo_origem Enviar NOW para pegar a data atual formatada ou BD para formatar a data enviada
     * @param String $data Enviar campo vazio "" quando NOW é utilizado e data vinda do banco de dados quando utilizado BD
     * @param String $tipo_destino Enviar o formato que deseja receber: BD ('Y-m-d H:i:s'), PADRAO (d/m/Y H:i), COMPLETO (d/m/Y H:i:s), DMA (d/m/Y),HMS (H:i:s),HM(H:i)
     * @return String Data Formatada
     * @Exemplo
     * <code>
     *
     * <?php
     *
     *  $data_formatada = $objeto->get_dataFormat("BD","2009-12-25 15:22:12","PADRAO");
     *  echo $data_formatada;
     *
     * // Imprime 25/12/2009 15:22
     *
     * ?>
     * </code>
     *
     */
    public function get_dataFormat($tipo_origem, $data, $tipo_destino) {

        if ($tipo_origem == "BD") {
            $this->carregaDataBD($data);
        }

        if ($tipo_origem == "NOW") {
            $this->carregaDataAtual();
        }

        if ($tipo_origem == "CALENDARINICIO") {
            $this->carregaDataCalendarInicio($data);
        }

        if ($tipo_origem == "CALENDARFIM") {
            $this->carregaDataCalendarFim($data);
        }

        if ($tipo_origem == "CALENDARHORA") {
            $this->carregaDataCalendarHora($data);
        }

        switch ($tipo_destino) {

            case 'BD': {
                    $tms = $this->get_ts();
                    $retorno = date('Y-m-d H:i:s', $tms);
                    break;
                }

            case 'PADRAO': {
                    $tms = $this->get_ts();
                    $retorno = date('d/m/Y H:i', $tms);
                    break;
                }

            case 'COMPLETO': {
                    $tms = $this->get_ts();
                    $retorno = date('d/m/Y H:i:s', $tms);
                    break;
                }

            case 'DMA': {
                    $tms = $this->get_ts();
                    $retorno = date('d/m/Y', $tms);
                    break;
                }
            case 'AMD': {
                    $tms = $this->get_ts();
                    $retorno = date('Y-m-d', $tms);
                    break;
                }

            case 'HMS': {
                    $tms = $this->get_ts();
                    $retorno = date('H:i:s', $tms);
                    break;
                }

            case 'HM': {
                    $tms = $this->get_ts();
                    $retorno = date('H:i', $tms);
                    break;
                }

            case 'ARTIGO': {
                    $tms = $this->get_ts();
                    $retorno = date('YmdHis', $tms);
                    break;
                }
            case 'LUMA': {
                    $tms = $this->get_ts();
                    $retorno = date('H:i | d/m/Y', $tms);
                    break;
                }

            case 'TIMESTAMP': {
                    $retorno = $this->get_ts();
                    break;
                }
            case 'ANO': {
                    $tms = $this->get_ts();
                    $retorno = date('Y', $tms);
                    break;
                }
            case 'MA': {
                    $tms = $this->get_ts();
                    $retorno = date('m/Y', $tms);
                    break;
                }
        }

        return $retorno;
    }

    /**
     * @ignore
     */
    public function get_seg() {
        return $this->seg;
    }

    /**
     * @ignore
     */
    public function set_seg($seg) {
        if ($seg < 10 and strlen($seg) < 2) {
            $seg = "0$seg";
        }
        $this->seg = $seg;
    }

    /**
     * @ignore
     */
    public function get_min() {
        return $this->min;
    }

    /**
     * @ignore
     */
    public function set_min($min) {
        if ($min < 10 and strlen($min) < 2) {
            $min = "0$min";
        }
        $this->min = $min;
    }

    /**
     * @ignore
     */
    public function get_hora() {
        return $this->hora;
    }

    /**
     * @ignore
     */
    public function set_hora($hora) {
        if ($hora < 10 and strlen($hora) < 2) {
            $hora = "0$hora";
        }
        $this->hora = $hora;
    }

    /**
     * @ignore
     */
    public function get_dia() {
        return $this->dia;
    }

    /**
     * @ignore
     */
    public function set_dia($dia) {
        if ($dia < 10 and strlen($dia) < 2) {
            $dia = "0$dia";
        }
        $this->dia = $dia;
    }

    /**
     * @ignore
     */
    public function get_mes() {
        return $this->mes;
    }

    /**
     * @ignore
     */
    public function set_mes($mes) {
        if ($mes < 10 and strlen($mes) < 2) {
            $mes = "0$mes";
        }
        $this->mes = $mes;
    }

    /**
     * @ignore
     */
    public function get_ano() {
        return $this->ano;
    }

    /**
     * @ignore
     */
    public function set_ano($ano) {
        $this->ano = $ano;
    }

    /**
     * @ignore
     */
    public function get_ts() {
        return $this->ts;
    }

    /**
     * @ignore
     */
    public function set_ts($ts) {
        $this->ts = $ts;
    }

    public function get_mes_literal($mes = 'atual') {

        if ($mesm == 'atual') {
            $mes = $this->mes;
        }
        switch ($mes) {
            case 1:
                return 'Janeiro';
            case 2:
                return 'Fevereiro';
            case 3:
                return 'Março';
            case 4:
                return 'Abril';
            case 5:
                return 'Maio';
            case 6:
                return 'Junho';
            case 7:
                return 'Julho';
            case 8:
                return 'Agosto';
            case 9:
                return 'Setembro';
            case 10:
                return 'Outubro';
            case 11:
                return 'Novembro';
            case 12:
                return 'Dezembro';
        }
    }

}

/*
  //TESTES

  //$tipo_origem   = "NOW";
  $tipo_origem   = "BD";

  $data          = "2009-09-08 07:08:01"; // simula data do banco
  //$data          = ""; // simula agora

  //$tipo_destino  = "BD";
  $tipo_destino  = "PADRAO";
  //$tipo_destino  = "COMPLETO";
  //$tipo_destino  = "DMA";
  //$tipo_destino  = "HMS";
  //$tipo_destino  = "HM";

  $obj = new Data();
  echo $obj->get_dataFormat($tipo_origem,$data,$tipo_destino);
 */
?>
