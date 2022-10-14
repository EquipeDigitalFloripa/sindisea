<?php

class TemplateManager {

    public static function start() {
        ob_start();
    }

    public static function show($template_file = 'template1.php', $js = '', $bg = '', $det = '', $vetor_conteudo = Array(), $post_request = Array()) {
        // $conteudo = ob_get_clean();
        $java_script = $js;
        include($template_file);
    }

}

?>
