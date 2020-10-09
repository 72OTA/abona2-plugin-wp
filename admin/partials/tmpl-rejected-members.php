
<div class="wrap">
  <h3>Usuarios rechazados   
      <i class="fas fa-users-slash"></i>
</h3> 
  <br>
  <table class="table" id="datatable-abona2">
    <thead class="thead-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">RUT</th>
        <th scope="col">Titulo</th>
        <th scope="col">Telefono</th>
        <th scope="col">Correo</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
    <?php
      global $wpdb;
      $table_name = $wpdb->prefix . 'abona2_'. 'pre_register_member';
      $result = $wpdb->get_results("SELECT * FROM $table_name WHERE estado_id = 3");
      foreach ($result as $print) {
        echo "
          <tr>
            <td>$print->id</td>
            <td>$print->nombre  $print->apellido</td>
            <td>$print->rut</td>
            <td>$print->titulo</td>
            <td><a href='tel:".$print->telefono."'>$print->telefono</a></td>
            <td><a href='mailto:".$print->email."'>$print->email</a></td>
            <td width='25%'><button class='btn btn-info' onclick='getUserData($print->id,3)'>Información</button><a class='btn btn-danger' href='admin.php?page=abona2/Abonados.php&del=$print->id'>Eliminar</a></td>
          </tr>
        ";
      }
    ?>
    </tbody>
    <tfoot class="thead-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Nombre</th>
        <th scope="col">RUT</th>
        <th scope="col">Titulo</th>
        <th scope="col">Telefono</th>
        <th scope="col">Correo</th>
        <th scope="col">Acciones</th>
      </tr>
    </tfoot>
  </table>
  <br>
  <a href="?page=abona2-management-tool" class="btn btn-light btn-sm">Volver al dashboard</a>
  <br>
  <div class="modal" id="loadingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered d-flex justify-content-center" role="document">
        <div class="spinner-border" role="status">
            <span class="sr-only">Cargando...</span>
        </div>
    </div>
</div>
</div>