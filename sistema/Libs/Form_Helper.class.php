<?php

/**
 * Classe de Ajuda para escrever itens de forms
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 01/10/2009
 * @Ultima_Modif 01/10/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package Libs
 *
 */
class Form_Helper {

    private $resetcampos = Array();
    private $ajax = Array();

    /**
     * @ignore
     */
    public function get_ajax() {
        return $this->ajax;
    }

    /**
     * @ignore
     */
    public function set_ajax($ajax) {
        $this->ajax = $ajax;
    }

    /**
     * @ignore
     */
    public function get_resetcampos() {
        return $this->resetcampos;
    }

    /**
     * @ignore
     */
    public function set_resetcampos($resetcampos) {
        $this->resetcampos = $resetcampos;
    }

    /**
     * @ignore
     */
    public function comment($texto) {
        return "<span class=\"texto_azul\">$texto</span>";
    }

    /**
     * Formata texto para formulários
     * @author Ricardo Ribeiro Assink
     * @param String $texto Texto que será formatado
     * @param Boolean $obrig true|false Determina se deve ou não colocar * antes do texto, tem false como default
     * @param String $align Alinhamento, tem left como default
     * @return String Texto formatado  * @Exemplo
     * <code>
     *
     * <?php
     *
     * require_once("Form_Helper.class.php");
     *
     *  $form = new Form_Helper();
     *  echo $form->texto("Nome",true);
     *
     *  // escreve no HTML
     *  // <div align="left" class="texto_leg_tabela"><span class="texto_azul">* </span> Nome </div>
     *
     * ?>
     * </code>
     *
     */
    public function texto($texto, $obrig = false, $align = "left", $bold = false) {

        $ret = "<div align=\"" . $align . "\" class=\"texto_leg_tabela\">";

        $ret .= "<ul type=\"square\" class=\"lista\"> <li>";

        if ($obrig) {
            $ret .= "<span class=\"texto_azul\">*</span> ";
        }

        if ($bold) {
            $b = "<span class=\"texto\"><b>";
            $b2 = "</b><span>";
        } else {
            $b = "";
            $b2 = "";
        }

        $ret .= " $b $texto $b2 </li></div></ul>";

        return $ret;
    }

    /**
     * Insere INPUT textfield
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $value Valor do campo, tem vazio como default
     * @param int $size Tamanho do campo, tem 40 como default
     * @param Boolean $comment true|false Comentário no topo do campo, tem false como default
     * @param String $texto_comment Texto do comentário no topo do campo, tem vazio como default
     * @param int $maxlength Número máximo de caracteres no campo, tem null como default
     * @param String $align Alinhamento, tem left como default
     * @return String Código HTML do INPUT
     *
     */
    public function textfield($name, $value = "", $size = 40, $comment = false, $texto_comment = "", $maxlength = null, $align = "left", $jscript = "", $style = "") {

        $comentario = ($comment) ? " <div style=\"width:100%; margin-top:4px;\"><span class=\"texto_azul\">" . $this->comment($texto_comment) . "</span></div>" : "";

        $maxlength = ($maxlength > 0) ? "maxlength=\"" . $maxlength . "\"" : "";

        return "<div style=\"$style\" align=\"" . $align . "\">
                    <input name=\"" . $name . "\" type=\"text\" id=\"" . $name . "\" value=\"" . $value . "\" class=\"textfields\" size=\"" . $size . "\" $maxlength $jscript/>
                    $comentario
                </div> \n";
    }

    public function textfield_login($name, $value = "", $size = 40, $comment = false, $texto_comment = "", $maxlength = null, $align = "left", $jscript = "", $style = "", $styleinput = "") {

        $comentario = ($comment) ? $this->comment($texto_comment) : "";

        $maxlength = ($maxlength > 0) ? "maxlength=\"" . $maxlength . "\"" : "";

        return "
                <div style=\"$style\" align=\"" . $align . "\" >
                    <input style=\"$styleinput\"  name=\"" . $name . "\" type=\"text\" onkeypress=\"javascript:submit_filtro(event,'')\" id=\"" . $name . "\" value=\"" . $value . "\"  class=\"textfields\" size=\"" . $size . "\" $maxlength $jscript required>
                                            <label class=\"label-login\">$comentario</label>
                                                 <span class=\"icon\"><i class=\"fa-user\" style=\" background : url(img/user.png) no-repeat center center;\"></i></span>
                                           
                </div> \n";
    }

