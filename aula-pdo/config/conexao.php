<?php
// try - ira tentar executar instruções, caos falhe irá cair no catch que irá capturar um erro
// e retornar o possível erro para nós
/*
try {
    $dbh = new PDO('mysql:host=localhost;dbname=aula_pdo;charset=utf8mb4;port=3306
    ', 'root', '');
    $listaUsuarios = $dbh->query('SELECT * from usuarios');
    foreach($listaUsuarios as $usuario) {
        echo "<pre>";
        echo $usuario["nome"] . "<br>";
        echo $usuario["sobrenome"] . "<br>";
        echo $usuario["email"] . "<br>";
        echo $usuario["senha"] . "<br>"; 
        echo "</pre>";
    }
    //foreach($dbh->query('SELECT * from usuarios') as $row) {
        //print_r($row);
    }
    */
    try {
        // instanciando conexao com o banco de dados atraves da classe PDO
        $dbh = new PDO('mysql:host=localhost;dbname=aula_pdo;charset=utf8mb4;port=3306', 'root', '');
      } catch (PDOException $e) {
        print "Erro: " . $e->getMessage() . "<br/>";
        die();
      }
?>