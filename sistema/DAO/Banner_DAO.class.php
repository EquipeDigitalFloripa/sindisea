<?php
require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");

/**
 * DAO da entidade Noticia, acessa todas as operações de banco de dados referentes ao Model Noticia
 *
 * @author Marcela Santana <marcela@equipedigital.com>
 * @copyright Copyright (c) 2009-2012, EquipeDigital.com
 * @link http://www.equipedigital.com
 * @license Comercial
 *
 * @Data_Criacao 13/10/2009
 * @Ultima_Modif 13/10/2009 por Marcela Santana
 *
 *
 * @package DAO
 *
 */

class Banner_DAO extends Generic_DAO {

    public $chave = 'id_banner';
    public $tabela = 'tb_banner';

    public function __construct($factory) {

        parent::__construct($factory, $this->chave, $this->tabela);
    }

    /**
     * Salva o objeto, se tiver id setado executa update, se não tiver executa insert
     *
     * @author Marcela Santana
     * @param Objeto $objeto Objeto
     * @return mixed int id_mailing no caso de cadastro e Boolean true no caso de update
     * @Exemplo
     * <code>
     *
     * <?php
     *
     *  // dentro do controller, operação de cadastro de novo Artigo
     *
     *  $meuObjetoDAO    = new DAO_Objeto("AF_Bd_Mysql");
     *  $meuObjetoArtigo = new Artigo();
     *     ... popula o objeto só faltando o id
     *  $meuObjetoDAO->Save($meuObjetoArtigo);
     *
     * ?>
     * </code>
     *
     */

    public function Save($objeto){

        if($objeto->get_id_banner() == ""){ // Cadastra nova notícia

             $sql        = "LOCK TABLES tb_banner WRITE";
             $this->conexao->consulta("$sql");

             $sql        = "select max(id_banner) id_banner from tb_banner where id_banner < 999990";
             $result     = $this->conexao->consulta("$sql");
             $row        = $this->conexao->criaArray($result);

             $id_banner_new    = $row[0][0];
             $id_banner_new++;

             $objeto->set_id_banner($id_banner_new);

             $dados = array_map("addslashes", $objeto->get_all_dados());
             $sql        = "INSERT INTO tb_banner values("
                             .$dados['id_banner'].",
                          \"".$dados['nome']."\",
                          \"".$dados['ext']."\",
                          \"".$dados['link']."\",
                          \"".$dados['regiao']."\",
                          \"".$dados['status_banner']."\"
                            );";
             $this->conexao->consulta("$sql");

             $sql        = "UNLOCK TABLES";
             $this->conexao->consulta("$sql");

             return $id_banner_new;

       }else{ // já tem ID então é UPDATE

             $dados = $objeto->get_all_dados();
             $sql        = "UPDATE tb_banner SET
                          nome               = \"".$dados['nome']."\",
                          ext                = \"".$dados['ext']."\",
                          link               = \"".$dados['link']."\",
                          regiao             = \"".$dados['regiao']."\",
                          status_banner      = \"".$dados['status_banner']."\"
                            where id_banner = ".$dados['id_banner']."
                            ";
             $this->conexao->consulta("$sql");
             return true;

       }


   } // fim do Save

  /**
  * Apaga o registro através do id passado por parâmetro
  *
  * @author Ricardo Ribeiro Assink
  * @param int $id ID do registro que deve ser apagado
  * @return void
  */
    public function Delete($id){

        $sql = "DELETE FROM tb_banner where id_banner = $id";
        $this->conexao->consulta("$sql");

    }

  /**
  *
  * DAO deve instanciar um objeto do Modelo e populá-lo com os dados do Banco de Dados
  *
  * @author Ricardo Ribeiro Assink
  * @param int $id ID do registro que deve popular o objeto
  * @return Objeto Objeto populado
  */
    public function loadObjeto($id){

         $objeto = new Banner();
         $objeto->set_id_banner($id);
            $sql = "
                    SELECT
                          nome,
                          ext,
                          link,
                          regiao,
                          status_banner
                     FROM
                          tb_banner
                     WHERE
                          id_banner = $id;
                   ";

            $result = $this->conexao->consulta("$sql");
            $row    = $this->conexao->criaArray($result);
            
            $objeto->set_nome($row[0][0]);
            $objeto->set_ext($row[0][1]);
            $objeto->set_link($row[0][2]);
            $objeto->set_regiao($row[0][3]);
            $objeto->set_status_banner($row[0][4]);

            return $objeto;
                     
   }


