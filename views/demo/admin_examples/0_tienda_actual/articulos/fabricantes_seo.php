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
  <div id="editform" style="position:fixed;top:0;width:100%;height:100%;z-index: 100;background-color:rgba(0,0,0,0.6);padding:20px;display:none;">
    <div class="container" style="background-color:#eee;padding: 10px;border-radius: 10px;">
      <div style="height: 20px"></div>
      <div style="font-size:30px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;"><span class='iname'></span> - Info SEO </div>
      <div style="height: 20px"></div>
      <?=form_open('admin_library/update_fab_seo');?>
        <div style="display:none"><?= form_input('fab','','class="iid"') ?></div>

        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="ed_text" name="cat_text"></textarea></div>
        <br />
        <?php 
        /*
        <div class="sec row">Descripción Extendida:</div>
        <div class="sec row"><textarea id="ed_text2" name="cat_text2"></textarea></div>
        <br />
        */
        ?>
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title", "", 'class="ten imtitle"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description", "", 'class="ten imdesc"  style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords", "", 'class="ten imkey"') ?></div>
          <br />
        </div>


      <?=form_submit("test", "Guardar",'class="button orange-button six t-full m-full send2"')?>
      <?=form_button("test", "Cancelar",'class="button orange-button six t-full m-full close"')?>
    <?=form_close();?>
    </div>
  </div>


  <?php 
  $this->load->view('includes/demo_header');
  ?>
  <div class="container">
    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO INFO SEO FABRICANTES</div>
    <div style="height: 20px"></div>
    <div class="list">
      <?php
      /*
      print '<pre><xmp>';
      print_r($fab);
      print '</xmp></pre>';
      exit;
      */
      $a_fabricantes=array();
      $a_descripciones=array();
      $a_meta_title=array();
      $a_meta_desc=array();
      foreach ($fab as $key){
        if ($key->activo==1 && $key->publico==1){
          $seo_completo=99;
          $estado_texto_ok=false;
          if (trim($key->cat_text)==''){
            $estado_texto='<span style="color:red;">Sin descripción</span>';
            $seo_completo=0;
          }
          elseif(str_word_count($key->cat_text)<900){
            $estado_texto='<span style="color:red;">Descripción con '.str_word_count($key->cat_text).' palabras</span>';
            $a_descripciones[]=$key->cat_text;
            $seo_completo=0;
          }
          elseif(in_array($key->cat_text, $a_descripciones)){
            $estado_texto='<span style="color:red;">Descripción duplicada</span>';
            $seo_completo=0;
          }
          else{
            $estado_texto='<span style="color:green;">Descripción OK</span>';
            $a_descripciones[]=$key->cat_text;
            $estado_texto_ok=true;
          }

          $estado_title='';
          $estado_title_ok=false;
          if(in_array($key->meta_titlef, $a_meta_title)){
            $estado_title.="<span style='color:red;'>Metatitle duplicado</span><br />";
            $seo_completo=0;
          }
          if (trim($key->meta_titlef)==''){
            $estado_title.='<span style="color:red;">Sin metatitle</span>';
            $seo_completo=0;
          }
          elseif(strlen($key->meta_titlef)>60){
            $estado_title.='<span style="color:red;">Metatitle > 60 ('.strlen($key->meta_titlef).')</span>';
            $a_meta_title[]=$key->meta_titlef;
            $seo_completo=0;
          }
          else{
            $estado_title='<span style="color:green;">Metatitle OK</span>';
            $a_meta_title[]=$key->meta_titlef;
            $estado_title_ok=true;
          }

          $estado_desc='';
          $estado_desc_ok=false;
          if(in_array($key->meta_descriptionf, $a_meta_desc)){
            $estado_desc.="<span style='color:red;'>Metadesc duplicado</span><br />";
            $seo_completo=0;
          }
          if (trim($key->meta_descriptionf)==''){
            $estado_desc.='<span style="color:red;">Sin Metadesc</span>';
            $seo_completo=0;
          }
          elseif(strlen($key->meta_descriptionf)>150){
            $estado_desc.='<span style="color:red;">Metadesc > 150 ('.strlen($key->meta_descriptionf).')</span>';
            $a_meta_desc[]=$key->meta_descriptionf;
            $seo_completo=0;
          }
          else{
            $estado_desc='<span style="color:green;">Metadesc OK</span>';
            $a_meta_desc[]=$key->meta_descriptionf;
            $estado_desc_ok=true;
          }


          $a_fabricantes[$seo_completo][$key->cat_id]['cat_name']=$key->cat_name;
          $a_fabricantes[$seo_completo][$key->cat_id]['cat_text']=$key->cat_text;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_texto']=$estado_texto;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_texto_ok']=$estado_texto_ok;
          $a_fabricantes[$seo_completo][$key->cat_id]['meta_title']=$key->meta_titlef;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_title']=$estado_title;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_title_ok']=$estado_title_ok;
          $a_fabricantes[$seo_completo][$key->cat_id]['meta_description']=$key->meta_descriptionf;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_desc']=$estado_desc;
          $a_fabricantes[$seo_completo][$key->cat_id]['estado_desc_ok']=$estado_desc_ok;
          
          $a_fabricantes[$seo_completo][$key->cat_id]['meta_keywords']=$key->meta_keywordsf;
        }
      }
      ksort($a_fabricantes);

      /*      
      print '<pre><xmp>';
      print_r($a_fabricantes);
      print '</xmp></pre>';
      exit;
      */
      foreach ($a_fabricantes as $seo_completo=>$a_datos){
        foreach ($a_datos as $id=>$datos){
            /*
            print '<pre><xmp>';
            print_r($datos);
            print '</xmp></pre>';
            exit;
            */
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
                <span class="edit btn" id="<?php echo $id; ?>" style='width: auto;'>Editar</span>
              </div>
              <div style="display:none" class="cid"><?php echo $id; ?></div>
              <div style="display:none" class="cmkey"><?php echo $datos['meta_keywords']; ?></div>
              <div style="display:none" class="cname"><?php echo $datos['cat_name']; ?></div>
            </div>
            <?php
        }
      }
      ?>
    </div>
  </div>
  <?php  
  $this->load->view('includes/scripts'); 
  ?> 
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
  <script type="text/javascript">
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
      $('.iname').html($('#registro_'+id_registro+' .cname').text().trim());
      $('.imtitle').val($('#registro_'+id_registro+' .cmtitle').text().trim());
      $('.imdesc').val($('#registro_'+id_registro+' .cmdesc').text().trim());
      $('.imkey').val($('#registro_'+id_registro+' .cmkey').text().trim());
      
      tinymce.get('ed_text').setContent($('#registro_'+id_registro+' .ctex').html());
    });
    /*
    $('.row').on('click','.edit', function(e) {
        var t = $(this).attr('id');
        var cats= $(this).attr('data-cats').split(",");
        $("#editform select[name='cats[]']").val(0);
        cats.forEach(function(e) {
              $("#editform select[name='cats[]']").find('option[value="' + e + '"]').attr("selected", true);
            });
        p = $(this).parent().parent();
        container2=$(this);
        $('#editform').show();
        $('.iid').val(p.find('.cid').text().trim());
        $('.iname').val(p.find('.cname').text().trim());
        $('.ifabmargen').val($(this).attr("data-margen"));
        $('.imtitle').val(p.find('.cmtitle').text().trim());
        $('.imdesc').val(p.find('.cmdesc').text().trim());
        $('.imkey').val(p.find('.cmkey').text().trim());
        if($(this).attr("data-disc") == "1"){
          $('.idisc').prop('checked', true );
        }else $('.idisc').prop('checked', false );
       // alert(p.find('.ctex').html());
        tinymce.get('ed_text').setContent(p.find('.ctex').html());
        tinymce.get('ed_text2').setContent(p.find('.ctex2').html());
    });
    */
    $(".close").click(function(){
      $("#editform").hide();  
    });

  </script> 

