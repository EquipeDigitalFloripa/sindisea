<?php

require_once($_SERVER['DOCUMENT_ROOT']."/sistema/AutoLoader.php");

/**
 * Interface que dita o padrão dos DAOs
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
 * @package DAO
 *
 */



interface DAO {

/** 
 * Salva o objeto, se tiver id setado executa update, se não tiver executa insert  
 * 
 * @author Ricardo Ribeiro Assink
 * @param Objeto $objeto Objeto
 * @return void 
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

   public function Save($objeto);
 
  /** 
  * Apaga o registro através do id passado por parâmetro 
  * 
  * @author Ricardo Ribeiro Assink 
  * @param int $id ID do registro que deve ser apagado 
  * @return void
  */
    public function Delete($id);

  /**
  *
  * DAO deve instanciar um objeto do Modelo e populá-lo com os dados do Banco de Dados
  *
  * @author Ricardo Ribeiro Assink
  * @param int $id ID do registro que deve popular o objeto
  * @return Objeto Objeto populado
  */
    public function loadObjeto($id);
    
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
    public function get_Total($condicao);
    
/** 
 *
 * Retorna um Array com o todos os ids de registro conforme parâmetros.
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
   public function get_Ids($condicao,$ordem,$inicio,$fim);


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
   public function get_Objs($condicao,$ordem,$inicio,$fim);

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
   public function get_Descricoes();
   
    
}



?>
