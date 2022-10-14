<?

require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");

    $config        = new Config();
    $factory       = $config->get_banco();
    $banco         = new $factory();
    $conexao       = $banco->getInstance();
    $dat = new Data();
    

    $sql                 = "select
                                     id_noticia,
                                 titulo_noticia,
                                chamada_noticia,
                                  texto_noticia,
                                ext_img_noticia,
                                   data_noticia,
                          data_cadastro_noticia,
                                 status_noticia,
                                 export_noticia
                                from tb_noticia
			where export_noticia = 1 order by data_cadastro_noticia";
    

   $result     = $conexao->consulta("$sql");
   $row        = $conexao->criaArray($result);

 
   $conteudo = "";
if(count($row) > 0){
   for($i = 0; $i < count($row); $i++){
        //echo $i." - ".$conteudo;

        $id_noticia          = $row[$i][0];
        $titulo              = htmlentities($row[$i][1]);
        $chamada             = htmlentities($row[$i][2]);
        $noticia             = stripcslashes($row[$i][3]);
        $ext_img             = $row[$i][4];
        $data_noticia        = $row[$i][6];
        $data_noticia        = $dat->get_dataFormat('BD', $data_noticia, 'DMA');


		     $conteudo =  "
             <br><table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"5\">
                      <tr>
                        <td bgcolor=\"#eaeaea\">
                          <font size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">
                           <strong>
                             $data_noticia - $titulo
                           </strong>
                          </font>
                        </td>
                      </tr>
                      <tr>
                        <td bgcolor=\"#FFFFFF\">
						  <p>
						    <img src=\"".$config->get_dominio()."/sistema/sys/arquivos/img_noticias/$id_noticia.$ext_img\" align=\"left\" hspace=\"5\" vspace=\"2\">
						    <font size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">
							  $noticia
							</font>
						  </p>
                        </td>
                      </tr>
                    </table><hr width=\"95%\" size=\"1\">";

                     echo $conteudo;

   }
   
} else {
    
    echo "Nenhum conte&uacute;do exportado ...";
    
}

?>



