jQuery(document).ready(function () {
    jQuery('#userModal').modal('show');
    datatableLang("#datatable-abona2");

})
var showModal = (id) => {
    alert(id);
}

var getUserData = (id,tipo) => {
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
            crearModal(resultado,tipo,id);
        }
    }).responseJSON;
}

var aprobar = (id,opc) => {
    modalObservacion(id,opc)
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
                    type:"success",
                    closeOnConfirm: false
                },
                function(){
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
                type:"error",
                closeOnConfirm: false
            },
            function(){
                location.reload();
            });
        }
    }).responseJSON;
}

var datatableDestroy = (tableName) => {
    Jquery(tableName).DataTable().destroy();
}

var datatableLang = (tableName) => {
    if (!jQuery(tableName).length) {
        jQuery(tableName).DataTable({
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
            }
        });
    }
}

var crearModal = (user,tipo,id) => {
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

var modalObservacion = (id,type) => {
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