<?php

/**
 * Operações e Formatação de Imagens
 *
 * @author Ricardo Ribeiro Assink <ricardo@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 18/09/2009
 * @Ultima_Modif 18/09/2009 por Ricardo Ribeiro Assink
 *
 *
 * @package Libs
 *
 */
class Imagem {

    /**
     *
     * Reduz o tamanho da imagem de acordo com a largura máxima informada, se a imagem for menor o tamanho é mantido.
     *
     * @author Ricardo Ribeiro Assink
     * @param String $diretorio Diretório onde está a imagem
     * @param String $nome Nome do arquivo
     * @param Int $largura Largura máxima que a imagem deverá assumir
     * @param Int $qualidade Qualidade da imagem de 0 a 100
     * @return void
     *
     */
    public function resizeImage($diretorio, $nome, $largura = 600, $qualidade = 90) {

        $img = $this->createImage($diretorio, $nome);
        $img_x = ImageSX($img);
        $img_y = ImageSY($img);
        if ($img_x < $largura and $img_y < $largura) {
            //chmod($imagem, 777);
        } else {
            if ($img_x > $img_y) {
                $scale = $img_x / $largura;
            } else {
                $scale = $img_y / $largura;
            }
            $img_nova = ImageCreatetruecolor((ImageSX($img) / $scale), (ImageSY($img) / $scale));
            ImageCopyResampled($img_nova, $img, 0, 0, 0, 0, (ImageSX($img) / $scale), (ImageSY($img) / $scale), ImageSX($img), ImageSY($img));
            $this->replaceImage($diretorio, $nome, $img_nova, $qualidade);
            ImageDestroy($img_nova);
            ImageDestroY($img);
            //chmod($imagem, 0777);
        }
        return true;
    }

    public function resizeMinImage($diretorio, $nome, $larguramin = 250, $qualidade = 90) {
        $img = $this->createImage($diretorio, $nome);
        $img_x = imagesX($img); //width
        $img_y = imagesY($img); //height
        if ($img_x > $larguramin || $img_y > $larguramin) {
            if ($img_x < $img_y) { //Se a altura > largura
                $img_nova = ImageCreatetruecolor($img_y, $img_y);
                $color = imagecolorallocate($img_nova, 255, 255, 255);
                imagefill($img_nova, 0, 0, $color);
                chmod($img_nova, 0777);
                $dista_x = ($img_y / 2 - $img_x / 2);
                ImageCopyResampled($img_nova, $img, $dista_x, 0, 0, 0, $img_x, $img_y, $img_x, $img_y);
            } else if ($img_x > $img_y) { //contrario  largura > altura .
                $img_nova = ImageCreatetruecolor($img_x, $img_x);
                $color = imagecolorallocate($img_nova, 255, 255, 255);
                imagefill($img_nova, 0, 0, $color);
                chmod($img_nova, 0777);
                $dista_y = ($img_x / 2 - $img_y / 2);
                ImageCopyResampled($img_nova, $img, 0, $dista_y, 0, 0, $img_x, $img_y, $img_x, $img_y);
            }
        } else { //imagem é menor que o tamanho minimo
            $img_nova = ImageCreatetruecolor($larguramin, $larguramin);
            $color = imagecolorallocate($img_nova, 255, 255, 255);
            imagefill($img_nova, 0, 0, $color);
            chmod($img_nova, 0777);
            $dista_x = ($larguramin / 2 - $img_x / 2);
            $dista_y = ($larguramin / 2 - $img_y / 2);
            ImageCopyResampled($img_nova, $img, $dista_x, $dista_y, 0, 0, $img_x, $img_y, $img_x, $img_y);
        }
        $this->replaceImage($diretorio, $nome, $img_nova, $qualidade);
        ImageDestroy($img);
        return true;
    }

