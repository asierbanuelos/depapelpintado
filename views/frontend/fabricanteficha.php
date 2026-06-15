<!--prog Maider-->
<div class="units-row units-padding">
  <div class="unit-centered unit-80 cuerpocentral blancobg sombra">
    <?php
    $this->load->view('frontend/migas', $this->data);
    if($fab==null)
      echo "Fabricante no encontrado";
    else{
    ?>
      <div class="units-row">
        <div class="unit-50">
          <h1 class="fuentecorporativa magenta-secundario">
            <?php
            if (isset($familia_producto) && trim($familia_producto)!='')
              echo $familia_producto.' ';
            echo $fab->cat_name;
            ?>
          </h1>
          <p>
            <img src="<?=$includes_dir?>images/logos/<?=$fab->cat_id?>.jpg" width="160" height="80" alt="Fabricante de papel pintado: <?=$fab->cat_name;?>" loading='lazy' />
          </p>
          <p><?=$fab->cat_text;?></p>
        </div>

        <div class="unit-50" style="min-height:400px">
          <?php
          if(count($col)>1){
            ?>
              <div class="slider-wrapper theme-default nuevo-slider">
                <div class="slideshow-container " style="max-height:310px;overflow: hidden;">
                  <?php
                  $kont_slide=0;
                  foreach($col as $c){
                    if($c['ccats']!='null'){
                      $kont_slide++;
                      $txt_alt=$c['coleccion_name'];
                      //if ($key->titulo!='NUEVA')
                      //    $txt_alt=$key->titulo.'-'.$kont_slide;
                      ?>
                      <div class="mySlides fade">
                          <?php /*<div class="numbertext">1 / 3</div>*/ ?>
                          <img src="<?=$includes_dir?><?=  str_replace("../", "", $c['col_ambimg']);?>" style="width:100%" alt="<?php echo $txt_alt; ?>"  onmouseover="pauseCarousel();" onmouseout="startCarousel();" />
                          <?php /*<div class="text">Caption Text</div>>*/ ?>
                      </div>
                      <?php
                    }
                  }
                  ?>
                  <!-- Next and previous buttons -->
                  <div class="prev" onclick="plusSlides(-1)" onmouseover="pauseCarousel();" onmouseout="startCarousel()" >&#10094;</div>
                  <div class="next" onclick="plusSlides(1)" onmouseover="pauseCarousel();" onmouseout="startCarousel()" >&#10095;</div>
                </div>
                <br>
                <div style="text-align:center">
                    <?php
                    for($i=1; $i<=$kont_slide; $i++){
                        echo '<span class="dot" onclick="currentSlide('.$i.')" onmouseover="pauseCarousel();" onmouseout="startCarousel()" ></span>';
                    } 
                    ?>
                </div>    
              </div>
            <?php
          }
          else{
            foreach($col as $c){?>
              <div style="max-height:340px; overflow:hidden">
                <img style="width:100%" src="<?=$includes_dir?><?=  str_replace("../", "", $c['col_ambimg']);?>"/>
              </div>
            <?}
          }?>
        </div>
      </div>
<div class="units-row units-padding">
<div class="unit-100">
<h2>
  <?php
  if (isset($familia_producto) && trim($familia_producto)!='')
    echo 'Colecciones de '.$familia_producto.' '.$fab->cat_name;
  else
    echo 'Colecciones de '.$fab->cat_name;
  ?>
</h2> 
</div>
</div>
<div class="units-row units-padding">
<div class="unit-100">
<ul class="blocks-4">
  <?php
  $count=0;
  foreach($col as $c){
    if($c['ccats']!='null'){?>
      <li <?if($count%4==0) echo 'style="clear:both"; ';$count++;?>>
        <div class="preficha">
          <?php if(isset($c['novedad_bool']) && $c['novedad_bool']==1):?>
            <div style="position:absolute;top:0px;right:0;z-index: 1000;width:90px"><img class="novedad" alt="novedad" src="<?=$includes_dir?>images/novedad_der.png"></div>      
          <?php endif;?>
          <?if($c['cdisc']==1){?>
            <div style="position:absolute;right:0px;top:0px;z-index: 1000;width:75px"><img src="<?=$includes_dir?>images/descuento.png"></div>
            <div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:25px;font-size: 10px;">Descuento</div>
          <?}?>
          <a href="<?=urlenc($fab->cat_name);?>/<?=$c['coleccion_id']?>/<?=urlenc($c['coleccion_name']);?>">
            <img data-id="<?=$c['coleccion_id']?>" class="colecc" alt="" src="<?php echo $includes_dir.  str_replace("../", "", $c['col_img']); ?>th.jpg"/></span>
          </a>
        </div>
        <br/>     
        <a href="<?=urlenc($fab->cat_name);?>/<?=$c['coleccion_id']?>/<?=urlenc($c['coleccion_name']);?>">
          <span><strong><?=$c['coleccion_name'];?></strong></span>
        </a>
      </li>
    <?php
    }
  }
  ?>

</ul>
</div>
<div class="unit-100"><p><?=$fab->cat_text2;?></p></div>

</div>
<?}?>
</div><!-- fin cuerpo central-->
</div> <!--fin contenedor cuerpo central units row-->
<?if(count($col)>1){?>
  <script>
  var slideIndex = 0;
  var t;
  var dots;
  var timedelay = 3000;

  //showSlides(slideIndex);
  slide_carousel();
  function plusSlides(n) {
    showSlides(slideIndex += n);
  }
  function currentSlide(n) {
    showSlides(slideIndex = n);
  }
  function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      if (n==undefined){n = ++slideIndex}
      if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " active";
  }
  function slide_carousel() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    t= setTimeout(slide_carousel, timedelay); // Change image every 2 seconds
  }
  function pauseCarousel() {
      clearTimeout(t);
  }
  function startCarousel() {
      t = setTimeout(slide_carousel, timedelay);
  }
</script><?}?>