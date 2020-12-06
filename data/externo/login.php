<?php
    function login($pdo, $email, $senha)
    {
        $sql = <<<SQL
        SELECT hash_senha
        FROM funcionario
        where email = ?
        SQL;

        try
        {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $row = $stmt->fetch();
            if(!$row)
                return false;
            else
                password_verify($senha, $row['hash_senha']);
        }
        catch(Exception $e)
        {
            exit('Falha inesperada: ' . $e->getMessage());
        }
    }

    $errorMsg = "";
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        require "conexaoMysql.php";
        $pdo = mysqlConnect();

        $email = $senha = "";
    }
?>