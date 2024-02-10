<?php

include "./classes/database.php";

class Funcoes extends Database
{
    // Autenticação & start database

    public function InicioDatabase()
    {
        $query = mysqli_connect($this->getServer(), $this->getUsuario(), $this->getSenha(), $this->getDatabase());
        return $query;
    }

    // Logar no sistema

    public function Logar($getLogin, $getPassword)
    {
        $query = "select login, password from {$this->getTabela()} where binary login = '{$getLogin}' and binary password = '{$getPassword}'";
        return $query;
    }

    // Cadastra novo cliente

    public function InserirCliente($setNome, $setEmpresa, $setContato)
    {
        $query = "insert into {$this->getTabela()}(nome, id_empresa, data_cadastro, whatsapp) VALUES('$setNome', (select id from empresas where nome = '$setEmpresa'), NOW(), '$setContato')";
        return $query;
    }

    // Mostra todos os clientes cadastrados

    public function ListarClientes()
    {
        $query = "select clientes.id, clientes.nome, clientes.whatsapp as whatsapp, empresas.nome as empresa, date_format(clientes.data_cadastro, '%d/%m/%Y') as data_cadastro from {$this->getTabela()} join empresas on empresas.id = clientes.id_empresa order by clientes.nome";
        return $query;
    }

    // Atualizar cliente existente

    public function AtualizarCliente($getNome, $getContato, $getId)
    {
        $query = "UPDATE {$this->getTabela()} SET nome = '{$getNome}', whatsapp = '{$getContato}' WHERE id = {$getId}";
        return $query;
    }

    // Exclui um cliente cadastrado

    public function ExcluirCliente($getId)
    {
        $query = "DELETE FROM {$this->getTabela()} WHERE ID = $getId";
        return $query;
    }

    // Cadastra nova empresa

    public function InserirEmpresa($setNome)
    {
        $query = "INSERT INTO {$this->getTabela()}(NOME, DATA_CADASTRO) VALUES('$setNome', NOW())";
        return $query;
    }

    // Mostra todas as empresas cadastradas

    public function ListarEmpresas()
    {
        $query = "SELECT EMPRESAS.ID, EMPRESAS.NOME, DATE_FORMAT(EMPRESAS.DATA_CADASTRO, '%d/%m/%Y') AS DATA_CADASTRO FROM EMPRESAS GROUP BY EMPRESAS.NOME";
        return $query;
    }

    // Exclui uma empresa cadastrada

    public function ExcluirEmpresa($getId)
    {
        $query = "DELETE FROM EMPRESAS WHERE ID = $getId";
        return $query;
    }

    // Cadastra um novo produto

    public function InserirProduto($setNome, $setLote, $setValor, $setQuantidade, $setEntrada, $setFabricacao, $setValidade)
    {
        $query = "INSERT INTO {$this->getTabela()}(PRODUTO, LOTE, PRECO, QUANTIDADE, DATA_CADASTRO, DATA_FABRICACAO, DATA_VALIDADE) VALUES('{$setNome}', {$setLote}, {$setValor}, {$setQuantidade}, $setEntrada, STR_TO_DATE('{$setFabricacao}', '%d/%m/%Y'), STR_TO_DATE('{$setValidade}', '%d/%m/%Y')) ON DUPLICATE KEY UPDATE PRECO = {$setValor}, QUANTIDADE = QUANTIDADE + {$setQuantidade}, DATA_FABRICACAO = STR_TO_DATE('{$setFabricacao}', '%d/%m/%Y'), DATA_VALIDADE = STR_TO_DATE('{$setValidade}', '%d/%m/%Y')";
        return $query;
    }

    // Mostra todos os produtos cadastrados

    public function ListarProdutos()
    {
        $query = "SELECT PRODUTOS.ID, PRODUTO, LOTE, PRECO, QUANTIDADE, DATE_FORMAT(DATA_CADASTRO, '%d/%m/%Y') AS CADASTRO, PRECO * QUANTIDADE AS TOTAL, DATE_FORMAT(DATA_FABRICACAO, '%d/%m/%Y') AS FABRICACAO, DATE_FORMAT(DATA_VALIDADE, '%d/%m/%Y') AS VALIDADE FROM {$this->getTabela()} ORDER BY QUANTIDADE > 0 DESC, VALIDADE ASC";
        return $query;
    }

    // Atualizar produto existente

    public function AtualizarProduto($setNome, $setValor, $setQuantidade, $setFabricacao, $setValidade, $getId)
    {
        $query = "UPDATE {$this->getTabela()} SET PRODUTO = '{$setNome}', PRECO = $setValor, QUANTIDADE = $setQuantidade, DATA_FABRICACAO = STR_TO_DATE('{$setFabricacao}', '%d/%m/%Y'), DATA_VALIDADE = STR_TO_DATE('{$setValidade}', '%d/%m/%Y') WHERE ID = $getId";
        return $query;
    }

    // Exclui um produto cadastrado

    public function ExcluirProduto($getId)
    {
        $query = "DELETE FROM {$this->getTabela()} WHERE ID = $getId";
        return $query;
    }
}
