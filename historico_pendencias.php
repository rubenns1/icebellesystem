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
    <a class="navbar-brand" href="./home.php"><i class="bi bi-box2-heart" style='font-size: 1.5rem; color: red;'>&nbsp;&nbsp;</i>Icebelle System</a>
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
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cadastros</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="./clientes.php"><i class="bi bi-person-plus"></i>&nbsp;&nbsp;Clientes</a>
            <a class="dropdown-item" href="./encomendas.php"><i class="bi bi-card-checklist">&nbsp;&nbsp;</i>Encomendas</a>
            <a class="dropdown-item" href="./empresas.php"><i class="bi bi-building">&nbsp;&nbsp;</i>Empresas</a>
            <a class="dropdown-item" href="#"><i class="bi bi-cart-check">&nbsp;&nbsp;</i>Fornecedores</a>
            <a class="dropdown-item" href="./produtos.php"><i class="bi bi-box2-heart">&nbsp;&nbsp;</i>Produtos</a>
        </li>
        <li class="nav-item dropdown active">
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
  <table class='table table-hover table-sm' style='text-align:center;'>
    <thead>
      <tr>
        <th scope='col'>Id</th>
        <th scope='col'>Cliente</th>
        <th scope='col'>Empresa</th>
        <th scope='col'>Encomenda(Id)</th>
        <th scope='col'>Produto</th>
        <th scope='col'>Valor(R$)</th>
        <th scope='col'>Estimado Recebimento</th>
        <th scope='col'>Recebido(R$)</th>
        <th scope='col'>Status</th>
        <th scope='col'>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php

      $setBaseConfigs = array("localhost", "root", null, "ICEBELLE_HOMOLOG");
      $mysqliStart = mysqli_connect($setBaseConfigs[0], $setBaseConfigs[1], $setBaseConfigs[2], $setBaseConfigs[3]) or die(print("Fatal error!"));
      //$queryExecute = "SELECT HISTPAG.ID, CLIENTES.NOME AS CLIENTE, EMPRESAS.UNIDADE AS UNIDADE, ID_ENCOMENDA AS ENCOMENDA, VALOR, DATE_FORMAT(DATA_RECEBER, '%d/%m/%Y') AS RECEBIMENTO, VALOR_RECEBIDO AS RECEBIDO, STATUS FROM HISTPAG JOIN CLIENTES JOIN EMPRESAS ON HISTPAG.ID_CLIENTE = CLIENTES.ID AND HISTPAG.ID_EMPRESA = EMPRESAS.ID ORDER BY VALOR ASC";//
      $queryExecute = "SELECT HISTPAG.ID, CLIENTES.NOME AS CLIENTE, EMPRESAS.NOME AS UNIDADE, ENCOMENDAS.ID AS ENCOMENDA_ID, PRODUTOS.PRODUTO AS PRODUTO, VALOR, DATE_FORMAT(DATA_RECEBIMENTO, '%d/%m/%Y') AS RECEBIMENTO, VALOR_RECEBIDO AS RECEBIDO, HISTPAG.COMPROVANTE AS DOC_FILE FROM HISTPAG JOIN CLIENTES JOIN EMPRESAS JOIN ENCOMENDAS JOIN PRODUTOS ON ENCOMENDAS.ID_PRODUTO = PRODUTOS.ID AND HISTPAG.ID_CLIENTE = CLIENTES.ID AND HISTPAG.ID_EMPRESA = EMPRESAS.ID AND ENCOMENDAS.ID = HISTPAG.ID_ENCOMENDA ORDER BY RECEBIMENTO ASC, RECEBIDO != 0 ASC";
      $executeQuery = mysqli_query($mysqliStart, $queryExecute);

      while ($getValue = mysqli_fetch_assoc($executeQuery)) {
        if ($getValue["VALOR"] < 0) {
          echo
          "
          <tr class='table-danger'>
          <td><span style='font-weight:bold'>#{$getValue["ID"]}</span></td>
          <td>{$getValue["CLIENTE"]}</td>
          <td>{$getValue["UNIDADE"]}</td>
          <td><span style='font-weight:bold;'>#{$getValue["ENCOMENDA_ID"]}</span></td>
          <td>{$getValue["PRODUTO"]}</td>
          <td><span style='font-weight:bold;'>{$getValue["VALOR"]}</span></td>
          <td>{$getValue["RECEBIMENTO"]}</td>
          <td><span style='font-weight:bold;'>{$getValue["RECEBIDO"]}</span></td>
          <td><i class='bi bi-exclamation-circle-fill text-danger'></i></td>
          <td>
          <div class='dropdown'>
                    <button class='btn btn-danger btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <i class='bi bi-three-dots-vertical'>&nbsp;&nbsp;</i>Ações</button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                    <form action='./clientes_alertar.php' method='post'>
                    <input name='{$getValue["ID"]}' type='hidden' />
                    <input name='{$getValue["CLIENTE"]}' type='hidden' />
                    <button class='btn-primary dropdown-item' type='submit'><i class='bi bi-exclamation-triangle text-danger'>&nbsp;&nbsp;</i>Alertar Cliente</a></button>
                    </form>
                    <button class='dropdown-item' onclick='returnValue({$getValue['ID']})' data-toggle='modal' data-target='#recebimentoInformer'><i class='bi bi-cash-coin text-info'>&nbsp;&nbsp;</i>Informar Pagamento</button>
                    </div>
                    </div>
          </form>
          </td>
        </tr>
        ";
        } elseif ($getValue["VALOR"] == 0.00 && $getValue["RECEBIDO"] > 0) {
          echo
          "
          <tr class='table-success'>
          <td><span style='font-weight:bold'>#{$getValue["ID"]}</span></td>
          <td>{$getValue["CLIENTE"]}</td>
          <td>{$getValue["UNIDADE"]}</td>
          <td><span style='font-weight:bold;'>#{$getValue["ENCOMENDA_ID"]}</span></td>
          <td>{$getValue["PRODUTO"]}</td>
          <td><span style='font-weight:bold;'>{$getValue["VALOR"]}</span></td>
          <td>{$getValue["RECEBIMENTO"]}</td>
          <td><span style='font-weight:bold;'>{$getValue["RECEBIDO"]}</span></td>
          <td><a href='../icebelle_homolog/upload_comprovantes/{$getValue['DOC_FILE']}.pdf'><i class='bi bi-check-circle-fill text-success'></i></i></a></td>
          <td>
          <div class='dropdown'>
                    <button class='btn btn-danger btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <i class='bi bi-three-dots-vertical'>&nbsp;&nbsp;</i>Ações</button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                    <input name='{$getValue["ID"]}' type='hidden' />
                    <input name='{$getValue["CLIENTE"]}' type='hidden' />
                    <button class='dropdown-item' disabled><i class='bi bi-exclamation-triangle text-danger'>&nbsp;&nbsp;</i>Alertar Cliente</a></button>
                    <button class='dropdown-item' disabled><i class='bi bi-cash-coin text-info'>&nbsp;&nbsp;</i>Informar Pagamento</button>
                    </div>
                    </div>
          </form>
          </td>
        </tr>
        ";
        } elseif ($getValue["VALOR"] > 0) {
          echo
          "
          <tr class='table-info'>
          <td><span style='font-weight:bold'>#{$getValue["ID"]}</span></td>
          <td>{$getValue["CLIENTE"]}</td>
          <td>{$getValue["UNIDADE"]}</td>
          <td><span style='font-weight:bold;'>#{$getValue["ENCOMENDA_ID"]}</span></td>
          <td>{$getValue["PRODUTO"]}</td>
          <td><span style='font-weight:bold;'>+{$getValue["VALOR"]}</span></td>
          <td>{$getValue["RECEBIMENTO"]}</td>
          <td><span style='font-weight:bold;'>{$getValue["RECEBIDO"]}</span></td>
          <td><i class='bi bi-exclamation-triangle-fill text-primary'></i></i></i></td>
          <td>
          <div class='dropdown'>
                    <button class='btn btn-danger btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <i class='bi bi-three-dots-vertical'>&nbsp;&nbsp;</i>Ações</button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                    <button class='dropdown-item disabled'><i class='bi bi-exclamation-triangle'>&nbsp;&nbsp;</i>Alertar Cliente</a></button>
                    <button class='dropdown-item'><i class='bi bi-cash-coin'>&nbsp;&nbsp;</i>Abater Crédito</button>
                    <button class='dropdown-item' data-toggle='modal' data-target='#uploadModal'><i class='bi bi-cloud-upload'>&nbsp;&nbsp;</i>Comprovante</button>
                    </div>
                    </div>
          </form>
          </td>
        </tr>
        ";
        }
      }
      mysqli_free_result($executeQuery);
      ?>
  </table>

  <!-- Inicio QRCode Modal -->
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
  <!-- Fim QRCode Modal -->

  <!-- Modal Informe de pagamento -->
  <div class='modal fade' id='recebimentoInformer' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog' role='document'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='exampleModalLabel'>
            <i class='bi bi-info-circle-fill'>&nbsp;</i>
            <span style='font-weight:bold' id='setPed'>Registrar Valor (R$)</span>
          </h5>
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <div class='modal-body'>
          <form action='./pagamento_def.php' method='post' enctype='multipart/form-data' style='text-align:center;'>
            <div class='input-group mb-3'>
              <div class='input-group-prepend'>
                <span class='input-group-text'><i class='bi bi-currency-dollar'></i></span>
              </div>
              <input type='text' class='form-control' name="valor" placeholder="0.00" required>
            </div>
            <div class='input-group mb-3'>
              <div class='input-group-prepend'>
              </div>
              <input type='file' class='form-control' accept="application/pdf" placeholder="PDF" name='comprovante' required>
              <button type='submit' id='btnPag' class='btn btn-sm btn-primary'>Confirmar</button>
          </form>
        </div>
        </form>
      </div>

    </div>
  </div>
  </div>
  <!-- Fim Modal Informe de Pagamento -->

  <!-- Inicio Upload Modal -->
  <div class='modal fade' id='uploadModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog' role='document'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='exampleModalLabel'>
            <i class="bi bi-cloud-arrow-up text-success">&nbsp;</i>
            <span style='font-weight:bold' id='setPed'>Enviar Comprovante</span>
          </h5>
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <div class='modal-body'>
          <form action="./upload.php" method="post" enctype="multipart/form-data" style='text-align:center;'>
            <div class='input-group mb-3'>
              <div class='input-group-prepend'>
              </div>
              <input type='file' class='form-control' accept="application/pdf" placeholder="PDF" name='comprovante' required>
              <button type='submit' id='btnUpload' class='btn btn-sm btn-primary'>Confirmar</button>
          </form>
        </div>
        </form>
      </div>

    </div>
  </div>
  </div>
  <!-- Fim Upload Modal -->

  </div>
</body>
<script>
  function returnValue(myId) {
    myId.value;
    document.getElementById('btnPag').name = myId;
  }
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</html>