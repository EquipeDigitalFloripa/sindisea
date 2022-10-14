<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

/**
 * View PAI
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
 * @package View
 *
 */
class View {

    /**
     * @var String Tema configurado na Classe Config
     * @see Config
     */
    protected $tema;

    /**
     * @var Objeto Objeto da classe Menu
     * @see Menu
     */
    protected $menu;

    /**
     * @var Objeto Objeto da classe Data
     * @see Data
     */
    protected $dat;

    /**
     * @var Objeto Objeto da classe Usuario, válido apenas para o Usuário Corrente
     * @see Usuario
     */
    protected $user;

    /**
     * @var Objeto Objeto da classe Sessao, válido apenas para a Sessão Corrente
     * @see Traducao
     */
    protected $sess;

    /**
     * @var String ID da sessão encriptado
     */
    protected $id_sessao;

    /**
     * @var String Idioma escolhido pelo Usuário
     */
    protected $idioma;

    /**
     * @var Objeto Objeto da classe Traducao
     * @see Traducao
     */
    protected $traducao;

    /**
     * @var Array Array com o merge de _POST e _REQUEST
     */
    protected $post_request;

    /**
     * @var int Total de registros para paginação
     */
    protected $total_reg;

    /**
     * @var Array Array de Objetos para lista
     */
    protected $objetos;

    /**
     * @var int Total de registros por página
     */
    protected $pag_views;

    /**
     * @var Array Array com as descrições de campos da entidade
     */
    protected $descricoes;

    /**
     * @var Objeto Objeto da classe Form_Helper
     * @see Form_Helper
     */
    protected $form;

    /**
     * @var Objeto Objeto da classe Imagem
     */
    protected $image;
    protected $dominio;
    protected $associacao;
    protected $detect;

    /**
     * Retorna o idioma corrente
     *
     * @author Ricardo Ribeiro Assink
     * @return String Retorna o idioma corrente
     */
    public function get_idioma() {
        return $this->idioma;
    }

    /**
     * Seta o idioma corrente, se nenhum for escolhido retorna PT
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     */
    public function set_idioma($idioma) {
        if ($idioma == "") {
            $this->idioma = "PT";
        } else {
            $this->idioma = $idioma;
        }
    }

    /**
     * Retorna o tema configurado em Config
     *
     * @author Ricardo Ribeiro Assink
     * @return String Retorna o tema configurado em Config
     * @see Config
     */
    public function get_tema() {
        return $this->tema;
    }

    /**
     * @ignore
     */
    public function set_tema($tema) {
        $this->tema = $tema;
    }

    /**
     * Retorna o id de sessão encriptado
     *
     * @author Ricardo Ribeiro Assink
     * @return String Retorn o id de sessão encriptado
     */
    public function get_id_sessao() {
        return $this->id_sessao;
    }

    /**
     * @ignore
     */
    public function set_id_sessao($id_sessao) {
        $this->id_sessao = $id_sessao;
    }

    /**
     * @ignore
     */
    public function get_post_request() {
        return $this->post_request;
    }

    /**
     * @ignore
     */
    public function set_post_request($post_request) {
        $this->post_request = $post_request;
    }

    /**
     * @ignore
     */
    public function get_descricoes() {
        return $this->descricoes;
    }

    /**
     * @ignore
     */
    public function set_descricoes($descricoes) {
        $this->descricoes = $descricoes;
    }

    /**
     * @ignore
     */
    public function get_pag_views() {
        return $this->pag_views;
    }

    /**
     * @ignore
     */
    public function set_pag_views($pag_views) {
        $this->pag_views = $pag_views;
    }

    /**
     * @ignore
     */
    public function get_objetos() {
        return $this->objetos;
    }

    /**
     * @ignore
     */
    public function set_objetos($objetos) {
        $this->objetos = $objetos;
    }

    /**
     * @ignore
     */
    public function getTotal_reg() {
        return $this->total_reg;
    }

    /**
     * @ignore
     */
    public function setTotal_reg($total_reg) {
        $this->total_reg = $total_reg;
    }

    public function get_dominio() {
        return $this->dominio;
    }

    public function set_dominio($dominio) {
        $this->dominio = $dominio;
    }

    public function get_associacao() {
        return $this->associacao;
    }

    public function set_associacao($associacao) {
        $this->associacao = $associacao;
    }

    /**
     * Carrega o contrutor.
     *
     * @author Ricardo Ribeiro Assink
     * @return void
     * @Exemplo
     * <code>
     *
     *   public function __construct() {
     *       $config = new Config();
     *       $this->set_tema($config->get_tema());
     *
     *       $this->menu     = new Menu();
     *       $this->dat      = new Data();
     *       $this->sess     = new Sessao();
     *       $this->traducao = new Traducao();
     *
     *       $this->sess->loadSessao($id_sessao);
     *       $user_dao       = $config->get_DAO("Usuario");
     *       $this->user     = $user_dao->loadObjeto($this->sess->get_id_usuario());
     *
     *       $this->set_id_sessao($id_sessao);
     *       $this->set_idioma($idioma);
     *   }
     *
     * </code>
     *
     */
    public function __construct($post_request, $objetos = null, $descricoes = null, $total_reg = 1, $pag_views = 1, $associacao = null) {

        $this->post_request = $post_request;
        $config = new Config();
        $this->set_tema($config->get_tema());
        $this->set_dominio($config->get_dominio());

        $this->menu = new Menu();
        $this->dat = new Data();
        $this->sess = new Sessao();
        $this->traducao = new Traducao();
        $this->image = new Imagem();
        $this->form = new Form_Helper();

        $id_sessao = (isset($this->post_request['id_sessao'])) ? $this->post_request['id_sessao'] : "";
        $this->sess->loadSessao($id_sessao);
        $user_dao = $config->get_DAO("Usuario");
        $this->user = $user_dao->loadObjeto($this->sess->get_id_usuario());

        $this->set_id_sessao($id_sessao);
        $this->set_idioma((isset($this->post_request['idioma'])) ? $this->post_request['idioma'] : "");

        $this->setTotal_reg($total_reg);
        $this->set_objetos($objetos);
        $this->set_pag_views($pag_views);
        $this->set_descricoes($descricoes);
        $this->set_associacao($associacao);
    }

    /**
     * Cria o Cabeçalho HTML
     *
     * @author Ricardo Ribeiro Assink
     * @return String HTML do Cabeçalho
     */
    public function criaCabecalho() {

//        $cabecalho = "
//<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
//<html xmlns=\"http://www.w3.org/1999/xhtml\">\n\n";
//        
        $cabecalho = "       <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n\n";
        return $cabecalho;
    }

    /**
     * Cria os MetaTags HTML
     *
     * @author Ricardo Ribeiro Assink
     * @return String HTML dos MetaTags
     */
    public function criaMetaTags() {


        $meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">\n
                <meta http-equiv=\"cache-control\" content=\"no-cache\" />\n\n";
        return $meta;
    }

    /**
     * Cria a chamada dos arquivos CSS em HTML
     *
     * @author Ricardo Ribeiro Assink
     * @return String HTML das chamadas de arquivos CSS
     */
    public function criaCss() {

        $tema = $this->get_tema();
//
        $css = "";

        $css .= "<link href=\"temas/$tema/site.css\" rel=\"stylesheet\" type=\"text/css\" />";
        $css .= "<link href=\"temas/$tema/site.css\" rel=\"stylesheet\" type=\"text/css\" />";

        $css .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"temas/$tema/menu/ddsmoothmenu.css\" />
                <link rel=\"stylesheet\" href=\"componente_comum/amplia/lightbox.css\" type=\"text/css\" media=\"screen\" />";

        $css .= "<!--[if lte IE 7]>
                <style type=\"text/css\">
                html .ddsmoothmenu{height: 1%;} /*Holly Hack for IE7 and below*/
                </style>
                <![endif]-->";

        $css .= "<link rel=\"stylesheet\" href=\"temas/$tema/modal/modal-message.css\" type=\"text/css\">\n\n";

        return $css;
    }

    /**
     * Cria as chamadas de arquivos js em HTML
     *
     * @author Ricardo Ribeiro Assink
     * @return String HTML das chamadas de arquivo js
     */
    public function criaJs() {

        $tema = $this->get_tema();
        $js = "
            <script src=\"includes/jquery-3.3.1.min.js\"></script>
            <script language=\"JavaScript\" type=\"text/javascript\" src=\"temas/$tema/modal/ajax.js\"></script>
            <script language=\"JavaScript\" type=\"text/javascript\" src=\"temas/$tema/modal/modal-message.js\"></script>
            <script language=\"JavaScript\" type=\"text/javascript\" src=\"temas/$tema/modal/ajax-dynamic-content.js\"></script>
            <script language=\"JavaScript\" type=\"text/javascript\" src=\"includes/site.js\"></script>
            <script language=\"JavaScript\" type=\"text/javascript\" src=\"includes/jquery.mask.js\"></script>
            <script language=\"JavaScript\" type=\"text/javascript\" src=\"includes/jquery.validate.js\"></script>
            <script language=\"JavaScript\" type=\"text/javascript\" src=\"includes/AC_RunActiveContent.js\"></script>    
            <script language=\"JavaScript\" type=\"text/javascript\" src=\"componente_comum/amplia/modernizr.custom.js\"></script>
            <script language=\"JavaScript\" type=\"text/javascript\" src=\"componente_comum/amplia/lightbox.min.js\"></script>
            <script language=\"JavaScript\" type=\"text/javascript\" src=\"temas/$tema/menu/ddsmoothmenu.js\"></script>\n\n";
        return $js;
    }

    /**
     * Cria algumas funções Javascript estruturais do framework
     *
     * @author Ricardo Ribeiro Assink
     * @return String Algumas funções Javascript estruturais do framework
     */
    public function criaJssemLightbox() {

        $tema = $this->get_tema();
        $js = "
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"temas/$tema/modal/ajax.js\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"temas/$tema/modal/modal-message.js\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"temas/$tema/modal/ajax-dynamic-content.js\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"includes/site.js\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"includes/jquery.mask.js\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"includes/jquery.validate.js\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"includes/AC_RunActiveContent.js\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"componente_comum/amplia/prototype.js\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"componente_comum/amplia/scriptaculous.js?load=effects\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"includes/jquery-1.4.2.min.js\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"temas/$tema/menu/jquery.min.js\"></script>
                <script language=\"JavaScript\" type=\"text/javascript\" src=\"temas/$tema/menu/ddsmoothmenu.js\"></script>";


        return $js;
    }

