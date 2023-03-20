<?php
session_start();
include_once("./check.php");
$setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
$mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));
$id = $_POST["CODIGO"];
$valor = $_POST["VALOR"];
$quantia = $_POST["QUANTIA"];

if (isset($_POST["EDITAR"])) {
    $setData = new DateTime();
    $getData = date_format($setData, "dMY"); //Formata data atual como ex 10Feb2022;
    //$getData = date_format($getDia, 'Y-m-d'); //Formata data atual como ex 2022-02-10;

    $editQuery = "update {$getData} set VALOR = {$valor}, QUANTIA = {$quantia} where CODIGO = {$id}";
    $executeQuery = mysqli_query($MySQLiConnectStart, $editQuery) or die(print("Oops! 404 Error."));
    header("location:./cadastro.php");
} else {
    header("location:./cadastro.php");
    mysqli_close($MySQLiConnectStart);
}

function SearchNumber()
{
    foreach ($_POST as $KEY => $valor) {
        $i = preg_replace("/[^0-9]/", "", $valor);
        return $i;
    }
}
mysqli_close($MySQLiConnectStart);
