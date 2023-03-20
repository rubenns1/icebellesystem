<?php
session_start();
include_once("./check.php");
$getAction = json_encode($_POST);
$returnAction = preg_replace('/[\@\.\;\" {}:"]+/', '', $getAction);

$setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
$mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));
$deleteQuery = "DELETE FROM CLIENTES WHERE ID = {$returnAction}";
mysqli_query($mysqliStart, $deleteQuery);
mysqli_close($mysqliStart);
header("location:./clientes_listar.php")
?>