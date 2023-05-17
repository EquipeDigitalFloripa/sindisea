<html>

<head>
    <?php include('./includes/metatags.php'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <link type="text/css" rel="stylesheet" href="/mobile/includes/mobile.css">

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
        $startDate = strtotime('2023-05-17 08:00:00');
        $currentDate = strtotime(date('Y-m-d h:i:s'));
        if($startDate < $currentDate) {
            echo 'date is in the past';
            include('includes/popup.php');
        }
        //  
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

    <section id="noticias">
        <div class="titulo_capa">NOTÍCIAS</div>
        <div class="busca">
            <form name="form_busca" id="form_busca" method="post" action="/noticias">
                <input type="text" name="busca" id="busca" value="" placeholder="Pesquise uma notícia">
                <input type="submit" id="btn_buscar" value="">
            </form>
        </div>
        <?php echo $vetor_conteudo['noticias']; ?>
    </section>

    <div class="divisao_capa"></div>

    <section id="a_empresa">
        <div class="titulo_capa">O SINDISEA</div>
        <div class="foto_sindisea"></div>
        <div class="texto_sindisea">
            <?php echo $vetor_conteudo['o_sindiasea']['conteudo']; ?>
        </div>
        <a href="/o-sindisea">
            <div class="veja_mais">Saiba mais</div>
        </a>
    </section>

    <div class="divisao_capa_cinza"></div>

    <section id="onde_estamos">
        <div class="titulo_capa">ONDE ESTAMOS</div>
        <div class="endereco">
            <p>R. Presidente Nereu Ramos, 69 - Edifício Bello Empresarial, Sala 205 - Centro, Florianópolis - SC, 88015-010</p>
        </div>
        <div class="mapa">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1767.9853821447446!2d-48.55175112422894!3d-27.594435995688656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x952738231359f95b%3A0xc7cca0f15da848a8!2sR.+Pres.+Nereu+Ramos%2C+69+-+Centro%2C+Florian%C3%B3polis+-+SC%2C+88015-010!5e0!3m2!1spt-BR!2sbr!4v1541607248538" width="100%" height="220" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </section>

    <section id="redes_sociais">
        <div class="titulo_capa">REDES SOCIAIS</div>
        <div class="box_redes">
            <a href="https://www.facebook.com/sindiseasc" target="_blank">
                <div class="icon_rodape facebook_icon"></div>
            </a>
            <a href="https://twitter.com/sindiseasc/" target="_blank">
                <div class="icon_rodape twitter_icon"></div>
            </a>
            <a href="https://www.instagram.com/sindiseasc" target="_blank">
                <div class="icon_rodape instagram_icon"></div>
            </a>
        </div>
    </section>

    <footer>
        <?php include('./mobile/includes/rodape.php'); ?>
    </footer>
</body>

</html>