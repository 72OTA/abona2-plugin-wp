<?php

/**
 * Fired during plugin activation
 *
 * @link       https://chiledevelopers.com
 * @since      1.0.0
 *
 * @package    Abona2_Management_Tool
 * @subpackage Abona2_Management_Tool/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Abona2_Management_Tool
 * @subpackage Abona2_Management_Tool/includes
 * @author     Felipe Andrade <f.andradevalenzuela@gmail.com>
 */

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

class Abona2_Management_Tool_Activator {
	
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */



	public static function activate() {
		(new self)->tbl_vinculo();
		(new self)->tbl_grade();
		(new self)->tbl_file();
		(new self)->tbl_validation();
		(new self)->tbl_users();
		(new self)->tbl_estatus();
		(new self)->rlt_tables();
		(new self)->page_pre_reg();
		(new self)->page_complete_reg();
		(new self)->create_dir();
	}

	public function tbl_users() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'abona2_'. 'pre_register_member';
		$create = "CREATE TABLE `$table_name` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
			`apellido` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
			`rut` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
			`telefono` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
			`email` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
			`secondMail` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
			`direccion` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
			`titulo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
			`grade_id` int(11) NOT NULL DEFAULT '1',
			`cargo` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
			`institucion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
			`vinculo_id` int(11) NOT NULL,
			`observaciones` longtext COLLATE utf8_spanish_ci,
			`terms` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
			`miembro` tinyint(1) NOT NULL DEFAULT '0',
			`pendiente` tinyint(1) NOT NULL DEFAULT '0',
			`preRegistro` int(11) NOT NULL DEFAULT '1',
			`completarRegistro` int(11) NOT NULL DEFAULT '0',
			`createDate` datetime DEFAULT NULL,
			`modificationDate` datetime DEFAULT CURRENT_TIMESTAMP,
			`estado_id` int(11) NOT NULL DEFAULT '1',
			PRIMARY KEY(id),
			UNIQUE(rut)
		  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla para el pre registro de miembros';";
		
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			dbDelta($create);
		}

	}

	public function tbl_vinculo() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'abona2_'. 'vinculo_type';
		$create = "CREATE TABLE $table_name (
			`vinculo_id` int(11) NOT NULL AUTO_INCREMENT,
			`nombre` varchar(40) NOT NULL,
			PRIMARY KEY(vinculo_id)
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla tipo para verificar tipos de vinculo';";

		$insert = "INSERT INTO $table_name (`vinculo_id`, `nombre`) VALUES
		(1, 'Investigación científica'),
		(2, 'Enseñanza'),
		(3, 'Ejercicio profesional');";

		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			dbDelta($create);
			dbDelta($insert);
		}
	}

	public function tbl_grade() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'abona2_'. 'grade_type';
		$create = "CREATE TABLE $table_name (
			`grade_id` int(11) NOT NULL AUTO_INCREMENT,
			`nombre` varchar(100) NOT NULL,
			PRIMARY KEY(grade_id)
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		$insert = "INSERT INTO $table_name (`grade_id`, `nombre`) VALUES
		(1, 'Estudiante'),
		(2, 'Licenciado'),
		(3, 'Magister'),
		(4, 'Doctorado'),
		(5, 'Post-Doctorado');";

		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			dbDelta($create);
			dbDelta($insert);
		}
	}

	public function tbl_file() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'abona2_'. 'file_user';
		$create = "CREATE TABLE $table_name (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`userId` int(11) NOT NULL,
			`tokenId` int(11) NOT NULL,
			`filenameEncrypt` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
			`creationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY(id)
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			dbDelta($create);
		}
	}

	public function tbl_estatus() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'abona2_'. 'estado_type';
		$create = "CREATE TABLE $table_name (
			`estado_id` int(11) NOT NULL AUTO_INCREMENT,
			`descripcion` varchar(100) NOT NULL,
			PRIMARY KEY(estado_id)
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		$insert = "INSERT INTO $table_name (`estado_id`, `descripcion`) VALUES
		(1, 'PRE REGISTRADO'),
		(2, 'PENDIENTE'),
		(3, 'RECHAZADO'),
		(4, 'PENDIENTE DE PAGO'),
		(5, 'REGISTRO COMPLETO');";

		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			dbDelta($create);
			dbDelta($insert);
		}
	}

	public function tbl_validation() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'abona2_'. 'validation_email';
		$create = "CREATE TABLE $table_name (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`userId` int(11) NOT NULL,
			`token` varchar(250) NOT NULL,
			`tiempo` timestamp NULL DEFAULT NULL,
			`estado` bit(1) NOT NULL DEFAULT b'0',
			`modificationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY(id)
		  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			dbDelta($create);
		}
	}

	public function rlt_tables() {
		global $wpdb;
		$member = $wpdb->prefix . 'abona2_'. 'pre_register_member';
		$grade = $wpdb->prefix . 'abona2_'. 'grade_type';
		$vinculo = $wpdb->prefix . 'abona2_'. 'vinculo_type';
		$validation = $wpdb->prefix . 'abona2_'. 'validation_email';
		$estado = $wpdb->prefix . 'abona2_'. 'estado_type';
		$file = $wpdb->prefix . 'abona2_'. 'file_user';

		$alter_keys = "ALTER TABLE $member
		ADD KEY `vinculo` (`vinculo_id`),
		ADD KEY `grado` (`grade_id`),
		ADD KEY `estado` (`estado_id`);
		ALTER TABLE $validation
		ADD KEY `validation_user` (`userId`);
		ALTER TABLE $file
		ADD KEY `file_user` (`userId`),
		ADD KEY `file_token` (`tokenId`);";

		$alter_constraints = "ALTER TABLE $member
		ADD CONSTRAINT `grade_user` FOREIGN KEY (`grade_id`) REFERENCES $grade (`grade_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
		ADD CONSTRAINT `vinculo_user` FOREIGN KEY (`vinculo_id`) REFERENCES $vinculo (`vinculo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
		ADD CONSTRAINT `estado_user` FOREIGN KEY (`estado_id`) REFERENCES $estado (`estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
		COMMIT;
		ALTER TABLE $validation
		ADD CONSTRAINT `validation_user` FOREIGN KEY (`userId`) REFERENCES $member (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
		COMMIT;
		ALTER TABLE $file
		ADD CONSTRAINT `file_token` FOREIGN KEY (`tokenId`) REFERENCES $validation (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
		ADD CONSTRAINT `file_user` FOREIGN KEY (`userId`) REFERENCES $member (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
		COMMIT;";

		$change_token_status = "CREATE PROCEDURE `change_token_status`() COMMENT 'Update estado de validation token' 
		NOT DETERMINISTIC MODIFIES SQL DATA SQL SECURITY DEFINER 
		UPDATE validation_email set estado = 1 WHERE tiempo < CURRENT_TIMESTAMP;";

		$get_user_for_approval = "CREATE PROCEDURE `get_user_for_approval`(IN `idUsuario` INT(11) UNSIGNED) COMMENT 'SP para obtener los datos del usuario registrado' 
		NOT DETERMINISTIC READS SQL DATA SQL SECURITY DEFINER 
		SELECT DISTINCT 
		usr.nombre, 
		usr.apellido, 
		usr.rut, 
		usr.email, 
		usr.telefono, 
		grado.nombre as grado, 
		usr.titulo, 
		usr.institucion, 
		vinculo.nombre as vinculo, 
		doc.filenameEncrypt as pathDoc, 
		usr.direccion, 
		usr.observaciones, 
		usr.createDate, 
		usr.modificationDate 
		FROM " .$member. " AS usr 
		INNER JOIN " .$grade. " AS grado 
		ON usr.grade_id = grado.grade_id 
		INNER JOIN " .$vinculo. " AS vinculo 
		ON usr.vinculo_id = vinculo.vinculo_id 
		INNER JOIN ". $file. " AS doc 
		ON doc.userId = usr.Id 
		WHERE usr.id = idUsuario;";
		  
		$events = "CREATE EVENT `change_token_status_recurring` 
		ON SCHEDULE EVERY 30 MINUTE 
		ON COMPLETION PRESERVE ENABLE 
		COMMENT 'Vencer tokens' DO CALL change_token_status();";

		$update_time_token = "CREATE TRIGGER `update_time_token` BEFORE UPDATE ON $validation 
		FOR EACH ROW set new.modificationDate = CURRENT_TIMESTAMP + INTERVAL + 3 HOUR;";

		$update_time = "CREATE TRIGGER `update_time` BEFORE UPDATE ON $member 
		FOR EACH ROW set new.modificationDate = CURRENT_TIMESTAMP + INTERVAL 3 HOUR, 
		new.completarRegistro = 1;";

		$validation_time_lapse ="CREATE TRIGGER `validation_timelapse` BEFORE INSERT ON $validation 
		FOR EACH ROW set new.tiempo = CURRENT_TIMESTAMP + INTERVAL + 8 HOUR,
		new.modificationDate = CURRENT_TIMESTAMP + INTERVAL + 3 HOUR;";

		$update_time_user = "CREATE TRIGGER `update_time_user` BEFORE INSERT ON $member 
		FOR EACH ROW set new.createDate = CURRENT_TIMESTAMP + INTERVAL 3 HOUR;";
		
		if ($wpdb->get_var("SHOW TABLES LIKE '$member'") == $member &&
			$wpdb->get_var("SHOW TABLES LIKE '$grade'") == $grade &&
			$wpdb->get_var("SHOW TABLES LIKE '$vinculo'") == $vinculo &&
			$wpdb->get_var("SHOW TABLES LIKE '$validation'") == $validation &&
			$wpdb->get_var("SHOW TABLES LIKE '$file'") == $file) {

		//Algunas querys se llaman directamente desde wbdb->query, ya que al ser procedimientos
		//o triggers estos tienen problematicas al crearse con dbDelta

		//FK
		dbDelta($alter_keys);
		dbDelta($alter_constraints);

		//SP & EVENTS
		dbDelta($change_token_status);
		// dbDelta($get_user_for_approval);
		// dbDelta($events);

		$wpdb->query($events);
		$wpdb->query($get_user_for_approval);

		//Disipadores
		dbDelta($update_time_token);
		dbDelta($update_time);
		$wpdb->query($validation_time_lapse);
		$wpdb->query($update_time_user);
		// dbDelta($validation_time_lapse);
		// dbDelta($update_time_user);
		}
		
		
	}


	public function page_pre_reg() {
		global $wpdb;
		global $user_ID;
		
		$get_data = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM ".$wpdb->prefix."posts WHERE post_name = %s",
				'pre-register'
			)
		);
		$pre_registro = '
								<div class="row">
									<div class="col-md-12">
										<form name="registration" id="registration">
											<div class="form-row row">
												<div class="form-group col-md-6"><label for="firstname">Nombres</label>
													<input class="form-control" name="firstname" id="firstname"
														type="text" placeholder="Mi nombre" required=""></div>
												<div class="form-group col-md-6"><label for="lastname">Apellidos</label>
													<input class="form-control" name="lastname" id="lastname"
														type="text" placeholder="Mi Apellido" required=""></div>
											</div>
											<br>
											<div class="form-row row">
												<div class="form-group col-md-6"><label for="mail">Correo electrónico</label>
													<input class="form-control" name="mail" id="mail" type="text"
														placeholder="ej@domain.cl" required="">
												</div>
												<div class="form-group col-md-6"><label for="rut">RUT</label>
													<input class="form-control" name="rut" id="rut" type="text"
														placeholder="12.345.678-9" required="">
												</div>
											</div>
											<br>
											<div class="form-row row">
												<div class="form-group col-md-12">
													<label class="form-check-label">Vínculo con la Ciencia de la Computación a través de:</label>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="vinculo"
															id="op1" value="1">
														<label class="form-check-label" for="op1">Investigación científica</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="vinculo"
															id="op2" value="2">
														<label class="form-check-label" for="op2">Enseñanza</label>
													</div>
													<div class="form-check form-check-inline">
														<input class="form-check-input" type="radio" name="vinculo"
															id="op3" value="3">
														<label class="form-check-label" for="op3">Ejercicio profesional</label>
													</div>
												</div>
											</div>
											<br>
											<div class="form-row row">
												<div class="form-group col-md-12"><label for="comment">¿Cuál es su motivación para ser miembro de la SCCC?</label>
													<textarea class="form-control" name="comment" id="comment"
														type="text" placeholder="Quiero ser parte de la sccc ya que..."
														rows="3" minlength="200" maxlength="1500"
														required=""></textarea></div>
											</div>
											<br>
											<div class="row">
												<div class="col">
													<input type="checkbox"
														class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
														name="terms" id="terms"><span class="woocommerce-terms-and-conditions-checkbox-text">He leídoy acepto la totalidad de los<button type="button" data-toggle="modal"
															data-target="#termsConditions"
															class="woocommerce-terms-and-conditions-link"
															style="font-weight: bold;">Estatutos de la
															Sociedad Chilena de las Ciencias de la Computación.
														</button> Así como también declaro la veracidad de la información entregada en este formulario de postulación para membresía.*
													</span>
												</div>
											</div>
											<div class="row">
												<div class="col">
													<div class="g-recaptcha" style="margin-left: 30%;"
														data-sitekey="6LfOKbYZAAAAAG45uzyh5iysd0diyr_G1I2B0bU6">
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<button id="registro_credenciales"
											class="btn btn-modern btn-lg btn-gradient btn-full-rounded"
											onclick="form_validation()">Enviar</button>
									</div>
								</div>
								<div class="modal fade" id="termsConditions" tabindex="-1" role="dialog"
									aria-labelledby="termsConditions" aria-hidden="true">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content" style="font-family: sans-serif;">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"
													aria-label="Close">
													<span aria-hidden="true">×</span>
												</button>
											</div>

											<div class="modal-body" style="overflow-y:scroll;">
												<h1 style="text-align: center;">ESTATUTOS</h1>
												<h2 style="text-align: center;">"SOCIEDAD CHILENA DE CIENCIA DE
													LA COMPUTACIÓN"</h2>
												<p>
													EN SANTIAGO DE CHILE, a doce de diciembre de mil novecientos
													ochenta y cuatro, ante mí, SAMUEL FUCHS
													BROTFELD, Abogado, Notario Publico de 18 Novena Notaria de
													este Departamento, Teatinos doscientos
													cincuenta y siete y testigos cuyos nombres al final se
													consignan, comparece: Don PEDRO HEPP KUSCHEL,
													chileno, Ingeniero civil, casado, cédula de identidad número
													ocho millones ochenta y nueve mil
													trescientos cincuenta y seis raya seis de Santiago,
													domiciliado en esta ciudad, calle Las Violetas
													numero dos mil doscientos cuarenta y siete, mayor de edad, a
													quien conozco por su cédula y expone:-
													Que debidamente facultado viene en reducir a escritura
													pública los Estatutos de la "SOCIEDAD CHILENA
													DE CIENCIA DE LA COMPUTACION", que constan del acta de
													sesión número uno del Libro de Actas de dicha
													entidad en formación y que son:- "En Santiago, a cinco de
													Octubre de mil novecientos ochenta y
													cuatro a las trece horas se llevó a efecto la reunión
													convocada para acordar los Estatutos de la
													Persona Jurídica de Derecho Privado denominada Sociedad
													Chilena de la Ciencia de la Computación.
												</p>
												<p>
													Asistieron las personas que se consignes al final de la
													presente acta. Presidió don Pedro Hepp
													Kuschel, actuando como Secretario don Patricio Poblete.
												</p>
												<p>
													Por la unanimidad de los asistentes se acordó la
													constitución de una corporación, persona Jurídica
													de Derecho Privado sin fines de lucro, denominada Sociedad
													Chilena de Ciencia de la Computación,
													cuyos estatutos serán los que se transcriben a
													continuación:- "ESTATUTOS DE LA SOCIEDAD CHILENA DE
													CINCIA DE LA COMPUTACION.
												</p>
												<h3>TITULO PRIMERO.- Nombre, Objeto, domicilio y duración.</h3>
												<p>
													<b>ARTICULO PRIMERO:</b> Constitúyese una Corporación de
													Derecho Privado, bajo el nombre de
													"SOCIEDAD CHILENA DE CIENCIA DE LA COMPUTACION".
												</p>
												<p>
													<b>ARTICULO SEGUNDO: </b>La Corporación se regirá por las
													disposiciones que se contienen en estos
													estatutos y en el silencio de ellos por las normas
													contenidas en el Libro Trigésimo Tercero del
													Libro Primero del Código Civil y en el Decreto Supremo
													número ciento diez del ministerio de Justicia
													publicado en el Diario Oficial de veinte de Marzo de mil
													novecientos setenta y nueve.
												</p>
												<p>
													<b>ARTICUIO TERCERO:</b> la finalidad de la Corporación es
													la de estimular la investigación en el
													campo de la Computación, la divulgación de esta disciplina y
													el contacto con las personas que tengan
													como ocupación la práctica de esta ciencia.
												</p>
												<p>
													Para el cumplimiento de sus objetivos tendrá las siguientes
													funciones:
												</p>
												<ol type="a">
													<li>Organizar reuniones científicas periódicas y fomentar la
														publicación de los trabajos de
														investigación presentados.</li>
													<li>Apoyar la formación de grupos de socios interesados en
														desarrollar áreas específicas de la
														Ciencia de la Computación.</li>
													<li>Propender al mejoramiento de la enseñanza de la Ciencia
														de la Computación en todos los
														niveles y a lo largo del país.</li>
													<li>Mantener relaciones con otras sociedades científicas o
														profesionales de Chile y del
														extranjero y ayudar al intercambio de informaciones.
													</li>
													<li>Asesorar a los organismos gubernamentales o
														internacionales en asuntos o problemas de
														carácter científico en los casos que le sea requerido.
													</li>
													<li>En general, ejecutar todos los actos que sean necesarios
														para el cumplimiento de sus fines,
														la Corporación tendrá en todo caso, carácter
														estrictamente científico, no pudiendo
														proponerse fines gremiales ni de lucro y deberá
														manifestarse ajena a toda discriminación
														política, religiosa, racial y de sexo.</li>
												</ol>
												<p></p>
												<p>
													<b>ARTICULO CUARTO:</b> El domicilio legal de la corporación
													será la ciudad de Santiago, sin perjuicio de las oficinas,
													sedes o agencias que se establezcan en otros lugares.
												</p>
												<p>
													<b>ARTICULO QUINTO:</b> El número de socios será ilimitado y
													la duración de la Corporación indefinida.
												</p>
												<h3>TITULO SEGUNDO.- De los Socios.</h3>
												<p>
													<b>ARTICULO SEXTO:</b> Podrán pertenecer a la Sociedad
													Chilena de Ciencia de la Computación todas aquellas
													personas, cualquiera que sea su residencia o nacionalidad,
													que estén vinculadas a la Ciencia de la Computación a través
													de la investigación científica, la enseñanza o el ejercicio
													profesional. En el caso de estudiantes, se exigirá haber
													cursado estudios superiores regulares durante por lo menos
													dos años académicos.
												</p>
												<p>
													<b>ARTICULO SEPTIMO:</b> Existirán cuatro categorías de
													socios:
												</p>
												<ol type="a">
													<li>
														<b>SOCIOS ACTIVOS:</b> Serán aquellos que suscriban la
														escritura de constitución de la corporación y los que
														habiendo realizado un trabajo de incorporación que haya
														sido aceptado en la Conferencia Anual de la Sociedad,
														soliciten su ingreso mediante una presentación escrita
														dirigida al Presidente de la Corporación.
													</li>
													<li>
														<b>SOCIOS ADHERENTES:</b> Serán aquellos que cumplan con
														el siguiente procedimiento:
														<ol type="1">
															<li>Presentar una solicitud escrita firmada por el
																solicitante, declarando en ella que conoce y
																promete cumplir las exigencias del presente
																estatuto.</li>
															<li>que esta solicitud sea aprobada por el
																Directorio.</li>
														</ol>
													</li>
													<li>
														<b>SOCIOS HONORARIOS:</b> Esta es una categoría,
														honorífica reservada para distinguidos científicos,
														chilenos o extranjeros, que hayan aportado una
														contribución valiosa al desarrollo de la ciencia de la
														Computación en Chile. Será facultad de la Asamblea de
														Socios otorgar esta distinción, a propuesta del
														Directorio.
													</li>
													<li>
														<b>SOCIOS INSTITUCIONALES:</b> Esta es une categoría
														reservada a empresas o instituciones que deseen
														colaborar en la realización de los objetivos de la
														Sociedad. Cada socio institucional deberá designar una
														persona para que lo represente. Este tipo de socios
														tendrá los derechos y obligaciones de un socio
														adherente.
													</li>
												</ol>
												<p></p>
												<p>
													<b>ARTICULO OCTAVO:</b> Son derechos en todos los socios:
												</p>
												<ol type="a">
													<li>Participar en las actividades que desarrolle la
														Sociedad. En aquellas que sean pagadas, tendrán derecho
														a cancelar una cuota rebajada que será determinada por
														el Directorio.</li>
													<li>Recibir la información distribuida por la Corporación.
													</li>
													<li>Hacer uso de los convenios, planes de becas,
														intercambios u otros que defina la Corporación.</li>
													<li>Participar en la Asamblea General de Socios con derecho
														a voz.</li>
												</ol>
												<p></p>
												<p>
													<b>ARTICULO NOVENO:</b> Son derechos de los socios Activos:
												</p>
												<ol type="a">
													<li>Todos aquellos descritos en el articulo octavo.</li>
													<li>Participar en las Asambleas Generales con derecho a voz
														y voto.</li>
													<li>Elegir y ser elegido en los cargos directivos de la
														Corporación.</li>
													<li>Presentar cualquier proyecto o proposición al estudio
														del Directorio o Asamblea General. El Directorio
														decidirá su rechazo o inclusión en la tabla de la
														Asamblea General.</li>
												</ol>
												<p></p>
												<p>
													<b>ARTICULO DECIMO:</b> Son obligaciones de los socios
													activos y adherentes:
												</p>
												<ol type="a">
													<li>Cumplir las disposiciones de los estatutos sociales,
														reglamentos internos internos y acuerdos de las
														Asambleas Generales y del Directorio.</li>
													<li>Pagar puntualmente la cuota social anual que será fijada
														por el Directorio. El Directorio podrá fijar una cuota
														especial tanto para socios institucionales como para
														aquellos que acrediten la calidad de socio estudiante,
														dentro de los limites fijados en el artículo trigésimo
														segundo.</li>
													<li>Cooperar con los medios a su alcance a les finalidades
														de la Corporación.</li>
													<li>Servir los cargos para los cuales sean designados y
														colaborar con las tareas que se les encomienden.</li>
													<li>Asistir a las reuniones para los cuales hayan sido
														citados.</li>
												</ol>
												<p></p>
												<p>
													<b>ARTICULO UNDECIMO:</b> Los derechos de los socios Activos
													y Adherentes se suspenden por no pago de la cuota social
													anual, salvo debida justificación presentada por el socio y
													calificada por el Directorio. Los derechos suspendidos se
													restablecen al cancelarse la cuote correspondiente del año
													en curso.
												</p>
												<p>
													<b>ARTICULO DUODECIMO:</b> La calidad de socio adherente o
													Activo se pierde:
												</p>
												<ol type="a">
													<li>Por renuncia.</li>
													<li>Por muerte del socio.</li>
													<li>Por expulsión basada en las siguientes causales:
														<ol type="1">
															<li>Por incumplimiento de sus obligaciones
																pecuniarias durante tres años consecutivos.</li>
															<li>Por causar daño de palabra o por escrito a los
																intereses de la Corporación.</li>
														</ol>
													</li>
												</ol>
												<p></p>
												<p>
													La expulsión deberá decretarla el directorio por acuerdo
													adoptado por la mayoría absoluta de sus miembros en
													ejercicio. De ella podrá apelarse dentro de un plazo de
													quince días a la Asamblea General, la que decidirá en
													definitiva.
												</p>
												<p>
													<b>ARTICULO DECIMO TERCERO:</b> El directorio deberá
													pronunciarse sobre las solicitudes de ingreso y tomará nota
													de las renuncias en la primera reunión después de
													presentadas.
												</p>
												<h3>TITULO TERCERO.- De las Asambleas Generales.</h3>
												<p>
													<b>ARTICULO DECIMO CUARTO:</b> La Asamblea General es la
													máxima autoridad de la Corporación y estará formada por
													todos los socios. Los acuerdos de la Asamblea General
													obligan a todos los socios presentes y ausentes, siempre que
													hubieren sido tomados en la forma establecida por estos
													estatutos y no fueren contrarios a las leyes y reglamentos.
												</p>
												<p>
													<b>ARTICULO DECIMO QUINTO:</b> Habrá Asambleas Generales,
													Generales ordinarias y Extraordinarias.
												</p>
												<ul>
													<li>Las Asambleas Generales Ordinarias serán convocadas por
														el Directorio una vez al año, dentro de los primeros
														ocho meses. - En ella el Directorio deberá dar cuenta de
														su administración, pudiendo tratarse cualquier asunto de
														interés para la Corporación.</li>
													<li>Las extraordinarias se celebrarán cada vez que el
														Directorio acuerde convocarlas por estimarlo necesario
														para la marcha de la Corporación y cada vez que lo
														soliciten por escrito al Presidente, por lo menos el
														treinta por ciento de los Socios Activos y en ellas sólo
														podrán tomarse acuerdos relacionados con las materias
														indicadas en los avisos de citación.</li>
													<li>Sólo en Asamblea General Extraordinaria podrá tratarse
														de la reforma de estatutos de la Corporación y de su
														disolución.</li>
												</ul>
												<p></p>
												<p>
													<b>ARTICULO DECIMO SEXTO:</b> Las citaciones a Asambleas
													Generales, se harán por medio de un aviso publicado en un
													diario de la capital, dentro de los ocho días anteriores a
													la fecha señalada para la reunión y en él se indicará la
													ciudad, local, día y hora en que tendrá lugar. La citación a
													Asambleas General Extraordinaria deberá indicar su objeto.
													No podrá citarse en un mismo aviso para una segunda reunión
													cuando por falta de quorum no se lleve a efecto la primera.
												</p>
												<p>
													<b>ARTICULO DECIMO SEPTIMO:</b> Las Asambleas Generales se
													constituirán en primera citación con el cuarenta por ciento
													de los Socios Activos. Si llegado el día para la reunión no
													se reuniere el indicado quórum, se dejará constancia de este
													hecho en el Libro de Actas, y se citará por segunda vez para
													dentro de los próximos quince días.
												</p>
												<p>
													En segunda citación la Asamblea se constituirá con los
													socios que asistan. Los acuerdos se adoptarán por mayoría de
													votos, de los socios activos presentes. No obstante, los
													acuerdos relativos a la modificación de los estatutos y
													disolución de la Corporación, sólo podrán adoptarse por los
													dos tercios de los socios activos presentes. De las
													deliberaciones y acuerdos adoptados se dejará constancia en
													un libro especial que será llevado por el Secretario.
												</p>
												<p>
													Las Actas serán firmadas por el Presidente, el Secretario y
													tres asistentes que designe la Asamblea. En dichas actas
													podrán los asistentes estampar las reclamaciones
													convenientes a sus derechos por vicios de procedimiento
													relativos a la citación, constitución y funcionamiento de la
													misma.
												</p>
												<p>
													<b>ARTICULO DECIMO OCTAVO:</b> Las Asambleas serán
													presididas por el Presidente de la Corporación y actuará
													como Secretario el que lo sea de la Corporación o la persona
													que haga sus veces.
												</p>
												<h3>TITULO CUARTO.- Del Directorio.</h3>
												<p>
													<b>ARTICULO DECIMO NOVENO:</b> La dirección y administración
													de la Corporación estará a cargo de un Directorio compuesto
													de cinco miembros titulares y uno suplente, que durarán dos
													años en sus cargos, pudiendo ser reelegidos indefinidamente.
													En todo caso, se entenderán prorrogadas sus funciones hasta
													la elección de sus reemplazantes.
												</p>
												<p>
													<b>ARTICULO VIGESIMO:</b> Los Directores serán nominados en
													la Asamblea General Ordinaria anual que corresponda, en la
													cual cada miembro sufragara por tres personas, proclamándose
													elegidos a los que en una misma y única votación resultaren
													con el mayor número de votos, hasta completar seis
													Directores, designándose Director suplente el que obtenga la
													secta mayoría. En caso de empate se repetirá la votación
													entre las personas a quienes este afecte, y si se produjere
													un nuevo empate, se decidirá por sorteo.
												</p>
												<p>
													<b>ARTICULO VIGESIMO PRIMERO:</b> El directorio sesionará
													tres veces al año, y cada vez que lo soliciten tres de sus
													miembros o lo convoque el Presidente. En su primera sesión,
													designará de entre sus miembros, un Presidente, un
													Secretario y un Tesorero.
												</p>
												<p>
													<b>ARTICULO VIGESIMO SEGUNDO:</b> El Presidente del
													Directorio lo será de la Corporación y la representará,
													Judicial y extrajudicialmente.
												</p>
												<p>
													<b>ARTICULO VIGESIMO TERCERO:</b> El Directorio sesionará
													con la mayoría absoluta de sus miembros y sus acuerdos se
													adoptarán por la mayoría absoluta de los asistentes,
													decidiendo en caso de empate el voto del Presidente o quien
													lo subrogue.
												</p>
												<p>
													<b>ARTICULO VIGESIMO CUARTO:</b> Los miembros del Directorio
													cesarán en sus cargos;
												</p>
												<ol type="a">
													<li>Por fallecimiento.</li>
													<li>Por pérdida de la calidad de socio.</li>
													<li>Por inasistencia a tres sesiones consecutivas del
														Directorio sin aviso oportuno o sin causa justificada.
													</li>
												</ol>
												<p></p>
												<p>
													<b>ARTICULO VIGESIMO QUINTO:</b> En caso de ausencia,
													fallecimiento, renuncia o imposibilidad de algún miembro del
													Directorio para desempeñar su cargo, asumirá el Director
													Suplente por el tiempo que dure el impedimento o hasta el
													término del periodo respectivo. Si se produjeren nuevas
													ausencias, los miembros restantes nombrarán a un
													reemplazante de entre los socios de la Corporación que
													tengan derecho a desempeñar cargos directivos, el cual
													permanecerá en él por el tiempo que dure la ausencia o hasta
													el término del periodo. Si la inhabilidad o ausencia
													afectare al Presidente, lo subrogará el Secretario y en
													ausencia de este, subrogará al Presidente el Tesorero.
												</p>
												<p>
													<b>ARTICULO VIGESIMO SEXTO:</b> El cargo de Director no será
													remunerado.
												</p>
												<p>
													<b>ARTICULO VIGESIMO SEPTIMO:</b> Son atribuciones y deberes
													del Directorio:
												</p>
												<ol type="1">
													<li>Cumplir los estatutos y reglamentos de la Corporación.
													</li>
													<li>Organizar la Conferencia Científica Anual de la
														Sociedad, la cual estará constituida por el Comité
														Organizativo integrado por tres socios que designará el
														Directorio; se constituirá con la mayoría de sus
														miembros y adoptará sus acuerdos por mayoría de votos.
													</li>
													<li>Convocar a la Asamblea General y cumplir y ejecutar sus
														acuerdos.</li>
													<li>Proponer las comisiones encargadas de estudiar materias
														específicas, cuando la Sociedad sea requerida por parte
														de instituciones gubernamentales, académicas o
														internacionales.</li>
													<li>Proponer a la Asamblea General la calidad de Socio
														Honorario.</li>
													<li>Someter a la aprobación de la Asamblea General, los
														reglamentos que sea necesario dictar para el
														funcionamiento de la Corporación y todos aquellos
														asuntos que estime necesarios.</li>
													<li>Administrar los bienes de la Corporación e invertir sus
														recursos. En uso de tales facultades le corresponde
														cobrar y percibir cuanto corresponda a la Corporación,
														resolver la inversión de los fondos o bienes de la
														misma, comprar y vender, arrendar bienes corporales e
														incorporales muebles y valores mobiliarios; constituir
														prenda sobre ellos, comprar, arrendar y dar en
														arrendamiento bienes raíces, contratar préstenos en
														forma de pagarés, avances en cuenta corriente o
														cualquier otra; tomar dinero a interés en cualquier
														forma, celebrar contratos de cuenta corriente bancaria,
														de depósito y de crédito, girar y sobregirar en ellas,
														reconocer o impugnar sus saldos, retirar talonarios de
														cheques, cancelar y endosar cheques, girar, suscribir,
														aceptar, reaceptar, endosar, descontar y protestar
														letras de cambio, cheques, pagarés y demás documentos
														mercantiles de cualquier tipo; retirar valores en
														custodia o en garantía, arrendar y administrar cajas de
														seguridad, ceder créditos y aceptar cesiones, endosar y
														retirar documentos de embarque, suscribir registros de
														importación y efectuar toda clase de operaciones
														relacionadas con ellos. El Directorio podrá delegar en
														un tercero parte de las facultades de índole
														administrativa y/o económica señalada en esta letra. Las
														facultades indicadas en este número deberá ejercerlas el
														Directorio por intermedio y con la firma del Presidente
														o del Tesorero. Para vender bienes raíces de la
														corporación será necesario el acuerdo de la Asamblea
														General de Socios.</li>
													<li>Celebrar sesiones en las épocas señaladas en estos
														estatutos y cuando lo soliciten tres de sus miembros o
														lo convoque el Presidente.</li>
													<li>Resolver la colocación de fondos y aceptar toda clase de
														donativos. </li>
													<li>Rendir cuenta ante la Asamblea General de Socios de la
														marcha de la Institución, de la inversión de sus fondos
														y de los demás asuntos que por su importancia deben ser
														considerados en ella.</li>
													<li>Resolver todo aquello no previsto en estos estatutos.
													</li>
												</ol>
												<p></p>
												<p>
													<b>ARTICULO VIGESIMO OCTAVO:</b> De las deliberaciones y
													acuerdos del Directorio se dejará constancia en un libro
													especial de actas que deberá ser firmado por todos los
													Directores que hubiesen concurrido a la sesión. El Director
													que quiera salvar su responsabilidad por algún acto o
													acuerdo, deberá hacer constar su oposición.
												</p>
												<p>
													<b>ARTICULO VIGESIMO NOVENO:</b> Son atribuciones y deberes
													del Presidente del Directorio:
												</p>
												<ol type="1">
													<li>Representar judicial y extrajudicialmente a la
														Corporación.</li>
													<li>Presidir las sesiones del Directorio y de la Asamblea
														General. En ausencia del Presidente, presidirá las
														sesiones el Secretario y a falta de éste el Tesorero.
													</li>
													<li>Convocar a la Asamblea General Extraordinaria cada vez
														que lo soliciten por escrito al menos el treinta por
														ciento de los socios activos, indicándose el objeto.
													</li>
													<li>Convocar al Directorio cuando lo estime necesario.</li>
													<li>Contratar, remover y fijar las remuneraciones del
														personal de planta aprobada por la Asamblea General
														Ordinaria.</li>
												</ol>
												<p></p>
												<p>
													<b>ARTICULO TRIGESIMO:</b> Son atribuciones y deberes del
													Secretario:
												</p>
												<ol type="1">
													<li>Llevar los libros de actas de las reuniones del
														Directorio y de las Asambleas Generales, mantener los
														archivos y correspondencia de la Corporación.</li>
													<li>Despachar las citaciones a Asamblea General de socios.
													</li>
													<li>Subrogar al Presidente de acuerdo a lo prescrito en el
														artículo Vigésimo Noveno.</li>
												</ol>
												<p></p>
												<p>
													<b>ARTICULO TRIGESIMO PRIMERO:</b> Son atribuciones y
													deberes del Tesorero:
												</p>
												<ol type="1">
													<li>Cuidar que la contabilidad de la Corporación se lleve al
														día y proporcionar en cualquier momento información
														acerca de las entradas, gastos e inversiones de la
														corporación. En su desempeño responderá personalmente
														del manejo de los fondos que se encuentren a su cargo.
													</li>
													<li>Velar por el cobro de las cuotas sociales.</li>
													<li>Subrogar al Presidente de acuerdo a lo prescrito en el
														artículo Vigésimo Noveno.</li>
												</ol>
												<p></p>
												<h3>TITULO QUINTO.- Del Patrimonio.</h3>
												<p>
													<b>ARTICULO TRIGESIMO SEGUNDO:</b> El patrimonio inicial de
													la corporación lo constituye la suma de cien mil pesos que
													se ha recibido como aporte de los miembros constituyentes en
													el acto de constitución de la corporación.
												</p>
												<p>
													<b>ARTICULO TRIGESIMO TERCERO:</b> Para atender sus
													necesidades la Corporación dispondrá de las rentas que
													produzcan los bienes que posea, además de las cuotas
													sociales ordinarias que aporten sus socios, las que serán
													determinadas por el Directorio y no podrá ser inferior a
													media Unidad de Fomento mensual ni superior a treinta
													Unidades de Fomento mensuales, por las cuotas
													extraordinarias que acuerde la Asamblea de socios, y con las
													donaciones, erogaciones, herencias, legados y subvenciones
													que reciba de personas naturales o jurídicas; y, en general
													con los bienes que a cualquier título adquiera o posea, con
													sus frutos e intereses.
												</p>
												<h3>TITULO SEXTO.- De la modificación de los estatutos y
													disolución de la entidad.</h3>
												<p>
													<b>ARTICULO TRIGESIMO CUARTO:</b> Se podrán modificar los
													estatutos por acuerdo de una Asamblea Extraordinaria de
													Socios citada especialmente para este efecto, debiendo
													adoptarse el acuerdo por los dos tercios de los socios
													activos presentes. A la asamblea deberá concurrir un Notario
													que certifique el hecho de haberse cumplido con las
													formalidades y requisitos que para la reforma de estatutos
													establecen éstos.
												</p>
												<p>
													<b>ARTICULO TRIGESIMO QUINTO:</b> La Corporación podrá
													disolverse por acuerdo de una Asamblea General
													Extraordinaria citada especialmente para este efecto con el
													mismo quórum y requisitos establecidos en el artículo
													anterior.
												</p>
												<p>
													<b>ARTICULO TRIGESIMO SEXTO:</b> En caso de disolución de la
													Corporación, los bienes de esta, una vez canceladas todas
													sus deudas, se entregarán a la o las Instituciones que
													teniendo fidelidades análogas, determine el Presidente de la
													República, de conformidad con lo prescrito en el Artículo
													quinientos sesenta y uno del Código Civil.
												</p>
												<p>
													<b>ARTICULO PRIMERO TRANSITORIO.</b> El Directorio
													Provisorio estará integrado por las siguientes personas:
												</p>
												<ul>
													<li>Señor Pedro Hepp Kuschel como Presidente</li>
													<li>Señor Patricio Poblete Olivares, Secretario</li>
													<li>Señor Edgardo Krell Goldfseb, Tesorero</li>
													<li>señores Jorge Olivos Aravena y Yussef Farran Leiva,
														directores</li>
												</ul>
												<p></p>
												<p>
													<b>ARTICULO SEGUNDO TRANSITORIO.</b> Estos Directores
													durarán en sus funciones hasta la celebración de la primera
													Asamblea General, en la que se designará el Directorio
													definitivo en conformidad a los Estatutos.
												</p>
												<p>
													<b>ARTICULO TERCERO TRANSITORIO.</b> Se faculte a don Pedro
													Hepp Kuschel para que reduzca a escritura pública el acta de
													constitución, y a la Abogado señora Lenis Botti Gilchrist,
													inscripcicón cinco mil ochocientos - treinta y cuatro - dos
													, patente cuatrocientos diez mil seis cientos cincuenta y
													dos- cero , Rut número cuatro millones setecientos noventa y
													ocho mil setecientos tres raya dos de Santiago, con
													domicilio en calle Doctor Sótero del Río trescientos
													veintiseis, Oficina cuatrocientos dos- Santiago, para que
													solicite al Presidente de la República la aprobación de
													estos estatutos y para aceptar las reformas que sea
													necesario introducir, pudiendo suscribir las escrituras
													públicas o privadas que su encargo haga necesario.
												</p>
												<p>
													Firman los asistentes, que quedan individualizados con su
													nombre y Rut.
												</p>
												<ul>
													<li>P. Hepp. Pedro E. Hepp Kuschel, Rut ocho millones
														ochenta y nueve mil trescientos cincuenta y seis- seis
														Santiago.</li>
													<li>P. Poblete O. Patricio Poblete Olivares. Rut seis
														millones quinientos diecisiete mil quinientos cincuenta
														y tres- tres.</li>
													<li>Olivos A. Rut cinco millones cuatrocientos tres mil
														trescientos sesenta y seis- cuatro Santiago.</li>
													<li>P. Alliende E.- Pablo Alliende - Edwards. Rut siete
														millones doscientos setenta y nueve mil novecientos
														treinta- cinco.</li>
													<li>R. Hernandez C.- Rafael Hernán dez Contreras.- Rut seis
														millones trescientos ochenta y nueve mil novecientos
														treinta y uno- cero.</li>
													<li>J. A. Benguria D.- José A. Benguria Donoso. Rut siete
														millones novecientos treinta y seis mil cuatrocientos
														noventa y cuatro- cero.</li>
													<li>E. Azorín M. Ernesto Azorin Minguez. Rut cinco millones
														novocientos veintisiete mil cuatrocientos ochenta y tres
														- K.</li>
													<li>Edgardo Krell Edgardo Krell Goldfarb. Rut cinco millones
														ciento doce mil nueve - cuatro.</li>
													<li>M. Pardo B.- Marcelo Pardo Brown. Rut cuatro millones
														trescientos veintisiete mil seiscientos dieciocho- dos.
													</li>
													<li>J. Cockbaine O.- Juan Carlos Cockbaine Ojeda. Rut siete
														millones trescientos diecisiete mil doscientos setenta y
														uno raya tres.</li>
													<li>Horacio Meléndez V.- Horacio Meléndez Villalobos Rut
														seis millones trescientos cincuenta y cinco mil cuarenta
														y ocho- cinco.</li>
													<li>S. Mujica.- Sergio Mujica López. Rut seis millones
														cuatrocientas cuarenta y nueve mil trescientos no venta
														y ocho- uno.</li>
													<li>David A. Fuller P.- David Fuller Padilla. Rut ocho
														millones trescientos veintiun mil ochocientos
														veintinueve- cero.</li>
													<li>Miguel Nussbaun.- Miguel Nussbaum Voehl. Rut cinco
														millones seiscientos sesenta y cuatro mil seiscientos
														treinta y seis- uno.</li>
													<li>F. Aurtenechea O.- Francisco Aurtenechea Ortega.- Rut
														seis millones sesenta y seis mil trescientos ochenta y
														siete- cuatro.</li>
													<li>J. Cordero F.- Juan Carlos Cordero Peña. Rut seis
														millones trescientos sesenta y seis mil seiscientos
														noventa y tres- nueve.</li>
													<li>H. Bórquez L.- Hugo Bórquez Legaza. Rut seis millones
														novecientos ochenta y nueve mil quinientos setenta y
														uno- nueve.</li>
													<li>O. Mimica R.- Oscar Mimica Roki.- Rut seis millones
														doscientos veinte mil cuatrocientos trece- tres.</li>
												</ul>
												<p></p>
												<p>
													Se dio término a la Sesión, siendo las quince horas.
												</p>
												<p>
													Conforme con su original que he tenido a la vista y que rola
													do fojas, una a fojas veintitres del Libro de Actas
													respectivo.
												</p>
												<p>
													En comprobante firma previa lectura con los testigos doña
													Myrna Jiménez Pérez y doña Iris Jiménez Pérez. - Se da
													copia.- La presente escritura queda anotada en el Repertorio
													bajo el número tres mil trescientos treinta y siete. Doy
													fe.- P. HEPP.- R.u.t. 8.089.356- 6.- M. JIMELNEZ P.- IRIS
													JIMENEZ PEREZ.- SAMUEL FUCHS B.- Notario Público de
													Santiago.
												</p>
												<p>
													ES TESTIMONIO FIEL DE SU ORIGINAL.- Santiago , doce de
													Diciembre de mil novecientos ochenta y cuatro,
												</p>
												<p>SAMUEL FUCHS BROTFELD</p>
												<p>NOTARIO PUBLICO </p>
												<p>SANTIAGO</p>
											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-secondary"
													data-dismiss="modal" id="cerrarModal">Cerrar</button>
												<button type="button" class="btn btn-primary"
													onclick="aceptarTerms()" data-dismiss="modal"
													id="aceptarTerms">Aprobar Estatutos</button>
											</div>

										</div>
									</div>
								</div>
								<div class="modal" id="loadingModal" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-dialog-centered d-flex justify-content-center" role="document">
									<div class="spinner-border" role="status">
										<span class="sr-only">Loading...</span>
									</div>
								</div>
							</div>';
		if(!empty($get_data)){

		}else{
			$post_arr_data = array(
				"post_title" => "Formulario de pre-registro para miembros",
				"post_name" => "pre-register",
				"post_status" => "publish",
				"post_author" => $user_ID,
				"post_content" => $pre_registro,
				"post_type" => "page",
				"page_template" => "template-full-width.php"
			);

			wp_insert_post($post_arr_data);
		}

	}

	public function page_complete_reg() {
		global $wpdb;
		global $user_ID;
		
		$get_data = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM ".$wpdb->prefix."posts WHERE post_name = %s",
				'completar-credenciales'
			)
		);

		$completar_credenciales = '<form name="complete-registration" id="complete-registration">
		<div class="form-row row">
		<div class="form-group col-md-6">
												<label for="address">Dirección</label>
		<input class="form-control" name="address" id="address" type="text" placeholder="Daniel de la vega 0283, Maipú, Santiago" required=""></div>
		<div class="form-group col-md-6">
												<label for="phone">Teléfono</label>
		<input class="form-control" name="phone" id="phone" type="text" placeholder="+569 86606669"></div>
		</div>
		<div class="form-row row">
		<div class="form-group col-md-6">
													<label for="grade">Grado académico</label>
		<select class="form-control" name="grade" id="grade" type="text" placeholder="Seleccione una opción" required="">
		<option value="1">Estudiante</option>
		<option value="2">Licenciado</option>
		<option value="3">Magister</option>
		<option value="4">Doctorado</option>
		<option value="5">Post-Doctorado</option>
		</select></div>
		<div class="form-group col-md-6">
													<label for="institution">Institución académica o laboral, a la cual pertenece</label>
		<input class="form-control" name="institution" id="institution" type="text" placeholder="UNAB"></div>
		</div>
		<div class="form-row row">
		<div class="form-group col-md-6">
													<label for="title">Título profesional</label>
		<input class="form-control" name="title" id="title" type="text" placeholder="Ingeniero en Computación e Informática" required=""></div>
		<div class="form-group col-md-6">
												<label for="workPosition">Cargo Actual</label>
		<input class="form-control" name="workPosition" id="workPosition" type="text" placeholder="Desarrollador, Account Manager..." required=""></div>
		</div>
		<div class="form-row row">
		<div class="form-group col-md-6">
													<label for="secondMail">Correo electrónico secundario</label>
		<input class="form-control" name="secondMail" id="secondMail" type="text" placeholder="ej@domain.cl" required=""></div>
		</div>
		<div class="form-row row">
												<input class="form-control d-none" name="token" id="token" type="text">
		<div class="form-group col-md-12">
													<label for="customFile">El formato debe ser PDF y no mayor a 5mb</label>
		<div class="custom-file" id="customFile" lang="es">
														<input type="file" class="form-control custom-file-input" id="inputFile" name="inputFile" aria-describedby="fileHelp" accept="application/pdf">
		<label class="custom-file-label" for="inputFile">Seleccionar archivo que certifique su: titulo profesional, grado académico, certificado de alumno regular o contrato de trabajo.</label></div>
		</div>
		</div>
		</form>
		<div class="row">
		<div class="col" id="botonera">
											<button id="registro_completar_credenciales" class="btn btn-modern btn-lg btn-gradient btn-full-rounded" onclick="form_validation()">Completar registro</button></div>
		</div>
		<div class="modal" id="loadingModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered d-flex justify-content-center" role="document">
				<div class="spinner-border" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</div>
		</div>';
		if(!empty($get_data)){

		}else{
			$post_arr_data = array(
				"post_title" => "Completar Credenciales",
				"post_name" => "completar-credenciales",
				"post_status" => "publish",
				"post_author" => $user_ID,
				"post_content" => $completar_credenciales,
				"post_type" => "page",
				"page_template" => "template-full-width.php"
			);

			wp_insert_post($post_arr_data);
		}
	}

	public function create_dir() {
		$uploads_dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'member-attachments';
		wp_mkdir_p( $uploads_dir );
		// $upload = wp_upload_dir();
		// $upload_dir = $upload['basedir'];
		// $upload_dir = $upload_dir . '/mypluginfiles';
	}
}
