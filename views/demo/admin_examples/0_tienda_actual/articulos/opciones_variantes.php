<option value="0">No tiene Variantes</option>
<?php foreach($variantes as $item){ ?>
  <option <?if($this->input->post("var_de")==$item['item_id']) echo "selected";?> value="<?=$item['item_id']?>"><?=$item['item_ref']?></option>
<?}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
