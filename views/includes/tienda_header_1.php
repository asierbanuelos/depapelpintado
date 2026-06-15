<?php $flexi_cart_library = (isset($current_url['admin_library'])) ? 'flexi_cart_admin' : 'flexi_cart'; ?>
<div class="container">
  <div class=" content_wrap nav_bg" style="position:fixed;z-index: 50;width:1080px;">
    <div  class=" twelve m-full t-full">
      <div id="sub_nav_wrap" class="content container" >
        <ul class="sub_nav">
          <li>
            <a href="#">DEPAPELPINTADO.COM</a>
          </li>
          <li  style="float:right;padding: 4px;">
            <select class="sort_items" style="margin-top:0;magin-left:5px;" name="sort">
              <option value="">Ordenar por:</option>
              <option value="pop">POPULARES</option>
              <option value="item_price">PRECIO</option>
              <option value="item_cat_fk">FABRICANTES</option>
              <option value="gama_id">COLORES</option>
              <option value="estilo_id">ESTILOS</option>
            </select>
          </li>
          <li class="css_nav_dropmenu" style="float:right">
            <a href="#<? //php echo $base_url . "lite_library/item_link_examples";     ?>">COLORES▼</a>
            <ul class="colores" style="width:690px" style="float:right">
              <li class="aire">Limpiar</li>
              <?
              $count = 0;
              foreach ($gama as $value) {
                $count++;
                ?>
                <li class="cell" style="width:226px; <?php if ($count % 3 != 0) echo 'boirder:none;border-right:1px solid #333;'; ?>">
                  <input id="col<?= $value->gama_id ?>" type="checkbox" name="gama" value="<?= $value->gama_id ?>"/>
                  <label title="<?= $value->gama_name ?>"  for="col<?= $value->gama_id ?>"><span style="background-color:#25a"></span> <?= $value->gama_name ?></label>
                </li>
              <? } ?>
            </ul>
          </li>
          <li class="separador" style="float:right">|</li>
          <li class="css_nav_dropmenu" style="float:right">
            <a href="#<? //php echo $base_url . "lite_library/item_link_examples";      ?>">ESTILOS▼</a>
            <ul class="estilos" style="width:750px">
              <li class="aire">Borrar Selección</li>
              <?
              $count = 0;
              foreach ($estilo as $value) {
                $count++;
                ?>
                <li class="cell" style="width:246px; <?php if ($count % 3 != 0) echo 'boirder:none;border-right:1px solid #333;'; ?>">
                  <input id="est<?= $value->estilo_id ?>" type="checkbox" name="est" value="<?= $value->estilo_id ?>"/>
                  <label  title="<?= $value->estilo_name ?>" style="" for="est<?= $value->estilo_id ?>"><?= $value->estilo_name ?></label>
                </li>
              <? } ?>
            </ul>
          </li>
          <li class="separador" style="float:right">|</li>
          <li class="css_nav_dropmenu" style="float:right">
            <a href="#<? //php echo $base_url . "lite_library/item_link_examples";      ?>">MARCAS▼</a>
            <ul class="fabricantes" style="width:750px">
              <li class="aire">Borrar Selección</li>
              <?
              $count = 0;
              foreach ($fab as $value) {
                $count++
                ?>
                <li class="cell" style="width:247px; <?php if ($count % 3 != 0) echo 'border-right:1px solid #333;'; ?>">
                  <input id="fab<?= $value->cat_id ?>" type="checkbox" name="est" value="<?= $value->cat_id ?>"/>
                  <label  title="<?= $value->cat_name ?>" style="" for="fab<?= $value->cat_id ?>"><?= $value->cat_name ?></label>
                </li>
              <? } ?>
            </ul>
          </li>
          
          
          
          
        </ul>
      </div>
    </div>
  </div>
