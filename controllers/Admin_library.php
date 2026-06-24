<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_library extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		
		// To load the CI benchmark and memory usage profiler - set 1==1.
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

		// Load CI libraries and helpers.
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('text');
 		$this->load->helper('url');
 		$this->load->helper('form');

 		// Example of defining a specific language to return flexi carts status and error messages.
 		// The defined language file must be added to the CI application directory as 'application/language/[language_name]/flexi_cart_lang.php'.
 		// Alternatively, CI's default language can be set via the CI config. file.
 		// Note: This must be defined before $this->load->library('flexi_cart').
 		# $this->lang->load('flexi_cart', 'spanish');

 		// IMPORTANT! This global must be defined BEFORE the flexi cart library is loaded! 
 		// It is used as a global that is accessible via both models and both libraries, without it, flexi cart will not work.
		$this->flexi = new stdClass;
		
		// Load 'admin' flexi cart library by default.
		$this->load->library('flexi_cart_admin');
    $this->user['user']="ekam";
    //$this->user['pass']="P4p3lp1nt4d02016!";
    $this->user['pass']="P4p3lp1nt4d02016!2023";
		// Note: This is only included to create base urls for purposes of this demo only and are not necessarily considered as 'Best practice'.
		$this->load->vars('base_url', base_url());
		$this->load->vars('includes_dir', base_url().'includes/');
		$this->load->vars('current_url', $this->uri->uri_to_assoc(1));
		$this->islogged();
		// Load cart data to be displayed via 'Mini Cart' menu.
		$this->mini_cart_data();
	}
	
	/**
	 * FLEXI CART ADMIN DEMO
	 * Many of the functions within this controller load a custom model called 'demo_cart_admin_model' that has been created for the purposes of this demo.
	 * This file is not part of flexi cart, it is included to demonstrate how some of the functions of flexi cart can be used.
	 */
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// ADMIN DASHBOARD
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * index
	 * View and manage all the available admin functions within flexi cart.
	 */ 
	function index() 
	{	
      $this->load->view('demo/admin_examples/dashboard_view', $this->data);
		//$this->load->view('demo/admin_examples/admin_main', $this->data);
        redirect('admin_library/articulos');
	}

  function objeto_vacio($tabla){
    $campos=$this->db->list_fields('nueva_categoria');
    $objeto=new stdClass();
    foreach($campos as $nombre_campo){
      $objeto->$nombre_campo='';
    }
    return $objeto;
  }
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CUSTOM ITEM TABLE
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * items
	 * Whilst flexi cart takes care of online ordering, shipping rates, tax rates, discounts and currencies, it leaves the database structure for item and category 
	 * tables completely up to the design of the developer.
	 * For the purposes of demonstrating some of flexi carts features, a demo item, and category table have been included that are then linked to some of the cart functions.
	 */
    
    function islogged(){
      if($this->session->userdata('hash')!=md5($this->user['user'].$this->user['pass']) && $this->input->cookie('hash')!=md5($this->user['user'].$this->user['pass']))redirect ('tienda');
    }
    function contenido(){
    //  $this->db->where("item_economico",1)->update("demo_items",array("activo"=>1));
      
      $this->load->model('contenido_model');
      $this->data['portada']=$this->contenido_model->get_page(1);
      $this->data['paginas']=$this->contenido_model->get_promos(true,false);
      $this->data['paginasr']=$this->contenido_model->get_promos(false,false);
      $this->load->view('contenido_view', $this->data);
    }
    function slider(){
      $this->load->model('contenido_model');
      //$this->data['paginas']=$this->contenido_model->get_imagenes(false);
      $this->data['paginas']=$this->contenido_model->get_imagenes_admin(false);
      $this->load->view('slider_view', $this->data);
    }

    function editpagina($a=""){
      if ($a=="")redirect ('admin_library/contenido');
      $this->load->model('contenido_model');
      $this->data['pagina']=$this->contenido_model->get_page_edit($a);
      $this->load->view('contenidoedit_view', $this->data);
    }
    function update_page($a=""){
      if(!$this->input->post('id'))redirect ('admin_library/contenido');
      $this->load->model('contenido_model');
      $this->data['pagina']=$this->contenido_model->update_page();
	  //$this->db->cache_delete_all();
      if($this->input->post('tipo')=="Imagen")redirect ('admin_library/slider');
      else redirect ('admin_library/contenido');
    }
    function activarpagina($id="",$activo=0){
      if($id=="")redirect ('admin_library/contenido');
      $this->load->model('contenido_model');
      $this->data['pagina']=$this->contenido_model->toogle($id,$activo);
      redirect ('admin_library/contenido');
    }
    function activarimagen($id="",$activo=0){
      if($id=="")redirect ('admin_library/slider');
      $this->load->model('contenido_model');
      $this->data['pagina']=$this->contenido_model->toogle($id,$activo);
      redirect ('admin_library/slider');
    }
    function borrarimagen($id=""){
      if($id=="")redirect ('admin_library/slider');
      $this->load->model('contenido_model');
      $this->data['pagina']=$this->contenido_model->del($id);
      redirect ('admin_library/slider');
    }
    function addpromo($left=0){
      $this->load->model('contenido_model');
      $this->data['pagina']=$this->contenido_model->add_promo(($left==1)?true:false);
      redirect ('admin_library/contenido');
    }
    function addimage(){
      $this->load->model('contenido_model');
      $this->data['pagina']=$this->contenido_model->add_image();
      redirect ('admin_library/slider');
    }

    // ---- FAQs ----

    function faqs(){
      $this->load->model('demo_cart_admin_model');
      $filtro_tipo    = $this->input->get('tipo') ? $this->input->get('tipo') : '';
      $filtro_page_id = (int)$this->input->get('page_id');
      // Traer todas siempre; la vista las separa en pestañas
      $this->data['faqs']           = $this->demo_cart_admin_model->get_faqs_admin('', 0);
      $this->data['categorias_seo'] = $this->demo_cart_admin_model->get_categorias_seo_array_para_edicion();
      $this->data['filtro_tipo']    = $filtro_tipo;
      $this->data['filtro_page_id'] = $filtro_page_id;
      $this->load->view('demo/admin_examples/faqs/listado', $this->data);
    }

    function faq_nueva(){
      $this->load->model('demo_cart_admin_model');
      $prefill = new stdClass();
      $prefill->faq_id   = 0;
      $prefill->page_type = $this->input->get('tipo') === 'categoria' ? 'categoria' : 'home';
      $prefill->page_id   = (int)$this->input->get('page_id');
      $prefill->pregunta  = '';
      $prefill->respuesta = '';
      $prefill->orden     = 0;
      $prefill->activo    = 1;
      $this->data['faq']        = $prefill;
      $this->data['categorias_seo'] = $this->demo_cart_admin_model->get_categorias_seo_array_para_edicion();
      $this->load->view('demo/admin_examples/faqs/editar', $this->data);
    }

    function faq_editar($id=0){
      $this->load->model('demo_cart_admin_model');
      $this->data['faq']        = $this->demo_cart_admin_model->get_faq((int)$id);
      $this->data['categorias_seo'] = $this->demo_cart_admin_model->get_categorias_seo_array_para_edicion();
      $this->load->view('demo/admin_examples/faqs/editar', $this->data);
    }

    function faq_guardar(){
      $this->load->model('demo_cart_admin_model');
      $this->demo_cart_admin_model->save_faq();
      redirect('admin_library/faqs');
    }

    function faq_eliminar($id=0){
      $this->load->model('demo_cart_admin_model');
      $this->demo_cart_admin_model->delete_faq((int)$id);
      redirect('admin_library/faqs');
    }

    // ---- /FAQs ----

    function articulos(){
      $this->load->model('demo_cart_admin_model');
      $this->data['fab']=$this->demo_cart_admin_model->get_cat_array();
      $this->data['col']=$this->demo_cart_admin_model->get_col_array();
      $this->data['mod']=$this->demo_cart_admin_model->get_mod_array();
      $this->data['gama']=$this->demo_cart_admin_model->get_gama_array();
      $this->data['estilo']=$this->demo_cart_admin_model->get_estilo_array();
      $this->data['nuevas_categorias']=$this->demo_cart_admin_model->get_categorias_seo_array_para_edicion();
      //$this->data['nuevas_categorias']=array();
      //$this->data['all']=$this->demo_cart_admin_model->demo_get_item_data("DESC");
      $a_familias[]=6;
      $this->data['usar_alt_lista']=$this->demo_cart_admin_model->get_categorias_seo_array_para_edicion($a_familias);
      
      $this->data['all']=$this->demo_cart_admin_model->demo_get_last_item_data("DESC");
      //$this->data['all']=array();

      $this->load->view('demo/admin_examples/articulos/articulos', $this->data);
    }
    
    function articulos_crea_metas(){
      $this->load->model('demo_cart_admin_model');

      // Meta-titles
      $this->data['all']=$this->demo_cart_admin_model->demo_get_items_meta("DESC", 5000);
      foreach ($this->data['all'] as $key => $item) {
        //if (trim($item['meta_title'])==''){
          // code...
          /*
          print '<pre><xmp>';
          print_r($item);
          print '</xmp></pre>';
          */
          switch ($item['item_tipo']) {
              case 0: $categ = "Papel Pintado";
                  break;
              case 1: $categ = "Fotomural";
                  break;
              case 2: $categ = "Revestimiento";
                  break;
              case 3: $categ = "Tela";
                  break;
              case 4: $categ = "Alfombra";
                  break;
              case 5: $categ = "Herramientas";
                  break;
              default: break;
          }
          if (trim($item['item_name'])!=''){
            //$meta_title=ucwords(mb_strtolower ($item['coleccion_name']))." ".ucwords(mb_strtolower ($item['item_name']))." ".$item['item_ref']." ".ucwords(mb_strtolower ($item['cat_name']))." - ".$categ;
            $meta_title=$categ." ".ucwords(mb_strtolower ($item['item_name']))." de ".ucwords(mb_strtolower ($item['cat_name'])).", referencia ".$item['item_ref'];
            $meta_description=$categ.' '. ucwords(mb_strtolower ($item['item_name']))." (referencia {$item['item_ref']}) perteneciente a la colección ".ucwords(mb_strtolower ($item['coleccion_name']))." creada por ".ucwords(mb_strtolower ($item['cat_name'])).'.';
          }
          else{
            //$meta_title=ucwords(mb_strtolower ($item['coleccion_name']))." ".$item['item_ref']." ".ucwords(mb_strtolower ($item['cat_name']))." - ".$categ;
            $meta_title=$categ." ".ucwords(mb_strtolower ($item['cat_name'])).", referencia ".$item['item_ref'];
            $meta_description=$categ.' '. ucwords(mb_strtolower ($item['item_name']))." (referencia {$item['item_ref']}) perteneciente a la colección ".ucwords(mb_strtolower ($item['coleccion_name']))." creada por ".ucwords(mb_strtolower ($item['cat_name'])).'.';

            if ($item['cat_name']=='OUTLET'){
              $col_zatiak=explode('-', $item['coleccion_name']);
              $meta_title=$categ." ".ucwords(mb_strtolower ($item['cat_name'])).' '.ucwords(mb_strtolower($col_zatiak[0])).", referencia ".$item['item_ref'];
              $meta_description=$categ.' liquidación '. ucwords(mb_strtolower ($item['item_name']))." (referencia {$item['item_ref']}) perteneciente a la colección ".ucwords(mb_strtolower ($item['coleccion_name'])).'.';
            }
          }
          /*
          Sería catálogo-nombre papel y/o referencia numérica-marca-producto (mural ,papel pintado)
          Lamorran Coastline W7680-01 Osborne & Little Mural          
          */
          echo "<br />".$meta_title.' ('.strlen($meta_title).')';
          echo "<br />".$meta_description.' ('.strlen($meta_description).')';
          //exit;
         /*
         $itemarray=array(
            'meta_title'=>$data['meta_title'],
            'meta_description'=>$data['meta_description'],
            'meta_keywords'=>$data['meta_keywords'],
            'item_text'=>$data['her_text']);
         $item_id=$data['iher'];
         */
          $itemarray=array(
            'meta_title'=>$meta_title,
            'meta_description'=>$meta_description);
          $item_id=$item['item_id'];

          $this->db->where('item_id',$item_id)->update('demo_items',$itemarray);
          //echo "<br />".$meta_title;
      }
      exit;
      // Meta-description
      $this->data['all']=$this->demo_cart_admin_model->demo_get_items_meta_desc("DESC", 1000);
      foreach ($this->data['all'] as $key => $item) {
          /*
          print '<pre><xmp>';
          print_r($item);
          print '</xmp></pre>';
          */
          switch ($item['item_tipo']) {
              case 0: $categ = "Papel Pintado";
                  break;
              case 1: $categ = "Fotomural";
                  break;
              case 2: $categ = "Revestimiento";
                  break;
              case 3: $categ = "Tela";
                  break;
              case 4: $categ = "Alfombra";
                  break;
              case 5: $categ = "Herramienta";
                  break;
              default: break;
          }
          if (trim($item['item_name'])!='')
            $meta_description=$categ.' '. ucwords(mb_strtolower ($item['item_name']))." (referencia {$item['item_ref']}) perteneciente a la colección ".ucwords(mb_strtolower ($item['coleccion_name']))." creada por ".ucwords(mb_strtolower ($item['cat_name'])).'.';
          else
            $meta_description=$categ.' con referencia '.$item['item_ref'].' perteneciente a la colección '. ucwords(mb_strtolower ($item['coleccion_name']))." creada por ".ucwords(mb_strtolower ($item['cat_name'])).'.';
          
          $a_colores_aux=explode(',', $item['color']);
          $a_colores=array();
          foreach ($a_colores_aux as $color) {
            if (trim($color)!='')
              $a_colores[trim($color)]=trim($color);
          }
          if (count($a_colores)){
            $meta_description.=" Colores principales: ".ucwords(mb_strtolower (implode(', ', $a_colores))).'.';
          }

          $a_estilos_aux=explode(',', $item['estilo']);
          $a_estilos=array();
          foreach ($a_estilos_aux as $estilo) {
            if (trim($estilo)!='')
              $a_estilos[trim($estilo)]=trim($estilo);
          }
          if (count($a_estilos)){
            $meta_description.=" Estilos: ".ucwords(mb_strtolower (implode(', ', $a_estilos))).'.';
          }


          $itemarray=array(
            'meta_description'=>$meta_description);
          $item_id=$item['item_id'];

          $this->db->where('item_id',$item_id)->update('demo_items',$itemarray);
          //echo "<br />".$meta_description;
          /*
          exit;
          */
      }
      echo "<br />Metas actualizadas";

      exit;
      

    }
    function colecciones_crea_metas_malo(){
      $this->load->model('demo_cart_admin_model');

      // Meta-titles
      $colecciones=$this->demo_cart_admin_model->demo_get_colecciones_meta("DESC", 5000);
      /*
      print '<pre><xmp>';
      print_r($colecciones);
      print '</xmp></pre>';
      exit;
      */
      foreach ($colecciones as $key => $item) {
        //if (trim($item['meta_title'])==''){
          // code...
          print '<pre><xmp>';
          print_r($item);
          print '</xmp></pre>';
          /*
          exit;
          */
          switch ($item['item_tipo']) {
              case 0: $categ = "Papel Pintado";
                  break;
              case 1: $categ = "Fotomural";
                  break;
              case 2: $categ = "Revestimiento";
                  break;
              case 3: $categ = "Tela";
                  break;
              case 4: $categ = "Alfombra";
                  break;
              case 5: $categ = "Herramientas";
                  break;
              default: break;
          }
          if (trim($item['item_name'])!='')
            $meta_title=ucwords(mb_strtolower ($item['coleccion_name']))." ".ucwords(mb_strtolower ($item['item_name']))." ".$item['item_ref']." ".ucwords(mb_strtolower ($item['cat_name']))." - ".$categ;
          else
            $meta_title=ucwords(mb_strtolower ($item['coleccion_name']))." ".$item['item_ref']." ".ucwords(mb_strtolower ($item['cat_name']))." - ".$categ;
          /*
          Sería catálogo-nombre papel y/o referencia numérica-marca-producto (mural ,papel pintado)
          Lamorran Coastline W7680-01 Osborne & Little Mural          
          */
          echo "<br />".$meta_title;
          exit;

         /*
         $itemarray=array(
            'meta_title'=>$data['meta_title'],
            'meta_description'=>$data['meta_description'],
            'meta_keywords'=>$data['meta_keywords'],
            'item_text'=>$data['her_text']);
         $item_id=$data['iher'];
         */
          $itemarray=array(
            'meta_title'=>$meta_title);
          $item_id=$item['item_id'];
          print '<pre><xmp>';
          print_r($itemarray);
          print '</xmp></pre>';
          exit;

          //$this->db->where('item_id',$item_id)->update('demo_items',$itemarray);
          //echo "<br />".$meta_title;
      }
      exit;
      // Meta-description
      $this->data['all']=$this->demo_cart_admin_model->demo_get_items_meta_desc("DESC", 1000);
      foreach ($this->data['all'] as $key => $item) {
          /*
          print '<pre><xmp>';
          print_r($item);
          print '</xmp></pre>';
          */
          switch ($item['item_tipo']) {
              case 0: $categ = "Papel Pintado";
                  break;
              case 1: $categ = "Fotomural";
                  break;
              case 2: $categ = "Revestimiento";
                  break;
              case 3: $categ = "Tela";
                  break;
              case 4: $categ = "Alfombra";
                  break;
              case 5: $categ = "Herramienta";
                  break;
              default: break;
          }
          if (trim($item['item_name'])!='')
            $meta_description=$categ.' '. ucwords(mb_strtolower ($item['item_name']))." (referencia {$item['item_ref']}) perteneciente a la colección ".ucwords(mb_strtolower ($item['coleccion_name']))." creada por ".ucwords(mb_strtolower ($item['cat_name'])).'.';
          else
            $meta_description=$categ.' con referencia '.$item['item_ref'].' perteneciente a la colección '. ucwords(mb_strtolower ($item['coleccion_name']))." creada por ".ucwords(mb_strtolower ($item['cat_name'])).'.';
          
          $a_colores_aux=explode(',', $item['color']);
          $a_colores=array();
          foreach ($a_colores_aux as $color) {
            if (trim($color)!='')
              $a_colores[trim($color)]=trim($color);
          }
          if (count($a_colores)){
            $meta_description.=" Colores principales: ".ucwords(mb_strtolower (implode(', ', $a_colores))).'.';
          }

          $a_estilos_aux=explode(',', $item['estilo']);
          $a_estilos=array();
          foreach ($a_estilos_aux as $estilo) {
            if (trim($estilo)!='')
              $a_estilos[trim($estilo)]=trim($estilo);
          }
          if (count($a_estilos)){
            $meta_description.=" Estilos: ".ucwords(mb_strtolower (implode(', ', $a_estilos))).'.';
          }


          $itemarray=array(
            'meta_description'=>$meta_description);
          $item_id=$item['item_id'];

          $this->db->where('item_id',$item_id)->update('demo_items',$itemarray);
          /*
          echo "<br />".$meta_description;
          exit;
          */
      }
      echo "<br />Metas actualizadas";

      exit;
    }
    function categorias_crea_metas(){
      $this->load->model('demo_cart_admin_model');

      $registros=$this->demo_cart_admin_model->get_categories("ASC");
      /*
      print '<pre><xmp>';
      print_r($registros);
      print '</xmp></pre>';
      exit;
      */
      foreach ($registros as $key => $item) {
        if(strlen($item->meta_titlef)>100 || trim($item->meta_titlef)==''){

          $item->cats=str_replace('Foto Murales', 'Fotomurales',$item->cats);
          $categorias=explode(',', $item->cats);
          if (count($categorias)>1){
            $ultimo_elemento=array_pop($categorias);

            $item->meta_title=implode(', ', $categorias).' y '.$ultimo_elemento.' '.$item->cat_name;
            $item->meta_description='Tenemos las mejores colecciones de '.implode(', ', $categorias).' y '.$ultimo_elemento.' creadas por '.$item->cat_name.'. Catálogos actualizados en nuestra web. ¡Descúbrelos!';
          }
          else{
            $item->meta_title=implode(', ', $categorias).' '.$item->cat_name;
            $item->meta_description='Tenemos las mejores colecciones de '.implode(', ', $categorias).' creadas por '.$item->cat_name.'. Catálogos actualizados en nuestra web. ¡Descúbrelos!';
          }

          print '<pre><xmp>';
          print_r($item);
          print '</xmp></pre>';
          /*
          */
          $cat_array=array(
            'meta_titlef'=>$item->meta_title,
            'meta_descriptionf'=>$item->meta_description
          );
          $cat_id=$item->cat_id;

          $this->db->where('cat_id',$cat_id)->update('demo_categories',$cat_array);
          //exit;
        }
      }
    }
    function colecciones_crea_metas(){
      $this->load->model('demo_cart_admin_model');

      $registros=$this->demo_cart_admin_model->demo_get_colecciones_meta("ASC");
      //$colecciones=$this->demo_cart_admin_model->demo_get_colecciones_meta("DESC", 5000);
      /*
      print '<pre><xmp>';
      print_r($registros);
      print '</xmp></pre>';
      exit;
      */
      foreach ($registros as $key => $item) {
        if(strlen($item->meta_titlec)>100 || trim($item->meta_titlec)==''){
        //if(strlen($item->meta_descriptionc)=='' || trim($item->meta_titlec)==''){
        //if(strpos($item->meta_descriptionc, 'actualizados')){

          $categorias_id=explode(',', $item->ccats);
          $categorias=array();
          foreach($categorias_id as $tipo){
            switch ($tipo) {
              case 0: $categorias[] = "Papel Pintado";
                  break;
              case 1: $categorias[] = "Fotomurales";
                  break;
              case 2: $categorias[] = "Revestimientos";
                  break;
              case 3: $categorias[] = "Telas";
                  break;
              case 4: $categorias[] = "Alfombras";
                  break;
              case 5: $categorias[] = "Herramientas";
                  break;
              default: break;
            }
          }
          
          if (count($categorias)>1){
            $ultimo_elemento=array_pop($categorias);

            $item->meta_title=implode(', ', $categorias).' y '.$ultimo_elemento.' '.$item->coleccion_name;
            //$item->meta_title='Colección '.$item->coleccion_name.' de ' .implode(', ', $categorias).' y '.$ultimo_elemento;
            //$item->meta_title='Colección '.$item->coleccion_name.' de ' .implode(', ', $categorias).' y '.$ultimo_elemento.' '.$item->cat_name;
            $item->meta_description='Colección '.$item->coleccion_name.' de '.implode(', ', $categorias).' y '.$ultimo_elemento.' creada por '.$item->cat_name.'. Catálogo actualizado en nuestra web. ¡Descúbrelo!';
          }
          else{
            $item->meta_title=implode(', ', $categorias).' '.$item->coleccion_name;
            $item->meta_description='Colección '.$item->coleccion_name.' de '.implode(', ', $categorias).' creada por '.$item->cat_name.'. Catálogo actualizado en nuestra web. ¡Descúbrelo!';
            //$item->meta_description='Tenemos las mejores colecciones de '.implode(', ', $categorias).' creadas por '.$item->cat_name.'. Catálogos actualizados en nuestra web. ¡Descúbrelos!';
          }

          print '<pre><xmp>';
          print_r($item);
          print '</xmp></pre>';
          /*
          print '<pre><xmp>';
          print_r($registros);
          print '</xmp></pre>';
          exit;
          */
          $col_array=array(
            'meta_titlec'=>$item->meta_title,
            'meta_descriptionc'=>$item->meta_description
          );
          $coleccion_id=$item->coleccion_id;

          $this->db->where('coleccion_id',$coleccion_id)->update('demo_coleccion',$col_array);
          //exit;
        }
      }
    }
    
    function con_variantes($fab=0,$col=0){
      if($fab==0 && $this->input->post("fab"))$fab=$this->input->post("fab");
      if($col==0 && $this->input->post("col"))$col=$this->input->post("col");
      $this->load->model('demo_cart_admin_model');

      $this->data['variantes']=$this->demo_cart_admin_model->con_variantes($fab,$col);

      $this->load->view('demo/admin_examples/articulos/opciones_variantes', $this->data);
    }
    function con_relacionados($fab=0,$col=0){
      if($fab==0 && $this->input->post("fab"))$fab=$this->input->post("fab");
      if($col==0 && $this->input->post("col"))$col=$this->input->post("col");
      $this->load->model('demo_cart_admin_model');

      $this->data['relacionados']=$this->demo_cart_admin_model->con_relacionados($fab,$col);

      $this->load->view('demo/admin_examples/articulos/opciones_relacionados', $this->data);
    }
    function kudeatu_bilaketa_eremua ($saio_izena, $eremua, $defektuz='') {
      if (isset($_POST[$eremua]))  {
        $_SESSION[$saio_izena][$eremua]=$_POST[$eremua];
      } 
      else {
        //bilatu botoia sakatu da. CHECKBOX motako eremuak ondo funtzionatzeko egiten dugu hau.
        if (isset($_POST['bilatu'])) {
          $_SESSION[$saio_izena][$eremua]=NULL;
        }
      }
      
      $itzultzeko_balorea=$defektuz;
      if (isset($_SESSION[$saio_izena][$eremua])) 
        $itzultzeko_balorea=$_SESSION[$saio_izena][$eremua];
      
      return $itzultzeko_balorea;
    }

    function noimg($fab=0,$col=0,$gama=0,$estilo=0,$page=0,$todos=0,$order='item_id',$categ=-1,$precio='', $referencia=''){
      if (isset($_GET['limpiar']) && $_GET['limpiar']==1)
        if(isset($_SESSION['BUSCADOR_NOIMG']))
          unset ($_SESSION['BUSCADOR_NOIMG']);
      /*
      if(isset($_POST['fab']))$fab=$_POST['fab'];
      if(isset($_POST['col']))$col=$_POST['col'];
      if(isset($_POST['gama']))$gama=$_POST['gama'];
      if(isset($_POST['categ']))$categ=$_POST['categ'];
      if(isset($_POST['estilo']))$estilo=$_POST['estilo'];
      if(isset($_POST['item_activo']))$todos=1;
      if(isset($_POST['order']))$order=$_POST['order'];
      if(isset($_POST['precio']))$precio=$_POST['precio'];
      if(isset($_POST['referencia']))$referencia=$_POST['referencia'];
      */
      $fab = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'fab', $fab);
      $col = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'col', $col);
      $gama = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'gama', $gama);
      $categ = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'categ', $categ);
      $estilo = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'estilo', $estilo);
      $todos = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'todos', $todos);
      $order = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'order', $order);
      $precio = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'precio', $precio);
      $referencia = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'referencia', $referencia);  
      $cur_cat_seo = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'categoria_seo', 0);  
      $publico_be = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'publico_be', 0);  
      $vinilo_be = $this->kudeatu_bilaketa_eremua ('BUSCADOR_NOIMG', 'vinilo_be', 0);  

      $this->data['curfab']=$fab;
      $this->data['curcol']=$col;
      $this->data['curpage']=$page;
      $this->data['curtodos']=$todos;
      $this->data['curorder']=$order;
      $this->data['curgama']=$gama;
      $this->data['curestilo']=$estilo;
      $this->data['curcateg']=$categ;
      $this->data['curprecio']=$precio;
      $this->data['curreferencia']=$referencia;
      
      //$cur_cat_seo=0;
      //if(isset($_POST['categoria_seo']))$cur_cat_seo=$_POST['categoria_seo'];
      $this->data['cur_cat_seo']=$cur_cat_seo;
      //$publico_be=0;
      //if(isset($_POST['publico_be']))$publico_be=$_POST['publico_be'];
      $this->data['publico_be']=$publico_be;
      //$vinilo_be=0;
      //if(isset($_POST['vinilo_be']))$vinilo_be=$_POST['vinilo_be'];
      $this->data['vinilo_be']=$vinilo_be;

      $this->load->model('demo_cart_admin_model');
      $this->data['fab']=$this->demo_cart_admin_model->get_cat_array();
      $this->data['col']=$this->demo_cart_admin_model->get_col_array($fab);
      $this->data['mod']=$this->demo_cart_admin_model->get_mod_array();
      $this->data['gama']=$this->demo_cart_admin_model->get_gama_array();
      $this->data['estilo']=$this->demo_cart_admin_model->get_estilo_array();
      $this->data['count']=$this->demo_cart_admin_model->get_items_count($fab,$col,$todos,$gama,$estilo,$categ,$precio,$referencia);
      $this->data['all']=$this->demo_cart_admin_model->get_items_filter($fab,$col,$page,$todos,$order,$gama,$estilo,$categ,$precio,$referencia);
      //echo "<br />". $this->db->last_query();
      $this->data['nuevas_categorias']=$this->demo_cart_admin_model->get_categorias_seo_array_para_edicion();
	
      $a_familias[]=6;
      $this->data['usar_alt_lista']=$this->demo_cart_admin_model->get_categorias_seo_array_para_edicion($a_familias);
      /*
      print '<pre><xmp>';
    	print_r($this->data['usar_alt_lista']);
    	print '</xmp></pre>';
    	exit;
      */

      $this->load->view('demo/admin_examples/articulos/artnoimg', $this->data);
    
    }

    function editar_articulo($id=0){
      $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
      $this->output->set_header('Pragma: no-cache');
      $this->load->model('demo_cart_admin_model');

      $datos_item_aux=$this->demo_cart_admin_model->get_full_item_data_new($id);
      $datos_item=$datos_item_aux[0];
      
      if (isset($_GET['array'])){
        print '<pre><xmp>';
        print_r($datos_item);
        print '</xmp></pre>';
        exit;
      }
      /*
      */
      $this->data=$datos_item;
      
      $this->data['fab']=$this->demo_cart_admin_model->get_cat_array();
      //$this->data['col']=$this->demo_cart_admin_model->get_col_array();
      $this->data['col']=$this->demo_cart_admin_model->get_col_array($datos_item['item_cat_fk']);
      //$this->data['mod']=$this->demo_cart_admin_model->get_mod_array();
      $this->data['mod']=$this->demo_cart_admin_model->get_mod_array($datos_item['item_coleccion_id']);
      $this->data['gama']=$this->demo_cart_admin_model->get_gama_array();
      $this->data['estilo']=$this->demo_cart_admin_model->get_estilo_array();
      //$this->data['count']=$this->demo_cart_admin_model->get_items_count($fab,$col,$todos,$precio,$referencia);
      //$this->data['all']=$this->demo_cart_admin_model->get_items_filter($fab,$col,$page,$todos,$order,$gama,$estilo,$categ,$precio,$referencia);
      //echo "<br />". $this->db->last_query();
      $this->data['nuevas_categorias']=$this->demo_cart_admin_model->get_categorias_seo_array_para_edicion();
  
      $a_familias[]=6;
      $this->data['a_usar_alt_lista']=$this->demo_cart_admin_model->get_categorias_seo_array_para_edicion($a_familias);

      
      $this->data['variantes']=$this->demo_cart_admin_model->con_variantes($datos_item['item_cat_fk'], $datos_item['item_coleccion_id']);
      $this->data['relacionados']=$this->demo_cart_admin_model->con_relacionados($datos_item['item_cat_fk'], $datos_item['item_coleccion_id']);

      /*
      print '<pre><xmp>';
      print_r($this->data['opciones_variantes']);
      print '</xmp></pre>';
      print '<pre><xmp>';
      print_r($this->data['opciones_relacionados']);
      print '</xmp></pre>';
      exit;

      //$this->data['estilos']=$this->demo_cart_admin_model->get_estilos("DESC");
      if ($id==0){
        $this->data['categoria']=$this->objeto_vacio('nueva_categoria');
      }
      else{
        $nueva_categoria=$this->demo_cart_admin_model->get_categoria_seo($id);
        $this->data['categoria']=$nueva_categoria[0];
      }
      */
      $this->load->view('demo/admin_examples/articulos/articulo_editar', $this->data);
    }

    function paypal(){
      $this->load->model('contenido_model');
      if(isset($_POST['usr']))$this->contenido_model->set_paypal();
      $this->data['pago']=$this->contenido_model->get_paypal();
      
      $this->load->view('demo/admin_examples/paypal', $this->data);
    }
    function add_art(){
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_insert_item();
	  //$this->db->cache_delete_all();
      echo json_encode($return);
    }
  function update_art(){
    $this->load->model('demo_cart_admin_model');
    $this->ret['val'] = $this->demo_cart_admin_model->demo_update_item();
    //$this->db->cache_delete_all();
    $this->load->view('demo/admin_examples/articulos/noimgitem', $this->ret);
    //echo json_encode($return);
  }
  function update_art_test(){
    $this->load->model('demo_cart_admin_model');
    $this->demo_cart_admin_model->demo_update_item();
    redirect('admin_library/editar_articulo/'.(int)$_POST['item_id'].'?saved=1&_='.time());

  }
	function update_art_masivo(){
		$this->load->model('demo_cart_admin_model');
		$this->ret['val'] = $this->demo_cart_admin_model->demo_update_item_masivo();
		//~ print '<pre><xmp>';
		//~ print_r($_POST);
		//~ print '</xmp></pre>';
		//~ exit;
		//$this->db->cache_delete_all();
		//~ $this->load->view('demo/admin_examples/articulos/noimgitem', $this->ret);
		if(isset($_POST['fab']))$fab=$_POST['fab'];
		if(isset($_POST['col']))$col=$_POST['col'];
		if(isset($_POST['gama']))$gama=$_POST['gama'];
		if(isset($_POST['categ']))$categ=$_POST['categ'];
		if(isset($_POST['estilo']))$estilo=$_POST['estilo'];
		$page=0;
		$todos=0;
		if(isset($_POST['order']))$order=$_POST['order'];
		if(isset($_POST['precio']))$precio=$_POST['precio'];
		if(isset($_POST['referencia']))$referencia=$_POST['referencia'];
		
		//~ $this-> noimg($fab,$col,$gama,$estilo,$page,$todos,$order,$categ,$precio, $referencia);
		
		$this->data['all']=$this->demo_cart_admin_model->get_items_filter($fab,$col,$page,$todos,$order,$gama,$estilo,$categ,$precio,$referencia);
		$this->load->view('demo/admin_examples/articulos/cuadro_resultados', $this->data);
		//echo json_encode($return);
	}
    function fabricantes($page=0){
      $this->load->model('demo_cart_admin_model');
      $this->data['count']=$this->demo_cart_admin_model->get_fab_count();
      $this->data['fab']=$this->demo_cart_admin_model->get_categories_20("ASC",$page);
      $this->load->view('demo/admin_examples/articulos/fabricantes', $this->data);
    }
    function fabricantes_seo($page=0){
      $this->load->model('demo_cart_admin_model');
      $this->data['fab']=$this->demo_cart_admin_model->get_categories("ASC",$page);
      $this->load->view('demo/admin_examples/articulos/fabricantes_seo', $this->data);
    }
    function add_fab(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_insert_fab();
      echo json_encode($return);
    }
    function update_fab(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_update_fab();
    }
    function update_fab_seo(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_update_fab_seo();

      redirect('admin_library/fabricantes_seo');
    }
    function editar_fabricante_seo($id=0){
      $this->load->model('demo_cart_admin_model');
      $datos = $this->demo_cart_admin_model->get_categories_seo((int)$id);
      $this->data['categoria'] = $datos['principal'];
      if (isset($datos['ekam'])){
        $this->data['categoria_ekam'] = $datos['ekam'];
      } else {
        $ekam = new stdClass();
        $ekam->cat_id = 0;
        $ekam->cat_text = '';
        $ekam->meta_titlef = '';
        $ekam->meta_descriptionf = '';
        $ekam->meta_keywordsf = '';
        $this->data['categoria_ekam'] = $ekam;
      }
      $this->data['volver_ekam'] = 0;
      $this->load->view('demo/admin_examples/articulos/fabricantes_editar', $this->data);
    }
    function update_fabricante_seo(){
      $this->load->model('demo_cart_admin_model');
      $this->demo_cart_admin_model->demo_save_fabricante_seo();
      redirect('admin_library/fabricantes_seo#registro_'.$this->input->post('cat_id'));
    }
    function publica_fab(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      echo $this->demo_cart_admin_model->demo_publicar_fab($this->input->post('activar'));
    }
    function publica_col(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      
      echo $this->demo_cart_admin_model->demo_publicar_col($this->input->post('activar'));
    }
    function publica_item(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      //echo $this->demo_cart_admin_model->demo_publicar_item($this->input->post('activar'));
      echo $this->demo_cart_admin_model->demo_publicar_item_new($this->input->post('activar'), $this->input->post('i'));
    }
    function publica_item_new($publico=0, $id=0){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      //echo $this->demo_cart_admin_model->demo_publicar_item_new($this->input->post('activar'));
      echo $this->demo_cart_admin_model->demo_publicar_item_new($publico, $id);
    }
    /*
    */
    function update_col(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_update_col();
    }
    function update_col_seo(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_update_col_seo();

      redirect('admin_library/colecciones_seo');
    }
    function publicar_texto_coleccion($id, $estado_anterior){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      if ($estado_anterior==0)
        $this->demo_cart_admin_model->demo_publicar_texto_coleccion($id, 1);
      else
        $this->demo_cart_admin_model->demo_publicar_texto_coleccion($id, 0);
      redirect('admin_library/colecciones_seo#registro_'.$id);
    }
    function del_fab(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $this->demo_cart_admin_model->demo_del_fab();
    }
    function colecciones($page=0){
      $this->load->model('demo_cart_admin_model');
      if(isset($_POST['fab']))$fab=$_POST['fab'];else $fab=0;
      $this->data['count']=$this->demo_cart_admin_model->get_col_count($fab);
      
      $this->data['fab']=$this->demo_cart_admin_model->get_cat_array("ASC");
      $this->data['col']=$this->demo_cart_admin_model->get_colecciones(0,"ASC",$page);
      $this->load->view('demo/admin_examples/articulos/colecciones', $this->data);
    }
    function colecciones_seo($page=0){
      $this->load->model('demo_cart_admin_model');
      $this->data['col']=$this->demo_cart_admin_model->get_colecciones(0,"ASC",$page);
      $this->load->view('demo/admin_examples/articulos/colecciones_seo', $this->data);
    }
    function add_col(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_insert_col();
      echo json_encode($return);
    }
    function del_col(){
    	//$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $this->demo_cart_admin_model->demo_del_col();
    }
    function get_col_select(){
       $this->load->model('demo_cart_admin_model');
      $arr = $this->demo_cart_admin_model->get_col_array($this->input->post('fab'),"ASC");
      $res="<option></option>";
      foreach ($arr as $key => $value) {
        $res.='<option value="'.$key.'">'.$value.'</option>';
      }
      echo $res;
    }
    function categorias_seo($page=0){
      $this->load->model('demo_cart_admin_model');
      $this->data['categorias']=$this->demo_cart_admin_model->get_categorias_seo(-1,"ASC",$page);
      $this->data['filtros_categoria']=$this->demo_cart_admin_model->get_filtros_categoria_array();

      $this->load->view('demo/admin_examples/articulos/categorias_seo', $this->data);
    }
    function editar_categoria_seo($id=0){
      $this->load->model('demo_cart_admin_model');
      //$this->data['estilos']=$this->demo_cart_admin_model->get_estilos("DESC");
      if ($id==0){
        $this->data['categoria']=$this->objeto_vacio('nueva_categoria');
      }
      else{
        $nueva_categoria=$this->demo_cart_admin_model->get_categoria_seo($id);
        $this->data['categoria']=$nueva_categoria[0];
      }
      $this->data['filtros_categoria']=$this->demo_cart_admin_model->get_filtros_categoria_array();
      $this->load->view('demo/admin_examples/articulos/categorias_editar', $this->data);
    }
    function update_categoria_seo(){
      //$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_save_categoria_seo();
      //echo json_encode($return);
      redirect('admin_library/categorias_seo');
    }
    function composicion_telas(){
      $composiciones=$this->db->select("item_id, composicion",FALSE)
        ->from('demo_items')
        ->where('item_tipo',3)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        ->get()->result();
      
      $a_composiciones=array();
      foreach ($composiciones as $dato) {
        //if (trim($dato->composicion)!='' && !isset($a_composiciones[text2url($dato->composicion)]))
        //  echo "<br />".text2url($dato->composicion);
        $a_composiciones[text2url($dato->composicion)][]=$dato->item_id;
        //$a_composiciones[$dato->composicion][1]=text2url($dato->composicion);
        //$a_composiciones[$dato->composicion][2]=text2url_clean($dato->composicion);
      }
      foreach ($a_composiciones as $texto =>$a_ids){
        $a_zatiak=explode('-', $texto);

        foreach ($a_zatiak as $txt_aux){
          if (!is_numeric($txt_aux)){
            $a_composiciones_2[$txt_aux][]=implode(',',$a_ids);
          }
        }
        //$a_composiciones[$dato->composicion][1]=text2url($dato->composicion);
        //$a_composiciones[$dato->composicion][2]=text2url_clean($dato->composicion);
      }
      ksort($a_composiciones_2);
      print '<pre><xmp>';
      print_r($a_composiciones_2);
      print '</xmp></pre>';
      
      $cat_composiciones['acrilica']=139;
      $cat_composiciones['acrylic']=139;
      $cat_composiciones['algodon']=132;
      $cat_composiciones['co']=132;
      $cat_composiciones['cotton']=132;
      $cat_composiciones['lana']=135;
      $cat_composiciones['lansa']=135;
      $cat_composiciones['li']=133;
      $cat_composiciones['limo']=133;
      $cat_composiciones['lino']=133;
      $cat_composiciones['nylon']=136;
      $cat_composiciones['poliester']=137;
      $cat_composiciones['polyester']=137;
      $cat_composiciones['rayon']=138;
      $cat_composiciones['vi']=138;
      $cat_composiciones['viscosa']=138;
      $cat_composiciones['se']=134;
      $cat_composiciones['seda']=134;
      $cat_composiciones['seta']=134;

      foreach($cat_composiciones as $texto_composicion=>$idcategoria_seo){
        echo "<br /><br />composicion: $texto_composicion";
        echo "<br />idcategoria_seo: $idcategoria_seo";

        $items_nueva_categoria=$this->db->select("*",FALSE)
          ->from('nueva_categoria_item')
          ->where('nueva_categoria_id',$idcategoria_seo)
          ->get()->result();
        
        $ids_existentes=array();
        foreach ($items_nueva_categoria as $relacion) {
          $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
        }

        if (isset($a_composiciones_2[$texto_composicion])){
          $kont=0;
          foreach ($a_composiciones_2[$texto_composicion] as $lista_ids) {
            //echo "<br />$lista_ids";
            $a_ids=explode(',', $lista_ids);
            foreach($a_ids as $id_item){
              if (!isset($ids_existentes[$id_item])){
                $datos_insert=array(
                  'nuevacategoria_item_id'=>$id_item,
                  'nueva_categoria_id'=>$idcategoria_seo
                );
                $this->db->insert('nueva_categoria_item',$datos_insert);

                $ids_existentes[$id_item]=$id_item;
                $kont++;
              }
            }
          }
        }
        echo "<br />$kont items asociados";
        //exit;
      }
      exit;
      foreach ($a_composiciones_2 as $texto){
        echo "<br />".$texto;
      }

      /*

      $items_viejo_estilo=$this->db->select("*",FALSE)
        ->from('demo_items')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        ->where('item_cat_fk',$idmarca)
        ->get()->result();
      
      $items_nueva_categoria=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where('nueva_categoria_id',$idcategoria_seo)
        ->get()->result();
      
      $ids_existentes=array();
      foreach ($items_nueva_categoria as $relacion) {
        $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
      }
      $kont=0;
      foreach ($items_viejo_estilo as $item) {
        if (!isset($ids_existentes[$item->item_id])){
          //if ($item->item_coleccion_id!=1205){
            $datos_insert=array(
              'nuevacategoria_item_id'=>$item->item_id,
              'nueva_categoria_id'=>$idcategoria_seo
            );
            $this->db->insert('nueva_categoria_item',$datos_insert);
            $kont++;
          //}
        }
      }
      echo "<br />$kont items asociados";
      */
    }

    function asignar_familia_categoria_seo($item_tipo, $idcategoria_seo){
      echo "<br />Tipo producto: ".$item_tipo;
      echo "<br />Nueva categoria: ".$idcategoria_seo;
      
      $items_viejo_estilo=$this->db->select("*",FALSE)
        ->from('demo_items')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        //->where('demo_items.item_vinilo',1) // para coger solo vinilos
        ->get()->result();
      
      $items_nueva_categoria=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where('nueva_categoria_id',$idcategoria_seo)
        ->get()->result();
      
      $ids_existentes=array();
      foreach ($items_nueva_categoria as $relacion) {
        $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
      }
      $kont=0;
      foreach ($items_viejo_estilo as $item) {
        if (!isset($ids_existentes[$item->item_id])){
          $datos_insert=array(
            'nuevacategoria_item_id'=>$item->item_id,
            'nueva_categoria_id'=>$idcategoria_seo
          );
          $this->db->insert('nueva_categoria_item',$datos_insert);
          $kont++;
        }
      }
      echo "<br />$kont items asociados";

    }

    function asignar_marca_categoria_seo($item_tipo, $idmarca, $idcategoria_seo){
      echo "<br />Tipo producto: ".$item_tipo;
      echo "<br />idmarca: ".$idmarca;
      echo "<br />Nueva categoria: ".$idcategoria_seo;
      
      $items_viejo_estilo=$this->db->select("*",FALSE)
        ->from('demo_items')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        ->where('item_cat_fk',$idmarca)
        ->get()->result();
      
      $items_nueva_categoria=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where('nueva_categoria_id',$idcategoria_seo)
        ->get()->result();
      
      $ids_existentes=array();
      foreach ($items_nueva_categoria as $relacion) {
        $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
      }
      $kont=0;
      foreach ($items_viejo_estilo as $item) {
        if (!isset($ids_existentes[$item->item_id])){
          //if ($item->item_coleccion_id!=1205){
            $datos_insert=array(
              'nuevacategoria_item_id'=>$item->item_id,
              'nueva_categoria_id'=>$idcategoria_seo
            );
            $this->db->insert('nueva_categoria_item',$datos_insert);
            $kont++;
          //}
        }
      }
      echo "<br />$kont items asociados";

    }

    function asignar_coleccion_categoria_seo($item_tipo, $idcoleccion, $idcategoria_seo){
      echo "<br />Tipo producto: ".$item_tipo;
      echo "<br />idcoleccion: ".$idcoleccion;
      echo "<br />Nueva categoria: ".$idcategoria_seo;
      
      $items_viejo_estilo=$this->db->select("*",FALSE)
        ->from('demo_items')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        //->where('demo_items.item_vinilo',1) // para coger solo vinilos
        ->where('item_coleccion_id',$idcoleccion)
        ->get()->result();
      
      $items_nueva_categoria=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where('nueva_categoria_id',$idcategoria_seo)
        ->get()->result();
      
      $ids_existentes=array();
      foreach ($items_nueva_categoria as $relacion) {
        $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
      }
      $kont=0;
      foreach ($items_viejo_estilo as $item) {
        if (!isset($ids_existentes[$item->item_id])){
          $datos_insert=array(
            'nuevacategoria_item_id'=>$item->item_id,
            'nueva_categoria_id'=>$idcategoria_seo
          );
          $this->db->insert('nueva_categoria_item',$datos_insert);
          $kont++;
        }
      }
      echo "<br />$kont items asociados";

    }
    
    function asignar_coleccion_estilo_viejo($idcoleccion, $idestilo_viejo){
      echo "<br />idcoleccion: ".$idcoleccion;
      echo "<br />Estilo: ".$idestilo_viejo;
      
      $items_viejo_estilo=$this->db->select("*",FALSE)
        ->from('demo_items')
        //->where('demo_items.activo',1)
        //->where('demo_items.publico3',1)
        //->where('demo_items.item_vinilo',1) // para coger solo vinilos
        ->where('item_coleccion_id',$idcoleccion)
        ->get()->result();
      
      $kont=0;
      foreach ($items_viejo_estilo as $item) {
        $datos_insert=array(
          'estilo_item_item'=>$item->item_id,
          'estilo_item_estilo'=>$idestilo_viejo
        );
        /*
        print '<pre><xmp>';
        print_r($datos_insert);
        print '</xmp></pre>';
        exit;
        */
        $this->db->insert('demo_estilo_item',$datos_insert);
        $kont++;
      }
      echo "<br />$kont items asociados";

    }

    
    function asignar_categorias_ambiente(){
      $items_viejo_estilo=$this->db->select("item_id, usar_alt_lista",FALSE)
        ->from('demo_items')
        ->where('usar_alt',1)
        ->get()->result();
      /*
      print '<pre><xmp>';
      print_r($items_viejo_estilo);
      print '</xmp></pre>';
      exit;
      */
      $kont=0;
      foreach ($items_viejo_estilo as $item) {
        if (trim($item->usar_alt_lista)!=''){
          // Primero borraremos los registros de ese id
          $this->db->where('iditem',$item->item_id)->delete('demo_item_cat_ambiente');
          
          $a_usar_alt_lista=explode(",",$item->usar_alt_lista);
          
          foreach ($a_usar_alt_lista as $key=>$value){
            $datos_img_cat_ambiente=array(
                'iditem'=>$item->item_id,
                'idcategoria'=>$value
            );
            /*
            print '<pre><xmp>';
            print_r($datos_img_cat_ambiente);
            print '</xmp></pre>';
            exit;
            */
            $this->db->insert('demo_item_cat_ambiente',$datos_img_cat_ambiente);
            $kont++;
          }
        }
      }
      echo "<br />$kont items asociados";

    }
    
    function asignar_coleccion_lista_categorias_seo($item_tipo, $idcoleccion, $lista_categorias_seo){
      echo "<br />Tipo producto: ".$item_tipo;
      echo "<br />idcoleccion: ".$idcoleccion;
      echo "<br />Lista categorias: ".$lista_categorias_seo;
      
      $items_viejo_estilo=$this->db->select("*",FALSE)
        ->from('demo_items')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        //->where('demo_items.item_vinilo',1) // para coger solo vinilos
        ->where('item_coleccion_id',$idcoleccion)
        ->get()->result();
      
      $a_categorias=explode('-', $lista_categorias_seo);

      foreach($a_categorias as $idcategoria_seo){
        $items_nueva_categoria=$this->db->select("*",FALSE)
          ->from('nueva_categoria_item')
          ->where('nueva_categoria_id',$idcategoria_seo)
          ->get()->result();
        
        $ids_existentes=array();
        foreach ($items_nueva_categoria as $relacion) {
          $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
        }
        $kont=0;
        foreach ($items_viejo_estilo as $item) {
          if (!isset($ids_existentes[$item->item_id])){
            $datos_insert=array(
              'nuevacategoria_item_id'=>$item->item_id,
              'nueva_categoria_id'=>$idcategoria_seo
            );
            $this->db->insert('nueva_categoria_item',$datos_insert);
            $kont++;
          }
        }
        echo "<br /><br />Nueva categoria: ".$idcategoria_seo;
        echo "<br />$kont items asociados";
      }
    }
    
    function copiar_categoria_seo($idcategoria_seo_origen, $idcategoria_seo_destino){
      echo "<br />idcategoria_seo_origen: ".$idcategoria_seo_origen;
      echo "<br />Nueva categoria: ".$idcategoria_seo_destino;
      
      $items_categoria_origen=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where('nueva_categoria_id',$idcategoria_seo_origen)
        ->get()->result();
      
      $items_nueva_categoria=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where('nueva_categoria_id',$idcategoria_seo_destino)
        ->get()->result();
      
      $ids_existentes=array();
      foreach ($items_nueva_categoria as $relacion) {
        $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
      }

      $kont=0;
      foreach ($items_categoria_origen as $item) {
        /*
        print '<pre><xmp>';
        print_r($item);
        print '</xmp></pre>';
        */
        if (!isset($ids_existentes[$item->nuevacategoria_item_id])){
          $datos_insert=array(
            'nuevacategoria_item_id'=>$item->nuevacategoria_item_id,
            'nueva_categoria_id'=>$idcategoria_seo_destino
          );
          /*
          print '<pre><xmp>';
          print_r($datos_insert);
          print '</xmp></pre>';
          */
          $this->db->insert('nueva_categoria_item',$datos_insert);
          $kont++;
          //exit;
        }
      }
      echo "<br />$kont items asociados";

    }
    
    function asignar_estilo_categoria_seo($item_tipo, $idestilo, $idcategoria_seo){
      echo "<br />Tipo producto: ".$item_tipo;
      echo "<br />Viejo idestilo: ".$idestilo;
      echo "<br />Nueva categoria: ".$idcategoria_seo;
      
      $items_viejo_estilo=$this->db->select("*",FALSE)
        ->from('demo_items')
        ->join('demo_estilo_item', 'item_id = estilo_item_item')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        ->where('estilo_item_estilo',$idestilo)
        ->get()->result();
      
      $items_nueva_categoria=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where('nueva_categoria_id',$idcategoria_seo)
        ->get()->result();
      
      $ids_existentes=array();
      foreach ($items_nueva_categoria as $relacion) {
        $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
      }
      $kont=0;
      foreach ($items_viejo_estilo as $item) {
        if (!isset($ids_existentes[$item->item_id])){
          $datos_insert=array(
            'nuevacategoria_item_id'=>$item->item_id,
            'nueva_categoria_id'=>$idcategoria_seo
          );
          $this->db->insert('nueva_categoria_item',$datos_insert);
          $kont++;
        }
      }
      echo "<br />$kont items asociados";

    }

    function borrar_estilo_categoria_seo($item_tipo, $idestilo, $idcategoria_seo){
      echo "<br />Tipo producto: ".$item_tipo;
      echo "<br />Viejo idestilo: ".$idestilo;
      echo "<br />Nueva categoria: ".$idcategoria_seo;
      
      $items_viejo_estilo=$this->db->select("*",FALSE)
        ->from('demo_items')
        ->join('demo_estilo_item', 'item_id = estilo_item_item')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        ->where('estilo_item_estilo',$idestilo)
        ->get()->result();
      
      $items_nueva_categoria=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where('nueva_categoria_id',$idcategoria_seo)
        ->get()->result();
      
      $ids_existentes=array();
      foreach ($items_nueva_categoria as $relacion) {
        $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nueva_categoria_item_id;
      }
      /*
      print '<pre><xmp>';
      print_r($ids_existentes);
      print '</xmp></pre>';
      exit;
      */
      $kont=0;
      foreach ($items_viejo_estilo as $item) {
        if (isset($ids_existentes[$item->item_id])){
          $id_a_borrar=$ids_existentes[$item->item_id];
          $this->db->delete('nueva_categoria_item',array('nueva_categoria_item_id'=>$id_a_borrar));
          $kont++;
        }
      }
      echo "<br />$kont items eliminados";

    }

    function modificar_viejos_estilos($idestilo, $nuevos_estilos=''){
      echo "<br />Viejo idestilo: ".$idestilo;
      echo "<br />Nuevos estilos: ".$nuevos_estilos;

      if (trim($nuevos_estilos)!=''){
        $a_nuevos_estilos=explode('-', $nuevos_estilos);
        $a_nuevos_estilos[]=$idestilo;
        
        $items_estilos=$this->db->select("*",FALSE)
          ->from('demo_estilo_item')
          ->where_in('estilo_item_estilo',$a_nuevos_estilos)
          ->get()->result();

        $a_items_a_cambiar=array();
        $a_items=array();
        foreach ($items_estilos as $relacion_estilo) {
          if ($relacion_estilo->estilo_item_estilo==$idestilo){
            $a_items_a_cambiar[$relacion_estilo->estilo_item_item][$relacion_estilo->estilo_item_estilo]=$relacion_estilo->estilo_item_estilo;
          }
          $a_items[$relacion_estilo->estilo_item_item][$relacion_estilo->estilo_item_estilo]=$relacion_estilo->estilo_item_estilo;
        }
        
        foreach ($a_items_a_cambiar as $estilo_item_item => $nada){
          foreach ($a_nuevos_estilos as $id_aux) {
            if ($id_aux!=$idestilo && !isset($a_items[$estilo_item_item][$id_aux])){
              echo "<br />isertar idestilo ".$id_aux;
              $datos_insert=array(
                'estilo_item_item'=>$estilo_item_item,
                'estilo_item_estilo'=>$id_aux
              );
              $this->db->insert('demo_estilo_item',$datos_insert);

            }
          }
        }
      }
    }

    function publicar_coleccion_santos_monteiro($idcoleccion){
      echo "<br />idcoleccion: ".$idcoleccion;
      
      $items_coleccion=$this->db->select("*",FALSE)
        ->from('demo_items')
        ->where('item_cat_fk',268)
        ->where('item_coleccion_id',$idcoleccion)
        ->get()->result();
      /*
      print '<pre><xmp>';
      print_r($items_coleccion);
      print '</xmp></pre>';
      exit;
      */
      $kont=0;
      foreach ($items_coleccion as $item){
        $publico3=0;
        if($item->item_price_aux > 0)
          $publico3=1;
        $itemarray=array(
          'publico3'=>$publico3);
        $item_id=$item->item_id;
        /*
        print '<pre><xmp>';
        print_r($itemarray);
        print '</xmp></pre>';
        exit;
        */
        $this->db->where('item_id',$item_id)->update('demo_items',$itemarray);
        
        /*
        $datos_insert=array(
          'estilo_item_item'=>$item->item_id,
          'estilo_item_estilo'=>$idestilo_viejo
        );
        */
        //$this->db->insert('demo_estilo_item',$datos_insert);
        $kont++;
      }
      echo "<br />$kont items asociados";

    }

    function listado_categorias_colecciones($item_tipo){
      /*
      $items=$this->db->select("item_id, item_cat_fk, item_coleccion_id",FALSE)
        ->from('demo_items')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        ->get()->result();
      */
      $query=$this->db->select("item_id, item_cat_fk, item_coleccion_id",FALSE)
        ->from('demo_items')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        ->get();

      $items=$query->result();

      $a_items=array();
      $a_ids=array();
      foreach ($items as $item) {
        $a_items[$item->item_id]['marca']=$item->item_cat_fk;
        $a_items[$item->item_id]['coleccion']=$item->item_coleccion_id;
        $a_ids[$item->item_id]=$item->item_id;
      }
      $query->free_result(); // The $query result object will no longer be available
      /*
      $items_categorias=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where_in('nuevacategoria_item_id',$a_ids)
        ->get()->result();
      */
      $query=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where_in('nuevacategoria_item_id',$a_ids)
        ->get();
      $items_categorias=$query->result();

      $a_categorias_items=array();
      foreach ($items_categorias as $relacion) {
        $a_categorias_items[$relacion->nuevacategoria_item_id][$relacion->nueva_categoria_id]=$relacion->nueva_categoria_id;
      }
      $query->free_result(); // The $query result object will no longer be available

      $a_categorias_por_coleccion=array();
      $a_colecciones_por_categoria=array();
      foreach ($a_items as $iditem=>$datos) {
        if (isset($a_categorias_items[$iditem])){
          foreach ($a_categorias_items[$iditem] as $idcategoria) {
            if (isset($a_categorias_por_coleccion[$datos['marca']][$datos['coleccion']][$idcategoria]))
              $a_categorias_por_coleccion[$datos['marca']][$datos['coleccion']][$idcategoria]++;
            else
              $a_categorias_por_coleccion[$datos['marca']][$datos['coleccion']][$idcategoria]=1;
          }
        }
      }

      $this->load->model('demo_cart_admin_model');
      $marcas=$this->demo_cart_admin_model->get_cat_array();
      $colecciones=$this->demo_cart_admin_model->get_col_array();
      $categorias_seo=$this->demo_cart_admin_model->get_categorias_seo_array($item_tipo);
      /*
      print '<pre><xmp>';
      print_r($categorias_seo);
      print '</xmp></pre>';
      exit;
      */
      foreach ($a_categorias_por_coleccion as $idmarca=>$a_colecciones){
        echo "<h2 style='margin-bottom:0'>".utf8_decode($marcas[$idmarca])."</h2>";
        foreach ($a_colecciones as $idcoleccion=>$a_categorias) {
          if (isset($colecciones[$idcoleccion]))
            echo "<br /><h3 style='margin:0'> &nbsp; &nbsp; &nbsp; &nbsp; ".utf8_decode($colecciones[$idcoleccion])."</h3>";
          else
            echo "<br /><h3 style='margin:0'> &nbsp; &nbsp; &nbsp; &nbsp; Colecci&oacute;n no existente, id: $idcoleccion </h3>";
          
          foreach ($a_categorias as $idcategoria=>$num_prods) {
            echo "<br /> &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; - ".utf8_decode($categorias_seo[$idcategoria])." ($num_prods)";
          }  
          echo "<br />";
        }
      }
    }

    function listado_colecciones_categorias($item_tipo){
      /*
      $items=$this->db->select("item_id, item_cat_fk, item_coleccion_id",FALSE)
        ->from('demo_items')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        ->get()->result();
      */
      $query=$this->db->select("item_id, item_cat_fk, item_coleccion_id",FALSE)
        ->from('demo_items')
        ->where('item_tipo',$item_tipo)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        ->get();

      $items=$query->result();


      $a_items=array();
      $a_ids=array();
      foreach ($items as $item) {
        $a_items[$item->item_id]['marca']=$item->item_cat_fk;
        $a_items[$item->item_id]['coleccion']=$item->item_coleccion_id;
        $a_ids[$item->item_id]=$item->item_id;
      }
      $query->free_result(); // The $query result object will no longer be available

      /*
      print '<pre><xmp>';
      print_r($query);
      print '</xmp></pre>';
      exit;
      //echo "freeResult";
      //exit;
      $items_categorias=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where_in('nuevacategoria_item_id',$a_ids)
        ->get()->result();
      */
      $query=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where_in('nuevacategoria_item_id',$a_ids)
        ->get();
      $items_categorias=$query->result();

      $a_categorias_items=array();
      $a_items_categoria=array();
      foreach ($items_categorias as $relacion) {
        $a_items_categoria[$relacion->nueva_categoria_id][$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
      }
      $query->free_result(); // The $query result object will no longer be available

      $a_colecciones_por_categoria=array();
      foreach ($a_items_categoria as $id_cat_seo=>$a_items_cat_seo) {
        foreach ($a_items_cat_seo as $iditem) {
          if (isset($a_items[$iditem])){
            $idmarca=$a_items[$iditem]['marca'];
            $idcoleccon=$a_items[$iditem]['coleccion'];

              if (isset($a_colecciones_por_categoria[$id_cat_seo][$idmarca][$idcoleccon]))
                $a_colecciones_por_categoria[$id_cat_seo][$idmarca][$idcoleccon]++;
              else
                $a_colecciones_por_categoria[$id_cat_seo][$idmarca][$idcoleccon]=1;
          }
        }
      }
      /*
      print '<pre><xmp>';
      print_r($a_colecciones_por_categoria);
      print '</xmp></pre>';
      exit;
      */
      $this->load->model('demo_cart_admin_model');
      $marcas=$this->demo_cart_admin_model->get_cat_array();
      $colecciones=$this->demo_cart_admin_model->get_col_array();
      $categorias_seo=$this->demo_cart_admin_model->get_categorias_seo_array(-1);
      /*
      */
      foreach ($a_colecciones_por_categoria as $id_cat_seo=>$a_marcas){
        echo "<h2 style='margin-bottom:0'>".utf8_decode($categorias_seo[$id_cat_seo])."</h2>";
        /*
        if (isset($categorias_seo[$id_cat_seo]))
          echo "<br /><h2 style='margin:0'> &nbsp; &nbsp; &nbsp; &nbsp; ".utf8_decode($categorias_seo[$id_cat_seo])."</h3>";
        else
          echo "<br /><h2 style='margin:0'> &nbsp; &nbsp; &nbsp; &nbsp; Categor&2acute;a no existente, id: $id_cat_seo </h3>";
        */
        foreach ($a_marcas as $idmarca=>$a_colecciones) {
          echo "<br /><h3 style='margin:0'> &nbsp; &nbsp; &nbsp; &nbsp; ".utf8_decode($marcas[$idmarca])."</h3>";
          foreach ($a_colecciones as $idcoleccion=>$num_prods) {
            echo "<br /> &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; - ".utf8_decode($colecciones[$idcoleccion])." ($num_prods)";
          }  
          echo "<br />";
        }
      }
    }

  function get_erregistroak($taula, $eremua, $a_where){
    $result= $this->db->select($eremua)->from($taula)->where($a_where)->get()->result();
    //~ return $result; 
    $a_idak=array();
    foreach($result as $row){
      $a_idak[$row->$eremua]=$row->$eremua;
    }
    return $a_idak;
  }
    
    function asignar_caracteristica_categoria_seo($item_tipo, $campo, $valor, $idcategoria_seo, $lista_estilos=0){
      echo "<br />Tipo producto: ".$item_tipo;
      echo "<br />Nombre campo: ".$campo;
      echo "<br />Valor campo: ".$valor;
      echo "<br />Nueva categoria: ".$idcategoria_seo;
      echo "<br />lista_estilos: ".$lista_estilos;

      $a_kategoriak=$this->get_erregistroak('demo_categories', 'cat_id', array('publico'=>1));
      $a_colecciones=$this->get_erregistroak('demo_coleccion', 'coleccion_id', array('publico2'=>1));

      if ($lista_estilos==0){
        $items_viejo_estilo=$this->db->select("*",FALSE)
          ->from('demo_items')
          ->where('item_tipo',$item_tipo)
          ->where_in('item_cat_fk',$a_kategoriak)
          ->where_in('item_coleccion_id',$a_colecciones)
          ->where('demo_items.activo',1)
          ->where('demo_items.publico3',1)
          ->where($campo,$valor)
          ->get()->result();
      }
      else{
        $a_idestilos=explode('-',$lista_estilos);

        $result=$this->db->select('estilo_item_item')->from('demo_estilo_item')->where_in('estilo_item_estilo',$a_idestilos)->get()->result();
        $ids_cumplen_estilos=array();
        foreach($result as $row){
          $ids_cumplen_estilos[$row->estilo_item_item]=$row->estilo_item_item;
        }
        /*
        */

        /*
        // Para coger los que no pertenezcan a un estilo o lista de estilos concretos
        $result=$this->db->select('estilo_item_item')->from('demo_estilo_item')->where_in('estilo_item_estilo',$a_idestilos)->get()->result();
        $ids_a_ignorar=array();
        foreach($result as $row){
          $ids_a_ignorar[$row->estilo_item_item]=$row->estilo_item_item;
        }
        //echo "<br />num registros: ".count($items_viejo_estilo);
        print '<pre><xmp>';
        print_r($ids_cumplen_estilos);
        print '</xmp></pre>';
        exit;
        */

        //mirar despues para estilos, con la seleccion previa
        $items_viejo_estilo=$this->db->select("*",FALSE)
          ->from('demo_items')
          //->join('demo_estilo_item', 'item_id = estilo_item_item')
          ->where('item_tipo',$item_tipo)
          ->where_in('item_id',$ids_cumplen_estilos)
          //->where_not_in('item_id',$ids_a_ignorar)
          ->where_in('item_cat_fk',$a_kategoriak)
          ->where_in('item_coleccion_id',$a_colecciones)
          ->where('demo_items.activo',1)
          ->where('demo_items.publico3',1)
          ->where($campo,$valor)
          //->where_in('estilo_item_estilo',$a_idestilos)
          //->where_not_in('estilo_item_estilo',$a_idestilos) // salta por memoria
          ->get()->result();
      }

      /*
      echo "<br />num registros: ".count($items_viejo_estilo);
      echo "<br />: ".$this->db->last_query();
      exit;
      print '<pre><xmp>';
      print_r($items_viejo_estilo);
      print '</xmp></pre>';
      exit;
      */
      $items_nueva_categoria=$this->db->select("*",FALSE)
        ->from('nueva_categoria_item')
        ->where('nueva_categoria_id',$idcategoria_seo)
        ->get()->result();
      
      $ids_existentes=array();
      foreach ($items_nueva_categoria as $relacion) {
        $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
      }
      /*
      print '<pre><xmp>';
      print_r($items_viejo_estilo);
      print '</xmp></pre>';
      exit;
      */
      $kont=0;
      foreach ($items_viejo_estilo as $item) {
        if (!isset($ids_existentes[$item->item_id])){
          $datos_insert=array(
            'nuevacategoria_item_id'=>$item->item_id,
            'nueva_categoria_id'=>$idcategoria_seo
          );
          $this->db->insert('nueva_categoria_item',$datos_insert);
          $kont++;
        }
      }
      echo "<br />$kont items asociados";

    }
    
    function asignar_usos_telas_categoria_seo($item_tipo=3){
      //echo "<br />Tipo producto: ".$item_tipo;

      $a_kategoriak=$this->get_erregistroak('demo_categories', 'cat_id', array('publico'=>1));
      $a_colecciones=$this->get_erregistroak('demo_coleccion', 'coleccion_id', array('publico2'=>1));

      $items_telas=$this->db->select("*",FALSE)
        ->from('demo_items')
        ->where('item_tipo',$item_tipo)
        ->where_in('item_cat_fk',$a_kategoriak)
        ->where_in('item_coleccion_id',$a_colecciones)
        ->where('demo_items.activo',1)
        ->where('demo_items.publico3',1)
        ->get()->result();

      echo "<br />Total productos: ".count($items_telas);
      $a_usos=array();
      foreach($items_telas as $row){
        $usos_aux=explode(' ', $row->uso);
        foreach($usos_aux as $iduso)
          $a_usos[$iduso][]=$row->item_id;
      }

      foreach ($a_usos as $iduso=>$articulos){
        switch ($iduso) {
            case 0: $idcategoria_seo = 9;
                break;
            case 1: $idcategoria_seo = 10;
                break;
            case 2: $idcategoria_seo = 128;
                break;
            case 3: $idcategoria_seo = 34;
                break;
            case 4: $idcategoria_seo = 129;
                break;
            case 5: $idcategoria_seo = 124;
                break;
            default: break;
        }
        $items_nueva_categoria=$this->db->select("*",FALSE)
          ->from('nueva_categoria_item')
          ->where('nueva_categoria_id',$idcategoria_seo)
          ->get()->result();
        
        $ids_existentes=array();
        foreach ($items_nueva_categoria as $relacion) {
          $ids_existentes[$relacion->nuevacategoria_item_id]=$relacion->nuevacategoria_item_id;
        }

        $kont=0;
        foreach ($articulos as $item_id) {
          if (!isset($ids_existentes[$item_id])){
            $datos_insert=array(
              'nuevacategoria_item_id'=>$item_id,
              'nueva_categoria_id'=>$idcategoria_seo
            );
            $this->db->insert('nueva_categoria_item',$datos_insert);
            $kont++;
          }
        }
        echo "<br />iduso: $iduso";
        echo "<br />idcategoria_seo: $idcategoria_seo";
        echo "<br />$kont items asociados";

      }
    }

    function listado_articulos_portada($idtipo=0){
      $this->load->model('demo_cart_admin_model');
      $this->data['a_articulos'] = $this->db->select("demo_items.item_id, item_ref, item_cat_fk, item_coleccion_id, item_tipo, img, imgamb, cat_name, coleccion_name, demo_items.orden", FALSE)
        ->from('demo_items')
        ->join('demo_categories', 'item_cat_fk = cat_id')
        ->join('demo_coleccion', 'item_coleccion_id = coleccion_id')
        ->where('portada', 1)
        ->where('item_tipo', (int)$idtipo)
        ->order_by('demo_items.orden ASC')
        ->get()->result_array();
      $this->data['idtipo'] = (int)$idtipo;
      $this->load->view('demo/admin_examples/articulos/listado-portada', $this->data);
    }

    function quitar_portada($idtipo=0, $item_id=0){
      $this->load->model('demo_cart_admin_model');
      $this->demo_cart_admin_model->quita_portada((int)$idtipo, (int)$item_id);
      redirect('admin_library/listado_articulos_portada/'.(int)$idtipo);
    }

    function quitar_todos_portada($idtipo=0){
      $this->load->model('demo_cart_admin_model');
      $this->demo_cart_admin_model->quita_portada((int)$idtipo, 0);
      redirect('admin_library/listado_articulos_portada/'.(int)$idtipo);
    }

    function listado_colecciones_en_meta(){
      $this->data['colecciones'] = $this->db->select("coleccion_id, coleccion_name, cat_name, col_img, col_ambimg", FALSE)
        ->from('demo_coleccion')
        ->join('demo_categories', 'coleccion_cat_id = cat_id')
        ->where('demo_coleccion.xml_META_be', 1)
        ->order_by('cat_name ASC, coleccion_name ASC')
        ->get()->result();
      $this->load->view('demo/admin_examples/articulos/listado-colecciones-meta', $this->data);
    }

    function quitar_meta($idcoleccion=0){
      $this->load->model('demo_cart_admin_model');
      $this->demo_cart_admin_model->quita_meta((int)$idcoleccion);
      redirect('admin_library/listado_colecciones_en_meta');
    }

    function precios_santos_monteiro($opcion='m_cuadrado'){
      $acabados_raw = $this->db->select("idsantos_monteiro_acabado, nombre_acabado, agrupar_en_id", FALSE)
        ->from('santos_monteiro_acabado')
        ->where('activo_be', 1)
        ->order_by('orden ASC')
        ->get()->result();
      $a_acabados = array();
      $a_agrupados = array();
      foreach ($acabados_raw as $a) {
        if ($a->agrupar_en_id == 0) {
          $a_acabados[$a->idsantos_monteiro_acabado] = $a->nombre_acabado;
        } else {
          $a_agrupados[$a->agrupar_en_id][] = $a->idsantos_monteiro_acabado;
        }
      }
      $colecciones_raw = $this->db->select("coleccion_id, coleccion_name", FALSE)
        ->from('demo_coleccion')
        ->where('coleccion_cat_id', 268)
        ->where('activo', 1)
        ->order_by('coleccion_name ASC')
        ->get()->result();
      $a_colecciones = array();
      foreach ($colecciones_raw as $c) {
        $a_colecciones[$c->coleccion_id] = $c->coleccion_name;
      }
      $precios_raw = $this->db->select("*", FALSE)->from('santos_monteiro_acabado_precio')->get()->result();
      $a_precios = array();
      foreach ($precios_raw as $p) {
        $a_precios[$p->idcoleccion][$p->idsantos_monteiro_acabado][$p->idsantos_monteiro_acabado_precio] = (array)$p;
      }
      $this->data['a_acabados'] = $a_acabados;
      $this->data['a_agrupados'] = $a_agrupados;
      $this->data['a_colecciones'] = $a_colecciones;
      $this->data['a_precios'] = $a_precios;
      $this->data['opcion'] = $opcion;
      $this->load->view('demo/admin_examples/articulos/precios_santos_monteiro', $this->data);
    }

    function update_precios_santos_monteiro(){
      $data = $this->input->post(NULL, TRUE);
      $campo = $data['campo_precio'];
      $opcion = isset($data['opcion']) ? $data['opcion'] : 'm_cuadrado';
      if (!in_array($campo, array('precio_m_cuadrado', 'precio_m_cuadrado_exacto'))) {
        redirect('admin_library/precios_santos_monteiro/'.$opcion);
        return;
      }
      if (!empty($data['a_precios'])) {
        foreach ($data['a_precios'] as $idcol => $acabados) {
          foreach ($acabados as $idacabado => $precios) {
            foreach ($precios as $idprecio => $valores) {
              $precio = (float)$valores[$campo];
              if ((int)$idprecio === 0) {
                $this->db->insert('santos_monteiro_acabado_precio', array(
                  'idcoleccion' => (int)$idcol,
                  'idsantos_monteiro_acabado' => (int)$idacabado,
                  $campo => $precio,
                ));
              } else {
                $this->db->where('idsantos_monteiro_acabado_precio', (int)$idprecio)
                  ->update('santos_monteiro_acabado_precio', array($campo => $precio));
              }
            }
          }
        }
      }
      if (!empty($data['a_agrupado'])) {
        foreach ($data['a_agrupado'] as $idacabado_primario => $colecciones) {
          foreach ($colecciones as $idcol => $acabados_aux) {
            foreach ($acabados_aux as $id_acabado_aux => $precios) {
              foreach ($precios as $idprecio => $valores) {
                $precio = (float)$valores[$campo];
                if ((int)$idprecio === 0) {
                  $this->db->insert('santos_monteiro_acabado_precio', array(
                    'idcoleccion' => (int)$idcol,
                    'idsantos_monteiro_acabado' => (int)$id_acabado_aux,
                    $campo => $precio,
                  ));
                } else {
                  $this->db->where('idsantos_monteiro_acabado_precio', (int)$idprecio)
                    ->update('santos_monteiro_acabado_precio', array($campo => $precio));
                }
              }
            }
          }
        }
      }
      redirect('admin_library/precios_santos_monteiro/'.$opcion);
    }

    function tarifas_acabados(){
      $marcas = $this->db->select("DISTINCT(marca_id) as cat_id, cat_name", FALSE)
        ->from('alfombra_acabados_tarifas')
        ->join('demo_categories', 'marca_id = cat_id')
        ->order_by('cat_name ASC')
        ->get()->result();
      $marca_seleccionada = (int)$this->input->get('marca');
      if (!$marca_seleccionada && !empty($marcas)) $marca_seleccionada = $marcas[0]->cat_id;
      $acabados = array();
      if ($marca_seleccionada) {
        $acabados = $this->db->where('marca_id', $marca_seleccionada)
          ->order_by('orden ASC, id ASC')
          ->get('alfombra_acabados_tarifas')->result();
      }
      $this->data['marcas_alfombras'] = $marcas;
      $this->data['marca_seleccionada'] = $marca_seleccionada;
      $this->data['acabados'] = $acabados;
      $this->load->view('demo/admin_examples/articulos/tarifas_acabados', $this->data);
    }

    function update_tarifas_acabados(){
      $data = $this->input->post(NULL, TRUE);
      $marca_id = (int)$data['marca_id'];
      if (!empty($data['eliminar'])) {
        foreach ($data['eliminar'] as $id => $v) {
          $this->db->where('id', (int)$id)->delete('alfombra_acabados_tarifas');
          break;
        }
      } elseif (!empty($data['acabados'])) {
        foreach ($data['acabados'] as $id => $valores) {
          $this->db->where('id', (int)$id)->update('alfombra_acabados_tarifas', array(
            'nombre_acabado' => $valores['nombre_acabado'],
            'precio_m_lineal' => (float)$valores['precio_m_lineal'],
            'precio_m_lineal_largo' => (float)$valores['precio_m_lineal_largo'],
            'precio_m2' => (float)$valores['precio_m2'],
            'opciones' => $valores['opciones'],
            'txt_opciones' => $valores['txt_opciones'],
            'imagen' => $valores['imagen'],
            'orden' => (int)$valores['orden'],
            'activo' => isset($valores['activo']) ? 1 : 0,
          ));
        }
      }
      redirect('admin_library/tarifas_acabados?marca='.$marca_id);
    }

    function add_tarifa_acabado(){
      $data = $this->input->post(NULL, TRUE);
      $this->db->insert('alfombra_acabados_tarifas', array(
        'marca_id' => (int)$data['marca_id'],
        'nombre_acabado' => $data['nombre_acabado'],
        'precio_m_lineal' => (float)$data['precio_m_lineal'],
        'precio_m_lineal_largo' => 0,
        'precio_m2' => (float)$data['precio_m2'],
        'imagen' => $data['imagen'],
        'activo' => 1,
        'orden' => 0,
        'opciones' => '',
        'txt_opciones' => '',
      ));
      redirect('admin_library/tarifas_acabados?marca='.(int)$data['marca_id']);
    }

    function orden_colecciones(){
      $marcas = $this->db->select("cat_id, cat_name, COUNT(coleccion_id) as total_colecciones", FALSE)
        ->from('demo_categories')
        ->join('demo_coleccion', 'coleccion_cat_id = cat_id')
        ->where('demo_coleccion.activo', 1)
        ->group_by('cat_id')
        ->order_by('cat_name ASC')
        ->get()->result();
      $marca_seleccionada = (int)$this->input->get('marca');
      if (!$marca_seleccionada && !empty($marcas)) $marca_seleccionada = $marcas[0]->cat_id;
      $colecciones = array();
      $nombre_marca = '';
      if ($marca_seleccionada) {
        $colecciones = $this->db->select("coleccion_id, coleccion_name, col_img, COUNT(demo_items.item_id) as total_items", FALSE)
          ->from('demo_coleccion')
          ->join('demo_items', 'item_coleccion_id = coleccion_id AND demo_items.activo = 1', 'left')
          ->where('coleccion_cat_id', $marca_seleccionada)
          ->where('demo_coleccion.activo', 1)
          ->group_by('coleccion_id')
          ->order_by('demo_coleccion.orden ASC, coleccion_name ASC')
          ->get()->result();
        $cat = $this->db->where('cat_id', $marca_seleccionada)->get('demo_categories')->row();
        if ($cat) $nombre_marca = $cat->cat_name;
      }
      if ($this->input->get('saved')) $this->data['mensaje'] = 'Orden guardado correctamente.';
      $this->data['marcas'] = $marcas;
      $this->data['colecciones'] = $colecciones;
      $this->data['marca_seleccionada'] = $marca_seleccionada;
      $this->data['nombre_marca'] = $nombre_marca;
      $this->load->view('demo/admin_examples/articulos/orden_colecciones', $this->data);
    }

    function update_orden_colecciones(){
      $data = $this->input->post(NULL, TRUE);
      $marca_id = (int)$data['marca_id'];
      if (!empty($data['orden'])) {
        foreach ($data['orden'] as $coleccion_id => $orden) {
          $this->db->where('coleccion_id', (int)$coleccion_id)
            ->update('demo_coleccion', array('orden' => (int)$orden));
        }
      }
      redirect('admin_library/orden_colecciones?marca='.$marca_id.'&saved=1');
    }

    function modelos(){
      $this->load->model('demo_cart_admin_model');
      $this->data['fab']=$this->demo_cart_admin_model->get_cat_array("ASC");
      $this->data['col']=$this->demo_cart_admin_model->get_col_array(0,"ASC");
      $this->data['mod']=$this->demo_cart_admin_model->get_modelos(0,"DESC");
      $this->load->view('demo/admin_examples/articulos/modelos', $this->data);
    }
    function add_mod(){
    	//$this->db->cache_delete_all();
       $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_insert_mod();
      echo json_encode($return);
    }
    function del_mod(){
    	//$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $this->demo_cart_admin_model->demo_del_mod();
    }
    function get_mod_select(){
       $this->load->model('demo_cart_admin_model');
      $arr = $this->demo_cart_admin_model->get_mod_array($this->input->post('col'),"ASC");
      $res="<option></option>";
      foreach ($arr as $key => $value) {
        $res.='<option value="'.$key.'">'.$value.'</option>';
      }
      echo $res;
    }

    private function get_tonalidades(){
      $a_tonalidades[0]['nombre_tonalidad']='--';
      $a_tonalidades[0]['img_tonalidad']='';
      $a_tonalidades[1]['nombre_tonalidad']='BLANCO/NEGRO';
      $a_tonalidades[1]['img_tonalidad']='blanco-negro';
      $a_tonalidades[2]['nombre_tonalidad']='CRUDO/MARRÓN';
      $a_tonalidades[2]['img_tonalidad']='crudo-marron';
      $a_tonalidades[3]['nombre_tonalidad']='AMARILLOS';
      $a_tonalidades[3]['img_tonalidad']='amarillos';
      $a_tonalidades[4]['nombre_tonalidad']='AZULES/MORADOS';
      $a_tonalidades[4]['img_tonalidad']='azules-morados';
      $a_tonalidades[5]['nombre_tonalidad']='ROSAS/ROJOS';
      $a_tonalidades[5]['img_tonalidad']='rosas-rojos';
      $a_tonalidades[6]['nombre_tonalidad']='VERDES';
      $a_tonalidades[6]['img_tonalidad']='verdes';
      $a_tonalidades[7]['nombre_tonalidad']='MULTICOLOR';
      $a_tonalidades[7]['img_tonalidad']='multicolor';
      $a_tonalidades[8]['nombre_tonalidad']='METALIZADOS';
      $a_tonalidades[8]['img_tonalidad']='metalizados';

      return $a_tonalidades;
    }

    function colores(){
      $this->load->model('demo_cart_admin_model');
      $this->data['colores']=$this->demo_cart_admin_model->get_gamas("DESC");
      $this->data['a_tonalidades']=$this->get_tonalidades();
      $this->load->view('demo/admin_examples/articulos/colores', $this->data);
    }
    function add_color(){
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_insert_gama();
      echo json_encode($return);
    }
    function update_color(){
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_update_gama();
    }
    function del(){
    	//$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $this->demo_cart_admin_model->demo_del("demo_".$this->input->post('t'),$this->input->post('n')."_id",$this->input->post('i'));
    }
    function estilos(){
      $this->load->model('demo_cart_admin_model');
      //$this->data['estilos']=$this->demo_cart_admin_model->get_estilos("DESC");
      $this->data['estilos']=$this->demo_cart_admin_model->get_estilos("ASC");
      $this->load->view('demo/admin_examples/articulos/estilos', $this->data);
    }
    function editar_estilo($id){
      $this->load->model('demo_cart_admin_model');
      //$this->data['estilos']=$this->demo_cart_admin_model->get_estilos("DESC");
      $estilos=$this->demo_cart_admin_model->get_estilo($id);
      $this->data['estilo']=$estilos[0];
      $this->load->view('demo/admin_examples/articulos/estilos_editar', $this->data);
    }
    function add_estilo(){
    	//$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_insert_estilo();
      //echo json_encode($return);
      redirect('admin_library/estilos');
    }
    function update_estilo(){
    	//$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_update_estilo();
      $data=$this->input->post(NULL, TRUE);
      
      redirect('admin_library/estilos#registro_'.$data['estilo']);
    }
    function herramientas(){
      $this->load->model('demo_cart_admin_model');
      $this->data['her']=$this->demo_cart_admin_model->get_hers("ASC");
      $this->load->view('demo/admin_examples/articulos/herramientas', $this->data);
    }
    function add_her(){
    	////$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_insert_her();
      echo json_encode($return);
    }
    function update_her(){
    	////$this->db->cache_delete_all();
      $this->load->model('demo_cart_admin_model');
      $return = $this->demo_cart_admin_model->demo_update_her();
    }
    
    function get_item(){
      $this->load->model('demo_cart_admin_model');
      //$datos_item=$this->demo_cart_admin_model->get_full_item_data($this->input->post('i'));
      $datos_item=$this->demo_cart_admin_model->get_full_item_data_new($this->input->post('i'));
      /*
      if (!isset($datos_item[0]['nuevacategoriaid']) || trim($datos_item[0]['nuevacategoriaid'])=='') 
        $datos_item[0]['nuevacategoriaid']=0;
      */
      echo json_encode($datos_item);
      //echo json_encode($this->demo_cart_admin_model->get_full_item_data($this->input->post('i')));
    }
    public function get_item_new($id){
      $this->load->model('demo_cart_admin_model');
      
      $original=$this->demo_cart_admin_model->get_full_item_data($id);
      print '<pre><xmp>';
      print_r($original);
      print '</xmp></pre>';
      echo "<br />".$this->db->last_query();

      $nuevo=$this->demo_cart_admin_model->get_full_item_data_new($id);
      if (!isset($nuevo[0]['nuevacategoriaid']) || trim($nuevo[0]['nuevacategoriaid'])=='') 
        $nuevo[0]['nuevacategoriaid']=0;
      print '<pre><xmp>';
      print_r($nuevo);
      print '</xmp></pre>';
      echo "<br />".$this->db->last_query();
    }
	function items()
	{
		$this->load->model('demo_cart_admin_model');
		
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_items'))
		{
			$this->demo_cart_admin_model->demo_update_item_stock();
			////$this->db->cache_delete_all();
		}

		// Get an array of all demo items from a custom demo model function.
		$this->data['item_data'] = $this->demo_cart_admin_model->demo_get_item_data();
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');	

		$this->load->view('demo/admin_examples/items/items_view', $this->data);
	}	
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// ORDER MANAGEMENT
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * orders
	 * View and manage customer orders that have been saved by flexi cart
	 */ 
	function orders($filter="") 
	{
		// Get an array of all saved orders. 
		// Using a flexi cart SQL function, set the order the order data so that dates are listed newest to oldest.
		$this->flexi_cart_admin->sql_order_by($this->flexi_cart_admin->db_column('order_summary', 'date'), 'desc');
		if($filter==1||$filter==2||$filter==3||$filter==4||$filter==5)
			$this->flexi_cart_admin->sql_where('ord_status',$filter);
		else{
			$desde=(date('Y')-1).'-01-01';
			$this->flexi_cart_admin->create_sql_where('ord_date','>=',$desde);
		}
		$this->data['order_data'] = $this->flexi_cart_admin->get_db_order_array();
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('demo/admin_examples/orders/orders_view', $this->data);
	}
	function informe_ventas($filter="") 
	{
		$desde='2012-01-01';
		$this->flexi_cart_admin->create_sql_where('ord_date','>=',$desde);
		$pedidos = $this->flexi_cart_admin->get_db_order_array();
		$datos = array();
    $guztira = array();
    $datos_dia = array();
		foreach ($pedidos as $pedido){
			if ($pedido['ord_status']!=5 && $pedido['ord_status']!=1 ){
				$data_aux=substr($pedido['ord_date'], 0, 10);
        $urtea_aux=substr($pedido['ord_date'], 0, 4);
				$hilabetea_aux=substr($pedido['ord_date'], 5, 2);
				if (isset($datos[$urtea_aux][$hilabetea_aux])){
					$datos[$urtea_aux][$hilabetea_aux]['num']++;
					$datos[$urtea_aux][$hilabetea_aux]['importe']+=$pedido['ord_total'];
				}
				else{
					$datos[$urtea_aux][$hilabetea_aux]['num']=1;
					$datos[$urtea_aux][$hilabetea_aux]['importe']=$pedido['ord_total'];
				}

        if (isset($guztira[$urtea_aux])){
          $guztira[$urtea_aux]['num']++;
          $guztira[$urtea_aux]['importe']+=$pedido['ord_total'];
          if ((int)$hilabetea_aux <= (int)date('m')){
            $guztira[$urtea_aux]['num_actual']++;
            $guztira[$urtea_aux]['importe_actual']+=$pedido['ord_total'];
          }
        }
        else{
          $guztira[$urtea_aux]['num']=1;
          $guztira[$urtea_aux]['importe']=$pedido['ord_total'];
          $guztira[$urtea_aux]['num_actual']=1;
          $guztira[$urtea_aux]['importe_actual']=$pedido['ord_total'];
        }


        if ($urtea_aux>=2023){
          if (isset($datos_dia[$data_aux])){
            $datos_dia[$data_aux]['num']++;
            $datos_dia[$data_aux]['importe']+=$pedido['ord_total'];
          }
          else{
            $datos_dia[$data_aux]['num']=1;
            $datos_dia[$data_aux]['importe']=$pedido['ord_total'];
          }
        }
			}
		}
		echo "<h1>Pedidos Pagados (sin contar cancelados ni pendientes)</h1>";
		echo "<table style='font-size:0.9em;'>";
		echo "	<tr>";
		echo "		<td></td>";
		echo "		<td colspan='2' style='text-align:center;'>Enero</td>";
		echo "		<td colspan='2' style='text-align:center;'>Febrero</td>";
		echo "		<td colspan='2' style='text-align:center;'>Marzo</td>";
		echo "		<td colspan='2' style='text-align:center;'>Abril</td>";
		echo "		<td colspan='2' style='text-align:center;'>Mayo</td>";
		echo "		<td colspan='2' style='text-align:center;'>Junio</td>";
		echo "		<td colspan='2' style='text-align:center;'>Julio</td>";
		echo "		<td colspan='2' style='text-align:center;'>Agosto</td>";
		echo "		<td colspan='2' style='text-align:center;'>Septiembre</td>";
		echo "		<td colspan='2' style='text-align:center;'>Octubre</td>";
		echo "		<td colspan='2' style='text-align:center;'>Noviembre</td>";
    echo "    <td colspan='2' style='text-align:center;'>Diciembre</td>";
		echo "	</tr>";
		echo "	<tr>";
		echo "		<td></td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
    echo "    <td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "	</tr>";
		foreach ($datos as $urtea =>$urteko_datuak){
			echo "<tr>";
			echo "		<td style='text-align:left;padding-right:15px;'>$urtea</td>";
			foreach ($urteko_datuak as $hilabetea =>$hilabeteko_datuak){
				echo "		<td style='text-align:right;padding-right:5px;'>{$hilabeteko_datuak['num']}</td>";
				echo "		<td style='text-align:right;padding-right:15px;'>".number_format($hilabeteko_datuak['importe'], 2, ',', '.')."</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
		
    echo "<h1>Totales</h1>";
    echo "<table style='font-size:0.9em;'>";
    echo "  <tr>";
    echo "    <td></td>";
    echo "    <td colspan='2' style='text-align:center;'>Acum. mes actual</td>";
    echo "    <td colspan='2' style='text-align:center;'>Total A&ntilde;o</td>";
    echo "  </tr>";
    echo "  <tr>";
    echo "    <td></td>";
    echo "    <td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
    echo "    <td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
    echo "  </tr>";
    foreach ($guztira as $urtea =>$urteko_datuak){
      echo "<tr>";
      echo "    <td style='text-align:left;padding-right:15px;'>$urtea</td>";
      echo "    <td style='text-align:right;padding-right:5px;'>{$urteko_datuak['num_actual']}</td>";
      echo "    <td style='text-align:right;padding-right:15px;'>".number_format($urteko_datuak['importe_actual'], 2, ',', '.')."</td>";
      echo "    <td style='text-align:right;padding-right:5px;'>{$urteko_datuak['num']}</td>";
      echo "    <td style='text-align:right;padding-right:15px;'>".number_format($urteko_datuak['importe'], 2, ',', '.')."</td>";
      echo "</tr>";
    }
    echo "</table>";
    
		$datos = array();
		foreach ($pedidos as $pedido){
			$urtea_aux=substr($pedido['ord_date'], 0, 4);
			$hilabetea_aux=substr($pedido['ord_date'], 5, 2);
			if (isset($datos[$urtea_aux][$hilabetea_aux])){
				$datos[$urtea_aux][$hilabetea_aux]['num']++;
				$datos[$urtea_aux][$hilabetea_aux]['importe']+=$pedido['ord_total'];
			}
			else{
				$datos[$urtea_aux][$hilabetea_aux]['num']=1;
				$datos[$urtea_aux][$hilabetea_aux]['importe']=$pedido['ord_total'];
			}
		}
		
		echo "<h1>Pedidos totales (contando cancelados y pendientes de pago)</h1>";
    echo "<table style='font-size:0.9em;'>";
		echo "	<tr>";
		echo "		<td></td>";
		echo "		<td colspan='2' style='text-align:center;'>Enero</td>";
		echo "		<td colspan='2' style='text-align:center;'>Febrero</td>";
		echo "		<td colspan='2' style='text-align:center;'>Marzo</td>";
		echo "		<td colspan='2' style='text-align:center;'>Abril</td>";
		echo "		<td colspan='2' style='text-align:center;'>Mayo</td>";
		echo "		<td colspan='2' style='text-align:center;'>Junio</td>";
		echo "		<td colspan='2' style='text-align:center;'>Julio</td>";
		echo "		<td colspan='2' style='text-align:center;'>Agosto</td>";
		echo "		<td colspan='2' style='text-align:center;'>Septiembre</td>";
		echo "		<td colspan='2' style='text-align:center;'>Octubre</td>";
		echo "		<td colspan='2' style='text-align:center;'>Noviembre</td>";
		echo "		<td colspan='2' style='text-align:center;'>Diciembre</td>";
		echo "	</tr>";
		echo "	<tr>";
		echo "		<td></td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "		<td style='text-align:center;'>Num.</td><td style='text-align:center;'>Importe</td>";
		echo "	</tr>";
		foreach ($datos as $urtea =>$urteko_datuak){
			echo "<tr>";
			echo "		<td style='text-align:left;padding-right:15px;'>$urtea</td>";
			foreach ($urteko_datuak as $hilabetea =>$hilabeteko_datuak){
				echo "		<td style='text-align:right;padding-right:5px;'>{$hilabeteko_datuak['num']}</td>";
				echo "		<td style='text-align:right;padding-right:15px;'>".number_format($hilabeteko_datuak['importe'], 2, ',', '.')."</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
		print '<pre><xmp>';
		print_r($datos_dia);
		print '</xmp></pre>';
		exit;
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * order_details
	 * Displays all data related to a saved order, including the users billing and shipping details, the cart contents and the cart summary.
	 * This demo includes an example of indicating to flexi cart which items have been shipped or cancelled since the order was receieved, flexi cart can then use this data 
	 * to manage item stock and user reward points.
	 */ 
	function order_details($order_number) 
	{
		//~ print '<pre><xmp>';
		//~ print_r($_POST);
		//~ print '</xmp></pre>';
		//~ exit;
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('actualizar_facturacion')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_datos_facturacion($order_number);
			////$this->db->cache_delete_all();
		}
		if ($this->input->post('actualizar_envio')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_datos_envio($order_number);
			////$this->db->cache_delete_all();
		}
		if ($this->input->post('actualizar_linea')){
			echo "<br />actualizar_linea";
			print '<pre><xmp>';
			print_r($_POST);
			print '</xmp></pre>';
			exit;
			//~ $this->load->model('demo_cart_admin_model');
			//~ $this->demo_cart_admin_model->demo_update_datos_envio($order_number);
			////$this->db->cache_delete_all();
		}
		if ($this->input->post('update_order')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_order_details($order_number);
			////$this->db->cache_delete_all();
		}
                if ($this->input->post('factura')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_facturar($order_number);
			////$this->db->cache_delete_all();
		}
                if ($this->input->post('factura_rectificativa')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_facturar_rectificativa($order_number);
			////$this->db->cache_delete_all();
		}
                if ($this->input->post('ticket')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_cerrar_ticket($order_number);
			////$this->db->cache_delete_all();
		}
		//~ echo "<br />seguimos";
		//~ exit;
		
		// Get the row array of the order filtered by the order number in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
		$this->data['summary_data'] = $this->flexi_cart_admin->get_db_order_summary_row_array(FALSE, $sql_where);
		
		// Get an array of all order details related to the above order, filtered by the order number in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $order_number);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_order_detail_array(FALSE, $sql_where);
		
		// Get an array of all order statuses that can be set for an order.
		// The data is then to be displayed via a html select input to allow the user to update the orders status.
		$this->data['status_data'] = $this->flexi_cart_admin->get_db_order_status_array();

		// Get the row array of any refund data that may be available for the order, filtered by the order number in the url.
		$this->data['refund_data'] = $this->flexi_cart_admin->get_refund_summary_row_array($order_number);
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');	
		//~ print '<pre><xmp>';
		//~ print_r($this->data['summary_data']);
		//~ print '</xmp></pre>';
		//~ print '<pre><xmp>';
		//~ print_r($this->data['item_data']);
		//~ print '</xmp></pre>';
		//~ exit;
		
		$this->load->view('demo/admin_examples/orders/order_details_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * update_order_details
	 * Reloads the saved cart data from a saved order into the users current cart session.
	 * Once the saved cart data is reloaded, the user can browse the store adding and updating items to the cart as normal.
	 * When the cart is resaved, the new cart data will update and overwrite the original saved order.
	 * The page includes an example of listing items that can be further added to the cart, and examples of how to apply discounts and surcharges all from within the same page.
	 *
	 * This page is accessed from the 'Order Details' page via the 'Edit Order' link.
	 */ 
	function update_order_details($order_number)
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_order'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_resave_order($order_number);
			////$this->db->cache_delete_all();
		}
		
		// Get the row array of the original order details, filtered by the order number in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('order_summary', 'order_number') => $order_number);
		$this->data['current_order_data'] = $this->flexi_cart_admin->get_db_order_summary_row_array(FALSE, $sql_where);

		// Get the id of the loaded cart data.
		$cart_data_id = $this->data['current_order_data'][$this->flexi_cart_admin->db_column('order_summary', 'cart_data')];

		// To prevent re-reloading the saved cart data (And losing any changes) every time the page is refreshed, check if the current CI session contains 
		// the cart data array matching the saved order data that is to be updated.		
		if ($this->flexi_cart_admin->cart_data_id() != $cart_data_id)
		{
			// Load saved cart data array from the confirmed order.
			// This data is loaded into the browser session as if you were shopping with the cart as a customer.
			$this->flexi_cart_admin->load_cart_data($cart_data_id, TRUE);
		}
		
		// This demo includes a list of items from the demo item table that can be added to the reloaded cart.
		// For simplicity, rather than including all example items that can be found in the demo, only items from the 'demo_items' table are used.
		$this->load->model('demo_cart_model');
		$this->data['item_data'] = $this->demo_cart_model->demo_get_item_data();
		//~ $this->load->model('flexi_cart_model');
		//~ $this->data['item_data'] = $this->flexi_cart_model->demo_get_item_data();

		// Get required data on cart items, summary discounts and cart surcharges for use on the cart.
		// Note: This demo requires the 'get_shipping_options()' function being loaded from the standard flexi cart library.
		$this->load->library('flexi_cart');
		$this->data['update_cart_items'] = $this->flexi_cart_admin->cart_items(FALSE, TRUE, TRUE);
		$this->data['update_shipping_options'] = $this->flexi_cart->get_shipping_options(); 
		$this->data['update_reward_vouchers'] = $this->flexi_cart_admin->reward_voucher_data(TRUE, TRUE);
		$this->data['update_discounts'] = $this->flexi_cart_admin->summary_discount_data(FALSE, TRUE, TRUE);
		$this->data['update_surcharges'] = $this->flexi_cart_admin->surcharge_data(FALSE, TRUE, TRUE);
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');	
		
		$this->load->view('demo/admin_examples/orders/order_details_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * unset_discount
	 * Removes a specific active item or summary discount from the cart. 
	 * This function is accessed from the 'Update Order Details' page via a 'Remove' link located in the description of an active discount.
	 */ 
	function unset_discount($discount_id = FALSE, $order_number = FALSE)
	{
		$this->load->library('flexi_cart');
		
		// If a discount id is submitted, then only that specific discount will be unset, if submitted as FALSE, all discounts are unset.
		$this->flexi_cart->unset_discount($discount_id);
		
		redirect('admin_library/update_order_details/'.$order_number);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * unset_surcharge
	 * Removes a specific surcharge from the cart.
	 * This function is accessed from the 'Update Order Details' page via a 'Remove' link located in the description of a surcharge.
	 */ 
	function unset_surcharge($surcharge_id = FALSE, $order_number = FALSE)
	{
		$this->load->library('flexi_cart');

		// If a surcharge id is submitted, then only that specific surcharge will be unset, if submitted as FALSE, all surcharges will be unset.
		$this->flexi_cart->unset_surcharge($surcharge_id);
		
		redirect('admin_library/update_order_details/'.$order_number);
	}	
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// LOCATIONS AND ZONES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * LOCATIONS AND ZONES
	 * Location Types act as a parent grouping for locations, for example a location type of 'Country' would act as the parent to locations like 'United States', 'United Kingdom'.
	 * Locations can be setup to identify a users specific location. Shipping and tax rates can then be applied to each location.
	 * Zones can be setup so the shipping and tax rates can be applied to a range of locations, rather than each specific location. For example, EU and non EU European countries.
	 */
	
	/**
	 * location_types
	 * Displays a manageable list of all 'Locations Types'. Each row can be updated or deleted. 
	 */ 
	function location_types() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_location_types'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_location_types();
			////$this->db->cache_delete_all();
		}
	
		// Get an array of all location types.		
		$this->data['location_type_data'] = $this->flexi_cart_admin->get_db_location_type_array();
		
		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];

		$this->load->view('demo/admin_examples/locations/location_type_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_location_type
	 * Inserts new location types to the database. 
	 * This page is accessed via the 'Location' page via a link titled 'Insert New Location Type'.
	 */ 
	function insert_location_type() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_location_type'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_location_type();
			////$this->db->cache_delete_all();
		}
		
		// Get an array of all location types.		
		$this->data['location_type_data'] = $this->flexi_cart_admin->get_db_location_type_array();

		$this->load->view('demo/admin_examples/locations/location_type_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * locations
	 * Displays a manageable list of all 'Locations'. Each row can be updated or deleted.
	 * This page is accessed via the 'Location Type' page via a link on the row of the locations 'parent' (Location type).
	 */ 
	function locations($location_type_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_locations'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_locations();
			////$this->db->cache_delete_all();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get arrays of all shipping and tax zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');
	
		// Get the row array of the location type filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('location_type', 'id') => $location_type_id);
		$this->data['location_type_data'] = $this->flexi_cart_admin->get_db_location_type_row_array(FALSE, $sql_where);

		// Get an array of all locations filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('locations', 'type') => $location_type_id);
		$this->data['location_data'] = $this->flexi_cart_admin->get_db_location_array(FALSE, $sql_where);
	
		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('demo/admin_examples/locations/location_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_location
	 * Inserts new locations to the database. 
	 * This page is accessed via the 'Location Type' page via a link on the row of the locations 'parent' (Location type), followed by a link similar to 'Insert New Location'.
	 */ 
	function insert_location($location_type_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_location'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_location($location_type_id);
			////$this->db->cache_delete_all();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get arrays of all shipping and tax zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');
	
		// Get the row array of the location type filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('location_type', 'id') => $location_type_id);
		$this->data['location_type_data'] = $this->flexi_cart_admin->get_db_location_type_row_array(FALSE, $sql_where);
		
		$this->load->view('demo/admin_examples/locations/location_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * zones
	 * Displays a manageable list of all 'Zones'. Each row can be updated or deleted.
	 */ 
	function zones() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_zones'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_zones();
			////$this->db->cache_delete_all();
		}
		
		// Get an array of all zones.
		$this->data['location_zone_data'] = $this->flexi_cart_admin->get_db_location_zone_array();
	
		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('demo/admin_examples/locations/zone_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_zone
	 * Inserts new location based zones to the database. 
	 * This page is accessed via the 'Zones' page via a link titled 'Insert New Zone'.
	 */ 
	function insert_zone() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_zone'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_zones();
			////$this->db->cache_delete_all();
		}

		$this->load->view('demo/admin_examples/locations/zone_insert_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// SHIPPING OPTIONS AND RATES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * SHIPPING OPTIONS AND RATES
	 * Shipping can be setup to return a selection of different shipping options and rates related to a customers location and the weight and value of the cart.
	 */
	
	/**
	 * shipping
	 * Displays a manageable list of all shipping options. Each row can be updated or deleted.
	 */ 
	function shipping() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_shipping'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_shipping();
			////$this->db->cache_delete_all();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'tiered' into the location type groups, so locations can be listed 
		// over multiple html select menus.
		$this->data['locations_tiered'] = $this->flexi_cart_admin->locations_tiered();

		// Get an array of all shipping zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');
	
		// Get an array of all shipping option data.
		$this->data['shipping_data'] = $this->flexi_cart_admin->get_db_shipping_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('demo/admin_examples/shipping/shipping_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_shipping
	 * Inserts new shipping options to the database. 
	 * This page is accessed via the 'Shipping Options' page via a link titled 'Insert New Shipping Option'.
	 */ 
	function insert_shipping() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_option') && $this->input->post('insert_rate'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_shipping();
			////$this->db->cache_delete_all();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'tiered' into the location type groups, so locations can be listed 
		// over multiple html select menus.
		$this->data['locations_tiered'] = $this->flexi_cart_admin->locations_tiered();

		// Get an array of all shipping zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');
	
		$this->load->view('demo/admin_examples/shipping/shipping_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * shipping_rates
	 * Displays a manageable list of all shipping rates for a specific shipping option. Each row can be updated or deleted.
	 * This page is accessed via the 'Shipping Options' page via a link titled 'Manage'.
	 */ 
	function shipping_rates($shipping_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_shipping_rates'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_shipping_rate();
			////$this->db->cache_delete_all();
		}
		
		// Get the row array of the shipping option filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('shipping_options', 'id') => $shipping_id);
		$this->data['shipping_data'] = $this->flexi_cart_admin->get_db_shipping_row_array(FALSE, $sql_where);
		
		// Get an array of all shipping rates filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('shipping_rates', 'parent') => $shipping_id);
		$this->data['shipping_rate_data'] = $this->flexi_cart_admin->get_db_shipping_rate_array(FALSE, $sql_where);
		
		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('demo/admin_examples/shipping/shipping_rate_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_shipping_rate
	 * Inserts new shipping rates to a specific shipping option in the database. 
	 * This page is accessed via the 'Shipping Options' page via a link titled 'Insert New Rates'.
	 */ 
	function insert_shipping_rate($shipping_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_shipping_rate'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_shipping_rate($shipping_id);
			////$this->db->cache_delete_all();
		}
		
		// Get the row array of the shipping option filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('shipping_options', 'id') => $shipping_id);
		$this->data['shipping_data'] = $this->flexi_cart_admin->get_db_shipping_row_array(FALSE, $sql_where);
	
		$this->load->view('demo/admin_examples/shipping/shipping_rate_insert_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * item_shipping
	 * Displays a manageable list of all shipping rates for a specific item. Each row can be updated or deleted.
	 * This page is accessed via the 'Items' page via a link titled 'Manage' in the 'Item Shipping Rules' table column.	 
	 */ 
	function item_shipping($item_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_item_shipping'))
		{		
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_item_shipping();
			////$this->db->cache_delete_all();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all shipping zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');

		// Get the row array of the demo item filtered by the id in the url.
		$sql_where = array('item_id' => $item_id);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_table_data_row_array('demo_items', FALSE, $sql_where);

		// Get an array of all item shipping rules filtered by the id in the url.		
		$sql_where = array($this->flexi_cart_admin->db_column('item_shipping', 'item') => $item_id);
		$this->data['item_shipping_data'] = $this->flexi_cart_admin->get_db_item_shipping_array(FALSE, $sql_where);

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('demo/admin_examples/items/item_shipping_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_item_shipping
	 * Inserts new item shipping rules for a specific item in the database. 
	 * This page is accessed via the 'Items' page via a link titled 'Manage' in the 'Item Shipping Rules' table column, 
	 * followed by a link titled 'Insert New Item Shipping Rules'.
	 */ 
	function insert_item_shipping($item_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_item_shipping'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_item_shipping($item_id);
			////$this->db->cache_delete_all();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all shipping zones.
		$this->data['shipping_zones'] = $this->flexi_cart_admin->location_zones('shipping');

		// Get the row array of the demo item filtered by the id in the url.
		$sql_where = array('item_id' => $item_id);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_table_data_row_array('demo_items', FALSE, $sql_where);
	
		$this->load->view('demo/admin_examples/items/item_shipping_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// TAXES
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * TAXES
	 * Taxes can be setup to return a tax rate related to a customers location.
	 */
	
	/**
	 * tax
	 * Displays a manageable list of all tax rates. Each row can be updated or deleted.
	 */ 
	function tax() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_tax'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_tax();
			////$this->db->cache_delete_all();
		}
	
		// Get an array of location data formatted with all sub-locations displayed 'tiered' into the location type groups, so locations can be listed 
		// over multiple html select menus.
		$this->data['locations_tiered'] = $this->flexi_cart_admin->locations_tiered();

		// Get an array of all tax zones.
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');

		// Get an array of all tax rates.
		$this->data['tax_data'] = $this->flexi_cart_admin->get_db_tax_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('demo/admin_examples/tax/tax_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_tax
	 * Inserts new tax rate to the database. 
	 * This page is accessed via the 'Taxes' page via a link titled 'Insert New Tax'.
	 */ 
	function insert_tax() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_tax'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_tax();
			////$this->db->cache_delete_all();
		}
	
		// Get an array of location data formatted with all sub-locations displayed 'tiered' into the location type groups, so locations can be listed 
		// over multiple html select menus.
		$this->data['locations_tiered'] = $this->flexi_cart_admin->locations_tiered();

		// Get an array of all tax zones.
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');

		$this->load->view('demo/admin_examples/tax/tax_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * item_tax
	 * Displays a manageable list of all tax rates for a specific item. Each row can be updated or deleted.
	 * This page is accessed via the 'Items' page via a link titled 'Manage' in the 'Item Taxes' table column.
	 */ 
	function item_tax($item_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_item_tax'))
		{		
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_item_tax();
			////$this->db->cache_delete_all();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all tax zones.
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');

		// Get the row array of the demo item filtered by the id in the url.
		$sql_where = array('item_id' => $item_id);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_table_data_row_array('demo_items', FALSE, $sql_where);

		// Get an array of all the item tax rates filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('item_tax', 'item') => $item_id);
		$this->data['item_tax_data'] = $this->flexi_cart_admin->get_db_item_tax_array(FALSE, $sql_where);

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('demo/admin_examples/items/item_tax_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_item_tax
	 * Inserts new item tax rates for a specific item in the database. 
	 * This page is accessed via the 'Items' page via a link titled 'Manage' in the 'Item Taxes' table column, followed by a link titled 'Insert New Item Tax Rates'.
	 */ 
	function insert_item_tax($item_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_item_tax'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_item_tax($item_id);
			////$this->db->cache_delete_all();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all tax zones.
		$this->data['tax_zones'] = $this->flexi_cart_admin->location_zones('tax');

		// Get the row array of the demo item filtered by the id in the url.
		$sql_where = array('item_id' => $item_id);
		$this->data['item_data'] = $this->flexi_cart_admin->get_db_table_data_row_array('demo_items', FALSE, $sql_where);
	
		$this->load->view('demo/admin_examples/items/item_tax_insert_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// DISCOUNTS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * DISCOUNTS
	 * Discounts can be setup with a wide range of rule conditions.
	 * The discounts can then be applied to specific items, groups of items or can be applied across the entire cart.
	 */ 
	
	/**
	 * item_discounts
	 * Displays a manageable list of all item discounts. Each row can be updated or deleted.
	 */ 
	function item_discounts(){
    /*
    print '<pre><xmp>';
    print_r($_POST);
    print '</xmp></pre>';
    exit;
    */
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_discounts')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discounts();
			////$this->db->cache_delete_all();
		}
		
		// Get an array of all discounts filtered by a 'type' of 1 ('item discounts') and for purposes of this demo, have an id of 32+.
		$sql_where = array(
			$this->flexi_cart_admin->db_column('discounts', 'id').' >=' => 32,
			$this->flexi_cart_admin->db_column('discounts', 'type') => 1
		);
		$this->data['discount_data'] = $this->flexi_cart_admin->get_db_discount_array(FALSE, $sql_where);
		
		// Set a variable to indicate on the html page that the discount is an 'item' discount.
		$this->data['discount_type'] = 'item';
	
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('demo/admin_examples/discounts/discounts_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * summary_discounts
	 * Displays a manageable list of all summary discounts. Each row can be updated or deleted.
	 */ 
	function summary_discounts() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_discounts'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discounts();
			////$this->db->cache_delete_all();
		}

		// Get an array of all discounts filtered by a 'type' of 2 ('summary discounts').
		$sql_where = array($this->flexi_cart_admin->db_column('discounts', 'type') => 2);
		$this->data['discount_data'] = $this->flexi_cart_admin->get_db_discount_array(FALSE, $sql_where);
		
		// Set a variable to indicate on the html page that the discount is an 'summary' discount.
		$this->data['discount_type'] = 'summary';
	
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');

		$this->load->view('demo/admin_examples/discounts/discounts_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * update_discount
	 * Updates data for an existing discount in the database. 
	 * This page is accessed via either the 'Item Discounts' or 'Summary Discounts' page via a link titled 'Edit'.
	 */ 
	function update_discount($discount_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_discount'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discount($discount_id);
			////$this->db->cache_delete_all();
		}

		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all zones.
		$this->data['zones'] = $this->flexi_cart_admin->location_zones();
		
		// Get an array of all discount types.		
		$this->data['discount_types'] = $this->flexi_cart_admin->get_db_discount_type_array();
		
		// Get an array of all discount methods.	
		$this->data['discount_methods'] = $this->flexi_cart_admin->get_db_discount_method_array();
		
		// Get an array of all discount tax methods.		
		$this->data['discount_tax_methods'] = $this->flexi_cart_admin->get_db_discount_tax_method_array();
		
		// Get an array of all discount groups.		
		$this->data['discount_groups'] = $this->flexi_cart_admin->get_db_discount_group_array();
		
		// Get an array of all demo items.		
		//$this->data['items'] = $this->flexi_cart_admin->get_db_table_data_array('demo_items');

		// Get the row array of the discount filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('discounts', 'id') => $discount_id);
		$this->data['discount_data'] = $this->flexi_cart_admin->get_db_discount_row_array(FALSE, $sql_where);

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('demo/admin_examples/discounts/discount_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * insert_discount
	 * Inserts a new item or summary discount to the database. 
	 * This page is accessed via either the 'Item Discounts' or 'Summary Discounts' page via a link titled 'Insert New Discount'.
	 */ 
	function insert_discount() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_discount'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_discount();
			////$this->db->cache_delete_all();
		}

		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all zones.
		$this->data['zones'] = $this->flexi_cart_admin->location_zones();
		
		// Get an array of all discount types.		
		$this->data['discount_types'] = $this->flexi_cart_admin->get_db_discount_type_array();
		
		// Get an array of all discount methods.	
		$this->data['discount_methods'] = $this->flexi_cart_admin->get_db_discount_method_array();
		
		// Get an array of all discount tax methods.		
		$this->data['discount_tax_methods'] = $this->flexi_cart_admin->get_db_discount_tax_method_array();
		
		// Get an array of all discount groups.		
		$this->data['discount_groups'] = $this->flexi_cart_admin->get_db_discount_group_array();
		
		// Get an array of all demo items.		
		//$this->data['items'] = $this->flexi_cart_admin->get_db_table_data_array('demo_items');
	
		$this->load->view('demo/admin_examples/discounts/discount_insert_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * discount_groups
	 * Displays a manageable list of all discount groups. Each row can be updated or deleted.
	 */ 
	function discount_groups() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		//if ($this->input->post('update_discount_groups')){
    if (isset($_POST['update'])){
      /*
      print '<pre><xmp>';
      print_r($_POST);
      print '</xmp></pre>';
      exit;
      */
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discount_groups();
			////$this->db->cache_delete_all();
		}
	
		// Get an array of all discount groups.		
		$this->data['discount_group_data'] = $this->flexi_cart_admin->get_db_discount_group_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
	
		$this->load->view('demo/admin_examples/discounts/discount_groups_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	function item_discounts_ekam(){
		if ($this->input->post('update_discounts')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discounts_generica('discounts_ekam');
		}
		$sql_where = array($this->flexi_cart_admin->db_column('discounts_ekam', 'type') => 1);
		$this->data['discount_data'] = $this->flexi_cart_admin->get_db_discount_generic_array($sql_where, 'discounts_ekam');
		$this->data['discount_type'] = 'item';
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('demo/admin_examples/discounts/ekam/discounts_view', $this->data);
	}

	function summary_discounts_ekam(){
		if ($this->input->post('update_discounts')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discounts_generica('discounts_ekam');
		}
		$sql_where = array($this->flexi_cart_admin->db_column('discounts_ekam', 'type') => 2);
		$this->data['discount_data'] = $this->flexi_cart_admin->get_db_discount_generic_array($sql_where, 'discounts_ekam');
		$this->data['discount_type'] = 'summary';
		$this->data['message'] = $this->session->flashdata('message');
		$this->load->view('demo/admin_examples/discounts/ekam/discounts_view', $this->data);
	}

	function insert_discount_ekam(){
		if ($this->input->post('insert_discount')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_discount_generica('discounts_ekam');
		}
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		$this->data['zones'] = $this->flexi_cart_admin->location_zones();
		$this->data['discount_types'] = $this->flexi_cart_admin->get_db_discount_type_array();
		$this->data['discount_methods'] = $this->flexi_cart_admin->get_db_discount_method_array();
		$this->data['discount_tax_methods'] = $this->flexi_cart_admin->get_db_discount_tax_method_array();
		$this->data['discount_groups'] = $this->flexi_cart_admin->get_db_discount_group_array();
		$this->load->view('demo/admin_examples/discounts/ekam/discount_insert_view', $this->data);
	}

	function update_discount_ekam($discount_id){
		if ($this->input->post('update_discount')){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discount_generica($discount_id, 'discounts_ekam');
		}
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		$this->data['zones'] = $this->flexi_cart_admin->location_zones();
		$this->data['discount_types'] = $this->flexi_cart_admin->get_db_discount_type_array();
		$this->data['discount_methods'] = $this->flexi_cart_admin->get_db_discount_method_array();
		$this->data['discount_tax_methods'] = $this->flexi_cart_admin->get_db_discount_tax_method_array();
		$this->data['discount_groups'] = $this->flexi_cart_admin->get_db_discount_group_array();
		$sql_where = array($this->flexi_cart_admin->db_column('discounts_ekam', 'id') => $discount_id);
		$all = $this->flexi_cart_admin->get_db_discount_generic_array($sql_where, 'discounts_ekam');
		$this->data['discount_data'] = !empty($all) ? $all[0] : array();
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		$this->load->view('demo/admin_examples/discounts/ekam/discount_update_view', $this->data);
	}

	function discount_groups_ekam(){
		if (isset($_POST['update'])){
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_discount_groups();
		}
		$this->data['discount_group_data'] = $this->flexi_cart_admin->get_db_discount_group_array();
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		$this->load->view('demo/admin_examples/discounts/ekam/discount_groups_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###

	/**
	 * update_discount_group
	 * Updates data for an existing discount group and its related discount group items in the database.
	 * This page is accessed via the 'Discount Groups' page via a link titled 'Manage Items in Group'.
	 */
	function update_discount_group($group_id) {
		//~ if ($group_id==233 || $group_id==334){
			//~ echo "<br />".count($_POST['delete_item']);
			//~ print '<pre><xmp>';
			//~ print_r($_POST);
			//~ print '</xmp></pre>';
			//~ exit;
		//~ }
		
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_discount_group_items'))
		{
			
			$this->load->model('demo_cart_admin_model');
			
			$this->demo_cart_admin_model->demo_update_discount_group($group_id);
			////$this->db->cache_delete_all();
		}
		
		// Get the row array of the discount group filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('discount_groups', 'id') => $group_id);
		
		$this->data['group_data'] = $this->flexi_cart_admin->get_db_discount_group_row_array(FALSE, $sql_where);
		
		// Get an array of all the discount group items filtered by the id in the url.
		// Using flexi cart SQL functions, join the demo item table with the discount group items and then order the data by item id.
		$this->flexi_cart_admin->sql_join('demo_items', 'item_id = '.$this->flexi_cart_admin->db_column('discount_group_items', 'item')); 
		$this->flexi_cart_admin->sql_order_by('item_id');
		$sql_where = array($this->flexi_cart_admin->db_column('discount_group_items', 'group') => $group_id);		
		
		$this->data['group_item_data'] = $this->flexi_cart_admin->get_db_discount_group_item_array(FALSE, $sql_where);
		
		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('demo/admin_examples/discounts/discount_group_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_discount_group
	 * Inserts a new discount group and its related discount group items to the database. 
	 * This page is accessed via the 'Discount Groups' page via a link titled 'Insert New Group'.
	 */ 
	function insert_discount_group() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_discount_group'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_discount_group();
			////$this->db->cache_delete_all();
		}
	
		$this->load->view('demo/admin_examples/discounts/discount_group_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_discount_group_items
	 * Inserts new discount group items to the database. 
	 * This page is accessed via the 'Discount Groups' page via a link titled 'Insert New Items to Group'.
	 */ 
	function insert_discount_group_items($group_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_discount_group_items'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_discount_group_items($group_id);
			////$this->db->cache_delete_all();
		}
		
		// Get the row array of the discount group filtered by the id in the url.
		$sql_where = array($this->flexi_cart_admin->db_column('discount_groups', 'id') => $group_id);
		$this->data['group_data'] = $this->flexi_cart_admin->get_db_discount_group_row_array(FALSE, $sql_where);
				
		$this->load->view('demo/admin_examples/discounts/discount_group_items_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// REWARD POINTS AND VOUCHERS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * REWARD POINTS AND VOUCHERS
	 * Customers can earn reward points when purchasing cart items. The reward points can then be converted to vouchers that can be used to buy other items.
	 */ 
	
	/**
	 * user_reward_points
	 * Displays a summary list of all users and their reward points.
	 */ 
	function user_reward_points() 
	{
		$this->load->model('demo_cart_admin_model');
		
		// Get an array of all demo users and their related reward points from a custom demo model function.
		$this->data['user_data'] = $this->demo_cart_admin_model->demo_reward_point_summary();
		
		$this->load->view('demo/admin_examples/reward_points/user_reward_points_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * user_reward_point_history
	 * Displays an itemised list of all earnt and converted user reward points.
	 * This page is accessed via the 'Reward Points' page via a link titled 'View' in the 'History' table column.
	 */ 
	function user_reward_point_history($user_id) 
	{
		$this->load->model('demo_cart_admin_model');
		
		// Get the row array of the demo users filtered by the id in the url.
		$sql_where = array('user_id' => $user_id);
		$this->data['user_data'] = $this->flexi_cart_admin->get_db_table_data_row_array('demo_users', FALSE, $sql_where);
	
		// Get an array of all reward points for a user filtered by the id in the url.
		// The 'get_user_reward_points()' function only returns the minimum required fields, therefore define the other required table fields via an SQL SELECT statement.
		$sql_select = array(
			$this->flexi_cart_admin->db_column('reward_points', 'order_number'),
			$this->flexi_cart_admin->db_column('reward_points', 'description'),
			$this->flexi_cart_admin->db_column('reward_points', 'order_date')
		);	
		$sql_where = array($this->flexi_cart_admin->db_column('reward_points', 'user') => $user_id);
		$this->data['points_awarded_data'] = $this->flexi_cart_admin->get_db_reward_points_array($sql_select, $sql_where);
		
		// Call a custom function that returns a nested array of reward voucher codes and the reward point data used to create the voucher.
		$this->data['points_converted_data'] = $this->demo_cart_admin_model->demo_converted_reward_point_history($user_id);
		
		$this->load->view('demo/admin_examples/reward_points/user_reward_point_history_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * user_vouchers
	 * Displays a list of all reward vouchers for a specific user. Each row can be updated.
	 * This page is accessed via the 'Reward Points' page via a link titled 'View' in the 'Vouchers' table column.
	 */ 
	function user_vouchers($user_id) 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_vouchers'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_voucher();
		}
	
		// Get the row array of the demo user filtered by the id in the url.
		$sql_where = array('user_id' => $user_id);
		$this->data['user_data'] = $this->flexi_cart_admin->get_db_table_data_row_array('demo_users', FALSE, $sql_where);

		// Get an array of all the reward vouchers filtered by the id in the url.
		// Using flexi cart SQL functions, join the demo user table with the discount table.
		$sql_where = array($this->flexi_cart_admin->db_column('discounts', 'user') => $user_id);
		$this->flexi_cart_admin->sql_join('demo_users', 'user_id = '.$this->flexi_cart_admin->db_column('discounts', 'user'));
		$this->data['voucher_data'] = $this->flexi_cart_admin->get_db_voucher_array(FALSE, $sql_where);
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('demo/admin_examples/reward_points/user_vouchers_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * vouchers
	 * Displays a list of all reward vouchers. Each row can be updated.
	 */ 
	function vouchers() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_vouchers'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_voucher();
		}
	
		// Get an array of all reward vouchers.
		// Using flexi cart SQL functions, join the demo users table with the discount table.
		$this->flexi_cart_admin->sql_join('users', 'user_id = '.$this->flexi_cart_admin->db_column('discounts', 'user'));
		$this->data['voucher_data'] = $this->flexi_cart_admin->get_db_voucher_array();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('demo/admin_examples/reward_points/vouchers_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * convert_reward_points
	 * Converts a submitted number of reward points into a reward voucher.
	 * This page is accessed via the 'Reward Points' page via a link titled 'Convert' in the 'Vouchers' table column.
	 */ 
	function convert_reward_points($user_id) 
	{
		$this->load->model('demo_cart_admin_model');
		
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('convert_reward_points'))
		{
			$this->demo_cart_admin_model->demo_convert_reward_points($user_id);
			////$this->db->cache_delete_all();
		}

		// Get an array of a demo user and their related reward points from a custom demo model function, filtered by the id in the url.
		$user_data = $this->demo_cart_admin_model->demo_reward_point_summary($user_id);
		
		// Note: The custom function returns a multi-dimensional array, of which we only need the first array, so get the first row '$user_data[0]'.
		$this->data['user_data'] = $user_data[0];
		
		// Get the conversion tier values for converting reward points to vouchers.
		$conversion_tiers = $this->data['user_data'][$this->flexi_cart_admin->db_column('reward_points', 'total_points_active')];
		$this->data['conversion_tiers'] = $this->flexi_cart_admin->get_reward_point_conversion_tiers($conversion_tiers);
		
		$this->load->view('demo/admin_examples/reward_points/user_reward_point_convert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CURRENCY
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * currency
	 * Displays a manageable list of all currencies. Each row can be updated or deleted.
	 */ 
	function currency() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_currency'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_currency();
			////$this->db->cache_delete_all();
		}

		// Get an array of all currencies.
		$this->data['currency_data'] = $this->flexi_cart_admin->get_db_currency_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('demo/admin_examples/currency/currency_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_currency
	 * Inserts new currencies to the database. 
	 * This page is accessed via the 'Currency' page via a link titled 'Insert New Currency'.
	 */ 
	function insert_currency() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_currency'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_currency();
			////$this->db->cache_delete_all();
		}

		$this->load->view('demo/admin_examples/currency/currency_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// ORDER STATUS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * order_status
	 * Displays a manageable list of all order statuses. Each row can be updated or deleted.
	 */ 
	function order_status() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_order_status'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_order_status();
			////$this->db->cache_delete_all();
		}

		// Get an array of all order statuses.
		$this->data['order_status_data'] = $this->flexi_cart_admin->get_db_order_status_array();

		// Get any status message that may have been set.
		$this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
		
		$this->load->view('demo/admin_examples/orders/order_status_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###
	
	/**
	 * insert_order_status
	 * Inserts new order statuses to the database. 
	 * This page is accessed via the 'Order Status' page via a link titled 'Insert New Order Status'.
	 */ 
	function insert_order_status()
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('insert_order_status'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_insert_order_status();
			////$this->db->cache_delete_all();
		}

		$this->load->view('demo/admin_examples/orders/order_status_insert_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// CART CONFIGURATION AND DEFAULTS
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * config
	 * Updates the carts configuration data in the database. 
	 */ 
	function config() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_config'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_config();
			////$this->db->cache_delete_all();
		}
		
		// Get the row array of the config table.
		$this->data['config'] = $this->flexi_cart_admin->get_db_config_row_array();

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('demo/admin_examples/config/config_update_view', $this->data);
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * defaults
	 * Sets the default cart values for the currency, shipping and tax tables. 
	 */ 
	function defaults() 
	{
		// Check if POST data has been submitted, if so, call the custom demo model function to handle the submitted data.
		if ($this->input->post('update_defaults'))
		{
			$this->load->model('demo_cart_admin_model');
			$this->demo_cart_admin_model->demo_update_defaults();
			////$this->db->cache_delete_all();
		}
		
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		// Alternatively, the location data could have been formatted with all sub-locations displayed 'tiered' into the location type groups.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of all currencies.
		$this->data['currency_data'] = $this->flexi_cart_admin->get_db_currency_array();

		// Get an array of all shipping options.
		$this->data['shipping_data'] = $this->flexi_cart_admin->get_db_shipping_array();

		// Get an array of all tax rate.
		$this->data['tax_data'] = $this->flexi_cart_admin->get_db_tax_array();

		// Get current cart defaults.
		$this->data['default_currency'] = $this->flexi_cart_admin->get_db_currency_row_array(FALSE, array('curr_default' => 1));
		$this->data['default_ship_location'] = $this->flexi_cart_admin->get_db_location_row_array(FALSE, array('loc_ship_default' => 1));
		$this->data['default_tax_location'] = $this->flexi_cart_admin->get_db_location_row_array(FALSE, array('loc_tax_default' => 1));
		$this->data['default_ship_option'] = $this->flexi_cart_admin->get_db_shipping_row_array(FALSE, array('ship_default' => 1));
		$this->data['default_tax_rate'] = $this->flexi_cart_admin->get_db_tax_row_array(FALSE, array('tax_default' => 1));

		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->load->view('demo/admin_examples/config/defaults_update_view', $this->data);
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// LOCATION MENU EXAMPLE
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * demo_location_menus
	 * A demo example of how location data can be displayed via html select menus with a JavaScript and non Javascript example.
	 */ 
	function demo_location_menus()
	{
		// Get an array of location data formatted with all sub-locations displayed 'inline', so all locations can be listed in one html select menu.
		$this->data['locations_inline'] = $this->flexi_cart_admin->locations_inline();
		
		// Get an array of location data formatted with all sub-locations displayed 'tiered' into the location type groups, so locations can be listed 
		// over multiple html select menus.
		$this->data['locations_tiered'] = $this->flexi_cart_admin->locations_tiered();

		$this->load->view('demo/admin_examples/locations/location_menu_demo_view', $this->data);		
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// MINI CART DATA
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	
	/**
	 * mini_cart_data
	 * This function is called by the '__construct()' to set item data to be displayed on the 'Mini Cart' menu.
	 */ 
	private function mini_cart_data()
	{
		$this->data['mini_cart_items'] = $this->flexi_cart_admin->cart_items();
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

public function mkt_fab()
	{
		try{
                    $this->load->library('grocery_CRUD');
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('demo_categories');
			$crud->set_subject('Fabricantes');
			$crud->unset_add()->unset_delete()->unset_read();
			$crud->columns('cat_name','cat_text','cat_text2','cat-desc');
                        $crud->edit_fields('cat_name','cat_text','cat_text2','cat-desc');
			$crud->display_as('cat_name',"Nombre")
				 ->display_as('cat_text',"Texto1")
				 ->display_as('cat_text2',"Texto2")
				 ->display_as('cat-desc',"Meta descripcion");
			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
        public function mkt_col()
	{
		try{
                    $this->load->library('grocery_CRUD');
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('demo_coleccion');
			$crud->set_subject('Colecciones');
			$crud->unset_add()->unset_delete()->unset_read();
			$crud->columns('coleccion_name','col_text','col-desc');
                        $crud->edit_fields('coleccion_name','col_text','col-desc');
			$crud->display_as('coleccion_name',"Nombre")
				 ->display_as('col_text',"Texto1")
				 ->display_as('col-desc',"Meta descripcion");
			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
public function mkt_usr()
	{
		try{
                    $this->load->library('grocery_CRUD');
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('users');
			$crud->set_subject('Usuarios');
			$crud->unset_add()->unset_delete()->unset_edit()->unset_read();
			$crud->columns('ord_demo_bill_name','ord_demo_bill_company','ord_demo_bill_address_01','ord_demo_bill_city','ord_demo_bill_state','ord_demo_bill_post_code','ord_demo_ship_name','ord_demo_ship_address_01','ord_demo_ship_city', 'ord_demo_ship_state','ord_demo_ship_post_code','email','phone','requestdate');
			$crud->display_as('ord_demo_bill_name',"Nombre(fr)")
				 ->display_as('ord_demo_bill_company',"CIF")
				 ->display_as('ord_demo_bill_address_01',"Dir(fr)")
				 ->display_as('ord_demo_bill_city',"Población(fr)")
				 ->display_as('ord_demo_bill_state',"Provincia(fr)")
				 ->display_as('ord_demo_bill_post_code',"CP(fr)")
				 ->display_as('ord_demo_ship_name',"Nombre")
				 ->display_as('ord_demo_ship_address_01',"Dir")
				 ->display_as('ord_demo_ship_city',"Población")
				 ->display_as('ord_demo_ship_state',"Provincia")
				 ->display_as('ord_demo_ship_post_code',"CP")
				 ->display_as('phone',"telefono")
                                 ->display_as('requestdate',"fecha");
			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	public function mkt_ord()
	{
		try{
                    $this->load->library('grocery_CRUD');
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('order_summary');
			$crud->set_subject('Pedidos')->where('ord_status <', 5)->where('ord_order_number >', "00001000");
			$crud->unset_add()->unset_delete()->unset_edit()->unset_read();
			$crud->set_relation('ord_status','order_status','ord_status_description');
			$crud->columns('ord_order_number','ord_total','ord_total_items','ord_status','ord_demo_bill_name','ord_demo_bill_company','ord_demo_bill_address_01','ord_demo_bill_city','ord_demo_bill_state','ord_demo_bill_post_code','ord_demo_ship_name','ord_demo_ship_address_01','ord_demo_ship_city', 'ord_demo_ship_state','ord_demo_ship_post_code','ord_demo_email','ord_demo_phone');
			$crud->display_as('ord_order_number',"Pedido")
				 ->display_as('ord_total',"Importe")
				 ->display_as('ord_total_items',"Artículos")
				 ->display_as('ord_status',"Estado")
				 ->display_as('ord_demo_bill_name',"Nombre(fr)")
				 ->display_as('ord_demo_bill_company',"CIF")
				 ->display_as('ord_demo_bill_address_01',"Dir(fr)")
				 ->display_as('ord_demo_bill_city',"Población(fr)")
				 ->display_as('ord_demo_bill_state',"Provincia(fr)")
				 ->display_as('ord_demo_bill_post_code',"CP(fr)")
				 ->display_as('ord_demo_ship_name',"Nombre")
				 ->display_as('ord_demo_ship_address_01',"Dir")
				 ->display_as('ord_demo_ship_city',"Población")
				 ->display_as('ord_demo_ship_state',"Provincia")
				 ->display_as('ord_demo_ship_post_code',"CP")
				 ->display_as('ord_demo_email',"email")
				 ->display_as('ord_demo_phone',"telefono");
			$output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
        public function _example_output($output = null)
	{
		$this->load->view('example_crud.php',$output);
	}
        function ver_factura($pedido){
		$this->load->library('flexi_cart_admin');
		$this->load->model('demo_cart_model');
		$this->load->model('demo_cart_admin_model');
		$this->data['pedido']=$this->getFactura($pedido);
		$this->load->view("frontend/cuentas/plantillamailfra",$this->data);
		//$this->demo_cart_admin_model->demo_facturar($pedido);   
        }
        function ver_factura_rect($pedido){
		$this->load->library('flexi_cart_admin');
		$this->load->model('demo_cart_model');
		$this->load->model('demo_cart_admin_model');
		$this->data['pedido']=$this->getFacturaRect($pedido);
		$this->load->view("frontend/cuentas/plantillamailfra",$this->data);
		//$this->demo_cart_admin_model->demo_facturar($pedido);   
        }
        function ver_ticket($pedido){
            $this->load->library('flexi_cart_admin');
            $this->load->model('demo_cart_model');
            $this->load->model('demo_cart_admin_model');
            $this->data['pedido']=$this->getTicket($pedido);
            $this->load->view("frontend/cuentas/plantillamailfra",$this->data);
            //$this->demo_cart_admin_model->demo_facturar($pedido);   
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


    public function listado_urls(){
      $this->load->model('flexi_cart_model');

      $colecciones=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_coleccion', 'coleccion_id', array('publico2'=>1));
      $a_colecciones=array();
      $a_colecciones_aux=array();
      foreach($colecciones as $id_coleccion =>$datos){
        $a_colecciones[$id_coleccion]=$datos['coleccion_name'];
      }
      /*
      print '<pre><xmp>';
      print_r($a_colecciones);
      print '</xmp></pre>';
      */
      $idmarca=268;
      $tipo_producto=4;
      $publico3=0;
        
      $productos=$this->flexi_cart_model->get_erregistroak_eremu_guztiak('demo_items', 'item_id', 
                        array('item_tipo'=>$tipo_producto, 
                              'item_cat_fk'=>$idmarca, 
                              'publico3'=>$publico3,
                              'tiene_relacionados'=>0,
                              'relacionado_con'=>0));
      $a_productos=array();
      foreach($productos as $item_id =>$datos){
        $idcoleccion=$datos['item_coleccion_id'];
        if (!isset($a_productos[$idcoleccion])){
          $a_productos[$idcoleccion]['item_id']=$datos['item_id'];
          $a_productos[$idcoleccion]['coleccion']=$this->urlenc_aux($a_colecciones[$idcoleccion]);

          $id=$datos['item_id'];
          $nombre=$this->urlenc_aux($a_colecciones[$idcoleccion]);
          $a_url[$nombre]="<br />https://www.depapelpintado.es/tienda/articulo/marca/{$nombre}/id/{$id}?test=eneko";
        }
      }
      ksort($a_url);
      foreach($a_url as $nombre=>$url){
        echo "$url";
      }
      /*
      print '<pre><xmp>';
      print_r($a_productos);
      print '</xmp></pre>';
      */
      exit;
      
      //https://www.depapelpintado.es/tienda/articulo/asdfa-monteiro/asdfasd/id/89288?test=eneko

        /*
        header('Content-Type: text/xml');
        echo "<?xml version='1.0' encoding='UTF-8'?><?xml-stylesheet type='text/xsl' href='https://www.depapelpintado.es/sitemaps/main-sitemap.xsl'?>\n";
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
                            echo "       <loc>https://www.depapelpintado.es/tienda/articulo/".$this->urlenc_aux($nombre_marca)."/".$this->urlenc_aux($nombre_coleccion)."/id/{$idproducto}</loc>\n";
                            echo "</url>\n";
                        }
                    }
                }
            }
        }
        echo "</urlset>\n";
        */
    }
    private function urlenc_aux($str){
        //$search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,!,(,)");
        //$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,ñ,,,");
        $search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,%,!,(,)");
        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,ñ,,,,");

        return str_replace($search,$replace,strtolower(str_replace(',','', str_replace('+','-plus-',str_replace('#','number-',str_replace('&','and',str_replace(' ','-',rawurldecode($str))))))));
    }

}

/* End of file admin_library.php */
/* Location: ./application/controllers/admin_library.php */