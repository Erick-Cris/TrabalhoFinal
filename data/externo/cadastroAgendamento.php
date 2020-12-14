<?php
      require "../conexaoMySql.php";
      $pdo = mysqlConnect();

      $medico = $data = $horario = "";
      $nome = $email = $telefone = "";

      if(isset($_POST["especialidade"])) $especialidade = $_POST["especialidade"];
      if(isset($_POST["medico"])) $medico = $_POST["medico"];
      if(isset($_POST["dataAgendamento"])) $dataAgendamento = $_POST["dataAgendamento"];
      if(isset($_POST["horario"])) $horario = $_POST["horario"];
      if(isset($_POST["nome"])) $nome = $_POST["nome"];
      if(isset($_POST["email"])) $email = $_POST["email"];
      if(isset($_POST["telefone"])) $telefone = $_POST["telefone"];

      if($horario == 8 || $horario == 9)
      {
            $horario = "0" . $horario . ":00:00";
      }
      else
      if($horario > 9 && $horario <= 17)
      {
            $horario = $horario . ":00:00";
      }
      
      try
      {
            $pdo->beginTransaction();

            //QUERY MEDICO
            $sql = <<<SQL
            SELECT p.codigo
            FROM pessoa AS p
            INNER JOIN funcionario AS f ON p.codigo = f.codigo
            INNER JOIN medico AS m ON f.codigo = m.codigo
            WHERE p.nome like ?
            LIMIT 1
            SQL;

            $stmt = $pdo->prepare($sql);
            if(!$stmt->execute([$medico]))
                  throw new Exception('Erro em buscar médico.');
            $codigoMedico = $stmt->fetch(PDO::FETCH_COLUMN);

            //QUERY AGENDA
            $sql = <<<SQL
            INSERT INTO agenda (codigo_medico, data_agendamento, horario, nome, email, telefone)
            values (?, ?, ?, ?, ?, ?);
            SQL;

            $stmt = $pdo->prepare($sql);
            if(!$stmt->execute([$codigoMedico, $dataAgendamento, $horario, $nome, $email, $telefone]))
                  throw new Exception('Erro em cadastrar agendamento.');
            $codigoPessoa = $pdo->lastInsertId();

            $pdo->commit();

            header("location: ../../homeExterna.html");
            exit();
      }
      catch(Exception $e)
      {
            $pdo->rollBack();
            exit('Erro: ' . $e->getMessage());
      }
?>