<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * Configurar a aplicação
 *
 * @author Marcio Figueredo <marcio@equipedigital.com>
 * @copyright Copyright (c) 2016-2019, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 16/05/2016
 *
 * @package Config
 *
 */
class Config
{

    public $cliente = "SINDIASEA";
    public $dominio = "http://sindiasea.org.br";
    public $email = "sindiasea@sindiasea.org.br";

    /**
     * @var String Usuário da factory de objetos Mysql
     */
    public $Mysql_user = 'sindiase_1';
    //    public $Mysql_user = 'root';

    /**
     * @var String Senha da factory de objetos Mysql
     */
    public $Mysql_pass = 'equipe12qwasZX';
    //    public $Mysql_pass = 'rootpass';

    /**
     * @var String Database da factory de objetos Mysql
     */
    public $Mysql_db = 'sindiase_1';
    //    public $Mysql_db = 'sindiasea';

    /**
     * @var String HOST da factory de objetos Mysql
     */
    public $Mysql_host = 'localhost';

    /**
     * Configuração da Classe de Envio de E-mail
     *
     * OBS:
     * Se for Google Apps
     *   1. Acessar o link abaixo e ativar a permissão de uso:
     *      https://www.google.com/settings/security/lesssecureapps
     *
     *   2. Em Seguida executar a configuração a seguir:
     *      public $email_host = "smtp.gmail.com";
     *      public $email_username = "equipedigital@DOMINIO";
     *      public $email_password = "equipeqwas";
     *      public $email_port = 465;
     *      public $email_secure = 'ssl';
     */
    public $email_host = "mail.sindisea.org.br"; //smtp.equipedigital.info
    public $email_username = "no-reply@sindisea.org.br";
    public $email_password = "equipeqwasZX!@";
    public $email_port = 587; // Para ssl port 465 | Para tls port 587
    // public $email_secure = 'tls'; // tls
    //    public $email_host = "smtp.equipedigital.info";
    //    public $email_username = "noreply@equipedigital.info";
    //    public $email_password = "equipeqwasZX!@";
    //    public $email_port = 587;
    //    public $email_secure = 'tls';

    /**
     * @var $galerias_destaques configura número de Galerias Destaques na capa
     */
    public $galerias_destaques = 3;

    /**
     * @var $noticias_destaque configura número de Post Destaques na capa
     */
    public $noticias_destaque = 6;

    /**
     * @var $produtos_destaques configura número de Produtos Destaques na capa
     */
    public $produtos_destaques = 0;
    public $slider_destaque = 1;
    public $gestao_destaque = 1;

    /**
     * @var $num_passos define número de passos para inserção de Posts
     */
    public $num_passos = 4;
    public $assinatura_mailing = "";

    /**
     * Configura??o da lista de hiperlinks do sistema
     * O elemento do array contem a String que representa o link,
     * n?o modifique os 5 primeiros elementos do array, apenas comente
     * as linhas que n?o ser?o utilizadas.
     *
     * Para novos m?dulos, adicione no final, como no exemplo abaixo:
     * o ?ndice cont?m o o link, e o elemento uma string que representa o link.
     */
    public $modulos = array(
        'NOTICIAS' => 'Noticias',
        'GALERIAS' => 'Galerias de Fotos',
        'VIDEOS' => 'Videos',
        'POSTS' => 'Posts',
        'CONTATOS' => 'Contatos',
    );
    public $tema = 1;

    /**
     * @var String determina qual o factory de banco de dados os DAOs devem pedir
     */
    public $banco = 'AF_Bd_Mysql';

    /**
     * $var $path indica onde arquivos são inserido para download TinyMCE
     */
    public $path = "/sistema/sys/componente_comum/tinymce/plugins/filemanager/source/";

    public function __construct()
    {
    }

    /**
     * @ignore
     */
    public function get_cliente()
    {
        return $this->cliente;
    }

    /**
     * @ignore
     */
    public function get_email()
    {
        return $this->email;
    }

    /**
     * @ignore
     */
    public function get_dominio()
    {
        return $this->dominio;
    }

    /**
     * @ignore
     */
    public function get_tema()
    {
        return $this->tema;
    }

    /**
     * @ignore
     */
    public function set_tema($tema)
    {
        $this->tema = $tema;
    }

    /**
     * @ignore
     */
    public function get_banco()
    {
        return $this->banco;
    }

    /**
     * @ignore
     */
    public function get_Mysql_user()
    {
        return $this->Mysql_user;
    }

    /**
     * @ignore
     */
    public function get_Mysql_pass()
    {
        return $this->Mysql_pass;
    }

    /**
     * @ignore
     */
    public function get_Mysql_db()
    {
        return $this->Mysql_db;
    }

    /**
     * @ignore
     */
    public function get_Mysql_host()
    {
        return $this->Mysql_host;
    }

    /**
     * @ignore
     */
    public function get_modulos()
    {
        return $this->modulos;
    }

    /**
     * @ignore
     */
    public function get_produtos_destaques()
    {
        return $this->produtos_destaques;
    }

    /**
     * @ignore
     */
    public function get_galerias_destaques()
    {
        return $this->galerias_destaques;
    }

    /**
     * @ignore
     */
    public function get_noticias_destaque()
    {
        return $this->noticias_destaque;
    }

    /**
     * @ignore
     */
    public function get_slider_destaque()
    {
        return $this->slider_destaque;
    }

    /**
     * @ignore
     */
    public function get_gestao_destaque()
    {
        return $this->gestao_destaque;
    }

    /**
     * @ignore
     */
    public function get_assinatura_mailing()
    {
        return $this->assinatura_mailing;
    }

    /**
     * @ignore
     */
    public function get_num_passos()
    {
        return $this->num_passos;
    }

    /**
     * @ignore
     */
    public function get_path()
    {
        return $this->path;
    }

    /**
     * @ignore
     */
    public function get_email_host()
    {
        return $this->email_host;
    }

    /**
     * @ignore
     */
    public function get_email_username()
    {
        return $this->email_username;
    }

    /**
     * @ignore
     */
    public function get_email_password()
    {
        return $this->email_password;
    }

    /**
     * @ignore
     */
    public function get_email_port()
    {
        return $this->email_port;
    }

    /**
     * @ignore
     */
    public function get_email_secure()
    {
        return $this->email_secure;
    }

    /**
     * @ignore
     */
    public function get_DAO($classe)
    {
        $dao = $classe . "_DAO";
        return new $dao($this->banco);
    }
}
