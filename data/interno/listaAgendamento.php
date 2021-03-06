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
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- JavaScript Bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../paginasInternas/index.html" style="color: rgba(0,0,0,.5);">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                  </svg>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../../paginasInternas/cadastroFuncionario.html">Novo Funcionário</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../paginasInternas/cadastroPaciente.html">Novo Paciente</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listaFuncionario.php">Funcionários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listaPaciente.php">Pacientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listaEndereco.php">Endereços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listaMeusAgendamentos.php" style="display: none;">Meus Agendamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.html">Sair</a>
                    </li>
                </ul>
            </div>
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