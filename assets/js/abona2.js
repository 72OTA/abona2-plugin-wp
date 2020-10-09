jQuery(document).ready(function () {
    jQuery('#userModal').modal('show');
    datatableLang("#datatable-abona2");
})
var showModal = (id) => {
    alert(id);
}

var getUserData = (id, tipo) => {
    jQuery.ajax({
        url: abona2_vars.ajaxurl,
        type: 'post',
        data: {
            action: 'abona2_get_user',
            id_user: id
        },
        beforeSend: function () {
            jQuery('#loadingModal').show();
        },
        success: function (resultado) {
            // document.getElementById('userModal') = innerHTML(resultado);
            jQuery('#loadingModal').hide();
            crearModal(resultado, tipo, id);
        }
    }).responseJSON;
}

var aprobar = (id, opc) => {
    modalObservacion(id, opc)
}

var cancelarPopup = () => {
    swal("Cancelaste!", "", "error");
}

var enviarAprobacion = (id) => {
    var msg = jQuery('#mensajeApp').val();
    jQuery.ajax({
        url: abona2_vars.ajaxurl,
        type: 'post',
        data: {
            action: 'abona2_approbe_user',
            id_user: id,
            mensaje: msg
        },
        beforeSend: function () {
            jQuery('#loadingModal').show();
        },
        success: function (resultado) {
            // document.getElementById('userModal') = innerHTML(resultado);
            jQuery('#loadingModal').hide();
            jQuery('#userModal').hide();
            jQuery('#observacionModal').hide();
            swal({
                    title: "Buen trabajo!",
                    text: "Aprobaste al usuario!",
                    type: "success",
                    closeOnConfirm: false
                },
                function () {
                    location.reload();
                });
        }
    }).responseJSON;
}

var enviarRechazo = (id) => {
    var msg = jQuery('#mensajeApp').val();
    jQuery.ajax({
        url: abona2_vars.ajaxurl,
        type: 'post',
        data: {
            action: 'abona2_reject_user',
            id_user: id,
            mensaje: msg
        },
        beforeSend: function () {
            jQuery('#loadingModal').show();
        },
        success: function (resultado) {
            // document.getElementById('userModal') = innerHTML(resultado);
            jQuery('#loadingModal').hide();
            jQuery('#userModal').hide();
            jQuery('#observacionModal').hide();
            swal({
                    title: "Buen trabajo!",
                    text: "Rechazaste al usuario!",
                    type: "error",
                    closeOnConfirm: false
                },
                function () {
                    location.reload();
                });
        }
    }).responseJSON;
}

let guardarMembresia = (type) => {
    switch (type) {
        case 1:
            membresia = 'Membresía individual';
            var product = jQuery('#membresiaIndividual option:selected').val();
            if (!product) {
                swal("Algo salio mal!", `Seleccione un producto para asociar`, "error");
                return
            }
            break;
        case 2:
            membresia = 'Membresía institucional';
            var product = jQuery('#membresiaInstitucional option:selected').val();
            if (!product) {
                swal("Algo salio mal!", `Seleccione un producto para asociar`, "error");
                return
            }
            break;
        default:
            break;
    }
    jQuery.ajax({
        url: abona2_vars.ajaxurl,
        type: 'post',
        data: {
            action: 'abona2_save_membership',
            product_id: product,
            type: type
        },
        beforeSend: function () {
            jQuery('#loadingModal').show();
        },
        success: function (resultado) {
            jQuery('#loadingModal').hide();
            if (resultado.status === "success") {
                swal("Buen trabajo!", `Asociaste este producto a la ${membresia}!`, "success");
            } else if (resultado.status === "error") {
                swal("Algo salio mal!", `No se pudo completar la asociación`, "error");
            }
        }
    }).responseJSON;
}

