
<div class="wrap">
  <h3>Usuarios Individuales Historico <i class="fas fa-user-friends"></i></h3>
  <br>
  <table class="table" id="datatable-abona2">
    <thead class="thead-dark">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">RUT</th>
        <th scope="col">Nombre</th>
        <th scope="col">Correo</th>
        <th scope="col">Institución</th>
        <th scope="col">Teléfono</th>
        <th scope="col">Estado de membresía</th>
      </tr>
    </thead>
    <tbody>
    <?php
      global $wpdb;
      $table_historic = 'abona2_scc_historico';
      $result = $wpdb->get_results("SELECT * FROM $table_historic WHERE tipo_socio = 'Institucional'");
    
      foreach ($result as $print) {
        echo "
          <tr>
            <td>$print->id</td>
            <td>$print->rut</td>
            <td>$print->nombre</td>
            <td><a href='mailto:".$print->email."'>$print->email</a></td>
            <td>$print->institucion</td>
            <td><a href='tel:".$print->telefono."'>$print->telefono</a></td>
            <td>$print->estado_membresia</td>
            ";
      }
    ?>
    </tbody>
    <tfoot class="thead-dark">
      <tr>
      <th scope="col">ID</th>
        <th scope="col">RUT</th>
        <th scope="col">Nombre</th>
        <th scope="col">Correo</th>
        <th scope="col">Institución</th>
        <th scope="col">Teléfono</th>
        <th scope="col">Estado de membresía</th>
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