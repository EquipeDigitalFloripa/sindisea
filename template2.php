<?php
extract($vetor_conteudo);
?>
<html>

<head>
    <?php include('./includes/metatags.php'); ?>
    <?php 
            include('includes/popup.php');
            ?>
    <?php echo (isset($metas)) ? $metas : ""; ?>

    <link href="/includes/site.css" type="text/css" rel="stylesheet">
    <script src="/scripts/jquery-1.12.3.min.js" type="text/javascript"></script>
    <script src="/scripts/jquery.mask.js" type="text/javascript"></script>
    <script src="/scripts/jquery.validate.js" type="text/javascript"></script>
    <?php require "includes/scripts.php"; ?>
    <?php echo $java_script; ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#menu_click').click(function() {
                $('html').toggleClass("menu_active");
            });

            $(".aba").click(function(event) {
                $(".aba").removeClass("aba_selecionada");
                $(this).addClass("aba_selecionada");
                var aba = $(this).text();
                jQuery.ajax({
                    type: "POST",
                    url: "webservice.php?acao=listar_arquivos&aba=" + aba,
                    dataType: "json",
                    success: function(data) {
                        $('#lista_arquivos').html(data['lista_arquivos']);
                    }
                });
            });
            $(".seta_opcoes").click(function(event) {
                $('html').toggleClass('ativa_opcoes');
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
    <header id="topo_2nivel">
        <div class="centraliza_conteudo">
            <div id="topo_esquerdo">
                <a href="/inicio">
                    <div class="logo_topo"></div>
                </a>
                <div id="menu_click">
                    <div class="menu_nome">MENU</div>
                    <div class="menu_icon"></div>
                </div>
                <div id="menu_2nivel">
                    <?php include('./includes/menu.php'); ?>
                </div>
            </div>
            <div id="topo_direito">
                <div class="contato">
                    <div class="fone">
                        <p>(48) 99182 2462&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp</p>
                    </div>
                    <div class="email">
                        <p>sindiasea@sindisea.org.br</p>
                    </div>
                </div>

                <div id="area_cliente">
                    <?php include('./includes/acesso.php'); ?>
                </div>
            </div>
        </div>

    </header>

    <section id="conteudo_2nivel">
        <div class="centraliza_conteudo">
            <div class="caminho"><?php echo $caminho ?></div>
            <div class="titulo"><?php echo $nome_link ?></div>
            <div class="texto_pagina"><?php echo $conteudo; ?></div>
        </div>
    </section>

    <footer>
        <?php include('./includes/rodape.php'); ?>
    </footer>


    <?php include('./includes/google_analytics.php'); ?>
</body>

</html>