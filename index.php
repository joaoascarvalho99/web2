<?php

    include "utils.php";
    include "db.php";

    //show_var($teste);

    function post(){
        $posts = posts();
        // aqui iriam os 10 posts buscados na base de dados para nao sobrecarregar a página
        foreach($posts as $post){
            // renderiza o post
            if(!empty($post['fk_img'])):
                $post['fk_img'] = "<img src=\"{$post['fk_img']}\" alt=\"Imagem do post\" class=\"post-img\">";
            else:
                $post['fk_img'] = "";
            endif;
            $post['created_at'] = data($post['created_at']);
            echo <<<POST
                <div class="post">
                    <div class="post-body">
                        <div class="post-meta">
                            <strong>t/{$post['fk_temaid']}</strong> • por u/{$post['fk_userid']} • há {$post['created_at']}
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
    <link rel="stylesheet" href="teste.css">
</head>

<body>
    <header class="global">
        <div class="logo">
            <div class="mark">T</div><strong>Threadly</strong>
        </div>
        <div class="search"><input placeholder="Pesquisar comunidades, posts..."></div>
        <div class="user-actions">
            <button class="btn">Criar</button>
            <button class="btn">Entrar</button>
        </div>
    </header>

    <main class="container">
        <aside class="sidebar">
            <h4>Comunidades</h4>
            <ul class="sub-list">
                <li>
                    <div class="sub-mark">PT</div>
                    <div>t/Portugal</div>
                </li>
                <li>
                    <div class="sub-mark">JS</div>
                    <div>t/javascript</div>
                </li>
                <li>
                    <div class="sub-mark">UX</div>
                    <div>t/userexperience</div>
                </li>
                <li>
                    <div class="sub-mark">AI</div>
                    <div>t/artificial</div>
                </li>
            </ul>

            <div style="margin-top:12px">
                <div class="pill">Criar comunidade</div>
            </div>
        </aside>

        <section class="feed">
            <?php post(); ?>
        </section>

        <aside class="trending" aria-label="Barra lateral direita">
            <h4>Tendências</h4>
            <div class="trend-item">
                <div>t/Portugal</div>
                <div class="pill">🔥 12.4k</div>
            </div>
            <div class="trend-item">
                <div>t/technology</div>
                <div class="pill">🔥 9.1k</div>
            </div>

            <div style="margin-top:12px">
                <h4>Sobre</h4>
                <p style="margin:6px 0;color:var(--muted);font-size:14px">Exemplo de layout inspirado no Reddit. Usa
                    isto como base para um projeto ou para adaptar componentes.</p>
            </div>
        </aside>
    </main>
</body>
</html>