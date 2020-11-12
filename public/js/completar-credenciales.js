  jQuery(document).ready(function () {
    document.querySelector('#inputFile').addEventListener('change',function(e){
        var fileName = document.getElementById("inputFile").files[0].name;
        var ext = fileName.split('.').pop();
        if(ext != 'pdf'){
            alertify.alert('La extensión no es permitida','La extensión del archivo solo es valida para PDF');
            document.getElementById("inputFile").value = "";
        }else{
          if(document.getElementById("inputFile").files[0].size > 5242880){
          alertify.alert('El tamaño del archivo excede el máximo','El tamaño del archivo no debe superar los 5mb');
          document.getElementById("inputFile").value = "";
          }else{
            document.querySelector("#customFile > label").textContent = fileName;
            //   var nextSibling = e.target.nextElementSibling
            //   nextSibling.innerText = fileName
          }
        }
      })

      const urlParams = new URLSearchParams(window.location.search);
      const myParam = urlParams.get('token');
      if (myParam) {
          document.getElementById("token").value = myParam;
      }else {
          document.getElementById("registro_completar_credenciales").remove();
          alertify.alert('Dirección invalida','No es posible completar el formulario sin un Token',function() {
              window.location = '/';
          })
      }
})

var form_validation = () => {
    var need = [];
    var customer_name = document.forms["complete-registration"]["address"].value;
    if (customer_name == "" || customer_name == null) {
        need.push(document.getElementById("address"));
    }else{
        document.getElementById("address").setAttribute("class","form-control is-valid");
    }
    var customer_phone = document.forms["complete-registration"]["phone"].value;
    if (customer_phone == "" || customer_phone == null) {
        need.push(document.getElementById("phone"));
    }else{
        document.getElementById("phone").setAttribute("class","form-control is-valid");
    }
    var customer_title = document.forms["complete-registration"]["title"].value;
    if (customer_title == "" || customer_title == null) {
        need.push(document.getElementById("title"));
    }else{
        document.getElementById("title").setAttribute("class","form-control is-valid");
    }
    var customer_institution = document.forms["complete-registration"]["institution"].value;
    if (customer_institution == "" || customer_institution == null) {
        need.push(document.getElementById("institution"));
    }else{
        document.getElementById("institution").setAttribute("class","form-control is-valid");
    }
    var customer_grade = document.forms["complete-registration"]["grade"].value;
    if (customer_grade == "" || customer_grade == null) {
        need.push(document.getElementById("grade"));
    }else{
        document.getElementById("grade").setAttribute("class","form-control is-valid");
    }
    var customer_workPosition = document.forms["complete-registration"]["workPosition"].value;
    if (customer_workPosition == "" || customer_workPosition == null) {
        need.push(document.getElementById("workPosition"));
    }else{
        document.getElementById("workPosition").setAttribute("class","form-control is-valid");
    }
    var customer_email = document.forms["complete-registration"]["secondMail"].value;
    var at_position = customer_email.indexOf("@");
    var dot_position = customer_email.lastIndexOf(".");
    if (at_position < 1 || dot_position < at_position + 2 || dot_position + 2 >= customer_email.length) {
        need.push(document.getElementById("secondMail"));
    }else{
        document.getElementById("secondMail").setAttribute("class","form-control is-valid");
    }

    if (need.length>0) {
        need.forEach(element => {
            element.setAttribute("class","form-control is-invalid invalido");
        });
        alertar('Complete los campos marcados en rojo');
        return;
    }

    var customer_file = document.forms["complete-registration"]["inputFile"];
    if (customer_file.files.length == 0) {
        need.push(document.getElementById("inputFile"));
        alertify.alert('Faltan archivos', `Debes subir un archivo PDF para validar tu vinculo con la ciencia de la computación`)
        return;
    }else{
        document.getElementById("institution").setAttribute("class","form-control is-valid");
    }

    enviar();

}
  
var enviar = () => {
    var form = jQuery('#complete-registration')[0];
    var data = new FormData(form);
    data.append('action','abona2_update_user_data');
    var file = jQuery('#inputFile')[0].files[0];
    data.append('inputFile',file);
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
            alertify.alert('Registro completado', `Gracías tu registro se completo de manera correcta. Te enviaremos un correo con la respuesta de la solicitud de membresía.`,
            function(){ 
            window.location = "/";}
            );
        },
        error: function (e) {
            if (e.responseJSON.data == 'Token invalido o vencido') {
                document.getElementById("registro_completar_credenciales").remove();
                document.getElementById("botonera").innerHTML += `<button id="solicitar_token" class="btn btn-modern btn-lg btn-gradient btn-full-rounded" onclick="solicitar_token()">Solicitar nuevo token</button>`;
            }
            alertar(e.responseJSON.data,'Error de servidor');
        }
    }).responseJSON;
  }

  var solicitar_token = () => {
    alertify.prompt('Nueva solicitud de token','Escriba su correo con el cual realizo el pre registro','sucorreo@domino.com',
    function(evt,value){
     if (value == '') {
         alertify.error('Debes ingresar un valor');
     }else{
        var data = new FormData();
        data.append('correo',value);
        data.append('action','abona2_get_token');
        jQuery.ajax({
            url : abona2_user.ajaxurl,
            type : 'post',
            data : data, 
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function () {
                jQuery('#loadingModal').show();
            },
            success: function (resp) {
                jQuery('#loadingModal').hide();
                alertify.alert("Solicitud Correcta","Su solicitud de token fue enviada de manera correcta, espere el correo con el nuevo token.",
                function(){
                    window.location = "/"
                });
            },
            error: function (e) {
                jQuery('#loadingModal').hide();
                alertify.alert('Correo inexistente',e.responseJSON.data+" Ahora sera redirigido para realizar su pre registro. ",
                function(){
                    window.location = "/pre-register"
                });
            }
        }).responseJSON;
     }
    },
    function(){
        alertify.error('Solicitud cancelada');
    })
}

var alertar = (valor,titulo = '<h3>Faltan Datos</h3>') => {
    alertify.alert(titulo,'<h5><b>'+valor+'</b></h5>').set({transition:'zoom'});
}