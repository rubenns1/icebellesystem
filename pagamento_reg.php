<?php
session_start();
include_once("./check.php");
$getDatePag = $_POST["datePag"];
$getPedido = $_SESSION["getPedido"];

$setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
$mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));
$insertQuery = "INSERT INTO HISTPAG(ID_CLIENTE, ID_EMPRESA, ID_ENCOMENDA, VALOR, DATA_RECEBER, DATA_CADASTRO) VALUES((SELECT ID_CLIENTE FROM ENCOMENDAS ORDER BY ID DESC LIMIT 1), (SELECT ID_EMPRESA FROM ENCOMENDAS ORDER BY ID DESC LIMIT 1), $getPedido, -(SELECT TOTAL FROM ENCOMENDAS ORDER BY ID DESC LIMIT 1), STR_TO_DATE('{$getDatePag}', '%d/%m/%Y'), NOW())";

mysqli_query($mysqliStart, $insertQuery);
mysqli_close($mysqliStart);

header("location:./encomendas.php");
?>