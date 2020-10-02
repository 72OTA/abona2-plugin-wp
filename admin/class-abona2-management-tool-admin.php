<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://chiledevelopers.com
 * @since      1.0.0
 *
 * @package    Abona2_Management_Tool
 * @subpackage Abona2_Management_Tool/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Abona2_Management_Tool
 * @subpackage Abona2_Management_Tool/admin
 * @author     Felipe Andrade <f.andradevalenzuela@gmail.com>
 */

class Abona2_Management_Tool_Admin {
	public $arrContextOptions=array(
		"ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		),
	); 

	public $valid_pages = array("abona2-management-tool","members-management","pending-approve-management","pending-pay-management","pre-members-management","rejected-members-management");

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Abona2_Management_Tool_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Abona2_Management_Tool_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : "";

		if(in_array($page,$this->valid_pages)){
			wp_enqueue_style( "bootstrap", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/css/bootstrap.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( "datatables", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/css/jquery.dataTables.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( "sweetalert", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/css/sweetalert.css', array(), $this->version, 'all' );
			wp_enqueue_style( "fontawesome", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/css/fontawesome.all.css', array(), $this->version, 'all' );
			wp_enqueue_style( "alertify", plugin_dir_url( __FILE__ ) . 'css/alertify.min.css', array(), $this->version, 'all' );
		}
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/abona2-management-tool-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Abona2_Management_Tool_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Abona2_Management_Tool_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : "";

		if(in_array($page,$this->valid_pages)){
			wp_enqueue_script("jquery");
			wp_enqueue_script( "abona2-js", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/abona2.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "bootstrap-js", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "popper-js", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/popper.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "datatables-js", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "sweetalert-js", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/sweetalert.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "validate-js", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/jquery.validate.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/abona2-management-tool-admin.js', array( 'datatables-js' ), $this->version, false );
			wp_enqueue_script( "alertify-js", plugin_dir_url( __FILE__ ) . 'js/alertify.min.js', array( 'jquery' ), $this->version, false );
			wp_localize_script($this->plugin_name,'abona2_vars', array(
				"name" => "Abona2",
				"author" => "Felipe Andrade",
				'ajaxurl' => admin_url('admin-ajax.php')
			));
		}


	}

	public function abona2_management_menu() {
		
		add_menu_page( 
			"Abona2", 
			"Abona2", 
			"manage_options", 
			"abona2-management-tool", 
			array($this, "abona2_management_plugin"),
			"dashicons-admin-users", 
			58
		);

		add_submenu_page(
			"abona2-management-tool", 
			'Dashboard SCCC',
			'Dashboard',
			'manage_options',
			'abona2-management-tool',
			array($this, "abona2_management_plugin")
		);

		add_submenu_page(
			"abona2-management-tool", 
			'Miembros SCCC',
			'Miembros',
			'manage_options',
			'members-management',
			array($this, "abona2_member_management")
		);

		add_submenu_page(
			"abona2-management-tool", 
			'Pendientes SCCC',
			'Pendientes de pago',
			'manage_options',
			'pending-pay-management',
			array($this, "abona2_pending_pay_management")
		);

		add_submenu_page(
			"abona2-management-tool", 
			'Pendientes SCCC',
			'Pendientes de aprobación',
			'manage_options',
			'pending-approve-management',
			array($this, "abona2_pending_approbe_management")
		);

		add_submenu_page(
			"abona2-management-tool", 
			'Pre registrados SCCC',
			'Pre registrados',
			'manage_options',
			'pre-members-management',
			array($this, "abona2_pre_member_management")
		);

		add_submenu_page(
			"abona2-management-tool", 
			'Rechazados SCCC',
			'Rechazados',
			'manage_options',
			'rejected-members-management',
			array($this, "abona2_rejected_member_management")
		);
	}
	
	//funcion callback del menu
	public function abona2_management_plugin(){
		global $wpdb;
		// //obtiene solo 1 resultado a una variable
		// $display_name = $wpdb->get_var("SELECT display_name FROM sccc_users");
		// //obtiene una fila desde la query con prepare para evitar SQL injection
		// $usuario = $wpdb->get_row(
		// 	$wpdb->prepare("SELECT * FROM sccc_users WHERE ID = %d", 1), ARRAY_A
		// );
		// //todas las columna de una tabla seleccionadas en la query
		// $user_names = $wpdb->get_col("SELECT display_name FROM sccc_users");
		// //obtiene todos los resultados predefinidos en la query
		// $users_all = $wpdb->get_results("SELECT * FROM sccc_users", ARRAY_A);
		ob_start();//start buffer
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-dashboard.php");
		
		$template = ob_get_contents();//leer contenido
		
		ob_end_clean();//cerar y limpiar buffer
		echo $template;
	}

	public function abona2_member_management() {
		ob_start();//start buffer
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-members.php");
		
		$template = ob_get_contents();//leer contenido
		
		ob_end_clean();//cerar y limpiar buffer
		echo $template;
	}
	
	public function abona2_pending_pay_management() {
		ob_start();
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-pending-pay-members.php");
		
		$template = ob_get_contents();
		
		ob_end_clean();
		echo $template;
	}

	public function abona2_pending_approbe_management() {
		$this->getFromView();
		ob_start();
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-pending-approbe-members.php");
		
		$template = ob_get_contents();
		
		ob_end_clean();
		echo $template;
	}

	public function abona2_pre_member_management() {
		ob_start();
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-pre-register-members.php");
		
		$template = ob_get_contents();
		
		ob_end_clean();
		echo $template;
	}

	public function abona2_rejected_member_management() {
		ob_start();
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-rejected-members.php");
		
		$template = ob_get_contents();
		
		ob_end_clean();
		echo $template;
	}

	public function get_user_data() {
		//handler ajax request
		global $wpdb;
		$id_user = $_POST['id_user'];
		$result = $wpdb->get_results("CALL get_user_for_approval('$id_user')",ARRAY_A);
		
		wp_send_json($result,200);
		// var_dump($result[0]);
		wp_die();
	}

	public function getFromView() {
		if (isset($_GET['userId'])) {
			$userId = $_GET['userId'];
			  echo '<script>getUserData('.$userId.',1)</script>';
		  }
		// if (isset($_GET['approve'])) {
		// $wpdb->query("UPDATE $table_name SET pendiente = 1 WHERE id='$approve_id'");
		// echo "<script>location.reload()";
		// }
		// if (isset($_GET['reject'])) {
		// $reject_id = $_GET['reject'];
		// $wpdb->query("UPDATE $table_name SET pendiente = -1 WHERE id='$reject_id'");
		// echo "<script>location.reload()";
		// }
	}


	public function approbe_user() {
		global $wpdb;
		$member_table = $wpdb->prefix. 'abona2_'."pre_register_member";
		$id_user = $_POST['id_user'];
		$mensaje = $_POST['mensaje'];
		// $wpdb->query("UPDATE $member_table SET estado_id = 4 WHERE id='$id_user'");
		
		$prepared_user_qry = $wpdb->prepare("SELECT id,nombre,apellido,observaciones,email FROM $member_table WHERE id = %s",$id_user);
		$datos_usuario = $wpdb->get_results($prepared_user_qry,ARRAY_A);

		$obj_usuario = $datos_usuario[0];
		$user_id = $obj_usuario['id'];
		$user_name = $obj_usuario['nombre'];
		$user_lastname = $obj_usuario['apellido'];
		$user_email = $obj_usuario['email'];

		$variablesAdmin = array();
		$variablesAdmin['nombre'] = $user_name;
		$variablesAdmin['apellido'] = $user_lastname;
		$variablesAdmin['descripcion'] = $mensaje;
		$variablesAdmin['token'] = $user_id;
		$variablesAdmin['url'] = get_home_url();

		$this->membership_order();
		$templateAdmin = file_get_contents(ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . "assets/mails/aprobado.html", false, stream_context_create($this->arrContextOptions));
		foreach($variablesAdmin as $key => $value)
			{
				$templateAdmin = str_replace('{{ '.$key.' }}', $value, $templateAdmin);
			}

		$to = 'contacto@nube.site';
		$subject = 'SU SOLICITUD FUE APROBADA';
		$body = $templateAdmin;
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[] = 'From: SCCC <contacto@nube.site>';
		$headers[] = 'Cc: '.$user_name.' '.$user_lastname.' <'.$user_email.'>';

		wp_mail( $to, $subject, $body, $headers );

		$respuesta =  array(
			'mensaje'=>'El usuario fue aprobado exitosamente',
			'code' => '200',
			'user_name' => $user_name,
			'user_lastname' => $user_lastname,
			'mensaje' => $mensaje
		);
		
		wp_send_json( $respuesta, 200 );
		wp_die();
	}

	public function reject_user() {
		global $wpdb;
		$member_table = $wpdb->prefix. 'abona2_'."pre_register_member";
		$id_user = $_POST['id_user'];
		$mensaje = $_POST['mensaje'];
		$wpdb->query("UPDATE $member_table SET estado_id = 3 WHERE id='$id_user'");
		
		$prepared_user_qry = $wpdb->prepare("SELECT id,nombre,apellido,observaciones,email FROM $member_table WHERE id = %s",$id_user);
		$datos_usuario = $wpdb->get_results($prepared_user_qry,ARRAY_A);

		$obj_usuario = $datos_usuario[0];
		$user_id = $obj_usuario['id'];
		$user_name = $obj_usuario['nombre'];
		$user_lastname = $obj_usuario['apellido'];
		$user_email = $obj_usuario['email'];

		$variablesAdmin = array();
		$variablesAdmin['nombre'] = $user_name;
		$variablesAdmin['apellido'] = $user_lastname;
		$variablesAdmin['descripcion'] = $mensaje;
		$variablesAdmin['token'] = $user_id;
		$variablesAdmin['url'] = get_home_url();

		$templateAdmin = file_get_contents(ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . "assets/mails/rechazado.html", false, stream_context_create($this->arrContextOptions));
		foreach($variablesAdmin as $key => $value)
			{
				$templateAdmin = str_replace('{{ '.$key.' }}', $value, $templateAdmin);
			}

		$to = 'contacto@nube.site';
		$subject = 'SU SOLICITUD FUE RECHAZADA';
		$body = $templateAdmin;
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[] = 'From: SCCC <contacto@nube.site>';
		$headers[] = 'Cc: '.$user_name.' '.$user_lastname.' <'.$user_email.'>';

		wp_mail( $to, $subject, $body, $headers );

		$respuesta =  array(
			'mensaje'=>'El usuario fue rechazado exitosamente',
			'code' => '200',
			'user_name' => $user_name,
			'user_lastname' => $user_lastname,
			'mensaje' => $mensaje
		);
		
		wp_send_json( $respuesta, 200 );
		wp_die();
	}

	public function membership_order() {
		global $wpdb;


		$membership = $wpdb->prefix . 'abona2_'. 'membership_type';
		$product = $wpdb->get_var( 
			$wpdb->prepare("SELECT product_id FROM $membership WHERE description = %s ORDER BY id DESC",'INDIVIDUAL') 
		);
		$address = array(
				'first_name' => 'Felipe',
				'last_name'  => 'Andrade',
				'company'    => 'UNAB',
				'email'      => 'f.andradevalenzuela@gmail.com',
				'phone'      => '+56986606669',
				'address_1'  => 'Daniel de la vega 0283',
				'address_2'  => '',
				'city'       => 'Santiago',
				'state'      => 'Región metropolitana',
				'postcode'   => '',
				'country'    => 'CL'
			);

		$order = wc_create_order();

		$order->add_product( wc_get_product($product));
		$order->set_address($address,'billing');
		$order->set_address($address,'shipping');

		$order->calculate_totals();

		update_post_meta( $order->id, '_payment_method', 'transbank' );
    	update_post_meta( $order->id, '_payment_method_title', 'Transbank Webpay Plus' );

		$available_gateways = WC()->payment_gateways->get_available_payment_gateways();
		$result = $available_gateways[ 'transbank' ]->process_payment( $order->get_id() );
		// Redirect to success/confirmation/payment page
		// var_dump(esc_url($order->get_checkout_payment_url()));

		if ( $result['result'] == 'success' ) {

			$result = apply_filters( 'woocommerce_payment_successful_result', $result, $order->get_id() );

			// wp_redirect( $result['redirect'] );
			wp_redirect( esc_url($order->get_checkout_payment_url()));
			exit;
		}
	}

	public function get_pre_register_users() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'abona2_'. 'pre_register_member';
		$result = $wpdb->get_results("SELECT * FROM $table_name WHERE estado_id = 2");
		echo wp_send_json($result);
		wp_die();
	}

	public function membership_configuration() {
		global $wpdb;
		$membership = $wpdb->prefix . 'abona2_'. 'membership_type';
		$product_id = $_POST['product_id'];
		$type = $_POST['type'];

		if($type == 1){
			$descripcion = 'INDIVIDUAL';
		}else if($type == 2){
			$descripcion = 'INSTITUCIONAL';
		}
		
		try{
			$wpdb->query(
				$wpdb->prepare("INSERT INTO $membership ( description, product_id) 
				VALUES ( %s, %d)", $descripcion, $product_id)
			);
		} catch(Exception $e){ 
			wp_send_json_error( $e, 400 );
			wp_die();
		}
		$result =  array(
			'mensaje'=>'El usuario fue rechazado exitosamente',
			'code' => '200',
			'status'=> 'success'
		);
		
		wp_send_json($result,200);
		wp_die();
	}

}
