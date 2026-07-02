<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Colecciones</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  
  <div id="editform" style="position:fixed;top:0;width:100%;height:100%;z-index: 100;background-color:rgba(0,0,0,0.6);padding:20px;display:none;">
    <div class="container" style="background-color:#eee;padding: 10px;border-radius: 10px;">
      <?=form_open('admin_library/update_col');?>
        <div style="display:none"><?= form_input('col','','class="iid"') ?></div>
        <div class="sec row">
          <div class="col two">Fabricante:</div>
          <?=form_dropdown('fab',$fab,'','class="six fabr icatname"')?>
        </div>
        <div class="sec row">
          <div class="col two t-six m-six">Colección:</div>
          <?=  form_input("name","",'class="six t-six m-six iname"')?>
        </div>
        <div class="sec row">
          <div class="col two t-six m-six">Tiene Descuentos:</div>
          <?= form_checkbox("disc","1",false,'class="idisc"')?>
        </div>
        <div class="sec row" style="padding:10px 0;">
          <div class="col two t-six m-six">Novedad:</div>
          <?= form_checkbox("novedad_bool","1",false,'class="novedad"')?>
        </div>    
        <div class="sec row"><div class="col two">Categorias:</div><?=form_multiselect('cats[]', array("0"=>"Papel Pintado","1"=>"Foto Murales","2"=>"Revestimientos","3"=>"Telas","4"=>"Alfombras")) ?></div>
        <div class="sec row"><div class="col two t-six m-six">Plazo Entrega (dias):</div><?=  form_input("plazo","",'class="six t-six m-six iplazo"')?></div>

        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="ed_text" name="col_text"></textarea></div>
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
    <?=form_open('admin_library/add_col');?>
       <div style="height: 20px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">ZONA COLECCIONES</div>
    <div style="height: 20px"></div>
    <div class="sec row"><div class="col two">Fabricante:</div><?=form_dropdown('fab',$fab,'','class="six fabr"')?></div>
    <div class="sec row"><div class="col two t-six m-six">Colección:</div><?=  form_input("name","",'class="six t-six m-six"')?></div>
    <div class="sec row"><div class="col two t-six m-six">Tiene Descuentos:</div>
        <?= form_checkbox("disc","1",false,'class="adisc"')?></div>
         <div class="sec row" style="padding:10px 0;">
    	<div class="col two t-six m-six">Novedad:</div>
        <?= form_checkbox("novedad_bool","1",false,'class="addnovedad"')?>
    </div> 
    <div class="sec row"><div class="col two">Categorias:</div><?=form_multiselect('cats[]', array("0"=>"Papel Pintado","1"=>"Foto Murales","2"=>"Revestimientos","3"=>"Telas","4"=>"Alfombras")) ?></div>
    <div class="sec row"><div class="col two t-six m-six">Plazo Entrega (dias):</div><?=  form_input("plazo","",'class="six t-six m-six"')?></div>
    <div class="sec row">Descripción (al menos 900 palabras):</div>
    <div class="sec row"><textarea id="col_text" name="col_text"></textarea></div>
    <br />
    <div class="">
      <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title", "", 'class="ten"') ?></div>
      <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description", "", 'class="ten" style="height:50px"') ?></div>
      <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords", "", 'class="ten"') ?></div>
      <br />
    </div>
    <?=form_submit("test", "Guardar",'class="button orange-button twelve t-full m-full send"')?>
    <?=form_close();?>
       <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO COLECCIONES</div>
    <div style="height: 20px"></div>

