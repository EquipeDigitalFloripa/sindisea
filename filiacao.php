<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$detect = new Mobile_Detect();

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$js_head = <<<JAVASCRIPT

        
JAVASCRIPT;

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > Filiar-se";

$vetor_conteudo['nome_link'] = "FILIE-SE";


/* * ***************************************************************************
 * MONTA FORMULÁRIO
 * *************************************************************************** */

if($detect->isMobile() && !$detect->isTablet()){
    $iframe_mapa = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1767.9853821447446!2d-48.55175112422894!3d-27.594435995688656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x952738231359f95b%3A0xc7cca0f15da848a8!2sR.+Pres.+Nereu+Ramos%2C+69+-+Centro%2C+Florian%C3%B3polis+-+SC%2C+88015-010!5e0!3m2!1spt-BR!2sbr!4v1541607248538" width="100%" height="220" frameborder="0" style="border:0" allowfullscreen></iframe>';
}else{
    $iframe_mapa = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1767.9853821447446!2d-48.55175112422894!3d-27.594435995688656!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x952738231359f95b%3A0xc7cca0f15da848a8!2sR.+Pres.+Nereu+Ramos%2C+69+-+Centro%2C+Florian%C3%B3polis+-+SC%2C+88015-010!5e0!3m2!1spt-BR!2sbr!4v1541607248538" width="100%" height="425" frameborder="0" style="border:0" allowfullscreen></iframe>';
}


