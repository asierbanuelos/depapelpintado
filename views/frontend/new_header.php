<?php
function urlenc($str){
        $search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,!,(,)");
        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,ñ,,,");

        return str_replace($search,$replace,strtolower(str_replace(',','', str_replace('+','-plus-',str_replace('#','number-',str_replace('&','and',str_replace(' ','-',rawurldecode($str))))))));
}
function urldec($str){
    return str_replace('-',' ',str_replace('-plus-','+',str_replace('-and-',' & ',rawurldecode($str))));
}
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);?>
<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
  <?php
  /* 
  <!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js" itemscope itemtype="http://schema.org/Product"><!--<![endif]-->
  */
  ?>
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<title><? if(!isset($title2)){ echo (isset($title))?$title:""?>De Papel Pintado <? } else { echo $title2; }?></title>
	<meta name="description" content="<? if(!isset($description2)){echo (isset($description))?$description:"";}else{echo $description2;}?>"/> 
	<meta name="keywords" content="<? if(!isset($keywords2)){echo (isset($keywords))?$keywords:"";}else{echo $keywords2;}?>"/>
	<meta name="p:domain_verify" content="8bfbd62d7f101f5ebc24bc1647e8a41d"/>
	<?if (strpos(current_url(),'944056616') !== false){?><meta name="robots" content="noindex"><?}else{?><meta name="robots" content="index, follow"/><?}?>
	<?if(isset($extrameta)) echo $extrameta;?>
	<?php
	/*
	<meta name="author" content="http://www.bitarlan.net"/>
	*/
	?>

	<meta name="copyright" content="Copyright &copy; <?php echo date('Y');?>, dePapelPintado.com, All Rights Reserved"/>
	<meta http-equiv="imagetoolbar" content="no"/>


	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	
  <?php $this->load->view('includes/scripts'); ?>
  <?php 
  /**
  <script src="/includes/js/shadowbox/shadowbox.js"></script>
  <link rel="stylesheet" href="/includes/js/shadowbox/shadowbox.css">
   */
  ?>
	<script src="<?php echo $includes_dir; ?>js/jsCarousel/jsCarousel-2.0.0.js"></script>
	<script src="<?php echo $includes_dir; ?>js/scroll.js"></script>
  
  <?php
  $url_actual_zatiak=explode('/orden/',current_url());

  //$url_actual=current_url();
  $url_actual=$url_actual_zatiak[0];
  ?>
  <link rel="canonical" href="<?php echo str_replace('http:', 'https:', $url_actual); ?>" />
	
	<link rel="stylesheet" href="<?=$includes_dir?>js/zoomy.css">
	<link rel="stylesheet" href="<?=$includes_dir?>js/jquery_ui/jquery-ui.min.css"> <?php // quitar carpeta jquery_ui/ para coger el css original ; ?>
	<link rel="stylesheet" href="<?=$includes_dir?>js/jsCarousel/jsCarousel-2.0.0.css">
	<!--  <link href='http://fonts.googleapis.com/css?family=Rochester' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow:400,700' rel='stylesheet' type='text/css'>
	--> 
	<link rel="shortcut icon" href="https://www.depapelpintado.es/favicon.ico"> 

	<!--<link rel="stylesheet" href="<?=$includes_dir?>style.css">-->
	<link rel="stylesheet" href="<?=$includes_dir?>kube.css">
  <?php 
  ?>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

  <link rel="stylesheet" href="<?=$includes_dir?>html-slider.css">

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
  /*
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList"
    }
  </script> 

  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebPage",
      "isPartOf": {
        "@type": "WebSite",
          "url" : "https://www.depapepintado.es/",
          "name": "De Papel Pintado"
      },
      "name": "Papel Pintado GALUCHAT IVORY - GA01 - Andrew Martin",
      "url":  "https://www.elmundodelpapelpintado.com/papel-pintado/marcas/andrew-martin/engineer/9696-galuchat-ga01-7400000096967.html"
    }
  </script>
  */
  ?>
    
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


  ?>


	<?php 
	if(isset($cssseo)) 
		echo htmlspecialchars_decode($cssseo->texto);
	
	if(isset($recaptcha_v3))
		echo "	<script src='https://www.google.com/recaptcha/api.js?render=".RECAPTCHA_V3_SITE_KEY."'></script>";
	?>
	<?php
  /*
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-58619860-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-58619860-1');
    gtag('config', 'AW-973779706');
    gtag('config', 'AW-949991153');
	</script>
  */
  ?>
  <meta name="google-site-verification" content="0JEDsNegisYaZRBFZaZCqkcHsAt8__hKK7utQXezAt0" />
