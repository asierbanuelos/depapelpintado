<?php 
//$this->load->view('frontend/instagram_widget'); 

//if (isset($_GET['test']) && $_GET['test']=='eneko'){
    $footer_recaptcha_v3=new stdClass;
    $footer_recaptcha_v3->aktibaturik=true;
    $footer_recaptcha_v3->action='';
    $footer_recaptcha_v3->form_id='#newsletter_footer';
    /*
    print '<pre><xmp>';
    print_r($footer_recaptcha_v3);
    print '</xmp></pre>';
    exit;
    */
    $this->load->view('frontend/newsletter_banner_footer');
//}


?>

<footer>
    <div class="contenido-footer bg-black">
        <div class="container">
            <div class="row align-items-top pagina-info-texto-small">
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class='tit-seccion-footer'>Contáctanos</div>
                    <div>
                        <?php
                        /*
                       <a href="tel:+34605666429" rel="nofollow" title='Teléfono de contacto' aria-label="Telf: 605 66 64 29" ><i class="fa fa-phone" aria-hidden="true"></i> <span>Telf: 605 66 64 29</span></a> 
                        */
                        ?>              
                       <a href="tel:+34692910240" rel="nofollow" title='Teléfono de contacto' aria-label="Telf: 692 91 02 40"><i class="fa fa-phone" aria-hidden="true"></i> <span>692 91 02 40</span></a>
                    </div>
                    <div class='mb-4'><a href="mailto:info@depapelpintado.es" target="_blank"><i class="fa fa-envelope" aria-hidden="true"></i> <span>info@depapelpintado.es</span></a></div>
                    <div class='mb-4 text-white'><?php $this->load->view('frontend/horarios');?></div>
                    <?php
                    $this->load->view('frontend/redes_sociales'); 
                    ?>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class='tit-seccion-footer'>Categorías</div>
                    <ul class="menu-footer2">
                        <li><?=anchor("tienda/papel_pintado","Papel Pintado");?></li>
                        <li><?=anchor("tienda/murales","Murales");?></li>
                        <li><?=anchor("tienda/revestimientos","Revestimientos");?></li>
                        <li><?=anchor("tienda/telas","Telas");?></li>
                        <li><?=anchor("tienda/alfombras","Alfombras");?></li>
                        <li><?=anchor("tienda/herramientas","Herramientas");?></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class='tit-seccion-footer'>Tienda Online</div>
                    <ul class="menu-footer1 separacion-barravertical">
                        <li><a href="/quienes-somos" title="Quienes somos Depapelpintado">Quienes Somos</a></li>
                        <li><?=anchor("politica-de-envio-y-devoluciones","Envíos y devoluciones");?></li>
                        <?php
                        /*
                        <li> <?=anchor("condiciones-de-pago","Pagos");?></li>
                        <li><?=anchor("condiciones-de-envio","Envíos");?></li>
                        <li><?=anchor("condiciones-de-devoluciones","Devoluciones");?></li>
                        <li><?=anchor("tienda/mi_cuenta","Mi Cuenta");?></li>
                        */
                        ?>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-3 mb-4">
                    <div class='tit-seccion-footer'>Términos legales</div>
                    <ul class="menu-footer2">
                        <?php
                        /*
                        <li><?=anchor("condiciones-de-uso","Condiciones de Uso");?></li>
                        */
                        ?>
                        <li><?=anchor("condiciones-particulares-de-contratacion","Condiciones particulares de contratación");?></li>
                        <li><?=anchor("politica-de-privacidad","Politica de Privacidad");?></li>
                        <li><?=anchor("politica-de-cookies","Politica de Cookies");?></li>
                        <li><?=anchor("aviso-legal-formulario","Aviso Legal");?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-top">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-6">
                <div class='mt-4'>
                    <img src='/includes/images/plan-renovacion.png' alt='plan renovación NextGenerationEU' title='Plan renovación NextGenerationEU' width="680" height="73" />
                </div>
            </div>
            <div class="col-sm-3">
            </div>
        </div>
    </div>
    <div style="position:fixed;bottom:70px;right:30px;cursor:pointer;display:none;" id="subir"><i style="font-size:50px" class="fa fa-arrow-circle-up "></i></div>
</footer>

<div class="units-row end negro">
<div class="unit-100">
<nav class="navbar navbar-left">



</nav>

<nav class="navbar navbar-right separacion-barravertical">
</nav>
</div>
</div>

<div class="units-row end negro">
    <?php if(isset($footseo)) echo htmlspecialchars_decode($footseo->texto);?>
