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

    include "./classes/access.php";
    include "./classes/funcoes.php";

    $objAccess = new Access();

    $objDatabase = new Funcoes();
    $objDatabase->setServer("localhost");
    $objDatabase->setUsuario("root");
    $objDatabase->setSenha(null);
    $objDatabase->setDatabase("icebelle_homolog");
    $objDatabase->setTabela("access");

    session_start();
    if (empty($_POST["LOGIN"]) && empty($_POST["PASSWORD"])) {
        header("location:./index.php");
        exit();
    } else {
        $getUsuario = mysqli_real_escape_string($objDatabase->InicioDatabase(), MD5($_POST["LOGIN"]));
        $getSenha = mysqli_real_escape_string($objDatabase->InicioDatabase(), MD5($_POST["PASSWORD"]));

        $objAccess->setLogin($getUsuario);
        $objAccess->setPassword($getSenha);

        $run = mysqli_query($objDatabase->InicioDatabase(), $objDatabase->Logar($objAccess->getLogin(), $objAccess->getPassword()));
        $getDados = mysqli_num_rows($run);

        if ($getDados == 1) {
            $_SESSION["LOGIN"] = $objAccess->getLogin();
            header("location:./home.php");
            exit();
        } else {
            echo
            "
        <div class='alert alert-danger text-center' role='alert'>
        <i class='bi bi-exclamation-triangle-fill'>&nbsp;&nbsp;</i>Falha ao logar-se no sistema.<br/>Por gentileza <a href='./login.php'>volte</a> para verificar usuário e senha informados.
        </div>
        ";
        }
    }

    ?>