<?php
      require "../conexaoMySql.php";
      $pdo = mysqlConnect();

      $cep = "";
      if(isset($_GET["cep"])) $cep = $_GET["cep"];

    try
    {
        $sql = <<<SQL
        SELECT *
        FROM base_enderecos_ajax
        WHERE cep like ?
        LIMIT 1
        SQL;

        $stmt = $pdo->prepare($sql);
        if(!$stmt->execute([$cep]))
            throw new Exception('Erro em buscar endereço.');

        if($row = $stmt->fetch())
        {
            $flag = true;
            $logradouro =  $row['logradouro'];
            $bairro =  $row['bairro'];
            $cidade =  $row['cidade'];
            $estado =  $row['estado'];
        }
        else
        {
            $flag = false;
            $logradouro =  "";
            $bairro =  "";
            $cidade =  "";
            $estado =  "";
        }

        if (! $jsonStr = json_encode([$flag, $logradouro, $bairro, $cidade, $estado]))
			throw new Exception("Erro no json_encode do PHP ao buscar endereço");
		
		echo $jsonStr;
    }
    catch(Exception $e)
    {
        exit('Erro: ' . $e->getMessage());
    }
?>