<div class="unit-100">

<?php
/*
<p class="denocheydia text-centered"><a title="Bitarlan" target="_blank" href="http://www.bitarlan.eus" >
Bitarlan
</a>
</p>
*/
?>
</div>
</div>
<?php
/*
<div class="cookiesms" id="cookie1" style="display:none">
    Este sitio web utiliza cookies para que usted tenga la mejor experiencia de usuario. Puede ver nuestra <?=anchor("politica_de_cookies","política de Cookies Aqui.");?>
    Si continúa navegando está dando su consentimiento para la aceptación de las mencionadas Cookies
    <button onclick="controlcookies()">Aceptar</button>
</div> 
<script>
    if(typeof(Storage) !== "undefined") {
        if (localStorage.controlcookie==0){
         document.getElementById('cookie1').style.display = 'block';
    	} 
        else if(typeof(localStorage.controlcookie) === "undefined" && getCookie("controlcookie")==""){
            document.getElementById('cookie1').style.display = 'block';
        }
    
    }
    function controlcookies() {
        
// si variable no existe se crea (al clicar en Aceptar)
        if(typeof(Storage) !== "undefined") {
            localStorage.controlcookie = (localStorage.controlcookie || 0);
            localStorage.controlcookie++; // incrementamos cuenta de la cookie
            cookie1.style.display='none'; // Esconde la política de cookies
        } else {
            setCookie("controlcookie",1,3650);
            cookie1.style.display='none';
        }
    }
    function setCookie(cname, cvalue, exdays) {
	    var d = new Date();
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    var expires = "expires="+d.toUTCString();
	    document.cookie = cname + "=" + cvalue + "; " + expires;
    } 
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    } 
</script>
<script type="text/javascript" charset="UTF-8" src="//cdn.cookie-script.com/s/f7447b5286fd6027d8bf7382e53e4c96.js"></script>
*/
?>

<?php
// 2025-05-14 Para intentar evitar la verificación de robot que salta en algunos usuarios y navegadores, descargamos los ficheros del CDN a local
/*
//<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
//<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.8/popper.min.js"></script>
//<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
*/
?>
<script src="/js/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/js/ajax/libs/popper.js/1.0.8/popper.min.js"></script>
<script src="/js/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>


<?php  
if (isset($includes_footer)){
    foreach ($includes_footer as $texto_include) {
      echo $texto_include."\n";
    }
}
?>