let guardarURL = (type) => {
    switch (type) {
        case 1:
            url = 'URL Exitosa';
            var page = jQuery('#urlExitosa option:selected').val();
            if (!page) {
                swal("Algo salio mal!", `Seleccione un producto para asociar`, "error");
                return
            }
            break;
        case 2:
            url = 'URL Fallida';
            var page = jQuery('#urlFallida option:selected').val();
            if (!page) {
                swal("Algo salio mal!", `Seleccione un producto para asociar`, "error");
                return
            }
            break;
        default:
            break;
    }
    jQuery.ajax({
        url: abona2_vars.ajaxurl,
        type: 'post',
        data: {
            action: 'abona2_save_url_afterpayment',
            page_id: page,
            type: type
        },
        beforeSend: function () {
            jQuery('#loadingModal').show();
        },
        success: function (resultado) {
            jQuery('#loadingModal').hide();
            if (resultado.status === "success") {
                swal("Buen trabajo!", `Asociaste el Endpoint a ${url}!`, "success");
            } else if (resultado.status === "error") {
                swal("Algo salio mal!", `No se pudo completar la asociación`, "error");
            }
        }
    }).responseJSON;
}

var crearUsuarioByAdmin = (tipo) => {
    var form = jQuery('#registration')[0];
    var data = new FormData(form);
    data.append('action','abona2_create_user');
    data.append('tipo',tipo);
    var file = jQuery('#inputFile')[0].files[0];
    data.append('inputFile',file);

    jQuery.ajax({
        url: abona2_vars.ajaxurl,
        type: 'post',
        data: data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function () {
            jQuery('#loadingModal').show();
        },
        success: function (resultado) {
            // document.getElementById('userModal') = innerHTML(resultado);
            jQuery('#loadingModal').hide();
            jQuery('#userModal').hide();
            jQuery('#observacionModal').hide();
            swal({
                    title: "Buen trabajo!",
                    text: "Creaste al usuario!",
                    type: "success",
                    closeOnConfirm: false
                },
                function () {
                    location.reload();
                });
        },
        error: function (e) {
            jQuery('#loadingModal').hide();
            swal({
                    title: "Error de servidor",
                    text: "No fue posible crear al usuario"+e.responseJSON.data,
                    type: "error",
                });
        }
    }).responseJSON;
}

var crearCorreoByAdmin = () => {
    var form = jQuery('#registration')[0];
    var data = new FormData(form);
    data.append('action','abona2_create_email');
    jQuery.ajax({
        url: abona2_vars.ajaxurl,
        type: 'post',
        data: data,
        dataType: 'json',
        contentType: false,
        processData: false,
        beforeSend: function () {
            jQuery('#loadingModal').show();
        },
        success: function (resultado) {
            // document.getElementById('userModal') = innerHTML(resultado);
            jQuery('#loadingModal').hide();
            jQuery('#userModal').hide();
            jQuery('#observacionModal').hide();
            swal({
                    title: "Buen trabajo!",
                    text: "Asociaste un correo de notificación!",
                    type: "success",
                    closeOnConfirm: false
                },
                function () {
                    location.reload();
                });
        },
        error: function (e) {
            jQuery('#loadingModal').hide();
            swal({
                    title: "Error de servidor",
                    text: "No fue posible crear el correo"+e.responseJSON.data,
                    type: "error",
                });
        }
    }).responseJSON;
}

var datatableDestroy = (tableName) => {
    Jquery(tableName).DataTable().destroy();
}

