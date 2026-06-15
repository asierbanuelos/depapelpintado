
<div class="fabdiv" style="padding:20px;display:block;min-height: 500px;">
  <div><h1><img src="<?=$includes_dir?>images/logos/<?=$fab->cat_id?>.jpg" width="160" height="80" alt="Fabricante de papel pintado: <?=$fab->cat_name;?>"/>
    </h1><span id="catname" style="display: none;"><?=$fab->cat_name;?></span></div>
  <div class="imgfab">
    <div id="slidefab" style="overflow: hidden; display: block; margin-bottom: 5px; margin-left:1px">
      <? $cont=0;
      foreach ($col as $c){?>
      <img alt="" src="<?php echo $includes_dir.(str_replace("../", "", $c['col_ambimg']))."med.jpg"; ?>" class="slidesjs-slide" slidesjs-index="0"/>
      <? $cont++;
      }?>
    </div>
  </div>
  <div class="textfab">
  
  <div>
    <?=$fab->cat_text;?>
  </div>
  </div>
  <div class="coldiv">
    <h2>Colecciones</h2>
    
    <?foreach($col as $c){?>
    <div class="itm col two t-two m-three" style="height:200px; display:block;"><span  style="background-color: #000;display:block;width:158px;height:158px">
        <img data-id="<?=$c['coleccion_id']?>" class="colecc" width="158" height="158" alt="" src="<?php echo $includes_dir.  str_replace("../", "", $c['col_img']); ?>th.jpg"/></span>
    <span><strong><?=$c['coleccion_name'];?></strong><br/></span>
  
  </div>
    <?}?><div class="clear"></div>
  </div>
  <div class="aire"></div>
  
</div>
  <?


?>
