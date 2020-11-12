<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://chiledevelopers.com
 * @since      1.0.0
 *
 * @package    Abona2_Management_Tool
 * @subpackage Abona2_Management_Tool/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Abona2_Management_Tool
 * @subpackage Abona2_Management_Tool/public
 * @author     Felipe Andrade <f.andradevalenzuela@gmail.com>
 */
class Abona2_Management_Tool_Public {
	

	public $arrContextOptions=array(
		"ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		),
	); 

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		
		if(is_page("pre-register") || is_page( "completar-credenciales" )) {
			// wp_enqueue_style( "sweetalert", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/css/sweetalert.css', array(), $this->version, 'all' );
			wp_enqueue_style( "fontawesome", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/css/fontawesome.all.css', array(), $this->version, 'all' );
			wp_enqueue_style( "bootstrap", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/css/bootstrap.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/abona2-management-tool-public.css', array(), $this->version, 'all' );
			wp_enqueue_style( "alertify", plugin_dir_url( __FILE__ ) . 'css/alertify.min.css', array(), $this->version, 'all' );
		}
		

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if(is_page("pre-register") || is_page( "completar-credenciales" )) {
			wp_enqueue_script( "bootstrap-js", ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . 'assets/js/bootstrap.min.js', array(), $this->version, 'all' );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/abona2-management-tool-public.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "axios-js", plugin_dir_url( __FILE__ ) . 'js/axios.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( "alertify-js", plugin_dir_url( __FILE__ ) . 'js/alertify.min.js', array( 'jquery' ), $this->version, false );
		}

		if (is_page("pre-register")) {
			wp_enqueue_script( "pre-register-js", plugin_dir_url( __FILE__ ) . 'js/pre-register.js', array( 'jquery' ), $this->version, false );
		}
		if (is_page("completar-credenciales")) {
			wp_enqueue_script( "completar-credenciales-js", plugin_dir_url( __FILE__ ) . 'js/completar-credenciales.js', array( 'jquery' ), $this->version, false );
		}

		wp_localize_script($this->plugin_name,'abona2_user', array(
			"name" => "Abona2",
			"author" => "Felipe Andrade",
			'ajaxurl' => admin_url('admin-ajax.php')
		));
		

	}

	public function insert_user_data() {

		global $wpdb;

		//get del formulario
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$rut = $_POST['rut'];
		$correo = $_POST['mail'];
		$comment = $_POST['comment'];
		$terms = $_POST['terms'];
		$vinc = $_POST['vinculo'];
		$asunto = 'Pre registro SCCC';
		$member_type = $_POST['memberType'];

		$this->verificarCorreo($correo); 
		$this->verificarRut($rut);

		//se intenta realizar el insert
		try{ 
			$member_table = $wpdb->prefix. 'abona2_'."pre_register_member";
			$validation_table = $wpdb->prefix. 'abona2_'."validation_email";

			$wpdb->query(
				$wpdb->prepare("INSERT INTO $member_table ( nombre, apellido, rut, email,observaciones, vinculo_id, terms, member_type) 
				VALUES ( %s, %s, %s, %s,%s, %d, %s, %d)",$firstname,$lastname,$rut,$correo,$comment,$vinc,$terms,$member_type)
			);
			
			$user_id = $wpdb->insert_id;

			$wpdb->query(
				$wpdb->prepare("INSERT INTO $validation_table (userId, token, estado) 
				VALUES ( %d, UUID(), b'0')",$user_id)
			);
		
			$token_id = $wpdb->insert_id;

			$token = $wpdb->get_var( 
				$wpdb->prepare("SELECT token FROM $validation_table WHERE id= %d",$token_id) 
			);
			
		} catch(RuntimeException $e){ 
			wp_send_json_error( $e, 400 );
			wp_die();
		}
	
		//se crea un arreglo que contiene las variables que le pasaremos al template
		$variables = array();
		$variables['nombre'] = $firstname;
		$variables['apellido'] = $lastname;
		$variables['token'] = $token;
		$variables['url'] = get_home_url();

		$template = file_get_contents(ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . "assets/mails/confirmar-correo.html", false, stream_context_create($this->arrContextOptions));
		foreach($variables as $key => $value)
			{
				$template = str_replace('{{ '.$key.' }}', $value, $template);
			}

		$to = $correo;
		$subject = $asunto;
		$body = $template;
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[] = 'From: Sociedad Chilena de Ciencia de la Computación <contacto@nube.site>';
		
			wp_mail( $to, $subject, $body, $headers );

			$respuesta =  array(
				'mensaje'=>'El usuario fue pre registrado exitosamente',
				'code' => '200',
				'firstname' => $firstname,
				'lastname' => $lastname
			);
			wp_send_json( $respuesta, 200 );
			wp_die();
		

	}

	public function update_user_data() {

		global $wpdb;
		$problemas = [];
		// Get form
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$title = $_POST['title'];
		$institution = $_POST['institution'];
		$secondMail = $_POST['secondMail'];
		$workPosition = $_POST['workPosition'];
		$token = $_POST['token'];
		$grade = $_POST['grade'];
	
		$this->verificarToken($token);
		$this->verificarCorreo($secondMail);

		try{ 
			$member_table = $wpdb->prefix. 'abona2_'."pre_register_member";
			$validation_table = $wpdb->prefix. 'abona2_'."validation_email";
			$file_table = $wpdb->prefix. 'abona2_'."file_user";

			$prepared_validation_qry = $wpdb->prepare("SELECT userId,id FROM $validation_table where token = %s",$token);
			$validation_data = $wpdb->get_results($prepared_validation_qry);

			
			$obj_validation = get_object_vars($validation_data[0]);
			$user_id = $obj_validation['userId'];
			$token_id = $obj_validation['id'];


			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$ext = array_search(
				$finfo->file($_FILES['inputFile']['tmp_name']),
				array(
					'pdf' => 'application/pdf'
				),true);

			$file_encrypt = sha1_file($_FILES['inputFile']['tmp_name']).$user_id.".".$ext;
			$uploads_dir = trailingslashit( wp_upload_dir()['baseurl'] ) . 'member-attachments/';
			$filenameDestination =   sprintf($uploads_dir.'/%s',$file_encrypt);
			$file_url = sprintf(trailingslashit( wp_upload_dir()['baseurl'] ). 'member-attachments/'.'%s',$file_encrypt);
			$destination_folder = $_SERVER['DOCUMENT_ROOT'].'/sccc-dev/wp-content/uploads/member-attachments/'.$file_encrypt;
			// $destination_folder = '/home/nube/public_html/wp-content/uploads/member-attachments/'.sha1_file($_FILES['inputFile']['tmp_name']).".".$ext; PRODUCTIVO
			
			// $newfname = $destination_folder .sha1_file($_FILES['inputFile']['tmp_name']).$ext; //set your file ext
			// $url = get_site_url();
			// $fullUrl = $url.$uploads_dir.$_FILES['inputFile']['tmp_name'].$ext;

			// $uploaded_file = wp_handle_upload($_FILES['input_file'], array('test_form' => false));

			// if ( $uploaded_file && ! isset( $uploaded_file['error'] ) ) {
			// 	echo __( 'File is valid, and was successfully uploaded.', 'textdomain' ) . "\n";
  			// 	  var_dump( $uploaded_file );
			// }else{
			// 	echo $uploaded_file['error'];
			// }
			// Debemos nombrarlo de manera unica
			// NO USAR $_FILES['inputFile']['name'] SIN NINGUNA VALIDACION !!
			// En este ejemplo, obtenemos un unico nombre seguro desde su data binaria.
			if (!move_uploaded_file(
				$_FILES['inputFile']['tmp_name'],$destination_folder)) 
			{
				wp_send_json_error('Fallo al intentar mover el archivo subido', 400 );
				wp_die();
			}

			$prepared_user_qry = $wpdb->prepare("SELECT email,nombre,apellido FROM $member_table where id = %d",$user_id);
			$user_data = $wpdb->get_results($prepared_user_qry);
			
			$obj_user = get_object_vars($user_data[0]);
			$user_email = $obj_user['email'];
			$user_name = $obj_user['nombre'];
			$user_lastname = $obj_user['apellido'];

			
			$prepared_user_update_qry = $wpdb->prepare(
				"UPDATE $member_table SET direccion = %s, telefono = %s, titulo = %s, institucion = %s, secondMail = %s, cargo = %s, grade_id = %d, estado_id=2 WHERE id = %d",
				$address,$phone,$title,$institution,$secondMail,$workPosition,$grade,$user_id);
			$user_data = $wpdb->query($prepared_user_update_qry);

			$prepared_file_qry = $wpdb->prepare("INSERT INTO $file_table (userId,tokenId, filenameEncrypt) VALUES (%d,%d,%s);",$user_id,$token_id,$filenameDestination);
			$wpdb->query($prepared_file_qry);

			$wpdb->query(
				$wpdb->prepare("UPDATE $validation_table SET estado = 1 WHERE userId = %d",$token_id)
			);
			
		} catch(RuntimeException $e){ 
			wp_send_json_error( $e, 400 );
			wp_die();
		}

		//variables correo usuario
		$variables = array();
		$variables['nombre'] = $user_name;
		$variables['apellido'] = $user_lastname;
			$template = file_get_contents(ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . "assets/mails/registro-completado.html", false, stream_context_create($this->arrContextOptions));
			foreach($variables as $key => $value)
				{
					$template = str_replace('{{ '.$key.' }}', $value, $template);
				}
			$this->correoCompleto($user_email,$template,$user_name,$user_lastname);
	
			$get_all_usr_data =	$wpdb -> get_results("CALL get_user_for_approval($user_id);");
			$obj_all_user = get_object_vars($get_all_usr_data[0]);

			//Variables correo admin
			$variablesAdmin = array();
			$variablesAdmin['id'] = $user_id;
			$variablesAdmin['nombre'] = $obj_all_user['nombre'];
			$variablesAdmin['apellido'] = $obj_all_user['apellido'];
			$variablesAdmin['rut'] = $obj_all_user['rut'];
			$variablesAdmin['correo'] = $obj_all_user['email'];
			$variablesAdmin['telefono'] = $obj_all_user['telefono'];
			$variablesAdmin['grado'] = $obj_all_user['grado'];
			$variablesAdmin['titulo'] = $obj_all_user['titulo'];
			$variablesAdmin['institucion'] = $obj_all_user['institucion'];
			$variablesAdmin['vinculo'] = $obj_all_user['vinculo'];
			// $variablesAdmin['archivo'] = 	get_home_url().$obj_all_user['pathDoc'];
			$variablesAdmin['archivo'] = 	$file_url;
			$variablesAdmin['dirección'] = $obj_all_user['direccion'];
			$variablesAdmin['observaciones'] = $obj_all_user['observaciones'];
			$variablesAdmin['fechaCreacion'] = $obj_all_user['createDate'];
			$variablesAdmin['fechaModificacion'] = $obj_all_user['modificationDate'];
			$variablesAdmin['url'] = get_home_url();
	
			$templateAdmin = file_get_contents(ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . "assets/mails/nuevo-usuario.html", false, stream_context_create($this->arrContextOptions));
			foreach($variablesAdmin as $key => $value)
				{
					$templateAdmin = str_replace('{{ '.$key.' }}', $value, $templateAdmin);
				}
	
			$email_table = $wpdb->prefix. 'abona2_'."email_configuration";

			$to = 'contacto@nube.site';
			$subject = 'Un nuevo usuario completo su perfil';
			$body = $templateAdmin;
			$headers = array('Content-Type: text/html; charset=UTF-8');
			$headers[] = 'From: Sociedad Chilena de Ciencia de la Computación <contacto@nube.site>';
			
			$prepared_email_qry = $wpdb->prepare("SELECT email, nombre FROM $email_table WHERE status = %d",1);
			$datos_email_config = $wpdb->get_results($prepared_email_qry,ARRAY_A);
			foreach($datos_email_config as $element)
			{
			$headers[] = 'Cc: '.$element['nombre'].' <'.$element['email'].'>';
			}

			wp_mail( $to, $subject, $body, $headers );

				$respuesta =  array(
					'mensaje'=>'El usuario fue registrado exitosamente',
					'code' => '200',
					'firstname' => $user_name,
					'lastname' => $user_lastname
				);
		
				wp_send_json( $respuesta, 200 );
				wp_die();

	}

	public function get_token() {
	
		global $wpdb;
		$correo = $_POST['correo'];
		$asunto = 'Solicitud de token SCCC';
		$this->verificarCorreoToken($correo);
	
		try{ 

			$member_table = $wpdb->prefix. 'abona2_'."pre_register_member";
			$validation_table = $wpdb->prefix. 'abona2_'."validation_email";

			$prepared_user_qry = $wpdb->prepare("SELECT id,nombre,apellido FROM $member_table WHERE email = %s",$correo);
			$datos_usuario = $wpdb->get_results($prepared_user_qry,ARRAY_A);

			$obj_usuario = $datos_usuario[0];
			$user_id = $obj_usuario['id'];
			$user_name = $obj_usuario['nombre'];
			$user_lastname = $obj_usuario['apellido'];

			$wpdb->query(
				$wpdb->prepare("UPDATE $validation_table SET estado = 1 WHERE userId = %d",$user_id)
			);

			$wpdb->query(
				$wpdb->prepare("INSERT INTO $validation_table (userId, token, estado) 
				VALUES ( %d, UUID(), b'0')",$user_id)
			);

			$token_id = $wpdb->insert_id;

			$token = $wpdb->get_var( 
				$wpdb->prepare("SELECT token FROM $validation_table WHERE id= %d",$token_id) 
			);
			
		} catch(Exception $e){ 
			wp_send_json_error( $e, 400 );
			wp_die();
		}
		
		$variables = array();
		$variables['nombre'] = $user_name;
		$variables['apellido'] = $user_lastname;
		$variables['token'] = $token;
		$variables['url'] = get_home_url();
		
		$template = file_get_contents(ABONA2_MANAGEMENT_TOOL_PLUGIN_URL . "assets/mails/solicitud-token.html", false, stream_context_create($this->arrContextOptions));
		foreach($variables as $key => $value)
			{
				$template = str_replace('{{ '.$key.' }}', $value, $template);
			}

		$to = $correo;
		$subject = $asunto;
		$body = $template;
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[] = 'From: Sociedad Chilena de Ciencia de la Computación <contacto@nube.site>';
		wp_mail( $to, $subject, $body, $headers );

		$respuesta =  array(
			'mensaje'=>'La solicitud de token fue enviada de manera exitosa',
			'code' => '200',
			'firstname' => $user_name,
			'lastname' => $user_lastname
		);
		wp_send_json( $respuesta, 200 );
		wp_die();
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

	function verificarCorreoToken($correo){
		global $wpdb;
		$member_table = $wpdb->prefix . 'abona2_'. "pre_register_member";
		$prepare_query = $wpdb->prepare("SELECT COUNT(*) FROM $member_table WHERE email = %s",$correo);
		$getMail = $wpdb->get_var($prepare_query);

		if( $getMail == 0 ){
			$error = "El correo que intenta utilizar no esta asociado a un usuario";
			wp_send_json_error( $error, 400 );
			wp_die();
		}
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

	function verificarToken($token){
		global $wpdb;
		$validation_table = $wpdb->prefix. 'abona2_'."validation_email";
		$prepare_query = $wpdb->prepare("SELECT COUNT(*) FROM $validation_table WHERE token = %s AND estado = 0",$token);
		$getToken =  $wpdb->get_var($prepare_query);

		if($getToken == 0) {
			$error = "Token invalido o vencido";
			wp_send_json_error( $error, 400 );
			wp_die();
		}
	}

	function correoCompleto($user_email,$template,$user_name,$user_lastname){
		$to = $user_email;
		$subject = 'Registro Completo';
		$body = $template;
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$headers[] = 'From: Sociedad Chilena de Ciencia de la Computación <contacto@nube.site>';
		$headers[] = 'Cc: '.$user_name.' '. $user_lastname.' <'.$user_email.'>';
			wp_mail( $to, $subject, $body, $headers );
	}

}
