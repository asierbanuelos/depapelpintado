<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Colores</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div id="editform" style="position:fixed;top:0;width:100%;height:100%;z-index: 100;background-color:rgba(0,0,0,0.6);padding:20px;display:none;">
    <div class="container" style="background-color:#eee;padding: 10px;border-radius: 10px;">
      <?=form_open('admin_library/update_color');?>
        <div style="display:none"><?= form_input('gama','','class="iid"') ?></div>
        <div class="sec row">
          <div class="col twelve">
            <div class="col two">
              Color:
            </div>
            <?=  form_input("name","",'class="col five iname"')?>
          </div>
          <div class="twelve">
            <div class="col two">Tonalidad:</div>
            <div class="col nine">
              <select name='idtonalidad' id='id_tonalidad'>
                <?php  
                foreach ($a_tonalidades as $idtonalidad=>$datos_tonalidad){
                  echo "<option value='$idtonalidad'>{$datos_tonalidad['nombre_tonalidad']}</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="twelve">
            <div class="col two">Categorias:</div>
            <div class="col nine">
              <?= form_multiselect('cats[]', array("Papel Pintado"=>"Papel Pintado","Foto Murales"=>"Foto Murales","Revestimientos"=>"Revestimientos","Telas"=>"Telas","Alfombras"=>"Alfombras")) ?>
            </div>
          </div>
        </div>
        <div class="sec row">
          <?=form_submit("test", "Guardar",'class="button orange-button six t-full m-full send2"')?>
          <?=form_button("test", "Cancelar",'class="button orange-button six t-full m-full close"')?>
        </div>
      <?=form_close();?>
    </div>
  </div>
  <div class="container">
    <?=form_open('admin_library/add_color');?>
      <div style="height: 20px"></div>
      <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">ZONA COLORES</div>
      <div style="height: 40px"></div>
      <div class="sec row">
        <div class="col six t-six m-six" style="text-align: right;padding: 3px 10px 0px 0px;">
          COLOR: <?=  form_input("name","",'class="two t-six m-six"')?>
        </div>
        <div class="col one t-six m-six">Categorias:</div>
        <div class="col three t-six m-six">
          <?= form_multiselect('cats[]', array("Papel Pintado"=>"Papel Pintado","Foto Murales"=>"Foto Murales","Revestimientos"=>"Revestimientos","Telas"=>"Telas","Alfombras"=>"Alfombras")) ?>
        </div>
      </div>
      <div class="sec row">
        <?=form_submit("test", "Guardar",'class="button orange-button twelve t-full m-full send"')?>
      </div>
    <?=form_close();?> 

    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO COLORES</div>
    <div style="height: 20px"></div>
    <?php
    foreach ($colores as $key) {?>
      <div class="sec row">
        <div class="col one cid" style="padding-top: 15px;">
          <?=$key->gama_id?>
        </div>
        <div class="col four cname" style="text-align:center;padding-top: 15px;">
          <?=$key->gama_name?>
        </div>
        <div class="col four nametonalidad" style="text-align:center;padding-top: 15px;">
          <input type="hidden" class='cidtonalidad' value='<?php echo $key->idtonalidad; ?> '/>
          <?php 
            //echo $key->idtonalidad; 
            echo $a_tonalidades[$key->idtonalidad]['nombre_tonalidad']; 
          ?>
        </div>
        <div class="col three t-three m-three">
          <span data-cats="<?= $key->cats ?>" class="edit btn" id="<?= $key->gama_id ?>">Edit</span>
          <span class="del btn pequeno" id="<?=$key->gama_id ?>">Del</span>
        </div>
      </div>
    <?}?>
  </div>
    <?php $this->load->view('includes/scripts'); ?> 
  <script>
    function addline(d){
      var text='<div class="sec row"><div class="col one">'+d.gama_id+'</div><div class="col ten">'+d.gama_name+
              '</div><div id="'+d.gama_id+'" class="col one del">Del</div></div>';
       $('.list').prepend(text);
      
    }
  $('.send').click(function(event){
		event.preventDefault();
		var parent_form = $(this).closest('form');
		var submit_url = parent_form.attr('action');
		var $form_inputs = parent_form.find(':input');
		var form_data = {};
		$form_inputs.each(function()
		{
			form_data[this.name] = $(this).val();
		});

		$.ajax(
		{
			url: submit_url,
			type: 'POST',
			data: form_data,
			success:function(data)
			{
				addline(jQuery.parseJSON(data)[0]);
			}
		});
	});
    $('.send2').click(function(event){
		event.preventDefault();
		var parent_form = $(this).closest('form');
       
       
		var submit_url = parent_form.attr('action');
		var $form_inputs = parent_form.find(':input');
        
		var form_data = {};
		$form_inputs.each(function(){form_data[this.name] = $(this).val();});
        $.ajax(
		{
			url: submit_url,
			type: 'POST',
			data: form_data,
			success:function(data)
			{
				$("#editform").hide();
			}
		});
	});
    $('.row').on('click','.del',function(e){
     if(confirm("¿Estas seguro de querer borrar el registro?")){
    var t=$(this).attr('id');
    var p=$(this).parent().parent();
      $.ajax({
        url:"<?=site_url('admin_library/del')?>",
        type:'POST',
        data:'&t=gama&n=gama&i='+t,
        success:function(data){p.slideUp();}
      });
      }
    });
     $('.row').on('click','.edit', function(e) {
        var t = $(this).attr('id');
        var cats= $(this).attr('data-cats').split(",");
        $('#id_tonalidad option:selected').removeAttr('selected');
        $("#editform select[name='cats[]']").val(0);
        cats.forEach(function(e) {
              $("#editform select[name='cats[]']").find('option[value="' + e + '"]').attr("selected", true);
            });
        p = $(this).parent().parent();
        $('#editform').show();
        $('.iid').val(p.find('.cid').text().trim());
        $('.iname').val(p.find('.cname').text().trim());
        id_tonalidad_val=p.find('.cidtonalidad').val();

        $('#id_tonalidad option[value='+id_tonalidad_val+']').attr('selected','selected');
        //$('.itonalidad').val(p.find('.cidtonalidad').val());
        //cidtonalidad
    });
    $(".close").click(function(){
  $("#editform").hide();  
    });
</script>

</body>
</html>