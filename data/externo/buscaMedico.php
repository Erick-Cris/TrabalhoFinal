<?php
      require "../conexaoMySql.php";
      $pdo = mysqlConnect();


    $especialidade = "";
    if(isset($_GET["especialidade"])) $especialidade = $_GET["especialidade"];

    try
    {
        $sql = <<<SQL
        SELECT nome
        FROM pessoa
        INNER JOIN funcionario ON pessoa.codigo = funcionario.codigo
        INNER JOIN medico ON funcionario.codigo = medico.codigo
        WHERE especialidade like ?
        SQL;

        $stmt = $pdo->prepare($sql);
        if(!$stmt->execute([$especialidade]))
            throw new Exception('Erro em buscar medicos.');

        $nomes = [];
        while($row = $stmt->fetch()){
            $nomes[] =  $row['nome'];
        }

        if (! $jsonStr = json_encode($nomes))
			throw new Exception("Erro no json_encode do PHP ao buscar medico");
		
		echo $jsonStr;
    }
    catch(Exception $e)
    {
        exit('Erro: ' . $e->getMessage());
    }
?>