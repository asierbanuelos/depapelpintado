<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
/*
*/
$route['dgTsg36shsd73dbcr245sj9d'] = 'tools/db_cache_delete';
$route['default_controller'] = 'tienda';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['condiciones-de-pago'] = 'pagina_info/index/condiciones-de-pago';
$route['condiciones-de-envio'] = 'pagina_info/index/condiciones-de-envio';
$route['condiciones-de-devoluciones'] = 'pagina_info/index/condiciones-de-devoluciones';
$route['condiciones-de-uso'] = 'pagina_info/index/condiciones-de-uso';
$route['politica-de-privacidad'] = 'pagina_info/index/politica-de-privacidad';
$route['politica-de-cookies'] = 'pagina_info/index/politica-de-cookies';
$route['condiciones-particulares-de-contratacion'] = 'pagina_info/index/condiciones-particulares-de-contratacion';
$route['politica-de-envio-y-devoluciones'] = 'pagina_info/index/politica-de-envio-y-devoluciones';
$route['aviso-legal-formulario'] = 'pagina_info/index/aviso-legal-formulario';
$route['ayuda_papel_pintado'] = 'pagina_info/index/ayuda-papel-pintado';
$route['ayuda-papel-pintado'] = 'pagina_info/index/ayuda-papel-pintado';
$route['quienes-somos'] = 'pagina_info/index/quienes-somos';
$route['contacto'] = 'contacto/index';
$route['contacto/(:any)'] = 'contacto/index/$1';


