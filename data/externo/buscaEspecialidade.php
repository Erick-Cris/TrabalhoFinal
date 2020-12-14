<?php
      require "../conexaoMySql.php";
      $pdo = mysqlConnect();

    try
    {
        $sql = <<<SQL
        SELECT DISTINCT  especialidade
        FROM medico
        SQL;

        $stmt = $pdo->query($sql);

        $especialidades = [];
        while($row = $stmt->fetch()){
            $especialidades[] =  $row['especialidade'];
        }

        if (! $jsonStr = json_encode($especialidades))
			throw new Exception("Erro no json_encode do PHP ao buscar especialidades");
		
		echo $jsonStr;
    }
    catch(Exception $e)
    {
        exit('Erro: ' . $e->getMessage());
    }
?>