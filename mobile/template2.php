<?php
extract($vetor_conteudo);
?>

<html>

<head>
    <?php include('./includes/metatags.php'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <link type="text/css" rel="stylesheet" href="/mobile/includes/mobile.css">

    <script src="./scripts/jquery-1.12.3.min.js" type="text/javascript"></script>

    <?php echo $java_script; ?>

    <script src="/scripts/jquery.mask.js" type="text/javascript"></script>
    <script src="/scripts/jquery.validate.js" type="text/javascript"></script>
    <?php require "./includes/scripts.php"; ?>

    <script>
        $(document).ready(function() {
            $('#menu_click').click(function() {
                $('html').toggleClass("menu_active");
            });

            $('#btn_area_restrita, #close_area_restrita').click(function() {
                $('html').toggleClass("area_restrita_active");
            });
        });
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-V7MDP9PB4T"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-V7MDP9PB4T');
    </script>
</head>

<body>
<?php 
            include('includes/popup.php');
            ?>
    <div id="escurecedor">
        <div id="close_area_restrita"></div>
        <div id="area_restrita">
            <div class="titulo_area_restrita">Área restrita do sindicalizado</div>
            <form name="form_login" id="form_login" method="post" action="" onSubmit="return validar_form_login();">
                <div class="icone icone_login"></div><input name="cpf" type="text" id="cpf" placeholder="CPF" />
                <div class="icone icone_pass"></div><input type="password" name="senha" id="senha" placeholder="Senha" />
                <input type="submit" value="Entrar" name="entrar" id="entrar" class="botao-entrar" />
                <div class="infos"><a href="/perdeu-senha">
                        <div id="perdeu_sua_senha">Perdeu sua senha?</div>
                    </a></div>
            </form>
            <div id="msg_formulario"></div>
        </div>
    </div>

    <header id="topo_capa">
        <div id="topo_esquerdo">
            <a href="/inicio">
                <div class="logo_topo"></div>
            </a>
            <div id="menu_click">
                <div class="menu_icon"></div>
            </div>
        </div>
        <div id="menu">
            <?php include('./mobile/includes/menu.php'); ?>
        </div>
    </header>

    <section id="conteudo_2nivel">
        <div class="centraliza_conteudo">
            <div class="titulo"><?php echo $nome_link ?></div>
            <div class="texto_pagina"><?php echo $conteudo; ?></div>
        </div>
    </section>

    <footer>
        <?php include('./mobile/includes/rodape.php'); ?>
    </footer>
</body>

</html>