    public function criaJavascript() {

        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();
        $tema = $this->get_tema();

        if ($idioma == "" or $idioma == "PT") {
            $q0 = "";
        } else {
            $q0 = "_en";
        }

        $jav = "
            <script language=\"JavaScript\" type=\"text/javascript\">\n\n";

        $jav .= "
                MM_preloadImages(
                    'temas/$tema/icones/carregando.gif',
                    'temas/$tema/modal/fundo_modal_processando" . $q0 . ".jpg',
                    'temas/$tema/modal/fundo_modal_erro" . $q0 . ".jpg',
                    'temas/$tema/modal/fundo_modal_alerta" . $q0 . ".jpg',
                    'temas/$tema/modal/fundo_modal_pergunta" . $q0 . ".jpg',
                    'temas/$tema/modal/fundo_modal_sair" . $q0 . ".jpg',
                    'temas/$tema/modal/fundo_modal_sucesso" . $q0 . ".jpg',
                    'temas/$tema/modal/progress.png'
                );\n\n";

        $jav .= "
                function sair(ver){
                    if(ver){
                        location.href=\"logout.php?id_sessao=$id_sessao\";
                    }
                 }\n\n";

        $jav .= "
                function set_campo(campo,valor){
                    document.getElementById(campo).value = valor;
                 }\n\n";

        $jav .= "
                function submit_campo(id,ac){
                    set_campo('id',id);
                    set_campo('ac',ac);
                    go();
                 }\n\n";

        $jav .= "
                function submit_filtro(event,click){
                    if( event.keyCode==13 ||click == 'submit') {
                        set_campo('pagina','1');
                        validar();
                        //document.form1.submit();
                    }                 
                    
                 }\n\n";

        $jav .= "
                function limpar_filtro(){
                
                        $(':input','#form1')
                          .not(':button, :submit, :reset, :hidden')
                          .val('')
                          .removeAttr('checked')
                          .removeAttr('selected');                        
                                                  
                        validar();
                    
                 }\n\n";




        $msg = rawurlencode('document.form1.submit();');
        $jav .= "
                function go(){                    
                    displayMessage('temas/$tema/modal/msg_processando.php?tema=$tema&idioma=$idioma&msg=$msg');                        
                    displayMessage                    
                 }\n\n";

        $jav .= "
                messageObj = new DHTML_modalMessage();
                //messageObj.setShadowOffset(5);\n\n";


        $jav .= "
            </script>\n\n";

        return $jav;
    }

    /**
     * Cria o Título da página HTML
     *
     * @author Ricardo Ribeiro Assink
     * @return String Título da página HTML
     */
    public function criaTitulo() {

        return "<title>EquipeDigital.com - Área Restrita</title>";
    }

    /**
     * Cria um Título para página 
     *
     * @author Marcio Figueredo
     * @return String Título da página 
     */
    public function criaTituloPagina($titulo) {
        $pg = "<div class=\"titulo_pagina\">
                <div class=\"icone\"><p>$titulo</p></div>
            </div>";
        return $pg;
    }

