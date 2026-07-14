<?php
function urlenc($str){
  //$search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,!,(,)");
  //$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,ñ,,,");
  $search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,%,!,(,)");
  $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,ñ,,,,");

  return str_replace($search,$replace,strtolower(str_replace(',','', str_replace('+','-plus-',str_replace('#','number-',str_replace('&','and',str_replace(' ','-',rawurldecode($str))))))));
}
function urldec($str){
  return str_replace('-',' ',str_replace('-plus-','+',str_replace('-and-',' & ',rawurldecode($str))));
}
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

// Desactivar toda notificación de error
//error_reporting(0);
//exit;
// Notificar solamente errores de ejecución
//error_reporting(E_ERROR | E_PARSE);

$meta_datos['title']='De Papel Pintado';
if (isset($meta_title))
  $meta_datos['title']=$meta_title;

$meta_datos['description']='dePapelPintado, tu tienda de confianza. Especialistas en papel pintado, amplio catálogo de marcas y colecciones con las últimas novedades. Más de 40 años de experiencia con la garantía de Ekam Decoración. ¡Descúbrenos!';
if (isset($meta_description))
  $meta_datos['description']=$meta_description;

$meta_datos['keywords']='';

$url_actual_zatiak=explode('/orden/',current_url());
$url_actual=$url_actual_zatiak[0];

$url_actual_zatiak=explode('/', $url_actual);
$zati_kopurua=count($url_actual_zatiak);
if (is_numeric($url_actual_zatiak[($zati_kopurua-1)]) && $url_actual_zatiak[($zati_kopurua-2)]!='id'){
  array_pop($url_actual_zatiak);
  $url_actual=implode('/', $url_actual_zatiak);
}
if (!isset($url_canonica))
  $url_canonica=$url_actual;

?>
<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-M44ZXZL');</script>
  <!-- End Google Tag Manager -->

  <!-- Google tag (gtag.js) --> 
  <script async src="https://www.googletagmanager.com/gtag/js?id=GT-5NPLPMW"></script> 
  <script> 
    window.dataLayer = window.dataLayer || []; 
    function gtag(){dataLayer.push(arguments);} 
    gtag('js', new Date()); gtag('config', 'GT-5NPLPMW'); 
  </script>

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-JSNKD3S185"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());gtag('config', 'G-JSNKD3S185');
  </script>
  
  <?php
  /*
  */
  ?>
  <meta charset="utf-8">
  <?php
  /*
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
  */
  ?>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, shrink-to-fit=no">
  <title><?php echo $meta_datos['title']; ?></title>
  <meta name="description" content="<?php echo $meta_datos['description']; ?>" /> 
  <?php
  if($meta_datos['keywords']!='')
    echo '<meta name="keywords" content="'.$meta_datos['keywords'].'"/>';
  ?>

  <meta name="p:domain_verify" content="8bfbd62d7f101f5ebc24bc1647e8a41d"/>
  <?php
  /*
  */

  // SEO Fase 6: noindex en URLs con parametros de filtro/orden/paginacion (contenido fino/duplicado)
  $params_noindex_seo = array('color','estilo','calidad','precio','marca','page','pagina','orden');
  $tiene_param_filtro = false;
  foreach ($params_noindex_seo as $p_ni) { if (isset($_GET[$p_ni]) && $_GET[$p_ni] !== '') { $tiene_param_filtro = true; break; } }
  if (strpos(current_url(),'944056616') !== false || $tiene_param_filtro){
  ?>
    <meta name="robots" content="noindex, follow">
  <?php
  }
  else{
  ?>
    <meta name="robots" content="index, follow"/>
  <?
  }

  if(isset($extrameta)) 
    echo $extrameta;
  ?>
  <meta name="copyright" content="Copyright &copy; <?php echo date('Y');?>, dePapelPintado.com, All Rights Reserved"/>
  <meta http-equiv="imagetoolbar" content="no"/>
  <?php
  /*
  <meta name="facebook-domain-verification" content="lamhfmwxl3nqezz9aa7s6ciyc09qxg" />
  Comentamos código google
  <meta name="google-site-verification" content="0JEDsNegisYaZRBFZaZCqkcHsAt8__hKK7utQXezAt0" />
  */
  ?>
  <link rel="canonical" href="<?php echo str_replace('http:', 'https:', $url_canonica); ?>" />

  <?php 
  //$this->load->view('includes/scripts'); 
  /*
  <script src="/includes/js/shadowbox/shadowbox.js"></script>
  <script src="/includes/js/jsCarousel/jsCarousel-2.0.0.js"></script>


  // Este habrá que meterlo
  <script src="/includes/js/scroll.js"></script>
  */
  if (isset($includes_header)){
    foreach ($includes_header as $texto_include) {
      echo $texto_include."\n";
    }
  }


  /*

  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link rel="preload" href="https://fonts.gstatic.com/s/muli/v28/7Aulp_0qiz-aVz7u3PJLcUMYOFnOkEk30e6fwniDtzM.woff" as="font" crossorigin>
  <link rel="preload" href="https://fonts.gstatic.com/s/montserrat/v25/JTUHjIg1_i6t8kCHKm4532VJOt5-QNFgpCtr6Hw5aXx-p7K4KLg.woff" as="font" crossorigin>
  <link rel="preload" href="https://fonts.gstatic.com/s/rochester/v18/6ae-4KCqVa4Zy6Fif-UC2FHXFzAgoA.woff2" as="font" crossorigin>

  <link rel="stylesheet" href="/includes/js/shadowbox/shadowbox.css">
  <link rel="stylesheet" href="/includes/js/jsCarousel/jsCarousel-2.0.0.css">
  <link rel="stylesheet" href="/includes/js/zoomy.css">
  <link rel="stylesheet" href="/includes/js/jquery_ui/jquery-ui.min.css">  // quitar carpeta jquery_ui/ para coger el css original ; 
  */
  ?>
  <link rel="shortcut icon" href="https://www.depapelpintado.es/favicon.ico"> 

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/includes/bootstrap4/css/bootstrap.min.css" >
  <link rel="stylesheet" href="/includes/header.min_v6.css" >
  <?php 
  /*
  <link rel="stylesheet" href="/includes/header_v2.css" >

  
  <link rel="preload" href="/includes/bootstrap4/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="/includes/bootstrap4/css/bootstrap.min.css"></noscript>
  <link rel="preload" href="/includes/header.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="/includes/header.css"></noscript>
  */
  ?>
  <!--
  <link rel="stylesheet" href="/includes/css/estilo.css" >
  -->
  <link rel="preload" href="/includes/css/estilo-v2.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="/includes/css/estilo-v2.min.css"></noscript>
  <?php 
  /*
  <!--  

  <link href='http://fonts.googleapis.com/css?family=Rochester' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Archivo+Narrow:400,700' rel='stylesheet' type='text/css'>
  --> 
  <!--
  -->
  <!--<link rel="stylesheet" href="<?=$includes_dir?>style.css">-->
  <!--
  <link rel="stylesheet" href="/includes/kube-3.css">
  <link rel="stylesheet" href="/includes/content-collapse-2.css">
  <link href="/includes/fontawesome/css/depapelpintado.css" rel="stylesheet">
  <link rel="stylesheet" href="/includes/html-slider.css">
  --> 

  <!--
  <link rel="stylesheet" href="/includes/font-awesome/css/all.min.css" >
  -->
  */
  ?>

  <link rel="preload" href="/includes/font-awesome/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="/includes/font-awesome/css/all.min.css"></noscript>
  

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&amp;display=swap" media="screen">
  <style>
    @font-face {
      font-family: 'MoonCreme';
      src: url('/includes/fonts/mooncreme-regular.otf') format('opentype'),
           url('/includes/fonts/moon-creme.ttf') format('truetype');
      font-weight: normal;
      font-style: normal;
      font-display: swap;
    }
    h1, h2, h3, h4, h5, h6 {
      font-family: 'MoonCreme', Georgia, serif;
    }
  </style>
  <?php 
  /*
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic&amp;display=swap" media="all">
  <link rel="preload" href="/includes/ceicons.woff2?t6ebnx" as="font" type="font/woff2" crossorigin>
  
  <link rel="preload" href="/includes/font-awesome/fonts/fontawesome-webfont.woff2?v=4.7.0" as="font" type="font/woff2" crossorigin>
  <link rel="stylesheet" href="/includes/kube-min.css">
  <link rel="stylesheet" href="/includes/kube.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  // En el all están todos los iconos, en papelpintado.css solo los que usamos
  <link href="/includes//fontawesome/css/all.min.css" rel="stylesheet">
  */
  ?>
  <!--
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic%7CRoboto+Slab:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic&amp;display=swap" media="all">
  -->

  <?php
  /*
  <!-- Comentamos código google -->
  */
  ?>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name" : "De Papel Pintado",
    "url" : "https://www.depapelpintado.es/",
    "logo": {
      "@type": "ImageObject",
      "url":"https://www.depapelpintado.es/includes/images/depapelpintado-logo.jpg"
    }
  }
  </script>

  <?php  
  if (isset($key) && !empty($key)){
    if($key['item_tipo']!=5)
      if (isset($title2))
        $prod_name=$title2;
      else  
        $prod_name=$key['cat_name']." ".$key['coleccion_name']." ".$key['item_ref'];
    else
      $prod_name=$key['item_name'];

    $prod_precio=$key['item_price'];

    if (isset($key['disc_method_fk'])){
      if($key['disc_method_fk']==1){//%
        $prod_precio=($key['item_price']*(100-$key['disc_value_discounted'])/100);
      }
      else if(isset($key['disc_status']) && $key['disc_status']==1 && $key['disc_method_fk']==2 && $totalcarro>=$key['disc_value_required']){//%
        $prod_precio=($key['item_price']-$key['disc_value_discounted']);
      }
    }

    $img_1=$includes_dir.str_replace("../", "", $key['img']).'med.jpg';   
    $img_2=$includes_dir.str_replace("../", "", $key['imgamb']).'med.jpg';   
    if($key['item_tipo']!=5){
      ?>
      <script type="application/ld+json">
      {
      "@context": "https://schema.org",
      "@type": "Product",
      "name": "<?php echo htmlspecialchars($prod_name, ENT_QUOTES); ?>",
      "image": [
        "<?php echo $img_1; ?>",
        "<?php echo $img_2; ?>"
        ],
      "sku": "<?php echo htmlspecialchars($key['item_ref'], ENT_QUOTES); ?>",
      "description": "<?php echo htmlspecialchars(isset($meta_description) ? $meta_description : $prod_name, ENT_QUOTES); ?>",
      "brand": {
        "@type": "Brand",
        "name": "<?php echo htmlspecialchars($key['cat_name'], ENT_QUOTES); ?>"
        },
      "offers": {
        "@type": "Offer",
        "price": "<?php echo number_format(round($prod_precio,2),2, '.',''); ?>",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "itemCondition": "https://schema.org/NewCondition",
        "url": "<?php echo current_url(); ?>"
        }
      }
      </script>
      <?php 
    }
    else{
      ?>
      <script type="application/ld+json">
      {
      "@context": "https://schema.org",
      "@type": "Product",
      "name": "<?php echo htmlspecialchars($prod_name, ENT_QUOTES); ?>",
      "image": [
        "<?php echo $img_1; ?>"
        ],
      "sku": "<?php echo htmlspecialchars($key['item_ref'], ENT_QUOTES); ?>",
      "offers": {
        "@type": "Offer",
        "price": "<?php echo number_format(round($prod_precio,2),2, '.',''); ?>",
        "priceCurrency": "EUR",
        "availability": "https://schema.org/InStock",
        "itemCondition": "https://schema.org/NewCondition",
        "url": "<?php echo current_url(); ?>"
        }
      }
      </script>
      <?php 
    } 
  }

  if(isset($cssseo)) 
    echo htmlspecialchars_decode($cssseo->texto);
  //if(isset($recaptcha_v3)) // Al meter la newsletter en el footer, siempre vamos a necesitar el recatcha
  echo "  <script src='https://www.google.com/recaptcha/api.js?render=".RECAPTCHA_V3_SITE_KEY."'></script>";

  /*
  <!-- Comentamos código google -->
  if(isset($recaptcha_v3))
    echo "	<script src='https://www.google.com/recaptcha/api.js?render=".RECAPTCHA_V3_SITE_KEY."'></script>";
  */
  ?>
  <style>
  .material-symbols-outlined {
  font-variation-settings:
  'FILL' 0,
  'wght' 400,
  'GRAD' 0,
  'opsz' 24
  }
  </style>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- Meta Pixel Code -->
  <script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '693775456975755');
  fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=693775456975755&ev=PageView&noscript=1"
  /></noscript>
  <!-- End Meta Pixel Code -->

