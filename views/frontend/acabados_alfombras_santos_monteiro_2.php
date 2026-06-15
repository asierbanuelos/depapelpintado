<?php
// 4: alfombras
// 268: marca Santos Monteiro

$a_forma_alfombra[4][268]['RECTANGULAR CUADRADA']['img']='/includes/images/acabados-santos-monteiro/rectangular-cuadrada.jpg';
$a_forma_alfombra[4][268]['REDONDA']['img']='/includes/images/acabados-santos-monteiro/redonda.jpg';
$a_forma_alfombra[4][268]['ROLLO']['img']='/includes/images/acabados-santos-monteiro/rollo.jpg';

$a_acabados[4][268]['SIN ACABADO']['img']='/includes/images/acabados-santos-monteiro/sin-acabado.jpg';
$a_acabados[4][268]['BAY']['img']='/includes/images/acabados-santos-monteiro/bay.jpg';
$a_acabados[4][268]['COLOR']['img']='/includes/images/acabados-santos-monteiro/color.jpg';
$a_acabados[4][268]['DOBRA']['img']='/includes/images/acabados-santos-monteiro/dobra.jpg';
$a_acabados[4][268]['DUNE']['img']='/includes/images/acabados-santos-monteiro/dune.jpg';
$a_acabados[4][268]['EASY']['img']='/includes/images/acabados-santos-monteiro/easy.jpg';
$a_acabados[4][268]['JUST']['img']='/includes/images/acabados-santos-monteiro/just.jpg';
$a_acabados[4][268]['LINE']['img']='/includes/images/acabados-santos-monteiro/line.jpg';
$a_acabados[4][268]['VENEZA']['img']='/includes/images/acabados-santos-monteiro/veneza.jpg';
$a_acabados[4][268]['FRANJA']['img']='/includes/images/acabados-santos-monteiro/franja.jpg';
$a_acabados[4][268]['LINE COLORS']['img']='/includes/images/acabados-santos-monteiro/line-colors.jpg';
$a_acabados[4][268]['FRESH']['img']='/includes/images/acabados-santos-monteiro/fresh.jpg';
$a_acabados[4][268]['LUX']['img']='/includes/images/acabados-santos-monteiro/lux.jpg';
$a_acabados[4][268]['TWILL']['img']='/includes/images/acabados-santos-monteiro/twill.jpg';

// Los metros lineales son para calcular a partir del rollo
$a_acabados[4][268]['SIN ACABADO']['precio_m_lineal']=0;
$a_acabados[4][268]['BAY']['precio_m_lineal']=11.16;
$a_acabados[4][268]['COLOR']['precio_m_lineal']=8.4;
$a_acabados[4][268]['DOBRA']['precio_m_lineal']=9.6; // Mirar lo que hay que sumar por m2 por el fieltro
$a_acabados[4][268]['DOBRA']['precio_m2_fieltro']=26.40; 
$a_acabados[4][268]['DUNE']['precio_m_lineal']=9.36;
$a_acabados[4][268]['EASY']['precio_m_lineal']=9.36;
$a_acabados[4][268]['JUST']['precio_m_lineal']=10.8;
$a_acabados[4][268]['LINE']['precio_m_lineal']=5.4;
$a_acabados[4][268]['VENEZA']['precio_m_lineal']=9.72;
$a_acabados[4][268]['FRANJA']['precio_m_lineal']=34.8;
//$a_acabados[4][268]['LINE COLORS']['precio_m_lineal']=6.6;
$a_acabados[4][268]['LINE COLORS']['precio_m_lineal']=10.5;
$a_acabados[4][268]['FRESH']['precio_m_lineal']=21.36;
$a_acabados[4][268]['LUX']['precio_m_lineal']=8.64;
$a_acabados[4][268]['TWILL']['precio_m_lineal']=10.56;

// Precios del metro cuadrado a medida del acabado
$a_acabados[4][268]['BAY']['precio_m2_medida']=23.34; // ojo coleccion Sleek -> 25.73
$a_acabados[4][268]['COLOR']['precio_m2_medida']=19.59;
$a_acabados[4][268]['DOBRA']['precio_m2_medida']=49.1; // Mirar lo que hay que sumar por m2 por el feltex
$a_acabados[4][268]['DUNE']['precio_m2_medida']=19.59;
$a_acabados[4][268]['EASY']['precio_m2_medida']=19.59;
$a_acabados[4][268]['JUST']['precio_m2_medida']=22.59;
$a_acabados[4][268]['LINE']['precio_m2_medida']=11.31;
$a_acabados[4][268]['VENEZA']['precio_m2_medida']=19.59;
$a_acabados[4][268]['LUX']['precio_m2_medida']=18.08;
$a_acabados[4][268]['TWILL']['precio_m2_medida']=22.09;
// Los siguientes acabados no tienen precio por metro cuadrado a medida
// Para que el calculo a medida se dispare, ya que no hay opción y si dejamos sin poner sale como sin acabado
$a_acabados[4][268]['FRANJA']['precio_m2_medida']=999.9; 
$a_acabados[4][268]['LINE COLORS']['precio_m2_medida']=999.9;
$a_acabados[4][268]['FRESH']['precio_m2_medida']=999.9;


$extra_coleccion[4][268][1938]['extra_precio_m2_medida']=12.12; // La coleccion Creek (id 1938) sale 12.12 más cara el metro cuadrado a medida

$extra_acabado[4][268]['LINE'][1948]=8.52; // La Sisal Natura (id 1948) sale 8.52 más cara el metro cuadrado a medida en el acabado LINE
$extra_acabado[4][268]['LINE'][1816]=8.52; // La Stone contract (id 1816) sale 8.52 más cara el metro cuadrado a medida en el acabado LINE
$extra_acabado[4][268]['LINE'][1817]=8.52; // La Stone  (id 1817) sale 8.52 más cara el metro cuadrado a medida en el acabado LINE
$extra_acabado[4][268]['LINE'][1818]=8.52; // La Stone rustique (id 1818) sale 8.52 más cara el metro cuadrado a medida en el acabado LINE
$extra_acabado[4][268]['LINE'][1819]=8.52; // La Stone colors (id 1819) sale 8.52 más cara el metro cuadrado a medida en el acabado LINE

$extra_acabado[4][268]['LUX'][1948]=8.52; // La Sisal Natura (id 1948) sale 8.52 más cara el metro cuadrado a medida en el acabado LUX

$precio_promo[4][268]['DOBRA'][1803]=15.78; // La colceccion chenille (id 1803) está mucho más barata que el precio general DOBRA

$extra_acabado_lineal[4][268]['LINE'][1816]=3.9; // La Stone contract (id 1816) sale 3.9 más cara el metro lineal en el acabado LINE
$extra_acabado_lineal[4][268]['LINE'][1817]=3.9; // La Stone  (id 1817) sale 3.9 más cara el metro lineal en el acabado LINE
$extra_acabado_lineal[4][268]['LINE'][1818]=3.9; // La Stone rustique (id 1818) sale 3.9 más cara el metro lineal en el acabado LINE
$extra_acabado_lineal[4][268]['LINE'][1819]=3.9; // La Stone colors (id 1819) sale 3.9 más cara el metro lineal en el acabado LINE

//$a_acabados[4][268]['PREMIUM']['precio_m_2']=40.8;

