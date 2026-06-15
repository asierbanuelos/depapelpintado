<h2> 
	<?php
	$cat=$datos_item_ko['item_tipo'];
	if($cat==0) echo "Otros papeles pintados ";
	if($cat==1) echo "Otros murales ";
	if($cat==2) echo "Otros revestimientos ";
	if($cat==3) echo "Otras telas ";
	if($cat==4) echo "Otras Alfombras ";
	?>
	de la misma colección
</h2>
<div style="width:100%;position:relative">
<span class="prev2" style="cursor:pointer;position:relative;top:50px;left:10px;z-index: 100000;float:left;"><i class="fa fa-arrow-circle-left fa-3x"></i></span> 
  <span class="next2" style="cursor:pointer;position:relative;top:50px;right:10px;z-index: 100000;float:right"><i class="fa fa-arrow-circle-right fa-3x"></i></span>
  </div>
<div style="overflow: hidden; width: 100%; height:130px;position:relative;top:-40px" id="slida" class="prefichas">
   
  
<div id="slidec" style="left:0px;position:relative;width:<?=(144*count($otro))?>px">
  
<?
$count=0;
$coleccion_name_aux=str_replace('%', '', $datos_item_ko['coleccion_name']);

foreach($otro as $key){?>

  <span class="ccc" style="width:130px; margin:7px;display:inline-block;float:left;">

    <?//Datos a mostrar?>
    <div class="preficha <?php if($key['item_tipo']==0) echo "prefpapel";?>" style="overflow:hidden">
        <a href="<?=$base_url?>tienda/articulo/<?=($categ!=5)?  urlenc($key['cat_name']):"Herramientas"?>/<?=($categ!=5)? urlenc($coleccion_name_aux):urlenc(preg_replace('/[^A-Za-z0-9\-]/', ' ', $key['item_name'])) //nombre de la coleccion?>/id/<?=$key['item_id'] //id del item?>">
          
<?if(false){?>
<div style="position:absolute;left:0px;bottom:35px;z-index: 1000;width:120px"><img src="<?=$includes_dir?>images/etiqueta-sin-iva.png" alt='sin IVA' title='sin IVA' /></div>
<?}?>
       
        
 
            
            
	<?
	if(isset($key['disc_resumen']) && $key['disc_resumen']!="" && $key['disc_status']==1 && $totalcarro>=$key['disc_value_required']){
	?>
		<div style="position:absolute;right:0px;top:0px;z-index: 1000;width:75px"><img src="<?=$includes_dir?>images/descuentob.png" alt='descuento' title='descuento' /></div>
		<div style="position:absolute;right:2px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:14px;font-size: 16px;"><?=$key['disc_resumen']?></div>
	<?
	}
	if(isset($key['disc_resumen']) && $key['disc_resumen']=="" && $key['disc_status']==1 && $key['disc_method_fk']==1 && $totalcarro>=$key['disc_value_required']){
	/*
	?>
		<div style="position:absolute;right:0px;top:0px;z-index: 1000;width:132px"><img src="<?=$includes_dir?>images/descuento2.png" alt='descuento' title='descuento' /></div>
		<?
		if(false){
		?>
			<div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: right;padding-right:5px;color: #fff;font-weight: bold;padding-top:10px;font-size: 10px;">Descuento</div><div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: right;padding-right: 5px;color: #fff;font-weight: bold;padding-top:28px;font-size: 20px;"><?=  number_format($key['disc_value_discounted'])?>%</div>
		<?
		}
		else{
		?>
			<div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: right;padding-right: 5px;color: #fff;font-weight: bold;padding-top:10px;font-size: 18px;">-<?=  number_format($key['disc_value_discounted'])?>%</div>
		<?
		}
		*/
	}	
	if(isset($key['disc_resumen']) && $key['disc_resumen']==""  && $key['disc_status']==1 && $key['disc_method_fk']==2 && $totalcarro>$key['disc_value_required']){?>
		<div style="border: none;" style="position:absolute;right:0px;top:0px;z-index: 1000;width:120px"><img style="border: none;" src="<?=$includes_dir?>images/descuento2.png" alt='descuento' title='descuento' /></div>
		<?
		if(false){
		?>
			<div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: right;color: #fff;font-weight: bold;padding-top:10px;padding-right:5px;font-size: 10px;">Descuento</div><div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: right;padding-right:5px;color: #fff;font-weight: bold;padding-top:38px;font-size: 20px;">-<?=  number_format($key['disc_value_discounted'])?>€</div>
		<?
		}
		else{?>
			<div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: right;padding-right:5px;color: #fff;font-weight: bold;padding-top:10px;font-size: 18px;">-<?=  number_format($key['disc_value_discounted'])?>€</div>
		<?
		}
	}
	?>


      <?php 
      if ($key['usar_alt']==1){
        if (trim($key['imgambalt'])=='')
          $key['imgambalt']=$key['meta_title'].' - 2';
        if (trim($key['imgambtitle'])=='')
          $key['imgambtitle']=$key['meta_title'].' - 2';
	      ?>
				<img title="<?=$key['imgambtitle']?>" alt="<?=$key['imgambalt']?>" class="img-prefichas" src="<?=$includes_dir?><?=str_replace("../", "", $key['imgamb']) //imagen del articulo?>th.jpg"/> 
      <?php 
    	}else{
        if (trim($key['imgdetalt'])=='')
          $key['imgdetalt']=$key['meta_title'].' - 1';
        if (trim($key['imgdettitle'])=='')
          $key['imgdettitle']=$key['meta_title'].' - 1';
				?>
				<img title="<?=$key['imgdettitle']?>" alt="<?=$key['imgdetalt']?>" class="img-prefichas" src="<?=$includes_dir?><?=str_replace("../", "", $key['img']) //imagen del articulo?>th.jpg"/>
      <?php 
    	}
    	?></a>
    </div>
  </span>
 
 <?}?>
