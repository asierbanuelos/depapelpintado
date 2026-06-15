<?php 
$flexi_cart_library = (isset($current_url['admin_library'])) ? 'flexi_cart_admin' : 'flexi_cart'; 
if (!isset($mini_cart_items))
        $mini_cart_items=$this->flexi_cart->cart_items();

?>
<?php
$div_display='display: none;';
if (isset($_GET['test'])){
  $div_display='';
}
?>
<div id="mini_cart" class="right minicarro errro">
  <div style="display:inline">
    <?php
    //echo anchor('tienda/carrito', '<span style="width:100%;"  class="cartdisplay"><span class="precio-minicarro sombra">' . $this->$flexi_cart_library->total() . '</span><img src="'.$includes_dir.'images/carro.png" alt="carrito" title="carrito" /></span>','style="width:100%;"'); 
    //echo anchor('tienda/carrito', '<span style="width:100%;"  class="cartdisplay"><span class="precio-minicarro sombra">' . $this->$flexi_cart_library->total() . '</span> <i class="fas fa-shopping-cart"></i></span>','style="width:100%;" aria-label="'.$this->$flexi_cart_library->total().' - Ver carrito"'); 
    ?>
    
    <a href="/tienda/carrito" style="width:100%;" aria-label="<?php echo $this->$flexi_cart_library->total(); ?> - Ver carrito">
      <span style="width:100%;" class="cartdisplay">
        <?php /*<span class="precio-minicarro sombra" id='precio_minicarro'><?php echo $this->$flexi_cart_library->total(); ?></span> <i class="fa fa-shopping-bag"></i>*/ ?>
        <span class="precio-minicarro sombra" id='precio_minicarro'>
          <?php echo $this->$flexi_cart_library->total(); ?> 
          <svg xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 -960 960 960" width="18"><path d="M240-80q-33 0-56.5-23.5T160-160v-480q0-33 23.5-56.5T240-720h80q0-66 47-113t113-47q66 0 113 47t47 113h80q33 0 56.5 23.5T800-640v480q0 33-23.5 56.5T720-80H240Zm0-80h480v-480h-80v80q0 17-11.5 28.5T600-520q-17 0-28.5-11.5T560-560v-80H400v80q0 17-11.5 28.5T360-520q-17 0-28.5-11.5T320-560v-80h-80v480Zm160-560h160q0-33-23.5-56.5T480-800q-33 0-56.5 23.5T400-720ZM240-160v-480 480Z"/></svg>
        </span>
      </span>
    </a>

  </div>
  <div class="ulcarro dropdown-carrito" id='capa-mini-carro' style='display:none;'>
    <div>
      <p class="text-center h6 tit-resumen-carrito p-2">Resumen Carrito</p>
      <table>
        <?php 
        if (!empty($mini_cart_items)) { ?>
          <tbody>
            <?php
            $i = 0;
            foreach ($mini_cart_items as $row) {
              $i++;
              ?>
              <tr>
                <td class='p-2' style="width:35%;">
                  <picture>
                    <img src="<?php echo $includes_dir.str_replace("../", "", $row['thumb'])."th.jpg";?>"/>
                  </picture> 
                </td>
                <td class='p-2 text-left align-top'>
                  <strong><?php echo $row['name'];?></strong><br />
                  <?php
                  // If an item discount exists.
                  if ($this->$flexi_cart_library->item_discount_status($row['row_id'])) {
                    // If the quantity of non discounted items is zero, strike out the standard price.
                    // Else, display the quantity of items that are at the standard price.
                    // If there are discounted items, display the quantity of items that are at the discount price.
                    if ($row['discount_quantity'] > 0) {
                      echo '<span style="text-decoration:line-through;">' . number_format((float)$row['price'], 2, ',', '.') . '</span><br/>';
                      echo number_format((float)$row['discount_price'], 2, ',', '.');
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
                    echo  number_format((float)$row['price'], 2, ',', '.');
                  }
                  echo ' x '.(int)$row['quantity']; 
                ?>
                </td>
                <td class='p-2 px-4 text-right align-top'>
                <?php
                  // If an item discount exists, strike out the standard item total and display the discounted item total.
                  if ($row['discount_quantity'] > 0) {
                    echo '<span  style="text-decoration:line-through;">' . number_format((float)$row['price_total'], 2, ',', '.') . '</span><br/>';
                    echo number_format((float)$row['discount_price_total'], 2, ',', '.');
                  }
                  // Else, display item total as normal.
                  else {
                    echo number_format((float)$row['price_total'], 2, ',', '.');
                  }
                  ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <?php
            /*
            <tr>
              <th colspan="2">Envío</th>
              <td>
                <?php echo $this->$flexi_cart_library->shipping_total(); ?>
              </td>
            </tr>
            */
            ?>
            <tr>
              <th colspan='2'>Total: </th>
              <td class='px-4'><?php echo $this->$flexi_cart_library->total(); ?></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class='text-center p-4'>
        <a href="/tienda/carrito" class="boton-opciones m-0">Compra ahora <i class="fa fa-chevron-right "></i></a>
      </div>
        <?php 
        } 
        else { ?>
          <tbody>
            <tr>
              <td class="p-4 h6 text-center">
                El carro está vacio.
              </td>
            </tr>
          </tbody>
        </table>
        <?php } ?>
</div>