/**
 * Pega o total de registros da tabela através da condição enviada.
 *
 * @author Ricardo Ribeiro Assink
 * @param String $condicao Condição para cálculo do total de registros
 * @return int Total de Registros
 * @Exemplo
 * <code>
 *
 * <?php
 *
 * $meuObjetoDAO    = new DAO_Objeto("AF_Bd_Mysql");
 * $total_registro  = $meuObjetoDAO->get_Total("status_usuario = 'A'");
 *
 *     // pega o total de usuários ativos
 *
 * ?>
 * </code>
 *
 */
    public function get_Total($condicao){

        $sql    = "SELECT count(id_banner) from tb_banner where status_banner <> \"D\" $condicao";
        $result = $this->conexao->consulta("$sql");
        $ret    = $this->conexao->criaArray($result);
        return $ret[0][0];
    }


/**
 *
 * Pega um Array com o todos os ids de registro conforme parâmetros.
 *
 * @author Ricardo Ribeiro Assink
 * @param String $condicao Instrução SQL
 * @param String $ordem Condição Instrução SQL
 * @param int $iniciao Registro inicial
 * @param int $fim Registro Final
 * @return Array Array com os ids dos registros
 * @Exemplo
 * <code>
 *
 * <?php
 *
 * $meuObjetoDAO    = new DAO_Objeto("AF_Bd_Mysql");
 * $ids_de_usuarios = Array();
 * $ids_de_usuarios = $meuObjetoDAO->get_Ids("status_usuario = 'A'","nome_usuario",0,15);
 *
 *  // pega os 15 primeiros ids ordenados pelo nome, dos registros no banco onde o usuário está ativo
 *
 * ?>
 * </code>
 *
 */
    public function get_Ids($condicao,$ordem,$inicio,$pag_views){

        if(!isset($inicio) or !isset($pag_views)){
            $limite = "";
        }else{
            $limite = "LIMIT $inicio,$pag_views";
        }

        $sql    = "SELECT id_banner from tb_banner where status_banner <> \"D\" $condicao order by $ordem $limite";
    
        $result = $this->conexao->consulta("$sql");
        $ret    = $this->conexao->criaArrayOnce($result);
        return $ret;
    }
/**
 *
 * Retorna um Array com o todos os objetos carregados conforme parâmetros.
 *
 * @author Ricardo Ribeiro Assink
 * @param String $condicao Instrução SQL
 * @param String $ordem Condição Instrução SQL
 * @param int $iniciao Registro inicial
 * @param int $fim Registro Final
 * @return Array Array com o todos os objetos carregados conforme parâmetros.
 * @Exemplo
 * <code>
 *
 * <?php
 *
 * $meuObjetoDAO    = new DAO_Objeto("AF_Bd_Mysql");
 * $objs_de_usuarios = Array();
 * $objs_de_usuarios = $meuObjetoDAO->get_Objs("status_usuario = 'A'","nome_usuario",0,15);
 *
 *
 * ?>
 * </code>
 *
 */
    public function get_Objs($condicao,$ordem,$inicio,$pag_views){
     
        $ret    = $this->get_Ids($condicao,$ordem,$inicio,$pag_views);
        $objs   = Array();

        if(count($ret) > 0){
            foreach($ret as $valor){
                $o    = $this->loadObjeto($valor);
                Array_push($objs,$o);

            }
        }

        return $objs;
    }


 /**
  *
  * Retorna as descrições de campos
  *
  * @author Ricardo Ribeiro Assink
  * @param Classe $className Nome do arquivo da classe
  * @return Array Array com as descrições de campos
  *
  * @exemplo
  * <code>
  *
  * Array
  *      (
  *          [desc_perm_usuario] => Array
  *              (
  *                  [R] => Root
  *                  [W] => Webmaster
  *                  [A] => Autor
  *                  [D] => Diretor do Portal
  *                  [C] => Consultor
  *                  [S] => Salva Vidas
  *              )
  *
  *          [desc_status_usuario] => Array
  *              (
  *                  [P] => Aguardando aprovação
  *                  [N] => Negada a entrada na Comunidade
  *                  [A] => Ativo
  *                  [I] => Inativo
  *              )
  *
  *      )
  *
  *
  * </code>
  *
  */

    public function get_Descricao(){
  
        //$desc = Array();
        $sql = "SELECT id_regiao,nome from tb_regiao_banner";
        $result               = $this->conexao->consulta("$sql");
        $desc_regioes    = $this->conexao->criaArray($result);
        $i = 0;
        while($i < count($desc_regioes)){
            $desc_regioes_compact[$desc_regioes[$i]['id_regiao']] = $desc_regioes[$i]['nome'];
            $i++;
           
        }
        $desc['regiao'] = $desc_regioes_compact;
        return $desc;

    }


}


