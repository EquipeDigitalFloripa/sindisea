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
} else {
    $q0 = "_en";
}
?>


<table width="400" border="0" cellpadding="0" cellspacing="0" style="background-image:url(temas/<?php echo $tema; ?>/modal/fundo_modal_processando<?php echo $q0; ?>.jpg); background-repeat:no-repeat;">
    <tr>
        <td width="0%"><img src="img/pixel.gif" width="1" height="200" /></td>
        <td width="100%" valign="bottom"><table width="100%" border="0" align="right" cellpadding="5" cellspacing="5">
                <tr>
                    <td>
                        <div style="margin-top:-46px;" align="center"><img  src="temas/<?php echo $tema; ?>/modal/progress.gif" />
                        </div></td>
                </tr>
                <tr>
                    <td><br /><br />
                    </td>
                </tr>
            </table></td>
    </tr>
</table>
<script type="text/JavaScript">
    setTimeout('<?php echo $msg; ?>', 2000);
</script>

