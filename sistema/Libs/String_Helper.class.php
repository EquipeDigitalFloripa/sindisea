<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of String_Hekper
 *
 * @author Marcela
 */
class String_Helper {

    function remove_caracteres($string) {
        // Remove acentos sobre a string
        $string = preg_replace("[ÁÀÂÃÄ]", "A", $string);
        $string = preg_replace("[áàâãäª]", "a", $string);
        $string = preg_replace("[ÉÈÊË]", "E", $string);
        $string = preg_replace("[éèêë]", "e", $string);
        $string = preg_replace("[ÍÌÎÏ]", "I", $string);
        $string = preg_replace("[íìîï]", "i", $string);
        $string = preg_replace("[ÓÒÔÕÖ]", "O", $string);
        $string = preg_replace("[óòôõöº]", "o", $string);
        $string = preg_replace("[ÚÙÛÜ]", "U", $string);
        $string = preg_replace("[úùûü]", "u", $string);
        $string = str_replace("Ç", "C", $string);
        $string = str_replace("ç", "c", $string);

        // Remove acentos
        $string = str_replace("´", "", $string);
        $string = str_replace("`", "", $string);
        $string = str_replace("~", "", $string);
        $string = str_replace("^", "", $string);
        $string = str_replace("¨", "", $string);

        $string = preg_replace("/[^\w\.-]+/", "_", $string);
        $string = trim(strtolower($string));

        return $string;
    }

    function formata_codigo($string) {
        $string = $this->remove_caracteres($string);
        $string = str_replace("_", "", $string);
        $string = str_replace("-", "", $string);
        $string = strtoupper($string);
        return $string;
    }

    function abrevia($string, $tam_str = 52, $carac_fim = " ...") {
        if (strlen($string) > $tam_str) {
            $string = htmlspecialchars(substr($string, 0, $tam_str));
            $string = "$$string$carac_fim";
        } else {
            $string = htmlspecialchars($string);
        }
        return $string;
    }
    
    /**
     * Cria um link interno
     * 
     * @author Jean Barcellos <jean@equipedigital.com>
     * 
     * @param string $co Controlador Encriptado
     * @param string $ac Ação/Método Encriptado
     * @param array $parametros Array com parâmetros adicionais na query string
     * @return string Link pronto para ser usado
     */
    function criaLinkInterno($post_request, $co, $ac, array $parametros = array())
    {        
        $link = array();
        $link['id_sessao'] = $post_request['id_sessao'];
        $link['idioma'] = $post_request['idioma'];
        $link['co'] = $co;
        $link['ac'] = $ac;

        foreach ($parametros as $chave => $valor) {
            if (!in_array($chave, array('id_sessao', 'idioma', 'co', 'ac'))) {
                $link[$chave] = $valor;
            }
        }

        return "sys.php?" . http_build_query($link);
    }
    
    /**
     * @author Marcio Figueredo
     * @param $number - número do telefone a ser formatado
     *      
     * @return string numero formatado
     */
    public function phone_format($number) {
        if ($number != "") {
            $number = "(" . substr($number, 0, 2) . ") " . substr($number, 2, -4) . "-" . substr($number, -4);
        }
        return $number;
    }

}

?>
