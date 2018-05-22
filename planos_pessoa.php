<?php

require_once 'config.php';

class Planos_pessoa {

    private $id_pessoa;
    private $id_plano;
    private $data_pagamento;
    private $flg_pagamento;

    function getId_pessoa() {
        return $this->id_pessoa;
    }

    function getId_plano() {
        return $this->id_plano;
    }

    function getData_pagamento() {
        return $this->data_pagamento;
    }

    function getFlg_pagamento() {
        return $this->flg_pagamento;
    }

    function setId_pessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
    }

    function setId_plano($id_plano) {
        $this->id_plano = $id_plano;
    }

    function setData_pagamento($data_pagamento) {
        $this->data_pagamento = $data_pagamento;
    }

    function setFlg_pagamento($flg_pagamento) {
        $this->flg_pagamento = $flg_pagamento;
    }

    public function dados_boleto($id_servico) {
        $db = new DB();
        $link = $db->DBconnect();
        $query = "SELECT p.nome, p.cpf_cnpj, p.flg_pessoa_juridica,p.nome_fantasia, e.endereco, e.cep, c.nome as cidade, es.nome as estado, pl.*, plp.*  FROM magiclink.Planos_pessoa plp "
                . "INNER JOIN Planos pl ON (plp.id_plano = pl.id_plano) "
                . "INNER JOIN Pessoa p ON (plp.id_pessoa = p.id_pessoa) "
                . "INNER JOIN Endereco e ON (e.id_pessoa = p.id_pessoa) "
                . "INNER JOIN Cidade c ON (c.id_cidade = e.cidade_id) "
                . "INNER JOIN Estado es ON (c.id_estado = es.id_estado) "
                . "WHERE plp.id_servico = " . $id_servico . " order by data_pagamento";
        $resultado = mysqli_query($link, $query);
        $dados = mysqli_fetch_array($resultado);
        $db->DBclose($link);
        return $dados;
    }

    public function listar_boleto_pessoa($id_pessoa) {
        $db = new DB();
        $link = $db->DBconnect();
        $query = "SELECT * FROM magiclink.Planos_pessoa plp "
                . "INNER JOIN Planos p ON (plp.id_plano = p.id_plano) "
                . "WHERE id_pessoa = " . $id_pessoa . " ORDER BY data_pagamento";
        $resultado = mysqli_query($link, $query);
        $dados = mysqli_fetch_all($resultado);
        $db->DBclose($link);
        return $dados;
    }
}
