<? 
?>
<div >
  
   
  
</div>
<div class="units-row units-padding">
  <div class="unit-centered unit-80 cuerpocentral blancobg">
<? 
$this->load->view('frontend/migas', $this->data);

?>
    <?if ($this->input->post('search')==false){?>
    <? //if ($categ <= 2 || $categ == 5) {
 
    if ($categ <= 4 && ($this->uri->segment(3)!="economicos" && $this->uri->segment(3)!="los_mas_vendidos")) {
    	 if(!isset($cole)){?>
    	<div class="units-row nomargin"><div class="unit-100 breadcrumbs nomargin"><div class='old-h3'>Puede elegir por:</div></div></div>
      <?
      
      ?>
      
      <nav>
        <ul class="menu-secundario separacion-barravertical">
      <? //ESTO ES EL BOTON DE ECONOMICOS MUEVELO POR DONDE QUIERAS
      if ( $categ != 5) {
        ?>

  
          <li class="primario"><?= anchor($this->uri->segment(1) . "/" . $this->uri->segment(2) . "/marcas", "MARCAS"); ?></li>
          <li class="primario">ESTILOS
            <table class="enlaceestilos blancobg">
              <tr class="tituloestilos">
  <? if ($categ <= 0) { ?> <td>Estilos Basicos</td><td colspan="4" class="text-centered">Estilos Avanzados</td><? } ?>
              </tr>
              <tr>
                <td class="basicos">
  <?
  $count = 0;
  $first = 0;
  $total = count($estilo);
  foreach ($estilo as $value) {
    if ($total>10) {

      if ($categ <= 0 && $first == 0 && $value->principal == 0) {
        ?>
                      </td>
                   <?if ($categ == 0){?><td class="avanzados"><?}else{?><td class="basicos"><?}?>
        <?
        $first = $count;
      }
      if ($count == ceil($first + (($total - $first) / 3))) {
        ?>
                      </td>

                      <?if ($categ == 0){?><td class="avanzados"><?}else{?><td class="basicos"><?}?>
                      <? }
                      if ($count == ceil($first + (($total - $first) / 3) * 2)) {
                        ?>
                      </td>

                      <?if ($categ == 0){?><td class="avanzados"><?}else{?><td class="basicos"><?}?>

                        <?
                      }$count++;
                    }
                    ?>

                    <?
                    $don = $donde;
                    $don['estilo'] = $value->estilo_name;
                    ksort($don);
                    ?>
                          <div><a href="<?= base_url() ?>tienda/<?= $this->uri->segment(2) ?>/<?if ($this->uri->segment(3)=="economicos") echo "economicos/";  ?><?= urlenc($this->uri->assoc_to_uri($don)) ?>" /><?= $value->estilo_name ?></a></div>


  <? } ?>
                </td></tr></table>
          </li>
          <li class="primario">COLORES
            <table class="enlaceestilos blancobg basicos">
              <tr><td>
                  <?
                  $count = 0;
                  $first = 0;
                  $total = count($gama);

                  foreach ($gama as $value) {

                    if ($count == 0) {
                      ?>

                    </td><td>
                      <? }if ($count == ceil($total / 3)) {
                      ?>
                    </td><td>
                      <? $first = $count;
                    }if ($count == ceil($total / 3) * 2) {
                      ?>
                    </td><td>
                      <?
                    }$count++;
                    ?>

                    <?
                    $don = $donde;
                    $don['color'] = $value->gama_name;
                    ksort($don);
                    ?>
                        <div><a href="<?= base_url() ?>tienda/<?= $this->uri->segment(2) ?>/<?if ($this->uri->segment(3)=="economicos") echo "economicos/";  ?><?= urlenc($this->uri->assoc_to_uri($don)) ?>"  /><?= $value->gama_name ?></a></div>
                     <!--<input id="col<?= $value->gama_id ?>" type="checkbox" name="gama" value="<?= $value->gama_id ?>"/>
                     <label title="<?= mb_strtolower($value->gama_name, 'UTF-8') ?>"  for="col<?= $value->gama_id ?>"><span style="background:<?= (strpos($value->rgb, '#') === false) ? 'url(\'' . $includes_dir . 'images/colores.jpg\') 0 ' . (-($value->rgb * 19) + 20) . 'px' : $value->rgb ?>"></span> <?= mb_strtolower($value->gama_name, 'UTF-8') ?></label>-->

  <? } ?>
                </td></tr></table>
          </li>
          <? } //FIN  ECONOMICOS ?>
          <li class="primario"><?= anchor($this->uri->segment(1) . "/" . $this->uri->segment(2) . "/los_mas_vendidos", "LOS MÁS VENDIDOS"); ?></li>
          <?php 
          if(count($all)!=0){
            ?>
            <li class="primario" style="float:right">
              <?
              $don=array();
              if(isset($donde))
                $don = $donde;

              $don['orden'] = 0;
              ksort($don);
              $esecon=($this->uri->segment(3)=="economicos")?"economicos/":""
              ?>
              <select onchange="self.location=this.options[this.selectedIndex].value;">
                <option <?=(!isset($donde['orden']) || $donde['orden']==0)?'selected':""?> value="<?=base_url()."tienda/".$this->uri->segment(2)."/".$esecon.$this->uri->assoc_to_uri($don)?>">--Ordenar Por--</option>
                <?$don['orden'] = 1;?>
                <option <?=(isset($donde['orden']) && $donde['orden']==1)?'selected':""?> value="<?=base_url()."tienda/".$this->uri->segment(2)."/".$esecon.$this->uri->assoc_to_uri($don)?>"> Precio Ascendente</option>
                <?$don['orden'] = 2;?>
                <option <?=(isset($donde['orden']) && $donde['orden']==2)?'selected':""?> value="<?=base_url()."tienda/".$this->uri->segment(2)."/".$esecon.$this->uri->assoc_to_uri($don)?>"> Precio Descendente</option>
              </select>
            </li>
            <?php 
          } 
          ?>
        </ul>
        
      </nav>
      
    <? }} else if($categ==3 || $categ==4){ //MSG de próximamente?>
        
      <?}}?>
    <?php

    $texto_h1='';
    $texto_descripcion='';
    if (isset($datos_coleccion)){
      $texto_h1='Colección '.$datos_coleccion->coleccion_name.' de '.$familia_producto.' '.$datos_coleccion->cat_name;
      if ($datos_coleccion->col_text_publico)
        $texto_descripcion=$datos_coleccion->col_text;
    }
    elseif (isset($datos_estilo[0])){
      if (isset($_GET['test'])){
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
    <div class="units-row">
      <?php
      $nomargin='nomargin';
      if (trim($texto_descripcion)=='')
        $nomargin='';

      if (trim($texto_h1)!=''){
        ?>
        <div class="unit-100"><h1 class="fuentecorporativa magenta-secundario <?php echo $nomargin; ?>"><?php echo $texto_h1; ?></h1></div>

        <?php
      }

      //if (isset($_GET['test'])){
      if (trim($texto_descripcion)!=''){
        ?>
        <div class="unit-100">
          <div class="contenido-colapsable"><?php echo $texto_descripcion;?></div>
          <button class="my_collapsible" aria-label="Ver más"></button>
        </div>
        <?php
      }
      //}
      ?>
    </div>
    <?php
    //}
    /*
    if (isset($familia_producto) && trim($familia_producto)!=''){
    }
    */

    if(count($all)!=0){
      echo "<ul class='blocks-4 prefichas' itemscope itemtype='http://schema.org/ItemList'> \n";
      $this->load->view('frontend/prefichas', $this->data); 
      echo "</ul> \n";
    }
    else{
      $this->load->view('frontend/sinresultados', $this->data); 
    }
    ?>


    <button onclick="requestnext()" >Ver más</button>
  </div>
  <div style="position:fixed;bottom:70px;right:30px;cursor:pointer;display:none;" id="subir"><i style="font-size:50px" class="fa fa-arrow-circle-up "></i></div>
</div>
<div id="dialog-confirm" title="Se ha añadido el artículo">
<p><span></span></p>
</div>
<script>
  document.getElementById('inicio1').scrollIntoView();
  var preview="";
 var nombreart="";
 var precioart="";
      $(document).ready(function() {
        $(".primario").hover(function(e) {
          e.stopPropagation();
          var t = $(this);
          $(".enlaceestilos").each(function() {
            if ($(this).parents()[0] == t[0])
              $(this).toggle();
            else
              $(this).hide();
          });
        },function(){
          $(".enlaceestilos").hide();
        });
        $(".primario").click(function(e) {
          e.stopPropagation();
          var t = $(this);
          $(".enlaceestilos").each(function() {
            if ($(this).parents()[0] == t[0])
              $(this).toggle();
            else
              $(this).hide();
          });
        });
        $("body").click(function() {
          $(".enlaceestilos").hide();
        });
        
        $(window).scroll(function(){
          if ($(this).scrollTop() > 100) {
            $('#subir').fadeIn();
          } else {
            $('#subir').fadeOut();
          }
        });
  
 
 $('#subir').click(function(){
    $('html, body').animate({scrollTop : 0},800);
    return false;
  });
        $(".addformitem").click(function(event) {
          event.preventDefault();
          $("#overlay").fadeOut();
          $.ajax({
            url: "<?php echo $base_url; ?>tienda/insert_database_item_to_cart/" + $("#itemid").val(),
            type: 'POST',
            data: {'qty': $("#unidades").val(), 'p_ancho': $("#p_ancho").val(), 'p_alto': $("#p_alto").val(), 'ud': $("#ud").val()},
            success: function(data)
            {
              ajax_update_mini_cart(data);
            }
          });
        });
        $(".addformsample").click(function(event) {
          event.preventDefault();
          $("#overlay").fadeOut();
          $.ajax({
            url: "<?php echo $base_url; ?>tienda/insert_database_item_to_cart/" + $("#itemid").val(),
            type: 'POST',
            data: {'sample': 1},
            success: function(data)
            {
              ajax_update_mini_cart(data);
            }
          });
        });
        $(".prefichas").on('click', '.add_item_via_ajax_link', function(event) {
          event.preventDefault();
          preview=$(this).attr('data-img');
          nombreart=$(this).attr('data-fab')+"-"+$(this).attr('data-col')+"-"+$(this).attr('data-ref');
          precioart=$(this).attr('data-precio');
          $.ajax({
            url: $(this).attr('href'),
            type: 'POST',
            data: {'fab': $(this).attr('data-fab'),'col':$(this).attr('data-col')},
            success: function(data)
            {
              ajax_update_mini_cart(data);
            }
          });
        });
        $(function() {
          $('select[name^="shipping"], input[name^="shipping"]').live('change', function() {
            var data = new Object();
            $('select[name^="shipping"], input[name^="shipping"]').each(function() {
              data[$(this).attr('name')] = $(this).val();
            });
            data['update'] = true;
            data['csrf_test_name'] = $('input[name="csrf_test_name"]').val();
            $('#cart_content').load('<?php echo current_url(); ?> #ajax_content', data);
          });
        });

      });
      function ajax_update_mini_cart(data) {
        var ajax_mini_cart = $(data).find('.ulcarro>.status');
        var importe =$(data).find('.precio-minicarro').html();
        $('.ulcarro>.status').replaceWith(ajax_mini_cart);
        $('.precio-minicarro').replaceWith(importe);
        $("#dialog-confirm span").html('<img style="width:60px; margin-right:10px;" src="'+preview+'"/> '+nombreart+" : "+ precioart + " €");
         $( "#dialog-confirm" ).dialog({
resizable: false,
height:240,
width:500,
modal: true,
buttons: {
"Continuar en la tienda": function() {
$( this ).dialog( "close" );
},
"Ir al carro": function() {
$( this ).dialog( "close" );
window.location="http://www.depapelpintado.es/tienda/carrito";
}
}
});
        //confirm("El carro se ha actualizado.");

      }
      var isRunning = false;
      var currentpage = 1;
      var cole = "<?= (isset($cole)) ? $cole : ""; ?>";
      var search = "<?= ($this->input->post("search")) ? $this->input->post("search") : "" ?>";
      var requesting = false;
      var econ =<?= ($this->uri->segment(3)=="economicos") ? "true" : "false" ?>;
      var tops =<?= (isset($donde['los_mas_vendidos'])) ? "true" : "false" ?>;
      function requestnext() {
        return;
        if (!requesting && cole=="") {
          requesting = true;
          //var fab = $('.fabricantes input:checked').map(function(i, n) { return $(n).val(); }).get().join();
          var est = "<?= (isset($donden['estilo'])) ? $donden['estilo'] : "" ?>";
          var col = "<?= (isset($donden['color'])) ? $donden['color'] : "" ?>";
          var fab = "<?= (isset($donden['marca'])) ? $donden['marca'] : "" ?>";
          var ord = "<?= (isset($donde['orden'])) ? $donde['orden'] : "" ?>";
          $.ajax({
            url: "<?= $base_url ?>tienda/get_next/0/0/0/" + currentpage,
            dataType: 'html',
            type: 'POST',
            data: {'est': est, 'col': col, 'fab': fab, 'ord': ord, 'categ': categ, 'econ': ((econ) ? 1 : 0), 'top': ((tops) ? 1 : 0), 'search': search},
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
<script>
  var botones_collapse = document.getElementsByClassName("my_collapsible");
  var i;
  for (i = 0; i < botones_collapse.length; i++) {
    var content = botones_collapse[i].previousElementSibling;
    if(content.scrollHeight<100)
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
</script>