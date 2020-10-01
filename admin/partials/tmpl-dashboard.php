<?php

global $wpdb;

$table_name = $wpdb->prefix . 'abona2_' . 'pre_register_member';

$pre_register = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 1");
$register_complete = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 2");
$rejected_members = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 3");
$pay_pending = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 4");
$members = $wpdb->get_var("SELECT COUNT(*) FROM $table_name where estado_id = 5");
?>

    <div class="row mx-0">
        <div class="col-md-12">
            <h1 class="text-center">Abona2</h1>
            <h3 class="text-center">Gestión en el proceso membresias</h3>
        </div>
    </div>
    <div class="row mx-0">
        <div class="col-md-2">
            <div class="card border-success mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Membresias actuales: <h1 class="text-success"><?php echo $members ?> <i
                                class="fas fa-user-friends"></i></h1>
                    </h5>
                    <a href="?page=members-management" class="btn btn-light btn-sm">Explorar</a>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-warning mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Pendientes de pago: <h1 class="text-warning"><?php echo $pay_pending ?> <i
                                class="fas fa-money-bill-alt"></i></h1>
                    </h5>
                    <a href="?page=pending-pay-management" class="btn btn-light btn-sm">Solicitar pago</a>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-info mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Pendientes de aprobación: <h1 class="text-info">
                            <?php echo $register_complete?> <i class="fas fa-user-clock"></i></h1>
                    </h5>
                    <a href="?page=pending-approve-management" class="btn btn-light btn-sm">Brindar resolución</a>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-primary mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Usuarios pre registrados: <h1 class="text-primary">
                            <?php echo $pre_register ?> <i class="fas fa-user-edit"></i></h1>
                    </h5>
                    <a href="?page=pre-members-management" class="btn btn-light btn-sm">Enviar correo</a>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-danger mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Usuarios rechazados: <h1 class="text-danger"><?php echo $rejected_members ?>
                            <i class="fas fa-user-alt-slash"></i></h1>
                    </h5>
                    <a href="?page=rejected-members-management" class="btn btn-light btn-sm">Más información</a>
                </div>
            </div>
        </div>
    </div>
    <?php 
    $post_list = get_posts( array(
        'post_type' => 'product'
    ) );
    $membership = $wpdb->prefix . 'abona2_'. 'membership_type';
    $individual = $wpdb->get_var( 
        $wpdb->prepare("SELECT product_id FROM $membership WHERE description = %s ORDER BY id DESC",'INDIVIDUAL') 
    );
    $institucional = $wpdb->get_var( 
        $wpdb->prepare("SELECT product_id FROM $membership WHERE description = %s ORDER BY id DESC",'INSTITUCIONAL') 
    );
    $individual = $individual+0;
    $institucional = $institucional+0;

    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <label for="exampleFormControlSelect1">Seleccionar membresía individual</label>
                    </div>
                    <div class="card-subtitle text-muted">
                        <small>(Guardar el tipo de membresía que debe comprar el usuario, al momento de estar pendiente de pago)</small>
                    </div>
                <form class="">
                    <div class="form-group">
                        <select class="form-control form-control-lg" id="membresiaIndividual">
                            <?php 
                            if($individual == 0){
                                echo '<option value="" selected disabled>No hay productos relacionados</option>';
                            }
                            foreach ( $post_list as $key => $post ) {
                                if($post->ID == $individual){
                                    echo '<option value="'.$post->ID.'" selected="selected">'.$post->post_name.'</option>';
                                }else{
                                    echo '<option value="'.$post->ID.'">'.$post->post_name.'</option>';
                                }
                             }
                            ?>
                        </select>
                    </div>
                </form>
                <button type="button" onclick="guardarMembresia(1)" class="btn btn-primary mb-2">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <label for="exampleFormControlSelect1">Seleccionar membresía institucional</label>
                    </div>
                    <div class="card-subtitle text-muted">
                        <small>(Guardar el tipo de membresía que debe comprar el usuario, al momento de estar pendiente de pago)</small>
                    </div>
                <form class="">
                    <div class="form-group">
                        <select class="form-control form-control-lg" id="membresiaInstitucional">
                        <?php 
                            if($institucional == 0){
                                echo '<option value="" selected disabled>No hay productos relacionados</option>';
                            }
                            foreach ( $post_list as $key => $post ) {
                                if($post->ID == $institucional){
                                    echo '<option value="'.$post->ID.'" selected>'.$post->post_name.'</option>';
                                }else{
                                    echo '<option value="'.$post->ID.'">'.$post->post_name.'</option>';
                                }
                             }
                            ?>
                        </select>
                    </div>
                </form>
                <button type="button" onclick="guardarMembresia(2)" class="btn btn-primary mb-2">Guardar</button>
                </div>
            </div>
        </div>
    </div>