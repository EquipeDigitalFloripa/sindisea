<?

function verifica_traducao($conexao,$id_artigo){

    $sql                 = "select
  lingua_origem,
  titulo_artigo_pt,
  abstract_pt,
  sub_tema_artigo_pt,
  palavras_chave_pt,
  titulo_artigo_en,
  abstract_en,
  sub_tema_artigo_en,
  palavras_chave_en,
  data_arq_pt,
  data_arq_en
      from
  tb_artigo
	  where
		id_artigo = $id_artigo
";

  $result  = mysql_query("$sql",$conexao) or die ("ERRO: " . mysql_error());
  $row     = mysql_fetch_array($result, MYSQL_NUM);

  $lingua_origem                  = stripslashes(trim($row[0]));
  $titulo_artigo_pt               = stripslashes(trim($row[1]));
  $abstract_pt                    = stripslashes(trim($row[2]));
  $sub_tema_artigo_pt             = stripslashes(trim($row[3]));
  $palavras_chave_pt              = stripslashes(trim($row[4]));
  $titulo_artigo_en               = stripslashes(trim($row[5]));
  $abstract_en                    = stripslashes(trim($row[6]));
  $sub_tema_artigo_en             = stripslashes(trim($row[7]));
  $palavras_chave_en              = stripslashes(trim($row[8]));
  $data_arq_pt                    = trim($row[9]);
  $data_arq_en                    = trim($row[10]);

            if($lingua_origem == "EN"){

               if($titulo_artigo_pt != "" and $sub_tema_artigo_pt != "" and $palavras_chave_pt != "" and $abstract_pt != "" and $data_arq_pt != "" and $data_arq_pt != "0000-00-00 00:00:00"){
                 return true;
               }else{
                 return false;
               }

            }

            if($lingua_origem == "PT"){

               if($titulo_artigo_en != "" and $sub_tema_artigo_en != "" and $palavras_chave_en != "" and $abstract_en != "" and $data_arq_en != "" and $data_arq_en != "0000-00-00 00:00:00"){
                 return true;
               }else{
                 return false;
               }

           }
}





function lista_intervencoes($conexao,$id_artigo,$idioma){


                if($idioma == "PT"){
                  $rr = "Aguardando resposta...";
                  $r1 = "Enviado em:";
                  $r2 = "Mensagem:";
                  $r3 = "Respondido em:";
                  $r4 = "Resposta:";
                  $r5 = "Para:";
                  $r6 = "De:";
                }else{
                  $rr = "Awaiting response...";
                  $r1 = "Posted on:";
                  $r2 = "Message:";
                  $r3 = "Answered on:";
                  $r4 = "Answer:";
                  $r5 = "To:";
                  $r6 = "From:";
                }

                $sql           = "select
                                      t1.id_intervencao,
                                      t1.id_artigo,
                                      t2.nome_usuario,
                                      t3.nome_usuario,
                                      t1.data_envio,
                                      t1.data_resposta,
                                      t1.intervencao,
                                      t1.resposta_intervencao,
                                      t1.status_intervencao
                                          from
                                      tb_intervencao t1,
                                      tb_usuario t2,
                                      tb_usuario t3
                                          where
                                          t1.id_artigo = $id_artigo
                                          and t1.id_autor = t2.id_usuario
                                          and t1.id_diretor = t3.id_usuario
                                          order by t1.id_intervencao desc";

	        $result        = mysql_query("$sql",$conexao) or die ("ERRO : " . mysql_error());

                while ($row = mysql_fetch_array($result, MYSQL_NUM)) {

                      $id_intervencao       = stripslashes(trim($row[0]));
                      $id_artigo            = stripslashes(trim($row[1]));
                      $nome_autor           = nl2br(htmlentities(stripslashes(trim($row[2])),ENT_QUOTES,'UTF-8'));
                      $nome_diretor         = nl2br(htmlentities(stripslashes(trim($row[3])),ENT_QUOTES,'UTF-8'));
                      $data_envio           = stripslashes(trim($row[4]));
                      $data_resposta        = stripslashes(trim($row[5]));
                      $intervencao          = nl2br(htmlentities(stripslashes(trim($row[6])),ENT_QUOTES,'UTF-8'));
                      $resposta_intervencao = nl2br(htmlentities(stripslashes(trim($row[7])),ENT_QUOTES,'UTF-8'));
                      $status_intervencao   = stripslashes(trim($row[8]));

                      $data_envio           = formatadata2($data_envio);


                      if($data_resposta != "" and $data_resposta != "0000-00-00 00:00:00"){
                        $data_resposta         = formatadata2($data_resposta);
                      }else{
                         $data_resposta        = $rr;
                         $resposta_intervencao = $rr;

                      }

              $consult .= "
<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"1\" bgcolor=\"#999999\">
  <tr>
    <td width=\"20%\" bgcolor=\"#EBEBEB\"><span class=\"texto_info\">$r1</span> </td>
    <td width=\"80%\" bgcolor=\"#FFFFFF\"><span class=\"texto_info\"><b>$data_envio</b></span></td>
  </tr>
  <tr>
    <td width=\"20%\" bgcolor=\"#EBEBEB\"><span class=\"texto_info\">$r6</span> </td>
    <td width=\"80%\" bgcolor=\"#FFFFFF\"><span class=\"texto_info\"><b>$nome_diretor</b></span></td>
  </tr>
  <tr>
    <td width=\"20%\" bgcolor=\"#EBEBEB\"><span class=\"texto_info\">$r5</span> </td>
    <td width=\"80%\" bgcolor=\"#FFFFFF\"><span class=\"texto_info\"><b>$nome_autor</b></span></td>
  </tr>
  <tr>
    <td colspan=\"2\" bgcolor=\"#FFFFFF\">
      <div align=\"justify\">
      <span class=\"texto_info\"><b>$r2</b><br />
      <p>$intervencao</p>
      </span>
      </div>
    </td>
  </tr>
  <tr>
    <td width=\"20%\" nowrap=\"nowrap\" bgcolor=\"#EBEBEB\"><span class=\"texto_info\">$r3</span></td>
    <td width=\"80%\" bgcolor=\"#FFFFFF\"><span class=\"texto_info\"><b>$data_resposta</b></span></td>
  </tr>
  <tr>
    <td colspan=\"2\" bgcolor=\"#FFFFFF\">
       <div align=\"justify\">
          <span class=\"texto_info\"><b>$r4</b><br />
          <p>$resposta_intervencao</p>
          </span>
       </div>
    </td>
  </tr>
</table> <br><hr width=\"50%\" size=\"1\"> <br>";

           } // fim do while


     return $consult;
}

