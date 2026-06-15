<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Modelos</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
<?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <?=form_open('admin_library/add_mod');?>
    <div style="height: 20px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">ZONA MODELOS</div>
    <div style="height: 20px"></div>
    <div class="sec row"><div class="col two">Fabricante:</div><?=form_dropdown('fab',$fab,'','class="six fabr"')?></div>
    <div class="sec row"><div class="col two">Colección:</div><?=form_dropdown('cole',$col,'','class="six cole"')?></div>   
    <div class="sec row"><div class="col two t-six m-six">Modelo:</div><?=  form_input("name","",'class="two t-six m-six"')?></div>
    <div class="sec row">Descripción:</div>
      <div class="sec row"><textarea id="mod_text" name="mod_text"></textarea></div>
      <div style="height: 20px"></div>
    <?=form_submit("test", "Guardar",'class="button orange-button twelve t-full m-full send"')?>
    <?=form_close();?>
    
<div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center; border-bottom: 1px solid #B05380;">LISTADO MODELOS</div>
    <div style="height: 20px"></div>
    
<?foreach ($mod as $value) {?>
     <div class="sec row">
       <div class="col one" style="padding: 15px;">
         <?=$value->modelo_id?>
       </div>
       <div class="col four" style="padding: 15px;">
         <?=$value->coleccion_name?>
       </div>
       <div class="col four" style="padding: 15px;">
         <?=$value->modelo_name?>
       </div>
       <div class="col three t-three m-three">
       	  <span class="edit btn " id="<?=$value->modelo_id?>">Edit</span>
          <span class="del btn pequeno" id="<?=$value->modelo_id ?>">Del</span>        
      </div>
       
     </div>
<?}?>
  </div>
    <?php $this->load->view('includes/scripts'); ?> 
  <script type="text/javascript" src="<?=$includes_dir?>/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    menubar:false,
    language: "es"
 });
</script>
  <script>
    function addline(d){
      var text='<div class="sec row"><div class="col one">'+d.modelo_id+'</div><div class="col two">'+d.coleccion_name+
       '</div><div class="col eight">'+d.modelo_name+'</div><div id="'+d.modelo_id+'" class="col one del">Del</div></div>';
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
        form_data["mod_text"] = tinymce.get('mod_text').getContent();

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
    $(".fabr").change(function(e){
    if($(this).val()>0){
      $.ajax({
        url:"<?=site_url('admin_library/get_col_select')?>",
        type:'POST',
        data:$(this).closest('form').serialize(),
        success:function(data){ $('.cole').html(data);$('.mod').html("");}
      })}
    });
    $(".cole").change(function(e){
    if($(this).val()>0){
      $.ajax({
        url:"<?=site_url('admin_library/get_mod_select')?>",
        type:'POST',
        data:$(this).closest('form').serialize(),
        success:function(data){ $('.mod').html(data);}
      })}
    });
    $('.row').on('click','.del',function(e){
    var t=$(this).attr('id');
    var p=$(this).parent().parent();
      $.ajax({
        url:"<?=site_url('admin_library/del')?>",
        type:'POST',
        data:'&t=modelo&n=modelo&i='+t,
        success:function(data){p.slideUp();}
      })
    });
    $(".fabr").change();
</script>

</body>
</html>