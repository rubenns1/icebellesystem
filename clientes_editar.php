<?php

    include "./classes/cliente.php";
    include "./classes/funcoes.php";

    $objCliente = new Cliente();

    $objCliente->setId($_POST["id"]);
    $objCliente->setNome($_POST["nome"]);
    $objCliente->setContato($_POST["contato"]);


    $objDatabase = new Funcoes();
    $objDatabase->setServer("localhost");
    $objDatabase->setUsuario("root");
    $objDatabase->setSenha(null);
    $objDatabase->setDatabase("icebelle_homolog");
    $objDatabase->setTabela("clientes");

    try
    {
        mysqli_query($objDatabase->InicioDatabase(), $objDatabase->AtualizarCliente($objCliente->getNome(), $objCliente->getContato(), $objCliente->getId()));
        header("location:./clientes_listar.php");
    }
    catch(Exception $exception)
    {
        echo "Falha!";
    }