    /**
     * Cria as chamadas de componentes externos como TOOLTIP, CALENDAR, etc.
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $componentes Array de componentes configurado nas views filhas
     * @return String HTML das chamadas de componentes externos
     * @see View::criaInfo()
     *
     * @exemplo
     * <code>
     *
     *  // na classe filha de View se faz a configuração dos parâmetros e a chamada do método
     *
     *   $componentes      = Array("TOOLTIP"); // adicionar ao Array o nome dos componentes
     *
     *   // Neste exemplo, o item do template é configurado com o componente.
     *   // Adiciona a página HTML os respectivos códigos Javascript para possibilitar o funcionamento do componente
     *   $tpl->COMPONENTES = $this->criaComponentes($componentes);
     *
     *
     *   // Neste caso o componente TOOLTIP foi adicionada mas para usá-lo é necessário criar conteúdo para o TOOLTIP
     *   // Usamos a função criaInfo() para criar conteúdo para o TOOLTIP
     *
     *           // As linhas seguem  $inf['nome_do_campo'] = "$valor_do_campo";
     *           // Exemplo:          $inf['Nome do Usuário: '] = "Ricardo R. A";
     *           $inf = Array();
     *           $inf["".$this->traducao->get_leg21().""] = $dados['nome_usuario'];
     *           $inf["".$this->traducao->get_leg22().""] = $this->descricoes['desc_perm_usuario'][$dados['perm_usuario']]; // pega a descrição da permissão do usuário
     *           $inf["".$this->traducao->get_leg23().""] = $dados['login_usuario'];
     *           $inf["".$this->traducao->get_leg24().""] = $dados['email_usuario'];
     *           $inf["".$this->traducao->get_leg25().""] = $dados['cidade_usuario'];
     *           $inf["".$this->traducao->get_leg26().""] = $dados['pais_residencia_usuario'];
     *           $inf["".$this->traducao->get_leg27().""] = $dados['instituicao_usuario'];
     *           $inf["".$this->traducao->get_leg28().""] = $dados['local_instituicao_usuario'];
     *
     *           $infos = $this->criaInfo($inf);
     *
     *     // A variável $infos será adicionada a um dos itens da tabela nas ações de gerenciamento.
     *     // Quando o usuário colocar o mouse em cima do link o TOOLTIP será mostrado.
     *
     * </code>
     */
    public function criaComponentes($componentes) {

        $tema = $this->get_tema();
        $idioma = $this->get_idioma();
        $comp = $string = "";
        $i = 0;
        if (count($componentes) > 0) {

            if (in_array("TOOLTIP", $componentes)) {
                $comp .= "<script type=\"text/javascript\" src=\"temas/$tema/boxover/boxover.js\"></script>";
            }

            if (in_array("DTREE", $componentes)) {
                $comp .= "
                        <link href=\"componente_comum/dtree/dtree.css\" rel=\"stylesheet\" type=\"text/css\">
                        <script type=\"text/javascript\" src=\"componente_comum/dtree/dtree.js\"></script>
                        ";
            }
            if (in_array("TINYMCE_CONTEUDO", $componentes)) {
                /*           mode : \"exact\",
                 *           elements : \"conteudo\",
                  editor_selector : \"conteudo\",
                 */
                if (strtolower($idioma) == 'pt') {
                    $idioma = 'pt_BR';
                }
                if (is_array($this->descricoes['urls'])) {
                    foreach ($this->descricoes['urls'] as $key => $value) {
                        if ($key == 0) {
                            $string = "{title: '$value[0]', value: '/$value[1]'}";
                        } else {
                            $string .= ",{title: '$value[0]', value: '/$value[1]'}";
                        }
                    }
                }

                /*
                 * LE ARQUIVOS E MONTA A LISTA DE ARQUIVOS PARA LINKS NO TINYMCE
                 */
                $diretorio = dir('./componente_comum/tinymce/plugins/filemanager/source/');
                while ($arquivo = $diretorio->read()) {
                    if (!is_dir($arquivo)) {
                        $arrayArquivos[strtolower($arquivo)] = $arquivo;
                    }
                }
                $diretorio->close();

                //ORDENA ARQUIVOS EM ORDEM CRESCENTE
                ksort($arrayArquivos, SORT_STRING);
                foreach ($arrayArquivos as $valorArquivos) {
                    $value = "http://" . $_SERVER['HTTP_HOST'] . "/sistema/sys/" . $diretorio->path . $valorArquivos;
                    $string .= ",{title: '$valorArquivos', value: '$value'}";
                }
                /*
                 * FIM
                 */


                $comp .= "
                    <script type=\"text/javascript\" src=\"componente_comum/tinymce/tinymce.min.js\"></script>
                    <script type=\"text/javascript\">
                        tinymce.init({                            
                            selector: \"textarea.tinymce\",
                            theme: \"modern\",                        
                            height : 300,                        
                            convert_newlines_to_brs : false,                            
                            force_p_newlines : false,
                            force_br_newlines : false,
                            paste_auto_cleanup_on_paste : true,
                            paste_create_paragraphs : false,
                            convert_urls : false,
                            language : '$idioma',
                            image_advtab: true,  
                            fontsize_formats: \"8px 10px 12px 14px 16px 18px 20px 22px 24px 26px 28px 30px\",                            
                            plugins: [
                                \"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker\",
                                \"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking\",
                                \"insertdatetime table contextmenu paste filemanager textcolor\"
                            ],
                            link_list: [
                                $string
                            ],
                            toolbar: \"insertfile undo redo | styleselect | fontsizeselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | media\",                                                     
                        });
                    </script>";
            }

            if (in_array("TINYMCE_MAILING", $componentes)) {
                /*           mode : \"exact\",
                 *           elements : \"conteudo\",
                  editor_selector : \"conteudo\",
                 */
                if (strtolower($idioma) == 'pt') {
                    $idioma = 'pt_BR';
                }
                foreach ($this->descricoes['urls'] as $key => $value) {
                    if ($key == 0) {
                        $string = "{title: '$value[0]', value: '/$value[1]'}";
                    } else {
                        $string .= ",{title: '$value[0]', value: '/$value[1]'}";
                    }
                }

                /*
                 * LE ARQUIVOS E MONTA A LISTA DE ARQUIVOS PARA LINKS NO TINYMCE
                 */
                $diretorio = dir('./componente_comum/tinymce/plugins/filemanager/source/');
                while ($arquivo = $diretorio->read()) {
                    if (!is_dir($arquivo)) {
                        $arrayArquivos[strtolower($arquivo)] = $arquivo;
                    }
                }
                $diretorio->close();

                //ORDENA ARQUIVOS EM ORDEM CRESCENTE
                ksort($arrayArquivos, SORT_STRING);
                foreach ($arrayArquivos as $valorArquivos) {
                    $value = "http://" . $_SERVER['HTTP_HOST'] . "/sistema/sys/" . $diretorio->path . $valorArquivos;
                    $string .= ",{title: '$valorArquivos', value: '$value'}";
                }
                /*
                 * FIM
                 */


                $comp .= "
                    <script type=\"text/javascript\" src=\"componente_comum/tinymce/tinymce.min.js\"></script>

                    <script type=\"text/javascript\">
                        tinymce.init({                            
                            selector: \"textarea.tinymce\",
                            theme: \"modern\",                        
                            height : 300,                        
                            convert_newlines_to_brs : false,                            
                            force_p_newlines : false,
                            force_br_newlines : false,
                            paste_auto_cleanup_on_paste : true,
                            paste_create_paragraphs : false,
                            convert_urls : false,                            
                            language : '$idioma',    
                            image_advtab: true,  
                            fontsize_formats: \"8px 10px 12px 14px 16px 18px 20px 22px 24px 26px 28px 30px\",                            
                            plugins: [
                                \"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker\",
                                \"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking\",
                                \"insertdatetime table contextmenu paste filemanager textcolor\"
                            ],
                            link_list: [
                                $string
                            ],
                            toolbar: \"insertfile undo redo | styleselect | fontsizeselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | media\",                                                     
                        });
                    </script>
                    ";
            }

            if (in_array("TINYMCE_NEWS", $componentes)) {
                /*           mode : \"exact\",
                 *           elements : \"conteudo\",
                  editor_selector : \"conteudo\",
                 */
                if (strtolower($idioma) == 'pt') {
                    $idioma = 'pt_BR';
                }
                foreach ($this->descricoes['urls'] as $key => $value) {
                    if ($key == 0) {
                        $string = "{title: '$value[0]', value: '/$value[1]'}";
                    } else {
                        $string .= ",{title: '$value[0]', value: '/$value[1]'}";
                    }
                }

                /*
                 * LE ARQUIVOS E MONTA A LISTA DE ARQUIVOS PARA LINKS NO TINYMCE
                 */
                $diretorio = dir('./componente_comum/tinymce/plugins/filemanager/source/');
                while ($arquivo = $diretorio->read()) {
                    if (!is_dir($arquivo)) {
                        $arrayArquivos[strtolower($arquivo)] = $arquivo;
                    }
                }
                $diretorio->close();

                //ORDENA ARQUIVOS EM ORDEM CRESCENTE
                ksort($arrayArquivos, SORT_STRING);
                foreach ($arrayArquivos as $valorArquivos) {
                    $value = "http://" . $_SERVER['HTTP_HOST'] . "/sistema/sys/" . $diretorio->path . $valorArquivos;
                    $string .= ",{title: '$valorArquivos', value: '$value'}";
                }
                /*
                 * FIM
                 */

                $comp .= "
                    <script type=\"text/javascript\" src=\"componente_comum/tinymce/tinymce.min.js\"></script>

                    <script type=\"text/javascript\">
                       tinymce.init({                            
                            selector: \"textarea.tinymce\",
                            theme: \"modern\",                        
                            height : 300,                        
                            convert_newlines_to_brs : false,                            
                            force_p_newlines : false,
                            force_br_newlines : false,
                            paste_auto_cleanup_on_paste : true,
                            paste_create_paragraphs : false,
                            convert_urls : false,                            
                            language : '$idioma',    
                            image_advtab: true,  
                            fontsize_formats: \"8px 10px 12px 14px 16px 18px 20px 22px 24px 26px 28px 30px\",                            
                            plugins: [
                                \"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker\",
                                \"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking\",
                                \"insertdatetime table contextmenu paste filemanager textcolor\"
                            ],
                            link_list: [
                                $string
                            ],
                            toolbar: \"insertfile undo redo | styleselect | fontsizeselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | media\",                                                     
                        });
                    </script>
                    ";
            }


            //SE NÃO FORM MOBILE, MOSTRA MENU
            if (in_array("TINYMCE_EXACT", $componentes)) {
                if (strtolower($idioma) == 'pt') {
                    $idioma = 'pt_BR';
                }

                if (isset($this->descricoes['urls']) && is_array($this->descricoes['urls'])) {
                    foreach ($this->descricoes['urls'] as $key => $value) {
                        if ($key == 0) {
                            $string = "{title: '$value[0]', value: '/$value[1]'}";
                        } else {
                            $string .= ",{title: '$value[0]', value: '/$value[1]'}";
                        }
                    }
                }

                /*
                 * LE ARQUIVOS E MONTA A LISTA DE ARQUIVOS PARA LINKS NO TINYMCE
                 */
                $diretorio = dir('./componente_comum/tinymce/plugins/filemanager/source/');
                $valorArquivos = "";
                while ($arquivo = $diretorio->read()) {
                    if (!is_dir($arquivo)) {
                        $arrayArquivos[strtolower($arquivo)] = $arquivo;
                    }
                }
                $diretorio->close();

                //ORDENA ARQUIVOS EM ORDEM CRESCENTE
                if (is_array($valorArquivos)) {
                    ksort($arrayArquivos, SORT_STRING);
                    foreach ($arrayArquivos as $valorArquivos) {
                        $value = "http://" . $_SERVER['HTTP_HOST'] . "/sistema/sys/" . $diretorio->path . $valorArquivos;
                        $string .= ",{title: '$valorArquivos', value: '$value'}";
                    }
                }

                /*
                 * FIM
                 */


                $comp .= "
                    <script type=\"text/javascript\" src=\"componente_comum/tinymce/tinymce.min.js\"></script>

                    <script type=\"text/javascript\">
                        tinymce.init({                            
                            selector: \"textarea.tinymce\",
                            theme: \"modern\",                        
                            height : 300,                        
                            convert_newlines_to_brs : false,                            
                            force_p_newlines : false,
                            force_br_newlines : false,
                            paste_auto_cleanup_on_paste : true,
                            paste_create_paragraphs : false,
                            convert_urls : false,                            
                            language : '$idioma',    
                            image_advtab: true,  
                            fontsize_formats: \"8px 10px 12px 14px 16px 18px 20px 22px 24px 26px 28px 30px\",                            
                            plugins: [
                                \"advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker\",
                                \"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking\",
                                \"insertdatetime table contextmenu paste filemanager textcolor\"
                            ],
                            link_list: [
                                $string
                            ],
                            toolbar: \"insertfile undo redo | styleselect | fontsizeselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | media\",                                                     
                        });
                    </script>";
            }
//            }




            if (in_array("CALENDAR", $componentes)) {
                if ($idioma == "PT") {
                    $comp .= "
                        <link rel=\"stylesheet\" href=\"temas/$tema/calendar/calendar.css?random=20090909\" media=\"screen\"></link>
                        <SCRIPT type=\"text/javascript\" src=\"temas/$tema/calendar/calendar.js?random=20090909\"></script>
                        ";
                } else {
                    $comp .= "
                        <link rel=\"stylesheet\" href=\"temas/$tema/calendar/calendar.css?random=20090909\" media=\"screen\"></link>
                        <SCRIPT type=\"text/javascript\" src=\"temas/$tema/calendar/calendar_en.js?random=20090909\"></script>
                        ";
                }
            }


            if (in_array("COUNTER", $componentes)) {
                $comp .= "
                        <script type=\"text/JavaScript\">

                        function textCounter(field,counter,maxlimit,linecounter) {
                                // text width//
                                var fieldWidth =  parseInt(field.offsetWidth);
                                var charcnt = field.value.length;

                                // trim the extra text
                                if (charcnt > maxlimit) {
                                        field.value = field.value.substring(0, maxlimit);
                                }

                                else {
                                // progress bar percentage
                                var percentage = parseInt(100 - (( maxlimit - charcnt) * 100)/maxlimit) ;
                                var r = parseInt(100 - (( maxlimit - charcnt) * 100)/maxlimit) ;
                                var g = parseInt(100 - (( maxlimit - charcnt) * 100)/maxlimit) ;
                                var b = parseInt(100 - (( maxlimit - charcnt) * 100)/maxlimit) ;
                                document.getElementById(counter).style.width =  parseInt((fieldWidth*percentage)/100)+\"px\";
                                document.getElementById(counter).innerHTML=\"  \"+percentage+\"%\"
                                // color correction on style from CCFFF -> CC0000
                                setcolor(document.getElementById(counter),r,g,b,\"background-color\");
                                }
                        }

                        function setcolor(obj,r,g,b,prop){                                
                                //obj.style[prop] = \"rgb(\"+(10+percentage))+\"%,\"+(100-percentage)+\"%,\"+(100-percentage)+\"%)\";
                                r = (r*2)+70;
                                g = 130-g;
                                b = 180-b;
                                if(g == 30){g = 0;}
                                if(b == 80){b = 0;}
                                obj.style[prop] = \"rgb( \"+r+\", \"+g+\", \"+b+\")\";                                                               
                        }

                        </script>
                        ";
            }

            if (in_array("RESIZETEXTAREA", $componentes)) {
                $comp .= "
                        <script type=\"text/JavaScript\">

                        function resizeTextArea(){
                            var niLin_ = 0;

                            for (var i=0; i < document.getElementsByTagName(\"TEXTAREA\").length; i++){
                                var area = document.getElementsByTagName(\"TEXTAREA\")[i];
                                Tam = trim(area.value);
                                nLin = Math.round(Tam.length/60);
                                nLin = nLin * 18;

                                if(nLin == 0 || nLin == \"\" || nLin < 18){
                                    area.style.height = 18 + \"px\";
                                    area.style.width = \"96%\";
                                }else{
                                    //nLin = nLin + 36;
                                    area.style.height = nLin +\"px\";
                                    area.style.width = \"96%\";
                                }
                            }
                        }
                        </script>";
            }
        }
        return $comp;
    }

    /**
     * Cria o HTML de navegação do sistema
     *
     * @author Ricardo Ribeiro Assink
     * @param String $retorno_nav String com os parâmetros de retorno
     * @param String $control_div SIM|NAO determina se alguma div interna deve ser escondida ao chamar modais
     * @return String HTML de navegação do sistema
     */
    public function criaMenu() {

        $perm_usuario = $this->user->get_perm_usuario();
        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();
        $this->menu->loadMenu($perm_usuario, $id_sessao, $idioma);
        $men = $this->menu->criaMenu();

        return $men;
    }

    public function criaDivLista($tamanho, $quantidade, $title_tab, $botoes = array(), $titulo = '', $texto = '') {
        $numero = 0;
        while ($numero < count($quantidade)) {
            $bloco = $quantidade[$numero];
            foreach ($bloco as $col) {// aqui da o numero de colunas
                $tabela .= "" . $col["texto"] . "";
            }
            $numero++;
        }

        $tema = $this->get_tema();
        $colspan = count($col);
        $bgtitle = "url(temas/$tema/topotabela.jpg)";
        $bgbutton = "transparent";
        if ($tam_tab < 500) {
            $tam_tab = 500;
        }
        $data_atual = $this->dat->get_dataFormat("NOW", "", "LUMA");
        $ret_form = "
 <style>
        #listadiv{
    text-decoration: none;
    list-style: none;
}

#listadiv li{
    width:190px;
    height:190px;
    padding:8px;
    float:left;
    margin:auto;
    /*cursor: move;*/
}

#listadiv li img{
        margin:auto;
    cursor: move;
}
    </style>

                    <br><table width=\"$tamanho\" border=\"0\" align=\"center\" cellpadding=\"1\" class=\"table\" cellspacing=\"1\" >
                        <tr>
                            <td  style=\"border-radius:6px; background:$bgtitle\">
                                <div style=\"position:relative;\">
                                <div class=\"infoicon\"><img style=\"float:left; left:2px; top:1px; position:absolute;\"  src=\"temas/$tema/info.png\">
                                    <div class=\"infoacao\"><div class=\"seta-cima\"></div>
                                     <table>
                                        <td width=\"8%\" valign=\"center\" >
                                            <img src=\"temas/$tema/info2.png\" width=\"30\" height=\"30\" style=\"padding-right:10px\">
                                        </td> 
                                     <td width=\"92%\" >
                                            <div align=\"left\">
                                                <span class=\"texto_titulo_ferramenta\">
                                                    $titulo
                                                </span>
                                            </div>
                                            <div align=\"left\">
                                                <span class=\"texto_ferramenta\">
                                                    $texto
                                                </span>
                                            </div>
                                    </td>       
                                    </table>
                                            </div>
                                    </div>
                                <div style=\"float:right; position:absolute; top:2px; right:8px; font-size:8px; line-height:10px; color:white;  height:20px; padding-left:26px; margin-top:3px; line-height:20px; background: url(temas/$tema/icones/relogio.png) left no-repeat;\">$data_atual</div>
                                <div align=\"center\" class=\"texto_titulo_tabela\">
                                $title_tab
                                </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                        <td></td>
                        </tr>
                                                                <tr align=\"center\" bgcolor=\"#ffffff\">
                                            <td align=\"center\"><div id=\"conteudodragdrop\" style=\"margin-left:0%\"><ul id=\"listadiv\">$tabela</ul></div></td>
                                </tr></table>
                    ";
        $ret_form .= "
                        <tr>
                            <td colspan=\"" . $colspan . "\" style=\"background:$bgbutton\">
                                <div align=\"center\">
";


        foreach ($botoes as $valor) {
            $ret_form .= "$valor";
        }


        $ret_form .= "     </div> </td>
                        </tr>
                    ";


        return $ret_form;
    }

