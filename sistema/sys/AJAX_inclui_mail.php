<?php

require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");

    $config        = new Config();
    $factory       = $config->get_banco();
    $banco         = new $factory();
    $conexao       = $banco->getInstance();
    $dat = new Data();
    $data_atual = $dat->get_dataFormat('NOW', "", 'BD');

    $email                 = trim($_POST['email']);
    $tipo_email            = 1; // corresponde ao GERAL
    $email                 = strtolower($email);

    // verifica se mail j� existe
    $sql     = "select email_mailing,status_mailing,id_mailing from tb_mailing where email_mailing = \"$email\"";
    $result     = $conexao->consulta("$sql");
    $row        = $conexao->criaArray($result);

    $email2      = "";
    $email2         = strtolower($row[0]['email_mailing']);
    $status_email2  = $row[0]['status_mailing'];
    $id_email2      = $row[0]['id_mailing'];

    if($email2 != ""){

        if($status_email2 == "A"){

            $msg = rawurlencode(base64_encode("Seu e-mail j&aacute; est&aacute; cadastrado e ATIVO na base de dados."));
            header("Location:./../../index.php?msg=$msg#mailing");
	    exit();

        } else {
            $sql        = "update tb_mailing set status_mailing = \"A\" where id_mailing = $id_email2";
	    $result     = $conexao->consulta("$sql");
            $msg = rawurlencode(base64_encode("Seu e-mail j&aacute; est&aacute; cadastrado e foi ativado com sucesso."));
            header("Location:./../../index.php?msg=$msg#mailing");
	    exit();

       }

    }

    $sql        = "LOCK TABLES tb_mailing WRITE";
    $result     = $conexao->consulta("$sql");

    $sql        = "select max(id_mailing) id_mailing from tb_mailing";
    $result    = $conexao->consulta("$sql");
    $row        = $conexao->criaArrayOnce($result);

    $id_email  = $row[0];
    $id_email++;
    
    $sql                 = "INSERT INTO tb_mailing values(
                                $id_email,
                                \"$email\",
                                \"A\",
                                \"$data_atual\",
                                $tipo_email
                        )";
    $result     = $conexao->consulta("$sql");

    // desbloqueia as tabelas usadas
    $sql        = "UNLOCK TABLES";
    $result     = $conexao->consulta("$sql");
    $msg = rawurlencode(base64_encode("Seu e-mail foi cadastrado com sucesso."));
    header("Location:./../../index.php?msg=$msg#mailing");
    exit();
  
?>
