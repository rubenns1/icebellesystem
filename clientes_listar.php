<!DOCTYPE HTML>

<head lang="pt-BR">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="./css/index.css" media="screen" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
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
        <th scope="col">Id</th>
        <th scope="col">Nome</th>
        <th scope="col">Empresa</th>
        <th scope="col">Contato (WhatsApp)</th>
        <th scope="col">Cadastro</th>
        <th scope='col'>Extras</th>
      </tr>
    </thead>
    <?php

    include "./classes/funcoes.php";

    $objDatabase = new Funcoes();

    $objDatabase->setServer("localhost");
    $objDatabase->setUsuario("root");
    $objDatabase->setSenha(null);
    $objDatabase->setDatabase("icebelle_homolog");
    $objDatabase->setTabela("clientes");

    $run = mysqli_query($objDatabase->InicioDatabase(), $objDatabase->ListarClientes());

    foreach ($run as $runs) {
      if ($runs["id"] > 0 && strlen($runs["whatsapp"] > 0)) {
        echo
        "
            <tbody class='table-info table-sm text-dark' style='text-align:center;'>
            <th scope='{$runs["id"]}'>#{$runs["id"]}</th>
            <td scope=''>{$runs["nome"]}</td>
            <td scope=''>{$runs["empresa"]}</a></td>
            <td scope=''><i class='bi bi-whatsapp text-success'>&nbsp;&nbsp;</i><a href='https://wa.me/{$runs["whatsapp"]}' target='_blank'>Mensagem</a></td>
            <td scope=''>{$runs["data_cadastro"]}</td>
            <td scope=''>
            <div class='dropdown'>
                <button class='btn btn-danger btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='bi bi-three-dots-vertical'>&nbsp;&nbsp;</i>Ações
                </button>

                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                <button type='button' class='dropdown-item' data-toggle='modal' data-target='#editarCliente' data-id='{$runs["id"]}' data-nome='{$runs["nome"]}'><i class='bi bi-pencil-square text-primary'>&nbsp;&nbsp;</i>Editar</a>

                <form action='./clientes_delete.php' method='post'>
                <button class='btn-primary dropdown-item' type='submit' name='{$runs["id"]}'>
                <i class='bi bi-trash-fill text-danger'>&nbsp;&nbsp;</i>Excluir</a>
                </button>
                </form>
                </div>
                </div>
            </td>
      ";
      } elseif ($runs["whatsapp"] < 0 || $runs["whatsapp"] == null) {
        echo
        "
            <tbody class='table-info table-sm' style='text-align:center;'>
            <th scope='{$runs["id"]}'>#{$runs["id"]}</th>
            <td scope=''>{$runs["nome"]}</td>
            <td scope=''>{$runs["empresa"]}</a></td>
            <td scope=''><i class='text-danger'>Não Registrado</i></td>
            <td scope=''>{$runs["data_cadastro"]}</td>
            <td scope=''>
            <div class='dropdown'>
                <button class='btn btn-danger btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <i class='bi bi-three-dots-vertical'>&nbsp;&nbsp;</i>Ações
                </button>
                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                <button class='dropdown-item' data-toggle='modal' data-target='#editarCliente' data-id='{$runs["id"]}' data-nome='{$runs["nome"]}'><i class='bi bi-pencil-square text-primary'>&nbsp;&nbsp;</i>Editar</a>
                <form action='./clientes_delete.php' method='post'>
                <button class='btn-primary dropdown-item' type='submit' name='{$runs["id"]}'>
                <i class='bi bi-trash-fill text-danger'>&nbsp;&nbsp;</i>Excluir</a>
                </button>
                </form>
                </div>
                </div>
            </td>
        ";
      }

      echo
      "
      <div class='modal fade' id='editarCliente' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' data-id='{$runs["id"]}' aria-hidden='true'>
        <div class='modal-dialog' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title text-primary' id='exampleModalLabel' style=width:100%;text-align:center;'>getDados</h5>
              <button type='button' class='close text-danger' data-dismiss='modal' aria-label='Fechar'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>
              <form action='./clientes_editar.php' method='post'>
                <div class='form-group'>
                  <label for='recipient-name' class='col-form-label'>Nome:</label>
                <div class='input-group mb-3'>
                        <div class='input-group-prepend'>
                            <span class='input-group-text'><i class='bi bi-person-circle text-primary'></i></span>
                        </div>
                        <input class='form-control' type='text' name='nome' placeholder='Fulano Silva' required>
                      </div>
                    </div>
                    <label for='recipient-name' class='col-form-label'>Telefone / Contato:</label>
                    <div class='input-group mb-3'>
                        <div class='input-group-prepend'>
                        <span class='input-group-text'><i class='bi bi-telephone-plus-fill text-primary'></i></span>
                        </div>
                        <input class='form-control' type='text' name='contato' placeholder='5511912345678'>
                    </div>
            </div>
            <div class='modal-footer'>
              <button type='button' class='btn btn-danger' data-dismiss='modal' style='width:50%'>Fechar</button>
              <input type='hidden' name='id' readonly='1'>
              <button type='submit' class='btn btn-success' style='width:50%'>Salvar</button>
            </form>
            </div>
          </div>
        </div>
      </div>

      <script type='text/javascript'>
      $('#editarCliente').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Botão que acionou o modal
        var recipientId = button.data('id') // Extrai informação dos atributos data-*
        var recipientNome = button.data('nome')
        // Se necessário, você pode iniciar uma requisição AJAX aqui e, então, fazer a atualização em um callback.
        // Atualiza o conteúdo do modal. Nós vamos usar jQuery, aqui. No entanto, você poderia usar uma biblioteca de data binding ou outros métodos.
        var modal = $(this)
        modal.find('.modal-title').text('#' + recipientId + ' - ' + recipientNome)
        modal.find('.modal-footer input').val(recipientId)
      })
      </script>
      ";
    }

    mysqli_close($objDatabase->InicioDatabase());
    ?>
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
</body>

</html>