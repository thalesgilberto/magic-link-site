<?php
require_once 'config.php';

class Pessoa {

    private $id_pessoa;
    private $nome;
    private $nome_fantasia;
    private $data_nascimento;
    private $sexo;
    private $cpf_cnpj;
    private $email;
    private $inscricao_estadual;
    private $inscricao_municipal;
    private $flg_pessoa_juridica;
    private $flg_funcionario;
    private $senha;
    private $img_user;
    private $data_cadastro;

############## GETS ###############    

    public function getId_pessoa() {
        return $this->id_pessoa;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getNome_fantasia() {
        return $this->nome_fantasia;
    }

    public function getData_nascimento() {
        return $this->data_nascimento;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getCpf_cnpj() {
        return $this->cpf_cnpj;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getInscricao_estadual() {
        return $this->inscricao_estadual;
    }

    public function getInscricao_municipal() {
        return $this->inscricao_municipal;
    }

    public function getFlg_pessoa_juridica() {
        return $this->flg_pessoa_juridica;
    }

    public function getFlg_funcionario() {
        return $this->$flg_funcionario;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getImg_user() {
        return $this->img_user;
    }

    public function getData_cadastro() {
        return $this->data_cadastro;
    }

################## SETS ####################

    public function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setNome_fantasia($nome_fantasia) {
        $this->nome_fantasia = $nome_fantasia;
    }

    public function setData_nascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    public function setCpf_cnpj($cpf_cnpj) {
        $this->cpf_cnpj = $cpf_cnpj;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setInscricao_estadual($inscricao_estadual) {
        $this->inscricao_estadual = $inscricao_estadual;
    }

    public function setInscricao_municipal($inscricao_municipal) {
        $this->inscricao_municipal = $inscricao_municipal;
    }

    public function setFlg_pessoa_juridica($flg_pessoa_juridica) {
        $this->flg_pessoa_juridica = $flg_pessoa_juridica;
    }

    public function setFlg_funcionario($flg_funcionario) {
        $this->flg_funcionario = $flg_funcionario;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setImg_user($img_user) {
        $this->img_user = $img_user;
    }

    public function setData_cadastro($data_cadastro) {
        $this->data_cadastro = $data_cadastro;
    }

    public function validar_usuario() {
        $db = new DB();
        $link = $db->DBconnect();
        $query = "SELECT id_pessoa, nome, email, img_user FROM Pessoa "
                . "WHERE email='" . $this->email . "' AND senha='" . $this->senha . "' limit 1";
        $resultado = mysqli_query($link, $query);
        $dados = mysqli_fetch_array($resultado);


        if (!empty($dados)) {
            $_SESSION['nome_cliente'] = $dados["nome"];
            $_SESSION['id_pessoa_cliente'] = $dados["id_pessoa"];
            $_SESSION['email_cliente'] = $dados['email'];
            $db->DBclose($link);
            return true;
        } else {
            $db->DBclose($link);
            return false;
        }
    }

    public function mostrar_dados_pessoa($id) {
        $db = new DB();
        $link = $db->DBconnect();
        $query = "SELECT P.*, T.*, E.*, concat(C.nome,' (',ES.uf,')') cidade FROM magiclink.Pessoa P "
                . "INNER JOIN Telefone T ON (P.id_pessoa = T.id_pessoa) INNER JOIN Endereco E ON (P.id_pessoa = E.id_pessoa) "
                . "INNER JOIN Cidade C ON (E.cidade_id = C.id_cidade) INNER JOIN Estado ES ON (C.id_estado = ES.id_estado) "
                . "WHERE P.id_pessoa = " . $id;
        $resultado = mysqli_query($link, $query);
        $dados = mysqli_fetch_array($resultado);
        $db->DBclose($link);
        return $dados;
    }

    
}
