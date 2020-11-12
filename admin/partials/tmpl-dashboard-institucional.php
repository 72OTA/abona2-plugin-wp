<?php

global $wpdb;

$table_name = $wpdb->prefix . 'abona2_' . 'pre_register_member';
$table_historic = 'abona2_scc_historico';

$pre_register = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 1 AND member_type=2");
$register_complete = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 2 AND member_type=2");
$rejected_members = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 3 AND member_type=2");
$pay_pending = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 4 AND member_type=2");
$members = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 5 AND member_type=2");
$all = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE member_type=2");
$historic = $wpdb->get_var("SELECT COUNT(*) FROM $table_historic WHERE tipo_socio = 'Institucional'");
?>

<div class="row mx-0">
    <div class="col-md-12">
        <h1 class="text-center">Abona2</h1>
        <h3 class="text-center">Gestión en el proceso membresias institucionales</h3>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card border-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Membresias actuales: <h1 class="text-success"><?php echo $members ?> <i
                                class="fas fa-user-friends"></i></h1>
                    </h5>
                    <a href="?page=members-management&type=Org" class="btn btn-light btn-sm">Explorar</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pendientes de pago: <h1 class="text-warning"><?php echo $pay_pending ?> <i
                                class="fas fa-money-bill-alt"></i></h1>
                    </h5>
                    <a href="?page=pending-pay-management&type=Org" class="btn btn-light btn-sm">Solicitar pago</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pendientes aprobación: <h1 class="text-info">
                            <?php echo $register_complete?> <i class="fas fa-user-clock"></i></h1>
                    </h5>
                    <a href="?page=pending-approve-management&type=Org" class="btn btn-light btn-sm">Revisar</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pre registrados: <h1 class="text-primary">
                            <?php echo $pre_register ?> <i class="fas fa-user-edit"></i></h1>
                    </h5>
                    <a href="?page=pre-members-management&type=Org" class="btn btn-light btn-sm">Enviar correo</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card border-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Usuarios rechazados: <h1 class="text-danger"><?php echo $rejected_members ?>
                            <i class="fas fa-user-alt-slash"></i></h1>
                    </h5>
                    <a href="?page=rejected-members-management&type=Org" class="btn btn-light btn-sm">Más información</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-default mb-3">
                <div class="card-body">
                    <h5 class="card-title">Todos los usuarios: <h1 class="text-default"><?php echo $all ?>
                            <i class="fas fa-users"></i></h1>
                    </h5>
                    <a href="?page=all-users-management&type=Org" class="btn btn-light btn-sm">Listar</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
        <div class="card border-default mb-3">
                <div class="card-body">
                    <h5 class="card-title">Usuarios Historico: <h1 class="text-default"><?php echo $historic ?>
                            <i class="fas fa-user-clock"></i></h1>
                    </h5>
                    <a href="?page=all-users-historico&type=Org" class="btn btn-light btn-sm">Listar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-md-6">
                <div class="card mt-3">
                    <h5 class="card-title">
                        Configuración avanzadas
                    </h5>
                    <p>Edite los parametros de cada membresía, tambien los correos de notificación etc.</p>
                    <a href="?page=abona2-settings" class="btn btn-primary btn-md">Opciones avanzadas</a>
                </div>
            </div>
        </div>
    </div>
