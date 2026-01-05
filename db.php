<?php

   function estabelecerConexao(){
      $hostname = 'localhost';
      $dbname   = 'test';
      $username = 'root';
      $password = '';

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

   function finduserid($id){
      $con = estabelecerConexao();
      $sql = "SELECT * FROM users WHERE userid = $id";
      $stmt = $con->query($sql);
      $dados = $stmt->fetchAll();
      return $dados;
   }

   function finduser($username, $password){
      $con = estabelecerConexao();
      if(filter_var($username, FILTER_VALIDATE_EMAIL)){
         $sql = "SELECT * FROM users WHERE email = '$username' AND password = '$password'";
      }else{
         $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
      }
      $stmt = $con->query($sql);
      $dados = $stmt->fetchAll();
      return $dados;
   }

   function posts(){
      $con = estabelecerConexao();
      $sql = "SELECT * FROM post WHERE data >= NOW() - INTERVAL 7 DAY LIMIT 10";
      $stmt = $con->query($sql);
      $dados = $stmt->fetchAll();
      if (!$dados) {
         $sql = "SELECT * FROM post LIMIT 10";
         $stmt = $con->query($sql);
         $dados = $stmt->fetchAll();
      }
      return $dados;
   }

   function temas(){
      $con = estabelecerConexao();
      $sql = "SELECT * FROM tema";
      $stmt = $con->query($sql);
      $dados = $stmt->fetchAll();
      return $dados;
   }

   function getTrends(){
      $con = estabelecerConexao();
      $sql = "SELECT * FROM post WHERE data >= NOW() - INTERVAL 7 DAY ORDER BY comments DESC LIMIT 5";
      $stmt = $con->query($sql);
      $dados = $stmt->fetchAll();
      if (!$dados) {
         $sql = "SELECT * FROM post ORDER BY comments DESC LIMIT 5";
         $stmt = $con->query($sql);
         $dados = $stmt->fetchAll();
      }
      return $dados;
   }

   function getTrendTemas() {
      $con = estabelecerConexao();
      $posts = getTrends();
      $temas = [];

      foreach ($posts as $item) {
         $temaid = (int)$item['fk_temaid'];

         $sql = "SELECT * FROM tema WHERE temaid = :temaid";
         $stmt = $con->prepare($sql);
         $stmt->execute(['temaid' => $temaid]);

         $tema = $stmt->fetch(PDO::FETCH_ASSOC);
         if ($tema) {
            $temas[] = $tema;
         }
      }

      return $temas;
   }

   function register($username, $email, $password){
      $con = estabelecerConexao();
      $sql = "INSERT INTO users (username, password, email, fk_imgid) VALUES ('isaac', 'pass123', 'isaac@mail.com', 1),";
      $stmt = $con->prepare($sql);
      $stmt->execute([
         'username' => $username,
         'email' => $email,
         'password' => $password
      ]);
      return $con->lastInsertId();
   }

?>