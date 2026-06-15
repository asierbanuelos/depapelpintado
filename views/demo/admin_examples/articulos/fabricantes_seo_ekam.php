<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Fabricantes SEO</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO INFO SEO FABRICANTES EKAM</div>
    <div style="height: 20px"></div>
    <div class="sec row">
      <div class="col three">&nbsp;</div>
      <div class="col six">
        <span class="edit btn" style='width: 100%;margin:0;'><a style="color: #fff;text-decoration: none;" href='/admin_library/fabricantes_seo'>Ver estado de los fabricantes principales</a></span>
      </div>
    </div>
    <div style="height: 20px"></div>
    <div class="list">
      <?php
      $a_fabricantes=array();
      $a_descripciones=array();
      $a_meta_title=array();
      $a_meta_desc=array();
      foreach ($fab as $key){
        if ($key->activo==1 && $key->publico==1){
          $seo_completo=99;
          $estado_texto_ok=false;
          if (trim($key->cat_text_ekam)==''){
            $estado_texto='<span style="color:red;">Sin descripción</span>';
            $seo_completo=0;
          }
          elseif(str_word_count($key->cat_text_ekam)<900){
            $estado_texto='<span style="color:red;">Descripción con '.str_word_count($key->cat_text_ekam).' palabras</span>';
            $a_descripciones[]=$key->cat_text_ekam;
            $seo_completo=0;
          }
          elseif(in_array($key->cat_text_ekam, $a_descripciones)){
            $estado_texto='<span style="color:red;">Descripción duplicada</span>';
            $seo_completo=0;
          }
          else{
            $estado_texto='<span style="color:green;">Descripción OK</span>';
            $a_descripciones[]=$key->cat_text_ekam;
            $estado_texto_ok=true;
          }

          $estado_title='';
          $estado_title_ok=false;
          if(in_array($key->meta_titlef_ekam, $a_meta_title)){
            $estado_title.="<span style='color:red;'>Metatitle duplicado</span><br />";
            $seo_completo=0;
          }
          if (trim($key->meta_titlef_ekam)==''){
            $estado_title.='<span style="color:red;">Sin metatitle</span>';
            $seo_completo=0;
          }
          elseif(strlen($key->meta_titlef_ekam)>60){
            $estado_title.='<span style="color:red;">Metatitle > 60 ('.strlen($key->meta_titlef_ekam).')</span>';
            $a_meta_title[]=$key->meta_titlef_ekam;
            $seo_completo=0;
          }
          else{
            $estado_title='<span style="color:green;">Metatitle OK</span>';
            $a_meta_title[]=$key->meta_titlef_ekam;
            $estado_title_ok=true;
          }

          $estado_desc='';
          $estado_desc_ok=false;
          if(in_array($key->meta_descriptionf_ekam, $a_meta_desc)){
            $estado_desc.="<span style='color:red;'>Metadesc duplicado</span><br />";
            $seo_completo=0;
          }
          if (trim($key->meta_descriptionf_ekam)==''){
            $estado_desc.='<span style="color:red;">Sin Metadesc</span>';
            $seo_completo=0;
          }
          elseif(strlen($key->meta_descriptionf_ekam)>150){
            $estado_desc.='<span style="color:red;">Metadesc > 150 ('.strlen($key->meta_descriptionf_ekam).')</span>';
            $a_meta_desc[]=$key->meta_descriptionf_ekam;
            $seo_completo=0;
          }
          else{
            $estado_desc='<span style="color:green;">Metadesc OK</span>';
            $a_meta_desc[]=$key->meta_descriptionf_ekam;
            $estado_desc_ok=true;
          }


          $a_fabricantes[$seo_completo][$key->cat_id]['cat_name']=$key->cat_name;
          $a_fabricantes[$seo_completo][$key->cat_id]['cat_text']=$key->cat_text_ekam;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_texto']=$estado_texto;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_texto_ok']=$estado_texto_ok;
          $a_fabricantes[$seo_completo][$key->cat_id]['meta_title']=$key->meta_titlef_ekam;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_title']=$estado_title;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_title_ok']=$estado_title_ok;
          $a_fabricantes[$seo_completo][$key->cat_id]['meta_description']=$key->meta_descriptionf_ekam;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_desc']=$estado_desc;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_desc_ok']=$estado_desc_ok;
          
          $a_fabricantes[$seo_completo][$key->cat_id]['meta_keywords']=$key->meta_keywordsf;
        }
      }
      ksort($a_fabricantes);

      foreach ($a_fabricantes as $seo_completo=>$a_datos){
        foreach ($a_datos as $id=>$datos){
          ?>
          <div style="border-bottom:dotted 1px #aaa" class="sec row" id='registro_<?php echo $id; ?>'>
            <div class="col two">
              <img src="<?php echo $includes_dir ."images/logos/". $id.".jpg";?>" width="80" height="40"/><br />
              <?php echo $datos['cat_name'];?>
            </div>
            <div class="col three ">
              <?php 
              if ($datos['estado_texto_ok'])
                echo $datos['estado_texto'];
              else
                echo '<span style="color:red;">'.$datos['estado_texto'].'</span>';
              if(trim($datos['cat_text'])!='')
                echo " <a href='#' class='ver-texto' data-texto-id='texto_$id'>Ver</a>\n";
              echo "<div style='display:none;' id='texto_$id' class='ctex'>{$datos['cat_text']}</div> \n";
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
              <?php /*<span class="edit btn" id="<?php echo $id; ?>" style='width: 100%;'>Editar</span>*/ ?>
              <span class="edit btn" id="<?php echo $id; ?>" style='width: 100%;'>
                <a style="color: #fff;text-decoration: none;" href='/admin_library/editar_fabricante_seo/<?php echo $id; ?>/1'>Editar</a>
              </span>
            </div>
          </div>
          <?php
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
    /*
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
    */
    $(".close").click(function(){
      $("#editform").hide();  
    });
  </script>
</body>
</html>
