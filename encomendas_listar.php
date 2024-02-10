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
  include_once("./check.php");
  ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <a class="navbar-brand" href="./home.php"><i class="bi bi-box2-heart" style="font-size: 1.5rem; color: red;">&nbsp;&nbsp;</i>Icebelle System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Alterna navegação">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarToggleExternalContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Página Inicial</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="./clientes_listar.php"><i class="bi bi-people">&nbsp;&nbsp;</i>Listar Clientes</a>
            <a class="dropdown-item" href="./encomendas_listar.php"><i class="bi bi-card-heading">&nbsp;&nbsp;</i>Listar Encomendas</a>
            <a class="dropdown-item" href="./empresas_listar.php"><i class="bi bi-building">&nbsp;&nbsp;</i>Listar Empresas</a>
            <a class="dropdown-item" href="#"><i class="bi bi-shop">&nbsp;&nbsp;</i>Listar Fornecedores</a>
            <a class="dropdown-item" href="./produtos_listar.php"><i class="bi bi-list-stars">&nbsp;&nbsp;</i>Listar Produtos</a>
        <li class="nav-item">
        </li>
        <li class="nav-item dropdown">
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
  <!-- Inicio da Tabela de Encomendas -->
  <table class="table table-hover table-sm" style="text-align:center;">
    <thead>
      <tr>
        <th scope="col">Pedido</th>
        <th scope="col">Cliente</th>
        <th scope="col">Empresa</th>
        <th scope="col">Produto</th>
        <th scope="col">Quantidade</th>
        <th scope="col">Total(R$)</th>
        <th scope="col">Cadastro</th>
        <th scope="col">Entrega</th>
        <th scope="col">Status</th>
        <th scope="col">Faturamento(Id)</th>
        <th scope="col">Extras</th>
      </tr>
    </thead>
    <?php
    $setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
    $mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));

    $queryExecute = "SELECT ENCOMENDAS.ID, CLIENTES.NOME AS CLIENTE, ID_HISTPAG AS HISTPAG, EMPRESAS.NOME AS EMPRESA, ENCOMENDAS.QUANTIDADE AS QUANTIDADE, DATE_FORMAT(ENCOMENDAS.DATA_ENTREGA, '%d/%m/%Y') AS ENTREGA, DATE_FORMAT(ENCOMENDAS.DATA_CADASTRO, '%d/%m/%Y') AS CADASTRO, ENCOMENDAS.TOTAL AS TOTAL, ENCOMENDAS.STATUS AS STATUS, PRODUTOS.PRODUTO AS PRODUTO FROM ENCOMENDAS INNER JOIN CLIENTES JOIN EMPRESAS JOIN PRODUTOS ON ENCOMENDAS.ID_PRODUTO = PRODUTOS.ID AND ENCOMENDAS.ID_CLIENTE = CLIENTES.ID AND ENCOMENDAS.ID_EMPRESA = EMPRESAS.ID ORDER BY STATUS ASC, ENTREGA ASC, CLIENTE ASC";
    $executeQuery = mysqli_query($mysqliStart, $queryExecute);

    while ($getValue = mysqli_fetch_assoc($executeQuery)) {
      if (($getValue["STATUS"] == "Entregue")) {
        echo
        "
                <tbody class='table-success table-sm' style='text-align:center;'>
                <th scope='{$getValue["ID"]}'>#{$getValue["ID"]}</th>
                <td>{$getValue["CLIENTE"]}</td>
                <td>{$getValue["EMPRESA"]}</td>
                <td>{$getValue["PRODUTO"]}</td>
                <th>{$getValue["QUANTIDADE"]}</span></th>
                <th>{$getValue["TOTAL"]}</th>
                <td>{$getValue["CADASTRO"]}</td>
                <td>{$getValue["ENTREGA"]}</td>
                <td><i class='bi bi-check-circle' style='color:green;'></i></td>
                ";
        if ($getValue["HISTPAG"] == null) {
          echo
          "
                    <td><i class='text-danger'>Sem Informações</i></td>
                    <td>
                    <div class='dropdown'>
                    <button class='btn btn-danger btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <i class='bi bi-three-dots-vertical'>&nbsp;&nbsp;</i>Ações
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                    <a class='dropdown-item disabled' href='#' ><i class='bi bi-check-circle'>&nbsp;&nbsp;</i>Confirmar Entrega</a>
                    <a class='dropdown-item disabled' href='#' ><i class='bi bi-trash3'>&nbsp;&nbsp;</i>Excluir</a>
                    </div>
                    </div>
                    </td>
                    </tr>
                    </tbody>
                    ";
        } else {
          echo
          "
                <th>#{$getValue["HISTPAG"]}</th>
                <td>
                <div class='dropdown'>
                <button class='btn btn-danger btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='bi bi-three-dots-vertical'>&nbsp;&nbsp;</i>Ações
                </button>
                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                <a class='dropdown-item disabled' href='#' ><i class='bi bi-check-circle'>&nbsp;&nbsp;</i>Confirmar Entrega</a>
                <a class='dropdown-item disabled' href='#' ><i class='bi bi-trash3'>&nbsp;&nbsp;</i>Excluir</a>
                </div>
                </div>
                </td>
                </tr>
                </tbody>
                ";
        }
      } elseif ($getValue["STATUS"] == null) {
        echo
        "
                <tbody class='table-info table-sm' style='text-align:center;'>
                <th scope='{$getValue["ID"]}'>#{$getValue["ID"]}</th>
                <td>{$getValue["CLIENTE"]}</td>
                <td>{$getValue["EMPRESA"]}</td>
                <td>{$getValue["PRODUTO"]}</td>
                <td><span style='font-weight:bold;'>{$getValue["QUANTIDADE"]}</span></td>
                <th>{$getValue["TOTAL"]}</td>
                <td>{$getValue["CADASTRO"]}</td>
                <td>{$getValue["ENTREGA"]}</td>
                <td><i class='bi bi-x-circle' style='color:red;font-weight:bold;'></i></td>
                ";
        if ($getValue["HISTPAG"] == null) {
          echo
          "
                  <td><i class='text-danger'>Sem Informação</i></td>
                  <td>
                  <div class='dropdown'>
                  <button class='btn btn-danger btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                  <i class='bi bi-three-dots-vertical'>&nbsp;&nbsp;</i>Ações
                  </button>
                  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                  <form action='./encomendas_confirm.php' method='post'>
                  <input name='{$getValue["ID"]}' type='hidden'/>
                  <button class='btn-primary dropdown-item' type='submit'><i class='bi bi-check-circle'>&nbsp;&nbsp;</i>Confirmar Entrega</a>
                  </button>
                  </form>
                  <button class='btn-primary dropdown-item' type='submit'><i class='bi bi-coin'>&nbsp;&nbsp;</i>Confirmar Pagamento</a></button>
                  <a class='dropdown-item' href='#' name='Modificar{$getValue["ID"]}'><i class='bi bi-pencil-square'>&nbsp;&nbsp;</i>Modificar</a>
                  <form action='./encomendas_delete.php' method='post'>
                  <input name='{$getValue["ID"]}' type='hidden'/>
                  <button class='btn-primary dropdown-item' type='submit'><i class='bi bi-trash3'>&nbsp;&nbsp;</i>Excluir</a>
                  </form>
                  </div>
                  </div>
                  </td>
                  </tr>
                  </tbody>
                  ";
        } else {
          echo
          "
                  <th>#{$getValue["HISTPAG"]}</th>
                  <td>
                  <div class='dropdown'>
                  <button class='btn btn-danger btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                  <i class='bi bi-three-dots-vertical'>&nbsp;&nbsp;</i>Ações
                  </button>
                  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                  <form action='./encomendas_confirm.php' method='post'>
                  <input name='{$getValue["ID"]}' type='hidden'/>
                  <button class='btn-primary dropdown-item' type='submit'><i class='bi bi-check-circle'>&nbsp;&nbsp;</i>Confirmar Entrega</a></button>
                  </form>
                  <button class='btn-primary dropdown-item' type='submit'><i class='bi bi-coin'>&nbsp;&nbsp;</i>Confirmar Pagamento</a></button>
                  <a class='dropdown-item' href='#' name='Modificar{$getValue["ID"]}'><i class='bi bi-pencil-square'>&nbsp;&nbsp;</i>Modificar</a>
                  <form action='./encomendas_delete.php' method='post'>
                  <input name='{$getValue["ID"]}' type='hidden'/>
                  <button class='btn-primary dropdown-item' type='submit'><i class='bi bi-trash3'>&nbsp;&nbsp;</i>Excluir</a>
                  </form>
                  </div>
                  </div>
                  </td>
                  </tr>
                  </tbody>
                  ";
        }
      }
    }
    ?>
  </table>
  <!-- Fim da Tabela de Encomendas -->

  <!-- Modal QRCode -->
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
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" style="width:100%;"><i class="bi bi-x">&nbsp;</i>Fechar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Fim modal QRCode -->
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>