$vetor_conteudo['conteudo'] = '
        
        <div id="formulario_filiacao">
            <form id="formFiliacao" name="formFiliacao" onSubmit="return false">	
            
                <div class="box_item_form">
                    <label>Nome*</label>
                    <input name="nome" type="text" id="nome" maxlength="60" value="" onKeyPress="Mascara(this, Letra);"/>	
                </div>
                
                <div class="box_item_form">
                    <label>Email Pessoal*</label>
                    <input name="email_pessoal" type="text" id="email_pessoal" maxlength="110" value="" />
                </div>
                
                <div class="box_item_form">
                    <label>Email Empresarial</label>
                    <input name="email_trabalho" type="text" id="email_trabalho" maxlength="110" value="" />
                </div>

                <div class="box_item_form">
                    <label>CPF*</label>
                    <input name="cpf_form" type="text" id="cpf_form" maxlength="60" value="""/>							
                </div>

                <div class="box_item_form">
                    <label>Data de Nascimento*</label>
                    <input name="data_nascimento" type="text" id="data_nascimento" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Matrícula*</label>
                    <input name="matricula" type="text" id="matricula" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Unidade Organizacional (Lotação)</label>
                    <input name="unidade_organizacional" type="text" id="unidade_organizacional" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Categoria*</label>
                    <select name="categoria">
                      <option value="0">Selecione</option>
                      <option value="ativo">Ativo</option>
                      <option value="aposentado">Aposentado</option>
                    </select>
                </div>

                <div class="box_item_form">
                    <label>Telefone Celular*</label>
                    <input name="telefone_celular" type="text" id="telefone_celular" value=""/>							
                </div>

                <div class="box_item_form">
                    <label>Telefone Residencial</label>
                    <input name="telefone_residencial" type="text" id="telefone_residencial" value=""/>							
                </div>

                <div class="box_item_form">
                    <label>Telefone Empresarial</label>
                    <input name="telefone_trabalho" type="text" id="telefone_trabalho" value=""/>							
                </div>

                <div class="box_item_form">
                    <label>CEP*</label>
                    <input name="cep" type="text" id="cep" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Endereço*</label>
                    <input name="endereco" type="text" id="endereco" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Número*</label>
                    <input name="numero" type="text" id="numero" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Complemento</label>
                    <input name="complemento" type="text" id="complemento" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Bairro*</label>
                    <input name="bairro" type="text" id="bairro" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Cidade*</label>
                    <input name="cidade" type="text" id="cidade" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Estado*</label>
                    <select name="estado">
                        <option value="0">Selecione</option>
                        <option value="AC">Acre</option>
                        <option value="AL">Alagoas</option>
                        <option value="AP">Amapá</option>
                        <option value="AM">Amazonas</option>
                        <option value="BA">Bahia</option>
                        <option value="CE">Ceará</option>
                        <option value="DF">Distrito Federal</option>
                        <option value="ES">Espírito Santo</option>
                        <option value="GO">Goiás</option>
                        <option value="MA">Maranhão</option>
                        <option value="MT">Mato Grosso</option>
                        <option value="MS">Mato Grosso do Sul</option>
                        <option value="MG">Minas Gerais</option>
                        <option value="PA">Pará</option>
                        <option value="PB">Paraíba</option>
                        <option value="PR">Paraná</option>
                        <option value="PE">Pernambuco</option>
                        <option value="PI">Piauí</option>
                        <option value="RJ">Rio de Janeiro</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="RS">Rio Grande do Sul</option>
                        <option value="RO">Rondônia</option>
                        <option value="RR">Roraima</option>
                        <option value="SC">Santa Catarina</option>
                        <option value="SP">São Paulo</option>
                        <option value="SE">Sergipe</option>
                        <option value="TO">Tocantins</option>
                    </select>							
                </div>

                <div class="box_item_form">
                    <label>Senha*</label>
                    <input name="senha_form" type="password" id="senha_form" value="" />							
                </div>

                <div class="box_item_form">
                    <label>Confirmação de senha*</label>
                    <input name="senha2" type="password" id="senha2" value="" />						
                </div>
                
                <div class="box_termos">
                    <div class="termos_titulo">Termos de uso:</div>
                    <div id="termoss">
                        Neste ATO DE FILIAÇÃO ao SINDIASEA, EU (NOME DA PESSOA INTERESSADA EM FILIAR-SE) de livre e espontânea vontade, em harmonia com
                        as deliberações fixadas na ASSEMBLÉIA GERAL datada de 15 de abril de 2011, que instituiu o ESTATUTO SOCIAL
                        da categoria e em consonância com as disposições constitucionais e legais.
                        AUTORIZO independentemente do Poder Estadual constituído, do regime jurídico adotado pela Administração direta, que
                        seja descontado na minha folha de pagamento para repasse ao SINDIASEA a:
                        ? CONTRIBUIÇÃO SINDICAL SOCIAL MENSAL DE 1% (um por cento), calculado sobre vencimento do servidor
                        (Códigos 1001 ou 1005), na forma do Estatuto Social, do inciso I, do artigo 47, e na parte inicial do inciso IV, do artigo
                        8º, da CF;<br><br>

                        EXPRESSO AINDA, A RATIFICAÇÃO DA AUTORIZAÇÃO ESTATUTÁRIA,<br>
                        prevista no Estatuto Social, em consonância com o inciso III, do artigo 8º, da CF, para outorgar ao SINDIASEA o direito de
                        declarar greve, de se fazer integrar como parte legítima nos polos ativo ou passivo de quaisquer ações administrativas ou
                        judiciais, individual ou coletiva que envolva os servidores integrantes da categoria e qualquer ente público em todas as
                        instâncias e competências administrativas ou jurisdicionais. Esta Autorização se aplica a quaisquer fatos que impliquem em
                        criação, alteração, extinção de direitos e obrigações da relação jurídica do servidor com a administração pública. Serve
                        também, para o SINDIASEA reivindicar ou defender a manutenção e cumprimento da legislação, para os casos de
                        interpretação e de aplicação ou não de quaisquer leis ou atos administrativos, de acordos, de convenções coletivas, de
                        sentenças normativas, de todos os institutos que assegurem ou prejudiquem direitos. Enfim, o SINDIASEA fica prévia,
                        permanente e expressamente autorizado e outorgado, na qualidade de apoiador, interveniente ou SUBSTITUTO
                        PROCESSUAL, a defender-me e aos servidores como "amicuscuriae", a impugnar ou fazer Reclamação no âmbito judicial
                        ou administrativo, a ingressar com AÇÕES ADMINISTRATIVAS ou JUDICIAIS, INDIVIDUAIS OU COLETIVAS, para impedir
                        lesões, para obter e manter direitos oriundos da relação jurídica de prestação de serviço público, sendo tudo sem a
                        necessidade de outra deliberação assemblear, de apresentar "Lista dos Filiados com endereço, nome e identificação
                        documental" nem de outros documentos específicos para que o SINDIASEA possa cumprir livremente as finalidades
                        sindicais de defesa dos membros da categoria.
                    </div>
                </div>
                
                <div class="box_item_form">
                    <input name="termos de uso" type="checkbox" id="termos_checkbox" value="" />
                    <label for="termos_checkbox" id="termos">Eu li e concordo com os <a href="#termoss">termos de uso</a>.*</label>						
                </div>

                <div class="form_botao">					
                    <input class="disabled" id="botao-enviar" type="submit" value="ENVIAR" name="enviar" class="botao-enviar" />	
                    <div id="msg_formulario2"></div>				
                </div>
            </form>
            
        </div>
        
        <div class="onde_estamos">
            <div class="titulo">ONDE ESTAMOS</div>
            <div class="endereco"><p>R. Presidente Nereu Ramos, 69 - Edifício Bello Empresarial, Sala 204 - Centro, Florianópolis - SC, 88015-010</p></div>
            <div class="mapa">
                '.$iframe_mapa.'
            </div>
        </div>
        ';
?>

<?php

TemplateManager::start();

if ($detect->isMobile() && !$detect->isTablet()) {
    TemplateManager::show('mobile/template2.php', $js_head, "", "", $vetor_conteudo);
} else {
    TemplateManager::show('template2.php', $js_head, "", "", $vetor_conteudo);
}
?>
