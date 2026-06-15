<?php $flexi_cart_library = (isset($current_url['admin_library'])) ? 'flexi_cart_admin' : 'flexi_cart'; ?>
<div style="font-family: sans-serif">
<!--  <div id="logo" class="logo"><a class="logo" href="#">de<span class="alt">Papel</span>Pintado</a></div>-->
  <div class=" content_wrap nav_bg" style="position:fixed;z-index: 50;width:100%;height:35px;">
    <div  class=" twelve m-full t-full">
      <div id="sub_nav_wrap" class="teal" >
        <ul class="sub_nav">
          <li>
            <a class="logo" href="<?$base_url?>tienda/papel_pintado">de<span class="alt">Papel</span>Pintado<span style="font-size:60%">.com</span></a>
            <div style="position:absolute;top:17px;left:100px;font-weight: bold;"><span style="color:#ddd;">by</span> <a style="position:relative;top:13px;height:40px;display:inline-block;z-index: 10" href="http://www.ekamdecoracion.com" target="_blank"><img  height="40" src="<?=$includes_dir?>images/ekam_logo.png"/></a></div>
          </li>
            <li style="width:30px;"> </li>
            <li class="seccion <?if($categ==0) echo "sombra";?>"><?=anchor("tienda/papel_pintado","Papel Pintado")?></li>
            <li class="separador">|</li>
            <li class="seccion <?if($categ==1) echo "sombra";?>"><?=anchor("tienda/fotomurales","Foto-Murales")?></li>
            <li class="separador">|</li>
            <li class="seccion <?if($categ==2) echo "sombra";?>"><?=anchor("tienda/revestimientos","Revestimientos")?></li>
            <li class="separador">|</li>
            <li class="seccion <?if($categ==3) echo "sombra";?>"><?=anchor("tienda/telas","Telas")?></li>
            <li class="separador">|</li>
            <li class="seccion <?if($categ==4) echo "sombra";?>"><?=anchor("tienda/alfombras","Alfombras")?></li>
            <li class="separador">|</li>
            <li class="seccion <?if($categ==5) echo "sombra";?>"><?=anchor("tienda/herramientas","Herramientas")?></li>
            <!--<li>Ordenar por<b> »</b> <span class="sort_items">
                &nbsp; &nbsp; <input id="sortpop" type="radio" name="sort" value="pop"><label for="sortpop">POPULARES</label> &nbsp; /
                &nbsp; <input id="sortpre" type="radio" name="sort" value="item_price"><label for="sortpre">PRECIO</label> &nbsp; /
                &nbsp; <input id="sortfab" type="radio" name="sort" value="item_cat_fk"><label for="sortfab">FABRICANTES</label> &nbsp; /
                &nbsp; <input id="sortcol" type="radio" name="sort" value="gama_id"><label for="sortcol">COLORES</label> &nbsp; /
                &nbsp; <input id="sortest" type="radio" name="sort" value="estilo_id"><label for="sortest">ESTILOS</label>
              </span></li>-->
             
            <li style="float:right;"><a href="http://www.ekamdecoracion.com/sobre-nosotros/" class="quienes" target="_blank">Quienes Somos</a></li>
            <li style="float:right;"><a href="http://www.ekamdecoracion.com/contacto/" class="quienes" target="_blank">Contacto</a></li>
          </ul>
        </div>

        </ul>
        <ul class="sub_nav down">
          <li id="mini_cart" style="float:right;width:290px;" class="css_nav_dropmenu">
