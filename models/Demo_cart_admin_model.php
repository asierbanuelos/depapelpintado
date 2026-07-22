<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demo_cart_admin_model extends CI_Model {
	
	// The following method prevents an error occurring when $this->data is modified.
	// Error Message: 'Indirect modification of overloaded property Demo_cart_admin_model::$data has no effect'
	public function &__get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// UPDATE ORDER DETAILS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * demo_resave_order
	 * Update the cart data from a reloaded order.
	 */
	function demo_resave_order($order_number)
	{
		$this->load->library('flexi_cart');

		// Set 'update_order' post data to variable to allow easier checking of array values in the POST data.
		$this->post_data = $this->input->post('update_order');
				
		// Insert any submitted discount codes.
		if (isset($this->post_data['discount_code']))
		{	
			$discount_data = $this->input->post('discount_code');					
			$this->flexi_cart->update_discount_codes($discount_data);
		}
		
		// Remove any specifically submitted manual discounts.
		if (isset($this->post_data['remove_discount']))
		{
			$remove_discount = key($this->post_data['remove_discount']);					
			$this->flexi_cart->unset_discount($remove_discount);
		}
		
		// Remove any specifically submitted surcharges.
		if (isset($this->post_data['remove_surcharge']))
		{
			$remove_surcharge = key($this->post_data['remove_surcharge']);					
			$this->flexi_cart->unset_surcharge($remove_surcharge);
		}
		
		if (isset($this->post_data['order']))
		{	
			$this->demo_insert_manual_discount();	
			$this->demo_insert_surcharge();
		}
		
		$order_item_data = $this->input->post('items');
		$settings['update_shipping'] = $this->input->post('shipping');
		
		$this->flexi_cart->update_cart($order_item_data, $settings, TRUE);		
	
		// Insert any items with a quantity over 0 to the cart. 
		if (isset($this->post_data['insert_items']))
		{	
			$this->demo_insert_item_to_cart();
		}

		// If 'Re-Save Cart as Order' button was clicked, resave the order data to the database.
		if (isset($this->post_data['save']))
		{
			$this->flexi_cart_admin->resave_order();
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			
			$this->flexi_cart->destroy_cart();
			
			redirect('admin_library/order_details/'.$order_number);
		}
		else
		{
			redirect('admin_library/update_order_details/'.$order_number);
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	function demo_insert_item_to_cart()
	{
		$insert_item_data = array();
		foreach($this->input->post('insert_item') as $item_id => $item_post_data)
		{
			if ($item_post_data['item_quantity'] > 0)
			{
				$query = $this->db->select('item_name, item_weight')
					->from('demo_items')
					->where('item_id', $item_id)
					->get();
					
				if ($query->num_rows() == 1)
				{
					$item_db_data = $query->row_array();
					
					// Note: It is not necessary to insert any item shipping, tax or discount data that is present in the defined flexi cart tables.
					// This data will automatically be retrieved by the cart library.
					$insert_item_data[] = array(
						'id' => $item_id, 
						'name' => 'Example Database '.$item_db_data['item_name'],
						'quantity' => $item_post_data['item_quantity'],
						'price' => $item_post_data['item_price'],
						'weight' => $item_db_data['item_weight']
					);
				}
			}
		}
		
		if (! empty($insert_item_data))
		{
			$this->load->library('flexi_cart');
			$this->flexi_cart->insert_items($insert_item_data);
		}
		
		return FALSE;
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	function demo_insert_manual_discount()
	{
		$this->load->library('flexi_cart');

		foreach($this->input->post('discount') as $discount_data)
		{
			if (! empty($discount_data['description']) && $discount_data['value'] > 0)
			{
				// Set the manual discount POST data to the insert array.
				// Note: 'tax_method' and 'void_reward_points' could also be set if required.				
				$insert_discount_data = array(
					'description' => $discount_data['description'],
					'column' => $discount_data['column'],
					'value' => $discount_data['value'],
					'calculation' => $discount_data['calculation']
				);
				
				$this->flexi_cart->set_discount($insert_discount_data);
			}
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	function demo_insert_surcharge()
	{
		$this->load->library('flexi_cart');

		foreach($this->input->post('surcharge') as $surcharge_data)
		{
			if (! empty($surcharge_data['description']) && $surcharge_data['value'] > 0)
			{
				// Set the surcharge POST data to the insert array.
				$insert_surcharge_data = array(
					'description' => $surcharge_data['description'],
					'tax_rate' => $surcharge_data['tax_rate'],
					'value' => $surcharge_data['value'],
					'column' => $surcharge_data['column']
				);
				
				$this->flexi_cart->set_surcharge($insert_surcharge_data);
			}
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CUSTOM ITEM TABLE
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * demo_get_item_data
	 * Get data from a custom item table that is not a part of flexi cart.
	 */
    function demo_del ($table,$idname,$id){
      $data=array('activo'=>0);
      $this->db->where($idname,$id)->update($table,$data);
    }
    function con_variantes($fab=0,$col=0){

      $temp=$this->db->select("*",FALSE)->from('demo_items');
      if($fab!=0){$temp->where('item_cat_fk',$fab);}
      if($col!=0){$temp->where('item_coleccion_id',$col);}
      $temp->where('tiene_variantes',"1");
      return $temp->order_by('item_ref','asc')->get()->result_array();
    }
    function con_relacionados($fab=0,$col=0){

      $temp=$this->db->select("*",FALSE)->from('demo_items');
      if($fab!=0){$temp->where('item_cat_fk',$fab);}
      if($col!=0){$temp->where('item_coleccion_id',$col);}
      $temp->where('tiene_relacionados',"1");
      return $temp->order_by('item_ref','asc')->get()->result_array();
    }
    function demo_get_colecciones_meta($order="ASC", $limit=100){	
		return $this->db->select("coleccion_id, coleccion_name, cat_name, meta_titlec, meta_descriptionc, meta_keywordsc, ccats, col_text_publico",FALSE)
			->from('demo_coleccion')
				->join('demo_categories', 'coleccion_cat_id = cat_id')
        ->where('demo_coleccion.activo',1)
        ->where('demo_coleccion.publico2',1)
        ->group_by('coleccion_id')
        //->limit($limit) // Para coger bloques de $limit registros
        ->order_by('coleccion_id',$order)
			->get()
			->result();
			//->result_array();
		}
    
    function demo_get_items_meta($order="ASC", $limit=100){	
		return $this->db->select("demo_items.item_id, item_name, item_ref, item_tipo, coleccion_name, cat_name",FALSE)
			->from('demo_items')
				->join('demo_categories', 'item_cat_fk = cat_id')
        ->join('demo_coleccion', 'item_coleccion_id = coleccion_id')
        //->where('demo_items.activo',1)
        ->where('demo_items.meta_title','') // Linea para actualizar solo los metatitle en blanco
        ->group_by('item_id')
        //->limit($limit) // Para coger bloques de $limit registros
        ->order_by('item_id',$order)
			->get()
			->result_array();
		}
    function demo_get_items_meta_desc($order="ASC", $limit=100){	
		return $this->db->select("demo_items.item_id, item_name, item_ref, item_tipo, meta_description, coleccion_name, cat_name, GROUP_CONCAT(gama_name SEPARATOR ', ') AS color, GROUP_CONCAT(estilo_name SEPARATOR ',') AS estilo",FALSE)
			->from('demo_items')
				->join('demo_categories', 'item_cat_fk = cat_id')
        ->join('demo_coleccion', 'item_coleccion_id = coleccion_id')
        ->join('demo_gama_item', 'item_id = gama_item_item')
        ->join('demo_gama', 'gama_id = gama_item_gama')
        ->join('demo_estilo_item', 'item_id = estilo_item_item')
        ->join('demo_estilo', 'estilo_id = estilo_item_estilo')
        ->where('demo_items.activo',1)
        ->where('demo_items.meta_description','') // Linea para actualizar solo los metatitle en blanco
        ->group_by('item_id')
        //->limit($limit) // Para coger bloques de $limit registros
        ->order_by('item_id',$order)
			->get()
			->result_array();
		}
    
    function demo_get_item_data($order="ASC"){	
		return $this->db->select("*,GROUP_CONCAT(gama_name SEPARATOR ', ') AS color",FALSE)
			->from('demo_items')
                ->join($this->flexi_cart_admin->db_table('item_stock'), 'item_id = '.$this->flexi_cart_admin->db_column('item_stock', 'item'))
			->join('demo_categories', 'item_cat_fk = cat_id')
            ->join('demo_coleccion', 'item_coleccion_id = coleccion_id')
            ->join('demo_modelo', 'item_model_id = modelo_id')
                ->join('demo_gama_item', 'item_id = gama_item_item')
                ->join('demo_gama', 'gama_id = gama_item_gama')
            ->where('demo_items.activo',1)
                ->group_by('item_id')->limit(100)
            ->order_by('item_id',$order)
			->get()
			->result_array();
        
		}
    function demo_get_last_item_data($order="ASC"){	
		return $this->db->select("*,GROUP_CONCAT(gama_name SEPARATOR ', ') AS color",FALSE)
			->from('demo_items')
                ->join($this->flexi_cart_admin->db_table('item_stock'), 'item_id = '.$this->flexi_cart_admin->db_column('item_stock', 'item'))
			->join('demo_categories', 'item_cat_fk = cat_id')
            ->join('demo_coleccion', 'item_coleccion_id = coleccion_id')
            ->join('demo_modelo', 'item_model_id = modelo_id')
                ->join('demo_gama_item', 'item_id = gama_item_item')
                ->join('demo_gama', 'gama_id = gama_item_gama')
            ->where('demo_items.activo',1)
                ->group_by('item_id')->limit(10)
            ->order_by('item_id',$order)
			->get()
			->result_array();
        
		}
    function get_full_item_data($itemid){
      return $this->db->select("*,
      	GROUP_CONCAT(gama_name SEPARATOR ',') AS color, 
      	GROUP_CONCAT(estilo_name SEPARATOR ',') AS estilo,
      	GROUP_CONCAT(gama_id SEPARATOR ',') AS colorid, 
      	GROUP_CONCAT(estilo_id SEPARATOR ',') AS estiloid",
      	FALSE)
			->from('demo_items')
            ->join($this->flexi_cart_admin->db_table('item_stock'), 'demo_items.item_id = '.$this->flexi_cart_admin->db_column('item_stock', 'item'))
						->join('demo_categories', 'item_cat_fk = cat_id')
            ->join('demo_coleccion', 'item_coleccion_id = coleccion_id')
            ->join('demo_modelo', 'item_model_id = modelo_id')
            ->join('demo_gama_item', 'item_id = gama_item_item')
            ->join('demo_gama', 'gama_id = gama_item_gama')
            ->join('demo_estilo_item', 'item_id = estilo_item_item')
            ->join('demo_estilo', 'estilo_id = estilo_item_estilo')
            ->group_by('demo_items.item_id')
            ->where('demo_items.activo',1)
            ->where(array('demo_items.item_id'=>$itemid))
			->get()
			->result_array();
    }
    function get_full_item_data_new($itemid){
      $resultado= $this->db->select("*, demo_items.orden AS orden, demo_items.activo AS activo, demo_items.portada AS portada",FALSE)
			->from('demo_items')
            ->join($this->flexi_cart_admin->db_table('item_stock'), 'demo_items.item_id = '.$this->flexi_cart_admin->db_column('item_stock', 'item'))
						->join('demo_categories', 'item_cat_fk = cat_id')
            ->join('demo_coleccion', 'item_coleccion_id = coleccion_id')
            ->join('demo_modelo', 'item_model_id = modelo_id')
            ->group_by('demo_items.item_id')
            ->where('demo_items.activo',1)
            ->where(array('demo_items.item_id'=>$itemid))
			->get()
			->result_array();

			$gamas= $this->db->select("*",FALSE)
			->from('demo_gama_item')
            ->join('demo_gama', 'gama_id = gama_item_gama', 'left')
            ->where(array('gama_item_item'=>$itemid))
			->get()
			->result_array();

			$a_gamas['ids'][]=0;
			$a_gamas['nombres']=array();
			foreach($gamas as $datos_gama){
				if ($datos_gama['gama_id']!=0)
					$a_gamas['ids'][]=$datos_gama['gama_id'];
				if (trim($datos_gama['gama_name'])!='')
					$a_gamas['nombres'][]=$datos_gama['gama_name'];
			}

			$resultado[0]['color']=implode(', ', $a_gamas['nombres']);
			$resultado[0]['colorid']=implode(', ', $a_gamas['ids']);

			$estilos= $this->db->select("*",FALSE)
			->from('demo_estilo_item')
            ->join('demo_estilo', 'estilo_id = estilo_item_estilo', 'left')
            ->where(array('estilo_item_item'=>$itemid))
			->get()
			->result_array();

			$a_estilos['ids'][]=0;
			$a_estilos['nombres']=array();
			foreach($estilos as $datos_estilo){
				if ($datos_estilo['estilo_id']!=0)
					$a_estilos['ids'][]=$datos_estilo['estilo_id'];
				if (trim($datos_estilo['estilo_name'])!='')
					$a_estilos['nombres'][]=$datos_estilo['estilo_name'];
			}

			$resultado[0]['estilo']=implode(', ', $a_estilos['nombres']);
			$resultado[0]['estiloid']=implode(', ', $a_estilos['ids']);

			$nuevas_categorias= $this->db->select("*",FALSE)
			->from('nueva_categoria_item')
            ->join('nueva_categoria', 'nueva_categoria_item.nueva_categoria_id = nueva_categoria.nueva_categoria_id', 'left')
            ->where(array('nuevacategoria_item_id'=>$itemid))
			->get()
			->result_array();
			
			$a_categorias['ids'][]=0;
			$a_categorias['nombres']=array();
			foreach($nuevas_categorias as $datos_categoria){
				if ($datos_categoria['nueva_categoria_id']!=0)
					$a_categorias['ids'][]=$datos_categoria['nueva_categoria_id'];
				if (trim($datos_categoria['nueva_categoria_name'])!='')
					$a_categorias['nombres'][]=$datos_categoria['nueva_categoria_name'];
			}

			$resultado[0]['nuevacategoria']=implode(', ', $a_categorias['nombres']);
			$resultado[0]['nuevacategoriaid']=implode(', ', $a_categorias['ids']);
      
    	/*
      print '<pre><xmp>';
      print_r($resultado);
      print '</xmp></pre>';
      $resultado= $this->db->select("*,
      	GROUP_CONCAT(gama_name SEPARATOR ',') AS color, 
      	GROUP_CONCAT(estilo_name SEPARATOR ',') AS estilo,
      	GROUP_CONCAT(nueva_categoria_id SEPARATOR ',') AS nuevacategoriaid, 
      	GROUP_CONCAT(gama_id SEPARATOR ',') AS colorid, 
      	GROUP_CONCAT(estilo_id SEPARATOR ',') AS estiloid",
      	FALSE)
			->from('demo_items')
            ->join($this->flexi_cart_admin->db_table('item_stock'), 'demo_items.item_id = '.$this->flexi_cart_admin->db_column('item_stock', 'item'))
						->join('demo_categories', 'item_cat_fk = cat_id')
            ->join('demo_coleccion', 'item_coleccion_id = coleccion_id')
            ->join('demo_modelo', 'item_model_id = modelo_id')
            ->join('demo_gama_item', 'item_id = gama_item_item')
            ->join('demo_gama', 'gama_id = gama_item_gama')
            ->join('demo_estilo_item', 'item_id = estilo_item_item')
            ->join('demo_estilo', 'estilo_id = estilo_item_estilo')
            ->join('nueva_categoria_item', 'demo_items.item_id = nuevacategoria_item_id', 'left')
            ->group_by('demo_items.item_id')
            ->where('demo_items.activo',1)
            ->where(array('demo_items.item_id'=>$itemid))
			->get()
			->result_array();
			*/

      //exit;
			return $resultado;
    }
    
    function get_item_data($itemid)
	{
		return $this->db->from('demo_items')
			->join($this->flexi_cart_admin->db_table('item_stock'), 'item_id = '.$this->flexi_cart_admin->db_column('item_stock', 'item'))
			->join('demo_categories', 'item_cat_fk = cat_id')
            ->join('demo_coleccion', 'item_coleccion_id = coleccion_id')
            ->join('demo_modelo', 'item_model_id = modelo_id')
            ->where(array('item_id'=>$itemid))
			->get()
			->result_array();
	}
	function get_items_count($fab=0,$colec=0,$todos=0,$gama=0,$estilo=0,$categ=-1,$precio='', $referencia='', $categoria_seo=0, $publico_be=0, $vinilo_be=0){
		$temp=$this->db->select("*",FALSE)->from('demo_items');
		if($fab!=0)$temp->where('item_cat_fk',$fab);
		if($colec!=0)$temp->where('item_coleccion_id',$colec);
		if($todos==0) $temp->where('demo_items.activo',1);
    /*
    if(isset($_POST['categoria_seo']) && $_POST['categoria_seo']!=0){
			$temp->join('nueva_categoria_item', 'item_id = nuevacategoria_item_id')->where('nueva_categoria_id',$_POST['categoria_seo']);
    }
    */
    if($categoria_seo!=0){
			$temp->join('nueva_categoria_item', 'item_id = nuevacategoria_item_id')->where('nueva_categoria_id',$categoria_seo);
    }

		if($gama!=0){
			$temp->join('demo_gama_item', 'item_id = gama_item_item')
			->join('demo_gama', 'gama_id = gama_item_gama')->where('gama_id',$gama);
		}
		if($estilo!=0){
			$temp->join('demo_estilo_item', 'item_id = estilo_item_item')
			->join('demo_estilo', 'estilo_id = estilo_item_estilo')->where('estilo_id',$estilo);
		}
		if($categ>=0){
			$temp->where('item_tipo',$categ);
		}
		if(trim($precio)!=''){
			$temp->where('item_price',$precio);
		}
		if(trim($referencia)!=''){
			$temp->like('item_ref',$referencia);
		}
		/*
    if(isset($_POST['publico_be'])){
			$temp->where('publico3',$_POST['publico_be']);
    }
    if(isset($_POST['vinilo_be'])){
			$temp->where('item_vinilo',$_POST['vinilo_be']);
    }
    */
		if($publico_be!=0){
			$temp->where('publico3',$publico_be);
    }
		if($vinilo_be!=0){
			$temp->where('item_vinilo',$vinilo_be);
    }
		return $temp->count_all_results();
	}
    function get_fab_count(){
      $temp=$this->db->select("*",FALSE)->from('demo_categories');
       $temp->where('activo',1);
      return $temp->count_all_results();
    }
    function get_col_count($fab=0){
      $temp=$this->db->select("*",FALSE)->from('demo_coleccion');
      if($fab!=0)$temp->where('coleccion_cat_id',$fab);
      $temp->where('activo',1);
      return $temp->count_all_results();
    }
	//function get_items_filter($fab=null,$colec=null,$page=0,$todos=0,$order='item_id',$gama=0,$estilo=0,$categ=-1,$precio='', $referencia=''){
	function get_items_filter($fab=null,$colec=null,$page=0,$todos=0,$order='item_id',$gama=0,$estilo=0,$categ=-1,$precio='', $referencia='', $categoria_seo=0, $publico_be=0, $vinilo_be=0){
		/*
		print '<pre><xmp>';
		print_r($_REQUEST);
		print '</xmp></pre>';
		*/

		$temp=$this->db->select("*,demo_items.activo as item_activo, GROUP_CONCAT(gama_name SEPARATOR ', ') AS color",FALSE)
			->from('demo_items')
			->join($this->flexi_cart_admin->db_table('item_stock'), 'item_id = '.$this->flexi_cart_admin->db_column('item_stock', 'item'))
			->join('demo_categories', 'item_cat_fk = cat_id')
			->join('demo_coleccion', 'item_coleccion_id = coleccion_id');
		$temp->join('demo_modelo', 'item_model_id = modelo_id')
			->join('demo_gama_item', 'item_id = gama_item_item')
			->join('demo_gama', 'gama_id = gama_item_gama');
    
    //if(isset($_POST['categoria_seo']) && $_POST['categoria_seo']!=0){
		//	$temp->join('nueva_categoria_item', 'item_id = nuevacategoria_item_id')->where('nueva_categoria_id',$_POST['categoria_seo']);
    //}
    if($categoria_seo!=0){
			$temp->join('nueva_categoria_item', 'item_id = nuevacategoria_item_id')->where('nueva_categoria_id',$categoria_seo);
    }
		if($gama!=0){
			$temp->where('gama_id',$gama);
		}
		if($estilo!=0){
			$temp->join('demo_estilo_item', 'item_id = estilo_item_item')
			->join('demo_estilo', 'estilo_id = estilo_item_estilo')->where('estilo_id',$estilo);
		}
		if($categ>=0){
			$temp->where('item_tipo',$categ);
		}
		if(trim($precio)!=''){
			$temp->where('item_price',$precio);
		}
		/*
    if(isset($_POST['publico_be'])){
			$temp->where('publico3',$_POST['publico_be']);
    }
    if(isset($_POST['vinilo_be'])){
			$temp->where('item_vinilo',$_POST['vinilo_be']);
    }
    */
		if($publico_be!=0){
			$temp->where('publico3',$publico_be);
    }
		if($vinilo_be!=0){
			$temp->where('item_vinilo',$vinilo_be);
    }
		if(trim($referencia)!=''){
			$temp->like('item_ref',$referencia);
		}
		if($fab!=null && $fab!=0)$temp->where('cat_id',$fab);
		if($colec!=null && $colec!=0)$temp->where('coleccion_id',$colec);
		if($todos==0) $temp->where('demo_items.activo',1);
		

		if (($estilo!=0) || ($gama!=0) ){$temp->limit(1000,0);}
		else if ($fab==null || $fab==0 )$temp->limit(100,0);
		//añadir filtro por colores
		//$this->data['count']=$temp->count_all_results();
		return $temp->group_by('item_id')->order_by($order)->get()->result_array();
	}

	function get_items_listado($where_txt='', $orden_txt=''){

		$a_join[]=' LEFT JOIN demo_categories ON item_cat_fk=cat_id ';
		$a_join[]=' LEFT JOIN demo_coleccion ON item_coleccion_id=coleccion_id ';

		$join_txt=implode(' ', $a_join);
		$query_txt="SELECT * FROM demo_items $join_txt $where_txt ORDER BY $orden_txt  ";
		
		$query=$this->db->query($query_txt);
		$result=$query->result_array();

    
		return $result;
	}

    function get_con_variantes($fab=0){
      $temp=$this->db->select("*",FALSE)->from('demo_items');
      if($fab!=0)$temp->where('item_cat_fk',$fab);
      $temp->where('tiene_variantes','1');
      return $temp->order_by("item_ref")->get->result_array();
    }
    function get_hers($order="DESC"){
      return $temp=$this->db->from('demo_items')->where(array('activo'=>1,'item_tipo'=>5))->order_by('item_ref',$order)->get()->result_array();
    }
    function get_categories_20($order="DESC", $page=0){
      return $this->db->from('demo_categories')->where(array('activo'=>1))->order_by('cat_name',$order)->limit(20,$page*20)->get()->result();
    }
    function get_categories($order="DESC", $page=0){
      return $this->db->from('demo_categories')->where(array('activo'=>1))->order_by('cat_name',$order)->get()->result();
    }
    function get_categories_seo($cat_id){
      $categoria=$this->db->from('demo_categories')->where(array('cat_id'=>$cat_id))->get()->result();
      $categoria_ekam=$this->db->from('demo_categories_ekam')->where(array('cat_id'=>$cat_id))->get()->result();

      $datos_categoria['principal']=$categoria[0];
      if (isset($categoria_ekam[0]))
	      $datos_categoria['ekam']=$categoria_ekam[0];
			
      return $datos_categoria;
      //return $this->db->from('nueva_categoria')->where(array('nueva_categoria_id'=>$catid))->get()->result();
    }
    function get_categories_ekam($order="DESC", $page=0){
    	$todas_las_marcas=$this->get_categories();
    	$seo_ekam=$this->db->from('demo_categories_ekam')->get()->result();
      
      $a_seo_ekam=array();
      foreach($seo_ekam as $row){
        $a_seo_ekam[$row->cat_id]=$row;
      }

      $res= array();
      foreach($todas_las_marcas as $row){
      	if (isset($a_seo_ekam[$row->cat_id])){
      		$res[$row->cat_id]=$row;
      		$res[$row->cat_id]->cat_text_ekam=$a_seo_ekam[$row->cat_id]->cat_text;
      		$res[$row->cat_id]->meta_titlef_ekam=$a_seo_ekam[$row->cat_id]->meta_titlef;
      		$res[$row->cat_id]->meta_descriptionf_ekam=$a_seo_ekam[$row->cat_id]->meta_descriptionf;
      	}
      }
      return $res;
    }
    function get_category($catid){
      return $this->db->from('demo_categories')->where(array('cat_id'=>$catid))->get()->result();
    }
     function get_her($herid){
      return $this->db->from('demo_items')->where(array('item_id'=>$herid))->get()->result();
    }
    function get_cat_array($order="ASC"){
      $res= array();
      $result=$this->get_categories($order);
      
      foreach($result as $row){
        $res[$row->cat_id]=$row->cat_name;
      }
      return $res;
    }
    function get_colecciones($cat=0,$order="ASC",$page=0){
      if ($cat==0 )return $this->db->from('demo_coleccion')->join('demo_categories', 'coleccion_cat_id = cat_id')->where(array('demo_coleccion.activo'=>1))->order_by('coleccion_name',$order)->get()->result();
      else return $this->db->from('demo_coleccion')->join('demo_categories', 'coleccion_cat_id = cat_id')->where(array('coleccion_cat_id'=>$cat,'demo_coleccion.activo'=>1))->order_by('coleccion_name',$order)->get()->result();
      
    }
    function get_colecciones_ekam($cat=0,$order="ASC",$page=0){
    	$todas_las_colecciones=$this->get_colecciones();
    	$seo_ekam=$this->db->from('demo_coleccion_ekam')->get()->result();
      
      $a_seo_ekam=array();
      foreach($seo_ekam as $row){
        $a_seo_ekam[$row->coleccion_id]=$row;
      }

      $res= array();
      foreach($todas_las_colecciones as $row){
      	if (isset($a_seo_ekam[$row->coleccion_id])){
      		$res[$row->coleccion_id]=$row;
      		$res[$row->coleccion_id]->col_text_ekam=$a_seo_ekam[$row->coleccion_id]->col_text;
      		$res[$row->coleccion_id]->meta_titlec_ekam=$a_seo_ekam[$row->coleccion_id]->meta_titlec;
      		$res[$row->coleccion_id]->meta_descriptionc_ekam=$a_seo_ekam[$row->coleccion_id]->meta_descriptionc;
      	}
      }
      return $res;
    }


    function get_colecciones_20($cat=0,$order="ASC",$page=0){
      if ($cat==0 )return $this->db->from('demo_coleccion')->join('demo_categories', 'coleccion_cat_id = cat_id')->where(array('demo_coleccion.activo'=>1))->order_by('coleccion_name',$order)->limit(20,$page*20)->get()->result();
      else return $this->db->from('demo_coleccion')->join('demo_categories', 'coleccion_cat_id = cat_id')->where(array('coleccion_cat_id'=>$cat,'demo_coleccion.activo'=>1))->order_by('coleccion_name',$order)->limit(20,$page*20)->get()->result();
      
    }
    function get_coleccion($coleccion=0){
      if ($coleccion!=0 )return $this->db->from('demo_coleccion')->join('demo_categories', 'coleccion_cat_id = cat_id')->where(array('coleccion_id' => $coleccion))->get()->result();
      return $this->db->get('demo_coleccion')->result();
    }
    function get_col_array($cat=0,$order="ASC"){
      $res= array();
      $result=$this->get_colecciones($cat,$order);
      foreach($result as $row){
        $res[$row->coleccion_id]=$row->coleccion_name;
      }
      return $res;
    }
    /*
    function get_colecciones_seo_ekam($tipo_producto=-1){
      if ($tipo_producto>=0 )
      	$result= $this->db->from('nueva_categoria_ekam')->where(array('tipo_producto'=>$tipo_producto))->order_by('nueva_categoria_name','ASC')->get()->result();
      else 
      	$result= $this->db->from('nueva_categoria_ekam')->order_by('tipo_producto, nueva_categoria_name','ASC, ASC')->get()->result();
    
      $res= array();
      foreach($result as $row){
        $res[$row->nueva_categoria_id]=$row;
      }
      return $res;

    }
    */
    function get_coleccion_seo($colid){
      $nueva_col=$this->db->from('demo_coleccion')->where(array('coleccion_id'=>$colid))->get()->result();
      $nueva_col_ekam=$this->db->from('demo_coleccion_ekam')->where(array('coleccion_id'=>$colid))->get()->result();

      $datos_coleccion['principal']=$nueva_col[0];
      if (isset($nueva_col_ekam[0]))
	      $datos_coleccion['ekam']=$nueva_col_ekam[0];
			
      return $datos_coleccion;
      //return $this->db->from('nueva_categoria')->where(array('nueva_categoria_id'=>$catid))->get()->result();
    }


    function get_categorias_proyectos(){
      	return $this->db->from('proyecto_categoria')->order_by('proyecto_categoria_name','ASC')->get()->result();
    }
    function get_categoria_proyecto($catid){
      $proyecto_categoria=$this->db->from('proyecto_categoria')->where(array('idproyecto_categoria'=>$catid))->get()->result();
			
      return $proyecto_categoria;
    }
    function get_categorias_proyectos_array(){
     	$result=$this->get_categorias_proyectos();
      $res[0]='--';
      foreach($result as $row){
        $res[$row->idproyecto_categoria]=$row->proyecto_categoria_name;
      }
      return $res;
    }

    function get_proyectos(){
      	return $this->db->from('proyecto')->order_by('proyecto_fecha','DESC')->get()->result();
    }
    function get_proyecto($id){
      $proyecto=$this->db->from('proyecto')->where(array('idproyecto'=>$id))->get()->result();
			
      return $proyecto;
    }
    function get_img_proyectos($id=0){
			return $this->db->from('proyecto_img')->where(array('idproyecto'=>$id))->order_by('idproyecto_img','ASC')->get()->result();
    }
    function get_imagen_proyecto($id_img=0){
			return $this->db->from('proyecto_img')->where(array('idproyecto_img'=>$id_img))->get()->result();
    }
    
    function get_categorias_noticias(){
      	return $this->db->from('noticia_categoria')->order_by('noticia_categoria_name','ASC')->get()->result();
    }
    function get_categoria_noticia($catid){
      $noticia_categoria=$this->db->from('noticia_categoria')->where(array('idnoticia_categoria'=>$catid))->get()->result();
			
      return $noticia_categoria;
    }
    function get_categorias_noticias_array(){
     	$result=$this->get_categorias_noticias();
      $res[0]='--';
      foreach($result as $row){
        $res[$row->idnoticia_categoria]=$row->noticia_categoria_name;
      }
      return $res;
    }
    function get_categorias_noticias_url(){
     	$result=$this->get_categorias_noticias();
      $res[0]='--';
      foreach($result as $row){
        $res[$row->idnoticia_categoria]=$row->noticia_categoria_name_url;
      }
      return $res;
    }

    function get_noticias(){
      	return $this->db->from('noticia')->order_by('noticia_fecha','DESC')->get()->result();
    }
    function get_noticia($id){
      $noticia=$this->db->from('noticia')->where(array('idnoticia'=>$id))->get()->result();
			
      return $noticia;
    }
    function get_img_noticias($id=0){
			return $this->db->from('noticia_img')->where(array('idnoticia'=>$id))->order_by('idnoticia_img','ASC')->get()->result();
    }
    
    function get_tipos_producto_seo($tipo_producto=-1){
      if ($tipo_producto>=0 )
     			return $this->db->from('tipo_producto')->where(array('tipo_producto_id'=>$tipo_producto))->order_by('tipo_producto_id','ASC')->get()->result();
     	else
     			return $this->db->from('tipo_producto')->order_by('tipo_producto_id','ASC')->get()->result();
    }
    function get_tipos_producto_seo_ekam($tipo_producto=-1){
      if ($tipo_producto>=0 )
     		$result= $this->db->from('tipo_producto_ekam')->where(array('tipo_producto_id'=>$tipo_producto))->order_by('tipo_producto_id','ASC')->get()->result();
     	else
	     	$result= $this->db->from('tipo_producto_ekam')->order_by('tipo_producto_id','ASC')->get()->result();
    
			$res= array();
      foreach($result as $row){
        $res[$row->tipo_producto_id]=$row;
      }
      return $res;

    }
    
    function get_categorias_seo($tipo_producto=-1){
      if ($tipo_producto>=0 )
      	return $this->db->from('nueva_categoria')->where(array('tipo_producto'=>$tipo_producto))->order_by('nueva_categoria_name','ASC')->get()->result();
      else 
      	return $this->db->from('nueva_categoria')->order_by('tipo_producto, nueva_categoria_name','ASC, ASC')->get()->result();
    }
    function get_categorias_seo_ekam($tipo_producto=-1){
      if ($tipo_producto>=0 )
      	$result= $this->db->from('nueva_categoria_ekam')->where(array('tipo_producto'=>$tipo_producto))->order_by('nueva_categoria_name','ASC')->get()->result();
      else 
      	$result= $this->db->from('nueva_categoria_ekam')->order_by('tipo_producto, nueva_categoria_name','ASC, ASC')->get()->result();
    
      $res= array();
      foreach($result as $row){
        $res[$row->nueva_categoria_id]=$row;
      }
      return $res;

    }
    function get_categoria_seo($catid){
      $nueva_categoria=$this->db->from('nueva_categoria')->where(array('nueva_categoria_id'=>$catid))->get()->result();
      $nueva_categoria_ekam=$this->db->from('nueva_categoria_ekam')->where(array('nueva_categoria_id'=>$catid))->get()->result();

      $datos_categoria['principal']=$nueva_categoria[0];
      if (isset($nueva_categoria_ekam[0]))
	      $datos_categoria['ekam']=$nueva_categoria_ekam[0];
			
      return $datos_categoria;
      //return $this->db->from('nueva_categoria')->where(array('nueva_categoria_id'=>$catid))->get()->result();
    }
    function get_categorias_seo_array($tipo_producto){
      $res= array();
      $result=$this->get_categorias_seo($tipo_producto);
      foreach($result as $row){
        $res[$row->nueva_categoria_id]=$row->nueva_categoria_name;
      }
      return $res;
    }
    function get_categorias_seo_array_para_edicion($a_familias=array()){
      $a_tipos[0]='Papel Pintado';
      $a_tipos[1]='Fotomurales';
      $a_tipos[2]='Revestimientos';
      $a_tipos[3]='Telas';
      $a_tipos[4]='Alfombras';

    	$familias=$this->get_filtros_categoria_array();
     	$result=$this->get_categorias_seo();
      foreach($result as $row){
      	if($row->nueva_categoria_activo){
      		if (count($a_familias)==0)
		        $res[$a_tipos[$row->tipo_producto].' '.$familias[$row->idnueva_categoria_familia]][$row->nueva_categoria_id]=$row->nueva_categoria_name;
		      else{
		        if (in_array($row->idnueva_categoria_familia, $a_familias))
			        $res[$a_tipos[$row->tipo_producto].' '.$familias[$row->idnueva_categoria_familia]][$row->nueva_categoria_id]=$row->nueva_categoria_name;
		      }
      	}
      }
      return $res;
    }
    function get_filtros_categoria(){
     	return $this->db->from('nueva_categoria_familia')->order_by('nombre_familia_categoria','ASC')->get()->result();
    }
    function get_filtros_categoria_array(){
     	$result=$this->get_filtros_categoria();
      $res[0]='--';
      foreach($result as $row){
        $res[$row->idnueva_categoria_familia]=$row->nombre_familia_categoria;
      }
      return $res;
    }
    
    function get_modelos($col=0,$order="ASC"){
      if ($col==0 )return $this->db->from('demo_modelo')->join('demo_coleccion', 'modelo_coleccion_id = coleccion_id')->where(array('demo_modelo.activo'=>1))->order_by('modelo_id',$order)->get()->result();
      else return $this->db->from('demo_modelo')->join('demo_coleccion', 'modelo_coleccion_id = coleccion_id')->where(array('modelo_coleccion_id'=>$col,'demo_modelo.activo'=>1))->order_by('modelo_id',$order)->get()->result();
      
    }
    function get_modelo($col=0){
      if ($col!=0)return $this->db->from('demo_modelo')->join('demo_coleccion','modelo_coleccion_id =coleccion_id')->where(array('modelo_id' => $col))->get()->result();
      return $this->db->get('demo_modelo')->result();
    }
    function get_mod_array($col=0,$order="ASC"){
      $res= array();
      $result=$this->get_modelos($col,$order);
      foreach($result as $row){
        $res[$row->modelo_id]=$row->modelo_name;
      }
      return $res;
    }
    function get_gamas($order="ASC"){
      return $this->db->from('demo_gama')->where(array('activo'=>1))->order_by('gama_name',$order)->get()->result();
    }
    function get_gama($catid){
      return $this->db->from('demo_gama')->where(array('gama_id'=>$catid))->get()->result();
    }
    function get_gama_array($order="ASC"){
      $res= array();
      $result=$this->get_gamas($order);
      
      foreach($result as $row){
        $res[$row->gama_id]=$row->gama_name;
      }
      return $res;
    }
    function get_estilos($order="ASC"){
      return $this->db->from('demo_estilo')->order_by('estilo_name',$order)->get()->result();
      //return $this->db->from('demo_estilo')->where(array('activo'=>1))->order_by('estilo_name',$order)->get()->result();
    }
    function get_estilo($catid){
      return $this->db->from('demo_estilo')->where(array('estilo_id'=>$catid))->get()->result();
    }
    function get_estilo_array($order="ASC"){
      $res= array();
      $result=$this->get_estilos($order);
      
      foreach($result as $row){
      	if ($row->activo==1)
	        $res[$row->estilo_id]=$row->estilo_name;
      }
      return $res;
    }
    function demo_update_item(){
      $data=$this->input->post(NULL, TRUE);
     if(!isset($data['mod']))$data['mod']=0;
     if(isset($data['limpieza']))$limp=implode(" ",$data['limpieza']);else $limp="";
     if(isset($data['uso']))$uso=implode(" ",$data['uso']);else $uso="";
     if(isset($data['usar_alt_lista'])){
			$usar_alt_lista=implode(",",$data['usar_alt_lista']);
			// además de gaurdarlo como hasta ahora, vamos a meter la relación en un a tabla
      // Primero borraremos los registros de ese id
      $this->db->where('iditem',$data['item_id'])->delete('demo_item_cat_ambiente');
      
      foreach ($data['usar_alt_lista'] as $key=>$value){
        $datos_img_cat_ambiente=array(
            'iditem'=>$data['item_id'],
            'idcategoria'=>$value
        );
        $this->db->insert('demo_item_cat_ambiente',$datos_img_cat_ambiente);
      }
     }
     else 
     	$usar_alt_lista="";

      $itemarray=array(
          'item_cat_fk'=>$data['fab'],
          'item_tipo'=>$data['cats'],
          'item_unidad'=>$data['unidad'],
          'item_model_id'=>$data['mod'],
          'item_ref'=>$data['ref'],
          'item_name'=>$data['name'],
          'extra'=>$data['extra'],
          'item_price'=>$data['precio'],
          'item_price_aux'=>$data['precio_aux'],
          'item_weight'=>($data['weight']>1)?$data['weight']:1,
          'item_ancho'=>$data['ancho'],
          'item_largo'=>$data['largo'],
          'item_case'=>$data['case'],'item_case2'=>$data['case2'],
          'item_lavable'=>$data['lavable'],
          'item_sol'=>isset($data['sol'])?1:0,
          'item_vinilo'=>isset($data['vinilo'])?1:0,
          'usar_alt'=>isset($data['usar_alt'])?1:0,
          'usar_alt_lista'=>$usar_alt_lista,
          'item_economico'=>isset($data['economico'])?1:0,
          'portada'=>isset($data['portada'])?1:0,
          'item_top'=>isset($data['topventas'])?1:0,
          'tiene_variantes'=>isset($data['tiene_variantes'])?1:0,
          'tiene_relacionados'=>isset($data['tiene_relacionados'])?1:0,
          'google_market_be'=>isset($data['google_market_be'])?1:0,
          'variante_de'=>$data['variante_de'],
          'relacionado_con'=>$data['relacionado_con'],
          'texto_relacion'=>$data['texto_relacion'],
          'item_cola'=>$data['cola'],
          'orden'=>$data['orden'],
          'composicion'=>$data['composicion'],
          'limpieza'=>$limp,
          'uso'=>$uso,
          'meta_title'=>$data['meta_title'],
          'meta_description'=>$data['meta_description'],
          'meta_keywords'=>$data['meta_keywords'],
          'imgdetalt'=>$data['imgdetalt'],
          'imgdettitle'=>$data['imgdettitle'],
          'imgambalt'=>$data['imgambalt'],
          'imgambtitle'=>$data['imgambtitle']);
			if($data['col']!=0)
				$itemarray['item_coleccion_id']=$data['col'];
      $lastid=$data['item_id'];

      $new_orden = intval($data['orden']);
      if ($new_orden > 0) {
          $row = $this->db->select('orden')->where('item_id', $lastid)->get('demo_items')->row();
          $old_orden = $row ? intval($row->orden) : 0;
          if ($new_orden !== $old_orden) {
              $this->db->where('orden >=', $new_orden)->where('item_id !=', $lastid)
                       ->set('orden', 'orden + 1', FALSE)->update('demo_items');
          }
      }

      $this->db->where('item_id',$lastid)->update('demo_items',$itemarray);
			//echo "<br />".$this->db->last_query();
			//exit;
      $this->db->where('gama_item_item',$lastid)->delete('demo_gama_item');
      $this->db->where('estilo_item_item',$lastid)->delete('demo_estilo_item');
      if(isset($data['gama'])){
        foreach ($data['gama'] as $key=>$value){
          $gamaarray=array(
              'gama_item_item'=>$lastid,
              'gama_item_gama'=>$value
          );
          $this->db->insert('demo_gama_item',$gamaarray);
        }
      }
      else {
        $gamaarray =array(
              'gama_item_item'=>$lastid,
              'gama_item_gama'=>'0'
          );
        $this->db->insert('demo_gama_item',$gamaarray);
      }
      if (isset($data['estilo'])){
        foreach ($data['estilo'] as $key=>$value){
          $estiloarray=array(
              'estilo_item_item'=>$lastid,
              'estilo_item_estilo'=>$value
          );
           $this->db->insert('demo_estilo_item',$estiloarray);
        }
      }
      else {
        $estiloarray=array(
              'estilo_item_item'=>$lastid,
              'estilo_item_estilo'=>'0'
          );
        $this->db->insert('demo_estilo_item',$estiloarray);
      }

      $this->db->where('nuevacategoria_item_id',$lastid)->delete('nueva_categoria_item');
      if (isset($data['nuevas_categorias'])){
        foreach ($data['nuevas_categorias'] as $key=>$value){
          $categoriasarray=array(
              'nuevacategoria_item_id'=>$lastid,
              'nueva_categoria_id'=>$value
          );
           $this->db->insert('nueva_categoria_item',$categoriasarray);
        }
      }

      if(!isset($data['stock']) || $data['stock']>1000 || $data['stock']=="")
        $stock=60000;
      else $stock=$data['stock'];
      $stockarray=array(
          'stock_quantity'=>$stock,
      );
       $this->db->where('stock_item_fk',$lastid)->update('item_stock',$stockarray);
      return $this->get_full_item_data($lastid); 
    }
    
	function demo_update_item_masivo(){
		$data=$this->input->post(NULL, TRUE);

		$id_seleccionados = isset($data['id_seleccionados']) ? array_map('intval', (array)$data['id_seleccionados']) : array();
		if (count($id_seleccionados) === 0 || count($id_seleccionados) >= 1000)
			return true;

		$itemarray=array();
		$nonempty = function($v){ return isset($v) && trim($v) !== ''; };
		$numeric  = function($v){ return isset($v) && trim($v) !== '' && is_numeric($v); };

		if ($nonempty($data['fab_masivo'] ?? '') && ($data['fab_masivo'] ?? '') !== '0')
			$itemarray['item_cat_fk'] = $data['fab_masivo'];
		if ($nonempty($data['col_masivo'] ?? '') && ($data['col_masivo'] ?? '') !== '0')
			$itemarray['item_coleccion_id'] = $data['col_masivo'];
		if ($nonempty($data['cats'] ?? ''))
			$itemarray['item_tipo'] = $data['cats'];
		if ($nonempty($data['mod'] ?? '') && ($data['mod'] ?? '') !== '0')
			$itemarray['item_model_id'] = $data['mod'];
		if ($nonempty($data['lavable'] ?? ''))
			$itemarray['item_lavable'] = $data['lavable'];
		if ($nonempty($data['cola'] ?? ''))
			$itemarray['item_cola'] = $data['cola'];
		if ($nonempty($data['unidad'] ?? ''))
			$itemarray['item_unidad'] = $data['unidad'];
		if ($numeric($data['precio'] ?? ''))
			$itemarray['item_price'] = $data['precio'];
		if ($numeric($data['precio_aux'] ?? ''))
			$itemarray['item_price_aux'] = $data['precio_aux'];
		if ($numeric($data['ancho'] ?? '') && $data['ancho'] > 0)
			$itemarray['item_ancho'] = $data['ancho'];
		if ($numeric($data['largo'] ?? '') && $data['largo'] > 0)
			$itemarray['item_largo'] = $data['largo'];
		if ($numeric($data['weight'] ?? '') && $data['weight'] > 1)
			$itemarray['item_weight'] = $data['weight'];
		// orden se gestiona por separado (ver bloque al final)
		if ($numeric($data['stock'] ?? ''))
			$itemarray['stock_quantity_aux'] = $data['stock'];
		if ($nonempty($data['extra'] ?? ''))
			$itemarray['extra'] = $data['extra'];
		if ($nonempty($data['composicion'] ?? ''))
			$itemarray['composicion'] = $data['composicion'];
		if ($nonempty($data['meta_title'] ?? ''))
			$itemarray['meta_title'] = $data['meta_title'];
		if ($nonempty($data['meta_description'] ?? ''))
			$itemarray['meta_description'] = $data['meta_description'];
		if ($nonempty($data['meta_keywords'] ?? ''))
			$itemarray['meta_keywords'] = $data['meta_keywords'];
		foreach ([
			'economico'       => 'item_economico',
			'topventas'       => 'item_top',
			'portada'         => 'portada',
			'sol'             => 'item_sol',
			'vinilo'          => 'item_vinilo',
			'usar_alt'        => 'usar_alt',
			'google_market_be'=> 'google_market_be',
		] as $field => $col) {
			if (isset($data[$field]) && $data[$field] !== '')
				$itemarray[$col] = intval($data[$field]);
		}

		if (count($itemarray) > 0)
			$this->db->where_in('item_id', $id_seleccionados)->update('demo_items', $itemarray);

		// Orden: asignación secuencial para evitar duplicados
		if ($numeric($data['orden'] ?? '')) {
			$n = intval($data['orden']);
			if ($n === 0) {
				// Volver al pool aleatorio
				$this->db->where_in('item_id', $id_seleccionados)->update('demo_items', ['orden' => 0]);
			} else {
				$count = count($id_seleccionados);
				// Hacer hueco: desplazar los que ya tienen posición fija >= n
				$this->db->where('orden >=', $n)->where('orden >', 0)
						 ->where_not_in('item_id', $id_seleccionados)
						 ->set('orden', 'orden + ' . $count, FALSE)->update('demo_items');
				// Asignar posiciones consecutivas en el orden en que aparecen en la lista
				foreach ($id_seleccionados as $i => $item_id)
					$this->db->where('item_id', $item_id)->update('demo_items', ['orden' => $n + $i]);
			}
		}

		// Stock en tabla separada
		if ($numeric($data['stock'] ?? ''))
			$this->db->where_in('item_id', $id_seleccionados)->update($this->flexi_cart_admin->db_table('item_stock'), array('stock_quantity' => $data['stock']));

		// Gama (reemplaza si se seleccionó alguna)
		if (!empty($data['gama']) && is_array($data['gama'])) {
			$this->db->where_in('gama_item_item', $id_seleccionados)->delete('demo_gama_item');
			foreach ($id_seleccionados as $item_id)
				foreach ($data['gama'] as $gama_id)
					$this->db->insert('demo_gama_item', array('gama_item_item'=>$item_id, 'gama_item_gama'=>$gama_id));
		}

		// Estilo (reemplaza si se seleccionó alguno)
		if (!empty($data['estilo']) && is_array($data['estilo'])) {
			$this->db->where_in('estilo_item_item', $id_seleccionados)->delete('demo_estilo_item');
			foreach ($id_seleccionados as $item_id)
				foreach ($data['estilo'] as $estilo_id)
					$this->db->insert('demo_estilo_item', array('estilo_item_item'=>$item_id, 'estilo_item_estilo'=>$estilo_id));
		}

		// Categorías SEO (reemplaza si se seleccionó alguna)
		if (!empty($data['nuevas_categorias']) && is_array($data['nuevas_categorias'])) {
			$this->db->where_in('nuevacategoria_item_id', $id_seleccionados)->delete('nueva_categoria_item');
			foreach ($id_seleccionados as $item_id)
				foreach ($data['nuevas_categorias'] as $cat_id)
					$this->db->insert('nueva_categoria_item', array('nuevacategoria_item_id'=>$item_id, 'nueva_categoria_id'=>$cat_id));
		}

		// Limpieza
		if (!empty($data['limpieza']) && is_array($data['limpieza']))
			$this->db->where_in('item_id', $id_seleccionados)->update('demo_items', array('limpieza'=>implode(' ', $data['limpieza'])));

		// Uso recomendado
		if (!empty($data['uso']) && is_array($data['uso']))
			$this->db->where_in('item_id', $id_seleccionados)->update('demo_items', array('uso'=>implode(' ', $data['uso'])));

		return true;
	}

	function update_elementos_masivo($tabla, $idtabla, $a_registros){
		foreach ($a_registros as $valor_id=>$a_valores){
      $this->db->where($idtabla,$valor_id)->update($tabla,$a_valores);
		}
	}	

    function demo_insert_item(){
      $data=$this->input->post(NULL, TRUE);
      if(isset($data['limpieza']))$limp=implode(" ",$data['limpieza']);else $limp="";
      if(isset($data['uso']))$uso=implode(" ",$data['uso']);else $uso="";
			if(isset($data['usar_alt_lista']))$usar_alt_lista=implode(",",$data['usar_alt_lista']);else $usar_alt_lista="";
      $itemarray=array(
          'item_tipo'=>$data['cats'],
          'item_cat_fk'=>$data['fab'],
          'item_coleccion_id'=>$data['col'],
          'item_unidad'=>$data['unidad'],
          'item_model_id'=>$data['mod'],
          'item_ref'=>$data['ref'],
          'item_name'=>$data['name'],
          'item_price'=>$data['precio'],
          'extra'=>$data['extra'],
          'item_weight'=>($data['weight']>1)?$data['weight']:1,
          'item_ancho'=>$data['ancho'],
          'item_largo'=>$data['largo'],
          'item_case'=>$data['case'],'item_case2'=>$data['case2'],
          'item_lavable'=>$data['lavable'],
          'item_sol'=>isset($data['sol'])?1:0,
          'item_vinilo'=>isset($data['vinilo'])?1:0,
          'usar_alt'=>isset($data['usar_alt'])?1:0,
          'usar_alt_lista'=>$usar_alt_lista,
          'item_economico'=>isset($data['economico'])?1:0,
          'tiene_variantes'=>isset($data['tiene_variantes'])?1:0,
          'variante_de'=>$data['variante_de'],
          'tiene_relacionados'=>isset($data['tiene_relacionados'])?1:0,
          'relacionado_con'=>$data['relacionado_con'],
          'texto_relacion'=>$data['texto_relacion'],
          'portada'=>isset($data['portada'])?1:0,
          'item_top'=>isset($data['topventas'])?1:0,
          'google_market_be'=>isset($data['google_market_be'])?1:0,
          'item_cola'=>$data['cola'],
          'composicion'=>$data['composicion'],
          'limpieza'=>$limp,
          'uso'=>$uso,
          'meta_title'=>$data['meta_title'],
          'meta_description'=>$data['meta_description'],
          'meta_keywords'=>$data['meta_keywords'],
          'imgdetalt'=>$data['imgdetalt'],
          'imgdettitle'=>$data['imgdettitle'],
          'imgambalt'=>$data['imgambalt'],
          'imgambtitle'=>$data['imgambtitle']
          );

      $this->db->insert('demo_items',$itemarray);
      $lastid=$this->db->insert_id();
      
      if(isset($data['usar_alt_lista'])){
	      foreach ($data['usar_alt_lista'] as $key=>$value){
	        $datos_img_cat_ambiente=array(
	            'iditem'=>$lastid,
	            'idcategoria'=>$value
	        );
	        $this->db->insert('demo_item_cat_ambiente',$datos_img_cat_ambiente);
	      }
      }
      if(isset($data['gama'])){
        foreach ($data['gama'] as $key=>$value){
          $gamaarray=array(
              'gama_item_item'=>$lastid,
              'gama_item_gama'=>$value
          );
          $this->db->insert('demo_gama_item',$gamaarray);
        }
      }
      else {
        $gamaarray =array(
              'gama_item_item'=>$lastid,
              'gama_item_gama'=>'0'
          );
        $this->db->insert('demo_gama_item',$gamaarray);
      }
      if (isset($data['estilo'])){
        foreach ($data['estilo'] as $key=>$value){
          $estiloarray=array(
              'estilo_item_item'=>$lastid,
              'estilo_item_estilo'=>$value
          );
           $this->db->insert('demo_estilo_item',$estiloarray);
        }
      }
      else {
        $estiloarray=array(
              'estilo_item_item'=>$lastid,
              'estilo_item_estilo'=>'0'
          );
        $this->db->insert('demo_estilo_item',$estiloarray);
      }

      if (isset($data['nuevas_categorias'])){
        foreach ($data['nuevas_categorias'] as $key=>$value){
          $categoriasarray=array(
              'nuevacategoria_item_id'=>$lastid,
              'nueva_categoria_id'=>$value
          );
					$this->db->insert('nueva_categoria_item',$categoriasarray);
        }
      }

      if(!isset($data['stock']) || $data['stock']>1000 || $data['stock']=="")
        $stock=60000;
      else $stock=$data['stock'];
      $stockarray=array(
          'stock_item_fk'=>$lastid,
          'stock_quantity'=>$stock,
          'stock_auto_allocate_status'=>0
      );
       $this->db->insert('item_stock',$stockarray);
      return $this->get_item_data($lastid);
    }
    function demo_insert_fab(){
      $data=$this->input->post(NULL, TRUE);
      if (count($data['cats'])>1){
	      $categorias=$data['cats'];
        $ultimo_elemento=str_replace('Foto Murales', 'Fotomurales',array_pop($categorias));
        $resto_elementos=str_replace('Foto Murales', 'Fotomurales',implode(', ', $categorias));

        $meta_title=$resto_elementos.' y '.$ultimo_elemento.' '.$data['name'];
        $meta_description='Tenemos las mejores colecciones de '.$resto_elementos.' y '.$ultimo_elemento.' creadas por '.$data['name'].'. Catálogos actualizados en nuestra web. ¡Descúbrelos!';
      }
      else{
	      $categorias=$data['cats'];
        $resto_elementos=str_replace('Foto Murales', 'Fotomurales',implode(', ', $categorias));
        $meta_title=$resto_elementos.' '.$data['name'];
        $meta_description='Tenemos las mejores colecciones de '.$resto_elementos.' creadas por '.$data['name'].'. Catálogos actualizados en nuestra web. ¡Descúbrelos!';
      }
			$cats=implode(',',$data['cats']);
      $fabarray=array('cat_name'=>$data['name'],'fabmargen'=> $data['fabmargen'],'cat_text'=> $data['cat_text'],'cat_text2'=> $data['cat_text2'],'meta_titlef'=>$data['meta_title'],
          'meta_descriptionf'=>$data['meta_description'],
          'meta_keywordsf'=>$data['meta_keywords'],'cats'=>$cats,'disc'=>($data['disc']=="true")?1:0);
     
      $this->db->insert('demo_categories',$fabarray);
      $lastid=$this->db->insert_id();
      return $this->get_category($lastid);
    }
    function demo_insert_col(){
      $data=$this->input->post(NULL, TRUE);
     $cats=implode(',',$data['cats']);
      $fabarray=array('coleccion_cat_id'=>$data['fab'],'coleccion_name'=>$data['name'],'col_text'=>  $data['col_text'],'meta_titlec'=>$data['meta_title'],
          'meta_descriptionc'=>$data['meta_description'],
          'meta_keywordsc'=>$data['meta_keywords'],'plazo'=>$data['plazo'],'ccats'=>$cats,'cdisc'=>($data['disc']=="true")?1:0,'novedad_bool'=>($data['novedad_bool']=="true")?1:0);
      $this->db->insert('demo_coleccion',$fabarray);
      $lastid=$this->db->insert_id();
      return $this->get_coleccion($lastid);
    }
    function demo_insert_mod(){
      $data=$this->input->post(NULL, TRUE);
     
      $fabarray=array('modelo_coleccion_id'=>$data['cole'],'modelo_name'=>$data['name'],'mod_text'=>$data['mod_text']);
      $this->db->insert('demo_modelo',$fabarray);
      $lastid=$this->db->insert_id();
      return $this->get_modelo($lastid);
    }
    function demo_insert_her(){
      $data=$this->input->post(NULL, TRUE);

      $meta_title=$data['name'];
      if (isset($data['meta_title']))
	      $meta_title=$data['meta_title'];
	    
      $meta_description=$data['name'];
      if (isset($data['meta_description']))
	      $meta_description=$data['meta_description'];
	    
      $meta_keywords='';
      if (isset($data['meta_keywords']))
	      $meta_keywords=$data['meta_keywords'];
	    
      $itemarray=array(
          'portada'=>$data['portada'],
          'item_top'=>$data['topventas'],
          'item_ref'=>$data['ref'],
          'item_name'=>$data['name'],
          'item_price'=>$data['precio'],
          'item_tipo'=>5,
          'item_unidad'=>"Unidad",
          'meta_title'=>$meta_title,
          'meta_description'=>$meta_description,
          'meta_keywords'=>$meta_keywords,
      'item_text'=>$data['her_text']);
      $this->db->insert('demo_items',$itemarray);
      $lastid=$this->db->insert_id();
      return $this->get_category($lastid);
    }
    function demo_update_fab(){
      $data=$this->input->post(NULL, TRUE);

      if (count($data['cats'])>1){
	      $categorias=$data['cats'];
        $ultimo_elemento=str_replace('Foto Murales', 'Fotomurales',array_pop($categorias));
        $resto_elementos=str_replace('Foto Murales', 'Fotomurales',implode(', ', $categorias));

        $meta_title=$resto_elementos.' y '.$ultimo_elemento.' '.$data['name'];
        $meta_description='Tenemos las mejores colecciones de '.$resto_elementos.' y '.$ultimo_elemento.' creadas por '.$data['name'].'. Catálogos actualizados en nuestra web. ¡Descúbrelos!';
      }
      else{
	      $categorias=$data['cats'];
        $resto_elementos=str_replace('Foto Murales', 'Fotomurales',implode(', ', $categorias));
        $meta_title=$resto_elementos.' '.$data['name'];
        $meta_description='Tenemos las mejores colecciones de '.$resto_elementos.' creadas por '.$data['name'].'. Catálogos actualizados en nuestra web. ¡Descúbrelos!';
      }

      $cats=implode(',',$data['cats']);
      $fabarray=array('cat_name'=>$data['name'],'fabmargen'=> $data['fabmargen'],'cat_text'=>$data['cat_text'],'cat_text2'=> $data['cat_text2'],
      	//'meta_titlef'=>$data['meta_title'],
        //'meta_descriptionf'=>$data['meta_description'],
      	'meta_titlef'=>$meta_title,
        'meta_descriptionf'=>$meta_description,
        'meta_keywordsf'=>$data['meta_keywords'],
        'cats'=>$cats,'disc'=>($data['disc']=="true")?1:0);
       echo $data['cat_text'];
      $cat_id=$data['fab'];
      if(isset($cat_id)&& $cat_id!="")
      $this->db->where('cat_id',$cat_id)->update('demo_categories',$fabarray);
    }
    function demo_update_fab_seo(){
      $data=$this->input->post(NULL, TRUE);
      $fabarray=array(
      	'cat_text'=>$data['cat_text']
      );
      /*
      // Las metas del fabricante se generan al guardar la ficha del fabricante, para asegurar el texto exacto que permita no tener duplicidades en la web
      $fabarray=array(
      	'cat_text'=>$data['cat_text'],
      	'meta_titlef'=>$data['meta_title'],
        'meta_descriptionf'=>$data['meta_description'],
        'meta_keywordsf'=>$data['meta_keywords']
      );
      */
      $cat_id=$data['fab'];
      if(isset($cat_id) && $cat_id!="")
	      $this->db->where('cat_id',$cat_id)->update('demo_categories',$fabarray);
    }
    function demo_save_fabricante_seo(){
      $data=$this->input->post(NULL, TRUE);
			/*
			print '<pre><xmp>';
			print_r($data);
			print '</xmp></pre>';
			exit;
	    [nueva_categoria_id] => 1
	    [descripcion_categoria] => 
	    [meta_title_estilo] => 
	    [meta_description_estilo] => 
	    [meta_keywords_estilo] => 
	    [test] => Guardar
			*/
      $datos_array=array(
      	'cat_text'=>$data['cat_text'],
      	'meta_titlef'=>$data['meta_title_categoria'],
        'meta_descriptionf'=>$data['meta_description_categoria'],
        'meta_keywordsf'=>$data['meta_keywords_categoria']
      );

      $cat_id=$data['cat_id'];
      if(isset($cat_id) && $cat_id!="")
	      $this->db->where('cat_id',$cat_id)->update('demo_categories',$datos_array);
      
      $datos_array_ekam=array(
      	'cat_id'=>$data['cat_id'],
      	'cat_text'=>$data['cat_text_ekam'],
      	'meta_titlef'=>$data['meta_title_categoria_ekam'],
        'meta_descriptionf'=>$data['meta_description_categoria_ekam'],
        'meta_keywordsf'=>$data['meta_keywords_categoria_ekam']
      );
      if ($data['cat_id_ekam']==0){
	      $this->db->insert('demo_categories_ekam',$datos_array_ekam);
	      $lastid=$this->db->insert_id();
      }
      else{
	      $lastid=$this->db->where('cat_id',$data['cat_id_ekam'])->update('demo_categories_ekam',$datos_array_ekam);
      }
    }

    // ---- FAQs ----

    function get_faqs_admin($page_type='', $page_id=0){
      $q = $this->db->select('*')->from('demo_faqs');
      if ($page_type !== '') $q = $q->where('page_type', $page_type);
      if ($page_id > 0) $q = $q->where('page_id', (int)$page_id);
      return $q->order_by('page_type ASC, page_id ASC, orden ASC, faq_id ASC')->get()->result();
    }

    function get_faq($faq_id){
      return $this->db->where('faq_id',(int)$faq_id)->get('demo_faqs')->row();
    }

    function get_faqs_frontend($page_type, $page_id=0){
      return $this->db->where('page_type',$page_type)->where('page_id',(int)$page_id)
        ->where('activo',1)->order_by('orden ASC, faq_id ASC')->get('demo_faqs')->result();
    }

    function save_faq(){
      $data = $this->input->post(NULL, TRUE);
      $row = array(
        'page_type' => ($data['page_type'] === 'categoria') ? 'categoria' : 'home',
        'page_id'   => (int)$data['page_id'],
        'pregunta'  => $data['pregunta'],
        'respuesta' => $data['respuesta'],
        'orden'     => (int)$data['orden'],
        'activo'    => isset($data['activo']) ? 1 : 0,
      );
      $faq_id = (int)$data['faq_id'];
      if ($faq_id > 0)
        $this->db->where('faq_id', $faq_id)->update('demo_faqs', $row);
      else
        $this->db->insert('demo_faqs', $row);
    }

    function delete_faq($faq_id){
      $this->db->where('faq_id',(int)$faq_id)->delete('demo_faqs');
    }

    // ---- /FAQs ----

    function demo_update_col(){
      $data=$this->input->post(NULL, TRUE);
      $cats=implode(',',$data['cats']);
      $fabarray=array('coleccion_cat_id'=>$data['fab'],'coleccion_name'=>$data['name'],'col_text'=>$data['col_text'],'meta_titlec'=>$data['meta_title'],
          'meta_descriptionc'=>$data['meta_description'],
          'meta_keywordsc'=>$data['meta_keywords'],'plazo'=>$data['plazo'],'ccats'=>$cats,'cdisc'=>($data['disc']=="true")?1:0,'novedad_bool'=>($data['novedad_bool']=="true")?1:0);
      $lastid=$this->db->where('coleccion_id',$data['col'])->update('demo_coleccion',$fabarray);
      
      $this->db->where('item_coleccion_id',$data['col'])->update('demo_items',array('item_cat_fk'=>$data['fab']));
    }
    function demo_update_col_seo(){
      $data=$this->input->post(NULL, TRUE);
			$col_text_publico=0;
			if(isset($data['col_text_publico']))
				$col_text_publico=$data['col_text_publico'];
			$greca_misma_coleccion_be=0;
			if(isset($data['greca_misma_coleccion_be']))
				$greca_misma_coleccion_be=$data['greca_misma_coleccion_be'];
			$xml_META_be=0;
			if(isset($data['xml_META_be']))
				$xml_META_be=$data['xml_META_be'];
      $fabarray=array(
      	'col_intro'=>isset($data['col_intro'])?$data['col_intro']:'',
      	'col_text'=>$data['col_text'],
      	'col_text_publico'=>$col_text_publico,
      	'greca_misma_coleccion_be'=>$greca_misma_coleccion_be,
      	'xml_META_be'=>$xml_META_be,
      	'meta_titlec'=>$data['meta_title'],
        'meta_descriptionc'=>$data['meta_description'],
        'meta_keywordsc'=>$data['meta_keywords']
      );
      $coleccion_id=$data['col'];
      if(isset($coleccion_id) && $coleccion_id!="")
	      $this->db->where('coleccion_id',$coleccion_id)->update('demo_coleccion',$fabarray);
    }
    function demo_save_coleccion_seo(){
      $data=$this->input->post(NULL, TRUE);
			/*
			print '<pre><xmp>';
			print_r($data);
			print '</xmp></pre>';
			exit;
	    [nueva_categoria_id] => 1
	    [descripcion_categoria] => 
	    [meta_title_estilo] => 
	    [meta_description_estilo] => 
	    [meta_keywords_estilo] => 
	    [test] => Guardar
			*/
			$col_text_publico=0;
			if(isset($data['col_text_publico']))
				$col_text_publico=$data['col_text_publico'];
			$greca_misma_coleccion_be=0;
			if(isset($data['greca_misma_coleccion_be']))
				$greca_misma_coleccion_be=$data['greca_misma_coleccion_be'];
			$xml_META_be=0;
			if(isset($data['xml_META_be']))
				$xml_META_be=$data['xml_META_be'];

      $datos_array=array(
      	'col_intro'=>isset($data['col_intro'])?$data['col_intro']:'',
      	'col_text'=>$data['col_text'],
      	'col_text_publico'=>$col_text_publico,
      	'greca_misma_coleccion_be'=>$greca_misma_coleccion_be,
      	'xml_META_be'=>$xml_META_be,
      	'meta_titlec'=>$data['meta_title_coleccion'],
        'meta_descriptionc'=>$data['meta_description_coleccion'],
        'meta_keywordsc'=>$data['meta_keywords_coleccion']
      );

      $coleccion_id=$data['coleccion_id'];
      if(isset($coleccion_id) && $coleccion_id!="")
	      $this->db->where('coleccion_id',$coleccion_id)->update('demo_coleccion',$datos_array);
      
      $datos_array_ekam=array(
      	'coleccion_id'=>$data['coleccion_id'],
      	'col_text'=>$data['col_text_ekam'],
      	'meta_titlec'=>$data['meta_title_coleccion_ekam'],
        'meta_descriptionc'=>$data['meta_description_coleccion_ekam'],
        'meta_keywordsc'=>$data['meta_keywords_coleccion_ekam']
      );
      if ($data['coleccion_id_ekam']==0){
	      $this->db->insert('demo_coleccion_ekam',$datos_array_ekam);
	      $lastid=$this->db->insert_id();
      }
      else{
	      $lastid=$this->db->where('coleccion_id',$data['coleccion_id_ekam'])->update('demo_coleccion_ekam',$datos_array_ekam);
      }
    }
    
    function demo_update_estilo(){
      $data=$this->input->post(NULL, TRUE);
			/*
			print '<pre><xmp>';
			print_r($data);
			print '</xmp></pre>';
			exit;
			*/
			$cats='';
			if(isset($data['cats']))
				$cats=implode(',',$data['cats']);
			$activo=0;
			if(isset($data['activo']))
				$activo=$data['activo'];
			$principal=0;
			if(isset($data['principal']))
				$principal=$data['principal'];
			$descripcion_estilo_publico=0;
			if(isset($data['descripcion_estilo_publico']))
				$descripcion_estilo_publico=$data['descripcion_estilo_publico'];

      $fabarray=array(
      	'estilo_name'=>$data['name'],
      	'cats'=>$cats,
      	'activo'=>$activo,
      	'principal'=>$principal,
      	'descripcion_estilo_publico'=>$descripcion_estilo_publico,
      	'h1_estilo'=>$data['h1_estilo'],
      	'h2_estilo'=>$data['h2_estilo'],
      	'descripcion_estilo'=>$data['descripcion_estilo'],
      	'meta_title_estilo'=>$data['meta_title_estilo'],
      	'meta_description_estilo'=>$data['meta_description_estilo'],
      	'meta_keywords_estilo'=>$data['meta_keywords_estilo']
      );

      $lastid=$this->db->where('estilo_id',$data['estilo'])->update('demo_estilo',$fabarray);
    }

    function demo_save_categoria_seo(){
      $data=$this->input->post(NULL, TRUE);
			/*
			print '<pre><xmp>';
			print_r($data);
			print '</xmp></pre>';
			exit;
	    [nueva_categoria_id] => 1
	    [descripcion_categoria] => 
	    [meta_title_estilo] => 
	    [meta_description_estilo] => 
	    [meta_keywords_estilo] => 
	    [test] => Guardar
			*/
			$nueva_categoria_activo=0;
			if(isset($data['nueva_categoria_activo']))
				$nueva_categoria_activo=$data['nueva_categoria_activo'];
			$categoria_publico=0;
			if(isset($data['categoria_publico']))
				$categoria_publico=$data['categoria_publico'];

      $datos_array=array(
      	'nueva_categoria_name'=>$data['nueva_categoria_name'],
      	'nueva_categoria_name_url'=>text2url($data['nueva_categoria_name']),
      	'nombre_filtro'=>$data['nombre_filtro'],
      	'tipo_producto'=>$data['tipo_producto'],
      	'idnueva_categoria_familia'=>$data['idnueva_categoria_familia'],
      	'nueva_categoria_activo'=>$nueva_categoria_activo,
      	'categoria_publico'=>$categoria_publico,
      	'h1_categoria'=>$data['h1_categoria'],
      	'intro_categoria'=>isset($data['intro_categoria']) ? $data['intro_categoria'] : '',
      	//'h2_categoria'=>$data['h2_categoria'],
      	'descripcion_categoria'=>$data['descripcion_categoria'],
      	'meta_title_categoria'=>$data['meta_title_categoria'],
      	'meta_description_categoria'=>$data['meta_description_categoria'],
      	'meta_keywords_categoria'=>$data['meta_keywords_categoria']
      );
      if ($data['nueva_categoria_id']==0){
	      $this->db->insert('nueva_categoria',$datos_array);
	      $lastid=$this->db->insert_id();

	      $data['nueva_categoria_id']=$lastid;
      }
      else{
	      $lastid=$this->db->where('nueva_categoria_id',$data['nueva_categoria_id'])->update('nueva_categoria',$datos_array);
      }

			$nueva_categoria_activo=0;
			if(isset($data['nueva_categoria_activo_ekam']))
				$nueva_categoria_activo=$data['nueva_categoria_activo_ekam'];
			$categoria_publico=0;
			if(isset($data['categoria_publico_ekam']))
				$categoria_publico=$data['categoria_publico_ekam'];

      $datos_array_ekam=array(
      	'nueva_categoria_id'=>$data['nueva_categoria_id'],
      	'tipo_producto'=>$data['tipo_producto'],
      	'idnueva_categoria_familia'=>$data['idnueva_categoria_familia'],
      	'nueva_categoria_name'=>$data['nueva_categoria_name'],
      	'nueva_categoria_name_url'=>text2url($data['nueva_categoria_name']),
      	'nombre_filtro'=>$data['nombre_filtro_ekam'],
      	'nueva_categoria_activo'=>$nueva_categoria_activo,
      	'categoria_publico'=>$categoria_publico,
      	'h1_categoria'=>$data['h1_categoria_ekam'],
      	//'h2_categoria'=>$data['h2_categoria_ekam'],
      	'descripcion_categoria'=>$data['descripcion_categoria_ekam'],
      	'meta_title_categoria'=>$data['meta_title_categoria_ekam'],
      	'meta_description_categoria'=>$data['meta_description_categoria_ekam'],
      	'meta_keywords_categoria'=>$data['meta_keywords_categoria_ekam']
      );
      if ($data['nueva_categoria_id_ekam']==0){
	      $this->db->insert('nueva_categoria_ekam',$datos_array_ekam);
	      $lastid=$this->db->insert_id();
      }
      else{
	      $lastid=$this->db->where('nueva_categoria_id',$data['nueva_categoria_id_ekam'])->update('nueva_categoria_ekam',$datos_array_ekam);
      }
    

    }

    function demo_save_categoria_proyecto(){
      $data=$this->input->post(NULL, TRUE);
			
			$categoria_publico=0;
			if(isset($data['categoria_publico']))
				$categoria_publico=$data['categoria_publico'];

      $datos_array=array(
      	'proyecto_categoria_name'=>$data['proyecto_categoria_name'],
      	'proyecto_categoria_name_url'=>text2url($data['proyecto_categoria_name']),
      	'nombre_filtro'=>$data['nombre_filtro'],
      	'categoria_publico'=>$categoria_publico,
      	'h1_categoria'=>$data['h1_categoria'],
      	'h2_categoria'=>$data['h2_categoria'],
      	'descripcion_categoria'=>$data['descripcion_categoria'],
      	'meta_title_categoria'=>$data['meta_title_categoria'],
      	'meta_description_categoria'=>$data['meta_description_categoria'],
      	'meta_keywords_categoria'=>$data['meta_keywords_categoria']
      );


      if ($data['idproyecto_categoria']==0){
				$lastid= $this->db->select_max("idproyecto_categoria")->get("proyecto_categoria")->row()->idproyecto_categoria;
	      $datos_array['idproyecto_categoria']=$lastid+1;

	      $this->db->insert('proyecto_categoria',$datos_array);
      }
      else{
	      $lastid=$this->db->where('idproyecto_categoria',$data['idproyecto_categoria'])->update('proyecto_categoria',$datos_array);
      }
    }

    function demo_save_categoria_noticia(){
      $data=$this->input->post(NULL, TRUE);
			
			$categoria_publico=0;
			if(isset($data['categoria_publico']))
				$categoria_publico=$data['categoria_publico'];

      $datos_array=array(
      	'noticia_categoria_name'=>$data['noticia_categoria_name'],
      	'noticia_categoria_name_url'=>text2url($data['noticia_categoria_name']),
      	'nombre_filtro'=>$data['nombre_filtro'],
      	'categoria_publico'=>$categoria_publico,
      	'h1_categoria'=>$data['h1_categoria'],
      	'h2_categoria'=>$data['h2_categoria'],
      	'descripcion_categoria'=>$data['descripcion_categoria'],
      	'meta_title_categoria'=>$data['meta_title_categoria'],
      	'meta_description_categoria'=>$data['meta_description_categoria'],
      	'meta_keywords_categoria'=>$data['meta_keywords_categoria']
      );


      if ($data['idnoticia_categoria']==0){
				$lastid= $this->db->select_max("idnoticia_categoria")->get("noticia_categoria")->row()->idnoticia_categoria;
	      $datos_array['idnoticia_categoria']=$lastid+1;

	      $this->db->insert('noticia_categoria',$datos_array);
      }
      else{
	      $lastid=$this->db->where('idnoticia_categoria',$data['idnoticia_categoria'])->update('noticia_categoria',$datos_array);
      }
    }

    function demo_save_proyecto(){
      $data=$this->input->post(NULL, TRUE);

			$proyecto_publico=0;
			if(isset($data['proyecto_publico']))
				$proyecto_publico=$data['proyecto_publico'];

      $datos_array=array(
      	'idproyecto_categoria'=>$data['idproyecto_categoria'],
      	'proyecto_fecha'=>$data['proyecto_fecha'],
      	'proyecto_name'=>$data['proyecto_name'],
      	'proyecto_name_url'=>text2url($data['proyecto_name']),
      	'resumen_proyecto'=>$data['resumen_proyecto'],
      	'descripcion_proyecto'=>$data['descripcion_proyecto'],
      	'proyecto_publico'=>$proyecto_publico,
      	'meta_title_proyecto'=>$data['meta_title_proyecto'],
      	'meta_description_proyecto'=>$data['meta_description_proyecto'],
      	'meta_keywords_proyecto'=>$data['meta_keywords_proyecto']
      );

      if ($data['idproyecto']==0){
				$lastid= $this->db->select_max("idproyecto")->get("proyecto")->row()->idproyecto;

				$id_proyecto=$lastid+1;
	      $datos_array['idproyecto']=$id_proyecto;

	      $this->db->insert('proyecto',$datos_array);
      }
      else{
				$id_proyecto=$data['idproyecto'];
	      $lastid=$this->db->where('idproyecto',$data['idproyecto'])->update('proyecto',$datos_array);
      }

	  	$output_dir = "includes/images/proyectos/";

      if (isset($data['imagenes'])){
      	foreach ($data['imagenes'] as $idimagen => $datos_img) {
				  $nombre=text2url($datos_img['nombre']);
		      $datos_imagen_modif=array(
		      	'titulo'=>$datos_img['titulo'],
		      	'nombre_imagen'=>trim($nombre),
		      	'url_tienda'=>trim($datos_img['url_tienda']),
		      	'alt'=>$datos_img['alt'],
		      	'title'=>$datos_img['title'],
		      );
		      if (trim($nombre) != trim($datos_img['nombre_orig'])){
			      $this->renombrar_imagenes($output_dir, $datos_img['nombre_orig'], $nombre, $idimagen);
		      }

		      $updated_imagen=$this->db->where('idproyecto_img',$idimagen)->update('proyecto_img',$datos_imagen_modif);
      	}
      }


      // Tratamiento guardar nueva imagen
			if (isset($_FILES["nueva_imagen_proyecto"]) && trim($_FILES["nueva_imagen_proyecto"]['name'])!='') {
			  //Filter the file types , if you want.
			  if ($_FILES["nueva_imagen_proyecto"]["error"] > 0) {
			    echo "Error: " . $_FILES["nueva_imagen_proyecto"]["error"] . "<br>";
			  } 
			  else {

			    $name =$_POST['nuevo_nombre'];
				  $name=text2url($name);
				  $fitxategi_zatiak=explode('.', $_FILES["nueva_imagen_proyecto"]['name']);

				  $extensioa=$fitxategi_zatiak[count($fitxategi_zatiak)-1];
		      
		      $datos_imagen=array(
		      	'idproyecto'=>$id_proyecto,
		      	'nombre_imagen'=>$name,
		      	'titulo'=>$data['nuevo_titulo'],
		      	'url_tienda'=>$data['nueva_url'],
		      	'alt'=>$data['nuevo_alt'],
		      	'title'=>$data['nuevo_title'],
		      );

					$lastid_img=$this->db->select_max("idproyecto_img")->get("proyecto_img")->row()->idproyecto_img;

					$id_proyecto_img=$lastid_img+1;
		      $datos_imagen['idproyecto_img']=$id_proyecto_img;
		      
		      $this->db->insert('proyecto_img',$datos_imagen);
			     
		      $targetPath = $output_dir;

		      $this->subir_imagen($_FILES["nueva_imagen_proyecto"]["tmp_name"], $targetPath, $name, $id_proyecto_img, $extensioa);
		    }
		  }
		  return $id_proyecto;
		}

    function demo_save_noticia(){
      $data=$this->input->post(NULL, TRUE);

			$noticia_publico=0;
			if(isset($data['noticia_publico']))
				$noticia_publico=$data['noticia_publico'];

      $datos_array=array(
      	'idnoticia_categoria'=>$data['idnoticia_categoria'],
      	'noticia_fecha'=>$data['noticia_fecha'],
      	'noticia_name'=>$data['noticia_name'],
      	'noticia_name_url'=>text2url($data['noticia_name']),
      	'resumen_noticia'=>$data['resumen_noticia'],
      	'descripcion_noticia'=>$data['descripcion_noticia'],
      	'noticia_publico'=>$noticia_publico,
      	'meta_title_noticia'=>$data['meta_title_noticia'],
      	'meta_description_noticia'=>$data['meta_description_noticia'],
      	'meta_keywords_noticia'=>$data['meta_keywords_noticia']
      );

      if ($data['idnoticia']==0){
				$lastid= $this->db->select_max("idnoticia")->get("noticia")->row()->idnoticia;

				$id_noticia=$lastid+1;
	      $datos_array['idnoticia']=$id_noticia;

	      $this->db->insert('noticia',$datos_array);
      }
      else{
				$id_noticia=$data['idnoticia'];
	      $lastid=$this->db->where('idnoticia',$data['idnoticia'])->update('noticia',$datos_array);
      }

	  	$output_dir = "includes/images/noticias/";

      if (isset($data['imagenes'])){
      	foreach ($data['imagenes'] as $idimagen => $datos_img) {
				  $nombre=text2url($datos_img['nombre']);
		      $datos_imagen_modif=array(
		      	'titulo'=>$datos_img['titulo'],
		      	'nombre_imagen'=>trim($nombre),
		      	'url_tienda'=>trim($datos_img['url_tienda']),
		      	'alt'=>$datos_img['alt'],
		      	'title'=>$datos_img['title'],
		      );
		      if (trim($nombre) != trim($datos_img['nombre_orig'])){
			      $this->renombrar_imagenes($output_dir, $datos_img['nombre_orig'], $nombre, $idimagen);
		      }

		      $updated_imagen=$this->db->where('idnoticia_img',$idimagen)->update('noticia_img',$datos_imagen_modif);
      	}
      }


      // Tratamiento guardar nueva imagen
			if (isset($_FILES["nueva_imagen_noticia"]) && trim($_FILES["nueva_imagen_noticia"]['name'])!='') {
			  //Filter the file types , if you want.
			  if ($_FILES["nueva_imagen_noticia"]["error"] > 0) {
			    echo "Error: " . $_FILES["nueva_imagen_noticia"]["error"] . "<br>";
			  } 
			  else {

			    $name =$_POST['nuevo_nombre'];
				  $name=text2url($name);
				  $fitxategi_zatiak=explode('.', $_FILES["nueva_imagen_noticia"]['name']);

				  $extensioa=$fitxategi_zatiak[count($fitxategi_zatiak)-1];
		      
		      $datos_imagen=array(
		      	'idnoticia'=>$id_noticia,
		      	'nombre_imagen'=>$name,
		      	'titulo'=>$data['nuevo_titulo'],
		      	'url_tienda'=>$data['nueva_url'],
		      	'alt'=>$data['nuevo_alt'],
		      	'title'=>$data['nuevo_title'],
		      );

					$lastid_img=$this->db->select_max("idnoticia_img")->get("noticia_img")->row()->idnoticia_img;

					$id_noticia_img=$lastid_img+1;
		      $datos_imagen['idnoticia_img']=$id_noticia_img;
		      
		      $this->db->insert('noticia_img',$datos_imagen);
			     
		      $targetPath = $output_dir;

		      $this->subir_imagen($_FILES["nueva_imagen_noticia"]["tmp_name"], $targetPath, $name, $id_noticia_img, $extensioa);
		    }
		  }
		  return $id_noticia;
		}

    function demo_save_tipo_producto_seo(){
      $data=$this->input->post(NULL, TRUE);

      $datos_array=array(
      	'intro_tipo_producto'=>isset($data['intro_tipo_producto'])?$data['intro_tipo_producto']:'',
      	'descripcion_tipo_producto'=>$data['descripcion_tipo_producto'],
      	'meta_title_tipo_producto'=>$data['meta_title_tipo_producto'],
      	'meta_description_tipo_producto'=>$data['meta_description_tipo_producto'],
      	'meta_keywords_tipo_producto'=>$data['meta_keywords_tipo_producto']
      );
      $this->db->where('tipo_producto_id',$data['tipo_producto_id'])->update('tipo_producto',$datos_array);
      /*
      if ($data['nueva_categoria_id']==0){
	      $this->db->insert('nueva_categoria',$datos_array);
	      $lastid=$this->db->insert_id();

	      $data['nueva_categoria_id']=$lastid;
      }
      else{
	      $lastid=$this->db->where('tipo_producto_id',$data['tipo_producto_id'])->update('tipo_producto',$datos_array);
      }
      */

      $datos_array_ekam=array(
      	'descripcion_tipo_producto'=>$data['descripcion_tipo_producto_ekam'],
      	'meta_title_tipo_producto'=>$data['meta_title_tipo_producto_ekam'],
      	'meta_description_tipo_producto'=>$data['meta_description_tipo_producto_ekam'],
      	'meta_keywords_tipo_producto'=>$data['meta_keywords_tipo_producto_ekam']
      );
      
      $this->db->where('tipo_producto_id',$data['tipo_producto_id'])->update('tipo_producto_ekam',$datos_array_ekam);
      /*
      if ($data['nueva_categoria_id_ekam']==0){
	      $this->db->insert('nueva_categoria_ekam',$datos_array_ekam);
	      $lastid=$this->db->insert_id();
      }
      else{
	      $lastid=$this->db->where('tipo_producto_id',$data['tipo_producto_id_ekam'])->update('tipo_producto_ekam',$datos_array_ekam);
      }
    	*/

    }

    function renombrar_imagenes($targetPath, $old_name, $name, $id){
    	$old_1=$targetPath . $old_name."-".$id.".jpg";
    	$old_2=$targetPath . $old_name."-th-".$id.".jpg";
    	$old_3=$targetPath . $old_name."-".$id.".webp";
    	$old_4=$targetPath . $old_name."-th-".$id.".webp";

    	$new_1=$targetPath . $name."-".$id.".jpg";
    	$new_2=$targetPath . $name."-th-".$id.".jpg";
    	$new_3=$targetPath . $name."-".$id.".webp";
    	$new_4=$targetPath . $name."-th-".$id.".webp";

    	/*
    	echo "<br />$old_1  $new_1";
    	echo "<br />$old_2  $new_2";
    	echo "<br />$old_3  $new_3";
    	echo "<br />$old_4  $new_4";
			*/
			rename($old_1, $new_1);
			rename($old_2, $new_2);
			rename($old_3, $new_3);
			rename($old_4, $new_4);
    }

    function borrar_imagenes($targetPath, $name, $id){
    	$img_1=$targetPath . $name."-".$id.".jpg";
    	$img_2=$targetPath . $name."-th-".$id.".jpg";
    	$img_3=$targetPath . $name."-".$id.".webp";
    	$img_4=$targetPath . $name."-th-".$id.".webp";

      unlink($img_1);
      unlink($img_2);
      unlink($img_3);
      unlink($img_4);
    }

    function subir_imagen($file_name, $targetPath, $name, $id, $extensioa){
      $targetFile = $targetPath . $name."-".$id.".".$extensioa;
      $targetFile_aux = $targetPath . $name."-th-".$id.".jpg";

      // Borramos las anteriores
      //unlink($targetFile);
      //unlink($targetFile_aux);

      move_uploaded_file($file_name, $targetFile);
      
      $this->webpImage($targetFile, 75);
      $imgsize = getimagesize($targetFile);
      if ($imgsize) {
        $image = imagecreatefromjpeg($targetFile);
      }

      $width = 380;
      $height = $imgsize[1] / $imgsize[0] * $width; //This maintains proportions
      $src_w = $imgsize[0];
      $src_h = $imgsize[1];
      $picture = imagecreatetruecolor($width, $height);
      imagealphablending($picture, false);
      imagesavealpha($picture, true);
      $bool = imagecopyresampled($picture, $image, 0, 0, 0, 0, $width, $height, $src_w, $src_h);
      if ($bool) {
        header("Content-Type: image/jpeg");
        imageJPEG($picture, $targetFile_aux, 80);

	      $this->webpImage($targetFile_aux, 75);
      }

      imagedestroy($picture);
      imagedestroy($image);
    }
		
		public static function webpImage($source, $quality = 100, $removeOld = false){
        $dir = pathinfo($source, PATHINFO_DIRNAME);
        $name = pathinfo($source, PATHINFO_FILENAME);
        $destination = $dir . DIRECTORY_SEPARATOR . $name . '.webp';
        $info = getimagesize($source);
        $isAlpha = false;
        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);
        elseif ($isAlpha = $info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source);
        } elseif ($isAlpha = $info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
        } else {
            return $source;
        }
        if ($isAlpha) {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }
        imagewebp($image, $destination, $quality);

        if ($removeOld)
            unlink($source);

        return $destination;
    }

    function demo_update_mod(){
      $data=$this->input->post(NULL, TRUE);
     
      $fabarray=array('modelo_coleccion_id'=>$data['cole'],'modelo_name'=>$data['name'],'mod_text'=>$data['mod_text']);
      $this->db->where('modelo_id',$data['mod'])->update('demo_modelo',$fabarray);
    }
    function demo_update_her(){
      $data=$this->input->post(NULL, TRUE);
       $itemarray=array(
          'portada'=>(isset($data['portada']))?1:0,
          'item_top'=>(isset($data['topventas']))?1:0,
          'item_ref'=>$data['ref'],
          'item_name'=>$data['name'],
          'item_price'=>$data['precio'],
          'meta_title'=>$data['meta_title'],
          'meta_description'=>$data['meta_description'],
          'meta_keywords'=>$data['meta_keywords'],
          'item_text'=>$data['her_text']);
       $item_id=$data['iher'];
     
      $this->db->where('item_id',$item_id)->update('demo_items',$itemarray);
      echo json_encode($itemarray);
    }
    function quita_portada($idtipo, $item_id=0){
			$data=$this->input->post(NULL, TRUE);
				$itemarray=array(
					'portada'=>0,
				);
			
			if($item_id!=0)
				$this->db->where('item_id',$item_id)->update('demo_items',$itemarray);
			else
				$this->db->where('item_tipo',$idtipo)->update('demo_items',$itemarray);
    }
    function quita_meta($idcoleccion=0){
			$itemarray=array(
				'xml_META_be'=>0,
			);
			
			if($idcoleccion!=0)
				$this->db->where('coleccion_id',$idcoleccion)->update('demo_coleccion',$itemarray);
    }
    function demo_insert_pic($item_id,$model=0) {
      $this->db->insert('demo_pics',$this->input->post(NULL, TRUE));
    }
    function demo_delete_pic($item_id,$gama_id,$pic_id) {
      $this->db->delete('demo_pics',array('item_id'=>$item_id,'pic_id',$pic_id));
    }
    function demo_insert_gama (){
     $data=$this->input->post(NULL, TRUE);
     $cats=implode(',',$data['cats']);
      $fabarray=array('gama_name'=>$data['name'],'cats'=>$cats);
      $this->db->insert('demo_gama',$fabarray);
      $lastid=$this->db->insert_id();
      return $this->get_gama($lastid);
    }
    function demo_insert_estilo (){
			$data=$this->input->post(NULL, TRUE);
			/*
			print '<pre><xmp>';
			print_r($data);
			print '</xmp></pre>';
			exit;
			*/
			$cats=implode(',',$data['cats']);
      $fabarray=array('estilo_name'=>$data['name'],'cats'=>$cats);
     
      //$fabarray=array('estilo_name'=>$data['name']);
      $this->db->insert('demo_estilo',$fabarray);
      $lastid=$this->db->insert_id();
      return $this->get_estilo($lastid);
    }
    function demo_del_gama(){
      $this->db->delete('demo_gama',array('gama_id'=>$gama_id));
    }
    function demo_update_gama(){
      $data=$this->input->post(NULL, TRUE);
      $cats=implode(',',$data['cats']);
      $this->db->where('gama_id',$data['gama'])->update('demo_gama',array('gama_name'=>$data['name'],'cats'=>$cats, 'idtonalidad'=>$data['idtonalidad']));
    }
    function demo_del_estilo(){
      $this->db->delete('demo_estilo',array('estilo_id'=>$estilo_id));
    }
    function demo_del_col(){
      $this->db->where('item_coleccion_id',$this->input->post('i'))->update('demo_items',array('activo'=>0));
      $this->db->delete('demo_coleccion',array('coleccion_id'=>$this->input->post('i')));
    }
    function demo_publicar_fab($publicar){
      $this->db->where('cat_id',$this->input->post('i'))->update('demo_categories',array('publico'=>$publicar));
//      $this->db->where('coleccion_cat_id',$this->input->post('i'))->update('demo_coleccion',array('publico'=>$publicar));
 //     $this->db->where('item_cat_fk',$this->input->post('i'))->update('demo_items',array('publico'=>$publicar));
      return $publicar;
    }
    function demo_publicar_col($publicar){
      $this->db->where('coleccion_id',$this->input->post('i'))->update('demo_coleccion',array('publico2'=>$publicar));
//      $this->db->where('item_coleccion_id',$this->input->post('i'))->update('demo_items',array('publico2'=>$publicar));
      return $publicar;
    }
    function demo_publicar_texto_coleccion($id, $col_text_publico){
      $this->db->where('coleccion_id',$id)->update('demo_coleccion',array('col_text_publico'=>$col_text_publico));
      //return $publicar;
    }
    /*
    */
    function demo_publicar_item($publicar){
      $this->db->where('item_id',$this->input->post('i'))->update('demo_items',array('publico3'=>$publicar));
      return $publicar;
    }
    function demo_publicar_item_new($publicar, $id){
    	// Si vamos a ocultar un item, miramos si tiene variantes, para marcar como principal la primera de ellas
    	// Ya que si lo ocultamos sin más (prque no se fabrique por ejemplo) desaparecería el resto
			//echo "<br />publicar: ".$publicar;
    	if ($publicar==0){
    		$item=$this->get_item_data($id);
    		if ($item[0]['tiene_variantes']==1){
    			$variantes=$this->db->select("*",FALSE)->from('demo_items')->where('variante_de',$id)->where('demo_items.activo',1)->where('demo_items.publico3',1)->get()->result_array();
					/*
					echo "<br />".$this->db->last_query();
				  print '<pre><xmp>';
				  print_r($variantes);
				  print '</xmp></pre>';
				  exit;
				  */
    			if (count($variantes)){
    				$nuevo_id_principal=$variantes[0]['item_id'];
	    			foreach($variantes as $item_relacionado){
	    				if ($item_relacionado['item_id']==$nuevo_id_principal){
	    					// modificamos el item para ponerlo como principal
								$this->db->where('item_id',$item_relacionado['item_id'])->update('demo_items',array('tiene_variantes'=>1, 'variante_de'=>0));
	    					//echo "<br />ponemos el nuevo como principal: {$item_relacionado['item_id']}";
	    				}
	    				else{
	    					// modificamos el resto de variantes para asignar la nueva como principal
								$this->db->where('item_id',$item_relacionado['item_id'])->update('demo_items',array('tiene_variantes'=>0, 'variante_de'=>$nuevo_id_principal));
	    					//echo "<br />ponemos variantes al nuevo: {$item_relacionado['item_id']} => $nuevo_id_principal";
	    				}
	    				//echo "<br />".$this->db->last_query();
	    			}
	    			// Modificamos la que estamos ocultando para ponerla como variante de la nueva
						$this->db->where('item_id',$id)->update('demo_items',array('tiene_variantes'=>0, 'variante_de'=>$nuevo_id_principal));
						//echo "<br />quitamos el viejo: {$id} => $nuevo_id_principal";
						//echo "<br />".$this->db->last_query();
    			}
    		}
    		/*
    		exit;
			  print '<pre><xmp>';
			  print_r($variantes);
			  print '</xmp></pre>';
    		*/
    	}
      $this->db->where('item_id',$id)->update('demo_items',array('publico3'=>$publicar));
			//echo "<br />".$this->db->last_query();
      return $publicar;
    }
    
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// LOCATIONS AND ZONES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	function demo_update_location_types()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		foreach($this->input->post('update') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$this->form_validation->set_rules('update['.$id.'][name]', 'Row #'.$i.' Location Type', 'required');
			$this->form_validation->set_rules('update['.$id.'][parent_location_type]', 'Row #'.$i.' Parent Location Type', 'requried|integer');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('update') as $row)
			{
				if ($row['delete'] == 1)
				{
					$this->flexi_cart_admin->delete_db_location_type($row['id'], TRUE);
				}
				else
				{
					$sql_update = array(
						$this->flexi_cart_admin->db_column('location_type', 'name') => $row['name'],
						$this->flexi_cart_admin->db_column('location_type', 'parent') => $row['parent_location_type']
					);
				
					$this->flexi_cart_admin->update_db_location_type($sql_update, $row['id']);
				}
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());	
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_location_type()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert['.$id.'][name]', 'Row #'.$i.' Location Type', 'required');
			$this->form_validation->set_rules('insert['.$id.'][parent_location_type]', 'Row #'.$i.' Parent Location Type', 'requried|integer');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('insert') as $row)
			{
				$sql_insert = array(
					$this->flexi_cart_admin->db_column('location_type', 'name') => $row['name'],
					$this->flexi_cart_admin->db_column('location_type', 'parent') => $row['parent_location_type']
				);
			
				$this->flexi_cart_admin->insert_db_location_type($sql_insert);
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/location_types');
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}
	}	
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	function demo_update_locations()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		foreach($this->input->post('update') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$this->form_validation->set_rules('update['.$id.'][name]', 'Row #'.$i.' Name', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('update['.$id.'][parent_location]');
			$this->form_validation->set_rules('update['.$id.'][shipping_zone]');
			$this->form_validation->set_rules('update['.$id.'][tax_zone]');
			$this->form_validation->set_rules('update['.$id.'][status]');
		}

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('update') as $row)
			{
				if ($row['delete'] == 1)
				{
					$this->flexi_cart_admin->delete_db_location($row['id']);
				}
				else
				{
					$sql_update = array(
						$this->flexi_cart_admin->db_column('locations', 'name') => $row['name'],
						$this->flexi_cart_admin->db_column('locations', 'parent') => $row['parent_location'],
						$this->flexi_cart_admin->db_column('locations', 'shipping_zone') => $row['shipping_zone'],
						$this->flexi_cart_admin->db_column('locations', 'tax_zone') => $row['tax_zone'],
						$this->flexi_cart_admin->db_column('locations', 'status') => $row['status']
					);
				
					$this->flexi_cart_admin->update_db_location($sql_update, $row['id']);
				}
			}
		
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());	
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_location($location_type_id)
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert['.$id.'][name]', 'Row #'.$i.' Name', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('insert['.$id.'][parent_location]');
			$this->form_validation->set_rules('insert['.$id.'][shipping_zone]');
			$this->form_validation->set_rules('insert['.$id.'][tax_zone]');
			$this->form_validation->set_rules('insert['.$id.'][status]');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('insert') as $row)
			{
				$sql_insert = array(
					$this->flexi_cart_admin->db_column('locations', 'type') => $location_type_id,
					$this->flexi_cart_admin->db_column('locations', 'name') => $row['name'],
					$this->flexi_cart_admin->db_column('locations', 'parent') => $row['parent_location'],
					$this->flexi_cart_admin->db_column('locations', 'shipping_zone') => $row['shipping_zone'],
					$this->flexi_cart_admin->db_column('locations', 'tax_zone') => $row['tax_zone'],
					$this->flexi_cart_admin->db_column('locations', 'status') => $row['status']
				);
			
				$this->flexi_cart_admin->insert_db_location($sql_insert);
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/locations/'.$location_type_id);
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	function demo_update_zones()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		foreach($this->input->post('update') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$this->form_validation->set_rules('update['.$id.'][name]', 'Row #'.$i.' Name', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('update['.$id.'][description]');
			$this->form_validation->set_rules('update['.$id.'][status]');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('update') as $row)
			{
				if ($row['delete'] == 1)
				{
					$this->flexi_cart_admin->delete_db_location_zone($row['id']);
				}
				else
				{
					$sql_update = array(
						$this->flexi_cart_admin->db_column('location_zones', 'name') => $row['name'],
						$this->flexi_cart_admin->db_column('location_zones', 'description') => $row['description'],
						$this->flexi_cart_admin->db_column('location_zones', 'status') => $row['status']
					);
				
					$this->flexi_cart_admin->update_db_location_zone($sql_update, $row['id']);
				}
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_zones()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert['.$id.'][name]', 'Row #'.$i.' Name', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('insert['.$id.'][description]');
			$this->form_validation->set_rules('insert['.$id.'][status]');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('insert') as $row)
			{		
				$sql_insert = array(
					$this->flexi_cart_admin->db_column('location_zones', 'name') => $row['name'],
					$this->flexi_cart_admin->db_column('location_zones', 'description') => $row['description'],
					$this->flexi_cart_admin->db_column('location_zones', 'status') => $row['status']
				);
			
				$this->flexi_cart_admin->insert_db_location_zone($sql_insert);
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/zones');
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// SHIPPING OPTIONS AND RATES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	function demo_update_shipping()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		foreach($this->input->post('update') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$this->form_validation->set_rules('update['.$id.'][name]', 'Row #'.$i.' Shipping Option Name', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('update['.$id.'][description]');
			$this->form_validation->set_rules('update['.$id.'][location]');
			$this->form_validation->set_rules('update['.$id.'][zone]');
			$this->form_validation->set_rules('update['.$id.'][inc_sub_locations]');
			$this->form_validation->set_rules('update['.$id.'][tax_rate]');
			$this->form_validation->set_rules('update['.$id.'][discount_inclusion]');
			$this->form_validation->set_rules('update['.$id.'][status]');
		}

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('update') as $row)
			{
				if ($row['delete'] == 1)
				{
					// Submit TRUE to the second argument to ensure all related shipping rates are deleted.
					$this->flexi_cart_admin->delete_db_shipping($row['id'], TRUE);
				}
				else
				{
					// The forms locations field is submitted as an array to ensure each location id is returned,
					// We can then reverse the order of the array and get the most specific location that was selected. i.e. 'Post Code' > 'State' > 'Country'
					$location_id = 0;
					foreach(array_reverse($row['location']) as $id)
					{
						if ($id > 0)
						{
							$location_id = $id;
							break;
						}
					}
				
					$sql_update = array(
						$this->flexi_cart_admin->db_column('shipping_options', 'name') => $row['name'],
						$this->flexi_cart_admin->db_column('shipping_options', 'description') => $row['description'],
						$this->flexi_cart_admin->db_column('shipping_options', 'location') => $location_id,
						$this->flexi_cart_admin->db_column('shipping_options', 'zone') => $row['zone'],
						$this->flexi_cart_admin->db_column('shipping_options', 'inc_sub_locations') => $row['inc_sub_locations'],
						$this->flexi_cart_admin->db_column('shipping_options', 'tax_rate') => $row['tax_rate'],
						$this->flexi_cart_admin->db_column('shipping_options', 'discount_inclusion') => $row['discount_inclusion'],
						$this->flexi_cart_admin->db_column('shipping_options', 'status') => $row['status']
					);
				
					$this->flexi_cart_admin->update_db_shipping($sql_update, $row['id']);
				}
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_shipping()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$this->form_validation->set_rules('insert_option[name]', 'Shipping Option Name', 'required');
		
		// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
		$this->form_validation->set_rules('insert_option[description]');
		$this->form_validation->set_rules('insert_option[location]');
		$this->form_validation->set_rules('insert_option[zone]');
		$this->form_validation->set_rules('insert_option[inc_sub_locations]');
		$this->form_validation->set_rules('insert_option[tax_rate]');
		$this->form_validation->set_rules('insert_option[discount_inclusion]');
		$this->form_validation->set_rules('insert_option[status]');
		
		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert_rate') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert_rate['.$id.'][value]', 'Row #'.$i.' Rate', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('insert_rate['.$id.'][tare_weight]');
			$this->form_validation->set_rules('insert_rate['.$id.'][min_weight]');
			$this->form_validation->set_rules('insert_rate['.$id.'][max_weight]');
			$this->form_validation->set_rules('insert_rate['.$id.'][min_value]');
			$this->form_validation->set_rules('insert_rate['.$id.'][max_value]');
			$this->form_validation->set_rules('insert_rate['.$id.'][status]');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			$option_data = $this->input->post('insert_option');
			$rate_data = $this->input->post('insert_rate');
			
			// The forms locations field is submitted as an array to ensure each location id is returned,
			// We can then reverse the order of the array and get the most specific location that was selected. i.e. 'Post Code' > 'State' > 'Country'
			$location_id = 0;
			foreach(array_reverse($option_data['location']) as $id)
			{
				if ($id > 0)
				{
					$location_id = $id;
					break;
				}
			}
			
			$sql_insert = array(
				$this->flexi_cart_admin->db_column('shipping_options', 'name') => $option_data['name'],
				$this->flexi_cart_admin->db_column('shipping_options', 'description') => $option_data['description'],
				$this->flexi_cart_admin->db_column('shipping_options', 'location') => $location_id,
				$this->flexi_cart_admin->db_column('shipping_options', 'zone') => $option_data['zone'],
				$this->flexi_cart_admin->db_column('shipping_options', 'inc_sub_locations') => $option_data['inc_sub_locations'],
				$this->flexi_cart_admin->db_column('shipping_options', 'tax_rate') => $option_data['tax_rate'],
				$this->flexi_cart_admin->db_column('shipping_options', 'discount_inclusion') => $option_data['discount_inclusion'],
				$this->flexi_cart_admin->db_column('shipping_options', 'status') => $option_data['status']
			);
			
			$shipping_id = $this->flexi_cart_admin->insert_db_shipping($sql_insert);
			
			###+++++++++++++++###
			
			foreach($rate_data as $row)
			{
				$sql_insert = array(
					$this->flexi_cart_admin->db_column('shipping_rates', 'parent') => $shipping_id,
					$this->flexi_cart_admin->db_column('shipping_rates', 'value') => $row['value'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'tare_weight') => $row['tare_weight'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'min_weight') => $row['min_weight'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'max_weight') => $row['max_weight'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'min_value') => $row['min_value'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'max_value') => $row['max_value'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'status') => $row['status']
				);
				
				$this->flexi_cart_admin->insert_db_shipping_rate($sql_insert);
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/shipping');
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}			
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	function demo_update_shipping_rate()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		foreach($this->input->post('update') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$this->form_validation->set_rules('update['.$id.'][value]', 'Row #'.$i.' Rate', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('update['.$id.'][tare_weight]');
			$this->form_validation->set_rules('update['.$id.'][min_weight]');
			$this->form_validation->set_rules('update['.$id.'][max_weight]');
			$this->form_validation->set_rules('update['.$id.'][min_value]');
			$this->form_validation->set_rules('update['.$id.'][max_value]');
			$this->form_validation->set_rules('update['.$id.'][status]');
		}

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('update') as $row)
			{
				if ($row['delete'] == 1)
				{
					$this->flexi_cart_admin->delete_db_shipping_rate($row['id']);
				}
				else
				{
					$sql_update = array(
						$this->flexi_cart_admin->db_column('shipping_rates', 'value') => $row['value'],
						$this->flexi_cart_admin->db_column('shipping_rates', 'tare_weight') => $row['tare_weight'],
						$this->flexi_cart_admin->db_column('shipping_rates', 'min_weight') => $row['min_weight'],
						$this->flexi_cart_admin->db_column('shipping_rates', 'max_weight') => $row['max_weight'],
						$this->flexi_cart_admin->db_column('shipping_rates', 'min_value') => $row['min_value'],
						$this->flexi_cart_admin->db_column('shipping_rates', 'max_value') => $row['max_value'],
						$this->flexi_cart_admin->db_column('shipping_rates', 'status') => $row['status']
					);
				
					$this->flexi_cart_admin->update_db_shipping_rate($sql_update, $row['id']);
				}
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());	
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_shipping_rate($shipping_id)
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert['.$id.'][value]', 'Row #'.$i.' Rate', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('insert['.$id.'][tare_weight]');
			$this->form_validation->set_rules('insert['.$id.'][min_weight]');
			$this->form_validation->set_rules('insert['.$id.'][max_weight]');
			$this->form_validation->set_rules('insert['.$id.'][min_value]');
			$this->form_validation->set_rules('insert['.$id.'][max_value]');
			$this->form_validation->set_rules('insert['.$id.'][status]');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('insert') as $row)
			{
				$sql_insert = array(
					$this->flexi_cart_admin->db_column('shipping_rates', 'parent') => $shipping_id,
					$this->flexi_cart_admin->db_column('shipping_rates', 'value') => $row['value'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'tare_weight') => $row['tare_weight'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'min_weight') => $row['min_weight'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'max_weight') => $row['max_weight'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'min_value') => $row['min_value'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'max_value') => $row['max_value'],
					$this->flexi_cart_admin->db_column('shipping_rates', 'status') => $row['status']
				);

				$this->flexi_cart_admin->insert_db_shipping_rate($sql_insert);
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/shipping_rates/'.$shipping_id);
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	function demo_update_item_shipping()
	{
		foreach($this->input->post('update') as $row)
		{
			if ($row['delete'] == 1)
			{
				$this->flexi_cart_admin->delete_db_item_shipping($row['id']);
			}
			else
			{
				$sql_update = array(
					$this->flexi_cart_admin->db_column('item_shipping', 'location') => $row['location'],
					$this->flexi_cart_admin->db_column('item_shipping', 'zone') => $row['zone'],
					$this->flexi_cart_admin->db_column('item_shipping', 'value') => $row['value'],
					$this->flexi_cart_admin->db_column('item_shipping', 'separate') => $row['separate'],
					$this->flexi_cart_admin->db_column('item_shipping', 'banned') => $row['banned'],
					$this->flexi_cart_admin->db_column('item_shipping', 'status') => $row['status']
				);
			
				$this->flexi_cart_admin->update_db_item_shipping($sql_update, $row['id']);
			}
		}
		
		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		redirect(current_url());
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_item_shipping($item_id)
	{
		foreach($this->input->post('insert') as $row)
		{
			$sql_insert = array(
				$this->flexi_cart_admin->db_column('item_shipping', 'item') => $item_id,
				$this->flexi_cart_admin->db_column('item_shipping', 'location') => $row['location'],
				$this->flexi_cart_admin->db_column('item_shipping', 'zone') => $row['zone'],
				$this->flexi_cart_admin->db_column('item_shipping', 'value') => $row['value'],
				$this->flexi_cart_admin->db_column('item_shipping', 'separate') => $row['separate'],
				$this->flexi_cart_admin->db_column('item_shipping', 'banned') => $row['banned'],
				$this->flexi_cart_admin->db_column('item_shipping', 'status') => $row['status']
			);
		
			$this->flexi_cart_admin->insert_db_item_shipping($sql_insert);
		}
		
		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		redirect('admin_library/item_shipping/'.$item_id);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// TAXES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	function demo_update_tax()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		foreach($this->input->post('update') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$this->form_validation->set_rules('update['.$id.'][name]', 'Row #'.$i.' Name', 'required');
			$this->form_validation->set_rules('update['.$id.'][rate]', 'Row #'.$i.' Tax Rate', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('update['.$id.'][location]');
			$this->form_validation->set_rules('update['.$id.'][zone]');
			$this->form_validation->set_rules('update['.$id.'][status]');
		}

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('update') as $row)
			{
				if ($row['delete'] == 1)
				{
					$this->flexi_cart_admin->delete_db_tax($row['id']);
				}
				else
				{
					// The forms locations field is submitted as an array to ensure each location id is returned,
					// We can then reverse the order of the array and get the most specific location that was selected. i.e. 'Post Code' > 'State' > 'Country'
					$location_id = 0;
					foreach(array_reverse($row['location']) as $id)
					{
						if ($id > 0)
						{
							$location_id = $id;
							break;
						}
					}
				
					$sql_update = array(
						$this->flexi_cart_admin->db_column('tax', 'name') => $row['name'],
						$this->flexi_cart_admin->db_column('tax', 'location') => $location_id,
						$this->flexi_cart_admin->db_column('tax', 'zone') => $row['zone'],
						$this->flexi_cart_admin->db_column('tax', 'rate') => $row['rate'],
						$this->flexi_cart_admin->db_column('tax', 'status') => $row['status']
					);
				
					$this->flexi_cart_admin->update_db_tax($sql_update, $row['id']);
				}
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_tax()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert['.$id.'][name]', 'Row #'.$i.' Name', 'required');
			$this->form_validation->set_rules('insert['.$id.'][rate]', 'Row #'.$i.' Tax Rate', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('insert['.$id.'][location]');
			$this->form_validation->set_rules('insert['.$id.'][zone]');
			$this->form_validation->set_rules('insert['.$id.'][status]');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('insert') as $row)
			{			
				// The forms locations field is submitted as an array to ensure each location id is returned,
				// We can then reverse the order of the array and get the most specific location that was selected. i.e. 'Post Code' > 'State' > 'Country'
				$location_id = 0;
				foreach(array_reverse($row['location']) as $id)
				{
					if ($id > 0)
					{
						$location_id = $id;
						break;
					}
				}
				
				$sql_insert = array(
					$this->flexi_cart_admin->db_column('tax', 'name') => $row['name'],
					$this->flexi_cart_admin->db_column('tax', 'location') => $location_id,
					$this->flexi_cart_admin->db_column('tax', 'zone') => $row['zone'],
					$this->flexi_cart_admin->db_column('tax', 'rate') => $row['rate'],
					$this->flexi_cart_admin->db_column('tax', 'status') => $row['status']
				);

				$this->flexi_cart_admin->insert_db_tax($sql_insert);
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/tax/');
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	function demo_update_item_tax()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		foreach($this->input->post('update') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$this->form_validation->set_rules('update['.$id.'][rate]', 'Row #'.$i.' Rate', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated.
			$this->form_validation->set_rules('update['.$id.'][location]');
			$this->form_validation->set_rules('update['.$id.'][zone]');
			$this->form_validation->set_rules('update['.$id.'][status]');
		}

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('update') as $row)
			{
				if ($row['delete'] == 1)
				{
					$this->flexi_cart_admin->delete_db_item_tax($row['id']);
				}
				else
				{
					$sql_update = array(
						$this->flexi_cart_admin->db_column('item_tax', 'location') => $row['location'],
						$this->flexi_cart_admin->db_column('item_tax', 'zone') => $row['zone'],
						$this->flexi_cart_admin->db_column('item_tax', 'rate') => $row['rate'],
						$this->flexi_cart_admin->db_column('item_tax', 'status') => $row['status']
					);
				
					$this->flexi_cart_admin->update_db_item_tax($sql_update, $row['id']);
				}
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_item_tax($item_id)
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert['.$id.'][rate]', 'Row #'.$i.' Rate', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated.
			$this->form_validation->set_rules('insert['.$id.'][location]');
			$this->form_validation->set_rules('insert['.$id.'][zone]');
			$this->form_validation->set_rules('insert['.$id.'][status]');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('insert') as $row)
			{
				$sql_insert = array(
					$this->flexi_cart_admin->db_column('item_tax', 'item') => $item_id,
					$this->flexi_cart_admin->db_column('item_tax', 'location') => $row['location'],
					$this->flexi_cart_admin->db_column('item_tax', 'zone') => $row['zone'],
					$this->flexi_cart_admin->db_column('item_tax', 'rate') => $row['rate'],
					$this->flexi_cart_admin->db_column('item_tax', 'status') => $row['status']
				);
			
				$this->flexi_cart_admin->insert_db_item_tax($sql_insert);
			}
			
			// Set a message to the CI flashdata so that it is available after the page redirect.
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/item_tax/'.$item_id);
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// ITEM STOCK
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	function demo_update_item_stock()
	{
		foreach($this->input->post('update') as $row)
		{
			// Update item stock levels.
			$sql_update_stock = array(
				$this->flexi_cart_admin->db_column('item_stock', 'quantity') => $row['stock_quantity'],
				$this->flexi_cart_admin->db_column('item_stock', 'auto_allocate_status') => $row['auto_allocate_status']
			);
			
			$sql_where_stock = array($this->flexi_cart_admin->db_column('item_stock', 'item') => $row['id']);
		
			$this->flexi_cart_admin->update_db_item_stock($sql_update_stock, $sql_where_stock);
			
			###+++++++++++++++++++++++++++++++++###
			
			// Update the weight and price of items from the custom item database table.
			$sql_update_price = array(
				'item_weight' => $row['weight'],
				'item_price' => $row['price']
			);
			
			$sql_where_price = array('item_id' => $row['id']);
			
			$this->db->update('demo_items', $sql_update_price, $sql_where_price);
			
			// Set a custom status message stating that data has been successfully updated.
			$this->flexi_cart_admin->set_status_message('Data successfully updated.', 'public', TRUE);
		}
		
		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		redirect(current_url());
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CART ORDERS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	function demo_update_datos_facturacion($order_number){
		$sql_update['ord_demo_bill_name'] = $this->input->post('ord_demo_bill_name');
		$sql_update['ord_demo_bill_company'] = $this->input->post('ord_demo_bill_company');
		$sql_update['ord_demo_bill_address_01'] = $this->input->post('ord_demo_bill_address_01');
		$sql_update['ord_demo_bill_city'] = $this->input->post('ord_demo_bill_city');
		$sql_update['ord_demo_bill_state'] = $this->input->post('ord_demo_bill_state');
		$sql_update['ord_demo_bill_post_code'] = $this->input->post('ord_demo_bill_post_code');

		$this->flexi_cart_admin->update_db_order_summary($sql_update, $order_number);
  	}
	function demo_update_datos_envio($order_number){
		$sql_update['ord_demo_ship_name'] = $this->input->post('ord_demo_ship_name');
		$sql_update['ord_demo_ship_address_01'] = $this->input->post('ord_demo_ship_address_01');
		$sql_update['ord_demo_ship_city'] = $this->input->post('ord_demo_ship_city');
		$sql_update['ord_demo_ship_state'] = $this->input->post('ord_demo_ship_state');
		$sql_update['ord_demo_ship_post_code'] = $this->input->post('ord_demo_ship_post_code');
		$this->flexi_cart_admin->update_db_order_summary($sql_update, $order_number);
	}
	function demo_update_order_details($order_number){
		// Update order status.
		$cambiar_a=$this->input->post('update_status');
		if($cambiar_a==6) 
			$cambiar_a=3;
		$sql_update = array($this->flexi_cart_admin->db_column('order_summary', 'status') => $cambiar_a);

		$this->flexi_cart_admin->update_db_order_summary($sql_update, $order_number);
		$sql_w = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
		$order_data = $this->flexi_cart_admin->get_db_order_summary_row_array("*", $sql_w);

		if($this->input->post('update_status')==3){
			$body=array(
			"nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
			"msg"=>"Su pedido $order_number está siendo procesado.",
			"pedido"=>$this->getPedido($order_number)
			);
			if ($order_data['ord_user_ekam_fk']!=0)
				$this->send_email_ekam($order_data['ord_demo_email'],"El pedido $order_number está siendo procesado",$body);
			else
				$this->send_email($order_data['ord_demo_email'],"El pedido $order_number está siendo procesado",$body);
		}
		if($this->input->post('update_status')==4){
			$body=array(
			"nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
			"msg"=>"Su pedido $order_number ha sido enviado.",
			"pedido"=>$this->getPedido($order_number)
			);
			if ($order_data['ord_user_ekam_fk']!=0)
				$this->send_email_ekam($order_data['ord_demo_email'],"El pedido $order_number ha sido enviado",$body);
			else
				$this->send_email($order_data['ord_demo_email'],"El pedido $order_number ha sido enviado",$body);
		}
		if($this->input->post('update_status')==5){
			$body=array(
			"nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
			"msg"=>"Se ha cancelado su pedido $order_number.",
			"pedido"=>$this->getPedido($order_number)
			);
			if ($order_data['ord_user_ekam_fk']!=0)
				$this->send_email_ekam($order_data['ord_demo_email'],"El pedido $order_number ha sido cancelado",$body);
			else
				$this->send_email($order_data['ord_demo_email'],"El pedido $order_number ha sido cancelado",$body);
		}
		### ++++++++++ ###
		// Update shipped and cancelled item quantities.
		$nuevosvales = array();
		foreach($this->input->post('update_details') as $id => $row){
			$sql_update = array();
			// Check that the 'Quantity Shipped' input field was submitted (Incase the field was disabled).
			if (isset($row['quantity_shipped'])){
				$sql_update[$this->flexi_cart_admin->db_column('order_details', 'item_quantity_shipped')] = $row['quantity_shipped'];
				if(isset($row['muestra'])){
					$vales=explode(",",$row['muestra']);
					$numvales=0;
					if(!empty($vales)) $numvales=count($vales);
					if($row['muestra']=="_"){$vales=null;$numvales=0;}
					if($numvales<$row['quantity_shipped']){
						for($j=0;$j<$row['quantity_shipped']-$numvales;$j++)  {
							$nuevo=$this->flexi_cart_admin_model->generar_vale($this->input->post('user_id'));
							$vales[]=$nuevo;
							$nuevosvales[]=$nuevo;
						}
						$sql_update['ord_det_vales'] = implode(",", $vales);
					}
				}
			}
			
			// Check that the 'Quantity Cancelled' input field was submitted (Incase the field was disabled).
			if (isset($row['quantity_cancelled'])){
				$sql_update[$this->flexi_cart_admin->db_column('order_details', 'item_quantity_cancelled')] = $row['quantity_cancelled'];
			}
			
			// Check that the 'Quantity ' input field was submitted (Incase the field was disabled).
			//~ if (isset($row['quantity'])){
				//~ $sql_update[$this->flexi_cart_admin->db_column('order_details', 'item_quantity')] = $row['quantity'];
			//~ }
		
			if (!empty($sql_update)){
				$this->flexi_cart_admin->update_db_order_details($sql_update, $row['id']);
			}
		}
		if(!empty($nuevosvales)){
			$sql_w = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
			$order_data2 = $this->flexi_cart_admin->get_db_order_summary_row_array('ord_demo_email', $sql_w);
			$textovales="<fieldset><legend>Códigos de descuento</legend>Introduce tus códigos de descuento en el próximo pedido para que se te abone el importe de las muestras. <br />* Cada código es valido para un rollo, no necesariamente del mismo modelo que la muestra<ul>";
			foreach($nuevosvales as $cadavale){
				$textovales.="<li>$cadavale</li>";
			}
			$textovales.="</ul></fieldset>";
			$body=array(
				"nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
				"msg"=>"Tiene disponibles nuevos vales de descuento correspondientes al pedido $order_number.<br/>",
				"pedido"=>$textovales.$this->getPedido($order_number)
			);
			$this->send_email($order_data['ord_demo_email'],"Nuevos vales descuento ( pedido: ".$order_number.")",$body);
		}
		if($this->input->post('update_status')==6){
			$body=array(
				"nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
				"msg"=>"Se ha enviado parcialmete su pedido $order_number.",
				"pedido"=>$this->getPedido($order_number)
			);
			if ($order_data['ord_user_ekam_fk']!=0)
				$this->send_email_ekam($order_data['ord_demo_email'],"El pedido $order_number esta siendo parcialmente enviado",$body);
			else
				$this->send_email($order_data['ord_demo_email'],"El pedido $order_number esta siendo parcialmente enviado",$body);
		}	
		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		redirect(current_url());
	}
  function demo_facturar($order_number){
		$nbr= $this->db->select_max("factura")->get("order_summary")->row()->factura;
		$sql_w = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
		$order_data = $this->flexi_cart_admin->get_db_order_summary_row_array("*", $sql_w);
		if($order_data['factura']==0){
			// Modificamos la fecha de factura para que no coja la del sistema si no la del pedido
			//~ //$sql_update = array("factura" => $nbr+1, "fechafactura"=>date('Y-m-d'));
			$sql_update = array("factura" => $nbr+1, "fechafactura"=>substr($order_data['ord_date'], 0, 10));
			$this->flexi_cart_admin->update_db_order_summary($sql_update, $order_number);
			$body=array(
				"nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
				"msg"=>"Factura dePapelpintado ".($nbr+1).".",
				"pedido"=>$this->getFactura($order_number)
			);
			// Quitamos el envío de la factura
			//$this->send_email_fra($order_data['ord_demo_email'],"Factura dePapelpintado.es: ".($nbr+1).".",$body);
		}
		else{
			//~ print '<pre><xmp>';
			//~ print_r($nbr);
			//~ print '</xmp></pre>';
			//~ print '<pre><xmp>';
			//~ print_r($sql_w);
			//~ print '</xmp></pre>';
			//~ print '<pre><xmp>';
			//~ print_r($order_data);
			//~ print '</xmp></pre>';
			//~ echo "<br />entro 2";
			//~ $body=array(
				//~ "nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
				//~ "msg"=>"Factura dePapelpintado ".($nbr+1).".",
				//~ "pedido"=>$this->getFactura($order_number)
			//~ );
			//~ print '<pre><xmp>';
			//~ print_r($body);
			//~ print '</xmp></pre>';
			//~ exit;
		}
        }
        function demo_facturar_rectificativa($order_number){
		$nbr= $this->db->select_max("factura")->get("order_summary")->row()->factura;
		$sql_w = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
		$order_data = $this->flexi_cart_admin->get_db_order_summary_row_array("*", $sql_w);
		//~ print '<pre><xmp>';
		//~ print_r($order_data);
		//~ print '</xmp></pre>';
		//~ exit;
		if($order_data['factura_rect']==0 || $order_data['factura_rect']==4366){
			$sql_update = array("factura_rect" => $order_data['factura'], "fechafactura_rect"=>date('Y-m-d'));
			$this->flexi_cart_admin->update_db_order_summary($sql_update, $order_number);
			$body=array(
				"nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
				"msg"=>"Factura Rectificativa dePapelpintado ".($order_data['factura'])."-R.",
				"pedido"=>$this->getFacturaRect($order_number)
			);
			//~ echo "<br />demo_facturar_rectificativa";
			//~ print '<pre><xmp>';
			//~ print_r($nbr);
			//~ print '</xmp></pre>';
			//~ print '<pre><xmp>';
			//~ print_r($sql_w);
			//~ print '</xmp></pre>';
			//~ print '<pre><xmp>';
			//~ print_r($order_data);
			//~ print '</xmp></pre>';
			//~ print '<pre><xmp>';
			//~ print_r($body);
			//~ print '</xmp></pre>';
			//~ exit;
			//~ $this->send_email_fra($order_data['ord_demo_email'],"Factura Rectificativa dePapelpintado: ".($order_data['factura'])."-R.".".",$body);
		}
		else{
		}
        }
        function demo_cerrar_ticket($order_number){
            $nbr= $this->db->select_max("factura2")->get("order_summary")->row()->factura2;
            $sql_w = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
            $order_data = $this->flexi_cart_admin->get_db_order_summary_row_array("*", $sql_w);
            if($order_data['factura2']==0){
            $sql_update = array("factura2" => $nbr+1, "fechafactura"=>date('Y-m-d'));
            $this->flexi_cart_admin->update_db_order_summary($sql_update, $order_number);
            $body=array(
                 "nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
                 "msg"=>"Ticket dePapelpintado ".($nbr+1).".",
                 "pedido"=>$this->getTicket($order_number)
              );
            //$this->send_email_fra($order_data['ord_demo_email'],"Ticket dePapelpintado.es: ".($nbr+1).".",$body);
            }   
        }
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// ORDER STATUS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	function demo_update_order_status()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		foreach($this->input->post('update') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$this->form_validation->set_rules('update['.$id.'][status]', 'Row #'.$i.' Status Description', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('update['.$id.'][cancelled]');
			$this->form_validation->set_rules('update['.$id.'][default]');
		}

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('update') as $row)
			{
				if ($row['delete'] == 1)
				{
					$this->flexi_cart_admin->delete_db_order_status($row['id']);
				}
				else
				{
					$sql_update = array(
						$this->flexi_cart_admin->db_column('order_status', 'status') => $row['status'],
						$this->flexi_cart_admin->db_column('order_status', 'cancelled') => $row['cancelled'],
						$this->flexi_cart_admin->db_column('order_status', 'save_default') => $row['save_default'],
						$this->flexi_cart_admin->db_column('order_status', 'resave_default') => $row['resave_default']
					);
              
          if($row['status']==3 || $row['status']==4){
            
        }  
					$this->flexi_cart_admin->update_db_order_status($sql_update, $row['id']);
                    
                    /*_*/
				}
                
			}
			
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_order_status()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert['.$id.'][status]', 'Row #'.$i.' Status Description', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('insert['.$id.'][cancelled]');
			$this->form_validation->set_rules('insert['.$id.'][save_default]');
			$this->form_validation->set_rules('insert['.$id.'][resave_default]');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('insert') as $row)
			{			
				$sql_insert = array(
					$this->flexi_cart_admin->db_column('order_status', 'status') => $row['status'],
					$this->flexi_cart_admin->db_column('order_status', 'cancelled') => $row['cancelled'],
					$this->flexi_cart_admin->db_column('order_status', 'save_default') => $row['save_default'],
					$this->flexi_cart_admin->db_column('order_status', 'resave_default') => $row['resave_default']
				);

				$this->flexi_cart_admin->insert_db_order_status($sql_insert);
			}
			
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/order_status');
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CURRENCY
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	function demo_update_currency()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		foreach($this->input->post('update') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$this->form_validation->set_rules('update['.$id.'][name]', 'Row #'.$i.' Name', 'required');
			$this->form_validation->set_rules('update['.$id.'][exchange_rate]', 'Row #'.$i.' Exchange Rate', 'required');
			$this->form_validation->set_rules('update['.$id.'][symbol]', 'Row #'.$i.' Symbol', 'required');
			$this->form_validation->set_rules('update['.$id.'][thousand]', 'Row #'.$i.' Thousand Separator', 'required');
			$this->form_validation->set_rules('update['.$id.'][decimal]', 'Row #'.$i.' Decimal Separator', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('update['.$id.'][symbol_suffix]');
			$this->form_validation->set_rules('update['.$id.'][status]');
		}

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('update') as $row)
			{
				if ($row['delete'] == 1)
				{
					$this->flexi_cart_admin->delete_db_currency($row['id']);
				}
				else
				{
					$sql_update = array(
						$this->flexi_cart_admin->db_column('currency', 'name') => $row['name'],
						$this->flexi_cart_admin->db_column('currency', 'exchange_rate') => $row['exchange_rate'],
						$this->flexi_cart_admin->db_column('currency', 'symbol') => $row['symbol'],
						$this->flexi_cart_admin->db_column('currency', 'symbol_suffix') => $row['symbol_suffix'],
						$this->flexi_cart_admin->db_column('currency', 'thousand_separator') => $row['thousand'],
						$this->flexi_cart_admin->db_column('currency', 'decimal_separator') => $row['decimal'],
						$this->flexi_cart_admin->db_column('currency', 'status') => $row['status']
					);
				
					$this->flexi_cart_admin->update_db_currency($sql_update, $row['id']);
				}
			}
			
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_currency()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert['.$id.'][name]', 'Row #'.$i.' Name', 'required');
			$this->form_validation->set_rules('insert['.$id.'][exchange_rate]', 'Row #'.$i.' Exchange Rate', 'required');
			$this->form_validation->set_rules('insert['.$id.'][symbol]', 'Row #'.$i.' Symbol', 'required');
			$this->form_validation->set_rules('insert['.$id.'][thousand]', 'Row #'.$i.' Thousand Separator', 'required');
			$this->form_validation->set_rules('insert['.$id.'][decimal]', 'Row #'.$i.' Decimal Separator', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
			$this->form_validation->set_rules('insert['.$id.'][symbol_suffix]');
			$this->form_validation->set_rules('insert['.$id.'][status]');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('insert') as $row)
			{			
				$sql_insert = array(
					$this->flexi_cart_admin->db_column('currency', 'name') => $row['name'],
					$this->flexi_cart_admin->db_column('currency', 'exchange_rate') => $row['exchange_rate'],
					$this->flexi_cart_admin->db_column('currency', 'symbol') => $row['symbol'],
					$this->flexi_cart_admin->db_column('currency', 'symbol_suffix') => $row['symbol_suffix'],
					$this->flexi_cart_admin->db_column('currency', 'thousand_separator') => $row['thousand'],
					$this->flexi_cart_admin->db_column('currency', 'decimal_separator') => $row['decimal'],
					$this->flexi_cart_admin->db_column('currency', 'status') => $row['status']
				);

				$this->flexi_cart_admin->insert_db_currency($sql_insert);
			}
			
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/currency');
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// DISCOUNTS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	function demo_update_discounts(){
		/*
		print '<pre><xmp>';
		print_r($_POST);
		print '</xmp></pre>';
		exit;
		*/
		foreach($this->input->post('update') as $row){
			if ($row['delete'] == 1){
				$this->flexi_cart_admin->delete_db_discount($row['id']);
			}
			else{
				$sql_update = array($this->flexi_cart_admin->db_column('discounts', 'status') => $row['status']);
			
				$this->flexi_cart_admin->update_db_discount($sql_update, $row['id']);
			}
		}
		
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		redirect(current_url());
	}
	function demo_update_discounts_generica($tabla_descuentos){
		foreach($this->input->post('update') as $row){
			if ($row['delete'] == 1){
				$this->flexi_cart_admin->delete_db_discount_generica($row['id'], $tabla_descuentos);
			}
			else{
				$sql_update = array($this->flexi_cart_admin->db_column($tabla_descuentos, 'status') => $row['status']);
				$this->flexi_cart_admin->update_db_discount_generica($sql_update, $row['id'], $tabla_descuentos);
			}
		}
		
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		redirect(current_url());
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_update_discount($discount_id)
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$this->form_validation->set_rules('update[type]', 'Discount Type', 'greater_than[0]');
		$this->form_validation->set_rules('update[method]', 'Discount Method', 'greater_than[0]');
		$this->form_validation->set_rules('update[usage_limit]', 'Usage Limit', 'required');
		$this->form_validation->set_rules('update[valid_date]', 'Valid Date', 'required');
		$this->form_validation->set_rules('update[expire_date]', 'Expire Date', 'required');
		
		// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
		$this->form_validation->set_rules('update[tax_method]');
		$this->form_validation->set_rules('update[location]');
		$this->form_validation->set_rules('update[zone]');
		$this->form_validation->set_rules('update[group]');
		$this->form_validation->set_rules('update[item]');
		$this->form_validation->set_rules('update[code]');
		$this->form_validation->set_rules('update[description]');
		$this->form_validation->set_rules('update[quantity_required]');
		$this->form_validation->set_rules('update[quantity_discounted]');
		$this->form_validation->set_rules('update[value_required]');
		$this->form_validation->set_rules('update[value_discounted]');
		$this->form_validation->set_rules('update[recursive]');
		$this->form_validation->set_rules('update[unique]');
		$this->form_validation->set_rules('update[void_reward]');
		$this->form_validation->set_rules('update[force_shipping]');
		$this->form_validation->set_rules('update[custom_status_1]');
		$this->form_validation->set_rules('update[custom_status_2]');
		$this->form_validation->set_rules('update[custom_status_3]');
		$this->form_validation->set_rules('update[order_by]');

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			$row = $this->input->post('update');
		
			$sql_update = array(
				$this->flexi_cart_admin->db_column('discounts', 'type') => $row['type'],
				$this->flexi_cart_admin->db_column('discounts', 'method') => $row['method'],
				$this->flexi_cart_admin->db_column('discounts', 'tax_method') => $row['tax_method'],
				$this->flexi_cart_admin->db_column('discounts', 'location') => $row['location'],
				$this->flexi_cart_admin->db_column('discounts', 'zone') => $row['zone'],
				$this->flexi_cart_admin->db_column('discounts', 'group') => $row['group'],
				$this->flexi_cart_admin->db_column('discounts', 'item') => $row['item'],
				$this->flexi_cart_admin->db_column('discounts', 'code') => $row['code'],
				$this->flexi_cart_admin->db_column('discounts', 'description') => $row['description'],
				$this->flexi_cart_admin->db_column('discounts', 'quantity_required') => $row['quantity_required'],
				$this->flexi_cart_admin->db_column('discounts', 'quantity_discounted') => $row['quantity_discounted'],
				$this->flexi_cart_admin->db_column('discounts', 'value_required') => $row['value_required'],
				$this->flexi_cart_admin->db_column('discounts', 'value_discounted') => $row['value_discounted'],
				$this->flexi_cart_admin->db_column('discounts', 'recursive') => $row['recursive'],
				$this->flexi_cart_admin->db_column('discounts', 'non_combinable') => $row['non_combinable'],
				$this->flexi_cart_admin->db_column('discounts', 'void_reward_points') => $row['void_reward'],
				$this->flexi_cart_admin->db_column('discounts', 'force_shipping_discount') => $row['force_shipping'],
				$this->flexi_cart_admin->db_column('discounts', 'custom_status_1') => $row['custom_status_1'],
				$this->flexi_cart_admin->db_column('discounts', 'custom_status_2') => $row['custom_status_2'],
				$this->flexi_cart_admin->db_column('discounts', 'custom_status_3') => $row['custom_status_3'],
				$this->flexi_cart_admin->db_column('discounts', 'usage_limit') => $row['usage_limit'],
				$this->flexi_cart_admin->db_column('discounts', 'valid_date') => $row['valid_date'],
				$this->flexi_cart_admin->db_column('discounts', 'expire_date') => $row['expire_date'],
				$this->flexi_cart_admin->db_column('discounts', 'status') => $row['status'],
				$this->flexi_cart_admin->db_column('discounts', 'order_by') => $row['order_by'],
                                "disc_resumen" =>$row['resumen']
			);

			if ($this->flexi_cart_admin->update_db_discount($sql_update, $discount_id))
			{
				// Update was successful, redirect.
				$redirect_page = ($row['type'] == 1) ? 'item_discounts' : 'summary_discounts';
				
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				redirect('admin_library/'.$redirect_page);
			}
			else
			{
				// Set errors.
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				redirect(current_url());
			}
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}

	function demo_update_discount_generica($discount_id, $tabla_descuentos){
		$this->load->library('form_validation');

		// Set validation rules.
		$this->form_validation->set_rules('update[type]', 'Discount Type', 'greater_than[0]');
		$this->form_validation->set_rules('update[method]', 'Discount Method', 'greater_than[0]');
		$this->form_validation->set_rules('update[usage_limit]', 'Usage Limit', 'required');
		$this->form_validation->set_rules('update[valid_date]', 'Valid Date', 'required');
		$this->form_validation->set_rules('update[expire_date]', 'Expire Date', 'required');
		
		// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
		$this->form_validation->set_rules('update[tax_method]');
		$this->form_validation->set_rules('update[location]');
		$this->form_validation->set_rules('update[zone]');
		$this->form_validation->set_rules('update[group]');
		$this->form_validation->set_rules('update[item]');
		$this->form_validation->set_rules('update[code]');
		$this->form_validation->set_rules('update[description]');
		$this->form_validation->set_rules('update[quantity_required]');
		$this->form_validation->set_rules('update[quantity_discounted]');
		$this->form_validation->set_rules('update[value_required]');
		$this->form_validation->set_rules('update[value_discounted]');
		$this->form_validation->set_rules('update[recursive]');
		$this->form_validation->set_rules('update[unique]');
		$this->form_validation->set_rules('update[void_reward]');
		$this->form_validation->set_rules('update[force_shipping]');
		$this->form_validation->set_rules('update[custom_status_1]');
		$this->form_validation->set_rules('update[custom_status_2]');
		$this->form_validation->set_rules('update[custom_status_3]');
		$this->form_validation->set_rules('update[order_by]');

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			$row = $this->input->post('update');
		
			$sql_update = array(
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'type') => $row['type'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'method') => $row['method'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'tax_method') => $row['tax_method'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'location') => $row['location'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'zone') => $row['zone'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'group') => $row['group'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'item') => $row['item'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'code') => $row['code'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'description') => $row['description'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'quantity_required') => $row['quantity_required'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'quantity_discounted') => $row['quantity_discounted'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'value_required') => $row['value_required'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'value_discounted') => $row['value_discounted'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'recursive') => $row['recursive'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'non_combinable') => $row['non_combinable'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'void_reward_points') => $row['void_reward'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'force_shipping_discount') => $row['force_shipping'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'custom_status_1') => $row['custom_status_1'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'custom_status_2') => $row['custom_status_2'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'custom_status_3') => $row['custom_status_3'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'usage_limit') => $row['usage_limit'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'valid_date') => $row['valid_date'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'expire_date') => $row['expire_date'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'status') => $row['status'],
				$this->flexi_cart_admin->db_column('discounts', 'order_by') => $row['order_by'],
                                "disc_resumen" =>$row['resumen']
			);

			if ($this->flexi_cart_admin->update_db_discount_generica($sql_update, $discount_id, $tabla_descuentos))
			{
				// Update was successful, redirect.
				$redirect_page = ($row['type'] == 1) ? 'item_'.$tabla_descuentos : 'summary_'.$tabla_descuentos;
				
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				redirect('admin_library/'.$redirect_page);
			}
			else
			{
				// Set errors.
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				redirect(current_url());
			}
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_discount()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$this->form_validation->set_rules('insert[type]', 'Discount Type', 'greater_than[0]');
		$this->form_validation->set_rules('insert[method]', 'Discount Method', 'required|greater_than[0]');
		$this->form_validation->set_rules('insert[usage_limit]', 'Usage Limit', 'required');
		$this->form_validation->set_rules('insert[valid_date]', 'Valid Date', 'required');
		$this->form_validation->set_rules('insert[expire_date]', 'Expire Date', 'required');
		
		// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
		$this->form_validation->set_rules('insert[tax_method]');
		$this->form_validation->set_rules('insert[location]');
		$this->form_validation->set_rules('insert[zone]');
		$this->form_validation->set_rules('insert[group]');
		$this->form_validation->set_rules('insert[item]');
		$this->form_validation->set_rules('insert[code]');
		$this->form_validation->set_rules('insert[description]');
		$this->form_validation->set_rules('insert[quantity_required]');
		$this->form_validation->set_rules('insert[quantity_discounted]');
		$this->form_validation->set_rules('insert[value_required]');
		$this->form_validation->set_rules('insert[value_discounted]');
		$this->form_validation->set_rules('insert[recursive]');
		$this->form_validation->set_rules('insert[unique]');
		$this->form_validation->set_rules('insert[void_reward]');
		$this->form_validation->set_rules('insert[force_shipping]');
		$this->form_validation->set_rules('insert[custom_status_1]');
		$this->form_validation->set_rules('insert[custom_status_2]');
		$this->form_validation->set_rules('insert[custom_status_3]');
		$this->form_validation->set_rules('insert[order_by]');

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			$row = $this->input->post('insert');

			$sql_insert = array(
				$this->flexi_cart_admin->db_column('discounts', 'type') => $row['type'],
				$this->flexi_cart_admin->db_column('discounts', 'method') => $row['method'],
				$this->flexi_cart_admin->db_column('discounts', 'tax_method') => $row['tax_method'],
				$this->flexi_cart_admin->db_column('discounts', 'location') => $row['location'],
				$this->flexi_cart_admin->db_column('discounts', 'zone') => $row['zone'],
				$this->flexi_cart_admin->db_column('discounts', 'group') => $row['group'],
				$this->flexi_cart_admin->db_column('discounts', 'item') => $row['item'],
				$this->flexi_cart_admin->db_column('discounts', 'code') => $row['code'],
				$this->flexi_cart_admin->db_column('discounts', 'description') => $row['description'],
				$this->flexi_cart_admin->db_column('discounts', 'quantity_required') => $row['quantity_required'],
				$this->flexi_cart_admin->db_column('discounts', 'quantity_discounted') => $row['quantity_discounted'],
				$this->flexi_cart_admin->db_column('discounts', 'value_required') => $row['value_required'],
				$this->flexi_cart_admin->db_column('discounts', 'value_discounted') => $row['value_discounted'],
				$this->flexi_cart_admin->db_column('discounts', 'recursive') => $row['recursive'],
				$this->flexi_cart_admin->db_column('discounts', 'non_combinable') => $row['non_combinable'],
				$this->flexi_cart_admin->db_column('discounts', 'void_reward_points') => $row['void_reward'],
				$this->flexi_cart_admin->db_column('discounts', 'force_shipping_discount') => $row['force_shipping'],
				$this->flexi_cart_admin->db_column('discounts', 'custom_status_1') => $row['custom_status_1'],
				$this->flexi_cart_admin->db_column('discounts', 'custom_status_2') => $row['custom_status_2'],
				$this->flexi_cart_admin->db_column('discounts', 'custom_status_3') => $row['custom_status_3'],
				$this->flexi_cart_admin->db_column('discounts', 'usage_limit') => $row['usage_limit'],
				$this->flexi_cart_admin->db_column('discounts', 'valid_date') => $row['valid_date'],
				$this->flexi_cart_admin->db_column('discounts', 'expire_date') => $row['expire_date'],
				$this->flexi_cart_admin->db_column('discounts', 'status') => $row['status'],
				$this->flexi_cart_admin->db_column('discounts', 'order_by') => $row['order_by'],
                                "disc_resumen" =>$row['resumen']
			);

			$this->flexi_cart_admin->insert_db_discount($sql_insert);
			
			$redirect_page = ($row['type'] == 1) ? 'item_discounts' : 'summary_discounts';
			
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/'.$redirect_page);
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}

	function demo_insert_discount_generica($tabla_descuentos)
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$this->form_validation->set_rules('insert[type]', 'Discount Type', 'greater_than[0]');
		$this->form_validation->set_rules('insert[method]', 'Discount Method', 'required|greater_than[0]');
		$this->form_validation->set_rules('insert[usage_limit]', 'Usage Limit', 'required');
		$this->form_validation->set_rules('insert[valid_date]', 'Valid Date', 'required');
		$this->form_validation->set_rules('insert[expire_date]', 'Expire Date', 'required');
		
		// The following fields are not validated, however must be included as done below or their data will not be repopulated by CI.
		$this->form_validation->set_rules('insert[tax_method]');
		$this->form_validation->set_rules('insert[location]');
		$this->form_validation->set_rules('insert[zone]');
		$this->form_validation->set_rules('insert[group]');
		$this->form_validation->set_rules('insert[item]');
		$this->form_validation->set_rules('insert[code]');
		$this->form_validation->set_rules('insert[description]');
		$this->form_validation->set_rules('insert[quantity_required]');
		$this->form_validation->set_rules('insert[quantity_discounted]');
		$this->form_validation->set_rules('insert[value_required]');
		$this->form_validation->set_rules('insert[value_discounted]');
		$this->form_validation->set_rules('insert[recursive]');
		$this->form_validation->set_rules('insert[unique]');
		$this->form_validation->set_rules('insert[void_reward]');
		$this->form_validation->set_rules('insert[force_shipping]');
		$this->form_validation->set_rules('insert[custom_status_1]');
		$this->form_validation->set_rules('insert[custom_status_2]');
		$this->form_validation->set_rules('insert[custom_status_3]');
		$this->form_validation->set_rules('insert[order_by]');

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			$row = $this->input->post('insert');

			$sql_insert = array(
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'type') => $row['type'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'method') => $row['method'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'tax_method') => $row['tax_method'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'location') => $row['location'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'zone') => $row['zone'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'group') => $row['group'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'item') => $row['item'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'code') => $row['code'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'description') => $row['description'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'quantity_required') => $row['quantity_required'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'quantity_discounted') => $row['quantity_discounted'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'value_required') => $row['value_required'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'value_discounted') => $row['value_discounted'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'recursive') => $row['recursive'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'non_combinable') => $row['non_combinable'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'void_reward_points') => $row['void_reward'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'force_shipping_discount') => $row['force_shipping'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'custom_status_1') => $row['custom_status_1'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'custom_status_2') => $row['custom_status_2'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'custom_status_3') => $row['custom_status_3'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'usage_limit') => $row['usage_limit'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'valid_date') => $row['valid_date'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'expire_date') => $row['expire_date'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'status') => $row['status'],
				$this->flexi_cart_admin->db_column($tabla_descuentos, 'order_by') => $row['order_by'],
                                "disc_resumen" =>$row['resumen']
			);

			$this->flexi_cart_admin->insert_db_discount_generica($sql_insert, $tabla_descuentos);
			
			$redirect_page = ($row['type'] == 1) ? 'item_'.$tabla_descuentos : 'summary_'.$tabla_descuentos;
			
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/'.$redirect_page);
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
		
		
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	function demo_update_discount_groups()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		foreach($this->input->post('update') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$this->form_validation->set_rules('update['.$id.'][name]', 'Row #'.$i.' Name', 'required');
			
			// The following fields are not validated, however must be included as done below or their data will not be repopulated.
			$this->form_validation->set_rules('update['.$id.'][status]');
		}

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			foreach($this->input->post('update') as $row)
			{
				if (isset($row['delete']) && $row['delete'] == 1)
				{
					$this->flexi_cart_admin->delete_db_discount_group($row['id']);
				}
				else
				{
					if (isset($row['status'])){
						$sql_update = array(
							$this->flexi_cart_admin->db_column('discount_groups', 'name') => $row['name'],
							$this->flexi_cart_admin->db_column('discount_groups', 'status') => $row['status'],
						);
					}	
					else{
						$sql_update = array(
							$this->flexi_cart_admin->db_column('discount_groups', 'name') => $row['name'],
						);
					}	
				
					$this->flexi_cart_admin->update_db_discount_group($sql_update, $row['id']);
				}
			}
			
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_update_discount_group($group_id)
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$this->form_validation->set_rules('update_group[name]', 'Name', 'required');

		// Validate fields.
		if ($this->form_validation->run()) 
		{
			$group_data = $this->input->post('update_group');
			
			$sql_update = array(
				$this->flexi_cart_admin->db_column('discount_groups', 'name') => $group_data['name'],
				$this->flexi_cart_admin->db_column('discount_groups', 'status') => $group_data['status']
			);
		
			$this->flexi_cart_admin->update_db_discount_group($sql_update, $group_id);
			
			###+++++++++++++++++++++++++++++++++###
			
			if ($this->input->post('delete_item'))
			{
				foreach($this->input->post('delete_item') as $row)
				{
					if ($row['delete'] == 1)
					{
						$sql_where = array($this->flexi_cart_admin->db_column('discount_group_items', 'id') => $row['id']);
						
						$this->flexi_cart_admin->delete_db_discount_group_item($sql_where);
					}
				}
			}
			
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect(current_url());
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_discount_group()
	{
	
		$this->load->library('form_validation');

		// Set validation rules.
		$this->form_validation->set_rules('insert_group[name]', 'Name', 'required');
		
		// The following fields are not validated, however must be included as done below or their data will not be repopulated.
		$this->form_validation->set_rules('insert_group[status]');

		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert_item') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert_item['.$id.'][logic_operator]', 'Row #'.$i.' Operator', 'required');
			$this->form_validation->set_rules('insert_item['.$id.'][column_name]', 'Row #'.$i.' Filter Column', 'required');
			$this->form_validation->set_rules('insert_item['.$id.'][comparison_operator]', 'Row #'.$i.' Filter Match Method', 'required');
			
			// The filter field is not validated, however must be included as done below or its data will not be repopulated.			
			$this->form_validation->set_rules('insert_item['.$id.'][value]');
		}
		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			// Create SQL WHERE statement from form filters.
			
			
			foreach($this->input->post('insert_item') as $data)
			{
				$column_name = $this->demo_get_discount_group_column($data['column_name']);
				if ($column_name)
				{
					// The 'create_sql_where()' function will use CI's active record to generate an SQL WHERE statement to filter items that match the query.
					$this->flexi_cart_admin->create_sql_where($column_name, $data['comparison_operator'], $data['value'], $data['logic_operator']);
					
				}
				
			}
			
			// Custom query getting item and category data.
			$query = $this->db->select('item_id,item_cat_fk')
				->from('demo_items')
				->join('demo_categories', 'cat_id = item_cat_fk', 'left')
                ->join('demo_coleccion', 'coleccion_id = item_coleccion_id', 'left')
				->get();
			
			if ($query->num_rows() > 0)
			{
				$group_data = $this->input->post('insert_group');
				
				$sql_insert = array(
					$this->flexi_cart_admin->db_column('discount_groups', 'name') => $group_data['name'],
					$this->flexi_cart_admin->db_column('discount_groups', 'status') => $group_data['status']
				);
			
				$group_id = $this->flexi_cart_admin->insert_db_discount_group($sql_insert);
			
				if ($group_id)
				{
					foreach($query->result_array() as $item)
					{
						
							$sql_insert = array(
								$this->flexi_cart_admin->db_column('discount_group_items', 'group') => $group_id,
								$this->flexi_cart_admin->db_column('discount_group_items', 'item') => $item['item_id']
							);
							
							$this->flexi_cart_admin->insert_db_discount_group_item($sql_insert);
						
					}
				}
				
				$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
				redirect('admin_library/update_discount_group/'.$group_id);
			}
			else
			{
				$this->data['message'] = '<p class="error_msg">There are no items matching the submitted SQL WHERE statement.</p>';
				$this->data['validation_row_ids'] = $row_ids;
				
				return FALSE;
			}
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function demo_insert_discount_group_items($group_id)
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$i = 0;
		$row_ids = array();
		foreach($this->input->post('insert_item') as $id => $row)
		{
			$i++; // Identify rows using standard counting starting from 1 rather than 0.
			$row_ids[] = $id; // Save row indexes incase validation fails and the form needs to be repopulated.
			$this->form_validation->set_rules('insert_item['.$id.'][logic_operator]', 'Row #'.$i.' Operator', 'required');
			$this->form_validation->set_rules('insert_item['.$id.'][column_name]', 'Row #'.$i.' Filter Column', 'required');
			$this->form_validation->set_rules('insert_item['.$id.'][comparison_operator]', 'Row #'.$i.' Filter Match Method', 'required');

			// The filter field is not validated, however must be included as done below or its data will not be repopulated.			
			$this->form_validation->set_rules('insert_item['.$id.'][value]');
		}

		// The following fields are not validated, however must be included as done below or their data will not be repopulated.
		$this->form_validation->set_rules('insert_method');

		
		// Validate fields.
		if ($this->form_validation->run()) 
		{
			// Create SQL WHERE statement from form filters.
			foreach($this->input->post('insert_item') as $data)
			{
				$column_name = $this->demo_get_discount_group_column($data['column_name']);
				
				if ($column_name)
				{
					$this->flexi_cart_admin->create_sql_where($column_name, $data['comparison_operator'], $data['value'], $data['logic_operator']);
				}
                
			}
			
			// Custom Item query.
			$query = $this->db->select('item_id')
				->from('demo_items')
				->join('demo_categories', 'cat_id = item_cat_fk', 'left')
                ->join('demo_coleccion', 'coleccion_id = item_coleccion_id', 'left')
				->get();
				/*
		    print '<pre><xmp>';
		    print_r($_POST);
		    print '</xmp></pre>';
				echo "<br />".$this->db->last_query();
		    print '<pre><xmp>';
		    print_r($query->result_array());
		    print '</xmp></pre>';
		    exit;
		    */

		  // ---------------------------------------------------------------------------------------------------------------------------------------  
		  // 2025-02-18
		  // Movemos la eliminación de artículos si pedimos reemplazo. Si no llega ninguno a meter, quedará vacío, pero eliminamos lo que había
		  // Antes solo se hacía si llegaban nuevos items  
		  // ---------------------------------------------------------------------------------------------------------------------------------------  
			if ($this->input->post('insert_method') == 'replace'){
				$sql_where = array($this->flexi_cart_admin->db_column('discount_group_items', 'group') => $group_id);
				$this->flexi_cart_admin->delete_db_discount_group_item($sql_where);
			}
			
			if ($query->num_rows() > 0){
				/*
				if ($this->input->post('insert_method') == 'replace'){
					$sql_where = array($this->flexi_cart_admin->db_column('discount_group_items', 'group') => $group_id);
					$this->flexi_cart_admin->delete_db_discount_group_item($sql_where);
				}
				*/
				foreach($query->result_array() as $item_data)
				{
					$sql_insert = array(
						$this->flexi_cart_admin->db_column('discount_group_items', 'group') => $group_id,
						$this->flexi_cart_admin->db_column('discount_group_items', 'item') => $item_data['item_id']
					);
					
					$this->flexi_cart_admin->insert_db_discount_group_item($sql_insert);
				}
			}
			
			$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
			redirect('admin_library/update_discount_group/'.$group_id);
		}
		else
		{
			// Set validation errors and field name ids so that data can be repopulated for all rows.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			$this->data['validation_row_ids'] = $row_ids;
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
		
	function demo_get_discount_group_column($value)
	{
		$table_columns = array(
			'item_id' => 'item_id',
			'item_name' => 'item_name',
			'item_price' => 'item_price',
			'item_weight' => 'item_weight',
			'cat_id' => 'item_cat_fk',
			'cat_name' => 'cat_name',
            'coleccion_name' => 'coleccion_name',
            'item_tipo'=>'item_tipo'
		);
		
		return (isset($table_columns[$value])) ? $table_columns[$value] : FALSE;
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// REWARD POINTS AND VOUCHERS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
			
	function demo_reward_point_summary($user_id = FALSE)
	{
		$sql_select = array(
			'user_id', 
			'user_name'
		);
	
		if ($user_id)
		{
			$this->db->where('user_id', $user_id);
		}
	
		$query = $this->db->select($sql_select)
			->get('demo_users');
			
		if ($query->num_rows() > 0)
		{
			$user_data = array();
			foreach($query->result_array() as $column)
			{
				$summary_data = $this->flexi_cart_admin->get_db_reward_point_summary($column['user_id']);
				
				$user_data[] = array(
					'user_id' => $column['user_id'],
					'user_name' => $column['user_name'],
					'total_points' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points')],
					'total_points_pending' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_pending')],
					'total_points_active' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_active')],
					'total_points_active' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_active')],
					'total_points_expired' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_expired')],
					'total_points_converted' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_converted')],
					'total_points_cancelled' => $summary_data[$this->flexi_cart_admin->db_column('reward_points', 'total_points_cancelled')]
				);
			}
			
			return $user_data;
		}
		
		return FALSE;
	}
		
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * demo_get_converted_reward_point_history
	 * Get data of all reward vouchers for a specific user.
	 * The returned array then nests another array of reward point data that was used to create the voucher.
	 */
	function demo_converted_reward_point_history($user_id)
	{
		$sql_select = array(
			$this->flexi_cart_admin->db_column('discounts', 'id'),
			$this->flexi_cart_admin->db_column('discounts', 'code')
		);
		
		$sql_where = array($this->flexi_cart_admin->db_column('discounts', 'user') => $user_id);
		
		$points_converted_data = $this->flexi_cart_admin->get_db_voucher_array($sql_select, $sql_where);
		
		// Loop through voucher data and get reward point data used to create voucher.
		foreach($points_converted_data as $row => $data)
		{
			$sql_select = array(
				$this->flexi_cart_admin->db_column('reward_points', 'order_number'),
				$this->flexi_cart_admin->db_column('reward_points', 'description'),
				$this->flexi_cart_admin->db_column('reward_points_converted', 'points'),
				$this->flexi_cart_admin->db_column('reward_points_converted', 'date')
			);
			
			$sql_where = array(
				$this->flexi->cart_database['reward_points_converted']['columns']['discount'] => $data[$this->flexi->cart_database['discounts']['columns']['id']]
			);
			
			$points_converted_data[$row]['reward_points'] = $this->flexi_cart_admin->get_db_converted_reward_points_array($sql_select, $sql_where);
		}

		return $points_converted_data;
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/*
	 * demo_update_voucher
	 */
	function demo_update_voucher()
	{
		foreach($this->input->post('update') as $row)
		{
			$sql_update = array(
				$this->flexi_cart_admin->db_column('discounts', 'status') => $row['status'],
			);
		
			$this->flexi_cart_admin->update_db_voucher($sql_update, $row['id']);
		}
		
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		redirect(current_url());
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * demo_convert_reward_points
	 */
	function demo_convert_reward_points($user_id)
	{
		$points_to_convert = $this->input->post('reward_points');
	
		$this->flexi_cart_admin->insert_db_voucher($user_id, $points_to_convert);
		
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		redirect('admin_library/user_vouchers/'.$user_id);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CART CONFIGURATION AND DEFAULTS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	function demo_update_config()
	{
		$data = $this->input->post('update');
	
		$sql_update = array(
			$this->flexi_cart_admin->db_column('configuration', 'order_number_prefix') => $data['order_number_prefix'],
			$this->flexi_cart_admin->db_column('configuration', 'order_number_suffix') => $data['order_number_suffix'],
			$this->flexi_cart_admin->db_column('configuration', 'increment_order_number') => $data['increment_order_number'],
			$this->flexi_cart_admin->db_column('configuration', 'minimum_order') => $data['minimum_order'],
			$this->flexi_cart_admin->db_column('configuration', 'quantity_decimals') => $data['quantity_decimals'],
			$this->flexi_cart_admin->db_column('configuration', 'increment_duplicate_item_quantity') => $data['increment_duplicate_item_quantity'],
			$this->flexi_cart_admin->db_column('configuration', 'quantity_limited_by_stock') => $data['quantity_limited_by_stock'],
			$this->flexi_cart_admin->db_column('configuration', 'remove_no_stock_items') => $data['remove_no_stock_items'],
			$this->flexi_cart_admin->db_column('configuration', 'auto_allocate_stock') => $data['auto_allocate_stock'],
			$this->flexi_cart_admin->db_column('configuration', 'weight_type') => $data['weight_type'],
			$this->flexi_cart_admin->db_column('configuration', 'weight_decimals') => $data['weight_decimals'],
			$this->flexi_cart_admin->db_column('configuration', 'display_tax_prices') => $data['display_tax_prices'],
			$this->flexi_cart_admin->db_column('configuration', 'price_inc_tax') => $data['price_inc_tax'],
			$this->flexi_cart_admin->db_column('configuration', 'multi_row_duplicate_items') => $data['multi_row_duplicate_items'],
			$this->flexi_cart_admin->db_column('configuration', 'dynamic_reward_points') => $data['dynamic_reward_points'],
			$this->flexi_cart_admin->db_column('configuration', 'reward_point_multiplier') => $data['reward_point_multiplier'],
			$this->flexi_cart_admin->db_column('configuration', 'reward_voucher_multiplier') => $data['reward_voucher_multiplier'],
			$this->flexi_cart_admin->db_column('configuration', 'reward_point_to_voucher_ratio') => $data['reward_point_to_voucher_ratio'],
			$this->flexi_cart_admin->db_column('configuration', 'reward_point_days_pending') => $data['reward_point_days_pending'],
			$this->flexi_cart_admin->db_column('configuration', 'reward_point_days_valid') => $data['reward_point_days_valid'],
			$this->flexi_cart_admin->db_column('configuration', 'reward_voucher_days_valid') => $data['reward_voucher_days_valid'],
			$this->flexi_cart_admin->db_column('configuration', 'save_banned_shipping_items') => $data['save_banned_shipping_items'],
			$this->flexi_cart_admin->db_column('configuration', 'custom_status_1') => $data['custom_status_1'],
			$this->flexi_cart_admin->db_column('configuration', 'custom_status_2') => $data['custom_status_2'],
			$this->flexi_cart_admin->db_column('configuration', 'custom_status_3') => $data['custom_status_3']
		);
	
		$this->flexi_cart_admin->update_db_config($sql_update);
		
		// Destroy the current cart and all settings so that new config settings can be set.
		// Note: The 'destroy_cart()' function is apart of the standard library.
		$this->load->library('flexi_cart');
		$this->flexi_cart->destroy_cart();
		
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		redirect(current_url());
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	function demo_update_defaults()
	{
		$data = $this->input->post('update');

		###+++++++++++++++++++++++++++++++++###
		
		// Reset all cart defaults.
		$sql_update = array('curr_default' => 0);
		$this->flexi_cart_admin->update_db_currency($sql_update);
	
		$sql_update = array('loc_ship_default' => 0, 'loc_tax_default' => 0);
		$this->flexi_cart_admin->update_db_location($sql_update);
	
		$sql_update = array('ship_default' => 0);
		$this->flexi_cart_admin->update_db_shipping($sql_update);
	
		$sql_update = array('tax_default' => 0);
		$this->flexi_cart_admin->update_db_tax($sql_update);
					
		###+++++++++++++++++++++++++++++++++###

		// Set new cart defaults.			
		$sql_update = array('curr_default' => 1);
		
		$this->flexi_cart_admin->update_db_currency($sql_update, $data['currency']);

		$sql_update = array('loc_ship_default' => 1);
		$this->flexi_cart_admin->update_db_location($sql_update, $data['shipping_location']);
		
		$sql_update = array('loc_tax_default' => 1);
		$this->flexi_cart_admin->update_db_location($sql_update, $data['tax_location']);
		
		$sql_update = array('ship_default' => 1);
		$this->flexi_cart_admin->update_db_shipping($sql_update, $data['shipping_option']);
		
		$sql_update = array('tax_default' => 1);
		$this->flexi_cart_admin->update_db_tax($sql_update, $data['tax_rate']);
		
		###+++++++++++++++++++++++++++++++++###
		
		$this->session->set_flashdata('message', $this->flexi_cart_admin->get_messages('admin'));
		redirect(current_url());
	}
    
    private function send_email($email, $subject, $body){
			$this->load->library('email');
			$config['wordwrap'] = FALSE;
			$config['mailtype'] = 'html'; 
			$this->email->initialize($config);
			$this->email->from('info@depapelpintado.es', 'dePapelPintado');
			$this->email->to($email);

			$this->email->bcc('pagos@depapelpintado.es');

			$this->email->subject($subject);
			$this->email->message($this->load->view('frontend/cuentas/plantillamail', $body,TRUE));

			$this->email->send();
    }

		function update_order_test($order_number){
			$sql_w = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
			$order_data = $this->flexi_cart_admin->get_db_order_summary_row_array("*", $sql_w);
			$pedido = $this->getPedido($order_number);
			if ($order_data['ord_user_ekam_fk']!=0){
				$body=array(
					"nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
					"msg"=>"Su pedido $order_number está siendo procesado.",
					"pedido"=>$this->getPedido($order_number)
				);
				$this->send_email_ekam('enanclares77@gmail.com',"[TEST] El pedido $order_number está siendo procesado",$body);
				echo 'Enviado';
			}
			/*
			if($this->input->post('update_status')==3){
				$body=array(
				"nombre"=>($order_data['ord_demo_ship_name']!="")?$order_data['ord_demo_ship_name']:$order_data['ord_demo_bill_name'],
				"msg"=>"Su pedido $order_number está siendo procesado.",
				"pedido"=>$this->getPedido($order_number)
				);
				$this->send_email($order_data['ord_demo_email'],"El pedido $order_number está siendo procesado",$body);
			}
			*/
		}
    private function send_email_ekam($email, $subject, $body){
        $this->load->library('email');
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        $this->email->from('info@decoracionbilbao.es', 'EKAM Decoracion');
        $this->email->to($email);

        $this->email->bcc('pagos@decoracionbilbao.es');
        //$this->email->bcc('enanclares77@gmail.com');

        $this->email->subject($subject);
        $this->email->message($this->load->view('frontend/cuentas/ekam/plantillamail', $body, TRUE));

        $this->email->send();
    }

     private function send_email_fra($email, $subject, $body){
      
$this->load->library('email');
$config['wordwrap'] = FALSE;
$config['mailtype'] = 'html'; 
$this->email->initialize($config);
$this->email->from('info@depapelpintado.es', 'dePapelPintado');
$this->email->to($email);

$this->email->bcc('pagos@depapelpintado.es');

$this->email->subject($subject);
$this->email->message($this->load->view('frontend/cuentas/plantillamailfra', $body,TRUE));

$this->email->send();

    }
		private function getPedido($ped){
			$this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE,array("ord_order_number"=>$ped));
			$sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $ped);
			$this->data['item_data'] = $this->db->select("*")->from("order_details")->where("ord_det_order_number_fk",$ped)->get()->result_array();
		  $this->data['refund_data'] = $this->db->query("SELECT SUM(ord_det_quantity_cancelled * ord_det_price) AS ord_det_price, SUM(ord_det_quantity_cancelled * ord_det_discount_price) AS ord_det_discount_price, SUM(ord_det_quantity_cancelled * ord_det_tax) AS ord_det_tax, SUM(ord_det_quantity_cancelled * ord_det_shipping_rate) AS ord_det_shipping_rate, SUM(ord_det_quantity_cancelled * ord_det_weight) AS ord_det_weight, SUM(ord_det_quantity_cancelled * ord_det_reward_points) AS ord_det_reward_points FROM (`order_details`) WHERE `ord_det_order_number_fk` ='".$ped."'")->result_array();    

			if (isset($this->data['summary_data'][0]['ord_user_ekam_fk']) && $this->data['summary_data'][0]['ord_user_ekam_fk']!=0)
			  return $this->load->view('frontend/cuentas/ekam/pedidoPlantilla', $this->data,TRUE);
			else
			  return $this->load->view('frontend/cuentas/pedidoPlantilla', $this->data,TRUE);
		}
private function getFactura($ped){
	$this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE,array("ord_order_number"=>$ped));
	$sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $ped);
	$this->data['item_data'] = $this->db->select("*")->from("order_details")->where("ord_det_order_number_fk",$ped)->get()->result_array();
	$this->data['refund_data'] = $this->db->query("SELECT SUM(ord_det_quantity_cancelled * ord_det_price) AS ord_det_price, SUM(ord_det_quantity_cancelled * ord_det_discount_price) AS ord_det_discount_price, SUM(ord_det_quantity_cancelled * ord_det_tax) AS ord_det_tax, SUM(ord_det_quantity_cancelled * ord_det_shipping_rate) AS ord_det_shipping_rate, SUM(ord_det_quantity_cancelled * ord_det_weight) AS ord_det_weight, SUM(ord_det_quantity_cancelled * ord_det_reward_points) AS ord_det_reward_points FROM (`order_details`) WHERE `ord_det_order_number_fk` ='".$ped."'")->result_array();    
	$this->data['rectificativa'] = false;    
	return $this->load->view('frontend/cuentas/facturaPlantilla', $this->data,TRUE);
}
private function getFacturaRect($ped){
	$this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE,array("ord_order_number"=>$ped));
	$sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $ped);
	$this->data['item_data'] = $this->db->select("*")->from("order_details")->where("ord_det_order_number_fk",$ped)->get()->result_array();
	$this->data['refund_data'] = $this->db->query("SELECT SUM(ord_det_quantity_cancelled * ord_det_price) AS ord_det_price, SUM(ord_det_quantity_cancelled * ord_det_discount_price) AS ord_det_discount_price, SUM(ord_det_quantity_cancelled * ord_det_tax) AS ord_det_tax, SUM(ord_det_quantity_cancelled * ord_det_shipping_rate) AS ord_det_shipping_rate, SUM(ord_det_quantity_cancelled * ord_det_weight) AS ord_det_weight, SUM(ord_det_quantity_cancelled * ord_det_reward_points) AS ord_det_reward_points FROM (`order_details`) WHERE `ord_det_order_number_fk` ='".$ped."'")->result_array();    
	$this->data['rectificativa'] = true;    
	return $this->load->view('frontend/cuentas/facturaPlantilla', $this->data,TRUE);
}    
private function getTicket($ped){
      $this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_array(FALSE,array("ord_order_number"=>$ped));
		$sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $ped);
		$this->data['item_data'] = $this->db->select("*")->from("order_details")->where("ord_det_order_number_fk",$ped)->get()->result_array();
        $this->data['refund_data'] = $this->db->query("SELECT SUM(ord_det_quantity_cancelled * ord_det_price) AS ord_det_price, SUM(ord_det_quantity_cancelled * ord_det_discount_price) AS ord_det_discount_price, SUM(ord_det_quantity_cancelled * ord_det_tax) AS ord_det_tax, SUM(ord_det_quantity_cancelled * ord_det_shipping_rate) AS ord_det_shipping_rate, SUM(ord_det_quantity_cancelled * ord_det_weight) AS ord_det_weight, SUM(ord_det_quantity_cancelled * ord_det_reward_points) AS ord_det_reward_points FROM (`order_details`) WHERE `ord_det_order_number_fk` ='".$ped."'")->result_array();    return $this->load->view('frontend/cuentas/ticketPlantilla', $this->data,TRUE);
    }
}
/* End of file demo_cart_admin_model.php */
/* Location: ./application/models/demo_cart_admin_model.php */


