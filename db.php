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

   function finduserid($id){
      $con = estabelecerConexao();
      $sql = "SELECT * FROM users WHERE userid = $id";
      $stmt = $con->query($sql);
      $dados = $stmt->fetchAll();
      return $dados;
   }

   function finduser($username, $password) {
      $con = estabelecerConexao();
      if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
         $sql = "SELECT userid, password FROM users WHERE email = :user LIMIT 1";
      } else {
         $sql = "SELECT userid, password FROM users WHERE username = :user LIMIT 1";
      }
      $stmt = $con->prepare($sql);
      $stmt->execute([
         ':user' => $username
      ]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$user) {
         return false;
      }
      if (!password_verify($password, $user['password'])) {
         return false;
      }
      $info = [
         'username' => $username,
         'userid' => $user['userid'],
         'img' => getImgId($user['userid'])
      ];
      return $info;
   }

   function getImgId($userid)  {
      $con = estabelecerConexao();
      $sql = "SELECT imagem FROM imgs WHERE imgid = (SELECT fk_imgid FROM users WHERE userid = :userid)";
      $stmt = $con->prepare($sql);
      $stmt->execute([
         ':userid' => $userid
      ]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!$user) {
         return false;
      }
      return $user['imagem'];
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

   function register($username, $email, $password, $img) {
      $con = estabelecerConexao();
      // Check if user already exists
      $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
      $stmt = $con->prepare($sql);
      $stmt->execute([
         ':username' => $username,
         ':email' => $email
      ]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($user) {
         return false; // User already exists
      }

      // Insert image into images table
      $sql = "INSERT INTO imgs (imagem) VALUES (:imgdata)";
      $stmt = $con->prepare($sql);
      $stmt = $con->prepare($sql);
      $stmt->execute([
            ':imgdata' => $img
      ]);
      $imgId = $con->lastInsertId();

      // Insert new user
      $sql = "INSERT INTO users (username, email, password, fk_imgid) VALUES (:username, :email, :password, :fk_imgid)";
      $stmt = $con->prepare($sql);
      $stmt->execute([
         ':username' => $username,
         ':email' => $email,
         ':password' => password_hash($password, PASSWORD_DEFAULT),
         ':fk_imgid' => $imgId
      ]);
      return $con->lastInsertId();
   }

?>