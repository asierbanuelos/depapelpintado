
Listado de Fabricantes
<ul  class="blocks-4">
<?foreach ($fab as $l) { ?>
<li> 
<?anchor($this->uri->sergment(1)."/marca/".$l->cat_id."/".$l->cat_name,'<img alt="<?'.$l->cat_name.'" title="<?'.$l->cat_name.'" src="<?'.$includes_dir.'images/logos/'.$l->cat_id.'.jpg" />');?>
</li>
<?}?>
</ul>