<?php

session_start();

include "./classes/funcoes.php";
include_once("./check.php");

$objDatabase = new Funcoes();
$objDatabase -> setServer("localhost");
$objDatabase -> setUsuario("root");
$objDatabase -> setSenha(null);
$objDatabase -> setDatabase("icebelle_homolog");
$objDatabase -> setTabela("produtos");

$getPost = json_encode($_POST);
$getId = preg_replace('/[\@\.\;\" {}:"]+/', '', $getPost);

mysqli_query($objDatabase -> InicioDatabase(), $objDatabase -> ExcluirProduto($getId));
mysqli_close($objDatabase -> InicioDatabase());

header("location:./produtos_listar.php");
