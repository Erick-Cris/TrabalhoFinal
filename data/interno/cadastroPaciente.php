<?php
      require "../conexaoMySql.php";
      $pdo = mysqlConnect();

      $nome = $email = $telefone = $cep = "";
      $logradouro = $bairro = $cidade = $estado = "";
      $peso = $altura = $sangue = "";

      if(isset($_POST["nome"])) $nome = $_POST["nome"];
      if(isset($_POST["email"])) $email = $_POST["email"];
      if(isset($_POST["telefone"])) $telefone = $_POST["telefone"];
      if(isset($_POST["cep"])) $cep = $_POST["cep"];
      if(isset($_POST["logradouro"])) $logradouro = $_POST["logradouro"];
      if(isset($_POST["bairro"])) $bairro = $_POST["bairro"];
      if(isset($_POST["cidade"])) $cidade = $_POST["cidade"];
      if(isset($_POST["estado"])) $estado = $_POST["estado"];
      if(isset($_POST["peso"])) $peso = $_POST["peso"];
      if(isset($_POST["altura"])) $altura = $_POST["altura"];
      if(isset($_POST["sangue"])) $sangue = $_POST["sangue"];

      //    cria hash da senha
      $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
      
      try
      {
            $pdo->beginTransaction();

            //QUERY PESSOA
            $sql = <<<SQL
            INSERT INTO pessoa (nome, email, telefone, cep, logradouro, bairro, cidade, estado)
            values (?, ?, ?, ?, ?, ?, ?, ?);
            SQL;

            $stmt = $pdo->prepare($sql);
            if(!$stmt->execute([$nome, $email, $telefone, $cep, $logradouro, $bairro, $cidade, $estado]))
                  throw new Exception('Erro em cadastrar pessoa.');
            $codigoPessoa = $pdo->lastInsertId(); 

            //QUERY Paciente                       
            $sql = <<<SQL
            INSERT INTO paciente (peso, altura, tipo_sanguineo, codigo)
            values (?, ?, ?, ?);
            SQL;

            $stmt = $pdo->prepare($sql);
            if(!$stmt->execute([$peso, $altura, $sangue, $codigoPessoa]))
                  throw new Exception('Erro em cadastrar paciente');

            $pdo->commit();


            header("location: ../../homeInterna.html");
            exit();
      }
      catch(Exception $e)
      {
            $pdo->rollBack();
            exit('Erro: ' . $e->getMessage());
      }
?>