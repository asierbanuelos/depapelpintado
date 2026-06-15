<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Editar Proyecto</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <?php
    /*
    print '<pre><xmp>';
    print_r($a_imagenes);
    print '</xmp></pre>';
    print '<pre><xmp>';
    print_r($nueva_imagen);
    print '</xmp></pre>';
    */
    echo form_open_multipart('admin_library/update_proyecto');?>
      <div style="height: 20px"></div>
      <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">EDITAR PROYECTO</div>
      <div style="height: 20px"></div>

        <input type='hidden' name='idproyecto' id='idproyecto' value='<?php echo (int)$proyecto->idproyecto;?>' />
        
        <div class="sec row"><div class="col two t-six m-six">Categoría:</div>
          <div class="ten t-six m-six">
            <?php
              echo form_dropdown('idproyecto_categoria', $categorias, $proyecto->idproyecto_categoria);
            ?>
          </div>
        </div>

        <div class="sec row"><div class="col two t-six m-six">Título:</div><?=  form_input("proyecto_name",$proyecto->proyecto_name,'class="ten t-six m-six"')?></div>
        <div class="sec row"><div class="col two t-six m-six">Fecha:</div><?=  form_input("proyecto_fecha",$proyecto->proyecto_fecha,'class="ten t-six m-six datepicker"')?></div>
        <div class="sec row">Resumen (texto que saldrá en el listado de proyectos en la web):</div>
        <div class="sec row"><textarea id="resumen_proyecto" name="resumen_proyecto" style='width: 100%;' rows='5'><?php echo $proyecto->resumen_proyecto; ?></textarea></div>
        <br />
        <div class="sec row">Descripción completa (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="descripcion_proyecto" name="descripcion_proyecto" class='editor'><?php echo $proyecto->descripcion_proyecto; ?></textarea></div>
        <br />
        <div class="sec row">
          <div class="col two"><label for="proyecto_publico">Publicado en web:</label></div>
          <div class="ten"><?= form_checkbox("proyecto_publico", "1", $proyecto->proyecto_publico, 'id="proyecto_publico"') ?></div>
        </div>
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_proyecto", $proyecto->meta_title_proyecto, 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_proyecto", $proyecto->meta_description_proyecto, 'class="ten" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_proyecto", $proyecto->meta_keywords_proyecto, 'class="ten"') ?></div>
        </div>
      
      <fieldset style='width:100%;' id='img_nueva'>
        <legend style='padding:0 5px;'> Añadir imagen </legend>
        <p>
          A nivel seo las imágenes tienen que llamarse con palabra clave, meter el ALT o texto descriptivo, título, no pesar mucho ni ser muy grandes y rellenar el YOAST con el meta title y la meta description
        </p>
        <div class="">
          <div class="sec row"><div class="col two">Imagen:</div><?= form_upload("nueva_imagen_proyecto", '', 'class="ten" style="margin-bottom: 10px;"') ?></div>
          <div class="sec row"><div class="col two">Título:</div><?= form_input("nuevo_titulo", '', 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Nombre imagen:</div><?= form_input("nuevo_nombre", '', 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">URL tienda (EKAM):</div><?= form_input("nueva_url", '', 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Alt imagen:</div><?= form_input("nuevo_alt", '', 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Title imagen:</div><?= form_input("nuevo_title", '', 'class="ten"') ?></div>
        </div>
        <?php echo form_submit("mas_imagenes", "Añadir imagen",'class="button orange-button twelve t-full m-full send"')?>
      </fieldset>
      <br />
      <br />
      <div style="font-size:20px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">IMÁGENES SUBIDAS</div>
      <?php 
      foreach($a_imagenes as $imagen){
        $img=$imagen->nombre_imagen.'-th-'.$imagen->idproyecto_img;
        $img_ext=$imagen->nombre_imagen.'-th-'.$imagen->idproyecto_img.'.jpg';
        ?>
        <div style="border-bottom:dotted 1px #aaa;margin:10px 0;padding:5px;" class="sec row">
          <div class="col three">
            <span class="imguploader" ref="<?php echo  $img; ?>" data-name-img='<?php echo $imagen->nombre_imagen; ?>' data-id-img="<?php echo $imagen->idproyecto_img; ?>" style="background-color: #000;display:block;">
              <?php 
              if ($imagen->nombre_imagen != ""){
                ?>
                <img src="/includes/images/proyectos/<?php echo $img_ext; ?>" style="max-width: 100%;"/>
                <? 
              } 
              ?>
            </span>
          </div>
          <div class="col nine ">
            <input type='hidden' name='imagenes[<?php echo $imagen->idproyecto_img; ?>][nombre_orig]' value='<?php echo $imagen->nombre_imagen;?>' />
            <div class="sec row"><div class="col two">Título imagen:</div><?= form_input("imagenes[{$imagen->idproyecto_img}][titulo]", $imagen->titulo, 'class="ten"') ?></div>
            <div class="sec row"><div class="col two">Nombre imagen:</div><?= form_input("imagenes[{$imagen->idproyecto_img}][nombre]", $imagen->nombre_imagen, 'class="ten"') ?></div>
            <div class="sec row"><div class="col two">URL tienda (EKAM):</div><?= form_input("imagenes[{$imagen->idproyecto_img}][url_tienda]", $imagen->url_tienda, 'class="ten"') ?></div>
            <div class="sec row"><div class="col two">Alt imagen:</div><?= form_input("imagenes[{$imagen->idproyecto_img}][alt]", $imagen->alt, 'class="ten"') ?></div>
            <div class="sec row"><div class="col two">Title imagen:</div><?= form_input("imagenes[{$imagen->idproyecto_img}][title]", $imagen->title, 'class="ten"') ?></div>
            <div class="sec row">
              <div class="col two">&nbsp;</div>
              <div class="col two"  style="margin-left: 0;">
                <span class="btn" style="width: 100%;margin-left: 0;">
                  <a style="color: #fff;text-decoration: none;" href="/admin_library/borrar_img_proyecto/<?php echo $imagen->idproyecto_img; ?>">Borrar imagen</a>
                </span>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>

      <div style="height: 20px"></div>
      <div class="sec row">
        <?php echo form_submit("test", "Guardar",'class="button orange-button six t-full m-full send"')?>
        <?echo form_button("test", "Cancelar",'class="button orange-button six t-full m-full close"')?>
      </div>
      <br />
    <?=form_close();?>

  <?php $this->load->view('includes/scripts'); ?> 
  <script type="text/javascript" src="<?=$includes_dir?>/tinymce/tinymce.min.js"></script>
  <script type="text/javascript">
  tinymce.init({
    convert_urls: false,entity_encoding : "raw",
      selector: "textarea.editor",
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
  $(".close").click(function(){
    $(location).attr("href", "/admin_library/proyectos");
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
      alert(name_img);
      */
      var uploadURL = "<?= $includes_dir ?>grid/modificar_imagen.php"; //Upload URL
      //var uploadURL = "/admin_library/modificar_imagen"; //Upload URL
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

    function handleFileUpload(files, obj, ref, name_img, id_img){
      for (var i = 0; i < files.length; i++){
        var fd = new FormData();
        fd.append('file', files[i]);
        fd.append('fname', ref);
        fd.append('name_img', name_img);
        fd.append('id_img', id_img);
        fd.append('output_dir', "../images/proyectos/");

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
        name_img=$(this).attr("data-name-img");
        id_img=$(this).attr("data-id-img");
        handleFileUpload(files, $(this), $(this).attr("ref"), name_img, id_img);
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