var datatableLang = (tableName) => {
    if (jQuery(tableName).length) {
        jQuery(tableName).DataTable({
            "dom": 'Bfrtip',
            "buttons": [{
                    "extend": "excelHtml5",
                    "autoFilter": true,
                    "sheetName": "Usuarios exportados"
                },
                {
                    "extend": "copy",
                    "text": "Copiar"
                },
                "pdf"
            ],
            "language": {
                "lengthMenu": "Mostrar _MENU_ resultados por página",
                "zeroRecords": "No se encontro nada - lo sentimos",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay resultados",
                "infoFiltered": "(filtrado desde _MAX_ resultados totales)",
                "sSearch": "Buscar",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "emptyTable": "No hay contenido disponible en la tabla",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });
    }
}

var crearModal = (user, tipo, id) => {
    jQuery('#userModal').remove();
    var modal = `<div class="modal" data-backdrop="static" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userInfo"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userInfo">Proceso membresía de ${user[0].nombre} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col">
                            <label>RUT</label>
                            <p>${user[0].rut}</p>
                        </div>
                        <div class="col">
                            <label>Nombre Completo</label>
                            <p>${user[0].nombre} ${user[0].apellido}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Correo</label>
                            <p><a target="_blank" href="mailto:${user[0].email}">${user[0].email}</a></p>
                        </div>
                        <div class="col">
                            <label>Teléfono</label>
                            <p><a target="_blank" href="tel:${user[0].telefono}">${user[0].telefono}</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Grado</label>
                            <p>${user[0].grado}</p>
                        </div>
                        <div class="col">
                            <label>Título</label>
                            <p>${user[0].titulo}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Institución</label>
                            <p>${user[0].institucion}</p>
                        </div>
                        <div class="col">
                            <label>Vinculo</label>
                            <p>${user[0].vinculo}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Documento de respaldo</label>
                            <p><a target="_blank"
                                    href="${user[0].pathDoc}">Revisar
                                    Documento</a></p>
                        </div>
                        <div class="col">
                            <label>Dirección</label>
                            <p><a target="_blank" href="https://www.google.cl/maps/search/${user[0].direccion}">${user[0].direccion}</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Observaciones</label>
                            <p>${user[0].observaciones}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p><label>Fecha de pre solicitud: </label> ${user[0].createDate}</p>
                            <p><label>Fecha de solicitud completada: </label> ${user[0].modificationDate}</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">`;
    switch (tipo) {
        case 1:
            modal += `
                        <button type="button" class="btn btn-success" onClick="aprobar(${id},1);">Aprobar</button>
                        <button type="button" class="btn btn-danger" onClick="aprobar(${id},2);">Rechazar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>`;
            break;
        case 2:
            modal += `
                    <a href="admin.php?page=abona2/Abonados.php&approve=$userId">
                        <button type="button" class="btn btn-success">Solicitar pago</button>
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>`;
            break;
        case 3:
            modal += `
                    <a href="admin.php?page=abona2/Abonados.php&approve=$userId">
                        <button type="button" class="btn btn-success">Solicitar Completar Registro</button>
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>`;
            break;
        case 4:
            modal += `
                    <a href="admin.php?page=abona2/Abonados.php&approve=$userId">
                        <button type="button" class="btn btn-success">Solicitar información</button>
                    </a>
                    <a href="admin.php?page=abona2/Abonados.php&reject=$userId">
                        <button type="button" class="btn btn-danger">Eliminar Solicitud</button>
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>`;
            break;
        default:
            modal += `<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>`;
            break;
    }

    modal += `</div>
        </div>
    </div>
</div>`;

    jQuery('#wpbody-content').append(modal);
    jQuery('#userModal').modal('show');
}

var createUser = (tipo) => {
    jQuery('#userModal').remove();
    var modal = `<div class="modal" data-backdrop="static" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userInfo"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userInfo">Creación de usuario metodo tradicional </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="registration" id="registration">
                <div class="form-row row">
                <div class="form-group col-md-6"><label for="firstname">Nombres</label><br>
                    <input class="form-control" name="firstname" id="firstname" type="text" placeholder="Nombre de usuario" required=""></div>
                <div class="form-group col-md-6"><label for="lastname">Apellidos</label><br>
                    <input class="form-control" name="lastname" id="lastname" type="text" placeholder="Apellido de usuario" required=""></div></div>
                <div class="form-row row">
                <div class="form-group col-md-6"><label for="mail">Correo electrónico</label><br>
                    <input class="form-control" name="mail" id="mail" type="text" placeholder="ej@domain.cl" required="">
                </div>
                <div class="form-group col-md-6"><label for="rut">RUT</label><br>
                    <input class="form-control" name="rut" id="rut" type="text" placeholder="12.345.678-9" required="">
                </div></div>
                <div class="form-row row">
                <div class="form-group col-md-12">
                    <label class="form-check-label">Vínculo con la Ciencia de la Computación a través de:</label>
                    <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="vinculo" id="op1" value="1"><br>
                    <label class="form-check-label" for="op1">Investigación científica</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="vinculo" id="op2" value="2"><br>
                    <label class="form-check-label" for="op2">Enseñanza</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="vinculo" id="op3" value="3"><br>
                    <label class="form-check-label" for="op3">Ejercicio profesional</label>
                </div></div></div>
                    <div class="form-row row">
                    <div class="form-group col-md-12">`;
                switch (tipo) {
                    case 2:
                        modal += `
                            <label for="comment">Razón de creación de este usuario de manera tradicional</label>
                            <br>
                        <textarea class="form-control" name="comment" id="comment" type="text" placeholder="El usuario es parte de la sociedad desde sus inicios..." rows="3" minlength="200" maxlength="1500" required=""></textarea>`;
                        break;
                    case 3:
                        modal += `
                            <label for="comment">Razón de creación de este usuario de manera tradicional</label>
                            <br>
                            <textarea class="form-control" name="comment" id="comment" type="text" placeholder="El usuario realizo un estudio sobre..." rows="3" minlength="200" maxlength="1500" required=""></textarea>`;
                        break;
                    default:
                        modal += ` <label for="comment">Razón de creación de este usuario</label>`;
                        break;
                }
                 modal += `</div></div>
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="address">Dirección</label><br>
                                <input class="form-control" name="address" id="address" type="text" placeholder="Daniel de la vega 0283, Maipú, Santiago" required=""></div>
                            <div class="form-group col-md-6">
                                <label for="phone">Teléfono</label><br>
                                <input class="form-control" name="phone" id="phone" type="text" placeholder="+569 86606669"></div></div>
                            <div class="form-row row">
                                <div class="form-group col-md-6">
                                <label for="grade">Grado académico</label><br>
                                <select class="form-control" name="grade" id="grade" type="text" placeholder="Seleccione una opción" required=""><option value="1">Estudiante</option><option value="2">Licenciado</option><option value="3">Magister</option><option value="4">Doctorado</option><option value="5">Post-Doctorado</option></select></div>
                            <div class="form-group col-md-6">
                                <label for="institution">Institución académica o laboral, a la cual pertenece</label><br>
                                <input class="form-control" name="institution" id="institution" type="text" placeholder="UNAB"></div></div>
                            <div class="form-row row">
                                <div class="form-group col-md-6">
                                <label for="title">Título profesional</label><br>
                                <input class="form-control" name="title" id="title" type="text" placeholder="Ingeniero en Computación e Informática" required=""></div>
                            <div class="form-group col-md-6">
                                <label for="workPosition">Cargo Actual</label><br>
                                <input class="form-control" name="workPosition" id="workPosition" type="text" placeholder="Desarrollador, Account Manager..." required=""></div></div>
                            <div class="form-row row">
                                <div class="form-group col-md-6">
                                <label for="secondMail">Correo electrónico secundario</label><br>
                                <input class="form-control" name="secondMail" id="secondMail" type="text" placeholder="ej@domain.cl" required=""></div></div>
                                <br>
                            <div class="form-row row">
                            <div class="form-group col-md-12">
                            <div class="custom-file" id="customFile" lang="es">
                                <input type="file" class="form-control custom-file-input" id="inputFile" name="inputFile" aria-describedby="fileHelp" accept="application/pdf"><br>
                                <label class="custom-file-label" for="inputFile">Seleccionar archivo que certifique al usuario, el formato debe ser PDF y no mayor a 5mb.</label></div>
                        </div>
                    </div>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onClick="crearUsuarioByAdmin(${tipo});">Crear</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>`;

    jQuery('#wpbody-content').append(modal);
    jQuery('#userModal').modal('show');
    jQuery('#inputFile').on('change',function(e){
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
}

var createEmail = () => {
    jQuery('#userModal').remove();
    var modal = `<div class="modal" data-backdrop="static" id="userModal" tabindex="-1" role="dialog" aria-labelledby="mailInfo"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mailInfo">Correo de recepción de notificaciones </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="registration" id="registration">
                <div class="form-row row">
                <div class="form-group col-md-6"><label for="firstname">Nombre completo</label><br>
                    <input class="form-control" name="firstname" id="firstname" type="text" placeholder="Nombre de usuario" required=""></div>
                
                <div class="form-row row">
                <div class="form-group col-md-6"><label for="mail">Correo electrónico</label><br>
                    <input class="form-control" name="mail" id="mail" type="text" placeholder="ej@domain.cl" required="">
                </div>
               </div>
                </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onClick="crearCorreoByAdmin();">Crear</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>`;
    jQuery('#wpbody-content').append(modal);
    jQuery('#userModal').modal('show');
}

var modalObservacion = (id, type) => {
    jQuery('#observacionModal').remove();
    switch (type) {
        case 1:
            var modal = `
            <div class="modal fade" id="observacionModal" tabindex="-1" role="dialog" aria-labelledby="observacionModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="observacionModalLabel">Mensaje de aprobación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Mensaje predefinido:</label>
                            <select class="form-control form-control-lg" id="selectMsg">
                                <option>Usted fue aprobado porque cumple con todos los requerimientos para formar parte de la SCCC</option>
                                <option>Usted fue aprobado ya que cumple con labores relacionadas a la ciencia de la computación</option>
                                <option>Usted fue aprobado gracias a su vinculo con la ciencia de la computación</option>
                            </select>
                            <button type="button" class="btn btn-primary btn-sm" onclick="clonarMsg()">Usar este mensaje</button>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Mensaje:</label>
                            <textarea class="form-control" id="mensajeApp"></textarea>
                        </div>
                       
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarPopup()">Cancelar</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal"  onclick="enviarAprobacion(${id})">Aprobar</button>
                    </div>
                    </div>
                </div>
            </div>
                `;
            break;
        case 2:
            var modal = `
            <div class="modal fade" id="observacionModal" tabindex="-1" role="dialog" aria-labelledby="observacionModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="observacionModalLabel">Mensaje de rechazo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Mensaje predefinido:</label>
                            <select class="form-control form-control-lg" id="selectMsg">
                                <option>Usted fue rechazado porque no cumple con los requisitos minimos para formar parte de la SCCC</option>
                                <option>Usted fue rechazado ya que no cumple con labores relacionadas a la ciencia de la computación</option>
                                <option>Usted fue rechazado debido a que no existe un vinculo con la ciencia de la computación</option>
                            </select>
                            <button type="button" class="btn btn-primary btn-sm" onclick="clonarMsg()">Usar este mensaje</button>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Mensaje:</label>
                            <textarea class="form-control" id="mensajeApp"></textarea>
                        </div>
                       
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cancelarPopup()">Cancelar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"  onclick="enviarRechazo(${id})">Rechazar</button>
                    </div>
                    </div>
                </div>
            </div>
                `;
            break;
        default:
            break;
    }

    jQuery('#wpbody-content').append(modal);
    jQuery('#observacionModal').modal('show');
}

var clonarMsg = () => {
    var msg = jQuery('#selectMsg option:selected').val();
    jQuery('#mensajeApp').val(msg);
}