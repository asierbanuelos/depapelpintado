<option value="0">No es Variante</option>
<?php 
$id_variante=0;
if (isset($_POST['var_de']))
  $id_variante=$_POST['var_de'];
elseif (isset($variante_de)) {
  $id_variante=$variante_de;
}

foreach($variantes as $item){ 
  /*<option <?if($this->input->post("var_de")==$item['item_id']) echo "selected";?> value="<?=$item['item_id']?>"><?=$item['item_ref']?></option>*/

  ?>
  <option <?if($id_variante==$item['item_id']) echo "selected";?> value="<?=$item['item_id']?>"><?=$item['item_ref']?></option>
<?}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
