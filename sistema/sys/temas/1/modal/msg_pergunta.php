<?php

$msg = (isset($_REQUEST['msg'])) ? $_REQUEST['msg'] : "";
$tema = (isset($_REQUEST['tema'])) ? $_REQUEST['tema'] : "";
$abrir = (isset($_REQUEST['abrir'])) ? $_REQUEST['abrir'] : "";
$acao = (isset($_REQUEST['acao']))?$_REQUEST['acao']:"";
$id = (isset($_REQUEST['id']))?$_REQUEST['id']:"";

$ab_if = ($abrir == "SIM") ? "mostraDIV();" : "";

$msg = htmlentities(rawurldecode($msg), NULL, "ISO-8859-1");

$idioma = $_REQUEST['idioma'];

if ($idioma == "" or $idioma == "PT") {
    $q0 = "";
    $q1 = "Sim";
    $q2 = "Não";
} else {
    $q0 = "_en";
    $q1 = "Yes";
    $q2 = "No";
}
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(temas/<?php echo $tema; ?>/modal/fundo_modal_pergunta<?php echo $q0; ?>.jpg); background-repeat:no-repeat;">
    <tr>
        <td width="0%"><img src="img/pixel.gif" width="1" height="1" /></td>
        <td width="100%" valign="middle">

            <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                <tr>
                    <td><img src="img/pixel.gif" width="50" height="30" /></td>
                </tr>
                <tr>
                    <td> <div align="center" style="margin-top:50px; height:30px; color:white; font-size:14px;"><?php echo $msg; ?><br />
                        </div></td>
                </tr>
                <tr>
                    <td>

                        <form name="form_pergunta">
                            <table border="0" align="center">
                                <tr>
                                    <td><input  style="margin-top:20px; bottom:0px;" type="button" value="   <?php echo $q1; ?>   "  class="botao3" onclick="closeMessage();pergunta('<?php echo $acao; ?>',<?php echo $id; ?>);" id="link_fechar">
                                        <input type="button" value="   <?php echo htmlentities("$q2", NULL, 'ISO-8859-1'); ?>   " class="botao3" onclick="closeMessage();<?php echo $ab_if; ?>"></td>
                                </tr>
                            </table>
                        </form>        </td>
                </tr>
            </table>
            <br />
        </td>
    </tr>
</table>

<script type="text/JavaScript">
    //document.form_pergunta.link_fechar.focus();
</script>
