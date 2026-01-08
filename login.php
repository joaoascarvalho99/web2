<?php   

    session_start();
    include "utils.php";
    include "db.php";

    $erro = False;

    if ($_POST && $_GET["l"] == 1) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $res = finduser($username, $password);
        if($res){
            $_SESSION['username'] = $res['username'];
            $_SESSION['userid'] = $res['userid'];
            $_SESSION['img'] = $res['img'];
            echo '<script>window.location.href = "index.php";</script>';
        }else{
            $erro = True;
        }
    }else if ($_POST && $_GET["l"] == 0) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $img = file_get_contents($_FILES["avatar"]["tmp_name"]);
        $res = register($username, $email, $password, $img);
        if($res == false){
            $erro = True;
        }else{
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $res;
            $_SESSION['img'] = $img;
            echo '<script>window.location.href = "index.php";</script>';
        }
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

        .avatar-upload {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .avatar-upload input {
            display: none;
        }

        .avatar-upload label {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            position: relative;
            border: 2px dashed var(--card-border);
            background: #0f1113;
        }

        .avatar-upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar-upload span {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: var(--muted);
            background: rgba(0,0,0,0.4);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .avatar-upload label:hover span {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo" style="justify-content: center; align-items: center;">
            <div class="mark">T</div><strong>Threadly</strong>
        </div>
        <?php
            if ($_GET["l"] == 0) {
                echo '<h2>Criar Conta</h2>';
            }else{
                echo '<h2>Iniciar Sessão</h2>';
            }
        ?>
        <form method="POST" enctype="multipart/form-data">
            <?php 
                if ($_GET["l"] == 0) {
                    echo <<<IMG
                        <div class="avatar-upload">
                            <label for="avatar">
                                <img id="avatarPreview" src="default-avatar.png" alt="    ">
                                <span>+</span>
                            </label>
                            <input type="file" id="avatar" name="avatar" accept="image/*" required>
                        </div>
                    IMG;
                    echo '<input type="text" name="username" placeholder="Nome de utilizador" required>';
                    echo '<input type="email" name="email" placeholder="Email" required>';
                }else{
                    echo '<input type="text" name="username" placeholder="Nome de utilizador ou Email" required>';
                }
            ?>
            <input type="password" name="password" placeholder="Palavra-passe" required>
            <?php
                if($erro == True){
                    if($_GET["l"] == 0)
                        echo '<div class="error">Nome de utilizador ou email já em uso.</div>';
                    else{
                        echo '<div class="error">Nome de utilizador ou palavra-passe inválidos.</div>';   
                    }
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
            <script>
                document.getElementById('avatar').addEventListener('change', function () {
                    const file = this.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = () => {
                        document.getElementById('avatarPreview').src = reader.result;
                    };
                    reader.readAsDataURL(file);
                });
            </script>
</body>
</html>