</head>
<body id="cart">
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M44ZXZL"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <?php
  /*
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.3";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
  */
  ?>
  
  <?php
  /*
  <!-- Google Tag Manager -->
  <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-K68KRL"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-K68KRL');</script>
  <!-- End Google Tag Manager -->
  */
  ?>
    <script>
      // Hide content onload, prevents JS flicker
      document.body.className += ' js-enabled';
      <?if(isset($categ)){?>var categ= "<?=$categ?>";<?}?>
    </script>
    
    <header>
     <?php $mensaje = $this->contenido_model->get_page(47);
     if(isset($mensaje->texto) && $mensaje->texto!=''):
     ?> 
     <div class="units-row gris-oscurobg end barrasuperior">
     <p class="horario-cabecera" style="text-align:center;font-weight:bold;font-size:13px"><?php echo $mensaje->texto ?></p> 
	</div>
	<?php endif; ?>

    <!-- barra superior -->
    <div class="units-row gris-oscurobg end barrasuperior">
    	
      <div class="unit-50 end">

        <div class="units-row end">
          <div class="unit-40">
          
          <nav>
          <ul class="minimenu1">
         <li> <?=anchor("",'<img src="'.$includes_dir.'images/home.png" alt="Home - Inicio" title="Home - Inicio" width="31" height="28" loading="lazy" //>');?></li>
         <li> <?=anchor("contacto",'<img src="'.$includes_dir.'images/contacto.png"  alt="Contacto" title="Contacto" width="36" height="29" loading="lazy" />');?></li>
         <li class="tlf-cabecera"> &nbsp;&nbsp;Tlf: <a rel="nofollow" target="_blank" href="tel:944056616">94 405 66 16</a></li>
          </ul>
         </nav> 
          
          </div>
        
	<?php
	$gaur=date('Y-m-d');
	//~ $gaur='2021-08-28';
	$quitar_padding_top='';
	if ($gaur <= '2021-08-27')	
		$quitar_padding_top=" style='padding-top:0' ";
	?>
	<div class="unit-60">
		<p class="horario-cabecera" <?php echo $quitar_padding_top; ?> >
		<?php
		$hilabete_eguna=date('m-d');
		//~ $hilabete_eguna='08-31';
		if ($hilabete_eguna>='07-01' && $hilabete_eguna<='08-31')
			echo "Horario de verano: de lunes a viernes de 10:00h a 14:00h \n";
		else
			//echo "De lunes a viernes de 9:30h a 15:00h \n";
			//~ echo "De lunes a viernes de 10:00h a 13:30h \n";
			//~ echo "De lunes a viernes de 9:30h a 14:30h \n";
			echo "De lunes a jueves de 9:30h a 14:30h y de 16:30h a 18:30h \n";
      echo "<br />Viernes de 9:30h a 15:00h  \n";
			//~ echo "De lunes a viernes de 10:00h a 14:00h \n";
		if ($gaur <= '2022-08-26')	
			echo "<br />Viernes 26 de agosto cerrado por festivo local \n";
		?>
		</p>
	</div>
        </div>
      </div>

      
      
      <div class="unit-50">
        <div class="units-row units-split end">
          <div class="unit-60">
          
          <nav>
          <ul class="minimenu2 separacion-barravertical">
          <li><a href="http://www.decoracionbilbao.es/sobre-nosotros/" title="Quienes somos Depapelpintado" target="_blank">Quienes Somos</a></li>
          
          
            <li>
             <?=anchor("ayuda_papel_pintado","Te ayudamos");?>
            </li>
            <?
            if ($usuario->user_id<=1)$textocuenta="Mi cuenta";
            
            else if($usuario->ord_demo_ship_name!="")$textocuenta=$usuario->ord_demo_ship_name;
            else if($usuario->ord_demo_bill_name!="")$textocuenta=$usuario->ord_demo_bill_name;
            else $textocuenta=$usuario->email;
            ?>
          <li><?=anchor("tienda/mi_cuenta",$textocuenta);?></li>
          </ul>
          </nav>
          
          
          </div>
         
          <div class="unit-40">
          
        <ul class="minimenu1">
        
        
         <li> <a href="https://www.facebook.com/pages/depapelpintadoes/841339525924852" target="_blank"><img src="<?=$includes_dir?>images/facebook.jpg"  alt="Búscanos en Facebook" title="Búscanos en Facebook" width='36' height='29' loading='lazy' /></a></li>
         <li> <a href="https://twitter.com/EKAMDecoracion" target="_blank"><img src="<?=$includes_dir?>images/twitter.jpg"  alt="Síguenos en Twitter" title="Síguenos en Twitter" width='36' height='29' loading='lazy' /></a></li>
         <?php
         /*
         <li> <a href="https://plus.google.com/u/0/b/101395417104462170337/101395417104462170337/about" target="_blank"><img src="<?=$includes_dir?>images/googleplus.jpg"  alt="" ></a></li>
         */
         ?>
         <li> <a href="https://instagram.com/depapelpintado.es/" target="_blank"><img src="<?=$includes_dir?>images/instagram.jpg"  alt="Síguenos en Instagram" title="Síguenos en Instagram" width='36' height='29' loading='lazy' /></a></li>
         <li> <a href="https://es.pinterest.com/depapelpintado/" target="_blank"><img src="<?=$includes_dir?>images/pinterest.jpg"  alt="Síguenos en Pinterest" title="Síguenos en Pinterest" width='36' height='29' loading='lazy' /></a></li>
          </ul>  
          
          
           
          </div>
        </div>
      </div>
    </div>
    
    <!-- fin barra superior -->
   
   <!-- cabecera: logo, carro, iconos pago -->
   
   <div id="inicio1" class="units-row gris-verdoso-clarobg end">
    <?php
    /*  
    <!-- El script de google translator me genera una etiqueta <h1>Texto original</h1> que no puedo manipular por si hiciera falta en vistas a estructura de SEO -->
   	<div id="google_translate_element" style="min-height:27px;"></div>
    */
    ?>

    <div class="unit-centered unit-80 cuerpocentral">
    <div class="unit-50 logo text-left" style="height:100px;z-index: 99999999999;position:relative;">

    <h1><img src="<?=$includes_dir?>images/img-depapelpintado.png"  alt="dePapelPintado" title="dePapelPintado" ><?=anchor("",'de<span>P</span>apel<span>P</span>intado');?></h1>
   
    </div>
    <div class="unit-50" style="z-index: 99999999999;position:relative;">
    
     <div class="units-row end">
  
     	
     <div class="unit-push-30 unit-70 search">
       <form action="<?=  base_url()."tienda"?>" method="post">
     		<input style="width:70%" id="searchfield" type="text" name="search" class="buscador" placeholder="Busqueda Avanzada..."/><button style="width:30%" class="link_button2" type="submit" value="Busca" aria-label="Busca"/><i class="fa fa-search"></i></button>
     		<label for="searchfield" ></label> 
     	</form>
     </div>
     </div>
     </div>
    
    <div class="units-row" style="height:130px;position:relative;">
    

      <?php //minicarro
     
         $this->load->view('frontend/minicarro'); 

    ?>