    /**
     * Cria o HTML de navegação do sistema
     *
     * @author Ricardo Ribeiro Assink
     * @param String $retorno_nav String com os parâmetros de retorno
     * @param String $control_div SIM|NAO determina se alguma div interna deve ser escondida ao chamar modais
     * @return String HTML de navegação do sistema
     */
    public function criaNav($retorno_nav, $control_div) {

        $nome_usuario = $this->user->get_nome_usuario();
        $nome_usuario = ucfirst($this->user->get_login_usuario());
        $data_atual = $this->dat->get_dataFormat("NOW", "", "PADRAO");
        $id_sessao = $this->get_id_sessao();
        $idioma = $this->get_idioma();
        $tema = $this->get_tema();
        if ($control_div == "SIM") {
            $ab_if = "&abrir=SIM";
            $ab_if2 = "escondeDIV();";
        } else {
            $ab_if = "";
            $ab_if2 = "";
        }

        if ($idioma == "" or $idioma == "PT") {
            $sal = "sair.png";
        } else {
            $sal = "sair_en.png";
        }

        $nav = "
        <table width=\"150px\" style=\"margin-top:20px;\" border=\"0\" cellpadding=\"3\" cellspacing=\"3\">
            <tr>
                <td width=\"10%\" nowrap>
                    <div class=\"link_ball1\" align=\"left\">
                        <span class=\"link_nav\" >
                            <img src=\"temas/$tema/icones/usuario.png\" width=\"25\" height=\"25\" align=\"top\" style=\"margin-left:-1px;margin-top:4px;\">
                        </span>
                        <div class=\"nav_moldura\" style=\" background:url(img/bloco1.png) no-repeat;\"><p>$nome_usuario</p></div>
                    </div>
                </td>
                <td width=\"10%\" nowrap>
                    <div class=\"link_ball2\" align=\"left\">
                        <span class=\"link_nav\">
                            <img src=\"temas/$tema/icones/crm.png\" width=\"25\" height=\"25\" style=\"margin-left:-0px;margin-top:5px;\" align=\"top\">
                        </span>
                        <div class=\"nav_moldura2\" style=\" background:url(img/bloco2.png) no-repeat;\"><p>Atendimento</p></div>
                    </div>
                </td>
                <td width=\"10%\" nowrap>
                    <div class=\"link_ball3\" align=\"center\">
                        <span class=\"link_nav\">
                            <a style=\"text-decoration:none;\" href=\"javascript: $ab_if2 displayMessage('temas/$tema/modal/msg_sair.php?tema=$tema$ab_if&idioma=$idioma');\">
                                <img src=\"temas/$tema/icones/sair.png\" width=\"18\" height=\"19\" align=\"top\" style=\"margin-left:-0px;margin-top:8px;\" border=\"0\">
                            </a>
                            <div class=\"nav_moldura3\" style=\"text-decoration:none; background:url(img/bloco3.png)  no-repeat;\"><p>Sair do Sistema</p></div>
                        </span>
                    </div>
                </td>
            </tr>
        </table>\n\n";


        return $nav;
    }

    /**
     *
     * Cria o HTML do box de informações logo abaixo do menu
     *
     * @author Ricardo Ribeiro Assink
     * @param String $tamanho Configura o tamanho do box
     * @param String $titulo Configura o título do box
     * @param String $texto Configura o texto dentro do box
     * @param String $obrigatorio true|false Determina se o campo obrigatório deve ser mostrado ou não
     * @param String $texto_obrigatorio Configura o texto ao lado do * no campo obrigatório
     * @return String HTML do box de informações logo abaixo do menu
     *
     *
     * @exemplo
     * <code>
     *
     * Exemplo de config utilizada nos filhos de View
     *
     *       $tam_infoacao      = 500; // tamanho em px do box de informações
     *       $titulo_infoacao   = $this->traducao->get_titulo_formulario01(); // título do box de informações
     *       $texto_infoacao    = $this->traducao->get_titulo_formulario02(); // texto do box de informações
     *       $mostrar_obrig     = false; // mostrar ou não o * de campos obrigatórios
     *       $texto_obrig       = $this->traducao->get_titulo_formulario03(); // texto ao lado do * no campo obrigatorio
     *
     *   // Exemplo da chamada para dentro do template
     *   $tpl->INFOACAO    = $this->criaInfoAcao($tam_infoacao, $titulo_infoacao, $texto_infoacao, $mostrar_obrig, $texto_obrig);
     *
     * </code>
     */
    public function criaInfoAcao($tamanho, $titulo, $texto, $obrigatorio = false, $texto_obrigatorio = "") {

        $tema = $this->get_tema();
        $tabela = "
                                <table width=\"$tamanho\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\">
                                    <tr>
                                        <td colspan=\"2\" valign=\"top\" bgcolor=\"#FFFFFF\">
                                            <div align=\"center\">
                                                <span class=\"texto_titulo_ferramenta\">
                                                    $titulo
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width=\"5%\" valign=\"top\" bgcolor=\"#FFFFFF\">
                                            <img src=\"temas/$tema/icones/info2.png\" width=\"50\" height=\"50\">
                                        </td>
                                        <td width=\"95%\" valign=\"top\" bgcolor=\"#FFFFFF\">
                                            <span class=\"texto_info\">
                                                <div align=\"justify\">
                                                    $texto
                                                </div>
                                            </span>
                                        </td>
                                    </tr>";
        $tabela = "<div class=\"seta-cima\"></div><div class=\"infoacao\"><span class=\"texto_titulo_ferramenta\">
                                                    $titulo
                                                </span>
                                                <div align=\"justify\">
                                                    $texto
                                                </div>
                                                ";

        if ($obrigatorio) {
            $tabela .= "
                                    <tr>
                                        <td colspan=\"2\" valign=\"top\" bgcolor=\"#FFFFFF\" class=\"texto_azul\"><div align=\"left\">* $texto_obrigatorio</div></td>
                                    </tr>";
        }

        $tabela .= "
                               </div>";
        return $tabela;
    }

    /**
     *
     * Cria o HTML do COMPONENTE TOOLTIP
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $array Array com os dados do TOOLTIP
     * @return String HTML do COMPONENTE TOOLTIP
     * @see View::criaComponentes()
     *
     */
    public function criaInfo($array) {
        $tema = $this->get_tema();
        $tabela = "
                                                <span title=\"header=[<img src='temas/$tema/icones/info.png' style='vertical-align:middle'>&nbsp;<font size=1 face=verdana>INFO</font>]
                                                body=[<table width=100% border=0 cellpadding=1 cellspacing=1>
                              ";
        foreach ($array as $legenda => $valor) {
            $tabela .= "
                                                    <tr>
                                                        <td valign=top nowrap width=10%>
                                                            <font size=1 face=verdana>$legenda</font>
                                                        </td>
                                                        <td valign=top width=90%>
                                                            <font size=1 face=verdana color=#000000>$valor</font>
                                                        </td>
                                                    </tr>";
        }
        $tabela .= "
                                                    </table>]delay=[100] fade=[on]\" style='font-family:Verdana;font-size:10px;color:#000000;cursor:pointer'>
                                                        <a href=\"javascript://\"><img src=\"temas/1/icones/info.png\" border=\"0\" height=\"25\" width=\"25\" align=\"center\" hspace=\"2\"></a>
                                                    </span>\n\n";
        return $tabela;
    }

