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
	

$flexi_cart_library = (isset($current_url['admin_library'])) ? 'flexi_cart_admin' : 'flexi_cart'; ?>
	<div class="content_wrap nav_bg">
		<div id="sub_nav_wrap" class="content">
			<ul class="sub_nav">
              <li class="css_nav_dropmenu">
					<a href="#">Contenido</a>
                    <ul>
                      <li class="header">&nbsp;</li>
                      <li><a href="<?php echo $base_url; ?>admin_library/contenido">Bloques</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/home_edit">Home</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/categorias_proyectos">Categorías Proyectos</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/proyectos">Proyectos</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/categorias_noticias">Categorías Noticias</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/noticias">Noticias</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/faqs">FAQs (Preguntas frecuentes)</a></li>
                    </ul>
				</li>
				<li class="css_nav_dropmenu">
					<a href="<?php echo $base_url; ?>admin_library/articulos">Articulos</a>
                    <ul>
                      <li class="header">Configurar "Grupos"</li>
                      <li><a href="<?php echo $base_url; ?>admin_library/tipo_productos_seo">Tipos Producto SEO</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/fabricantes">Fabricantes</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/fabricantes_seo">Fabricantes info SEO</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/colecciones">Colecciones</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/colecciones_seo">Colecciones info SEO</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/categorias_seo">Nuevas Categorías SEO</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/modelos">Modelos</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/colores">Colores</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/estilos">Estilos</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/herramientas">Herramientas</a></li>
                      <li class="header">Especiales
						<small>Accesos rapidos a funciones especificas</small>
                      </li>
                      <li><a href="<?php echo $base_url; ?>admin_library/noimg">Editar</a>
                      <small>Lista aquellos artículos que no<br/>tienen imágenes para añadirlas</small></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/listado_articulos_portada">Articulos en portada</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/listado_colecciones_en_meta">Colecciones en META</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/precios_santos_monteiro/m_cuadrado">Precios Santos monteiro m<sup>2</sup></a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/precios_santos_monteiro/m_cuadrado_exacto">Precios Santos monteiro m<sup>2</sup> (ancho rollo)</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/tarifas_acabados">Tarifas acabados alfombras</a></li>
                      <li><a href="<?php echo $base_url; ?>admin_library/orden_colecciones">Orden de colecciones</a></li>
                    </ul>
				</li>
                <li><a href="<?php echo $base_url; ?>admin_library/orders">Pedidos</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/paypal">Paypal</a></li>
				<li class="css_nav_dropmenu">
					<a href="<?php echo $base_url; ?>admin_library/">Otras Configuraciones</a>
					<ul>
						
						<!--<li class="header">Zonas</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/location_types">Areas</a>
						</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/zones">Zonas</a>
						</li>-->
						<li class="header">Envio e Impuestos</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/shipping">Ociones de Envio</a>
						</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/tax">Impuestos</a>
						</li>
						<li class="header">Descuentos</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/item_discounts">Por Articulo</a>
						</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/item_discounts_ekam">Por Articulo EKAM</a>
						</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/summary_discounts">Resumen</a>
						</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/summary_discounts_ekam">Resumen EKAM</a>
						</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/discount_groups">Grupos de descuento</a>
						</li>
						<li class="header">Puntos fidelidad y vales</li>
						<!--<li>
							<a href="<?php echo $base_url; ?>admin_library/user_reward_points">Puntos Fidelidads</a>
						</li>-->
						<li>
							<a href="<?php echo $base_url; ?>admin_library/vouchers">Vales</a>
						</li>
						<li class="header">Moneda y configuracion del carro.</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/currency">Monedas</a>
						</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/order_status">Estado del pedido</a>
						</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/config">Configuracion del carro</a>
						</li>
						<li>
							<a href="<?php echo $base_url; ?>admin_library/defaults">Valores por defecto</a>
						</li>
					</ul>		
				</li>
        <li class="css_nav_dropmenu"><a href="<?php echo $base_url; ?>admin_library/mkt_usr">Listados Marketing</a>
            <ul>
                <li><a href="<?php echo $base_url; ?>admin_library/mkt_fab">Fabricantes</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/mkt_col">Colecciones</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/listado_colecciones_categorias/0" target='_blank'>Colecciones Papel por categoría</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/listado_colecciones_categorias/1" target='_blank'>Colecciones Fotomurales por categoría</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/listado_colecciones_categorias/2" target='_blank'>Colecciones Revestimientos por categoría</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/listado_colecciones_categorias/3" target='_blank'>Colecciones Telas por categoría</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/listado_colecciones_categorias/4" target='_blank'>Colecciones Alfombres por categoría</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/listado_categorias_colecciones/0" target='_blank'>Categorías Papel por colección</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/listado_categorias_colecciones/1" target='_blank'>Categorías Fotomurales por colección</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/listado_categorias_colecciones/2" target='_blank'>Categorías Revestimientos por colección</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/listado_categorias_colecciones/3" target='_blank'>Categorías Telas por colección</a></li>
                <li><a href="<?php echo $base_url; ?>admin_library/listado_categorias_colecciones/4" target='_blank'>Categorías Alfombres por colección</a></li>
            </ul>
        </li>
        <li style="float:right"><a target="_blank" style="font-size:11px;color:#FF5858" href="http://www.depapelpintado.es/dgTsg36shsd73dbcr245sj9d">Vaciar caché</a></li>
                                
			</ul>
		</div>
	</div>
<?php if ($this->session->flashdata('admin_saved')): ?>
<div id="admin-toast" style="position:fixed;bottom:24px;right:24px;background:#2e7d32;color:#fff;padding:12px 22px;border-radius:6px;font-size:14px;font-weight:bold;box-shadow:0 4px 12px rgba(0,0,0,0.25);z-index:99999;opacity:1;transition:opacity 0.5s">
  ✓ Cambios guardados correctamente
</div>
<script>setTimeout(function(){ var t=document.getElementById('admin-toast'); if(t){t.style.opacity='0';setTimeout(function(){t.remove()},500);} }, 3000);</script>
<?php endif; ?>