<script>
$(document).ready(function() {
    $(window).scroll(function(){
      if ($(this).scrollTop() > 100) {
        $('#subir').fadeIn();
      } else {
        $('#subir').fadeOut();
      }
    });

    $('#subir').click(function(){
      $('html, body').animate({scrollTop : 0},800);
      return false;
    });

    $( ".ver-submenu" ).on( "click", function( event ) {
      if($(window).width() < 992){
        event.preventDefault();
        event.stopPropagation();
        $(this).parent().siblings().find('ul').slideUp();
        $(this).parent().find('ul').slideToggle();
      }
    });
    $( ".ver-submenu-side" ).on( "click", function( event ) {
        event.preventDefault();
        event.stopPropagation();
        $(this).parent().siblings().find('ul').slideUp();
        $(this).parent().find('ul').slideToggle();
    });

    $("#imgContrasenaVieja").click(function () {
      var control = $(this);
      var estatus = control.data('activo');
      var image = control.find('img');
      if (estatus == false) {
        control.data('activo', true);
        $(image).attr('src', '/includes/iconos/show_hide_password_32.png');
        $("#field-old-password").attr('type', 'text');
      }
      else {
        control.data('activo', false);
        $(image).attr('src', '/includes/iconos/show_hide_password_2_32.png');
        $("#field-old-password").attr('type', 'password');
      }
    });

    $("#imgContrasena").click(function () {
      var control = $(this);
      var estatus = control.data('activo');
      var image = control.find('img');
      if (estatus == false) {
        control.data('activo', true);
        $(image).attr('src', '/includes/iconos/show_hide_password_32.png');
        $("#field-password").attr('type', 'text');
        $("#checkout_login_pass").attr('type', 'text');
      }
      else {
        control.data('activo', false);
        $(image).attr('src', '/includes/iconos/show_hide_password_2_32.png');
        $("#field-password").attr('type', 'password');
        $("#checkout_login_pass").attr('type', 'password');
      }
    });

    $("#imgContrasenaRep").click(function () {
      var control = $(this);
      var estatus = control.data('activo');
      var image = control.find('img');
      if (estatus == false) {
        control.data('activo', true);
        $(image).attr('src', '/includes/iconos/show_hide_password_32.png');
        $("#field-password-rep").attr('type', 'text');
      }
      else {
        control.data('activo', false);
        $(image).attr('src', '/includes/iconos/show_hide_password_2_32.png');
        $("#field-password-rep").attr('type', 'password');
      }
    });

    $("#imgContrasenaReg").click(function () {
      var control = $(this);
      var estatus = control.data('activo');
      var image = control.find('img');
      if (estatus == false) {
        control.data('activo', true);
        $(image).attr('src', '/includes/iconos/show_hide_password_32.png');
        $("#field-password-reg").attr('type', 'text');
      }
      else {
        control.data('activo', false);
        $(image).attr('src', '/includes/iconos/show_hide_password_2_32.png');
        $("#field-password-reg").attr('type', 'password');
      }
    });

   var bsDefaults = {
         offset: false,
         overlay: true,
         width: '330px'
      },
      bsMain = $('.bs-offset-main'),
      bsOverlay = $('.bs-canvas-overlay');

   $('[data-toggle="canvas"][aria-expanded="false"]').on('click', function() {
      var canvas = $(this).data('target'),
         opts = $.extend({}, bsDefaults, $(canvas).data()),
         prop = $(canvas).hasClass('bs-canvas-right') ? 'margin-right' : 'margin-left';

      if (opts.width === '100%')
         opts.offset = false;
      
      $(canvas).css('width', opts.width);
      if (opts.offset && bsMain.length)
         bsMain.css(prop, opts.width);

      $(canvas + ' .bs-canvas-close').attr('aria-expanded', "true");
      $('[data-toggle="canvas"][data-target="' + canvas + '"]').attr('aria-expanded', "true");
      // overlay desactivado para móvil
      return false;
   });

   $('.bs-canvas-close, .bs-canvas-overlay').on('click', function() {
      var canvas, aria;
      if ($(this).hasClass('bs-canvas-close')) {
         canvas = $(this).closest('.bs-canvas');
         aria = $(this).add($('[data-toggle="canvas"][data-target="#' + canvas.attr('id') + '"]'));
         if (bsMain.length)
            bsMain.css(($(canvas).hasClass('bs-canvas-right') ? 'margin-right' : 'margin-left'), '');
      } else {
         canvas = $('.bs-canvas');
         aria = $('.bs-canvas-close, [data-toggle="canvas"]');
         if (bsMain.length)
            bsMain.css({
               'margin-left': '',
               'margin-right': ''
            });
      }
      canvas.css('width', '');
      aria.attr('aria-expanded', "false");
      if (bsOverlay.length)
         bsOverlay.removeClass('show');
      return false;
   });
   
    <?php 
    if(isset($recaptcha_v3)){
    ?>
    // when form is submit
    $('<?php echo $recaptcha_v3->form_id; ?>').submit(function() { 
        // we stoped it
        event.preventDefault();
        // needs for recaptacha ready
        grecaptcha.ready(function() {
            // do request for recaptcha token
            // response is promise with passed token
            grecaptcha.execute('<?php echo RECAPTCHA_V3_SITE_KEY; ?>', {action: '<?php echo $recaptcha_v3->action; ?>'}).then(function(token) {
                // add token to form
                $('<?php echo $recaptcha_v3->form_id; ?>').prepend('<input type="hidden" name="token" value="' + token + '">');
                $('<?php echo $recaptcha_v3->form_id; ?>').prepend('<input type="hidden" name="action" value="<?php echo $recaptcha_v3->action; ?>">');
                // submit form now
                $('<?php echo $recaptcha_v3->form_id; ?>').unbind('submit').submit();
            });;
        });
    });
    <?php
    }

    if(isset($footer_recaptcha_v3)){
    ?>
    // when form is submit
        $('<?php echo $footer_recaptcha_v3->form_id; ?>').submit(function() { 
            // we stoped it
            event.preventDefault();

            if ($('#legaladvice').is(':checked')){            
                // needs for recaptacha ready
                grecaptcha.ready(function() {
                    // do request for recaptcha token
                    // response is promise with passed token
                    grecaptcha.execute('<?php echo RECAPTCHA_V3_SITE_KEY; ?>', {action: '<?php echo $footer_recaptcha_v3->action; ?>'}).then(function(token) {
                        // add token to form
                        $('<?php echo $footer_recaptcha_v3->form_id; ?>').prepend('<input type="hidden" name="token" value="' + token + '">');
                        $('<?php echo $footer_recaptcha_v3->form_id; ?>').prepend('<input type="hidden" name="action" value="<?php echo $footer_recaptcha_v3->action; ?>">');
                        // submit form now
                        $('<?php echo $footer_recaptcha_v3->form_id; ?>').unbind('submit').submit();
                    });;
                });
            }
            else{
                //$(this).find('.newsletter_msg').html('Debe aceptar la política de privacidad para poder realizar la suscripción.');                  
                alert('Debe aceptar la política de privacidad para poder realizar la suscripción.');                  
            }
        });
    <?php
    }

    if(isset($registro_recaptcha_v3)){
    ?>
    // when form is submit
        $('<?php echo $registro_recaptcha_v3->form_id; ?>').submit(function() { 
            // we stoped it
            event.preventDefault();

            // needs for recaptacha ready
            grecaptcha.ready(function() {
                // do request for recaptcha token
                // response is promise with passed token
                grecaptcha.execute('<?php echo RECAPTCHA_V3_SITE_KEY; ?>', {action: '<?php echo $registro_recaptcha_v3->action; ?>'}).then(function(token) {
                    // add token to form
                    $('<?php echo $registro_recaptcha_v3->form_id; ?>').prepend('<input type="hidden" name="token" value="' + token + '">');
                    $('<?php echo $registro_recaptcha_v3->form_id; ?>').prepend('<input type="hidden" name="action" value="<?php echo $registro_recaptcha_v3->action; ?>">');
                    // submit form now
                    $('<?php echo $registro_recaptcha_v3->form_id; ?>').unbind('submit').submit();
                });;
            });
        });
    <?php
    }

    if(isset($registro_checkout_recaptcha_v3)){
    ?>
        // when form is submit
        $('<?php echo $registro_checkout_recaptcha_v3->form_id; ?>').submit(function() { 
            // we stoped it
            event.preventDefault();
            //alert('submit');
            // needs for recaptacha ready
            grecaptcha.ready(function() {
                // do request for recaptcha token
                // response is promise with passed token
                grecaptcha.execute('<?php echo RECAPTCHA_V3_SITE_KEY; ?>', {action: '<?php echo $registro_checkout_recaptcha_v3->action; ?>'}).then(function(token) {
                    // add token to form
                    $('<?php echo $registro_checkout_recaptcha_v3->form_id; ?>').prepend('<input type="hidden" name="token" value="' + token + '">');
                    $('<?php echo $registro_checkout_recaptcha_v3->form_id; ?>').prepend('<input type="hidden" name="action" value="<?php echo $registro_checkout_recaptcha_v3->action; ?>">');
                    // submit form now
                    $('<?php echo $registro_checkout_recaptcha_v3->form_id; ?>').unbind('submit').submit();
                });;
            });
        });
    <?php
    }
    ?>
    /*
    $('#mini_cart').hover(function(){
        $('#capa-mini-carro').fadeIn();
    });
    $( "#mini_cart" ).hover(function() {
        $('#capa-mini-carro').fadeIn();
        $('#capa-mini-carro').fadeOut();
    });
    */
    activar_minicarro();

    $("#notificacionModal .mensaje-modal-notificacion").html('Suscripción realizada.');
    $('#notificacionModal').modal('toggle');

});

