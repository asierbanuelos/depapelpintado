<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contacto extends CI_Controller {
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
	public function index($txt_consulta=''){
		// introducir aqui el contenido a mostrar en los metas
		//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
		$title="";
		$description="";
		
		$recaptcha_v3=new stdClass;
		$recaptcha_v3->aktibaturik=true;
		$recaptcha_v3->action='kontaktu_mezua';
		$recaptcha_v3->form_id='#kontaktu-formularioa';

		$this->data['recaptcha_v3']=$recaptcha_v3;

		// NO TOCAR A PARTIR DE AQUI 
        $this->data['meta_title']='Contacta con nosotros - De Papel Pintado'; 
        $this->data['meta_description']='Llámanos o déjanos un mensaje y te contestaremos con la mayor brevedad posible.'; 
		$this->load->view('frontend/header', $this->data);

		//~ if($this->input->post("enviar")!==false){
		if($this->input->post("token")){
			$captcha_balidazioa=$this->captcha_v3_balidatu();
			//~ $captcha_balidazioa->score=0.3;
			/*
			print '<pre><xmp>';
			print_r($_POST);
			print '</xmp></pre>';
			print '<pre><xmp>';
			print_r($_FILES);
			print '</xmp></pre>';
			exit;
			*/
			if ($captcha_balidazioa->success){
				$this->load->library('email');
				$config['mailtype'] = "html";

				$this->email->initialize($config);
				$this->email->from('noreply@depapelpintado.es', 'Formulario');
				$this->email->to('info@depapelpintado.es');
				$this->email->bcc('enanclares77@gmail.com');
				//$this->email->to('enanclares77@gmail.com');
				
				$mezu_originala="Nombre: ".$this->input->post("i-name").
								"<br>Email: ".$this->input->post("i-email").
								"<br>Mensaje: ".$this->input->post("message");
				
				
				if ($captcha_balidazioa->score >=0.5){
					//$this->email->subject($this->input->post("asunto"));
					$this->email->subject('Contacto: '.$this->input->post("i-tema"));
					$this->email->message($mezu_originala);
				}
				else{
					$this->email->subject('[Consulta sospechosa] '.$this->input->post("i-tema"));
					$mezua="<p>Un usuario calificado por el sistema de Google como sospechoso ha realizado una consulta.</p>";
					$mezua.="<p>La fiabilidad se calcula en valores entre 0 y 1. Mediante programación se envía este mail especial a los que obtienen menos de 0.5 para comprobar si el criterio es correcto o si hubiera que modificarlo.</p>";
					$mezua.="<p>";
					$mezua.="<strong>Usuario de la consulta:</strong> ".$this->input->post('nombre')."<br />";
					$mezua.="<strong>Fiabilidad del usuario:</strong> ".$captcha_balidazioa->score."<br />";
					$mezua.="</p>";
					$mezua.="<p>";
					$mezua.=$mezu_originala;
					$mezua.="</p>";
					
					$this->email->message($mezua);
				}
				if (isset($_FILES['fileUpload']['tmp_name'])){
					//$resume_tmp_path = $_FILES['fileUpload']['tmp_name'].'/'.$_FILES['fileUpload']['name'];
					//$this->email->attach($resume_tmp_path);	

					$this->email->attach($_FILES['fileUpload']['tmp_name'], '', $_FILES['fileUpload']['name']);		
				}

				$this->email->send();

				/*
				print '<pre><xmp>';
				print_r($this->email);
				print '</xmp></pre>';
				exit;
				*/
			}
			/*
			print '<pre><xmp>';
			print_r($captcha_balidazioa);
			print '</xmp></pre>';
			exit;
			*/
		}
		if(trim($txt_consulta)!='')
			$txt_consulta='Información sobre '.$this->urldec_aux($txt_consulta);
        $this->data['txt_consulta']=$txt_consulta;
        $this->data['a_migas']['/contacto']='Contacto';
	    $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);

		$this->load->view('frontend/contacto-2');
        $this->data['includes_footer'][]='<script src="/includes/js/contacto.js"></script>';            
        $this->data['recaptcha_v3']=$recaptcha_v3;            
		$this->load->view('frontend/footer',$this->data);
	}
	function urldec_aux($str){
		return str_replace('-',' ',str_replace('-plus-','+',str_replace('-and-',' & ',rawurldecode($str))));
	}

	public function index_original(){
		// introducir aqui el contenido a mostrar en los metas
		//  para el titulo sigue este formato: "Papelpintado %title% - %color estilo y demas%"
		$title="";
		$description="";
		
		$recaptcha_v3=new stdClass;
		$recaptcha_v3->aktibaturik=true;
		$recaptcha_v3->action='kontaktu_mezua';
		$recaptcha_v3->form_id='#kontaktu-formularioa';

		$this->data['recaptcha_v3']=$recaptcha_v3;

		// NO TOCAR A PARTIR DE AQUI 
		$this->data['title']=" - ". $title;
		$this->data['description']= $description;
		$this->load->view('frontend/header', $this->data);

		//~ if($this->input->post("enviar")!==false){
		if($this->input->post("token")){
			$captcha_balidazioa=$this->captcha_v3_balidatu();
			//~ $captcha_balidazioa->score=0.3;
			/*
			print '<pre><xmp>';
			print_r($_POST);
			print '</xmp></pre>';
			print '<pre><xmp>';
			print_r($_FILES);
			print '</xmp></pre>';
			exit;
			*/
			if ($captcha_balidazioa->success){
				$this->load->library('email');
				$config['mailtype'] = "html";

				$this->email->initialize($config);
				$this->email->from('noreply@depapelpintado.es', 'Formulario');
				$this->email->to('info@depapelpintado.es');
				//$this->email->bcc('enanclares77@gmail.com');

				$mezu_originala="Nombre: ".$this->input->post("i-ape")." ".$this->input->post("i-name").
								"<br>Email: ".$this->input->post("i-email")."<br>Teléfono: ".$this->input->post("i-tel").
								"<br>Mensaje: ".$this->input->post("message");
				
				
				if ($captcha_balidazioa->score >=0.5){
					//$this->email->subject($this->input->post("asunto"));
					$this->email->subject('Contacto');
					$this->email->message($mezu_originala);
				}
				else{
					$this->email->subject('[Consulta sospechosa] '.$this->input->post("asunto"));
					$mezua="<p>Un usuario calificado por el sistema de Google como sospechoso ha realizado una consulta.</p>";
					$mezua.="<p>La fiabilidad se calcula en valores entre 0 y 1. Mediante programación se envía este mail especial a los que obtienen menos de 0.5 para comprobar si el criterio es correcto o si hubiera que modificarlo.</p>";
					$mezua.="<p>";
					$mezua.="<strong>Usuario de la consulta:</strong> ".$this->input->post('nombre')."<br />";
					$mezua.="<strong>Fiabilidad del usuario:</strong> ".$captcha_balidazioa->score."<br />";
					$mezua.="</p>";
					$mezua.="<p>";
					$mezua.=$mezu_originala;
					$mezua.="</p>";
					
					$this->email->message($mezua);
				}
				$this->email->send();

				/*
				print '<pre><xmp>';
				print_r($this->email);
				print '</xmp></pre>';
				exit;
				*/
			}
			/*
			print '<pre><xmp>';
			print_r($captcha_balidazioa);
			print '</xmp></pre>';
			exit;
			*/
		}

        $this->data['a_migas']['/contacto']='Contacto';
	    $this->load->view('frontend/migas_nuevas_img_fondo', $this->data);

		$this->load->view('frontend/contacto');
		$this->load->view('frontend/footer',array('recaptcha_v3'=>$recaptcha_v3));
	}

	function captcha_v3_balidatu(){
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
}
