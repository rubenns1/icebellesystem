<!DOCTYPE HTML>

<head lang="pt-BR">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="./css/index.css" media="screen" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="./images/favicon.ico">
    <title>Icebelle System</title>
</head>

<body>
<?php
session_start();
if(empty($_POST["LOGIN"]) && empty($_POST["PASSWORD"]))
{
    header("location:./index.php");
    exit();
}
else
{
    $setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
    $mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));
    $getUsuario = mysqli_real_escape_string($mysqliStart, MD5($_POST["LOGIN"]));
    $getSenha = mysqli_real_escape_string($mysqliStart, MD5($_POST["PASSWORD"]));

    $selectQuery = "SELECT LOGIN, PASSWORD FROM ACCESS WHERE BINARY LOGIN = '{$getUsuario}' AND BINARY PASSWORD = '{$getSenha}'";
    $queryExecute = mysqli_query($mysqliStart, $selectQuery);
    $rowDetails = mysqli_num_rows($queryExecute);

    if($rowDetails == 1)
    {
        $_SESSION["LOGIN"] = $getUsuario;
        header("location:./home.php");
        exit();
    }
    else
    {
        echo
        "
        <div class='alert alert-danger text-center' role='alert'>
        <i class='bi bi-exclamation-triangle-fill'>&nbsp;&nbsp;</i>Falha ao logar-se no sistema.<br/>Por gentileza <a href='./login.php'>volte</a> para verificar usuário e senha informados.
        </div>
        ";
    }
}
?>