    public function textfield_FILE($name, $value = "", $size = 40, $comment = false, $texto_comment = "", $maxlength = null, $align = "left") {

        if ($comment) {
            $comentario = $this->comment($texto_comment) . "<br>";
        }

        if ($maxlength > 0) {
            $maxlength = "maxlength=\"" . $maxlength . "\"";
        }

        return "
                <div align=\"" . $align . "\">
                $comentario
                    <input name=\"" . $name . "\" type=\"file\" id=\"" . $name . "\" value=\"" . $value . "\" class=\"textfields\" size=\"" . $size . "\" $maxlength />
                        
                </div> \n";
    }

    /**
     * Insere INPUT password
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $value Valor do campo, tem vazio como default
     * @param int $size Tamanho do campo, tem 40 como default
     * @param Boolean $comment true|false Comentário no topo do campo, tem false como default
     * @param String $texto_comment Texto do comentário no topo do campo, tem vazio como default
     * @param int $maxlength Número máximo de caracteres no campo, tem null como default
     * @param String $align Alinhamento, tem left como default
     * @return String Código HTML do INPUT
     *
     */
    public function password($name, $value = "", $size = 60, $comment = false, $texto_comment = "", $maxlength = null, $align = "left") {

        if ($comment) {
            $comentario = " <div style=\"width:100%; margin-top:4px;\"><span class=\"texto_azul\">" . $this->comment($texto_comment) . "</span></div>";
        }

        if ($maxlength > 0) {
            $maxlength = "maxlength=\"" . $maxlength . "\"";
        }

        return "
                <div align=\"" . $align . "\">
                    <input name=\"" . $name . "\" type=\"password\" id=\"" . $name . "\" value=\"" . $value . "\" class=\"textfields\" size=\"" . $size . "\" $maxlength />
                                        $comentario
                </div> \n";
    }

    public function password_login($name, $value = "", $size = 60, $comment = false, $texto_comment = "", $maxlength = null, $align = "left", $style = "", $styleinput = "") {

        if ($comment) {
            $comentario = $this->comment($texto_comment);
        }

        if ($maxlength > 0) {
            $maxlength = "maxlength=\"" . $maxlength . "\"";
        }

        return "
                <div style=\"$style\" align=\"" . $align . "\">
                    <input style=\"$styleinput\" name=\"" . $name . "\" type=\"password\" onkeypress=\"javascript:submit_filtro(event,'')\" id=\"" . $name . "\" value=\"" . $value . "\" class=\"textfields\" size=\"" . $size . "\" $maxlength required>
                                        <label class=\"label-login\">$comentario</label>
                                            <span class=\"icon\"><i class=\"fa-key\" style=\" background : url(img/chave.png) no-repeat center center\"></i></span>
                </div> \n";
    }

    /**
     * Insere Botão
     * @author Ricardo Ribeiro Assink
     * @param String $align Alinhamento, tem "center" como default
     * @param String $leg Legenda do Botão, tem "OK" como default
     * @param String $type submit|button Tipo do botão, tem "button" como default
     * @param String $onclick Chamda de javascript do click do botão, tem "false" como default
     * @param String $name Nome do campo, tem "botao" como default
     * @return String Código HTML do Botão
     *
     */
    public function button2($align = "center", $leg = "         OK         ", $type = "button", $link = "", $name = "botao", $style = "") {

        $ret_button = "<a href=\"" . $link . "\"><input type=\"" . $type . "\" name=\"" . $name . "\" value=\"" . $leg . "\" class=\"botao\" style=\"$style\" $onclick ></a>";
        return $ret_button;
    }

    public function button($align = "center", $leg = "         OK         ", $type = "button", $onclick = "validar()", $name = "botao", $style = "") {

        if ($type == "button") {
            $onclick = " onClick=\"" . $onclick . "\"";
        } else {
            $onclick = "";
        }
        $ret_button = "<input type=\"" . $type . "\" name=\"" . $name . "\" value=\"" . $leg . "\" class=\"botao\" style=\"$style\" $onclick >";
        return $ret_button;
    }

