<?php
    require "../conexaoMySql.php";
    $pdo = mysqlConnect();

    try
    {
        $sql = <<<SQL
        SELECT nome, email, telefone, cep, logradouro, bairro, cidade, estado,
        peso, altura, tipo_sanguineo
        FROM pessoa INNER JOIN paciente ON pessoa.codigo = paciente.codigo
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
    <title>Cadastro de Paciente</title>
    <meta charset="UTF-8">

    <!--Bootstrap-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy"
        crossorigin="anonymous"></script>

    <!--CSS de layout Geral-->
    <link rel="stylesheet" type="text/css" href="../../css/layout.css">
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
                <li class="col-sm-2"><a href="">Novo Funcionário</a></li>
                <li class="col-sm-2"><a href="">Novo Paciente</a></li>
                <li class="col-sm-2"><a href="">Funcionários</a></li>
                <li class="col-sm-1"><a href="">Pacientes</a></li>
                <li class="col-sm-1"><a href="">Endereços</a></li>
                <li class="col-sm-1"><a href="">Agendamentos</a></li>
                <li class="col-sm-2"><a href="">Meus Agendamentos</a></li>
            </ul>
        </div>
    </nav>

    <!--Main-->
    <main>
        <h2>Pacientes</h2>
            <div class="container">
                <table class="table table-striped table-hover">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>CEP</th>
                        <th>Logradouro</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>Peso</th>
                        <th>Altura</th>
                        <th>Tipo Sanguíneo</th>
                    </tr>

                    <?php
                        while($row = $stmt->fetch())
                        {
                            $nome = htmlspecialchars($row['nome']);
                            $email = htmlspecialchars($row['email']);
                            $telefone = htmlspecialchars($row['telefone']);
                            $cep = htmlspecialchars($row['cep']);
                            $logradouro = htmlspecialchars($row['logradouro']);
                            $bairro = htmlspecialchars($row['bairro']);
                            $cidade = htmlspecialchars($row['cidade']);
                            $estado = htmlspecialchars($row['estado']);
                            $tipo_sanguineo = htmlspecialchars($row['tipo_sanguineo']);

                            //dataInicioContrato = new DateTime($row['data_contrato']);
                            //dataFormatoDiaMesAno = $data->format('d-m-Y');

                            echo <<<HTML
                            <tr>
                                <td>$nome</td>
                                <td>$email</td>
                                <td>$telefone</td>
                                <td>$cep</td>
                                <td>$logradouro</td>
                                <td>$bairro</td>
                                <td>$cidade</td>
                                <td>$estado</td>
                                <td>{$row['altura']}</td>
                                <td>{$row['peso']}</td>
                                <td>$tipo_sanguineo</td>
                            </tr>
                            HTML;
                        }
                    ?>

                </table>
            </div>
    </main>
    <footer>
        © Copyright 2001-2020 Copyright.com.br - All Rights Reserved
    </footer>
</body>

</html>