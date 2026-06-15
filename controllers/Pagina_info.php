<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagina_info extends CI_Controller {
	function __construct(){
		parent::__construct();

		if (1==2){
			$sections = array(
				'benchmarks' => TRUE, 'memory_usage' => TRUE, 
				'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE, 
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

		$this->flexi = new stdClass;

		$this->load->library('flexi_cart');	
		$this->user['user']="admin";
		$this->user['pass']="admin";
		$this->load->vars('base_url', base_url());
		$this->load->vars('includes_dir', base_url().'includes/');
		$this->load->vars('current_url', $this->uri->uri_to_assoc(1));

		$this->data['usuario']=  $this->isLog();
        $this->mini_cart_data();
        $this->data['totalcarro'] = str_replace(array("€", " ", ","), array("", "", "."), $this->flexi_cart->total());

	}
	function isLog(){
		if($this->session->userdata('email')&&$this->session->userdata('logged_in')){
			if($this->db->where('email',$this->session->userdata('email'))->get('users')->num_rows()==1){
				return $this->db->where('email',$this->session->userdata('email'))->get('users')->row();
			}
			else{
				return $this->db->where('user_id',1)->get('users')->row();
			}
		}
		else return $this->db->where('user_id',1)->get('users')->row();
	}

	public function index($url=''){
    switch (trim($url)) {
        case 'quienes-somos':
            $vista='frontend/quienes_somos';
            //$vista='';
	        $this->data['a_migas'][$url]='Quienes somos';
	        $this->data['meta_title']='Quiénes somos De Papel Pintado'; 
	        $this->data['meta_description']='2ª generación familiar en tienda física. Somos cercanos y te asesoramos con capacidades de empatía ayudándote a personalizar tu hogar.'; 
            break;
        case 'ayuda-papel-pintado':
            $vista='frontend/ayuda';
	        $this->data['a_migas'][$url]='Te ayudamos';
	        $this->data['meta_title']='¿Necesitas ayuda con el papel pintado?'; 
	        $this->data['meta_description']='Te ayudamos a resolver tus dudas respecto a preparación, empapelado, tratamiento de problemas...'; 
            break;
        case 'condiciones-de-pago':
            $vista='frontend/condiciones_pago';
	        $this->data['a_migas'][$url]='Condiciones de pago';
	        $this->data['meta_title']='Condiciones de pago - De Papel Pintado'; 
	        $this->data['meta_description']='Consulta nuestras condiciones de pago.'; 
            break;
        case 'condiciones-de-envio':
            $vista='frontend/condiciones_envio';
	        $this->data['a_migas'][$url]='Envío';
	        $this->data['meta_title']='Información sobre envíos - De Papel Pintado'; 
	        $this->data['meta_description']='Consulta nuestras condiciones de envíos.'; 
            break;
        case 'condiciones-de-devoluciones':
            $vista='frontend/condiciones_devolucion';
	        $this->data['a_migas'][$url]='Devoluciones';
	        $this->data['meta_title']='Condiciones de devolución - De Papel Pintado'; 
	        $this->data['meta_description']='Consulta nuestras condiciones de devolución.'; 
            break;
        case 'condiciones-de-uso':
            $vista='frontend/condiciones_uso';
	        $this->data['a_migas'][$url]='Condiciones de uso';
	        $this->data['meta_title']='Condiciones de uso - De Papel Pintado'; 
	        $this->data['meta_description']='Consulta las condiciones de uso del sitio web.'; 
            break;
        case 'politica-de-privacidad':
            $vista='frontend/privacidad';
	        $this->data['a_migas'][$url]='Política de privacidad';
	        $this->data['meta_title']='Política de privacidad - De Papel Pintado'; 
	        $this->data['meta_description']='Consulta nuestra política de privacidad de datos.'; 
            break;
        case 'politica-de-cookies':
            $vista='frontend/cookies';
	        $this->data['a_migas'][$url]='Política de cookies';
	        $this->data['meta_title']='Política de cookies - De Papel Pintado'; 
	        $this->data['meta_description']='Consulta la política de cookies de nuestra web.'; 
            break;
        case 'aviso-legal-formulario':
            $vista='frontend/avisolegal';
	        $this->data['a_migas'][$url]='Aviso Legal';
	        $this->data['meta_title']='Aviso legal y cláusula de protección de datos - De Papel Pintado'; 
	        $this->data['meta_description']='Consulta nuestra política de protección de datos.'; 
            break;
        case 'condiciones-particulares-de-contratacion':
            $vista='frontend/condiciones-particulares-de-contratacion';
	        $this->data['a_migas'][$url]='Condiciones particulares de contratación';
	        $this->data['meta_title']='Condiciones particulares de contratación - De Papel Pintado'; 
	        $this->data['meta_description']='Consulta nuestras condiciones particulares de contratación.'; 
            break;
        case 'politica-de-envio-y-devoluciones':
            $vista='frontend/politica-de-envio-y-devoluciones';
	        $this->data['a_migas'][$url]='Política de envío y devoluciones';
	        $this->data['meta_title']='Política de envío y devoluciones - De Papel Pintado'; 
	        $this->data['meta_description']='Consulta nuestra política de envío y devoluciones.'; 
            break;
        
        case 'contacto':
            $vista='frontend/contacto';
	        $this->data['a_migas'][$url]='Contacto';
            break;

        default:
            echo"Comprobar url:<br />$url";
            $vista='';
            break;
    }

		// introducir aqui el contenido a mostrar en los metas
		//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
		$title="";
		$description="";
		// NO TOCAR A PARTIR DE AQUI 
		$this->data['title']=" - ". $title;
		$this->data['description']= $description;
		$this->load->view('frontend/header', $this->data);
	    $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);
		if (trim($vista)!='')
			$this->load->view($vista);
		$this->load->view('frontend/footer');
	}
    private function mini_cart_data() {
        $this->data['mini_cart_items'] = $this->flexi_cart->cart_items();
        if (isset($this->data['mini_cart_items']) && count($this->data['mini_cart_items'])==0){
            $this->flexi_cart->destroy_cart();
        }
   }


}
?>