<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Categorias noticias</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
<?php $this->load->view('includes/demo_header'); ?>
  <div class="container pb-4">
    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO CATEGORÍAS NOTICIAS</div>
    <div style="height: 20px"></div>
    <div class="sec row">
      <div class="col twelve">
        <span class="edit btn" style='width: 100%;margin:0;'><a style="color: #fff;text-decoration: none;" href='/admin_library/editar_categoria_noticia'>Nueva categoría</a></span>
      </div>
    </div>
    <div class="list">
      <?php
      /*
      print '<pre><xmp>';
      print_r($categorias_ekam);
      print '</xmp></pre>';
      print '<pre><xmp>';
      print_r($categorias);
      print '</xmp></pre>';
      exit;
      */
      $a_categorias=array();
      $a_descripciones=array();
      $a_meta_title=array();
      $a_meta_desc=array();
      foreach ($categorias as $key){
        $seo_completo=99;
        $estado_texto_ok=false;
        if (trim($key->descripcion_categoria)==''){
          $estado_texto='<span style="color:red;">Sin descripción</span>';
          $seo_completo=0;
        }
        elseif(str_word_count($key->descripcion_categoria)<900){
          $estado_texto='<span style="color:red;">Descripción con '.str_word_count($key->descripcion_categoria).' palabras</span>';
          $a_descripciones[]=$key->descripcion_categoria;
          $seo_completo=0;
        }
        elseif(in_array($key->descripcion_categoria, $a_descripciones)){
          $estado_texto='<span style="color:red;">Descripción duplicada</span>';
          $seo_completo=0;
        }
        else{
          $estado_texto='<span style="color:green;">Descripción OK</span>';
          $a_descripciones[]=$key->descripcion_categoria;
          $estado_texto_ok=true;
        }

        $estado_title='';
        $estado_title_ok=false;
        if(in_array($key->meta_title_categoria, $a_meta_title)){
          $estado_title.="<span style='color:red;'>Metatitle duplicado</span><br />";
          $seo_completo=0;
        }
        if (trim($key->meta_title_categoria)==''){
          $estado_title.='<span style="color:red;">Sin metatitle</span>';
          $seo_completo=0;
        }
        elseif(strlen($key->meta_title_categoria)>60){
          $estado_title.='<span style="color:red;">Metatitle > 60 ('.strlen($key->meta_title_categoria).')</span>';
          $a_meta_title[]=$key->meta_title_categoria;
          $seo_completo=0;
        }
        else{
          $estado_title='<span style="color:green;">Metatitle OK</span>';
          $a_meta_title[]=$key->meta_title_categoria;
          $estado_title_ok=true;
        }

        $estado_desc='';
        $estado_desc_ok=false;
        if(in_array($key->meta_description_categoria, $a_meta_desc)){
          $estado_desc.="<span style='color:red;'>Metadesc duplicado</span><br />";
          $seo_completo=0;
        }
        if (trim($key->meta_description_categoria)==''){
          $estado_desc.='<span style="color:red;">Sin Metadesc</span>';
          $seo_completo=0;
        }
        elseif(strlen($key->meta_description_categoria)>150){
          $estado_desc.='<span style="color:red;">Metadesc > 150 ('.strlen($key->meta_description_categoria).')</span>';
          $a_meta_desc[]=$key->meta_description_categoria;
          $seo_completo=0;
        }
        else{
          $estado_desc='<span style="color:green;">Metadesc OK</span>';
          $a_meta_desc[]=$key->meta_description_categoria;
          $estado_desc_ok=true;
        }


        $a_categorias[$seo_completo][$key->idnoticia_categoria]['noticia_categoria_name']=$key->noticia_categoria_name;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['noticia_categoria_name_url']=$key->noticia_categoria_name_url;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['descripcion_categoria']=$key->descripcion_categoria;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['estado_texto']=$estado_texto;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['estado_texto_ok']=$estado_texto_ok;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['meta_title']=$key->meta_title_categoria;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['estado_title']=$estado_title;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['estado_title_ok']=$estado_title_ok;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['meta_description']=$key->meta_description_categoria;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['estado_desc']=$estado_desc;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['estado_desc_ok']=$estado_desc_ok;
        
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['meta_keywords']=$key->meta_keywords_categoria;
        $a_categorias[$seo_completo][$key->idnoticia_categoria]['categoria_publico']=$key->categoria_publico;
      }

      foreach ($a_categorias as $seo_completo=>$a_datos){
        foreach ($a_datos as $id=>$datos){
          $inactivo='';
          if ($datos['categoria_publico']==0)
            $inactivo='background-color:#ffc5c5;';
          $publico_txt='';
          if ($datos['categoria_publico']==0)
            $publico_txt='<br />(sin publicar web)';
          ?>
          <div style="border-bottom:dotted 1px #aaa;margin:0;padding:5px;<?php echo $inactivo; ?>" class="sec row" id='registro_<?php echo $id; ?>'>
            <div class="col two">
              <strong><a href='/<?php echo $datos['noticia_categoria_name_url'];?>' target='_blank'><?php echo $datos['noticia_categoria_name']."&nbsp;".$publico_txt;?></a></strong>
            </div>
            <div class="col three ">
              <?php 
              if ($datos['estado_texto_ok'])
                echo $datos['estado_texto'];
              else
                echo '<span style="color:red;">'.$datos['estado_texto'].'</span>';
              if(trim($datos['descripcion_categoria'])!='')
                echo " <a href='#' class='ver-texto' data-texto-id='texto_$id'>Ver</a>\n";
              
              echo "<div style='display:none;' id='texto_$id' class='ctex'>{$datos['descripcion_categoria']}</div> \n";
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
              <span class="edit btn" id="<?php echo $id; ?>" style='width: 100%;'><a style="color: #fff;text-decoration: none;" href='/admin_library/editar_categoria_noticia/<?php echo $id; ?>'>Editar</a></span>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>
    <br />
  </div>
  <?php 
  $this->load->view('includes/scripts'); 
  ?> 
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
  </script>
  <script>
    /*
    */
    function sendFileToServer(formData, status, ref){
      /*
      alert('sendFileToServer');
      alert(formData);
      alert(status);
      alert(ref);
      */

      var uploadURL = "<?= $includes_dir ?>grid/up006uy.php"; //Upload URL
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

    var rowCount = 0;
    function createStatusbar(obj){
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

    function handleFileUpload(files, obj, ref){
      for (var i = 0; i < files.length; i++){
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