</div>
</div>
</div>
   
   
    
    
      <!-- fin cabecera: logo, carro, iconos pago -->
    
   <!-- menu principal superior -->
    <div class="units-row end gris-verdoso-clarobg">
 <div class="unit-centered unit-80 cuerpocentral">
 
 <nav class="nav fullwidth menu-principal">
      <ul class="separacion-barravertical">
          <?$cat=-1;
          if(isset($categ))$cat=$categ;
          if (strpos(uri_string(),"economicos")!==false)$cat=-3;
          if (strpos(uri_string(),"articulo")!==false && isset ($key['item_tipo']))
            $cat=$key['item_tipo'];?>
        <li <?if($cat==0) echo ' class="activa" style="background-color:#880643;color:#ccc"'?>><?=anchor("tienda/papel_pintado","PAPEL PINTADO",'class="miclase"');//como tercer parametros puedes meter cualquier attr.?></li>
        <li <?if($cat==1) echo ' class="activa" style="background-color:#880643;color:#ccc"'?>><?=anchor("tienda/murales","MURALES");?></li>
        <li <?if($cat==2) echo ' class="activa" style="background-color:#880643;color:#ccc"'?>><?=anchor("tienda/revestimientos","REVESTIMIENTOS");?></li>
	<?php
	/*
        <li <?if($cat==-3) echo ' class="activa" style="background-color:#880643;color:#ccc"'?>><?= anchor("tienda/papel_pintado/economicos", "ECONÓMICOS"); ?></li>
        */
	?>
	<li <?if($cat==-3) echo ' class="activa" style="background-color:#880643;color:#ccc"'?>><?= anchor("tienda/papel_pintado/economicos", "OUTLET"); ?></li>
        <li <?if($cat==3) echo ' class="activa" style="background-color:#880643;color:#ccc"'?>><?=anchor("tienda/telas","TELAS");?></li>
        <li <?if($cat==4) echo ' class="activa" style="background-color:#880643;color:#ccc"'?>><?=anchor("tienda/alfombras","ALFOMBRAS");?></li>
        <li <?if($cat==5) echo ' class="activa" style="background-color:#880643;color:#ccc"'?>><?=anchor("tienda/herramientas","HERRAMIENTAS");?></li>
        
      </ul>
      </nav>
      
      </div>
    </div>
   <!-- fin menu principal superior --> 
   
   </header>