<?php
    require "../conexaoMySql.php";
    $pdo = mysqlConnect();

    $email = $senha = "";
    if(isset($_POST["email"])) $email = $_POST["email"];
    if(isset($_POST["senha"])) $senha = $_POST["senha"];

    $sql = <<<SQL
    SELECT f.senha_hash, p.codigo
    FROM pessoa AS p
    INNER JOIN funcionario AS f ON p.codigo = f.codigo
    WHERE email like ?
    LIMIT 1
    SQL;

    try
    {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        if($row = $stmt->fetch())
        {
            $senhaHash = $row['senha_hash'];
            $codigo = $row['codigo'];
        }

  
        $resultado = password_verify($senha, $senhaHash);

        if($resultado)
            $_SESSION["usuario"] = $codigo;
            //setcookie("usuario", $codigo , time() + (86400 * 30));

        if (! $jsonStr = json_encode($resultado))
        throw new Exception("Erro no json_encode do PHP ao buscar medico");
            
        echo $jsonStr;
    }
    catch(Exception $e)
    {
        exit('Falha inesperada: ' . $e->getMessage());
    }
?>