<?php

class SiteHelper {

    /**
     * Gera o c�digo html para exibi��o de uma miniatura
     * @param int $id Nome do arquivo
     * @param string $extensao Extens�o do arquivo
     * @param string $dir Nome da pasta em ../arquivos/
     * @param int $largura Largura da miniatura
     * @param string $classe_css Classe CSS para a tag img
     * @return String C�digo html para exibi��o de uma miniatura
     */
    public static function thumb($id, $extensao, $dir, $largura = 200, $classe_css = '') {
        $html = "<img src=\"sistema/sys/includes/make_thumb.php?arquivo=%s.%s&diretorio=../arquivos/%s/&tamanho=%s\" class=\"%s\">";
        return sprintf($html, $id, $extensao, $dir, $largura, $classe_css);
    }

}

?>
