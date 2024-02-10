<?php

session_start();

include_once "./check.php";
include "./classes/funcoes.php";

$getPost = json_encode($_POST);
$getId = preg_replace('/[\@\.\;\" {}:"]+/', '', $getPost);

$objDatabase = new Funcoes();

$objDatabase -> setServer("localhost");
$objDatabase -> setUsuario("root");
$objDatabase -> setSenha(null);
$objDatabase -> setDatabase("icebelle_homolog");
$objDatabase -> setTabela("empresas");

mysqli_query($objDatabase -> InicioDatabase(), $objDatabase -> ExcluirEmpresa($getId));
mysqli_close($objDatabase -> InicioDatabase());

header("location:./empresas_listar.php");