<?php
/*
print '<pre><xmp>';
print_r($col);
print '</xmp></pre>';
exit;
*/
foreach ($col as $value) { 
?>
     <div class="sec row" id='coleccion_<?php echo $value->coleccion_id; ?>'>
       
       <div class="col one cid">
         <?=$value->coleccion_id?>
         <span class="imguploader" ref="<?= $value->coleccion_id . ":col_" . $value->coleccion_id ?>" style="background-color: #000;display:block;width:74px;height:74px">
            <? if ($value->col_img != "") { ?>
              <img src="<?php echo $includes_dir . str_replace("../", "", $value->col_img); ?>th.jpg" width="74" height="74"/>
            <? } ?>
          </span>
       </div>
       <div style="display:none" class="ccatid">
         <?=$value->cat_id?>
       </div>
       <div style="display:none" class="cmtitle">
         <?=$value->meta_titlec?>
       </div>
       <div style="display:none" class="cmdesc">
         <?=$value->meta_descriptionc?>
       </div>
       <div style="display:none" class="cmkey">
         <?=$value->meta_keywordsc?>
       </div>
       <div class="col two ccatname">
         <?=$value->cat_name?>
         <span class="imguploader2" ref="<?= $value->coleccion_id . ":col_" . $value->coleccion_id ?>" style="background-color: #000;display:block;width:74px;height:74px">
            <? if ($value->col_ambimg != "") { ?>
              <img src="<?php echo $includes_dir . str_replace("../", "", $value->col_ambimg); ?>th.jpg" width="74" height="74"/>
            <? } ?>
          </span>
       </div>
       <div class="col one cplazo">
         <?=$value->plazo?>
       </div>
       <div class="col two cname">
         <?=$value->coleccion_name?>
       </div>
       
         
       <div class="col four ctex"> 
         <?=  $value->col_text?> 
       </div>
       <div class="col two t-two m-three">
        
          <span class="del btn" id="<?=$value->coleccion_id ?>"
            data-colname="<?= htmlspecialchars($value->coleccion_name) ?>"
            data-catname="<?= htmlspecialchars($value->cat_name) ?>"
            data-catid="<?= $value->cat_id ?>"
            data-cats="<?= $value->ccats ?>">Del</span>
          <span class="edit btn" data-disc="<?=$value->cdisc?>" data-novedad="<?=$value->novedad_bool?>" data-cats="<?= $value->ccats ?>" id="<?=$value->coleccion_id?>">Edit</span>
          <span data-publico="<?if($value->publico2==1)echo "0";else echo "1";?>" class="publicar btn" id="<?= $value->coleccion_id ?>">
            <?if($value->publico2==1)echo "Ocultar";else echo "Publicar";?>
            </span>
      </div>
   </div>
      
<?}//$this->load->view('demo/paginador');?>
  </div>
    <?php 
    $this->load->view('includes/scripts'); ?> 
    <script type="text/javascript" src="<?=$includes_dir?>/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
  relative_urls : false,
          remove_script_host : true,
   selector: "textarea:not(#del-col-modal-from)",
    
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
      var text='<div class="sec row"><div class="col one">'+d.coleccion_id+'</div><div class="col two">'+d.cat_name+
       '</div><div class="col eight">'+d.coleccion_name+'</div><div id="'+d.coleccion_id+'" class="col one del">Del</div></div>';
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
        form_data["disc"]= $(".adisc").prop("checked");
        form_data["col_text"] = tinymce.get('col_text').getContent();
        form_data["novedad_bool"]= $(".addnovedad").prop("checked");

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
		var form_data = {};
		$form_inputs.each(function()
		{
			form_data[this.name] = $(this).val();
		});
        form_data["disc"]= $(".idisc").prop("checked");
        form_data["novedad_bool"]= $(".novedad").prop("checked");
        form_data["col_text"] = tinymce.get('ed_text').getContent();

		$.ajax(
		{
			url: submit_url,
			type: 'POST',
			data: form_data,
			success:function(data)
			{
				$("#editform").hide();
                container2.attr('data-disc',(form_data["disc"])?"1":"0");
                container2.parent().parent().find(".ctex").html(form_data["col_text"]);
                container2.parent().parent().find(".cname").html(form_data["name"]);
                container2.parent().parent().find(".cmtitle").html(form_data["meta_title"]);
                container2.parent().parent().find(".cmdesc").html(form_data["meta_description"]);
                container2.parent().parent().find(".cmkey").html(form_data["meta_keywords"]);
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
      var colId   = $(this).attr('id');
      var colName = $(this).data('colname') || colId;
      var catName = $(this).data('catname') || '';
      var catId   = $(this).data('catid') || '';
      var cats    = String($(this).data('cats') || '0').split(',');
      var row     = $(this).parent().parent();

      var catPaths = {'0':'papel-pintado','1':'murales','2':'revestimientos','3':'telas','4':'alfombras'};
      var fromLines = [];
      cats.forEach(function(c){
        c = $.trim(c);
        if (catPaths[c])
          fromLines.push('/tienda/'+catPaths[c]+'/marca/'+catId+'/'+urlenc(catName)+'/'+colId+'/'+urlenc(colName));
      });

      $('#del-col-modal-name').text(colName + ' (' + catName + ')');
      $('#del-col-modal-from').val(fromLines.join("\n"));
      $('#del-col-modal-to').val('');
      $('#del-col-modal').data('col-id', colId).data('row', row).show();
    });
    $('.row').on('click','.publicar',function(e){
    var t=$(this).attr('id');
     var pub=$(this).html();
    if(pub=="Publicar")pub="1";
    else pub="0";
    var p=$(this);
      $.ajax({
        url:"<?=site_url('admin_library/publica_col')?>",
        type:'POST',
        data:'&activar='+pub+'&i='+t,
        success:function(data){
          if(data=="0"){p.html("Publicar");p.attr('data-publico',data);}
          else if(data=="1"){p.html("Ocultar");p.attr('data-publico',data);}
        }
      });
    });
    $(".fabr").change();
    $('.row').on('click','.edit', function(e) {
      var t = $(this).attr('id');
      var cats= $(this).attr('data-cats').split(",");
      console.log('Editar id: '+t);
      console.log('cats: '+cats);
        p = $(this).parent().parent();
        container2=$(this);
        $('#editform').show();
        $('.iid').val(p.find('.cid').text().trim());
        $('.icatname').val(p.find('.ccatid').text().trim())
        $('.iname').val(p.find('.cname').text().trim());
        $('.iplazo').val(p.find('.cplazo').text().trim());
        $('.imtitle').val(p.find('.cmtitle').text().trim());
        $('.imdesc').val(p.find('.cmdesc').text().trim());
        $('.imkey').val(p.find('.cmkey').text().trim());
       
        if($(this).attr("data-disc") == "1"){
          $('.idisc').prop('checked', true );
        }else $('.idisc').prop('checked', false );
        if($(this).attr("data-novedad") == "1"){
          $('.novedad').prop('checked', true );
        }else $('.novedad').prop('checked', false );
        
        //$("#editform select[name='cats[]']").val("");
        $("#editform select[name='cats[]'] option:selected").attr("selected", false);
        //$("#editform select[name='cats[]']").multiselect('refresh');
        cats.forEach(function(e) {
          console.log('seleccionar cat: '+e);
          $("#editform select[name='cats[]']").find('option[value="' + e + '"]').attr("selected", true);
        });
       // alert(p.find('.ctex').html());
        tinymce.get('ed_text').setContent(p.find('.ctex').html());
    });
      $(".close").click(function(){
  $("#editform").hide();  
  });
</script>
<script>
    function sendFileToServer(formData, status, ref)
    {
      var uploadURL = "<?= $includes_dir ?>grid/up002uy.php"; //Upload URL
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

    function sendFileToServer2(formData, status, ref)
    {
      var uploadURL = "<?= $includes_dir ?>grid/up003uy.php"; //Upload URL
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
    function handleFileUpload2(files, obj, ref)
    {
      for (var i = 0; i < files.length; i++)
      {
        var fd = new FormData();
        fd.append('file', files[i]);
        fd.append('fname', ref);

        var status = new createStatusbar(obj); //Using this we can set progress.
        status.setFileNameSize(files[i].name, files[i].size);
        sendFileToServer2(fd, status, ref);
      }
    }
    function sP(e) {
      e.stopPropagation();
      e.preventDefault();
    }
    $(document).ready(function() {
      var obj = $(".imguploader");
      var obj2 = $(".imguploader2");
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
      $('.row').on('dragenter',".imguploader2", function(e) {
        sP(e);
        $(this).css('border', '2px solid #0B85A1');
      });
      $('.row').on('dragover',".imguploader2", function(e) {
        sP(e);
      });
      $('.row').on('drop',".imguploader2", function(e) {
        $(this).css('border', '2px dotted #0B85A1');
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        handleFileUpload2(files, $(this), $(this).attr("ref"));
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

  <!-- Modal borrar colección con redirección -->
  <div id="del-col-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;z-index:200;background:rgba(0,0,0,0.6);padding:20px;box-sizing:border-box">
    <div style="background:#fff;max-width:600px;margin:60px auto;border-radius:8px;padding:24px;box-shadow:0 8px 32px rgba(0,0,0,0.3)">
      <div style="font-size:18px;font-weight:bold;margin-bottom:4px;color:#c0392b">Eliminar colección</div>
      <div style="color:#555;margin-bottom:16px" id="del-col-modal-name"></div>
      <div style="margin-bottom:6px;font-weight:bold">URLs a redirigir <span style="font-weight:normal;color:#888">(una por línea — edita si no son correctas)</span>:</div>
      <textarea id="del-col-modal-from" rows="3" style="width:100%;box-sizing:border-box;padding:8px;font-size:12px;font-family:monospace;border:1px solid #ccc;border-radius:4px;margin-bottom:14px"></textarea>
      <div style="margin-bottom:8px;font-weight:bold">Redirigir a <span style="font-weight:normal;color:#888">(deja vacío para borrar sin redirección)</span>:</div>
      <input id="del-col-modal-to" type="text" placeholder="/tienda/papel-pintado o URL de otra colección similar" style="width:100%;box-sizing:border-box;padding:8px;font-size:13px;border:1px solid #ccc;border-radius:4px;margin-bottom:20px"/>
      <div style="display:flex;gap:10px">
        <button id="del-col-modal-confirm" style="flex:1;background:#c0392b;color:#fff;border:none;padding:10px;border-radius:4px;cursor:pointer;font-size:14px;font-weight:bold">Eliminar colección</button>
        <button id="del-col-modal-cancel" style="flex:1;background:#aaa;color:#fff;border:none;padding:10px;border-radius:4px;cursor:pointer;font-size:14px">Cancelar</button>
      </div>
    </div>
  </div>
  <script>
  function urlenc(str) {
    var s = ['ç','æ','œ','á','é','í','ó','ú','à','è','ì','ò','ù','ä','ë','ï','ö','ü','ÿ','â','ê','î','ô','û','å','e','i','ø','u','Á','É','Í','Ó','Ú','Ñ','%','!','(',')'];
    var r = ['c','ae','oe','a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','y','a','e','i','o','u','a','e','i','o','u','a','e','i','o','u','n','','','',''];
    str = str.toLowerCase().replace(/ /g,'-').replace(/,/g,'').replace(/\+/g,'-plus-').replace(/#/g,'number-').replace(/&/g,'and');
    for (var i=0;i<s.length;i++) str = str.split(s[i]).join(r[i]);
    return str;
  }
  $('#del-col-modal-cancel').click(function(){ $('#del-col-modal').hide(); });
  $('#del-col-modal').click(function(e){ if($(e.target).is('#del-col-modal')) $(this).hide(); });
  $('#del-col-modal-confirm').click(function(){
    var modal  = $('#del-col-modal');
    var colId  = modal.data('col-id');
    var row    = modal.data('row');
    var urlTo  = $.trim($('#del-col-modal-to').val());
    var urlsFrom = $('#del-col-modal-from').val().split("\n").map(function(s){ return $.trim(s); }).filter(function(s){ return s!=''; });
    modal.hide();
    $.ajax({
      url: "<?= site_url('admin_library/del_col_redirect') ?>",
      type: 'POST',
      data: { col_id: colId, urls_from: urlsFrom, url_to: urlTo },
      success: function(){ row.slideUp(300); }
    });
  });
  </script>
</body>
</html>
