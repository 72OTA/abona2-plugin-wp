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
            crearModal(JSON.parse(resultado),tipo);
        }
    }).responseJSON;
}

var crearModal = (user,tipo) => {
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
                                    href="https://nube.site/wp-content/themes/sccc/${user[0].pathDoc}">Revisar
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
                    <a href="admin.php?page=abona2/Abonados.php&approve=$userId">
                        <button type="button" class="btn btn-success">Aprobar</button>
                    </a>
                    <a href="admin.php?page=abona2/Abonados.php&reject=$userId">
                        <button type="button" class="btn btn-danger">Rechazar</button>
                    </a>
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


var datatableLang = (tableName) => {
    if (jQuery(tableName).length > 0) {
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