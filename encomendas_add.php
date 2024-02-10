<!DOCTYPE HTML>

<head lang="pt-BR">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="./css/index.css" media="screen" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/bootstrap-datepicker.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="./js/bootstrap-datepicker.min.js"></script>
    <script src="./js/bootstrap-datepicker.pt-BR.min.js"></script>
    <link rel="shortcut icon" href="./images/favicon.ico">
    <title>Icebelle System</title>
</head>

<body>
    <?php
    session_start();
    include_once("./check.php");
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <a class="navbar-brand" href="./home.php"><i class="bi bi-box2-heart" style="font-size: 1.5rem; color: red;">&nbsp;&nbsp;</i>Icebelle System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Alterna navegação">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggleExternalContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Página Inicial</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./clientes_listar.php"><i class="bi bi-people">&nbsp;&nbsp;</i>Listar Clientes</a>
                        <a class="dropdown-item" href="./encomendas_listar.php"><i class="bi bi-card-heading">&nbsp;&nbsp;</i>Listar Encomendas</a>
                        <a class="dropdown-item" href="./empresas_listar.php"><i class="bi bi-building">&nbsp;&nbsp;</i>Listar Empresas</a>
                        <a class="dropdown-item" href="#"><i class="bi bi-shop">&nbsp;&nbsp;</i>Listar Fornecedores</a>
                        <a class="dropdown-item" href="./produtos_listar.php"><i class="bi bi-list-stars">&nbsp;&nbsp;</i>Listar Produtos</a>
                <li class="nav-item">
                </li>
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cadastros</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./clientes.php"><i class="bi bi-person-plus"></i>&nbsp;&nbsp;Clientes</a>
                        <a class="dropdown-item" href="./encomendas.php"><i class="bi bi-card-checklist">&nbsp;&nbsp;</i>Encomendas</a>
                        <a class="dropdown-item" href="./empresas.php"><i class="bi bi-building">&nbsp;&nbsp;</i>Empresas</a>
                        <a class="dropdown-item" href="#"><i class="bi bi-cart-check">&nbsp;&nbsp;</i>Fornecedores</a>
                        <a class="dropdown-item" href="./produtos.php"><i class="bi bi-box2-heart">&nbsp;&nbsp;</i>Produtos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Faturamento</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./historico_pendencias.php"><i class="bi bi-clock-history">&nbsp;&nbsp;</i>Histórico de Pagamentos</a>
                        <a class="dropdown-item " data-toggle="modal" data-target="#qrcodeModal" href="#"><i class="bi bi-qr-code-scan">&nbsp;&nbsp;</i>QRCode</a>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">Logout</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Pesquisar</button>
            </form>
        </div>
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4">
            </div>
        </div>
    </nav>
    <?php
    $getCliente = $_POST["CLIENTE"];
    $getProduto = $_POST["PRODUTO"];
    $getQuantidade = $_POST["QUANTIDADE"];
    $getDataEntrega = $_POST["ENTREGA"];

    $setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
    $mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));
    $selectQuantiaMenor = "SELECT QUANTIDADE FROM PRODUTOS WHERE PRODUTO = '{$getProduto}'";
    $getQuantiaMenor = mysqli_query($mysqliStart, $selectQuantiaMenor);
    $exQuantiaMenor = mysqli_fetch_row($getQuantiaMenor);

    $insertEncomenda =  "INSERT INTO ENCOMENDAS(ID_PRODUTO, QUANTIDADE, DATA_CADASTRO, DATA_ENTREGA, ID_CLIENTE, ID_EMPRESA, TOTAL, STATUS) VALUES((SELECT ID FROM PRODUTOS WHERE PRODUTO = '{$getProduto}'), $getQuantidade, NOW(), STR_TO_DATE('$getDataEntrega', '%d/%m/%Y'), (SELECT ID FROM CLIENTES WHERE NOME = '$getCliente'), (SELECT ID_EMPRESA FROM CLIENTES WHERE CLIENTES.NOME = '{$getCliente}'), (SELECT PRECO * $getQuantidade FROM PRODUTOS WHERE PRODUTO = '$getProduto'), null)";
    $updateProduto = "UPDATE PRODUTOS SET QUANTIDADE = QUANTIDADE - $getQuantidade WHERE PRODUTO = '$getProduto'";

    if ($getQuantidade == 0 || $getQuantidade < 0) {
        echo
        "
        <div class='alert alert-danger' role='alert' style='text-align:center;'>
        Impossível encomendar {$getQuantidade} unidade(s) do Produto <span style='font-weight:bold;'>{$getProduto}</span>, <a href='./encomendas.php' class='link'>tente novamente</a>.
        </div>
        ";
        mysqli_close($mysqliStart);
    } elseif ($getQuantidade > $exQuantiaMenor[0]) {
        echo
        "
        <div class='alert alert-danger' role='alert' style='text-align:center;'>
        Produto <span style='font-weight:bold;'>$getProduto</span> está disponível apenas em $exQuantiaMenor[0] unidade(s), <a href='./encomendas.php' class='link'>voltar</a>.
        </div>
        ";
        mysqli_close($mysqliStart);
    } else {
        try {
            //REGRA PARA CLIENTE RESTAURANTE
            if (strpos($getCliente, "Cliente") !== false && strpos($getProduto, "Bolo") !== false) {
                echo
                "
                <div class='alert alert-success' role='alert' style='text-align:center;'>
                <span style='font-weight:bold;'><i class='bi bi-info-circle'></i>&nbsp;$getQuantidade $getProduto</span> reservado ao cliente <span style='font-weight:bold;'>$getCliente</span>.</br>
                <a href='#' data-toggle='modal' data-target='#recebimentoInformer' class='link'>Clique aqui</a> para informar a data de recebimento desta encomenda ou <a href='./encomendas.php' class='link'>voltar</a>.
                </div>
                ";
                mysqli_query($mysqliStart, $updateProduto);
                mysqli_close($mysqliStart);
            } else {
                echo
                "
                <div class='alert alert-success' role='alert' style='text-align:center;'>
                <span style='font-weight:bold;'><i class='bi bi-info-circle'></i>&nbsp;$getQuantidade $getProduto</span> reservado ao cliente <span style='font-weight:bold;'>$getCliente</span>.</br>
                <a href='#' data-toggle='modal' data-target='#recebimentoInformer' class='link'>Clique aqui</a> para informar a data de recebimento desta encomenda ou <a href='./encomendas.php' class='link'>voltar</a>.
                </div>
                ";
                mysqli_query($mysqliStart, $insertEncomenda);
                mysqli_query($mysqliStart, $updateProduto);
                mysqli_close($mysqliStart);
            }
        } catch (Exception $exception) {
            "
            <div class='alert alert-danger' role='alert' style='text-align:center;'>
            <span style='font-weight:bold;'><i class='bi bi-exclamation-circle'></i>&nbsp;Fatal Error Exception</span></br>$exception</br><a href='./encomendas.php' class='link'>Voltar</a>
            </div>
            ";
            mysqli_close($mysqliStart);
        }
    }
    ?>

    <!-- Modal de Teste -->
    <div class="modal fade" id="recebimentoInformer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="bi bi-info-circle-fill">&nbsp;</i>
                        <?php
                        $setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
                        $mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));
                        $getInfos = "SELECT MAX(ENCOMENDAS.ID), CLIENTES.NOME AS CLIENTE FROM ENCOMENDAS JOIN CLIENTES WHERE CLIENTES.NOME = '{$getCliente}'";
                        $mysqlExec = mysqli_query($mysqliStart, $getInfos);
                        $setInfo = mysqli_fetch_row($mysqlExec);
                        echo "Pedido #{$setInfo[0]} / {$setInfo[1]}";
                        ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="text-align:center;">
                        <?php
                        $setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
                        $mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));
                        $getInfos = "SELECT ID, ID_CLIENTE, QUANTIDADE, TOTAL FROM ENCOMENDAS ORDER BY ID DESC LIMIT 1";
                        $mysqlExec = mysqli_query($mysqliStart, $getInfos);
                        $setInfo = mysqli_fetch_row($mysqlExec);

                        echo "";

                        $_SESSION["getPedido"] = $setInfo[0];

                        echo "
                            <span style='text-align:center;'>
                            Número do Pedido: {$setInfo[0]}
                            <br>
                            Nome do Cliente: {$getCliente}
                            <br>
                            Produto Solicitado: {$getProduto}
                            <br>
                            Quantidade Solicitada: {$getQuantidade}
                            <br>
                            <br>
                            <h1>Total: R$$setInfo[3]</h1>
                            ";
                        ?>
                    </form>
                    <br>
                    <form action="./pagamento_reg.php" method='post' style="text-align:center;">
                        <label class="col-form-label" style="text-align:center;">Previsão de Recebimento:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                            </div>
                            <input type="text" class="form-control" id="defDate" name="datePag" placeholder="<?php echo date('d/m/Y') ?>" required>
                            <button type="submit" class="btn btn-sm btn-success">Confirmar</button>
                    </form>
                </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    <!-- Fim do Modal -->

    <!--Modal QRCode-->
    <div class="modal fade bd-example-modal-sm" id="qrcodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrcodeModal" style="font-weight:bold;"><i class="bi bi-qr-code-scan">&nbsp;&nbsp;</i>QRCode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <img src="./images/qrcode.jpeg"></img>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:100%;"><i class="bi bi-x">&nbsp;</i>Fechar</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!--Fim Modal QRCode-->
    </div>
    </div>
    <script type="text/javascript">
        $('#defDate').datepicker({
            format: 'dd/mm/yyyy',
            startDate: '0d',
            endDate: '+30d',
            language: 'pt-BR',
            orientation: "bottom auto"
        });
    </script>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</html>