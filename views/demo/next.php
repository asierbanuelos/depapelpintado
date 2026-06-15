<?if(false)foreach ($all as $cada){?> 
       <div class="col two t-two m-three"> 
        <span  style="background-color: #000;display:block;width:128px;height:128px"> 
          <img class="info" width="128" height="128" src="<?php echo $includes_dir.str_replace("../", "", $cada['img']);?>th.jpg"/>
          
        </span>
      <span><small>
          <a class="add_item_via_ajax_link" href="<?php echo $base_url; ?>standard_library/insert_database_item_to_cart/<?=$cada['item_id']?>">Añadir:</a><?=$cada['item_name']?><br/><?=$cada['item_price']?> €/Rollo<br/>2 Rollos:xxx</small></span>
       </div>
      
<?}?><?

echo json_encode($all);
?>