function activar_minicarro(){
    $( "#mini_cart" ).hover(
      function() {
        $('#capa-mini-carro').fadeIn();
      }, function() {
        $('#capa-mini-carro').fadeOut();
      }
    );
    $( "#mini_cart_movil" ).hover(
      function() {
        $('#capa-mini-carro_movil').fadeIn();
      }, function() {
        $('#capa-mini-carro_movil').fadeOut();
      }
    );

    $( "#menu_usuario_movil" ).hover(
      function() {
        $('#capa-usuario_movil').fadeIn();
      }, function() {
        $('#capa-usuario_movil').fadeOut();
      }
    );
}

</script>

<?php 
/*
<script src="/includes/js/jquery-172.min.js"></script>
<script src="/includes/js/jquery_ui/jquery-ui.min.js"></script>  // quitar carpeta jquery_ui/ para coger el script original ; 
*/

/*
<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'es', includedLanguages: 'de,en,es,et,fr,pl,pt,ru', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL}, 'google_translate_element');
  }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
*/
?>


  <!-- Widget Sociedad de Opiniones Contrastadas -->
  <script id="grc-widgets" src="https://widgets.guaranteed-reviews.com/static/widgets.min.js" data-public-key="c0711d58629393101bc6a58b2a8e79c2" data-lang="auto"></script>
  <div class="grc-site-floating"></div>

  </body>
</html>
