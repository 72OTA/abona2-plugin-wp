<?php

global $wpdb;
    $post_list_products = get_posts( array(
        'post_type' => 'product'
    ) );
    $post_list_pages = get_posts( array(
        'post_type' => 'page'
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

    $url_after_payment = $wpdb->prefix . 'abona2_'. 'url_after_payment';
    $exitosa = $wpdb->get_var( 
        $wpdb->prepare("SELECT page_id FROM $url_after_payment WHERE description = %s ORDER BY id DESC",'EXITOSO') 
    );
    $fallida = $wpdb->get_var( 
        $wpdb->prepare("SELECT page_id FROM $url_after_payment WHERE description = %s ORDER BY id DESC",'FALLIDO') 
    );
    $exitosa = $exitosa+0;
    $fallida = $fallida+0;
    ?>
<hr>
<div class="row mx-0">
    <div class="col-md-12">
        <h1 class="text-center">Abona2</h1>
        <h3 class="text-center">Gestión de parametros avanzados</h3>
    </div>
</div>
<hr>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h4>Parametros de membresias</h4>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <label for="exampleFormControlSelect1">Seleccionar membresía individual</label>
                    </div>
                    <div class="card-subtitle text-muted">
                        <small>(Guardar el tipo de membresía que debe comprar el usuario, al momento de estar pendiente de
                            pago)</small>
                    </div>
                    <form class="">
                        <div class="form-group">
                            <select class="form-control form-control-lg" id="membresiaIndividual">
                                <?php 
                                if($individual == 0){
                                    echo '<option value="" selected disabled>No hay productos relacionados</option>';
                                }
                                foreach ( $post_list_products as $key => $post ) {
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
        <div class="col-md-6">
            <h4>Parametros de URL posterior a pago</h4>
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <label for="exampleFormControlSelect1">Seleccionar Página post compra exitosa</label>
                    </div>
                    <div class="card-subtitle text-muted">
                        <small>(página a la cual el usuario se redirige posterior a una compra exitosa)</small>
                    </div>
                    <form class="">
                        <div class="form-group">
                            <select class="form-control form-control-lg" id="urlExitosa">
                                <?php 
                                if($exitosa == 0){
                                    echo '<option value="" selected disabled>No hay Endpoint relacionado</option>';
                                }
                                foreach ( $post_list_pages as $key => $post ) {
                                    if($post->ID == $exitosa){
                                        echo '<option value="'.$post->ID.'" selected>'.$post->post_name.'</option>';
                                    }else{
                                        echo '<option value="'.$post->ID.'">'.$post->post_name.'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                    <button type="button" onclick="guardarURL(1)" class="btn btn-primary mb-2">Guardar</button>
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
                            <small>(Guardar el tipo de membresía que debe comprar el usuario, al momento de estar pendiente de
                                pago)</small>
                        </div>
                        <form class="">
                            <div class="form-group">
                                <select class="form-control form-control-lg" id="membresiaInstitucional">
                                    <?php 
                                    if($institucional == 0){
                                        echo '<option value="" selected disabled>No hay productos relacionados</option>';
                                    }
                                    foreach ( $post_list_products as $key => $post ) {
                                        if($post->ID == $fallida){
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <label for="exampleFormControlSelect1">Seleccionar Página post compra fallida</label>
                        </div>
                        <div class="card-subtitle text-muted">
                            <small>(página a la cual el usuario se redirige posterior a una compra fallida)</small>
                        </div>
                        <form class="">
                            <div class="form-group">
                                <select class="form-control form-control-lg" id="urlFallida">
                                    <?php 
                                    if($fallida == 0){
                                        echo '<option value="" selected disabled>No hay Endpoint relacionado</option>';
                                    }
                                    foreach ( $post_list_pages as $key => $post ) {
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
                        <button type="button" onclick="guardarURL(2)" class="btn btn-primary mb-2">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
</div>
<hr>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <div class="wrap">
            <h3>Insertar correo de recepción de notificaciones <i class="fas fa-user"></i></h3>
            <br>
            <button class='btn btn-success float-right' onclick='createEmail()'>Agregar correo</button>
            <br>
            <br>
            <table class="table" id="datatable-abona2">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                global $wpdb;
                $table_name = $wpdb->prefix . 'abona2_'. 'email_configuration';
                $result = $wpdb->get_results("SELECT * FROM $table_name");
                foreach ($result as $print) {
                    echo "
                    <tr>
                        <td>$print->id</td>
                        <td>$print->nombre</td>
                        <td><a href='mailto:".$print->email."'>$print->email</a></td>
                        <td>$print->status</td>";
                        if ($print->status == 1) {
                            echo "<td width='25%'><a class='btn btn-info' href='admin.php?page=abona2-settings&desactivar=$print->id'>Desactivar</a><a class='btn btn-danger' href='admin.php?page=abona2-settings&eliminar=$print->id'>Eliminar</a></td>";
                        }else{
                            echo "<td width='25%'><a class='btn btn-info' href='admin.php?page=abona2-settings&activar=$print->id'>Activar</a><a class='btn btn-danger' href='admin.php?page=abona2-settings&eliminar=$print->id'>Eliminar</a></td>";

                        }
                }
                ?>
                </tbody>
                <tfoot class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
        