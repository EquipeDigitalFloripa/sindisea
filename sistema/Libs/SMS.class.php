<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");
$post_request = array_merge($_POST, $_REQUEST);
/*
 * 
 * Configura a aplicação de envio de SMS
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2016-2019, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 * 
 * @Data_Criacao 04/05/2016
 * 
 */

class SMS {

    public $username = "sindiasea";
    public $password = "Mailsindi2018";
    public $codepais = "55";
//    public $username = "sindiasea";
//    public $password = "Mailsindi2018";
//    public $codepais = "55";
    private $conexao;

    /**
     * @author Marcio Figueredo
     * Construtor da class SMS
     */
    public function __construct() {
        $config = new Config();
        $factory = $config->get_banco();
        $banco = new $factory();
        $this->conexao = $banco->getInstance();
    }

    /**
     * @author Marcio Figueredo
     * Formata o Texto da SMS Unicode
     * Texto que será enviado.
     * Não deve ter caracter especial. Ex: Ç, à, á, é, ó
     * Limite de caracteres de 160
     */
    public function EncodeText($string) {

        $str = strlen($string) > 160 ? substr($string, 0, 160) : $string;
        $str = preg_replace("/[^a-zA-Z0-9,.!\/\:]/", " ", strtr($str, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC"));

        return $str;
    }

    /**
     * @author Marcio Figueredo
     * O npumero deve ter o formato internacional máximo 15 digitos
     * Código do país 2 dígitos
     * Código de área 2 dígitos
     * Número do telefone
     */
    public function PhoneNumbersFormat($number) {

        $erro = strlen($number) > 15 ? TRUE : FALSE;

        $num = preg_replace("/[^0-9]/", "", $number);

        return $erro == FALSE ? $this->codepais . $num : $erro;
    }

    /**
     * @author Marcio Figueredo
     * Envia a SMS
     * To = é o destino
     * $text - é o texto da SMS
     */
    public function Send($to, $text) {

        $numero = $this->PhoneNumbersFormat($to);

        if ($numero != FALSE) {

            $postUrl = "https://www.facilitamovel.com.br/api/simpleSend.ft?";

            $texto = $this->EncodeText($text);

            $postDataJson = array(
                "user" => $this->username,
                "password" => $this->password,
                "destinatario" => $numero,
                "msg" => $texto
            );

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            if ($httpCode >= 200 && $httpCode < 300) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    /**
     * @author Marcio Figueredo
     * Retorna o saldo da conta
     */
    public function AccountBalance() {

        $postUrl = "https://www.facilitamovel.com.br/api/checkCredit.ft?";
//        $postUrl = "https://www.facilitamovel.com.br/api/checkCreditExpires.ft?";

        $postDataJson = array(
            "user" => $this->username,
            "password" => $this->password
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $postUrl);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return $response;
        } else {
            return FALSE;
        }
    }

}