/*
$route['condiciones-de-pago'] = 'condiciones_de_pago';
$route['condiciones-de-envio'] = 'condiciones_de_envio';
$route['condiciones-de-devoluciones'] = 'condiciones_de_devoluciones';
$route['condiciones-de-uso'] = 'condiciones_de_uso';
$route['politica-de-privacidad'] = 'politica_de_privacidad';
$route['politica-de-cookies'] = 'politica_de_cookies';
$route['aviso-legal-formulario'] = 'aviso_legal_formulario';
$route['ayuda_papel_pintado'] = 'ayuda_papel_pintado';
$route['contacto'] = 'contacto';
*/
// Para no perder los raices de un solo parámetro
$route['admin_library'] = 'admin_library';
$route['admin_library/(:any)'] = 'admin_library/$1';
$route['admin_library/(:any)/(:any)'] = 'admin_library/$1/$2';
$route['admin_library/(:any)/(:any)/(:any)'] = 'admin_library/$1/$2/$3';
$route['admin_library/(:any)/(:any)/(:any)/(:any)'] = 'admin_library/$1/$2/$3/$4';
$route['admin_library/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin_library/$1/$2/$3/$4/$5';
$route['admin_library/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin_library/$1/$2/$3/$4/$5/$6';
$route['admin_library/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin_library/$1/$2/$3/$4/$5/$6/$7';
$route['admin_library/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'admin_library/$1/$2/$3/$4/$5/$6/$7/$8';

$route['tienda'] = 'tienda';
$route['tienda/murales'] = 'tienda/murales';
$route['tienda/murales/(:any)'] = 'tienda/murales/$1';
$route['tienda/murales/(:any)/(:any)'] = 'tienda/murales/$1/$2';
$route['tienda/murales/(:any)/(:any)/(:any)'] = 'tienda/murales/$1/$2/$3';
$route['tienda/murales/(:any)/(:any)/(:any)/(:any)'] = 'tienda/murales/$1/$2/$3/$4';
$route['tienda/(:any)'] = 'tienda/$1';
$route['tienda/(:any)/(:any)'] = 'tienda/$1/$2';
$route['tienda/(:any)/(:any)/(:any)'] = 'tienda/$1/$2/$3';
$route['tienda/(:any)/(:any)/(:any)/(:any)'] = 'tienda/$1/$2/$3/$4';
$route['tienda/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'tienda/$1/$2/$3/$4/$5';
$route['tienda/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'tienda/$1/$2/$3/$4/$5/$6';
$route['tienda/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'tienda/$1/$2/$3/$4/$5/$6/$7';
$route['tienda/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'tienda/$1/$2/$3/$4/$5/$6/$7/$8';
$route['tienda/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'tienda/$1/$2/$3/$4/$5/$6/$7/$8/$9';
$route['tienda/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'tienda/$1/$2/$3/$4/$5/$6/$7/$8/$9/$10';

// ============================================================
// URLs SEO amigables de categoria (Fase 1) - sirven el contenido real
// Colocadas ANTES del catch-all comprobar_url para que no caigan en soft-404.
// Solo el slug exacto de cada categoria; las URLs viejas /tienda/* siguen igual.
// ============================================================
$route['papel-pintado'] = 'tienda/papel_pintado';
$route['murales'] = 'tienda/murales';
$route['revestimientos'] = 'tienda/revestimientos';
$route['telas'] = 'tienda/telas';
$route['alfombras'] = 'tienda/alfombras';
$route['herramientas'] = 'tienda/herramientas';
$route['complementos'] = 'tienda/complementos';
$route['outlet'] = 'tienda/papel_pintado/economicos';
$route['marcas'] = 'tienda/marcas';

// URL SEO de producto (Opcion A): /{marca}/{coleccion}/{nombre}-{id}  (ultimo segmento acaba en -numero)
// Va ANTES del catch-all; articulo() extrae el id del final. Las viejas /tienda/articulo/... siguen igual.
$route['([a-z0-9\-]+)/([a-z0-9\-]+)/([a-z0-9\-]+-[0-9]+)'] = 'tienda/articulo';
// Producto de herramientas (sin marca/coleccion): /herramientas/{nombre}-{id}
$route['herramientas/([a-z0-9\-]+-[0-9]+)'] = 'tienda/articulo';

// MARCAS (Opcion B: quitar /tienda/, mantener IDs). Seccion de marcas:
$route['marcas/marca/(:any)'] = 'tienda/marcas/marca/$1';
$route['marcas/marca/(:any)/(:any)'] = 'tienda/marcas/marca/$1/$2';
$route['marcas/marca/(:any)/(:any)/(:any)'] = 'tienda/marcas/marca/$1/$2/$3';
$route['marcas/marca/(:any)/(:any)/(:any)/(:any)'] = 'tienda/marcas/marca/$1/$2/$3/$4';
$route['marcas/marca/(:any)/(:any)/(:any)/(:any)/(:any)'] = 'tienda/marcas/marca/$1/$2/$3/$4/$5';
// Coleccion de una marca dentro de una categoria: /{cat}/marca/{id}/{name}[/{colid}/{colname}]
$route['papel-pintado/marca/(:any)/(:any)'] = 'tienda/papel_pintado/marca/$1/$2';
$route['papel-pintado/marca/(:any)/(:any)/(:any)/(:any)'] = 'tienda/papel_pintado/marca/$1/$2/$3/$4';
$route['murales/marca/(:any)/(:any)'] = 'tienda/murales/marca/$1/$2';
$route['murales/marca/(:any)/(:any)/(:any)/(:any)'] = 'tienda/murales/marca/$1/$2/$3/$4';
$route['revestimientos/marca/(:any)/(:any)'] = 'tienda/revestimientos/marca/$1/$2';
$route['revestimientos/marca/(:any)/(:any)/(:any)/(:any)'] = 'tienda/revestimientos/marca/$1/$2/$3/$4';
$route['telas/marca/(:any)/(:any)'] = 'tienda/telas/marca/$1/$2';
$route['telas/marca/(:any)/(:any)/(:any)/(:any)'] = 'tienda/telas/marca/$1/$2/$3/$4';
$route['alfombras/marca/(:any)/(:any)'] = 'tienda/alfombras/marca/$1/$2';
$route['alfombras/marca/(:any)/(:any)/(:any)/(:any)'] = 'tienda/alfombras/marca/$1/$2/$3/$4';
// Listado de marcas por categoria: /{cat}/marcas
$route['papel-pintado/marcas'] = 'tienda/papel_pintado/marcas';
$route['murales/marcas'] = 'tienda/murales/marcas';
$route['revestimientos/marcas'] = 'tienda/revestimientos/marcas';
$route['telas/marcas'] = 'tienda/telas/marcas';
$route['alfombras/marcas'] = 'tienda/alfombras/marcas';
// Marcas Opcion A (slugs limpios, sin ID): /marcas/{marca-slug}[/{coleccion-slug}]
$route['marcas/(:any)'] = 'tienda/marca_seo/$1';
$route['marcas/(:any)/(:any)'] = 'tienda/marca_seo/$1/$2';

$route['(:any)'] = 'tienda/comprobar_url/$1';
$route['(:any)/(:any)'] = 'tienda/comprobar_url/$1/$2';
$route['(:any)/(:any)/(:any)'] = 'tienda/comprobar_url/$1/$2/$3';
$route['(:any)/(:any)/(:any)/(:any)'] = 'tienda/comprobar_url/$1/$2/$3/$4';
/* End of file routes.php */
/* Location: ./application/config/routes.php */
