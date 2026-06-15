<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class muestras_gratis_de_papel_pintado extends CI_Controller {
function __construct() 
	{
		parent::__construct();

		if (1==2)
		{
			$sections = array(
				'benchmarks' => TRUE, 'memory_usage' => TRUE, 
				'config' => FALSE, 'controller_info' => FALSE, 'get' => FALSE, 'post' => FALSE, 'queries' => FALSE, 
				'uri_string' => FALSE, 'http_headers' => FALSE, 'session_data' => FALSE
			); 
			$this->output->set_profiler_sections($sections);
			$this->output->enable_profiler(TRUE);
		}

		$this->load->database();
		$this->load->library('session');
		$this->load->helper('text');
 		$this->load->helper('url');
 		$this->load->helper('form');
		$this->flexi = new stdClass;

		$this->load->library('flexi_cart');	
        $this->user['user']="admin";
		$this->user['pass']="admin";
		$this->load->vars('base_url', base_url());
		$this->load->vars('includes_dir', base_url().'includes/');
		$this->load->vars('current_url', $this->uri->uri_to_assoc(1));
		$this->mini_cart_data();
	}
	public function index()
	{
// introducir aqui el contenido a mostrar en los metas
//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
            $title="";
            $description="";
// NO TOCAR A PARTIR DE AQUI 
            $this->data['title']=" - ". $title;
            $this->data['description']= $description;
		$this->load->view('frontend/header');
        $this->load->view('frontend/muestras');
        $this->load->view('frontend/footer');
	}
}
