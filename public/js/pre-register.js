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

    var customer_rut = document.forms["registration"]["rut"].value;
    if (checkRut(customer_rut)) {
        document.getElementById("rut").setAttribute("class","form-control is-valid");
    }else{
        document.getElementById("rut").setAttribute("class","form-control is-invalid invalido");
        alertar('El RUT es invalido, debe llevar el formado de #.###.###-#');
        return false;
    }

    var customer_message = document.forms["registration"]["comment"].value;
    if (customer_message == null || customer_message.length < 130 && customer_message != 0) {
        document.getElementById("comment").setAttribute("class","form-control is-invalid invalido");
        alertar('La declaración de motivación debe contener un mínimo de 130 caracteres');
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
    enviar();
}

var enviar = () => {
    var form = jQuery('#registration')[0];
    var data = new FormData(form);
    data.append('action','abona2_insert_user_data');
    jQuery.ajax({
        url : abona2_user.ajaxurl,
        type : 'post',
        data : data, 
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function () {
            alertar(`<div class="loader"></div>`,'Enviando solicitud');
        },
        success: function (resp) {
            alertify.alert('pre-registro completado', `Gracías ${resp.firstname + ' ' + resp.lastname}, 
            tu pre registro se realizo de manera correcta. Espera un correo electrónico de confirmación. Serás redirigido a la página principal.`
            ,function(){ 
                window.location = "/"; }
            );
        },
        error: function (e) {
            console.log(e);
            alertar(`${e.responseJSON.data}, serás redirigido a la página de socios para revisar tu membresía`,'Valor ya registrado'),
            function(){
                window.location = "/socios";
            };
        }
    }).responseJSON;
  }

function aceptarTerms() {
    document.getElementById("terms").checked = true;
}

function alertar(valor,titulo = '<h3>Faltan Datos</h3>'){
    alertify.alert(titulo,'<h5><b>'+valor+'</b></h5>').set({transition:'zoom'});
};

function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.replaceAll('.','');
    // Despejar Guión
    var rutSinPuntos = valor;
    valor = valor.replaceAll('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { alertar("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { alertar("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    document.forms["registration"]["rut"].value = rutSinPuntos;
    return true;
}

