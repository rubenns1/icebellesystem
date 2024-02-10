<?php
session_start();
include_once("./check.php");
//$getFile = $_POST["comprovante"];

$getAction = json_encode($_POST);
$returnAction = preg_replace('/[\@\\;\"{Aa Bb Cc Dd Ee Ff Gg Hh Ii Jj Kk Ll Mm Nn Oo Pp Qq Rr Ss Tt Uu Vv Ww Xx Yy Zz}:"]+/', '', $getAction);
$returnIdFormat = substr(strpbrk($returnAction, ","), 1);

$returnValueFormat = substr($returnAction, 0, -1);

$cod = str_replace(",", ";", $returnAction);
$test = substr($cod, 0, strpos($cod, ";"));

$setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
$mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));

$decode = json_decode($getAction, true);
$ultimo = reset($decode);

if (isset($_FILES["comprovante"])) {
    $extFile = strtolower(substr($_FILES["comprovante"]["name"], -4));
    $newFile = md5(time()) . $extFile;
    $dirFile = "upload_comprovantes/";

    move_uploaded_file($_FILES["comprovante"]["tmp_name"], $dirFile . $newFile);
    $updateQuery = "UPDATE HISTPAG SET VALOR = VALOR + {$ultimo}, VALOR_RECEBIDO = {$ultimo}, DOC_FILE = '{$newFile}', DOC_DATA = NOW() WHERE ID = {$returnIdFormat}";
    
    try {
        mysqli_query($mysqliStart, $updateQuery);
        echo
        "
        <div class='alert alert-success' role='alert' style='text-align:center;'>
        <i class='bi bi-info-circle'></i>&nbsp;Upload de comprovante feito com sucesso, <a href='./historico_pendencias.php' class='link'>voltar</a>.
        </div>
        ";
    } catch (Exception $exception) {
        echo $exception;
        "Falha ao subir o arquivo desejado.";
    }
}

mysqli_close($mysqliStart);
header("location:./historico_pendencias.php");
