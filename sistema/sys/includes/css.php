<?

if( substr($_SERVER["HTTP_USER_AGENT"],0,20) == "Mozilla/5.0 (iPhone;"){


   echo "<link href=\"temas/iphone/site_iphone.css\" rel=\"stylesheet\" type=\"text/css\" />";

}else{

   echo "<link href=\"temas/$tema/site.css\" rel=\"stylesheet\" type=\"text/css\" />";

}

?>
