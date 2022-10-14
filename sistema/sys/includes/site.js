
function MM_preloadImages() { //v3.0
    var d = document;
    if (d.images) {
        if (!d.MM_p)
            d.MM_p = new Array();
        var i, j = d.MM_p.length, a = MM_preloadImages.arguments;
        for (i = 0; i < a.length; i++)
            if (a[i].indexOf("#") != 0) {
                d.MM_p[j] = new Image;
                d.MM_p[j++].src = a[i];
            }
    }
}

function MM_jumpMenu(targ, selObj, restore) { //v3.0
    eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");
    if (restore)
        selObj.selectedIndex = 0;
}

tam_fone = 0;
function mascara_fone(campo) {
    if (tam_fone < campo.value.length) {
        if (campo.value.length == 1) {
            campo.value = '(' + campo.value;
        }
        if (campo.value.length == 3) {
            campo.value = campo.value + ')';
        }
        if (campo.value.length == 8) {
            campo.value = campo.value + '-';
        }
    }
    tam_fone = campo.value.length;
}


tam_cpf = 0;
function mascara_cpf(campo) {
    if (tam_cpf < campo.value.length) {

        if (campo.value.length == 3) {
            campo.value = campo.value + '.';
        }
        if (campo.value.length == 7) {
            campo.value = campo.value + '.';
        }
        if (campo.value.length == 11) {
            campo.value = campo.value + '-';
        }
    }
    tam_cpf = campo.value.length;
}

tam_cnpj = 0;
function mascara_cnpj(campo) {
    if (tam_cnpj < campo.value.length) {

        if (campo.value.length == 2) {
            campo.value = campo.value + '.';
        }
        if (campo.value.length == 6) {
            campo.value = campo.value + '.';
        }
        if (campo.value.length == 10) {
            campo.value = campo.value + '/';
        }
        if (campo.value.length == 15) {
            campo.value = campo.value + '-';
        }
    }
    tam_cnpj = campo.value.length;
}

tam_cep = 0;
function mascara_cep(campo) {
    if (tam_cep < campo.value.length) {

        if (campo.value.length == 2) {
            campo.value = campo.value + '.';
        }
        if (campo.value.length == 6) {
            campo.value = campo.value + '-';
        }

    }
    tam_cep = campo.value.length;
}

function view(name) {

    if (document.layers) { // NS4
        document.layers[name].visibility = 'visible';
    }
    else if (document.all) { // IE4+
        document.all(name).style.visibility = 'visible';
    }
    else if (document.getElementById) { // NS6 and IE5+
        document.getElementById(name).style.visibility = 'visible';
    }
}

function hide(name) {
    // [url]http://www.experts-exchange.com/Web/Web_Languages/JavaScript/Q_20261147.html[/url]
    if (document.layers) { // NS4
        document.layers[name].visibility = 'hidden';
    }
    else if (document.all) { // IE4+
        document.all(name).style.visibility = 'hidden';
    }
    else if (document.getElementById) { // NS6 and IE5+
        document.getElementById(name).style.visibility = 'hidden'; // if layer$id
    }
}

function formataMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e) {
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    // 13=enter, 8=backspace as demais retornam 0(zero)
    // whichCode==0 faz com que seja possivel usar todas as teclas como delete, setas, etc
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8))
        return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave


    if (strCheck.indexOf(key) == -1)
        return false; // Chave inválida
    len = objTextBox.value.length;
    for (i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal))
            break;
    aux = '';
    for (; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i)) != -1)
            aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0)
        objTextBox.value = '';
    if (len == 1)
        objTextBox.value = '0' + SeparadorDecimal + '0' + aux;
    if (len == 2)
        objTextBox.value = '0' + SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
            objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}

function displayMessageMobile(url) {
    messageObj.setSource(url);
    messageObj.setCssClassMessageBox(false);
    messageObj.setSize(300, 190);
    messageObj.setShadowDivVisible(false);
    messageObj.display();
}

function displayMessage(url) {
    messageObj.setSource(url);
    messageObj.setCssClassMessageBox(false);
    messageObj.setSize(400, 200);
    messageObj.setShadowDivVisible(false);
    messageObj.display();
}

function displayStaticMessage(messageContent, cssClass) {
    messageObj.setHtmlContent(messageContent);
    messageObj.setSize(300, 150);
    messageObj.setCssClassMessageBox(cssClass);
    messageObj.setSource(false);	// no html source since we want to use a static message here.
    messageObj.setShadowDivVisible(false);	// Disable shadow for these boxes
    messageObj.display();
}

function closeMessage() {
    messageObj.close();
}



function checkMail(mail) {
    var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
    if (typeof (mail) == "string") {
        if (er.test(mail)) {
            return true;
        }
    } else if (typeof (mail) == "object") {
        if (er.test(mail.value)) {
            return true;
        }
    } else {
        return false;
    }
}

function trim(str) {
    return str.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
}





