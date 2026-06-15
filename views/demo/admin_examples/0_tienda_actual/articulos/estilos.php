<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Estilos</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <div id="editform" style="position:fixed;top:0;width:100%;height:100%;z-index: 100;background-color:rgba(0,0,0,0.6);padding:20px;display:none;">
    <div class="container" style="background-color:#eee;padding: 10px;border-radius: 10px;">
      <?=form_open('admin_library/update_estilo');?>
      <div style="display:none"><?= form_input('estilo','','class="iid"') ?></div>
      <div class="sec row"><div class="col two t-six m-six">ESTILO:</div><?=  form_input("name","",'class="ten t-six m-six iname"')?></div>
      <div class="sec row"><div class="col two t-six m-six">Categorias:</div>
        <div class="ten t-six m-six">
          <?= form_multiselect('cats[]', array("Papel Pintado"=>"Papel Pintado","Foto Murales"=>"Foto Murales","Revestimientos"=>"Revestimientos","Telas"=>"Telas","Alfombras"=>"Alfombras")) ?>
        </div>
      </div>
      <div class="sec row">Los textos h1 y h2 se generarán por defecto, completar si lo que se quiere es un texto específico:</div>
      <br />
      <div class="sec row"><div class="col two">Texto H1:</div><?= form_input("h1_estilo", "", 'class="ten"') ?></div>
      <div class="sec row"><div class="col two">Texto H2:</div><?= form_input("h2_estilo", "", 'class="ten"') ?></div>
      <br />
      <div class="sec row">Descripción (al menos 900 palabras):</div>
      <div class="sec row"><textarea id="edit_descripcion_estilo" name="descripcion_estilo"></textarea></div>
      <br />
      <div class="">
        <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_estilo", "", 'class="ten"') ?></div>
        <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_estilo", "", 'class="ten" style="height:50px"') ?></div>
        <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_estilo", "", 'class="ten"') ?></div>
      </div>
      <div style="height: 20px"></div>
      <?=form_submit("test", "Guardar",'class="button orange-button six t-full m-full send2"')?>
      <?=form_button("test", "Cancelar",'class="button orange-button six t-full m-full close"')?>
      <?=form_close();?>
    </div>
  </div>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <?=form_open('admin_library/add_estilo');?>
      <div style="height: 20px"></div>
      <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">ZONA ESTILOS</div>
      <div style="height: 20px"></div>
      <?php /* 
        <div class="sec row">
          <div class="col five t-six m-six" style="padding-right: 10px;">ESTILO:<?=  form_input("name","",'class="four t-six m-six"')?></div>
          <div class="col one t-six m-six">Categorias:</div>
          <div class="col three t-six m-six">
            <?= form_multiselect('cats[]', array("Papel Pintado"=>"Papel Pintado","Foto Murales"=>"Foto Murales","Revestimientos"=>"Revestimientos","Telas"=>"Telas","Alfombras"=>"Alfombras")) ?>
          </div>
        </div>
        */
      ?>
      <div class="sec row"><div class="col two t-six m-six">ESTILO:</div><?=  form_input("name","",'class="ten t-six m-six"')?></div>
      <div class="sec row"><div class="col two t-six m-six">Categorias:</div>
        <div class="ten t-six m-six">
          <?= form_multiselect('cats[]', array("Papel Pintado"=>"Papel Pintado","Foto Murales"=>"Foto Murales","Revestimientos"=>"Revestimientos","Telas"=>"Telas","Alfombras"=>"Alfombras")) ?>
        </div>
      </div>

      <div class="sec row">Los textos h1 y h2 se generarán por defecto, completar si lo que se quiere es un texto específico:</div>
      <br />
      <div class="sec row"><div class="col two">Texto H1:</div><?= form_input("h1_estilo", "", 'class="ten"') ?></div>
      <div class="sec row"><div class="col two">Texto H2:</div><?= form_input("h2_estilo", "", 'class="ten"') ?></div>
      <br />
      <div class="sec row">Descripción (al menos 900 palabras):</div>
      <div class="sec row"><textarea id="descripcion_estilo" name="descripcion_estilo"></textarea></div>
      <br />
      <div class="">
        <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_estilo", "", 'class="ten"') ?></div>
        <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_estilo", "", 'class="ten" style="height:50px"') ?></div>
        <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_estilo", "", 'class="ten"') ?></div>
      </div>
      <div style="height: 20px"></div>
      <div class="sec row">
        <?php
          //echo form_submit("test", "Guardar",'class="button orange-button twelve t-full m-full send"');
          echo form_submit("test", "Guardar",'class="button orange-button twelve t-full m-full"');
        ?>
      </div>
    <?=form_close();?>
    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO ESTILOS</div>
    <div style="height: 20px"></div>

    <?php
    $a_estilos=array();
    $a_descripciones=array();
    $a_meta_title=array();
    $a_meta_desc=array();
    foreach ($estilos as $key){
      $seo_completo=99;
      $estado_texto_ok=false;
      if (trim($key->descripcion_estilo)==''){
        $estado_texto='<span style="color:red;">Sin descripción</span>';
        $seo_completo=0;
      }
      elseif(str_word_count($key->descripcion_estilo)<900){
        $estado_texto='<span style="color:red;">Descripción con '.str_word_count($key->descripcion_estilo).' palabras</span>';
        $a_descripciones[]=$key->descripcion_estilo;
        $seo_completo=0;
      }
      elseif(in_array($key->descripcion_estilo, $a_descripciones)){
        $estado_texto='<span style="color:red;">Descripción duplicada</span>';
        $seo_completo=0;
      }
      else{
        $estado_texto='<span style="color:green;">Descripción OK</span>';
        $a_descripciones[]=$key->descripcion_estilo;
        $estado_texto_ok=true;
      }

      $estado_title='';
      $estado_title_ok=false;
      if(in_array($key->meta_title_estilo, $a_meta_title)){
        $estado_title.="<span style='color:red;'>Metatitle duplicado</span><br />";
        $seo_completo=0;
      }
      if (trim($key->meta_title_estilo)==''){
        $estado_title.='<span style="color:red;">Sin metatitle</span>';
        $seo_completo=0;
      }
      elseif(strlen($key->meta_title_estilo)>60){
        $estado_title.='<span style="color:red;">Metatitle > 60 ('.strlen($key->meta_title_estilo).')</span>';
        $a_meta_title[]=$key->meta_title_estilo;
        $seo_completo=0;
      }
      else{
        $estado_title='<span style="color:green;">Metatitle OK</span>';
        $a_meta_title[]=$key->meta_title_estilo;
        $estado_title_ok=true;
      }

      $estado_desc='';
      $estado_desc_ok=false;
      if(in_array($key->meta_description_estilo, $a_meta_desc)){
        $estado_desc.="<span style='color:red;'>Metadesc duplicado</span><br />";
        $seo_completo=0;
      }
      if (trim($key->meta_description_estilo)==''){
        $estado_desc.='<span style="color:red;">Sin Metadesc</span>';
        $seo_completo=0;
      }
      elseif(strlen($key->meta_description_estilo)>150){
        $estado_desc.='<span style="color:red;">Metadesc > 150 ('.strlen($key->meta_description_estilo).')</span>';
        $a_meta_desc[]=$key->meta_description_estilo;
        $seo_completo=0;
      }
      else{
        $estado_desc='<span style="color:green;">Metadesc OK</span>';
        $a_meta_desc[]=$key->meta_description_estilo;
        $estado_desc_ok=true;
      }


      $a_estilos[$seo_completo][$key->estilo_id]['estilo_name']=$key->estilo_name;
      $a_estilos[$seo_completo][$key->estilo_id]['activo']=$key->activo;
      $a_estilos[$seo_completo][$key->estilo_id]['descripcion_estilo']=$key->descripcion_estilo;
      $a_estilos[$seo_completo][$key->estilo_id]['estado_texto']=$estado_texto;
      $a_estilos[$seo_completo][$key->estilo_id]['estado_texto_ok']=$estado_texto_ok;
      $a_estilos[$seo_completo][$key->estilo_id]['meta_title']=$key->meta_title_estilo;
      $a_estilos[$seo_completo][$key->estilo_id]['estado_title']=$estado_title;
      $a_estilos[$seo_completo][$key->estilo_id]['estado_title_ok']=$estado_title_ok;
      $a_estilos[$seo_completo][$key->estilo_id]['meta_description']=$key->meta_description_estilo;
      $a_estilos[$seo_completo][$key->estilo_id]['estado_desc']=$estado_desc;
      $a_estilos[$seo_completo][$key->estilo_id]['estado_desc_ok']=$estado_desc_ok;
      
      $a_estilos[$seo_completo][$key->estilo_id]['meta_keywords']=$key->meta_keywords_estilo;
      $a_estilos[$seo_completo][$key->estilo_id]['descripcion_estilo_publico']=$key->descripcion_estilo_publico;
    }

    foreach ($a_estilos as $seo_completo=>$a_datos){
      foreach ($a_datos as $id=>$datos){
        $inactivo='';
        if ($datos['activo']==0)
          $inactivo='background-color:#ffc5c5;';
        ?>
        <div style="border-bottom:dotted 1px #aaa;margin:0;padding:5px;<?php echo $inactivo; ?>" class="sec row" <?php echo $inactivo; ?> id='registro_<?php echo $id; ?>'>
          <div class="col two">
            <strong><?php echo $datos['estilo_name'].'-'.$id;?></strong>
          </div>
          <div class="col three ">
            <?php 
            if ($datos['estado_texto_ok'])
              echo $datos['estado_texto'];
            else
              echo '<span style="color:red;">'.$datos['estado_texto'].'</span>';
            if(trim($datos['descripcion_estilo'])!='')
              echo " <a href='#' class='ver-texto' data-texto-id='texto_$id'>Ver</a>\n";
            
            if($datos['descripcion_estilo_publico'])
              echo "<br /><span style='color:blue;'>Texto publicado en web</span>";
            else
              echo "<br /><span style='color:red;'>Texto oculto en web</span>";
            echo "<div style='display:none;' id='texto_$id' class='ctex'>{$datos['descripcion_estilo']}</div> \n";
            ?>
          </div>
          <div class="col three ">
            <?php 
            echo $datos['estado_title'];
            if ($datos['estado_title_ok']){
              echo "<div id='meta_title_$id' class='cmtitle'>{$datos['meta_title']}</div> \n";
            }
            else{
              if(trim($datos['meta_title'])!='')
                echo " <a href='#' class='ver-meta-title' data-meta-title-id='meta_title_$id'>Ver</a>\n";
              echo "<div style='display:none;' id='meta_title_$id' class='cmtitle'>{$datos['meta_title']}</div> \n";
            }
            ?>
          </div>
          <div class="col three ">
            <?php 
            echo $datos['estado_desc'];
            if ($datos['estado_desc_ok']){
              echo "<div id='meta_desc_$id' class='cmdesc'>{$datos['meta_description']}</div> \n";
            }
            else{
              if(trim($datos['meta_description'])!='')
                echo " <a href='#' class='ver-meta-desc' data-meta-desc-id='meta_desc_$id'>Ver</a>\n";
              echo "<div style='display:none;' id='meta_desc_$id' class='cmdesc'>{$datos['meta_description']}</div> \n";
            }
            ?>
          </div>
          <div class="col one">
            <span class="edit btn" id="<?php echo $id; ?>" style='width: 100%;'>Editar</span>
            <?php 
            if ($datos['activo']==0){
            ?>
              <span class="del btn" id="<?php echo $id; ?>" data-estilo-id="<?php echo $id; ?>" style='width: 100%;'>Del</span>          
            <?php  
            }
            else{
              if($datos['descripcion_estilo_publico']==1){
                $txt_boton="Ocultar Desc.";
                $color='background-color: #277BF1;';
              } 
              else{
                $txt_boton="Publicar Desc.";
                $color='';
              }
              ?>
              <span class="publicar btn" data-descripcion_estilo_publico="<?php echo $datos['descripcion_estilo_publico']; ?>" data-estilo-id="<?php echo $id; ?>" style='width: 100%;<?php echo $color;?>'> 
                <?php echo $txt_boton; ?>
              </span>
              <?php 
            }
            ?>
          </div>
          <div style="display:none" class="cid"><?php echo $id; ?></div>
          <div style="display:none" class="cmkey"><?php echo $datos['meta_keywords']; ?></div>
          <div style="display:none" class="estilo_name"><?php echo $datos['estilo_name']; ?></div>
          <div style="display:none" class="descripcion_estilo_publico"><?php echo $datos['descripcion_estilo_publico']; ?></div>
        </div>
        <?php
      }
    }
    /*
    foreach ($estilos as $key){
      $inactivo='';
      if ($key->activo==0)
        $inactivo=' style="background-color:#ffc5c5" ';
      ?>
      <div class="sec row" <?php echo $inactivo; ?>>
        <div class="col one cid"><?php echo $key->estilo_id; ?></div>
        <div class="col eight cname" style="text-align: center;"><?php echo $key->estilo_name; ?></div>
        <div class="col three t-three m-three">
          <span data-cats="<?php echo $key->cats; ?>" class="edit btn" id="<?php echo $key->estilo_id; ?>">Edit</span>
          <span class="del btn pequeno" id="<?php echo $key->estilo_id; ?>">Del</span>          
        </div>
      </div>
      <?
    }
    */
    ?>
  </div>

  <?php $this->load->view('includes/scripts'); ?> 
  <script type="text/javascript" src="<?=$includes_dir?>/tinymce/tinymce.min.js"></script>
  <script type="text/javascript">
  tinymce.init({
    convert_urls: false,entity_encoding : "raw",
      selector: "textarea",
      language: "es",
        plugins: [
          "advlist autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen",
          "insertdatetime media nonbreaking save table contextmenu directionality",
          "emoticons template paste textcolor imgsurfer"
      ],
      toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | imgsurfer",
      toolbar2: "print preview media | forecolor backcolor emoticons",
      image_advtab: true,
      templates: [
          {title: 'Test template 1', content: 'Test 1'},
          {title: 'Test template 2', content: 'Test 2'}
      ]
   });
  </script>
  <script>
    function addline(d){
      var text='<div class="sec row"><div class="col one">'+d.estilo_id+'</div><div class="col nine">'+d.estilo_name+
              '</div class="col two"><span class="del btn" id="'+d.cat_id+'">Del</span><span data-cats="'+d.cats+'" class="edit btn" id="'+d.cat_id+'">Edit</span></div>';
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
    /*
    $('.send2').click(function(event){
  		event.preventDefault();
  		var parent_form = $(this).closest('form');
         
         
  		var submit_url = parent_form.attr('action');
  		var $form_inputs = parent_form.find(':input');
          var $form_text=$('#ed_text');
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
    */
    $('.row').on('click','.del',function(e){
     if(confirm("¿Estas seguro de querer borrar el registro?")){
        var t=$(this).attr('id');
        var p=$(this).parent().parent();
        $.ajax({
          url:"<?=site_url('admin_library/del')?>",
          type:'POST',
          data:'&t=estilo&n=estilo&i='+t,
          success:function(data){p.slideUp();}
        });
      }
    });
    $('.row').on('click','.edit', function(e) {
        var t = $(this).attr('id');
        $(location).attr("href", "/admin_library/editar_estilo/"+t);

        //alert(t);
        /*
        var cats= $(this).attr('data-cats').split(",");
        $("#editform select[name='cats[]']").val(0);
        cats.forEach(function(e) {
              $("#editform select[name='cats[]']").find('option[value="' + e + '"]').attr("selected", true);
            });
        p = $(this).parent().parent();
        $('#editform').show();
        $('.iid').val(p.find('.cid').text().trim());
        $('.iname').val(p.find('.cname').text().trim());
       // alert(p.find('.ctex').html());
        tinymce.get('ed_text').setContent(p.find('.ctex').html());
        */
    });
    $(".close").click(function(){
      $("#editform").hide();  
    });
</script>

</body>
</html>