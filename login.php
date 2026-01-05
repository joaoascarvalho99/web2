<?php   

    session_start();
    include "utils.php";
    include "db.php";

    $erro = False;

    if ($_POST && $_GET["l"] == 1) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $res = finduser($username, $password);
        if($res[0]["userid"] ?? false){
            $_SESSION['username'] = $res['username'];
            $_SESSION['userid'] = $res['userid'];
            echo '<script>window.location.href = "index.php";</script>';
        }else{
            $erro = True;
        }
    }else if ($_POST && $_GET["l"] == 0) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $res = register($username, $email, $password);
        show_var($res);
    }

    if(!isset($_GET["l"])){
        echo '<script>window.location.href = "login.php?l=1";</script>';
    }

?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Login</title>
    <style>
        :root {
            --bg: #0f1113;
            --panel: #16181c;
            --muted: #9aa0a6;
            --accent: #ff4500;
            --card-border: #2a2d33;
            --radius: 10px;
            --font-sans: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        body {
            font-family: var(--font-sans);
            background: var(--bg);
            color: #e6e6e6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: var(--panel);
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            width: 320px;
        }

        h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #e6e6e6;
        }

        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 12px 10px;
            margin-bottom: 16px;
            border-radius: 6px;
            border: 1px solid var(--card-border);
            background: #0f1113;
            color: #e6e6e6;
            font-size: 14px;
        }

        input::placeholder {
            color: var(--muted);
        }

        button {
            width: 100%;
            padding: 12px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #e03e00;
        }

        .forgot {
            display: block;
            text-align: center;
            margin-top: 12px;
            font-size: 13px;
            color: var(--muted);
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
            color: #ffffff;
        }

        .error {
            text-align: center;
            color: #ff6666;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo" style="justify-content: center; align-items: center;">
            <div class="mark">T</div><strong>Threadly</strong>
        </div>
        <?php
            show_var($_SESSION["userid"]);
            if ($_GET["l"] == 0) {
                echo '<h2>Criar Conta</h2>';
            }else{
                echo '<h2>Iniciar Sessão</h2>';
            }
        ?>
        <form method="POST">
            <?php 
                if ($_GET["l"] == 0) {
                    echo '<input type="text" name="username" placeholder="Nome de utilizador" required>';
                    echo '<input type="email" name="email" placeholder="Email" required>';
                }else{
                    echo '<input type="text" name="username" placeholder="Nome de utilizador ou Email" required>';
                }
            ?>
            <input type="password" name="password" placeholder="Palavra-passe" required>
            <?php
                if($erro == True){
                    echo '<div class="error">Nome de utilizador ou palavra-passe inválidos.</div>';
                }
                if ($_GET["l"] == 0) {
                    echo '<button type="submit">Registar</button>';
                    echo '<a href="?l=1" class="forgot">Já tens conta?</a>';
                }else{
                    echo '<button type="submit">Entrar</button>';
                    echo '<a href="?l=0" class="forgot">Não tens conta?</a>'; 
                }
            ?>
        </form>
    </div>
</body>
</html>