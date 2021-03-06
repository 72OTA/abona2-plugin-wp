
<div class="wrap">
  <h3>Insertar usuario tradicional <i class="fas fa-user"></i></h3>
  <br>
  <button class='btn btn-success float-right' onclick='createUser(2)'>Agregar usuario</button>
  <br>
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
        <th scope="col">Institución</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody>
    <?php
      global $wpdb;
      $table_name = $wpdb->prefix . 'abona2_'. 'pre_register_member';
      $result = $wpdb->get_results("SELECT * FROM $table_name WHERE create_id = 2");
      foreach ($result as $print) {
        echo "
          <tr>
            <td>$print->id</td>
            <td>$print->nombre  $print->apellido</td>
            <td>$print->rut</td>
            <td>$print->titulo</td>
            <td><a href='tel:".$print->telefono."'>$print->telefono</a></td>
            <td><a href='mailto:".$print->email."'>$print->email</a></td>
            <td>$print->institucion</td>
            <td width='25%'><button class='btn btn-info' onclick='getUserData($print->id)'>Información</button></td>
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
        <th scope="col">Institución</th>
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
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
</div>