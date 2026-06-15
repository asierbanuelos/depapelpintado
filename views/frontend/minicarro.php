<?php 
$flexi_cart_library = (isset($current_url['admin_library'])) ? 'flexi_cart_admin' : 'flexi_cart'; 
?>
<div id="mini_cart" class="right minicarro errro dropdown" >
  <div style="display:inline">
    <?php
    //echo anchor('tienda/carrito', '<span style="width:100%;"  class="cartdisplay"><span class="precio-minicarro sombra">' . $this->$flexi_cart_library->total() . '</span><img src="'.$includes_dir.'images/carro.png" alt="carrito" title="carrito" /></span>','style="width:100%;"'); 
    echo anchor('tienda/carrito', '<span style="width:100%;"  class="cartdisplay"><span class="precio-minicarro sombra">' . $this->$flexi_cart_library->total() . '</span> <i class="fas fa-shopping-cart"></i></span>','style="width:100%;" aria-label="'.$this->$flexi_cart_library->total().' - Ver carrito"'); 
    ?>
  </div>
  <ul class="ulcarro dropdown-menu" style="top:25px;overflow:hidden;margin-right: 50px;display: none;">
    <li class="status" style="list-style-type: none;">
      <div>
      	<br/>
      <p class="text-centered old-h4">Resumen Carro</p>
      <table>
        <thead>
          <tr>
            <th >Art</th> 
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
                  <span style="overflow:hidden;height:75px;width:75px;display:inline-block"><img style="height:75px" src="<?php echo $includes_dir.str_replace("../", "", $row['thumb'])."th.jpg";?>"/></span> <?php echo $row['name'];?>
                </td>
                <td>
                  <?php
                  // If an item discount exists.
                  if ($this->$flexi_cart_library->item_discount_status($row['row_id'])) {
                    // If the quantity of non discounted items is zero, strike out the standard price.
                   
                      
                    
                    // Else, display the quantity of items that are at the standard price.
                    

                    // If there are discounted items, display the quantity of items that are at the discount price.
                    if ($row['discount_quantity'] > 0) {
                      echo '<span style="text-decoration:line-through;">' . $row['price'] . '</span><br/>';
                      echo $row['discount_price'];
                    }
                  }
              /*    if ($this->$flexi_cart_library->item_discount_status($row['row_id'])) {
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
                  }*/
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
                    echo '<span  style="text-decoration:line-through;">' . $row['price_total'] . '</span><br/>';
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
    </div>
    <br/>
    <div>
    <a href="http://www.depapelpintado.es/tienda/carrito" style="padding:7px;text-decoration:none;" class="total">Compra ahora <i class="fa fa-chevron-right "></i></a>
    </div>
    <br/>
    </li>
  </ul>
</div>
