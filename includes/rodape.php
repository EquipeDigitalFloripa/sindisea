<div class="centraliza_conteudo">
    <div class="lado_esquerdo">
        <div class="logo_rodape"></div>
        <div class="box_contato">
            <div class="endereco">
                <p>R. Presidente Nereu Ramos, 69 - Edifício Bello Empresarial, Sala 205 - Centro, Florianópolis - SC, 88015-010</p>
            </div>
            <div class="fone">
                <p>(48) 99182 2462</p>
            </div><span>|</span>
            <div class="email">
                <p>sindisea@sindisea.org.br</p>
            </div>
        </div>
        <div class="links_uteis">
            <div class="titulo_links_uteis">LINKS ÚTEIS</div>
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
            analisar e personalizar conteúdos e anúncios durante a sua navegação em nossa plataforma e em serviços de terceiros parceiros.
            Ao navegar pelo site, você autoriza a SINDISEA a coletar tais informações e utilizá-las para estas finalidades.
            Você pode alterar as suas permissões a qualquer momento.
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