    /**
     *
     * Cria o HTML da paginação de resultados em ações de gerenciamento
     *
     * @author Ricardo Ribeiro Assink
     * @param int $pagina Página corrente da paginação
     * @param int $pag_views Configura o número de registros por página
     * @param int $num_registros Número total de registros
     * @param String $retorno_paginacao String com os parâmetros de retorno de navegação
     * @param String $texto_page String com o texto "Páginas", parametrizado para fins de tradução.
     * @return String HTML da paginação de resultados em ações de gerenciamento
     *
     */
    public function criaPaginacao($pagina, $pag_views, $num_registros, $retorno_paginacao, $texto_page) {

        $idioma = $this->get_idioma();
        $id_sessao = $this->get_id_sessao();
        $outras = $pro = $pag = "";
        $dadospag = $outra = Array();
        if ($pagina == 0 or $pagina == "") {
            $pagina = 1;
        }

        $mat = $pagina - 1; //ASSIM INICIAREMOS DA LINHA ZERO DO BANCO
        $inicio = $mat * $pag_views;
        $linhas = $num_registros - 1;
        $paginas = $linhas / $pag_views;
        $volta = $pagina - 1;
        $proxima = $pagina + 1;

        $dadospag["inicio"] = $inicio;

        $link_retorno = ($volta > 0) ? "<a href=?pagina=$volta&id_sessao=$id_sessao&idioma=$idioma&$retorno_paginacao><< $vol</a>" : "";

        for ($i = 0; $i <= $paginas; $i++) { //REPETE ATÉ QUE SE ACABEM AS PAGINAS
            $pag = $i + 1; //EVITA A PÁGINA ZERO
            if ($pagina == $pag) {
                $outra[$i] = "<span class='texto_paginacao_destaque'>$pag </span>"; //MOSTRA O BOTÃO PARA A PÁGINA
            } else {
                $outra[$i] = "<span class='texto_paginacao'><a href=?pagina=$pag&id_sessao=$id_sessao&idioma=$idioma&$retorno_paginacao>$pag </a></span>"; //MOSTRA O BOTÃO PARA A PÁGINA
            }
        }

        $tam_outra = count($outra);
        $pagina_in = $pagina - 6;

        if ($pagina_in <= 0) {
            $pagina_in = 0;
        }

        $pagina_fin = $pagina_in + 11;

        if ($pagina_fin > $tam_outra) {
            $pagina_fin = $tam_outra;
        }


        for ($i = $pagina_in; $i < $pagina_fin; $i++) { //REPETE ATÉ QUE SE ACABEM AS PAGINAS
            $outras .= $outra[$i];
        }


        if ($pagina <= $paginas) {

            $link_proxima = "<a href=?pagina=$proxima&id_sessao=$id_sessao&idioma=$idioma&$retorno_paginacao>$pro >></a>";
        }

        if ($pag == 1 or $pag == 0) {
            $dadospag["nav_pesquisa"] = "";
            $dadospag["nav_pesquisa2"] = "";
        } else {
            $dadospag["nav_pesquisa"] = "<br><div align='center'><span class='texto_paginacao'>$tam_outra $texto_page<br>$link_retorno | $outras | $link_proxima</span></div>";
            $dadospag["nav_pesquisa2"] = "<br><hr width='50%' size='1'><div align='center'><span class='texto_paginacao'>$link_retorno | $outras | $link_proxima</span></div>";
        }

        return $dadospag;
    }

    /**
     * Cria o HTML do Rodapé
     *
     * @author Ricardo Ribeiro Assink
     * @return String HTML do Rodapé
     */
    public function criaRodapeLogin($color = "#fff") {

        $idioma = $this->get_idioma();

        if ($idioma == "" or $idioma == "PT") {
            $vers = "Vers&atilde;o 3.2 &copy; 2016-2019 | <a style=\"color:$color;\" href=\"http://www.equipedigital.com\">www.equipedigital.com</a>";
        }

        $rodape = "<hr align=\"center\" style=\"color:$color;\" width=\"50%\" size=\"1\">
                    <div align=\"center\">
                        <table width=\"100%\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
                            <tr>
                                <td>
                                    <div align=\"center\">
                                        <span style=\"color:$color;\" class=\"texto_rodape\">$vers</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>";

        return $rodape;
    }

    public function criaRodape($color = "#fff") {

        $idioma = $this->get_idioma();

        if ($idioma == "" or $idioma == "PT") {
            $vers = "Vers&atilde;o 3.2 &copy; 2016-2019 | <a style=\"color:$color;\" href=\"http://www.equipedigital.com\">http://www.equipedigital.com</a>";
        }

        $rodape = "<div align=\"center\">
                        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
                            <tr>
                                <td>
                                    <div align=\"center\">
                                        <span style=\"color:$color;\" class=\"texto_rodape\">$vers</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>";

        return $rodape;
    }

    /**
     * Cria o Javascript das chamadas de MODAL
     *
     * @author Ricardo Ribeiro Assink
     * @return String Javascript das chamadas de MODAL
     */
    public function criaModal($msg_tp, $msg) {

        $idioma = $this->get_idioma();
        $tema = $this->get_tema();
        $msg = base64_decode(rawurldecode($msg));
        $msg = rawurlencode($msg);


        switch ($msg_tp) {
            case "sucesso":
                $modal = "<script type=\"text/JavaScript\">
                            displayMessage('temas/$tema/modal/msg_sucesso.php?tema=$tema&msg=$msg&idioma=$idioma');
                          </script>";
                break;
            case "erro":
                $modal = "<script type=\"text/JavaScript\">
                            displayMessage('temas/$tema/modal/msg_erro.php?tema=$tema&msg=$msg&idioma=$idioma');
                          </script>";
                break;
            case "alerta":
                $modal = "<script type=\"text/JavaScript\">
                            displayMessage('temas/$tema/modal/msg_alerta.php?tema=$tema&msg=$msg&idioma=$idioma');
                          </script>";
                break;
            case "proc":
                $modal = "<script type=\"text/JavaScript\">
                            displayMessage('temas/$tema/modal/msg_processando.php?tema=$tema&msg=$msg&idioma=$idioma');
                          </script>";
                break;
            case "sair":
                $modal = "<script type=\"text/JavaScript\">
                            displayMessage('temas/$tema/modal/msg_sair.php?tema=$tema&msg=$msg&idioma=$idioma');
                          </script>";
                break;
            default : $modal = "";
                break;
        }// fim do switch

        return $modal;
    }

    /**
     *
     * Cria o HTML dos campos hidden dentro do form
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $campos Array com os dados dos campos hidden
     * @return String HTML dos campos hidden dentro do form
     *
     */
    public function criaHiddens($campos) {
        $retorno = "";
        foreach ($campos as $chave => $valor) {
            $retorno .= "<input id=\"$chave\" name=\"$chave\" type=\"hidden\" value=\"$valor\">";
        }

        $id = (isset($this->post_request['id'])) ? $this->post_request['id'] : "";
        $co = (isset($this->post_request['co'])) ? $this->post_request['co'] : "";
        $ac = (isset($this->post_request['ac'])) ? $this->post_request['ac'] : "";
        $pagina = (isset($this->post_request['pagina'])) ? $this->post_request['pagina'] : "";

        $retorno .= "<input id=\"id_sessao\" name=\"id_sessao\" type=\"hidden\" value=\"" . $this->get_id_sessao() . "\">
                    <input id=\"idioma\" name=\"idioma\" type=\"hidden\" value=\"" . $this->get_idioma() . "\">
                    <input id=\"id\" name=\"id\" type=\"hidden\" value=\"" . $id . "\">
                    <input id=\"co\" name=\"co\" type=\"hidden\" value=\"" . $co . "\">
                    <input id=\"ac\" name=\"ac\" type=\"hidden\" value=\"" . $ac . "\">
                    <input id=\"pagina\" name=\"pagina\" type=\"hidden\" value=\"" . $pagina . "\">";
        return $retorno;
    }

    /**
     *
     * Cria o HTML dos filtros no topo da lista de itens em ações de gerenciamento
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $filtros Array com os dados de cada filtro.
     * @return String HTML dos filtros no topo da lista de itens em ações de gerenciamento
     *
     */
    public function criaFiltros($filtros) {

        $ret_filtro = "<br><table width=\"950\" border=\"0\" align=\"center\"><tr>";

        if (array_key_exists("selecao04", $filtros)) { // existe o filtro pesquisa
            $ret_filtro .= "<td width=\"" . $filtros['selecao04']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['selecao04']["alinhamento"] . "\">
                                    <span class=\"texto_controle_tabela\">" . $filtros['selecao04']["texto"] . "</span><br>
                                    " . $filtros['selecao04']["select"] . "
                                </div>
                            </td>";
        }
        if (array_key_exists("selecao03", $filtros)) { // existe o filtro pesquisa
            $ret_filtro .= "<td width=\"" . $filtros['selecao03']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['selecao03']["alinhamento"] . "\">
                                    <span class=\"texto_controle_tabela\">" . $filtros['selecao03']["texto"] . "</span><br>
                                    " . $filtros['selecao03']["select"] . "
                                </div>
                            </td>";
        }
        if (array_key_exists("selecao02", $filtros)) { // existe o filtro pesquisa
            $ret_filtro .= "<td width=\"" . $filtros['selecao02']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['selecao02']["alinhamento"] . "\">
                                    <span class=\"texto_controle_tabela\">" . $filtros['selecao02']["texto"] . "</span><br>
                                    " . $filtros['selecao02']["select"] . "
                                </div>
                            </td>";
        }

        if (array_key_exists("selecao01", $filtros)) { // existe o filtro pesquisa
            $ret_filtro .= "<td width=\"" . $filtros['selecao01']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['selecao01']["alinhamento"] . "\">
                                    <span class=\"texto_controle_tabela\">" . $filtros['selecao01']["texto"] . "</span><br>
                                    " . $filtros['selecao01']["select"] . "
                                </div>
                            </td>";
        }

        if (array_key_exists("calendar01", $filtros)) { // existe o filtro pesquisa
            $ret_filtro .= "
                            <td width=\"" . $filtros['calendar01']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['calendar01']["alinhamento"] . "\">
                                    <span class=\"texto_controle_tabela\">" . $filtros['calendar01']["texto"] . "</span>
                                    " . $filtros['calendar01']["calendario"] . "
                                </div>
                            </td>";
        }
        if (array_key_exists("calendar02", $filtros)) { // existe o filtro pesquisa
            $ret_filtro .= "
                            <td width=\"" . $filtros['calendar02']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['calendar02']["alinhamento"] . "\">
                                    <span class=\"texto_controle_tabela\">" . $filtros['calendar02']["texto"] . "</span>
                                    " . $filtros['calendar02']["calendario"] . "
                                </div>
                            </td>";
        }
        if (array_key_exists("pesquisa2", $filtros)) { // existe o filtro pesquisa
            $ret_filtro .= "<td width=\"" . $filtros['pesquisa2']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['pesquisa2']["alinhamento"] . "\">
                                    <span class=\"texto_controle_tabela\">
                                        " . $filtros['pesquisa2']["texto"] . "
                                    </span>
                                    <input name=\"pesquisa2\" type=\"text\" onkeypress=\"javascript:submit_filtro(event,'')\" class=\"textfields\" id=\"pesquisa\" value=\"" . $this->post_request['pesquisa2'] . "\" size=\"20\">
                                </div>
                            </td>";
        }
        if (array_key_exists("pesquisa", $filtros)) { // existe o filtro pesquisa
            $pesquisa = (isset($this->post_request['pesquisa'])) ? $this->post_request['pesquisa'] : "";
            $ret_filtro .= "
                            <td width=\"" . $filtros['pesquisa']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['pesquisa']["alinhamento"] . "\">
                                    <span class=\"texto_controle_tabela\">" . $filtros['pesquisa']["texto"] . "</span><br>
                                    <input name=\"pesquisa\" type=\"text\" onkeypress=\"javascript:submit_filtro(event,'')\" class=\"textfields\" id=\"pesquisa\" value=\"" . $pesquisa . "\" size=\"30\">
                                    <input name=\"Submit\" type=\"button\" onClick=\"javascript:submit_filtro(event,'submit')\" class=\"botao2\" id=\"button\" value=\"\">
                                </div>
                            </td>";
        }

        if (array_key_exists("botao", $filtros)) { // existe o filtro pesquisa
            $ret_filtro .= "<td width=\"" . $filtros['botao']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['botao']["alinhamento"] . "\">
                                    " . $filtros['botao']["botao"] . "
                                </div>
                            </td>";
        }
        
        if (array_key_exists("botao01", $filtros)) { // existe o filtro pesquisa
            $ret_filtro .= "<td width=\"" . $filtros['botao01']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['botao01']["alinhamento"] . "\">
                                    " . $filtros['botao01']["botao01"] . "
                                </div>
                            </td>";
        }

        if (array_key_exists("botao_download", $filtros)) { // existe o filtro pesquisa
            $ret_filtro .= "<td width=\"" . $filtros['botao']["width"] . "\" nowrap>
                                <div align=\"" . $filtros['botao']["alinhamento"] . "\">
                                    " . $filtros['botao']["botao"] . "
                                </div>
                            </td>";
        }

        $ret_filtro .= "</tr></table><br>";

        return $ret_filtro;
    }

