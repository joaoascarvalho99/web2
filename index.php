<?php

    session_start();
    include "utils.php";
    include "db.php";
    include "avatar.php";

    function post(){
        $posts = posts();
        $temas = temas();
        if($posts == ""){
            echo "<p>Nenhum post disponível.</p>";
            return;
        }
        // aqui iriam os 10 posts buscados na base de dados para nao sobrecarregar a página
        foreach($posts as $post){
            // renderiza o post
            if(!empty($post['fk_img'])):
                $post['fk_img'] = "<img src=\"{$post['fk_img']}\" alt=\"Imagem do post\" class=\"post-img\">";
            else:
                $post['fk_img'] = "";
            endif;
            $post['created_at'] = data($post['created_at']);
            $post["fk_userid"] = finduserid($post["fk_userid"])[0]['username'];
            $tema = array_filter($temas, fn($t) => $t['temaid'] == $post['fk_temaid']);
            $tema = array_values($tema)[0]['temaname'];
            echo <<<POST
                <div class="post">
                    <div class="post-body">
                        <div class="post-meta">
                            <strong>t/{$tema}</strong> • por u/{$post['fk_userid']} • {$post['created_at']}
                        </div>
                        <h3>{$post['postname']}</h3>
                        <div class="post-content">
                            {$post['posttext']}
                            {$post['fk_img']}
                        </div>
                        <div class="post-footer">
                            <button><img src="message-circle-more.svg"> {$post['comments']} comentários</button>
                            <button aria-label="upvote">▲ {$post['upvotes']}</button>
                            <button aria-label="downvote">▼ {$post['downvotes']}</button> 
                        </div>
                    </div>
                </div>
            POST;
        }
    }

?>

<html lang="pt-PT">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Threadly</title>
    <link rel="stylesheet" href="estilos.css">
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
                if(isset($_SESSION['username'])){
                    avatar($_SESSION['img']);
                    echo <<< user
                        <h5>{$_SESSION['username']}</h5>
                        <div class="avatar-upload">
                            <img src="imagem_recuperada.jpg" alt="Avatar">
                        </div>
                        <button class="btn" onclick="location.href='\logout.php'">Sair</button> 
                    user;
                }else{
                    echo <<< login
                        <button class="btn" onclick="location.href='login.php?l=0'">Criar</button>
                        <button class="btn" onclick="location.href='login.php?l=1'">Entrar</button>
                    login;
                }
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
            <?php
                if($_SESSION['username'] ?? false){
                    echo <<< BTN
                        <button class="btn-plus" onclick="location.href='post.php'">+</button>
                    BTN;
                } 
                post();
            ?>
        </section>

        <aside class="trending">
            <h4>Tendências</h4>
            <?php tends(); ?>
        </aside>
    </main>
</body>
</html>