<?= anchor('tienda/view_cart', '<span class="cartdisplay"><span style="position:relative;top:-8px;margin-left:10px">' . $this->$flexi_cart_library->total() . '</span><img width="25" src="' . $includes_dir . 'images/carro.png"/></span>'); ?> 
              <ul style="top:25px;">
                <li class="status">
                  <h4>Resumen Carro</h4>
                  <table>
                    <thead>
                      <tr>
                        <th width="40">Art</th>
                        <th>€</th>
                        <th width="40">Nº</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                      <?php if (!empty($mini_cart_items)) { ?>
                      <tbody>
                        <?php
                        $i = 0;
                        foreach ($mini_cart_items as $row) {
                          $i++;
                          ?>
                          <tr>
                            <td>
                              #<?php echo $i; ?>
                            </td>
                            <td>
                              <?php
                              // If an item discount exists.
                              if ($this->$flexi_cart_library->item_discount_status($row['row_id'])) {
                                // If the quantity of non discounted items is zero, strike out the standard price.
                                if ($row['non_discount_quantity'] == 0) {
                                  echo '<span class="strike">' . $row['price'] . '</span><br/>';
                                }
                                // Else, display the quantity of items that are at the standard price.
                                else {
                                  echo $row['non_discount_quantity'] . ' @ ' . $row['price'] . '<br/>';
                                }

                                // If there are discounted items, display the quantity of items that are at the discount price.
                                if ($row['discount_quantity'] > 0) {
                                  echo $row['discount_quantity'] . ' @ ' . $row['discount_price'];
                                }
                              }
                              // Else, display price as normal.
                              else {
                                echo $row['price'];
                              }
                              ?>
                            </td>
                            <td>
    <?php echo $row['quantity']; ?>
                            </td>
                            <td>
                              <?php
                              // If an item discount exists, strike out the standard item total and display the discounted item total.
                              if ($row['discount_quantity'] > 0) {
                                echo '<span class="strike">' . $row['price_total'] . '</span><br/>';
                                echo $row['discount_price_total'];
                              }
                              // Else, display item total as normal.
                              else {
                                echo $row['price_total'];
                              }
                              ?>
                            </td>
                          </tr>
  <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="3">Envío</th>
                          <td>
  <?php echo $this->$flexi_cart_library->shipping_total(); ?>
                          </td>
                        </tr>
                        <tr>
                          <th colspan="3">Impuestos</th>
                          <td>
  <?php echo $this->$flexi_cart_library->tax_total(); ?>
                          </td>
                        </tr>
                        <tr>
                          <th colspan="3">Total</th>
                          <td><?php echo $this->$flexi_cart_library->total(); ?></td>
                        </tr>
                      </tfoot>
<?php } else { ?>
                      <tbody>
                        <tr>
                          <td colspan="4" class="empty">
                            El carro está vacio...
                          </td>
                        </tr>
                      </tbody>
<?php } ?>
                  </table>
                  <div id="mini_cart_status">¡Carro Actualizado!</div>
                </li>
              </ul>
            </li>
            <form action="#" id="search">
          <li class="search" style="float:right;position:absolute;right:90px;padding: 4px;">
            <input id="searchfield" type="text" name="search" placeholder="Busqueda Avanzada..."/> <label for="searchfield" >&nbsp;</label><input style="display:none" type="submit" value="Busca"/></form>
          </li>
          <?if($categ!=5){?>
           <li style="width:240px"></li>
           <li class="ec"><a id="economicos" href="#">ECONOMICOS</a></li>
           <li class="separador">|</li>
         <li class="ma">
            <a class="fabmenu" href="<? echo $base_url . "tienda/fabricantes/".$categ;       ?>">MARCAS</a>
           <!--<ul class="fabricantes" style="width:810px">
              <?
              $count = 0;
              $first=0;
              $total=count($fab);
              foreach ($fab as $value) {
                
                if($count==0)echo'<ul style="width:200px;float:left; display:inline-block;"><div>&nbsp;</div>';
                if($count==  round($total/4)){echo '</ul><ul style="width:200px;float:left; display:inline-block;"><div>&nbsp;</div>';$first=$count;}
                if($count==  round($total/2))echo '</ul><ul style="width:200px;float:left; display:inline-block;"><div>&nbsp;</div>';
                if($count==  round($total/4)*3)echo '</ul><ul style="width:200px;float:left; display:inline-block;"><div>&nbsp;</div>';
                $count++;
                ?>
                <li class="cell" style="width:200px;">
                  <input id="fab<?= $value->cat_id ?>" type="checkbox" name="est" value="<?= $value->cat_id ?>"/>
                  <label  title="<?= mb_strtolower($value->cat_name, 'UTF-8') ?>" style="" for="fab<?= $value->cat_id ?>"><?= mb_strtolower($value->cat_name, 'UTF-8') ?></label>
                </li>
              <? } ?>
            </ul>
            </ul>-->
          </li> 
          <li class="separador">|</li>
          <li class="css_nav_dropmenu" id="es">
            <a href="#<? //php echo $base_url . "lite_library/item_link_examples";       ?>">ESTILOS▼</a>
            <ul class="estilos" style="width:700px">
              <?
              $count = 0;
              $first=0;
              $total=count($estilo);
              
              foreach ($estilo as $value) {
                
                if($count==0)echo'<ul class="estdest" style="width:200px; display:inline-block;background-color:#fff;"><b><div style="margin:3px;margin-bottom:15px;background:#4c4c4c;text-align:center;"><div style="padding:10px 0px;color:#fff;font-size:18px;">Estilos Básicos</div></div></b>';
                if($first==0 && $value->principal==0){echo '</ul><ul style="width:160px; display:inline-block;"><b><div style="margin:3px;margin-bottom:15px; margin-right:0;background:#4c4c4c;text-align:center;"><div style="padding:10px 0px;color:#fff;font-size:18px;">&nbsp;</div></div></b>';$first=$count;}
                if($count==ceil($first+(($total-$first)/3)))echo '</ul><ul style="width:160px; display:inline-block;"><b><div style="margin:3px 0;margin-bottom:15px;background:#4c4c4c;text-align:center;"><div style="padding:10px 0px;color:#fff;font-size:18px;">Estilos Avanzados</div></div></b>';
                if($count==ceil($first+(($total-$first)/3)*2))echo '</ul><ul style="width:180px; display:inline-block;"><b><div style="margin:3px;margin-bottom:15px; margin-left:0;background:#4c4c4c;text-align:center;"><div style="padding:10px 0px;color:#fff;font-size:18px;">&nbsp;</div></div></b>';
                $count++;
                ?>
                <li class="cell" style="width:200px;float:left;display:inline-block;">
                  <input id="est<?= $value->estilo_id ?>" type="checkbox" name="est" value="<?= $value->estilo_id ?>"/>
                  <label  title="<?= mb_strtolower($value->estilo_name, 'UTF-8') ?>" style="" for="est<?= $value->estilo_id ?>"><?= mb_strtolower($value->estilo_name, 'UTF-8') ?></label>
                </li>
              <? } ?>
            </ul>
            </ul>
          </li>
          <li class="separador">|</li>
          <li class="css_nav_dropmenu" id="co">
            <a href="#<? //php echo $base_url . "lite_library/item_link_examples";      ?>">COLORES▼</a>
            <ul class="colores" style="width:600px; overflow:hidden;">
              
              <?
              $count = 0;
              $first=0;
              $total=count($gama);
             
              foreach ($gama as $value) {
                
                if($count==0)echo'<ul style="width:200px;float:left; display:block;margin:0;"><div style="margin:3px;"><div >&nbsp;</div></div>';
                if($count==  ceil($total/3)){echo '</ul><ul style="width:200px;float:left; display:block;"><div style="margin:3px;"><div>&nbsp;</div></div>';$first=$count;}
                if($count==  ceil($total/3)*2)echo '</ul><ul style="width:200px;float:left; display:block;"><div style="margin:3px;"><div>&nbsp;</div></div>';
                $count++;
                ?>
              
                <li class="cell" style="float:left;">
                  <input id="col<?= $value->gama_id ?>" type="checkbox" name="gama" value="<?= $value->gama_id ?>"/>
                  <label title="<?= mb_strtolower($value->gama_name, 'UTF-8') ?>"  for="col<?= $value->gama_id ?>"><span style="background:<?=(strpos($value->rgb,'#') === false)?'url(\''.$includes_dir.'images/colores.jpg\') 0 '.(-($value->rgb*19)+20).'px':$value->rgb ?>"></span> <?= mb_strtolower($value->gama_name, 'UTF-8') ?></label>
                </li>
                
              <? } ?>
            </ul>
            </ul>
          </li>
          <?}?>
        </ul>
      </div>
    </div>
  </div>
<div style="position:fixed;top:65px;z-index: 20;width:100%;height:20px; background: #fff"></div>
</div>

<div style="display:block;height: 85px"></div>



<div class="container no-m no-t f0">
  <div id="slides" style="overflow: hidden; display: block; margin-bottom: 5px; margin-left:1px">
    <?foreach($images as $key){?>
    <img alt="" src="<?php echo $includes_dir; ?>images/slider/<?=$key->id?>.jpg" class="slidesjs-slide" style="position: absolute; top: 0px; left: 1170px; width: 100%; z-index: 10; display: block;" slidesjs-index="0">
    <?}?>
  </div>
</div>
<div class="promo-top">
<div class="container promo-container">
  <div class="pleft">
 <?foreach($promosl as $key){?>
  <div class="promos "> 
    <a <?if ($key->ancho>0) echo 'class="pop"';?> data-id="<?=$key->id?>" href="<?=$key->enlace?>" target="_blank"><div><?=$key->titulo?></div></a>
  </div>
 <?}?>  
  </div>
  <div class="pright">
 <?foreach($promosr as $key){?>
  <div class="promos "> 
    <a <?if ($key->ancho>0) echo 'class="pop"';?> data-id="<?=$key->id?>" href="<?=$key->enlace?>" target="_blank"><div><?=$key->titulo?></div></a>
  </div>
 <?}?>  
  </div>
</div></div>
 <div class="container" style="height:45px;margin-top: 10px; margin-bottom: 10px;position:relative;clear:both;overflow:hidden;">
  <div id="mcts1">
  <?
   foreach ($fabsamp as $l) {
    ?>
    <img data-id="<?=$l->cat_id?>" class="logoindex" style="margin-left:11.2px;" src="<?php echo $includes_dir; ?>images/logos/<?= $l->cat_id ?>.jpg" width="86" height="43">
<? } ?>
</div>
</div>
<div  id="overlay" >
  <div class="contentWrap imgoverlay" style="display:none;height: 100%;width:100%"><center><img style="margin:auto;" src="../"/></center></div>
  <div class="contentWrap infowarp"><div class="close"></div>
    <div id="dettitle" class="dettitle"></div>
    <img id="papermed" class="med" src="../image.jpg"/>
    
    <div class="med selectdetail ">
      <div style="width:55%;display:inline-block;">
       <div>Ancho:<span class="ancho"></span></div>
       <div>Largo:<span class="largo"></span></div>
       <div>Case del dibujo:<span class="case"></span></div>
       <div>Mantenimiento:<span class="lavable"></span></div>
       <div>Resistente a luz solar:<span class="sol"></span></div>
       <div>Vinilo:<span class="vinilo"></span></div>
       <div>Encolar a:<span class="cola"></span></div>
       <div>Plazo de entrega (aproximado):<span class="plazo"></span></div>
       </div>
      <div style="width:35%;margin-left:5%;display:inline-block;">
       <div>
         
         <input type="hidden" name="itemid" id="itemid" value="0">
         <input type="hidden" name="ud" id="ud" value="">
         <span style="font-size:22px">Unidades:
         <input style="font-size:22px;width:40px;text-align: center" name="unidades" id="unidades" value="1"></span>
         <br> &nbsp;<br>
         <span class="m2" style="font-size:16px">Dimensiones:<br>
         Ancho X Alto(cm): <br><input style="font-size:16px;width:40px;text-align: center" name="p_ancho" id="p_ancho" value="">X<input style="font-size:16px;width:40px;text-align: center" name="p_alto" id="p_alto" value=""></span>&nbsp;<br> &nbsp; <br>
         <span style="font-size:20px;color:#AE0058;font-weight: bold;margin-bottom: 10px" class="precio"></span>
         <br> &nbsp; <br>
       </div>
       
       
      </div>
      
    </div>
    <div id="infoseparador"></div>
    <div id="iconosdet">
       <div><a class="addformitem" href="#"><img title="Añadir al Carro" height="60" src="<?=$includes_dir?>images/carroadd.png"/></a></div>
       <div><img class="opencal" title="Calculadora de rollos" height="60" src="<?=$includes_dir?>images/calculadora.png"/></div>
       <div><a class="addformsample" href="#"><img title="Herramientas" height="60" src="<?=$includes_dir?>images/brocha.png"/></a></div>
      </div>
     <div id="coltext">
       <img id="ambmed" class="zoom"  src="..."/>
       <span id="coldesc"></span>
     </div>
  </div>
</div>
<div class="detail">

</div>
<!-- Header -->  
<div id="overlay2">
  <div class="contentWrap2 infowarp"><div class="close"></div>
    <div class="dettitle"> Calculadora de rollos</div>
    <div style="margin:3px;">
      <table>
        <tr>
          <td style="height:100px;" colspan="2">Introduce las medidas de la superficie que necesitas cubrir para obtener una estimación de las cantidaes que puedes necesitar</td>
          
        </tr>
        <tr>
          <td>Ancho de la pared (metros)</td>
          <td><input id="paredancho" type="text" name="ancho" value=""/></td>
        </tr>
        <tr>
          <td>Altura (metros)</td>
          <td><input id="paredalto" type="text" name="alto" value=""/></td>
        </tr>
        <tr>
          <td><input onclick="javascript:calcular()" type="button" name="Calcular" value="Calcular"/></td>
          <td><input class="closecal" type="button" name="Cerrar" value="Cerrar"/></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div id="overlay3">
  <div class="contentWrap3 infowarp"><div class="close"></div>
    <div class="dettitle"> </div>
    <div class="texto" style="margin:3px;"></div>
  </div>
</div>
<div  id="overlay4" >
  <div class="contentWrap imgoverlay" style="display:none;height: 100%;width:100%"><center><img  style="margin:auto;" src="../"/></center></div>
  <div class="contentWrap infowarp"><div class="close"></div>
    <div id="dettitle" class="dettitle dettitle4">a</div>
    <img id="papermed" class="med papermed4" src="../image.jpg"/>
    <div class="med selectdetail ">
      <div style="width:35%;margin-left:5%;display:inline-block;">
       <div>
         <input type="hidden" id="itemid" value="0">
         <span style="font-size:22px">Unidades:
         <input style="font-size:22px;width:40px;text-align: center" id="unidades" value="1"></span>
         <br> &nbsp;<br> &nbsp; <br>
         <span style="font-size:20px;color:#AE0058;font-weight: bold;margin-bottom: 10px" class="precio"></span>
         <br> &nbsp;<br> &nbsp; <br>
       </div>
      </div> 
    </div>
    <div id="infoseparador"></div>
    <div id="iconosdet">
       <div><a class="addformitem" href="#"><img title="Añadir al Carro" height="60" src="<?=$includes_dir?>images/carroadd.png"/></a></div>
     </div>
     <div id="coltext">
       
       <span id="coldesc" class="coldesc4"></span>
     </div>
  </div>
</div>
<div id="body_wrap" class=" f0">
  <!-- Demo Navigation -->
  <div id="menu">
    <div id ="itemscont">
      <div style="" class="content_wrap nav_bg navegacion">
        <div class="srowstyle">
          
      </div>
    </div>
  </div>
</div>