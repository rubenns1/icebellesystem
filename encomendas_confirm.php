<?php
session_start();
include_once("./check.php");
$getAction = json_encode($_POST);
$returnAction = preg_replace('/[\@\.\;\" {}:"]+/', '', $getAction);

$setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
$mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));
$updateQuery = "UPDATE ENCOMENDAS SET STATUS = 'Entregue' WHERE ID = {$returnAction} AND STATUS IS NULL";
mysqli_query($mysqliStart, $updateQuery);
mysqli_close($mysqliStart);
header("location:./encomendas_listar.php");