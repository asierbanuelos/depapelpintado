<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Bloques</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  
  <?php $this->load->view('includes/demo_header'); ?>
  
  <div class="container">
    <?=anchor("admin_library/addpromo/1", "Añadir nuevo Bloque",'class="button orange-button twelve t-full m-full send" style="margin-top:10px;"')?>
    <?foreach($paginas as $key){?>
    <div class="row"> 
      <div class="col one" ><?=$key->id?></div>
      <div class="col six" ><?=$key->titulo?></div>
      
      <div class="col two" ><?=anchor('admin_library/editpagina/'.$key->id,"Editar");?></div>
      <div class="col two" ><?=anchor('admin_library/activarpagina/'.$key->id.'/'.$key->activo,($key->activo==0)?"Activar":"Desactivar");?></div>
      <div class="col one" >&nbsp;</div>
    </div> 
    <div style="clear:both"></div>
      <?}?>
        
  </div>
  <?php $this->load->view('includes/scripts'); ?> 
</body>
</html>