<?php
session_start();
include_once("./check.php");
$getAction = json_encode($_POST);
$returnAction = preg_replace('/[\@\.\;\"{, }:_"]+/', ' ', $getAction);
$newReturnNome = trim($returnAction, " 1234567890");
$newReturnId = trim($returnAction, " Aa Bb Cc Dd Ee Ff Gg Hh Ii Jj Kk Ll Mm Nn Oo Pp Qq Rr Ss Tt Uu Vv Ww Xx Yy Zz");

$setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
$mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));
$queryExecute = "SELECT NOME, WHATSAPP FROM CLIENTES WHERE NOME = '{$newReturnNome}'";
$executeQuery = mysqli_query($mysqliStart, $queryExecute);
$getWhatsApp = mysqli_fetch_row($executeQuery);
$listPedencias = "SELECT HISTPAG.ID, CLIENTES.NOME AS CLIENTE, EMPRESAS.NOME AS UNIDADE, VALOR, DATE_FORMAT(DATA_RECEBIMENTO, '%d/%m/%Y') AS RECEBIMENTO FROM HISTPAG JOIN CLIENTES JOIN EMPRESAS ON HISTPAG.ID_CLIENTE = CLIENTES.ID AND HISTPAG.ID_EMPRESA = EMPRESAS.ID WHERE HISTPAG.ID = {$newReturnId} AND CLIENTES.NOME = '{$newReturnNome}'";
$executeListPendencias = mysqli_query($mysqliStart, $listPedencias);

while($getPendencias = mysqli_fetch_assoc($executeListPendencias))
{
    $setMessage =  "Valor de *R$".trim($getPendencias["VALOR"], "-")."*%0AConforme combinado o pagamento seria em *{$getPendencias["RECEBIMENTO"]}*";
}

header("location:https://wa.me/{$getWhatsApp[1]}?text=Mensagem Automática%0AIcebelle System 0.2%0A%0AOlá, {$getWhatsApp[0]}!%0AVocê possui pendências em nosso sistema, sendo elas...%0A{$setMessage}");