    /**
     * Insere Select
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $leg Legenda do Select
     * @param String $value Valor do item que deve ser selecionado por padrão, tem "vazio" como default
     * @param Array $dados Array com os itens para o select, tem "Array()" como default
     * @param String $align Alinhamento, tem "left" como default
     * @return String Código HTML do Select
     *
     */
    public function select($name, $leg, $value = "", $dados = Array(), $align = "left", $onchange = "", $disabled = "", $comment = false, $texto_comment = "", $style = "", $class = "") {

        $comentario = ($comment) ? " <div style=\"width:100%; margin-top:4px;\"><span class=\"texto_azul\">" . $this->comment($texto_comment) . "</span></div>" : "";

        $ch = ($onchange != "") ? " onChange=\"$onchange\" " : "";

        if ($align != "") {
            $al = "<div align=\"" . $align . "\">";
            $al2 = "</div>";
        } else {
            $al = $al2 = "";
        }
        $select = "$al
                    <select $disabled name=\"$name\" id=\"$name\" class=\"textfields $class\" $ch style=\"$style\">";
        
        if($leg != false){
                $select .= "<option value=\"0\">$leg</option>";
        }

        if (count($dados) > 0) {
            foreach ($dados as $chave => $valor) {

                if ($chave == $value) {
                    $select .= "<option value=\"$chave\" selected>$valor</option>";
                } else {
                    $select .= "<option value=\"$chave\">$valor</option>";
                }
            }
        }

        $select .= "</select>
                    $comentario
                    $al2                 
                ";

        return $select;
    }

    /**
     * Insere Select
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $leg Legenda do Select
     * @param String $value Valor do item que deve ser selecionado por padrão, tem "vazio" como default
     * @param Array $dados Array com os itens para o select, tem "Array()" como default
     * @param String $align Alinhamento, tem "left" como default
     * @return String Código HTML do Select
     *
     */
    public function select_multiple($name, $leg, $value = Array(), $dados = Array(), $comment = false, $texto_comment = "", $align = "left") {


        $comentario = ($comment) ? "<div style=\"width:100%; margin-top:4px;\"><span class=\"texto_azul\">" . $this->comment($texto_comment) . "</span></div>" : "";
        $opt = "";
        if (count($dados > 0)) {
            foreach ($dados as $chave => $valor) {

                $option = '<option value="' . $chave . '" style="cursor:grab;padding: 4px 0px;">' . $valor . '</option>';
                $i = 0;

                if (count($value) > 0) {
                    while ($i < count($value)) {
                        if ($chave == $value[$i]) {
                            $option = '<option selected value="' . $chave . '" style="cursor:grab;padding: 4px 0px;">' . $valor . '</option>';
                        }
                        $i++;
                    }
                }
                $opt .= $option;
            }
        }



        $select = '<div align=' . $align . ' style="width: 300px;float:left;">
                        <select name="' . $name . '" id="' . $name . '" multiple size="5" class="textfields" style="min-width: 300px;">                            
                            ' . $opt . '
                        </select>
                        ' . $comentario . '
                    </div>';

        return $select;
    }