$a_acabados[4][268]['BAY']['opciones']='bay';
$a_acabados[4][268]['COLOR']['opciones']='color';
$a_acabados[4][268]['DUNE']['opciones']='dune';
$a_acabados[4][268]['EASY']['opciones']='easy';
$a_acabados[4][268]['JUST']['opciones']='just';
$a_acabados[4][268]['VENEZA']['opciones']='veneza';
$a_acabados[4][268]['FRANJA']['opciones']='franja';
$a_acabados[4][268]['FRESH']['opciones']='fresh';

$a_acabados[4][268]['BAY']['txt_opciones']='ACABADO BAY';
$a_acabados[4][268]['COLOR']['txt_opciones']='ACABADO COLOR';
$a_acabados[4][268]['DUNE']['txt_opciones']='ACABADO DUNE';
$a_acabados[4][268]['EASY']['txt_opciones']='ACABADO EASY';
$a_acabados[4][268]['JUST']['txt_opciones']='ACABADO JUST';
$a_acabados[4][268]['VENEZA']['txt_opciones']='ACABADO VENEZA';
$a_acabados[4][268]['FRANJA']['txt_opciones']='ACABADO FRANJA';
$a_acabados[4][268]['FRESH']['txt_opciones']='ACABADO FRESH';

$a_opciones['bay']['BAY 001']='/includes/images/acabados-santos-monteiro/bay/001.jpg';
$a_opciones['bay']['BAY 002']='/includes/images/acabados-santos-monteiro/bay/002.jpg';
$a_opciones['bay']['BAY 003']='/includes/images/acabados-santos-monteiro/bay/003.jpg';
$a_opciones['bay']['BAY 004']='/includes/images/acabados-santos-monteiro/bay/004.jpg';
$a_opciones['bay']['BAY 005']='/includes/images/acabados-santos-monteiro/bay/005.jpg';
$a_opciones['bay']['BAY 006']='/includes/images/acabados-santos-monteiro/bay/006.jpg';
$a_opciones['bay']['BAY 007']='/includes/images/acabados-santos-monteiro/bay/007.jpg';
$a_opciones['bay']['BAY 008']='/includes/images/acabados-santos-monteiro/bay/008.jpg';
$a_opciones['bay']['BAY 009']='/includes/images/acabados-santos-monteiro/bay/009.jpg';

$a_opciones['color']['COLOR 437']='/includes/images/acabados-santos-monteiro/color/437.jpg';
$a_opciones['color']['COLOR 337']='/includes/images/acabados-santos-monteiro/color/337.jpg';
$a_opciones['color']['COLOR 338']='/includes/images/acabados-santos-monteiro/color/338.jpg';
$a_opciones['color']['COLOR 006']='/includes/images/acabados-santos-monteiro/color/006.jpg';
$a_opciones['color']['COLOR 111']='/includes/images/acabados-santos-monteiro/color/111.jpg';
$a_opciones['color']['COLOR 517']='/includes/images/acabados-santos-monteiro/color/517.jpg';
$a_opciones['color']['COLOR 097']='/includes/images/acabados-santos-monteiro/color/097.jpg';
$a_opciones['color']['COLOR 232']='/includes/images/acabados-santos-monteiro/color/232.jpg';
$a_opciones['color']['COLOR 378']='/includes/images/acabados-santos-monteiro/color/378.jpg';
$a_opciones['color']['COLOR 516']='/includes/images/acabados-santos-monteiro/color/516.jpg';
$a_opciones['color']['COLOR 013']='/includes/images/acabados-santos-monteiro/color/013.jpg';
$a_opciones['color']['COLOR 617']='/includes/images/acabados-santos-monteiro/color/617.jpg';
$a_opciones['color']['COLOR 079']='/includes/images/acabados-santos-monteiro/color/079.jpg';
$a_opciones['color']['COLOR 585']='/includes/images/acabados-santos-monteiro/color/585.jpg';
$a_opciones['color']['COLOR 438']='/includes/images/acabados-santos-monteiro/color/438.jpg';
$a_opciones['color']['COLOR 060']='/includes/images/acabados-santos-monteiro/color/060.jpg';
$a_opciones['color']['COLOR 038']='/includes/images/acabados-santos-monteiro/color/038.jpg';
$a_opciones['color']['COLOR 101']='/includes/images/acabados-santos-monteiro/color/101.jpg';
$a_opciones['color']['COLOR 001']='/includes/images/acabados-santos-monteiro/color/001.jpg';
$a_opciones['color']['COLOR 075']='/includes/images/acabados-santos-monteiro/color/075.jpg';
$a_opciones['color']['COLOR 047']='/includes/images/acabados-santos-monteiro/color/047.jpg';
$a_opciones['color']['COLOR 016']='/includes/images/acabados-santos-monteiro/color/016.jpg';
$a_opciones['color']['COLOR 037']='/includes/images/acabados-santos-monteiro/color/037.jpg';
$a_opciones['color']['COLOR 231']='/includes/images/acabados-santos-monteiro/color/231.jpg';
$a_opciones['color']['COLOR 124']='/includes/images/acabados-santos-monteiro/color/124.jpg';
$a_opciones['color']['COLOR 115']='/includes/images/acabados-santos-monteiro/color/115.jpg';
$a_opciones['color']['COLOR 027']='/includes/images/acabados-santos-monteiro/color/027.jpg';
$a_opciones['color']['COLOR 025']='/includes/images/acabados-santos-monteiro/color/025.jpg';
$a_opciones['color']['COLOR 076']='/includes/images/acabados-santos-monteiro/color/076.jpg';
$a_opciones['color']['COLOR 030']='/includes/images/acabados-santos-monteiro/color/030.jpg';
$a_opciones['color']['COLOR 056']='/includes/images/acabados-santos-monteiro/color/056.jpg';

$a_opciones['dune']['DUNE 500']='/includes/images/acabados-santos-monteiro/dune/500.jpg';
$a_opciones['dune']['DUNE 150']='/includes/images/acabados-santos-monteiro/dune/150.jpg';
$a_opciones['dune']['DUNE 126']='/includes/images/acabados-santos-monteiro/dune/126.jpg';
$a_opciones['dune']['DUNE 125']='/includes/images/acabados-santos-monteiro/dune/125.jpg';
$a_opciones['dune']['DUNE 067']='/includes/images/acabados-santos-monteiro/dune/067.jpg';
$a_opciones['dune']['DUNE 051']='/includes/images/acabados-santos-monteiro/dune/051.jpg';
$a_opciones['dune']['DUNE 180']='/includes/images/acabados-santos-monteiro/dune/180.jpg';
$a_opciones['dune']['DUNE 84']='/includes/images/acabados-santos-monteiro/dune/84.jpg';
$a_opciones['dune']['DUNE 224']='/includes/images/acabados-santos-monteiro/dune/224.jpg';
$a_opciones['dune']['DUNE 201']='/includes/images/acabados-santos-monteiro/dune/201.jpg';
$a_opciones['dune']['DUNE 181']='/includes/images/acabados-santos-monteiro/dune/181.jpg';
$a_opciones['dune']['DUNE 821']='/includes/images/acabados-santos-monteiro/dune/821.jpg';
$a_opciones['dune']['DUNE 901']='/includes/images/acabados-santos-monteiro/dune/901.jpg';
$a_opciones['dune']['DUNE 812']='/includes/images/acabados-santos-monteiro/dune/812.jpg';
$a_opciones['dune']['DUNE 072']='/includes/images/acabados-santos-monteiro/dune/072.jpg';
$a_opciones['dune']['DUNE 071']='/includes/images/acabados-santos-monteiro/dune/071.jpg';
$a_opciones['dune']['DUNE 151']='/includes/images/acabados-santos-monteiro/dune/151.jpg';
$a_opciones['dune']['DUNE 078']='/includes/images/acabados-santos-monteiro/dune/078.jpg';
$a_opciones['dune']['DUNE 405']='/includes/images/acabados-santos-monteiro/dune/405.jpg';
$a_opciones['dune']['DUNE 700']='/includes/images/acabados-santos-monteiro/dune/700.jpg';
$a_opciones['dune']['DUNE 941']='/includes/images/acabados-santos-monteiro/dune/941.jpg';
$a_opciones['dune']['DUNE 475']='/includes/images/acabados-santos-monteiro/dune/475.jpg';
$a_opciones['dune']['DUNE 470']='/includes/images/acabados-santos-monteiro/dune/470.jpg';
$a_opciones['dune']['DUNE 421']='/includes/images/acabados-santos-monteiro/dune/421.jpg';

