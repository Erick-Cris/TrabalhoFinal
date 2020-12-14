<?php
    require "../conexaoMySql.php";
    $pdo = mysqlConnect();

    try
    {
        $sql = <<<SQL
        SELECT nome, email, telefone, cep, logradouro, bairro, cidade, estado,
        data_contrato, salario, senha_hash
        FROM pessoa INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo
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
    <title>Funcionários</title>
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
                <li class="col-sm-1"><a href="">Endereços</a></li>
                <li class="col-sm-1"><a href="">Agendamentos</a></li>
                <li class="col-sm-2"><a href="">Meus Agendamentos</a></li>
            </ul>
        </div>
    </nav>

    <!--Main-->
    <main>  <div class="tabela">
                <h2>Funcionarios</h2>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">CEP</th>
                        <th scope="col">Logradouro</th>
                        <th scope="col">Bairro</th>
                        <th scope="col">Cidade</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Data do Contrato</th>
                        <th scope="col">Salário</th>
                        <th scope="col">Senha Hash</th>
                    </tr>
                </thead>
                <tbody>
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

                            $data = new DateTime($row['data_contrato']);
                            $data_contrato = $data->format('d-m-Y');

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
                                <td>$data_contrato</td>
                                <td>{$row['salario']}</td>
                                <td>{$row['senha_hash']}</td>                                
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