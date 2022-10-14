<div class="contato">
  <form name="form_contato" id="form_contato" method="post" action="/contatos_02.php" onsubmit="return validar_form_contato();">
    <select name="assunto" id="assunto">                                                
      <option value="0" selected="selected">Qual o assunto da mensagem?</option>
      <option value="1">Or�amento</option>
      <option value="2">Financeiro</option>
      <option value="3">Suporte / Manuten��o</option>
      <option value="4">Parcerias / Fornecedores</option>
      <option value="5">Trabalhe conosco</option>
      <option value="6">D�vida / Sugest�o / Reclama��o</option>
      <option value="7">Outro Assunto</option>
    </select>
    <select name="tipo_servico" id="tipo_servico" style="display: none">
      <option value="0" selected="selected">Voc� busca que tipo de servi�o?</option>
      <option value="Site de divulga��o" >Site de divulga��o</option>
      <option value="Site para venda de produtos (Loja Virtual)" >Site para venda de produtos (Loja Virtual)</option>
      <option value="Cria��o de um sistema (intranet e outros)" >Cria��o de um sistema (intranet e outros)</option>
      <option value="Divulga��o na Internet (Search Engine Marketing)" >Divulga��o na Internet (Search Engine Marketing)</option>                    
      <option value="Site de Associa��o / Sindicato" >Site de Associa��o / Sindicato</option>
      <option value="Site de Delivery">Site de Delivery</option>                    
      <option value="Outro servi�o" >Outro servi�o</option>
    </select>    
    <select name="onde_conheceu" id="onde_conheceu">                            
      <option value="0" selected="selected">Onde conheceu a EquipeDigital.com ?</option>
      <option value="Clientes EquipeDigital.com">Clientes EquipeDigital.com</option>
      <option value="E-mail">E-mail</option>
      <option value="Eventos">Eventos</option>
      <option value="Facebook">Facebook</option>
      <option value="Indica��o">Indica��o</option>
      <option value="Jornal / Panfleto / R�dio / TV">Jornal / Panfleto / R�dio / TV</option>
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
      <option value="AP">Amap�</option>
      <option value="AM">Amazonas</option>
      <option value="BA">Bahia</option>
      <option value="CE">Cear�</option>
      <option value="DF">Distrito Federal</option>
      <option value="ES">Esp�rito Santo</option>
      <option value="GO">Goipas</option>
      <option value="MA">Maranh�o</option>
      <option value="MT">Mato Grosso</option>
      <option value="MS">Mato Grosso do Sul</option>
      <option value="MG">Minas Gerais</option>
      <option value="PA">Par�</option>
      <option value="PB">Para�ba</option>
      <option value="PR">Paran�</option>
      <option value="PE">Pernambuco</option>
      <option value="PI">Piau�</option>
      <option value="RJ">Rio de Janeiro</option>
      <option value="RN">Rio Grande do Norte</option>
      <option value="RS">Rio Grande do Sul</option>
      <option value="RO">Rond�nia</option>
      <option value="RR">Roraima</option>
      <option value="SC">Santa Catarina</option>
      <option value="SP">S�o Paulo</option>
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