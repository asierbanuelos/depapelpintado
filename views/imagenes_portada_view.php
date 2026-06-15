<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Contenido</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  
  <?php 
  $this->load->view('includes/demo_header'); 
  ?>
  
  <div class="container pb-4">
    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">IMÁGENES DE PORTADA</div>
    <div style="height: 20px"></div>
    <?php
    //echo anchor("admin_library/addimage", "Añadir nueva Imagen",'class="button orange-button twelve t-full m-full send"');

    foreach($img_depapel as $key){
      $carpeta='home/';
      if (strpos($key->zona, 'ekam')){
        $carpeta='home/ekam/';
      }

      $nom_foto=urlenc($key->titulo);

      $inactivo='';
      if ($key->activo==0)
        $inactivo=' style="background-color:#ffc5c5" ';
      ?>
    <div class="row" <?php echo $inactivo; ?> > 
      <div class="col three" >
          <div class="imguploader" ref="<?=$key->id?>" style="background-color: #000;display:block;width:200px;height:105px"  data-name-directorio="<?=$carpeta?>"data-name-clean="<?=$nom_foto?>" >
              <img src="<?php echo $includes_dir ."images/{$carpeta}". $nom_foto.".jpg";?>" width="200" height="105"/>
          </div>
      </div>
      <div class="col two" style="display:block;font-size: 16px;font-weight: 300;padding-top:12px;"><?=$key->zona?></div>
      <div class="col three" style="display:block;font-size: 16px;font-weight: 300;padding-top:12px;"><?=$key->titulo?></div>
      <div class="col four" style="display:block;text-align: right;">
        <?=anchor('admin_library/editpagina/'.$key->id,"Editar",'class="btn"');?>
      	<?php
        /*
        echo anchor('admin_library/activarimagen/'.$key->id.'/'.$key->activo,($key->activo==0)?"Activar":"Desactivar",'class="btn"');
      	echo anchor('admin_library/borrarimagen/'.$key->id.'/'.$key->activo,"Borrar",'class="btn"');
        */
        ?>
      </div>
      <div style="clear:both;"></div>
    </div> 
      <?}?>
    <div style="clear:both;"></div>
  </div>
  <?php $this->load->view('includes/scripts'); ?> 
  <script>
  function sendFileToServer(formData, status, ref)
    {
      var uploadURL = "<?= $includes_dir ?>grid/mosaico_home.php"; //Upload URL
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
    function handleFileUpload(files, obj, ref, directorio, clean_name)
    {
      for (var i = 0; i < files.length; i++)
      {
        var fd = new FormData();
        fd.append('file', files[i]);
        fd.append('fname', ref);
        fd.append('directorio', directorio);
        fd.append('clean_name', clean_name);

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
        //alert($(this).attr("data-name-directorio"));
        //alert($(this).attr("data-name-clean"));
        handleFileUpload(files, $(this), $(this).attr("ref"), $(this).attr("data-name-directorio"), $(this).attr("data-name-clean"));
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