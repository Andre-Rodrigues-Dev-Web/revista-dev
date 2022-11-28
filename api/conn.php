<?php 
    //Variaveis de conexão com o banco de dados
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "revistadev";
    $charset = "utf8";
    //Trata erros da conexao PDO
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }