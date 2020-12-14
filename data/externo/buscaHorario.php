<?php
      require "../conexaoMySql.php";
      $pdo = mysqlConnect();


    $medico = $data = "";
    if(isset($_GET["medico"])) $medico = $_GET["medico"];
    if(isset($_GET["data"])) $data = $_GET["data"];

    try
    {
        $sql = <<<SQL
        SELECT a.data_agendamento, a.horario, a.nome, a.email, a.telefone, p.nome as nome_medico
        FROM agenda AS a
        INNER JOIN pessoa AS p ON a.codigo_medico = p.codigo
        WHERE p.nome = ?
        AND a.data_agendamento = ?
        SQL;

        $stmt = $pdo->prepare($sql);
        if(!$stmt->execute([$medico, $data]))
            throw new Exception('Erro em buscar agendamentos.');

        $horarios = [];
        while($row = $stmt->fetch()){
            $horarios[] =  $row['horario'];
        }

        $horariosInteiros = [];
        foreach($horarios as $hor){
            $aux = explode(':', $hor, 1);
            $horariosInteiros[] = intval($aux[0]);
        }

        if (! $jsonStr = json_encode($horariosInteiros))
			throw new Exception("Erro no json_encode do PHP ao buscar horarios");
		
		echo $jsonStr;
    }
    catch(Exception $e)
    {
        exit('Erro: ' . $e->getMessage());
    }
?>