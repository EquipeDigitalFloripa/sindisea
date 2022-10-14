<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . "/sistema/AutoLoader.php");

$detect = new Mobile_Detect();

$post_request = array_merge($_POST, $_REQUEST);
extract($post_request);

$js_head = <<<JAVASCRIPT
        

JAVASCRIPT;

$ctr_associado = new Associado_Control($post_request);
$associado = $ctr_associado->Pega_Associado($_SESSION['id_associado']);
$data = new Data();

$vetor_conteudo['caminho'] = "<a href='/inicio'>Início</a> > <a href='/area-restrita'>Área Restrita</a> > Alterar meus dados";

$vetor_conteudo['nome_link'] = "ALTERAR MEUS DADOS";


/* * ***************************************************************************
 * MONTA FORMULÁRIO
 * *************************************************************************** */
$AC = $AL = $AP = $AM = $BA = $CE = $DF = $GO = $ES = $MA = $MT = $MS = $MG = $PA = $PB = $PR = $PE = $PI = $RJ = $RN = $RS = $RO = $RR = $SC = $SP = $SE = $TO = "";
$ativo = $aposentado = "";

$estado = $associado['estado'];

$$estado = 'selected';

$categoria = $associado['categoria'];
$$categoria = 'selected';
$vetor_conteudo['conteudo'] = '
        
        <div id="formulario_alterar_dados">
            <form id="formAlterarDados" name="formAlterarDados" onSubmit="return false">	
            
                <input type="hidden" name="id_associado" id="id_associado" value="'.$associado['id_associado'].'" />

                <div class="box_item_form">
                    <label>Nome*</label>
                    <input name="nome" type="text" id="nome" maxlength="60" value="'.$associado['nome'].'" onKeyPress="Mascara(this, Letra);"/>	
                </div>
                
                <div class="box_item_form">
                    <label>Email Empresarial</label>
                    <input name="email_trabalho" type="text" id="email_trabalho" maxlength="110" value="'.$associado['email_trabalho'].'" />
                </div>
                
                <div class="box_item_form">
                    <label>Email Pessoal*</label>
                    <input name="email_pessoal" type="text" id="email_pessoal" maxlength="110" value="'.$associado['email_pessoal'].'" />
                </div>

                <div class="box_item_form">
                    <label>CPF*</label>
                    <input name="cpf_form" type="text" id="cpf_form" maxlength="60" value="'.$associado['cpf'].'" />							
                </div>

                <div class="box_item_form">
                    <label>Data de Nascimento*</label>
                    <input name="data_nascimento" type="text" id="data_nascimento" value="'.$data->get_dataFormat('BD', $associado['data_nascimento'], 'DMA').'" />							
                </div>

                <div class="box_item_form">
                    <label>Matrícula*</label>
                    <input name="matricula" type="text" id="matricula" value="'.$associado['matricula'].'" />							
                </div>

                <div class="box_item_form">
                    <label>Unidade Organizacional*</label>
                    <input name="unidade_organizacional" type="text" id="unidade_organizacional" value="'.$associado['unidade_organizacional'].'" />							
                </div>

                <div class="box_item_form">
                    <label>Categoria*</label>
                    <select name="categoria">
                      <option value="0">Selecione</option>
                      <option value="ativo" '.$ativo.'>Ativo</option>
                      <option value="aposentado" '.$aposentado.'>Aposentado</option>
                    </select>
                </div>

                <div class="box_item_form">
                    <label>Telefone Empresarial*</label>
                    <input name="telefone_trabalho" type="text" id="telefone_trabalho" value="'.$associado['telefone_trabalho'].'"/>							
                </div>

                <div class="box_item_form">
                    <label>Telefone Residencial*</label>
                    <input name="telefone_residencial" type="text" id="telefone_residencial" value="'.$associado['telefone_residencial'].'"/>							
                </div>

                <div class="box_item_form">
                    <label>Celular*</label>
                    <input name="telefone_celular" type="text" id="telefone_celular" value="'.$associado['telefone_celular'].'"/>							
                </div>

                <div class="box_item_form">
                    <label>CEP*</label>
                    <input name="cep" type="text" id="cep" value="'.$associado['cep'].'" />							
                </div>

                <div class="box_item_form">
                    <label>Endereço*</label>
                    <input name="endereco" type="text" id="endereco" value="'.$associado['endereco'].'" />							
                </div>

                <div class="box_item_form">
                    <label>Número*</label>
                    <input name="numero" type="text" id="numero" value="'.$associado['numero'].'" />							
                </div>

                <div class="box_item_form">
                    <label>Complemento</label>
                    <input name="complemento" type="text" id="complemento" value="'.$associado['complemento'].'" />							
                </div>

                <div class="box_item_form">
                    <label>Bairro*</label>
                    <input name="bairro" type="text" id="bairro" value="'.$associado['bairro'].'" />							
                </div>

                <div class="box_item_form">
                    <label>Cidade*</label>
                    <input name="cidade" type="text" id="cidade" value="'.$associado['cidade'].'" />							
                </div>

                <div class="box_item_form">
                    <label>Estado*</label>
                    <select name="estado">
                        <option value="0">Selecione</option>
                        <option value="AC" '.$AC.'>Acre</option>
                        <option value="AL" '.$AL.'>Alagoas</option>
                        <option value="AP" '.$AP.'>Amapá</option>
                        <option value="AM" '.$AM.'>Amazonas</option>
                        <option value="BA" '.$BA.'>Bahia</option>
                        <option value="CE" '.$CE.'>Ceará</option>
                        <option value="DF" '.$DF.'>Distrito Federal</option>
                        <option value="ES" '.$ES.'>Espírito Santo</option>
                        <option value="GO" '.$GO.'>Goiás</option>
                        <option value="MA" '.$MA.'>Maranhão</option>
                        <option value="MT" '.$MT.'>Mato Grosso</option>
                        <option value="MS" '.$MS.'>Mato Grosso do Sul</option>
                        <option value="MG" '.$MG.'>Minas Gerais</option>
                        <option value="PA" '.$PA.'>Pará</option>
                        <option value="PB" '.$PB.'>Paraíba</option>
                        <option value="PR" '.$PR.'>Paraná</option>
                        <option value="PE" '.$PE.'>Pernambuco</option>
                        <option value="PI" '.$PI.'>Piauí</option>
                        <option value="RJ" '.$RJ.'>Rio de Janeiro</option>
                        <option value="RN" '.$RN.'>Rio Grande do Norte</option>
                        <option value="RS" '.$RS.'>Rio Grande do Sul</option>
                        <option value="RO" '.$RO.'>Rondônia</option>
                        <option value="RR" '.$RR.'>Roraima</option>
                        <option value="SC" '.$SC.'>Santa Catarina</option>
                        <option value="SP" '.$SP.'>São Paulo</option>
                        <option value="SE" '.$SE.'>Sergipe</option>
                        <option value="TO" '.$TO.'>Tocantins</option>
                    </select>							
                </div>

                <div class="form_botao">					
                    <input id="botao-enviar" type="submit" value="ALTERAR" name="enviar" class="botao-enviar" />	
                    <div id="msg_formulario"></div>				
                </div>
            </form>
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