</body>
</html>
<?php
exit;
?>
            <div class="col one t-two m-three">
              <span class="imguploader" ref="<?=$key->cat_id?>" style="background-color: #000;display:block;width:80px;height:40px">
                <img src="<?php echo $includes_dir ."images/logos/". $key->cat_id.".jpg";?>" width="80" height="40"/>
              </span>
            </div>

              <div class="col one cid">
            <?=$key->cat_id?>
            </div>
            <div style="display:none" class="cmtitle">
            <?=$key->meta_titlef?>
            </div>
            <div style="display:none" class="cmdesc">
            <?=$key->meta_descriptionf?>
            </div>
            <div style="display:none" class="cmkey">
            <?=$key->meta_keywordsf?>
            </div>
            <div class="col five fixedh ctex">
            <?=$key->cat_text?>
            </div>
            <div class="col five fixedh ctex2" style="display: none">
            <?=$key->cat_text2?>
            </div>
            <div class="col three t-two m-three">
            <span data-margen="<?=$key->fabmargen?>" data-disc="<?=$key->disc?>" data-cats="<?= $key->cats ?>" class="edit btn" id="<?= $key->cat_id ?>">Edit</span>
            <span data-publico="<?if($key->publico==1)echo "0";else echo "1";?>" class="publicar btn" id="<?= $key->cat_id ?>">
            <?if($key->publico==1)echo "Ocultar";else echo "Publicar";?>
            </span>
            <span class="del btn pequeno" id="<?= $key->cat_id ?>">Del</span>

  <?php  
  $this->load->view('includes/scripts'); 
  ?> 
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
      var text='<div style="border-bottom:dotted 1px #aaa" class="sec row"><div class="col one">'+d.cat_id+'</div><div class="col two">'+d.cat_name+
              '</div><div class="col seven">'+d.cat_text+'</div><div class="col two t-two m-three"><!--<span class="del btn" id="'+d.cat_id+'">Del</span><span data-cats="'+d.cats+'" class="edit btn" id="'+d.cat_id+'">Edit</span>--!></div>';
       $('.list').prepend(text); 
    }
  $('.send').click(function(event){
		event.preventDefault();
		var parent_form = $(this).closest('form');
       
		var submit_url = parent_form.attr('action');
		var $form_inputs = parent_form.find(':input');
        var $form_text=$('#cat_text');
		var form_data = {};
		$form_inputs.each(function(){form_data[this.name] = $(this).val();});
        form_data["cat_text"] = tinymce.get('cat_text').getContent();
        form_data["cat_text2"] = tinymce.get('cat_text2').getContent();
        form_data["disc"]= $(".adisc").prop("checked");
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
    var container2=""
    $('.send2').click(function(event){
		event.preventDefault();
		var parent_form = $(this).closest('form');
       
       
		var submit_url = parent_form.attr('action');
		var $form_inputs = parent_form.find(':input');
        var $form_text=$('#ed_text');
		var form_data = {};
		$form_inputs.each(function(){form_data[this.name] = $(this).val();});
        form_data["fab"]= $(".iid").val();
        form_data["disc"]= $(".idisc").prop("checked");
        form_data["cat_text"] = tinymce.get('ed_text').getContent();
        form_data["cat_text2"] = tinymce.get('ed_text2').getContent();
        $.ajax(
		{
			url: submit_url,
			type: 'POST',
			data: form_data,
			success:function(data)
			{
				$("#editform").hide();
                container2.attr('data-disc',(form_data["disc"])?"1":"0");
                container2.attr('data-margen',form_data["fabmargen"]);
                container2.parent().parent().find(".ctex").html(form_data["cat_text"]);
                container2.parent().parent().find(".ctex2").html(form_data["cat_text2"]);
                container2.parent().parent().find(".cname").html(form_data["name"]);
                container2.parent().parent().find(".cmtitle").html(form_data["meta_title"]);
                container2.parent().parent().find(".cmdesc").html(form_data["meta_description"]);
                container2.parent().parent().find(".cmkey").html(form_data["meta_keywords"]);
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
        data:'&t=categories&n=cat&i='+t,
        success:function(data){p.slideUp();}
      });
      }
    });
    $('.row').on('click','.publicar',function(e){
    var t=$(this).attr('id');
    var pub=$(this).html();
    if(pub=="Publicar")pub="1";
    else pub="0";
    var pe=$(this);
      $.ajax({
        url:"<?=site_url('admin_library/publica_fab')?>",
        type:'POST',
        data:'&activar='+pub+'&i='+t,
        success:function(data){
          if(data==0){pe.attr('data-publico',data);pe.html("Publicar");}
          else if(data==1){pe.attr('data-publico',data);pe.html("Ocultar");}         
        }
      });
    });
    $('.row').on('click','.edit', function(e) {
        var t = $(this).attr('id');
        var cats= $(this).attr('data-cats').split(",");
        $("#editform select[name='cats[]']").val(0);
        cats.forEach(function(e) {
              $("#editform select[name='cats[]']").find('option[value="' + e + '"]').attr("selected", true);
            });
        p = $(this).parent().parent();
        container2=$(this);
        $('#editform').show();
        $('.iid').val(p.find('.cid').text().trim());
        $('.iname').val(p.find('.cname').text().trim());
        $('.ifabmargen').val($(this).attr("data-margen"));
        $('.imtitle').val(p.find('.cmtitle').text().trim());
        $('.imdesc').val(p.find('.cmdesc').text().trim());
        $('.imkey').val(p.find('.cmkey').text().trim());
        if($(this).attr("data-disc") == "1"){
          $('.idisc').prop('checked', true );
        }else $('.idisc').prop('checked', false );
       // alert(p.find('.ctex').html());
        tinymce.get('ed_text').setContent(p.find('.ctex').html());
        tinymce.get('ed_text2').setContent(p.find('.ctex2').html());
    });
    
    $(".close").click(function(){
  $("#editform").hide();  
  });

    function sendFileToServer(formData, status, ref)
    {
      var uploadURL = "<?= $includes_dir ?>grid/up004uy.php"; //Upload URL
      var extraData = {refer: ref}; //Extra Data.
      var jqXHR = $.ajax({
        xhr: function() {
          var xhrobj = $.ajaxSettings.xhr();
          if (xhrobj.upload) {
            xhrobj.upload.addEventListener('progress', function(event) {
              var percent = 0;
              var position = event.loaded || event.position;
              var total = event.total;
              if (event.lengthComputable) {
                percent = Math.ceil(position / total * 100);
              }
              //Set progress
              status.setProgress(percent);
            }, false);
          }
          return xhrobj;
        },
        url: uploadURL,
        type: "POST",
        contentType: false,
        processData: false,
        cache: false,
        data: formData,
        success: function(data) {
          status.setProgress(100);

          $("#status1").append("File upload Done<br>");
        }
      });
      status.setAbort(jqXHR);
    }
    function createStatusbar(obj)
    {
      rowCount++;
      var row = "odd";
      if (rowCount % 2 == 0)
        row = "even";
      this.statusbar = $("<div class='statusbar " + row + "'></div>");
      this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
      this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
      this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
      this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
      obj.after(this.statusbar);

      this.setFileNameSize = function(name, size)
      {
        var sizeStr = "";
        var sizeKB = size / 1024;
        if (parseInt(sizeKB) > 1024)
        {
          var sizeMB = sizeKB / 1024;
          sizeStr = sizeMB.toFixed(2) + " MB";
        }
        else
        {
          sizeStr = sizeKB.toFixed(2) + " KB";
        }

        this.filename.html(name);
        this.size.html(sizeStr);
      }
      var rowCount = 0;
      this.setProgress = function(progress)
      {
        var progressBarWidth = progress * this.progressBar.width() / 100;
        this.progressBar.find('div').animate({width: progressBarWidth}, 10).html(progress + "% ");
        if (parseInt(progress) >= 100)
        {
          this.abort.hide();
        }
      }
      this.setAbort = function(jqxhr)
      {
        var sb = this.statusbar;
        this.abort.click(function()
        {
          jqxhr.abort();
          sb.hide();
        });
      }
    }
    function handleFileUpload(files, obj, ref)
    {
      for (var i = 0; i < files.length; i++)
      {
        var fd = new FormData();
        fd.append('file', files[i]);
        fd.append('fname', ref);

        var status = new createStatusbar(obj); //Using this we can set progress.
        status.setFileNameSize(files[i].name, files[i].size);
        sendFileToServer(fd, status, ref);
      }
    }
    function sP(e) {
      e.stopPropagation();
      e.preventDefault();
    }
     $(document).ready(function() {
      var obj = $(".imguploader");
      $('.row').on('dragenter',".imguploader", function(e) {
        sP(e);
        $(this).css('border', '2px solid #0B85A1');
      });
      $('.row').on('dragover',".imguploader", function(e) {
        sP(e);
      });
      $('.row').on('drop',".imguploader", function(e) {
        $(this).css('border', '2px dotted #0B85A1');
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        handleFileUpload(files, $(this), $(this).attr("ref"));
      });
      $(document).on('dragenter', function(e) {
        sP(e);
      });
      $(document).on('dragover', function(e) {
        sP(e);
        obj.css('border', '2px dotted #0B85A1');
      });
      $(document).on('drop', function(e) {
        sP(e);
      });
    });
</script>
</body>
</html>