$a_opciones['easy']['EASY 361']='/includes/images/acabados-santos-monteiro/easy/361.jpg';
$a_opciones['easy']['EASY 369']='/includes/images/acabados-santos-monteiro/easy/369.jpg';
$a_opciones['easy']['EASY 327']='/includes/images/acabados-santos-monteiro/easy/327.jpg';
$a_opciones['easy']['EASY 300']='/includes/images/acabados-santos-monteiro/easy/300.jpg';
$a_opciones['easy']['EASY 304']='/includes/images/acabados-santos-monteiro/easy/304.jpg';
$a_opciones['easy']['EASY 305']='/includes/images/acabados-santos-monteiro/easy/305.jpg';
$a_opciones['easy']['EASY 315']='/includes/images/acabados-santos-monteiro/easy/315.jpg';
$a_opciones['easy']['EASY 323']='/includes/images/acabados-santos-monteiro/easy/323.jpg';
$a_opciones['easy']['EASY 341']='/includes/images/acabados-santos-monteiro/easy/341.jpg';
$a_opciones['easy']['EASY 387']='/includes/images/acabados-santos-monteiro/easy/387.jpg';
$a_opciones['easy']['EASY 306']='/includes/images/acabados-santos-monteiro/easy/306.jpg';
$a_opciones['easy']['EASY 385']='/includes/images/acabados-santos-monteiro/easy/385.jpg';
$a_opciones['easy']['EASY 390']='/includes/images/acabados-santos-monteiro/easy/390.jpg';



$a_opciones['veneza']['VENEZA 0645']='/includes/images/acabados-santos-monteiro/veneza/0645.jpg';
$a_opciones['veneza']['VENEZA 1019']='/includes/images/acabados-santos-monteiro/veneza/1019.jpg';
$a_opciones['veneza']['VENEZA 1091']='/includes/images/acabados-santos-monteiro/veneza/1091.jpg';
$a_opciones['veneza']['VENEZA 0835']='/includes/images/acabados-santos-monteiro/veneza/0835.jpg';
$a_opciones['veneza']['VENEZA 0635']='/includes/images/acabados-santos-monteiro/veneza/0635.jpg';
$a_opciones['veneza']['VENEZA 0647']='/includes/images/acabados-santos-monteiro/veneza/0647.jpg';
$a_opciones['veneza']['VENEZA 0636']='/includes/images/acabados-santos-monteiro/veneza/0636.jpg';
$a_opciones['veneza']['VENEZA 0644']='/includes/images/acabados-santos-monteiro/veneza/0644.jpg';
$a_opciones['veneza']['VENEZA 0638']='/includes/images/acabados-santos-monteiro/veneza/0638.jpg';
$a_opciones['veneza']['VENEZA 0641']='/includes/images/acabados-santos-monteiro/veneza/0641.jpg';
$a_opciones['veneza']['VENEZA 0679']='/includes/images/acabados-santos-monteiro/veneza/0679.jpg';
$a_opciones['veneza']['VENEZA 0642']='/includes/images/acabados-santos-monteiro/veneza/0642.jpg';
$a_opciones['veneza']['VENEZA 0676']='/includes/images/acabados-santos-monteiro/veneza/0676.jpg';
$a_opciones['veneza']['VENEZA 0643']='/includes/images/acabados-santos-monteiro/veneza/0643.jpg';


$a_opciones['franja']['FRANJA 01']='/includes/images/acabados-santos-monteiro/franja/01.jpg';
$a_opciones['franja']['FRANJA 02']='/includes/images/acabados-santos-monteiro/franja/02.jpg';
$a_opciones['franja']['FRANJA 03']='/includes/images/acabados-santos-monteiro/franja/03.jpg';
$a_opciones['franja']['FRANJA 04']='/includes/images/acabados-santos-monteiro/franja/04.jpg';
$a_opciones['franja']['FRANJA 05']='/includes/images/acabados-santos-monteiro/franja/05.jpg';
$a_opciones['franja']['FRANJA 06']='/includes/images/acabados-santos-monteiro/franja/06.jpg';
$a_opciones['franja']['FRANJA 07']='/includes/images/acabados-santos-monteiro/franja/07.jpg';
$a_opciones['franja']['FRANJA 08']='/includes/images/acabados-santos-monteiro/franja/08.jpg';
$a_opciones['franja']['FRANJA 09']='/includes/images/acabados-santos-monteiro/franja/09.jpg';
$a_opciones['franja']['FRANJA 10']='/includes/images/acabados-santos-monteiro/franja/10.jpg';
$a_opciones['franja']['FRANJA 11']='/includes/images/acabados-santos-monteiro/franja/11.jpg';
$a_opciones['franja']['FRANJA 12']='/includes/images/acabados-santos-monteiro/franja/12.jpg';
$a_opciones['franja']['FRANJA 13']='/includes/images/acabados-santos-monteiro/franja/13.jpg';
$a_opciones['franja']['FRANJA 14']='/includes/images/acabados-santos-monteiro/franja/14.jpg';
$a_opciones['franja']['FRANJA 15']='/includes/images/acabados-santos-monteiro/franja/15.jpg';


$a_opciones['fresh']['FRESH 157']='/includes/images/acabados-santos-monteiro/fresh/157.jpg';
$a_opciones['fresh']['FRESH 489']='/includes/images/acabados-santos-monteiro/fresh/489.jpg';
$a_opciones['fresh']['FRESH 326']='/includes/images/acabados-santos-monteiro/fresh/326.jpg';
$a_opciones['fresh']['FRESH 437']='/includes/images/acabados-santos-monteiro/fresh/437.jpg';
$a_opciones['fresh']['FRESH 438']='/includes/images/acabados-santos-monteiro/fresh/438.jpg';
$a_opciones['fresh']['FRESH 260']='/includes/images/acabados-santos-monteiro/fresh/260.jpg';
$a_opciones['fresh']['FRESH 378']='/includes/images/acabados-santos-monteiro/fresh/378.jpg';
$a_opciones['fresh']['FRESH 323']='/includes/images/acabados-santos-monteiro/fresh/323.jpg';
$a_opciones['fresh']['FRESH 003']='/includes/images/acabados-santos-monteiro/fresh/003.jpg';
$a_opciones['fresh']['FRESH 504']='/includes/images/acabados-santos-monteiro/fresh/504.jpg';
$a_opciones['fresh']['FRESH 537']='/includes/images/acabados-santos-monteiro/fresh/537.jpg';
$a_opciones['fresh']['FRESH 538']='/includes/images/acabados-santos-monteiro/fresh/538.jpg';
$a_opciones['fresh']['FRESH 539']='/includes/images/acabados-santos-monteiro/fresh/539.jpg';
$a_opciones['fresh']['FRESH 261']='/includes/images/acabados-santos-monteiro/fresh/261.jpg';
$a_opciones['fresh']['FRESH 217']='/includes/images/acabados-santos-monteiro/fresh/217.jpg';
$a_opciones['fresh']['FRESH 700']='/includes/images/acabados-santos-monteiro/fresh/700.jpg';

