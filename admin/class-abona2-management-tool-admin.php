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
		$result = $wpdb->get_results("CALL get_user_for_approval('$id_user')");
		
		wp_json_encode($result);
	
		wp_die();
	}

}
