<?php

include "./interfaces/home.php";
include "./classes/funcoes.php";

class Index extends Funcoes implements Home

{
    public function Home()
    {
        $objDatabase = new Funcoes();
        $objDatabase->setServer("localhost");
        $objDatabase->setUsuario("root");
        $objDatabase->setSenha(null);
        $objDatabase->setDatabase("icebelle_homolog");
        $objDatabase->setTabela("produtos");

        $query = "SELECT produto, quantidade, lote, preco, DATE_FORMAT(data_fabricacao, '%d/%m/%Y') AS fabricacao, DATE_FORMAT(data_validade, '%d/%m/%Y') AS validade FROM {$objDatabase->getTabela()}";

        $run = mysqli_query($objDatabase->InicioDatabase(), $query);

        while ($getDados = mysqli_fetch_assoc($run)) {
            
            $timeZone = new DateTimeZone('UTC');
                $a = date("d/m/Y");
                $b = $getDados["validade"];

                $dataAtual = DateTime::createFromFormat('d/m/Y', $a, $timeZone);
                $dataValidade = DateTime::createFromFormat('d/m/Y', $b, $timeZone);
                $dataAtual = $dataAtual->format("Ymd");
                $dataValidade = $dataValidade->format("Ymd");

            if ($getDados["quantidade"] > 0) {
                if($dataValidade <= $dataAtual)
                {
                    echo 
                    "
                    <div class='card text-dark bg-warning mb-3' style='text-align:center;displpay:inline-block; max-width:30%; margin:1em; box-shadow: 1px 1px 20px #808080'>
                    <div class='card-header'><i class='bi bi-exclamation-circle-fill text-danger'></i></div>
                    <div class='card-body'>
                    <h5 class='card-title'><b>{$getDados["produto"]}</b>
                    </h5>
                    <class='card-text'>Valor Unitário: <b>R$ {$getDados["preco"]}</b></br>
                    <class='card-text'>Lote: {$getDados["lote"]}</br>
                    <class='card-text'>Fabricação: <b>{$getDados["fabricacao"]}</b></br>
                    <class='card-text'>Validade: <b class='text-danger'>{$getDados["validade"]}</b>
                    </div>
                    </div>
                    ";
                }
                else
                {
                    echo 
                    "
                    <div class='card text-white bg-success mb-3' style='text-align:center;displpay:inline-block; max-width:30%; margin:1em; box-shadow: 1px 1px 20px #808080'>
                    <div class='card-header'><i class='bi bi-emoji-smile text-white'></i></div>
                    <div class='card-body'>
                    <h5 class='card-title'><b>{$getDados["produto"]}</b>
                    </h5>
                    <class='card-text'>Valor Unitário: <b>R$ {$getDados["preco"]}</b></br>
                    <class='card-text'>Lote: {$getDados["lote"]}</br>
                    <class='card-text'>Fabricação: <b>{$getDados["fabricacao"]}</b></br>
                    <class='card-text'>Validade: <b class='text-danger'>{$getDados["validade"]}</b>
                    </div>
                    </div>
                    ";
                }
            }
        }
    }
}
