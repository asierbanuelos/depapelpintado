<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Santos_Monteiro_model extends CI_Model{
	public function __construct() {}
    
  public function get_datos_acabados(){
    $acabados=$this->db->select("*",FALSE)
    ->from('santos_monteiro_acabado')
    ->where('activo_be',1)
    ->order_by('orden','asc')
    ->get()->result();
    
    $a_acabados=array();
    foreach ($acabados as $item){
      $a_acabados[$item->idsantos_monteiro_acabado]=$item;
    }

    return $a_acabados;
  }


  public function get_precio_base($idcoleccion=0){
    // Cogemos el precio 'sin acabado'
    $temp=$this->db->select("*",FALSE);
    $temp->from('santos_monteiro_acabado_precio');
    
    $temp->where('idsantos_monteiro_acabado',1);
    $temp->where('idcoleccion',$idcoleccion);

    $precios=$temp->get()->result();
    
    $a_precios=array();
    foreach ($precios as $item){
      $a_precios['precio_m_cuadrado']=$item->precio_m_cuadrado;
      $a_precios['precio_m_cuadrado_exacto']=$item->precio_m_cuadrado_exacto;
    }
    
    return $a_precios;
  } 

  
  public function get_precios_acabados($idcoleccion=0){
    $temp=$this->db->select("*",FALSE);
    $temp->from('santos_monteiro_acabado_precio');
    $temp->join('santos_monteiro_acabado', 'santos_monteiro_acabado_precio.idsantos_monteiro_acabado = santos_monteiro_acabado.idsantos_monteiro_acabado');
    
    if ($idcoleccion!=0)
      $temp->where('idcoleccion',$idcoleccion);

    $temp->order_by('orden','asc');

    $precios=$temp->get()->result();
    
    $a_precios=array();
    foreach ($precios as $item){
      $idcoleccion=$item->idcoleccion;
      $idacabado=$item->idsantos_monteiro_acabado;
      $idprecio=$item->idsantos_monteiro_acabado_precio;
      $a_precios[$idcoleccion][$idacabado]=$item;
    }
    
    if ($idcoleccion!=0)
      return $a_precios[$idcoleccion];
    else
      return $a_precios;
  } 

  public function get_opciones_from_array(){
    $a_opciones['bay']['BAY 001']='/includes/images/acabados-santos-monteiro/bay/001.jpg';
    $a_opciones['bay']['BAY 002']='/includes/images/acabados-santos-monteiro/bay/002.jpg';
    $a_opciones['bay']['BAY 003']='/includes/images/acabados-santos-monteiro/bay/003.jpg';
    $a_opciones['bay']['BAY 004']='/includes/images/acabados-santos-monteiro/bay/004.jpg';
    $a_opciones['bay']['BAY 005']='/includes/images/acabados-santos-monteiro/bay/005.jpg';
    $a_opciones['bay']['BAY 006']='/includes/images/acabados-santos-monteiro/bay/006.jpg';
    $a_opciones['bay']['BAY 007']='/includes/images/acabados-santos-monteiro/bay/007.jpg';
    $a_opciones['bay']['BAY 008']='/includes/images/acabados-santos-monteiro/bay/008.jpg';
    $a_opciones['bay']['BAY 009']='/includes/images/acabados-santos-monteiro/bay/009.jpg';

    $a_opciones['burel']['BUREL 100']='/includes/images/acabados-santos-monteiro/burel/100.jpg';
    $a_opciones['burel']['BUREL 101']='/includes/images/acabados-santos-monteiro/burel/101.jpg';
    $a_opciones['burel']['BUREL 102']='/includes/images/acabados-santos-monteiro/burel/102.jpg';
    $a_opciones['burel']['BUREL 200']='/includes/images/acabados-santos-monteiro/burel/200.jpg';
    $a_opciones['burel']['BUREL 201']='/includes/images/acabados-santos-monteiro/burel/201.jpg';
    $a_opciones['burel']['BUREL 202']='/includes/images/acabados-santos-monteiro/burel/202.jpg';
    $a_opciones['burel']['BUREL 203']='/includes/images/acabados-santos-monteiro/burel/203.jpg';
    $a_opciones['burel']['BUREL 204']='/includes/images/acabados-santos-monteiro/burel/204.jpg';
    $a_opciones['burel']['BUREL 300']='/includes/images/acabados-santos-monteiro/burel/300.jpg';
    $a_opciones['burel']['BUREL 301']='/includes/images/acabados-santos-monteiro/burel/301.jpg';

    $a_opciones['color']['COLOR 437']='/includes/images/acabados-santos-monteiro/color/437.jpg';
    $a_opciones['color']['COLOR 337']='/includes/images/acabados-santos-monteiro/color/337.jpg';
    $a_opciones['color']['COLOR 338']='/includes/images/acabados-santos-monteiro/color/338.jpg';
    $a_opciones['color']['COLOR 006']='/includes/images/acabados-santos-monteiro/color/006.jpg';
    $a_opciones['color']['COLOR 111']='/includes/images/acabados-santos-monteiro/color/111.jpg';
    $a_opciones['color']['COLOR 517']='/includes/images/acabados-santos-monteiro/color/517.jpg';
    $a_opciones['color']['COLOR 097']='/includes/images/acabados-santos-monteiro/color/097.jpg';
    $a_opciones['color']['COLOR 232']='/includes/images/acabados-santos-monteiro/color/232.jpg';
    $a_opciones['color']['COLOR 378']='/includes/images/acabados-santos-monteiro/color/378.jpg';
    $a_opciones['color']['COLOR 516']='/includes/images/acabados-santos-monteiro/color/516.jpg';
    $a_opciones['color']['COLOR 013']='/includes/images/acabados-santos-monteiro/color/013.jpg';
    $a_opciones['color']['COLOR 617']='/includes/images/acabados-santos-monteiro/color/617.jpg';
    $a_opciones['color']['COLOR 079']='/includes/images/acabados-santos-monteiro/color/079.jpg';
    $a_opciones['color']['COLOR 585']='/includes/images/acabados-santos-monteiro/color/585.jpg';
    $a_opciones['color']['COLOR 438']='/includes/images/acabados-santos-monteiro/color/438.jpg';
    $a_opciones['color']['COLOR 060']='/includes/images/acabados-santos-monteiro/color/060.jpg';
    $a_opciones['color']['COLOR 038']='/includes/images/acabados-santos-monteiro/color/038.jpg';
    $a_opciones['color']['COLOR 101']='/includes/images/acabados-santos-monteiro/color/101.jpg';
    $a_opciones['color']['COLOR 001']='/includes/images/acabados-santos-monteiro/color/001.jpg';
    $a_opciones['color']['COLOR 075']='/includes/images/acabados-santos-monteiro/color/075.jpg';
    $a_opciones['color']['COLOR 047']='/includes/images/acabados-santos-monteiro/color/047.jpg';
    $a_opciones['color']['COLOR 016']='/includes/images/acabados-santos-monteiro/color/016.jpg';
    $a_opciones['color']['COLOR 037']='/includes/images/acabados-santos-monteiro/color/037.jpg';
    $a_opciones['color']['COLOR 231']='/includes/images/acabados-santos-monteiro/color/231.jpg';
    $a_opciones['color']['COLOR 124']='/includes/images/acabados-santos-monteiro/color/124.jpg';
    $a_opciones['color']['COLOR 115']='/includes/images/acabados-santos-monteiro/color/115.jpg';
    $a_opciones['color']['COLOR 027']='/includes/images/acabados-santos-monteiro/color/027.jpg';
    $a_opciones['color']['COLOR 025']='/includes/images/acabados-santos-monteiro/color/025.jpg';
    $a_opciones['color']['COLOR 076']='/includes/images/acabados-santos-monteiro/color/076.jpg';
    $a_opciones['color']['COLOR 030']='/includes/images/acabados-santos-monteiro/color/030.jpg';
    $a_opciones['color']['COLOR 056']='/includes/images/acabados-santos-monteiro/color/056.jpg';

    $a_opciones['dune']['DUNE 500']='/includes/images/acabados-santos-monteiro/dune/500.jpg';
    $a_opciones['dune']['DUNE 150']='/includes/images/acabados-santos-monteiro/dune/150.jpg';
    $a_opciones['dune']['DUNE 126']='/includes/images/acabados-santos-monteiro/dune/126.jpg';
    $a_opciones['dune']['DUNE 125']='/includes/images/acabados-santos-monteiro/dune/125.jpg';
    $a_opciones['dune']['DUNE 067']='/includes/images/acabados-santos-monteiro/dune/067.jpg';
    $a_opciones['dune']['DUNE 051']='/includes/images/acabados-santos-monteiro/dune/051.jpg';
    $a_opciones['dune']['DUNE 180']='/includes/images/acabados-santos-monteiro/dune/180.jpg';
    $a_opciones['dune']['DUNE 84']='/includes/images/acabados-santos-monteiro/dune/84.jpg';
    $a_opciones['dune']['DUNE 224']='/includes/images/acabados-santos-monteiro/dune/224.jpg';
    $a_opciones['dune']['DUNE 201']='/includes/images/acabados-santos-monteiro/dune/201.jpg';
    $a_opciones['dune']['DUNE 181']='/includes/images/acabados-santos-monteiro/dune/181.jpg';
    $a_opciones['dune']['DUNE 821']='/includes/images/acabados-santos-monteiro/dune/821.jpg';
    $a_opciones['dune']['DUNE 901']='/includes/images/acabados-santos-monteiro/dune/901.jpg';
    $a_opciones['dune']['DUNE 812']='/includes/images/acabados-santos-monteiro/dune/812.jpg';
    $a_opciones['dune']['DUNE 072']='/includes/images/acabados-santos-monteiro/dune/072.jpg';
    $a_opciones['dune']['DUNE 071']='/includes/images/acabados-santos-monteiro/dune/071.jpg';
    $a_opciones['dune']['DUNE 151']='/includes/images/acabados-santos-monteiro/dune/151.jpg';
    $a_opciones['dune']['DUNE 078']='/includes/images/acabados-santos-monteiro/dune/078.jpg';
    $a_opciones['dune']['DUNE 405']='/includes/images/acabados-santos-monteiro/dune/405.jpg';
    $a_opciones['dune']['DUNE 700']='/includes/images/acabados-santos-monteiro/dune/700.jpg';
    $a_opciones['dune']['DUNE 941']='/includes/images/acabados-santos-monteiro/dune/941.jpg';
    $a_opciones['dune']['DUNE 475']='/includes/images/acabados-santos-monteiro/dune/475.jpg';
    $a_opciones['dune']['DUNE 470']='/includes/images/acabados-santos-monteiro/dune/470.jpg';
    $a_opciones['dune']['DUNE 421']='/includes/images/acabados-santos-monteiro/dune/421.jpg';

    $a_opciones['easy']['EASY 361']='/includes/images/acabados-santos-monteiro/easy/361.jpg';
    $a_opciones['easy']['EASY 369']='/includes/images/acabados-santos-monteiro/easy/369.jpg';
    $a_opciones['easy']['EASY 327']='/includes/images/acabados-santos-monteiro/easy/327.jpg';
    $a_opciones['easy']['EASY 300']='/includes/images/acabados-santos-monteiro/easy/300.jpg';
    $a_opciones['easy']['EASY 304']='/includes/images/acabados-santos-monteiro/easy/304.jpg';
    $a_opciones['easy']['EASY 305']='/includes/images/acabados-santos-monteiro/easy/305.jpg';
    $a_opciones['easy']['EASY 315']='/includes/images/acabados-santos-monteiro/easy/315.jpg';
    $a_opciones['easy']['EASY 323']='/includes/images/acabados-santos-monteiro/easy/323.jpg';
    $a_opciones['easy']['EASY 341']='/includes/images/acabados-santos-monteiro/easy/341.jpg';
    $a_opciones['easy']['EASY 387']='/includes/images/acabados-santos-monteiro/easy/387.jpg';
    $a_opciones['easy']['EASY 306']='/includes/images/acabados-santos-monteiro/easy/306.jpg';
    $a_opciones['easy']['EASY 385']='/includes/images/acabados-santos-monteiro/easy/385.jpg';
    $a_opciones['easy']['EASY 390']='/includes/images/acabados-santos-monteiro/easy/390.jpg';

    $a_opciones['veneza']['VENEZA 0645']='/includes/images/acabados-santos-monteiro/veneza/0645.jpg';
    $a_opciones['veneza']['VENEZA 1019']='/includes/images/acabados-santos-monteiro/veneza/1019.jpg';
    $a_opciones['veneza']['VENEZA 1091']='/includes/images/acabados-santos-monteiro/veneza/1091.jpg';
    $a_opciones['veneza']['VENEZA 0835']='/includes/images/acabados-santos-monteiro/veneza/0835.jpg';
    $a_opciones['veneza']['VENEZA 0635']='/includes/images/acabados-santos-monteiro/veneza/0635.jpg';
    $a_opciones['veneza']['VENEZA 0647']='/includes/images/acabados-santos-monteiro/veneza/0647.jpg';
    $a_opciones['veneza']['VENEZA 0636']='/includes/images/acabados-santos-monteiro/veneza/0636.jpg';
    $a_opciones['veneza']['VENEZA 0644']='/includes/images/acabados-santos-monteiro/veneza/0644.jpg';
    $a_opciones['veneza']['VENEZA 0638']='/includes/images/acabados-santos-monteiro/veneza/0638.jpg';
    $a_opciones['veneza']['VENEZA 0641']='/includes/images/acabados-santos-monteiro/veneza/0641.jpg';
    $a_opciones['veneza']['VENEZA 0679']='/includes/images/acabados-santos-monteiro/veneza/0679.jpg';
    $a_opciones['veneza']['VENEZA 0642']='/includes/images/acabados-santos-monteiro/veneza/0642.jpg';
    $a_opciones['veneza']['VENEZA 0676']='/includes/images/acabados-santos-monteiro/veneza/0676.jpg';
    $a_opciones['veneza']['VENEZA 0643']='/includes/images/acabados-santos-monteiro/veneza/0643.jpg';

    $a_opciones['franja']['FRANJA 01']='/includes/images/acabados-santos-monteiro/franja/01.jpg';
    $a_opciones['franja']['FRANJA 02']='/includes/images/acabados-santos-monteiro/franja/02.jpg';
    $a_opciones['franja']['FRANJA 03']='/includes/images/acabados-santos-monteiro/franja/03.jpg';
    $a_opciones['franja']['FRANJA 04']='/includes/images/acabados-santos-monteiro/franja/04.jpg';
    $a_opciones['franja']['FRANJA 05']='/includes/images/acabados-santos-monteiro/franja/05.jpg';
    $a_opciones['franja']['FRANJA 06']='/includes/images/acabados-santos-monteiro/franja/06.jpg';
    $a_opciones['franja']['FRANJA 07']='/includes/images/acabados-santos-monteiro/franja/07.jpg';
    $a_opciones['franja']['FRANJA 08']='/includes/images/acabados-santos-monteiro/franja/08.jpg';
    $a_opciones['franja']['FRANJA 09']='/includes/images/acabados-santos-monteiro/franja/09.jpg';
    $a_opciones['franja']['FRANJA 10']='/includes/images/acabados-santos-monteiro/franja/10.jpg';
    $a_opciones['franja']['FRANJA 11']='/includes/images/acabados-santos-monteiro/franja/11.jpg';
    $a_opciones['franja']['FRANJA 12']='/includes/images/acabados-santos-monteiro/franja/12.jpg';
    $a_opciones['franja']['FRANJA 13']='/includes/images/acabados-santos-monteiro/franja/13.jpg';
    $a_opciones['franja']['FRANJA 14']='/includes/images/acabados-santos-monteiro/franja/14.jpg';
    $a_opciones['franja']['FRANJA 15']='/includes/images/acabados-santos-monteiro/franja/15.jpg';

    $a_opciones['fresh']['FRESH 157']='/includes/images/acabados-santos-monteiro/fresh/157.jpg';
    $a_opciones['fresh']['FRESH 489']='/includes/images/acabados-santos-monteiro/fresh/489.jpg';
    $a_opciones['fresh']['FRESH 326']='/includes/images/acabados-santos-monteiro/fresh/326.jpg';
    $a_opciones['fresh']['FRESH 437']='/includes/images/acabados-santos-monteiro/fresh/437.jpg';
    $a_opciones['fresh']['FRESH 438']='/includes/images/acabados-santos-monteiro/fresh/438.jpg';
    $a_opciones['fresh']['FRESH 260']='/includes/images/acabados-santos-monteiro/fresh/260.jpg';
    $a_opciones['fresh']['FRESH 378']='/includes/images/acabados-santos-monteiro/fresh/378.jpg';
    $a_opciones['fresh']['FRESH 323']='/includes/images/acabados-santos-monteiro/fresh/323.jpg';
    $a_opciones['fresh']['FRESH 003']='/includes/images/acabados-santos-monteiro/fresh/003.jpg';
    $a_opciones['fresh']['FRESH 504']='/includes/images/acabados-santos-monteiro/fresh/504.jpg';
    $a_opciones['fresh']['FRESH 537']='/includes/images/acabados-santos-monteiro/fresh/537.jpg';
    $a_opciones['fresh']['FRESH 538']='/includes/images/acabados-santos-monteiro/fresh/538.jpg';
    $a_opciones['fresh']['FRESH 539']='/includes/images/acabados-santos-monteiro/fresh/539.jpg';
    $a_opciones['fresh']['FRESH 261']='/includes/images/acabados-santos-monteiro/fresh/261.jpg';
    $a_opciones['fresh']['FRESH 217']='/includes/images/acabados-santos-monteiro/fresh/217.jpg';
    $a_opciones['fresh']['FRESH 700']='/includes/images/acabados-santos-monteiro/fresh/700.jpg';

    $a_opciones['reef']['REEF 01']='/includes/images/acabados-santos-monteiro/reef/01.jpg';
    $a_opciones['reef']['REEF 02']='/includes/images/acabados-santos-monteiro/reef/02.jpg';
    $a_opciones['reef']['REEF 03']='/includes/images/acabados-santos-monteiro/reef/03.jpg';
    $a_opciones['reef']['REEF 04']='/includes/images/acabados-santos-monteiro/reef/04.jpg';
    $a_opciones['reef']['REEF 05']='/includes/images/acabados-santos-monteiro/reef/05.jpg';
    $a_opciones['reef']['REEF 06']='/includes/images/acabados-santos-monteiro/reef/06.jpg';
    $a_opciones['reef']['REEF 07']='/includes/images/acabados-santos-monteiro/reef/07.jpg';
    $a_opciones['reef']['REEF 08']='/includes/images/acabados-santos-monteiro/reef/08.jpg';
    $a_opciones['reef']['REEF 09']='/includes/images/acabados-santos-monteiro/reef/09.jpg';
    $a_opciones['reef']['REEF 10']='/includes/images/acabados-santos-monteiro/reef/10.jpg';
    $a_opciones['reef']['REEF 11']='/includes/images/acabados-santos-monteiro/reef/11.jpg';
    $a_opciones['reef']['REEF 12']='/includes/images/acabados-santos-monteiro/reef/12.jpg';
    $a_opciones['reef']['REEF 13']='/includes/images/acabados-santos-monteiro/reef/13.jpg';
    $a_opciones['reef']['REEF 14']='/includes/images/acabados-santos-monteiro/reef/14.jpg';
    $a_opciones['reef']['REEF 15']='/includes/images/acabados-santos-monteiro/reef/15.jpg';
    $a_opciones['reef']['REEF 16']='/includes/images/acabados-santos-monteiro/reef/16.jpg';
    $a_opciones['reef']['REEF 17']='/includes/images/acabados-santos-monteiro/reef/17.jpg';
    $a_opciones['reef']['REEF 18']='/includes/images/acabados-santos-monteiro/reef/18.jpg';

    $a_opciones['twill']['TWILL 101']='/includes/images/acabados-santos-monteiro/twill/twill-101.jpg';
    $a_opciones['twill']['TWILL 102']='/includes/images/acabados-santos-monteiro/twill/twill-102.jpg';
    $a_opciones['twill']['TWILL 105']='/includes/images/acabados-santos-monteiro/twill/twill-105.jpg';
    $a_opciones['twill']['TWILL 111']='/includes/images/acabados-santos-monteiro/twill/twill-111.jpg';
    $a_opciones['twill']['TWILL 119']='/includes/images/acabados-santos-monteiro/twill/twill-119.jpg';
    $a_opciones['twill']['TWILL 122']='/includes/images/acabados-santos-monteiro/twill/twill-122.jpg';
    $a_opciones['twill']['TWILL 126']='/includes/images/acabados-santos-monteiro/twill/twill-126.jpg';
    $a_opciones['twill']['TWILL 130']='/includes/images/acabados-santos-monteiro/twill/twill-130.jpg';
    $a_opciones['twill']['TWILL 202']='/includes/images/acabados-santos-monteiro/twill/twill-202.jpg';
    $a_opciones['twill']['TWILL 204']='/includes/images/acabados-santos-monteiro/twill/twill-204.jpg';
    $a_opciones['twill']['TWILL 206']='/includes/images/acabados-santos-monteiro/twill/twill-206.jpg';
    $a_opciones['twill']['TWILL 208']='/includes/images/acabados-santos-monteiro/twill/twill-208.jpg';
    
    return $a_opciones;
  }

  /*
    public function set_paypal(){
      $temp =$this->db->where("name","paypal")->update("pagos",array('user'=>$_POST['usr'],'pass'=>$_POST['pass'],'token'=>$_POST['token'],'test'=>$_POST['test'],'test_ip'=>$_POST['test_ip']));
    }

    public function get_promos($left =true, $activos=true){
    	$this->db->cache_on();
      $temp=$this->db->select("*",FALSE);
      $temp->from('contenido');
      if ($left)$temp->where('tipo','Promo Izquierda');
      else $temp->where('tipo','Promo Derecha');
        if($activos)$temp->where('activo',1)->limit(4);
        $temp->order_by('orden','asc');
      $result= $temp->get()->result();
	  $this->db->cache_off();
	  return $result;
    }
    public function get_page($id){
      $this->db->cache_on();
      $temp=$this->db->select("*",FALSE);
      $temp->from('contenido');
      $result=$temp->where('id',$id)->get()->row();
	  $this->db->cache_off();
	  return $result;
    }

	public function get_page_edit($id){
      $temp=$this->db->select("*",FALSE);
      $temp->from('contenido');
      $result=$temp->where('id',$id)->get()->row();
	  return $result;
    }
    public function update_page(){
      $temp=$this->db->where('id',$this->input->post('id'))->update('contenido',$this->input->post(NULL,TRUE));
    }
    public function toogle($id,$activo){
      if($activo==0)$activo=1;
      else $activo=0;
      $data=array('activo'=>$activo);
      $temp=$this->db->where('id',$id)->update('contenido',$data);
    }
    public function del($id){
      $temp=$this->db->where('id',$id)->delete('contenido');
    }
     public function add_promo($left){
      $data=array('titulo'=>"NUEVA",'tipo'=>($left)?'Promo Izquierda':'Promo Derecha');
      $temp=$this->db->insert('contenido',$data);
    }
    public function get_imagenes_front_zona($zona){
      $temp=$this->db->select("*",FALSE);
      $temp->from('contenido');
      $temp->where('tipo','Imagen');
      $temp->where('zona',$zona);
      $temp->where('activo',1);
      
      $temp->order_by('orden','asc');
      $temp->order_by("id DESC");
      
      return $temp->get()->result();
    }
    public function get_imagenes($activos=true, $zona=""){
      $temp=$this->db->select("*",FALSE);
      $temp->from('contenido');
      $temp->where('tipo','Imagen');
        if($activos)$temp->where('activo',1);
        if($zona!=""){
          $temp->like('zona',$zona,"both");
        }
        $temp->order_by('orden','asc');
      $temp->order_by("id DESC");
      return $temp->get()->result();
    }
    public function get_imagenes_admin($activos=true, $zona=""){
      $temp=$this->db->select("*",FALSE);
      $temp->from('contenido');
      $temp->where('tipo','Imagen');
      if($activos)
        $temp->where('activo',1);
      if($zona!=""){
        $temp->like('zona',$zona,"both");
      }

      $temp->order_by('zona','asc');
      $temp->order_by('activo','desc');
      $temp->order_by('orden','asc');
      $temp->order_by("id DESC");
      return $temp->get()->result();
    }
     public function add_image(){
      $data=array('titulo'=>"NUEVA",'tipo'=>'Imagen');
      $temp=$this->db->insert('contenido',$data);
    }
    */ 
}
?>