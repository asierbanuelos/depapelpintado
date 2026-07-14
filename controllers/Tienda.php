<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tienda extends CI_Controller {

    function __construct() {
        parent::__construct();
        //setlocale(LC_ALL, 'es_ES');
        // To load the CI benchmark and memory usage profiler - set 1==1.
        if (1 == 2) {
            $sections = array(
                'benchmarks' => TRUE, 'memory_usage' => TRUE,
                'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => TRUE,
                'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
            );
            $this->output->set_profiler_sections($sections);
            $this->output->enable_profiler(TRUE);
        }

        // Load CI libraries and helpers.
        $this->load->database();
        $this->load->library('session');
        //echo "ok 2";
        //exit;
        $this->load->helper('text');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('contenido_model');
        $this->load->model('santos_monteiro_model');
        //$this->data['css'] = $this->contenido_model->get_page(1);
        $this->data['cssseo'] = $this->contenido_model->get_page(43);
        $this->data['footseo'] = $this->contenido_model->get_page(44);


        // Example of defining a specific language to return flexi carts status and error messages.
        // The defined language file must be added to the CI application directory as 'application/language/[language_name]/flexi_cart_lang.php'.
        // Alternatively, CI's default language can be set via the CI config. file.
        // Note: This must be defined before $this->load->library('flexi_cart').
        // $this->lang->load('flexi_cart', 'spanish');
        // IMPORTANT! This global must be defined BEFORE the flexi cart library is loaded! 
        // It is used as a global that is accessible via both models and both libraries, without it, flexi cart will not work.
        $this->flexi = new stdClass;

        // Load 'standard' flexi cart library by default.
        $this->load->library('flexi_cart');
        $this->user['user'] = "ekam";
        $this->user['pass'] = "P4p3lp1nt4d02016!2023";
        // Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
        $this->load->vars('base_url', base_url());
        $this->load->vars('includes_dir', base_url() . 'includes/');
        $this->load->vars('current_url', $this->uri->uri_to_assoc(1));

        // Load cart data to be displayed via 'Mini Cart' menu.
        if ($this->input->post('logout')) {
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('hash');
        }

        $this->nuevo_usuario=false;
        $this->nuevo_desde_pedido=false;
        if ($this->input->post("registrar")) {
            $this->load->helper('email');
            if (!valid_email($this->input->post("email"))) {
                $this->data["logmsg"] = "El nombre de usuario debe ser una cuenta de email valida.";
            } 
            else if ($this->input->post("email") && $this->input->post("pass") == $this->input->post("pass2") && $this->input->post("pass2") != '') {
                if (!isset($_POST['legaladvice'])){
                    $this->data["logmsg"] = "Debe leer y aceptar la política de privacidad.";
                }
                elseif ($this->db->where(array('email' => $this->input->post("email")))->count_all_results('users') == 0) {
                    if($this->input->post("token")){
                        $captcha_balidazioa=$this->captcha_v3_balidatu();
                        if ($captcha_balidazioa->success){
                            if ($this->input->post("suscripcionRegistro")){
                                $this->load->helper('email');
                                if (valid_email($this->input->post("email"))){
                                    $suscripcion_ok=$this->newsletter('registro_usuario', $_POST);

                                }
                            }
                            // Creamos el usuario
                            $this->db->insert('users', array('email' => $this->input->post("email"), 'password' => md5($this->input->post("pass"))));
                            $id_usuario=$this->db->insert_id();

                            // Asignamos los pedidos al idusuario del mail creado
                            $this->db->where("ord_demo_email", $this->input->post('email'))->update('order_summary', array('ord_user_fk' => $id_usuario));

                            $newdata = array(
                                'email' => $this->input->post("email"),
                                'logged_in' => TRUE
                            );
                            $this->session->set_userdata($newdata);

                            //$this->data["logmsg"] = "Te has registrado correctamente, logeate para acceder a tus datos.";
                            $this->nuevo_usuario=true;
                            
                            //$this->send_info_email($this->input->post("email"), "Gracias por registrarte en depapelpintado.es", $this->load->view('frontend/cuentas/emailregistro', array(), TRUE));
                            $this->send_registro_email($this->input->post("email"), "Gracias por registrarte en depapelpintado.es", 'emailregistro_bono', TRUE);
                        }
                    }
                } 
                else{
                    $this->data["logmsg"] = "Ya existe una cuenta con ese email.";
                }
            } 
            else{
                $this->data["logmsg"] = 'Los Datos introducidos no son validos.';
            }
        }
        $this->continuar_form_checkout=false;
        if ($this->input->post("checkout_registro_contacto")){
            // Si desde el checkout estamos metiendo contraseña y onfirmación de contraseña, es porque queremos crear un usuario
            $this->continuar_form_checkout=true;
            if ($this->input->post("email") && $this->input->post("pass") == $this->input->post("pass2") && $this->input->post("pass2") != '') {
                if (!isset($_POST['legaladvice'])){
                    $this->continuar_form_checkout=false;
                    $this->data["logmsg_new_carrito"] = "Debe leer y aceptar la política de privacidad.";
                }
                elseif ($this->db->where(array('email' => $this->input->post("email")))->count_all_results('users') == 0) {
                    if ($this->input->post("suscripcionRegistro")){
                        if($this->input->post("token")){
                            $captcha_balidazioa=$this->captcha_v3_balidatu();
                            if ($captcha_balidazioa->success){
                                $this->load->helper('email');
                                if (valid_email($this->input->post("email"))){
                                    $suscripcion_ok=$this->newsletter('registro_usuario', $_POST);

                                }
                            }
                        }
                    }
                    /*
                    print '<pre><xmp>';
                    print_r($_POST);
                    print '</xmp></pre>';
                    print '<pre><xmp>';
                    print_r($captcha_balidazioa);
                    print '</xmp></pre>';
                    exit;
                    */
                    // Creamos el usuario
                    $this->db->insert('users', array('email' => $this->input->post("email"), 'phone' => $this->input->post("phone"), 'password' => md5($this->input->post("pass"))));
                    $id_usuario=$this->db->insert_id();

                    // Asignamos los pedidos al idusuario del mail creado
                    $this->db->where("ord_demo_email", $this->input->post('email'))->update('order_summary', array('ord_user_fk' => $id_usuario));

                    $this->send_registro_email($this->input->post("email"), "Gracias por registrarte en depapelpintado.es", 'emailregistro');
                    //$this->send_info_email_copia_oculta($this->input->post("email"), "Gracias por registrarte en depapelpintado.es", $this->load->view('frontend/cuentas/emailregistro_bono'));
                
                    // Como estamos haciendo el registro desde el formulario de checkout, le logueamos de forma automática
                    $newdata = array(
                        'email' => $this->input->post("email"),
                        'logged_in' => TRUE
                    );
                    $this->nuevo_desde_pedido=true;
                    
                    $this->session->set_userdata($newdata);
                } 
                else{
                    $this->continuar_form_checkout=false;
                    $this->data["logmsg_new_carrito"] = "Ya existe una cuenta con el mail <strong>".$this->input->post("email")."</strong>";
                    $this->data["pass_olvidada"] = '¿No recuerdas tu contraseña? <a href="' . base_url() . 'tienda/recuperar_contrasena">Pincha Aqui</a>';
                }
                /*
                */
            }
            if ($this->input->post("pass") != $this->input->post("pass2") && $this->input->post("pass2") != '') {
                $this->continuar_form_checkout=false;
                $this->data["logmsg_new_carrito"] = "Las contraseñas no coinciden.";
            }
        }
        if ($this->input->post("identificate")) {
            if ($this->input->post("email")){
        		if ($this->db->where(array('email' => $this->input->post("email")))->count_all_results('users') == 0){
                    $this->data["logmsg"] = 'No existe ninguna cuenta asociada a ese email. Regístrate como nuevo usuario.';
        			$this->data["logmsg_carrito"] = 'No existe ninguna cuenta asociada a ese email. Regístrate como nuevo usuario.';
                }
        		else{
        			if ($this->input->post("pass")) {
        				if ($this->db->where(array('email' => $this->input->post("email"), 'password' => md5($this->input->post("pass"))))->count_all_results('users') == 1) {
        				    $newdata = array(
        					'email' => $this->input->post("email"),
        					'logged_in' => TRUE
        				    );
        				    $this->session->set_userdata($newdata);
        				} 
        				else{
                            $this->data["logmsg"] = 'Los Datos introducidos no son validos.  ¿No recuerdas tu contraseña? <a href="' . base_url() . 'tienda/recuperar_contrasena">Pincha Aqui</a>';
        					$this->data["logmsg_carrito"] = 'Los Datos introducidos no son validos.  ¿No recuerdas tu contraseña? <a href="' . base_url() . 'tienda/recuperar_contrasena">Pincha Aqui</a>';
                        }
        			}
        		}
    	    }
        }
        if ($this->input->post("email_newsletter_footer")){
            if($this->input->post("token")){
                $captcha_balidazioa=$this->captcha_v3_balidatu();
                if ($captcha_balidazioa->success){
                    $this->load->helper('email');
                    if (valid_email($this->input->post("email_newsletter_footer"))){
                        $this->data['notificacion_modal']='ok';
                        $suscripcion_ok=$this->newsletter('footer', $_POST);
                    }
                }
            }
        }
        $this->data['usuario'] = $this->isLog();
        $this->mini_cart_data();
        $this->data['totalcarro'] = str_replace(array("€", " ", ","), array("", "", "."), $this->flexi_cart->total());
    }


    /**
     * FLEXI CART DEMO
     * Many of the functions within this controller load a custom model called 'demo_cart_model' that has been created for the purposes of this demo.
     * The 'demo_cart_model' file is not part of flexi cart, it is included to demonstrate how some of the functions of flexi cart can be used.
     */
    function plantilla() {
        $this->load->view('frontend/cuentas/plantillamail', $this->data);
    }
	

    function login() {
        $this->data['incorrecto'] = 0;
        if (isset($_POST['log'])) {
            //       echo mysql_real_escape_string($_POST['pass']);
            
            //if ($_POST['user'] == $this->user['user'] && mysql_real_escape_string($_POST['pass']) == $this->user['pass']) {
            //if ($_POST['user'] == $this->user['user'] && $this->db->real_escape_string($_POST['pass']) == $this->user['pass']) {
            if ($this->db->escape_str($_POST['user']) == $this->user['user'] && $this->db->escape_str($_POST['pass']) == $this->user['pass']) {
                $newdata = array(
                    'username' => $this->user['user'],
                    'hash' => md5($this->user['user'] . $this->user['pass'])
                );
                $this->session->set_userdata($newdata);
                $this->input->set_cookie('username', $this->user['user'], 86500);
                $this->input->set_cookie('hash', md5($this->user['user'] . $this->user['pass']), 86500);
                redirect("admin_library");
            }
            $this->data['incorrecto'] = 1;
        }
        /*
        print '<pre><xmp>';
        print_r($this->db);
        print '</xmp></pre>';
        */
        $this->load->view('frontend/login', $this->data);
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // VIEW CART
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    function registro() {

        if ($this->data['usuario']->user_id != 1)
            redirect("tienda/mi_cuenta");
        $this->load->view('frontend/header', $this->data);
        $this->load->view('frontend/cuentas/registro', $this->data);
        $this->load->view('frontend/footer', $this->data);
    }

    function identificate() {

        //cookies
        $this->load->view('frontend/header', $this->data);
        $this->load->view('frontend/cuentas/login', $this->data);
        $this->load->view('frontend/footer', $this->data);
    }

    function recuperar_contrasena($mail = '', $token = '') {
    	//$this->load->view('frontend/header', $this->data);
    	$this->data['mail'] = urldecode($mail);
    	$this->data['msg'] = '';
    	if ($this->input->post('email')) {
    		//enviar mail guardar token + fecha
    		//~ if ($this->db->where("email", $this->data['mail'])->count_all_results("users") > 0) {
    		if ($this->db->where("email", $this->input->post('email'))->count_all_results("users") > 0) {
    			$this->data['cual'] = "enviado";
    			$this->data['mail'] = $this->input->post('email');
    			
                $this->data['meta_title']='Recupera tu contraseña';
                $this->data['meta_description']='Recupera tu contraseña de tu cuenta personal.';
                $this->load->view('frontend/header', $this->data);
                $this->data['a_migas']['/tienda/mi_cuenta']='Mi cuenta';
                $this->data['a_migas']['/tienda/recuperar_contrasena']='Recuperar contraseña';
                $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);
                $this->load->view('frontend/cuentas/recuperar', $this->data);
    			$hash = md5(time() . $this->input->post('email'));

    			$this->db->where("email", $this->input->post('email'))->update('users', array('token' => $hash, 'requestdate' => date('Y-m-d H:i:s', time())));
    			$this->send_info_email($this->data['mail'], 'Solicitud de reestablecimiento de contraseña', 'Se ha solicitado el cambio de contraseña para la cuenta asociada a este email en depapelpintado.es<br>Para continuar con el proceso haga click en el enlace siguente<br><a href="' . base_url() . 'tienda/recuperar_contrasena/' . urlencode($this->input->post('email')) . '/' . $hash . '">' . base_url() . 'tienda/recuperar_contrasena/' . urlencode($this->input->post('email')) . '/' . $hash . '</a><br>En caso de no haberla solicitado ud, simplemente ignore este email');
    		}
    		else{
    			$this->data["logmsg"] = 'No existe ninguna cuenta asociada a ese email.';
    			redirect("tienda/mi_cuenta/");
    		}
    		
    		//~ echo "<br />1 ".$this->db->last_query();
    		//~ exit;
    	} 
    	else if ($token != '') {
    		//mirar token y fecha y si coincide
    		//si coincide
    		$count = $this->db->where("email", $this->data['mail'])->where("token", $token)->where("requestdate > NOW() - INTERVAL 1 DAY")->count_all_results("users");
    		//~ echo "<br />mail: $mail";
    		//~ echo "<br />token: $token";
    		//~ echo "<br />2 ".$this->db->last_query();
    		//~ exit;
    		if ($count == 1) {
    			
                $this->data['meta_title']='Recupera tu contraseña';
                $this->data['meta_description']='Establece tu contraseña de tu cuenta personal.';
                $this->load->view('frontend/header', $this->data);
                $this->data['a_migas']['/tienda/mi_cuenta']='Mi cuenta';
                $this->data['a_migas']['/tienda/recuperar_contrasena']='Recuperar contraseña';
                $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);

                if ($this->input->post('pass') && $this->input->post('pass2') == $this->input->post('pass')) {
    				//~ echo "<br />1";
    				$this->db->where("email", $this->data['mail'])->update('users', array('token' => '', 'requestdate' => time(), 'password' => md5($this->input->post('pass'))));
    				$this->data['cual'] = "hecho";
    				$this->load->view('frontend/cuentas/recuperar', $this->data);
    			} else if ($this->input->post('pass') && $this->input->post('pass2')) {
    				//~ echo "<br />2";
    				$this->data['cual'] = "reset";
    				$this->data['msg'] = "Las claves no coinciden";
    				$this->load->view('frontend/cuentas/recuperar', $this->data);
    			} else {
    				//~ echo "<br />3";
    				$this->data['cual'] = "reset";
    				$this->load->view('frontend/cuentas/recuperar', $this->data);
    			}
    		} 
    		else {
    			$this->data['msg'] = "La solicitud de cambio ha caducado, por favor vuelva a solicitarla.";
    			redirect("tienda/recuperar_contrasena/" . $mail);
    		}
    	} 
    	else {
    		//~ echo "<br />4";
            $this->data['meta_title']='Recupera tu contraseña';
            $this->data['meta_description']='Recupera tu contraseña de tu cuenta personal.';
            $this->load->view('frontend/header', $this->data);
            $this->data['a_migas']['/tienda/mi_cuenta']='Mi cuenta';
            $this->data['a_migas']['/tienda/recuperar_contrasena']='Recuperar contraseña';
            $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);
    		$this->load->view('frontend/cuentas/recuperar', $this->data);
    	}
    	$this->load->view('frontend/footer', $this->data);
    }

    function isLog() {
        if ($this->session->userdata('email') && $this->session->userdata('logged_in')) {
            $user = $this->db->where('email', $this->session->userdata('email'))->get('users')->row();
            if ($user) return $user;
        }
        return $this->db->where('user_id', 1)->get('users')->row();
    }

    function logout() {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('hash');
        redirect("/");
    }

    function clave() {
        if ($this->data['usuario']->user_id != 1) {
            if ($this->input->post("cambiopass")) {
                //if ($this->input->post("email") && $this->input->post("pass") && $this->input->post("pass") == $this->input->post("pass2") && $this->input->post("oldpass")) {
                //    if ($this->db->where(array('email' => $this->data['usuario']->email, 'password' => md5($this->input->post("oldpass"))))->count_all_results('users') == 1) {
                if ($this->input->post("pass") && $this->input->post("pass") == $this->input->post("pass2") && $this->input->post("oldpass")){
                    /*
                    echo "<br />llegan datos:";
                    echo "<br />".$this->input->post("oldpass");
                    echo "<br />".$this->input->post("pass");
                    echo "<br />".$this->input->post("pass2");
                    echo "<br />user_id: ".$this->data['usuario']->user_id;
                    */
                    if ($this->db->where(array('user_id' => $this->data['usuario']->user_id, 'password' => md5($this->input->post("oldpass"))))->count_all_results('users') == 1) {
                        //echo "<br />hay correspondencia";
                        
                        $datos = array(
                            'password' => md5($this->input->post('pass'))
                        );

                        $this->db->where('user_id', $this->data['usuario']->user_id)->update('users', $datos);

                        //$this->db->update('users', array('password' => md5($this->input->post("pass"))))->where('user_id', $this->data['usuario']->user_id);
                        //$this->db->update('users', array('password' => md5($this->input->post("pass"))))->where('user_id', $this->data['usuario']->user_id);
                        //echo "<br />".$this->db->last_query();
                        $this->data['cambiook'] = "La contraseña se ha modificado correctamente.";
                    }
                    else{
                        $this->data['cambioko'] = "No se ha podido modificar la contraseña.";
                    }
                }
                else{
                    $this->data['cambioko'] = "No se ha podido modificar la contraseña, los datos no son correctos.";
                }
            }
            $this->data['meta_title']='Cambiao tu contraseña';
            $this->data['meta_description']='Cambia latu contraseña de tu cuenta personal.';
            $this->load->view('frontend/header', $this->data);
            $this->data['a_migas']['/tienda/mi_cuenta']='Mi cuenta';
            $this->data['a_migas']['/tienda/clave']='Cambiar contraseña';
            $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);
            $this->load->view('frontend/cuentas/clave', $this->data);
            $this->load->view('frontend/footer', $this->data);
        }
    }

    function mi_cuenta($nueva='') {
        if ($this->data['usuario']->user_id != 1) {
            if ($this->input->post("cambiopass")) {
                if ($this->input->post("email") && $this->input->post("pass") && $this->input->post("pass") == $this->input->post("pass2") && $this->input->post("oldpass")) {
                    if ($this->db->where(array('email' => $this->data['usuario']->email, 'password' => md5($this->input->post("oldpass"))))->count_all_results('users') == 1) {
                        $this->db->update('users', array('password' => md5($this->input->post("pass"))))->where('email', $this->data['usuario']->email);
                        $this->data['cambiook'] = "La contraseña se ha modificado correctamente.";
                    }
                }
            }
            if ($this->input->post("cambiodatos")) {
                $datos = array(
                    'ord_demo_bill_name' => $this->input->post('b_name'),
                    'ord_demo_bill_company' => $this->input->post('b_company'),
                    'ord_demo_bill_address_01' => $this->input->post('b_add_01'),
                    'ord_demo_bill_address_02' => $this->input->post('b_add_02'),
                    'ord_demo_bill_city' => $this->input->post('b_city'),
                    'ord_demo_bill_state' => $this->input->post('b_state'),
                    'ord_demo_bill_post_code' => $this->input->post('b_post_code'),
                    'ord_demo_bill_country' => $this->input->post('b_country'),
                    'ord_demo_ship_name' => $this->input->post('s_name'),
                    'ord_demo_ship_company' => $this->input->post('s_company'),
                    'ord_demo_ship_address_01' => $this->input->post('s_add_01'),
                    'ord_demo_ship_address_02' => $this->input->post('s_add_02'),
                    'ord_demo_ship_city' => $this->input->post('s_city'),
                    'ord_demo_ship_state' => $this->input->post('s_state'),
                    'ord_demo_ship_post_code' => $this->input->post('s_post_code'),
                    'ord_demo_ship_country' => $this->input->post('s_country'),
                    'phone' => $this->input->post('phone')
                );

                $this->db->where('user_id', $this->data['usuario']->user_id)->update('users', $datos);
                $this->data['datosok'] = "Los datos se han modificado";
            }

            $this->data['meta_title']='Mis datos';
            $this->data['meta_description']='Tu espacio personal en línea: inicia sesión para acceder a tu historial y disfrutar de beneficios exclusivos. ¡Bienvenido a tu cuenta personal!';
            
            //$this->data['includes_header'][]='<link rel="stylesheet" href="/includes/mi_cuenta.css">';            
            //$this->data['includes_header'][]='<link rel="stylesheet" href="/includes/mi_cuenta.min.css">';            
            $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));
            $this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);
            
            $this->load->view('frontend/header', $this->data);
            $this->data['a_migas']['/tienda/mi_cuenta']='Mi cuenta';
            $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);
            $this->load->view('frontend/cuentas/micuenta', $this->data);
        } 
        else {
            if($nueva=='' || $this->nuevo_usuario){
                $this->data['meta_title']='Accede a tu cuenta en depapelpintado.es';
                $this->data['meta_description']='Tu espacio personal en línea: inicia sesión para acceder a tu historial y disfrutar de beneficios exclusivos. ¡Bienvenido a tu cuenta personal!';
                $this->load->view('frontend/header', $this->data);
                $this->data['a_migas']['/tienda/mi_cuenta']='Mi cuenta';
                $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);
                $this->load->view('frontend/cuentas/nologged', $this->data);
            }
            elseif($nueva=='nueva'){
                $registro_recaptcha_v3=new stdClass;
                $registro_recaptcha_v3->aktibaturik=true;
                $registro_recaptcha_v3->action='';
                $registro_recaptcha_v3->form_id='#login-form';

                $this->data['registro_recaptcha_v3']=$registro_recaptcha_v3;
                $this->data['meta_title']='Regístrate en depapelpintado.es';
                $this->data['meta_description']='Crea tu espacio personal en línea: regístrate para guardar tu historial y disfrutar de beneficios exclusivos. ¡Bienvenido a tu cuenta personal!';
                $this->load->view('frontend/header', $this->data);
                $this->data['a_migas']['/tienda/mi_cuenta/nueva']='Regístrate';
                $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);
                $this->load->view('frontend/cuentas/registroform', $this->data);
            }
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function mis_pedidos($ped = "0") {
        /*
        echo '<pre>';
        print_r($this->data['usuario']);
        echo '</pre>';
        exit;
        */
        if ($this->data['usuario']->user_id == 1)
            redirect("tienda");
        $this->load->library("flexi_cart_admin");
        $this->flexi_cart_admin->sql_order_by($this->flexi_cart_admin->db_column('order_summary', 'date'), 'desc');
        if ($ped == "0") {
            $this->data['order_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_demo_email" => $this->data['usuario']->email));
            //$this->data['order_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_user_fk" => $this->data['usuario']->user_id));
            //$this->data['order_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_user_fk" => 1));

            // Get any status message that may have been set.
            $this->data['message'] = $this->session->flashdata('message');
            $this->data['meta_title']='Mis pedidos';
            $this->data['meta_description']='Consulta tus pedidos';
            $this->load->view('frontend/header', $this->data);
            $this->data['a_migas']['/tienda/mi_cuenta']='Mi cuenta';
            $this->data['a_migas']['/tienda/mis_pedidos']='Mis pedidos';
            $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);
            $this->load->view('frontend/cuentas/pedidos', $this->data);
            $this->load->view('frontend/footer', $this->data);
        } 
        else {
            $this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped, "ord_demo_email" => $this->data['usuario']->email));
            //$this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped, "ord_user_fk" => $this->data['usuario']->user_id));
            //$this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped, "ord_user_fk" => 1));
            $sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $ped);
            $this->data['item_data'] = $this->db->select("*")->from("order_details")->where("ord_det_order_number_fk", $ped)->get()->result_array();
            $this->data['refund_data'] = $this->db->query("SELECT SUM(ord_det_quantity_cancelled * ord_det_price) AS ord_det_price, SUM(ord_det_quantity_cancelled * ord_det_discount_price) AS ord_det_discount_price, SUM(ord_det_quantity_cancelled * ord_det_tax) AS ord_det_tax, SUM(ord_det_quantity_cancelled * ord_det_shipping_rate) AS ord_det_shipping_rate, SUM(ord_det_quantity_cancelled * ord_det_weight) AS ord_det_weight, SUM(ord_det_quantity_cancelled * ord_det_reward_points) AS ord_det_reward_points FROM (`order_details`) WHERE `ord_det_order_number_fk` ='" . $ped . "'")->result_array();
            // Get any status message that may have been set.
            $this->data['message'] = $this->session->flashdata('message');

            $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));
            $this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);

            $this->data['meta_title']='Mis pedidos';
            $this->data['meta_description']='Consulta tus pedidos';
            $this->load->view('frontend/header', $this->data);
            $this->data['a_migas']['/tienda/mi_cuenta']='Mi cuenta';
            $this->data['a_migas']['/tienda/mis_pedidos']='Mis pedidos';
            $this->data['a_migas']['/tienda/mis_pedidos/'.$ped]='Nº ped: '.$ped;
            $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);
            $this->load->view('frontend/cuentas/pedido', $this->data);
            $this->load->view('frontend/footer', $this->data);
        }
    }

    /**
     * index
     * Forwards to 'view_cart'.
     */
    function seeorder($ped = "") {
        echo "test";
        $this->load->library("flexi_cart_admin");
        if ($ped != "") {
            $this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped));
            $sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $ped);
            $this->data['item_data'] = $this->db->select("*")->from("order_details")->where("ord_det_order_number_fk", $ped)->get()->result_array();
            $this->data['refund_data'] = $this->db->query("SELECT SUM(ord_det_quantity_cancelled * ord_det_price) AS ord_det_price, SUM(ord_det_quantity_cancelled * ord_det_discount_price) AS ord_det_discount_price, SUM(ord_det_quantity_cancelled * ord_det_tax) AS ord_det_tax, SUM(ord_det_quantity_cancelled * ord_det_shipping_rate) AS ord_det_shipping_rate, SUM(ord_det_quantity_cancelled * ord_det_weight) AS ord_det_weight, SUM(ord_det_quantity_cancelled * ord_det_reward_points) AS ord_det_reward_points FROM (`order_details`) WHERE `ord_det_order_number_fk` ='" . $ped . "'")->result_array();
            echo $this->load->view('frontend/cuentas/pedidoPlantilla', $this->data, TRUE);
        }
    }

    private function getPedido($ped) {
        $this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped, "ord_user_fk" => $this->data['usuario']->user_id));
        $sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $ped);
        $this->data['item_data'] = $this->db->select("*")->from("order_details")->where("ord_det_order_number_fk", $ped)->get()->result_array();
        $this->data['refund_data'] = $this->db->query("SELECT SUM(ord_det_quantity_cancelled * ord_det_price) AS ord_det_price, SUM(ord_det_quantity_cancelled * ord_det_discount_price) AS ord_det_discount_price, SUM(ord_det_quantity_cancelled * ord_det_tax) AS ord_det_tax, SUM(ord_det_quantity_cancelled * ord_det_shipping_rate) AS ord_det_shipping_rate, SUM(ord_det_quantity_cancelled * ord_det_weight) AS ord_det_weight, SUM(ord_det_quantity_cancelled * ord_det_reward_points) AS ord_det_reward_points FROM (`order_details`) WHERE `ord_det_order_number_fk` ='" . $ped . "'")->result_array();
        return $this->load->view('frontend/cuentas/pedidoPlantilla', $this->data, TRUE);
    }

    private function getDatosPedidoParaScript($ped) {
        $item_data = $this->db->select("*")->from("order_details")->join('demo_items', 'item_id = ord_det_item_fk')->join('demo_categories', 'item_cat_fk = cat_id')->where("ord_det_order_number_fk", $ped)->get()->result_array();
        $datos_pedido=array();
        foreach ($item_data as $key => $item) {
            $datos_pedido[$item['ord_det_item_fk']]['name']=$item['ord_det_item_name'];
            $datos_pedido[$item['ord_det_item_fk']]['id']=$item['ord_det_item_fk'];
            $datos_pedido[$item['ord_det_item_fk']]['unit_price']=$item['ord_det_discount_price']; //unitario
            $datos_pedido[$item['ord_det_item_fk']]['total_price']=$item['ord_det_discount_price_total']; //unitario
            $datos_pedido[$item['ord_det_item_fk']]['brand']=$item['cat_name'];
            $datos_pedido[$item['ord_det_item_fk']]['category']=$item['item_tipo'];
            $datos_pedido[$item['ord_det_item_fk']]['quantity']=$item['ord_det_quantity'];
        }
        $this->data['items_pedido']=$datos_pedido;

        $acumulado_pedido = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped, "ord_user_fk" => $this->data['usuario']->user_id));
        $datos_acumulados=array();
        foreach ($acumulado_pedido as $key => $item) {
            /*
            echo '<pre>';
            print_r($item);
            echo '</pre>';
            */
            $datos_acumulados['id']=$ped;
            //$datos_acumulados['revenue']=$item['ord_item_summary_total'];  // Total transaction value (incl. tax and shipping)
            $datos_acumulados['revenue']=$item['ord_item_shipping_total'];  // Total transaction value (incl. tax and shipping)
            $datos_acumulados['tax']=$item['ord_tax_total'];
            $datos_acumulados['shipping']=$item['ord_shipping_total'];
        }
        $this->data['acumulado_pedido'] = $datos_acumulados;

        return $this->data;
    }

    private function getDatosPedidoParaScriptGA4($ped) {
        $item_data = $this->db->select("*")->from("order_details")->join('demo_items', 'item_id = ord_det_item_fk')->join('demo_categories', 'item_cat_fk = cat_id')->where("ord_det_order_number_fk", $ped)->get()->result_array();
        $datos=array();
        $datos_pedido=array();
        foreach ($item_data as $key => $item) {
            $datos_pedido[$item['ord_det_item_fk']]['name']=$item['ord_det_item_name'];
            $datos_pedido[$item['ord_det_item_fk']]['id']=$item['ord_det_item_fk'];
            $datos_pedido[$item['ord_det_item_fk']]['unit_price']=$item['ord_det_discount_price']; //unitario
            $datos_pedido[$item['ord_det_item_fk']]['total_price']=$item['ord_det_discount_price_total']; //unitario
            $datos_pedido[$item['ord_det_item_fk']]['brand']=$item['cat_name'];
            $datos_pedido[$item['ord_det_item_fk']]['category']=$item['item_tipo'];
            $datos_pedido[$item['ord_det_item_fk']]['quantity']=$item['ord_det_quantity'];
        }
        $datos['items_pedido']=$datos_pedido;

        $acumulado_pedido = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped, "ord_user_fk" => $this->data['usuario']->user_id));
        $datos_acumulados=array();
        $datos_acumulados['id']=$ped;
        foreach ($acumulado_pedido as $key => $item) {
            /*
            echo '<pre>';
            print_r($item);
            echo '</pre>';
            */
            //$datos_acumulados['revenue']=$item['ord_item_summary_total'];  // Total transaction value (incl. tax and shipping)
            $datos_acumulados['revenue']=$item['ord_item_shipping_total'];  // Total transaction value (incl. tax and shipping)
            $datos_acumulados['tax']=$item['ord_tax_total'];
            $datos_acumulados['shipping']=$item['ord_shipping_total'];
            $datos_acumulados['ord_demo_ship_name']=$item['ord_demo_ship_name'];
            $datos_acumulados['ord_demo_email']=$item['ord_demo_email'];
        }
        $datos['acumulado_pedido'] = $datos_acumulados;

        return $datos;
    }

    private function getFactura($ped) {
        $this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped, "ord_user_fk" => $this->data['usuario']->user_id));
        $sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $ped);
        $this->data['item_data'] = $this->db->select("*")->from("order_details")->where("ord_det_order_number_fk", $ped)->get()->result_array();
        $this->data['refund_data'] = $this->db->query("SELECT SUM(ord_det_quantity_cancelled * ord_det_price) AS ord_det_price, SUM(ord_det_quantity_cancelled * ord_det_discount_price) AS ord_det_discount_price, SUM(ord_det_quantity_cancelled * ord_det_tax) AS ord_det_tax, SUM(ord_det_quantity_cancelled * ord_det_shipping_rate) AS ord_det_shipping_rate, SUM(ord_det_quantity_cancelled * ord_det_weight) AS ord_det_weight, SUM(ord_det_quantity_cancelled * ord_det_reward_points) AS ord_det_reward_points FROM (`order_details`) WHERE `ord_det_order_number_fk` ='" . $ped . "'")->result_array();
        return $this->load->view('frontend/cuentas/facturaPlantilla', $this->data, TRUE);
    }

    function milistado() {
        $dd = $this->db->from("demo_items")->join('demo_categories', 'item_cat_fk = cat_id')->where("item_coleccion_id", 0)->where("demo_items.activo", 1)->order_by("item_cat_fk")->get()->result_array();
        $count = 1;
        foreach ($dd as $row) {
            echo $count . " --- " . $row['item_ref'] . " --- " . $row["cat_name"] . "<br/>";
            $count++;
        }
    }

    private function captcha_v3_balidatu(){
        $token = $_POST['token']; 
        $action = $_POST['action']; 
        $responseData=new stdClass();
        $responseData->success=0;
        if(isset($token) && !empty($token)){ 
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.RECAPTCHA_V3_SECRET.'&response='.$token); 
            $responseData = json_decode($verifyResponse); 
        }
        
        return $responseData;
    }

    function index() {
        // introducir aqui el contenido a mostrar en los metas
        //  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $meta_datos['title']='Inicio - De Papel Pintado';
        
        $this->data['meta_datos'] = $meta_datos;

        $this->data['categ'] = -1;
        
        $this->data['portada'] = $this->contenido_model->get_page(1);
        $this->data['promosl'] = $this->contenido_model->get_promos();
        $this->data['promosr'] = $this->contenido_model->get_promos(false);
        $this->data['images'] = $this->contenido_model->get_imagenes(true, "home");
        $this->data['mosaico'] = $this->contenido_model->get_imagenes_admin(true, 'mosaico');
        $this->data['novedades'] = $this->flexi_cart_model->get_items_portada(8);
        $this->data['estancias_home'] = $this->flexi_cart_model->get_estancias_home(0, 4);
        $this->data['fab'] = $this->flexi_cart_model->get_categories();
        $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample();
        $this->data['col'] = $this->flexi_cart_model->get_col_array();
        $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
        $this->data['gama'] = $this->flexi_cart_model->get_gamas();
        $this->data['estilo'] = $this->flexi_cart_model->get_estilos();
        //$this->data['all']=$this->flexi_cart_model->get_items_filter();

        $this->load->model('demo_cart_admin_model');
        $this->data['faqs'] = $this->demo_cart_admin_model->get_faqs_frontend('home', 0);

        $recaptcha_v3=new stdClass;
        $recaptcha_v3->aktibaturik=true;
        $recaptcha_v3->action='';
        $recaptcha_v3->form_id='#newsletter';


        if($this->input->post("token")){
            $captcha_balidazioa=$this->captcha_v3_balidatu();
            /*
            print '<pre><xmp>';
            print_r($captcha_balidazioa);
            print '</xmp></pre>';
            */
            if ($captcha_balidazioa->success){
                $this->load->helper('email');
                if (valid_email($this->input->post("email_newsletter"))){
                    $this->data['notificacion_modal']='ok';
                    $suscripcion_ok=$this->newsletter('home', $_POST);
                    /*
                    if ($suscripcion_ok){
                        echo "suscripcion_ok";
                        exit;
                        $this->data['notificacion_modal']='ok';
                    }
                    */
                }
            }
        }
        $this->data['recaptcha_v3']=$recaptcha_v3;

        $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/html-slider.css">';            

        if (isset($_GET['test']) && $_GET['test']=='eneko')
            $this->load->view('frontend/header_eneko', $this->data);
        else
            $this->load->view('frontend/header', $this->data);

        if (isset($_POST['search']) && trim($_POST['search']) != "") {
            $search = $_POST['search'];
            $this->data['all'] = $this->flexi_cart_model->search_items($search, 0);
            $this->load->view('frontend/cuerposeccion', $this->data);
        } else {
            //$this->load->view('frontend/slider', $this->data);
            $this->load->view('frontend/slider_nuevo', $this->data);
            $this->load->view('frontend/home', $this->data);
            $this->load->view('frontend/widget_resenas', $this->data);
        }
        //    $this->load->view('frontend/estilos', $this->data);
        //$this->data['includes_footer'][]='<script src="/includes/js/home.js"></script>';   // lo renombramos por el hackeo del recaptchca cloudflare
        $this->data['includes_footer'][]='<script src="/includes/js/sarrera.js"></script>';            
        if (isset($_GET['test']) && $_GET['test']=='eneko')
            $this->load->view('frontend/footer_eneko', $this->data);
        else
            $this->load->view('frontend/footer', $this->data);
        //RESTUARAR
        //$this->view_cart();
        //redirect('admin_library/articulos');
    }
    function alta_newsletter(){
        if($this->input->post("token")){
            $captcha_balidazioa=$this->captcha_v3_balidatu();
            /*
            print '<pre><xmp>';
            print_r($captcha_balidazioa);
            print '</xmp></pre>';
            */
            if ($captcha_balidazioa->success){
                $this->load->helper('email');
                if (valid_email($this->input->post("email_newsletter"))){
                    $this->data['notificacion_modal']='ok';
                    $suscripcion_ok=$this->newsletter('home', $_POST);
                    /*
                    if ($suscripcion_ok){
                        echo "suscripcion_ok";
                        exit;
                        $this->data['notificacion_modal']='ok';
                    }
                    */
                }
            }
        }
    }

    function busqueda() {
        // AJAX autocomplete request
        if ($this->input->get('ajax') == '1') {
            header('Content-Type: application/json');
            $search = $this->input->get('q', TRUE);
            if (empty($search) || strlen($search) < 2) {
                echo json_encode(array());
                return;
            }
            $results = $this->flexi_cart_model->search_items_autocomplete($search);
            echo json_encode($results);
            return;
        }

        if (isset($_POST['search']) && trim($_POST['search']) != "") {
            /*
            print '<pre><xmp>';
            print_r($_POST);
            print '</xmp></pre>';
            exit;
            */
            // introducir aqui el contenido a mostrar en los metas

            $this->data['categ'] = -1;
            /*
            $this->data['portada'] = $this->contenido_model->get_page(1);
            $this->data['promosl'] = $this->contenido_model->get_promos();
            $this->data['promosr'] = $this->contenido_model->get_promos(false);
            $this->data['images'] = $this->contenido_model->get_imagenes(true, "home");
            $this->data['fab'] = $this->flexi_cart_model->get_categories();
            $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample();
            $this->data['col'] = $this->flexi_cart_model->get_col_array();
            $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
            $this->data['gama'] = $this->flexi_cart_model->get_gamas();
            $this->data['estilo'] = $this->flexi_cart_model->get_estilos();
            //$this->data['all']=$this->flexi_cart_model->get_items_filter();
        */      

            //$orden = 0;
            $orden = 4; // Por defecto el más reciente primero (id descendente)
            if (isset($_REQUEST['orden']))
                $orden = $_REQUEST['orden'];
            $ord = $this->orden($orden);
            $this->data['orden_seleccionado'] = $orden;

            $this->data['meta_title']='Resultado de la Busqueda'; 
            $this->data['meta_description']='Resultado de la Busqueda'; 
            $this->data['texto_h1_seccion']='Resultado de la Busqueda'; 

            $this->data['a_migas']['busqueda']='Búsqueda';

            //$this->data['includes_footer'][]='<script src="/includes/js/listado-productos.js"></script>';            
            $this->data['includes_footer'][]='<script src="/includes/js/listado-productos.min.js?v=2"></script>';            
            
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/migas_nuevas_small', $this->data);
            $search = $_POST['search'];
            $this->data['all'] = $this->flexi_cart_model->search_items($search, 0);
            //echo "<br />".$this->db->last_query();
            //$this->load->view('frontend/cuerposeccion-sin-filtros', $this->data);
            $this->load->view('frontend/cuerposeccion-busqueda', $this->data);
            $this->load->view('frontend/footer', $this->data);
        } 
        else{
            redirect('/');
        }
    }

    function tienda($param1='', $param2='', $param3='', $param4='', $param5='', $param6=''){
        $this->error_url($_SERVER['SCRIPT_URL']);
        /*
        echo "<br />parametro duplicado tienda";
        print '<pre><xmp>';
        print_r($_SERVER['SCRIPT_URL']);
        print '</xmp></pre>';
        */
    }

    function comprobar_url($url, $param1='', $param2='', $param3=''){
        if ($url=='papeles-pintados-vegetacion')
            $url='papel-pintado-vegetacion';
        $categoria_seo=$this->flexi_cart_model->get_categoria_seo_by_name($url);
        if (count($categoria_seo)){
            // Se trata de una de las categorías nuevas
            $this->listado_nueva_categoria($categoria_seo[0]);
        }
        else{
            switch (trim($url)) {
                case 'papel-pintado':
                    $this->listado_productos_nuevo($url);
                    break;
                case 'papel-pintado-categorias':
                    $idnueva_categoria_familia=0;
                    $this->listado_categorias_nuevo(0, $idnueva_categoria_familia);
                    break;
                case 'estilos-papel-pintado':
                    $idnueva_categoria_familia=1;
                    $this->listado_categorias_nuevo(0, $idnueva_categoria_familia);
                    break;
                case 'marcas-papel-pintado':
                    $txt_marca=$param1;
                    $id_marca=$param2;
                    $id_coleccion=$param3;
                    if ((int)$id_coleccion!=0)
                        $this->listado_productos_coleccion('papel-pintado', $id_coleccion);
                    elseif ((int)$id_marca!=0)
                        $this->listado_marcas(0, $id_marca);
                    else
                        $this->listado_marcas(0);
                    break;
                case 'estilos-murales':
                case 'estilos-fotomurales':
                    $idnueva_categoria_familia=1;
                    $this->listado_categorias_nuevo(1, $idnueva_categoria_familia);
                    break;
                case 'estilos-revestimientos':
                    $idnueva_categoria_familia=1;
                    $this->listado_categorias_nuevo(2, $idnueva_categoria_familia);
                    break;
                case 'estilos-telas':
                    $idnueva_categoria_familia=1;
                    $this->listado_categorias_nuevo(3, $idnueva_categoria_familia);
                    break;
                case 'estilos-alfombras':
                    $idnueva_categoria_familia=1;
                    $this->listado_categorias_nuevo(4, $idnueva_categoria_familia);
                    break;
                default:
                    $this->error_url($url);
                    break;
            }
        }
    }
    function error_url($url){
        $this->load->library('email');
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@depapelpintado.es', 'dePapelPintado');
        $this->email->to('enanclares77@gmail.com');

        $mensaje="<p>No se ha encontrado la siguiente url:<br />$url";
        $this->email->subject('Error url, no encontrada');
        $this->email->message($mensaje);

        //$this->email->send();
        
        $this->load->view('frontend/header', $this->data);
        $this->load->view('frontend/noencontrado_nuevo', $this->data);
        $this->load->view('frontend/footer', $this->data);
    }

    function listado_categorias_nuevo($tipo_producto=0, $idnueva_categoria_familia=0){
        // Vista de las categorías SEO con su foto para un tipo de producto 
        // Si la familia es 0, se muestran todas, si no la familia seleccionada (1 para estilos por ejemplo) 
        $this->data['categ'] = $tipo_producto;
        $this->data['idnueva_categoria_familia'] = $idnueva_categoria_familia;

        $this->data['menu_categorias_seo']=$this->flexi_cart_model->get_categorias_seo_menu($this->data['categ'], $idnueva_categoria_familia);
        $this->data['menu_categorias_seo_diferenciadas']=$this->flexi_cart_model->get_categorias_seo_diferenciadas_menu($this->data['categ']);

        $this->data['filtros_categoria']=$this->flexi_cart_model->get_datos_filtros_categoria();
        
        $categ = "";
        switch ($this->data['categ']) {
            case 0: 
                $url_categoria_principal='papel-pintado';
                $url_tienda='tienda/papel_pintado';
                $categ = "Papel Pintado";
                $categ_txt_desc = "Todos los papeles pintados agrupados";
                break;
            case 1:
                $url_categoria_principal='murales';
                $url_tienda='tienda/murales';
                $categ = "Murales";
                $categ_txt_desc = "Todos los murales agrupados";
                break;
            case 2: 
                $url_categoria_principal='revestimientos';
                $url_tienda='tienda/revestimientos';
                $categ = "Revestimientos";
                $categ_txt_desc = "Todos los revestimientos agrupados";
                break;
            case 3: 
                $url_categoria_principal='telas';
                $url_tienda='tienda/telas';
                $categ = "Telas";
                $categ_txt_desc = "Todas las telas agrupadas";
                break;
            case 4: 
                $url_categoria_principal='alfombras';
                $url_tienda='tienda/alfombras';
                $categ = "Alfombras";
                $categ_txt_desc = "Todas las alfombras agrupadas";
                break;
            case 5: 
                $categ = "Herramientas";
                $categ_txt_desc = "herramientas";
                break;
            default: break;
        }
        $this->data['familia_producto'] = $categ;

        $this->data['a_migas'][$url_tienda]=$categ;

        $this->data['title2'] ='title2'; //title2 para evitar que añada depapelpintado al final
        $this->data['description2'] ='description2'; //title2 para evitar que añada depapelpintado al final

        switch ($idnueva_categoria_familia) {
            case 1:
                //$this->data['texto_h1_seccion']='Categorías de '.$categ; 
                $this->data['texto_h1_seccion']=$this->data['filtros_categoria'][$idnueva_categoria_familia]->nombre_familia_categoria_txt.' '.$categ; 
                $this->data['meta_title'] ='Todos los estilos de '.$categ; //title2 para evitar que añada depapelpintado al final
                $this->data['meta_description'] = $categ_txt_desc.' por estilos, seguro que tenemos lo que buscas. ¡Visítanos!'; //title2 para evitar que añada depapelpintado al final
                
                $this->data['a_migas']['estilos-'.$url_categoria_principal]='Estilos';
                break;
            default: 
                $this->data['texto_h1_seccion']='Categorías de '.$categ; 
                $this->data['a_migas'][$url_categoria_principal.'-categorias']='Categorías';
                break;
        }
        $this->data['texto__intro_seo']= 'texto__intro_seo'; 
        
        $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            
            
        $this->load->view('frontend/header', $this->data);
        //$this->load->view('frontend/migas_nuevas_small', $this->data);
        $this->load->view('frontend/listado-categorias', $this->data);
        $this->load->view('frontend/footer', $this->data);
    }

    function listado_nueva_categoria($categoria_seo){
        // Listado de productos de una categoría  SEO concreta
        //$this->output->cache(10);

        //$orden = 0;
        $orden = 4; // Por defecto el más reciente primero (id descendente)
        if (isset($_REQUEST['orden']))
            $orden = $_REQUEST['orden'];
        $this->data['orden_seleccionado'] = $orden;
        $ord = $this->orden($orden);
        
        $this->data['categ'] = $categoria_seo->tipo_producto;
        $categ = "";
        switch ($this->data['categ']) {
            case 0: $categ = "Papel Pintado";
                    $categoria_principal='tienda/papel_pintado';
                    $link_estilos='estilos-papel-pintado';
                    break;
            case 1: $categ = "Murales";
                    $categoria_principal='tienda/murales';
                    $link_estilos='estilos-murales';
                    break;
            case 2: $categ = "Revestimientos";
                    $categoria_principal='tienda/revestimientos';
                    $link_estilos='estilos-revestimientos';
                    break;
            case 3: $categ = "Telas";
                    $categoria_principal='tienda/telas';
                    $link_estilos='estilos-telas';
                    break;
            case 4: $categ = "Alfombras";
                    $categoria_principal='tienda/alfombras';
                    $link_estilos='estilos-alfombras';
                    break;
            case 5: $categ = "Herramientas";
                    break;
            default: break;
        }
        $this->data['familia_producto'] = $categ;

        //Fin cabeceras economicos
        $this->data['meta_title'] =$categoria_seo->meta_title_categoria; //title2 para evitar que añada depapelpintado al final
        $this->data['meta_description'] =$categoria_seo->meta_description_categoria; //title2 para evitar que añada depapelpintado al final

        $this->data['url_canonica']=base_url().$categoria_seo->nueva_categoria_name_url;

        $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            
        //$this->data['includes_footer'][]='<script src="/includes/js/listado-productos.js"></script>';            
        $this->data['includes_footer'][]='<script src="/includes/js/listado-productos.min.js?v=2"></script>';            
        
        $this->load->view('frontend/header', $this->data);

        $this->data['categoria_seo']=$categoria_seo; 
        
        if ($this->data['categ']==0)
            $this->data['menu_categorias_seo']=$this->flexi_cart_model->get_categorias_seo_menu_sin_estilos($this->data['categ']);
        else
            $this->data['menu_categorias_seo']=$this->flexi_cart_model->get_categorias_seo_menu($this->data['categ']);

        $this->data['menu_categorias_seo_diferenciadas']=$this->flexi_cart_model->get_categorias_seo_diferenciadas_menu($this->data['categ']);

        $this->data['texto_h1_seccion']=$categoria_seo->h1_categoria; 
        $this->data['texto__intro_seo']= $categoria_seo->descripcion_categoria; 
       
        $id_coleccion_seo = isset($_REQUEST['id_coleccion']) ? (int)$_REQUEST['id_coleccion'] : 0;
        if ($id_coleccion_seo > 0)
            $this->data['id_coleccion'] = $id_coleccion_seo;
        $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_izquierda_listado( $categoria_seo->tipo_producto, $categoria_seo->nueva_categoria_id, $id_coleccion_seo);
        /*
        if ($categoria_seo->nueva_categoria_id==110){
            print '<pre><xmp>';
            print_r($this->data);
            print '</xmp></pre>';
            exit;
        }
        */
        $pagina_actual = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 0;
        $this->data['pagina_actual'] = $pagina_actual;
        $this->data['registros_por_pagina'] = 42;
        $this->data['total_productos'] = $this->flexi_cart_model->count_items_filtros_nuevo_listado($categoria_seo->tipo_producto, $this->data['filtros_categorias_seo']['ids_categoria'], $categoria_seo->nueva_categoria_id);
        $this->data['all'] = $this->flexi_cart_model->get_items_filtros_nuevo_listado($categoria_seo->tipo_producto, $this->data['filtros_categorias_seo']['ids_categoria'], $pagina_actual, $ord, $categoria_seo->nueva_categoria_id);
        
        $this->data['a_migas'][$categoria_principal]=$categ;

        if ($categoria_seo->idnueva_categoria_familia==1)
            $this->data['a_migas'][$link_estilos]='Estilos';

        $this->data['a_migas'][$categoria_seo->nueva_categoria_name_url]=$categoria_seo->nueva_categoria_name;
        
        $this->data['ocultar_submenu']=true;
        $this->data['mostrar_estilos_viejos']=true;

        $this->load->model('demo_cart_admin_model');
        $this->data['faqs'] = $this->demo_cart_admin_model->get_faqs_frontend('categoria', $categoria_seo->nueva_categoria_id);

        if (isset($_GET['eneko'])){
            print '<pre><xmp>';
            print_r($this->data);
            print '</xmp></pre>';
            exit;
        }
        //    $this->load->view('frontend/cuerposeccion-categorias-seo-con-filtros-nuevo', $this->data);
        //else
            $this->load->view('frontend/cuerposeccion-categorias-seo-con-filtros', $this->data);
            

        $this->load->view('frontend/footer', $this->data);
    }
    function get_next_categoria_seo_filtros($page = -1, $ord = '') {
        // Siguiente página del listado de productos de una categoría  SEO concreta
        //$ord=$this->orden("1");
        if (isset($_POST['ord']) && $_POST['ord'] != "")
            $ord = $this->orden($_POST['ord']);
        
        if (isset($_POST['id_nueva_categoria_seo']) && $_POST['id_nueva_categoria_seo'] != "")
            $id_nueva_categoria_seo = $_POST['id_nueva_categoria_seo'];

        $categoria_seo=$this->flexi_cart_model->get_categoria_seo($id_nueva_categoria_seo);
        
        $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_izquierda_listado( $categoria_seo[0]->tipo_producto, $categoria_seo[0]->nueva_categoria_id);
        //$this->data['all'] = $this->flexi_cart_model->get_items_categoria_seo_filtros($categoria_seo[0], $this->data['filtros_categorias_seo']['ids_categoria'], $page, $ord);
        $this->data['all'] = $this->flexi_cart_model->get_items_filtros_nuevo_listado($categoria_seo[0]->tipo_producto,$this->data['filtros_categorias_seo']['ids_categoria'],$page,$ord,$id_nueva_categoria_seo);

        $this->data['categ'] = $categoria_seo[0]->tipo_producto;
        
        $this->load->view('frontend/articulo_cards', $this->data);
    }

    function listado_productos_nuevo($categoria_principal, $param1='', $param2='', $param3='', $param4='', $param5=''){
        ini_set('memory_limit', '1G');
        // Todos los artículos de un tipo de producto
        // La llamamos desde las antiguas funciones de tipos de productos (papel_pintado, fotomurales...)
        //echo "<br />$categoria_principal";
        $this->data['productos_outlet']=false;
        $this->data['mostrar_categorias_seo']=true;
        $this->data['idcoleccion'] = 0;
        //$this->data['enlace_marcas']='marcas-'.$categoria_principal;
        $this->data['enlace_marcas']='tienda/'.$categoria_principal.'/marcas';
        $this->data['enlace_estilos']='estilos-'.$categoria_principal;
        $categ = "";
        // Fase 2 SEO: el canonical debe apuntar a la URL amigable, no a /tienda/...
        $mapa_url_amigable = array(
            'papel-pintado' => 'papel-pintado', 'papel-pintado-economico' => 'outlet',
            'murales' => 'murales', 'fotomurales' => 'murales',
            'revestimientos' => 'revestimientos', 'telas' => 'telas',
            'alfombras' => 'alfombras', 'herramientas' => 'herramientas',
            'complementos' => 'complementos',
        );
        $slug_canonico = isset($mapa_url_amigable[$categoria_principal]) ? $mapa_url_amigable[$categoria_principal] : $categoria_principal;
        switch ($categoria_principal) {
            case 'papel-pintado': 
                $categ = "Papel Pintado";
                $categoria_principal='tienda/papel_pintado';
                $this->data['enlace_marcas']=$categoria_principal.'/marcas';
                $this->data['categ']=0;
                $this->data['meta_title']='Papel pintado para Pared - Amplio Catálogo'; 
                $this->data['meta_description']='Elige el Papel Pintado que mejor se adapte a tu ambiente. En nuestro amplio catálogo con las últimas novedades y más de 1000 muestrarios encontrarás lo que buscas. ¡Visítanos!'; 
                $this->data['texto_h1_seccion']='Papeles Pintados'; 
                $this->data['texto__intro_seo']= $this->load->view('textos_seo/papel-pintado-seo', $this->data, true); 
                //$this->data['alt_slider']='papel-pintado';
                //$this->data['images'] = $this->contenido_model->get_imagenes(true, "papelpintado");
                $this->data['url_canonica']=base_url().$slug_canonico;
                break;
            case 'papel-pintado-economico': 
                $categ = "Outlet";
                $categoria_principal='tienda/papel_pintado/economicos';
                $this->data['enlace_marcas']='';
                $this->data['enlace_estilos']='';
                $this->data['categ']=0;
                $this->data['meta_title']='Papel Pintado barato, ¡ahorra hasta un 70%!'; 
                $this->data['meta_description']='El mejor Papel Pintado outlet. Gran variedad de papeles pintados en liquidación con descuentos de hasta el 70% en nuestro amplio catálogo. ¡Visítanos!'; 
                $this->data['texto_h1_seccion']='Papeles Pintados Outlet'; 
                $this->data['texto__intro_seo']= $this->load->view('textos_seo/outlet-seo', $this->data, true); 
                //$this->data['images'] = $this->contenido_model->get_imagenes(true, "economicos");
                $this->data['url_canonica']=base_url().$slug_canonico;
                $this->data['productos_outlet']=true;
                $this->data['mostrar_categorias_seo']=false;
                $this->data['ocultar_marcas']=true;
                break;
            case 'murales':
            case 'fotomurales':
                $categ = "Murales";
                $categoria_principal='tienda/murales';
                $this->data['categ']=1;
                $this->data['meta_title']='Murales - Personaliza tu Espacio';
                $this->data['meta_description']='Elige tu Mural y consigue el efecto deseado en tu estancia. En nuestro amplio catálogo encontrarás lo que buscas. ¡Visítanos!';
                $this->data['texto_h1_seccion']='Murales';
                $this->data['texto__intro_seo']= $this->load->view('textos_seo/fotomurales-seo', $this->data, true);
                //$this->data['alt_slider']='fotomurales';
                //$this->data['images'] = $this->contenido_model->get_imagenes(true, "papelpintado");
                $this->data['url_canonica']=base_url().$slug_canonico;
                break;
            case 'revestimientos': 
                $categ = "Revestimientos";
                $categoria_principal='tienda/revestimientos';
                $this->data['categ']=2;
                $this->data['meta_title']='Revestimientos de Pared'; 
                $this->data['meta_description']='Elige el Revestimiento adecuado para tu espacio y decora tu pared. En nuestro amplio catálogo encontrarás lo que buscas. ¡Visítanos!'; 
                $this->data['texto_h1_seccion']='Revestimientos'; 
                $this->data['texto__intro_seo']= $this->load->view('textos_seo/revestimientos-seo', $this->data, true); 
                //$this->data['alt_slider']='fotomurales';
                //$this->data['images'] = $this->contenido_model->get_imagenes(true, "papelpintado");
                $this->data['url_canonica']=base_url().$slug_canonico;
                break;
            case 'telas': 
                $categ = "Telas";
                $categoria_principal='tienda/telas';
                $this->data['categ']=3;
                $this->data['meta_title']='Telas Online - Amplio Catálogo'; 
                $this->data['meta_description']='Elige la Tela  para decorar tu estancia con personalidad. En nuestro amplio catálogo encontrarás lo que buscas. ¡Visítanos!'; 
                $this->data['texto_h1_seccion']='Telas'; 
                $this->data['texto__intro_seo']= $this->load->view('textos_seo/telas-seo', $this->data, true); 
                //$this->data['alt_slider']='fotomurales';
                //$this->data['images'] = $this->contenido_model->get_imagenes(true, "papelpintado");
                $this->data['url_canonica']=base_url().$slug_canonico;
                break;
            case 'alfombras': 
                $categ = "Alfombras";
                $categoria_principal='tienda/alfombras';
                $this->data['categ']=4;
                $this->data['meta_title']='Alfombras a medida'; 
                $this->data['meta_description']='Elige la Alfombra que encaje con tu decoración. En nuestro amplio catálogo encontrarás lo que buscas. Visítanos!'; 
                $this->data['texto_h1_seccion']='Alfombras'; 
                $this->data['texto__intro_seo']= $this->load->view('textos_seo/alfombras-seo', $this->data, true); 
                //$this->data['alt_slider']='fotomurales';
                //$this->data['images'] = $this->contenido_model->get_imagenes(true, "papelpintado");
                $this->data['url_canonica']=base_url().$slug_canonico;
                break;
            case 'herramientas': 
                $categ = "Herramientas";
                $categoria_principal='tienda/herramientas';
                $this->data['enlace_marcas']='';
                $this->data['enlace_estilos']='';
                $this->data['categ']=5;
                $this->data['meta_title']='Colocar Papel Pintado -  Herramientas'; 
                $this->data['meta_description']='Todo lo que necesitas para colocar el papel pintado. En nuestro amplio catálogo encontrarás lo que buscas. Visítanos!'; 
                $this->data['texto_h1_seccion']='Herramientas para empapelar'; 
                $this->data['texto__intro_seo']= $this->load->view('textos_seo/herramientas-para-empapelar-seo', $this->data, true); 
                //$this->data['alt_slider']='fotomurales';
                //$this->data['images'] = $this->contenido_model->get_imagenes(true, "papelpintado");
                $this->data['url_canonica']=base_url().$slug_canonico;
                break;
            case 'complementos':
                $categ = "Complementos";
                $categoria_principal='tienda/complementos';
                $this->data['enlace_marcas']='';
                $this->data['enlace_estilos']='';
                $this->data['categ']=6;
                $this->data['meta_title']='Complementos de decoración';
                $this->data['meta_description']='Complementos de decoración para el hogar. Encuentra todo lo que necesitas en nuestra tienda online.';
                $this->data['texto_h1_seccion']='Complementos';
                $this->data['texto__intro_seo']='';
                $this->data['url_canonica']=base_url().$slug_canonico;
                break;
            default: break;
        }

        $tipo_producto_seo= $this->flexi_cart_model->get_tipo_producto_seo($this->data['categ']);
        if (isset($tipo_producto_seo[0])){
            if (trim($tipo_producto_seo[0]->descripcion_tipo_producto)!='')
                $this->data['texto__intro_seo']=$tipo_producto_seo[0]->descripcion_tipo_producto;
            
            if (trim($tipo_producto_seo[0]->meta_title_tipo_producto)!='')
                $this->data['meta_title']=$tipo_producto_seo[0]->meta_title_tipo_producto;
            
            if (trim($tipo_producto_seo[0]->meta_description_tipo_producto)!='')
                $this->data['meta_description']=$tipo_producto_seo[0]->meta_description_tipo_producto;
        } 


        $this->data['categoria_principal'] = $categoria_principal;
        $this->data['a_migas'][base_url().$categoria_principal]=$categ;

        //$orden = 0;
        $orden = 4; // Por defecto el más reciente primero (id descendente)
        if (isset($_REQUEST['orden']))
            $orden = $_REQUEST['orden'];
        $this->data['orden_seleccionado'] = $orden;
        $ord = $this->orden($orden);


        /*
        print '<pre><xmp>';
        print_r($this->data);
        print '</xmp></pre>';
        exit;
        $this->load->model('contenido_model');
        $this->data['portada'] = $this->contenido_model->get_page(1);
        $this->data['promosl'] = $this->contenido_model->get_promos();
        $this->data['promosr'] = $this->contenido_model->get_promos(false);
        
        
        $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample();
        $this->data['fab'] = $this->flexi_cart_model->get_categories("Papel Pintado");
        $this->data['col'] = $this->flexi_cart_model->get_col_array();
        $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
        $this->data['gama'] = $this->flexi_cart_model->get_gamas();
        $this->data['estilo'] = $this->flexi_cart_model->get_estilos();
        */
        
        //$this->data['all'] = $this->flexi_cart_model->get_items_categoria_seo($categoria_seo, null, $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $ord);
        /*
        $this->data['all'] = $this->flexi_cart_model->get_items_filter($this->data['donden']['marca'], $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $this->data['categ'], $econ, $losmas, $ord);
        $this->db->cache_on();
        $this->data['all'] = $this->flexi_cart_model->get_items_filter($this->data['donden']['marca'], $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $this->data['categ'], $econ, $losmas, $ord);
        $this->db->cache_off();
        */
        $this->data['familia_producto'] = $categ;
        
        $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            
        //$this->data['includes_footer'][]='<script src="/includes/js/listado-productos.js"></script>';            
        $this->data['includes_footer'][]='<script src="/includes/js/listado-productos.min.js?v=2"></script>';            

        if (isset($_GET['test']) && $_GET['test']=='eneko')
            $this->load->view('frontend/header_eneko', $this->data);
        else
            $this->load->view('frontend/header', $this->data);
        /*
        $this->data['nombre_listado'] = 'Listado papeles pintados';
        $this->data['id_listado'] = 'listado_papeles_pintados';
        $this->data['menu_categorias_seo']=$this->flexi_cart_model->get_categorias_seo_menu_sin_estilos($this->data['categ']);
        $this->data['menu_categorias_seo_diferenciadas']=$this->flexi_cart_model->get_categorias_seo_diferenciadas_menu($this->data['categ']);
        $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_nuevo_listado($this->data['categ']);
        print '<pre><xmp>';
        print_r($this->data['filtros_categorias_seo']);
        print '</xmp></pre>';
        exit;
        $this->data['all'] = $this->flexi_cart_model->get_items_nuevo_listado_filtros($this->data['categ'], $this->data['filtros_categorias_seo']['ids_categoria'], 0, $ord);
        */
        //$this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_nuevo_listado($this->data['categ']);
        $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_izquierda_listado($this->data['categ'], 0, 0, $this->data['productos_outlet']);
        $this->data['menu_categorias_seo'] = isset($this->data['filtros_categorias_seo']['menu_categorias_seo'])
            ? $this->data['filtros_categorias_seo']['menu_categorias_seo']
            : array();
        
        
        //$fab=null,$estilo=null,$gama=null,$page=-1, $categ=0, $econ=0,$losmas=0,  $order=''
        //$this->data['all'] = $this->flexi_cart_model->get_items_filter(0, 0, 0, 0, $this->data['categ'], 0, 0, $ord);
        
        $pagina_actual = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 0;
        $this->data['pagina_actual'] = $pagina_actual;
        $this->data['registros_por_pagina'] = 42;
        $this->data['total_productos'] = count($this->data['filtros_categorias_seo']['ids_categoria']);
        $this->data['all'] = $this->flexi_cart_model->get_items_filtros_nuevo_listado($this->data['categ'], $this->data['filtros_categorias_seo']['ids_categoria'], $pagina_actual, $ord);
        /*
        print '<pre><xmp>';
        print_r($this->data['all']);
        print '</xmp></pre>';
        

        $this->data['menu_categorias_seo_diferenciadas']=$this->flexi_cart_model->get_categorias_seo_diferenciadas_menu($this->data['categ']);
        $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_nuevo_listado($this->data['categ']);
        //$this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_categoria_seo($categoria_seo);
        $this->data['mostrar_categorias_seo']=true;
        
        
        echo "<br />Datuak harturik";
        exit;
        /*
        */
        /*
        print '<pre><xmp>';
        print_r($this->data['menu_categorias_seo']);
        print '</xmp></pre>';
        print '<pre><xmp>';
        print_r($this->data['menu_categorias_seo_diferenciadas']);
        print '</xmp></pre>';
        */
        //$this->data['texto_h1_seccion']=$categoria_seo->h1_categoria; 
        //$this->data['texto__intro_seo']= $categoria_seo->descripcion_categoria; 
        /*
        print '<pre><xmp>';
        print_r($this->data['menu_categorias_seo']);
        print '</xmp></pre>';
        */

        //if (isset($this->data['images']))
        //    $this->load->view('frontend/slider_nuevo', $this->data);

        $this->data['ocultar_submenu']=true;
        $this->data['mostrar_estilos_viejos']=true;
        //$this->data['categoria_principal'] = 'tienda/papel_pintado';
        if ($this->data['categ']==5){
            $this->load->view('frontend/migas_nuevas_small', $this->data);
            $this->load->view('frontend/cuerposeccion-sin-filtros', $this->data);
        }
        else{
            if (isset($_GET['test']) && $_GET['test']=='eneko')
                $this->load->view('frontend/cuerposeccion-con-filtros-overlay', $this->data);
            else
                $this->load->view('frontend/cuerposeccion-con-filtros', $this->data);
        }
        /*
        if (isset($_GET['test']) && $_GET['test']=='eneko'){
            $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_categoria_seo($categoria_seo);
            $this->data['all'] = $this->flexi_cart_model->get_items_categoria_seo_filtros($categoria_seo, $this->data['filtros_categorias_seo']['ids_categoria'], 0, $ord);
            $this->load->view('frontend/cuerposeccion-categorias-seo-con-filtros', $this->data);
        }
        else
            $this->load->view('frontend/cuerposeccion-categorias-seo', $this->data);
        */
        if (isset($_GET['test']) && $_GET['test']=='eneko')
            $this->load->view('frontend/footer_eneko', $this->data);
        else
            $this->load->view('frontend/footer', $this->data);
        /*
        $this->data['texto_h1_seccion']=$categoria_seo->h1_categoria; 
        $this->data['texto__intro_seo']=$categoria_seo->descripcion_categoria; 

        $this->load->view('frontend/header', $this->data);
        $this->load->view('frontend/cuerposeccion', $this->data);
        $this->load->view('frontend/footer', $this->data);

        exit;
        */
    }
    function listado_productos_coleccion($categoria_principal, $idcoleccion=0){
        // Todos los artículos de un tipo de producto
        $this->data['categoria_principal'] = $categoria_principal;
        $this->data['productos_coleccion'] = true;
        $this->data['ocultar_submenu'] = true;
        $this->data['idcoleccion'] = $idcoleccion;

        $coleccion = $this->flexi_cart_model->get_coleccion($idcoleccion);
        if (isset($coleccion[0])){
            $marca = $this->flexi_cart_model->get_fab($coleccion[0]->coleccion_cat_id);

            $categ = "";
            $categ_enlace = $categoria_principal;
            switch ($categoria_principal) {
                case 'papel-pintado': 
                    $categ = "Papel Pintado";
                    $categ_enlace = "papel_pintado";
                    $this->data['categ']=0;
                    $this->data['description2'] ='Elige el Papel Pintado que mejor se adapte a tu ambiente. En nuestro amplio catálogo con las últimas novedades y más de 1000 muestrarios encontrarás lo que buscas. ¡Visítanos!'; //title2 para evitar que añada depapelpintado al final
                    
                    //$this->data['texto__intro_seo']= $this->load->view('textos_seo/papel-pintado-seo', $this->data, true); 
                    $this->data['images'] = $this->contenido_model->get_imagenes(true, "papelpintado");
                    break;
                case 'papel-pintado-economico':
                    $categ = "Papel Pintado";
                    $this->data['categ']=0;
                    $this->data['texto_h1_seccion']='Papeles Pintados';
                    $this->data['texto__intro_seo']= $this->load->view('textos_seo/papel-pintado-seo', $this->data, true);
                    $this->data['images'] = $this->contenido_model->get_imagenes(true, "economicos");
                    break;
                case 'murales':
                case 'fotomurales':
                    $categ = "Murales";
                    $this->data['description2'] ='Elige el Mural que mejor se adapte a tu ambiente. En nuestro amplio catálogo con las últimas novedades y más de 1000 muestrarios encontrarás lo que buscas. ¡Visítanos!';
                    $this->data['categ']=1;
                    break;
                case 'revestimientos': 
                    $categ = "Revestimientos";
                    $this->data['categ']=2;
                    break;
                case 'telas': $categ = "Telas";
                    $this->data['categ']=3;
                    break;
                case 'alfombras': 
                    $categ = "Alfombras";
                    $this->data['categ']=4;
                    break;
                case 'herramientas': 
                    $categ = "Herramientas";
                    $this->data['categ']=5;
                    break;
                case 'todos': 
                    $categ = "Todos";
                    $this->data['categ']=-1;
                    break;
                default: 
                    $this->data['categ']=-1;
                    break;
            }

            $txt_reemplzazar_metas='';
            $a_categorias_productos=explode(',', $coleccion[0]->ccats);
            $categorias_txt=array();
            foreach($a_categorias_productos as $tipo_aux){
                switch ($tipo_aux) {
                  case 0: $categorias_txt[] = "Papel Pintado";
                      break;
                  case 1: $categorias_txt[] = "Murales";
                      break;
                  case 2: $categorias_txt[] = "Revestimientos";
                      break;
                  case 3: $categorias_txt[] = "Telas";
                      break;
                  case 4: $categorias_txt[] = "Alfombras";
                      break;
                  case 5: $categorias_txt[] = "Herramientas";
                      break;
                  default: break;
                }
            }
            if (count($categorias_txt)>1){
                $ultimo_elemento=array_pop($categorias_txt);
                $txt_reemplzazar_metas=implode(', ', $categorias_txt).' y '.$ultimo_elemento;

                $coleccion[0]->meta_titlec=str_replace($txt_reemplzazar_metas, $categ, $coleccion[0]->meta_titlec);
                $coleccion[0]->meta_descriptionc=str_replace($txt_reemplzazar_metas, $categ, $coleccion[0]->meta_descriptionc);
            }

            if (trim($coleccion[0]->meta_titlec)!='')
                $this->data['meta_title']=$coleccion[0]->meta_titlec; 
            else
                $this->data['meta_title']='Colección '.$coleccion[0]->coleccion_name.' de '.$categ.' '.$marca->cat_name; 

            $this->data['texto_h1_seccion']='Colección '.$coleccion[0]->coleccion_name.' de '.$categ.' '.$marca->cat_name; 

            if ($categoria_principal=='todos'){
                $this->data['meta_title']='Colección '.$coleccion[0]->coleccion_name.' de '.$marca->cat_name; 
                $this->data['texto_h1_seccion']='Colección '.$coleccion[0]->coleccion_name.' de '.$marca->cat_name; 
            }

            if (trim($coleccion[0]->meta_descriptionc)!='')
                $this->data['meta_description']=$coleccion[0]->meta_descriptionc; 
            elseif (trim($marca->meta_descriptionf)!='')
                $this->data['meta_description']=$marca->meta_descriptionf; 

            if ($categoria_principal=='todos'){
                //$this->data['a_migas']['marcas-'.$categoria_principal]='Marcas';
                $this->data['a_migas']['/tienda/marcas']='Marcas';
                $this->data['a_migas']['/tienda/marca/'.$this->urlenc_aux($marca->cat_id).'/'.$this->urlenc_aux($marca->cat_name)]=$marca->cat_name;
                $this->data['a_migas']['/tienda/marca/'.$this->urlenc_aux($marca->cat_id).'/'.$this->urlenc_aux($marca->cat_name).'/'.$idcoleccion.'/'.$this->urlenc_aux($coleccion[0]->coleccion_name)]=$coleccion[0]->coleccion_name;
                $this->data['url_especifica']='tienda/marca/'.$this->urlenc_aux($marca->cat_id).'/'.$this->urlenc_aux($marca->cat_name).'/'.$idcoleccion.'/'.$this->urlenc_aux($coleccion[0]->coleccion_name);
            }
            else{
                $this->data['a_migas']['/tienda/'.$categ_enlace]=$categ;
                //$this->data['a_migas']['marcas-'.$categoria_principal]='Marcas';
                $this->data['a_migas']['/tienda/'.$categ_enlace.'/marcas']='Marcas';
                $this->data['a_migas']['/tienda/'.$categ_enlace.'/marca/'.$this->urlenc_aux($marca->cat_id).'/'.$this->urlenc_aux($marca->cat_name)]=$marca->cat_name;
                $this->data['a_migas']['/tienda/'.$categ_enlace.'/marca/'.$this->urlenc_aux($marca->cat_id).'/'.$this->urlenc_aux($marca->cat_name).'/'.$idcoleccion.'/'.$this->urlenc_aux($coleccion[0]->coleccion_name)]=$coleccion[0]->coleccion_name;
                $this->data['url_especifica']='tienda/'.$categ_enlace.'/marca/'.$this->urlenc_aux($marca->cat_id).'/'.$this->urlenc_aux($marca->cat_name).'/'.$idcoleccion.'/'.$this->urlenc_aux($coleccion[0]->coleccion_name);
            }
            //$this->data['a_migas']['marcas-'.$categoria_principal.'/'.$this->urlenc_aux($marca->cat_name).'/'.$marca->cat_id]=$marca->cat_name;
            //$this->data['a_migas']['marcas-'.$categoria_principal.'/'.$this->urlenc_aux($marca->cat_name).'/'.$this->urlenc_aux($coleccion[0]->coleccion_name).'/'.$idcoleccion]=$coleccion[0]->coleccion_name;

            //$this->data['url_especifica']='marcas-'.$categoria_principal.'/'.$this->urlenc_aux($marca->cat_name).'/'.$this->urlenc_aux($coleccion[0]->coleccion_name).'/'.$idcoleccion;


            $this->load->model('contenido_model');
            $this->data['portada'] = $this->contenido_model->get_page(1);
            $this->data['promosl'] = $this->contenido_model->get_promos();
            $this->data['promosr'] = $this->contenido_model->get_promos(false);
            /*
            print '<pre><xmp>';
            print_r($this->data);
            print '</xmp></pre>';
            exit;
            */
            
            $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample();
            $this->data['fab'] = $this->flexi_cart_model->get_categories("Papel Pintado");
            $this->data['col'] = $this->flexi_cart_model->get_col_array();
            $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
            $this->data['gama'] = $this->flexi_cart_model->get_gamas();
            $this->data['estilo'] = $this->flexi_cart_model->get_estilos();
            
            //$this->data['all'] = $this->flexi_cart_model->get_items_categoria_seo($categoria_seo, null, $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $ord);
            /*
            $this->data['all'] = $this->flexi_cart_model->get_items_filter($this->data['donden']['marca'], $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $this->data['categ'], $econ, $losmas, $ord);
            $this->db->cache_on();
            $this->data['all'] = $this->flexi_cart_model->get_items_filter($this->data['donden']['marca'], $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $this->data['categ'], $econ, $losmas, $ord);
            $this->db->cache_off();
            */
            $this->data['familia_producto'] = $categ;
            
            //$this->data['losmas'] = $losmas;


            //$this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);
            //Fin cabeceras economicos
            //$this->data['title2'] =$categoria_seo->meta_title_categoria; //title2 para evitar que añada depapelpintado al final
            //$this->data['description2'] =$categoria_seo->meta_description_categoria; //title2 para evitar que añada depapelpintado al final


            $this->data['nombre_listado'] = 'Listado papeles pintados';
            $this->data['id_listado'] = 'listado_papeles_pintados';
            if ($categoria_principal=='todos'){
                $this->data['nombre_listado'] = 'Listado productos';
                $this->data['id_listado'] = 'listado_productos';
            }

            /*
            $this->data['menu_categorias_seo']=$this->flexi_cart_model->get_categorias_seo_menu_sin_estilos($this->data['categ']);
            $this->data['menu_categorias_seo_diferenciadas']=$this->flexi_cart_model->get_categorias_seo_diferenciadas_menu($this->data['categ']);
            */
            
            //$this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_nuevo_listado($this->data['categ'], $idcoleccion);
            
            //$this->data['all'] = $this->flexi_cart_model->get_items_cole($idcoleccion, false, $this->data['categ']);

            $orden = 3; // en colecciones ordenamos por referencia por defecto
            if (isset($_REQUEST['orden']))
                $orden = $_REQUEST['orden'];
            $this->data['orden_seleccionado'] = $orden;
            $ord = $this->orden($orden);

            
            $this->data['mostrar_categorias_seo']=false;
            $this->data['productos_outlet']=0;
            $this->data['id_coleccion']=$idcoleccion;
            $this->data['col_text_publico']=$coleccion[0]->col_text_publico;
            $this->data['col_text']=$coleccion[0]->col_text;
            $this->data['id_marca']=$marca->cat_id;
            $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_izquierda_listado($this->data['categ'], 0, $idcoleccion, $this->data['productos_outlet']);
            $this->data['menu_categorias_seo']=$this->flexi_cart_model->get_categorias_seo_menu_filtrado_por_items($this->data['categ'], $this->data['filtros_categorias_seo']['ids_categoria']);
            $this->data['mostrar_categorias_seo']=count($this->data['menu_categorias_seo']) ? true : false;
            $pagina_actual_col = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 0;
            $this->data['pagina_actual'] = $pagina_actual_col;
            $this->data['registros_por_pagina'] = 42;
            $this->data['total_productos'] = $this->flexi_cart_model->count_items_filtros_nuevo_listado($this->data['categ'], $this->data['filtros_categorias_seo']['ids_categoria']);
            $this->data['all'] = $this->flexi_cart_model->get_items_filtros_nuevo_listado($this->data['categ'], $this->data['filtros_categorias_seo']['ids_categoria'], $pagina_actual_col, $ord);

                    /*
                    print '<pre><xmp>';
                    print_r($this->data['a_migas']);
                    print '</xmp></pre>';
                    */
                /*
                print '<pre><xmp>';
                print_r($this->data['menu_categorias_seo']);
                print '</xmp></pre>';
                print '<pre><xmp>';
                print_r($this->data['menu_categorias_seo_diferenciadas']);
                print '</xmp></pre>';
                */
                //$this->data['texto_h1_seccion']=$categoria_seo->h1_categoria; 
                //$this->data['texto__intro_seo']= $categoria_seo->descripcion_categoria; 
            
            $this->data['url_canonica'] = current_url();
                
            $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            
            //$this->data['includes_footer'][]='<script src="/includes/js/listado-productos.js"></script>';            
            $this->data['includes_footer'][]='<script src="/includes/js/listado-productos.min.js?v=2"></script>';            
            unset($this->data['images']);


            if ($categoria_principal=='todos'){
                        $this->load->view('frontend/header', $this->data);
                        $this->load->view('frontend/noencontrado_nuevo', $this->data);
                        $this->load->view('frontend/footer', $this->data);
                /*
                echo "todos 11";
                print '<pre><xmp>';
                print_r($this->data);
                print '</xmp></pre>';
                $this->load->view('frontend/migas_nuevas_small', $this->data);
                echo "todos 11";
                */
                exit;
            }
            $this->load->view('frontend/header', $this->data);
            //$this->load->view('frontend/migas_nuevas_small', $this->data);
            $this->load->view('frontend/cuerposeccion-con-filtros', $this->data);
            $this->load->view('frontend/footer', $this->data);
                /*
                if (isset($_GET['test']) && $_GET['test']=='eneko'){
                    $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_categoria_seo($categoria_seo);
                    $this->data['all'] = $this->flexi_cart_model->get_items_categoria_seo_filtros($categoria_seo, $this->data['filtros_categorias_seo']['ids_categoria'], 0, $ord);
                    $this->load->view('frontend/cuerposeccion-categorias-seo-con-filtros', $this->data);
                }
                else
                    $this->load->view('frontend/cuerposeccion-categorias-seo', $this->data);
                */
            /*
            $this->data['texto_h1_seccion']=$categoria_seo->h1_categoria; 
            $this->data['texto__intro_seo']=$categoria_seo->descripcion_categoria; 

            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/cuerposeccion', $this->data);
            $this->load->view('frontend/footer', $this->data);

            exit;
            */
        }
        else{
            $categ = "";
            switch ($categoria_principal) {
                case 'papel-pintado': 
                    $categ = "Papel Pintado";
                    $this->data['categ']=0;
                    break;
                case 'papel-pintado-economico': 
                    $categ = "Papel Pintado";
                    $this->data['categ']=0;
                    break;
                case 'murales':
                case 'fotomurales':
                    $categ = "Murales";
                    $this->data['categ']=1;
                    break;
                case 'revestimientos': 
                    $categ = "Revestimientos";
                    $this->data['categ']=2;
                    break;
                case 'telas': $categ = "Telas";
                    $this->data['categ']=3;
                    break;
                case 'alfombras': 
                    $categ = "Alfombras";
                    $this->data['categ']=4;
                    break;
                case 'herramientas': 
                    $categ = "Herramientas";
                    $this->data['categ']=5;
                    break;
                default: break;
            }
            $this->data['marca_no_encontrada'] = true;
            $this->data['texto_intro'] = 'Otras marcas de '.$categ;
            $this->data['fabricantes'] = $this->flexi_cart_model->get_categories($categ);

            $this->load->view('frontend/header_404', $this->data);
            $this->load->view('frontend/noencontrado_nuevo', $this->data);
            $this->load->view('frontend/footer', $this->data);
        }
    }

    function listado_productos_coleccion_todos($idcoleccion) {
        /*
        $this->load->view('frontend/header', $this->data);
        $this->load->view('frontend/noencontrado_nuevo', $this->data);
        $this->load->view('frontend/footer', $this->data);
        */
        $this->data['productos_coleccion'] = true;
        $this->data['ocultar_submenu'] = true;
        $this->data['idcoleccion'] = $idcoleccion;

        $coleccion = $this->flexi_cart_model->get_coleccion($idcoleccion);
        if (isset($coleccion[0])){
            $marca = $this->flexi_cart_model->get_fab($coleccion[0]->coleccion_cat_id);

            $categ = "Todos";
            $this->data['categ']=-1;

            $this->data['meta_title']='Colección '.$coleccion[0]->coleccion_name.' de '.$marca->cat_name; 
            $this->data['texto_h1_seccion']='Colección '.$coleccion[0]->coleccion_name.' de '.$marca->cat_name; 

            if (trim($coleccion[0]->meta_descriptionc)!='')
                $this->data['meta_description']=$coleccion[0]->meta_descriptionc; 
            elseif (trim($marca->meta_descriptionf)!='')
                $this->data['meta_description']=$marca->meta_descriptionf; 

            $this->data['a_migas']['/tienda/marcas']='Marcas';
            $this->data['a_migas']['/tienda/marcas/marca/'.$this->urlenc_aux($marca->cat_id).'/'.$this->urlenc_aux($marca->cat_name)]=$marca->cat_name;
            $this->data['a_migas']['/tienda/marcas/marca/'.$this->urlenc_aux($marca->cat_id).'/'.$this->urlenc_aux($marca->cat_name).'/'.$idcoleccion.'/'.$this->urlenc_aux($coleccion[0]->coleccion_name)]=$coleccion[0]->coleccion_name;
            
            $this->data['url_especifica']='tienda/marcas/marca/'.$this->urlenc_aux($marca->cat_id).'/'.$this->urlenc_aux($marca->cat_name).'/'.$idcoleccion.'/'.$this->urlenc_aux($coleccion[0]->coleccion_name);

            $this->data['familia_producto'] = $categ;
            
            $this->data['nombre_listado'] = 'Listado productos';
            $this->data['id_listado'] = 'listado_productos';

            $orden = 3; // en colecciones ordenamos por referencia por defecto
            if (isset($_REQUEST['orden']))
                $orden = $_REQUEST['orden'];
            $this->data['orden_seleccionado'] = $orden;
            $ord = $this->orden($orden);

            
            $this->data['mostrar_categorias_seo']=false;
            $this->data['productos_outlet']=0;
            $this->data['id_coleccion']=$idcoleccion;
            $this->data['id_marca']=$marca->cat_id;
            $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_izquierda_listado($this->data['categ'], 0, $idcoleccion, $this->data['productos_outlet']);
            $this->data['menu_categorias_seo']=$this->flexi_cart_model->get_categorias_seo_menu_filtrado_por_items($this->data['categ'], $this->data['filtros_categorias_seo']['ids_categoria']);
            $this->data['mostrar_categorias_seo']=count($this->data['menu_categorias_seo']) ? true : false;
            $pagina_actual_col = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 0;
            $this->data['pagina_actual'] = $pagina_actual_col;
            $this->data['registros_por_pagina'] = 42;
            $this->data['total_productos'] = $this->flexi_cart_model->count_items_filtros_nuevo_listado($this->data['categ'], $this->data['filtros_categorias_seo']['ids_categoria']);
            $this->data['all'] = $this->flexi_cart_model->get_items_filtros_nuevo_listado($this->data['categ'], $this->data['filtros_categorias_seo']['ids_categoria'], $pagina_actual_col, $ord);

            $this->data['url_canonica'] = current_url();
                
            $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            
            //$this->data['includes_footer'][]='<script src="/includes/js/listado-productos.js"></script>';            
            $this->data['includes_footer'][]='<script src="/includes/js/listado-productos.min.js?v=2"></script>';            
            unset($this->data['images']);

            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/cuerposeccion-con-filtros', $this->data);
            $this->load->view('frontend/footer', $this->data);
        }
        else{
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/noencontrado_nuevo', $this->data);
            $this->load->view('frontend/footer', $this->data);
        }
     }

    function get_next_listado_filtros($page = -1) {
        // Siguiente página del listado de productos genérico
        //$ord=$this->orden("1");
        if (isset($_POST['ord']) && $_POST['ord'] != "")
            $ord = $this->orden($_POST['ord']);
        //echo $ord;
        
        $tipo_producto=0;
        if (isset($_POST['tipo_producto']) && $_POST['tipo_producto'] != "")
            $tipo_producto = $_POST['tipo_producto'];
        $productos_outlet=0;
        if (isset($_POST['productos_outlet']) && $_POST['productos_outlet'] != "")
            $productos_outlet = $_POST['productos_outlet'];
        /*
        echo "<br />id_nueva_categoria_seo: $id_nueva_categoria_seo";
        echo '<pre>';
        print_r($categoria_seo);
        echo '</pre>';
        $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_categoria_seo($categoria_seo[0]);
        $this->data['all'] = $this->flexi_cart_model->get_items_categoria_seo_filtros($categoria_seo[0], $this->data['filtros_categorias_seo']['ids_categoria'], $page, $ord);
        */
        
        $this->data['filtros_categorias_seo']= $this->flexi_cart_model->get_filtros_izquierda_listado($tipo_producto, 0, 0, $productos_outlet);
        $this->data['all'] = $this->flexi_cart_model->get_items_filtros_nuevo_listado($tipo_producto, $this->data['filtros_categorias_seo']['ids_categoria'], $page, $ord);

        $this->data['categ'] = $tipo_producto;
        $this->load->view('frontend/articulo_cards', $this->data);
    }

    function listado_marcas($tipo_producto=0, $id_marca=''){
        $this->data['categ'] = $tipo_producto;
        $categ = "";

        $this->data['title2'] = "Falta title"; // en title2 damos prioridad a ese título
        $this->data['description2'] ='Falta descripción'; //title2 para evitar que añada depapelpintado al final
        switch ($this->data['categ']) {
            case 0: 
                //$url_categoria_principal='papel-pintado';
                $categoria_principal='/tienda/papel_pintado';
                $url_categoria_principal='papel-pintado';
                $categ = "Papel Pintado";
                $this->data['meta_title'] = "Listado de marcas de papel pintado para pared"; 
                $this->data['meta_description'] ='Todos los papeles pintados agrupados por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 
                break;
            case 1:
                $categ = "Murales";
                $categoria_principal='/tienda/murales';
                $url_categoria_principal='murales';
                $this->data['meta_title'] = "Listado de marcas de Murales. ¡Personaliza tu Espacio!";
                $this->data['meta_description'] ='Todos los murales agrupados por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 
                break;
            case 2: 
                $categ = "Revestimientos";
                $categoria_principal='/tienda/revestimientos';
                $url_categoria_principal='revestimientos';
                $this->data['meta_title'] = "Listado de marcas Revestimientos. ¡Decora tu Pared!"; 
                $this->data['meta_description'] ='Todos los revestimientos agrupados por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 

                break;
            case 3: 
                $categ = "Telas";
                $categoria_principal='/tienda/telas';
                $url_categoria_principal='telas';
                $this->data['meta_title'] = "Listado de marcas de Telas online"; 
                $this->data['meta_description'] ='Todas las telas agrupadas por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 
                break;
            case 4: 
                $categ = "Alfombras";
                $categoria_principal='/tienda/alfombras';
                $url_categoria_principal='alfombras';
                $this->data['meta_title'] = "Listado de marcas de Alfombras a medida. ¡Decora tu ambiente!";
                $this->data['meta_description'] ='Todas las alfombras agrupadas por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 
                break;
            case 5: 
                $categ = "Herramientas";
                break;
            default: 
                $categoria_principal='/tienda';
                $url_categoria_principal='marca';
                $this->data['meta_title'] = "Listado de marcas. ¡Decora tu ambiente!";
                $this->data['meta_description'] ='Todas las marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 
                //$url_categoria_principal='marcas';
                break;
        }
        $this->data['familia_producto'] = $categ;
        if ($tipo_producto!=-1){
            // Para papeles pintados mostramos marcas de papeles, murales y revestimientos.
            if ($tipo_producto==0){
                $categoria_principal='/tienda/marcas';
                $url_categoria_principal='marca';
                $this->data['url_categoria_principal'] = $url_categoria_principal;
                $this->data['url_marca'] = $categoria_principal.'/marca';
                $this->data['a_migas'][$categoria_principal]=$categ;
                $this->data['fab'] = $this->flexi_cart_model->get_categories('papeles_murales_revestimientos');
            }
            else{
                $this->data['url_categoria_principal'] = $url_categoria_principal;
                $this->data['url_marca'] = $categoria_principal.'/marca';
                $this->data['a_migas'][$categoria_principal]=$categ;
                $this->data['fab'] = $this->flexi_cart_model->get_categories($categ);
            }
        }
        else{
            $this->data['url_marca'] = $categoria_principal.'/marcas/marca';
            $this->data['fab'] = $this->flexi_cart_model->get_categories('papeles_murales_revestimientos');
        }
        
        //$this->data['a_migas']['marcas-'.$url_categoria_principal]='Marcas';
        $this->data['a_migas'][$categoria_principal.'/marcas']='Marcas';

        if($categ=='Foto Murales' || $categ=='Fotomurales') // lo cambiamos para el encabezado
            $categ='Murales';
       // $this->data['col'] = $this->flexi_cart_model->get_col_array();

        //$this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            
        //$this->data['includes_footer'][]='<script src="/includes/js/listado-productos.js"></script>';            
        
        if ($id_marca!=''){
            // Hemos seleccionado una marca y vamos a mostrar sus colecciones
            $marca = $this->flexi_cart_model->get_fab($id_marca);
            if (is_object($marca)){
                $this->data['fab'] = $marca;
                $colecciones_aux = $this->flexi_cart_model->get_col($id_marca, $tipo_producto);
                $a_colecciones=array();
                foreach($colecciones_aux as $c){
                    $a_tipos=explode(',', $c['ccats']);
                    foreach ($a_tipos as $item_tipo){
                        if ($c['activo']==1 && $c['publico2']==1)
                            $a_colecciones[$item_tipo][$c['coleccion_id']]=$c;
                    }
                }

                $this->data['col'] = $a_colecciones;

                if ($tipo_producto!=-1)
                    $this->data['url_marca'] = $categoria_principal.'/marca/'.$id_marca.'/'.$this->urlenc_aux($marca->cat_name);
                else{
                    $this->data['url_marca'] = $categoria_principal.'/marcas/marca/'.$id_marca.'/'.$this->urlenc_aux($marca->cat_name);
                    $this->data['url_marca_aux'] = $id_marca.'/'.$this->urlenc_aux($marca->cat_name);
                }

                $this->data['a_migas'][$this->data['url_marca']]=$marca->cat_name;
                
                $this->data['url_canonica'] = current_url();

                if($url_categoria_principal!='marca'){
                    $categorias_productos=str_replace('Foto Murales', 'Murales',str_replace('Fotomurales', 'Murales',$marca->cats));
                    $a_categorias_productos=explode(',', $categorias_productos);
                    if (count($a_categorias_productos)>1){
                        $ultimo_elemento=array_pop($a_categorias_productos);
                        $txt_reemplzazar_metas=implode(', ', $a_categorias_productos).' y '.$ultimo_elemento;
                    
                        $marca->meta_titlef=str_replace($txt_reemplzazar_metas, $categ, $marca->meta_titlef);
                        $marca->meta_descriptionf=str_replace($txt_reemplzazar_metas, $categ, $marca->meta_descriptionf);
                    }
                }
                else{
                    // Si la marca solo tiene una categoría ponemos la url de la categoría como canónica
                    $a_categorias_productos=explode(',', $marca->cats);
                    if (count($a_categorias_productos)==1){
                        $categoria_producto_txt=strtolower($marca->cats);
                        $categoria_producto_txt=str_replace('foto murales', 'fotomurales',$categoria_producto_txt);
                        $categoria_producto_txt=str_replace('papel pintado', 'papel_pintado',$categoria_producto_txt);
                        $this->data['url_canonica']=base_url().'tienda/'.$categoria_producto_txt.'/marca/'.$id_marca.'/'.$this->urlenc_aux($marca->cat_name);
                    }
                }

                $this->data['meta_title'] = $marca->meta_titlef;
                $this->data['meta_description'] =$marca->meta_descriptionf; 
                $this->data['texto_h1_seccion']=$categ.' '.$marca->cat_name; 
                $this->data['texto_h2_seccion']='Colecciones de '.$categ.' '.$marca->cat_name; 
                
                if ($this->data['meta_title']==$this->data['texto_h1_seccion']){
                    // Si el title y el H1 son iguales, añadimos la coletilla
                    $this->data['meta_title'] .= ', catálogos actualizados';
                }
                $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            
                $this->load->view('frontend/header', $this->data);
                //$this->load->view('frontend/migas_nuevas_small', $this->data);
                $this->load->view('frontend/listado-colecciones', $this->data);
            }
            else{
                $this->data['marca_no_encontrada'] = true;
                $this->data['texto_intro'] = 'Otras marcas de '.$categ;
                $this->data['fabricantes'] = $this->flexi_cart_model->get_categories($categ);

                //$this->load->view('frontend/header_404', $this->data);
                $this->load->view('frontend/header', $this->data);
                $this->load->view('frontend/noencontrado_nuevo', $this->data);
            }   
        }
        else{
            if ($tipo_producto!=-1)
                $this->data['texto_h1_seccion']='Listado de Marcas de '.$categ; 
            else
                $this->data['texto_h1_seccion']='Todas las Marcas'; 

            $this->load->view('frontend/header', $this->data);
            //$this->load->view('frontend/migas_nuevas_small', $this->data);
            $this->load->view('frontend/listado-marcas', $this->data);
            $this->data['includes_footer'][]='<script src="/includes/js/listado-marcas.js"></script>';            

        }
        $this->load->view('frontend/footer', $this->data);
        
        /*

        if ($id_marca!=''){


        }
        else{
            $this->data['texto_h1_seccion']='Listado de Marcas de '.$categ; 
            $this->data['fab'] = $this->flexi_cart_model->get_categories($categ);
           // $this->data['col'] = $this->flexi_cart_model->get_col_array();

            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/listado-marcas', $this->data);
            $this->load->view('frontend/footer', $this->data);

        }
        */
    }

    function articulo() {
        $keywords = "";
        $this->data['keywords'] = "";
        $array = $this->uri->uri_to_assoc(3);
        // Nuevo formato SEO /{marca}/{coleccion}/{nombre}-{id}: el id va al final del ultimo segmento
        if (empty($array['id'])) {
            $ultimo_segmento = $this->uri->segment($this->uri->total_segments());
            if (preg_match('/-(\d+)$/', $ultimo_segmento, $m_seo_id))
                $array['id'] = $m_seo_id[1];
        }
        $this->data['categ'] = 0;
        if (isset($array["Herramientas"]) || isset($array["herramientas"]))
            $this->data['categ'] = 5;

        if (empty($array['id'])) show_404();

        $datos_item = $this->flexi_cart_model->get_item_siempre($array['id'], $this->data['categ']);
        /*
        if (isset($_GET['test'])){
            print '<pre><xmp>';
            print_r($datos_item);
            print '</xmp></pre>';
            exit;
        }
        */
        if (!isset($datos_item['item_cat_fk']))
            $datos_item['item_cat_fk']=0;
        if (!isset($datos_item['item_coleccion_id']))
            $datos_item['item_coleccion_id']=0;
        $marca = $this->flexi_cart_model->get_fab((int)$datos_item['item_cat_fk']);
        $coleccion = $this->flexi_cart_model->get_coleccion((int)$datos_item['item_coleccion_id']);

        // Fallbacks para previsualización admin (?test) cuando marca/colección no existen o están ocultas
        if (empty($marca))
            $marca = (object)['activo'=>0,'publico'=>0,'cat_name'=>'','cat_id'=>0,'fabmargen'=>0,'disc'=>0,'cats'=>''];
        if (empty($coleccion))
            $coleccion = [(object)[
                'coleccion_id'=>0,'coleccion_cat_id'=>0,'coleccion_name'=>'','col_text'=>'',
                'activo'=>0,'col_img'=>'','col_ambimg'=>'','plazo'=>'','ccats'=>'0','cdisc'=>0,
                'publico2'=>0,'col-desc'=>'','meta_titlec'=>'','meta_descriptionc'=>'',
                'meta_keywordsc'=>'','novedad_bool'=>0,'col_text_publico'=>0,
                'greca_misma_coleccion_be'=>0,'xml_META_be'=>0,'orden'=>0,
            ]];

        // Si el artículo ya no existe (fue eliminado por estar oculto), redirigir a su categoría principal
        if (!isset($datos_item['item_id'])){
            $a_categorias_principales = array(
                0 => 'tienda/papel_pintado',
                1 => 'tienda/murales',
                2 => 'tienda/revestimientos',
                3 => 'tienda/telas',
                4 => 'tienda/alfombras',
                5 => 'tienda/herramientas',
                6 => 'tienda/complementos',
            );
            $borrado = $this->db->where('item_id', (int)$array['id'])->get('demo_items_borrados_redirect')->row();
            if ($borrado && isset($a_categorias_principales[(int)$borrado->item_tipo])){
                redirect($a_categorias_principales[(int)$borrado->item_tipo], 'location', 301);
            }
        }

        // SEO productos: canonical -> URL amigable, y 301 de la vieja /tienda/articulo/... -> nueva /{marca}/{coleccion}/{nombre}-{id}
        // Solo para productos validos (no herramientas, no ?test, marca+coleccion+item activos y publicos)
        if (!isset($_GET['test']) && isset($datos_item['item_id']) && $this->data['categ']!=5
            && is_object($marca) && !empty($marca->cat_name) && $marca->activo==1 && $marca->publico==1
            && !empty($coleccion[0]) && !empty($coleccion[0]->coleccion_name) && $coleccion[0]->activo==1 && $coleccion[0]->publico2==1
            && !empty($datos_item['activo']) && !empty($datos_item['publico3'])) {
            $url_seo_producto = $this->urlenc_aux($marca->cat_name).'/'.$this->urlenc_aux($coleccion[0]->coleccion_name).'/'.$this->urlenc_aux($datos_item['item_name']).'-'.$datos_item['item_id'];
            $this->data['url_canonica'] = base_url().$url_seo_producto;
            if (strpos($this->uri->uri_string(), 'tienda/articulo') === 0) {
                redirect($url_seo_producto, 'location', 301);
                return;
            }
        }

        if (!isset($_GET['test']) && $this->data['categ']!=5 && (empty($marca) || $marca->activo==0 || $marca->publico==0)){
            // Marca inexistente, desactivada o no publicada
            //echo "<br />Marca inexistente, desactivada o no publicada.";
            $this->data['articulo_no_encontrado'] = true;
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/noencontrado_nuevo', $this->data);
            $this->load->view('frontend/footer', $this->data);
        }
        elseif (!isset($_GET['test']) && $this->data['categ']!=5 && (empty($coleccion) || $coleccion[0]->activo==0 || $coleccion[0]->publico2==0)){
            // Colección inexistente, desactivada o no publicada
            //echo "<br />Colección inexistente, desactivada o no publicada";
            $this->data['articulo_no_encontrado'] = true;
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/noencontrado_nuevo', $this->data);
            $this->load->view('frontend/footer', $this->data);
            /*
            $this->data['articulo_no_encontrado'] = true;
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/noencontrado', $this->data);
            $this->load->view('frontend/footer', $this->data);
            */
        }
        //elseif (count($datos_item)==0 || $datos_item['activo']==0 || $datos_item['publico3']==0){
        elseif (!isset($_GET['test']) && (count($datos_item)==0 || $datos_item['activo']==0 || $datos_item['publico3']==0)){
            if (isset($_GET['test'])){
                print '<pre><xmp>';
                print_r($this->data['categ']);
                print '</xmp></pre>';

                print '<pre><xmp>';
                print_r($datos_item);
                print '</xmp></pre>';

                /*
                print '<pre><xmp>';
                print_r($coleccion);
                print '</xmp></pre>';
                print '<pre><xmp>';
                print_r($array);
                print '</xmp></pre>';
                echo "<br />".$this->db->last_query();

                print '<pre><xmp>';
                print_r($datos_item);
                print '</xmp></pre>';

                print '<pre><xmp>';
                print_r($this->data);
                print '</xmp></pre>';
                */
            }
            // Artículo inexistente, desactivado o no publicado
            //echo "<br />Artículo inexistente, desactivado o no publicado";
            $this->data['articulo_no_encontrado'] = true;
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/noencontrado_nuevo', $this->data);
            $this->load->view('frontend/footer', $this->data);
        }
        else{
            // Ficha del producto
            $datos_marca = (array) $marca;
            $datos_coleccion = (array) $coleccion[0];
            if (isset($_GET['test_articulo'])){
                print '<pre><xmp>';
                print_r($datos_item);
                print '</xmp></pre>';
                exit;
            }
            $datos_item=array_merge($datos_item, $datos_coleccion, $datos_marca);

            $this->data['key']=$datos_item;
            /*
            if ($this->data['categ']==5){
                print '<pre><xmp>';
                print_r($datos_item);
                print '</xmp></pre>';
                print '<pre><xmp>';
                print_r($marca);
                print '</xmp></pre>';
                print '<pre><xmp>';
                print_r($datos_marca);
                print '</xmp></pre>';
            }
            /*
            $this->data['key']['cat_name']=$marca->cat_name;
            $this->data['key']['coleccion_name']=$coleccion[0]->coleccion_name;
            $this->data['key']['col_text']=$coleccion[0]->col_text;
            exit;
            */

            $this->_metadatosarray($this->data['key']);


            if ($this->data['key']['tiene_variantes'] != 0 || $this->data['key']['variante_de'] != 0) {
                $this->data['variantes'] = $this->flexi_cart_model->get_variantes(($this->data['key']['tiene_variantes'] == 0) ? $this->data['key']['variante_de'] : $this->data['key']['item_id']);
            }
            if ($this->data['key']['tiene_relacionados'] != 0 || $this->data['key']['relacionado_con'] != 0) {
                $this->data['relacionados'] = $this->flexi_cart_model->get_relacionados(($this->data['key']['tiene_relacionados'] == 0) ? $this->data['key']['relacionado_con'] : $this->data['key']['item_id']);
            }
            $this->data['otro'] = $this->flexi_cart_model->get_items_cole($this->data['key']['item_coleccion_id'], false, $this->data['key']['item_tipo']);
           
            $categ = "";
            switch ($this->data['key']['item_tipo']) {
                case 0: $categ = "Papel Pintado";
                    $tipo_producto = "Papel Pintado";
                    $categoria_principal='/tienda/papel_pintado';
                    break;
                case 1: $categ = "Murales";
                    $tipo_producto = "Mural";
                    $categoria_principal='/tienda/murales';
                    break;
                case 2: $categ = "Revestimientos";
                    $tipo_producto = "Revestimiento";
                    $categoria_principal='/tienda/revestimientos';
                    break;
                case 3: $categ = "Telas";
                    $tipo_producto = "Tela";
                    $categoria_principal='/tienda/telas';
                    break;
                case 4: $categ = "Alfombras";
                    $tipo_producto = "Alfombra";
                    $categoria_principal='/tienda/alfombras';
                    break;
                case 5: $categ = "Herramientas";
                    $tipo_producto = "";
                    $categoria_principal='/tienda/herramientas';
                    break;
                default: break;
            }
            /*
            switch ($this->data['categ']) {
                case 0: 
                    //$url_categoria_principal='papel-pintado';
                    $categoria_principal='/tienda/papel_pintado';
                    $url_categoria_principal='papel-pintado';
                    $categ = "Papel Pintado";
                    $this->data['meta_title'] = "Listado de marcas de papel pintado para pared"; 
                    $this->data['meta_description'] ='Todos los papeles pintados agrupados por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 
                    break;
                case 1:
                    $categ = "Murales";
                    $categoria_principal='/tienda/murales';
                    $url_categoria_principal='murales';
                    $this->data['meta_title'] = "Listado de marcas de Murales. ¡Personaliza tu Espacio!";
                    $this->data['meta_description'] ='Todos los murales agrupados por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 
                    break;
                case 2: 
                    $categ = "Revestimientos";
                    $categoria_principal='/tienda/revestimientos';
                    $url_categoria_principal='revestimientos';
                    $this->data['meta_title'] = "Listado de marcas Revestimientos. ¡Decora tu Pared!"; 
                    $this->data['meta_description'] ='Todos los revestimientos agrupados por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 

                    break;
                case 3: 
                    $categ = "Telas";
                    $categoria_principal='/tienda/telas';
                    $url_categoria_principal='telas';
                    $this->data['meta_title'] = "Listado de marcas de Telas online"; 
                    $this->data['meta_description'] ='Todas las telas agrupadas por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 
                    break;
                case 4: 
                    $categ = "Alfombras";
                    $categoria_principal='/tienda/alfombras';
                    $url_categoria_principal='alfombras';
                    $this->data['meta_title'] = "Listado de marcas de Alfombras a medida. ¡Decora tu ambiente!";
                    $this->data['meta_description'] ='Todas las alfombras agrupadas por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 
                    break;
                case 5: 
                    $categ = "Herramientas";
                    break;
                default: break;
            }
            */
            $this->data['tipo_producto'] = $tipo_producto;
            
            if ($datos_item['item_tipo'] == 5){
                $this->data['texto_h1_seccion']=$datos_item['item_name'];
            }
            else
                $this->data['texto_h1_seccion']=$tipo_producto.' '.$datos_item['cat_name']." ".$datos_item['coleccion_name']." ".$datos_item['item_ref']; 
            
            if(trim($this->data['key']['meta_title'])!='')
                $this->data['meta_title'] = $this->data['key']['meta_title'];
            else{
                if ($this->data['key']['item_tipo'] != 5)
                        $this->data['meta_title'] = $tipo_producto.' '.$this->data['key']['item_ref'].' de '. $marca->cat_name.', colección '.$coleccion[0]->coleccion_name;
                else{
                    $this->data['meta_title'] = $this->data['key']['item_name'].' - '.$this->data['key']['item_ref'];
                    //$this->data['meta_title'] = $this->data['key']['item_name'].' - '.$this->data['key']['item_ref'].' ('. $marca->cat_name.', colección '.$coleccion[0]->coleccion_name.')';
                }
            }

            if(trim($this->data['key']['meta_description'])!='')
                $this->data['meta_description'] = $this->data['key']['meta_description'];
            else    
                $this->data['meta_description'] = '';
            
            /*
            $this->data['meta_title'] = "Listado de marcas de Alfombras a medida. ¡Decora tu ambiente!";
            $this->data['meta_description'] ='Todas las alfombras agrupadas por marcas, seguro que tenemos lo que buscas. ¡Visítanos!'; 


            $this->data['description'] = html_entity_decode(($this->data['key']['item_tipo'] == 5) ? strip_tags($this->data['key']['item_text']) : strip_tags($this->data['key']['col_text']), ENT_COMPAT, 'UTF-8');
            $image2 = base_url() . "includes/" . str_replace("../", "", $this->data['key']['imgamb']) . "med.jpg";
            $image = base_url() . "includes/" . str_replace("../", "", $this->data['key']['img']) . "med.jpg";
            $articulo = array("precio" => $this->data['key']['item_price']);
            $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2, $articulo);
            
            /*
            $this->data['a_migas']['marcas-'.$categoria_principal]='Marcas';
            $this->data['a_migas']['marcas-'.$categoria_principal.'/'.$this->urlenc_aux($marca->cat_name).'/'.$marca->cat_id]=$marca->cat_name;
            $this->data['a_migas']['marcas-'.$categoria_principal.'/'.$this->urlenc_aux($marca->cat_name).'/'.$this->urlenc_aux($coleccion[0]->coleccion_name).'/'.$idcoleccion]=$coleccion[0]->coleccion_name;
            /*
            print '<pre><xmp>';
            print_r($this->data);
            print '</xmp></pre>';
            exit;
            */
            
            $this->data['a_migas'][$categoria_principal]=$categ;
            if ($this->data['categ']!=5){
                $this->data['url_marca']=$categoria_principal.'/marca/'.$marca->cat_id.'/'.$this->urlenc_aux($marca->cat_name);
                $this->data['url_coleccion']=$this->data['url_marca'].'/'.$coleccion[0]->coleccion_id.'/'.$this->urlenc_aux($coleccion[0]->coleccion_name);
                $this->data['url_pre_variante']='/tienda/articulo/'.$this->urlenc_aux($marca->cat_name).'/'.$this->urlenc_aux($coleccion[0]->coleccion_name).'/id/';
                $this->data['url_producto']='/tienda/articulo/'.$this->urlenc_aux($marca->cat_name).'/'.$this->urlenc_aux($coleccion[0]->coleccion_name).'/id/'.$this->data['key']['item_id'];
                $this->data['a_migas'][$this->data['url_marca']]=$marca->cat_name;
                $this->data['a_migas'][$this->data['url_coleccion']]=$coleccion[0]->coleccion_name;
                $this->data['a_migas'][$this->data['url_producto']]=$this->data['key']['item_ref'];
            }
            else{
                $this->data['url_producto']='/tienda/articulo/herramientas/'.$this->urlenc_aux($this->data['key']['item_name']).'/id/'.$this->data['key']['item_id'];
                $this->data['a_migas'][$this->data['url_producto']]=$this->data['key']['item_name'];
            }

            $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            

            $this->load->view('frontend/header', $this->data);
            $this->data['separa_migas']=true;
            $this->load->view('frontend/migas_nuevas_small', $this->data);
            /*
            if (isset($_GET['test']) && $_GET['test']=='eneko'){
                $this->data['includes_footer'][]='<script src="/includes/js/articulo-completo.js"></script>';            
                $this->load->view('frontend/articulo_completo_santos_monteiro', $this->data);
            }
            else{
            }
            */
            // Cuando esté confirmado, hay que minimizar el js     
            if (isset($_GET['testing']) && $_GET['testing']=='eneko')
                $this->data['includes_footer'][]='<script src="/includes/js/articulo-completo-nuevo.js"></script>';    
            else        
                $this->data['includes_footer'][]='<script src="/includes/js/articulo-completo-bbdd.js"></script>';    

            $this->data['includes_footer'][]='<script src="https://www.paypal.com/sdk/js?client-id=AbM4hpWmFs3LQpp6_C-JtlgwSrZp_RLwZv_2TUhQKdvWwRkBwc5Ip0ZPl62LDxiHC3Hf_8wzzby_2EES&currency=EUR&components=messages" data-namespace="PayPalSDK"></script>';         
            //$this->data['includes_footer'][]='<script src="/includes/js/articulo-completo-2.min.js"></script>';            
            $this->load->view('frontend/articulo_completo', $this->data);
            /*
            // Cuando esté confirmado, hay que minimizar el js     
            $this->data['includes_footer'][]='<script src="/includes/js/articulo-completo.js"></script>'; // Cuando esté confirmado, hay que minimizar el js            
            $this->load->view('frontend/articulo_completo_santos_monteiro', $this->data);

            // URL a tratar para el no encontrado post cambio:
            // https://depapelpintado.es/tienda/articulo/santos-monteiro/creek/id/86771
            */

            $this->load->view('frontend/footer', $this->data);
        }
        /*
        print '<pre><xmp>';
        print_r($datos_item);
        print '</xmp></pre>';
        print '<pre><xmp>';
        print_r($this->data['key']);
        print '</xmp></pre>';
        exit;
        
        if (empty($this->data['key'])){
            $nombre_marca=$this->uri->segment(3);
            $nombre_coleccion=$this->uri->segment(4);
            $item_id=$this->uri->segment(6);

            //Miramos si el item existe en la base de datos pero ya no está publicado
            $datos_item_ko=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_items', 'item_id', array('item_id'=>$item_id));
            $this->data['categ'] = -1;
            if(isset($datos_item_ko[$item_id])){
                //Buscamos otros productos activos de la misma coleccion
                $this->data['categ'] = $datos_item_ko[$item_id]['item_tipo'];
                $this->data['datos_item_ko']=$datos_item_ko[$item_id];
                $this->data['otros_items'] = $this->flexi_cart_model->get_items_cole($datos_item_ko[$item_id]['item_coleccion_id'], false, $datos_item_ko[$item_id]['item_tipo']);
                $this->data['fabricante'] = $this->flexi_cart_model->get_fab($datos_item_ko[$item_id]['item_cat_fk']);
                $this->data['coleccion'] = $this->flexi_cart_model->get_coleccion($datos_item_ko[$item_id]['item_coleccion_id']);
                $this->data['todas_las_colecciones'] = $this->flexi_cart_model->get_col($datos_item_ko[$item_id]['item_cat_fk'], $datos_item_ko[$item_id]['item_tipo']);
            }
            else{
                $marcas=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_categories', 'cat_id', array('publico'=>1));

                foreach($marcas as $id_marca =>$datos){
                    if ($datos['activo']==1 && trim($datos['cat_name'])!='')
                        if ($this->urlenc_aux($datos['cat_name'])==$nombre_marca){
                            $this->data['fabricante'] = $this->flexi_cart_model->get_fab($id_marca);
                            $this->data['todas_las_colecciones'] = $this->flexi_cart_model->get_col($id_marca, -1);
                            break;
                        }
                }
            }
            $this->data['articulo_no_encontrado'] = true;
            $this->load->view('frontend/header_404', $this->data);
            $this->load->view('frontend/noencontrado_nuevo', $this->data);
            $this->load->view('frontend/footer', $this->data);
        }
        else{
        }
        */
    }

    function index_eneko() {
        $meta_datos['title']='Inicio - De Papel Pintado';
        $this->data['meta_datos'] = $meta_datos;
        $this->data['categ'] = -1;
        
        $this->data['portada'] = $this->contenido_model->get_page(1);
        $this->data['promosl'] = $this->contenido_model->get_promos();
        $this->data['promosr'] = $this->contenido_model->get_promos(false);
        $this->data['images'] = $this->contenido_model->get_imagenes(true, "home");
        $this->data['fab'] = $this->flexi_cart_model->get_categories();
        $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample();
        $this->data['col'] = $this->flexi_cart_model->get_col_array();
        $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
        $this->data['gama'] = $this->flexi_cart_model->get_gamas();
        $this->data['estilo'] = $this->flexi_cart_model->get_estilos();
        
        $recaptcha_v3=new stdClass;
        $recaptcha_v3->aktibaturik=true;
        $recaptcha_v3->action='';
        $recaptcha_v3->form_id='#newsletter';

        if($this->input->post("token")){
            $captcha_balidazioa=$this->captcha_v3_balidatu();
            if ($captcha_balidazioa->success){
                $this->load->helper('email');
                if (valid_email($this->input->post("email_newsletter"))){
                    $this->data['notificacion_modal']='ok';
                    $suscripcion_ok=$this->newsletter('home', $_POST);
                }
            }
        }
        $this->data['recaptcha_v3']=$recaptcha_v3;

        $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/html-slider.css">';            

        $this->load->view('frontend/header_eneko', $this->data);

        if (isset($_POST['search']) && trim($_POST['search']) != "") {
            $search = $_POST['search'];
            $this->data['all'] = $this->flexi_cart_model->search_items($search, 0);
            $this->load->view('frontend/cuerposeccion', $this->data);
        } else {
            //$this->load->view('frontend/slider', $this->data);
            $this->load->view('frontend/slider_nuevo', $this->data);
            $this->load->view('frontend/home', $this->data);
        }
        //    $this->load->view('frontend/estilos', $this->data);
        //$this->data['includes_footer'][]='<script src="/includes/js/home.js"></script>';      // lo renombramos por el hackeo del recaptchca cloudflare         
        $this->data['includes_footer'][]='<script src="/includes/js/sarrera.js"></script>';         
        $this->load->view('frontend/footer', $this->data);
        //RESTUARAR
        //$this->view_cart();
        //redirect('admin_library/articulos');
    }

    private function orden($orden) {
        if ($orden == "1")
            return 'item_price asc';
        if ($orden == "2")
            return 'item_price desc';
        if ($orden == "3")
            return 'item_ref asc';
        if ($orden == "4"){
            return 'portada desc, item_id desc';
        }
        return '';
    }
    function _metadatos($objeto=FALSE){
        if ($objeto!=FALSE){
            if(isset($objeto->meta_title)){
                if($objeto->meta_title!="")$this->data["title2"]=$objeto->meta_title;
                if($objeto->meta_description!="")$this->data["description2"]=$objeto->meta_description;
                if($objeto->meta_keywords!="")$this->data["keywords2"]=$objeto->meta_keywords;
            }
            elseif(isset($objeto->meta_titlec)){
                if($objeto->meta_titlec!="")$this->data["title2"]=$objeto->meta_titlec;
                if($objeto->meta_descriptionc!="")$this->data["description2"]=$objeto->meta_descriptionc;
                if($objeto->meta_keywordsc!="")$this->data["keywords2"]=$objeto->meta_keywordsc;
            }
            elseif(isset($objeto->meta_titlef)){
                if($objeto->meta_titlef!="")$this->data["title2"]=$objeto->meta_titlef;
                if($objeto->meta_descriptionf!="")$this->data["description2"]=$objeto->meta_descriptionf;
                if($objeto->meta_keywordsf!="")$this->data["keywords2"]=$objeto->meta_keywordsf;
            }
        }   
    }
    function _metadatosarray($objeto=FALSE){
        if ($objeto!=FALSE){
            if(isset($objeto['meta_title'])){
                if($objeto['meta_title']!="")$this->data["title2"]=$objeto['meta_title'];
                if($objeto['meta_description']!="")$this->data["description2"]=$objeto['meta_description'];
                if($objeto['meta_keywords']!="")$this->data["keywords2"]=$objeto['meta_keywords'];
            }
            elseif(isset($objeto['meta_titlec'])){
                if($objeto['meta_titlec']!="")$this->data["title2"]=$objeto['meta_titlec'];
                if($objeto['meta_descriptionc']!="")$this->data["description2"]=$objeto['meta_descriptionc'];
                if($objeto['meta_keywordsc']!="")$this->data["keywords2"]=$objeto['meta_keywordsc'];
            }
            elseif(isset($objeto['meta_titlef'])){
                if($objeto['meta_titlef']!="")$this->data["title2"]=$objeto['meta_titlef'];
                if($objeto['meta_descriptionf']!="")$this->data["description2"]=$objeto['meta_descriptionf'];
                if($objeto['meta_keywordsf']!="")$this->data["keywords2"]=$objeto['meta_keywordsf'];
            }
        }   
    }
    function papel_pintado($param1 = "", $param2 = "", $param3 = "", $param4 = "", $param5 = "") {
        // SEO Fase 3: 301 de /tienda/papel_pintado -> /papel-pintado y /tienda/papel_pintado/economicos -> /outlet (las de marca van en su fase)
        if (strpos($this->uri->uri_string(), 'tienda/papel_pintado') === 0) {
            if ($param1==='') { redirect('papel-pintado', 'location', 301); return; }
            if ($param1==='economicos') { redirect('outlet', 'location', 301); return; }
        }
        if ($param1=='economicos')
            $this->listado_productos_nuevo('papel-pintado-economico');
        elseif ($param1=='marcas' || $param1=='marca'){
            $id_marca=$param2;
            $txt_marca=$param3;
            $id_coleccion=$param4;

            if ((int)$id_coleccion!=0)
                $this->listado_productos_coleccion('papel-pintado', $id_coleccion);
            elseif ((int)$id_marca!=0)
                $this->listado_marcas(0, $id_marca);
            else
                $this->listado_marcas(0);
        }
        else    
            $this->listado_productos_nuevo('papel-pintado');
    }
    function murales($param1 = "", $param2 = "", $param3 = "", $param4 = "", $param5 = "") {
        if ($param1==='' && strpos($this->uri->uri_string(), 'tienda/murales') === 0) { redirect('murales', 'location', 301); return; }
        if ($param1=='marcas' || $param1=='marca'){
            $id_marca=$param2;
            $txt_marca=$param3;
            $id_coleccion=$param4;

            if ((int)$id_coleccion!=0)
                $this->listado_productos_coleccion('murales', $id_coleccion);
            elseif ((int)$id_marca!=0)
                $this->listado_marcas(1, $id_marca);
            else
                $this->listado_marcas(1);
        }
        else
            $this->listado_productos_nuevo('murales');
    }
    function fotomurales($param1 = "", $param2 = "", $param3 = "", $param4 = "", $param5 = "") {
        redirect('tienda/murales'.($param1 ? '/'.$param1 : '').($param2 ? '/'.$param2 : '').($param3 ? '/'.$param3 : '').($param4 ? '/'.$param4 : '').($param5 ? '/'.$param5 : ''), 'location', 301);
    }
    function revestimientos($param1 = "", $param2 = "", $param3 = "", $param4 = "", $param5 = "") {
        if ($param1==='' && strpos($this->uri->uri_string(), 'tienda/revestimientos') === 0) { redirect('revestimientos', 'location', 301); return; }
        if ($param1=='marcas' || $param1=='marca'){
            $id_marca=$param2;
            $txt_marca=$param3;
            $id_coleccion=$param4;

            if ((int)$id_coleccion!=0)
                $this->listado_productos_coleccion('revestimientos', $id_coleccion);
            elseif ((int)$id_marca!=0)
                $this->listado_marcas(2, $id_marca);
            else
                $this->listado_marcas(2);
        }
        else    
            $this->listado_productos_nuevo('revestimientos');
    }
    function telas($param1 = "", $param2 = "", $param3 = "", $param4 = "", $param5 = "") {
        // SEO Fase 3: 301 de la URL vieja /tienda/telas -> /telas (solo el listado; las de marca van en la fase de marcas)
        if ($param1==='' && strpos($this->uri->uri_string(), 'tienda/telas') === 0) {
            redirect('telas', 'location', 301);
            return;
        }
        if ($param1=='marcas' || $param1=='marca'){
            $id_marca=$param2;
            $txt_marca=$param3;
            $id_coleccion=$param4;

            if ((int)$id_coleccion!=0)
                $this->listado_productos_coleccion('telas', $id_coleccion);
            elseif ((int)$id_marca!=0)
                $this->listado_marcas(3, $id_marca);
            else
                $this->listado_marcas(3);
        }
        else    
            $this->listado_productos_nuevo('telas');
    }
    function alfombras($param1 = "", $param2 = "", $param3 = "", $param4 = "", $param5 = "") {
        if ($param1==='' && strpos($this->uri->uri_string(), 'tienda/alfombras') === 0) { redirect('alfombras', 'location', 301); return; }
        if ($param1=='marcas' || $param1=='marca'){
            $id_marca=$param2;
            $txt_marca=$param3;
            $id_coleccion=$param4;

            if ((int)$id_coleccion!=0)
                $this->listado_productos_coleccion('alfombras', $id_coleccion);
            elseif ((int)$id_marca!=0)
                $this->listado_marcas(4, $id_marca);
            else
            $this->listado_marcas(4);
        }
        else    
            $this->listado_productos_nuevo('alfombras');
    }
    function herramientas($param1 = "") {
        if ($param1==='' && strpos($this->uri->uri_string(), 'tienda/herramientas') === 0) { redirect('herramientas', 'location', 301); return; }
        $this->listado_productos_nuevo('herramientas');
    }
    function complementos($param1 = "", $param2 = "", $param3 = "", $param4 = "", $param5 = "") {
        if ($param1==='' && strpos($this->uri->uri_string(), 'tienda/complementos') === 0) { redirect('complementos', 'location', 301); return; }
        $this->listado_productos_nuevo('complementos');
    }


    function papel_pintado_original($param1 = "") {
    	//$this->output->cache(10);
        $econ = 0;
        $losmas = 0;
        if ($this->uri->segment(3) == "economicos") {
            $this->data['donde'] = $this->uri->uri_to_assoc(4);
            $econ = 1;
        } else {
            $this->data['donde'] = $this->uri->uri_to_assoc(3);
        }
        $this->data['donden'] = array();
        $this->data['donden']['marca'] = null;

        // introducir aqui el contenido a mostrar en los metas
        //  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $title = "Papel pintado para Pared - Amplio Catálogo";
        $description = "Elige el Papel Pintado que mejor se adapte a tu ambiente. En nuestro amplio catálogo encontrarás lo que buscas. ¡Visítanos!";
        $keywords = "papel pintado para pared";

        $estilo = "";
        $color = "";
        $this->data['keywords'] = $keywords;
        $image = "";
        $image2 = "";

        /* if(isset($this->data['donde']['marca']))$this->data['donden']['marca']=$this->db->from("demo_categories")->where(array('cat_name'=>$this->data['donde']['marca']))->get()->row()->cat_id;
          else $this->data['donden']['marca']=null; */
        if (isset($this->data['donde']['estilo'])) {
            $this->data['donden']['estilo'] = $this->db->from("demo_estilo")->where(array('estilo_name' => str_replace("-", " ", rawurldecode(strtoupper($this->data['donde']['estilo']))), 'activo' => 1))->like("cats", "Papel Pintado", "both")->get()->row()->estilo_id;

            $this->data['datos_estilo']=$this->flexi_cart_model->get_estilo($this->data['donden']['estilo']);

            $estilo = " - " . $this->data['donde']['estilo'];
        } 
        else
            $this->data['donden']['estilo'] = null;
        if (isset($this->data['donde']['color'])) {
            $this->data['donden']['color'] = $this->db->from("demo_gama")->where(array('gama_name' => str_replace("-", " ", $this->data['donde']['color'])))->get()->row()->gama_id;
            $color = " - " . $this->data['donde']['color'];
        } else
            $this->data['donden']['color'] = null;
        $ord = $this->orden((isset($this->data['donde']['orden']) ? $this->data['donde']['orden'] : 0));
        if (isset($this->data['donde']['economicos']))
            $econ = 1;
        if (isset($this->data['donde']['los_mas_vendidos']))
            $losmas = 1;
        $this->data['categ'] = 0;
        $this->load->model('contenido_model');
        $this->data['portada'] = $this->contenido_model->get_page(1);
        $this->data['promosl'] = $this->contenido_model->get_promos();
        $this->data['promosr'] = $this->contenido_model->get_promos(false);
		if($econ){
			$this->data['images'] = $this->contenido_model->get_imagenes(true, "economicos");
		}
		else{
			$this->data['images'] = $this->contenido_model->get_imagenes(true, "papelpintado");
		}
        
        $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample();
        if (!isset($this->data['donde']['marca']) || $param1 != "marcas") {
            $this->data['fab'] = $this->flexi_cart_model->get_categories("Papel Pintado");
            $this->data['col'] = $this->flexi_cart_model->get_col_array();
        }
        $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
        $this->data['gama'] = $this->flexi_cart_model->get_gamas();
        $this->data['estilo'] = $this->flexi_cart_model->get_estilos();
		
		$this->db->cache_on();
        $this->data['all'] = $this->flexi_cart_model->get_items_filter($this->data['donden']['marca'], $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $this->data['categ'], $econ, $losmas, $ord);
		$this->db->cache_off();
        $categ = "";
        switch ($this->data['categ']) {
            case 0: $categ = "Papel Pintado";
                break;
            case 1: $categ = "Murales";
                break;
            case 2: $categ = "Revestimientos";
                break;
            case 3: $categ = "Telas";
                break;
            case 4: $categ = "Alfombras";
                break;
            case 5: $categ = "Herramientas";
                break;
            default: break;
        }
        if ($param1 == "marcas"){
            $title.=" - Listado de Marcas";
            $title = "Papel pintado para Pared - Amplio Catálogo";
            $this->data['title2'] = "Listado de marcas de papel pintado para pared"; // en title2 damos prioridad a ese título
        }
        else if (isset($this->data['donde']['marca'])) {
            if (isset($this->data['fab']) && $this->data['fab'] != null) {
                $f = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $title=ucwords(str_replace('-', ' ', str_replace('-and-', ' & ', rawurldecode($this->uri->segment(5)))));
                $image = base_url() . "includes/images/logos/" . $this->data['donde']['marca'] . ".jpg";
                $this->_metadatos($f);
            }
            if ($this->uri->segment(6)) {

                $coleccion = $this->flexi_cart_model->get_coleccion($this->uri->segment(6));
                $c = $coleccion[0];
                $image = base_url() . "includes/" . str_replace("../", "", $c->col_ambimg);
                $image2 = base_url() . "includes/" . str_replace("../", "", $c->col_img) . "th.jpg";
                $title=ucwords(str_replace('-', ' ', rawurldecode($this->uri->segment(7))))." - ".$title;
                $this->_metadatos($c);
            }
        }
        $this->data['title'] = $title . " - " . $categ . $estilo . $color." - " ;
        $this->data['familia_producto'] = $categ;
        $this->data['description'] = $description;
        $this->data['losmas'] = $losmas;

        //Aqui van las cabeceras de economicos
        if ($econ == 1) {
            $this->data['title'] = "Papel Pintado Barato - Ahorro Garantizado";
            $this->data['title2'] = "Papel Pintado barato, ¡ahorra hasta un 70%!"; // en title2 damos prioridad a ese título
            $this->data['description'] = "El mejor Papel Pintado outlet. Gran variedad de papeles pintados en liquidación con descuentos de hasta el 70% en nuestro amplio catálogo. ¡Visítanos!";
            $this->data['keywords'] = "papel pintado barato outlet liquidación";
        }
        elseif (isset($this->data['datos_estilo'][0])){
            if(trim($this->data['datos_estilo'][0]->meta_title_estilo)!='')
                $this->data['title'] = str_replace('XXXX', $categ, $this->data['datos_estilo'][0]->meta_title_estilo).' | ';
            if(trim($this->data['datos_estilo'][0]->meta_description_estilo)!='')
                $this->data['description'] = str_replace('XXXX', $categ, $this->data['datos_estilo'][0]->meta_description_estilo);

        }

        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);
        //Fin cabeceras economicos
        $this->load->view('frontend/header', $this->data);
        if (isset($_POST['search']) && trim($_POST['search']) != "") {
            $search = mysql_real_escape_string($_POST['search']);
            $this->db->cache_on();
            $this->data['all'] = $this->flexi_cart_model->search_items($search, 0);
            $this->db->cache_off();
            $this->load->view('frontend/cuerposeccion', $this->data);
        } 
        else if ($param1 == "marcas")
            $this->load->view('frontend/fabricantes', $this->data);
        else if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {
                // Estoy viendo una colección de una marca
                $this->data['datos_coleccion'] = $coleccion[0];
                
                $this->data['cole'] = $this->uri->segment(6);
                $this->db->cache_on();
                $this->data['all'] = $this->flexi_cart_model->get_items_cole($this->uri->segment(6), false, $this->data['categ']);
                $this->db->cache_off();
                //   $this->load->view('frontend/fichamarca', $this->data);
                $this->load->view('frontend/cuerposeccion', $this->data);
            } else {
                $this->data['fab'] = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $this->data['col'] = $this->flexi_cart_model->get_col($this->uri->segment(4), $this->uri->segment(6));
                $this->load->view('frontend/fabricanteficha', $this->data);
            }
        } else {

            if (count($this->data['donde']) == 0){
                //$this->load->view('frontend/slider2', $this->data);
                $this->load->view('frontend/slider_nuevo', $this->data);
            }

            $this->load->view('frontend/cuerposeccion', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }


    function fotomurales_original($param1 = "") {
        $this->data['donde'] = $this->uri->uri_to_assoc(3);
        $this->data['donden'] = array();
        $this->data['donden']['marca'] = null;
        // introducir aqui el contenido a mostrar en los metas
        //  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $title = "Murales - Personaliza tu Espacio";
        $description = "Elige tu Mural y consigue el efecto deseado en tu estancia. En nuestro amplio catálogo encontrarás lo que buscas. ¡Visítanos!";
        $keywords = "murales";
        // NO TOCAR A PARTIR DE AQUI      
        $estilo = "";
        $color = "";
        $this->data['keywords'] = $keywords;
        $image = "";
        $image2 = "";
        $econ = 0;
        $losmas = 0;
        /* if(isset($this->data['donde']['marca']))$this->data['donden']['marca']=$this->db->from("demo_categories")->where(array('cat_name'=>$this->data['donde']['marca']))->get()->row()->cat_id;
          else $this->data['donden']['marca']=null; */
        if (isset($this->data['donde']['estilo'])) {
            $this->data['donden']['estilo'] = $this->db->from("demo_estilo")->where(array('estilo_name' => str_replace("-", " ", $this->data['donde']['estilo']), 'activo' => 1))->like("cats", "Foto Murales", "both")->get()->row()->estilo_id;
            $estilo = " - " . $this->data['donde']['estilo'];
            $this->data['datos_estilo']=$this->flexi_cart_model->get_estilo($this->data['donden']['estilo']);
        } else
            $this->data['donden']['estilo'] = null;
        if (isset($this->data['donde']['color'])) {
            $this->data['donden']['color'] = $this->db->from("demo_gama")->where(array('gama_name' => str_replace("-", " ", $this->data['donde']['color'])))->get()->row()->gama_id;
            $color = " - " . $this->data['donde']['color'];
        } else
            $this->data['donden']['color'] = null;
        $ord = $this->orden((isset($this->data['donde']['orden']) ? $this->data['donde']['orden'] : 0));
        if (isset($this->data['donde']['economicos']))
            $econ = 1;
        if (isset($this->data['donde']['los_mas_vendidos']))
            $losmas = 1;

        $this->load->model('contenido_model');
        $this->data['categ'] = 1;
        $this->data['portada'] = $this->contenido_model->get_page(1);
        $this->data['promosl'] = $this->contenido_model->get_promos();
        $this->data['promosr'] = $this->contenido_model->get_promos(false);
        $this->data['images'] = $this->contenido_model->get_imagenes(true, 'fotomurales');
        $this->data['fab'] = $this->flexi_cart_model->get_categories("Foto Murales");
        $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample("Foto Murales");
        if (!isset($this->data['donde']['marca']) || $param1 != "marcas") {

            $this->data['col'] = $this->flexi_cart_model->get_col_array();
        }
        $this->data['col'] = $this->flexi_cart_model->get_col_array();
        $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
        $this->data['gama'] = $this->flexi_cart_model->get_gamas("Foto Murales");
        $this->data['estilo'] = $this->flexi_cart_model->get_estilos("Foto Murales");
        
        $this->db->cache_on();
        $this->data['all'] = $this->flexi_cart_model->get_items_filter($this->data['donden']['marca'], $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $this->data['categ'], $econ, $losmas, $ord);
        $this->db->cache_off();
        
        $categ = "";
        switch ($this->data['categ']) {
            case 0: $categ = "Papel Pintado";
                break;
            case 1: $categ = "Murales";
                break;
            case 2: $categ = "Revestimientos";
                break;
            case 3: $categ = "Telas";
                break;
            case 4: $categ = "Alfombras";
                break;
            case 5: $categ = "Herramientas";
                break;
            default: break;
        }
        if ($param1 == "marcas"){
            $title.=" - Listado de Marcas";
            $this->data['title2'] = "Listado de marcas de Murales. ¡Personaliza tu Espacio!"; // en title2 damos prioridad a ese título
        }
        else if (isset($this->data['donde']['marca'])) {
            if (isset($this->data['fab']) && $this->data['fab'] != null) {
                $f = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $title=ucwords(str_replace('-', ' ', str_replace('-and-', ' & ', rawurldecode($this->uri->segment(5)))));
                $image = base_url() . "includes/images/logos/" . $this->data['donde']['marca'] . ".jpg";
                $this->_metadatos($f);
            }
            if ($this->uri->segment(6)) {

                $coleccion = $this->flexi_cart_model->get_coleccion($this->uri->segment(6));
                $c = $coleccion[0];
                $image = base_url() . "includes/" . str_replace("../", "", $c->col_ambimg);
                $image2 = base_url() . "includes/" . str_replace("../", "", $c->col_img) . "th.jpg";
                $title=ucwords(str_replace('-', ' ', rawurldecode($this->uri->segment(7))))." - ".$title;
                $description=$c->{'col-desc'};
                $this->_metadatos($c);
            }
        }
        $this->data['familia_producto'] = $categ;
        $this->data['title'] = $title . " - " . $categ . $estilo . $color." - ";
        $this->data['description'] = $description;
        $this->data['losmas'] = $losmas;
        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);

        if (isset($this->data['datos_estilo'][0])){
            if(trim($this->data['datos_estilo'][0]->meta_title_estilo)!='')
                $this->data['title'] = str_replace('XXXX', $categ, $this->data['datos_estilo'][0]->meta_title_estilo).' | ';
            if(trim($this->data['datos_estilo'][0]->meta_description_estilo)!='')
                $this->data['description'] = str_replace('XXXX', $categ, $this->data['datos_estilo'][0]->meta_description_estilo);
        }
        

        $this->load->view('frontend/header', $this->data);
        if (isset($_POST['search']) && trim($_POST['search']) != "") {
            $search = $_POST['search'];
            
            $this->db->cache_on();
            $this->data['all'] = $this->flexi_cart_model->search_items($search, 0);
            $this->db->cache_off();
            
            $this->load->view('frontend/cuerposeccion', $this->data);
        } 
        else if ($param1 == "marcas")
            $this->load->view('frontend/fabricantes', $this->data);
        else if (isset($this->data['donde']['marca'])){
            if ($this->uri->segment(6)) {
                // Estoy viendo una colección de una marca
                $this->data['datos_coleccion'] = $coleccion[0];
                
                $this->data['cole'] = $this->uri->segment(6);
                
                $this->db->cache_on();               
                $this->data['all'] = $this->flexi_cart_model->get_items_cole($this->uri->segment(6), false, $this->data['categ']);
                $this->db->cache_off();
                
                //   $this->load->view('frontend/fichamarca', $this->data);
                $this->load->view('frontend/cuerposeccion', $this->data);
            } 
            else {
                // Estoy viendo las colecciones de una marca
                $this->data['fab'] = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $this->data['col'] = $this->flexi_cart_model->get_col($this->uri->segment(4), $this->data['categ']);
                $this->load->view('frontend/fabricanteficha', $this->data);
            }
        } 
        else {
            if (count($this->data['donde']) == 0){
                //$this->load->view('frontend/slider2', $this->data);
                $this->load->view('frontend/slider_nuevo', $this->data);
            }
            $this->load->view('frontend/cuerposeccion', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function revestimientos_original($param1 = "") {
        $this->data['donde'] = $this->uri->uri_to_assoc(3);
        $this->data['donden'] = array();
        $this->data['donden']['marca'] = null;
        $econ = 0;
        $losmas = 0;

// introducir aqui el contenido a mostrar en los metas
//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $title = "Revestimientos de Pared - Decora tu Pared";
        $description = "Elige el Revestimiento adecuado para tu espacio. En nuestro amplio catálogo encontrarás lo que buscas. ¡Visítanos!";
        $keywords = "revestimientos de pared";
// NO TOCAR A PARTIR DE AQUI      
        $estilo = "";
        $color = "";
        $this->data['keywords'] = $keywords;
        $image = "";
        $image2 = "";
        /* if(isset($this->data['donde']['marca']))$this->data['donden']['marca']=$this->db->from("demo_categories")->where(array('cat_name'=>$this->data['donde']['marca']))->get()->row()->cat_id;
          else $this->data['donden']['marca']=null; */
        if (isset($this->data['donde']['estilo'])) {
            $this->data['donden']['estilo'] = $this->db->from("demo_estilo")->where(array('estilo_name' => str_replace("-", " ", $this->data['donde']['estilo']), 'activo' => 1))->like("cats", "Revestimientos", "both")->get()->row()->estilo_id;
            $estilo = " - " . $this->data['donde']['estilo'];
        } else
            $this->data['donden']['estilo'] = null;
        if (isset($this->data['donde']['color'])) {
            $this->data['donden']['color'] = $this->db->from("demo_gama")->where(array('gama_name' => str_replace("-", " ", $this->data['donde']['color'])))->get()->row()->gama_id;
            $color = " - " . $this->data['donde']['color'];
        } else
            $this->data['donden']['color'] = null;
        if (isset($this->data['donde']['economicos']))
            $econ = 1;
        if (isset($this->data['donde']['los_mas_vendidos']))
            $losmas = 1;
        $ord = $this->orden((isset($this->data['donde']['orden']) ? $this->data['donde']['orden'] : 0));
        $this->load->model('contenido_model');
        $this->data['categ'] = 2;
        $this->data['portada'] = $this->contenido_model->get_page(1);
        $this->data['promosl'] = $this->contenido_model->get_promos();
        $this->data['promosr'] = $this->contenido_model->get_promos(false);
        $this->data['images'] = $this->contenido_model->get_imagenes(true, 'revestimientos');
        $this->data['fab'] = $this->flexi_cart_model->get_categories("Revestimientos");
        $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample("Revestimientos");
        if (!isset($this->data['donde']['marca']) || $param1 != "marcas") {

            $this->data['col'] = $this->flexi_cart_model->get_col_array();
        }
        $this->data['col'] = $this->flexi_cart_model->get_col_array();
        $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
        $this->data['gama'] = $this->flexi_cart_model->get_gamas("Revestimientos");
        $this->data['estilo'] = $this->flexi_cart_model->get_estilos("Revestimientos");
$this->db->cache_on();
        $this->data['all'] = $this->flexi_cart_model->get_items_filter($this->data['donden']['marca'], $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $this->data['categ'], $econ, $losmas, $ord);
$this->db->cache_off();
        $categ = "";
        switch ($this->data['categ']) {
            case 0: $categ = "Papel Pintado";
                break;
            case 1: $categ = "Murales";
                break;
            case 2: $categ = "Revestimientos";
                break;
            case 3: $categ = "Telas";
                break;
            case 4: $categ = "Alfombras";
                break;
            case 5: $categ = "Herramientas";
                break;
            default: break;
        }
        if ($param1 == "marcas"){
            $title.=" - Listado de Marcas";
            //$this->data['title2'] = "Listado de marcas Revestimientos de Pared. ¡Decora tu Pared!"; // en title2 damos prioridad a ese título
            $this->data['title2'] = "Listado de marcas Revestimientos. ¡Decora tu Pared!"; // en title2 damos prioridad a ese título
        }
        else if (isset($this->data['donde']['marca'])) {
            if (isset($this->data['fab']) && $this->data['fab'] != null) {
                $f = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $title=ucwords(str_replace('-', ' ', str_replace('-and-', ' & ', rawurldecode($this->uri->segment(5)))));
                $image = base_url() . "includes/images/logos/" . $this->data['donde']['marca'] . ".jpg";
                $this->_metadatos($f);
            }
            if ($this->uri->segment(6)) {

                $coleccion = $this->flexi_cart_model->get_coleccion($this->uri->segment(6));
                $c = $coleccion[0];
                $image = base_url() . "includes/" . str_replace("../", "", $c->col_ambimg);
                $image2 = base_url() . "includes/" . str_replace("../", "", $c->col_img) . "th.jpg";
                $title=ucwords(str_replace('-', ' ', rawurldecode($this->uri->segment(7))))." - ".$title;
                $this->_metadatos($c);
            }
        }
        $this->data['familia_producto'] = $categ;
        $this->data['title'] = $title . " - " . $categ . $estilo . $color." - ";
        $this->data['description'] = $description;
        $this->data['losmas'] = $losmas;
        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);
        $this->load->view('frontend/header', $this->data);
        if ($param1 == "marcas")
            $this->load->view('frontend/fabricantes', $this->data);
        else if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {
                // Estoy viendo una colección de una marca
                $this->data['datos_coleccion'] = $coleccion[0];
                
                $this->data['cole'] = $this->uri->segment(6);
                $this->db->cache_on();
                $this->data['all'] = $this->flexi_cart_model->get_items_cole($this->uri->segment(6), false, $this->data['categ']);
                $this->db->cache_off();
                //   $this->load->view('frontend/fichamarca', $this->data);
                $this->load->view('frontend/cuerposeccion', $this->data);
            } else {
                $this->data['fab'] = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $this->data['col'] = $this->flexi_cart_model->get_col($this->uri->segment(4), $this->data['categ']);
                $this->load->view('frontend/fabricanteficha', $this->data);
            }
        } else {

            if (count($this->data['donde']) == 0){
                //$this->load->view('frontend/slider2', $this->data);
                $this->load->view('frontend/slider_nuevo', $this->data);
            }

            $this->load->view('frontend/cuerposeccion', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function telas_original($param1 = "") {
        $this->data['donde'] = $this->uri->uri_to_assoc(3);
        $this->data['donden'] = array();
        $this->data['donden']['marca'] = null;
        $econ = 0;
        $losmas = 0;

// introducir aqui el contenido a mostrar en los metas
//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $title = "Telas Online - Amplio Catálogo";
        $description = "Elige la Tela  para decorar tu estancia con personalidad. En nuestro amplio catálogo encontrarás lo que buscas. ¡Visítanos!";
        $keywords = "telas online";
// NO TOCAR A PARTIR DE AQUI      
        $estilo = "";
        $color = "";
        $this->data['keywords'] = $keywords;
        $image = "";
        $image2 = "";
        /* if(isset($this->data['donde']['marca']))$this->data['donden']['marca']=$this->db->from("demo_categories")->where(array('cat_name'=>$this->data['donde']['marca']))->get()->row()->cat_id;
          else $this->data['donden']['marca']=null; */
        if (isset($this->data['donde']['estilo'])) {
            $this->data['donden']['estilo'] = $this->db->from("demo_estilo")->where(array('estilo_name' => str_replace("-", " ", $this->data['donde']['estilo']), 'activo' => 1))->like("cats", "Telas", "both")->get()->row()->estilo_id;
            $estilo = " - " . $this->data['donde']['estilo'];
        } else
            $this->data['donden']['estilo'] = null;
        if (isset($this->data['donde']['color'])) {
            $this->data['donden']['color'] = $this->db->from("demo_gama")->where(array('gama_name' => str_replace("-", " ", $this->data['donde']['color'])))->get()->row()->gama_id;
            $color = " - " . $this->data['donde']['color'];
        } else
            $this->data['donden']['color'] = null;
        if (isset($this->data['donde']['economicos']))
            $econ = 1;
        if (isset($this->data['donde']['los_mas_vendidos']))
            $losmas = 1;
        $ord = $this->orden((isset($this->data['donde']['orden']) ? $this->data['donde']['orden'] : 0));
        $this->load->model('contenido_model');
        $this->data['categ'] = 3;
        $this->data['portada'] = $this->contenido_model->get_page(1);
        $this->data['promosl'] = $this->contenido_model->get_promos();
        $this->data['promosr'] = $this->contenido_model->get_promos(false);
        $this->data['images'] = $this->contenido_model->get_imagenes(true, 'telas');
        $this->data['fab'] = $this->flexi_cart_model->get_categories("Telas");
        $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample("Telas");
        if (!isset($this->data['donde']['marca']) || $param1 != "marcas") {

            $this->data['col'] = $this->flexi_cart_model->get_col_array();
        }
        $this->data['col'] = $this->flexi_cart_model->get_col_array();
        $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
        $this->data['gama'] = $this->flexi_cart_model->get_gamas("Telas");
        $this->data['estilo'] = $this->flexi_cart_model->get_estilos("Telas");
$this->db->cache_on();
        $this->data['all'] = $this->flexi_cart_model->get_items_filter($this->data['donden']['marca'], $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $this->data['categ'], $econ, $losmas, $ord);
$this->db->cache_off();
        $categ = "";
        switch ($this->data['categ']) {
            case 0: $categ = "Papel Pintado";
                break;
            case 1: $categ = "Murales";
                break;
            case 2: $categ = "Revestimientos";
                break;
            case 3: $categ = "Telas";
                break;
            case 4: $categ = "Alfombras";
                break;
            case 5: $categ = "Herramientas";
                break;
            default: break;
        }
        if ($param1 == "marcas"){
            $title.=" - Listado de Marcas";
            $this->data['title2'] = "Listado de marcas de Telas online."; // en title2 damos prioridad a ese título
        }
        else if (isset($this->data['donde']['marca'])) {
            if (isset($this->data['fab']) && $this->data['fab'] != null) {
                $f = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $title=ucwords(str_replace('-', ' ', str_replace('-and-', ' & ', rawurldecode($this->uri->segment(5)))));
                $image = base_url() . "includes/images/logos/" . $this->data['donde']['marca'] . ".jpg";
                $this->_metadatos($f);
            }
            if ($this->uri->segment(6)) {

                $coleccion = $this->flexi_cart_model->get_coleccion($this->uri->segment(6));
                $c = $coleccion[0];
                $image = base_url() . "includes/" . str_replace("../", "", $c->col_ambimg);
                $image2 = base_url() . "includes/" . str_replace("../", "", $c->col_img) . "th.jpg";
                $title=ucwords(str_replace('-', ' ', rawurldecode($this->uri->segment(7))))." - ".$title;
                $this->_metadatos($c);
            }
        }
        $this->data['familia_producto'] = $categ;
        $this->data['title'] = $title . " - " . $categ . $estilo . $color." - ";
        $this->data['description'] = $description;
        $this->data['losmas'] = $losmas;

        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);
        $this->load->view('frontend/header', $this->data);
        if ($param1 == "marcas")
            $this->load->view('frontend/fabricantes', $this->data);
        else if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {
                // Estoy viendo una colección de una marca
                $this->data['datos_coleccion'] = $coleccion[0];
                
                $this->data['cole'] = $this->uri->segment(6);
                $this->db->cache_on();
                $this->data['all'] = $this->flexi_cart_model->get_items_cole($this->uri->segment(6), false, $this->data['categ']);
                $this->db->cache_off();
                //   $this->load->view('frontend/fichamarca', $this->data);
                $this->load->view('frontend/cuerposeccion', $this->data);
            } else {
                $this->data['fab'] = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $this->data['col'] = $this->flexi_cart_model->get_col($this->uri->segment(4), $this->data['categ']);
                $this->load->view('frontend/fabricanteficha', $this->data);
            }
        } else {

            if (count($this->data['donde']) == 0){
                //$this->load->view('frontend/slider2', $this->data);
                $this->load->view('frontend/slider_nuevo', $this->data);
            }

            $this->load->view('frontend/cuerposeccion', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function alfombras_original($param1 = "") {
        $this->data['donde'] = $this->uri->uri_to_assoc(3);
        $this->data['donden'] = array();
        $this->data['donden']['marca'] = null;
        $econ = 0;
        $losmas = 0;

// introducir aqui el contenido a mostrar en los metas
//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $title = "Alfombras a medida -  Decora tu Ambiente";
        $description = "Elige la Alfombra que encaje con tu decoración. En nuestro amplio catálogo encontrarás lo que buscas. Visítanos!";
        $keywords = "alfombras a medida";
// NO TOCAR A PARTIR DE AQUI      
        $estilo = "";
        $color = "";
        $this->data['keywords'] = $keywords;
        $image = "";
        $image2 = "";
        /* if(isset($this->data['donde']['marca']))$this->data['donden']['marca']=$this->db->from("demo_categories")->where(array('cat_name'=>$this->data['donde']['marca']))->get()->row()->cat_id;
          else $this->data['donden']['marca']=null; */
        if (isset($this->data['donde']['estilo'])) {
            $this->data['donden']['estilo'] = $this->db->from("demo_estilo")->where(array('estilo_name' => str_replace("-", " ", $this->data['donde']['estilo']), 'activo' => 1))->like("cats", "Alfombras", "both")->get()->row()->estilo_id;
            $estilo = " - " . $this->data['donde']['estilo'];
        } else
            $this->data['donden']['estilo'] = null;
        if (isset($this->data['donde']['color'])) {
            $this->data['donden']['color'] = $this->db->from("demo_gama")->where(array('gama_name' => str_replace("-", " ", $this->data['donde']['color'])))->get()->row()->gama_id;

            $color = " - " . $this->data['donde']['color'];
        } else
            $this->data['donden']['color'] = null;
        if (isset($this->data['donde']['economicos']))
            $econ = 1;
        if (isset($this->data['donde']['los_mas_vendidos']))
            $losmas = 1;
        $ord = $this->orden((isset($this->data['donde']['orden']) ? $this->data['donde']['orden'] : 0));
        $this->load->model('contenido_model');
        $this->data['categ'] = 4;
        $this->data['portada'] = $this->contenido_model->get_page(1);
        $this->data['promosl'] = $this->contenido_model->get_promos();
        $this->data['promosr'] = $this->contenido_model->get_promos(false);
        $this->data['images'] = $this->contenido_model->get_imagenes(true, 'alfombras');
        $this->data['fab'] = $this->flexi_cart_model->get_categories("Alfombras");
        $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample("Alfombras");
        if (!isset($this->data['donde']['marca']) || $param1 != "marcas") {

            $this->data['col'] = $this->flexi_cart_model->get_col_array();
        }
        $this->data['col'] = $this->flexi_cart_model->get_col_array();
        $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
        $this->data['gama'] = $this->flexi_cart_model->get_gamas("Alfombras");
        $this->data['estilo'] = $this->flexi_cart_model->get_estilos("Alfombras");
$this->db->cache_on();
        $this->data['all'] = $this->flexi_cart_model->get_items_filter($this->data['donden']['marca'], $this->data['donden']['estilo'], $this->data['donden']['color'], 0, $this->data['categ'], $econ, $losmas, $ord);
$this->db->cache_off();
        $categ = "";
        switch ($this->data['categ']) {
            case 0: $categ = "Papel Pintado";
                break;
            case 1: $categ = "Murales";
                break;
            case 2: $categ = "Revestimientos";
                break;
            case 3: $categ = "Telas";
                break;
            case 4: $categ = "Alfombras";
                break;
            case 5: $categ = "Herramientas";
                break;
            default: break;
        }
        if ($param1 == "marcas"){
            $title.=" - Listado de Marcas";
            $this->data['title2'] = "Listado de marcas de Alfombras a medida. ¡Decora tu ambiente!"; // en title2 damos prioridad a ese título
        }
        else if (isset($this->data['donde']['marca'])) {
            if (isset($this->data['fab']) && $this->data['fab'] != null) {
                $f = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $title=ucwords(str_replace('-', ' ', str_replace('-and-', ' & ', rawurldecode($this->uri->segment(5)))));
                $image = base_url() . "includes/images/logos/" . $this->data['donde']['marca'] . ".jpg";
                $this->_metadatos($f);
            }
            if ($this->uri->segment(6)) {

                $coleccion = $this->flexi_cart_model->get_coleccion($this->uri->segment(6));
                $c = $coleccion[0];
                $image = base_url() . "includes/" . str_replace("../", "", $c->col_ambimg);
                $image2 = base_url() . "includes/" . str_replace("../", "", $c->col_img) . "th.jpg";
                $title=ucwords(str_replace('-', ' ', rawurldecode($this->uri->segment(7))))." - ".$title;
                $this->_metadatos($c);
            }
        }
        $this->data['familia_producto'] = $categ;
        $this->data['title'] = $title . " - " . $categ . $estilo . $color." - ";
        $this->data['description'] = $description;
        $this->data['losmas'] = $losmas;

        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);
        $this->load->view('frontend/header', $this->data);
        if ($param1 == "marcas")
            $this->load->view('frontend/fabricantes', $this->data);
        else if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {
                // Estoy viendo una colección de una marca
                $this->data['datos_coleccion'] = $coleccion[0];
                
                $this->data['cole'] = $this->uri->segment(6);
                $this->db->cache_on();
                $this->data['all'] = $this->flexi_cart_model->get_items_cole($this->uri->segment(6), false, $this->data['categ']);
                $this->db->cache_off();
                //   $this->load->view('frontend/fichamarca', $this->data);
                $this->load->view('frontend/cuerposeccion', $this->data);
            } else {
                $this->data['fab'] = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $this->data['col'] = $this->flexi_cart_model->get_col($this->uri->segment(4), $this->data['categ']);
                $this->load->view('frontend/fabricanteficha', $this->data);
            }
        } else {

            if (count($this->data['donde']) == 0){
                //$this->load->view('frontend/slider2', $this->data);
                $this->load->view('frontend/slider_nuevo', $this->data);
            }

            $this->load->view('frontend/cuerposeccion', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function herramientas_original($param1 = "") {
        $this->data['donde'] = $this->uri->uri_to_assoc(3);
        $this->data['donden'] = array();
        $this->data['donden']['marca'] = null;
        $econ = 0;
        $losmas = 0;

// introducir aqui el contenido a mostrar en los metas
//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $title = "Colocar Papel Pintado -  Herramientas";
        $description = "Todo lo que necesitas para colocar el papel pintado. En nuestro amplio catálogo encontrarás lo que buscas. Visítanos!";
        $keywords = "";
// NO TOCAR A PARTIR DE AQUI      
        $this->data['keywords'] = $keywords;
        $image = "";
        $image2 = "";
        /* if(isset($this->data['donde']['marca']))$this->data['donden']['marca']=$this->db->from("demo_categories")->where(array('cat_name'=>$this->data['donde']['marca']))->get()->row()->cat_id;
          else $this->data['donden']['marca']=null; */
        if (isset($this->data['donde']['estilo']))
            $this->data['donden']['estilo'] = $this->db->from("demo_estilo")->where(array('estilo_name' => str_replace("-", " ", $this->data['donde']['estilo'])))->get()->row()->estilo_id;
        else
            $this->data['donden']['estilo'] = null;
        if (isset($this->data['donde']['color']))
            $this->data['donden']['color'] = $this->db->from("demo_gama")->where(array('gama_name' => str_replace("-", " ", $this->data['donde']['color'])))->get()->row()->gama_id;
        else
            $this->data['donden']['color'] = null;
        if (isset($this->data['donde']['economicos']))
            $econ = 1;
        if (isset($this->data['donde']['los_mas_vendidos']))
            $losmas = 1;
        $ord = $this->orden((isset($this->data['donde']['orden']) ? $this->data['donde']['orden'] : 0));
        $this->load->model('contenido_model');
        $this->data['categ'] = 5;
        $this->data['portada'] = $this->contenido_model->get_page(1);
        $this->data['promosl'] = $this->contenido_model->get_promos();
        $this->data['promosr'] = $this->contenido_model->get_promos(false);
        $this->data['images'] = $this->contenido_model->get_imagenes(true, 'herramientas');
        $this->data['fab'] = $this->flexi_cart_model->get_categories("Herramientas");
        $this->data['fabsamp'] = $this->flexi_cart_model->get_categoriessample("Herramientas");
        $this->data['col'] = $this->flexi_cart_model->get_col_array();
        $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
        $this->data['gama'] = $this->flexi_cart_model->get_gamas();
        $this->data['estilo'] = $this->flexi_cart_model->get_estilos();
        $this->data['all'] = $this->flexi_cart_model->get_items_filter(0, 0, 0, 0, $this->data['categ'], $econ, $losmas, $ord);
        $this->data['title'] = $title . " - Herramientas - ";
        $this->load->view('frontend/header', $this->data);

        if (count($this->data['donde']) == 0){
            //$this->load->view('frontend/slider2', $this->data);
            $this->load->view('frontend/slider_nuevo', $this->data);
        }

        $this->load->view('frontend/cuerposeccion', $this->data);
        $this->load->view('frontend/footer', $this->data);
    }

    function get_page($id = 0) {
        $this->load->model('contenido_model');
        echo json_encode($this->contenido_model->get_page($id));
    }

    function fabricantes($categ = 0) {
        if ($categ == -1)
            $categ = "all";
        else if ($categ == 0)
            $categ = "Papel Pintado";
        else if ($categ == 1)
            $categ = "Foto Murales";
        else if ($categ == 2)
            $categ = "Revestimientos";
        else if ($categ == 3)
            $categ = "Telas";
        else if ($categ == 4)
            $categ = "Alfombras";
        $this->data['fab'] = $this->flexi_cart_model->get_categories($categ);
        $this->load->view('frontend/fabricantes', $this->data);
    }

    function marcas($param1 = "",$param2 = "",$param3 = "",$param4 = "",$param5 = "") {
        if ($param1=='marca'){
            if ($param4=='')
                $this->listado_marcas(-1, $param2);
            else{
                if ((int)$param4!=0){
                    // LLega una colección
                    $a_tipos_productos=$this->flexi_cart_model->get_tipos_producto_coleccion($param4);
                    if (count($a_tipos_productos)==0){
                        $this->load->view('frontend/header', $this->data);
                        $this->load->view('frontend/noencontrado_nuevo', $this->data);
                        $this->load->view('frontend/footer', $this->data);
                    }
                    elseif (count( $a_tipos_productos)==1){
                        //listado_productos_coleccion($categoria_principal, $idcoleccion=0)
                        $categ=$a_tipos_productos[0];
                        $parte_comun="/{$param1}/{$param3}/{$param3}/{$param4}/{$param5}";
                        switch ($categ) {
                            case 0: $this->listado_productos_coleccion('papel-pintado', $param4);
                                    $url_redireccion="/tienda/papel_pintado".$parte_comun;
                                    break;
                            case 1: $this->listado_productos_coleccion('fotomurales', $param4);
                                    $url_redireccion="/tienda/fotomurales".$parte_comun;
                                    break;
                            case 2: $this->listado_productos_coleccion('revestimientos', $param4);
                                    $url_redireccion="/tienda/revestimientos".$parte_comun;
                                     break;
                            case 3: $this->listado_productos_coleccion('telas', $param4);
                                    $url_redireccion="/tienda/telas".$parte_comun;
                                    break;
                            case 4: $this->listado_productos_coleccion('alfombras', $param4);
                                    $url_redireccion="/tienda/alfombras".$parte_comun;
                                    break;
                            default: break;
                        }
                        //* Permanently redirect page 301
                        //* Temporaly redirect page 302
                        header("Location: $url_redireccion",TRUE,301);
                        exit;
                    }
                    else{
                        /*
                        $this->load->view('frontend/header', $this->data);
                        $this->load->view('frontend/noencontrado_nuevo', $this->data);
                        $this->load->view('frontend/footer', $this->data);
                        */
                        //Tipos de productos mezclados
                        //echo "diferentes tipos de productos en misma colección";
                        $this->listado_productos_coleccion_todos($param4);
                    }

                }
                else{
                    $this->load->view('frontend/header', $this->data);
                    $this->load->view('frontend/noencontrado_nuevo', $this->data);
                    $this->load->view('frontend/footer', $this->data);
                }
            }
        }
        else
            $this->listado_marcas(-1);
    }


    function no_encontrado() {
        $this->data['articulo_no_encontrado'] = true;
        $this->load->view('frontend/header', $this->data);
        $this->load->view('frontend/noencontrado', $this->data);
        $this->load->view('frontend/footer', $this->data);
    }


     function articulo_original() {
        $keywords = "";
        $this->data['keywords'] = "";
        $array = $this->uri->uri_to_assoc(3);
        $this->data['categ'] = 0;
        if (isset($array["Herramientas"]))
            $this->data['categ'] = 5;
        $this->data['key'] = $this->flexi_cart_model->get_item($array['id'], $this->data['categ']);
        
        if (empty($this->data['key'])){
            //redirect("tienda/no_encontrado");
            $nombre_marca=$this->uri->segment(3);
            $nombre_coleccion=$this->uri->segment(4);
            $item_id=$this->uri->segment(6);

            //Miramos si el item existe en la base de datos pero ya no está publicado
            $datos_item_ko=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_items', 'item_id', array('item_id'=>$item_id));
            $this->data['categ'] = -1;
            if(isset($datos_item_ko[$item_id])){
                //Buscamos otros productos activos de la misma coleccion
                $this->data['categ'] = $datos_item_ko[$item_id]['item_tipo'];
                $this->data['datos_item_ko']=$datos_item_ko[$item_id];
                $this->data['otros_items'] = $this->flexi_cart_model->get_items_cole($datos_item_ko[$item_id]['item_coleccion_id'], false, $datos_item_ko[$item_id]['item_tipo']);
                $this->data['fabricante'] = $this->flexi_cart_model->get_fab($datos_item_ko[$item_id]['item_cat_fk']);
                $this->data['coleccion'] = $this->flexi_cart_model->get_coleccion($datos_item_ko[$item_id]['item_coleccion_id']);
                $this->data['todas_las_colecciones'] = $this->flexi_cart_model->get_col($datos_item_ko[$item_id]['item_cat_fk'], $datos_item_ko[$item_id]['item_tipo']);
            }
            else{
                $marcas=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_categories', 'cat_id', array('publico'=>1));

                foreach($marcas as $id_marca =>$datos){
                    if ($datos['activo']==1 && trim($datos['cat_name'])!='')
                        if ($this->urlenc_aux($datos['cat_name'])==$nombre_marca){
                            $this->data['fabricante'] = $this->flexi_cart_model->get_fab($id_marca);
                            $this->data['todas_las_colecciones'] = $this->flexi_cart_model->get_col($id_marca, -1);
                            break;
                        }
                }
            }
            $this->data['articulo_no_encontrado'] = true;
            $this->load->view('frontend/header_404', $this->data);
            $this->load->view('frontend/noencontrado_nuevo', $this->data);
            $this->load->view('frontend/footer', $this->data);
        }
        else{
            $this->_metadatosarray($this->data['key']);
            if ($this->data['key']['tiene_variantes'] != 0 || $this->data['key']['variante_de'] != 0) {
                $this->data['variantes'] = $this->flexi_cart_model->get_variantes(($this->data['key']['tiene_variantes'] == 0) ? $this->data['key']['variante_de'] : $this->data['key']['item_id']);
            }
            $this->data['otro'] = $this->flexi_cart_model->get_items_cole($this->data['key']['item_coleccion_id'], false, $this->data['key']['item_tipo']);
           
            if ($this->session->userdata('migas')) {
                $this->data['migas'] = $this->session->userdata('migas');
                $this->session->set_userdata('migas', $this->data['migas']);
            }if ($this->session->userdata('busqueda')) {
                $this->data['busqueda'] = $this->session->userdata('busqueda');
                $this->session->set_userdata('busqueda', $this->data['busqueda']);
            }if ($this->session->userdata('colest')) {
                $this->data['colest'] = $this->session->userdata('colest');
                $this->session->set_userdata('colest', $this->data['colest']);
            }
            $categ = "";
            switch ($this->data['key']['item_tipo']) {
                case 0: $categ = "Papel Pintado";$tipo_producto = "Papel Pintado";
                    break;
                case 1: $categ = "Murales";$tipo_producto = "Mural";
                    break;
                case 2: $categ = "Revestimientos";$tipo_producto = "Revestimiento";
                    break;
                case 3: $categ = "Telas";$tipo_producto = "Tela";
                    break;
                case 4: $categ = "Alfombras";$tipo_producto = "Alfombra";
                    break;
                case 5: $categ = "Herramientas";$tipo_producto = "";
                    break;
                default: break;
            }
            $this->data['title'] = (($this->data['key']['item_tipo'] != 5) ? ($this->data['key']['cat_name'] . " - " . $this->data['key']['coleccion_name']) : $this->data['key']['item_name']) . " - " . $this->data['key']['item_ref'];
            $this->data['title'] .=" - " . $categ . " - ";
            $this->data['description'] = html_entity_decode(($this->data['key']['item_tipo'] == 5) ? strip_tags($this->data['key']['item_text']) : strip_tags($this->data['key']['col_text']), ENT_COMPAT, 'UTF-8');
            $image2 = base_url() . "includes/" . str_replace("../", "", $this->data['key']['imgamb']) . "med.jpg";
            $image = base_url() . "includes/" . str_replace("../", "", $this->data['key']['img']) . "med.jpg";
            $articulo = array("precio" => $this->data['key']['item_price']);
            $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2, $articulo);
            
            $this->data['tipo_producto'] = $tipo_producto;

            $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/js/shadowbox/shadowbox.css">';            
            $this->data['includes_footer'][]='<script src="/includes/js/shadowbox/shadowbox.js"></script>';            
            
            $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/js/jsCarousel/jsCarousel-2.0.0.css">';            
            $this->data['includes_footer'][]='<script src="/includes/js/jsCarousel/jsCarousel-2.0.0.js"></script>';            
            
            $this->data['includes_header'][]='<link rel="stylesheet" href="/includes/js/zoomy.css">';            
            $this->data['includes_footer'][]='<script src="/includes/js/jquery.zoomy.min.js"></script>';            
            

            $this->load->view('frontend/header', $this->data);
            if (isset($_GET['test'])){
                $this->load->view('frontend/articulo_eneko', $this->data);
            }
            else
                $this->load->view('frontend/articulo', $this->data);
            $this->load->view('frontend/footer', $this->data);
        }
    }

    function genera_feed_google_merchant($mostrar_todos='') {
        $marcas=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_categories', 'cat_id', array('publico'=>1));
        $a_marcas=array();
        foreach($marcas as $id_marca =>$datos){
            if ($datos['activo']==1 && trim($datos['cat_name'])!='')
                $a_marcas[$id_marca]=$datos['cat_name'];
        }
        /*
        echo "<br />incial: ".count($marcas);
        echo "<br />final: ".count($a_marcas);
        print '<pre><xmp>';
        print_r($a_marcas);
        print '</xmp></pre>';
        */
        $colecciones=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_coleccion', 'coleccion_id', array('publico2'=>1));
        $a_colecciones=array();
        $a_colecciones_aux=array();
        foreach($colecciones as $id_coleccion =>$datos){
            if ($datos['activo']==1 && isset($a_marcas[$datos['coleccion_cat_id']])){
                $a_colecciones[$id_coleccion]['id_marca']=$datos['coleccion_cat_id'];
                $a_colecciones[$id_coleccion]['marca_name']=$a_marcas[$datos['coleccion_cat_id']];
                $a_colecciones[$id_coleccion]['name']=$datos['coleccion_name'];
                $a_colecciones[$id_coleccion]['text']=$datos['col_text'];
                $a_colecciones_aux[$id_coleccion]=$id_coleccion;
           }
        }

        /*
        echo "<br />incial: ".count($colecciones);
        echo "<br />final: ".count($a_colecciones);
        print '<pre><xmp>';
        print_r($a_colecciones);
        print '</xmp></pre>';
        */

        //exit;
        
        /*
        */
        mb_internal_encoding('UTF-8');
        mb_http_output('UTF-8');

        header("Content-type: text/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="utf-8"?>';

        echo '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
        echo '<channel>';
        echo '<title>dePapelPintado.es</title>';
        echo '<link>depapelpintado.es</link>';
        // 2025-04-03 Vamos a preparar para todos los productos, no solo los que estén marcados para market
        if ($mostrar_todos=='all'){
            $productos=$this->flexi_cart_model->get_erregistroak_eremu_guztiak_where_in('demo_items', 'item_id', array('publico3'=>1, 'activo'=>1), $a_colecciones_aux);
        }
        elseif ($mostrar_todos=='test'){
            $a_colecciones_aux=array();
            $a_colecciones_aux[1593]=1593;
            $productos=$this->flexi_cart_model->get_erregistroak_eremu_guztiak_where_in('demo_items', 'item_id', array('publico3'=>1, 'activo'=>1), $a_colecciones_aux);
        }
        else{
            $productos=$this->flexi_cart_model->get_erregistroak_eremu_guztiak_where_in('demo_items', 'item_id', array('publico3'=>1, 'activo'=>1, 'google_market_be'=>1), $a_colecciones_aux);
        }
        //$productos=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_items', 'item_id', array('google_market_be'=>1));
        
        /*
        echo "<br />incial: ".count($productos);
        exit;
        print '<pre><xmp>';
        print_r($productos);
        print '</xmp></pre>';
        */

        $a_ids=array();
        foreach ($productos as $idproducto => $datos) {
            $a_ids[$idproducto]=$idproducto;
        }
        //$descuentos=$this->flexi_cart_model->get_erregistroak_deskontuak($a_ids);
        $descuentos=$this->flexi_cart_model->get_erregistroak_deskontu_guztiak();

        /*
        echo "<br />".count($a_ids);
        print '<pre><xmp>';
        print_r($descuentos);
        print '</xmp></pre>';
        exit;
        */
        $kont=0;
        foreach($productos as $item){
            if (trim($item['meta_description'])!=''){
                $descuento_producto=array();
                if (isset($descuentos[$item['item_id']])){
                    $item = array_merge($item, $descuentos[$item['item_id']]);
                    $descuento_producto=$descuentos[$item['item_id']];
                }
                /*
                if ($kont>90){
                    echo '<item>';
                    $this->item_feed_google_merchant($item, $a_colecciones, $descuento_producto);
                    echo '</item>';
                }
                */
                echo '<item>';
                $this->item_feed_google_merchant($item, $a_colecciones, $descuento_producto);
                echo '</item>';
                $kont++;
            }
            /*
            if ($kont>10000)
                break;
            */
        }

        echo '</channel>';
        echo '</rss>';
        exit;
    }

    private function item_feed_google_merchant($row, $a_colecciones, $descuento_producto) {
        $item="";
        
        $item.="<g:id>".$row["item_id"]."</g:id>\n";
        //$item.= "<g:mpn>".$row["nid"]."</g:mpn>\n";
        if (trim($row['item_name'])!=''){
            //$item.= "<g:title><![CDATA[".$row["item_name"]."]]></g:title>\n";
            $item.= "<g:title>".str_replace('&', '&#038;', $row["item_name"])."</g:title>\n";
        }
        else{
            $nombre_completo=$a_colecciones[$row['item_coleccion_id']]['marca_name']." ".$a_colecciones[$row['item_coleccion_id']]['name']." ".$row['item_ref'];
            //$item.= "<g:title><![CDATA[".$nombre_completo."]]></g:title>\n";
            $nombre_completo=str_replace('&', '&#038;', $nombre_completo);
            $item.= "<g:title>".$nombre_completo."</g:title>\n";
        }
        //$item.= "<g:description><![CDATA[".$row["meta_description"]."]]></g:description>\n";
        $item.= "<g:description>".str_replace('&', '&#038;', $row["meta_description"])."</g:description>\n";
        $item.= "<g:condition>new</g:condition>\n";
        
        $url='/tienda/articulo/';
        if($row['item_tipo']==5){
            $url.='Herramientas/';
            $url.=$this->urlenc_aux(strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $row['item_name'])));
        }
        else{
            $url.=$this->urlenc_aux($a_colecciones[$row['item_coleccion_id']]['marca_name']).'/';
            $url.=$this->urlenc_aux($a_colecciones[$row['item_coleccion_id']]['name']).'/';
        }
        $url.='id/'.$row["item_id"];

        $item.= "<g:link>https://depapelpintado.es".$url."</g:link>\n";
        
        //$item.= "<g:image_link>https://depapelpintado.es/".str_replace('../', 'includes/', $row["img"])."th.jpg</g:image_link>\n";
        $item.= "<g:image_link>https://depapelpintado.es/".str_replace('../', 'includes/', $row["img"])."med.jpg</g:image_link>\n";
        
        $item.= "<g:availability>in_stock</g:availability>\n";
        $item.= "<g:price>".number_format($row["item_price"],2)." EUR</g:price>\n";

        if (count($descuento_producto)){
            $precio=$row['item_price'];
            if($row['item_unidad']=="m2") $mostrarunidad="m<sup>2</sup>";
            else if($row['item_unidad']=="m lineal") $mostrarunidad="Metro Lineal";
            else $mostrarunidad=$row['item_unidad'];

            $preciobase=$precio;
            $preal=$row['item_price'];
            if($row['item_economico']){
                $precio='<span style="font-size:18px;color:#AE0058"><strong>'.$precio.' €/'.$mostrarunidad.'</strong></span>';
            }

            if(isset($row['disc_status']) && $row['disc_status']==1 && $row['disc_type_fk']==1){//tipo de descuento
                if($row['disc_method_fk']==1){//%
                    $preal=($row['item_price']*(100-$row['disc_value_discounted'])/100);
                    $precio='<span><strike><span id="pb">'.$row['item_price'].'</span> €/'.$mostrarunidad.'</strike></span><br><span style="font-size:18px;color:#AE0058"><strong>'.number_format(round($preal,2),2).' €/'.$mostrarunidad.'</strong>';
                }
                else if($row['disc_status']==1 && $row['disc_method_fk']==2){//%
                    $preal=($row['item_price']-$row['disc_value_discounted']);
                    $precio='<span><strike>'.$row['item_price'].' €/'.$row['item_unidad'].'</strike></span><br><span style="font-size:18px;color:#AE0058"><strong>'.number_format(round($preal,2),2).' €/'.$row['item_unidad'].'</strong>';
                }
            }
            elseif(!$row['item_economico']){
                $precio=$precio.' €/'.$mostrarunidad;
            }

            //echo '<b>'.$precio.'</b>';

            $item.= "<g:sale_price>".number_format($preal,2)." EUR</g:sale_price>\n";

        }
        
        switch ($row['item_tipo']) {
            case '0':
                $google_product_category=2334; // Casa y jardín > Decoración > Papel pintado
                break;
            case '4':
                $google_product_category=598; // Casa y jardín > Decoración > Alfombras
                break;
            default:
                $google_product_category=696; // Casa y jardín > Decoración
                break;
        }
        $item.= "<g:google_product_category>".$google_product_category."</g:google_product_category>\n";
        //$item.= "<g:brand><![CDATA[".utf8_encode($a_colecciones[$row['item_coleccion_id']]['marca_name'])."]]></g:brand>\n";
        $item.= "<g:brand>".str_replace('&', '&#038;', utf8_encode($a_colecciones[$row['item_coleccion_id']]['marca_name']))."</g:brand>\n";

        /*

        $item.= "<g:product_type>".$row["family"]."</g:product_type>\n";

        //$item.= "<g:gtin>".$row["gtin"]."</g:gtin>\n";

        $item.= "<g:shipping>\n";
        $item.= "<g:country>ES</g:country>\n";
        $item.= "<g:service>".$sellDesc."</g:service>\n";
        $item.= "<g:price>".$sellPrice." EUR</g:price>\n";
        $item.= "</g:shipping>\n";

        $item.= "<g:is_bundle>no</g:is_bundle>\n";
        */

        /* Devuelve el stock por cada variante */
        /*
        $stocks=getStockOptions( $conn, $row["nid"] );

        $ageGroups=array_fields( $row["google_age_groups"] );
        $genders=array_fields( $row["google_genders"] );
        $sizeTypes=array_fields( $row["google_size_types"] );

        $r=combinate( $item,$stocks,$ageGroups,$genders,$sizeTypes );

        echo $r;
        */
        echo $item;
        /*
        print '<pre><xmp>';
        print_r($row);
        print '</xmp></pre>';
        print '<pre><xmp>';
        print_r($item);
        print '</xmp></pre>';
        exit;
        */
    }

    function genera_feed_meta($mostrar_todos='') {
        $marcas=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_categories', 'cat_id', array('publico'=>1));
        $a_marcas=array();
        foreach($marcas as $id_marca =>$datos){
            if ($datos['activo']==1 && trim($datos['cat_name'])!='')
                $a_marcas[$id_marca]=$datos['cat_name'];
        }

        $colecciones=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_coleccion', 'coleccion_id', array('publico2'=>1, 'xml_META_be'=>1));
        $a_colecciones=array();
        $a_colecciones_aux=array();
        foreach($colecciones as $id_coleccion =>$datos){
            if ($datos['activo']==1 && isset($a_marcas[$datos['coleccion_cat_id']])){
                $a_colecciones[$id_coleccion]['id_marca']=$datos['coleccion_cat_id'];
                $a_colecciones[$id_coleccion]['marca_name']=$a_marcas[$datos['coleccion_cat_id']];
                $a_colecciones[$id_coleccion]['name']=$datos['coleccion_name'];
                $a_colecciones[$id_coleccion]['text']=$datos['col_text'];
                $a_colecciones_aux[$id_coleccion]=$id_coleccion;
           }
        }

        mb_internal_encoding('UTF-8');
        mb_http_output('UTF-8');

        header("Content-type: text/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="utf-8"?>';

        echo '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
        echo '<channel>';
        echo '<title>dePapelPintado.es</title>';
        echo '<link>depapelpintado.es</link>';

        if ($mostrar_todos=='test'){
            $a_colecciones_aux=array();
            $a_colecciones_aux[1593]=1593;
            $productos=$this->flexi_cart_model->get_erregistroak_eremu_guztiak_where_in('demo_items', 'item_id', array('publico3'=>1, 'activo'=>1), $a_colecciones_aux);
        }
        else{
            $productos=$this->flexi_cart_model->get_erregistroak_eremu_guztiak_where_in('demo_items', 'item_id', array('publico3'=>1, 'activo'=>1), $a_colecciones_aux);
        }


        $a_ids=array();
        foreach ($productos as $idproducto => $datos) {
            $a_ids[$idproducto]=$idproducto;
        }



        $descuentos=$this->flexi_cart_model->get_erregistroak_deskontu_guztiak();

        $kont=0;
        foreach($productos as $item){
            if (trim($item['meta_description'])!=''){
                $descuento_producto=array();
                if (isset($descuentos[$item['item_id']])){
                    $item = array_merge($item, $descuentos[$item['item_id']]);
                    $descuento_producto=$descuentos[$item['item_id']];
                }

                echo '<item>';
                $this->item_feed_google_merchant($item, $a_colecciones, $descuento_producto);
                echo '</item>';
                $kont++;
            }
        }
        /*
        print '<pre><xmp>';
        print_r($a_ids);
        print '</xmp></pre>';
        exit;
        */
        echo '</channel>';
        echo '</rss>';
        exit;
    }

    function sitemap_marcas_colecciones() {
        $marcas=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_categories', 'cat_id', array('publico'=>1));
        $a_marcas=array();
        foreach($marcas as $id_marca =>$datos){
            if ($datos['activo']==1 && trim($datos['cat_name'])!='')
                $a_marcas[$id_marca]=$datos['cat_name'];
        }
        
        $colecciones=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_coleccion', 'coleccion_id', array('publico2'=>1));
        $a_colecciones=array();
        $a_colecciones_aux=array();
        foreach($colecciones as $id_coleccion =>$datos){
            if ($datos['activo']==1 && trim($datos['coleccion_name'])!='' && isset($a_marcas[$datos['coleccion_cat_id']])){
                $idmarca=$datos['coleccion_cat_id'];
                $a_colecciones[$idmarca][$id_coleccion]=$datos['coleccion_name'];
                $a_colecciones_aux[$id_coleccion]=$id_coleccion;
           }
        }
        header('Content-Type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="https://depapelpintado.es/sitemaps/main-sitemap.xsl"?>';
        echo "\n<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'> \n";
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/tienda/marcas</loc>\n";
        echo "</url>\n";
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/tienda/papel_pintado/marcas</loc>\n";
        echo "</url>\n";
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/tienda/fotomurales/marcas</loc>\n";
        echo "</url>\n";
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/tienda/revestimientos/marcas</loc>\n";
        echo "</url>\n";
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/tienda/telas/marcas</loc>\n";
        echo "</url>\n";
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/tienda/alfombras/marcas</loc>\n";
        echo "</url>\n";
        asort($a_marcas);
        foreach ($a_marcas as $idmarca => $nombre_marca) {
            echo "<url>\n";
            echo "       <loc>https://depapelpintado.es/tienda/marcas/marca/$idmarca/".$this->urlenc_aux($nombre_marca)."</loc>\n";
            echo "</url>\n";
            if (isset($a_colecciones[$idmarca])){
                $colecciones_tratar=$a_colecciones[$idmarca];
                asort($colecciones);
                foreach ($colecciones_tratar as $idcoleccion => $nombre_coleccion) {
                    echo "<url>\n";
                    echo "       <loc>https://depapelpintado.es/tienda/marcas/marca/$idmarca/".$this->urlenc_aux($nombre_marca)."/$idcoleccion/".$this->urlenc_aux($nombre_coleccion)."</loc>\n";
                    echo "</url>\n";
                }
            }
        }
        echo "</urlset>\n";
    }
    
    function sitemap_papeles_pintados() {
        $this->sitemap_articulos(0);
    }
    function sitemap_fotomurales() {
        $this->sitemap_articulos(1);
    }
    function sitemap_revestimientos() {
        $this->sitemap_articulos(2);
    }
    function sitemap_telas() {
        $this->sitemap_articulos(3);
    }
    function sitemap_alfombras() {
        $this->sitemap_articulos(4);
    }


    function sitemap_herramientas() {
        $productos=$this->flexi_cart_model->get_erregistroak_sitemaperako('demo_items', 'item_id', array('item_tipo'=>5, 'publico3'=>1, 'activo'=>1));
        $a_productos=array();
        foreach($productos as $item_id =>$datos){
            $a_productos[$item_id]=$datos['item_name'];
        }

        header('Content-Type: text/xml');
        echo "<?xml version='1.0' encoding='UTF-8'?><?xml-stylesheet type='text/xsl' href='https://depapelpintado.es/sitemaps/main-sitemap.xsl'?>\n";
        echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'> \n";
        foreach ($a_productos as $idproducto=>$nombre_producto) {
            echo "<url>\n";
            echo "       <loc>https://depapelpintado.es/tienda/articulo/Herramientas/".$this->urlenc_aux($nombre_producto)."/id/{$idproducto}</loc>\n";
            echo "</url>\n";
        }
        echo "</urlset>\n";

    }

    private function sitemap_articulos($item_tipo) {
        $marcas=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_categories', 'cat_id', array('publico'=>1));
        $a_marcas=array();
        foreach($marcas as $id_marca =>$datos){
            if ($datos['activo']==1 && trim($datos['cat_name'])!='')
                $a_marcas[$id_marca]=$datos['cat_name'];
        }
        
        $colecciones=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_coleccion', 'coleccion_id', array('publico2'=>1));
        $a_colecciones=array();
        $a_colecciones_aux=array();
        foreach($colecciones as $id_coleccion =>$datos){
            if ($datos['activo']==1 && trim($datos['coleccion_name'])!='' && isset($a_marcas[$datos['coleccion_cat_id']])){
                $idmarca=$datos['coleccion_cat_id'];
                $a_colecciones[$idmarca][$id_coleccion]=$datos['coleccion_name'];
                $a_colecciones_aux[$id_coleccion]=$id_coleccion;
           }
        }
        
        $productos=$this->flexi_cart_model->get_erregistroak_sitemaperako('demo_items', 'item_id', array('item_tipo'=>$item_tipo, 'publico3'=>1, 'activo'=>1), $a_colecciones_aux);
        $a_productos=array();
        foreach($productos as $item_id =>$datos){
            if (trim($datos['img'])!=''){
                $idmarca=$datos['item_cat_fk'];
                $idcoleccion=$datos['item_coleccion_id'];
                $a_productos[$idmarca][$idcoleccion][$item_id]=$datos['item_id'];
            }
        }
        

        header('Content-Type: text/xml');
        echo "<?xml version='1.0' encoding='UTF-8'?><?xml-stylesheet type='text/xsl' href='https://depapelpintado.es/sitemaps/main-sitemap.xsl'?>\n";
        echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'> \n";
        asort($a_marcas);
        foreach ($a_marcas as $idmarca => $nombre_marca) {
            if (isset($a_colecciones[$idmarca])){
                $colecciones_tratar=$a_colecciones[$idmarca];
                asort($colecciones);
                foreach ($colecciones_tratar as $idcoleccion => $nombre_coleccion) {
                    if (isset($a_productos[$idmarca][$idcoleccion])){
                        foreach ($a_productos[$idmarca][$idcoleccion] as $idproducto) {
                            echo "<url>\n";
                            echo "       <loc>https://depapelpintado.es/tienda/articulo/".$this->urlenc_aux($nombre_marca)."/".$this->urlenc_aux($nombre_coleccion)."/id/{$idproducto}</loc>\n";
                            echo "</url>\n";
                        }
                    }
                }
            }
        }
        echo "</urlset>\n";
    }

    function sitemap_articulos_test($item_tipo) {
        $marcas=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_categories', 'cat_id', array('publico'=>1));
        $a_marcas=array();
        foreach($marcas as $id_marca =>$datos){
            if ($datos['activo']==1 && trim($datos['cat_name'])!='')
                $a_marcas[$id_marca]=$datos['cat_name'];
        }
        
        $colecciones=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_coleccion', 'coleccion_id', array('publico2'=>1));
        $a_colecciones=array();
        $a_colecciones_aux=array();
        foreach($colecciones as $id_coleccion =>$datos){
            if ($datos['activo']==1 && trim($datos['coleccion_name'])!='' && isset($a_marcas[$datos['coleccion_cat_id']])){
                $idmarca=$datos['coleccion_cat_id'];
                $a_colecciones[$idmarca][$id_coleccion]=$datos['coleccion_name'];
                $a_colecciones_aux[$id_coleccion]=$id_coleccion;
           }
        }
        
        $productos=$this->flexi_cart_model->get_erregistroak_sitemaperako('demo_items', 'item_id', array('item_tipo'=>$item_tipo, 'publico3'=>1, 'activo'=>1), $a_colecciones_aux);
        $a_productos=array();
        foreach($productos as $item_id =>$datos){
            if (trim($datos['img'])!=''){
                $idmarca=$datos['item_cat_fk'];
                $idcoleccion=$datos['item_coleccion_id'];
                $a_productos[$idmarca][$idcoleccion][$item_id]=$datos['item_id'];
            }
        }
        /*
        print '<pre><xmp>';
        print_r($a_marcas);
        print '</xmp></pre>';
        print '<pre><xmp>';
        print_r($a_colecciones);
        print '</xmp></pre>';
        print '<pre><xmp>';
        print_r($a_productos);
        print '</xmp></pre>';
        //exit;
        */

        header('Content-Type: text/xml');
        echo "<?xml version='1.0' encoding='UTF-8'?><?xml-stylesheet type='text/xsl' href='https://depapelpintado.es/sitemaps/main-sitemap.xsl'?>\n";
        echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'> \n";
        asort($a_marcas);
        foreach ($a_marcas as $idmarca => $nombre_marca) {
            if (isset($a_colecciones[$idmarca])){
                $colecciones_tratar=$a_colecciones[$idmarca];
                asort($colecciones);
                foreach ($colecciones_tratar as $idcoleccion => $nombre_coleccion) {
                    if (isset($a_productos[$idmarca][$idcoleccion])){
                        foreach ($a_productos[$idmarca][$idcoleccion] as $idproducto) {
                            echo "<url>\n";
                            echo "       <loc>https://depapelpintado.es/tienda/articulo/".$this->urlenc_aux($nombre_marca)."/".$this->urlenc_aux($nombre_coleccion)."/id/{$idproducto}</loc>\n";
                            echo "</url>\n";
                        }
                    }
                }
            }
        }
        echo "</urlset>\n";
    }

    function sitemap_nuevas_categorias() {
        header('Content-Type: text/xml');
        echo "<?xml version='1.0' encoding='UTF-8'?><?xml-stylesheet type='text/xsl' href='https://depapelpintado.es/sitemaps/main-sitemap.xsl'?>\n";
        echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'> \n";
        /*
        print '<pre><xmp>';
        print_r($papel_categorias_seo);
        print '</xmp></pre>';
        exit;
        */
        
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/estilos-papel-pintado</loc>\n";
        echo "</url>\n";
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/estilos-fotomurales</loc>\n";
        echo "</url>\n";
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/estilos-revestimientos</loc>\n";
        echo "</url>\n";
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/estilos-telas</loc>\n";
        echo "</url>\n";
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/estilos-alfombras</loc>\n";
        echo "</url>\n";
        $papel_categorias_seo=$this->flexi_cart_model->get_categorias_seo_menu(0);
        foreach ($papel_categorias_seo as $txt_familia_categoria => $a_categorias_familia) {
          foreach ($a_categorias_familia as $id => $datos_categorias_familia) {
            echo "<url>\n";
            echo "       <loc>https://depapelpintado.es/".$datos_categorias_familia['url']."</loc>\n";
            echo "</url>\n";
          }
        }
        $fotomurales_categorias_seo=$this->flexi_cart_model->get_categorias_seo_menu(1);
        foreach ($fotomurales_categorias_seo as $txt_familia_categoria => $a_categorias_familia) {
          foreach ($a_categorias_familia as $id => $datos_categorias_familia) {
            echo "<url>\n";
            echo "       <loc>https://depapelpintado.es/".$datos_categorias_familia['url']."</loc>\n";
            echo "</url>\n";
          }
        }
        $revestimientos_categorias_seo=$this->flexi_cart_model->get_categorias_seo_menu(2);
        foreach ($revestimientos_categorias_seo as $txt_familia_categoria => $a_categorias_familia) {
          foreach ($a_categorias_familia as $id => $datos_categorias_familia) {
            echo "<url>\n";
            echo "       <loc>https://depapelpintado.es/".$datos_categorias_familia['url']."</loc>\n";
            echo "</url>\n";
          }
        }
        $telas_categorias_seo=$this->flexi_cart_model->get_categorias_seo_menu(3);
        foreach ($telas_categorias_seo as $txt_familia_categoria => $a_categorias_familia) {
          foreach ($a_categorias_familia as $id => $datos_categorias_familia) {
            echo "<url>\n";
            echo "       <loc>https://depapelpintado.es/".$datos_categorias_familia['url']."</loc>\n";
            echo "</url>\n";
          }
        }
        $alfombras_categorias_seo=$this->flexi_cart_model->get_categorias_seo_menu(4);
        foreach ($alfombras_categorias_seo as $txt_familia_categoria => $a_categorias_familia) {
          foreach ($a_categorias_familia as $id => $datos_categorias_familia) {
            echo "<url>\n";
            echo "       <loc>https://depapelpintado.es/".$datos_categorias_familia['url']."</loc>\n";
            echo "</url>\n";
          }
        }

        echo "</urlset>\n";

    }

    function sitemap_caracteristicas() {
        header('Content-Type: text/xml');
        echo "<?xml version='1.0' encoding='UTF-8'?><?xml-stylesheet type='text/xsl' href='https://depapelpintado.es/sitemaps/main-sitemap.xsl'?>\n";
        echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'> \n";

        $this->sitemap_categoria("Papel pintado");
        $this->sitemap_categoria("Foto Murales");
        $this->sitemap_categoria("Revestimientos");
        $this->sitemap_categoria("Telas");
        $this->sitemap_categoria("Alfombras");
        /*
        */
        echo "</urlset>\n";

    }
    private function sitemap_categoria($categoria) {
        $gamas = $this->flexi_cart_model->get_gamas($categoria);
        $estilos = $this->flexi_cart_model->get_estilos($categoria);
        if ($categoria=='Foto Murales' || $categoria=='Fotomurales')
            $categoria='Murales';

        $categoria=str_replace(' ', '_', $categoria);
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/tienda/".$this->urlenc_aux($categoria)."</loc>\n";
        echo "</url>\n";
        if ($categoria=='Papel_pintado'){
            echo "<url>\n";
            echo "       <loc>https://depapelpintado.es/tienda/".$this->urlenc_aux($categoria)."/economicos</loc>\n";
            echo "</url>\n";
        }
        echo "<url>\n";
        echo "       <loc>https://depapelpintado.es/tienda/".$this->urlenc_aux($categoria)."/los_mas_vendidos</loc>\n";
        echo "</url>\n";
        foreach ($gamas as $gama) {
            echo "<url>\n";
            echo "  <loc>https://depapelpintado.es/tienda/".$this->urlenc_aux($categoria)."/color/".$this->urlenc_aux($gama->gama_name)."</loc>\n";
            echo "</url>\n";
        }

        foreach ($estilos as $estilo) {
            echo "<url>\n";
            echo "  <loc>https://depapelpintado.es/tienda/".$this->urlenc_aux($categoria)."/estilo/".$this->urlenc_aux($estilo->estilo_name)."</loc>\n";
            echo "</url>\n";
        }
    }


    
    public function urlenc_aux($str){
        //$search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,!,(,)");
        //$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,ñ,,,");
        $search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,%,!,(,)");
        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,ñ,,,,");

        return str_replace($search,$replace,strtolower(str_replace(',','', str_replace('+','-plus-',str_replace('#','number-',str_replace('&','and',str_replace(' ','-',rawurldecode($str))))))));
    }


    /**
     * view_cart
     * View and manage the contents of the cart.
     */
    function carrito() {
        $this->view_cart();
    }

    function view_cart() {
    	
        // Update cart contents and settings.
        if ($this->input->post('update')) {

            $this->update_cart();
            $this->test_codes();
            redirect('tienda/view_cart');
        }
        // Update discount codes.
        else if ($this->input->post('update_discount')) {
            $this->update_discount_codes();
        }
        // Remove discount code.
        else if ($this->input->post('remove_discount_code')) {
            $this->remove_discount_code();
        }
        // Remove all discount codes.
        else if ($this->input->post('remove_all_discounts')) {
            $this->remove_all_discounts();
        }
        // Clear / Empty cart contents.
        else if ($this->input->post('clear')) {
            $this->destroy_cart();
        }
        // Destroy all cart items and settings and reset to default settings.
        else if ($this->input->post('destroy')) {
            $this->destroy_cart();
        }
        // Navigate to checkout page.
        else if ($this->input->post('checkout')) {
            // Check if order surpasses the required minimum order value.
            if ($this->flexi_cart->minimum_order_status() && $this->flexi_cart->location_shipping_status(FALSE)) {
                // Minimum order value has been reached, proceed to the checkout page.
                redirect('tienda/checkout');
            }

            // Minimum order value has not been reached, set a custom error message notifying the user.			
            if (!$this->flexi_cart->minimum_order_status()) {
                $this->flexi_cart->set_error_message('The minimum order value of ' . $this->flexi_cart->minimum_order() . ' has not been reached.', 'public');
            }

            // There are no items in the cart that can currently be shipped to the current shipping location, set a custom error message notifying the user.
            if (!$this->flexi_cart->location_shipping_status(FALSE)) {
                $this->flexi_cart->set_error_message('There are no items in the cart that can currently be shipped to the current shipping location.', 'public');
            }

            // Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

            redirect('tienda/view_cart');
        }

        ###+++++++++++++++++++++++++++++++++###
        // Get required data on cart items, discounts and surcharges to display in the cart.
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['reward_vouchers'] = $this->flexi_cart->reward_voucher_data();
        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();
        $this->data['surcharges'] = $this->flexi_cart->surcharge_data();
		
        ###+++++++++++++++++++++++++++++++++###
        // This example shows how to lookup countries, states and post codes that can be used to calculate shipping rates.
        $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));
        $this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);
        $this->data['states'] = $this->flexi_cart->get_shipping_location_array($sql_select, 1);
        $this->data['postal_codes'] = $this->flexi_cart->get_shipping_location_array($sql_select, 2);
        $this->data['shipping_options'] = $this->flexi_cart->get_shipping_options();
		
        $this->data['fab'] = $this->flexi_cart_model->get_categories();
        $this->data['col'] = $this->flexi_cart_model->get_col_array();
        $this->data['mod'] = $this->flexi_cart_model->get_mod_array();
        $this->data['gama'] = $this->flexi_cart_model->get_gamas();
        $this->data['estilo'] = $this->flexi_cart_model->get_estilos();
        $this->db->cache_on();
        $this->data['all'] = $this->flexi_cart_model->get_items_filter();
        $this->db->cache_off();
        // Uncomment the lines below to use the manual shipping example. Read more below.
        # $this->load->model('demo_cart_model');
        # $this->data['shipping_options'] = $this->demo_cart_model->demo_manual_shipping_options(); 

        /**
         * By default, this demo is setup to show how to implement shipping rates with a database.
         * In the 2 steps below is an example showing how to manually set and define shipping options and rates.
         *
         * To use this example follow these steps:
         * #1: Replace the four "$this->data" arrays set above with "$this->data['shipping_options'] = $this->demo_cart_model->demo_manual_shipping_options();".
         * #2: Set "$config['database']['shipping_options']['table']" and "$config['database']['shipping_rates']['table']" to FALSE via the config file.
         */
        ###+++++++++++++++++++++++++++++++++###
        // Get any status message that may have been set.
        $this->data['message'] = $this->session->flashdata('message');


        $this->data['meta_title']='Carrito de compras'; 
        $this->data['meta_description']='Listado de productos seleccionados. ¡Finaliza du compra!'; 
        $this->data['a_migas']['/tienda/carrito']='Carrito';

        //$this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            
        $this->data['includes_footer'][]='<script src="/includes/js/carrito.js"></script>';            
        $this->data['includes_footer'][]='<script src="https://www.paypal.com/sdk/js?client-id=AbM4hpWmFs3LQpp6_C-JtlgwSrZp_RLwZv_2TUhQKdvWwRkBwc5Ip0ZPl62LDxiHC3Hf_8wzzby_2EES&currency=EUR&components=messages" data-namespace="PayPalSDK"></script>';         

        if (!$this->input->is_ajax_request()) {
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/migas_nuevas_small', $this->data);
        }
        $this->load->view('demo/cart_view', $this->data);
        if (!$this->input->is_ajax_request()) {
            $this->load->view('frontend/footer', $this->data);
            // $this->load->view('demo/tienda', $this->data);
        }
    }
    
	function carrito_eneko() {
		$this->view_cart_eneko();
	}

	function view_cart_eneko() {
		// Update cart contents and settings.
		if ($this->input->post('update')) {
			//~ print '<pre><xmp>';
			//~ print_r($_POST);
			//~ print '</xmp></pre>';
			$this->test_codes();
            $this->update_cart();
			redirect('tienda/view_cart');
		}
		// Update discount codes.
		else if ($this->input->post('update_discount')) {
			//~ print '<pre><xmp>';
			//~ print_r($_POST);
			//~ print '</xmp></pre>';
			//~ exit;
			$this->update_discount_codes();
		}
		// Remove discount code.
		else if ($this->input->post('remove_discount_code')) {
			$this->remove_discount_code();
		}
		// Remove all discount codes.
		else if ($this->input->post('remove_all_discounts')) {
			$this->remove_all_discounts();
		}
		// Clear / Empty cart contents.
		else if ($this->input->post('clear')) {
    		$this->destroy_cart();
		}
		// Destroy all cart items and settings and reset to default settings.
		else if ($this->input->post('destroy')) {
			$this->destroy_cart();
		}
		// Navigate to checkout page.
		else if ($this->input->post('checkout')) {
			// Check if order surpasses the required minimum order value.
			if ($this->flexi_cart->minimum_order_status() && $this->flexi_cart->location_shipping_status(FALSE)) {
				// Minimum order value has been reached, proceed to the checkout page.
				redirect('tienda/checkout');
			}

			// Minimum order value has not been reached, set a custom error message notifying the user.			
			if (!$this->flexi_cart->minimum_order_status()) {
				$this->flexi_cart->set_error_message('The minimum order value of ' . $this->flexi_cart->minimum_order() . ' has not been reached.', 'public');
			}

			// There are no items in the cart that can currently be shipped to the current shipping location, set a custom error message notifying the user.
			if (!$this->flexi_cart->location_shipping_status(FALSE)) {
				$this->flexi_cart->set_error_message('There are no items in the cart that can currently be shipped to the current shipping location.', 'public');
			}

			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart->get_messages());

			redirect('tienda/view_cart');
		}

		###+++++++++++++++++++++++++++++++++###
		// Get required data on cart items, discounts and surcharges to display in the cart.
		$this->data['cart_items'] = $this->flexi_cart->cart_items();

		$this->data['reward_vouchers'] = $this->flexi_cart->reward_voucher_data();
		$this->data['discounts'] = $this->flexi_cart->summary_discount_data();
		//~ echo "<br />".$this->db->last_query();
		//~ $this->data['discounts_eneko'] = $this->flexi_cart->item_summary_discount_data();
		//~ echo "<br />".$this->db->last_query();
        /*
        print '<pre><xmp>';
        print_r($this->data['cart_items']);
        print '</xmp></pre>';
        print '<pre><xmp>';
        print_r($this->data['reward_vouchers']);
        print '</xmp></pre>';
        print '<pre><xmp>';
        print_r($this->data['discounts']);
        print '</xmp></pre>';

		*/
        $acumulado_para_portes_especiales=0;
        $portes_especiales=0;
        foreach ($this->data['cart_items'] as $id_aux => $item_aux) {
            if ($item_aux['idmarca']==174) {
                $acumulado_para_portes_especiales+=$item_aux['discount_price_total'];
            }
        }
        if ($acumulado_para_portes_especiales>0 && $acumulado_para_portes_especiales<300)
            $portes_especiales=35;

        $this->data['portes_especiales'] = $portes_especiales;
        //~ print '<pre><xmp>';
		//~ print_r($this->data['discounts_eneko']);
		//~ print '</xmp></pre>';
		//~ print '<pre><xmp>';
		//~ print_r($this);
		//~ print '</xmp></pre>';
		//~ exit;
		$this->data['surcharges'] = $this->flexi_cart->surcharge_data();
		###+++++++++++++++++++++++++++++++++###


		// This example shows how to lookup countries, states and post codes that can be used to calculate shipping rates.
		$sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));
		$this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);
		$this->data['states'] = $this->flexi_cart->get_shipping_location_array($sql_select, 1);
		$this->data['postal_codes'] = $this->flexi_cart->get_shipping_location_array($sql_select, 2);
		$this->data['shipping_options'] = $this->flexi_cart->get_shipping_options();

		$this->data['fab'] = $this->flexi_cart_model->get_categories();
		$this->data['col'] = $this->flexi_cart_model->get_col_array();
		$this->data['mod'] = $this->flexi_cart_model->get_mod_array();
		$this->data['gama'] = $this->flexi_cart_model->get_gamas();
		$this->data['estilo'] = $this->flexi_cart_model->get_estilos();
		$this->db->cache_on();
		$this->data['all'] = $this->flexi_cart_model->get_items_filter();
		$this->db->cache_off();
		// Uncomment the lines below to use the manual shipping example. Read more below.
		# $this->load->model('demo_cart_model');
		# $this->data['shipping_options'] = $this->demo_cart_model->demo_manual_shipping_options(); 

		/**
		* By default, this demo is setup to show how to implement shipping rates with a database.
		* In the 2 steps below is an example showing how to manually set and define shipping options and rates.
		*
		* To use this example follow these steps:
		* #1: Replace the four "$this->data" arrays set above with "$this->data['shipping_options'] = $this->demo_cart_model->demo_manual_shipping_options();".
		* #2: Set "$config['database']['shipping_options']['table']" and "$config['database']['shipping_rates']['table']" to FALSE via the config file.
		*/

		###+++++++++++++++++++++++++++++++++###
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('demo/cart_eneko_view', $this->data);
		// $this->load->view('demo/tienda', $this->data);
	}

    function setmural() {
        $itemarray = array('item_tipo' => "1", 'item_unidad' => 'Unidad');
        $this->db->where('estilo_item_estilo', "38")->update('demo_items di JOIN demo_estilo_item de ON di.item_id=de.estilo_item_item ', $itemarray);
    }

    function get_next($fabs = 0, $est = 0, $gamas = 0, $page = -1, $ord = '') {

        //$ord=$this->orden("1");
        if (isset($_POST['ord']) && $_POST['ord'] != "")
            $ord = $this->orden($_POST['ord']);
        //echo $ord;
        if (isset($_POST['categ']) && $_POST['categ'] != "")
            $categ = $_POST['categ'];
        if (isset($_POST['econ']) && $_POST['econ'] != "")
            $econ = $_POST['econ'];
        if (isset($_POST['top']) && $_POST['top'] != "")
            $losmas = $_POST['top'];
        if ($fabs == 0 && isset($_POST['fab']) && $_POST['fab'] != "") {
            $fabs = explode(',', $_POST['fab']);
        }
        if ($est == 0 && isset($_POST['est']) && $_POST['est'] != "") {
            $est = explode(',', $_POST['est']);
        }
        if ($gamas == 0 && isset($_POST['col']) && $_POST['col'] != "") {
            $gamas = explode(',', $_POST['col']);
            if (count($gamas) == 0)
                $gamas = 0;
        }
        $this->data['fab'] = $this->flexi_cart_model->get_categories();
        if (isset($_POST['search']) && trim($_POST['search']) != "") {
            $search = $_POST['search'];
            $this->data['all'] = $this->flexi_cart_model->search_items($search, $page);
        } else {
            $this->data['all'] = $this->flexi_cart_model->get_items_filter($fabs, $est, $gamas, $page, $categ, $econ, $losmas, $ord);
        }
        $this->data['categ'] = $categ;
        $this->load->view('frontend/prefichas', $this->data);
    }

    function get_items($fabs = 0, $est = 0, $gamas = 0, $page = -1) {
        $ord = 'orden';
        $categ = 0;
        $econ = 0;
        if (isset($_POST['ord']) && $_POST['ord'] != "")
            $ord = $_POST['ord'];
        if (isset($_POST['categ']) && $_POST['categ'] != "")
            $categ = $_POST['categ'];
        if (isset($_POST['econ']) && $_POST['econ'] != "")
            $econ = $_POST['econ'];
        if ($fabs == 0 && isset($_POST['fab']) && $_POST['fab'] != "") {
            $fabs = explode(',', $_POST['fab']);
        }
        if ($est == 0 && isset($_POST['est']) && $_POST['est'] != "") {
            $est = explode(',', $_POST['est']);
        }
        if ($gamas == 0 && isset($_POST['col']) && $_POST['col'] != "") {
            $gamas = explode(',', $_POST['col']);
            if (count($gamas) == 0)
                $gamas = 0;
        }
        $this->data['fab'] = $this->flexi_cart_model->get_categories();
        if (isset($_POST['search']) && trim($_POST['search']) != "") {
            $search = $_POST['search'];
            $this->data['all'] = $this->flexi_cart_model->search_items($search, $page);
        } else {
            $this->data['all'] = $this->flexi_cart_model->get_items_filter($fabs, $est, $gamas, $page, $categ, $econ, $ord);
        }
        $this->load->view('frontend/listaarticulos', $this->data);
    }

    function get_next_fab($fabs = 0, $cat = 0) {
        $ord = 'item_cat_fk';
        if (isset($_POST['ord']) && $_POST['ord'] != "")
            $ord = $_POST['ord'];
        if (isset($_POST['categ']) && $_POST['categ'] != "")
            $categ = $_POST['categ'];
        if ($fabs == 0 && isset($_POST['fab']) && $_POST['fab'] != "") {
            $fabs = explode(',', $_POST['fab']);
        }
        $this->data['fab'] = $this->flexi_cart_model->get_fab($this->uri->segment(3));
        $this->data['col'] = $this->flexi_cart_model->get_col($this->uri->segment(3), $this->uri->segment(5));
//      $this->data['fab']=$this->flexi_cart_model->get_fab($_POST['fab']);
//      $this->data['col']=$this->flexi_cart_model->get_col($_POST['fab'],$categ);
        $this->load->view('demo/next_fab', $this->data);
    }

    function get_next_cole($cole) {
        if (isset($_POST['col']) && $_POST['col'] != "")
            $cole = $_POST['col'];
        $this->data['all'] = $this->flexi_cart_model->get_items_cole($cole);
        $this->load->view('demo/next_cole', $this->data);
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // CART CONTROLS
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * update_cart
     * Gets the carts item and shipping data from form inputs, and updates the cart.
     * The view cart page uses AJAX to seamlessly update values in the cart without reloading the page.
     * This function is accessed from the 'View Cart' page via a form input field named 'update'.
     */
    function update_cart() {
        // Load custom demo function to retrieve data from the submitted POST data and update the cart.
        $this->load->model('demo_cart_model');
        $this->demo_cart_model->demo_update_cart();

        // If the cart update was posted by an ajax request, do not perform a redirect.
        if (!$this->input->is_ajax_request()) {
            // Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());
        }
    }

    /**
     * delete_item
     * Deletes and item from the cart using the '$row_id' supplied via the url link.
     * This function is accessed from the 'View Cart' page via an items 'Remove' link.
     */
    function delete_item($row_id = FALSE) {
        // The 'delete_items()' function can accept an array of row_ids to delete more than one row at a time.
        // However, this example only uses the 1 row_id that was supplied via the url link.
        $this->flexi_cart->delete_items($row_id);
        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/view_cart');
    }

    /**
     * clear_cart
     * Clears (Empties) all item, discount and surcharge data from the cart.
     * This function is accessed from the 'View Cart' page via a form input field named 'clear'.
     */
    function clear_cart() {
        // The 'empty_cart()' function allows an argument to be submitted that will also reset all shipping data if 'TRUE'.
        $this->flexi_cart->empty_cart(TRUE);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/view_cart');
    }

    /**
     * destroy_cart
     * Destroys all cart items and settings and resets cart to its default settings.
     * This function is accessed from the 'View Cart' page via a form input field named 'destroy'.
     */
    function destroy_cart() {
        $this->flexi_cart->destroy_cart();

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/view_cart');
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // INSERT ITEMS TO CART
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * insert_link_item_to_cart
     * Inserts an item to the cart from the 'Add items to cart via a link' page.
     * The settings for each item are defined via the custom demo function 'demo_insert_link_item_to_cart()'.
     */
    function insert_link_item_to_cart($item_id = 0) {
        $this->load->model('demo_cart_model');

        $this->demo_cart_model->demo_insert_link_item_to_cart($item_id);

        redirect('tienda/view_cart');
    }

    /**
     * insert_form_item_to_cart
     * Inserts an item to the cart from the 'Add items to cart via a form' page.
     * The settings for each item are defined via the custom demo function 'demo_insert_form_item_to_cart()'.
     */
    function insert_form_item_to_cart($item_id = 0) {
        $this->load->model('demo_cart_model');

        $this->demo_cart_model->demo_insert_form_item_to_cart($item_id);

        redirect('tienda/view_cart');
    }

    /**
     * insert_ajax_link_item_to_cart
     * Inserts an item to the cart via a link from the 'Add Item to Cart via Ajax' page.
     * The settings for each item are defined via the custom demo function 'demo_insert_ajax_link_item_to_cart()'.
     */
    function insert_ajax_link_item_to_cart($item_id = 0) {
        $this->load->model('demo_cart_model');

        $this->demo_cart_model->demo_insert_ajax_link_item_to_cart($item_id);

        redirect('tienda');
    }

    /**
     * insert_ajax_form_item_to_cart
     * Inserts an item to the cart via a form from the 'Add Item to Cart via Ajax' page.
     * The settings for each item are defined via the custom demo function 'demo_insert_ajax_form_item_to_cart()'.
     */
    function insert_ajax_form_item_to_cart() {
        $this->load->model('demo_cart_model');

        $this->demo_cart_model->demo_insert_ajax_form_item_to_cart();

        redirect('tienda');
    }

    /**
     * insert_discount_item_to_cart
     * Inserts an item to the cart from the 'Add discount items to cart' page.
     * The settings for each item are defined via the custom demo function 'demo_insert_discount_item_to_cart()'.
     */
    private function insert_discount_item_to_cart($item_id = 0) {
        $this->load->model('demo_cart_model');

        $this->demo_cart_model->demo_insert_discount_item_to_cart($item_id);

        redirect('tienda/view_cart');
    }

    /**
     * insert_database_item_to_cart
     * Inserts an item to the cart from the 'Add database items to cart' page.
     * The settings for each item are defined via the custom demo function 'demo_insert_database_item_to_cart()'.
     */
    function insert_database_item_to_cart($item_id = 0) {
        $this->load->model('demo_cart_model');

        $this->demo_cart_model->demo_insert_database_item_to_cart($item_id);
		if(!$this->input->is_ajax_request()){
            redirect('tienda');
		}
       
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // DISCOUNTS
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * update_discount_codes
     * Updates all discount codes that have been submitted to the cart.
     * This function is accessed from the 'View Cart' page via a form input field named 'update_discount'.
     */
    function update_discount_codes() {
        // Get the discount codes from the submitted POST data.
        $discount_data = $this->input->post('discount');
	//~ if ($discount_data[0]=='ENEKO'){
		//~ echo "<br />controller tienda";
		//~ exit;
	//~ }

        // The 'update_discount_codes()' function will validate each submitted code and apply the discounts that have activated their quantity and value requirements.
        // Any previously set codes that have now been set as blank (i.e. no longer present) will be removed.
        // Note: Only 1 discount can be applied per item and per summary column. 
        // For example, 2 discounts cannot be applied to the summary total, but 1 discount could be applied to the shipping total, and another to the summary total.
 	//~ if ((isset($discount_data[0])) && $discount_data[0]=='ENEKO'){
		//~ echo "<br />controller tienda";
		//~ print '<pre><xmp>';
		//~ print_r($discount_data);
		//~ print '</xmp></pre>';
		//~ exit;
	//~ }
        /*
        print '<pre><xmp>';
        print_r($discount_data);
        print '</xmp></pre>';
        exit;
        */
        $this->flexi_cart->update_discount_codes($discount_data);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());
		
        redirect('tienda/view_cart');
    }

    function test_codes() {
        $discount_data = $this->input->post('discount');
        $this->flexi_cart->update_discount_codes($discount_data);
    }

    /**
     * set_discount
     * Set a manually defined discount to the cart, rather than using the discount database table.
     * This function is accessed from the 'Discounts / Surcharges' page.
     * The settings for each discount are defined via the custom demo function 'demo_set_discount()'.
     */
    function set_discount($discount_id = FALSE) {
        $this->load->model('demo_cart_model');

        $this->demo_cart_model->demo_set_discount($discount_id);
		
        redirect('tienda/view_cart');
    }

    /**
     * remove_discount_code
     * Removes a specific discount code from the cart.
     * This function is accessed from the 'View Cart' page via a form input field named 'remove_discount_code'.
     */
    function remove_discount_code() {
        // This examples gets the discount code from the array key of the submitted POST data.
        $discount_code = key($this->input->post('remove_discount_code'));

        // The 'unset_discount()' function can accept an array of either discount ids or codes to delete more than one discount at a time.
        // Alternatively, if no data is submitted, the function will delete all discounts that are applied to the cart.
        // This example uses the 1 discount code that was supplied via the POST data.
        $this->flexi_cart->unset_discount($discount_code);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/view_cart');
    }

    /**
     * remove_all_discounts
     * Removes all discounts from the cart, including discount codes, manually applied discounts and reward vouchers.
     * This function is accessed from the 'View Cart' page via a form input field named 'remove_all_discounts'.
     */
    function remove_all_discounts() {
        // The 'unset_discount()' function can accept an array of either discount ids or codes to delete more than one discount at a time.
        // Alternatively, if no data is submitted, the function will delete all discounts that are applied to the cart.
        // This example removes all discount data.
        $this->flexi_cart->unset_discount();

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/view_cart');
    }

    /**
     * unset_discount
     * Removes a specific active item or summary discount from the cart.
     * This function is accessed from the 'View Cart' page via a 'Remove' link located in the description of an active discount.
     */
    function unset_discount($discount_id = FALSE) {
        // The 'unset_discount()' function can accept an array of either discount ids or codes to delete more than one discount at a time.
        // Alternatively, if no data is submitted, the function will delete all discounts that are applied to the cart.
        // This example uses the 1 discount id that was supplied via the url link.
        $this->flexi_cart->unset_discount($discount_id);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/view_cart');
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // SURCHARGES
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * set_surcharge
     * Set a manually defined surcharge to the cart.
     * This function is accessed from the 'Discounts / Surcharges' page.
     * The settings for each surcharge are defined via the custom demo function 'demo_set_surcharge()'.
     */
    private function set_surcharge($surcharge_id = FALSE) {
        $this->load->model('demo_cart_model');

        $this->demo_cart_model->demo_set_surcharge($surcharge_id);

        redirect('tienda/view_cart');
    }

    /**
     * unset_surcharge
     * Removes a specific surcharge from the cart.
     * This function is accessed from the 'View Cart' page via a 'Remove' link located in the description of a surcharge.
     */
    private function unset_surcharge($surcharge_id = FALSE) {
        // The 'unset_surcharge()' function can accept an array of surcharge ids to delete more than one surcharge at a time.
        // Alternatively, if no data is submitted, the function will delete all surcharges that are applied to the cart.
        // This example uses the 1 surcharge id that was supplied via the url link.
        $this->flexi_cart->unset_surcharge($surcharge_id);

        redirect('tienda/view_cart');
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // CART CHECKOUT
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * checkout
     * The example 'Checkout' page collects the users billing, shipping and contact details, before the user confirms their order.
     * Note: As this is only a demo, the checkout page does not connect to a online payment gateway to process the order transaction.
     * Therefore, when the user data is submitted, it transfers directly to the 'Checkout Complete' page.
     */
    function checkout_viejo() { // previo al registro de usuario
    //function checkout() { // previo al registro de usuario
        /*
        */
        $this->load->model('demo_cart_model');

        // Check whether the cart is empty using the 'cart_status()' function and redirect the user away if necessary.
        if (!$this->flexi_cart->cart_status()) {
            $this->flexi_cart->set_error_message('You must add an item to the cart before you can checkout.', 'public');

            // Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

            redirect('tienda/view_cart');
        }
        /*
        // Update cart contents and settings.
        if ($this->input->post('update')) {

            $this->update_cart();
            redirect('tienda/checkout');
        }
        */
        /*
        */
        // Check whether the user has submitted their details and that the information is valid.
        // The custom demo function 'demo_save_order()' validates the data using CI's validation library and then saves the cart to the database using the 'save_order()' function.
        // If the data is saved successfully, the user is redirected to the 'Checkout Complete' page.
        if ($this->input->post('checkout')) {
            $response = $this->demo_cart_model->demo_save_order();

            // Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

            // Check that the order saved correctly.
            if ($response) {
                $sql_where = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $this->flexi_cart->order_number());
                if ($order_data = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_demo_email', $sql_where)) {
                    $body = array(
                        "nombre" => ($this->data['usuario']->ord_demo_ship_name != "") ? $this->data['usuario']->ord_demo_ship_name : $this->data['usuario']->ord_demo_bill_name,
                        "msg" => "A continuación le detallamos su pedido número " . $this->flexi_cart->order_number() . ".",
                        "pedido" => $this->getPedido($this->flexi_cart->order_number()) . 'Puede realizar el pago de este pedido pinchando en el siguiente enlace:<br> <a href="' . base_url() . 'tienda/checkout_compra_ya/' . $this->flexi_cart->order_number() . '">' . base_url() . 'tienda/checkout_compra_ya/' . $this->flexi_cart->order_number() . '</a>'
                    );
                    $this->send_email($order_data['ord_demo_email'], "Nuevo Pedido (" . $this->flexi_cart->order_number() . ") Realizado", $body);
                }
                $this->flexi_cart_admin->update_db_order_summary(array('ord_status' => 1), $this->flexi_cart->order_number());

                // Enviar pedido a Sociedad de Opiniones Contrastadas para solicitar resena
                $this->load->helper('resenas');
                $order_number = $this->flexi_cart->order_number();
                $nombre_completo = isset($order_data['ord_demo_bill_name']) ? $order_data['ord_demo_bill_name'] : '';
                if (empty($nombre_completo) && isset($this->data['usuario']->ord_demo_bill_name))
                    $nombre_completo = $this->data['usuario']->ord_demo_bill_name;
                $partes_nombre = explode(' ', trim($nombre_completo), 2);
                $firstname = $partes_nombre[0];
                $lastname = isset($partes_nombre[1]) ? $partes_nombre[1] : '';
                $email_cliente = $order_data['ord_demo_email'];

                $items_pedido = $this->db->select('ord_det_item_fk, ord_det_item_name, ord_det_quantity, ord_det_price, i.item_ref, c.cat_name, col.coleccion_name')
                    ->from('order_details')
                    ->join('demo_items i', 'i.item_id = ord_det_item_fk', 'left')
                    ->join('demo_categories c', 'i.item_cat_fk = c.cat_id', 'left')
                    ->join('demo_coleccion col', 'i.item_coleccion_id = col.coleccion_id', 'left')
                    ->where('ord_det_order_number_fk', $order_number)
                    ->get()->result_array();

                $productos_resena = array();
                foreach ($items_pedido as $item) {
                    $productos_resena[] = array(
                        'id' => $item['ord_det_item_fk'],
                        'name' => $item['ord_det_item_name'],
                        'qty' => $item['ord_det_quantity'],
                        'unit_price' => $item['ord_det_price'],
                        'sku' => isset($item['item_ref']) ? $item['item_ref'] : '',
                        'url' => base_url().'tienda/articulo/'.strtolower(str_replace(' ','-',$item['cat_name'])).'/'.strtolower(str_replace(' ','-',$item['coleccion_name'])).'/id/'.$item['ord_det_item_fk'],
                    );
                }
                enviar_pedido_resenas($order_number, date('Y-m-d H:i:s'), $email_cliente, $firstname, $lastname, $productos_resena);

                // Attach the saved order number to the redirect url.
                redirect('tienda/checkout_compra_ya/' . $this->flexi_cart->order_number());
            }
        }


        // Get all countries to list via a select menu as countries the user can be 'Billed to'.
        // In this example, the 'Shipped to' country is fixed by the shipping location and option they selected via the 'View Cart' page.
        $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));
        $this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);
        $this->data['states'] = $this->flexi_cart->get_shipping_location_array($sql_select, 1);
        $this->data['postal_codes'] = $this->flexi_cart->get_shipping_location_array($sql_select, 2);
        $this->data['shipping_options'] = $this->flexi_cart->get_shipping_options();

        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

    
        $this->data['a_migas']['/tienda/carrito']='Carrito';
        $this->data['a_migas']['/tienda/checkout']='Datos de envío';
        /*
        if ($usuario->user_id <=1){
            $this->data['a_migas']['/tienda/checkout']='Datos de contacto';
        }
        else{
            $this->data['a_migas']['/tienda/checkout']='Datos de envío';
        }
        */
        //$this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            
        $this->data['includes_footer'][]='<script src="/includes/js/carrito.js"></script>';            
        $this->data['includes_footer'][]='<script src="https://www.paypal.com/sdk/js?client-id=AbM4hpWmFs3LQpp6_C-JtlgwSrZp_RLwZv_2TUhQKdvWwRkBwc5Ip0ZPl62LDxiHC3Hf_8wzzby_2EES&currency=EUR&components=messages" data-namespace="PayPalSDK"></script>';         

        if (!$this->input->is_ajax_request()) {
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/migas_nuevas_small', $this->data);
        }

        if (isset($_GET['test']) && $_GET['test']=='eneko'){
            $this->load->view('demo/pre_checkout_view', $this->data);
        }
        elseif (isset($_GET['test']) && $_GET['test']=='original'){
            $this->load->view('demo/checkout_view_original', $this->data);
        }
        else{
            $this->load->view('demo/checkout_view', $this->data);
        }
        
        if (!$this->input->is_ajax_request()) {
            $this->load->view('frontend/footer', $this->data);
            // $this->load->view('demo/tienda', $this->data);
        }

    }

    //function checkout_eneko() {
    function checkout() {
        $this->load->model('demo_cart_model');

        // Check whether the cart is empty using the 'cart_status()' function and redirect the user away if necessary.
        if (!$this->flexi_cart->cart_status()) {
            $this->flexi_cart->set_error_message('You must add an item to the cart before you can checkout.', 'public');

            // Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

            redirect('tienda/view_cart');
        }

        /*
        // Update cart contents and settings.
        if ($this->input->post('update')) {

            $this->update_cart();
            redirect('tienda/checkout');
        }
        */
        /*
        */
        // Check whether the user has submitted their details and that the information is valid.
        // The custom demo function 'demo_save_order()' validates the data using CI's validation library and then saves the cart to the database using the 'save_order()' function.
        // If the data is saved successfully, the user is redirected to the 'Checkout Complete' page.
        if ($this->input->post('checkout')) {
                /*
                echo '<pre>';
                print_r($_POST);
                echo '</pre>';
                echo '<pre>';
                print_r($this->data['usuario']);
                echo '</pre>';
                exit;
                */
            
            $response = $this->demo_cart_model->demo_save_order();

            // Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

            // Check that the order saved correctly.
            if ($response) {
                // Si el pedido se ha guardado correctamente y es un usuario registrado nuevo (el nombre lo tiene en blanco) guardamos los datos de registro
                if($this->data['usuario']->user_id>1 && trim($this->data['usuario']->ord_demo_ship_name)==''){
                    $datos = array(
                        'ord_demo_bill_name' => $_POST['checkout']['billing']['name'],
                        'ord_demo_bill_company' => $_POST['checkout']['billing']['company'],
                        'ord_demo_bill_address_01' => $_POST['checkout']['billing']['add_01'],
                        'ord_demo_bill_address_02' => $_POST['checkout']['billing']['add_02'],
                        'ord_demo_bill_city' => $_POST['checkout']['billing']['city'],
                        'ord_demo_bill_state' => $_POST['checkout']['billing']['state'],
                        'ord_demo_bill_post_code' => $_POST['checkout']['billing']['post_code'],
                        'ord_demo_bill_country' => $_POST['checkout']['billing']['country'],

                        'ord_demo_ship_name' => $_POST['checkout']['shipping']['name'],
                        'ord_demo_ship_address_01' => $_POST['checkout']['shipping']['add_01'],
                        'ord_demo_ship_address_02' => $_POST['checkout']['shipping']['add_02'],
                        'ord_demo_ship_city' => $_POST['checkout']['shipping']['city'],
                        'ord_demo_ship_state' => $_POST['checkout']['shipping']['state'],
                        'ord_demo_ship_post_code' => $_POST['checkout']['shipping']['post_code'],
                        'ord_demo_ship_country' => $_POST['checkout']['shipping']['country'],
                        'phone' => $_POST['checkout']['phone']
                    );
                    $this->db->where('user_id', $this->data['usuario']->user_id)->update('users', $datos);
                }

                $sql_where = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $this->flexi_cart->order_number());
                if ($order_data = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_demo_email', $sql_where)) {
                    $body = array(
                        "nombre" => ($this->data['usuario']->ord_demo_ship_name != "") ? $this->data['usuario']->ord_demo_ship_name : $this->data['usuario']->ord_demo_bill_name,
                        "msg" => "A continuación le detallamos su pedido número " . $this->flexi_cart->order_number() . ".",
                        "pedido" => $this->getPedido($this->flexi_cart->order_number()) . 'Puede realizar el pago de este pedido pinchando en el siguiente enlace:<br> <a href="' . base_url() . 'tienda/checkout_compra_ya/' . $this->flexi_cart->order_number() . '">' . base_url() . 'tienda/checkout_compra_ya/' . $this->flexi_cart->order_number() . '</a>'
                    );
                    $this->send_email($order_data['ord_demo_email'], "Nuevo Pedido (" . $this->flexi_cart->order_number() . ") Realizado", $body);
                    /*
                    // 2025-09-03 probando mail al realizar el pedido (mamua)
                    $this->load->library('email');
                    $config['wordwrap'] = FALSE;
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);
                    $this->email->from('info@depapelpintado.es', 'dePapelPintado');
                    $this->email->to("enanclares77@gmail.com");
                    $this->email->subject("Nuevo Pedido (" . $this->flexi_cart->order_number() . ") Realizado.");
                    $this->email->message($this->load->view('frontend/cuentas/plantillamail', $body, TRUE));
                    $this->email->send();
                    // 2025-09-03 probando mail al realizar el pedido
                    */

                }
                $this->flexi_cart_admin->update_db_order_summary(array('ord_status' => 1), $this->flexi_cart->order_number());
                // Attach the saved order number to the redirect url.
                redirect('tienda/checkout_compra_ya/' . $this->flexi_cart->order_number());
            }
            else{
                if ($this->input->post('guardar_datos_nuevo_usuario')){
                    $this->nuevo_desde_pedido=true;
                }
                
                $this->continuar_form_checkout=true;
            }
        }

        // Get all countries to list via a select menu as countries the user can be 'Billed to'.
        // In this example, the 'Shipped to' country is fixed by the shipping location and option they selected via the 'View Cart' page.
        $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));
        $this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);
        $this->data['states'] = $this->flexi_cart->get_shipping_location_array($sql_select, 1);
        $this->data['postal_codes'] = $this->flexi_cart->get_shipping_location_array($sql_select, 2);
        $this->data['shipping_options'] = $this->flexi_cart->get_shipping_options();

        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

    
        $this->data['a_migas']['/tienda/carrito']='Carrito';
        $this->data['a_migas']['/tienda/checkout']='Datos de envío';


        if (!$this->input->is_ajax_request()) {
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/migas_nuevas_small', $this->data);
        }
        $this->data['includes_footer'][]='<script src="/includes/js/carrito_nuevo.js"></script>';            
        $this->data['includes_footer'][]='<script src="https://www.paypal.com/sdk/js?client-id=AbM4hpWmFs3LQpp6_C-JtlgwSrZp_RLwZv_2TUhQKdvWwRkBwc5Ip0ZPl62LDxiHC3Hf_8wzzby_2EES&currency=EUR&components=messages" data-namespace="PayPalSDK"></script>';         

        if ($this->data['usuario']->user_id >1 || $this->continuar_form_checkout){
            if ($this->input->post('email')) 
                $this->data['usuario']->email=$this->input->post('email');
            if (isset($_POST['checkout']['email'])) 
                $this->data['usuario']->email=$_POST['checkout']['email'];
            if ($this->input->post('phone')) 
                $this->data['usuario']->phone=$this->input->post('phone');
            if (isset($_POST['checkout']['phone'])) 
                $this->data['usuario']->phone=$_POST['checkout']['phone'];

            $this->data['guardar_datos_nuevo_usuario']=false;
            if ($this->nuevo_desde_pedido){
                $this->data['guardar_datos_nuevo_usuario']=true;
            }
            /*
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';
            echo '<pre>';
            print_r($this->data['usuario']);
            echo '</pre>';
            
            //exit;
            */
            $this->load->view('demo/checkout_nuevo_view', $this->data);
        }
        else{
            $registro_checkout_recaptcha_v3=new stdClass;
            $registro_checkout_recaptcha_v3->aktibaturik=true;
            $registro_checkout_recaptcha_v3->action='';
            $registro_checkout_recaptcha_v3->form_id='#checkout-registro-form';

            $this->data['registro_checkout_recaptcha_v3']=$registro_checkout_recaptcha_v3;
            if ($this->input->post('email')) 
                $this->data['usuario']->email=$this->input->post('email');
            if ($this->input->post('phone')) 
                $this->data['usuario']->phone=$this->input->post('phone');
            
            $this->data['pass_1']='';
            if ($this->input->post('pass')) 
                $this->data['pass_1']=$this->input->post('pass');
            $this->data['pass_2']='';
            if ($this->input->post('pass2')) 
                $this->data['pass_2']=$this->input->post('pass2');
           
            $this->load->view('demo/pre_checkout_view', $this->data);
        }
        
        if (!$this->input->is_ajax_request()) {
            $this->load->view('frontend/footer', $this->data);
            // $this->load->view('demo/tienda', $this->data);
        }

    }

    function checkout_actualizar_resumen() {

        $this->load->model('demo_cart_model');

        // Check whether the cart is empty using the 'cart_status()' function and redirect the user away if necessary.
        if (!$this->flexi_cart->cart_status()) {
            $this->flexi_cart->set_error_message('You must add an item to the cart before you can checkout.', 'public');

            // Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

            redirect('tienda/view_cart');
        }

        // Update cart contents and settings.
        if ($this->input->post('update')) {

            $this->update_cart();

            // Get all countries to list via a select menu as countries the user can be 'Billed to'.
            // In this example, the 'Shipped to' country is fixed by the shipping location and option they selected via the 'View Cart' page.
            $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));
            $this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);
            $this->data['states'] = $this->flexi_cart->get_shipping_location_array($sql_select, 1);
            $this->data['postal_codes'] = $this->flexi_cart->get_shipping_location_array($sql_select, 2);
            $this->data['shipping_options'] = $this->flexi_cart->get_shipping_options();

            $this->data['discounts'] = $this->flexi_cart->summary_discount_data();

            // Get any status message that may have been set.
            $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        
            $this->data['a_migas']['/tienda/carrito']='Carrito';
            $this->data['a_migas']['/tienda/checkout']='Datos de envío';

            //$this->data['includes_header'][]='<link rel="stylesheet" href="/includes/content-collapse.css">';            
            //$this->data['includes_footer'][]='<script src="/includes/js/carrito.js"></script>';            
            $this->data['includes_footer'][]='<script src="/includes/js/carrito_nuevo.js"></script>';            

            if (!$this->input->is_ajax_request()) {
                $this->load->view('frontend/header', $this->data);
                $this->load->view('frontend/migas_nuevas_small', $this->data);
                $this->load->view('demo/checkout_view', $this->data);
                $this->load->view('frontend/footer', $this->data);
            }
            else {
                $this->data['formulario_checkout']=true;
                $this->load->view('demo/cart_view_resumen', $this->data);
            }
        }

    }

    /**
     * checkout_complete
     * The example 'Checkout Complete' page displays a confirmation of the users order, displaying their order number.
     * On a real world site, this page is typically accessed after the user has entered their payment details via a online payment gateway.
     */
    private function send_email($email, $subject, $body) {

        $this->load->library('email');
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@depapelpintado.es', 'dePapelPintado');
        $this->email->to($email);

        $this->email->bcc('pagos@depapelpintado.es');

        $this->email->subject($subject);

        // Logo incrustado (cid) para que se vea aunque Cloudflare bloquee al proxy de imagenes del cliente de correo
        $logo_path = FCPATH.'images/logo-depapelpintado-nuevo2.png';
        if (is_array($body) && $this->email->attach($logo_path, 'inline') !== FALSE) {
            $body['logo_cid'] = $this->email->attachment_cid($logo_path);
        }

        $this->email->message($this->load->view('frontend/cuentas/plantillamail', $body, TRUE));

        $this->email->send();
    }

    private function send_info_email($email, $subject, $body) {

        $this->load->library('email');
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@depapelpintado.es', 'dePapelPintado');
        $this->email->to($email);

//$this->email->bcc('pagos@depapelpintado.es');

        $this->email->subject($subject);
        $this->email->message($body);

        $this->email->send();
    }

    private function send_info_email_copia_oculta($email, $subject, $body) {

        $this->load->library('email');
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@depapelpintado.es', 'dePapelPintado');
        $this->email->to($email);

        $this->email->bcc('info@depapelpintado.es');

        $this->email->subject($subject);
        $this->email->message($body);

        $result=$this->email->send(FALSE);
    }

    // Envia un email de plantilla (registro) con el logo incrustado (cid), inmune al bloqueo de Cloudflare al proxy de imagenes
    private function send_registro_email($email, $subject, $template, $bcc_self = FALSE) {
        $this->load->library('email');
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@depapelpintado.es', 'dePapelPintado');
        $this->email->to($email);
        if ($bcc_self) $this->email->bcc('info@depapelpintado.es');
        $this->email->subject($subject);

        $data = array();
        $logo_path = FCPATH.'images/logo-depapelpintado-nuevo2.png';
        if ($this->email->attach($logo_path, 'inline') !== FALSE) {
            $data['logo_cid'] = $this->email->attachment_cid($logo_path);
        }
        $this->email->message($this->load->view('frontend/cuentas/'.$template, $data, TRUE));

        return $this->email->send();
    }

    function checkout_compra_ya($order_number = FALSE, $pasarela = FALSE, $prueba=FALSE) {
        // Note: This example uses the 'get_db_order_summary_row_array()' and 'update_db_order_summary()' function which are located in the flexi cart ADMIN library.
        $this->load->library('flexi_cart_admin');

        $this->data['script_checkout'] = false;
        if(isset($_GET['temp']) && $_GET['temp']=='eneko'){
            $this->data['script_checkout'] = true;
            
            $this->getDatosPedidoParaScript($order_number);
            /*
            echo '<pre>';
            print_r($this->data);
            echo '</pre>';
            exit;
            */
       }
        $this->data['script_checkout'] = true;
            
        $this->getDatosPedidoParaScript($order_number);

        $this->load->model('contenido_model');
        $this->data['pago'] = $this->contenido_model->get_paypal();
        // Get the confrimed order number to display to the user.
        $this->data['order_number'] = $order_number;

        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();

        // Get the users email address that was just saved with the order data.
        $sql_where = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $this->data['order_number']);
        if ($order_data = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_demo_email', $sql_where)) {
            $order_data2 = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_total', $sql_where);
            $order_data3 = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_status', $sql_where);
            $this->data['user_email'] = $order_data['ord_demo_email'];
            $this->data['total'] = $order_data2['ord_total'];
            $this->data['status'] = $order_data3['ord_status'];
            $this->data['resumen_pedido'] = $this->flexi_cart_admin->get_db_order_summary_row_array('*', $sql_where);
			$this->data['urlnext'] = base_url() . "tienda/checkout_confirm/" . $order_number;
			if($prueba){
				$this->data['urlnext'] = base_url() . "tienda/checkout_confirm/" . $order_number."/false/true";
			}
            
            $this->data['urlthis'] = base_url() . "tienda/checkout_compra_ya/" . $order_number;
            // In many real world cases, the cart data may need to be later updated once saved - for example to save the response from an online payment gateway.
            // With such an example, the 'update_order_summary()' admin library function can be used.			
            // A real world site would typically now send the user an order acknowledgement email.
            # $this->flexi_cart_admin->email_order($this->data['order_number'], array('example@company_name.com', $this->data['user_email']), 'Email Subject Title');
        }

        // Destroy the cart.
        // Note: once checkout is complete, it is better to use the 'destroy_cart()' function rather than 'empty_cart()' to ensure all session data from the
        // now completed order is removed, rather than just removing the items in the cart.
        //if($pasarela=="pruebas_laboral")$this->data['pruebas_laboral']="lab";
        if ($pasarela == "paypal") {

            if (session_status() == PHP_SESSION_NONE) { session_start(); } //PHP >= 5.4.0
            /*if (session_id() == '') {
                session_start();
            } //uncomment this line if PHP < 5.4.0 and comment out line above*/

            $PayPalMode = ($this->data['pago']->test == "0") ? 'live' : 'sandbox'; // sandbox or live
            $PayPalApiUsername = $this->data['pago']->user; //PayPal API Username
            $PayPalApiPassword = $this->data['pago']->pass; //Paypal API password
            $PayPalApiSignature = $this->data['pago']->token;  //Paypal API Signature
            $PayPalCurrencyCode = 'EUR'; //Paypal Currency Code
            $PayPalReturnURL = base_url() . 'tienda/checkout_confirm/' . $order_number . '/paypal'; //Point to process.php page
            $PayPalCancelURL = base_url() . 'tienda/checkout_confirm/' . $order_number . '/paypal';

            //Mainly we need 4 variables from product page Item Name, Item Price, Item Number and Item Quantity.
            //Please Note : People can manipulate hidden field amounts in form,
            //In practical world you must fetch actual price from database using item id. Eg: 
            //$ItemPrice = $mysqli->query("SELECT item_price FROM products WHERE id = Product_Number");

            $ItemName = "Pedido " . $order_number; //Item Name
            $ItemPrice = $this->data['total']; //Item Price
            $ItemNumber = ""; //$_POST["itemnumber"]; //Item Number
            $ItemDesc = ""; //$_POST["itemdesc"]; //Item Number
            $ItemQty = 1; //$_POST["itemQty"]; // Item Quantity
            $ItemTotalPrice = ($ItemPrice * $ItemQty); //(Item Price x Quantity = Total) Get total amount of product; 
            //Other important variables like tax, shipping cost
            $TotalTaxAmount = 2.58;  //Sum of tax for all items in this order. 
            $HandalingCost = 2.00;  //Handling cost for this order.
            $InsuranceCost = 1.00;  //shipping insurance cost for this order.
            $ShippinDiscount = -3.00; //Shipping discount for this order. Specify this as negative number.
            $ShippinCost = 3.00; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
            //Grand total including all tax, insurance, shipping cost and discount
            $GrandTotal = ($ItemTotalPrice /* + $TotalTaxAmount + $HandalingCost + $InsuranceCost + $ShippinCost + $ShippinDiscount */);

            //Parameters for SetExpressCheckout, which will be sent to PayPal
            $padata = '&METHOD=SetExpressCheckout' .
                    '&RETURNURL=' . urlencode($PayPalReturnURL) .
                    '&CANCELURL=' . urlencode($PayPalCancelURL) .
                    '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
                    '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($ItemName) .
                    '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($ItemNumber) .
                    '&L_PAYMENTREQUEST_0_DESC0=' . urlencode($ItemDesc) .
                    '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($ItemPrice) .
                    '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($ItemQty) .
                    '&NOSHIPPING=0' . //set 1 to hide buyer's shipping address, in-case products that does not require shipping

                    '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemTotalPrice) .
                    '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) .
                    '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
                    '&LOCALECODE=ES' . //PayPal pages to match the language on your website.
                    '&LOGOIMG=https://depapelpintado.es/includes/images/img-depapelpintado.png' . //site logo
                    '&CARTBORDERCOLOR=FFFFFF' . //border color of cart
                    '&ALLOWNOTE=1';

            ############# set session variable we need later for "DoExpressCheckoutPayment" #######
            $_SESSION['ItemName'] = $ItemName; //Item Name
            $_SESSION['ItemPrice'] = $ItemPrice; //Item Price
            $_SESSION['ItemNumber'] = $ItemNumber; //Item Number
            $_SESSION['ItemDesc'] = $ItemDesc; //Item Number
            $_SESSION['ItemQty'] = $ItemQty; // Item Quantity
            $_SESSION['ItemTotalPrice'] = $ItemTotalPrice; //(Item Price x Quantity = Total) Get total amount of product; 
            $_SESSION['TotalTaxAmount'] = $TotalTaxAmount;  //Sum of tax for all items in this order. 
            $_SESSION['HandalingCost'] = $HandalingCost;  //Handling cost for this order.
            $_SESSION['InsuranceCost'] = $InsuranceCost;  //shipping insurance cost for this order.
            $_SESSION['ShippinDiscount'] = $ShippinDiscount; //Shipping discount for this order. Specify this as negative number.
            $_SESSION['ShippinCost'] = $ShippinCost; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
            $_SESSION['GrandTotal'] = $GrandTotal;


            //We need to execute the "SetExpressCheckOut" method to obtain paypal token

            $httpParsedResponseAr = $this->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

            //Respond according to message we receive from Paypal
            if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

                //Redirect user to PayPal store with Token received.
                $paypalmode = ($PayPalMode == 'sandbox') ? '.sandbox' : '';
                $paypalurl = 'https://www' . $paypalmode . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $httpParsedResponseAr["TOKEN"] . '';
                header('Location: ' . $paypalurl);
            } else {
                //Show error message
                echo '<div style="color:red"><b>Error : </b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
                echo '<pre>';
                print_r($httpParsedResponseAr);
                echo '</pre>';
            }
        }
		$this->data['prueba']=$prueba;

        $this->data['includes_footer'][]='<script src="/includes/js/carrito.js"></script>';            
        $this->data['includes_footer'][]='<script src="https://www.paypal.com/sdk/js?client-id=AbM4hpWmFs3LQpp6_C-JtlgwSrZp_RLwZv_2TUhQKdvWwRkBwc5Ip0ZPl62LDxiHC3Hf_8wzzby_2EES&currency=EUR&components=messages" data-namespace="PayPalSDK"></script>';         

        $this->load->view('frontend/header', $this->data);
        //$this->load->view('frontend/migas_nuevas_small', $this->data);
        $this->load->view('demo/checkout_compra_ya', $this->data);
        $this->load->view('frontend/footer', $this->data);
    }

    function checkout_compra_ya_test($order_number = FALSE, $pasarela = FALSE, $prueba=FALSE) {
        // Note: This example uses the 'get_db_order_summary_row_array()' and 'update_db_order_summary()' function which are located in the flexi cart ADMIN library.
        $this->load->library('flexi_cart_admin');

        $this->data['script_checkout'] = false;
        if(isset($_GET['temp']) && $_GET['temp']=='eneko'){
            $this->data['script_checkout'] = true;
            
            $this->getDatosPedidoParaScript($order_number);
            /*
            echo '<pre>';
            print_r($this->data);
            echo '</pre>';
            exit;
            */
       }
        $this->data['script_checkout'] = true;
            
        $this->getDatosPedidoParaScript($order_number);

        $this->load->model('contenido_model');
        $this->data['pago'] = $this->contenido_model->get_paypal();
        // Get the confrimed order number to display to the user.
        $this->data['order_number'] = $order_number;

        // Get the users email address that was just saved with the order data.
        $sql_where = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $this->data['order_number']);
        if ($order_data = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_demo_email', $sql_where)) {

            $order_data2 = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_total', $sql_where);
            $order_data3 = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_status', $sql_where);
            
            $this->data['user_email'] = $order_data['ord_demo_email'];
            $this->data['total'] = $order_data2['ord_total'];
            $this->data['status'] = $order_data3['ord_status'];
            $this->data['resumen_pedido'] = $this->flexi_cart_admin->get_db_order_summary_row_array('*', $sql_where);
            $this->data['urlnext'] = base_url() . "tienda/checkout_confirm/" . $order_number;
            if($prueba){
                $this->data['urlnext'] = base_url() . "tienda/checkout_confirm/" . $order_number."/false/true";
            }
            /*
            echo '<pre>';
            print_r($this->data['resumen_pedido']);
            echo '</pre>';
            exit;
            echo "opcion 1";
            */
            $this->data['urlthis'] = base_url() . "tienda/checkout_compra_ya_test/" . $order_number;
            // In many real world cases, the cart data may need to be later updated once saved - for example to save the response from an online payment gateway.
            // With such an example, the 'update_order_summary()' admin library function can be used.           
            // A real world site would typically now send the user an order acknowledgement email.
            # $this->flexi_cart_admin->email_order($this->data['order_number'], array('example@company_name.com', $this->data['user_email']), 'Email Subject Title');
        }

        // Destroy the cart.
        // Note: once checkout is complete, it is better to use the 'destroy_cart()' function rather than 'empty_cart()' to ensure all session data from the
        // now completed order is removed, rather than just removing the items in the cart.
        //if($pasarela=="pruebas_laboral")$this->data['pruebas_laboral']="lab";
        if ($pasarela == "paypal") {

            if (session_status() == PHP_SESSION_NONE) { session_start(); } //PHP >= 5.4.0
            /*if (session_id() == '') {
                session_start();
            } //uncomment this line if PHP < 5.4.0 and comment out line above*/

            $PayPalMode = ($this->data['pago']->test == "0") ? 'live' : 'sandbox'; // sandbox or live
            $PayPalApiUsername = $this->data['pago']->user; //PayPal API Username
            $PayPalApiPassword = $this->data['pago']->pass; //Paypal API password
            $PayPalApiSignature = $this->data['pago']->token;  //Paypal API Signature
            $PayPalCurrencyCode = 'EUR'; //Paypal Currency Code
            $PayPalReturnURL = base_url() . 'tienda/checkout_confirm/' . $order_number . '/paypal'; //Point to process.php page
            $PayPalCancelURL = base_url() . 'tienda/checkout_confirm/' . $order_number . '/paypal';

            //Mainly we need 4 variables from product page Item Name, Item Price, Item Number and Item Quantity.
            //Please Note : People can manipulate hidden field amounts in form,
            //In practical world you must fetch actual price from database using item id. Eg: 
            //$ItemPrice = $mysqli->query("SELECT item_price FROM products WHERE id = Product_Number");

            $ItemName = "Pedido " . $order_number; //Item Name
            $ItemPrice = $this->data['total']; //Item Price
            $ItemNumber = ""; //$_POST["itemnumber"]; //Item Number
            $ItemDesc = ""; //$_POST["itemdesc"]; //Item Number
            $ItemQty = 1; //$_POST["itemQty"]; // Item Quantity
            $ItemTotalPrice = ($ItemPrice * $ItemQty); //(Item Price x Quantity = Total) Get total amount of product; 
            //Other important variables like tax, shipping cost
            $TotalTaxAmount = 2.58;  //Sum of tax for all items in this order. 
            $HandalingCost = 2.00;  //Handling cost for this order.
            $InsuranceCost = 1.00;  //shipping insurance cost for this order.
            $ShippinDiscount = -3.00; //Shipping discount for this order. Specify this as negative number.
            $ShippinCost = 3.00; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
            //Grand total including all tax, insurance, shipping cost and discount
            $GrandTotal = ($ItemTotalPrice /* + $TotalTaxAmount + $HandalingCost + $InsuranceCost + $ShippinCost + $ShippinDiscount */);

            //Parameters for SetExpressCheckout, which will be sent to PayPal
            $padata = '&METHOD=SetExpressCheckout' .
                    '&RETURNURL=' . urlencode($PayPalReturnURL) .
                    '&CANCELURL=' . urlencode($PayPalCancelURL) .
                    '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
                    '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($ItemName) .
                    '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($ItemNumber) .
                    '&L_PAYMENTREQUEST_0_DESC0=' . urlencode($ItemDesc) .
                    '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($ItemPrice) .
                    '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($ItemQty) .
                    '&NOSHIPPING=0' . //set 1 to hide buyer's shipping address, in-case products that does not require shipping

                    '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemTotalPrice) .
                    '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) .
                    '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
                    '&LOCALECODE=ES' . //PayPal pages to match the language on your website.
                    '&LOGOIMG=https://depapelpintado.es/includes/images/img-depapelpintado.png' . //site logo
                    '&CARTBORDERCOLOR=FFFFFF' . //border color of cart
                    '&ALLOWNOTE=1';

            ############# set session variable we need later for "DoExpressCheckoutPayment" #######
            $_SESSION['ItemName'] = $ItemName; //Item Name
            $_SESSION['ItemPrice'] = $ItemPrice; //Item Price
            $_SESSION['ItemNumber'] = $ItemNumber; //Item Number
            $_SESSION['ItemDesc'] = $ItemDesc; //Item Number
            $_SESSION['ItemQty'] = $ItemQty; // Item Quantity
            $_SESSION['ItemTotalPrice'] = $ItemTotalPrice; //(Item Price x Quantity = Total) Get total amount of product; 
            $_SESSION['TotalTaxAmount'] = $TotalTaxAmount;  //Sum of tax for all items in this order. 
            $_SESSION['HandalingCost'] = $HandalingCost;  //Handling cost for this order.
            $_SESSION['InsuranceCost'] = $InsuranceCost;  //shipping insurance cost for this order.
            $_SESSION['ShippinDiscount'] = $ShippinDiscount; //Shipping discount for this order. Specify this as negative number.
            $_SESSION['ShippinCost'] = $ShippinCost; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
            $_SESSION['GrandTotal'] = $GrandTotal;


            //We need to execute the "SetExpressCheckOut" method to obtain paypal token

            $httpParsedResponseAr = $this->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

            //Respond according to message we receive from Paypal
            if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

                //Redirect user to PayPal store with Token received.
                $paypalmode = ($PayPalMode == 'sandbox') ? '.sandbox' : '';
                $paypalurl = 'https://www' . $paypalmode . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $httpParsedResponseAr["TOKEN"] . '';
                header('Location: ' . $paypalurl);
            } else {
                //Show error message
                echo '<div style="color:red"><b>Error : </b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
                echo '<pre>';
                print_r($httpParsedResponseAr);
                echo '</pre>';
            }
        }
        $this->data['prueba']=$prueba;

        $this->data['includes_footer'][]='<script src="/includes/js/carrito.js"></script>';            

        $this->load->view('frontend/header', $this->data);
        //$this->load->view('frontend/migas_nuevas_small', $this->data);
        $this->load->view('demo/checkout_compra_ya_test', $this->data);
        $this->load->view('frontend/footer', $this->data);
    }

    function checkout_confirm($order_number = FALSE, $pasarela = FALSE, $prueba=false) {
        // Note: This example uses the 'get_db_order_summary_row_array()' and 'update_db_order_summary()' function which are located in the flexi cart ADMIN library.
       
        $this->load->library('flexi_cart_admin');

        // Get the confrimed order number to display to the user.
        $this->data['order_number'] = $order_number;
        $this->data['msg']="";
        // Get the users email address that was just saved with the order data.
        $sql_where = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $this->data['order_number']);
        if ($order_data = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_demo_email', $sql_where)) {
            $this->data['user_email'] = $order_data['ord_demo_email'];
            $order_data3 = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_status', $sql_where);
            $this->data['status'] = $order_data3['ord_status'];
			
            // In many real world cases, the cart data may need to be later updated once saved - for example to save the response from an online payment gateway.
            // With such an example, the 'update_order_summary()' admin library function can be used.
            if ($pasarela == "paypal") {

                $this->load->model('contenido_model');
                $this->data['pago'] = $this->contenido_model->get_paypal();
                if (session_status() == PHP_SESSION_NONE) { session_start(); } //PHP >= 5.4.0
                /*if (session_id() == '') {
                    session_start();
                } //uncomment this line if PHP < 5.4.0 and comment out line above*/

                $PayPalMode = ($this->data['pago']->test == "0") ? 'live' : 'sandbox'; // sandbox or live
                $PayPalApiUsername = $this->data['pago']->user; //PayPal API Username
                $PayPalApiPassword = $this->data['pago']->pass; //Paypal API password
                $PayPalApiSignature = $this->data['pago']->token; //Paypal API Signature
                $PayPalCurrencyCode = 'EUR'; //Paypal Currency Code
                $PayPalReturnURL = base_url() . 'tienda/checkout_confirm/' . $order_number . '/paypal'; //Point to process.php page
                $PayPalCancelURL = base_url() . 'tienda/checkout_confirm/' . $order_number . '/paypal';
                if (isset($_GET["token"]) && isset($_GET["PayerID"])) {
                    //we will be using these two variables to execute the "DoExpressCheckoutPayment"
                    //Note: we haven't received any payment yet.

                    $token = $_GET["token"];
                    $payer_id = $_GET["PayerID"];

                    //get session variables
                    $ItemName = $_SESSION['ItemName']; //Item Name
                    $ItemPrice = $_SESSION['ItemPrice']; //Item Price
                    $ItemNumber = $_SESSION['ItemNumber']; //Item Number
                    $ItemDesc = $_SESSION['ItemDesc']; //Item Number
                    $ItemQty = $_SESSION['ItemQty']; // Item Quantity
                    $ItemTotalPrice = $_SESSION['ItemTotalPrice']; //(Item Price x Quantity = Total) Get total amount of product; 
                    $TotalTaxAmount = $_SESSION['TotalTaxAmount'];  //Sum of tax for all items in this order. 
                    $HandalingCost = $_SESSION['HandalingCost'];  //Handling cost for this order.
                    $InsuranceCost = $_SESSION['InsuranceCost'];  //shipping insurance cost for this order.
                    $ShippinDiscount = $_SESSION['ShippinDiscount']; //Shipping discount for this order. Specify this as negative number.
                    $ShippinCost = $_SESSION['ShippinCost']; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
                    $GrandTotal = $_SESSION['GrandTotal'];

                    $padata = '&TOKEN=' . urlencode($token) .
                            '&PAYERID=' . urlencode($payer_id) .
                            '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
                            //set item info here, otherwise we won't see product details later	
                            '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($ItemName) .
                            '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($ItemNumber) .
                            '&L_PAYMENTREQUEST_0_DESC0=' . urlencode($ItemDesc) .
                            '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($ItemPrice) .
                            '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($ItemQty) .
                            '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemTotalPrice) .
                            '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) .
                            '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode);

                    //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
                    $this->data['msg'] = "";

                    $httpParsedResponseAr = $this->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

                    //Check if everything went ok..
                    if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

                        $this->data['msg'].= '<h2>Pago realizado</h2>';
                        $this->data['msg'].= 'Tu transaccion ID : ' . urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);

                        /*
                          //Sometimes Payment are kept pending even when transaction is complete.
                          //hence we need to notify user about it and ask him manually approve the transiction
                         */

                        if ('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
                            $this->data['msg'].= '<div style="color:green">Pago recibido correctamente</div>';
                        } else if ('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
                            $this->data['msg'].= '<div style="color:red">La transaccion ha sido completada, pero el pago permanece pendiente. ' . 'Necesita autorizar manualmente el pago a través de su cuenta de <a target="_new" href="http://www.paypal.com">Paypal</a>.</div>';
                        }

                        // we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
                        // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
                        $padata = '&TOKEN=' . urlencode($token);

                        $httpParsedResponseAr = $this->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

                        if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

                            $this->flexi_cart_admin->update_db_order_summary(array('ord_status' => 2), $this->data['order_number']);


                            // A real world site would typically now send the user an order acknowledgement email.
                            // $this->flexi_cart_admin->email_order($this->data['order_number'], array('pagos@depapelpintado.es', $this->data['user_email']), 'Su pedido ha sido procesado correctamente.');
                            $body = array(
                                "nombre" => ($this->data['usuario']->ord_demo_ship_name != "") ? $this->data['usuario']->ord_demo_ship_name : $this->data['usuario']->ord_demo_bill_name,
                                "msg" => "A continuación le detallamos su pedido número $order_number.",
                                "pedido" => $this->getPedido($this->data['order_number'])
                            );
							
							
							
                            $this->send_email($this->data['user_email'], "El pago de su pedido (" . $order_number . ") se ha realizado correctamente.", $body);
                            $this->flexi_cart->destroy_cart();
                            $order_data2 = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_status', $sql_where);
                            if ($order_data2['ord_status'] == 2) {
                            	$this->data['status']=2;
                                $this->data['msg'] = "Su pedido se ha procesado correctamente";
                                $this->data['ecommerce'] = $this->getecommerce($order_number);
                                $this->data['ga4_purchase'] = $this->script_ga4_purchase($order_number);
                            }
                        } else {
                            $this->data['msg'].= '<div style="color:red"><b>Se ha producido un error al validar los datos:</b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
                        }
                    } else {
                        $this->data['msg'].= '<div style="color:red"><b>Error : </b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
                    }
                } else {
                    $this->data['msg'] = '<div style="color:red"><b>Error : </b>Transacción cancelada.</div>';
                }
            }

            if ($this->data['status']==1 && isset($_REQUEST['Ds_Signature'])) {
            	$signatureRecibida = $_REQUEST["Ds_Signature"];
				$version = $_REQUEST["Ds_SignatureVersion"];
				$datos = $_REQUEST["Ds_MerchantParameters"];
                /*$scode = "jfw465Ahn5F7ws8seW4j";
                $validhash = sha1($_POST['Ds_Amount'] . $_POST['Ds_Order'] . $_POST['Ds_MerchantCode'] . $_POST['Ds_Currency'] . $_POST['Ds_Response'] . $scode);
                $scode2 = "jfw465Ahn5F7ws8seW4j";
                $validhash2 = sha1($_POST['Ds_Amount'] . $_POST['Ds_Order'] . $_POST['Ds_MerchantCode'] . $_POST['Ds_Currency'] . $_POST['Ds_Response'] . $scode2);*/  
				$this->load->library('Redsys');
			    
				$miObj=new Redsys;
				$decodec = $miObj->decodeMerchantParameters($datos);	
				
				if($prueba){
					$kc=REDSYS_DEVKEY;
				}
				else{
					$kc = REDSYS_KEY;
				}
				
				$firma = $miObj->createMerchantSignatureNotif($kc,$datos);	
				
				$dsreponse=$miObj->getParameter("Ds_Response");
			    //$validhash2 = hash('sha256',$_POST['Ds_Amount'] . $_POST['Ds_Order'] . $_POST['Ds_MerchantCode'] . $_POST['Ds_Currency'] . $_POST['Ds_Response'] . $scode2);
			    if ($dsreponse >= "0000" && $dsreponse <= "0099" && $firma == $signatureRecibida) {
			    	
                    $this->flexi_cart_admin->update_db_order_summary(array('ord_status' => 2), $this->data['order_number']);
                    // A real world site would typically now send the user an order acknowledgement email.
                    $this->flexi_cart->destroy_cart();

                    sleep(1);
                    
                    $this->data['msg'] = "Su pedido se ha procesado correctamente";
                    $this->data['ecommerce'] = $this->getecommerce($order_number);
                    $this->data['ga4_purchase'] = $this->script_ga4_purchase($order_number);
                    $body = array(
                        "nombre" => ($this->data['usuario']->ord_demo_ship_name != "") ? $this->data['usuario']->ord_demo_ship_name : $this->data['usuario']->ord_demo_bill_name,
                        "msg" => "A continuación le detallamos su pedido número $order_number.",
                        "pedido" => $this->getPedido($this->data['order_number'])
                    );
                    $this->send_email($this->data['user_email'], "El pago de su pedido (" . $order_number . ") se ha realizado correctamente.", $body);
                	//mamua dagoelako ezabatu daiteke
					$this->load->library('email');
			        $config['wordwrap'] = FALSE;
			        $config['mailtype'] = 'html';
			        $this->email->initialize($config);
			        $this->email->from('info@depapelpintado.es', 'dePapelPintado');
			        $this->email->to("antonio@bitarlan.net");
			        $this->email->subject("El pago de su pedido (" . $order_number . ") se ha realizado correctamente.");
			        $this->email->message($this->load->view('frontend/cuentas/plantillamail', $body, TRUE));
			        $this->email->send();
					//mamua dagoelako ezabatu daiteke

                    // Marcamos a mano el pedido como pagado
                    $this->data['status']==2;
				}
            }
        }

        // Destroy the cart.
        // Note: once checkout is complete, it is better to use the 'destroy_cart()' function rather than 'empty_cart()' to ensure all session data from the
        // now completed order is removed, rather than just removing the items in the cart.
        else
            $this->data['msg'] = "Se ha producido un error en el pago";
        
        if($this->data['status']==2){
            $this->data['ga4_purchase'] = $this->script_ga4_purchase($order_number);
            $this->data['datos_resumen_pantalla']=$this->getDatosPedidoParaScriptGA4($order_number);
            $this->data['msg'] = "El pago de su pedido se ha realizado correctamente.";
            $this->flexi_cart->destroy_cart();
        }
		elseif($this->data['status']>2){
            $this->data['ga4_purchase'] = $this->script_ga4_purchase($order_number);
            $this->data['datos_resumen_pantalla']=$this->getDatosPedidoParaScriptGA4($order_number);
            $this->data['msg'] = "El pago de su pedido ya se realizó correctamente.";
            $this->flexi_cart->destroy_cart();
        }
        else{
            $this->data['msg'] = "Se ha producido un error en el pago";
        }
        if ($order_number=='00009471'){
            echo "<br />".$dsreponse;
        }
        $this->load->view('demo/checkout_complete_view', $this->data);
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
    // SAVE / LOAD CART DATA
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * load_save_cart_data
     * Either load or save the carts session data from/to the the database.
     * This function is accessed from the 'Save / Load Cart Data' page.
     */
    private function load_save_cart_data() {
        // The load/save/delete cart data functions require the flexi cart ADMIN library.
        $this->load->library('flexi_cart_admin');

        // Create an SQL WHERE clause to list all previously saved cart data for a specific user.
        // For this example, the user id will be set as 1. In a real world application, this would be the logged-in users id.
        // This examples also prevents cart session data from confirmed orders being loaded, by checking the readonly status is set at '0'.
        $sql_where = array(
            $this->flexi_cart->db_column('db_cart_data', 'user') => 1,
            $this->flexi_cart->db_column('db_cart_data', 'readonly_status') => 0
        );

        // Get a list of all saved carts that match the SQL WHERE statement.
        $this->data['saved_cart_data'] = $this->flexi_cart_admin->get_db_cart_data_array(FALSE, $sql_where);

        // Get any status message that may have been set.
        $this->data['message'] = $this->session->flashdata('message');

        $this->load->view('demo/feature_examples/features_save_load_cart_view', $this->data);
    }

    /**
     * save_cart_data
     * Saves the users current cart to the database so that it can be reloaded at a later date.
     * This function is accessed from either the 'View Cart' or the 'Save / Load Cart Data' page.
     */
    function save_cart_data() {
        // The load/save/delete cart data functions require the flexi cart ADMIN library.
        $this->load->library('flexi_cart_admin');

        // For this example, the user id will be set as 1. 
        // In a real world application, this would be the logged-in users id.
        $user_id = $this->data['usuario']->user_id;

        // Save the cart data to the database.
        $this->flexi_cart_admin->save_cart_data($user_id);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/view_cart');
    }

    /**
     * load_cart_data
     * Loads saved cart data into the users current cart, overwriting any existing cart data in their current session.
     * A custom function 'demo_update_loaded_cart_data()' has been included to ensure that all loaded item data is up-to-date with the current item database table. 
     * This function is accessed from the 'Save / Load Cart Data' page.
     */
    function load_cart_data($cart_data_id = 0) {
        // The load/save/delete cart data functions require the flexi cart ADMIN library.
        $this->load->library('flexi_cart_admin');
        $this->load->model('demo_cart_model');

        // Load saved cart data array.
        // This data is loaded into the browser session as if you were shopping with the cart as normal.
        $this->flexi_cart_admin->load_cart_data($cart_data_id);

        // To ensure that the prices and other data of all loaded items are still correct, a custom demo function has been made to loop through each item in the cart, 
        // query the demo item database table and retrieve the current item data.
        // As flexi cart does not manage item tables, this function has to be custom made to suit each sites requirements, this is an example of how it can be achieved.
        // Note that cart items including selectable options would potentially require a more complex query.	
        $this->demo_cart_model->demo_update_loaded_cart_data();

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/view_cart');
    }

    /**
     * delete_cart_data
     * Deletes specific saved cart data from the database.
     * This function is accessed from the 'Save / Load Cart Data' page.
     */
    function delete_cart_data($cart_data_id = 0) {
        // The load/save/delete cart data functions require the flexi cart ADMIN library.
        $this->load->library('flexi_cart_admin');

        // Delete the saved cart data from the database.
        $this->flexi_cart_admin->delete_db_cart_data($cart_data_id);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/load_save_cart_data');
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // NAVIGATION MENU FUNCTIONS
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * currency
     * Set which currency to display cart pricing in.
     * This function is accessed from the navigation menu 'Feature Examples'.
     */
    private function currency($currency_identifier) {
        // Update cart currency using url parameter.
        $this->flexi_cart->update_currency($currency_identifier);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/view_cart');
    }

    /**
     * pricing_tax
     * Set whether to display cart pricing including or excluding tax.
     * This function is accessed from the navigation menu 'Feature Examples'.
     */
    private function pricing_tax($tax_status) {
        // Check whether tax is to be included or excluded from pricing.
        $tax_status = ($tax_status == 'inc');

        // Update tax pricing status.
        $this->flexi_cart->set_prices_inc_tax($tax_status);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/view_cart');
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // SET MISC CART SETTINGS
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * misc_features
     * A list of miscellaneous features that are also available in flexi cart.
     * The features include setting a minimum order value, changing tax location, changing cart statuses and converting weights and currencies.
     * This page is accessed from the 'Miscellaneous' page listed in the navigation menu 'Feature Examples'.
     */
    private function misc_features() {
        $this->load->model('demo_cart_model');

        // Check if the 'Change Tax Rate' form input has been submitted.
        if ($this->input->post('tax_location')) {
            $this->demo_cart_model->demo_update_tax();
        }

        // Set country location data for use with tax location demo.
        $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));
        $this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);

        // Get any status message that may have been set.
        $this->data['message'] = $this->session->flashdata('message');

        $this->load->view('demo/feature_examples/features_misc_view', $this->data);
    }

    /**
     * minimum_order
     * Sets the minimum order value required to checkout.
     * This function is accessed from the 'Miscellaneous' page.
     */
    private function minimum_order($value) {
        // Set the minimum order value.
        $this->flexi_cart->set_minimum_order($value);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/misc_features');
    }

    /**
     * user_status
     * Toggles a custom status that in this demo represents whether a user has logged in.
     * Discounts can be set to only be applied if a custom status is active, i.e. only logged in users.
     * This function is accessed from the 'Miscellaneous' page.
     */
    private function user_status($status) {
        // Check whether the user is logging in or out. 
        $status = ($status == 'login');

        // Update the carts custom status.
        $this->flexi_cart->set_custom_status_1($status);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

        redirect('tienda/misc_features');
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // MINI CART DATA
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * mini_cart_data
     * This function is called by the '__construct()' to set item data to be displayed on the 'Mini Cart' menu.
     */
    function cerrar_pedido() {
        $this->flexi_cart->destroy_cart();
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());
        redirect('tienda');
    }

    function datos_minicarro() {
        $this->data['mini_cart_items']=$this->mini_cart_data();
        return $this->load->view('frontend/minicarro_nuevo');  
        /*
        print '<pre><xmp>';
        print_r($this->data['mini_cart_items']);
        print '</xmp></pre>';
        */
    }

    private function mini_cart_data() {
        $this->data['mini_cart_items'] = $this->flexi_cart->cart_items();
        if (isset($this->data['mini_cart_items']) && count($this->data['mini_cart_items'])==0){
            $this->flexi_cart->destroy_cart();
        }
   }

    private function reparar_colecciones() {
        foreach ($this->db->select("*,(SELECT GROUP_CONCAT(DISTINCT item_tipo SEPARATOR ',')) AS ctipo", FALSE)->join('demo_items', 'item_coleccion_id = coleccion_id')->group_by('coleccion_id')->where("demo_items.activo", 1)->where('demo_coleccion.activo', 1)->get('demo_coleccion')->result() as $e) {
            //$this->data['colec'].= $e->coleccion_name." - $e->ctipo - $e->ccats<br>";
            $this->db->where('coleccion_id', $e->coleccion_id)->update('demo_coleccion', array('ccats' => str_replace(' ', '', $e->ctipo)));
        }
    }

    private function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode) {
        // Set up your API credentials, PayPal end point, and API version.
        $API_UserName = urlencode($PayPalApiUsername);
        $API_Password = urlencode($PayPalApiPassword);
        $API_Signature = urlencode($PayPalApiSignature);

        $paypalmode = ($PayPalMode == 'sandbox') ? '.sandbox' : '';
        $API_Endpoint = "https://api-3t" . $paypalmode . ".paypal.com/nvp";
        $version = urlencode('109.0');

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit("$methodName_ failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }

        return $httpParsedResponseAr;
    }

    function ver_plantilla_factura($pedido) {
        $this->load->library('flexi_cart_admin');
        $this->load->model('demo_cart_model');
        $this->load->model('demo_cart_admin_model');
        $this->data['pedido'] = $this->getFactura($pedido);
        $this->load->view("frontend/cuentas/plantillamailfra", $this->data);
        $this->demo_cart_admin_model->demo_facturar($pedido);
    }

    private function ver_script_ecommerce($pedido) {
        $this->load->library('flexi_cart_admin');
        echo $this->getecommerce($pedido);
    }

    function ver_script_ga4_purchase($pedido) {
        $this->load->library('flexi_cart_admin');
        $datos=$this->getDatosPedidoParaScriptGA4_test($pedido);

        $script_purchase=$this->load->view('frontend/cuentas/ga4_purchase', $datos,TRUE);

        echo $script_purchase;
    }

    private function getDatosPedidoParaScriptGA4_test($ped) {
        $item_data = $this->db->select("*")->from("order_details")->join('demo_items', 'item_id = ord_det_item_fk')->join('demo_categories', 'item_cat_fk = cat_id')->where("ord_det_order_number_fk", $ped)->get()->result_array();
        $datos=array();
        $datos_pedido=array();
        foreach ($item_data as $key => $item) {
            $datos_pedido[$item['ord_det_item_fk']]['name']=$item['ord_det_item_name'];
            $datos_pedido[$item['ord_det_item_fk']]['id']=$item['ord_det_item_fk'];
            $datos_pedido[$item['ord_det_item_fk']]['unit_price']=$item['ord_det_discount_price']; //unitario
            $datos_pedido[$item['ord_det_item_fk']]['total_price']=$item['ord_det_discount_price_total']; //unitario
            $datos_pedido[$item['ord_det_item_fk']]['brand']=$item['cat_name'];
            $datos_pedido[$item['ord_det_item_fk']]['category']=$item['item_tipo'];
            $datos_pedido[$item['ord_det_item_fk']]['quantity']=$item['ord_det_quantity'];
        }
        $datos['items_pedido']=$datos_pedido;

        //$acumulado_pedido = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped, "ord_user_fk" => $this->data['usuario']->user_id));
        $acumulado_pedido = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped));
        $datos_acumulados=array();
        foreach ($acumulado_pedido as $key => $item) {
            /*
            echo '<pre>';
            print_r($item);
            echo '</pre>';
            */
            $datos_acumulados['id']=$ped;
            //$datos_acumulados['revenue']=$item['ord_item_summary_total'];  // Total transaction value (incl. tax and shipping)
            $datos_acumulados['revenue']=$item['ord_item_shipping_total'];  // Total transaction value (incl. tax and shipping)
            $datos_acumulados['tax']=$item['ord_tax_total'];
            $datos_acumulados['shipping']=$item['ord_shipping_total'];
            $datos_acumulados['ord_demo_email']=$item['ord_demo_email'];
        }
        $datos['acumulado_pedido'] = $datos_acumulados;

        return $datos;
    }


    private function script_ga4_purchase($pedido) {
        $this->load->library('flexi_cart_admin');
        $datos=$this->getDatosPedidoParaScriptGA4($pedido);

        $script_purchase=$this->load->view('frontend/cuentas/ga4_purchase', $datos,TRUE);

        return $script_purchase;
    }

    private function getecommerce($ped) {
        return "";
        //  $this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE,array("ord_order_number"=>$ped,"ord_user_fk"=>$this->data['usuario']->user_id));
        //	$sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $ped);
        //	$this->data['item_data'] = $this->db->select("*")->from("order_details")->where("ord_det_order_number_fk",$ped)->get()->result_array();
        //    $this->data['refund_data'] = $this->db->query("SELECT SUM(ord_det_quantity_cancelled * ord_det_price) AS ord_det_price, SUM(ord_det_quantity_cancelled * ord_det_discount_price) AS ord_det_discount_price, SUM(ord_det_quantity_cancelled * ord_det_tax) AS ord_det_tax, SUM(ord_det_quantity_cancelled * ord_det_shipping_rate) AS ord_det_shipping_rate, SUM(ord_det_quantity_cancelled * ord_det_weight) AS ord_det_weight, SUM(ord_det_quantity_cancelled * ord_det_reward_points) AS ord_det_reward_points FROM (`order_details`) WHERE `ord_det_order_number_fk` ='".$ped."'")->result_array();   return $this->load->view('frontend/cuentas/analyticsecommerce', $this->data,TRUE);
    }

    private function extrameta($title = "", $description = "", $image = "", $image2 = "", $articulo = NULL) {
        $ret = "<meta itemprop=\"name\" content=\"depapelpintado.es $title\">
<meta itemprop=\"description\" content=\"$description\">
<meta name=\"twitter:title\" content=\"depapelpintado.es $title\">
<meta name=\"twitter:description\" content=\"$description\">
<meta property=\"og:description\" content=\"$description\" />
<meta property=\"og:site_name\" content=\"dePapelPintado.es\" />
<meta property=\"og:title\" content=\"depapelpintado.es $title\" />";
        if ($image != "") {
            $ret.= "
<meta itemprop=\"image\" content=\"$image\">
<meta name=\"twitter:image\" content=\"$image\">
<meta property=\"og:image\" content=\"$image\" />";
        }
        if ($image2 != "") {
            $ret.= "
<meta property=\"og:image\" content=\"$image2\" />";
        }
        if ($articulo != NULL) {
            $ret.= "
    <meta name=\"twitter:card\" content=\"product\">
<meta name=\"twitter:site\" content=\"@EKAMDecoracion\">

<meta name=\"twitter:creator\" content=\"@EKAMDecoracion\">

<meta name=\"twitter:data1\" content=\"€" . $articulo['precio'] . "\">
<meta name=\"twitter:label1\" content=\"Precio\">";
            if (isset($articulo['color'])) {

                $ret = "<meta name=\"twitter:data2\" content=\"" . $articulo['color'] . "\">
<meta name=\"twitter:label2\" content=\"Colores\">";
            }
            $ret = "
<meta property=\"og:type\" content=\"article\" />
<meta property=\"og:url\" content=\"" . current_url() . "/\" />

<meta property=\"og:price:amount\" content=\"" . $articulo['precio'] . "\" />
<meta property=\"og:price:currency\" content=\"EUR\" />";
        }
        return $ret;
    }

    function newsletter_test(){ 
        $this->send_registro_email("info@depapelpintado.es", "Gracias por registrarte en depapelpintado.es", 'emailregistro_bono', TRUE);
    }
    // Funcion que se usaba para registrar en mail en mailchimp y enviar el bono descuento
    function newsletter($desde, $a_post){ 
    }
    function newsletter_mailchimp_orig($desde, $a_post){ 
        $this->load->library('MailChimp_v3');
        $MailChimp = new MailChimp_v3();  
        $list_id =MAILCHIMP_V3_LIST_ID;

        if ($desde=='footer'){
            $email=$a_post['email_newsletter_footer'];

            $mergevars = array();
            $mergevars = array(
                        //'FNAME' => $_POST['name'],
                        //'LNAME' => $_POST['surname'],
                        'PHONE' => '',
                        //~ 'ULTIMOCON' => date('d/m/Y'),
                        //~ 'OFICINA' => $mail_oficina,
                        );
            
            $a_tag_id=array();
            $a_tag_id[]=2895177; // id del tag 'Newsletter Banner Web'
            //$a_tag_id[]=2895082; // id del tag 'Alta Newsletter Banner'
            //$a_tag_id[]=2884937; // id del tag 'HOME'
            //$a_tag_id[]=2884938; // id del tag 'FORMULARIO CONTACTO'

            $a_interests=array();
            //$a_interests=array('1e022633ed' => true,);
            //~ $a_interest_id[]=13; // id del grupo athletic

            $response= $MailChimp -> insertar_suscriptor($list_id, $email, $mergevars, $a_tag_id, $a_interests);

            if (isset($response->email_address) && $response->email_address==$email)
                return true;
        }
        elseif ($desde=='registro_usuario'){
            $email=$a_post['email'];

            $mergevars = array();
            $mergevars = array(
                        //'FNAME' => $_POST['name'],
                        //'LNAME' => $_POST['surname'],
                        'PHONE' => '',
                        //~ 'ULTIMOCON' => date('d/m/Y'),
                        //~ 'OFICINA' => $mail_oficina,
                        );
            
            $a_tag_id=array();
            $a_tag_id[]=2903911; // id del tag 'Registro usuario'
            //$a_tag_id[]=2895082; // id del tag 'Alta Newsletter Banner'
            //$a_tag_id[]=2884937; // id del tag 'HOME'
            //$a_tag_id[]=2884938; // id del tag 'FORMULARIO CONTACTO'

            $a_interests=array();
            //$a_interests=array('1e022633ed' => true,);
            //~ $a_interest_id[]=13; // id del grupo athletic

            $response= $MailChimp -> insertar_suscriptor($list_id, $email, $mergevars, $a_tag_id, $a_interests);

            if (isset($response->email_address) && $response->email_address==$email)
                return true;
        }
        elseif ($desde=='home'){
            $email=$a_post['email_newsletter'];

            $mergevars = array();
            $mergevars = array(
                        //'FNAME' => $_POST['name'],
                        //'LNAME' => $_POST['surname'],
                        'PHONE' => '',
                        //~ 'ULTIMOCON' => date('d/m/Y'),
                        //~ 'OFICINA' => $mail_oficina,
                        );
            
            $a_tag_id=array();
            $a_tag_id[]=2884937; // id del tag 'HOME'
            //$a_tag_id[]=2884938; // id del tag 'FORMULARIO CONTACTO'

            $a_interests=array();
            //$a_interests=array('1e022633ed' => true,);
            //~ $a_interest_id[]=13; // id del grupo athletic

            $response= $MailChimp -> insertar_suscriptor($list_id, $email, $mergevars, $a_tag_id, $a_interests);

            if (isset($response->email_address) && $response->email_address==$email)
                return true;
        }
        else{
            echo "<br />desde: $desde";
            print '<pre><xmp>';
            print_r($a_post);
            print '</xmp></pre>';
            exit;
            echo "<br />1";
            echo "<br />2";
            //echo "<br />".MAILCHIMP_V3_API_KEY;
            //exit;
            $_POST['email']='pruebaeneko2@pruebaeneko.com';
            //$_POST['email']='info@depapelpintado.es';
            $_POST['name']='Eneko Probando 3';
            $_POST['surname']='Desde formulario 3';
            $_POST['phone']='943332233';


            //exit;
            $mergevars = array();

            //~ $mergevars = array(
                        //~ 'FNAME' => 'LALALA',
                        //~ 'LNAME' => 'LOLOLO',
                        //~ 'TELEFONO' => $_POST['phone'],
                        //~ 'OFICINA' => $mail_oficina,
                        //~ 'ULTIMOCON' => date('d/m/Y'),
                        //~ );
            $mergevars = array(
                        'FNAME' => $_POST['name'],
                        'LNAME' => $_POST['surname'],
                        'PHONE' => $_POST['phone'],
                        //~ 'ULTIMOCON' => date('d/m/Y'),
                        //~ 'OFICINA' => $mail_oficina,
                        );
            /*
            */
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
            // OJO CON EL ETIQUETADO DE LAS SUSCRIPCIONES
            // Para añadir una etiqueta al suscriptor, deberemos pasar el id de esa etiqueta en mailchimp,
            // por lo que la etiqueta deberá ser creada previamente si es nueva
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
            $a_tag_id=array();
            $a_tag_id[]=2884937; // id del tag 'HOME'
            //$a_tag_id[]=2884938; // id del tag 'FORMULARIO CONTACTO'

            $a_interests=array();
            //$a_interests=array('1e022633ed' => true,);
            //~ $a_interest_id[]=13; // id del grupo athletic

            /*
            $a_interest_categories = $MailChimp->get("lists/$list_id/interest-categories");
            foreach ($a_interest_categories['categories'] as $obj) {
                echo $obj['id'] . ' - ' . $obj['title'];
                echo '<br />';
            }
            echo '<br />';
            echo '<br />';

            $group_id='18e6d54406'; // Eventos
            $a_interests = $MailChimp->get("lists/$list_id/interest-categories/".$group_id."/interests");
            foreach ($a_interests['interests'] as $obj) {
                echo $obj['id'] . ' - ' . $obj['name'];
                echo '<br />';
            }
             */
            /*
            $a_members = $MailChimp->get("lists/$list_id/members");
            print '<pre><xmp>';
            print_r($a_members);
            print '</xmp></pre>';
            */
           //~ print '<pre><xmp>';
            //~ print_r($a_interests);
            //~ print '</xmp></pre>';
            //~ exit;
            /*
            echo "<br />".$email;
            echo "<br />list_id: ".$list_id;
            print '<pre><xmp>';
            print_r($MailChimp);
            print '</xmp></pre>';
            */
            //~ print '<pre><xmp>';
            //~ print_r($mergevars);
            //~ print '</xmp></pre>';

            //~ print '<pre><xmp>';
            //~ print_r($a_interests);
            //~ print '</xmp></pre>';
            //exit;

            $response= $MailChimp -> insertar_suscriptor($list_id, $email, $mergevars, $a_tag_id, $a_interests);
            print '<pre><xmp>';
            print_r($response);
            print '</xmp></pre>';

            echo "<br />actualizado";
            exit;
        }
    }
}

/* End of tienda.php */
/* Location: ./application/controllers/tienda.php */
