<?php

$texto_h1='';
$texto_descripcion='';

if (isset($texto_h1_seccion)){
  $texto_h1=$texto_h1_seccion;
}
if (isset($texto__intro_seo)){
  $texto_descripcion=$texto__intro_seo;
}
if (isset($datos_coleccion)){
  $texto_h1='Colección '.$datos_coleccion->coleccion_name.' de '.$familia_producto.' '.$datos_coleccion->cat_name;
  if ($datos_coleccion->col_text_publico)
    $texto_descripcion=$datos_coleccion->col_text;
}
elseif (isset($datos_estilo[0])){
  if (isset($_REQUEST['test'])){
  }
  if(trim($datos_estilo[0]->h1_estilo)!='')
    $texto_h1=str_replace('XXXX', $familia_producto, $datos_estilo[0]->h1_estilo);
  
  if(trim($datos_estilo[0]->descripcion_estilo)!='' && $datos_estilo[0]->descripcion_estilo_publico)
    $texto_descripcion=str_replace('XXXX', $familia_producto, $datos_estilo[0]->descripcion_estilo);
  
}
elseif(isset($losmas) && $losmas==1){
  if ($familia_producto=='Papel Pintado')
    $texto_h1='Selección de los Papeles Pintados más vendidos';
  elseif ($familia_producto=='Telas' || $familia_producto=='Alfombras')
    $texto_h1='Selección de las '.$familia_producto.' más vendidas';
  else
    $texto_h1='Selección de los '.$familia_producto.' más vendidos';
  
}


?>
<div class="wrapper">
  <div class="container">
    <h1 class="titulo-1-grande pt-4 pb-4 text-center justify-content-center titulo-bg-image"><?php echo $texto_h1_seccion; ?></h1>
    <?php 
    $this->load->view('frontend/migas_nuevas_small', $this->data);
    ?>
    <div class='row'>
      <?php
      /*
      if (trim($texto_descripcion)!=''){
        ?>
        <div class='col-12'>
          <div class="contenido-colapsable px-4 texto-seo"><?php echo $texto_descripcion;?></div>
          <button class="my_collapsible pl-4" aria-label="Ver más"></button>
        </div>
        <?php
      }
      */
      ?>
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12 col-sp-12">
        <div class='columna-filtros'>
          <?php 
          $this->load->view('frontend/cuerposeccion-filtros', $this->data); 
          ?>
        </div>
      </div>

      <div class="col-xl-9 col-lg-9 col-md-9 col-sm-8 col-xs-12 col-sp-12">
        <?php
        if (trim($texto_descripcion)!=''){
          ?>
          <div class='col-12'>
            <div class="contenido-colapsable texto-seo"><?php echo $texto_descripcion;?></div>
            <button class="my_collapsible " aria-label="Ver más"></button>
          </div>
          <?php
        }
        ?>
        <div class='container'>
          <?php
          if(count($all)!=0){
            if(!isset($productos_outlet))
              $productos_outlet=0;
            ?>
            <div class='row listado-productos mt-0'>
              <input type='hidden' id='llamada_request_next' 
                data-funcion="get_next_categoria_seo_filtros"  
                data-id_categoria_seo="<?php echo $categoria_seo->nueva_categoria_id;?>" 
                data-tipo_producto="<?php echo $categ;?>" 
                data-outlet="<?php echo $productos_outlet;?>" 
                data-orden="<?php echo $orden_seleccionado;?>"  
                data-estilo="<?php echo isset($_REQUEST['estilo']) ? $_REQUEST['estilo'] : "";?>"  
                data-color="<?php echo isset($_REQUEST['color']) ? $_REQUEST['color'] : "";?>"  
                data-marca="<?php echo isset($_REQUEST['marca']) ? $_REQUEST['marca'] : "";?>"  
              />
              <?php
              $this->load->view('frontend/articulo_cards', $this->data); 
                //echo "    <ul class='blocks-3 prefichas' itemscope itemtype='http://schema.org/ItemList'> \n";
                //$this->load->view('frontend/prefichas', $this->data); 
                //echo "    </ul> \n";
              ?>
            </div>
            <?php
            echo '<div class="col-12"><button onclick="requestnext()" class="boton-opciones">Ver más</button></div>';
          }
          else{
            $this->load->view('frontend/sinresultados', $this->data); 
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$this->data['img_modal']='';
$this->load->view('frontend/articulo_modal_carrito', $this->data);
/*
<div id="dialog-confirm" title="Se ha añadido el artículo">
  <p><span></span></p>
</div>
*/
?>

<script>
  var botones_collapse = document.getElementsByClassName("my_collapsible");
  var i;
  for (i = 0; i < botones_collapse.length; i++) {
    var content = botones_collapse[i].previousElementSibling;
    if(content.scrollHeight<50)
      botones_collapse[i].style.display = "none";
  }
  
  for (i = 0; i < botones_collapse.length; i++) {
    botones_collapse[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var content = this.previousElementSibling;
      if (content.style.maxHeight){
        content.style.maxHeight = null;
      } else {
        content.style.maxHeight = content.scrollHeight + "px";
      } 
    });
  }
  var filtros_marcas = document.getElementsByClassName("my_collapsible_filtros");
  var i;
  for (i = 0; i < filtros_marcas.length; i++) {
    var content = filtros_marcas[i].previousElementSibling;
    if(content.scrollHeight<50)
      filtros_marcas[i].style.display = "none";
  }
</script>
<script>
  document.querySelectorAll('.columna-filtros .grupo-filtro').forEach(function(header) {
    if (header.dataset.acordeonFiltro === '1') return;
    header.dataset.acordeonFiltro = '1';

    var siblings = [], next = header.nextElementSibling;
    while (next && !next.classList.contains('grupo-filtro')) {
      siblings.push(next);
      next = next.nextElementSibling;
    }
    if (!siblings.length) return;

    var body = document.createElement('div');
    body.className = 'filtro-acordeon-body';
    header.parentNode.insertBefore(body, siblings[0]);
    siblings.forEach(function(s) { body.appendChild(s); });

    var uls = body.querySelectorAll('ul');
    var mainUl = uls[uls.length - 1];
    if (mainUl) {
      var items = mainUl.querySelectorAll('li');
      if (items.length > 8) {
        mainUl.style.maxHeight = '220px';
        mainUl.style.overflowY = 'auto';
        mainUl.style.paddingRight = '6px';
      }
    }

    body.style.maxHeight = '0';
    header.classList.add('filtro-cerrado');
    header.addEventListener('click', function() {
      var cerrado = header.classList.toggle('filtro-cerrado');
      body.style.maxHeight = cerrado ? '0' : body.scrollHeight + 'px';
    });
  });
</script>
