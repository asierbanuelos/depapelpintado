<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Herramientas</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <div id="editform" style="position:fixed;top:0;width:100%;height:100%;z-index: 100;background-color:rgba(0,0,0,0.6);padding:20px;display:none;">
    <div class="container" style="background-color:#eee;padding: 10px;border-radius: 10px;">
      <?=form_open('admin_library/update_her');?>
      <div style="display:none"><?= form_input('iher','','class="iid"') ?></div>
      <div class="sec row"><div class="col four">Más Vendido: <?= form_checkbox("topventas","1") ?></div><div class="col four">Portada: <?= form_checkbox("portada","1") ?></div></div>
      <div class="sec row"><div class="col one t-six m-six">Referencia:</div>
        <div class="col ten t-six m-six"><?=  form_input("ref","",'class="iref"')?></div>
      </div>
      <div class="sec row"><div class="col one t-six m-six">Nombre:</div>
        <div class="col ten t-six m-six"><?=  form_input("name","",'class="iname"')?></div>
      </div>
      <div class="sec row"><div class="col one t-six m-six">Precio:</div>
        <div class="col ten t-six m-six"><?=  form_input("precio","",'class="iprice"')?></div>
      </div>
      
              <div class="sec row"><div class="col one t-six m-six">Descripción:</div>
      <div class="col ten t-six m-six"><textarea id="ed_text" name="ed_text"></textarea></div></div>
    <?=form_submit("test", "Guardar",'class="button orange-button six t-full m-full send2"')?>
      <?=form_button("test", "Cancelar",'class="button orange-button six t-full m-full close"')?>
    <?=form_close();?>
    </div>
  </div>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <?=form_open('admin_library/add_her');?>
    <div style="height: 20px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">ZONA HERRAMIENTAS</div>
    <div style="height: 20px"></div>
    <div class="sec row"><div class="col four">Más Vendido: <?= form_checkbox("topventas", "1") ?></div><div class="col four">Portada: <?= form_checkbox("portada", "1") ?></div></div>
    <div class="sec row"><div class="col one t-six m-six">Referencia:</div>
        <div class="col ten t-six m-six"><?=  form_input("ref","")?></div>
      </div>
      <div class="sec row"><div class="col one t-six m-six">Nombre:</div>
        <div class="col ten t-six m-six"><?=  form_input("name","")?></div>
      </div>
      <div class="sec row"><div class="col one t-six m-six">Precio:</div>
        <div class="col ten t-six m-six"><?=  form_input("precio","")?></div>
      </div>
    <div class="sec row">Descripción:</div>
      <div class="sec row"><textarea id="her_text" name="her_text"></textarea></div>
      <div style="height: 20px"></div>
    <?=form_submit("test", "Guardar",'class="button orange-button twelve t-full m-full send"')?>
    <?=form_close();?>
  <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO HERRAMIENTAS</div>
    <div style="height: 20px"></div>
 
<?
foreach ($her as $value){
	//~ if ($value['portada']){
	?>
	     <div style="border-bottom:dotted 1px #aaa" class="sec row">
	       <div class="col one t-two m-three">
		  <span class="imguploader" ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref'] ?>" style="background-color: #000;display:block;width:74px;height:74px">
		    <? if ($value['img'] != "") { ?>
		      <img src="<?php echo $includes_dir . str_replace("../", "", $value['img']); ?>th.jpg" width="74" height="74"/>
		    <? } ?>
		  </span>
		</div>
	       <div class="col one cid">
		 <?=$value['item_id']?>
	       </div>
	       <div class="col one cref">
		 <?=$value['item_ref']?>
	       </div>
	       <div class="col two cname">
		 <?=$value['item_name']?>
	       </div>
	       <div class="col one cprice">
		 <?=$value['item_price']?>
	       </div>
	       <div class="col four fixedh ctex">
			<?=$value['item_text']?>
	       </div>
	       <div style="display:none" class="cportada">
		 <?=$value['portada']?>
	       </div>
	       <div  style="display:none" class="ctop">
		 <?=$value['item_top']?>
	       </div>
	      <div class="col two t-two m-three">
		  <span class="del btn" id="<?= $value['item_id'] ?>">Del</span>
		  <span class="edit btn" id="<?= $value['item_id'] ?>">Edit</span>
		</div>
	     </div>
	<?
	//~ }
}
?>
  </div>
    <?php $this->load->view('includes/scripts'); ?> 
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
    function addline(d){
      var text='<div style="border-bottom:dotted 1px #aaa" class="sec row"><div class="col one">'+d.item_id+'</div><div class="col two">'+d.item_name+
              '</div><div class="col seven">'+d.item_text+'</div><div class="col two t-two m-three"><span class="del btn" id="'+d.item_id+'">Del</span><span  class="edit btn" id="'+d.item_id+'">Edit</span></div>';
       $('.list').prepend(text);
      
    }
  $('.send').click(function(event){
		event.preventDefault();
		var parent_form = $(this).closest('form');
       
		var submit_url = parent_form.attr('action');
		var $form_inputs = parent_form.find(':input');
        var $form_text=$('#her_text');
		var form_data = {};
		$form_inputs.each(function(){form_data[this.name] = $(this).val();});
    form_data["her_text"] = tinymce.get('her_text').getContent();
		
    //alert(submit_url);
    
    $.ajax({
			url: submit_url,
			type: 'POST',
			data: form_data,
			success:function(data){
				addline(jQuery.parseJSON(data)[0]);
        //alert('herramienta añadida');
			}
		});
	});
    $('.send2').click(function(event){
		event.preventDefault();
		 var parent_form = $(this).closest('form');
        var submit_url = parent_form.attr('action');
        var $form_inputs = parent_form.find(':input');
        var form_data = parent_form.serialize();
        
        //form_data["fab"]= $(".iid").val();
        form_data+="&her_text="+tinymce.get('ed_text').getContent({format : 'raw'});
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
        data:'&t=items&n=item&i='+t,
        success:function(data){p.slideUp();}
      });
      }
    });
    $('.row').on('click','.edit', function(e) {
        var t = $(this).attr('id');
        p = $(this).parent().parent();
        $('#editform').show();
        $("#editform input[name='topventas']").prop('checked', (p.find('.ctop').text().trim() == "1") ? true : false);
            $("#editform input[name='portada']").prop('checked', (p.find('.cportada').text().trim() == "1") ? true : false);
            
        $('.iid').val(p.find('.cid').text().trim());
        $('.iref').val(p.find('.cref').text().trim());
        $('.iprice').val(p.find('.cprice').text().trim());
        $('.iname').val(p.find('.cname').text().trim());
       // alert(p.find('.ctex').html());
        tinymce.get('ed_text').setContent(p.find('.ctex').html());
    });
    $(".close").click(function(){
  $("#editform").hide();  
  });

    function sendFileToServer(formData, status, ref)
    {
      var uploadURL = "<?= $includes_dir ?>grid/up000uy.php"; //Upload URL
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
      /*
      */
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