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
        $this->load->helper('text');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('contenido_model');
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
        $this->user['pass'] = "P4p3lp1nt4d02016!";
        // Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
        $this->load->vars('base_url', base_url());
        $this->load->vars('includes_dir', base_url() . 'includes/');
        $this->load->vars('current_url', $this->uri->uri_to_assoc(1));

        // Load cart data to be displayed via 'Mini Cart' menu.
        if ($this->input->post('logout')) {
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('hash');
        }

        if ($this->input->post("registrar")) {
            $this->load->helper('email');
            if (!valid_email($this->input->post("email"))) {
                $this->data["logmsg"] = "El nombre de usuario debe ser una cuenta de email valida.";
            } else if ($this->input->post("email") && $this->input->post("pass") == $this->input->post("pass2") && $this->input->post("pass2") != '') {
                if ($this->db->where(array('email' => $this->input->post("email")))->count_all_results('users') == 0) {
                    $this->db->insert('users', array('email' => $this->input->post("email"), 'password' => md5($this->input->post("pass"))));
                    $this->data["logmsg"] = "Te has registrado correctamente, logeate para acceder a tus datos.";
                    $this->send_info_email($this->input->post("email"), "Gracias por registrarte en depapelpintado.es", $this->load->view('frontend/cuentas/emailregistro', array(), TRUE));
                } else
                    $this->data["logmsg"] = "Ya existe una cuenta con ese email.";
            } else
                $this->data["logmsg"] = 'Los Datos introducidos no son validos.';
        }
        if ($this->input->post("identificate")) {
            if ($this->input->post("email") && $this->input->post("pass")) {
                if ($this->db->where(array('email' => $this->input->post("email"), 'password' => md5($this->input->post("pass"))))->count_all_results('users') == 1) {
                    $newdata = array(
                        'email' => $this->input->post("email"),
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($newdata);
                } else
                    $this->data["logmsg"] = 'Los Datos introducidos no son validos.  ¿No recuerdas tu contraseña? <a href="' . base_url() . 'tienda/recuperar_contrasena">Pincha Aqui</a>';
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
            
            if ($_POST['user'] == $this->user['user'] && mysql_real_escape_string($_POST['pass']) == $this->user['pass']) {
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
        $this->load->view('frontend/header', $this->data);
        $this->data['mail'] = urldecode($mail);
        $this->data['msg'] = '';
        if ($this->input->post('email')) {
            //enviar mail guardar token + fecha
            if ($this->db->where("email", $this->data['mail'])->count_all_results("users") > 0) {
                $this->data['cual'] = "enviado";
                $this->data['mail'] = $this->input->post('email');
                $this->load->view('frontend/cuentas/recuperar', $this->data);
                $hash = md5(time() . $this->input->post('email'));

                $this->db->where("email", $this->input->post('email'))->update('users', array('token' => $hash, 'requestdate' => date('Y-m-d H:i:s', time())));
                $this->send_info_email($this->data['mail'], 'Solicitud de reestablecimiento de contraseña', 'Se ha solicita el cambio de contraseña para la cuenta asociada a este email en depapelpintado.es<br>Para continuar con el proceso haga click en el enlace siguente<br><a href="' . base_url() . 'tienda/recuperar_contrasena/' . urlencode($this->input->post('email')) . '/' . $hash . '">' . base_url() . 'tienda/recuperar_contrasena/' . urlencode($this->input->post('email')) . '/' . $hash . '</a><br>En caso de no haberla solicitado ud, simplemente ignore este email');
            }
        } else if ($token != '') {
            //mirar token y fecha y si coincide
            //si coincide
            $count = $this->db->where("email", $this->data['mail'])->where("token", $token)->where("requestdate > NOW() - INTERVAL 1 DAY")->count_all_results("users");
            if ($count == 1) {
                if ($this->input->post('pass') && $this->input->post('pass2') == $this->input->post('pass')) {
                    $this->db->where("email", $this->data['mail'])->update('users', array('token' => '', 'requestdate' => time(), 'password' => md5($this->input->post('pass'))));
                    $this->data['cual'] = "hecho";
                    $this->load->view('frontend/cuentas/recuperar', $this->data);
                } else if ($this->input->post('pass') && $this->input->post('pass2')) {
                    $this->data['cual'] = "reset";
                    $this->data['msg'] = "Las claves no coinciden";
                    $this->load->view('frontend/cuentas/recuperar', $this->data);
                } else {
                    $this->data['cual'] = "reset";
                    $this->load->view('frontend/cuentas/recuperar', $this->data);
                }
            } else {
                $this->data['msg'] = "La solicitud de cambio ha caducado, por favor vuelva a solicitarla.";
                redirect("tienda/recuperar_contrasena/" . $mail);
            }
        } else {
            $this->load->view('frontend/cuentas/recuperar', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function isLog() {
        if ($this->session->userdata('email') && $this->session->userdata('logged_in')) {
            if ($this->db->where('email', $this->session->userdata('email'))->get('users')->num_rows() == 1) {
                return $this->db->where('email', $this->session->userdata('email'))->get('users')->row();
            } else {
                return $this->db->where('user_id', 1)->get('users')->row();
            }
        } else
            return $this->db->where('user_id', 1)->get('users')->row();
    }

    function clave() {
        if ($this->data['usuario']->user_id != 1) {
            if ($this->input->post("cambiopass")) {
                if ($this->input->post("email") && $this->input->post("pass") && $this->input->post("pass") == $this->input->post("pass2") && $this->input->post("oldpass")) {
                    if ($this->db->where(array('email' => $this->data['usuario']->email, 'password' => md5($this->input->post("oldpass"))))->count_all_results('users') == 1) {
                        $this->db->update('users', array('password' => md5($this->input->post("pass"))))->where('email', $this->data['usuario']->email);
                        $this->data['cambiook'] = "La contraseña se ha modificado correctamente.";
                    }
                }
            }
            if (isset($this->data['cambiook']))
                $this->data['cambioko'] = "No se ha podido modificar la contraseña.";
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/cuentas/clave', $this->data);
        }
    }

    function mi_cuenta() {
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
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/cuentas/micuenta', $this->data);
        } else {
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/cuentas/nologged', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function mis_pedidos($ped = "0") {
        if ($this->data['usuario']->user_id == 1)
            redirect("tienda");
        $this->load->library("flexi_cart_admin");
        $this->flexi_cart_admin->sql_order_by($this->flexi_cart_admin->db_column('order_summary', 'date'), 'desc');
        if ($ped == "0") {
            $this->data['order_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_user_fk" => $this->data['usuario']->user_id));

            // Get any status message that may have been set.
            $this->data['message'] = $this->session->flashdata('message');
            $this->load->view('frontend/header', $this->data);
            $this->load->view('frontend/cuentas/pedidos', $this->data);
            $this->load->view('frontend/footer', $this->data);
        } else {

            $this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE, array("ord_order_number" => $ped, "ord_user_fk" => $this->data['usuario']->user_id));
            $sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $ped);
            $this->data['item_data'] = $this->db->select("*")->from("order_details")->where("ord_det_order_number_fk", $ped)->get()->result_array();
            $this->data['refund_data'] = $this->db->query("SELECT SUM(ord_det_quantity_cancelled * ord_det_price) AS ord_det_price, SUM(ord_det_quantity_cancelled * ord_det_discount_price) AS ord_det_discount_price, SUM(ord_det_quantity_cancelled * ord_det_tax) AS ord_det_tax, SUM(ord_det_quantity_cancelled * ord_det_shipping_rate) AS ord_det_shipping_rate, SUM(ord_det_quantity_cancelled * ord_det_weight) AS ord_det_weight, SUM(ord_det_quantity_cancelled * ord_det_reward_points) AS ord_det_reward_points FROM (`order_details`) WHERE `ord_det_order_number_fk` ='" . $ped . "'")->result_array();
            // Get any status message that may have been set.
            $this->data['message'] = $this->session->flashdata('message');
            $this->load->view('frontend/header', $this->data);
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

    function index() {
        // introducir aqui el contenido a mostrar en los metas
        //  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $this->data['title'] = "";
        $this->data['description'] = "";

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
        //$this->data['all']=$this->flexi_cart_model->get_items_filter();

        $this->load->view('frontend/header', $this->data);

        if (isset($_POST['search']) && trim($_POST['search']) != "") {
            $search = $_POST['search'];
            $this->data['all'] = $this->flexi_cart_model->search_items($search, 0);
            $this->load->view('frontend/cuerposeccion', $this->data);
        } else {
            $this->load->view('frontend/slider', $this->data);
            $this->load->view('frontend/home', $this->data);
        }
        //    $this->load->view('frontend/estilos', $this->data);
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
        return '';
    }
    function _metadatos($objeto=FALSE){
        if ($objeto!=FALSE){
            if(isset($objeto->meta_title)){
                if($objeto->meta_title!="")$this->data["title2"]=$objeto->meta_title;
                if($objeto->meta_description!="")$this->data["description2"]=$objeto->meta_description;
                if($objeto->meta_keywords!="")$this->data["keywords2"]=$objeto->meta_keywords;
            }
            if(isset($objeto->meta_titlec)){
                if($objeto->meta_titlec!="")$this->data["title2"]=$objeto->meta_titlec;
                if($objeto->meta_descriptionc!="")$this->data["description2"]=$objeto->meta_descriptionc;
                if($objeto->meta_keywordsc!="")$this->data["keywords2"]=$objeto->meta_keywordsc;
            }
            if(isset($objeto->meta_titlef)){
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
            if(isset($objeto['meta_titlec'])){
                if($objeto['meta_titlec']!="")$this->data["title2"]=$objeto['meta_titlec'];
                if($objeto['meta_descriptionc']!="")$this->data["description2"]=$objeto['meta_descriptionc'];
                if($objeto['meta_keywordsc']!="")$this->data["keywords2"]=$objeto['meta_keywordsc'];
            }
            if(isset($objeto['meta_titlef'])){
                if($objeto['meta_titlef']!="")$this->data["title2"]=$objeto['meta_titlef'];
                if($objeto['meta_descriptionf']!="")$this->data["description2"]=$objeto['meta_descriptionf'];
                if($objeto['meta_keywordsf']!="")$this->data["keywords2"]=$objeto['meta_keywordsf'];
            }
        }   
    }

    function papel_pintado($param1 = "") {
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
        $description = "Elige el Papel Pintado que mejor se adapte a tu ambiente. En nuestro amplio catálogo encontrarás lo que buscas. Visítanos!";
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
            $estilo = " - " . $this->data['donde']['estilo'];
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
            case 1: $categ = "Fotomurales";
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
        if ($param1 == "marcas")
            $title.=" - Listado de Marcas";
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
        $this->data['description'] = $description;

        //Aqui van las cabeceras de economicos
        if ($econ == 1) {
            $this->data['title'] = "Papel Pintado Barato - Ahorro Garantizado";
            $this->data['description'] = "Elige el Papel Pintado para decorar tu estancia por muy poco dinero. En nuestro amplio catálogo encontrarás lo que buscas. Visítanos!";
            $this->data['keywords'] = "papel pintado barato";
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
        } else if ($param1 == "marcas")
            $this->load->view('frontend/fabricantes', $this->data);
        else if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {
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

            if (count($this->data['donde']) == 0)
                $this->load->view('frontend/slider2', $this->data);

            $this->load->view('frontend/cuerposeccion', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function fotomurales($param1 = "") {
        $this->data['donde'] = $this->uri->uri_to_assoc(3);
        $this->data['donden'] = array();
        $this->data['donden']['marca'] = null;
// introducir aqui el contenido a mostrar en los metas
//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $title = "Fotomurales- Personaliza tu Espacio";
        $description = "Elige tu Fotomural y consigue el efecto deseado en tu estancia. En nuestro amplio catálogo encontrarás lo que buscas. Visítanos!";
        $keywords = "fotomurales";
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
            case 1: $categ = "Fotomurales";
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
        if ($param1 == "marcas")
            $title.=" - Listado de Marcas";
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
        $this->data['title'] = $title . " - " . $categ . $estilo . $color." - ";
        $this->data['description'] = $description;
        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);
        $this->load->view('frontend/header', $this->data);
        if (isset($_POST['search']) && trim($_POST['search']) != "") {
            $search = $_POST['search'];
$this->db->cache_on();
            $this->data['all'] = $this->flexi_cart_model->search_items($search, 0);
$this->db->cache_off();
            $this->load->view('frontend/cuerposeccion', $this->data);
        } else if ($param1 == "marcas")
            $this->load->view('frontend/fabricantes', $this->data);
        else if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {
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
            if (count($this->data['donde']) == 0)
                $this->load->view('frontend/slider2', $this->data);
            $this->load->view('frontend/cuerposeccion', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function revestimientos($param1 = "") {
        $this->data['donde'] = $this->uri->uri_to_assoc(3);
        $this->data['donden'] = array();
        $this->data['donden']['marca'] = null;
        $econ = 0;
        $losmas = 0;

// introducir aqui el contenido a mostrar en los metas
//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $title = "Revestimientos de Pared - Decora tu Pared";
        $description = "Elige el Revestimiento adecuado para tu espacio.En nuestro amplio catálogo encontrarás lo que buscas. Visítanos!";
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
            case 1: $categ = "Fotomurales";
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
        if ($param1 == "marcas")
            $title.=" - Listado de Marcas";
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
        $this->data['title'] = $title . " - " . $categ . $estilo . $color." - ";
        $this->data['description'] = $description;
        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);
        $this->load->view('frontend/header', $this->data);
        if ($param1 == "marcas")
            $this->load->view('frontend/fabricantes', $this->data);
        else if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {
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

            if (count($this->data['donde']) == 0)
                $this->load->view('frontend/slider2', $this->data);

            $this->load->view('frontend/cuerposeccion', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function telas($param1 = "") {
        $this->data['donde'] = $this->uri->uri_to_assoc(3);
        $this->data['donden'] = array();
        $this->data['donden']['marca'] = null;
        $econ = 0;
        $losmas = 0;

// introducir aqui el contenido a mostrar en los metas
//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $title = "Telas Online - Amplio Catálogo";
        $description = "Elige la Tela  para decorar tu estancia con personalidad. En nuestro amplio catálogo encontrarás lo que buscas. Visítanos!";
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
            case 1: $categ = "Fotomurales";
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
        if ($param1 == "marcas")
            $title.=" - Listado de Marcas";
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
        $this->data['title'] = $title . " - " . $categ . $estilo . $color." - ";
        $this->data['description'] = $description;

        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);
        $this->load->view('frontend/header', $this->data);
        if ($param1 == "marcas")
            $this->load->view('frontend/fabricantes', $this->data);
        else if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {
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

            if (count($this->data['donde']) == 0)
                $this->load->view('frontend/slider2', $this->data);

            $this->load->view('frontend/cuerposeccion', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function alfombras($param1 = "") {
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
            case 1: $categ = "Fotomurales";
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
        if ($param1 == "marcas")
            $title.=" - Listado de Marcas";
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
        $this->data['title'] = $title . " - " . $categ . $estilo . $color." - ";
        $this->data['description'] = $description;

        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);
        $this->load->view('frontend/header', $this->data);
        if ($param1 == "marcas")
            $this->load->view('frontend/fabricantes', $this->data);
        else if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {
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

            if (count($this->data['donde']) == 0)
                $this->load->view('frontend/slider2', $this->data);

            $this->load->view('frontend/cuerposeccion', $this->data);
        }
        $this->load->view('frontend/footer', $this->data);
    }

    function herramientas($param1 = "") {
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

        if (count($this->data['donde']) == 0)
            $this->load->view('frontend/slider2', $this->data);

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

    function marcas($param1 = "") {
        $this->data['donde'] = $this->uri->uri_to_assoc(3);
        $this->data['donden'] = array();
        $this->data['donden']['marca'] = null;
        $this->data['categ'] = -1;
        $econ = 0;
// introducir aqui el contenido a mostrar en los metas
//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
        $title = "";
        $description = "";
        $keywords = "";
// NO TOCAR A PARTIR DE AQUI      
        $estilo = "";
        $color = "";
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
        if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {
                $this->data['cole'] = $this->uri->segment(6);
            } else {
                $this->data['fab'] = $this->flexi_cart_model->get_fab($this->uri->segment(4));
            }
        }
        if (!isset($this->data['donde']['marca']))
            $title.=" - Listado de Marcas";
        else if (isset($this->data['donde']['marca'])) {
            if (isset($this->data['fab']) && $this->data['fab'] != null) {
                $title=ucwords(str_replace('-', ' ', str_replace('-and-', ' & ', rawurldecode($this->uri->segment(5)))));
                $image = base_url() . "includes/images/logos/" . $this->data['donde']['marca'] . ".jpg";
            }
            if ($this->uri->segment(6)) {

                $coleccion = $this->flexi_cart_model->get_coleccion($this->uri->segment(6));
                $c = $coleccion[0];
                $image = base_url() . "includes/" . str_replace("../", "", $c->col_ambimg);
                $image2 = base_url() . "includes/" . str_replace("../", "", $c->col_img) . "th.jpg";
                $title=ucwords(str_replace('-', ' ', rawurldecode($this->uri->segment(7))))." - ".$title;
            }
        }
        $this->data['title'] =$title. " - ";
        $this->data['description'] = $description;
        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2);

        $this->load->view('frontend/header', $this->data);
        if (!isset($this->data['donde']['marca']) || $param1 != "marcas") {

            $this->data['col'] = $this->flexi_cart_model->get_col_array();
        }
        if (isset($this->data['donde']['marca'])) {
            if ($this->uri->segment(6)) {

                $this->data['cole'] = $this->uri->segment(6);
                $this->data['gama'] = $this->flexi_cart_model->get_gamas();
                $this->data['estilo'] = $this->flexi_cart_model->get_estilos();
                $this->data['all'] = $this->flexi_cart_model->get_items_cole($this->uri->segment(6));
                //   $this->load->view('frontend/fichamarca', $this->data);
                $this->load->view('frontend/cuerposeccion', $this->data);
            } else {
                $this->data['fab'] = $this->flexi_cart_model->get_fab($this->uri->segment(4));
                $this->data['col'] = $this->flexi_cart_model->get_col($this->uri->segment(4), $this->data['categ']);
                $this->load->view('frontend/fabricanteficha', $this->data);
            }
        } else
            $this->fabricantes(-1);
        $this->load->view('frontend/footer', $this->data);
    }

    function no_encontrado() {
        $this->load->view('frontend/header', $this->data);
        $this->load->view('frontend/noencontrado', $this->data);
        $this->load->view('frontend/footer', $this->data);
    }

    function articulo() {
        $keywords = "";
        $this->data['keywords'] = "";
        $array = $this->uri->uri_to_assoc(3);
        $this->data['categ'] = 0;
        if (isset($array["Herramientas"]))
            $this->data['categ'] = 5;
        $this->data['key'] = $this->flexi_cart_model->get_item($array['id'], $this->data['categ']);
        
        if (empty($this->data['key']))
            redirect("tienda/no_encontrado");
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
            case 0: $categ = "Papel Pintado";
                break;
            case 1: $categ = "Fotomurales";
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
        $this->data['title'] = (($this->data['key']['item_tipo'] != 5) ? ($this->data['key']['cat_name'] . " - " . $this->data['key']['coleccion_name']) : $this->data['key']['item_name']) . " - " . $this->data['key']['item_ref'];
        $this->data['title'] .=" - " . $categ . " - ";
        $this->data['description'] = html_entity_decode(($this->data['key']['item_tipo'] == 5) ? strip_tags($this->data['key']['item_text']) : strip_tags($this->data['key']['col_text']), ENT_COMPAT, 'UTF-8');
        $image2 = base_url() . "includes/" . str_replace("../", "", $this->data['key']['imgamb']) . "med.jpg";
        $image = base_url() . "includes/" . str_replace("../", "", $this->data['key']['img']) . "med.jpg";
        $articulo = array("precio" => $this->data['key']['item_price']);
        $this->data['extrameta'] = $this->extrameta($this->data['title'], $this->data['description'], $image, $image2, $articulo);

        $this->load->view('frontend/header', $this->data);
        $this->load->view('frontend/articulo', $this->data);
        $this->load->view('frontend/footer', $this->data);
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

        $this->load->view('demo/cart_view', $this->data);
        // $this->load->view('demo/tienda', $this->data);
    }
    /*function carrito_eneko() {
        $this->view_cart_eneko();
    }

    function view_cart_eneko() {
    	
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
	print '<pre><xmp>';
	print_r($this->data['cart_items']);
	print '</xmp></pre>';
	exit;

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
        
        ###+++++++++++++++++++++++++++++++++###
        // Get any status message that may have been set.
        $this->data['message'] = $this->session->flashdata('message');

        $this->load->view('demo/cart_view', $this->data);
        // $this->load->view('demo/tienda', $this->data);
    }*/

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

        // The 'update_discount_codes()' function will validate each submitted code and apply the discounts that have activated their quantity and value requirements.
        // Any previously set codes that have now been set as blank (i.e. no longer present) will be removed.
        // Note: Only 1 discount can be applied per item and per summary column. 
        // For example, 2 discounts cannot be applied to the summary total, but 1 discount could be applied to the shipping total, and another to the summary total.
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
    function checkout() {
        $this->load->model('demo_cart_model');

        // Check whether the cart is empty using the 'cart_status()' function and redirect the user away if necessary.
        if (!$this->flexi_cart->cart_status()) {
            $this->flexi_cart->set_error_message('You must add an item to the cart before you can checkout.', 'public');

            // Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

            redirect('tienda/view_cart');
        }

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
                // Attach the saved order number to the redirect url.
                redirect('tienda/checkout_compra_ya/' . $this->flexi_cart->order_number());
            }
        }

        // Get all countries to list via a select menu as countries the user can be 'Billed to'.
        // In this example, the 'Shipped to' country is fixed by the shipping location and option they selected via the 'View Cart' page.
        $sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name'));
        $this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);

        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

        $this->load->view('demo/checkout_view', $this->data);
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

    function checkout_compra_ya($order_number = FALSE, $pasarela = FALSE, $prueba=FALSE) {
        // Note: This example uses the 'get_db_order_summary_row_array()' and 'update_db_order_summary()' function which are located in the flexi cart ADMIN library.

        $this->load->library('flexi_cart_admin');

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
                    '&LOGOIMG=http://www.depapelpintado.es/includes/images/img-depapelpintado.png' . //site logo
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
        $this->load->view('demo/checkout_compra_ya', $this->data);
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
                    // $this->flexi_cart_admin->email_order($this->data['order_number'], array('pagos@depapelpintado.es', $this->data['user_email']), 'Su pedido ha sido procesado correctamente.');
                    $this->flexi_cart->destroy_cart();
                    $this->data['msg'] = "Su pedido se ha procesado correctamente";
                    $this->data['ecommerce'] = $this->getecommerce($order_number);
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
				}
            }
        }

        // Destroy the cart.
        // Note: once checkout is complete, it is better to use the 'destroy_cart()' function rather than 'empty_cart()' to ensure all session data from the
        // now completed order is removed, rather than just removing the items in the cart.
        else
            $this->data['msg'] = "Se ha producido un error en el pago";
        
        if($this->data['status']==2){
            $this->data['msg'] = "El pago de su pedido se ha realizado correctamente.";
            $this->flexi_cart->destroy_cart();
        }
		elseif($this->data['status']>2){
            $this->data['msg'] = "El pago de su pedido ya se realizó correctamente.";
            $this->flexi_cart->destroy_cart();
        }
        else{
            $this->data['msg'] = "Se ha producido un error en el pago";
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

    private function mini_cart_data() {
        $this->data['mini_cart_items'] = $this->flexi_cart->cart_items();
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

}

/* End of tienda.php */
/* Location: ./application/controllers/tienda.php */
