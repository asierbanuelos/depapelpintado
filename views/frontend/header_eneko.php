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


  <!-- Google tag (gtag.js) --> 
  <script async src="https://www.googletagmanager.com/gtag/js?id=GT-5NPLPMW"></script> 
  <script> 
    window.dataLayer = window.dataLayer || []; 
    function gtag(){dataLayer.push(arguments);} 
    gtag('js', new Date()); gtag('config', 'GT-5NPLPMW'); 
  </script>

  <?php
  /*
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-10880569823"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'AW-10880569823');
  </script>
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

  if (strpos(current_url(),'944056616') !== false){
  ?>
    <meta name="robots" content="noindex">
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
  <link rel="stylesheet" href="/includes/header_v7.css" >
  <?php 
  /*
  <link rel="stylesheet" href="/includes/header.min_v6.css" >
  <link rel="stylesheet" href="/includes/header.min_v6.css" >

  
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
  <link rel="preload" href="/includes/font-awesome/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="/includes/font-awesome/css/all.min.css"></noscript>
  

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&amp;display=swap" media="screen">
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

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-M44ZXZL');</script>
  <!-- End Google Tag Manager -->

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name" : "De Papel Pintado",
    "url" : "https://www.depapepintado.es/",
    "logo": {
      "@type": "ImageObject",
      "url":"https://www.depapepintado.es/includes/images/depapelpintado-logo.jpg"
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
      "@context": "http://schema.org",
      "@type": "Product",
      "name": "<?php echo $prod_name; ?>",
      "image": [
        "<?php echo $img_1; ?>",
        "<?php echo $img_2; ?>"
        ],
      "brand": {
        "@type": "Brand",
        "name": "<?php echo $key['cat_name']; ?>"
        },
      "offers": {
        "@type": "Offer",
        "price": "<?php echo number_format(round($prod_precio,2),2, '.',''); ?>",
        "priceCurrency": "EUR"
        }
      }
      </script>
      <?php 
    }
    else{
      ?>
      <script type="application/ld+json">
      {
      "@context": "http://schema.org",
      "@type": "Product",
      "name": "<?php echo $prod_name; ?>",
      "image": [
        "<?php echo $img_1; ?>"
        ],
      "offers": {
        "@type": "Offer",
        "price": "<?php echo number_format(round($prod_precio,2),2, '.',''); ?>",
        "priceCurrency": "EUR"
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
</head>
<body id="cart">
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
<header>
  <div class="container">
    <div class="row cabecera-fija <?php //fixed-top ?> mb-2 mb-md-4 bg-white align-items-center">
      <div class="col-md-8 col-lg-4">
        <div class="contacto-header text-center">
          <a href="/" title='Inicio' aria-label="Inicio"><i class="fa fa-home"></i></a>    
          <a href="tel:+34944056616" rel="nofollow" title='Teléfono de contacto' aria-label="Telf: 94 405 66 16" >Telf: 94 405 66 16</a> / 
          <a href="mailto:info@depapelpintado.es" rel="nofollow"  title='Email de contacto' aria-label="Email de contacto: info@depapelpintado.es">info@depapelpintado.es</a>
        </div>
      </div>
      <div class="col-md-4 d-none d-lg-block">
        <div class="horario-header text-center">
          <?php 
          $this->load->view('frontend/horarios'); 
          //echo $horario; 
          ?>
        </div>
      </div>
      <div class="col-md-4">
        <div class="enlaces-header text-center">
          <ul class='d-none d-lg-block'>
            <?php 
            if ($usuario->user_id<=1)
              $textocuenta="Mi cuenta";
            else if($usuario->ord_demo_ship_name!="")
              $textocuenta=$usuario->ord_demo_ship_name;
            else if($usuario->ord_demo_bill_name!="")
              $textocuenta=$usuario->ord_demo_bill_name;
            else $textocuenta=$usuario->email;
              
            echo "<li>".anchor("tienda/mi_cuenta",$textocuenta)."</li>";
            ?>
            <li><a href="/contacto" title="Contacto">Contacto</a></li>
            <li><a href="/ayuda-papel-pintado" title="Te ayudamos">Te ayudamos</a></li>
            <?php
            ?>
          </ul>
          <?php
          $this->load->view('frontend/redes_sociales'); 
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="header-top" id="inicio1">
    <div class="inner">
      <div class="wrapper">
        <div class="container">
          <div class="row header-flex no-margin ApRow  has-bg bg-boxed align-items-center" style="background: no-repeat;" data-bg_data=" no-repeat">

            <div class="col-6 col-md-3 text-start d-lg-none order-2 order-md-1">
              <button class="navbar-toggler pl-0 pt-2" type="button" data-toggle="canvas" data-target="#bs-canvas-left" aria-controls="s-canvas-left" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="border: 1px solid #666;padding-top: 5px;border-radius: 3px;"><i class="fas fa-bars"></i></span>
                <span class='txt-menu'>MENÚ</span>
              </button>
            </div>

            <div class="col-xl-3 col-lg-2 col-md-6 col-12 order-1 order-md-2 order-lg-2 text-center text-lg-start">
              <a href="/">
                <picture>
                  <source srcset="/images/logo-depapelpintado.webp" type="image/webp">
                  <source srcset="/images/depapelpintado.jpg" type="image/jpeg">   
                  <img class="logo img-fluid" src="/images/logo-depapelpintado.jpg" alt="De Papel Pintado" height="50" width="232">
                </picture>
              </a>
            </div>
            <div class="col-6 col-md-3 d-lg-none pt-3 order-3 text-right">
              <?php //minicarro
              //$this->load->view('frontend/minicarro'); 
              $data_aux['ocultar_enlace']=true;
              $this->load->view('frontend/menu_usuario_movil', $data_aux); 
              $this->load->view('frontend/minicarro_nuevo_movil', $data_aux); 
              ?>
            </div>

            <div class="col-xl-6 col-lg-8 d-flex justify-content-center m-auto order-4">
              <div id="search_widget" class="search-widget popup-over w-100 text-center mt-4" data-search-controller-url="/tienda/busqueda">
                <form action="/tienda/busqueda" method="post">
                  <input id="searchfield" type="text" name="search" class="buscador w-100" placeholder="Busque en nuestro catálogo"/>
                  <button class="link_button2 float-xs-right popup-title" type="submit" value="Buscar" aria-label="Buscar"/><i class="fa fa-search"></i></button>
                  <label for="searchfield" ></label> 
                </form>

              </div>
            </div>

            <div class="col-xl-3 col-lg-2 d-none d-lg-block right-header no-padding ApColumn  text-right order-5 ">
              <?php //minicarro
              //$this->load->view('frontend/minicarro'); 
              $this->load->view('frontend/minicarro_nuevo_2'); 
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- fin barra superior -->
  <!-- cabecera: logo, carro, iconos pago -->
  <!-- fin cabecera: logo, carro, iconos pago -->
  <!-- menu principal superior -->
  <?php //menu principal
  $this->load->view('frontend/menu_principal'); 
  //$this->load->view('frontend/menu_principal_presta'); 
  ?>
  <!-- fin menu principal superior --> 
</header>
