<div id="custCarousel" class="carousel slide carousel-fade" data-ride="carousel" align="center" data-interval="false">
  <!-- slides -->
  <div class="carousel-inner">
    <?php
    $kont_slide=0;
    $active='active';
    foreach($images as $key){
        $kont_slide++;
        $txt_alt='slide-'.$kont_slide;
        if ($key->titulo!='NUEVA')
            $txt_alt=$key->titulo.'-'.$kont_slide;
        // Vamos a mirar si existe la foto sin marca de agua
        $nombre_fichero = 'https://www.depapelpintado.es/includes/'.$key->ruta_img.'cl.jpg';
        
        $ch = curl_init($nombre_fichero);

        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // $retcode >= 400 -> not found, $retcode = 200, found.
        curl_close($ch);

        $webp_img='';
        if ($retcode==200){
          $key->src='/includes/'.$key->ruta_img.'cl.jpg';
          $webp_img='/includes/'.$key->ruta_img.'cl.webp';
        }
        /*
        */
        echo '<div class="carousel-item '.$active.' ">';
        echo '<picture>';
        echo '<source srcset="'.$webp_img.'" type="image/webp">';
        //echo '<source srcset="'.$key->src.'/'.$key->id.'.webp" type="image/webp">';
        //echo '<source srcset="'.$key->src.'" type="image/jpeg">';
        echo '<img src="'.$key->src.'" style="width:100%" alt="'.$txt_alt.'" height="'.$key->height.'" />';
        echo '</picture>';
        echo '</div>';
        $active='';
    }
    /*
    <div class="carousel-item active">
      <img src="https://i.imgur.com/weXVL8M.jpg" alt="Hills">
    </div>

    <div class="carousel-item">
      <img src="https://i.imgur.com/Rpxx6wU.jpg" alt="Hills">
    </div>

    <div class="carousel-item">
      <img src="https://i.imgur.com/83fandJ.jpg" alt="Hills">
    </div>

    <div class="carousel-item">
      <img src="https://i.imgur.com/JiQ9Ppv.jpg" alt="Hills">
    </div>
    */
    ?>
  </div>
  <?php
  if (count($images)>1){
    ?>
    <!-- Left right -->
    <a class="carousel-control-prev" href="#custCarousel" data-slide="prev" aria-label="Imagen anterior">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#custCarousel" data-slide="next"  aria-label="Siguiente imagen">
        <span class="carousel-control-next-icon"></span>
    </a>

    <!-- Thumbnails -->
    <ol class="carousel-indicators list-inline">
      <?php
      $kont_slide=0;
      $kont_aux=0;
      $active='active';
      $selected='selected';
      foreach($images as $key){
          $kont_slide++;
          $txt_alt='slide-'.$kont_slide;
          if ($key->titulo!='NUEVA')
              $txt_alt=$key->titulo.'-'.$kont_slide;
          
          echo '<li class="list-inline-item '.$active.'" >';
          echo  '<a id="carousel-selector-'.$kont_aux.'" class="'.$selected.'" data-slide-to="'.$kont_aux.'" data-target="#custCarousel">';
          echo    '<picture>';
          //echo '<source srcset="'.$key->src.'/'.$key->id.'.webp" type="image/webp">';
          echo      '<source srcset="'.$key->src.'" type="image/jpeg">';
          echo      '<img src="'.$key->src.'" class="img-fluid" alt="'.$txt_alt.'" height="'.$key->height.'" />';
          echo    '</picture>';
          echo  '</a>';
          echo '</li>';
          $active='';
          $selected='';
          $kont_aux++;
      }
      ?>
    </ol>
    <?php 
  }
  ?>
</div>
<style>
.carousel-inner img {width: 100%;height: 100%;}
.imagenes-producto{padding-bottom: 100px;}
#custCarousel .carousel-indicators {position: static;margin-top:20px;}
#custCarousel .carousel-indicators > li {width:100px;}
#custCarousel .carousel-indicators li img {display: block;opacity: 0.5;}
#custCarousel .carousel-indicators li.active img {opacity: 1;}
#custCarousel .carousel-indicators li:hover img {opacity: 0.75;}
.carousel-item img{width:80%;}
</style>