    /**
     * Insere TextArea
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $value Valor da textarea, tem "vazio" como default
     * @param int $cols Número de Colunas, tem "70" como default
     * @param int $rows Número de Linhas, tem "2" como default
     * @param Boolean $counter true|false Determina se o componente de contador deve ser utilizado, tem "false" como default
     * @param int $tam_counter Número máximo de caracteres para o contador, tem "250" como default
     * @param Boolean $comment true|false Comentário no topo do campo, tem false como default
     * @param String $texto_comment Texto do comentário no topo do campo, tem vazio como default
     * @param String $align Alinhamento, tem "left" como default
     * @return String Código HTML do TextArea
     *
     */
    public function textarea($name, $value = "", $cols = 70, $rows = 2, $counter = false, $tam_counter = 250, $comment = false, $texto_comment = "", $align = "left", $disabled = false) {


        $comentario = ($comment) ? " <div style=\"width:100%; margin-top:4px;\"><span class=\"texto_azul\">" . $this->comment($texto_comment) . "</span></div>" : "";

        if ($counter) {
            $cont = "onKeyDown=\"textCounter(this,'progressbar_$name',$tam_counter)\"
                     onKeyUp=\"textCounter(this,'progressbar_$name',$tam_counter)\"
                     onFocus=\"textCounter(this,'progressbar_$name',$tam_counter)\"";

            $script = "
                    <div id=\"progressbar_$name\" class=\"progress\"><br></div>
                    <script>textCounter(document.getElementById(\"$name\"),\"progressbar_$name\",$tam_counter)</script>";
        } else {
            $cont = "";
            $script = "";
        }

        $desabilita = $disabled == TRUE ? "disabled" : "";

        $textarea = "
                    <div align=\"" . $align . "\">

                    <textarea name=\"$name\" cols=\"$cols\" rows=\"$rows\" class=\"textfields\" id=\"$name\" $desabilita $cont>$value</textarea>                    
                    $comentario
                    </div>
                    $script";

        return $textarea;
    }

    /**
     * Insere TextArea com o componente RESIZEAREA
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $value Valor da textarea, tem "vazio" como default
     * @param int $cols Número de Colunas, tem "70" como default
     * @param int $rows Número de Linhas, tem "2" como default
     * @param Boolean $counter true|false Determina se o componente de contador deve ser utilizado, tem "false" como default
     * @param int $tam_counter Número máximo de caracteres para o contador, tem "250" como default
     * @param Boolean $comment true|false Comentário no topo do campo, tem false como default
     * @param String $texto_comment Texto do comentário no topo do campo, tem vazio como default
     * @param String $align Alinhamento, tem "left" como default
     * @return String Código HTML do TextArea com o componente RESIZEAREA
     *
     */
    public function textarea_resize($name, $value = "", $cols = 70, $rows = 2, $comment = false, $texto_comment = "", $align = "left") {

            $comentario = isset($comment) ? " <div style=\"width:100%; margin-top:4px;\"><span class=\"texto_azul\">" . $this->comment($texto_comment) . "</span></div>" : "";

        $textarea = "<div align=\"" . $align . "\">
                        <textarea onKeyUp=\"javascript:resizeTextArea();\" name=\"$name\" cols=\"$cols\" rows=\"$rows\" class=\"textfields\" id=\"$name\">$value</textarea>
                        $comentario 
                    </div>";

        return $textarea;
    }

    /**
     * Insere CheckBox
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $leg Legenda da opção de checkbox
     * @param String $value Valor do checkbox, tem "vazio" como default
     * @param Boolean $checked true|false determina se o checkbox deve estar marcado ou não, tem "false" como default
     * @param String $align Alinhamento, tem "left" como default
     * @return String Código HTML do CheckBox
     *
     */
    public function checkbox($name, $leg, $value = "", $checked = false, $align = "left", $jscript = "") {

        if ($checked) {
            $c = "checked";
        } else {
            $c = "";
        }

        $check = "<div class=\"checkbox\"  align=\"" . $align . "\">
                    <input name=\"$name\" type=\"checkbox\" id=\"$name\" value=\"$value\" $c $jscript />
                    <span class=\"texto_azul\" style=\"float: right; margin: 3px 0px 0px 5px;\">$leg</span>
                  </div>";

        return $check;
    }

    /**
     * Insere CheckBox
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $leg Legenda da opção de checkbox
     * @param String $value Valor do checkbox, tem "vazio" como default
     * @param Boolean $checked true|false determina se o checkbox deve estar marcado ou não, tem "false" como default
     * @param String $align Alinhamento, tem "left" como default
     * @return String Código HTML do CheckBox
     *
     */
    public function radio($name, $leg, $value = "", $checked = false, $align = "left") {

        if ($checked) {
            $c = "checked=\"checked\"";
        } else {
            $c = "";
        }

        $check = "<div class=\"radio\" align=\"" . $align . "\">
                    <input name=\"$name\" type=\"radio\" id=\"$name\" value=\"$value\" $c />
                    <span class=\"texto_azul\" style=\"float: right; margin: 3px 0px 0px 5px;\">$leg</span>
                  </div>";

        return $check;
    }

    /**
     * Insere Validações nas páginas HTML, usado em formulário de alteração e inclusão
     * @author Ricardo Ribeiro Assink
     * @param String $campo Nome do campo
     * @param String $atrib value|value.length Atributo do campo
     * @param String $operador Operador de comparação
     * @param String $valor_comparacao Valor que deve ser comparado com o campo
     * @param String $msg Mensagem que deve aparecer para o usuário em caso de false na comparação
     * @param Array $marcador_campos Array com o nome dos campos que devem ficar marcado indicando erro na digitação
     * @param String $tema Tema do sistema
     * @param String $idioma Idioma corrente do usuário
     * @return String Código HTML de Validações
     *
     */
    public function validar($campo, $atrib, $operador, $valor_comparacao, $msg, $marcador_campos, $tema, $idioma) {

        if (!in_array($campo, $this->resetcampos)) {
            Array_push($this->resetcampos, $campo);
        }
        $msg2 = rawurlencode($msg);
        $ret_val = "
                        if(document.form1." . $campo . "." . $atrib . " " . $operador . " " . $valor_comparacao . "){
                            displayMessage('temas/$tema/modal/msg_alerta.php?tema=$tema&msg=$msg2&idioma=$idioma');";

        foreach ($marcador_campos as $valor) {
            $ret_val .= "
                            document.form1." . $valor . ".className = \"textfields_erro\";";
        }

        $ret_val .= "
                        }
                    ";
        return $ret_val;
    }

    /**
     * Insere Validações específica para e-mail
     * @author Ricardo Ribeiro Assink
     * @param String $campo Nome do campo
     * @param String $msg Mensagem que deve aparecer para o usuário em caso de false na comparação
     * @param Array $marcador_campos Array com o nome dos campos que devem ficar marcado indicando erro na digitação
     * @param String $tema Tema do sistema
     * @param String $idioma Idioma corrente do usuário
     * @return String Código HTML de Validação específica para e-mail
     *
     */
    public function validar_email($campo, $msg, $marcador_campos, $tema, $idioma) {

        if (!in_array($campo, $this->resetcampos)) {
            Array_push($this->resetcampos, $campo);
        }
        $msg2 = rawurlencode($msg);
        $ret_val = "
                        if(!checkMail(document.form1." . $campo . ".value)){
                            displayMessage('temas/$tema/modal/msg_alerta.php?tema = $tema&msg = $msg2&idioma = $idioma');";

        foreach ($marcador_campos as $valor) {
            $ret_val .= "
                            document.form1." . $valor . ".className = \"textfields_erro\";";
        }

        $ret_val .= "
                        }
                    ";
        return $ret_val;
    }

    /**
     * Insere Código AJAX para validação de e-mail
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $value Valor do campo, tem "vazio" como default
     * @param int $size Tamanho do Campo, tem "40" como default
     * @param Boolean $comment true|false Comentário no topo do campo, tem false como default
     * @param String $texto_comment Texto do comentário no topo do campo, tem vazio como default
     * @param String $text_button Legenda do Botão, tem "OK" como default
     * @param int $maxlength Número máximo de caracteres no campo, tem null como default
     * @param String $align Alinhamento, tem "left" como default
     * @return String Código AJAX para validação de e-mail
     *
     */
    public function AJAX_existe_registro($name, $value = "", $size = 40, $comment = false, $texto_comment = "", $text_button = "OK", $maxlength = null, $align = "left") {

        if (!in_array($name, $this->ajax)) {
            Array_push($this->ajax, $name);
        }
        if ($comment) {
            $comentario = "<tr><td colspan=\"2\"><span class=\"texto_azul\">" . $this->comment($texto_comment) . "</span></td></tr>";
        }

        if ($maxlength > 0) {
            $maxlength = "maxlength=\"" . $maxlength . "\"";
        }

        return "<div align=\"" . $align . "\">
                <table width=\"100%\" border=\"0\">
                  <tr>
                    <td width=\"10%\" nowrap><input name=\"$name\" type=\"text\" class=\"textfields\" id=\"$name\" value=\"$value\" size=\"$size\" $maxlength onFocus=\"javascript:limpa_$name();\" onBlur=\"javascript: processa_$name();\">
                        <input type=\"button\" name=\"Submit_$name\" value=\"$text_button\" class=\"botao\" style=\"margin-left:4px;\" onClick=\"javascript:processa_$name();\" >
                    </td>
                    <td width=\"90%\">
                      <div class=\"texto_verde\" id=\"alerta_$name\" align=\"left\"></div>
                    </td>
                  </tr>$comentario
                </table>
                </div>
                ";
    }

    /**
     * Insere Calendário
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $leg Legenda do Botão
     * @param String $value Valor Inicial
     * @param String $align Alinhamento, tem "left" como default
     * @return String Código HTML do Calendário
     *
     */
    public function calendar($name, $leg, $value, $comment = false, $texto_comment = "", $align = "left") {

        $comentario = ($comment) ? "<div style=\"width:100%; margin-top:4px;\"><span class=\"texto_azul\">" . $this->comment($texto_comment) . "</span></div>" : "";

        $calendario = "<div align=\"" . $align . "\">
                        <input name=\"$name\" type=\"text\" class=\"textfields\" id=\"$name\" value=\"$value\" size=\"10\" readonly>
                        <input name=\"button\" type=\"button\" class=\"botao\" onClick=\"displayCalendar(document.form1.$name,'dd/mm/yyyy',this)\" value=\"$leg\">
                            $comentario
                        </div>
        ";

        return $calendario;
    }

    public function div_scroll($nome, $valor) {
        return "<div class=\"div_scroll\" id=\"$nome\">$valor</div>";
    }

    /**
     * Insere TextArea TINYMCE
     * @author Ricardo Ribeiro Assink
     * @param String $name Nome do campo
     * @param String $value Valor da textarea, tem "vazio" como default
     * @param String $align Alinhamento, tem "left" como default
     * @return String Código HTML do TextArea
     *
     */
    public function textarea_TINYMCE($name, $value = "", $align = "left") {


        $textarea = "<div align=\"" . $align . "\">
                        <textarea name=\"$name\" id=\"$name\" class=\"tinymce\">$value</textarea>
                    </div>
                    ";

        return $textarea;
    }

    public function textfield_FILE_2($name, $value = "", $size = 40, $comment = false, $texto_comment = "", $maxlength = null, $align = "left") {

        if ($comment) {
            $comentario = $this->comment($texto_comment) . "<br>";
        }

        if ($maxlength > 0) {
            $maxlength = "maxlength=\"" . $maxlength . "\"";
        }

        return "
                <div align=\"" . $align . "\">$comentario
                    <div class=\"img_favicon\" style=\"background-image: url('./../../favicon.ico'); \"></div>
                    <input name=\"" . $name . "\" type=\"file\" id=\"" . $name . "\" value=\"" . $value . "\" class=\"textfields\" size=\"" . $size . "\" $maxlength />
                        
                </div> \n";
    }

    /**
     * Insere DTREE
     * @author Ricardo Ribeiro Assink
     * @param Array $valores Nomes e ids dos links
     * @return String Código HTML do DTREE
     *
     */
    public function dtree($valores, $inicial) {


        $dtree = "
                <div class=\"dtree\">
                    <script type=\"text/javascript\">
                        <!--
                        set_campo('id','" . $inicial . "');
                        d = new dTree('d');
                        d.add(0,-1,'WWW');
                ";

        $i = 0;
        while ($i < count($valores)) {
            $nomelink = $valores[$i];
            $a = $i + 1;
            $dtree .= "d.add($a,0,'" . $nomelink['nome'] . "','javascript:submit_campo(\'" . $nomelink['id_conteudo'] . "\',\'" . $nomelink['ac'] . "\')');
";
            $i++;
        }


        $dtree .= "
document.write(d);

//-->
</script>
</div>
";

        return $dtree;
    }

    /**
     * @author Marcio Figueredo
     * Formatador de Strings
     * @param $mascara - formato de mascara 
     * (Tipo):
     * CEP: #####-###
     * CPF: ###.###.###-##
     * TEL: (##)####-####
     * 
     * @param $string - string a ser formatada
     *      
     * @return string formatada
     */
    public function mascara_string($mascara, $string) {
        $string = str_replace(" ", "", $string);
        for ($i = 0; $i < strlen($string); $i++) {
            $mascara[strpos($mascara, '#')] = $string[$i];
        }
        return $mascara;
    }

}

?>
