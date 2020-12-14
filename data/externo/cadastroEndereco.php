<?php
      require "../conexaoMySql.php";
      $pdo = mysqlConnect();
        
      $cep = $logradouro = $bairro = $cidade = $estado = "";

      if(isset($_POST["cep"])) $cep = $_POST["cep"];
      if(isset($_POST["logradouro"])) $logradouro = $_POST["logradouro"];
      if(isset($_POST["bairro"])) $bairro = $_POST["bairro"];
      if(isset($_POST["cidade"])) $cidade = $_POST["cidade"];
      if(isset($_POST["estado"])) $estado = $_POST["estado"];
      
      try
      {
            //QUERY ENDEREÇO
            $sql = <<<SQL
            INSERT INTO base_enderecos_ajax (cep, logradouro, bairro, cidade, estado)
            values (?, ?, ?, ?, ?);
            SQL;

            $stmt = $pdo->prepare($sql);
            if(!$stmt->execute([$cep, $logradouro, $bairro, $cidade, $estado]))
                  throw new Exception('Erro em cadastrar endereco.');
            $codigoPessoa = $pdo->lastInsertId(); 

            header("location: ../../homeExterna.html");
            exit();
      }
      catch(Exception $e)
      {
            $pdo->rollBack();
            exit('Erro: ' . $e->getMessage());
      }
?>