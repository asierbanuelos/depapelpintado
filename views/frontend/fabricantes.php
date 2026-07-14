
 
<div class="units-row units-padding">
 <div class="unit-centered unit-80 cuerpocentral blancobg sombra">
    <?$this->load->view('frontend/migas', $this->data);?>
    <div class="unit-100">
      <?php
      $texto_post_h1='';
      if (isset($familia_producto) && $familia_producto!='')
         $texto_post_h1=' de '.$familia_producto;
      ?>
      <h1 class="fuentecorporativa magenta-secundario">Listado de Marcas <?php echo $texto_post_h1; ?></h1>
    </div>
    <ul class="blocks-6">
       <li><?=anchor("marcas","Todas las Marcas");?></li>
       <li><?=anchor("tienda/papel_pintado/marcas","Papel Pintado");?></li>
       <li><?=anchor("tienda/murales/marcas","Murales");?></li>
       <li><?=anchor("tienda/revestimientos/marcas","Revestimientos");?></li>
       <li><?=anchor("tienda/telas/marcas","Telas");?></li>
       <li><?=anchor("tienda/alfombras/marcas","Alfombras");?></li>
    </ul>
    
    <ul class="blocks-4 listamarcas">
      
    <?$count=0;
    foreach ($fab as $l) {
      $d="";
      
      if($l->disc==1){
         $d.='<div style="position:absolute;right:-20px;top:-25px;z-index: 1000;width:75px"><img src="'.$includes_dir.'images/descuento.png"></div>
         <div style="position:absolute;right:-20px;top:-25px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:25px;font-size: 10px;">Descuento</div>';
         }
         $d.='<img alt="'.$l->cat_name.'" title="'.$l->cat_name.'" src="'.$includes_dir.'images/logos/'.$l->cat_id.'.jpg" />'?>
      
        <li ><?=anchor($this->uri->segment(1)."/".$this->uri->segment(2)."/marca/".$l->cat_id."/".  urlenc($l->cat_name),$d,'style="position:relative;"');?>
       </li>
     

     <? } ?>
    </ul>
 </div> <!--fin cuerpo central-->
</div> <!--fin units-row contenedor cuerpo central--> 