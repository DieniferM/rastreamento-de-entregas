<?php

  /*
    Data: 21/11/2023
    Descrição: Conexão com o banco de dados e retorno de possiveis erros. 
  */

  $host = "localhost";
  $dbname = "localiza_entregas";
  $user = "root";
  $pass = "";

  try{

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  }catch(PDOException $e){
    $error = $e->getMessage();
    echo "Erro com banco de dados: $error";
  }

?>
