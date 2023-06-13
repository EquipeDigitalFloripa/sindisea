<html>

<head>
    <?php include('./includes/metatags.php'); ?>

    <link type="text/css" rel="stylesheet" href="includes/site.css">

    <?php echo $java_script; ?>

    <script src="/scripts/jquery.mask.js" type="text/javascript"></script>
    <script src="/scripts/jquery.validate.js" type="text/javascript"></script>
    <?php require "includes/scripts.php"; ?>

    <script type="text/javascript">
        $(document).ready(function() {
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

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v14.0&appId=1175039226225232&autoLogAppEvents=1" nonce="OyDIfByr"></script>
    <!--
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.1&appId=640789542762717&autoLogAppEvents=1';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        -->
    <?php 
        $startDate = strtotime('2023-05-17 08:00:00');
        $currentDate = strtotime(date('Y-m-d h:i:s'));
        if($startDate < $currentDate) {
            include('includes/popup.php');
        }
        //  
    ?>
    <header id="topo_capa">
        <div class="centraliza_conteudo">
            <div id="topo_esquerdo">
                <a href="/inicio">
                    <div class="logo_topo"></div>
                </a>
            </div>
            <div id="topo_direito">
                <div class="contato">
                    <div class="fone">
                        <p>(48) 99182 2462&nbsp&nbsp&nbsp|&nbsp&nbsp&nbsp&nbsp</p>
                    </div>
                    <div class="email">
                        <p>sindisea@sindisea.org.br</p>
                    </div>
                </div>

                <div id="area_cliente">
                    <?php include('./includes/acesso.php'); ?>
                </div>
            </div>
            <div id="menu">
                <?php include('./includes/menu.php'); ?>
            </div>
        </div>
    </header>

    <section id="slider">
        <?php include('./includes/slider.php'); ?>
    </section>

    <section id="noticias">
        <div class="centraliza_conteudo">
            <div class="titulo_capa">NOTÍCIAS</div>
            <div class="busca">
                <form name="form_busca" id="form_busca" method="post" action="/noticias">
                    <input type="text" name="busca" id="busca" value="" placeholder="Pesquise uma notícia">
                    <input type="submit" id="btn_buscar" value="">
                </form>
            </div>
            <?php echo $vetor_conteudo['noticias']; ?>
        </div>
    </section>

    <div class="divisao_capa"></div>

    <section id="a_empresa">
        <div class="centraliza_conteudo">
            <div class="titulo_capa">O SINDISEA</div>
            <div class="foto_sindisea"></div>
            <div class="texto_sindisea">
                <?php echo $vetor_conteudo['o_sindiasea']['conteudo']; ?>
            </div>
            <a href="/o-sindiasea">
                <div class="veja_mais">Saiba mais</div>
            </a>
        </div>
    </section>

    <div class="divisao_capa_cinza"></div>

    <section id="onde_estamos">
        <div class="centraliza_conteudo">
            <div class="titulo_capa">ONDE ESTAMOS</div>
            <div class="endereco">
                <p>R. Presidente Nereu Ramos, 69 - Edifício Bello Empresarial, Sala 205 - Centro, Florianópolis - SC, 88015-010</p>
            </div>
        </div>
        <div class="mapa">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1767.9853821447446!2d-48.55175112422894!3d-27.594435995688656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x952738231359f95b%3A0xc7cca0f15da848a8!2sR.+Pres.+Nereu+Ramos%2C+69+-+Centro%2C+Florian%C3%B3polis+-+SC%2C+88015-010!5e0!3m2!1spt-BR!2sbr!4v1541607248538" width="100%" height="425" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </section>

    <section id="redes_sociais">
        <div class="centraliza_conteudo">
            <div class="titulo_capa">REDES SOCIAIS</div>
            <div class="box_facebook">
                <!-- <div class="fb-page" data-href="https://www.facebook.com/sindiseasc" data-tabs="timeline" data-width="446" data-height="282" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/sindiasea/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/sindiasea/">Sindiasea - Sindicato dos Analistas da SEA</a></blockquote></div> -->
                <div class="fb-page" data-href="https://www.facebook.com/sindiseasc/" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/sindiseasc/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/sindiseasc/">Sindisea - Sindicato dos Servidores da SEA SC</a></blockquote>
                </div>
            </div>
        </div>
        <div class="redes_sociais_fundo_cinza">
            <div class="centraliza_conteudo">
                <a href="https://twitter.com/sindiseasc/" target="_blank">
                    <div class="icon_rodape twitter_icon"></div>
                </a>
                <a href="https://www.instagram.com/sindiseasc" target="_blank">
                    <div class="icon_rodape instagram_icon"></div>
                </a>

            </div>
        </div>
    </section>

    <footer>
        <?php include('./includes/rodape.php'); ?>
    </footer>

    <?php include('./includes/google_analytics.php'); ?>




</body>

</html>