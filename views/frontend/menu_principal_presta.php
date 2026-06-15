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

<!-- create your responsive navbar -->
<nav class="navbar navbar-light menu-principal navbar-expand-lg" id="myNavbar">
    <!-- next is your mobile burger menu toggle --> 
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="navbar-nav ml-auto nav-fill">
        <li class="nav-item px-4 <?php if($cat==0) echo ' menu-activo ';?>" >
            <a href="/tienda/papel_pintado" class="nav-link">PAPEL PINTADO</a>
            <?php
            /*
            <ul class="dropdown-menu">
                <li><?=anchor("tienda/papel_pintado","Ver todos",'class=""');?></li>
                <li><?=anchor("tienda/papel_pintado/marcas","Marcas",'class=""');?></li>
                <li><?=anchor("estilos-papel-pintado","Estilos",'class=""');?></li>
            </ul>
            */
            ?>
        </li>
        <li class="nav-item px-4 dropdown">
            <!-- we will put our "Services" mega menu in here -->
        </li>
        <li class="nav-item px-4 <?php if($cat==1) echo ' menu-activo ';?>" >
            <a href="/tienda/fotomurales" class="nav-link">FOTOMURALES</a>
            <?php
            /*
            <ul class="dropdown-menu">
                <li><?=anchor("tienda/fotomurales","Ver todos",'class="miclase"');?></li>
                <li><?=anchor("tienda/fotomurales/marcas","Marcas",'class="miclase"');?></li>
                <li><?=anchor("estilos-fotomurales","Estilos",'class="miclase"');?></li>
            </ul>
            */
            ?>
        </li>
        <li class="nav-item px-4 <?php if($cat==2) echo ' menu-activo ';?>" >
            <a href="/tienda/revestimientos" class="nav-link">REVESTIMIENTOS</a>
        </li>
        <li class="nav-item px-4 <?php if($cat==2) echo ' menu-activo ';?>" >
            <a href="/tienda/papel_pintado/economicos" class="nav-link">OUTLET</a>
        </li>
        <li class="nav-item px-4 <?php if($cat==3) echo ' menu-activo ';?>" >
            <a href="/tienda/telas" class="nav-link">TELAS</a>
            <?php
            /*
            <ul class="dropdown-menu">
                <li><?=anchor("tienda/telas","Ver todas",'class="miclase"');?></li>
                <li><?=anchor("tienda/telas/marcas","Marcas",'class="miclase"');?></li>
            </ul>
            */
            ?>
        </li>
        <li class="nav-item px-4 <?php if($cat==4) echo ' menu-activo ';?>" >
            <a href="/tienda/alfombras" class="nav-link">ALFOMBRAS</a>
            <?php
            /*
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
            */
            ?>
        </li>
        <li class="nav-item px-4 <?php if($cat==5) echo ' menu-activo ';?>" >
            <a href="/tienda/herramientas" class="nav-link">HERRAMIENTAS</a>
        </li>
    </ul>
</nav>

<!-- fin menu principal superior --> 
<script>
  $(document).ready(function() {
    $( ".desplegar-submenu" ).on( "click", function( event ) {
      if($(window).width() < 768){
        event.preventDefault();
        event.stopPropagation();
        $(this).parent().siblings().find('ul').slideUp();
        $(this).parent().find('ul').slideToggle();
      }
    });
  });
</script>