function lista_consultorias($conexao,$id_artigo,$idioma){

                if($idioma == "PT"){
                  $rr = "Aguardando resposta...";
                  $r1 = "Enviado em:";
                  $r2 = "Mensagem:";
                  $r3 = "Respondido em:";
                  $r4 = "Resposta:";
                  $r5 = "Para:";
                  $r6 = "De:";
                }else{
                  $rr = "Awaiting response...";
                  $r1 = "Posted on:";
                  $r2 = "Message:";
                  $r3 = "Answered on:";
                  $r4 = "Answer:";
                  $r5 = "To:";
                  $r6 = "From:";
                }

                $sql           = "select
                                      t1.id_consultoria,
                                      t1.id_artigo,
                                      t2.nome_usuario,
                                      t3.nome_usuario,
                                      t1.data_envio,
                                      t1.data_resposta,
                                      t1.consultoria,
                                      t1.resposta_consultoria,
                                      t1.status_consultoria
                                          from
                                      tb_consultoria t1,
                                      tb_usuario t2,
                                      tb_usuario t3
                                          where
                                          t1.id_artigo = $id_artigo
                                          and t1.id_consultor = t2.id_usuario
                                          and t1.id_diretor = t3.id_usuario
                                          order by t1.id_consultoria desc";

	        $result        = mysql_query("$sql",$conexao) or die ("ERRO : " . mysql_error());

                while ($row = mysql_fetch_array($result, MYSQL_NUM)) {

                      $id_consultoria       = stripslashes(trim($row[0]));
                      $id_artigo            = stripslashes(trim($row[1]));
                      $nome_consultor       = nl2br(htmlentities(stripslashes(trim($row[2])),ENT_QUOTES,'UTF-8'));
                      $nome_diretor         = nl2br(htmlentities(stripslashes(trim($row[3])),ENT_QUOTES,'UTF-8'));
                      $data_envio           = stripslashes(trim($row[4]));
                      $data_resposta        = stripslashes(trim($row[5]));
                      $consultoria          = nl2br(htmlentities(stripslashes(trim($row[6])),ENT_QUOTES,'UTF-8'));
                      $resposta_consultoria = nl2br(htmlentities(stripslashes(trim($row[7])),ENT_QUOTES,'UTF-8'));
                      $status_consultoria   = stripslashes(trim($row[8]));

                      $data_envio           = formatadata2($data_envio);


                      if($data_resposta != "" and $data_resposta != "0000-00-00 00:00:00"){
                        $data_resposta         = formatadata2($data_resposta);
                      }else{
                         $data_resposta        = $rr;
                         $resposta_consultoria = $rr;

                      }

 $consult .= "
<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"1\" bgcolor=\"#999999\">
  <tr>
    <td width=\"20%\" bgcolor=\"#EBEBEB\"><span class=\"texto_info\">$r1</span> </td>
    <td width=\"80%\" bgcolor=\"#FFFFFF\"><span class=\"texto_info\"><b>$data_envio</b></span></td>
  </tr>
  <tr>
    <td width=\"20%\" bgcolor=\"#EBEBEB\"><span class=\"texto_info\">$r6</span> </td>
    <td width=\"80%\" bgcolor=\"#FFFFFF\"><span class=\"texto_info\"><b>$nome_diretor</b></span></td>
  </tr>
  <tr>
    <td width=\"20%\" bgcolor=\"#EBEBEB\"><span class=\"texto_info\">$r5</span></td>
    <td width=\"80%\" bgcolor=\"#FFFFFF\"><span class=\"texto_info\"><b>$nome_consultor</b></span></td>
  </tr>
  <tr>
    <td colspan=\"2\" bgcolor=\"#FFFFFF\">
      <div align=\"justify\">
      <span class=\"texto_info\"><b>$r2</b><br />
      <p>$consultoria</p>
      </span>
      </div>
    </td>
  </tr>
  <tr>
    <td width=\"20%\" nowrap=\"nowrap\" bgcolor=\"#EBEBEB\"><span class=\"texto_info\">$r3</span></td>
    <td width=\"80%\" bgcolor=\"#FFFFFF\"><span class=\"texto_info\"><b>$data_resposta</b></span></td>
  </tr>
  <tr>
    <td colspan=\"2\" bgcolor=\"#FFFFFF\">
       <div align=\"justify\">
          <span class=\"texto_info\"><b>$r4</b><br />
          <p>$resposta_consultoria</p>
          </span>
       </div>
    </td>
  </tr>
</table> <br><hr width=\"50%\" size=\"1\"> <br>";

           } // fim do while


     return $consult;
}





?>
