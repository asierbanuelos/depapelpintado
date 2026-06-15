<?php $flexi_cart_library = (isset($current_url['admin_library'])) ? 'flexi_cart_admin' : 'flexi_cart'; ?>
<ul>
  <li id="mini_cart" style="float:right;width:290px;z-index: 100;" class="css_nav_dropmenu">
    <?= anchor('tienda/view_cart', '<span class="cartdisplay"><span style="position:relative;top:-8px;margin-left:10px">' . $this->$flexi_cart_library->total() . '</span><img src="'.$includes_dir.'images/carro.png"/></span>'); ?> 
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
</ul>
