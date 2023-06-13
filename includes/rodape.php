<div class="centraliza_conteudo">
    <div class="lado_esquerdo">
        <div class="logo_rodape"></div>
        <div class="box_contato">
            <div class="endereco">
                <p>R. Presidente Nereu Ramos, 69 - Edif�cio Bello Empresarial, Sala 205 - Centro, Florian�polis - SC, 88015-010</p>
            </div>
            <div class="fone">
                <p>(48) 99182 2462</p>
            </div><span>|</span>
            <div class="email">
                <p>sindisea@sindisea.org.br</p>
            </div>
        </div>
        <div class="links_uteis">
            <div class="titulo_links_uteis">LINKS �TEIS</div>
            <ul>
                <a href="http://www.sea.sc.gov.br" target="_blank">
                    <li>www.sea.sc.gov.br</li>
                </a>
                <a href="http://www.assea.org.br" target="_blank">
                    <li>www.assea.org.br</li>
                </a>
                <a href="http://www.afipesc.com.br" target="_blank">
                    <li>www.afipesc.com.br</li>
                </a>
                <a href="http://www.portaldoservidor.sc.gov.br" target="_blank">
                    <li>www.portaldoservidor.sc.gov.br</li>
                </a>
            </ul>
        </div>
    </div>
    <div class="lado_direito">
        <a href="/filie-se">
            <div class="filie_se">Filie-se</div>
        </a>
    </div>
    <a class="logo_ed" href="http://equipedigital.com" target="_blank"></a>
    <div class="cookie">
        <p>
            Utilizamos dados de cookies para o funcionamento do website,
            analisar e personalizar conte�dos e an�ncios durante a sua navega��o em nossa plataforma e em servi�os de terceiros parceiros.
            Ao navegar pelo site, voc� autoriza a SINDISEA a coletar tais informa��es e utiliz�-las para estas finalidades.
            Voc� pode alterar as suas permiss�es a qualquer momento.
        </p>
        <div class="botoes-cookie">
            <button id="entendi">OK, ENTENDI</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(() => {
        if (localStorage.getItem("cookie") == "true") {
            $("div.cookie").hide()
        } else {
            $("div.cookie").show()
        }
        $('#entendi').on('click', () => {
            console.log($("div.cookie"))
            $("div.cookie").hide()
            localStorage.setItem("cookie", "true")

        })
    })
</script>