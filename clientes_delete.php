<?php

session_start();

include_once "./check.php";
include "./classes/funcoes.php";

$objDatabase = new Funcoes();
$objDatabase -> setServer("localhost");
$objDatabase -> setUsuario("root");
$objDatabase -> setSenha(null);
$objDatabase -> setDatabase("icebelle_homolog");
$objDatabase -> setTabela("clientes");

$getPost = json_encode($_POST);
$getId = preg_replace('/[\@\.\;\" {}:"]+/', '', $getPost);

$run = mysqli_query($objDatabase -> InicioDatabase(), $objDatabase -> ExcluirCliente($getId));

header("location:./clientes_listar.php");
