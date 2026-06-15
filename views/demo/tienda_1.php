<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title>DePapelPintado.com </title>
    <meta name="description" content="."/> 
    <meta name="keywords" content=""/>
    <?php $this->load->view('includes/scripts'); ?>
    <script src="<?php echo $includes_dir; ?>js/jquery.slides.min.js"></script>
    <?php $this->load->view('includes/admin_head'); ?> 
  </head>
  <body id="cart">
    <script>
      // Hide content onload, prevents JS flicker
      document.body.className += ' js-enabled';
    </script>
    
          <?php $this->load->view('includes/tienda_header'); ?> 
          </div></div>
      <div id="menuspace" style="display:none;height: 65px"></div>
      <div style="background-color: #5ff;height:50px;display:block;padding:10px;">BARRA DE Promos</div>
      <div style="background-color: #ff5;height:40px;display:block;padding:10px;">BARRA DE LOGOS</div>
      <div class="aire2"></div>
      
      <div class="container f0 itemshop">
        <div class="col two t-two m-three" style="display:none"></div>
        <?php //$this->load->view('demo/next');  ?> 
      </div>
      <!-- Footer -->  
      <?php //$this->load->view('includes/footer');  ?> 

    </div>

    <!-- Scripts -->     
    <script>
      var sr = "";

      $(".estilos>li").on('contextmenu', function(ev) {
        var checkbox = $(this).children("input");
        var check = checkbox.prop("checked");
        cell = checkbox.parents('li');
        checkbox.prop("checked", !check);
        checkbox.is(':checked') ? cell.addClass('activecell') : cell.removeClass('activecell');
        timer(3000);
        ev.stopImmediatePropagation();
        return false;
      });
      $(".estilos>li input").on('click', function(ev) {
        var checkbox = $(this);
        var check = checkbox.prop("checked");
        $(".estilos>li").removeClass('activecell');
        $(".estilos input").prop("checked", false);
        $(this).prop("checked", check);
        cell = checkbox.parents('li');
        checkbox.is(':checked') ? cell.addClass('activecell') : cell.removeClass('activecell');
        timer(1000);
      }).change();
      $(".fabricantes>li").on('contextmenu', function(ev) {
        var checkbox = $(this).children("input");
        var check = checkbox.prop("checked");
        cell = checkbox.parents('li');
        checkbox.prop("checked", !check);
        checkbox.is(':checked') ? cell.addClass('activecell') : cell.removeClass('activecell');
        timer(3000);
        ev.stopImmediatePropagation();
        return false;
      });
      $(".fabricantes>li input").on('click', function(ev) {
        var checkbox = $(this);
        var check = checkbox.prop("checked");
        $(".fabricantes>li").removeClass('activecell');
        $(".fabricantes input").prop("checked", false);
        checkbox.prop("checked", check);
        cell = checkbox.parents('li');
        checkbox.is(':checked') ? cell.addClass('activecell') : cell.removeClass('activecell');
        timer(1000);
      }).change();

      $(".colores input").on('click', function() {
        timer(3000);
      });
      $(".sort_items").on('change', function() {
        timer(500);
      });
      var requesting = false;

      function timer(time) {
        $(".updatebar>div").width(0);
        $(".itemshop").html('<div class="col two" style="display:block;height:' + $(window).height() + 'px"></div>');
        requesting = false;

        $(".updatebar>div").stop().animate({
          width: $(".updatebar").css("width"),
        }, time, function() {
          $(".updatebar>div").width(0);
          currentpage = 0;
          requestnext();


        });
      }
      function requestnext() {
        if (!requesting) {
          requesting = true;
          var fab = $('.fabricantes input:checked').map(function(i, n) {
            return $(n).val();
          }).get().join();
          var est = $('.estilos input:checked').map(function(i, n) {
            return $(n).val();
          }).get().join();
          var col = $('.colores input:checked').map(function(i, n) {
            return $(n).val();
          }).get().join();
          var ord = $('.sort_items').val();
          $.ajax({
            url: "<?= $base_url ?>standard_library/get_next/0/0/0/" + currentpage,
            dataType: 'json',
            type: 'POST',
            data: {
              'est': est,
              'col': col,
              'fab': fab,
              'ord': ord
            },
            success: function(json)
            {
              if (currentpage == 0)
                $(".itemshop").html('<div class="col two t-two m-three" style="display:none"></div>');
              for (var i = 0; i < json.length; i++) {
                var a = json[i];
                $(".itemshop").append('<div class="itm col two t-two m-three" style="height:230px; display:block;"><span  style="background-color: #000;display:block;width:158px;height:158px">\n\
    <img data-amb="' + a.imgamb + '" data-img="' + a.img + '" class="info" width="158" height="158" alt="' + a.item_id + '" src="<?php echo $includes_dir ?>' + a.img.replace("../", "") + 'th.jpg"/></span>\n\
    <span><small><strong>' + a.coleccion_name + '</strong><br/>' + a.item_price + ' €/Rollo<span style="float:right"><a class="add_item_via_ajax_link" href="<?php echo $base_url; ?>standard_library/insert_database_item_to_cart/' + a.item_id + '">Add</a> &nbsp; </span><br/>2 Rollos:xxx</small></span>\n\
    </div><div class="tooltip">' +
                        '<div><strong>' + a.cat_name + '</strong></div>' +
                        '<div><strong>' + a.coleccion_name + '</strong></div>' +
                        '<div>ancho: <span>' + a.item_ancho + 'cm</span></div>' +
                        '<div>largo: <span>' + a.item_largo + 'm</span></div>' +
                        '<div>case: <span>' + a.item_case + 'cm</span></div>' +
                        '<div>lavable: <span>' + ((a.item_lavable == 1) ? "SI" : "NO") + '</span></div>' +
                        '<div>Resistente al sol: <span>' + ((a.item_sol == 1) ? "SI" : "NO") + '</span></div>' +
                        '<div>Vinilo: <span>' + ((a.item_vinilo == 1) ? "SI" : "NO") + '</span></div>' +
                        '<div>Encolar: <span>' + ((a.item_cola == "pared") ? "PARED" : "PAPEL") + '</span></div>' +
                        '<div>Precio: <span>' + a.item_price + ' €</span></div>' +
                        '</div>');
                $(".itemshop .itm").last().trigger('new');
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
            wrap.html('<img  width=450 src="' + sr.attr("src").replace("th.jpg", "med.jpg") + '"/>' + "AAAAAAAAAAAA</br>AAAAAAAAAAAA</br>AAAAAAAAAAAA</br>AAAAAAAAAAAA</br>AAAAAAAAAAAA</br>AAAAAAAAAAAA</br>AAAAAAAAAAAA</br>AAAAAAAAAAAA</br>AAAAAAAAAAAA</br>AAAAAAAAAAAA</br>AAAAAAAAAAAA</br>");
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
        $('body').animate({'scrollTop': 0}, 250, function() {
          $('#mini_cart ul:first').stop().animate({'height': min_cart_height}, 400).delay(3000).animate({'height': '0'}, 400, function()
          {
            $('#mini_cart_status').hide();
          });
        });
      }
      $(function() {
        $('#slides').slidesjs({
          width: 946,
          height: 350,
          play: {active: false, effect: "fade", auto: true, interval: 5000, swap: true},
          effect: {fade: {speed: 1000, }},
          navigation: {active: false},
          pagination: {active: false}
        });
      });
      var isRunning = false;
      var currentpage = 0;
      $(function() {
        var nav = $('#menu');
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
          if (isDown) {
            requestnext();
          }
        });
      });

      $(function() {
        $(".itemshop").on('click', '.info', function() {
          sr = $(this);
        })
        $('.itm').live('new', function() {
          $(this).tooltip({
            effect: 'fade',
            predelay: 800,
            position: 'center left',
            offset: [-10, 0],
          }).dynamic({top: {direction: 'down', bounce: true}})
        });
      });
    </script>

    <div class="no-m no-t" style="position: fixed; top:10px; left:10px; width:44px; box-shadow: 0px 7px 14px -6px rgba(0,0,0,0.93);border-radius: 0px 0px 10px 10px; padding:5px;">
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/facebook.png" alt="facebook"/></a>
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/twitter.png" alt="twitter"/></a>
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/pinterest.png" alt="pinterest"/></a>
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/you_tube.png" alt="you tube"/></a>
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/google+.png" alt="google+"/></a>
      <a href="#"><img width=34 src="<?php echo $includes_dir; ?>images/mail.png" alt="contact"/></a>

    </div>
  </body>
</html>