
<div class="units-row end negro">
<div class="unit-100">
<nav class="navbar navbar-left">

<ul class="menu-footer1 separacion-barravertical">
 <li><a href="http://www.decoracionbilbao.es/sobre-nosotros/" title="Quienes somos Depapelpintado" target="_blank">Quienes Somos</a></li>
<li> <?=anchor("condiciones-de-pago","Pagos");?>
</li>
<li><?=anchor("condiciones-de-envio","Envíos");?>
</li>
<li><?=anchor("condiciones-de-devoluciones","Devoluciones");?>
</li>
<li><?=anchor("tienda/mi_cuenta","Mi Cuenta");?></li>
</ul>


</nav>

<nav class="navbar navbar-right separacion-barravertical">
<ul class="menu-footer2">
	<li><?=anchor("condiciones-de-uso","Condiciones de Uso");?></li>
	<li><?=anchor("politica-de-privacidad","Politica de Privacidad");?></li>
	<li><?=anchor("politica-de-cookies","Politica de Cookies");?></li>
	<li><?=anchor("aviso-legal-formulario","Aviso Legal");?></li>
</ul>
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

<script src="<?php echo $includes_dir; ?>js/jquery_ui/jquery-ui.min.js"></script> <?php // quitar carpeta jquery_ui/ para coger el script original ; ?>

<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'es', includedLanguages: 'de,en,es,et,fr,pl,pt,ru', layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL}, 'google_translate_element');
  }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<?php 
if(isset($recaptcha_v3)){
?>
	<script>
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
	</script>
<?php
}
?>

  </body>
</html>