    /**
     * Cria o Javascript das chamadas de modal para itens dentro das listas de gerenciamento
     *
     * @author Ricardo Ribeiro Assink
     * @param Array $modais Array com os dados dos modais que devem ser criados.
     * @return String Javascript das chamadas de modal para itens dentro das listas de gerenciamento
     *
     */
    public function criaModalLista($modais) {



        $ret_mod = "<script type=\"text/JavaScript\">";
        $ret_mod .= "function pergunta(acao,id){";
        $i = 0;
        while ($i < count($modais)) {
            $ret_mod .= "if(acao == \"" . $modais[$i]['acao'] . "\"){
                          set_campo('id',id);";

            $campos = Array();
            $campos = $modais[$i]['campos'];
            foreach ($campos as $chave => $valor) {
                $ret_mod .= "set_campo('$chave','$valor');";
            }
            $ret_mod .= "go();}";

            $i++;
        }

        $ret_mod .= "}";

        $i = 0;
        while ($i < count($modais)) {

            $ret_mod .= "function certeza_$i(id){
                            displayMessage('temas/" . $this->get_tema() . "/modal/msg_pergunta.php?tema=" . $this->get_tema() . "&idioma=" . $this->get_idioma() . "&msg=" . rawurlencode($modais[$i]['msg']) . "&acao=" . $modais[$i]['acao'] . "&id='+id+'');
                        }";


            $i++;
        }

        $ret_mod .= "</script>";

