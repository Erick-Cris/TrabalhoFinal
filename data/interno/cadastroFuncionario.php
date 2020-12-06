<?php
      require "../conexaoMySql.php";
      $pdo = mysqlConnect();

      $nome = $email = $telefone = $cep = "";
      $logradouro = $bairro = $cidade = $estado = "";
      $dataInicioContrato = $salario = $senha ="";
      $medico = $crm = $especialidade = "";

      if(isset($_POST["nome"])) $nome = $_POST["nome"];
      if(isset($_POST["email"])) $email = $_POST["email"];
      if(isset($_POST["telefone"])) $telefone = $_POST["telefone"];
      if(isset($_POST["cep"])) $cep = $_POST["cep"];
      if(isset($_POST["logradouro"])) $logradouro = $_POST["logradouro"];
      if(isset($_POST["bairro"])) $bairro = $_POST["bairro"];
      if(isset($_POST["cidade"])) $cidade = $_POST["cidade"];
      if(isset($_POST["estado"])) $estado = $_POST["estado"];
      if(isset($_POST["dataInicioContrato"])) $dataInicioContrato = $_POST["dataInicioContrato"];
      if(isset($_POST["salario"])) $salario = $_POST["salario"];
      if(isset($_POST["senha"])) $senha = $_POST["senha"];
      if(isset($_POST["medico"])) $medico = $_POST["medico"];
      if(isset($_POST["crm"])) $crm = $_POST["crm"];
      if(isset($_POST["especialidade"])) $especialidade = $_POST["especialidade"];

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
                  throw new Exception('Falha ao cadastrar pessoa.');
            $codigoPessoa = $pdo->lastInsertId(); 

            //QUERY FUNCIONÁRIO                       
            $sql = <<<SQL
            INSERT INTO funcionario (data_contrato, salario, senha_hash, codigo)
            values (?, ?, ?, ?);
            SQL;

            $stmt = $pdo->prepare($sql);
            if(!$stmt->execute([$dataInicioContrato, $salario, $hashSenha, $codigoPessoa]))
                  throw new Exception('Falha ao cadastrar funcionário');

            //QUERY MÉDICO
            if($medico)
            {
                  $sql = <<<SQL
                  INSERT INTO medico (crm, especialidade, codigo)
                  values (?, ?, ?);
                  SQL;
      
                  $stmt = $pdo->prepare($sql);
                  if(!$stmt->execute([$crm, $especialidade, $codigoPessoa]))
                        throw new Exception('Falha ao cadastrar médico');
            }

            $pdo->commit();


            header("location: ../../homeInterna.html");
            exit();
      }
      catch(Exception $e)
      {
            $pdo->rollBack();
            exit('Falha na transação: ' . $e->getMessage());
            /*
            if($e->errorInfo[1] === 1062)
                  exit('Dados duplicados: ' . $e->getMessage());
            else
                  exit('Falha ao cadastrar os dados: ' . $e->getMessage());
            */
      }
?>