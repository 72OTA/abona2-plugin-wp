    


    <?php

    global $wpdb;

    $table_name = $wpdb->prefix . 'pre_register_member';

    $pre_register = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 1");
    $register_complete = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 2");
    $rejected_members = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 3");
    $pay_pending = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 4");
    $members = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 5");


    echo '
          
        <div class="row mx-0">
            <div class="col-md-12">
                <h1 class="text-center">Abona2</h1>
                <h3 class="text-center">Gestión en el proceso membresias</h3>
            </div>
            <div class="col-md-2">
                <div class="card border-success mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Membresias actuales: <h1 class="text-success">'.$members.' <i
                                    class="fas fa-user-friends"></i></h1>
                        </h5>
                        <a href="?page=members-management" class="btn btn-light btn-sm">Explorar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-warning mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Pendientes de pago: <h1 class="text-warning">'.$pay_pending.' <i
                                    class="fas fa-money-bill-alt"></i></h1>
                        </h5>
                        <a href="?page=pending-pay-management" class="btn btn-light btn-sm">Solicitar pago</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-info mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Pendientes de aprobación: <h1 class="text-info">'.$register_complete.' <i
                                    class="fas fa-user-clock"></i></h1>
                        </h5>
                        <a href="?page=pending-approve-management" class="btn btn-light btn-sm">Brindar resolución</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-primary mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios pre registrados: <h1 class="text-primary">'.$pre_register.' <i
                                    class="fas fa-user-edit"></i></h1>
                        </h5>
                        <a href="?page=pre-members-management" class="btn btn-light btn-sm">Enviar correo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card border-danger mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios rechazados: <h1 class="text-danger">'.$rejected_members.' <i
                                    class="fas fa-user-alt-slash"></i></h1>
                        </h5>
                        <a href="?page=rejected-members-management" class="btn btn-light btn-sm">Más información</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';

    ?>
    
    