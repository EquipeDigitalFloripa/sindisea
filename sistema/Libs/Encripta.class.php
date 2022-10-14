<?php

/**
 * Biblioteca de Encriptação e Autenticação
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
class Encripta {

    /**
     * @ignore
     */
    private $chave_de_sessao;

    /**
     * @ignore
     */
    public function __construct() {
        // seta a semente
        $this->chave_de_sessao = '123deoliVeira4@@';
    }

    /**
     * @ignore
     */
    // http://www.ietf.org/rfc/rfc2104.txt
    public function hmac($key, $data, $hash = 'md5', $blocksize = 64) {
        if (strlen($key) > $blocksize) {
            $key = pack('H*', $hash($key));
        }
        $key = str_pad($key, $blocksize, chr(0));
        $ipad = str_repeat(chr(0x36), $blocksize);
        $opad = str_repeat(chr(0x5c), $blocksize);
        return $hash(($key ^ $opad) . pack('H*', $hash(($key ^ $ipad) . $data)));
    }

    /**
     * @ignore
     */
    public function make_seed() {
        list($usec, $sec) = explode(' ', microtime());
        return (float) $sec + ((float) $usec * 100000);
    }

    /**
     * @ignore
     */
    public function pw_encode($password) {
        mt_srand($this->make_seed());
        $seed = substr('00' . dechex(mt_rand()), -3) .
                substr('00' . dechex(mt_rand()), -3) .
                substr('0' . dechex(mt_rand()), -2);
        return $this->hmac($seed, $password, 'md5', 64) . $seed;
    }

    /**
     * @ignore
     */
    public function pw_check($password, $stored_value) {
        $seed = substr($stored_value, 32, 8);
        return $this->hmac($seed, $password, 'md5', 64) . $seed == $stored_value;
    }

    /**
     * @ignore
     */
    public function get_rnd_iv($iv_len) {
        $iv = '';
        while ($iv_len-- > 0) {
            $iv .= chr(mt_rand() & 0xff);
        }
        return $iv;
    }

    /**
     * @ignore
     */
    public function md5_encrypt($plain_text, $iv_len = 16) {
        $password = $this->chave_de_sessao;

        $plain_text .= "\x13";
        $n = strlen($plain_text);
        if ($n % 16)
            $plain_text .= str_repeat("\0", 16 - ($n % 16));
        $i = 0;
        $enc_text = $this->get_rnd_iv($iv_len);
        $iv = substr($password ^ $enc_text, 0, 512);
        while ($i < $n) {
            $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
            $enc_text .= $block;
            $iv = substr($block . $iv, 0, 512) ^ $password;
            $i += 16;
        }
        $dado = base64_encode($enc_text);
        $dado = str_replace('+', '-', $dado);
        $dado = str_replace('/', '_', $dado);
        return $dado;
    }

    /**
     * @ignore
     */
    public function md5_decrypt($enc_text, $iv_len = 16) {
        $password = $this->chave_de_sessao;

        $enc_text = str_replace('-', '+', $enc_text);
        $enc_text = str_replace('_', '/', $enc_text);

        $enc_text = base64_decode($enc_text);
        $n = strlen($enc_text);
        $i = $iv_len;
        $plain_text = '';
        $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
        while ($i < $n) {
            $block = substr($enc_text, $i, 16);
            $plain_text .= $block ^ pack('H*', md5($iv));
            $iv = substr($block . $iv, 0, 512) ^ $password;
            $i += 16;
        }
        return preg_replace('/\\x13\\x00*$/', '', $plain_text);
    }

}

/*
  // Teste
  $obj = new Encripta();
  $password = 'tecnico';
  $encoded  = $obj->pw_encode($password);
  $result  = $obj->pw_check ($password, $encoded) ? 'true' : 'false';
  $tam = strlen($encoded);
  echo<<<END
  password: $password  <br>
  encoded : $encoded   <br>
  encoded :  $tam  <br>
  rsult  : $result <br>
  END;
 */


/*
  _PtXHB8hS2cCU6JBYMiP81jZzYnjVN2jM1T9jGvx3_U=
  kYax1Km9lVJbFZRl-2CykkPgz1R7H0G64m3pWMfXsG4=
  -7QHPUHC8t6_rWPdmG5SI6UlCjhbAlu6Lm5Gka5iuH8=
  kC0ho882PsWm0JUkJooeGz6saoDMMFiST9MisYJ1NoI=
 */



/*
  //TESTES

  $obj = new Encripta();

  $id_sessao = "1";
  $id_sessao = $obj->md5_encrypt($id_sessao);
  $id_sessao2 = $obj->md5_decrypt($id_sessao);
  $tam = strlen($id_sessao);


  echo "
  <br>encriptado: $id_sessao
  <br>dencriptado: $id_sessao2
  <br>tamanho: $tam
  <br> ------------------------ \n";

  $password = 'tecnico';
  $encoded  = $obj->pw_encode($password);
  $result  = $obj->pw_check ($password, $encoded) ? 'true' : 'false';
  $tam = strlen($encoded);

  echo<<<END
  <br>password: $password
  <br>encoded : $encoded
  <br>encoded :  $tam
  <br>rsult  : $result
  END;
 */
?>
