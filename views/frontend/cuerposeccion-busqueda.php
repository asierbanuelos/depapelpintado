<? 
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
    <h1 class="titulo-1-grande pt-4 pb-4 text-center fuentecorporativa magenta-secundario"><?php echo $texto_h1_seccion; ?></h1>
    <div class='row'>
      <?php
      if (trim($texto_descripcion)!=''){
        ?>
        <div class='col-12'>
          <div class="contenido-colapsable px-4 texto-seo"><?php echo $texto_descripcion;?></div>
          <button class="my_collapsible pl-4" aria-label="Ver más"></button>
        </div>
        <?php
      }
      ?>
      <div class="col-12">
        <div class='container'>
          <?php
          if(isset($all) && count($all)!=0){
          ?>
            <div class='row listado-productos'>
              <input type='hidden' id='llamada_request_next' 
                data-funcion="get_next_listado_filtros"  
                data-id_categoria_seo="0" 
                data-tipo_producto="<?php echo $categ;?>" 
                data-orden="<?php echo $orden_seleccionado;?>"  
                data-estilo="<?php echo isset($_REQUEST['estilo']) ? $_REQUEST['estilo'] : "";?>"  
                data-color="<?php echo isset($_REQUEST['color']) ? $_REQUEST['color'] : "";?>"  
                data-marca="<?php echo isset($_REQUEST['marca']) ? $_REQUEST['marca'] : "";?>"  
              />
              <?php
              $this->data['no_hay_filtros']=true;
              $this->load->view('frontend/articulo_cards', $this->data); 
                //echo "    <ul class='blocks-3 prefichas' itemscope itemtype='http://schema.org/ItemList'> \n";
                //$this->load->view('frontend/prefichas', $this->data); 
                //echo "    </ul> \n";
              ?>
            </div>
            <?php
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
/*
?>

<script>
      function requestnext() {
        if (!requesting && cole=="") {
          requesting = true;
          //var fab = $('.fabricantes input:checked').map(function(i, n) { return $(n).val(); }).get().join();
          var id_nueva_categoria_seo = <?php echo $id_categoria_seo; ?>;
          var tipo_producto = <?php echo $categ; ?>;
          var id_coleccion = <?php echo $idcoleccion; ?>;
          var ord = "<?php echo $orden_seleccionado; ?>";
          var est = "<?= (isset($_REQUEST['estilo'])) ? $_REQUEST['estilo'] : "" ?>";
          var col = "<?= (isset($_REQUEST['color'])) ? $_REQUEST['color'] : "" ?>";
          var fab = "<?= (isset($_REQUEST['marca'])) ? $_REQUEST['marca'] : "" ?>";
          //alert(id_nueva_categoria_seo);
          //alert(est);
          //alert(col);
          //alert(fab);
          $.ajax({
            url: "<?= $base_url ?>tienda/<?php echo  $enlace_requestnext; ?>/" + currentpage,
            dataType: 'html',
            type: 'POST',
            //data: {'id_nueva_categoria_seo': id_nueva_categoria_seo, 'est': est, 'col': col, 'fab': fab, 'ord': ord, 'categ': categ, 'econ': ((econ) ? 1 : 0), 'top': ((tops) ? 1 : 0), 'search': search},
            data: {'id_nueva_categoria_seo': id_nueva_categoria_seo, 'estilo': est, 'color': col, 'marca': fab, 'ord': ord, 'tipo_producto': tipo_producto, 'id_coleccion': id_coleccion},
            success: function(html)
            {
              $(".prefichas").append(html);
              currentpage++;
              requesting = false;
            },
            error: function(data) {
              requesting = false;
            }
          });
        }
      }
</script>
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
  /*
  */
</script>