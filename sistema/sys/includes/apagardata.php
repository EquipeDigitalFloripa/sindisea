<?
// hora dos açores
date_default_timezone_set("Etc/GMT");

$meses = array(null,"Janeiro","Fevereiro","Março","Abril","Maio","Junho",

                       "Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");

$dias_semana = array("Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado");

$thedate = getdate();
$chave_de_sessao = '123deoliVeira4@@';
$day     = $thedate["mday"];
$mon     = $thedate["mon"];
$year    = $thedate["year"];

	if($day < 10){
		$day = "0$day";
	}

	if($mon < 10){
		$mon = "0$mon";
	}


	$datatual = getdate();
	$minutes  = $datatual['minutes'];
	$hours    = $datatual['hours'];
	$seconds  = $datatual['seconds'];
	$ampm     = "am";

	//if ($hours > 12) {
        //$hours = $hours-12;
        //$ampm  = "pm";
	//}

	if ( $minutes < 10) {
        $minutes = "0$minutes";
	}

	$horario =  "$hours:$minutes $ampm";
	$data    = "$day/$mon/$year";

	$dia    = $day;
	$mes    = $mon;
	$ano    = $year;
	$hora   = $hours;
	$minuto = $minutes;
	$segundo = $seconds;

	$data_atual = "$ano-$mes-$dia $hora:$minuto:$segundo";
	$data_f     = "$dia/$mes/$ano $hora:$minuto";
	$hora_atual = "$hora:$minuto:$segundo";
	
	
	
	
function formatadata($data){


   $ano   = substr($data,0,4);
   $mes   = substr($data,5,2);
   $dia   = substr($data,8,2);
   $hora  = substr($data,-8);

    return "$dia/$mes/$ano $hora";
}

function formatadata2($data){


   $ano   = substr($data,0,4);
   $mes   = substr($data,5,2);
   $dia   = substr($data,8,2);
   $hora  = substr($data,-8);
   $hora  = substr($hora,0,5);

    return "$dia/$mes/$ano $hora";
}



function formatadata3($data){


   $ano   = substr($data,0,4);
   $mes   = substr($data,5,2);
   $dia   = substr($data,8,2);

    return "$dia/$mes/$ano";
}

function formatadata4($data){

$time  = strtotime($data);

  /*
  $ano   = substr($data,0,4);
   $mes   = substr($data,5,2);
   $dia   = substr($data,8,2);
   $horai  = substr($data,-8);

           $se = date('s',$time);
        $mi = date('i',$time);
        $ho = date('H',$time);
        $di = date('d',$time);
        $me = date('m',$time);
        $an = date('Y',$time);

   list($hora,$minuto,$segundo) = split (":", $horai, 3);

   $retorno = mktime($hora,$minuto,$segundo,$mes,$dia,$ano);
   *
   */

    return "$time";
}

function formatadata_bdi($data){

   $dia_h           = substr($data,0,2);
   $mes_h           = substr($data,3,2);
   $ano_h           = substr($data,6,4);
   $data_ar         = "$ano_h-$mes_h-$dia_h 00:00:01";

    return "$data_ar";
}

function formatadata_bdi_hora($data,$hora_atual){

   $dia_h           = substr($data,0,2);
   $mes_h           = substr($data,3,2);
   $ano_h           = substr($data,6,4);
   $data_ar         = "$ano_h-$mes_h-$dia_h $hora_atual";

    return "$data_ar";
}

function formatadata_bdf($data){

   $dia_h           = substr($data,0,2);
   $mes_h           = substr($data,3,2);
   $ano_h           = substr($data,6,4);
   $data_ar         = "$ano_h-$mes_h-$dia_h 23:59:59";

    return "$data_ar";
}

function formatadata_artigo($data){

/*
   $ano   = substr($data,0,4);
   $mes   = substr($data,5,2);
   $dia   = substr($data,8,2);
   $horai  = substr($data,-8);

   list($hora,$minuto,$segundo) = split (":", $horai, 3);
   */

   $time  = strtotime($data);

           $se = date('s',$time);
        $mi = date('i',$time);
        $ho = date('H',$time);
        $di = date('d',$time);
        $me = date('m',$time);
        $an = date('Y',$time);

   $retorno = $an.$me.$di.$ho.$mi.$se;

    return "$retorno";
}


?>
