<?php

class Site_Helper {

    /**
     * Gera o código html para exibição de uma miniatura
     * @param int $id Nome do arquivo
     * @param string $extensao Extensão do arquivo
     * @param string $dir Nome da pasta em ../arquivos/
     * @param int $largura Largura da miniatura
     * @param string $classe_css Classe CSS para a tag img
     * @return String Código html para exibição de uma miniatura
     */
    public static function thumb($id, $extensao, $dir, $largura = 200, $classe_css = 'foto') {
        $html = "<img src=\"../sistema/sys/includes/make_thumb.php?arquivo=%s.%s&diretorio=../arquivos/%s/&tamanho=%s\" class=\"%s\">";
        return sprintf($html, $id, $extensao, $dir, $largura, $classe_css);
    }

    public static function thumb2($arquivo, $dir, $largura = 200, $classe_css = 'foto') {
        $html = "<img src=\"../sistema/sys/includes/make_thumb.php?arquivo=%s&diretorio=../arquivos/%s/&tamanho=%s\" class=\"%s\">";
        return sprintf($html, $arquivo, $dir, $largura, $classe_css);
    }

    public static function thumb3($arquivo, $dir, $largura = 200, $classe_css = 'foto') {
        $html = "<div class=\"%s\" style=\"background-image: url('../sistema/sys/includes/make_thumb.php?arquivo=%s&diretorio=../arquivos/%s/&tamanho=%s'); \"></div>";
        return sprintf($html, $classe_css, $arquivo, $dir, $largura);
    }

    public static function thumb4($arquivo, $dir, $largura = 200) {
        $html = "<img src=\"/sistema/sys/includes/make_thumb.php?arquivo=%s&diretorio=../arquivos/%s/&tamanho=%s\">";
        return sprintf($html, $arquivo, $dir, $largura);
    }

    /**
     * Mostra a URL atual
     * 
     * @author Jean Barcellos <jean@equipedigital.com>
     * @return void
     */
    public static function exibirUrlAtual() {
        $url_atual = strtolower(preg_replace('/[^a-zA-Z]/', '', $_SERVER['SERVER_PROTOCOL'])) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $url_atual;
    }

    /**
     * Exibe a barra com os botões de redes sociais 
     * (TEMPORÀRIO) Deverá ser aprimorado
     * 
     * @author Jean Barcellos <jean@equipedigital.com>
     * @return void
     * 
     */
    public static function criaBarraRedesSociais($link, $texto) {

        return "
          <ul class=\"lista-barra-redes-sociais\">
            <li class=\"fecebook\">
              <div id=\"fb-root\"></div>
              <script type=\"text/javascript\">(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = \"//connect.facebook.net/pt_BR/all.js#xfbml=1\";
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));</script>
              <div class=\"fb-like\" data-href=\"" . $link . "\" data-send=\"false\" data-layout=\"button_count\" data-width=\"90\" data-show-faces=\"false\"></div>
            </li>

            <li class=\"fecebook-share\">
              <div class=\"fb-share-button\" data-href=\"" . $link . "\" data-type=\"button_count\"></div>
            </li>

            <li class=\"twitter\">
              <a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url=\"" . $link . "\" data-text=\"" . $texto . "\" data-count=\"horizontal\"></a>
              <script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>
            </li>

          </ul>
        ";
    }

}

/*

            <li class=\"google\">
              <div class=\"g-plusone\"  data-onendinteraction=\"gplusoneinteraction\" data-size=\"medium\" data-href=\"" . $link . "\"></div>
              <script type=\"text/javascript\">
                window.___gcfg = {lang: 'pt-BR'};
                (function() {
                  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                  po.src = 'https://apis.google.com/js/plusone.js';
                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                  
                })();
              </script>
            </li>
 */

