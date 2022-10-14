<?php 
class Usuario {

	private $id_usuario; 
	private $nome_usuario; 
	private $perm_usuario; 
	private $login_usuario; 
	private $senha_usuario; 
	private $email_usuario; 
	private $endereco_usuario; 
	private $bairro_usuario; 
	private $complemento_end_usuario; 
	private $cep_usuario; 
	private $cidade_usuario; 
	private $pais_residencia_usuario; 
	private $telefone_usuario; 
	private $website_usuario; 
	private $nacionalidade_usuario; 
	private $naturalidade_usuario; 
	private $instituicao_usuario; 
	private $local_instituicao_usuario; 
	private $areas_interesse_usuario; 
	private $areas_especialidade_usuario; 
	private $autoriza_public_email; 
	private $outros_dados_usuario; 
	private $data_cadastro; 
	private $status_usuario; 

	public function get_id_usuario(){
             return $this->id_usuario;
	}
             
	public function set_id_usuario($id_usuario){
             	$this->id_usuario = $id_usuario;
	}

	public function get_nome_usuario(){
             return $this->nome_usuario;
	}
             
	public function set_nome_usuario($nome_usuario){
             	$this->nome_usuario = $nome_usuario;
	}

	public function get_perm_usuario(){
             return $this->perm_usuario;
	}
             
	public function set_perm_usuario($perm_usuario){
             	$this->perm_usuario = $perm_usuario;
	}

	public function get_login_usuario(){
             return $this->login_usuario;
	}
             
	public function set_login_usuario($login_usuario){
             	$this->login_usuario = $login_usuario;
	}

	public function get_senha_usuario(){
             return $this->senha_usuario;
	}
             
	public function set_senha_usuario($senha_usuario){
             	$this->senha_usuario = $senha_usuario;
	}

	public function get_email_usuario(){
             return $this->email_usuario;
	}
             
	public function set_email_usuario($email_usuario){
             	$this->email_usuario = $email_usuario;
	}

	public function get_endereco_usuario(){
             return $this->endereco_usuario;
	}
             
	public function set_endereco_usuario($endereco_usuario){
             	$this->endereco_usuario = $endereco_usuario;
	}

	public function get_bairro_usuario(){
             return $this->bairro_usuario;
	}
             
	public function set_bairro_usuario($bairro_usuario){
             	$this->bairro_usuario = $bairro_usuario;
	}

	public function get_complemento_end_usuario(){
             return $this->complemento_end_usuario;
	}
             
	public function set_complemento_end_usuario($complemento_end_usuario){
             	$this->complemento_end_usuario = $complemento_end_usuario;
	}

	public function get_cep_usuario(){
             return $this->cep_usuario;
	}
             
	public function set_cep_usuario($cep_usuario){
             	$this->cep_usuario = $cep_usuario;
	}

	public function get_cidade_usuario(){
             return $this->cidade_usuario;
	}
             
	public function set_cidade_usuario($cidade_usuario){
             	$this->cidade_usuario = $cidade_usuario;
	}

	public function get_pais_residencia_usuario(){
             return $this->pais_residencia_usuario;
	}
             
	public function set_pais_residencia_usuario($pais_residencia_usuario){
             	$this->pais_residencia_usuario = $pais_residencia_usuario;
	}

	public function get_telefone_usuario(){
             return $this->telefone_usuario;
	}
             
	public function set_telefone_usuario($telefone_usuario){
             	$this->telefone_usuario = $telefone_usuario;
	}

	public function get_website_usuario(){
             return $this->website_usuario;
	}
             
	public function set_website_usuario($website_usuario){
             	$this->website_usuario = $website_usuario;
	}

	public function get_nacionalidade_usuario(){
             return $this->nacionalidade_usuario;
	}
             
	public function set_nacionalidade_usuario($nacionalidade_usuario){
             	$this->nacionalidade_usuario = $nacionalidade_usuario;
	}

	public function get_naturalidade_usuario(){
             return $this->naturalidade_usuario;
	}
             
	public function set_naturalidade_usuario($naturalidade_usuario){
             	$this->naturalidade_usuario = $naturalidade_usuario;
	}

	public function get_instituicao_usuario(){
             return $this->instituicao_usuario;
	}
             
	public function set_instituicao_usuario($instituicao_usuario){
             	$this->instituicao_usuario = $instituicao_usuario;
	}

	public function get_local_instituicao_usuario(){
             return $this->local_instituicao_usuario;
	}
             
	public function set_local_instituicao_usuario($local_instituicao_usuario){
             	$this->local_instituicao_usuario = $local_instituicao_usuario;
	}

	public function get_areas_interesse_usuario(){
             return $this->areas_interesse_usuario;
	}
             
	public function set_areas_interesse_usuario($areas_interesse_usuario){
             	$this->areas_interesse_usuario = $areas_interesse_usuario;
	}

	public function get_areas_especialidade_usuario(){
             return $this->areas_especialidade_usuario;
	}
             
	public function set_areas_especialidade_usuario($areas_especialidade_usuario){
             	$this->areas_especialidade_usuario = $areas_especialidade_usuario;
	}

	public function get_autoriza_public_email(){
             return $this->autoriza_public_email;
	}
             
	public function set_autoriza_public_email($autoriza_public_email){
             	$this->autoriza_public_email = $autoriza_public_email;
	}

	public function get_outros_dados_usuario(){
             return $this->outros_dados_usuario;
	}
             
	public function set_outros_dados_usuario($outros_dados_usuario){
             	$this->outros_dados_usuario = $outros_dados_usuario;
	}

	public function get_data_cadastro(){
             return $this->data_cadastro;
	}
             
	public function set_data_cadastro($data_cadastro){
             	$this->data_cadastro = $data_cadastro;
	}

	public function get_status_usuario(){
             return $this->status_usuario;
	}
             
	public function set_status_usuario($status_usuario){
             	$this->status_usuario = $status_usuario;
	}

	public function get_all_dados(){
        	$classe = new ReflectionClass($this);
        $props = $classe->getProperties();
        $props_arr = array();
        foreach($props as $prop){
            $f = $prop->getName();
            // pra nao voltar a conexao
            if($f != "conexao"){
                $exec = '$valor = $this->get_'.$f.'();';
                eval($exec);
                $props_arr[$f] = $valor;
            }
        }
        return $props_arr;
     }} ?>