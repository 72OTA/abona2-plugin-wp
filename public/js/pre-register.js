if (location.protocol !== 'https:') {
    location.replace(`https:${location.href.substring(location.protocol.length)}`);
}
function form_validation() {
    var need = [];
    var customer_name = document.forms["registration"]["firstname"].value;
    if (customer_name == "" || customer_name == null) {
        need.push(document.getElementById("firstname"));
    }else{
        document.getElementById("firstname").setAttribute("class","form-control is-valid");
    }

    var customer_lastnamename = document.forms["registration"]["lastname"].value;
    if (customer_lastnamename == "" || customer_lastnamename == null) {
        need.push(document.getElementById("lastname"));
    }else{
        document.getElementById("lastname").setAttribute("class","form-control is-valid");
    }

    var customer_message = document.forms["registration"]["comment"].value;
    if (customer_message == "" || customer_message == null || customer_message.length < 200) {
        document.getElementById("comment").setAttribute("class","form-control is-invalid invalido");
        alertar('La declaración de motivación debe contener un mínimo de 200 caracteres');
        return;
    }else{
        document.getElementById("comment").setAttribute("class","form-control is-valid");
    }

    /* Check the Customer Email for invalid format */
    var customer_email = document.forms["registration"]["mail"].value;
    var at_position = customer_email.indexOf("@");
    var dot_position = customer_email.lastIndexOf(".");
    if (at_position < 1 || dot_position < at_position + 2 || dot_position + 2 >= customer_email.length) {
        need.push(document.getElementById("mail"));
    }else{
        document.getElementById("mail").setAttribute("class","form-control is-valid");
    }

    var customer_rut = document.forms["registration"]["rut"].value;
    if (!validar(customer_rut)) {
        document.getElementById("rut").setAttribute("class","form-control is-invalid invalido");
        alertar('El rut ingresado es invalido.');
    }else{
        document.getElementById("rut").setAttribute("class","form-control is-valid");
        formato_estandar(customer_rut);
    }

    if (need.length>0) {
        need.forEach(element => {
            element.setAttribute("class","form-control is-invalid invalido");
        });
        alertar('Complete los campos marcados en rojo');
        return;
    }
    var option=document.getElementsByName('vinculo');
    if (!(option[0].checked || option[1].checked || option[2].checked)) {
        alertar('Seleccione su vínculo con la ciencia de la computación');
        return;
    }

    var termsConditions = document.getElementById("terms").checked;
    if (!termsConditions || termsConditions == undefined) {
        alertar("Es necesario aceptar los estatutos para continuar con su registro.");
        return;
    }
    // return true;
    var form = jQuery('#registration');
    jQuery.ajax({
        url : abona2_user.ajaxurl,
        type : 'post',
        data : {
            action: 'abona2_insert_user_data',
            form: form.serialize()
        }, 
        beforeSend: function () {
            jQuery('#loadingModal').show();
        },
        success: function (resp) {
            jQuery('#loadingModal').hide();
            alertify.alert('pre-registro completado', `Gracías ${resp.firstname + ' ' + resp.lastname}, 
            tu pre registro se realizo de manera correcta. Espera un correo electrónico de confirmación. Serás redirigido a la página principal.`
            ,function(){ 
                window.location = "/"; }
            );
        },
        error: function (e) {
            jQuery('#loadingModal').hide();
            alertar(`${e.responseJSON['data']}, serás redirigido a la página de socios para revisar tu membresía`,'Valor ya registrado'),
            function(){
                window.location = "/socios";
            };
        }
    }).responseJSON;
}
function aceptarTerms() {
    document.getElementById("terms").checked = true;
}
function formatear(rut) {
    var tmp = this.quitar_formato(rut);
    var rut = tmp.substring(0, tmp.length - 1),
        f = "";
    while (rut.length > 3) {
        f = '.' + rut.substr(rut.length - 3) + f;
        rut = rut.substring(0, rut.length - 3);
    }
    return (rut.trim() == '') ? '' : rut + f + "-" + tmp.charAt(tmp.length - 1);
};

function quitar_formato(rut) {
    rut = rut.split('-').join('').split('.').join('');
    return rut;
};

function formato_estandar(rut){
    rut = rut.split('.').join('');
    document.getElementById("rut").value = rut;
}

function res(rut) {
    var M = 0,
        S = 1;
    for (; rut; rut = Math.floor(rut / 10))
        S = (S + rut % 10 * (9 - M++ % 6)) % 11;
    return S ? S - 1 : 'k';
};

function validar(rut) {
    rut = formatear(rut);
    if (!/[0-9]{1,2}.[0-9]{3}.[0-9]{3}-[0-9Kk]{1}/.test(rut))
        return false;
    var tmp = rut.split('-');
    var dv = tmp[1],
        rut = tmp[0].split('.').join('');
    if (dv == 'K') dv = 'k';
    return (res(rut) == dv);
};

function alertar(valor,titulo = '<h3>Faltan Datos</h3>'){
    alertify.alert(titulo,'<h5><b>'+valor+'</b></h5>').set({transition:'zoom'});
}