        return $ret_mod;
    }

    public function criaTituloPost($titulo) {


        $html = "<div class=\"title_post\">$titulo</div><br><br>";

        return $html;
    }

    /**
     *
     * Cria o HTML da tabela com a lista de itens em ações de gerenciamento
     *
     * @author Ricardo Ribeiro Assink
     * @param String $tamanho Configura a largura da tabela
     * @param String $titulo Configura o título da tabela
     * @param Array $campos Array com os títulos das colunas
     * @param Array $linhas Array com as linhas da tabela
     * @return String HTML da tabela com a lista de itens em ações de gerenciamento
     *
     *
     * @Exemplo
     *
     * <code>
     *
     *   // A criação da lista de ítens é dividida em 3 partes:
     *
     *   // 1 - configurações da tabela
     *
     *       $tam_tab           = "99%"; // tamanho da tabela que lista os itens em %
     *       $title_tab         = $this->traducao->get_titulo_formulario04(); // título da tabela que lista os itens
     *
     *    // 2 - configuração das colunas
     *
     *           $campos = Array();
     *           $campos[0]["tamanho_celula"] = "7%";
     *           $campos[0]["texto"]          = $this->traducao->get_leg01();
     *
     *           $campos[1]["tamanho_celula"] = "49%";
     *           $campos[1]["texto"]          = $this->traducao->get_leg02();
     *
     *           $campos[2]["tamanho_celula"] = "10%";
     *           $campos[2]["texto"]          = $this->traducao->get_leg03();
     *
     *           $campos[3]["tamanho_celula"] = "10%";
     *           $campos[3]["texto"]          = $this->traducao->get_leg04();
     *
     *           $campos[4]["tamanho_celula"] = "14%";
     *           $campos[4]["texto"]          = $this->traducao->get_leg05();
     *
     *           $campos[5]["tamanho_celula"] = "10%";
     *           $campos[5]["texto"]          = $this->traducao->get_leg06();
     *
     *
     *     // 3 - configuração das linhas da tabela
     *     // ABAIXO UM EXEMPLO COMPLETO com inclusão de TOOLTIPS e MODAIS DE CONFIRMAÇÃO
     *
     * * ************************************************************************************************************
     * * Seleciona os elementos que serão mostrados e configura as linhas da tabela
     * ***************INICIO
     *
     *       $linhas = Array();
     *       $i      = 0;
     *       while ($i < count($this->objetos)) {
     *
     *           $dados  = $this->objetos[$i]->get_all_dados();
     *
     *           // aplica regra de recebimento no array de dados
     *           foreach ($dados as $chave => $valor){
     *               $dados[$chave] = htmlspecialchars(stripslashes($valor));
     *           }
     *
     *           * ******************************************************************************************
     *            * CONFIGURE o tooltip de INFO
     *            ****************INICIO
     *
     *           $inf = Array();
     *           $inf["".$this->traducao->get_leg21().""] = $dados['nome_usuario'];
     *           $inf["".$this->traducao->get_leg22().""] = $this->descricoes['desc_perm_usuario'][$dados['perm_usuario']]; // pega a descrição da permissão do usuário
     *           $inf["".$this->traducao->get_leg23().""] = $dados['login_usuario'];
     *           $inf["".$this->traducao->get_leg24().""] = $dados['email_usuario'];
     *           $inf["".$this->traducao->get_leg25().""] = $dados['cidade_usuario'];
     *           $inf["".$this->traducao->get_leg26().""] = $dados['pais_residencia_usuario'];
     *           $inf["".$this->traducao->get_leg27().""] = $dados['instituicao_usuario'];
     *           $inf["".$this->traducao->get_leg28().""] = $dados['local_instituicao_usuario'];
     *
     *           $infos = $this->criaInfo($inf);
     *
     *            * ******************************************************************************************
     *            * CONFIGURE o tooltip de INFO
     *            ****************FIM
     *
     *
     *            * ******************************************************************************************
     *            * CONFIGURE OS MODAIS.
     *            ****************INICIO
     *
     *           $modais = Array();
     *
     *           $modais[0]['campos']   = Array('ac'=>$ac_apaga);
     *           $modais[0]['acao']     = "apagar";
     *           $modais[0]['msg']      = $this->traducao->get_leg31();
     *
     *           $modais[1]['campos']   = Array('ac'=>$ac_ativa);
     *           $modais[1]['acao']     = "ativar";
     *           $modais[1]['msg']      = $this->traducao->get_leg32();
     *
     *           $modais[2]['campos']   = Array('ac'=>$ac_desativa);
     *           $modais[2]['acao']     = "desativar";
     *           $modais[2]['msg']      = $this->traducao->get_leg33();
     *
     *            * ******************************************************************************************
     *            * CONFIGURE OS MODAIS.
     *            ****************FIM
     *
     *            * ******************************************************************************************
     *            * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
     *            ****************INICIO
     *
     *               if($dados['status_usuario'] == "A"){
     *                   $ad = "
     *                                           <span class=\"texto_conteudo_tabela\">
     *                                           <a href=\"javascript:certeza_2(".$dados['id_usuario'].")\">
     *                                               <img src=\"temas/".$this->get_tema()."/icones/disponivel.png\" width=\"15\" height=\"15\" align=\"left\" border=\"0\" hspace=\"2\"> ".$this->traducao->get_leg13()."
     *                                           </a>
     *                                           </span>";
     *               }else{
     *                   $ad = "
     *                                           <span class=\"texto_conteudo_tabela\">
     *                                           <a href=\"javascript:certeza_1(".$dados['id_usuario'].")\">
     *                                               <img src=\"temas/".$this->get_tema()."/icones/esgotado.png\" width=\"15\" height=\"15\" align=\"left\" border=\"0\" hspace=\"2\"> ".$this->traducao->get_leg14()."
     *                                           </a>
     *                                           </span>";
     *               }
     *
     *            * ******************************************************************************************
     *            * CONFIGURE ALGUNS TRATAMENTOS ANTES DE INCLUIR NA MATRIZ
     *            ****************FIM
     *
     *            * ******************************************************************************************
     *            * CONFIGURE as colunas de cada linha da tabela. NA CONFIG ANTERIOR VÂO ALGUNS TRATAMENTOS.
     *            ****************INICIO
     *
     *           $colunas = Array();
     *           $colunas[0]["alinhamento"] = "left";
     *           $colunas[0]["texto"]       = "
     *                                           $infos";
     *
     *           $colunas[1]["alinhamento"] = "left";
     *           $colunas[1]["texto"]       = "
     *                                           <strong><font size=\"1\" color = \"#003399\" face=\"Verdana, Arial, Helvetica, sans-serif\">".$dados['nome_usuario']."</strong></font>
     *                                        ";
     *
     *           $colunas[2]["alinhamento"] = "justify";
     *           $colunas[2]["texto"]       = "
     *                                           <span class=\"texto_conteudo_tabela\">
     *                                           <a href=\"javascript:submit_campo(".$dados['id_usuario'].",'$ac_altera');\">
     *                                                <img src=\"temas/".$this->get_tema()."/icones/dados.png\" width=\"25\" height=\"25\"  align=\"left\" border=\"0\" hspace=\"2\">".$this->traducao->get_leg11()."
     *                                            </a>
     *                                            </span>";
     *
     *
     *           $colunas[3]["alinhamento"] = "left";
     *           $colunas[3]["texto"]       = "
     *                                           <span class=\"texto_conteudo_tabela\">
     *                                           <a href=\"javascript:submit_campo(".$dados['id_usuario'].",'$ac_pass');\">
     *                                               <img src=\"temas/".$this->get_tema()."/icones/senha.png\" width=\"15\" height=\"15\" align=\"left\" border=\"0\" hspace=\"2\"> ".$this->traducao->get_leg12()."
     *                                           </a>
     *                                           </span>";
     *
     *           $colunas[4]["alinhamento"] = "left";
     *           $colunas[4]["texto"]       = $ad; // leg 13 e leg 14
     *
     *           $colunas[5]["alinhamento"] = "left";
     *           $colunas[5]["texto"]       = "
     *                                           <span class=\"texto_conteudo_tabela\">
     *                                           <a href=\"javascript:certeza_0(".$dados['id_usuario'].")\">
     *                                               <img src=\"temas/".$this->get_tema()."/icones/del.png\" width=\"15\" height=\"15\" align=\"left\" border=\"0\" hspace=\"2\">".$this->traducao->get_leg15()."
     *                                           </a>
     *                                           </span>";
     *
     *
     *           $linhas[$i] = $colunas;
     *
     *            * ******************************************************************************************
     *            * CONFIGURE as colunas de cada linha da tabela.
     *            ****************FIM
     *
     *           $i++;
     *       }
     *
     *
     *
     *
     *       // AQUI A TABELA É ADICIONADA AO TEMPLATE
     *
     *       $tpl->TABELALISTA = $this->criaTabelaLista($tam_tab, $title_tab, $campos, $linhas, $titulo_infoacao, $texto_infoacao);
     *
     * </code>
     */
    public function criaTabelaLista($tamanho, $titulo, $campos, $linhas, $titulo_info, $texto_info, $botoes = Array()) {

        $colspan = count($campos);
        $tema = $this->get_tema();
        $bgbutton = "transparent";
        $data_atual = $this->dat->get_dataFormat("NOW", "", "LUMA");
        $bgtitle = "url(temas/$tema/topotabela.jpg)";
        $tabela = " <table width=\"$tamanho\" border=\"0\" align=\"center\" cellpadding=\"1\" class=\"table\" cellspacing=\"1\" >
                        <tr>
                            <td colspan=\"$colspan\" style=\"border-radius:6px; background:$bgtitle\">
                                <div style=\"position:relative;\">
                                    <div class=\"infoicon\"><img style=\"float:left; left:2px; top:1px; position:absolute;\"  src=\"temas/$tema/info.png\">
                                        <div class=\"infoacao\"><div class=\"seta-cima\"></div>
                                            <table>
                                                <tr>
                                                    <td width=\"8%\" valign=\"center\" ><img src=\"temas/$tema/info2.png\" width=\"30\" height=\"30\" style=\"padding-right:10px\"></td> 
                                                <td width=\"92%\" ><div align=\"left\"><span class=\"texto_titulo_ferramenta\">$titulo_info</span></div><div align=\"left\"><span class=\"texto_ferramenta\">$texto_info</span></div></td>       
                                                </tr>                                                
                                            </table>
                                        </div>
                                    </div>
                                    <div style=\"float:right; position:absolute; top:2px; right:8px; font-size:8px; line-height:10px; color:white;  height:20px; padding-left:26px; margin-top:3px; line-height:20px; background: url(temas/$tema/icones/relogio.png) left no-repeat;\">$data_atual</div>
                                    <div align=\"center\" class=\"texto_titulo_tabela\">$titulo</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=\"$colspan\" ></td>
                        </tr><tr>";

        $i = 0;
        while ($i < count($campos)) {
            $tabela .= "<td width=\"" . $campos[$i]["tamanho_celula"] . "\" nowrap  bgcolor=\"#FFFFFF\"><div align=\"center\" class=\"texto_subitem_tabela\">" . $campos[$i]["texto"] . "</div></td>";
            $i++;
        }
        $tabela .= "</tr>";

        $linha = 0;
        $tabela .= "<table width=\"$tamanho\" align=\"center\" cellpadding=\"6\" cellspacing=\"0\" class=\"table f-table\" BORDERCOLOR=\"#ccc\" RULES=COLS FRAME=BOX >";
        while ($linha < count($linhas)) {// aqui da o numero de linhas
            $cordavez = ($linha & 1) ? "#f4f4f4" : "#FFFFFF";
// ------------------------------ uma linha
            $i = 0;
            $tabela .= "<tr>";

            $colunas = $linhas[$linha]; // aqui da o numero de colunas

            foreach ($colunas as $col) {// aqui da o numero de colunas
                $tabela .= "<td width=\"" . $campos[$i]["tamanho_celula"] . "\" bgcolor=\"$cordavez\"><div style=\"padding:6px 2px;\" align=\"" . $col["alinhamento"] . "\">" . $col["texto"] . "</div></td>";
                $i++;
            }
            $tabela .= "</tr>";
// ------------------------------ uma linha
            $linha++;
        }// fim do linha
        $tabela .= "</table></table>\n";

        $tabela .= "<table width=\"$tamanho\" border=\"0\" align=\"center\" cellpadding=\"1\" class=\"table\" cellspacing=\"1\" >";
        if (is_array($botoes) && $botoes != NULL) {
            $tabela .= "<tr>
                <td colspan=\"" . $colspan . "\" style=\"background:$bgbutton\">
                    <div align=\"center\">";
            foreach ($botoes as $valor) {
                $tabela .= "$valor";
            }
            $tabela .= "</div></td></tr>";
        }
        $tabela .= "</table>";

        return $tabela;
    }

    /*
     * Monta tabela de formulário para Mobile
     * @autor Marcio Figueredo
     * Data: 20/03/2015
     */

    public function criaTabelaFormMobile($tam_tab, $title_tab, $col, $lin, $botoes = Array(), $subtitle = null, $titulo = '0', $texto = '0') {
        $tema = $this->get_tema();
        $colspan = count($col);

        $bgtitle = "url(temas/$tema/topotabela.jpg)";
        $bgbutton = "transparent";

        $data_atual = $this->dat->get_dataFormat("NOW", "", "LUMA");
        $ret_form = "<br>
                    <table width=\"$tam_tab\" border=\"0\" align=\"center\" cellpadding=\"1\" class=\"table\" cellspacing=\"1\" style=\"$style\">
                        <tr>
                            <td collspan=\"$colspan\" style=\"border-radius:6px; background:$bgtitle\">
                                <div style=\"position:relative;\">
                                    <div class=\"infoicon\">
                                        <img style=\"float:left; left:2px; top:1px; position:absolute;\"  src=\"temas/$tema/info.png\">
                                        <div class=\"infoacao\"><div class=\"seta-cima\"></div>
                                            <table>
                                                <tr>
                                                    <td width=\"8%\" valign=\"center\" >
                                                        <img src=\"temas/$tema/info2.png\" width=\"30\" height=\"30\" style=\"padding-right:10px\">
                                                    </td> 
                                                    <td width=\"92%\" >
                                                        <div align=\"left\" ><span class=\"texto_titulo_ferramenta\">$titulo</span></div>
                                                        <div align=\"left\" ><span class=\"texto_ferramenta\">$texto</span></div>
                                                    </td>       
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class=\"data_atual\" style=\"background: url(temas/$tema/icones/relogio.png) left no-repeat;\">$data_atual</div>
                                    <div align=\"center\" class=\"texto_titulo_tabela\">$title_tab</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=\"$colspan\" ></td>
                        </tr>";

        if ($subtitle != null) {
            $ret_form .= "<tr>
                            <td colspan=\"$colspan\" style=\"background-color:#fff\">
                                <div align=\"center\">$subtitle</div>
                            </td>
                        </tr>";
        }

        $ret_form .= " <table width=\"$tam_tab\" align=\"center\" cellpadding=\"6\" cellspacing=\"0\" class=\"table\" BORDERCOLOR=\"#ccc\" RULES=COLS FRAME=BOX >";
        $i = 0;
        while ($i < count($lin)) {

            if ($i & 1) {
                $cordavez = "#EBEBEB";
            } else {
                $cordavez = "#FFFFFF";
            }

            $ret_form .= "<tr id=\"" . $lin[$i]['id'] . "\">";

            $a = 0;
            while ($a < count($col)) {

                if ($col[$a]['valign'] != "") {
                    $valign = "valign = \"" . $col[$a]["valign"] . "\"";
                }
                $ret_form .= "<td  width=\"" . $col[$a]['width'] . "\" style=\"background-color:" . $cordavez . "\" $valign>" . $lin[$i][$a] . "</td>";
                $a++;
            }
            $ret_form .= "</tr>";
            $i++;
        }

        $ret_form .= "</table>";

        $ret_form .= "<tr><td colspan=\"" . $colspan . "\" style=\"background:$bgbutton\"><div align=\"center\">";


        foreach ($botoes as $valor) {
            $ret_form .= "$valor";
        }

        $ret_form .= "</div></td></tr>";

        $ret_form .= "</table>";


        return $ret_form;
    }

    public function criaTabelaForm($tam_tab, $title_tab, $col, $lin, $botoes = Array(), $subtitle = null, $titulo = '0', $texto = '0') {

        $tema = $this->get_tema();
        $colspan = count($col);

        $bgtitle = "url(temas/$tema/topotabela.jpg)";
        $bgbutton = "transparent";
        if ($tam_tab < 500) {
            $tam_tab = 500;
        }
        $data_atual = $this->dat->get_dataFormat("NOW", "", "LUMA");
        $ret_form = "<br>
                    <table width=\"$tam_tab\" border=\"0\" align=\"center\" cellpadding=\"1\" class=\"table\" cellspacing=\"1\">
                        <tr>
                            <td collspan=\"$colspan\" style=\"border-radius:6px; background:$bgtitle\">
                                <div style=\"position:relative;\">
                                    <div class=\"infoicon\"><img style=\"float:left; left:2px; top:1px; position:absolute;\"  src=\"temas/$tema/info.png\">
                                        <div class=\"infoacao\"><div class=\"seta-cima\"></div>
                                            <table>
                                                <tr>
                                                    <td width=\"8%\" valign=\"center\" >
                                                        <img src=\"temas/$tema/info2.png\" width=\"30\" height=\"30\" style=\"padding-right:10px\">
                                                    </td> 
                                                    <td width=\"92%\" >
                                                        <div align=\"left\" ><span class=\"texto_titulo_ferramenta\">$titulo</span></div>
                                                        <div align=\"left\" ><span class=\"texto_ferramenta\">$texto</span></div>
                                                    </td>       
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div style=\"float:right; position:absolute; top:2px; right:8px; font-size:8px; line-height:10px; color:white;  height:20px; padding-left:26px; margin-top:3px; line-height:20px; background: url(temas/$tema/icones/relogio.png) left no-repeat;\">$data_atual</div>
                                    <div align=\"center\" class=\"texto_titulo_tabela\">$title_tab</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan=\"$colspan\" ></td>
                        </tr>";

        if ($subtitle != null) {
            $ret_form .= "<tr>
                            <td colspan=\"$colspan\" style=\"background-color:#fff\">
                                <div align=\"center\">$subtitle</div>
                            </td>
                        </tr>";
        }

        $ret_form .= " <table width=\"$tam_tab\" align=\"center\" cellpadding=\"6\" cellspacing=\"0\" class=\"table\" BORDERCOLOR=\"#ccc\" RULES=COLS FRAME=BOX >";
        $i = 0;
        while ($i < count($lin)) {

            if ($i & 1) {
                $cordavez = "#EBEBEB";
            } else {
                $cordavez = "#FFFFFF";
            }

            $ret_form .= "<tr>";

            $a = 0;
            while ($a < count($col)) {

                if ($col[$a]['valign'] != "") {
                    $valign = "valign = \"" . $col[$a]["valign"] . "\"";
                }
                $ret_form .= "<td  width=\"" . $col[$a]['width'] . "\" style=\"background-color:" . $cordavez . "\" $valign>" . $lin[$i][$a] . "</td>";
                $a++;
            }
            $ret_form .= "</tr>";
            $i++;
        }

        $ret_form .= "</table>";

        $ret_form .= "<tr><td colspan=\"" . $colspan . "\" style=\"background:$bgbutton\"><div align=\"center\">";

        if (is_array($botoes)) {
            foreach ($botoes as $valor) {
                $ret_form .= "$valor";
            }
        }

        $ret_form .= "</div></td></tr></table>";
        return $ret_form;
    }

    public function criaTabelaFormLogin($tam_tab, $title_tab, $col, $lin, $botoes = Array(), $subtitle = null, $border = "0", $cellspacing = "1", $bgtitle = "sim", $bgbutton = "#224f97", $style = "") {

        $tema = $this->get_tema();
        $colspan = count($col);
        if ($bgtitle == "sim") {
            $bgtitle = "url(temas/$tema/topotabela.jpg)";
        }

        $ret_form = "
                    <br><table width=\"$tam_tab\" border=\"$border\" align=\"center\" cellpadding=\"3\" class=\"table\" cellspacing=\"$cellspacing\" style=\"$style\">
                        <tr>
                            <td colspan=\"$colspan\" style=\"border-radius:6px; background:$bgtitle\">
                                <div align=\"center\" class=\"texto_titulo_tabela\">
                               $title_tab
                                </div>
                            </td>
                        </tr>
                    ";

        if ($subtitle != null) {
            $ret_form .= "<tr>
                            <td colspan=\"$colspan\" style=\"background-color:#fff\">
                                <div align=\"center\">
                                $subtitle
                                </div>
                            </td>
                        </tr>";
        }

        $i = 0;
        while ($i < count($lin)) {

            $ret_form .= "
                        <tr>";

            $a = 0;
            while ($a < count($col)) {

                if ($col[$a]['valign'] != "") {
                    $valign = "valign = \"" . $col[$a]["valign"] . "\"";
                }


                $ret_form .= "
                            <td width=\"" . $col[$a]['width'] . "\" style=\" background-color:" . $col[$a]['color'] . "\" $valign>
                            " . $lin[$i][$a] . "
                            </td>";
                $a++;
            }
            $ret_form .= "
                        </tr>
                        ";

            $i++;
        }

        $ret_form .= "
                        <tr>
                            <td colspan=\"" . $colspan . "\" style=\"background:$bgbutton\">
                                <div align=\"center\">";

        foreach ($botoes as $valor) {
            $ret_form .= "$valor";
        }


        $ret_form .= "     </div> </td>
                        </tr>
                    ";


        $ret_form .= "
                    </table>";


        return $ret_form;
    }

    public function criaValidacoes($validacao, $resetcampos, $post, $ajax_login = Array()) {

        $tema = $this->get_tema();

        if (count($ajax_login) > 0) {

            $ret_val = "
        <script src=\"ajax/ajax_login.js\" type=\"text/javascript\"></script>
        <script type=\"text/JavaScript\">";

            foreach ($ajax_login as $nome) {
                if ($nome == 'login_usuario') {
                    $parametros = "\"?login=\" + campo + \"&id_membro=\" + id, metodo";
                } elseif ($nome == 'codigo_produto') {
                    $parametros = "\"?codigo=\" + campo, metodo";
                } else {
                    $parametros = "\"?login=\" + campo + \"&id_membro=\" + id, metodo";
                }
                $ret_val .= "
                    function processa_$nome(){
                        var frase = document.form1.$nome.value;
                        document.form1.$nome.value =  frase.toLowerCase();
                        envia_$nome('AJAX_$nome.php', 'POST', false);
                    }

                    function envia_$nome(url, metodo, modo){
                        var campo = document.getElementById('$nome').value;
                        var id    = document.getElementById('id').value; // necessariamente o ID de usuario deve está setado no hidden
                        remoto    = new ajax();
                        xmlhttp   = remoto.enviar(url + $parametros, modo);                   
                        
                            
                        if(xmlhttp) {
                            document.getElementById(\"alerta_$nome\").className = 'texto_vermelho';
                            document.getElementById(\"alerta_$nome\").innerHTML = '<img src=\"temas/$tema/icones/esgotado.png\" width=\"15\" height=\"15\" hspace=\"10\">';
                            document.form1." . $nome . "_ok.value = 'nao';
                            document.form1." . $nome . ".className = \"textfields_erro\";

                        } else {
                            document.getElementById(\"alerta_$nome\").className = 'texto_verde';
                            document.getElementById(\"alerta_$nome\").innerHTML = '<img src=\"temas/$tema/icones/disponivel.png\" width=\"15\" height=\"15\" hspace=\"10\">';
                            document.form1." . $nome . "_ok.value = 'sim';
                            document.form1." . $nome . ".className = \"textfields\";
                        }
                    }

                    function limpa_$nome(){
                        document.getElementById(\"alerta_$nome\").innerHTML = '';
                        document.form1." . $nome . "_ok.value = 'nao';
                    }


                ";
            }
        } else {
            $ret_val = "
                <script type=\"text/JavaScript\">";
        }

        $ret_val .= "function resetcampos(){";

        foreach ($resetcampos as $valor) {
            $ret_val .= "document.form1." . $valor . ".className = \"textfields\";";
        }
        $ret_val .= "}
            function validar(){            
                resetcampos();
            ";

        if (count($ajax_login) > 0) {

            foreach ($ajax_login as $ex) {
                $ret_val .= "processa_$ex();";
            }
        }

        $i = 0;
        while ($i < count($validacao)) {

            if ($i == 0) {
                $ret_val .= "
                        $validacao[$i]";
            } else {
                $ret_val .= "
                        else $validacao[$i]";
            }

            $i++;
        }

        if ($i == 0) {
            $ret_val .= "if(1 != 1){}";
        }

        $ret_val .= "else{
                        set_campo('ac','" . $post . "');
                        go();
                   }
                }
        </script>";
        return $ret_val;
    }

    /*
     * 
     * 
     */

    public function criaPassos($onde) {
        $config = new Config();
        $tema = $this->get_tema();
        $p = $config->get_num_passos();

        $anterior = Array(
            1 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -10px -12px;\"></div>",
            2 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -36px -12px;\"></div>",
            3 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -62px -12px;\"></div>",
            4 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -88px -12px;\"></div>",
            5 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -114px -12px;\"></div>",
            6 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -140px -12px;\"></div>",
            7 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -166px -12px;\"></div>",
            8 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -192px -12px;\"></div>",
            9 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -218px -12px;\"></div>"
        );
        $atual = Array(
            1 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -245px -13px;\"></div>",
            2 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -273px -13px;\"></div>",
            3 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -301px -13px;\"></div>",
            4 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -329px -13px;\"></div>",
            5 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -357px -13px;\"></div>",
            6 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -385px -13px;\"></div>",
            7 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -413px -13px;\"></div>",
            8 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -441px -13px;\"></div>",
            9 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -469px -13px;\"></div>"
        );
        $proximo = Array(
            1 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -496px -12px;\"></div>",
            2 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -522px -12px;\"></div>",
            3 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -547px -12px;\"></div>",
            4 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -573px -12px;\"></div>",
            5 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -599px -12px;\"></div>",
            6 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -625px -12px;\"></div>",
            7 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -651px -12px;\"></div>",
            8 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -677px -12px;\"></div>",
            9 => "<div class=\"passos\" style=\"background: url(../sys/temas/$tema/passos.png) no-repeat -703px -12px;\"></div>"
        );


        $this->traducao->loadTraducao("2004", $this->get_idioma());
        $texto = Array(
            1 => $this->traducao->get_titulo_formulario01(),
            2 => $this->traducao->get_titulo_formulario02(),
            3 => $this->traducao->get_titulo_formulario03(),
            4 => $this->traducao->get_titulo_formulario04(),
            5 => $this->traducao->get_titulo_formulario05(),
            6 => $this->traducao->get_titulo_formulario06(),
            7 => $this->traducao->get_titulo_formulario07(),
            8 => $this->traducao->get_titulo_formulario08(),
            9 => $this->traducao->get_titulo_formulario09()
        );

        $tamanho = 900 / $p;
        for ($i = 1; $i <= $p; $i++) {
            if ($i < $onde) {
                $td .= "<td style=\"as\">" . $anterior[$i] . "<div class=\"b\">$texto[$i]</div></td>";
            }
            if ($onde == $i) {
                $td .= "<td style=\"\">" . $atual[$i] . "<div class=\"a\">$texto[$i]</div></td>";
            }
            if ($i > $onde) {
                if ($i == 2) {
                    $td .= "<td style=\"\">" . $proximo[$i] . "<div class=\"c\">$texto[$i]</div></td>";
                } else {
                    $td .= "<td style=\"\">" . $proximo[$i] . "<div class=\"c\">$texto[$i]</div></td>";
                }
            }
        }
        $passos = "<div id=\"passos\"><table border=\"0\" align=\"left\" cellpadding=\"10\"><tr>$td</tr></table></div>";
        return $passos;
    }

}

?>
