<?php

class Database
{
    private $server;
    private $usuario;
    private $senha;
    private $database;
    private $tabela;

    public function setServer($server)
    {
        $this->server = $server;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setDatabase($database)
    {
        $this->database = $database;
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function setTabela($tabela)
    {
        $this->tabela = $tabela;
    }

    public function getTabela()
    {
        return $this->tabela;
    }
}
