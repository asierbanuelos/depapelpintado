<div class="wrapper">
  <h1 class="titulo-1-grande pt-4 pb-4 text-center justify-content-center titulo-bg-image"><?php echo $texto_h1_seccion; ?></h1>
  <div class="container">
    <?php 
    $this->load->view('frontend/migas_nuevas_small', $this->data);
    ?>
    <div class='row'>
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-xs-12 col-sp-12">
        <?php 
        echo "  <div class='columna-filtros m-0'> \n";
        foreach ($menu_categorias_seo as $familia_categoria_txt=>$a_categorias){
          echo "<ul class='pl-4 filtros-solo-estilos'> \n";
          foreach ($a_categorias as $idcategoria=>$datos_categoria){
            switch ($categ) {
                case 0: $nombre_negrita=str_replace('Papel pintado ', 'Papel pintado <strong>', $datos_categoria['nombre']).'</strong>';
                        break;
                case 1: $nombre_negrita=str_replace('Mural ', 'Mural <strong>', $datos_categoria['nombre']).'</strong>';
                        $nombre_negrita=str_replace('Murales ', 'Murales <strong>', $nombre_negrita).'</strong>';
                        break;
                case 2: $nombre_negrita=str_replace('Papel pintado ', 'Papel pintado <strong>', $datos_categoria['nombre']).'</strong>';
                        break;
                case 3: $nombre_negrita=str_replace('Telas ', 'Telas <strong>', $datos_categoria['nombre']).'</strong>';
                        break;
                case 4: $nombre_negrita=str_replace('Alfombras ', 'Alfombras <strong>', $datos_categoria['nombre']).'</strong>';
                        break;
                default: break;
            }      
            echo "  <li class=''><a href='{$datos_categoria['url']}' title='{$datos_categoria['nombre']}'>$nombre_negrita</a></li> \n";
          }
          echo "</ul> \n";
          //echo "    <button class='pl-4 my_collapsible my_collapsible_movil' aria-label='Ver más'></button>";
        }
        echo "  </div> \n";
        ?>
      </div>
      <div class="col-xl-9 col-lg-9 col-md-9 col-sm-8 col-xs-12 col-sp-12 mt-3">
        <div class='container'>
          <?php 
          foreach ($menu_categorias_seo as $familia_categoria_txt=>$a_categorias){
            //if ($idnueva_categoria_familia==0)
            //  echo '<h2 class="clear">'.$familia_categoria_txt.'</h2>';
            echo "<div class='row listado prefichas prefichas prefichas-nuevas'> \n";
            foreach ($a_categorias as $idcategoria=>$datos_categoria){
              ?>
              <div class="subcategory-block col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 col-sp-12">
                <div class="preficha subcategory-image">
                  <a href="<?php echo $datos_categoria['url'];?>" title="<?php echo $datos_categoria['nombre']; ?>" >
                    <img class="img-fluid" src="/includes/<?php echo str_replace('../', '', $datos_categoria['img'].'th.jpg'); ?>" alt="<?php echo $datos_categoria['nombre']; ?>" title='<?php echo $datos_categoria['nombre']; ?>' />
                  </a>
                </div>
                <div class="subcategory-meta tit-centrado-imagen text-center">
                  <h2>
                    <a href="<?php echo $datos_categoria['url'];?>" title="<?php echo $datos_categoria['nombre']; ?>" >
                      <?php echo $datos_categoria['nombre']; ?>
                    </a>
                  </h2>
                  <div class="subcategory-description"></div>
                </div>
              </div>
              <?php 
            }
            echo "</div> \n";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

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
</script>

