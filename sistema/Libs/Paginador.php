<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Paginador
 *
 * @author Marcela
 */
class Paginador {

    private $post_request;
    private $n_registros;
    private $pag_views;
    private $link;
    private $tamanho = 5;

    public function __construct($post_request, $n_registros, $pag_views, $links = "") {
        $this->post_request = $post_request;
        $this->n_registros = $n_registros;
        $this->pag_views = $pag_views;
        $this->link = $link;
    }

    public function exibir($params = null) {
        if ($params != NULL) {
            $params = "&$params";
        } else {
            $params = "";
        }
        $paginacao = array();
        $total_paginas = $this->total_paginas();
        $pagina_atual = $this->pagina_atual();
        $inicio_pag = $this->inicio_paginacao();
        $fim_pag = $this->fim_paginacao();

        $paginacao[] = "<div id=\"paginador\">";
        $paginacao[] = $this->botoes_retornar($params);
        for ($i = $inicio_pag; $i <= $fim_pag; $i++) {
            if ($pagina_atual == $i) {
                $paginacao[] = "<span class=\"texto_paginacao_destaque\">$i</span>";
            } else {
                $paginacao[] = "<a href=\"?pagina=$i$params\"><span class=\"texto_paginacao\">$i</span></a>";
            }
        }
        $paginacao[] = $this->botoes_avancar($params);
        $paginacao[] = "</div>";


//        $paginacao[] = "<div class=\"texto_paginacao\" style=\"text-decoration: none;\" align=\"center\">" . $this->botoes_retornar($params);
//        $paginacao[] .= "";
//        for ($i = $inicio_pag; $i <= $fim_pag; $i++) {
//            if ($pagina_atual == $i) {
//                $paginacao[] .= "<span class=\"texto_paginacao_destaque\">$i</span>";
//            } else {
//                if (!empty($params)) {
//                    $paginacao[] .= "<span class=\"texto_paginacao\"  style=\"text-decoration: none;\" ><a style=\"text-decoration: none;\" href=\"?pagina=$i&$params\">$i </a></span>";
//                } else {
//                    $paginacao[] .= "<span class=\"texto_paginacao\"  style=\"text-decoration: none;\" ><a style=\"text-decoration: none;\" href=\"?pagina=$i\">$i </a></span>";
//                }
//            }
//        }
//        $paginacao[] .= "";
//        $paginacao[] .= $this->botoes_avancar($params) . "</div>";

        if ($this->total_paginas() <= 1) {
            return "";
        }
        return implode(" ", $paginacao);
    }

    public function pagina_atual() {

        if (!isset($this->post_request['pagina'])) {
            $this->post_request['pagina'] = 1;
        }
        return $this->post_request['pagina'];
    }

    public function total_paginas() {
        return ceil($this->n_registros / $this->pag_views);
    }

    public function calcula_inicio() {
        return ($this->pagina_atual() - 1) * $this->pag_views;
    }

    private function inicio_paginacao() {
        $inicio = $this->pagina_atual() - $this->tamanho;
        if ($inicio >= ($this->total_paginas() - ($this->tamanho * 2))) {
            $inicio = $this->total_paginas() - ($this->tamanho * 2);
        }
        if ($inicio < 1) {
            $inicio = 1;
        }
        return $inicio;
    }

    private function fim_paginacao() {
        $fim = $this->inicio_paginacao() + ($this->tamanho * 2);
        if ($fim > $this->total_paginas()) {
            $fim = $this->total_paginas();
        }
        return $fim;
    }

    private function botoes_retornar($params) {
        if ($this->pagina_atual() != 1) {
            return "<span class=\"primeiro\"><a href=\"?pagina=1$params\" ><strong style=\"float: left;\">&laquo;</strong> Primeira</a></span>
                    <span class=\"anterior\"><a href=\"?pagina=" . ($this->pagina_atual() - 1) . "$params\"><strong style=\"float: left;\">&laquo;</strong> Anterior</a></span>";
        }
    }

    private function botoes_avancar($params) {
        if ($this->pagina_atual() != $this->total_paginas()) {
            return "<span class=\"ultimo\"><a href=\"?pagina=" . $this->total_paginas() . "$params\"> Última <strong style=\"float: right;\">&raquo;</strong></a></span>
                    <span class=\"proximo\"><a href=\"?pagina=" . ($this->pagina_atual() + 1) . "$params\" >Próxima <strong style=\"float: right;\">&raquo;</strong></a></span>";
        }
    }

    public function escreve_total() {

        if ($this->total_paginas() <= 1) {
            return "";
        }
        return "<div style=\"text-decoration: none;\" class=\"texto_paginacao_total\">Total de " . $this->total_paginas() . " p&aacute;ginas</div>";
    }

}

?>
