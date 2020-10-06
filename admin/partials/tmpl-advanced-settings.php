<?php

global $wpdb;
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