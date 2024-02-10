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
                        <a class="dropdown-item disabled" href="#"><i class="bi bi-shop">&nbsp;&nbsp;</i>Listar Fornecedores</a>
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
    </nav>
    <div class="container">
        <div class="box">
            <!--Cadastro de Produtos-->
            <form action="./produtos_add.php" method="POST">
                <div class="form-group">
                    <label>Nome ou Descrição do Produto:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="bi bi-pencil-square text-primary"></i></span>
                        </div>
                        <input class="form-control" type="text" name="PRODUTO" placeholder="Bolo de Laranja" required>
                    </div>
                    <label>Quantidade do Produto:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="bi bi-123 text-primary"></i></span>
                        </div>
                        <input class="form-control" type="text" name="QUANTIDADE" placeholder="3" required>
                    </div>
                    <!-- Linha de Teste -->
                    <label>Data de Fabricação:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="bi bi-calendar-event text-primary"></i></span>
                        </div>
                        <input class="form-control" type="text" id="dateFab" name="FABRICACAO" placeholder="<?php echo date('d/m/Y') ?>" required>
                    </div>
                    <!-- Fim teste -->
                    <label>Data de Validade:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="bi bi-exclamation-triangle-fill text-danger"></i></span>
                        </div>
                        <input class="form-control" type="text" id="dateVal" name="VALIDADE" placeholder="<?php echo date('d/m/Y') ?>" required>
                    </div>
                    <label>Valor:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="bi bi-cash-coin text-success"></i></span>
                        </div>
                        <input type="text" class="form-control" name="VALOR" placeholder="0.00" required>
                    </div>
                </div>
                <button type="send" class="btn btn-dark" id="finalizar-cadastro"><i class="bi bi-check text-success">&nbsp;</i>Finalizar Cadastro</button>
            </form>
            <!--Fim de produtos-->
        </div>
    </div>

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
        $('#dateFab').datepicker({
            format: 'dd/mm/yyyy',
            startDate: '0d',
            endDate: '+7d',
            language: 'pt-BR',
            orientation: "bottom auto"
        });

        $('#dateVal').datepicker({
            format: 'dd/mm/yyyy',
            startDate: '0d',
            language: 'pt-BR',
            orientation: "bottom auto"
        })
    </script>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</html>