//$a_opciones['just']['COLOR XXX']='/includes/images/acabados-santos-monteiro/just/XXX.jpg';
/*
$a_acabados[4][268]['FRANJA']['tipo_txt']='TIPO DE FLECO';
$a_acabados[4][268]['FRANJA']['tipo']['EN TODO EL PERIMETRO']='/includes/images/acabados/flecos-perimetro.jpg';
$a_acabados[4][268]['FRANJA']['tipo']['EN EL ANCHO']='/includes/images/acabados/flecos-ancho.jpg';
*/
$a_rollos[4][268][2]='ANCHO DE 2 METROS';
$a_rollos[4][268][4]='ANCHO DE 4 METROS';

$ocultar_acabado['BAY'][]=1803;// CHENILLE
$ocultar_acabado['COLOR'][]=1803;// CHENILLE
$ocultar_acabado['EASY'][]=1803;// CHENILLE
$ocultar_acabado['DUNE'][]=1803;// CHENILLE
$ocultar_acabado['VENEZA'][]=1803;// CHENILLE
$ocultar_acabado['FRESH'][]=1803;// CHENILLE
$ocultar_acabado['TWILL'][]=1803;// CHENILLE

$ocultar_acabado['FRANJA'][]=1938;// CREEK
$ocultar_acabado['FRANJA'][]=1833;// WOOLLY II

$ocultar_acabado['DOBRA'][]=1802;// CLASSIC
$ocultar_acabado['DOBRA'][]=1793;// GLAMOUR
$ocultar_acabado['DOBRA'][]=1810;// KILT
$ocultar_acabado['DOBRA'][]=1822;// SISAL BALL
$ocultar_acabado['DOBRA'][]=1821;// SISAL MAYA
$ocultar_acabado['DOBRA'][]=1823;// SISAL TERRACOTE
$ocultar_acabado['DOBRA'][]=1833;// WOOLLY II

$ocultar_acabado['JUST'][]=1803;// CHENILLE
$ocultar_acabado['JUST'][]=1938;// CREEK
$ocultar_acabado['JUST'][]=1939;// FOGGY
$ocultar_acabado['JUST'][]=1795;// KASA
$ocultar_acabado['JUST'][]=1810;// KILT
$ocultar_acabado['JUST'][]=1812;// PALMA
$ocultar_acabado['JUST'][]=1822;// SISAL BALL
$ocultar_acabado['JUST'][]=1821;// SISAL MAYA
$ocultar_acabado['JUST'][]=1823;// SISAL TERRACOTE
$ocultar_acabado['JUST'][]=1947;// SISAL FLOW
$ocultar_acabado['JUST'][]=1948;// SISAL NATURA
$ocultar_acabado['JUST'][]=1817;// STONE
$ocultar_acabado['JUST'][]=1819;// STONE COLORS
$ocultar_acabado['JUST'][]=1816;// STONE CONTRACT
$ocultar_acabado['JUST'][]=1818;// STONE RUSTIQUE
$ocultar_acabado['JUST'][]=1833;// WOOLLY II

$ocultar_acabado['LINE'][]=1802;// CLASSIC
$ocultar_acabado['LINE'][]=1938;// CREEK
$ocultar_acabado['LINE'][]=1793;// GLAMOUR
$ocultar_acabado['LINE'][]=1810;// KILT
$ocultar_acabado['LINE'][]=1822;// SISAL BALL
$ocultar_acabado['LINE'][]=1821;// SISAL MAYA
$ocultar_acabado['LINE'][]=1823;// SISAL TERRACOTE
$ocultar_acabado['LINE'][]=1833;// WOOLLY II

$ocultar_acabado['LUX'][]=1796;// ARISTOCRAT
$ocultar_acabado['LUX'][]=1788;// ARTISAN
$ocultar_acabado['LUX'][]=1799;// BLISS
$ocultar_acabado['LUX'][]=1800;// BOND
$ocultar_acabado['LUX'][]=1801;// BUGATTI
$ocultar_acabado['LUX'][]=1803;// CHENILLE
$ocultar_acabado['LUX'][]=1804;// DELICATE
$ocultar_acabado['LUX'][]=1805;// DIVINE
$ocultar_acabado['LUX'][]=1807;// IMPRESSION
$ocultar_acabado['LUX'][]=1808;// INSPIRATION
$ocultar_acabado['LUX'][]=1809;// JOY
$ocultar_acabado['LUX'][]=1795;// KASA
$ocultar_acabado['LUX'][]=1940;// MATTE
$ocultar_acabado['LUX'][]=1811;// OPULENT
$ocultar_acabado['LUX'][]=1812;// PALMA
$ocultar_acabado['LUX'][]=1791;// REFLEX
$ocultar_acabado['LUX'][]=1790;// SEDUCTION
$ocultar_acabado['LUX'][]=1831;// SLEEK
$ocultar_acabado['LUX'][]=1813;// SUBLIME

$ocultar_acabado['LINE COLORS'][]=1796;// ARISTOCRAT
$ocultar_acabado['LINE COLORS'][]=1788;// ARTISAN
$ocultar_acabado['LINE COLORS'][]=1799;// BLISS
$ocultar_acabado['LINE COLORS'][]=1800;// BOND
$ocultar_acabado['LINE COLORS'][]=1801;// BUGATTI
$ocultar_acabado['LINE COLORS'][]=1803;// CHENILLE
$ocultar_acabado['LINE COLORS'][]=1802;// CLASSIC
$ocultar_acabado['LINE COLORS'][]=1938;// CREEK
$ocultar_acabado['LINE COLORS'][]=1804;// DELICATE
$ocultar_acabado['LINE COLORS'][]=1805;// DIVINE
$ocultar_acabado['LINE COLORS'][]=1806;// FINE
$ocultar_acabado['LINE COLORS'][]=1939;// FOGGY
$ocultar_acabado['LINE COLORS'][]=1793;// GLAMOUR
$ocultar_acabado['LINE COLORS'][]=1807;// IMPRESSION
$ocultar_acabado['LINE COLORS'][]=1808;// INSPIRATION
$ocultar_acabado['LINE COLORS'][]=1809;// JOY
$ocultar_acabado['LINE COLORS'][]=1795;// KASA
$ocultar_acabado['LINE COLORS'][]=1810;// KILT
$ocultar_acabado['LINE COLORS'][]=1940;// MATTE
$ocultar_acabado['LINE COLORS'][]=1811;// OPULENT
$ocultar_acabado['LINE COLORS'][]=1812;// PALMA
$ocultar_acabado['LINE COLORS'][]=1791;// REFLEX
$ocultar_acabado['LINE COLORS'][]=1790;// SEDUCTION
$ocultar_acabado['LINE COLORS'][]=1822;// SISAL BALL
$ocultar_acabado['LINE COLORS'][]=1821;// SISAL MAYA
$ocultar_acabado['LINE COLORS'][]=1823;// SISAL TERRACOTE
$ocultar_acabado['LINE COLORS'][]=1947;// SISAL FLOW
$ocultar_acabado['LINE COLORS'][]=1948;// SISAL NATURA
$ocultar_acabado['LINE COLORS'][]=1831;// SLEEK
$ocultar_acabado['LINE COLORS'][]=1817;// STONE
$ocultar_acabado['LINE COLORS'][]=1816;// STONE CONTRACT
$ocultar_acabado['LINE COLORS'][]=1818;// STONE RUSTIQUE
$ocultar_acabado['LINE COLORS'][]=1813;// SUBLIME
$ocultar_acabado['LINE COLORS'][]=1833;// WOOLLY II

