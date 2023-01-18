<?php

ini_set("display_errors", true);



extract($vetor_conteudo);

$ctr_eleicao = new Eleicao_Control($post_request);

$eleicao = $ctr_eleicao->Pega_Eleicao(1);

$hoje = date("Y-m-d H:i:s");

if ($eleicao['data_inicio'] > $hoje or $eleicao['data_fim'] < $hoje) {

    header('Location:/');
};

?>

<html>

<head>

    <?php include('./includes/metatags.php'); ?>



    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <?php echo (isset($metas)) ? $metas : ""; ?>



    <link type="text/css" rel="stylesheet" href="/mobile/includes/mobile.css?v=4">

    <script src="/scripts/jquery-1.12.3.min.js" type="text/javascript"></script>

    <script src="/scripts/jquery.mask.js" type="text/javascript"></script>

    <script src="/scripts/jquery.validate.js" type="text/javascript"></script>

    <?php require "includes/scripts.php"; ?>

    <script src="/scripts/easytimer.js" type="text/javascript"></script>

    <?php echo $java_script; ?>



    <script type="text/javascript">
        $(document).ready(function() {

            $('.telefone').mask('(99) 99999-9999');

            $('.cpf').mask('999.999.999-99');



            //$(".passo4").css("display", "block");

            //$(".passo1").css("display", "none");





            $('#menu_click').click(function() {

                $('html').toggleClass("menu_active");

            });



            $('#btn_area_restrita, #close_area_restrita').click(function() {

                $('html').toggleClass("area_restrita_active");

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



        function get5minFromNow() {

            return new Date(new Date().valueOf() + 5 * 60 * 1000);

        }



        function resetaClock() {

            $('#clock').countdown(get5minFromNow());

        }





        function desaparecer(div) {



            levTop();

            $("." + div).css("display", "none");

        }



        function abrirModal(n) {

            x = n + 1;





            var var_name = $(".passo" + n + " input[name='voto']:checked").val();

            if (var_name) {

                var html_modal = $('.info' + var_name).html();



                //console.log(html_modal);

                $(".modal_eleicao .infos").html(html_modal);

                $(".botao_eleicao.confirmar").attr('onclick', 'passo(' + x + ')');

                $(".modal_eleicao").css("display", "table");

            }

        }



        function relogio() {



            $('.btn_reenvia').css('display', 'none');

            $('.passo2 form').css('display', 'block');

            $('#clock').countdown(get5minFromNow(), {
                elapse: true
            }).on('update.countdown', function(event) {

                if (event.elapsed) {

                    $(this).html('00:00');

                    $('.btn_reenvia').css('display', 'block');

                    $('.passo2 form').css('display', 'none');

                } else {

                    $(this).html(event.strftime('%M:%S'));

                }

            });

        }



        function aparecer(n) {

            let x = n - 1;

            $(".passo" + x).css("display", "none");

            $(".passo" + n).css("display", "block");



            $(".p" + x).removeClass("ativo").addClass("confirmado");

            $(".p" + n).addClass("ativo");



            if (n == 4 || n == 5) {

                $(".modal_eleicao").css("display", "none");

            }



            if (n == 2) {

                relogio();

            }

        }

        function topTop() {

            var totop = $(window).scrollTop() - 270;

            if (totop <= 0) {

                clearInterval(idInterval);

            } else {

                totop--;

                $(window).scrollTop(totop);

            }

        }

        function levTop() {

            idInterval = setInterval('topTop();', 1);

        }

        var dados = "";



        function passo(n) {

            let x = n - 1;

            dados = dados + "&" + $(".passo" + x + " form").serialize();

            var msg = Array();

            if (x == 1) {

                msg[0] = "CPF ou Telefone informados inválido.";

                msg[-1] = "Esse associado já votou nessa eleição.";



                msg[-3] = "Ocorreu um erro ao enviar o SMS. Consulte um administrador.";

            } else if (x == 2) {

                msg[0] = "Código inválido.";

            }

            $.ajax({

                url: "includes/eleicoes.php?p=" + x,

                type: "POST",

                data: dados,



                dataType: "json",

                async: true,

                success: function(data, textStatus, jqXHR) {

                    if (data['passa'] == 1) {



                        levTop();

                        if (x == 1) {



                            $(".passo2 .texto b span").html($(".passo1 form .telefone").val())

                        }



                        aparecer(n);

                    } else {

                        $(".passo" + x + " .msg_erro").html(msg[data['codigo']]);

                    }



                }

            });



        }
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



<?php

$ctr_chapas = new ChapaEleicao_Control($post_request);

$ctr_candidatos = new Candidato_Control($post_request);

$chapas1 = $ctr_chapas->Lista_Chapas(1);

$chapas2 = $ctr_chapas->Lista_Chapas(2);



$branco_nulo = '<div class="chapa">

                            <input type="radio" name="voto" value="0">

                            <span class="checkmark"></span>



                            <div class="infos info0">

                                <div class="img_chapa" style="background-image: url(../imagens/vote_nulo.svg)"></div>

                                <div class="texto_chapa">

                                    <div class="nome_chapa">Nulo</div>

                                </div>

                            </div>

                        </div>

                        

                    <div class="chapa">

                            <input type="radio" name="voto" value="-1">

                            <span class="checkmark"></span>



                            <div class="infos info-1">

                                <div class="img_chapa" style="background-image: url(../imagens/vote_branco.svg)"></div>

                                <div class="texto_chapa">

                                    <div class="nome_chapa">Branco</div>

                                </div>

                            </div>

                        </div>';

?>



<body>



    <div id="escurecedor">

        <div id="close_area_restrita"></div>

        <div id="area_restrita">

            <div class="titulo_area_restrita">Área restrita do sindicalizado</div>

            <form name="form_login" id="form_login" method="post" action="" onSubmit="return validar_form_login();">

                <div class="icone icone_login"></div>

                <input name="cpf" type="text" id="cpf" placeholder="CPF" />

                <div class="icone icone_pass"></div>

                <input type="password" name="senha" id="senha" placeholder="Senha" />

                <input type="submit" value="Entrar" name="entrar" id="entrar" class="botao-entrar" />

                <div class="infos">

                    <a href="/perdeu-senha">
                        <div id="perdeu_sua_senha">Perdeu sua

                            senha?</div>
                    </a>

                </div>

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



    <section id="conteudo_2nivel" style="margin-left: 0; width: 100%">

        <!-- <div class="titulo"><?php echo $nome_link ?></div> -->

        <div class="processo_eleitoral">

            <span>Processo Eleitoral</span>

        </div>

        <div class="centraliza_conteudo">

            <div class="passos">

                <!-- <div class="passo p1 ativo">

					<span class="numero">01</span><br> <span class="texto">Autenticação</span>

				</div>



				<div class="passo p2">

					<span class="numero">02</span><br> <span class="texto">Confirmação</span>

				</div>

				<div class="passo p3">

					<span class="numero">03</span><br> <span class="texto">Cédula Chapa</span>

				</div>



				<div class="passo p4">

					<span class="numero">04</span><br> <span class="texto">Cédula

						Conselho Digital</span>

				</div>



				<div class="passo p5">

					<span class="numero">05</span><br> <span class="texto">Processo

						Finalizado</span>

				</div> -->





            </div>

            <div class="eleicao">

                <div class="passo1 step">

                    <div class="bloco">

                        <div class="titulo_eleicao">COMO FUNCIONA?</div>

                        <div class="texto">Seja bem-vindo ao local de votação.<br>

                            <b>Como votar</b>:<br><br>

                            Informe seu CPF e o número de seu celular com DDD.<br><br>

                            O sistema vai encaminhar um código via SMS para o seu número.<br><br>

                            Utilize esse código para votar.<br><br>

                            Primeiro você vai escolher a Diretoria executiva.<br><br>

                            Escolha sua opção, vote e confirme seu voto.<br><br>

                            Em seguida, você vai escolher um representante para o conselho fiscal.<br><br>

                            Finalize a votação.<br><br>

                            Dúvidas / dificuldades: Whatsapp 48 99182-2462
                        </div>

                    </div>



                    <div class="bloco">

                        <form onsubmit="return false;">

                            <label for="cpf">CPF*</label> <input type="text" name="cpf" class="cpf" /> <label for="cpf">Telefone*</label> <input type="text" name="telefone" class="telefone" />



                            <div class="msg_erro"></div>



                            <input type="submit" value="CONFIRMAR" class="confirmar" onclick="passo(2)" />

                        </form>

                        </form>

                    </div>

                </div>



                <div class="passo2 step">

                    <div class="bloco" style="">

                        <div class="titulo_eleicao">CONFIRMAÇÃO</div>

                        <div class="texto">

                            Esta etapa ajuda a validar sua autenticação durante o processo

                            eleitoral.<br> <br> <b>Você recebeu um código de verificação via

                                SMS<br> <br> O SINDISEA enviou um código de verificação para: <span></span>

                            </b>

                        </div>



                        <form onsubmit="return false;">

                            <label for="codigo">Código de verificação*</label> <input pattern="[0-9]+$" maxlength="5" minlength="5" type="text" name="codigo" class="codigo" />

                            <div class="msg_erro"></div>

                            <input type="submit" value="CONFIRMAR" class="confirmar" onclick="passo(3)" />

                        </form>



                        <div style="display: none" class="btn_reenvia">

                            <b>Não recebeu seu código de verificação?</b><br> Solicite um

                            novo abaixo. <input type="submit" name="reenviar" class="reenviar" onclick="passo(2);" value="ENVIAR NOVAMENTE" />

                        </div>



                    </div>





                    <div class="bloco">

                        <div class="img">

                            <div class="time">

                                <span id="clock"></span>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="passo3 step">

                    <div class="titulo_eleicao">DIRETORIA EXECUTIVA</div>

                    <p>Escolha apenas uma opção.</p>

                    <form onsubmit="return false;">

                        <?php

                        foreach ($chapas1 as $value) {

                        ?>

                            <div class="chapa">

                                <input type="radio" name="voto" value="<?php echo $value['id_chapa_eleicao'] ?>"> <span class="checkmark"></span>



                                <div class="infos info<?php echo $value['id_chapa_eleicao'] ?>">

                                    <div class="img_chapa" style="background-image: url(imagens/chapas/<?php echo $value['id_chapa_eleicao'] ?>.jpg)"></div>

                                    <div class="texto_chapa">

                                        <div class="nome_chapa"><?php echo $value['nome'] ?></div>

                                        <ul class="integrantes">

                                            <?php

                                            $candidatos = $ctr_candidatos->Lista_Candidatos(" AND id_chapa = " . $value['id_chapa_eleicao']);



                                            $desc_candidatos = $ctr_candidatos->Lista_Descricoes();

                                            foreach ($candidatos as $value2) {

                                            ?>

                                                <li><?php echo $value2['nome'] . " (" . $desc_candidatos['cargo'][$value2['id_cargo']] . ")" ?></li>

                                            <?php } ?>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        <?php

                        }



                        echo $branco_nulo;

                        ?>



                        <input type="submit" value="VOTAR" class="confirmar" onclick="abrirModal(3)" />

                    </form>





                </div>



                <div class="passo4 step">

                    <div class="titulo_eleicao">CONSELHO FISCAL</div>

                    <p>Escolha apenas uma opção.</p>

                    <form onsubmit="return false;">

                        <?php

                        foreach ($chapas2 as $value) {

                        ?>

                            <div class="chapa">

                                <input type="radio" name="voto" value="<?php echo $value['id_chapa_eleicao'] ?>"> <span class="checkmark"></span>



                                <div class="infos info<?php echo $value['id_chapa_eleicao'] ?>">

                                    <div class="img_chapa" style="background-image: url(../imagens/chapas/<?php echo $value['id_chapa_eleicao'] ?>.jpg)"></div>

                                    <div class="texto_chapa">

                                        <div class="nome_chapa"><?php echo $value['nome'] ?></div>

                                        <ul class="integrantes">

                                            <?php

                                            $candidatos = $ctr_candidatos->Lista_Candidatos(" AND id_chapa = " . $value['id_chapa_eleicao']);



                                            $desc_candidatos = $ctr_candidatos->Lista_Descricoes();

                                            foreach ($candidatos as $value2) {

                                            ?>

                                                <li><?php echo $value2['nome'] . " (" . $desc_candidatos['cargo'][$value2['id_cargo']] . ")" ?></li>

                                            <?php } ?>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        <?php

                        }



                        echo $branco_nulo;

                        ?>



                        <input type="submit" value="VOTAR" class="confirmar" onclick="abrirModal(4)" />

                    </form>



                </div>



                <div class="passo5 step">

                    <div class="titulo_eleicao">PROCESSO FINALIZADO</div>

                    <div class="texto">

                        <b>Seu voto foi computado com sucesso.</b><br> Obrigado pela sua

                        participação e confira a divulgação dos resultados no dia

                        22/05/2020

                    </div>



                    <input type="submit" value="FINALIZAR" class="confirmar" style="margin-top: 20px;" onclick="window.location.href = '/'" />



                </div>

            </div>

        </div>



        </div>

        </div>

    </section>

    <div class="modal_eleicao">

        <div class="centraliza_conteudo ">

            <div class="conteudo_modal">

                <div class="infos"></div>

                <input type="submit" value="CONFIRMAR SEU VOTO" class="botao_eleicao confirmar" /> <input type="submit" value="ALTERAR VOTO" class="botao_eleicao voltar" onclick="desaparecer('modal_eleicao')" />

            </div>



        </div>

    </div>

    <footer>

        <?php include('./includes/rodape.php'); ?>

    </footer>





    <?php include('./includes/google_analytics.php'); ?>

</body>

</html>