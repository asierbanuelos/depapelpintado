<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class condiciones_de_pago_envios_y_devoluciones extends CI_Controller {
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
        $this->data['usuario']=  $this->isLog();

	}
function isLog(){
        if($this->session->userdata('email')&&$this->session->userdata('logged_in')){
        if($this->db->where('email',$this->session->userdata('email'))->get('users')->num_rows()==1){
          return $this->db->where('email',$this->session->userdata('email'))->get('users')->row();
        }
        else{return $this->db->where('user_id',1)->get('users')->row();}
        }
        else return $this->db->where('user_id',1)->get('users')->row();
    
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
		$this->load->view('frontend/header', $this->data);
        $this->load->view('frontend/condiciones_pago');
        $this->load->view('frontend/footer');
	}
}
?>