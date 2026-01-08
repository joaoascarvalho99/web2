<?php
include "utils.php";
include "db.php";
include "avatar.php";

session_start();

// Redirecionar se não estiver logado
if (!isset($_SESSION['username']) || !isset($_SESSION['userid'])) {
    header("Location: login.php?l=1");
    exit;
}

// Processar envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tema = $_POST['tema'] ?? '';
    $postname = $_POST['postname'] ?? '';
    $posttext = $_POST['posttext'] ?? '';
    $img = null;

    if (isset($_FILES['avatar']) && $_FILES['avatar']['tmp_name']) {
        $img = file_get_contents($_FILES['avatar']['tmp_name']);
    }

    createPost($_SESSION['userid'], $tema, $postname, $posttext, $img);
    header("Location: index.php");
    exit;
}

// Função para criar o formulário de post
function postMacker() {
    $username = $_SESSION['username'] ?? 'Utilizador';
    echo <<<HTML
    <form class="post-form" method="POST" enctype="multipart/form-data">
        <div class="post">
            <div class="post-body">
                <div class="post-meta">
                    <strong>t/<input type="text" name="tema" placeholder="Tema" required></strong> • por u/{$username} • agora
                </div>
                <h3><input type="text" name="postname" placeholder="Título do post" required></h3>
                <div class="post-content">
                    <textarea name="posttext" placeholder="Conteúdo do post" required></textarea>
                    <div class="img-upload">
                        <label for="avatar">
                            <img id="avatarPreview" src="default-avatar.png" alt="Imagem do post">
                        </label>
                        <input type="file" id="avatar" name="avatar" accept="image/*">
                        <button type="submit" class="btn-submit">Publicar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    HTML;
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Threadly</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="criarPost.css">
    <style>
        .avatar-upload {
            max-width: 40px;
            max-height: 40px;
        }
        .avatar-upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <header class="global">
        <div class="logo">
            <div class="mark">T</div><strong>Threadly</strong>
        </div>
        <div class="search"><input placeholder="Pesquisar comunidades, posts..."></div>
        <div class="user-actions">
            <?php
                avatar($_SESSION['img'] ?? null);
                $username = $_SESSION['username'] ?? 'Utilizador';
                echo <<<USER
                <h5>{$username}</h5>
                <div class="avatar-upload">
                    <img src="imagem_recuperada.jpg" alt="Avatar">
                </div>
                <button class="btn" onclick="location.href='logout.php'">Sair</button>
                USER;
            ?>
        </div>
    </header>

    <main class="container">
        <aside class="sidebar">
            <?php coms(); ?>
            <div style="margin-top:12px">
                <div class="pill">Criar comunidade</div>
            </div>
        </aside>

        <section class="feed">
            <?php postMacker(); ?>
        </section>

        <aside class="trending">
            <h4>Tendências</h4>
            <?php tends(); ?>
        </aside>
    </main>

    <script>
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatarPreview');

        avatarInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = () => avatarPreview.src = reader.result;
            reader.readAsDataURL(file);
        });
    </script>
</body>
</html>