$rollo_diferenciado[1799]['ancho_1']=2.5;	// BLISS
$rollo_diferenciado[1799]['ancho_2']=5;		// BLISS
/*
print '<pre><xmp>';
print_r($key);
print '</xmp></pre>';

$extra_coleccion[4][268][1938]['extra_precio_m2_medida']=12.12; // La coleccion Creek (id 1938) sale 12.12 más cara el metro cuadrado a medida

$extra_acabado[4][268]['LINE'][1948]=8.52; // La Sisal Natura (id 1948) sale 8.52 más cara el metro cuadrado a medida en el acabado LINE
$extra_acabado[4][268]['LINE'][1816]=8.52; // La Stone contract (id 1816) sale 8.52 más cara el metro cuadrado a medida en el acabado LINE
$extra_acabado[4][268]['LINE'][1817]=8.52; // La Stone  (id 1817) sale 8.52 más cara el metro cuadrado a medida en el acabado LINE
$extra_acabado[4][268]['LINE'][1818]=8.52; // La Stone rustique (id 1818) sale 8.52 más cara el metro cuadrado a medida en el acabado LINE
$extra_acabado[4][268]['LINE'][1819]=8.52; // La Stone colors (id 1819) sale 8.52 más cara el metro cuadrado a medida en el acabado LINE

$extra_acabado[4][268]['LUX'][1948]=8.52; // La Sisal Natura (id 1948) sale 8.52 más cara el metro cuadrado a medida en el acabado LUX

$precio_promo[4][268]['DOBRA'][1803]=15.78; // La colceccion chenille (id 1803) está mucho más barata que el precio general DOBRA
*/

echo '<div class="row">';
echo '  <div class="h6 destacado mt-3 mb-3 col-11">SELECCIONE LA FORMA: <span id="forma_seleccionada"></span></div>';
echo '</div>';

echo '<div class="" id="lista-opciones-formas">';
echo '<ul class="opciones-grecas row p-0">';
foreach ($a_forma_alfombra[4][268] as $txt_forma=>$datos_forma){
	$nombre=$txt_forma;
	$src=$datos_forma['img'];
	echo '<li class="item-opcion-greca col-3 col-lg-2">';
	echo '  <div class="img-opcion-greca">';
	echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-forma-santos-monteiro" data-name-forma="'.$nombre.'" src="'.$src.'"/>';
	//echo '    <p class="name-opcion-greca text-center">'.$nombre.'</p>';
	echo '  </div>';
	echo '</li>';
}
echo '</ul>';
echo '</div>';

echo '<div id="div-acabados-santos-monteiro">';
echo '<div class="row">';
echo '  <div class="h6 destacado mt-3 mb-3 col-11">SELECCIONE EL ACABADO: <span id="acabado_seleccionado"></span></div>';
echo '</div>';

echo '<div class="" id="lista-opciones-grecas">';
echo '<ul class="opciones-grecas row p-0">';
foreach ($a_acabados[4][268] as $txt_acabado=>$datos_acabado){
	if (!isset($ocultar_acabado[$txt_acabado]) || !in_array($key['item_coleccion_id'], $ocultar_acabado[$txt_acabado])){
		$nombre=$txt_acabado;
		$nombre_aux='ID_'.str_replace(' ', '_', $nombre);
		$precio_m_lineal=0;
		if (isset($datos_acabado['precio_m_lineal']))
			$precio_m_lineal=$datos_acabado['precio_m_lineal'];
		
		if (isset($extra_acabado_lineal[4][268][$txt_acabado][$key['item_coleccion_id']]))
			$precio_m_lineal+=$extra_acabado_lineal[4][268][$txt_acabado][$key['item_coleccion_id']];
		
		$precio_m_lineal_largo=0;
		if ($txt_acabado=='FRANJA')
			$precio_m_lineal_largo=$a_acabados[4][268]['LINE']['precio_m_lineal']; // El acabado franja va en el lado corto, lado largo LINE
		
		$precio_m2_fieltro=0;
		if (isset($datos_acabado['precio_m2_fieltro']))
			$precio_m2_fieltro=$datos_acabado['precio_m2_fieltro'];

		$precio_m2_medida=0;
		if (isset($datos_acabado['precio_m2_medida']))
			$precio_m2_medida=$datos_acabado['precio_m2_medida'];
		
		$precio_extra=0;
		if (isset($extra_coleccion[4][268][$key['item_coleccion_id']]['extra_precio_m2_medida']))
			$precio_extra=$extra_coleccion[4][268][$key['item_coleccion_id']]['extra_precio_m2_medida'];
		elseif (isset($extra_acabado[4][268][$txt_acabado][$key['item_coleccion_id']]))
			$precio_extra=$extra_acabado[4][268][$txt_acabado][$key['item_coleccion_id']];


		$precio_promocion=0;
		if (isset($precio_promo[4][268][$txt_acabado][$key['item_coleccion_id']]))
			$precio_promocion=$precio_promo[4][268][$txt_acabado][$key['item_coleccion_id']];
		
		$txt_tit_opcion='';
		if (isset($datos_acabado['txt_opciones']))
			$txt_tit_opcion=$datos_acabado['txt_opciones'];
		
		$div_opciones='';
		if (isset($datos_acabado['opciones']))
			$div_opciones=$datos_acabado['opciones'];

		$src=$datos_acabado['img'];
		echo '<li class="item-opcion-greca col-3 col-lg-2">';
		echo '  <div class="img-opcion-greca">';
		echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-acabado-santos-monteiro" id="'.$nombre_aux.'" data-name-acabado="'.$nombre.'" data-div-opciones="'.$div_opciones.'" data-txt-opciones="'.$txt_tit_opcion.'" data-precio-ml="'.$precio_m_lineal.'" data-precio-ml_largo="'.$precio_m_lineal_largo.'" data-precio-m2="'.$precio_m2_medida.'" data-precio_m2_fieltro="'.$precio_m2_fieltro.'" data-precio_extra="'.$precio_extra.'" data-precio_promo="'.$precio_promocion.'" src="'.$src.'"/>';
		echo '    <p class="name-opcion-greca text-center">'.$nombre.'</p>';
		echo '  </div>';
		echo '</li>';
	}
}
echo '</ul>';
echo '</div>';
echo '</div>';