    public function forceResize($diretorio, $nome, $largura, $altura, $qualidade = 90) {

        $img = $this->createImage($diretorio, $nome);
        $img_x = ImageSX($img);
        $img_y = ImageSY($img);
        $img_nova = ImageCreatetruecolor($largura, $altura);
        ImageCopyResampled($img_nova, $img, 0, 0, 0, 0, $largura, $altura, ImageSX($img), ImageSY($img));
        $this->replaceImage($diretorio, $nome, $img_nova, $qualidade);
        ImageDestroy($img_nova);
        ImageDestroY($img);
        chmod($imagem, 0777);
        return true;
    }

    public function makeThumb($diretorio, $nome, $largura = 100) {

        $img = $this->createImage($diretorio, $nome);
        $img_x = ImageSX($img);
        $img_y = ImageSY($img);
        if ($img_x > $largura or $img_y > $largura) {
            if ($img_y > $img_x) {
                $scale = $img_y / $largura;
            } else {
                $scale = $img_x / $largura;
            }
        } else {
            $scale = 1;
        }
        $img_nova = ImageCreatetruecolor((ImageSX($img) / $scale), (ImageSY($img) / $scale));
        ImageCopyResampled($img_nova, $img, 0, 0, 0, 0, (ImageSX($img) / $scale), (ImageSY($img) / $scale), ImageSX($img), ImageSY($img));

        // Mostrando a imagem ja redefinida

        Header("Content-disposition: filename=$img_nova");
        Header("Content-Type: image/jpeg");
        ImageInterlace($img_nova, 1);
        ImageJpeg($img_nova, NULL, 90);
        ImageDestroy($img_nova);
        ImageDestroY($img);
    }

    public function crop($diretorio, $nome, $x1, $y1, $w, $h, $largura = 640, $altura = 410) {
        $imagem = $this->createImage($diretorio, $nome);
        $nome = trim(strtolower(substr($nome, 5)));
        $img_nova = imagecreatetruecolor($largura, $altura); //Cria a imagem de saida
        imagecopyresampled($img_nova, $imagem, 0, 0, $x1, $y1, $largura, $altura, $w, $h);
        $this->replaceImage($diretorio, $nome, $img_nova, 100);
    }

    public function crop_auto($diretorio, $nome, $largura = 640, $altura = 410) {
        $nome_imagem = $diretorio . $nome;
        $tamanho_src = getimagesize($nome_imagem);
        $src_prop = $tamanho_src[0] / $tamanho_src[1];
        $dst_prop = $largura / $altura;
        //Posição de corte
        $srcX = 0;
        $srcY = 0;
        $dstX = 0;
        $dstY = 0;
        if ($src_prop > $dst_prop) {
            $srcX = round(($tamanho_src[0] - ($tamanho_src[1] * $largura / $altura)) / 2);
            $tamanho_src[0] = $tamanho_src[1] * $dst_prop;
        } elseif ($src_prop < $dst_prop) {
            $srcY = round(($tamanho_src[1] - ($tamanho_src[0] * $altura / $largura)) / 2);
            $tamanho_src[1] = $tamanho_src[0] / $dst_prop;
        }
        $this->crop($diretorio, $nome, $srcX, $srcY, $tamanho_src[0], $tamanho_src[1], $largura, $altura);
    }

    private function createImage($diretorio, $nome) {

        $ext = trim(strtolower(substr($nome, -3)));
        $imagem = $diretorio . $nome;

        if ($ext == "jpg") {
            $img = imagecreateFromjpeg("$imagem");
        }
        if ($ext == "gif") {
            $img = imagecreatefromgif("$imagem");
        }
        if ($ext == "png") {
            $img = imagecreatefrompng("$imagem");
        }
        return $img;
    }

    private function replaceImage($diretorio, $nome, $img_nova, $qualidade) {

        $ext = trim(strtolower(substr($nome, -3)));
        $imagem = $diretorio . $nome;

        if ($ext == "jpg") {
            @unlink("$imagem");
            ImageJpeg($img_nova, $imagem, $qualidade);
        }
        if ($ext == "gif") {
            @unlink("$imagem");
            ImageGif($img_nova, $imagem);
        }
        if ($ext == "png") {
            @unlink("$imagem");
            imagepng($img_nova, $imagem);
        }
    }

}
?>
