<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://chiledevelopers.com
 * @since      1.0.0
 *
 * @package    Abona2_Management_Tool
 * @subpackage Abona2_Management_Tool/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Abona2_Management_Tool
 * @subpackage Abona2_Management_Tool/includes
 * @author     Felipe Andrade <f.andradevalenzuela@gmail.com>
 */

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

class Abona2_Management_Tool_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		(new self)->drop_something('abona2_vinculo_type','TABLE');
		(new self)->drop_something('abona2_grade_type','TABLE');
		(new self)->drop_something('abona2_pre_register_member','TABLE');
		(new self)->drop_something('abona2_file_user','TABLE');
		(new self)->drop_something('abona2_validation_email','TABLE');
		(new self)->drop_something('abona2_estado_type','TABLE');

		(new self)->drop_something('get_user_for_approval','PROCEDURE');
		(new self)->drop_something('get_pre_user','PROCEDURE');
		(new self)->drop_something('change_token_status','PROCEDURE');

		(new self)->drop_something('change_token_status_recurring','EVENT');
		(new self)->drop_something('change_token_status_recurring','EVENT');
		
		(new self)->drop_something('update_time','TRIGGER');
		(new self)->drop_something('update_time_token','TRIGGER');
		(new self)->drop_something('update_time_user','TRIGGER');
		(new self)->drop_something('validation_timelapse','TRIGGER');
		
		(new self)->delete_pages('pre-register');
		(new self)->delete_pages('completar-credenciales');
	}

	public function drop_something($nombre,$tipo) {
		global $wpdb;
		$wpdb->query("SET FOREIGN_KEY_CHECKS=0;");
		if($tipo == 'TABLE') {
			//contiene el prefijo de la tabla a dropear
			$delete = "DROP $tipo IF EXISTS $wpdb->prefix$nombre";
		}else {
			//dropea Events, SP, Triggers
			$delete = "DROP $tipo IF EXISTS $nombre";
		}
		$wpdb->query($delete);
		$wpdb->query("SET FOREIGN_KEY_CHECKS=1;");
	}

	public function delete_pages($name) {
		global $wpdb;
		$get_data = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT ID from ".$wpdb->prefix."posts WHERE post_name = %s",
				$name
			)
		);

		$page_id = $get_data->ID;

		if($page_id > 0) {
			wp_delete_post($page_id, true);
		}
	}

}
