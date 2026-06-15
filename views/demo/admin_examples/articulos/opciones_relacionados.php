<option value="0">No está relacionado</option>
<?php 
$id_relacionado=0;
if (isset($_POST['rel_con']))
  $id_relacionado=$_POST['rel_con'];
elseif (isset($relacionado_con)) {
  $id_relacionado=$relacionado_con;
}
foreach($relacionados as $item){ 
  /*<option <?if($this->input->post("rel_con")==$item['item_id']) echo "selected";?> value="<?=$item['item_id']?>"><?=$item['item_ref']?></option>*/
?>
  <option <?if($id_relacionado==$item['item_id']) echo "selected";?> value="<?=$item['item_id']?>"><?=$item['item_ref']?></option>
<?
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