</div>
</div>
<script>
   $(document).ready(function(){
// $('#slida').serialScroll({
       
//		items:'span',
		//offset:-230, //when scrolling to photo, stop 230 before reaching it (from the left)
		//start:1, //as we are centering it, start at the 2nd
//		duration:5000,
		//force:true,
		//stop:true,
       
		//cycle:true, // pull back once you reach the end
		 //use this easing equation for a funny effect
		//jump: true, //click on the images to scroll to them
 //       interval:20
//	});
//    $("#slida").trigger("start");
//    $(".next2").click(function(){$("#slida").trigger("stop");$("#slida").trigger("next");});
//    $(".prev2").click(function(){$("#slida").trigger("stop");$("#slida").trigger("prev");});
$(".next2").click(function(){$("#slidec").stop().animate({left:"-="+mover(true)+"px"})});
$(".prev2").click(function(){$("#slidec").stop().animate({left:"+="+mover(false)+"px"})});
var rght=true;
function mover(a){
  if(a){
    if($("#slidec").width()+Number($("#slidec").css("left").replace("px",""))-$("#slida").width()<$("#slida").width()){
      setTimeout(function() { solo();}, 2000);
      return $("#slidec").width()-$("#slida").width()+Number($("#slidec").css("left").replace("px",""));
    }
  }
  else if(Number(-$("#slidec").css("left").replace("px",""))<=$("#slida").width()){
    setTimeout(function() { solo();}, 2000);
    return -Number($("#slidec").css("left").replace("px",""));
  }
  setTimeout(function() { solo();}, 2000);
  return $("#slida").width();
}
function solo(){
  if($("#slida").width()>=$("#slidec").width()) { return 0;}
  if(Number($("#slidec").css("left").replace("px",""))==0)rght=true;
  else if($("#slidec").width()+Number($("#slidec").css("left").replace("px",""))-$("#slida").width()==0)rght=false;
  if(rght){
    $("#slidec").stop().animate({left:"-="+(Number($("#slidec").css("left").replace("px",""))+$("#slidec").width()-$("#slida").width())},($("#slidec").width()+Number($("#slidec").css("left").replace("px",""))-$("#slida").width())*10,"linear",function(){rght=false;setTimeout(function() { solo();}, 500);});
  }
  else{
    $("#slidec").stop().animate({left:"+="+(-Number($("#slidec").css("left").replace("px","")))},-Number($("#slidec").css("left").replace("px",""))*10,"linear",function(){rght=true;setTimeout(function() { solo();}, 500);});
  }
}
solo();

   });
    
</script>