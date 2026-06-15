<option value="0">No está relacionado</option>
<?php foreach($relacionados as $item){ ?>
  <option <?if($this->input->post("rel_con")==$item['item_id']) echo "selected";?> value="<?=$item['item_id']?>"><?=$item['item_ref']?></option>
<?}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