// TESTES

/*
// SAVE
$ObjetoDAO       = new Usuario_DAO("AF_Bd_Mysql");
$ObjetoUsuario   = new Usuario();

            //$ObjetoUsuario->set_id_usuario(1);
            $ObjetoUsuario->set_nome_usuario("Ricardo");
            $ObjetoUsuario->set_perm_usuario("W");
            $ObjetoUsuario->set_login_usuario("ricardo");
            $ObjetoUsuario->set_senha_usuario("c8a3e8eaab214d4df54b47c2b032a03000b768e5");
            $ObjetoUsuario->set_email_usuario("ricardo@equipedigital.com");
            $ObjetoUsuario->set_endereco_usuario("endereco");
            $ObjetoUsuario->set_bairro_usuario("bairro");
            $ObjetoUsuario->set_complemento_end_usuario("complemento");
            $ObjetoUsuario->set_cep_usuario("88034-000");
            $ObjetoUsuario->set_cidade_usuario("Floripa");
            $ObjetoUsuario->set_pais_residencia_usuario("pais");
            $ObjetoUsuario->set_telefone_usuario("tel");
            $ObjetoUsuario->set_website_usuario("website");
            $ObjetoUsuario->set_nacionalidade_usuario("nacionalidade");
            $ObjetoUsuario->set_naturalidade_usuario("naturalidade");
            $ObjetoUsuario->set_instituicao_usuario("instituicao");
            $ObjetoUsuario->set_local_instituicao_usuario("local_instituicao");
            $ObjetoUsuario->set_areas_interesse_usuario("areas_interesse");
            $ObjetoUsuario->set_areas_especialidade_usuario("areas_especialidade");
            $ObjetoUsuario->set_autoriza_public_email("S");
            $ObjetoUsuario->set_outros_dados_usuario("outros dados");
            $ObjetoUsuario->set_data_cadastro("2009-09-09 09:09:09");
            $ObjetoUsuario->set_status_usuario("A");

  echo $ObjetoDAO->Save($ObjetoUsuario);




// DELETE
//$ObjetoDAO       = new DAO_Usuario("AF_Bd_Mysql");
//$ObjetoDAO->Delete(1);

*/
// loadObjeto
//$ObjetoDAO       = new Banner_DAO("AF_Bd_Mysql");
//$meuusuario      = $ObjetoDAO->loadObjeto(1);
//print_r($meuusuario->get_all_dados());

/*
// get_Total
//$ObjetoDAO       = new DAO_Usuario("AF_Bd_Mysql");
//echo $ObjetoDAO->get_Total("id_usuario > 0");

// teste do get_Ids

// $meuObjetoDAO    = new DAO_Usuario("AF_Bd_Mysql");
// $ids_de_usuarios = Array();
// $ids_de_usuarios = $meuObjetoDAO->get_Ids("status_usuario = 'A'","nome_usuario",0,3);
// print_r($ids_de_usuarios);


//$ObjetoDAO       = new Mailing_DAO("AF_Bd_Mysql");
//$meuusuario      = $ObjetoDAO->loadObjeto();
//print_r($ObjetoDAO->get_Descricao());*/



?>
