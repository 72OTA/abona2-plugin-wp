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

	public $valid_pages = array("abona2-insert-traditional","abona2-insert-honorific","all-users-historico","abona2-management-tool","abona2-management-institutional","members-management","pending-approve-management","pending-pay-management","pre-members-management","rejected-members-management","abona2-settings","all-users-management");

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
			wp_enqueue_style( "buttons-datatable", plugin_dir_url( __FILE__ ) . 'css/buttons-datatable.min.css', array(), $this->version, 'all' );
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

			wp_enqueue_script( "jzip-js", plugin_dir_url( __FILE__ ) . 'js/jzip.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "pdfmake-js", plugin_dir_url( __FILE__ ) . 'js/pdfmake.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "vfs-fonts-js", plugin_dir_url( __FILE__ ) . 'js/vfs_fonts.min.js', array( 'jquery' ), $this->version, false );

			wp_enqueue_script( "datatables-js", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "buttons-dt-js", plugin_dir_url( __FILE__ ) . 'js/dataTables.buttons.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "buttons-flash-js", plugin_dir_url( __FILE__ ) . 'js/buttons.flash.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "buttons-html5-js", plugin_dir_url( __FILE__ ) . 'js/buttons.html5.min.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "buttons-print-js", plugin_dir_url( __FILE__ ) . 'js/buttons.print.min.js', array( 'jquery' ), $this->version, false );

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
			'Dashboard SCCC individual',
			'Dashboard individiual',
			'manage_options',
			'abona2-management-tool',
			array($this, "abona2_management_plugin")
		);
		add_submenu_page(
			"abona2-management-tool", 
			'Dashboard SCCC institucional',
			'Dashboard institucional',
			'manage_options',
			'abona2-management-institutional',
			array($this, "abona2_member_management_institutional")
		);
		add_submenu_page(
			'options.php', 
			'Miembros SCCC',
			'Miembros',
			'manage_options',
			'members-management',
			array($this, "abona2_member_management")
		);

		add_submenu_page(
			'options.php', 
			'Pendientes SCCC',
			'Pendientes de pago',
			'manage_options',
			'pending-pay-management',
			array($this, "abona2_pending_pay_management")
		);

		add_submenu_page(
			'options.php', 
			'Pendientes SCCC',
			'Pendientes de aprobación',
			'manage_options',
			'pending-approve-management',
			array($this, "abona2_pending_approbe_management")
		);

		add_submenu_page(
			'options.php', 
			'Pre registrados SCCC',
			'Pre registrados',
			'manage_options',
			'pre-members-management',
			array($this, "abona2_pre_member_management")
		);

		add_submenu_page(
			'options.php', 
			'Rechazados SCCC',
			'Rechazados',
			'manage_options',
			'rejected-members-management',
			array($this, "abona2_rejected_member_management")
		);
		add_submenu_page(
			'options.php', 
			'Todos los usuarios',
			'Todos',
			'manage_options',
			'all-users-management',
			array($this, "abona2_all_users_management")
		);
		add_submenu_page(
			'options.php', 
			'Todos los usuarios historico',
			'Todos historico',
			'manage_options',
			'all-users-historico',
			array($this, "abona2_all_users_historico_individual")
		);
		add_submenu_page(
			"abona2-management-tool", 
			'Opciones avanzadas',
			'Opciones avanzadas',
			'manage_options',
			'abona2-settings',
			array($this, "abona2_advanced_settings")
		);
		add_submenu_page(
			'options.php',
			'Crear usuario tradicional',
			'Crear usuario tradicional',
			'manage_options',
			'abona2-insert-traditional',
			array($this, "abona2_insert_traditional_user")
		);
		add_submenu_page(
			'options.php',
			'Crear usuario honorifico',
			'Crear usuario honorifico',
			'manage_options',
			'abona2-insert-honorific',
			array($this, "abona2_insert_honorific_user")
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
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-dashboard-individual.php");
		
		$template = ob_get_contents();//leer contenido
		
		ob_end_clean();//cerar y limpiar buffer
		echo $template;
	}

	public function abona2_member_management_institutional() {
		ob_start();//start buffer
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-dashboard-institucional.php");
		
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

	public function abona2_all_users_management() {
		ob_start();
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-all-users.php");
		
		$template = ob_get_contents();
		
		ob_end_clean();
		echo $template;
	}

	public function abona2_advanced_settings() {
		ob_start();
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-advanced-settings.php");
		
		$template = ob_get_contents();
		
		ob_end_clean();
		echo $template;
	}

	public function abona2_all_users_historico_individual() {
		ob_start();
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-all-users-historic.php");
		
		$template = ob_get_contents();
		
		ob_end_clean();
		echo $template;
	}

	public function abona2_insert_traditional_user() {
		ob_start();
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-insert-traditional.php");
		
		$template = ob_get_contents();
		
		ob_end_clean();
		echo $template;
	}

	public function abona2_insert_honorific_user() {
		ob_start();
		
		include_once(ABONA2_MANAGEMENT_TOOL_PLUGIN_PATH."/admin/partials/tmpl-insert-honorific.php");
		
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
		$wpdb->query("UPDATE $member_table SET estado_id = 4 WHERE id='$id_user'");
		
		$prepared_user_qry = $wpdb->prepare("SELECT id,nombre,apellido,observaciones,email,telefono,direccion,institucion FROM $member_table WHERE id = %s",$id_user);
		$datos_usuario = $wpdb->get_results($prepared_user_qry,ARRAY_A);

		$obj_usuario = $datos_usuario[0];
		$user_name = $obj_usuario['nombre'];
		$user_lastname = $obj_usuario['apellido'];
		$user_email = $obj_usuario['email'];
		$user_phone = $obj_usuario['telefono'];
		$user_dir = $obj_usuario['direccion'];
		$user_org = $obj_usuario['institucion'];



		$user_order = array();
		$user_order['first_name'] = $user_name;
		$user_order['last_name'] = $user_lastname;
		$user_order['company'] = $user_org;
		$user_order['email'] = $user_email;
		$user_order['phone'] = $user_phone;
		$user_order['address'] = $user_dir;
		$order_resp = $this->membership_order($user_order);

		$variablesAdmin = array();
		$variablesAdmin['nombre'] = $user_name;
		$variablesAdmin['apellido'] = $user_lastname;
		$variablesAdmin['descripcion'] = $mensaje;
		$variablesAdmin['url'] = $order_resp;

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

	public function membership_order(Array $user_order) {
		global $wpdb;


		$membership = $wpdb->prefix . 'abona2_'. 'membership_type';
		$product = $wpdb->get_var( 
			$wpdb->prepare("SELECT product_id FROM $membership WHERE description = %s ORDER BY id DESC",'INDIVIDUAL') 
		);
		$address = array(
				'first_name' => $user_order['first_name'],
				'last_name'  => $user_order['last_name'],
				'company'    => $user_order['company'],
				'email'      => $user_order['email'],
				'phone'      => $user_order['phone'],
				'address_1'  => $user_order['address'],
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

		update_post_meta( $order->get_id(), '_payment_method', 'transbank' );
    	update_post_meta( $order->get_id(), '_payment_method_title', 'Transbank Webpay Plus' );

		$available_gateways = WC()->payment_gateways->get_available_payment_gateways();
		$result = $available_gateways[ 'transbank' ]->process_payment( $order->get_id() );
		// Redirect to success/confirmation/payment page
		$order_url = strval(esc_url($order->get_checkout_payment_url(true)));
		return $order_url;

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
			'mensaje'=>'Producto configurado exitosamente',
			'code' => '200',
			'status'=> 'success'
		);
		
		wp_send_json($result,200);
		wp_die();
	}

	public function endpoint_configuration() {
		global $wpdb;
		$endpoint = $wpdb->prefix . 'abona2_'. 'url_after_payment';
		$page_id = $_POST['page_id'];
		$type = $_POST['type'];

		if($type == 1){
			$descripcion = 'EXITOSO';
		}else if($type == 2){
			$descripcion = 'FALLIDO';
		}
		
		try{
			$wpdb->query(
				$wpdb->prepare("INSERT INTO $endpoint ( description, page_id) 
				VALUES ( %s, %d)", $descripcion, $page_id)
			);
		} catch(Exception $e){ 
			wp_send_json_error( $e, 400 );
			wp_die();
		}
		$result =  array(
			'mensaje'=>'Endpoint configurado exitosamente',
			'code' => '200',
			'status'=> 'success'
		);
		
		wp_send_json($result,200);
		wp_die();
	}

	public function email_configuration() {
		global $wpdb;
		$email_conf = $wpdb->prefix . 'abona2_'. 'email_configuration';
		$email = $_POST['mail'];
		$nombre = $_POST['firstname'];

		
		try{
			$wpdb->query(
				$wpdb->prepare("INSERT INTO $email_conf (email,nombre) 
				VALUES ( %s, %s)", $email,$nombre)
			);
		} catch(Exception $e){ 
			wp_send_json_error( $e, 400 );
			wp_die();
		}
		$result =  array(
			'mensaje'=>'Email configurado exitosamente',
			'code' => '200',
			'status'=> 'success'
		);
		
		wp_send_json($result,200);
		wp_die();
	}

	public function alert_membership( $order_id ) {
		global $wpdb;
		$order = wc_get_order( $order_id );
		$correo = $order->get_billing_email();
		$member_table = $wpdb->prefix. 'abona2_'."pre_register_member";
		$endpoint = $wpdb->prefix . 'abona2_'. 'url_after_payment';

		$prepare_query = $wpdb->prepare("SELECT id FROM $member_table WHERE email = %s",$correo);
		$id_user = $wpdb->get_var($prepare_query);

		try{
			$wpdb->query("UPDATE $member_table SET estado_id = 5 WHERE id='$id_user'");
		} catch(Exception $e){ 
			wp_send_json_error( $e, 400 );
			wp_die();
		}

		$exitoso = $wpdb->get_var( 
			$wpdb->prepare("SELECT page_id FROM $endpoint WHERE description = %s ORDER BY id DESC",'EXITOSO') 
		);
		$fallido = $wpdb->get_var( 
			$wpdb->prepare("SELECT page_id FROM $endpoint WHERE description = %s ORDER BY id DESC",'FALLIDO') 
		);

		$success = get_post($exitoso);
		$fail = get_post($fallido);

		$successUrl = $success->post_name;
		$failUrl = $fail->post_name;


		if ( ! $order->has_status( 'failed' ) ) {
			$url = get_site_url().'/'.$successUrl;
			wp_safe_redirect( $url );
			exit;
		}else if($order->has_status( 'failed' )){
			$url = get_site_url().'/'.$failUrl;
			wp_safe_redirect( $url );
			exit;
		}
		
	}
	
	public function create_user() {
		global $wpdb;
		
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$rut = $_POST['rut'];
		$correo = $_POST['mail'];
		$comment = $_POST['comment'];
		$terms = 'on';
		$vinc = $_POST['vinculo'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$title = $_POST['title'];
		$institution = $_POST['institution'];
		$secondMail = $_POST['secondMail'];
		$workPosition = $_POST['workPosition'];
		$grade = $_POST['grade'];
		$tipo = $_POST['tipo'];
		if($tipo == '2'){
			$tipo = 2;
		}else{
			$tipo = 3;
		}

		$this->verificarCorreo($correo); 
		$this->verificarRut($rut);

		try {
			// Indefinido | Multiples archivos | $_FILES Ataque de corrupción
			// si el request se cae en cualquiera de estos, el request es invalido.
			if (!isset($_FILES['inputFile']['error']) ||
				is_array($_FILES['inputFile']['error'])) 
				{
				wp_send_json_error( 'Archivo con parametros invalidos.', 400 );
				wp_die();
			}
			 // Check $_FILES['inputFile']['error'] value.
			switch ($_FILES['inputFile']['error']) {
			case UPLOAD_ERR_OK:
				break;
			case UPLOAD_ERR_NO_FILE:
				wp_send_json_error( 'No se envio el archivo.', 400 );
				wp_die();
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				wp_send_json_error( 'El archivo excede el tamaño maximo permitido.', 400 );
				wp_die();
			default:
				wp_send_json_error( 'Error desconocido con el archivo.', 400 );
				wp_die();
			}
	
			// NO CONFIAR EN VALORES $_FILES['inputFile']['mime']!!
			// Checkear Tipo MIME uno mimso .
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			if (false === $ext = array_search(
			$finfo->file($_FILES['inputFile']['tmp_name']),
			array(
				'pdf' => 'application/pdf'
			),true)) 
			{
				wp_send_json_error( 'Formato del archivo invalido.', 400 );
				wp_die();
			}
			
		} catch (RuntimeException $e) {
			wp_send_json_error( $e, 400 );
			wp_die();
		}

		try{ 
			$member_table = $wpdb->prefix. 'abona2_'."pre_register_member";
			$validation_table = $wpdb->prefix. 'abona2_'."validation_email";
			$file_table = $wpdb->prefix. 'abona2_'."file_user";

			$wpdb->query(
				$wpdb->prepare("INSERT INTO $member_table ( nombre, apellido, rut, email,observaciones, vinculo_id, terms, direccion, telefono, titulo, institucion, secondMail, cargo, grade_id, estado_id, create_id) 
				VALUES ( %s, %s, %s, %s,%s, %d, %s, %s, %s, %s, %s, %s, %s, %d, %d, %d)",$firstname,$lastname,$rut,$correo,$comment,$vinc,$terms,$address,$phone,$title,$institution,$secondMail,$workPosition,$grade,5,$tipo)
			);
			
			$user_id = $wpdb->insert_id;

			$wpdb->query(
				$wpdb->prepare("INSERT INTO $validation_table (userId, token, estado) 
				VALUES ( %d, UUID(), b'1')",$user_id)
			);
		
			$token_id = $wpdb->insert_id;
			$uploads_dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'member-attachments/';
			$filenameDestination =   sprintf($uploads_dir.'/%s.%s',sha1_file($_FILES['inputFile']['tmp_name']).$user_id,$ext);

			if (!move_uploaded_file(
				$_FILES['inputFile']['tmp_name'],$filenameDestination)) 
			{
				wp_send_json_error('Fallo al intentar mover el archivo subido', 400 );
				wp_die();
			}

			$prepared_file_qry = $wpdb->prepare("INSERT INTO $file_table (userId,tokenId, filenameEncrypt) VALUES (%d,%d,%s);",$user_id,$token_id,$filenameDestination);
			$wpdb->query($prepared_file_qry);

			
		} catch(RuntimeException $e){ 
			wp_send_json_error( $e, 400 );
			wp_die();
		}

		$respuesta =  array(
			'mensaje'=>'El usuario fue creado exitosamente',
			'code' => '200',
		);

		wp_send_json( $respuesta, 200 );
		wp_die();
	}

	function verificarRut($rut){
		global $wpdb;
		$member_table = $wpdb->prefix . 'abona2_'. "pre_register_member";
		$prepare_query = $wpdb->prepare("SELECT COUNT(*) FROM $member_table WHERE rut = %s",$rut);
		$getRut = $wpdb->get_var($prepare_query);

		if( $getRut > 0 ){
			$error = "El rut que intenta utilizar esta asociado a un usuario";
			wp_send_json_error( $error, 400 );
			wp_die();
		}
	}

	function verificarCorreo($correo){
		global $wpdb;
		$member_table = $wpdb->prefix . 'abona2_'. "pre_register_member";
		$prepare_query = $wpdb->prepare("SELECT COUNT(*) FROM $member_table WHERE email = %s",$correo);
		$getMail = $wpdb->get_var($prepare_query);

		if( $getMail > 0 ){
			$error = "El correo que intenta utilizar esta asociado a un usuario";
			wp_send_json_error( $error, 400 );
			wp_die();
		}
	}

}
