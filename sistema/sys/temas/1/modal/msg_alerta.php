<?php
$msg = (isset($_REQUEST['msg'])) ? $_REQUEST['msg'] : "";
$tema = (isset($_REQUEST['tema'])) ? $_REQUEST['tema'] : 1;
$abrir = (isset($_REQUEST['abrir'])) ? $_REQUEST['abrir'] : "";

$ab_if = ($abrir == "SIM") ? "mostraDIV();" : "";


$msg = htmlentities(rawurldecode($msg), NULL, "ISO-8859-1");
$idioma = $_REQUEST['idioma'];

if ($idioma == "" or $idioma == "PT") {
    $q0 = "";
} else {
    $q0 = "_en";
}
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-image:url(temas/<?php echo $tema; ?>/modal/fundo_modal_alerta<?php echo $q0; ?>.jpg); background-repeat:no-repeat;">
    <tr>
        <td width="0%"><img src="img/pixel.gif" width="1" height="20" /></td>
        <td width="100%" valign="bottom"><table width="90%" border="0" align="right" cellpadding="5" cellspacing="5">
                <tr>
                    <td><p style="margin-top:90px; height:40px; color:white; font-size:14px;"><?php echo $msg; ?></p>           </td>
                </tr>
                <tr>
                    <td><div align="right" style="margin-top:0px;border:0;"><a href="javascript:closeMessage();<?php echo $ab_if; ?>" id="linkfechar"><span class="texto_modal"><img src="temas/<?php echo $tema; ?>/modal/fechar_modal<?php echo $q0; ?>.png" width="86" height="30" border="0" align="absmiddle" /></span></a></div></td>
                </tr>
            </table></td>
    </tr>
</table>

<script type="text/JavaScript">
    var link_fechar = document.getElementById('linkfechar');
    link_fechar.focus();
</script>
