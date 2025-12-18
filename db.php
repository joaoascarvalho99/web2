<?php

   function estabelecerConexao(){
      $hostname = 'localhost';
      $dbname   = 'u506280443_isajoaDB';
      $username = 'u506280443_isajoadbUser';
      $password = '#&Ja145zU~';

      try {
         $conexao = new PDO(
            "mysql:host=$hostname;dbname=$dbname;charset=utf8mb4",
            $username,
            $password,
            [
               PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
               PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
         );
         return $conexao;
      } catch (PDOException $e) {
         die("Erro na ligação à base de dados: " . $e->getMessage());
      }
   }

   function posts(){
      $con = estabelecerConexao();
      $sql = "SELECT * FROM post LIMIT 10";
      $stmt = $con->query($sql);
      $dados = $stmt->fetchAll();
      return $dados;
   }
   
?>