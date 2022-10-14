
var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
}, spOptions = {
    onKeyPress: function (val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }
};

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

function validar_form_contato() {
    var msg = '';
    var warning = '';
    if ($("#nome").val() == "") {
        msg = 'Por favor, informe seu nome.';
    } else if ($("#telefone").val() == "") {
        msg = 'Por favor, informe seu telefone.';
    } else if (!checkMail($('#email').val())) {
        msg = 'Por favor, informe um e-mail válido.';
    } else if ($("#mensagem").val() == "") {
        msg = 'Por favor, deixe sua mensagem.';
    } else {
        var dados = jQuery("#form_contato").serialize();
        $.ajax({
            url: "contatos_02.php",
            data: dados,
            type: "POST",
            cache: false,
            async: false,
            dataType: "json",
            beforeSend: function () {
                    $("#msg_contato").html('<strong style="color: #FFFFFF;">Aguarde...</strong>');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            },
            success: function (data, textStatus, jqXHR) {
                if (data.sucesso == 1) {
                    $('#form_contato')[0].reset();
                    $("#msg_contato").html('<strong style="color: #FFFFFF;">' + data.texto + '</strong>');
                } else {
                    $("#msg_contato").html('<strong style="color: #FFFFFF;">' + data.texto + '</strong>');
                }
            }
        });
        return false;
    }
    $("#msg_contato").html('<strong style="color: #FFFFFF;">' + msg + '</strong>');
    return false;
}