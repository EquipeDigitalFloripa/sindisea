<?php
$msg = $_REQUEST['msg'];
$tema = $_REQUEST['tema'];
$abrir = $_REQUEST['abrir'];


if ($abrir == "SIM") {
    $ab_if = "mostraDIV();";
}

$msg = htmlentities(rawurldecode($msg), NULL, "ISO-8859-1");

$idioma = $_REQUEST['idioma'];

if ($idioma == "" or $idioma == "PT") {

    $q0 = "";
    $q1 = "Sim";
    $q2 = "Não";
    $q3 = "Tem certeza de que deseja sair do sistema ?";
} else {
    $q0 = "_en";
    $q1 = "Yes";
    $q2 = "No";
    $q3 = "Are you sure you want to exit the system ?";
}
?>

<table width="100%"  border="0" cellpadding="0" cellspacing="0" style="background-image:url(temas/<?php echo $tema; ?>/modal/fundo_modal_sair<?php echo $q0; ?>.jpg); background-repeat:no-repeat;">
    <tr>
        <td width="0%" ><img src="img/pixel.gif" width="1" height="1" /></td>
        <td  width="100%" valign="middle" height="1" style="padding:0;margin:0;height:180px; overflow:hidden;table-layout:fixed;">

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><img src="img/pixel.gif" width="50" height="50" /></td>
                </tr>
                <tr>
                    <td> <div align="center" style="margin-top:50px; height:30px; color:white; font-size:14px;"><?php echo $q3; ?><br />
                            <br />
                        </div></td>
                </tr>
                <tr>
                    <td>

                        <form name="form_pergunta">
                            <table border="0" align="center">
                                <tr>
                                    <td><input type="button" style="margin-top:30px; bottom:0px;"  value="  <?php echo $q1; ?>   "  class="botao" onclick="closeMessage();
                                            sair(true)" id="link_fechar">
                                        <input type="button"  value="   <?php echo htmlentities("$q2", NULL, 'ISO-8859-1'); ?>   " class="botao" onclick="closeMessage();sair(false);<?php echo $ab_if; ?>"></td>
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
