<?php
    function mysqlConnect()
    {
        $db_host = "fdb30.awardspace.net";
        $db_username = "3637077_erickcristian";
        $db_password = "PPI@2020";
        $db_name = "3637077_erickcristian";

        //Acrônimo dsn
        $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";

        $options = [
            PDO::ATTR_EMULATE_PREPARES => false,//roda o prepares de forma logal, apresentando erros e previnindo sql injection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//os erros disparam excessões que auxiliam no tratamento
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,//modifica forma de como usar o fetch
        ];

        try{
            $pdo = new PDO($dsn, $db_username, $db_password, $options);
            return $pdo;
        }
        catch(Exception $e)
        {
            exit('Falha na conexão com o MySQL: ' . $e->getMessage());
        }
    }

?>