</div>
<div style="display:block;height: 35px"></div>
<div class="container no-m no-t f0">
  <div id="slides" style="overflow: hidden; display: block; margin-bottom: 5px;">
    <img alt="" src="<?php echo $includes_dir; ?>images/home1.jpg" class="slidesjs-slide" style="position: absolute; top: 0px; left: 1170px; width: 100%; z-index: 10; display: block;" slidesjs-index="0">
    <img alt="" src="<?php echo $includes_dir; ?>images/home2.jpg" class="slidesjs-slide" style="position: absolute; top: 0px; left: 0px; width: 100%; z-index: 0; display: none;" slidesjs-index="1">
    <img alt="" src="<?php echo $includes_dir; ?>images/home3.jpg" class="slidesjs-slide" style="position: absolute; top: 0px; left: 0px; width: 100%; z-index: 0; display: none;" slidesjs-index="2">
    <img alt="" src="<?php echo $includes_dir; ?>images/home4.jpg" class="slidesjs-slide" style="position: absolute; top: 0px; left: 0px; width: 100%; z-index: 10; display: block;" slidesjs-index="3">
  </div>
</div>
<div  class="apple_overlay" id="overlay" >
  <div class="contentWrap"></div>
</div>
<div class="detail">

</div>
<!-- Header -->  
<div id="body_wrap" class="container f0">
  <!-- Demo Navigation -->

  <div id="menu">
    <div id ="itemscont">
      <div style="" class="content_wrap nav_bg navegacion">
        <div style="position:relative;display:block;width: 100%;height:30px; background-color: #c0c0c0; top:0px; padding-top: 4px;">
          <ul class="sub_nav second_row">
            <li>Papel Pintado</li>
            <li class="separador">|</li>
            <li>Foto-Murales</li>
            <li class="separador">|</li>
            <li>Revestimientos</li>
            <li class="separador">|</li>
            <li>Telas</li>
            <!--<li>Ordenar por<b> »</b> <span class="sort_items">
                &nbsp; &nbsp; <input id="sortpop" type="radio" name="sort" value="pop"><label for="sortpop">POPULARES</label> &nbsp; /
                &nbsp; <input id="sortpre" type="radio" name="sort" value="item_price"><label for="sortpre">PRECIO</label> &nbsp; /
                &nbsp; <input id="sortfab" type="radio" name="sort" value="item_cat_fk"><label for="sortfab">FABRICANTES</label> &nbsp; /
                &nbsp; <input id="sortcol" type="radio" name="sort" value="gama_id"><label for="sortcol">COLORES</label> &nbsp; /
                &nbsp; <input id="sortest" type="radio" name="sort" value="estilo_id"><label for="sortest">ESTILOS</label>
              </span></li>-->
            <li id="mini_cart" style="float:right;width:260px" class="css_nav_dropmenu">
              <?= anchor('standard_library/view_cart', '<span class="cartdisplay"><span style="position:relative;top:-6px;">' . $this->$flexi_cart_library->total() . '</span><img width="25" src="' . $includes_dir . 'images/carro.png"/></span>'); ?>
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
            <li  style="float:right;"><div><div class="updatebar"><div><span style="padding-left:15px;"> <i>Actualizando...</i></span></div></div></div></li>
            
          </ul>
        </div>
        <div id="sub_nav_wrap" class="rel"  style="border-bottom:1px solid #4c4c4c;">
          <ul class="sub_nav">
            <li class="css_nav_dropmenu">
              <a href="#<? //php echo $base_url . "lite_library/item_link_examples";      ?>">MARCAS▼</a>
              <ul class="fabricantes" style="width:750px">
                <li class="aire">Borrar Selección</li>
                <?
                $count = 0;
                foreach ($fab as $value) {
                  $count++
                  ?>
                  <li class="cell" style="width:247px; <?php if ($count % 3 != 0) echo 'border-right:1px solid #333;'; ?>">
                    <input id="fab<?= $value->cat_id ?>" type="checkbox" name="est" value="<?= $value->cat_id ?>"/>
                    <label  title="<?= $value->cat_name ?>" style="" for="fab<?= $value->cat_id ?>"><?= $value->cat_name ?></label>
                  </li>
                <? } ?>
              </ul>
            </li>
            <li class="separador">|</li>
            <li class="css_nav_dropmenu">
              <a href="#<? //php echo $base_url . "lite_library/item_link_examples";      ?>">ESTILOS▼</a>
              <ul class="estilos" style="width:750px">
                <li class="aire">Borrar Selección</li>
                <?
                $count = 0;
                foreach ($estilo as $value) {
                  $count++;
                  ?>
                  <li class="cell" style="width:246px; <?php if ($count % 3 != 0) echo 'boirder:none;border-right:1px solid #333;'; ?>">
                    <input id="est<?= $value->estilo_id ?>" type="checkbox" name="est" value="<?= $value->estilo_id ?>"/>
                    <label  title="<?= $value->estilo_name ?>" style="" for="est<?= $value->estilo_id ?>"><?= $value->estilo_name ?></label>
                  </li>
                <? } ?>
              </ul>
            </li>
            <li class="separador">|</li>
            <li class="css_nav_dropmenu">
              <a href="#<? //php echo $base_url . "lite_library/item_link_examples";     ?>">COLORES▼</a>
              <ul class="colores" style="width:690px">
                <li class="aire">Limpiar</li>
                <?
                $count = 0;
                foreach ($gama as $value) {
                  $count++;
                  ?>
                  <li class="cell" style="width:226px; <?php if ($count % 3 != 0) echo 'boirder:none;border-right:1px solid #333;'; ?>">
                    <input id="col<?= $value->gama_id ?>" type="checkbox" name="gama" value="<?= $value->gama_id ?>"/>
                    <label title="<?= $value->gama_name ?>"  for="col<?= $value->gama_id ?>"><span style="background-color:#25a"></span> <?= $value->gama_name ?></label>
                  </li>
                <? } ?>
              </ul>
            </li>
            <li class="separador">|</li>
            <li>DESTACADOS</li>
            <li class="separador">|</li>
            <li>NOVEDADES</li>
            <select class="sort_items" style="margin-top:6px" name="sort">
              <option value="">Ordenar por:</option>
              <option value="pop">POPULARES</option>
              <option value="item_price">PRECIO</option>
              <option value="item_cat_fk">FABRICANTES</option>
              <option value="gama_id">COLORES</option>
              <option value="estilo_id">ESTILOS</option>
            </select>

            <? /* 		
              <li class="css_nav_dropmenu">
              Cart Status
              <ul>
              <li class="header">Envios</li>
              <li class="status">Opcion: <?php echo $this->$flexi_cart_library->shipping_name();?></li>
              <li class="status">Zona : <?php echo $this->$flexi_cart_library->shipping_location_name();?></li>
              <li class="header">Impuestos</li>
              <li class="status">Tipo: <?php echo $this->$flexi_cart_library->tax_name();?> @ <?php echo $this->$flexi_cart_library->tax_rate();?></li>
              <li class="status">Area : <?php echo $this->$flexi_cart_library->tax_location_name();?></li>
              <li class="status">Carro, Mostrar : Precios <?php echo ($this->$flexi_cart_library->display_prices_inc_tax()) ? "Include Tax" : "Exclude Tax";?></li>
              <li class="status">Carro, Interno : Precios <?php echo ($this->$flexi_cart_library->cart_prices_inc_tax()) ? "Include Tax" : "Exclude Tax";?></li>
              <li class="header">Cambio Divisa</li>
              <li class="status">Carro, Interno : <?php echo $this->$flexi_cart_library->currency_name(TRUE)." to ".$this->$flexi_cart_library->currency_name()." @ ".$this->$flexi_cart_library->exchange_rate(2);?></li>
              <li class="header">Importe Minimo</li>
              <li class="status">Pedido Minimo: <?php echo $this->$flexi_cart_library->minimum_order();?></li>
              <li class="status">Estado: <?php echo ($this->$flexi_cart_library->minimum_order_status()) ? "Eligible" : "Ineligible" ;?> to Checkout <a href="<?php echo $base_url; ?>standard_library/misc_features#minimum_order">[edit]</a></li>
              <li class="header">Estado Personalizado</li>
              <li class="status">Login Status: <?php echo ($this->$flexi_cart_library->custom_status_1()) ? 'Logged in' : 'Not logged in' ;?> <a href="<?php echo $base_url; ?>standard_library/misc_features#custom_status">[edit]</a></li>
              </ul>
              </li>
             */ ?>
            <li  style="float:right;"><div><div class="updatebar"><div><span style="padding-left:15px;"> <i>Actualizando...</i></span></div></div></div></li>
            <li class="no-f" style="float:right;padding-top:1px;">
              <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/facebook.png" alt="facebook"/></a>
              <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/twitter.png" alt="twitter"/></a>
              <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/pinterest.png" alt="pinterest"/></a>
              <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/you_tube.png" alt="you tube"/></a>
              <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/google+.png" alt="google+"/></a>
              <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/mail.png" alt="contact"/></a>
            </li>
          </ul>

        </div>

      </div>