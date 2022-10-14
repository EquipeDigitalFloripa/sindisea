<?php

class Associado {

    private $id_associado;
    private $nome;
    private $email_trabalho;
    private $email_pessoal;
    private $cpf;
    private $data_nascimento;
    private $matricula;
    private $unidade_organizacional;
    private $categoria;
    private $telefone_residencial;
    private $telefone_trabalho;
    private $telefone_celular;
    private $cep;
    private $endereco;
    private $numero;
    private $complemento;
    private $bairro;
    private $cidade;
    private $estado;
    private $senha;
    private $token;
    private $data_cadastro;
    private $status_associado;
    private $data_inicio_filiacao;
    private $data_fim_filiacao;
    private $observacoes;

    public function get_id_associado() {
        return $this->id_associado;
    }

    public function set_id_associado($id_associado) {
        $this->id_associado = $id_associado;
    }

    public function get_nome() {
        return $this->nome;
    }

    public function set_nome($nome) {
        $this->nome = $nome;
    }

    public function get_email_trabalho() {
        return $this->email_trabalho;
    }

    public function set_email_trabalho($email_trabalho) {
        $this->email_trabalho = $email_trabalho;
    }

    public function get_email_pessoal() {
        return $this->email_pessoal;
    }

    public function set_email_pessoal($email_pessoal) {
        $this->email_pessoal = $email_pessoal;
    }

    public function get_cpf() {
        return $this->cpf;
    }

    public function set_cpf($cpf) {
        $this->cpf = $cpf;
    }

    public function get_data_nascimento() {
        return $this->data_nascimento;
    }

    public function set_data_nascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }

    public function get_matricula() {
        return $this->matricula;
    }

    public function set_matricula($matricula) {
        $this->matricula = $matricula;
    }

    public function get_unidade_organizacional() {
        return $this->unidade_organizacional;
    }

    public function set_unidade_organizacional($unidade_organizacional) {
        $this->unidade_organizacional = $unidade_organizacional;
    }

    public function get_categoria() {
        return $this->categoria;
    }

    public function set_categoria($categoria) {
        $this->categoria = $categoria;
    }

    public function get_telefone_residencial() {
        return $this->telefone_residencial;
    }

    public function set_telefone_residencial($telefone_residencial) {
        $this->telefone_residencial = $telefone_residencial;
    }

    public function get_telefone_trabalho() {
        return $this->telefone_trabalho;
    }

    public function set_telefone_trabalho($telefone_trabalho) {
        $this->telefone_trabalho = $telefone_trabalho;
    }

    public function get_telefone_celular() {
        return $this->telefone_celular;
    }

    public function set_telefone_celular($telefone_celular) {
        $this->telefone_celular = $telefone_celular;
    }

    public function get_cep() {
        return $this->cep;
    }

    public function set_cep($cep) {
        $this->cep = $cep;
    }

    public function get_endereco() {
        return $this->endereco;
    }

    public function set_endereco($endereco) {
        $this->endereco = $endereco;
    }

    public function get_numero() {
        return $this->numero;
    }

    public function set_numero($numero) {
        $this->numero = $numero;
    }

    public function get_complemento() {
        return $this->complemento;
    }

    public function set_complemento($complemento) {
        $this->complemento = $complemento;
    }

    public function get_bairro() {
        return $this->bairro;
    }

    public function set_bairro($bairro) {
        $this->bairro = $bairro;
    }

    public function get_cidade() {
        return $this->cidade;
    }

    public function set_cidade($cidade) {
        $this->cidade = $cidade;
    }

    public function get_estado() {
        return $this->estado;
    }

    public function set_estado($estado) {
        $this->estado = $estado;
    }

    public function get_senha() {
        return $this->senha;
    }

    public function set_senha($senha) {
        $this->senha = $senha;
    }

    public function get_token() {
        return $this->token;
    }

    public function set_token($token) {
        $this->token = $token;
    }

    public function get_data_cadastro() {
        return $this->data_cadastro;
    }

    public function set_data_cadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
    }

    public function get_status_associado() {
        return $this->status_associado;
    }

    public function set_status_associado($status_associado) {
        $this->status_associado = $status_associado;
    }
    
    public function get_data_inicio_filiacao() {
        return $this->data_inicio_filiacao;
    }

    public function set_data_inicio_filiacao($data_inicio_filiacao) {
        $this->data_inicio_filiacao = $data_inicio_filiacao;
    }
    
    public function get_data_fim_filiacao() {
        return $this->data_fim_filiacao;
    }

    public function set_data_fim_filiacao($data_fim_filiacao) {
        $this->data_fim_filiacao = $data_fim_filiacao;
    }
    
    public function get_observacoes() {
        return $this->observacoes;
    }

    public function set_observacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    public function get_all_dados() {
        $classe = new ReflectionClass($this);
        $props = $classe->getProperties();
        $props_arr = array();
        foreach ($props as $prop) {
            $f = $prop->getName();
            // pra nao voltar a conexao
            if ($f != "conexao") {
                $exec = '$valor = $this->get_' . $f . '();';
                eval($exec);
                $props_arr[$f] = $valor;
            }
        }
        return $props_arr;
    }

}

?>