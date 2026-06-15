<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Colecciones SEO</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  
  <div id="editform" style="position:fixed;top:0;width:100%;height:100%;z-index: 100;background-color:rgba(0,0,0,0.6);padding:20px;display:none;">
    <div class="container" style="background-color:#eee;padding: 10px;border-radius: 10px;">
      <div style="height: 20px"></div>
      <div style="font-size:30px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">Info SEO<br /><span class='icatname'></span> - <span class='iname'></span></div>
      <div style="height: 20px"></div>
      <?=form_open('admin_library/update_col_seo');?>
        <div style="display:none"><?= form_input('col','','class="iid"') ?></div>

        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="ed_text" name="col_text"></textarea></div>
        <br />
        <div class="sec row"><div class="col two"><label for="principal">Desc. publicada en web:</label></div><div class="ten"><?= form_checkbox("col_text_publico", "1", '', 'id="col_text_publico"') ?></div></div>
        <div class="sec row"><div class="col two"><label for="principal">Greca misma colección:</label></div><div class="ten"><?= form_checkbox("greca_misma_coleccion_be", "1", '', 'id="greca_misma_coleccion_be"') ?></div></div>
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title", "", 'class="ten imtitle"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description", "", 'class="ten imdesc" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords", "", 'class="ten imkey"') ?></div>
          <br />
        </div>
        <?=form_submit("test", "Guardar",'class="button orange-button six t-full m-full send2"')?>
        <?=form_button("test", "Cancelar",'class="button orange-button six t-full m-full close"')?>
      <?=form_close();?>
    </div>
  </div>

  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO INFO SEO COLECCIONES</div>
    <div style="height: 20px"></div>
    <div class="list">
      <?php
      $a_colecciones=array();
      $a_descripciones=array();
      $a_meta_title=array();
      $a_meta_desc=array();
      foreach ($col as $key){
        if ($key->activo==1 && $key->publico==1 && $key->publico2==1){
          $seo_completo=99;
          $estado_texto_ok=false;
          if (trim($key->col_text)==''){
            $estado_texto='<span style="color:red;">Sin descripción</span>';
            $seo_completo=0;
          }
          elseif(str_word_count($key->col_text)<900){
            $estado_texto='<span style="color:red;">Descripción con '.str_word_count($key->col_text).' palabras</span>';
            $a_descripciones[]=$key->col_text;
            $seo_completo=0;
          }
          elseif(in_array($key->col_text, $a_descripciones)){
            $estado_texto='<span style="color:red;">Descripción duplicada</span>';
            $seo_completo=0;
          }
          else{
            $estado_texto='<span style="color:green;">Descripción OK</span>';
            $a_descripciones[]=$key->col_text;
            $estado_texto_ok=true;
          }

          $estado_title='';
          $estado_title_ok=false;
          if(in_array($key->meta_titlec, $a_meta_title)){
            $estado_title.="<span style='color:red;'>Metatitle duplicado</span><br />";
            $seo_completo=0;
          }
          if (trim($key->meta_titlec)==''){
            $estado_title.='<span style="color:red;">Sin metatitle</span>';
            $seo_completo=0;
          }
          elseif(strlen($key->meta_titlec)>60){
            $estado_title.='<span style="color:red;">Metatitle > 60 ('.strlen($key->meta_titlec).')</span>';
            $a_meta_title[]=$key->meta_titlec;
            $seo_completo=0;
          }
          else{
            $estado_title='<span style="color:green;">Metatitle OK</span>';
            $a_meta_title[]=$key->meta_titlec;
            $estado_title_ok=true;
          }

          $estado_desc='';
          $estado_desc_ok=false;
          if(in_array($key->meta_descriptionc, $a_meta_desc)){
            $estado_desc.="<span style='color:red;'>Metadesc duplicado</span><br />";
            $seo_completo=0;
          }
          if (trim($key->meta_descriptionc)==''){
            $estado_desc.='<span style="color:red;">Sin Metadesc</span>';
            $seo_completo=0;
          }
          elseif(strlen($key->meta_descriptionc)>150){
            $estado_desc.='<span style="color:red;">Metadesc > 150 ('.strlen($key->meta_descriptionc).')</span>';
            $a_meta_desc[]=$key->meta_descriptionc;
            $seo_completo=0;
          }
          else{
            $estado_desc='<span style="color:green;">Metadesc OK</span>';
            $a_meta_desc[]=$key->meta_descriptionc;
            $estado_desc_ok=true;
          }


          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['coleccion_name']=$key->coleccion_name;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['col_text']=$key->col_text;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['estado_texto']=$estado_texto;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['estado_texto_ok']=$estado_texto_ok;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['meta_title']=$key->meta_titlec;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['estado_title']=$estado_title;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['estado_title_ok']=$estado_title_ok;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['meta_description']=$key->meta_descriptionc;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['estado_desc']=$estado_desc;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['estado_desc_ok']=$estado_desc_ok;
          
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['meta_keywords']=$key->meta_keywordsc;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['col_text_publico']=$key->col_text_publico;
          $a_colecciones[$key->cat_name][$seo_completo][$key->coleccion_id]['greca_misma_coleccion_be']=$key->greca_misma_coleccion_be;
        }
      }
      ksort($a_colecciones);

      foreach ($a_colecciones as $fabricante=>$colecciones_fabricante){
        ?>
        <div class="sec row">
          <h1 class="col twelve" style="font-size: 1.2rem;color:#fff;background-color: #B05480;padding:5px;"><?php echo $fabricante; ?></h1>
        </div>
        <?php
        ksort($colecciones_fabricante);
        foreach ($colecciones_fabricante as $seo_completo=>$a_datos){
          foreach ($a_datos as $id=>$datos){
            ?>
            <div style="border-bottom:dotted 1px #aaa" class="sec row" id='registro_<?php echo $id; ?>'>
              <div class="col two">
                <strong><?php echo $datos['coleccion_name'].'-'.$id;?></strong>
              </div>
              <div class="col three ">
                <?php 
                if ($datos['estado_texto_ok'])
                  echo $datos['estado_texto'];
                else
                  echo '<span style="color:red;">'.$datos['estado_texto'].'</span>';
                if(trim($datos['col_text'])!='')
                  echo " <a href='#' class='ver-texto' data-texto-id='texto_$id'>Ver</a>\n";
                
                if($datos['col_text_publico'])
                  echo "<br /><span style='color:blue;'>Texto publicado en web</span>";
                else
                  echo "<br /><span style='color:red;'>Texto oculto en web</span>";
                echo "<div style='display:none;' id='texto_$id' class='ctex'>{$datos['col_text']}</div> \n";
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
                //    background-color: #277BF1;
                if($datos['col_text_publico']==1){
                  $txt_boton="Ocultar Desc.";
                  $color='background-color: #277BF1;';
                } 
                else{
                  $txt_boton="Publicar Desc.";
                  $color='';
                }
                ?>
                <span class="publicar btn" data-col_text_publico="<?php echo $datos['col_text_publico']; ?>" data-coleccion-id="<?php echo $id; ?>"style='width: 100%;<?php echo $color;?>'> 
                  <?php echo $txt_boton; ?>
                </span>
              </div>
              <div style="display:none" class="cid"><?php echo $id; ?></div>
              <div style="display:none" class="cmkey"><?php echo $datos['meta_keywords']; ?></div>
              <div style="display:none" class="catname"><?php echo $fabricante; ?></div>
              <div style="display:none" class="colname"><?php echo $datos['coleccion_name']; ?></div>
              <div style="display:none" class="col_text_publico"><?php echo $datos['col_text_publico']; ?></div>
              <div style="display:none" class="greca_misma_coleccion_be"><?php echo $datos['greca_misma_coleccion_be']; ?></div>
            </div>
            <?php
          }
        }
      }
      /*
      print '<pre><xmp>';
      print_r($a_colecciones);
      print '</xmp></pre>';
      exit;
      */
      ?>
    </div>
  </div>
  <?php 
  $this->load->view('includes/scripts'); 
  ?> 
  <script type="text/javascript" src="<?=$includes_dir?>/tinymce/tinymce.min.js"></script>
  <script type="text/javascript">
  tinymce.init({
    relative_urls : false,
            remove_script_host : true,
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
    $('.ver-texto').click(function(event){
      event.preventDefault();
      id_texto=$(this).attr("data-texto-id");
      $('#'+id_texto).toggle();
    });
    $('.ver-meta-title').click(function(event){
      event.preventDefault();
      id_meta_title=$(this).attr("data-meta-title-id");
      $('#'+id_meta_title).toggle();
    });
    $('.ver-meta-desc').click(function(event){
      event.preventDefault();
      id_meta_desc=$(this).attr("data-meta-desc-id");
      $('#'+id_meta_desc).toggle();
    });
    $('.edit').click(function(event){
      event.preventDefault();
      id_registro=$(this).attr('id');

      $('#editform').show();
      $('.iid').val($(this).attr('id'));

      //$('.iname').val($('#registro_'+id_registro+' .cname').text().trim());
      $('.icatname').html($('#registro_'+id_registro+' .catname').text().trim());
      $('.iname').html($('#registro_'+id_registro+' .colname').text().trim());
      $('.imtitle').val($('#registro_'+id_registro+' .cmtitle').text().trim());
      $('.imdesc').val($('#registro_'+id_registro+' .cmdesc').text().trim());
      $('.imkey').val($('#registro_'+id_registro+' .cmkey').text().trim());
      
      if($('#registro_'+id_registro+' .col_text_publico').text().trim()==1){
        $('#col_text_publico').prop('checked', true);
      }
      else{
        $('#col_text_publico').prop('checked', false);
      }
      
      if($('#registro_'+id_registro+' .greca_misma_coleccion_be').text().trim()==1){
        $('#greca_misma_coleccion_be').prop('checked', true);
      }
      else{
        $('#greca_misma_coleccion_be').prop('checked', false);
      }
      tinymce.get('ed_text').setContent($('#registro_'+id_registro+' .ctex').html());
    });

    $('.publicar').click(function(event){
      event.preventDefault();
      coleccion_id=$(this).attr("data-coleccion-id");
      col_text_publico=$(this).attr("data-col_text_publico");
      
      $(location).attr("href", "/admin_library/publicar_texto_coleccion/"+coleccion_id+"/"+col_text_publico);
    });
    $(".close").click(function(){
      $("#editform").hide();  
    });
  </script>
</body>
</html>
