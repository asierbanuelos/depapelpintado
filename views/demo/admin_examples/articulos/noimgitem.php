        <div class="col one t-two m-three">
          <?$value=reset($val); ?>
          <?= $value['item_ref'] ?><br/>
          <span class="imguploader" ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" style="background-color: #000;display:block;width:74px;height:74px">
            <? if ($value['img'] != "") { ?>
              <img src="<?php echo $includes_dir . str_replace("../", "", $value['img']); ?>th.jpg" width="74" height="74"/>
            <? } ?>
          </span>
        </div>
        <div class="col one t-two m-three">
          <br/>
          <span class="imguploader2" ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" style="background-color: #000;display:block;width:74px;height:74px">
            <? if ($value['imgamb'] != "") { ?>
              <img src="<?php echo $includes_dir . str_replace("../", "", $value['imgamb']); ?>th.jpg" width="74" height="74"/>
            <? } ?>
          </span>
        </div>
        <div class="col five t-four m-three">
          <?= $value['item_name'] ?><br/>
          <?= $value['cat_name'] ?><br/>
          <?= $value['coleccion_name'] ?><br/>
          <?= $value['modelo_name'] ?><br/>
          <b>Color: </b><?= $value['color'] ?><br/>
        </div>
        <div class="col two t-three m-three">
          Ancho:<?= $value['item_ancho'] ?><br/>
          Largo:<?= $value['item_largo'] ?><br/>
          Case: <?= $value['item_case'] ?><br/>
          <?= ($value['item_lavable'] == 1) ? "L" : "l" ?> - <?= ($value['item_sol'] == 1) ? "S" : "s" ?> - <?= ($value['item_vinilo'] == 1) ? "V" : "v" ?><br/>
          <b>Precio: <?= $value['item_price'] ?></b><br/>
        </div>

        <div class="col two t-two m-three">
          <span class="del btn" id="<?= $value['item_id'] ?>">Del</span>
          <span class="edit btn" id="<?= $value['item_id'] ?>">Edit</span>
        </div>


      </div>
 