
<div class="wrap">
  <h3>Miembros actuales <i class="fas fa-user-friends"></i></h3>
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
        <th scope="col">Estado</th>
      </tr>
    </thead>
    <tbody>
    <?php
      global $wpdb;
      $table_name = $wpdb->prefix . 'abona2_'. 'pre_register_member';
      $result = $wpdb->get_results("SELECT * FROM $table_name");
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
            ";
            switch ($print->estado_id) {
              case 1:
                echo "<td>Pre registrado</td>";
                break;
              case 2:
                echo "<td>Pendiente</td>";
                break;
              case 3:
                echo "<td>Rechazado</td>";
                break;
              case 4:
                echo "<td>Pendiente de pago</td>";
                break;
              case 5:
                echo "<td>Miembro</td>";
                break;
              default:
                # code...
                break;
            }
          echo "</tr>
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
        <th scope="col">Pendiente</th>
      </tr>
    </tfoot>
  </table>
  <br>
  <br>
  <div class="modal" id="loadingModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered d-flex justify-content-center" role="document">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
</div>