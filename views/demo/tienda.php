<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title>DePapelPintado.com </title>
    <meta name="description" content="."/> 
    <meta name="keywords" content=""/>
    <?php $this->load->view('includes/scripts'); ?>
    <script src="<?php echo $includes_dir; ?>js/jquery.slides.min.js"></script>
     <script src="<?php echo $includes_dir; ?>js/ths.js"></script>
   
    <link href='http://fonts.googleapis.com/css?family=Rochester' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Archivo+Narrow:400,700' rel='stylesheet' type='text/css'>
    <?php $this->load->view('includes/head'); ?> 
  </head>
  <body id="cart">
    <script>
      // Hide content onload, prevents JS flicker
      document.body.className += ' js-enabled';
      var categ= "<?=$categ?>";
    </script>
    <?php $this->load->view('includes/tienda_header'); ?> 
    <div id="menuspace" style="display:none;height: 65px"></div>
    <div class="aire2"></div>
    <div class="container f0 infocont"><?=$portada->texto?></div>
    <div class="container">
  <div class="col twelve t-full m-full migas" >___</div></div>
    <div class="container f0 itemshop">
      <div class="col two t-two m-three" style="display:none"></div>
    </div>
      <!-- Footer -->  
      <?php //$this->load->view('includes/footer');  ?> 
    </div>
    <!-- Scripts -->     
    <script>
      var sr = "";
      var cole="";
      var econ;
      $(".estilos li").on('contextmenu', function(ev) {
        cole="";
        search="";
        econ=false;
        $(".infocont").html("");
        var checkbox = $(this).children("input");
        var check = checkbox.prop("checked");
        fab='';
        cell = checkbox.parents('li');
        checkbox.prop("checked", !check);
        checkbox.is(':checked') ? cell.addClass('activecell') : cell.removeClass('activecell');
        timer(1000);
        ev.stopImmediatePropagation();
        return false;
      });
      $(".estilos li input").on('click', function(ev) {
        cole="";
        search="";
        econ=false;
        $(".infocont").html("");
        fab='';
        var checkbox = $(this);
        var check = checkbox.prop("checked");
        $(".estilos li").removeClass('activecell');
        $(".estilos input").prop("checked", false);
        $(this).prop("checked", check);
        cell = checkbox.parents('li');
        checkbox.is(':checked') ? cell.addClass('activecell') : cell.removeClass('activecell');
        $(this).parent().parent().parent().stop().animate({'height':'0'}, 400);
        timer(1000);
      }).change();
      
      $(".infocont").on("click",".logoindex",function(e){
        e.preventDefault();
        e.stopPropagation();
        $(".estilos li").removeClass('activecell');
        $(".estilos input").prop("checked", false);
        cole="";
        search="";
        econ=false;
        $(".infocont").html("");
        fab=$(this).attr('data-id');
        timer(0);
      }).change();
      $("#mcts1").on("click",".logoindex",function(e){
        e.preventDefault();
        e.stopPropagation();
        $(".estilos li").removeClass('activecell');
        $(".estilos input").prop("checked", false);
        cole="";
        search="";
        econ=false;
        $(".infocont").html("");
       fab=$(this).attr('data-id');
        timer(0);
      }).change();
      $(".fabmenu").click(function(e){ 
        e.preventDefault();
        e.stopPropagation();
         $.ajax({
            url: "<?= $base_url ?>tienda/fabricantes/"+categ,
            type: 'POST',
            success: function(json){
             $(".infocont").html(json);
             $('html,body').animate({
                scrollTop: $(".infocont").offset().top-85
              });
            }
            });
      });
      $(".colores input").on('click', function() { 
        econ=false;
        $(".infocont").html("");
       fab='';
       search="";
        $(this).parent().parent().parent().stop().animate({'height':'0'}, 400);
        timer(3000);
      });
      $(".sort_items").on('change', function() { timer(500); });
      $("#economicos").click(function(e){
        econ=true;
        e.preventDefault();
        e.stopPropagation();
         $(".infocont").html("");
        fab='';
        search="";
         $('.colores input:checked').attr("checked",false);
         $('.estilos input:checked').attr("checked",false);
          $(".migas").html("ECONÓMICOS");
        timer(100);
         $('html,body').animate({
                scrollTop: $(".infocont").offset().top-75
              });
      })
      
      var requesting = false;
      $(".opencal").click(function(){
        $("#overlay2").fadeIn();
        var h= $(window).height();
        var w= $(window).width();
        
        $(".contentWrap2").css({top:(h-300)/2,left:(w-350)/2,width:350,height:300});
      })
      $(".itemshop").on("click",".info2",function(){
        $("#overlay4").fadeIn();
        $(".papermed4").attr("src","<?php echo $includes_dir ?>" + $(this).attr("data-img").replace("../", "")+"med.jpg");
        $(".precio").text($(this).attr("data-precio")+"€/"+$(this).attr("data-ud"));
        $(".coldesc4").html($(this).attr("data-itemtext"));
        $(".dettitle4").html($(this).attr("data-ref")+" / "+$(this).attr("data-name"));
        var h= $(window).height();
        var w= $(window).width();
        
        $(".contentWrap").css({top:(h-575)/2,left:(w-1075)/2,width:1075,height:575});
      });
      $(".itemshop").on("click",".info",function(){
        var t=$(this).parent().parent().next(".tooltip");
        $("#overlay").fadeIn();
        $("#papermed").attr("src","<?php echo $includes_dir ?>" + $(this).attr("data-img").replace("../", "")+"med.jpg");
        //$("#papermed").parent().attr("href","<?php echo $includes_dir ?>" + $(this).attr("data-img").replace("../", "")+"med.jpg");
        $("#ambmed").attr("src","<?php echo $includes_dir ?>" + $(this).attr("data-amb").replace("../", "")+"med.jpg");
        //$("#ambmed").parent().attr("href","<?php echo $includes_dir ?>" + $(this).attr("data-amb").replace("../", "")+"med.jpg");
        $("#coldesc").html($(this).attr("data-coltext"));
        $("#dettitle").html($(this).attr("data-marca")+" / "+$(this).attr("data-col")+" / "+$(this).attr("data-ref"));
        $(".ancho").text($(this).attr("data-ancho")+"cm");
        $(".largo").text($(this).attr("data-largo")+"m");
        $(".case").text((($(this).attr("data-case")==0)?"NO":$(this).attr("data-case")+"cm"));
        $(".vinilo").text($(this).attr("data-vinilo"));
        $(".cola").text($(this).attr("data-cola"));
        $(".sol").text($(this).attr("data-sol"));
        $(".lavable").text($(this).attr("data-lavable"));
        $(".plazo").text($(this).attr("data-plazo"));
        $(".precio").text($(this).attr("data-precio")+"€/"+$(this).attr("data-ud"));
        $("#itemid").val($(this).attr("data-id"));
        $("#ud").val($(this).attr("data-ud"));
        if ($(this).attr("data-ud")=="m2") $(".m2").show();
        else $(".m2").hide();
        
        if($(this).attr("data-calcu")!=0)$("#unidades").val($(this).attr("data-calcu"));
       // $(".contentWrap").find(".selectdetail").html(t.html());
        var h= $(window).height();
        var w= $(window).width();
        
        $(".contentWrap").css({top:(h-575)/2,left:(w-1075)/2,width:1075,height:575});
      });
      $("#ambmed").click(function(){
        $(".imgoverlay").show();
        $(".infowarp").hide();
        $(".imgoverlay img").prop("src",$(this).attr("src"));
         var h= $(window).height();
        var w= $(window).width();
        $(".imgoverlay img").css({height:h-20,margin:10});
        var w2=$(".imgoverlay img").width()+20;
        $(".imgoverlay").css({top:0,left: ((w-w2)/2),width:w2,height:h});
      });
      $("#papermed").click(function(){
        $(".imgoverlay").show();
        $(".infowarp").hide();
        $(".imgoverlay img").prop("src",$(this).attr("src"));
        var h= $(window).height();
        var w= $(window).width();
        $(".imgoverlay img").css({height:h-20,margin:10});
        var w2=$(".imgoverlay img").width()+20;
        $(".imgoverlay").css({top:0,left: ((w-w2)/2),width:w2,height:h});
      });
      $(".imgoverlay").click(function(){
        $(".imgoverlay").hide();
        $(".infowarp").show();
      });
      $("#overlay").click( function(){
        $(".infowarp").show();
        $("#overlay").fadeOut();
        $(".imgoverlay").hide();
      });
      $(".close,").click( function(){
        $(".infowarp").show();
        $(this).parent().parent().fadeOut();
        $(".imgoverlay").hide();
      });
      $("#search").submit(function(e){e.preventDefault();e.stopPropagation();search=$("#searchfield").val();timer(10);});
      $(".pop").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        var thisid=$(this).attr('data-id');
         $.ajax({
            url: "<?= $base_url ?>tienda/get_page/"+ thisid ,
            type: 'POST',
            dataType: 'json',
            success: function(json){
               var h= $(window).height();
               var w= $(window).width();
               $("#overlay3").show();
              $(".contentWrap3 .dettitle").html(json['titulo']);
               $(".contentWrap3 .texto").html(json['texto']);
              $(".contentWrap3").css({top:(h-json['alto'])/2,left:(w-json['ancho'])/2,width:json['ancho'],height:json['alto']});
            }});
      });
      $("#overlay2,#overlay3,#overlay4, .closecal").click( function(){
        $("#overlay2").fadeOut();
         $("#overlay3").fadeOut();
         $("#overlay4").fadeOut();
      });
      $(".contentWrap2").click( function(e){
        e.stopPropagation();
      });
      $(".contentWrap").click( function(e){
        e.stopPropagation();
      });
      $(".imageoverlay img").click( function(e){
        $(".imgoverlay").hide();
      });
      var paredancho= parseFloat($("#paredancho").val());
      var paredalto= parseFloat($("#paredalto").val());
      var calcu=false;
      function calcular(){
        if (categ==1){
          alert("Calculadora no disponible para murales")
        }
        else if (categ<3){
          paredancho= parseFloat($("#paredancho").val());
          paredalto= parseFloat($("#paredalto").val());
          $(".info").each(function(){
            calcula($(this),paredancho,paredalto);
          });
          if(sr.attr("data-calcu")!=0)$("#unidades").val(sr.attr("data-calcu"));
          calcu=true;
        }
        else{
          alert("Calculadora no disponible para estos articulos");
        }
 
      }
      function calcula(elem){
        var ancho = parseFloat(elem.attr("data-ancho"))/100;
         var rollo = parseFloat(elem.attr("data-largo"));
         var caser = parseFloat(elem.attr("data-case"))/100;
         elem.attr("data-calcu",calcuval(ancho,rollo,caser));
      }
      function calcuval(ancho,rollo,caser){
        if(categ==0){
         var segmentos=Math.ceil(paredancho/ancho);
         if(caser>0.005){
          var tiracase=paredalto%caser;
          var tirafinal=paredalto+caser-tiracase;
         }
         else var tirafinal=paredalto;
         var rollofinal=Math.floor(rollo/tirafinal);
         return Math.ceil(segmentos/rollofinal);
        }
        if(categ==2){
           var segmentos=Math.ceil(paredancho/ancho);
            if(caser>0.005){
              var tiracase=paredalto%caser;
              var tirafinal=paredalto+caser-tiracase;
             }
            else var tirafinal=paredalto;
            return Math.ceil(tirafinal*segmentos);
        }
      }
      function timer(time) {
        $(".updatebar>div").width(0);
        $(".itemshop").html('<div class="col two" style="display:block;height:' + $(window).height() + 'px"></div>');
        requesting = false;
        
          currentpage = 0;
          if(fab!='')$('.ma').addClass("sombra2");else $('.ma').removeClass('sombra2');
          var est = $('.estilos input:checked').map(function(i, n) { return $(n).val(); }).get().join();
         
          if(est!='')$('#es').addClass("sombra2");else $('#es').removeClass('sombra2');
          var col = $('.colores input:checked').map(function(i, n) { return $(n).val(); }).get().join();
          if(col!='')$('#co').addClass("sombra2");else $('#co').removeClass('sombra2');
          if(econ)$('.ec').addClass("sombra2");else $('.ec').removeClass('sombra2');
         if (time!=0) requestnext();
         else requestfab();
        
      }
      function requestcol(){
        
          $.ajax({
            url: "<?= $base_url ?>tienda/get_next_cole/0/0/0/" + currentpage,
            type: 'POST',
            dataType: 'json',
            data: {'col': cole},
            success: function(json){
       $(".itemshop").html('<div class="col twelve t-full m-full" ></div>');
       $(".migas").html($("#catname").html()+" / "+json[0].coleccion_name);    
              for (var i = 0; i < json.length; i++) {
                var a = json[i];
                item(a);
            }
            $('html,body').animate({
                scrollTop: $(".itemshop").offset().top-75
              });
          }});
      }
      var fab='';
      function requestfab(){
        if (!requesting) {
          requesting = true;
          //var fab = $('.fabricantes input:checked').map(function(i, n) { return $(n).val(); }).get().join();
          var est = $('.estilos input:checked').map(function(i, n) { return $(n).val(); }).get().join();
          var col = $('.colores input:checked').map(function(i, n) { return $(n).val(); }).get().join();
          var ord = $('.sort_items').val();
          $.ajax({
            url: "<?= $base_url ?>tienda/get_next_fab/0/0/0/" + currentpage,
            type: 'POST',
            data: {'est': est, 'col': col, 'fab': fab, 'ord': ord, 'categ':categ},
            success: function(json){
              $(".infocont").html(json);
              $(".migas").html($("#catname").html());
            if($('#slidefab>img').length>1){
              $('#slidefab').slidesjs({
                width:480,
                height: 400,
                play: {active: false, effect: "fade", auto: true, interval: 3000, swap: true},
                effect: {fade: {speed: 800 }},
                navigation: {active: false},
                pagination: {active: false}
              });
            }
          
            $('html,body').animate({
                scrollTop: $(".infocont").offset().top-85
              });
          
              currentpage=-1;
              requesting=false;
              requestnext();
            }
          });
        }
      }
      var search="";
      function requestnext() {
        if (!requesting) {
          requesting = true;
          //var fab = $('.fabricantes input:checked').map(function(i, n) { return $(n).val(); }).get().join();
          var est = $('.estilos input:checked').map(function(i, n) { return $(n).val(); }).get().join();
          var col = $('.colores input:checked').map(function(i, n) { return $(n).val(); }).get().join();
          var ord = $('.sort_items').val();
          $.ajax({
            url: "<?= $base_url ?>tienda/get_next/0/0/0/" + currentpage,
            dataType: 'json',
            type: 'POST',
            data: { 'est': est, 'col': col, 'fab': fab, 'ord': '', 'categ':categ,'econ':((econ)?1:0),'search':search },
            success: function(json)
            {
              if (currentpage == 0){
                var miga=(econ)?"ECONOMICOS":"";
                $(".migas").html(miga);
                $(".itemshop").html('<div class="col twelve t-full m-full" ></div>');
              }
              if (currentpage<0){
           
              
                 $(".itemshop").html('<div class="col twelve t-full m-full" ></div>');
                currentpage=0;
              }
              for (var i = 0; i < json.length; i++) {
                var a = json[i];
                item(a);
              }
              currentpage++;
              requesting = false;
            },
            error: function(data) {
              alert("data");
            }
          });
        }
      }
      function item(a){
        var dimensiones= "";
        var descuento="";
        var datad='class="info" data-id="'+a.item_id+'" data-ref="' + a.item_ref + '" data-amb="' + a.imgamb + '" data-img="' + a.img + '" data-tipo="'+a.item_tipo+'" data-ud="'+a.item_unidad+'" data-plazo="'+a.plazo+'días laborables" data-precio="'+a.item_price+'" data-cola="'+((a.item_cola == "pared") ? "PARED" : "PAPEL")+'" data-vinilo="'+((a.item_vinilo == 1) ? "SI" : "NO")+'" data-sol="'+((a.item_sol == 1) ? "SI" : "NO")+'" data-lavable="'+((a.item_lavable == 1) ? "Lavable" : "No Lavable")+'" data-case="'+a.item_case+'" data-largo="'+a.item_largo+'" data-ancho=\''+a.item_ancho+'\' data-marca="'+ a.cat_name +'" data-col="'+a.coleccion_name+'" data-coltext=\''+a.col_text+'\'';
    if(calcu){
      datad+=' data-calcu="'+calcuval(parseFloat(a.item_ancho)/100,parseFloat(a.item_largo),parseFloat(a.item_case)/100)+'"';
    }
    var vd=true;
    var d="";
                if (a.item_unidad!="Unidad") dimensiones= '<div>ancho del rollo: <span>' + a.item_ancho + 'cm</span></div><div>largo del rollo: <span>' + a.item_largo + 'm</span></div>';
                else dimensiones='<div>dimensiones: <span>' + Math.round(a.item_ancho) +'x'+ Math.round(a.item_largo) +'cm</span></div>';
               
  if(a.disc_id){
                  if(a.disc_type_fk=='1'){
                    if(a.disc_method_fk=='1'){
                      descuento='<span><strike>' + a.item_price + ' €/'+a.item_unidad+'</strike></span><br><span style="font-size:18px;color:#AE0058"><strong>' + ((a.item_price*(100-a.disc_value_discounted))/100).toFixed(2) + ' €/'+a.item_unidad+'</strong>';
                      d='<img '+datad+' class="info"  src="<?=$includes_dir?>flags/base.png" style="position:relative;top:-161px;"/>';
                      datad="";
                    }
                    if(a.disc_method_fk=='2'){
                      descuento='<span><strike>' + a.item_price + ' €/'+a.item_unidad+'</strike></span><br><span style="font-size:18px;color:#AE0058"><strong>' + ((a.item_price-a.disc_value_discounted).toFixed(2)) + ' €/'+a.item_unidad+'</strong>';
                      d='<img '+datad+' class="info"  src="<?=$includes_dir?>flags/base.png" style="position:relative;top:-161px;"/>';
                      datad="";
                    }
                  }
                }
                else if(a.item_economico!=0){
                  descuento='<span style="font-size:18px;color:#AE0058"><strong>' + ((a.item_price*(100-a.disc_value_discounted))/100).toFixed(2) + ' €/'+a.item_unidad+'</strong>';
                      d='<img '+datad+' class="info"  src="<?=$includes_dir?>flags/base.png" style="position:relative;top:-161px;"/>';
                      datad="";
                }
                else{
                  descuento='<span><strong>' + a.item_price + ' €/'+a.item_unidad+'</strong>';
                }
                 if(a.item_tipo==5){
        $(".itemshop").append('<div class="itm col two t-two m-three" style="height:230px; display:block;"><span  style="background-color: #000;display:block;width:158px;height:158px">\n\
    <img class="info2" data-precio="'+a.item_price+'" data-itemtext=\''+a.item_text+'\' data-name="'+a.item_name+'" data-id="'+a.item_id+'" data-ref="' + a.item_ref + '" data-amb="' + a.imgamb + '" data-img="' + a.img + '" data-tipo="'+a.item_tipo+'" data-ud="'+a.item_unidad+'" width="158" height="158" alt="' + a.item_id + '" src="<?php echo $includes_dir; ?>' + a.img.replace("../", "") + 'th.jpg"/>'+d+'</span>\n\
    <span class="lte">' + a.item_ref + '<br/></span>'+descuento+'<span style="float:right"><a class="add_item_via_ajax_link" href="<?php echo $base_url; ?>tienda/insert_database_item_to_cart/' + a.item_id + '"><img style="position:relative;top:-10px;" title="Añadir al carro" src="<?=$includes_dir?>images/carroadd.png" width="30"></a> &nbsp; </span></div>');
      return;
      }
                $(".itemshop").append('<div class="itm col two t-two m-three" style="height:230px; display:block;"><span  style="background-color: #000;display:block;width:158px;height:158px">\n\
    <img '+datad+' width="158" height="158" alt="' + a.item_id + '" src="<?php echo $includes_dir; ?>' + a.img.replace("../", "") + 'th.jpg"/>'+d+'</span>\n\
    <span class="lte">' + a.coleccion_name + '<br/>' + a.item_ref + '<br/></span>'+descuento+'<span style="float:right"><a class="add_item_via_ajax_link" href="<?php echo $base_url; ?>tienda/insert_database_item_to_cart/' + a.item_id + '"><img style="position:relative;top:-10px;" title="Añadir al carro" src="<?=$includes_dir?>images/carroadd.png" width="30"></a> &nbsp; </span></div><div class="tooltip">' +
                        '<div class="title"><strong>' + a.cat_name + ' - ' + a.coleccion_name + '</strong></div>' +
                       '<div>'+ dimensiones+
                        ((a.item_case!=0)?'<div>case: <span>' + a.item_case + 'cm</span></div>':'') +
                        '<div>lavable: <span>' + ((a.item_lavable == 1) ? "SI" : "NO") + '</span></div>' +
                        '<div>Resistente al sol: <span>' + ((a.item_sol == 1) ? "SI" : "NO") + '</span></div>' +
                        '<div>Vinilo: <span>' + ((a.item_vinilo == 1) ? "SI" : "NO") + '</span></div>' +
                        '<div>Encolar: <span>' + ((a.item_cola == "pared") ? "PARED" : "PAPEL") + '</span></div>' +
                        '<div>Precio: <span>' + a.item_price + ' €/'+a.item_unidad+'</span></div>' +
                        '<div>Plazo de entrega: <span>' + a.plazo + ' días laborables</span></div>' +
                        '</div></div>');
                $(".itemshop .itm").last().trigger('new');
      }
      $(window).ready(function() {
        $(".updatebar>div").width(0);
        currentpage = 0;
        requestnext();
        // select the overlay element - and "make it an overlay"
        $("#overlay").overlay({
          mask: '#ccc',
          top: 'center',
          effect: 'apple',
          onBeforeLoad: function() {
            // grab wrapper element inside content
            var wrap = this.getOverlay().find(".contentWrap");
            // load the page specified in the trigger
            wrap.html('<img  width=450 src="' + sr.attr("src").replace("th.jpg", "med.jpg") + '"/>' + "AAAAAAAAAAAA</br>");
          }
        });
      });
      $(".addformitem").click(function(event){
        event.preventDefault();
        $("#overlay").fadeOut();
        $.ajax({
          url: "<?php echo $base_url; ?>tienda/insert_database_item_to_cart/"+$("#itemid").val() ,
          type: 'POST',
          data: { 'qty': $("#unidades").val(),'p_ancho':$("#p_ancho").val(),'p_alto':$("#p_alto").val(),'ud':$("#ud").val()},
          success: function(data)
          {
            ajax_update_mini_cart(data);
          }
        });
      });
      $(".addformsample").click(function(event){
        event.preventDefault();
        $("#overlay").fadeOut();
        $.ajax({
          url: "<?php echo $base_url; ?>tienda/insert_database_item_to_cart/"+$("#itemid").val() ,
          type: 'POST',
          data: { 'sample': 1},
          success: function(data)
          {
            ajax_update_mini_cart(data);
          }
        });
      });
      $(".itemshop").on('click', '.add_item_via_ajax_link', function(event){
        event.preventDefault();
        $.ajax({
          url: $(this).attr('href'),
          success: function(data)
          {
            ajax_update_mini_cart(data);
          }
        });
      });
      $(function() {
        $('select[name^="shipping"], input[name^="shipping"]').live('change', function() {
          var data = new Object();
          $('select[name^="shipping"], input[name^="shipping"]').each(function() {
            data[$(this).attr('name')] = $(this).val();
          });
          data['update'] = true;
          data['csrf_test_name'] = $('input[name="csrf_test_name"]').val();
          $('#cart_content').load('<?php echo current_url(); ?> #ajax_content', data);
        });
      });
      function ajax_update_mini_cart(data) {
        var ajax_mini_cart = $(data).find('#mini_cart');
        $('#mini_cart').replaceWith(ajax_mini_cart);
        $('#mini_cart_status').show();
        var min_cart_height = $('#mini_cart ul:first').height();
        $('#mini_cart').attr('data-menu-height', min_cart_height);
        $('#mini_cart').attr('class', 'js_nav_dropmenu');
       
          $('#mini_cart ul:first').stop().animate({'height': min_cart_height}, 400).delay(3000).animate({'height': '0'}, 400, function()
          {
            $('#mini_cart_status').hide();
          });
        
      }
      $(function() {
        $('#slides').slidesjs({
          width: 946,
          height: 310,
          play: {active: false, effect: "fade", auto: true, interval: 5000, swap: true},
          effect: {fade: {speed: 1000, crossfade:true}},
          navigation: {active: false},
          pagination: {active: false}
        });
      });
      var isRunning = false;
      var currentpage = 0;
      $(function() {
        var nav = $('#menu');
        nav.css({position: 'fixed', top: '35px', left: '50%', 'margin-left': -nav.width() / 2, width: nav.width(),'z-index':'35'});
        var navHomeY = nav.offset().top;
        var isFixed = false;
        var isDown = false;
        var $w = $(window);
        var scrollTop;
        $w.scroll(function() {
          isDown = $w.scrollTop() > $(document).height() - $w.height() - 150;
          if ((scrollTop > $w.scrollTop() || isRunning) && isDown) {
            scrollTop = $w.scrollTop();
            return;
          }
          scrollTop = $w.scrollTop();
          isDown = $w.scrollTop() > $(document).height() - $w.height() - 150;
          var shouldBeFixed = scrollTop > navHomeY-35;
/*         
          if (shouldBeFixed) {
            $("#menuspace").show();
            nav.css({position: 'fixed', top: '35px', left: '50%', 'margin-left': -nav.width() / 2, width: nav.width()});
            isFixed = true;
          }
          else if (!shouldBeFixed && isFixed) {
            $("#menuspace").hide();
            nav.css({position: '', left: '', top: '', 'margin-left': '', width: ''});
            isFixed = false;
          }
*/
          if (isDown && cole=="") {
            requestnext();
          }
        });
      });

      $(function() {
        $(".itemshop").on('click', '.info', function() {
          sr = $(this);
        });
        $(".infocont").on('click','.colecc',function(){
          cole =$(this).attr('data-id');
          requestcol();
        });
        $('.itm').live('new', function() {
          $(this).tooltip({
            effect: 'fade',
            predelay: 800,
            position: 'center left',
            offset: [-10, 0],
          }).dynamic({top: {direction: 'down', bounce: true}});
        });
      });
     
    </script>

    <div class="no-m no-t" style="position: fixed; top:85px; left:10px; width:44px; box-shadow: 0px 7px 14px -6px rgba(0,0,0,0.93);border-radius: 0px 0px 10px 10px; padding:5px;">
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/facebook.png" alt="facebook"/></a>
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/twitter.png" alt="twitter"/></a>
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/pinterest.png" alt="pinterest"/></a>
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/you_tube.png" alt="you tube"/></a>
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/google+.png" alt="google+"/></a>
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/mail.png" alt="contact"/></a>

    </div>
  </body>
</html>