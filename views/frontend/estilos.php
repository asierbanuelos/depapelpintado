   <div class="units-row blancobg">
 <div class="unit-centered unit-80 cuerpocentral">
<ul class="blocks-4">
 <? 
 if($categ==0) echo '<div style="clear:both;">Estilos Básicos</div>'; //si estamos en papeles hacemos distincion de tipos de estilos
   $currenttipo=1;
 foreach($estilo as $key){
   if($categ==0 && $key->principal!=$currenttipo)echo '<div style="clear:both;">Estilos Avanzados</div>'; //si estamos en papeles hacemos distincion de tipos de estilos
   ?>
  
  <li class="estilos"> 
    <?=$key->estilo_id?>
    <?=$key->estilo_name?>
    <?//=$key->estilo_img//No esta metido en la base de datos?>
  </li>
 <?
 $currenttipo=$key->principal;
 }?>  
  
  </ul>
</div>
</div>
