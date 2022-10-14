<div class="contato">
  <form name="form_contato" id="form_contato" method="post" action="/contatos_02.php" onsubmit="return validar_form_contato();">
    <select name="assunto" id="assunto">                                                
      <option value="0" selected="selected">Qual o assunto da mensagem?</option>
      <option value="1">Orçamento</option>
      <option value="2">Financeiro</option>
      <option value="3">Suporte / Manutenção</option>
      <option value="4">Parcerias / Fornecedores</option>
      <option value="5">Trabalhe conosco</option>
      <option value="6">Dúvida / Sugestão / Reclamação</option>
      <option value="7">Outro Assunto</option>
    </select>
    <select name="tipo_servico" id="tipo_servico" style="display: none">
      <option value="0" selected="selected">Você busca que tipo de serviço?</option>
      <option value="Site de divulgação" >Site de divulgação</option>
      <option value="Site para venda de produtos (Loja Virtual)" >Site para venda de produtos (Loja Virtual)</option>
      <option value="Criação de um sistema (intranet e outros)" >Criação de um sistema (intranet e outros)</option>
      <option value="Divulgação na Internet (Search Engine Marketing)" >Divulgação na Internet (Search Engine Marketing)</option>                    
      <option value="Site de Associação / Sindicato" >Site de Associação / Sindicato</option>
      <option value="Site de Delivery">Site de Delivery</option>                    
      <option value="Outro serviço" >Outro serviço</option>
    </select>    
    <select name="onde_conheceu" id="onde_conheceu">                            
      <option value="0" selected="selected">Onde conheceu a EquipeDigital.com ?</option>
      <option value="Clientes EquipeDigital.com">Clientes EquipeDigital.com</option>
      <option value="E-mail">E-mail</option>
      <option value="Eventos">Eventos</option>
      <option value="Facebook">Facebook</option>
      <option value="Indicação">Indicação</option>
      <option value="Jornal / Panfleto / Rádio / TV">Jornal / Panfleto / Rádio / TV</option>
      <option value="Procura no Google">Procura no Google</option>
      <option value="Outra Forma">Outra Forma</option>
    </select>

    <input type="text" name="nome" id="nome" placeholder="Nome" value="">
    <input type="text" name="email" id="email" placeholder="Email" value="">
    <input type="tel" name="telefone" id="telefone" placeholder="Telefone" value="">
    <input type="text" name="seu_site" id="seu_site" placeholder="Seu site" value="">

    <input type="text" name="cidade" id="cidade" placeholder="Cidade" value="" style="width: 60%; float:left;">
    <select name="estado" id="estado" style="width: 35%; float: right;">
      <option value="0" selected="selected">Estado</option>
      <option value="AC">Acre</option>
      <option value="AL">Alagoas</option>
      <option value="AP">Amapá</option>
      <option value="AM">Amazonas</option>
      <option value="BA">Bahia</option>
      <option value="CE">Ceará</option>
      <option value="DF">Distrito Federal</option>
      <option value="ES">Espírito Santo</option>
      <option value="GO">Goipas</option>
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

    <textarea name="mensagem" id="mensagem" placeholder="Deixe sua mensagem aqui."></textarea>
    <span>
      <input type="checkbox" name="receber_email" id="receber_email" value="sim">
      Sim, desejo receber por e-mail noticias da EquipeDigital.com
    </span>

    <div id="captcha"></div>				
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"></script>

    <div class="loading"></div>
    <div id="msg_contato" class="msg_contato"></div>                        

    <input type="submit" class="btn_submit" value="Enviar">

    <div class="contato_ico"><p>Fechar</p></div>
  </form>
</div>