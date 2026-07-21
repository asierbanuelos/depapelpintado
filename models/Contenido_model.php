<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contenido_model extends CI_Model
{
	public function __construct() {}

    public function get_contents(){
      $temp =$this->db->select("*",FALSE);
      $temp->from('contenido')->order_by("id, ASC");
      $query = $temp->get();
      return $query ? $query->result() : array();
    }
    public function get_paypal(){
      $temp =$this->db->select("*",FALSE);
      $temp->from('pagos')->where("name","paypal");
      $query = $temp->get();
      return $query ? $query->row() : null;
    }
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
      $query = $temp->get();
      $result = $query ? $query->result() : array();
	  $this->db->cache_off();
	  return $result;
    }
    public function get_page($id){
      $this->db->cache_on();
      $temp=$this->db->select("*",FALSE);
      $temp->from('contenido');
      $query = $temp->where('id',$id)->get();
      $result = $query ? $query->row() : null;
	  $this->db->cache_off();
	  return $result;
    }

	public function get_page_edit($id){
      $temp=$this->db->select("*",FALSE);
      $temp->from('contenido');
      $query = $temp->where('id',$id)->get();
      $result = $query ? $query->row() : null;
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

      $query = $temp->get();
      return $query ? $query->result() : array();
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
      $query = $temp->get();
      return $query ? $query->result() : array();
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
      $query = $temp->get();
      return $query ? $query->result() : array();
    }
     public function add_image(){
      $data=array('titulo'=>"NUEVA",'tipo'=>'Imagen');
      $temp=$this->db->insert('contenido',$data);
    }
}
?>
