<?php

function estabelecerConexao()
{
   // Podem mais tarde passar para um ficheiro de configuração
   $hostname = 'localhost';
   $dbname = 'u506280443_isajoaDB';
   $username = 'u506280443_isajoadbUser';
   $password = '#&Ja145zU~';

   try {
         $conexao = new PDO( "mysql:host=$hostname;dbname=$dbname;charset=utf8mb4",
                              $username, $password );
   }
   catch( PDOException $e ) {
      echo $e->getMessage();
   }

   return $conexao;
    
}



?>