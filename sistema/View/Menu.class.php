<?php

/**
 * Menu do sistema
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
class Menu {

    private $idioma;
    private $perm_usuario;
    private $id_sessao;

    /**
     * @ignore
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
    public function get_idioma() {
        return $this->idioma;
    }

    /**
     * @ignore
     */
    public function set_idioma($idioma) {
        $this->idioma = $idioma;
    }

    /**
     * @ignore
     */
    public function get_perm_usuario() {
        return $this->perm_usuario;
    }

    /**
     * @ignore
     */
    public function set_perm_usuario($perm_usuario) {
        $this->perm_usuario = $perm_usuario;
    }

    /**
     * Usado pelos filhos de View para carregar o menu
     *
     * @author Ricardo Ribeiro Assink
     * @param String $perm_usuario Permissão de usuário
     * @param String $id_sessao ID da sessão encriptado
     * @param String $idioma Idioma corrente escolhido pelo usuário
     * @return void
     *
     */
    public function loadMenu($perm_usuario, $id_sessao, $idioma) {
        $this->set_idioma($idioma);
        $this->set_id_sessao($id_sessao);
        $this->set_perm_usuario($perm_usuario);
    }

    /**
     * Cria o código HTML do Menu
     *
     * @author Ricardo Ribeiro Assink
     * @return String Código HTML do Menu
     *
     */
    public function criaMenu() {
        $idioma = $this->get_idioma();
        $perm_usuario = $this->get_perm_usuario();
        $id_sessao = $this->get_id_sessao();

        /*
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************INICIO
         */
        // USUARIO
        $home_co = base64_encode("Home_Control"); // CONTROLLER
        $home_ac = base64_encode("Home_V");

        $configuracoes_co = base64_encode("Configuracoes_Control"); // CONTROLLER
        $configuracoes_gerencia = base64_encode("Configuracoes_Gerencia");

        $usuario_co = base64_encode("Usuario_Control"); // CONTROLLER
        $usuario_gerencia = base64_encode("Usuario_Gerencia");
        $usuario_add = base64_encode("Usuario_Add_V");
        $usuario_mypass = base64_encode("Usuario_Mypass_V");
        $usuario_mydata = base64_encode("Usuario_Mydata_V");

        $traducao_co = base64_encode("Traducao_Control"); // CONTROLLER
        $traducao_add = base64_encode("Traducao_Add_V");
        $traducao_gerencia = base64_encode("Traducao_Gerencia");

        $conteudo_co = base64_encode("Conteudo_Control"); // CONTROLLER
        $conteudo_add = base64_encode("Conteudo_Add_V");
        $conteudo_edit = base64_encode("Conteudo_Edit_V");
        $conteudo_gerencia = base64_encode("Conteudo_Gerencia");

        $categoria_post_co = base64_encode("CategoriaNoticia_Control"); // CONTROLLER
        $categoria_noticia_add = base64_encode("CategoriaNoticia_Add_V");
        $categoria_noticia_gerencia = base64_encode("CategoriaNoticia_Gerencia");

        $noticia_co = base64_encode("Noticia_Control"); // CONTROLLER
        $noticia_add = base64_encode("Noticia_Add_V");
        $noticia_gerencia = base64_encode("Noticia_Gerencia");

        $slider_co = base64_encode("Slider_Control"); // CONTROLLER
        $slider_add = base64_encode("Slider_Add_V");
        $slider_gerencia = base64_encode("Slider_Gerencia");

        $depoimento_co = base64_encode("Depoimento_Control"); // CONTROLLER
        $depoimento_add = base64_encode("Depoimento_Add_V");
        $depoimento_gerencia = base64_encode("Depoimento_Gerencia");

        $contato_co = base64_encode("Contato_Control"); // CONTROLLER
        $contato_gerencia = base64_encode("Contato_Gerencia");

        $colaborador_co = base64_encode("Colaborador_Control"); // CONTROLLER
        $colaborador_gerencia = base64_encode("Colaborador_Gerencia");
        $colaborador_add = base64_encode("Colaborador_Add_V");

        $convenio_co = base64_encode("Convenio_Control"); // CONTROLLER
        $convenio_gerencia = base64_encode("Convenio_Gerencia");
        $convenio_add = base64_encode("Convenio_Add_V");

        $gestao_co = base64_encode("Gestao_Control"); // CONTROLLER
        $gestao_gerencia = base64_encode("Gestao_Gerencia");
        $gestao_add = base64_encode("Gestao_Add_V");

        $associado_co = base64_encode("Associado_Control"); // CONTROLLER
        $associado_gerencia = base64_encode("Associado_Gerencia");
        $associado_add = base64_encode("Associado_Add_V");
        $associado_solicitacoes = base64_encode("Associado_Ger_Solicitante_V");

        $balancete_co = base64_encode("Balancete_Control"); // CONTROLLER
        $balancete_gerencia = base64_encode("Balancete_Gerencia");
        $balancete_add = base64_encode("Balancete_Add_V");

        $arquivo_co = base64_encode("Arquivo_Control"); // CONTROLLER
        $arquivo_gerencia = base64_encode("Arquivo_Gerencia");
        $arquivo_add = base64_encode("Arquivo_Add_V");

        $categoria_arquivo_co = base64_encode("CategoriaArquivo_Control"); // CONTROLLER
        $categoria_arquivo_gerencia = base64_encode("CategoriaArquivo_Gerencia");
        $categoria_arquivo_add = base64_encode("CategoriaArquivo_Add_V");

        $categoria_galeria_co = base64_encode("CategoriaGaleria_Control"); // CONTROLLER
        $categoria_galeria_gerencia = base64_encode("CategoriaGaleria_Gerencia");
        $categoria_galeria_add = base64_encode("CategoriaGaleria_Add_V");

        $galeria_co = base64_encode("Galeria_Control"); // CONTROLLER
        $galeria_gerencia = base64_encode("Galeria_Gerencia");
        $galeria_add = base64_encode("Galeria_Add_V");
        
        $tipo_movimentacao_co = base64_encode("TipoMovimentacao_Control"); // CONTROLLER
        $tipo_movimentacao_gerencia = base64_encode("TipoMovimentacao_Gerencia");
        $tipo_movimentacao_add = base64_encode("TipoMovimentacao_Add_V");
        
        
        $movimentacao_co = base64_encode("Movimentacao_Control"); // CONTROLLER
        $movimentacao_gerencia = base64_encode("Movimentacao_Gerencia");
        $movimentacao_add = base64_encode("Movimentacao_Add_V");
        
        $grupo_sms_co = base64_encode("GrupoSMS_Control"); // CONTROLLER
        $grupo_sms_gerencia = base64_encode("GrupoSMS_Gerencia");

        $envio_sms_co = base64_encode("EnvioSMS_Control"); // CONTROLLER
        $aviso_sms_grupo = base64_encode("EnvioSMS_Grupo_V");
        
        $contato_sms_co = base64_encode("ContatoSMS_Control"); // CONTROLLER
        $contato_sms_gerencia = base64_encode("ContatoSMS_Gerencia");
        
        $gear_co = base64_encode("Gear_Control"); // CONTROLLER
        $gear_add = base64_encode("Gear_Add_V");
        
        
        $centro_co = base64_encode("Centro_Control"); // CONTROLLER
        $centro_gerencia = base64_encode("Centro_Gerencia");
        $centro_add = base64_encode("Centro_Add_V");
        
        $eleicao_co = base64_encode("Eleicao_Control"); // CONTROLLER
        $eleicao_resultado = base64_encode("Eleicao_Resultado");

        /**
         * ************************************************************************************************************
         * CONFIGURE AS POSSIVEIS ACOES
         * ***************FIM
         */
        $menu = "";
        Switch ("$perm_usuario") {
            case "R":  // ROOT ED
                $menu = "
                    <div id=\"submenu2\"></div>
                        <div id=\"navegador\">
                            <ul>
                                <li class=\"menu\" id=\"home\"><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$home_co&ac=$home_ac\">Página Inicial</a></li>

                                <li class=\"menu\" ><a href=\"#\">Meus Dados</a>
                                    <ul class=\"submenu\">
                                        <ul class=\"subpartes\">                    
                                            <span>Meus Dados</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$usuario_co&ac=$usuario_mypass\">Alterar Minha Senha</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$usuario_co&ac=$usuario_mydata\">Alterar Meus Dados</a></li>
                                        </ul>
                                    </ul>
                                </li>

                                <li class=\"menu\" ><a href=\"#\">Sistema</a>
                                    <ul class=\"submenu\">
                                        <ul class=\"subpartes\">
                                            <span>Traduções</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$traducao_co&ac=$traducao_add\">Incluir Tradução</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$traducao_co&ac=$traducao_gerencia\">Gerenciar Traduções</a></li>
                                                
                                            <span>Configurações</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$configuracoes_co&ac=$configuracoes_gerencia\">Configurações</a></li>                                            
                                        </ul>
                                        <ul class=\"subpartes\">
                                            <span>Usuários</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$usuario_co&ac=$usuario_add\">Incluir novo Usuário</a></li>
                                             <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$usuario_co&ac=$usuario_gerencia\">Gerenciar Usuário</a></li>
                                            <span>Contatos site</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$contato_co&ac=$contato_gerencia\">Relatório de Contatos</a></li>          
                                        </ul>
                                        <ul class=\"subpartes\">
                                            <span>GEAR</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$gear_co&ac=$gear_add\">Incluir</a></li>        
                                        </ul>
                                    </ul>
                                </li>

                                <li class=\"menu\" ><a href=\"#\">Conteúdo</a>
                                    <ul class=\"submenu\">
                                        <ul class=\"subpartes\">
                                            <span>Páginas</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$conteudo_co&ac=$conteudo_add\">Incluir Página</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$conteudo_co&ac=$conteudo_gerencia\">Gerenciar Páginas</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$conteudo_co&ac=$conteudo_edit\">Atualizar Conteúdo Simples</a></li>
                                            <span>Slider</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$slider_co&ac=$slider_add\">Incluir Novo Slider</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$slider_co&ac=$slider_gerencia\">Gerenciar Slders</a></li>
                                            <span>Galeria</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$galeria_co&ac=$galeria_add\">Incluir Galeria</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$galeria_co&ac=$galeria_gerencia\">Gerenciar Galerias</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_galeria_co&ac=$categoria_galeria_add\">Incluir Nova Categoria</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_galeria_co&ac=$categoria_galeria_gerencia\">Gerenciar Categorias</a></li>
                                        </ul>
                                        <ul class=\"subpartes\">
                                            <span>Noticias</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$noticia_co&ac=$noticia_add\">Incluir Nova Notícia</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$noticia_co&ac=$noticia_gerencia\">Gerenciar Notícias</a></li>
                                            <span>Categoria de Noticias</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_post_co&ac=$categoria_noticia_add\">Incluir Categoria de Notícias</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_post_co&ac=$categoria_noticia_gerencia\">Gerenciar Categorias de Notícias</a></li>
                                            <span>Categoria de Arquivos</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_arquivo_co&ac=$categoria_arquivo_add\">Incluir Categoria de Arquivo</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_arquivo_co&ac=$categoria_arquivo_gerencia\">Gerenciar Categorias de Arquivos</a></li>
                                        </ul>
                                        <ul class=\"subpartes\">
                                            <span>Gestões</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$gestao_co&ac=$gestao_add\">Incluir Nova Gestão</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$gestao_co&ac=$gestao_gerencia\">Gerenciar Gestões</a></li>
                                            <span>Colaboradores</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$colaborador_co&ac=$colaborador_add\">Incluir Novo Colaborador</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$colaborador_co&ac=$colaborador_gerencia\">Gerenciar Colaboradores</a></li>
                                            <span>Convênios</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$convenio_co&ac=$convenio_add\">Incluir Novo Convênio</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$convenio_co&ac=$convenio_gerencia\">Gerenciar Convênios</a></li>
                                        </ul>
                                        <ul class=\"subpartes\">
                                            <span>Arquivos</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$balancete_co&ac=$balancete_add\">Incluir Novo Balancete</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$balancete_co&ac=$balancete_gerencia\">Gerenciar Balancetes</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$arquivo_co&ac=$arquivo_add\">Incluir Novo Arquivo</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$arquivo_co&ac=$arquivo_gerencia\">Gerenciar Arquivos</a></li>
                                            <span>Filiados</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$associado_co&ac=$associado_add\">Incluir Novo Filiado</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$associado_co&ac=$associado_gerencia\">Gerenciar Filiados</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$associado_co&ac=$associado_solicitacoes\">Avaliar Solicitações</a></li>
                                        </ul>
                                    </ul>
                                </li>
                                <li class=\"menu\" ><a href=\"#\">Movimentações</a>
                                    
                                    <ul class=\"submenu\">
                                        <ul class=\"subpartes\">       
                                            <span>Centro de Custo</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$centro_co&ac=$centro_add\">Incluir Centro de Custo</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$centro_co&ac=$centro_gerencia\">Gerenciar Centros de Custo</a></li>
                                       </ul>
                                        <ul class=\"subpartes\">                    
                                            <span>Movimentações</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$movimentacao_co&ac=$movimentacao_add\">Adicionar Movimentação</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$movimentacao_co&ac=$movimentacao_gerencia\">Gerenciar Movimentações</a></li>
                                        </ul>
                                    </ul>
                                </li>
                                <li class=\"menu\" ><a href=\"#\">Comunicação</a>
                                    <ul class=\"submenu\">
                                        <ul class=\"subpartes\">                                                                                    
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$envio_sms_co&ac=$aviso_sms_grupo\">Enviar SMS ao Grupo</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$contato_sms_co&ac=$contato_sms_gerencia\">Gerenciar Contatos</a></li>
                                                
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$grupo_sms_co&ac=$grupo_sms_gerencia\">Gerenciar Grupos de SMS</a></li>
                                        </ul>
                                    </ul>
                                </li> 
                            </ul>
                        <br style=\"clear: left\" />
                        <div id=\"submenu\"></div>
                    </div>
                    ";
                break;

            case "W":  // ROOT ED
                $menu = "
                    <div id=\"submenu2\"></div>
                        <div id=\"navegador\">
                            <ul>
                                <li class=\"menu\" id=\"home\"><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$home_co&ac=$home_ac\">Página Inicial</a></li>

                                <li class=\"menu\" ><a href=\"#\">Meus Dados</a>
                                    <ul class=\"submenu\">
                                        <ul class=\"subpartes\">                    
                                            <span>Meus Dados</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$usuario_co&ac=$usuario_mypass\">Alterar Minha Senha</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$usuario_co&ac=$usuario_mydata\">Alterar Meus Dados</a></li>
                                        </ul>
                                    </ul>
                                </li>

                                <li class=\"menu\" ><a href=\"#\">Conteúdo</a>
                                    <ul class=\"submenu\">
                                        <ul class=\"subpartes\">
                                            <span>Páginas</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$conteudo_co&ac=$conteudo_edit\">Atualizar Conteúdo Simples</a></li>
                                                <span>Galeria</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$galeria_co&ac=$galeria_add\">Incluir Galeria</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$galeria_co&ac=$galeria_gerencia\">Gerenciar Galerias</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_galeria_co&ac=$categoria_galeria_add\">Incluir Nova Categoria</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_galeria_co&ac=$categoria_galeria_gerencia\">Gerenciar Categorias</a></li>
                                        </ul>
                                        <ul class=\"subpartes\">
                                            <span>Noticias</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$noticia_co&ac=$noticia_add\">Incluir Nova Notícia</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$noticia_co&ac=$noticia_gerencia\">Gerenciar Notícias</a></li>
                                            <span>Categoria de Noticias</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_post_co&ac=$categoria_noticia_add\">Incluir Categoria de Notícias</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_post_co&ac=$categoria_noticia_gerencia\">Gerenciar Categorias de Notícias</a></li>
                                            <span>Categoria de Arquivos</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_arquivo_co&ac=$categoria_arquivo_add\">Incluir Categoria de Arquivo</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$categoria_arquivo_co&ac=$categoria_arquivo_gerencia\">Gerenciar Categorias de Arquivos</a></li>
                                        </ul>
                                        <ul class=\"subpartes\">
                                            <span>Gestões</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$gestao_co&ac=$gestao_add\">Incluir Nova Gestão</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$gestao_co&ac=$gestao_gerencia\">Gerenciar Gestões</a></li>
                                            <span>Colaboradores</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$colaborador_co&ac=$colaborador_add\">Incluir Novo Colaborador</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$colaborador_co&ac=$colaborador_gerencia\">Gerenciar Colaboradores</a></li>
                                            <span>Convênios</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$convenio_co&ac=$convenio_add\">Incluir Novo Convênio</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$convenio_co&ac=$convenio_gerencia\">Gerenciar Convênios</a></li>
                                        </ul>
                                        <ul class=\"subpartes\">
                                            <span>Arquivos</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$balancete_co&ac=$balancete_add\">Incluir Novo Balancete</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$balancete_co&ac=$balancete_gerencia\">Gerenciar Balancetes</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$arquivo_co&ac=$arquivo_add\">Incluir Novo Arquivo</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$arquivo_co&ac=$arquivo_gerencia\">Gerenciar Arquivos</a></li>
                                            <span>Filiados</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$associado_co&ac=$associado_add\">Incluir Novo Filiado</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$associado_co&ac=$associado_gerencia\">Gerenciar Filiados</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$associado_co&ac=$associado_solicitacoes\">Avaliar Solicitações</a></li>
                                        </ul>
                                    </ul>
                                </li>
                                <li class=\"menu\" ><a href=\"#\">Movimentações</a>
                                    
                                    <ul class=\"submenu\">
                                        <ul class=\"subpartes\">       
                                            <span>Centro de Custo</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$centro_co&ac=$centro_add\">Incluir Centro de Custo</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$centro_co&ac=$centro_gerencia\">Gerenciar Centros de Custo</a></li>
                                       </ul>
                                        <ul class=\"subpartes\">                    
                                            <span>Movimentações</span>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$movimentacao_co&ac=$movimentacao_add\">Adicionar Movimentação</a></li>
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$movimentacao_co&ac=$movimentacao_gerencia\">Gerenciar Movimentações</a></li>
                                        </ul>
                                    </ul>
                                </li>
                                
                                <li class=\"menu\" ><a href=\"#\">Eleição</a>
                                    <ul class=\"submenu\">
                                        <ul class=\"subpartes\">                                                                                    
                                            <li><a href=\"sys.php?id_sessao=$id_sessao&idioma=$idioma&co=$eleicao_co&ac=$eleicao_resultado\">Resultado Eleição</a></li>
                                        </ul>
                                    </ul>
                                </li>
                            </ul>
                        <br style=\"clear: left\" />
                        <div id=\"submenu\"></div>
                    </div>
                    ";
                break;
        }
        return $menu;
    }

}

?>
