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
          <h1 class="fuentecorporativa magenta-secundario"><?=$fab->cat_name;?></h1>
          <p>
            <img src="<?=$includes_dir?>images/logos/<?=$fab->cat_id?>.jpg" width="160" height="80" alt="Fabricante de papel pintado: <?=$fab->cat_name;?>" loading='lazy' />
          </p>
          <p><?=$fab->cat_text;?></p>
        </div>

        <div class="unit-50" style="min-height:400px">
          <?php
          if(count($col)>1){
            ?>
              <div class="slider-wrapper theme-default">
                <div id="slider" class="nivoSlider"  style="max-height:310px">
                  <?php
                  foreach($col as $c){
                    ?>
                    <img src="<?=$includes_dir?><?=  str_replace("../", "", $c['col_ambimg']);?>"/>
                    <?php
                  }
                  ?>
                </div>
              </div>
            <?php
          }
          else{
            ?>
          <?foreach($col as $c){?>
          <div style="max-height:340px; overflow:hidden">
            <img style="width:100%" src="<?=$includes_dir?><?=  str_replace("../", "", $c['col_ambimg']);?>"/>
          </div>
          <?}?>
          <?}?>
          </div>
</div>
<div class="units-row units-padding">
<div class="unit-100">
<h3>Colecciones</h3> 
</div>
</div>
<div class="units-row units-padding">
<div class="unit-100">
<ul class="blocks-4">
<?$count=0;
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

<img data-id="<?=$c['coleccion_id']?>" class="colecc" alt="" src="<?php echo $includes_dir.  str_replace("../", "", $c['col_img']); ?>th.jpg"/></span></div>
<br/><span><strong><?=$c['coleccion_name'];?></strong></span></a>

</li>
<?}}?>

</ul>
</div>
<div class="unit-100"><p><?=$fab->cat_text2;?></p></div>

</div>
<?}?>
</div><!-- fin cuerpo central-->
</div> <!--fin contenedor cuerpo central units row-->
<?if(count($col)>1){?>
<script>
$(window).load(function() {
$('#slider').nivoSlider({effect: 'fade',animSpeed: 1});
});
</script>
<?}?>