</head>
<body id="cart" class="<?php echo (isset($images) && count($images)) ? 'tiene-slider' : 'sin-slider'; ?>">
  <!-- Overlay, must be placed direct after the opening body tag. -->
  <div class="bs-canvas-overlay bs-canvas-anim bg-dark position-fixed w-100 h-100"></div>
  <?php
  /*
  <!-- Comentamos código google -->
  */
  ?>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M44ZXZL"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  
  <script>
    // Hide content onload, prevents JS flicker
    document.body.className += ' js-enabled';
    <?php
    if(isset($categ)){
      ?>
      var categ= "<?=$categ?>";
      <?php
    }
    ?>
  </script>
<header class="site-header">
  <?php $this->load->view('frontend/sello_esquina'); ?>

  <!-- ===== BARRA INFO SUPERIOR ===== -->
  <div class="barra-info-top">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-3 d-none d-lg-flex align-items-center barra-rrss-top">
          <a href="https://www.facebook.com/depapelpintado/" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/depapelpintado.es/" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://wa.me/34692910240" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        </div>
        <div class="col-lg-6 d-none d-lg-block text-center">
          <?php $this->load->view('frontend/horarios'); ?>
        </div>
        <div class="col text-center text-lg-right">
          <a href="tel:+34692910240" rel="nofollow" aria-label="Telf: 692 91 02 40">Tel. 692 91 02 40</a>
          &nbsp;&nbsp;
          <a href="mailto:info@depapelpintado.es" rel="nofollow" aria-label="Email de contacto">info@depapelpintado.es</a>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== CABECERA PRINCIPAL ===== -->
  <div class="header-main" id="inicio1">
    <div class="container">
      <div class="row align-items-center header-main-row">

        <!-- Hamburger + búsqueda (sólo móvil) -->
        <div class="col-3 d-lg-none d-flex align-items-center" style="z-index:2; gap:10px;">
          <button class="navbar-toggler pl-0 p-0" type="button" data-toggle="canvas" data-target="#bs-canvas-left" aria-controls="bs-canvas-left" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="border: 1px solid #666;padding-top: 5px;border-radius: 3px;"><i class="fas fa-bars"></i></span>
            <span class="txt-menu">MENÚ</span>
          </button>
          <button id="btn-search-movil" aria-label="Buscar" style="background:none;border:none;padding:0;line-height:1;"><i class="fa fa-search" style="font-size:18px;"></i></button>
        </div>

        <!-- Logo -->
        <div class="col-6 col-lg-2 text-center text-lg-left">
          <a href="/">
            <img class="logo logo-dark img-fluid" src="/images/logo-depapelpintado-nuevo2.png" alt="De Papel Pintado" height="50" width="232">
            <img class="logo logo-white img-fluid" src="\images\logo-depapelpintado-blanco (2).png"
          </a>
        </div>

        <!-- Carrito/usuario (sólo móvil) -->
        <div class="col-3 d-lg-none d-flex align-items-center justify-content-end p-0" style="gap:8px;">
          <?php
          $data_aux['ocultar_enlace'] = true;
          $this->load->view('frontend/menu_usuario_movil', $data_aux);
          $this->load->view('frontend/minicarro_nuevo_movil', $data_aux);
          ?>
        </div>

        <!-- Navegación escritorio (col-8, oculto en móvil) -->
        <div class="col-lg-8 d-none d-lg-flex align-items-center justify-content-center">
          <?php $this->load->view('frontend/menu_principal'); ?>
        </div>

        <!-- Búsqueda + iconos escritorio -->
        <div class="col-lg-2 d-none d-lg-flex align-items-center justify-content-end header-icons-desktop">
          <button id="btn-search-desktop" aria-label="Buscar" style="background:none;border:none;padding:0 10px 0 0;line-height:1;cursor:pointer;flex-shrink:0;"><i class="fa fa-search" style="font-size:17px;"></i></button>
          <div class="icono-cuenta-desktop-wrap">
            <a href="/tienda/mi_cuenta" class="icono-cuenta-desktop" aria-label="Mi cuenta">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="18" width="18"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
            </a>
            <div class="dropdown-cuenta-desktop">
              <ul>
                <?php if ($usuario->user_id <= 1): ?>
                  <li><a href="/tienda/mi_cuenta">Iniciar sesión</a></li>
                  <li><a href="/tienda/mi_cuenta/nueva">Registrarse</a></li>
                <?php else: ?>
                  <li><a href="/tienda/mi_cuenta">Mis datos</a></li>
                  <li><a href="/tienda/mis_pedidos">Mis pedidos</a></li>
                  <li><a href="/tienda/clave">Cambiar contraseña</a></li>
                  <li><a href="/tienda/logout">Cerrar sesión</a></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
          <?php $this->load->view('frontend/minicarro_nuevo_2'); ?>
        </div>

      </div>
    </div>
  </div>

  <!-- Buscador escritorio desplegable -->
  <div id="buscador-desktop-bar" style="display:none;background:#fff;border-top:1px solid #e8e4df;padding:14px 0;position:relative;z-index:1049;box-shadow:0 4px 12px rgba(0,0,0,0.08);">
    <div class="container">
      <div id="search_widget" data-search-controller-url="/tienda/busqueda" style="position:relative;display:flex;align-items:center;gap:10px;">
        <form action="/tienda/busqueda" method="post" autocomplete="off" class="d-flex align-items-center" style="flex:1;">
          <input id="searchfield" type="text" name="search" placeholder="Buscar productos, marcas, colecciones..." autocomplete="off"
            style="flex:1;border:none;border-bottom:1px solid #ccc;padding:8px 0;font-size:15px;font-family:'Poppins',sans-serif;outline:none;background:transparent;color:#333;"/>
          <button class="btn-buscar-header" type="submit" aria-label="Buscar" style="color:#BB8AA3;font-size:18px;"><i class="fa fa-search"></i></button>
          <label for="searchfield" class="sr-only">Búsqueda</label>
        </form>
        <button id="btn-cerrar-busqueda-desktop" type="button" aria-label="Cerrar" style="background:none;border:none;font-size:24px;color:#999;cursor:pointer;line-height:1;padding:0;">&times;</button>
        <div id="search-suggestions" style="display:none;"></div>
      </div>
    </div>
  </div>

  <!-- Buscador móvil desplegable -->
  <div id="buscador-movil-bar" class="d-lg-none" style="display:none !important; background:#fff; border-top:1px solid #eee; padding:10px 16px;">
    <form action="/tienda/busqueda" method="post" autocomplete="off" class="d-flex align-items-center" style="gap:8px;">
      <input id="searchfield-movil" type="text" name="search" placeholder="Buscar productos, marcas..." autocomplete="off"
        style="flex:1;border:1px solid #ddd;border-radius:20px;padding:8px 16px;font-size:15px;outline:none;">
      <button type="submit" aria-label="Buscar" style="background:#BB8AA3;border:none;border-radius:50%;width:38px;height:38px;color:#fff;flex-shrink:0;">
        <i class="fa fa-search"></i>
      </button>
    </form>
  </div>

  <!-- Menú móvil off-canvas (FUERA de cualquier d-none) -->
  <?php $this->load->view('frontend/menu_offcanvas'); ?>

  <style>
  /* ----- Buscador móvil ----- */
  #btn-search-movil { color: #fff; }
  body.sin-slider #btn-search-movil,
  .site-header.header-scrolled #btn-search-movil { color: #333; }
  #buscador-movil-bar { position: relative; z-index: 1049; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
  @media (max-width: 991px) {
    /* Logo centrado en móvil */
    .header-main-row .col-6 {
      display: flex !important;
      justify-content: center;
      align-items: center;
    }
    /* Carrito alineado verticalmente en móvil */
    #mini_cart_movil { align-items: center; }
    #mini_cart_movil .precio-minicarro { font-size: 0; line-height: 1; }
    #mini_cart_movil .precio-minicarro svg {
      display: block;
      width: 24px;
      height: 24px;
      vertical-align: middle;
      margin-top: -20px;
    }
    #mini_cart_movil > div:first-child { display: flex; align-items: center; }
  }

  /* ----- Header fijo ----- */
  .site-header {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1050;
  }

  /* ----- Barra info superior: siempre visible ----- */
  .barra-info-top {
    background-color: #BB8AA3;
    border-bottom: none;
    padding: 6px 0;
    font-size: 12px;
    color: #fff;
    overflow: hidden;
    max-height: 60px;
    transition: max-height 0.35s ease, padding 0.35s ease, border-width 0.35s ease, opacity 0.35s ease;
    opacity: 1;
  }
  .barra-info-top.oculta {
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
    border-width: 0;
    opacity: 0;
  }
  .barra-info-top a { color: #fff; text-decoration: none; }
  .barra-info-top a:hover { text-decoration: underline; color: #fff; }
  .barra-rrss-top { gap: 14px; }
  .barra-rrss-top a { font-size: 14px; color: #fff; text-decoration: none !important; }
  .barra-rrss-top a:hover { color: rgba(255,255,255,0.8); text-decoration: none !important; }

  /* ----- Nav row: transparente al inicio ----- */
  .site-header .header-main,
  header.site-header .header-main {
    background: transparent !important;
    border-bottom: none !important;
    box-shadow: none !important;
    padding: 6px 0;
    transition: background 0.35s ease, box-shadow 0.35s ease;
    position: relative;
  }
  .header-main-row { min-height: 70px; }

  /* Nav links blancos cuando es transparente */
  .site-header:not(.header-scrolled) .header-main .nav-link {
    color: #fff !important;
    text-shadow: 0 1px 4px rgba(0,0,0,0.6);
    border-bottom-color: transparent !important;
  }
  .site-header:not(.header-scrolled) .header-main .nav-link:hover {
    color: rgba(255,255,255,0.85) !important;
  }

  /* Icono cuenta escritorio */
  .icono-cuenta-desktop-wrap { position: relative; display: flex; align-items: center; margin-right: 14px; }
  .icono-cuenta-desktop { display: flex; align-items: center; cursor: pointer; color: inherit; text-decoration: none; }
  .icono-cuenta-desktop svg path { transition: fill 0.2s; }
  .icono-cuenta-desktop:hover svg path { fill: #BB8AA3; }
  .dropdown-cuenta-desktop {
    display: none; position: absolute; top: 100%; right: 0; z-index: 1000;
    background: #fff; border: 1px solid #e8e4df; min-width: 180px;
    padding: 8px 0; margin-top: 8px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);
  }
  .dropdown-cuenta-desktop ul { list-style: none; margin: 0; padding: 0; }
  .dropdown-cuenta-desktop li a {
    display: block; padding: 8px 18px;
    font-family: 'Poppins', sans-serif; font-size: 12px; letter-spacing: 1px;
    text-transform: uppercase; color: #555; text-decoration: none;
  }
  .dropdown-cuenta-desktop li a:hover { color: #BB8AA3; background: #faf7f4; }
  .icono-cuenta-desktop-wrap:hover .dropdown-cuenta-desktop { display: block; }
  /* Icono cuenta blanco cuando header transparente */
  .site-header:not(.header-scrolled) .icono-cuenta-desktop svg path { fill: #fff; }
  .site-header:not(.header-scrolled) .icono-cuenta-desktop:hover svg path { fill: rgba(255,255,255,0.8); }
  /* Icono cuenta oscuro cuando scrolled */
  .site-header.header-scrolled .icono-cuenta-desktop svg path { fill: #333; }

  /* Carrito/iconos en estado transparente */
  .site-header:not(.header-scrolled) .precio-minicarro {
    color: #fff !important;
  }
  .site-header:not(.header-scrolled) .precio-minicarro svg path {
    fill: #fff;
  }
  .site-header:not(.header-scrolled) #mini_cart a {
    color: #fff !important;
  }
  .site-header:not(.header-scrolled) .navbar-toggler-icon,
  .site-header:not(.header-scrolled) .navbar-toggler .fa-bars {
    color: #fff !important;
  }
  .site-header:not(.header-scrolled) .navbar-toggler .txt-menu {
    color: #fff !important;
  }
  .site-header:not(.header-scrolled) .navbar-toggler-icon {
    border-color: rgba(255,255,255,0.8) !important;
  }

  /* ----- Estado scrolled: nav row blanco ----- */
  .site-header.header-scrolled .header-main {
    background: #fff !important;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  }
  .site-header.header-scrolled .header-main .nav-link {
    color: #333 !important;
    text-shadow: none;
  }
  .site-header.header-scrolled .precio-minicarro {
    color: #333 !important;
  }
  .site-header.header-scrolled .precio-minicarro svg path {
    fill: #333;
  }

  /* ----- Logos ----- */
  /* Por defecto: logo oscuro visible, logo blanco oculto */
  .logo-white { display: none; }
  .logo-dark  { display: inline; }

  /* Home (tiene-slider) antes del scroll: mostrar logo blanco */
  body.tiene-slider .site-header:not(.header-scrolled) .logo-white { display: inline; margin: 20px; }
  body.tiene-slider .site-header:not(.header-scrolled) .logo-dark  { display: none; }

  /* Tras scroll o en páginas sin slider: logo oscuro */
  .site-header.header-scrolled .logo-white { display: none; }
  .site-header.header-scrolled .logo-dark  { display: inline; }

  /* Páginas con slider: sin padding (el header flota encima) */
  body.tiene-slider { padding-top: 0; }

  /* Páginas interiores sin slider: compensar header fijo + siempre blanco */
  body.sin-slider { padding-top: 110px; }
  body.sin-slider .site-header .header-main {
    background: #fff !important;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
  }
  body.sin-slider .site-header .header-main .nav-link {
    color: #333 !important;
    text-shadow: none !important;
  }
  body.sin-slider .site-header .header-main .nav-link:hover { color: #BB8AA3 !important; }
  body.sin-slider .site-header .precio-minicarro { color: #333 !important; }
  body.sin-slider .site-header .precio-minicarro svg path { fill: #333 !important; }
  body.sin-slider .site-header #mini_cart a { color: #333 !important; }
  body.sin-slider .site-header .fa-bars { color: #333 !important; }
  body.sin-slider .site-header .txt-menu { color: #333 !important; }
  body.sin-slider .site-header .navbar-toggler-icon { border-color: rgba(0,0,0,0.3) !important; }
  body.sin-slider .site-header:not(.header-scrolled) .navbar-toggler .fa-bars { color: #333 !important; }
  body.sin-slider .site-header:not(.header-scrolled) .navbar-toggler .txt-menu { color: #333 !important; }
  body.sin-slider .site-header:not(.header-scrolled) .navbar-toggler-icon { border-color: rgba(0,0,0,0.3) !important; }
  body.sin-slider .site-header .buscador-header { color: #333; }
  body.sin-slider .site-header .fa-search { color: #333; }

  /* Nav de escritorio inline en el header */
  .header-main .menu-principal {
    margin-bottom: 0 !important;
    background: transparent;
    padding: 0;
    width: 100%;
  }
  .header-main .menu-principal .collapse { display: flex !important; }
  .header-main .menu-principal .navbar-nav {
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: center;
    justify-content: center;
    width: 100%;
  }
  .header-main .menu-principal .nav-item { padding: 0; }
  .header-main .menu-principal .nav-link {
    font-size: 11.5px;
    padding: 8px 7px;
    white-space: nowrap;
    letter-spacing: 0.3px;
  }
  .header-main .menu-principal .dropdown-menu { top: 100%; position: absolute; }

  /* Icono búsqueda escritorio */
  #btn-search-desktop { color: #fff; }
  body.sin-slider .site-header #btn-search-desktop,
  .site-header.header-scrolled #btn-search-desktop { color: #333 !important; }
  #btn-search-desktop:hover { opacity: 0.75; }

  /* Barra búsqueda escritorio */
  #buscador-desktop-bar input:focus { border-bottom-color: #BB8AA3; }
  #search-suggestions { min-width: 300px; }

  /* ----- Búsqueda compacta ----- */
  .search-widget-header { position: relative; display: flex; align-items: center; }

  /* Resetear el CSS viejo de estilo-v2.css que posiciona el botón con absolute */
  #search_widget button,
  #search_widget button:focus,
  #search_widget .btn-buscar-header,
  #search_widget .btn-buscar-header:focus {
    position: static !important;
    top: auto !important;
    right: auto !important;
  }

  .search-widget-header { margin-right: 20px; }
  .buscador-header {
    border: none;
    border-bottom: 1px solid rgba(255,255,255,0.6);
    border-radius: 0;
    padding: 4px 0;
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    font-weight: 300;
    letter-spacing: 1px;
    text-transform: none;
    width: 120px;
    outline: none;
    background: transparent;
    color: #fff;
    transition: width 0.3s;
  }
  .buscador-header::placeholder { color: rgba(255,255,255,0.75); font-weight: 300; }
  .buscador-header:focus { width: 170px; }

  .btn-buscar-header {
    background: transparent !important;
    border: none !important;
    color: rgba(255,255,255,0.85) !important;
    padding: 4px 0 4px 10px;
    font-size: 17px;
    cursor: pointer;
    line-height: 1;
    transition: color 0.2s, opacity 0.2s, transform 0.2s;
    flex-shrink: 0;
    position: static !important;
    top: auto !important;
    right: auto !important;
  }
  .btn-buscar-header:hover { color: #BB8AA3 !important; opacity: 1; transform: scale(1.08); }
  #btn-search-movil .fa-search { font-size: 21px !important; }

  /* Estado scrolled / páginas interiores */
  .site-header.header-scrolled .buscador-header,
  body.sin-slider .site-header .buscador-header {
    border-bottom-color: #bbb !important; color: #444 !important;
  }
  .site-header.header-scrolled .buscador-header::placeholder,
  body.sin-slider .site-header .buscador-header::placeholder { color: #aaa !important; }
  .site-header.header-scrolled .btn-buscar-header,
  body.sin-slider .site-header .btn-buscar-header { color: #444 !important; }

  /* ----- Autocomplete ----- */
  #search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #fff;
    border: 1px solid #ddd;
    border-top: none;
    z-index: 9999;
    max-height: 400px;
    overflow-y: auto;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    min-width: 300px;
  }
  #search-suggestions a {
    display: flex; align-items: center; padding: 8px 12px;
    text-decoration: none; color: #333; border-bottom: 1px solid #eee; transition: background 0.2s;
  }
  #search-suggestions a:hover { background: #f5f5f5; }
  #search-suggestions .search-thumb { width: 50px; height: 50px; object-fit: cover; margin-right: 12px; flex-shrink: 0; }
  #search-suggestions .search-info { flex: 1; text-align: left; min-width: 0; }
  #search-suggestions .search-info .search-label { font-size: 13px; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  #search-suggestions .search-info .search-price { font-size: 12px; color: #999; margin-top: 2px; }
  #search-suggestions .search-all { display: block; text-align: center; padding: 10px; font-weight: bold; color: #333; border-bottom: none; }

  /* ===== BREADCRUMB BAR (fondo blanco, unido al header) ===== */
  .categ-breadcrumb-bar { background: #fff; padding: 16px 0; }

  /* ===== BARRA FILTROS HORIZONTAL ===== */
  .categ-filtros-bar-wrap { background: #fff; border-top: 1px solid #e8e4df; border-bottom: 1px solid #e8e4df; }
  .categ-filtros-bar { display: flex; align-items: center; justify-content: space-between; padding: 10px 0; gap: 8px; flex-wrap: wrap; }
  .categ-pills { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }
  .categ-pill {
    font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 400;
    letter-spacing: 1.5px; text-transform: uppercase;
    border: 1px solid #ccc; border-radius: 20px; padding: 5px 14px;
    background: #fff; color: #555; cursor: pointer; text-decoration: none;
    transition: all 0.18s; white-space: nowrap; display: inline-block;
  }
  .categ-pill:hover, .categ-pill.active {
    background: #333; color: #fff; border-color: #333; text-decoration: none;
  }
  .categ-filtros-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
  .categ-count { font-family: 'Poppins', sans-serif; font-size: 11px; color: #999; letter-spacing: 1px; white-space: nowrap; }
  .categ-filtrar-btn {
    font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 400;
    letter-spacing: 2px; text-transform: uppercase;
    background: #fff; color: #333; border: 1px solid #ccc; border-radius: 20px;
    padding: 7px 18px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;
    transition: all 0.2s;
  }
  .categ-filtrar-btn:hover { background: #333; color: #fff; border-color: #333; }
  .categ-barra-movil { display: flex; align-items: center; justify-content: space-between; padding: 10px 0 12px; border-bottom: 1px solid #eee; }
  .categ-filtrar-btn-movil { font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 400; letter-spacing: 2px; text-transform: uppercase; background: #fff; color: #333; border: 1px solid #333; padding: 8px 20px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
  .categ-filtrar-btn-movil:hover, .categ-filtrar-btn-movil:focus { background: #333; color: #fff; outline: none; }
  .categ-count-movil { font-family: 'Poppins', sans-serif; font-size: 11px; color: #999; letter-spacing: 1px; }

  /* Toggle sidebar con JS */
  .categ-wrapper.filtros-ocultos .categ-sidebar { display: none !important; }
  .categ-wrapper.filtros-ocultos .categ-grid { flex: 0 0 100% !important; max-width: 100% !important; }

  /* ===== LAYOUT CATEGORÍA ===== */
  .categ-wrapper { background: #fff; min-height: 60vh; }
  .categ-header { width: 100%; padding: 0; background: #fff; }
  .categ-breadcrumb { font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 400; letter-spacing: 2px; text-transform: uppercase; color: #999; margin-bottom: 14px; }
  .categ-breadcrumb a { color: #999; text-decoration: none; }
  .categ-breadcrumb a:hover { color: #333; }
  .categ-h1 { font-family: 'MoonCreme', Georgia, serif; font-size: clamp(28px, 4vw, 52px); font-weight: normal; letter-spacing: 6px; text-transform: uppercase; color: #222; margin: 0 0 16px; line-height: 1.2; }
  @media (max-width: 767px) { .categ-h1 { text-align: center; } }
  .categ-desc { font-family: 'Poppins', sans-serif; font-size: 13px; color: #666; font-weight: 300; line-height: 1.7; max-height: 52px; overflow: hidden; transition: max-height 0.6s ease; }
  .categ-desc.expanded { max-height: 9999px; }
  .categ-leer-mas { font-family: 'Poppins', sans-serif; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: #BB8AA3; cursor: pointer; border: none; background: none; padding: 6px 0 0; display: inline-block; }
  .categ-divider { border: none; border-top: 1px solid #e8e4df; margin: 0; }

  /* ===== PAGINACIÓN ===== */
  .categ-paginacion { display: flex; justify-content: center; align-items: center; gap: 6px; padding: 40px 0 20px; flex-wrap: wrap; }
  .categ-pag-btn { font-family: 'MoonCreme', Georgia, serif; font-size: 13px; letter-spacing: 1px; color: #555; border: 1px solid #ddd; padding: 8px 14px; text-decoration: none; transition: all 0.2s; }
  .categ-pag-btn:hover { background: #333; color: #fff; border-color: #333; text-decoration: none; }
  .categ-pag-btn.active { background: #BB8AA3; color: #fff; border-color: #BB8AA3; }
  .categ-pag-ellipsis { color: #aaa; font-size: 13px; padding: 0 4px; }
  .categ-sidebar { padding-top: 32px; }
  .sticky-sidebar { position: sticky; top: 20px; } /* top se sobreescribe por JS */
  .columna-filtros { padding-right: 4px; }
  .categ-grid { padding-top: 28px; padding-bottom: 48px; }
  .columna-filtros .pl-4.h5 { font-family: 'MoonCreme', Georgia, serif !important; font-size: 12px !important; font-weight: normal !important; letter-spacing: 4px !important; text-transform: uppercase; color: #999 !important; padding: 0 0 16px 0 !important; margin: 0; }

  /* Acordeón filtros sidebar */
  .grupo-filtro {
    font-family: 'MoonCreme', Georgia, serif !important; font-size: 17px !important;
    font-weight: 500 !important; letter-spacing: 2px !important;
    text-transform: uppercase !important; color: #444 !important;
    padding: 13px 0 !important; margin: 0 !important;
    border-bottom: 1px solid #e0ddd8 !important;
    cursor: pointer; display: flex !important;
    justify-content: space-between; align-items: center;
  }
  .grupo-filtro span { pointer-events: none; }
  .grupo-filtro::after {
    content: ''; width: 7px; height: 7px; flex-shrink: 0; margin-right: 2px;
    border-right: 1.5px solid #999; border-bottom: 1.5px solid #999;
    transform: rotate(45deg); transition: transform 0.2s;
  }
  .grupo-filtro.filtro-cerrado::after { transform: rotate(-45deg) translateY(3px); }
  .filtro-acordeon-body { overflow: hidden; transition: max-height 0.25s ease; }
  .filtro-acordeon-body.cerrado { max-height: 0 !important; }

  /* Items de filtro */
  .columna-filtros ul { list-style: none !important; padding: 0 !important; margin: 0 !important; }
  .columna-filtros ul li a {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 300;
    color: #555; text-decoration: none; display: block;
    padding: 7px 0; border-bottom: 1px solid #f0ede8;
  }
  .columna-filtros ul li a:hover { color: #BB8AA3; text-decoration: none; }
  .columna-filtros .filtros-seleccionados li a { color: #BB8AA3 !important; font-weight: 500 !important; }
  .columna-filtros ul li a img { margin-right: 6px; vertical-align: middle; }
  .columna-filtros .my_collapsible { display: none; }
  .filtro-ver-todos a {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 400;
    color: #BB8AA3; text-decoration: none; display: block; padding: 8px 0 4px;
  }
  .filtro-ver-todos a:hover { text-decoration: underline; }

  /* ===== CARDS LISTADO ===== */
  .listado-productos .articulo-block .card { border: none !important; box-shadow: none !important; border-radius: 0; background: transparent; }
  .listado-productos .card-img { overflow: hidden; margin-bottom: 10px; position: relative; aspect-ratio: 3 / 4; }
  .listado-productos .card-img-top.img-prefichas { width: 100% !important; height: 100% !important; object-fit: cover; display: block; transition: transform 0.5s ease; }
  .listado-productos .articulo-block:hover .card-img-top { transform: scale(1.04); }
  .listado-productos .card-body { padding: 0; }
  .listado-productos .card-text.fabricante { display: none; }
  .listado-productos .card-title { font-family: 'MoonCreme', Georgia, serif; font-size: 17px; font-weight: normal; letter-spacing: 2px; text-transform: uppercase; color: #000; text-align: left; margin: 0 0 4px; line-height: 1.4; }
  .listado-productos .card-title a { color: #000; text-decoration: none; }
  .listado-productos .card-title a:hover { color: #BB8AA3; }
  .listado-productos .card-text.precio { font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 300; color: #555; text-align: left; margin: 0 0 6px; }
  .listado-productos .card-text.precio strong { font-weight: 400; color: #333; }
  .listado-productos .card-text.precio .tachado { font-size: 11px; color: #aaa; }
  /* Botón añadir al carrito: slide-up en hover (desktop) */
  .listado-productos .card-img { position: relative; }
  .listado-productos .card-text.text-center { margin: 0; padding: 0; }
  .listado-productos .card-text .boton-opciones {
    display: block;
    font-family: 'MoonCreme', Georgia, serif;
    font-size: 17px;
    padding: 14px 16px;
    letter-spacing: 2px;
    width: 100%;
    text-align: center;
    background: #FCF9F4;
    color: #BB8AA3;
    border: none;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    transform: translateY(100%);
    transition: transform 0.25s ease;
    z-index: 3;
  }
  .listado-productos .articulo-block:hover .card-text .boton-opciones { transform: translateY(0); }
  .listado-productos .card-text .boton-opciones:hover,
  .listado-productos .card-text .boton-opciones:focus { background: #FCF9F4 !important; color: #BB8AA3 !important; }
  @media (max-width: 767px) {
    .listado-productos .card-text .boton-opciones {
      position: static;
      transform: none;
      display: block;
      margin-top: 8px;
      background: #FCF9F4;
      color: #BB8AA3;
    }
    .listado-productos .articulo-block:hover .card-text .boton-opciones { transform: none; }
  }
  .listado-productos .etiqueta-novedad, .listado-productos .etiqueta-descuento { position: absolute; z-index: 2; top: 10px; left: 10px; font-size: 9px; letter-spacing: 2px; text-transform: uppercase; font-family: 'Poppins', sans-serif; padding: 4px 8px; }
  .listado-productos .etiqueta-descuento { background: #BB8AA3; color: #fff; }
  .listado-productos .etiqueta-novedad { background: #fff; color: #333; border: 1px solid #ddd; }
  .card-tonalidades { display: flex; gap: 4px; margin-top: 6px; margin-bottom: 2px; }
  .tonal-dot { width: 11px; height: 11px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.08); flex-shrink: 0; }

  /* ===== FICHA PRODUCTO ===== */
  /* Aire en la zona superior (migas + título) */
  body.sin-slider nav[aria-label="breadcrumb"] { padding: 24px 0 20px; }
  #inicio.wrapper { padding-top: 16px; }
  #inicio .heading-producto { padding-top: 16px; padding-bottom: 20px; border-bottom: 1px solid #e8e4df; margin-bottom: 16px; }
  .ficha-nombre-precio { padding-bottom: 20px; border-bottom: 1px solid #e8e4df; margin-bottom: 4px; }
  .ficha-h1 { font-family: 'MoonCreme', Georgia, serif; font-size: clamp(22px, 3vw, 38px); font-weight: normal; letter-spacing: 3px; text-transform: uppercase; color: #222; margin: 0 0 10px; line-height: 1.2; }
  .precio-heading { margin: 8px 0 10px; }
  .precio-heading-valor { font-family: 'MoonCreme', Georgia, serif; font-size: clamp(20px, 2.5vw, 28px); color: #BB8AA3; font-weight: normal; }
  .precio-heading-tachado { font-family: 'Poppins', sans-serif; font-size: 14px; color: #aaa; text-decoration: line-through; margin-right: 8px; }
  .ver-coleccion-link { font-family: 'Poppins', sans-serif; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: #999; text-decoration: none; border-bottom: 1px solid #ddd; padding-bottom: 1px; }
  .ver-coleccion-link:hover { color: #BB8AA3; border-color: #BB8AA3; }
  /* Enlace "Ver colección completa" sobre la foto del producto */
  .ficha-col-imagen { position: relative; }
  .ver-coleccion-link-foto {
    position: absolute; top: 10px; left: 10px; z-index: 10;
    background: rgba(255,255,255,0.92); padding: 5px 12px;
    font-family: 'Poppins', sans-serif; font-size: 10px; letter-spacing: 2px;
    text-transform: uppercase; color: #555; text-decoration: none;
    border: 1px solid #ddd; white-space: nowrap;
  }
  .ver-coleccion-link-foto:hover { color: #BB8AA3; border-color: #BB8AA3; text-decoration: none; }
  /* Scroll horizontal otros artículos de la colección */
  .otros-articulos-wrap { position: relative; display: flex; align-items: center; width: 100%; padding: 0 4px; }
  .otros-articulos-scroll {
    display: flex; overflow-x: auto; scroll-behavior: smooth;
    gap: 12px; padding: 8px 4px; scrollbar-width: none; flex: 1;
  }
  .otros-articulos-scroll::-webkit-scrollbar { display: none; }
  .otro-art-card {
    flex: 0 0 130px; display: flex; flex-direction: column;
    align-items: center; text-decoration: none; color: #333;
    font-size: 11px; text-align: center; font-family: 'Poppins', sans-serif;
  }
  .otro-art-card img { width: 130px; height: 130px; object-fit: cover; border: 1px solid #e8e4df; }
  .otro-art-card span { margin-top: 5px; color: #666; }
  .otro-art-card:hover img { border-color: #BB8AA3; }
  .otro-art-card:hover span { color: #BB8AA3; }
  .otros-scroll-btn {
    background: #fff; border: 1px solid #e8e4df; border-radius: 50%;
    width: 36px; height: 36px; font-size: 24px; line-height: 34px;
    cursor: pointer; flex: 0 0 36px; text-align: center; padding: 0;
    color: #555; transition: background 0.15s;
  }
  .otros-scroll-btn:hover { background: #FCF9F4; color: #BB8AA3; border-color: #BB8AA3; }
  .otros-scroll-left { margin-right: 6px; }
  .otros-scroll-right { margin-left: 6px; }

  /* ===== BLOQUE PRECIO + UNIDADES ===== */
  .ficha-precio-unidades {
    display: flex;
    align-items: center;
    gap: 0;
    background: #FCF9F4;
    border-radius: 10px;
    padding: 16px 20px;
    border: 1px solid #e8e4df;
    flex-wrap: wrap;
  }
  .ficha-precio-bloque {
    flex: 1;
    min-width: 100px;
  }
  .ficha-precio-actual {
    font-family: 'MoonCreme', Georgia, serif;
    font-size: clamp(22px, 2.8vw, 30px);
    color: #BB8AA3;
    font-weight: normal;
    line-height: 1.1;
  }
  .ficha-precio-ud {
    font-size: 0.55em;
    color: #999;
    font-family: 'Poppins', sans-serif;
    letter-spacing: 1px;
  }
  .ficha-precio-anterior {
    font-size: 13px;
    color: #bbb;
    margin-top: 2px;
  }
  .ficha-unidades-bloque {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 20px;
    border-left: 1px solid #e8e4df;
    border-right: 1px solid #e8e4df;
    gap: 4px;
  }
  .ficha-unidades-label {
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #999;
    margin: 0;
  }
  .ficha-unidades-input {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .ficha-unidades-input input[type="number"] {
    width: 60px;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 6px 10px;
    font-size: 18px;
    font-family: 'MoonCreme', Georgia, serif;
    text-align: center;
    background: #fff;
    color: #333;
    -moz-appearance: textfield;
  }
  .ficha-unidades-input input[type="number"]::-webkit-inner-spin-button,
  .ficha-unidades-input input[type="number"]::-webkit-outer-spin-button { opacity: 1; }
  .ficha-unidades-txt {
    font-family: 'Poppins', sans-serif;
    font-size: 12px;
    color: #888;
  }
  .ficha-total-bloque {
    flex: 1;
    text-align: right;
    min-width: 100px;
  }
  .ficha-total-label {
    display: block;
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #999;
    margin-bottom: 2px;
  }
  .ficha-total-valor,
  .ficha-precio-total-val {
    font-family: 'MoonCreme', Georgia, serif;
    font-size: clamp(20px, 2.5vw, 28px);
    color: #333;
    font-weight: normal;
  }
  @media (max-width: 576px) {
    .ficha-precio-unidades { flex-direction: column; align-items: flex-start; gap: 12px; }
    .ficha-unidades-bloque { border-left: none; border-right: none; border-top: 1px solid #e8e4df; border-bottom: 1px solid #e8e4df; padding: 12px 0; width: 100%; flex-direction: row; align-items: center; gap: 12px; }
    .ficha-total-bloque { text-align: left; }
  }

  /* Sección descripción del producto */
  .seccion-descripcion-producto {
    padding: 48px 0 40px;
    border-top: 1px solid #e8e4df;
  }
  .seccion-descripcion-titulo {
    font-family: 'MoonCreme', Georgia, serif;
    font-size: clamp(20px, 2.5vw, 28px);
    font-weight: normal;
    letter-spacing: 4px;
    text-transform: uppercase;
    color: #727272;
    margin-bottom: 24px;
  }
  .seccion-descripcion-contenido {
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    line-height: 1.8;
    color: #555;
    max-width: 100%;
  }

  /* Columna imagen: sticky solo en desktop */
  @media (min-width: 768px) {
    .ficha-col-imagen {
      position: sticky;
      top: 130px;
      align-self: flex-start;
    }
  }

  /* Características: de 2 columnas a 1 columna */
  /* ===== CARD INFORMACIÓN DESTACADA ===== */
  .caracteristicas-producto {
    border: 1px solid #e8e2db;
    padding: 20px 24px 8px;
    margin-top: 20px;
  }
  .caracteristicas-producto::before {
    content: 'INFORMACIÓN DESTACADA';
    display: block;
    font-family: 'MoonCreme', Georgia, serif;
    font-size: 14px;
    letter-spacing: 3px;
    color: #333;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #ede8e2;
  }
  .product-detail-feature {
    flex: 0 0 50% !important;
    max-width: 50% !important;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 0 0 16px !important;
    border-bottom: none !important;
  }
  .product-detail-feature > div:first-child { flex-shrink: 0; margin-top: 2px; }
  .product-detail-feature img { width: 42px !important; }
  .product-detail-feature .titulo-upper-claro-1 {
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 2px;
    color: #999;
    text-transform: uppercase;
    display: block;
    margin-bottom: 4px;
  }
  .product-detail-feature .titulo-upper-oscuro-1 {
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: #333;
    font-weight: 400;
    line-height: 1.4;
  }

  /* Detalles tabla: dentro de columna derecha, fondo blanco */
  .detalles-producto { background: #fff; border-top: 1px solid #ede8e2; margin-top: 28px; }
  .detalles-titulo {
    font-family: 'MoonCreme', Georgia, serif !important;
    font-size: 14px !important; font-weight: normal !important;
    letter-spacing: 3px !important; text-transform: uppercase !important;
    color: #333 !important; padding: 22px 0 12px !important; margin: 0 !important;
    border-bottom: 1px solid #ede8e2 !important;
  }
  .detalles-producto table { width: 100%; border-collapse: collapse; }
  .detalles-producto table tr th,
  .detalles-producto table tr td,
  .detalles-producto table tr:nth-of-type(odd) th,
  .detalles-producto table tr:nth-of-type(odd) td {
    background-color: transparent !important;
    border: none !important;
    border-bottom: 1px solid #ede8e2 !important;
  }
  .detalles-producto table th {
    font-family: 'Poppins', sans-serif; font-size: 11px; font-weight: 300;
    color: #aaa; padding: 11px 0; width: 45%; vertical-align: top; text-align: left;
  }
  .detalles-producto table td {
    font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 400;
    color: #444; padding: 11px 0 11px 16px;
  }
  .detalles-producto table tr:last-child th,
  .detalles-producto table tr:last-child td { border-bottom: none !important; }

  /* Botón añadir al carrito ficha producto */
  .boton-entero {
    background-color: #BB8AA3 !important;
    border-color: #BB8AA3 !important;
    color: #fff !important;
  }
  .boton-entero:hover, .boton-entero:focus {
    background-color: #fff !important;
    color: #BB8AA3 !important;
    border-color: #BB8AA3 !important;
  }

  /* Sección "otros productos" */
  #articulos-relacionados { padding: 56px 0 40px; background: #fff; }
  #articulos-relacionados h3 {
    font-family: 'Poppins', sans-serif !important;
    font-size: clamp(14px, 2vw, 24px) !important; font-weight: 200 !important;
    letter-spacing: 5px !important; text-transform: uppercase !important;
    color: #333 !important; padding-bottom: 8px !important;
  }
  #articulos-relacionados h3 span { font-weight: 400 !important; }
  #articulos-relacionados .link_button2 { list-style: none; }
  #articulos-relacionados .link_button2 a {
    font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 400;
    letter-spacing: 3px; text-transform: uppercase; color: #333;
    text-decoration: underline; text-underline-offset: 5px;
  }
  #articulos-relacionados .link_button2 a:hover { color: #BB8AA3; }

  /* Banner colección en ficha de producto */
  .banner-coleccion-ficha {
    position: relative; width: 100%; min-height: 340px;
    background-size: cover; background-position: center;
    display: flex; align-items: center; justify-content: center;
  }
  .banner-coleccion-overlay {
    position: absolute; inset: 0;
    background: rgba(0,0,0,0.38);
  }
  .banner-coleccion-content {
    position: relative; z-index: 1;
    text-align: center; padding: 48px 24px; max-width: 640px;
  }
  .banner-coleccion-titulo {
    font-family: 'Poppins', sans-serif; font-size: clamp(13px, 2vw, 18px);
    font-weight: 300; letter-spacing: 5px; text-transform: uppercase;
    color: #fff; margin-bottom: 16px;
  }
  .banner-coleccion-desc {
    font-family: 'Poppins', sans-serif; font-size: 13px; font-weight: 300;
    color: rgba(255,255,255,0.85); line-height: 1.7; margin-bottom: 24px;
  }
  .banner-coleccion-btn {
    display: inline-block; font-family: 'Poppins', sans-serif;
    font-size: 10px; font-weight: 400; letter-spacing: 4px;
    text-transform: uppercase; color: #fff;
    border: 1px solid rgba(255,255,255,0.7); padding: 10px 28px;
    text-decoration: none; transition: background 0.2s, color 0.2s;
  }
  .banner-coleccion-btn:hover {
    background: #fff; color: #333; text-decoration: none;
  }

  /* ===== FOOTER ===== */
  footer { margin-top: 0 !important; }
  footer .contenido-footer,
  footer .contenido-footer.bg-black,
  .contenido-footer { background-color: rgba(252, 249, 244, 1) !important; }
  footer .contenido-footer { padding: 56px 0 48px; }
  footer div.tit-seccion-footer {
    font-size: clamp(14px, 1.5vw, 20px) !important;
    font-weight: normal !important;
    letter-spacing: 4px !important;
    text-transform: uppercase !important;
    color: #727272 !important;
    margin-bottom: 16px !important;
    font-family: 'MoonCreme', Georgia, serif !important;
  }
  footer .menu-footer1 li,
  footer .menu-footer2 li { line-height: 1.9; }
  footer .menu-footer1 a,
  footer .menu-footer2 a {
    font-size: 13px !important;
    color: #888 !important;
    font-family: 'Poppins', sans-serif;
    font-weight: 300;
  }
  footer .menu-footer1 a:hover,
  footer .menu-footer2 a:hover { color: #BB8AA3 !important; }
  footer a { color: #888 !important; }
  footer a:hover { color: #BB8AA3 !important; }
  footer .text-white { color: #555 !important; }
  </style>

  <script>
  (function(){
    var timer = null;
    var field = document.getElementById('searchfield');
    var box = document.getElementById('search-suggestions');
    if (!field || !box) return;

    function doSearch(q) {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', '/tienda/busqueda?ajax=1&q=' + encodeURIComponent(q));
      xhr.onload = function(){
        if (xhr.status !== 200) { box.style.display='none'; return; }
        // Extraer sólo el JSON (por si CI añade algo extra al principio/final)
        var raw = xhr.responseText.trim();
        var jsonStart = raw.indexOf('[');
        if (jsonStart === -1) { box.style.display='none'; return; }
        raw = raw.substring(jsonStart);
        var jsonEnd = raw.lastIndexOf(']');
        if (jsonEnd === -1) { box.style.display='none'; return; }
        raw = raw.substring(0, jsonEnd + 1);
        var data;
        try { data = JSON.parse(raw); } catch(e) { box.style.display='none'; return; }
        if (!data || !data.length) { box.style.display='none'; return; }
        var html = '';
        for (var i = 0; i < data.length; i++) {
          html += '<a href="' + data[i].url + '">';
          html += '<img class="search-thumb" src="' + data[i].img + '" alt=""/>';
          html += '<div class="search-info">';
          html += '<div class="search-label">' + data[i].label + '</div>';
          html += '<div class="search-price">' + data[i].price + '</div>';
          html += '</div></a>';
        }
        html += '<a class="search-all" href="#" onclick="document.getElementById(\'searchfield\').closest(\'form\').submit();return false;">Ver todos los resultados &rarr;</a>';
        box.innerHTML = html;
        box.style.display = 'block';
      };
      xhr.onerror = function(){ box.style.display='none'; };
      xhr.send();
    }

    field.addEventListener('input', function(){
      clearTimeout(timer);
      var q = this.value.trim();
      if (q.length < 3) { box.style.display='none'; return; }
      timer = setTimeout(function(){ doSearch(q); }, 800);
    });
    document.addEventListener('click', function(e){
      if (!field.contains(e.target) && !box.contains(e.target)) box.style.display = 'none';
    });
    field.addEventListener('focus', function(){
      if (box.innerHTML && this.value.trim().length >= 2) box.style.display = 'block';
    });
  })();

  // Header transparente → blanco al hacer scroll
  (function(){
    var header = document.querySelector('.site-header');
    if (!header) return;
    function checkScroll(){
      if (window.scrollY > 60) {
        header.classList.add('header-scrolled');
      } else {
        header.classList.remove('header-scrolled');
      }
    }
    window.addEventListener('scroll', checkScroll, {passive: true});
    checkScroll();
  })();

  // Ocultar barra info superior al hacer scroll
  (function(){
    var barra = document.querySelector('.barra-info-top');
    if (!barra) return;
    function checkBarraScroll(){
      if (window.scrollY > 10) {
        barra.classList.add('oculta');
      } else {
        barra.classList.remove('oculta');
      }
    }
    window.addEventListener('scroll', checkBarraScroll, {passive: true});
    checkBarraScroll();
  })();

  // Toggle buscador móvil
  (function(){
    var btn = document.getElementById('btn-search-movil');
    var bar = document.getElementById('buscador-movil-bar');
    if (!btn || !bar) return;
    btn.addEventListener('click', function(){
      var visible = bar.style.display === 'block';
      bar.style.setProperty('display', visible ? 'none' : 'block', 'important');
      if (!visible) {
        var input = bar.querySelector('input');
        if (input) setTimeout(function(){ input.focus(); }, 50);
      }
    });
  })();

  // Toggle buscador escritorio
  (function(){
    var btnOpen  = document.getElementById('btn-search-desktop');
    var btnClose = document.getElementById('btn-cerrar-busqueda-desktop');
    var bar      = document.getElementById('buscador-desktop-bar');
    var field    = document.getElementById('searchfield');
    if (!btnOpen || !bar) return;
    btnOpen.addEventListener('click', function(){
      var open = bar.style.display !== 'none';
      bar.style.display = open ? 'none' : 'block';
      if (!open && field) setTimeout(function(){ field.focus(); }, 50);
    });
    if (btnClose) btnClose.addEventListener('click', function(){ bar.style.display = 'none'; });
    document.addEventListener('click', function(e){
      if (bar.style.display === 'none') return;
      if (!bar.contains(e.target) && e.target !== btnOpen && !btnOpen.contains(e.target))
        bar.style.display = 'none';
    });
  })();
  </script>

</header>
