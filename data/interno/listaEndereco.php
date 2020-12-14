<?php
    require "../conexaoMySql.php";
    $pdo = mysqlConnect();

    try
    {
        $sql = <<<SQL
        SELECT cep, logradouro, bairro, cidade, estado
        FROM base_enderecos_ajax
        SQL;

        $stmt = $pdo->query($sql);
    }
    catch(Exception $e)
    {
        exit('Erro: ' . $e->getMessage());
    }
?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>
    <title>Endereços</title>
    <meta charset="UTF-8">

    <!--Bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">

    <!--CSS de layout Geral-->
    <link rel="stylesheet" type="text/css" href="../../css/layout.css">

    <!--CSS de layout lista-->
    <link rel="stylesheet" type="text/css" href="../../css/interno/lista.css">
</head>

<body>
    <header>
        <img src="../../images/logo.png">
        <h1>Nome Clínica</h1>
    </header>

    <!--Navbar-->
    <nav>
        <div class="container-fluid">
            <ul class="row">
                <li class="col-sm-2"><a href="../../paginasInternas/cadastroFuncionario.html">Novo Funcionário</a></li>
                <li class="col-sm-2"><a href="../../paginasInternas/cadastroPaciente.html">Novo Paciente</a></li>
                <li class="col-sm-1"><a href="listaPaciente.php">Pacientes</a></li>
                <li class="col-sm-1"><a href="">Agendamentos</a></li>
                <li class="col-sm-2"><a href="">Meus Agendamentos</a></li>
            </ul>
        </div>
    </nav>

    <!--Main-->
    <main>  <div class="tabela">
                <h2>Endereços</h2>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">CEP</th>
                        <th scope="col">Logradouro</th>
                        <th scope="col">Bairro</th>
                        <th scope="col">Cidade</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $stmt->fetch())
                        {
                            $cep = htmlspecialchars($row['cep']);
                            $logradouro = htmlspecialchars($row['logradouro']);
                            $bairro = htmlspecialchars($row['bairro']);
                            $cidade = htmlspecialchars($row['cidade']);
                            $estado = htmlspecialchars($row['estado']);

                            echo <<<HTML
                            <tr>
                                <td>$cep</td>
                                <td>$logradouro</td>
                                <td>$bairro</td>
                                <td>$cidade</td>
                                <td>$estado</td>                              
                            </tr>
                            HTML;
                        }
                    ?>
                </tbody>
                </table>
                </div>
    </main>
    <footer>
        © Copyright 2001-2020 Copyright.com.br - All Rights Reserved
    </footer>
</body>

</html>