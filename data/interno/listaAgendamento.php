<?php
    require "../conexaoMySql.php";
    $pdo = mysqlConnect();

    try
    {
        $sql = <<<SQL
        SELECT a.nome, a.email, a.telefone, a.data_agendamento, a.horario, p.nome as nome_medico
        FROM agenda AS a
        INNER JOIN pessoa AS p ON p.codigo = a.codigo_medico
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
    <title>Agendamentos</title>
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
                <li class="col-sm-1"><a href="listaEndereco.php">Endereços</a></li>
                <li class="col-sm-2"><a href="">Meus Agendamentos</a></li>
            </ul>
        </div>
    </nav>

    <!--Main-->
    <main>  <div class="tabela">
                <h2>Agendamentos:</h2>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Data de Agendamento</th>
                        <th scope="col">Horário</th>
                        <th scope="col">Médico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $stmt->fetch())
                        {
                            $nome = htmlspecialchars($row['nome']);
                            $email = htmlspecialchars($row['email']);
                            $telefone = htmlspecialchars($row['telefone']);
                            $horario = htmlspecialchars($row['horario']);
                            $medico = htmlspecialchars($row['nome_medico']);

                            $data = new DateTime($row['data_agendamento']);
                            $data_agendamento = $data->format('d-m-Y');

                            echo <<<HTML
                            <tr>
                                <td>$nome</td>
                                <td>$email</td>
                                <td>$telefone</td>
                                <td>$data_agendamento</td>
                                <td>$horario</td>
                                <td>$medico</td>                              
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