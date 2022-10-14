<?php

function autoLoader($className) {

    $directories = array(
        $_SERVER['DOCUMENT_ROOT'] . '/sistema/',
        $_SERVER['DOCUMENT_ROOT'] . '/sistema/BD/',
        $_SERVER['DOCUMENT_ROOT'] . '/sistema/Control/',
        $_SERVER['DOCUMENT_ROOT'] . '/sistema/DAO/',
        $_SERVER['DOCUMENT_ROOT'] . '/sistema/Libs/',
        $_SERVER['DOCUMENT_ROOT'] . '/sistema/Model/',
        $_SERVER['DOCUMENT_ROOT'] . '/sistema/View/',
        $_SERVER['DOCUMENT_ROOT'] . '/sistema/Templates/',
        $_SERVER['DOCUMENT_ROOT'] . '/'
    );

    $fileNameFormats = array(
        '%s.php',
        '%s.class.php',
        'class.%s.php',
        '%s.inc.php'
    );

    // this is to take care of the PEAR style of naming classes
    $path = str_ireplace('_', '/', $className);
    if (@include_once $path . '.php') {
        return;
    }

    foreach ($directories as $directory) {
        foreach ($fileNameFormats as $fileNameFormat) {
            $path = $directory . sprintf($fileNameFormat, $className);
            if (file_exists($path)) {
                include_once $path;
                return;
            }
        }
    }
}

spl_autoload_register('autoLoader');

/*
  echo $_SERVER['DOCUMENT_ROOT'].'/sistema/Libs/'."<br>";

  $enc = new Data();
  echo $enc->get_dataFormat("NOW", "", "PADRAO");

 */
?>
