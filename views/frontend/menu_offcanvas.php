<?php
$cat=-1;
if(isset($categ))
  $cat=$categ;
if (strpos(uri_string(),"economicos")!==false)
  $cat=-3;
if (strpos(uri_string(),"articulo")!==false && isset ($key['item_tipo']))
  $cat=$key['item_tipo'];

$categorias_resaltadas_menu=$this->flexi_cart_model->get_categorias_resaltadas_menu(-1);
?>
<!-- MENÚ MÓVIL OFF-CANVAS -->
<div id="bs-canvas-left" class="bs-canvas bs-canvas-anim bs-canvas-left position-fixed bg-light h-100">
  <header class="bs-canvas-header p-3">
    <button type="button" class="bs-canvas-close close" aria-label="Close"><span aria-hidden="true" class="text-dark">&times;</span></button>
  </header>
  <div class="bs-canvas-content px-3 py-2">
    <ul class="navbar-nav ml-auto nav-fill d-flex justify-content-center mx-auto">
      <li class="nav-item px-3 dropdown <?php if($cat==0) echo ' menu-activo ';?>">
        <a class="nav-link ver-submenu" href="/tienda/papel_pintado" role="button" aria-haspopup="true" aria-expanded="false">PAPEL PINTADO</a>
        <ul class="dropdown-menu">
          <li><?=anchor("tienda/papel_pintado","Ver todos",'class=""');?></li>
          <li><?=anchor("tienda/papel_pintado/marcas","Marcas",'class=""');?></li>
          <li><?=anchor("estilos-papel-pintado","Estilos",'class=""');?></li>
        </ul>
      </li>
      <li class="nav-item px-3 <?php if($cat==4) echo ' menu-activo ';?>">
        <a class="nav-link ver-submenu" href="/tienda/alfombras" role="button" aria-haspopup="true" aria-expanded="false">ALFOMBRAS</a>
        <ul class="dropdown-menu">
          <li><?=anchor("tienda/alfombras","Ver todas",'class="miclase"');?></li>
          <li><?=anchor("tienda/alfombras/marcas","Marcas",'class="miclase"');?></li>
          <li><?=anchor("estilos-alfombras","Estilos",'class="miclase"');?></li>
          <?php
          if (isset($categorias_resaltadas_menu[4])){
            foreach ($categorias_resaltadas_menu[4] as $id_categoria_aux => $datos_categoria_resaltada) {
              echo '  <li>'.anchor($datos_categoria_resaltada['url'], $datos_categoria_resaltada['nombre'],'class="miclase"').'</li>';
            }
          }
          ?>
        </ul>
      </li>
      <li class="nav-item px-3 <?php if($cat==1) echo ' menu-activo ';?>">
        <a class="nav-link ver-submenu" href="/tienda/murales" role="button" aria-haspopup="true" aria-expanded="false">MURALES</a>
        <ul class="dropdown-menu">
          <li><?=anchor("tienda/murales","Ver todos",'class="miclase"');?></li>
          <li><?=anchor("tienda/murales/marcas","Marcas",'class="miclase"');?></li>
          <li><?=anchor("estilos-murales","Estilos",'class="miclase"');?></li>
        </ul>
      </li>
      <li class="nav-item px-3 <?php if($cat==2) echo ' menu-activo ';?>">
        <a class="nav-link ver-submenu" href="/tienda/revestimientos" role="button" aria-haspopup="true" aria-expanded="false">REVESTIMIENTOS</a>
        <ul class="dropdown-menu">
          <li><?=anchor("tienda/revestimientos","Ver todos",'class="miclase"');?></li>
          <li><?=anchor("tienda/revestimientos/marcas","Marcas",'class="miclase"');?></li>
          <li><?=anchor("estilos-revestimientos","Estilos",'class="miclase"');?></li>
        </ul>
      </li>
      <li class="nav-item px-3 <?php if($cat==-3 && isset($productos_outlet)) echo ' menu-activo ';?>">
        <a href="/tienda/papel_pintado/economicos" class="nav-link">OUTLET</a>
      </li>
      <li class="nav-item px-3 <?php if($cat==3) echo ' menu-activo ';?>">
        <a class="nav-link ver-submenu" href="/tienda/telas" role="button" aria-haspopup="true" aria-expanded="false">TELAS</a>
        <ul class="dropdown-menu">
          <li><?=anchor("tienda/telas","Ver todas",'class="miclase"');?></li>
          <li><?=anchor("tienda/telas/marcas","Marcas",'class="miclase"');?></li>
          <li><?=anchor("estilos-telas","Estilos",'class="miclase"');?></li>
        </ul>
      </li>
      <li class="nav-item px-3 <?php if($cat==5) echo ' menu-activo ';?>">
        <a href="/tienda/herramientas" class="nav-link">HERRAMIENTAS</a>
      </li>
      <li class="nav-item px-3">
        <a href="/tienda/marcas" class="nav-link">MARCAS</a>
      </li>
      <li class="nav-item px-3">
        <a href="/tienda/complementos" class="nav-link">COMPLEMENTOS</a>
      </li>
      <li class="nav-item px-3">
        <a href="/contacto" class="nav-link">CONTACTO</a>
      </li>
      <li class="nav-item px-3">
        <a href="/ayuda-papel-pintado" class="nav-link">TE AYUDAMOS</a>
      </li>
    </ul>
  </div>
</div>