$a_generados=array();
foreach ($a_acabados[4][268] as $txt_acabado=>$datos_acabado){
	/*
	print '<pre><xmp>';
	print_r($datos_acabado);
	print '</xmp></pre>';
	*/
	if (isset($datos_acabado['opciones'])){
		$txt_opcion=$datos_acabado['opciones'];
		$txt_tit_opcion=$datos_acabado['txt_opciones'];
		if (isset($a_opciones[$txt_opcion]) && !isset($a_generados[$txt_opcion])){
			//echo '<div class="" id="'.$txt_opcion.'">';
			echo '<div class="opciones-santos-monteiro d-none" id="opciones-'.$txt_opcion.'">';
			if (isset($datos_acabado['tipo_txt'])){
				echo '<div class="row">';
				echo '  <div class="h6 destacado mt-3 m3-2 col-11"><span class="txt_opcion_tipo">'.$datos_acabado['tipo_txt'].':</span> <span id="tipo-'.$txt_opcion.'" class="txt-tipo-seleccionado"></span></div>';
				//echo '  <button class="calc_collapsible col-1 py-0" data-toggle="collapse" data-target="#lista-colores-grecas" aria-expanded="false" aria-controls="calc-colapsable" aria-label="Ver opciones colores"></button>';
				echo '</div>';
				echo '<ul class="opciones-grecas row p-0">';
				foreach ($datos_acabado['tipo'] as $txt_tipo=>$img_tipo){
					$nombre=$txt_tipo;
					$src=$img_tipo;
					
					echo '<li class="item-opcion-greca col-3 col-lg-2">';
					echo '  <div class="img-opcion-greca">';
					echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-opcion-tipo-santos-monteiro" data-name-tipo="'.$nombre.'" data-txt-opcion="'.$txt_opcion.'" src="'.$src.'"/>';
					echo '    <p class="name-color-greca text-center">'.$nombre.'</p>';
					echo '  </div>';
					echo '</li>';
				}
				echo '</ul>';
			}



			echo '<div class="row">';
			echo '  <div class="h6 destacado mt-3 mb-3 col-11"><span id="txt-acabado-'.$txt_opcion.'" class="txt_opcion_acabado">'.$txt_tit_opcion.'</span>: <span id="seleccion-'.$txt_opcion.'" class="txt-opcion-seleccionada"></span></div>';
			//echo '  <button class="calc_collapsible col-1 py-0" data-toggle="collapse" data-target="#lista-colores-grecas" aria-expanded="false" aria-controls="calc-colapsable" aria-label="Ver opciones colores"></button>';
			echo '</div>';
			echo '<ul class="opciones-grecas row p-0">';
			foreach ($a_opciones[$txt_opcion] as $txt_remate=>$img_remate){
				$nombre=$txt_remate;
				$src=$img_remate;
				echo '<li class="item-opcion-greca col-3 col-lg-2">';
				echo '  <div class="img-opcion-greca">';
				echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-opcion-santos-monteiro" data-name-opcion="'.$nombre.'" data-txt-opcion="'.$txt_opcion.'" src="'.$src.'"/>';
				echo '    <p class="name-color-greca text-center">'.$nombre.'</p>';
				echo '  </div>';
				echo '</li>';
			}
			echo '</ul>';
			echo '</div>';
			$a_generados[$txt_opcion]=$txt_opcion;
		}
	}
}

$txt_caja='Introduce las medidas de tu alfombra:';
$txt_p_ancho='Ancho (max. 4m)';
$txt_p_alto='Largo (max. 25m)';

$ancho_1=2;
$ancho_2=4;
if (isset($rollo_diferenciado[$key['item_coleccion_id']])){
	$ancho_1=$rollo_diferenciado[$key['item_coleccion_id']]['ancho_1'];
	$ancho_2=$rollo_diferenciado[$key['item_coleccion_id']]['ancho_2'];

	$txt_p_ancho='Ancho (max. '.$ancho_2.'m)';
}
?>
<div class="product-detail-calculadora-rollo">
	<div class="product-title row">
	  <span class="title col-12"><?php echo $txt_caja; ?></span>
	</div>

	<div id='hr_calculadora_alfombra' class="row hr_calculadora">
	  <hr class="col-12 p-0 mt-2 mb-4" style='border-top: 1px solid #212529;'/>
	</div>

	<div class="form-group">
		<input type="hidden" id='calc_precio_m_lineal' name='precio_m_lineal' value='0' />	
		<input type="hidden" id='calc_precio_m_lineal_largo' name='calc_precio_m_lineal_largo' value='0' />	
		<input type="hidden" id='calc_precio_m_2' name='precio_m_2' value='0' />	
		<input type="hidden" id='calc_precio_m2_fieltro' name='precio_m_2_fieltro' value='0' />	
		<input type="hidden" id='calc_precio_extra' name='precio_m_2_extra' value='0' />	
		<input type="hidden" id='calc_precio_promo' name='precio_m_2_promo' value='0' />	
		<div id='dimensiones_cuadrada' class="row" >
			<p class="col-12">Introduce las dimensiones necesarias en metros, ej: 3.8 x 2.5</p>
			<div class="col-6">
				<div class="pr-15">
				  <label for="p_alto"><?php echo $txt_p_ancho; ?></label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_ancho" name="p_ancho" class="w-75 metrs calcuinput" oninput="calcularSantosMonteiro();" /> m
				    </div>
				  </div>
				</div>
			</div>
			<div class="col-6">
				<div class="">
				  <label for="p_alto"><?php echo $txt_p_alto; ?></label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_alto" name="p_alto" class="w-75" oninput="calcularSantosMonteiro();" /> m
				    </div>
				  </div>
				</div>
			</div>
		</div>
		<div id='dimensiones_redonda' class="row d-none" >
			<p class="col-12">Introduce el diámetro de la alfombra, ej: 1.8</p>
			<div class="col-6">
				<div class="pr-15">
				  <label for="p_diametro">Diámetro en metros (max. <?php echo str_replace('.', ',', $ancho_2); ?>m)</label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_diametro" name="p_diametro" class="w-75 metrs calcuinput" oninput="calcularSantosMonteiro();" /> m
				    </div>
				  </div>
				</div>
			</div>
		</div>
		<div id='dimensiones_rollo' class="row d-none" >
			<p class="col-12">Introduce el ancho del rollo y la longitud</p>
			<div class="col-6">
				<div class="pr-15">
				  <label for="ancho_rollo">Ancho rollo</label>
				  <div class="">
				    <div class="mt-2">
						<input type="radio" id="val_2" name="ancho_rollo" value="<?php echo $ancho_1; ?>" onclick="calcularSantosMonteiro();" />
						<label for="val_2" class="mr-4"><?php echo str_replace('.', ',', $ancho_1); ?> metros</label>
						<input type="radio" id="val_4" name="ancho_rollo" value="<?php echo $ancho_2; ?>" onclick="calcularSantosMonteiro();" />
						<label for="val_4"><?php echo str_replace('.', ',', $ancho_2); ?> metros</label>
						<?php
						/*
						<input type="number" min="0" step="0.1" id="ancho_rollo" name="ancho_rollo" class="w-75 metrs calcuinput" oninput="calcularSantosMonteiro();" /> m
						*/
						?>
				    </div>
				  </div>
				</div>
			</div>
			<div class="col-6">
				<div class="">
				  <label for="alto_rollo">Largo rollo</label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="alto_rollo" name="alto_rollo" class="w-75" oninput="calcularSantosMonteiro();" /> m
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
	<div id='nota_dimensiones_cuadrada' class="mt-4">
		<small><strong>Se confeccionan a partir de rollos de <?php echo str_replace('.', ',', $ancho_1); ?> ó <?php echo str_replace('.', ',', $ancho_2); ?> metros de ancho en función de la medida final solicitada considerando siempre el mínimo desperdicio de material posible sin tener en cuenta el sentido de tramas o dibujos.</strong></small>
	</div>
    <?php 
    $this->load->view('frontend/info_opc_seleccionadas'); 
    ?>

