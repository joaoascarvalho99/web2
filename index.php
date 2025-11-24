<?php
session_start();
include "db.php";

//echo date("Y-m-d H:i");


   //$con = estabelecerConexao();

   // Construir uma Query 'SELECT * FROM fotos'
   //$res = $con->query( 'SELECT * FROM fotos' );

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threadly</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Threadly</div>
            <div href="#">Popular</div>
            <div class="menu">

                <?php if(isset($_SESSION["threadly"])){
                    
                }else{
                    echo '<a href="login.php">Login</a>';
                }
                
            </div>
        </nav>

        

    </header>
</body>
</html>