</div>

<script>
<!--
function calcularSantosMonteiro(){
	// Vamos a calcular el precio de la alfombra de dos maneras: 
	// 	1.- a partir del rollo + los precios de los metros lineales
	// 	2.- a partir de los precios de los metros cuadrados con ela cabado incluido
	forma_seleccionada=$("#informacion_extra_forma").val();

	faltan_datos=true;
    if (forma_seleccionada=='Redonda'){
	    if(isNumeric($("#p_diametro").val()) && isNumeric($("#unidades").val())){
	    	// Para el cálculo de metros tomamos el cuadrado de la pieza que forma el círculo, por lo que alto=ancho=diametro
		    p_ancho= $("#p_diametro").val().replace(",",".");
		    p_alto= $("#p_diametro").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

			perimetro=p_ancho*3.1416; // 2 PI r, el ancho es igual al diametro= 2*r
		    perimetro=Math.ceil(perimetro*10)/10;
			lado_largo=0;
			lado_corto=0;

	        console.log("Redonda");
	        console.log("Diámetro: "+p_ancho+" - Perimetro: "+perimetro);
			
			faltan_datos=false;
		}
	}
    if (forma_seleccionada=='Rollo'){
        ancho_rollo_seleccionado=$('input[name="ancho_rollo"]:checked').val();
        
	    if(isNumeric(ancho_rollo_seleccionado) && isNumeric($("#alto_rollo").val()) && isNumeric($("#unidades").val())){
	    	// Para el cálculo de metros tomamos el cuadrado de la pieza que forma el círculo, por lo que alto=ancho=diametro
		    p_ancho= ancho_rollo_seleccionado.replace(",",".");
		    p_alto= $("#alto_rollo").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

			perimetro=0; // Es rollo, no va a tener acabado en el perímetro
			lado_largo=0;
			lado_corto=0;
	        console.log("Rollo");
	        console.log("Ancho: "+p_ancho+" - Largo: "+p_alto);
			faltan_datos=false;
		}
	}
    if (forma_seleccionada=='Rectangular-cuadrada'){
	    if(isNumeric($("#p_ancho").val()) && isNumeric($("#p_alto").val()) && isNumeric($("#unidades").val())){
		    p_ancho= $("#p_ancho").val().replace(",",".");
		    p_alto= $("#p_alto").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

			lado_largo=p_alto;
			lado_corto=p_ancho;
			if (p_ancho>p_alto){
				lado_largo=p_ancho;
				lado_corto=p_alto;
			}

			perimetro=p_ancho*2 + p_alto*2;

	        console.log("Cuadrada");
	        console.log("Ancho: "+p_ancho+" - Largo: "+p_alto);
			faltan_datos=false;
		}
	}
	if (faltan_datos){
		return;
	}
	else{
		// Precios de la base para el metro cuadrado a medida
		preciobase= parseFloat($("#preciobase").val()); // precio original`
		preciounitario= parseFloat($("#preciounitario").val()); // con descuento

		// Precios de la base para el cálculo a partir del rollo
		preciobase_aux= parseFloat($("#preciobase_aux").val()); // precio original`
		preciounitario_aux= parseFloat($("#preciounitario_aux").val()); // con descuento

	    precio_m_2= $("#calc_precio_m_2").val()*1;
	    precio_m_2_extra= $("#calc_precio_extra").val()*1;
	    precio_m_2_promo= $("#calc_precio_promo").val()*1;
	    precio_m_lineal= $("#calc_precio_m_lineal").val()*1;
	    precio_m_lineal_largo= $("#calc_precio_m_lineal_largo").val()*1;
	    precio_m_2_fieltro= $("#calc_precio_m2_fieltro").val()*1;

	    if (precio_m_2!=0)
	        console.log("m2 acabado: "+precio_m_2);
	    if (precio_m_2_extra!=0)
	        console.log("extra m2 acabado: "+precio_m_2_extra);
	    if (precio_m_2_promo!=0)
	        console.log("promo m2 acabado: "+precio_m_2_promo);
	    if (precio_m_2_fieltro!=0)
	        console.log("fieltro m2: "+precio_m_2_fieltro);
	    if (precio_m_lineal!=0)
	        console.log("precio m lineal: "+precio_m_lineal);
	    if (precio_m_lineal_largo!=0)
	        console.log("precio m lineal largo: "+precio_m_lineal_largo);

	    unidades= $("#unidades").val()*1;

		//Si hay descuentos, tenemos que aplicarlos también a los acabados
	    metodo_descuento= $("#metodo_descuento").val();
	    valor_descuento= $("#valor_descuento").val();
		
		// Inicio precios a medida
		metros_pieza_exactos=p_alto*p_ancho;

		precio_acabado_a_medida=precio_m_2+precio_m_2_extra;
		if(precio_m_2_promo!=0)
			precio_acabado_a_medida=precio_m_2_promo;
	    
	    precio_alfombra_original_a_medida=metros_pieza_exactos*preciobase + metros_pieza_exactos*precio_acabado_a_medida;		
	    precio_alfombra_final_a_medida=metros_pieza_exactos*preciounitario + metros_pieza_exactos*precio_acabado_a_medida;		
		if (metodo_descuento==1){
            precio_alfombra_final_a_medida=precio_alfombra_original_a_medida*(100 - valor_descuento)/100;
		}

        console.log("metros_pieza_exactos: "+metros_pieza_exactos);
        console.log("precio m2 sin acabado: "+preciobase +' --> '+preciounitario);
	    //if (precio_acabado_a_medida!=0)
	    //    console.log("precio m2 acabado: "+precio_acabado_a_medida);
        console.log("precio alfombra a medida: "+precio_alfombra_original_a_medida.toFixed(2) +' --> '+precio_alfombra_final_a_medida.toFixed(2));
		// Fin precios a medida

        console.log("lado corto: "+lado_corto);
        console.log("lado largo: "+lado_largo);

		// Inicio precios desde rollos
		metros_pieza=0;
		precio_alfombra_original_rollo=0;
		precio_alfombra_final_rollo=0;

		ancho_referencia_1=<?php echo $ancho_1; ?>;// 2 por defecto
		ancho_referencia_2=<?php echo $ancho_2; ?>;// 4 por defecto

        console.log("opciones rollos: "+ancho_referencia_1+" y "+ancho_referencia_2);
        console.log("precio m2 desde rollo: "+preciobase_aux+' --> '+preciounitario_aux);
				
		//if(p_ancho<=4){
		if(p_ancho<=ancho_referencia_2){
			//if (p_ancho>2)
			if (p_ancho>ancho_referencia_1){
				metros_pieza=p_alto*ancho_referencia_2;
				//metros_pieza=p_alto*4;
			}
			else{
				metros_pieza=p_alto*ancho_referencia_1;
				//metros_pieza=p_alto*2;
			}
	        console.log("metros cálculo 1: "+metros_pieza);
		    
		    if ($("#acabado_seleccionado").text()=='FRANJA' && lado_corto>0){
		    	// Si acabado es franja, no se aplica a ttodo el perímetro, solo al lado corto. Lado largo, LINE
			    precio_alfombra_original_rollo=metros_pieza*preciobase_aux + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;		
			    precio_alfombra_final_rollo=metros_pieza*preciounitario_aux + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;	
		        console.log("precio_alfombra_original: "+ (metros_pieza*preciobase_aux));
		        console.log("lado corto: "+ (lado_corto*2*precio_m_lineal));
		        console.log("lado largo: "+ (lado_largo*2*precio_m_lineal_largo));
		        console.log("precio final original: "+ precio_alfombra_original_rollo);
		    }
		    else{
			    precio_alfombra_original_rollo=metros_pieza*preciobase_aux + perimetro*precio_m_lineal + metros_pieza*precio_m_2_fieltro;		
			    precio_alfombra_final_rollo=metros_pieza*preciounitario_aux + perimetro*precio_m_lineal + metros_pieza*precio_m_2_fieltro;
			}
			if (metodo_descuento==1){
	            precio_alfombra_final_rollo=precio_alfombra_original_rollo*(100 - valor_descuento)/100;
		        //console.log("valor_descuento: "+ valor_descuento);
		        //console.log("precio final descuento: "+ precio_alfombra_final_rollo);
			}
		
	        //console.log("precio alfombra rollo cálculo 1: "+precio_alfombra_original_rollo +' --> '+precio_alfombra_final_rollo);

		}

		metros_pieza_2=0;
		precio_alfombra_original_rollo_2=0;
		precio_alfombra_final_rollo_2=0;
		//if(p_alto<=4){
		if(p_alto<=ancho_referencia_2){
			//if (p_alto>2)
			if (p_alto>ancho_referencia_1){
				metros_pieza_2=p_ancho*ancho_referencia_2;
			}
			else{
				metros_pieza_2=p_ancho*ancho_referencia_1;
			}
	        console.log("metros cálculo 2: "+metros_pieza_2);

		    if ($("#acabado_seleccionado").text()=='FRANJA' && lado_corto>0){
		    	// Si acabado es franja, no se aplica a ttodo el perímetro, solo al lado corto. Lado largo, LINE
			    precio_alfombra_original_rollo_2=metros_pieza_2*preciobase_aux + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;		
			    precio_alfombra_final_rollo_2=metros_pieza_2*preciounitario_aux + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;	
		        console.log("precio_alfombra_original 2: "+ (metros_pieza_2*preciobase_aux));
		        console.log("lado corto: "+ (lado_corto*2*precio_m_lineal));
		        console.log("lado largo: "+ (lado_largo*2*precio_m_lineal_largo));
		        console.log("precio final original 2: "+ precio_alfombra_original_rollo_2);
		    }
		    else{
			    precio_alfombra_original_rollo_2=metros_pieza_2*preciobase_aux + perimetro*precio_m_lineal + metros_pieza_2*precio_m_2_fieltro;		
			    precio_alfombra_final_rollo_2=metros_pieza_2*preciounitario_aux + perimetro*precio_m_lineal + metros_pieza_2*precio_m_2_fieltro;		
			}
			if (metodo_descuento==1){
	            precio_alfombra_final_rollo_2=precio_alfombra_original_rollo_2*(100 - valor_descuento)/100;
		        //console.log("valor_descuento: "+ valor_descuento);
		        //console.log("precio final descuento 2: "+ precio_alfombra_final_rollo_2);
			}
	        //console.log("precio alfombra rollo cálculo 1: "+precio_alfombra_original_rollo_2 +' --> '+precio_alfombra_final_rollo_2);
		}
		// Fin precios desde rollos

		// Inicio seleccion precio más barato, marcaremos;
		// 	SD si es a medida (Sin Desperdicio)
		// 	CD si es desde rollo (Con Desperdicio)
    	precio_alfombra_original=precio_alfombra_original_a_medida;
	    if(precio_alfombra_original_rollo < precio_alfombra_original && precio_alfombra_original_rollo!=0){
		    precio_alfombra_original=precio_alfombra_original_rollo;
	    }
	    if(precio_alfombra_original_rollo_2 < precio_alfombra_original && precio_alfombra_original_rollo_2!=0){
		    precio_alfombra_original=precio_alfombra_original_rollo_2;
	    }
		
	    informacion_extra_desperdicio='SD'; // Sin desperdicio, corte a medida
	    precio_alfombra_final=precio_alfombra_final_a_medida;
	    if(precio_alfombra_final_rollo < precio_alfombra_final && precio_alfombra_final_rollo!=0){
		    precio_alfombra_final=precio_alfombra_final_rollo;
		    informacion_extra_desperdicio='CD'; // Con desperdicio, corte a partir de rollos
	    }
	    if(precio_alfombra_final_rollo_2 < precio_alfombra_final && precio_alfombra_final_rollo_2!=0){
		    precio_alfombra_final=precio_alfombra_final_rollo_2;
		    informacion_extra_desperdicio='CD'; // Con desperdicio, corte a partir de rollos
	    }
		// Fin seleccion precio más barato, marcaremos;

	    //alert('ancho: '+p_ancho+' alto: '+p_alto+' unidades: '+unidades+'\n'+'metros_pieza: '+metros_pieza+' perimetro: '+perimetro+'\n'+'precio ml: '+precio_m_lineal+' precio_m_2: '+precio_m_2);
	    /*
        console.log("precio_acabado_a_medida: "+precio_acabado_a_medida);
        console.log("precio original a medida: "+precio_alfombra_original_a_medida.toFixed(2));
        console.log("precio_m_lineal: "+precio_m_lineal);
        console.log("precio_m_2_fieltro: "+precio_m_2_fieltro);
        console.log("precio original rollo: "+precio_alfombra_original_rollo.toFixed(2));
		*/
        //console.log("metros_pieza_exactos: "+metros_pieza_exactos);
        //console.log("metros_pieza_1: "+metros_pieza+" metros_pieza_2: "+metros_pieza_2);
        console.log("precio final a medida: "+precio_alfombra_final_a_medida.toFixed(2));
        console.log("precio final rollo 1 ( "+p_ancho+" x "+p_alto+" ): "+precio_alfombra_original_rollo.toFixed(2)+" --> "+precio_alfombra_final_rollo.toFixed(2));
        console.log("precio final rollo 2 ( "+p_alto+" x "+p_ancho+" ): "+precio_alfombra_original_rollo_2.toFixed(2)+" --> "+precio_alfombra_final_rollo_2.toFixed(2));
        
        console.log("precio final seleccionado( "+p_ancho+" x "+p_alto+" "+informacion_extra_desperdicio+"): "+precio_alfombra_final.toFixed(2));
		/*
	    alert(	'Precio final a medida: '+precio_alfombra_final_a_medida+'\n'+
	    		'Precio final a rollo ('+p_ancho+" x "+p_alto+'): '+precio_alfombra_final_rollo.toFixed(2)+'\n'+
	    		'Precio final a rollo ('+p_alto+" x "+p_ancho+'): '+precio_alfombra_final_rollo_2.toFixed(2));
		*/
		$("#total-current-price").html(parseFloat(precio_alfombra_final*unidades).toFixed(2).replace('.', ',')+" €");
		$("#total-regular-price").html(parseFloat(precio_alfombra_original*unidades).toFixed(2).replace('.', ',')+" €");
	   
	    $("#precio_unitario_final").val(parseFloat(precio_alfombra_final).toFixed(2));
	    $("#precio_unitario_final_sin_desc").val(parseFloat(precio_alfombra_original).toFixed(2));

	    $("#informacion_extra_desperdicio").val(informacion_extra_desperdicio);
	}
}
-->
</script>


