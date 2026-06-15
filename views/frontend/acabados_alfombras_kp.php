<?php
// 4: alfombras
// 276: marca KP
$a_forma_alfombra[4][276]['RECTANGULAR CUADRADA']['img']='/includes/images/acabados/rectangular-cuadrada.jpg';
$a_forma_alfombra[4][276]['REDONDA']['img']='/includes/images/acabados/redonda.jpg';
$a_forma_alfombra[4][276]['ROLLO']['img']='/includes/images/acabados/rollo.jpg';

// Cargar acabados desde BD
$CI =& get_instance();
$_acabados_bd = $CI->db->select('*')
  ->from('alfombra_acabados_tarifas')
  ->where('marca_id', 276)
  ->where('activo', 1)
  ->order_by('orden', 'asc')
  ->get()->result();

foreach ($_acabados_bd as $_ab) {
  $a_acabados[4][276][$_ab->nombre_acabado]['img'] = $_ab->imagen;
  if ($_ab->precio_m_lineal > 0)
    $a_acabados[4][276][$_ab->nombre_acabado]['precio_m_lineal'] = floatval($_ab->precio_m_lineal);
  if ($_ab->precio_m2 > 0)
    $a_acabados[4][276][$_ab->nombre_acabado]['precio_m_2'] = floatval($_ab->precio_m2);
  if (!isset($a_acabados[4][276][$_ab->nombre_acabado]['precio_m_lineal']))
    $a_acabados[4][276][$_ab->nombre_acabado]['precio_m_lineal'] = 0;
  if ($_ab->opciones != '')
    $a_acabados[4][276][$_ab->nombre_acabado]['opciones'] = $_ab->opciones;
  if ($_ab->txt_opciones != '')
    $a_acabados[4][276][$_ab->nombre_acabado]['txt_opciones'] = $_ab->txt_opciones;
}

$a_acabados[4][276]['FLECOS']['tipo_txt']='TIPO DE FLECO';
$a_acabados[4][276]['FLECOS']['tipo']['EN TODO EL PERIMETRO']='/includes/images/acabados/flecos-perimetro.jpg';
$a_acabados[4][276]['FLECOS']['tipo']['EN EL ANCHO']='/includes/images/acabados/flecos-ancho.jpg';

$a_rollos[4][276][2]='ANCHO DE 2 METROS';
$a_rollos[4][276][4]='ANCHO DE 4 METROS';


$a_opciones['fest']['000 SAUCO']='/includes/images/acabados/fest/sauco.jpg';
$a_opciones['fest']['37 DATADURA']='/includes/images/acabados/fest/datadura.jpg';
$a_opciones['fest']['70 LITHOP']='/includes/images/acabados/fest/lithop.jpg';
$a_opciones['fest']['640 SALVIA']='/includes/images/acabados/fest/salvia.jpg';
$a_opciones['fest']['780 SAGUARO']='/includes/images/acabados/fest/saguaro.jpg';
$a_opciones['fest']['800 SABILA']='/includes/images/acabados/fest/sabila.jpg';
$a_opciones['fest']['810 YUCCA']='/includes/images/acabados/fest/yucca.jpg';
$a_opciones['fest']['887 PICEA']='/includes/images/acabados/fest/picea.jpg';
$a_opciones['fest']['893 CINERARIA']='/includes/images/acabados/fest/cineraria.jpg';
$a_opciones['fest']['908 BIZNAGA']='/includes/images/acabados/fest/biznaga.jpg';
$a_opciones['fest']['910 ALMEZ']='/includes/images/acabados/fest/almez.jpg';
$a_opciones['fest']['917 MAMEY']='/includes/images/acabados/fest/mamey.jpg';
$a_opciones['fest']['925 SEDUM']='/includes/images/acabados/fest/sedum.jpg';
$a_opciones['fest']['930 SALSOLA']='/includes/images/acabados/fest/salsola.jpg';
$a_opciones['fest']['932 CICLAMEN']='/includes/images/acabados/fest/ciclamen.jpg';
$a_opciones['fest']['934 ANIS']='/includes/images/acabados/fest/anis.jpg';
$a_opciones['fest']['942 CORTEZA']='/includes/images/acabados/fest/corteza.jpg';
$a_opciones['fest']['944 ECHEVERIA']='/includes/images/acabados/fest/echeveria.jpg';
$a_opciones['fest']['971 MAGUEY']='/includes/images/acabados/fest/maguey.jpg';
$a_opciones['fest']['973 MUSCARI']='/includes/images/acabados/fest/muscari.jpg';


$a_opciones['strong']['Strong 303']='/includes/images/acabados/strong/303.jpg';
$a_opciones['strong']['Strong 304']='/includes/images/acabados/strong/304.jpg';
$a_opciones['strong']['Strong 309']='/includes/images/acabados/strong/309.jpg';
$a_opciones['strong']['Strong 312']='/includes/images/acabados/strong/312.jpg';
$a_opciones['strong']['Strong 319']='/includes/images/acabados/strong/319.jpg';
$a_opciones['strong']['Strong 333']='/includes/images/acabados/strong/333.jpg';
$a_opciones['strong']['Strong 358']='/includes/images/acabados/strong/358.jpg';
$a_opciones['strong']['Strong 401']='/includes/images/acabados/strong/401.jpg';
$a_opciones['strong']['Strong 409']='/includes/images/acabados/strong/409.jpg';
$a_opciones['strong']['Strong 410']='/includes/images/acabados/strong/410.jpg';
$a_opciones['strong']['Strong 413']='/includes/images/acabados/strong/413.jpg';
$a_opciones['strong']['Strong 421']='/includes/images/acabados/strong/421.jpg';
$a_opciones['strong']['Strong 432']='/includes/images/acabados/strong/432.jpg';
$a_opciones['strong']['Strong 452']='/includes/images/acabados/strong/452.jpg';
$a_opciones['strong']['Strong 422']='/includes/images/acabados/strong/422.jpg';


$a_opciones['antelook']['Antelook 002']='/includes/images/acabados/antelook/002.jpg';
$a_opciones['antelook']['Antelook 020']='/includes/images/acabados/antelook/020.jpg';
$a_opciones['antelook']['Antelook 023']='/includes/images/acabados/antelook/023.jpg';
$a_opciones['antelook']['Antelook 029']='/includes/images/acabados/antelook/029.jpg';
$a_opciones['antelook']['Antelook 060']='/includes/images/acabados/antelook/060.jpg';
$a_opciones['antelook']['Antelook 082']='/includes/images/acabados/antelook/082.jpg';
$a_opciones['antelook']['Antelook 102']='/includes/images/acabados/antelook/102.jpg';
$a_opciones['antelook']['Antelook 104']='/includes/images/acabados/antelook/104.jpg';
$a_opciones['antelook']['Antelook 121']='/includes/images/acabados/antelook/121.jpg';
$a_opciones['antelook']['Antelook 122']='/includes/images/acabados/antelook/122.jpg';
$a_opciones['antelook']['Antelook 123']='/includes/images/acabados/antelook/123.jpg';


$a_opciones['banda-natur']['Banda Natur 15 Hole']='/includes/images/acabados/banda-natur/hole.jpg';
$a_opciones['banda-natur']['Banda Natur 25 Taupe']='/includes/images/acabados/banda-natur/taupe.jpg';
$a_opciones['banda-natur']['Banda Natur 61 Ratan']='/includes/images/acabados/banda-natur/ratan.jpg';
$a_opciones['banda-natur']['Banda Natur 73 Nube']='/includes/images/acabados/banda-natur/nube.jpg';
$a_opciones['banda-natur']['Banda Natur 82 Grege']='/includes/images/acabados/banda-natur/grege.jpg';


$a_opciones['banda-microfibra']['Microfibra Black 15']='/includes/images/acabados/banda-microfibra/black.jpg';
$a_opciones['banda-microfibra']['Microfibra Blue 02']='/includes/images/acabados/banda-microfibra/blue.jpg';
$a_opciones['banda-microfibra']['Microfibra Brown 13']='/includes/images/acabados/banda-microfibra/brown.jpg';
$a_opciones['banda-microfibra']['Microfibra Cacao 28']='/includes/images/acabados/banda-microfibra/cacao.jpg';
$a_opciones['banda-microfibra']['Microfibra Darkgreen 18']='/includes/images/acabados/banda-microfibra/darkgreen.jpg';
$a_opciones['banda-microfibra']['Microfibra Jute 16']='/includes/images/acabados/banda-microfibra/jute.jpg';
$a_opciones['banda-microfibra']['Microfibra Moka 29']='/includes/images/acabados/banda-microfibra/moka.jpg';
$a_opciones['banda-microfibra']['Microfibra Mouse 26']='/includes/images/acabados/banda-microfibra/mouse.jpg';
$a_opciones['banda-microfibra']['Microfibra Natural 12']='/includes/images/acabados/banda-microfibra/natural.jpg';
$a_opciones['banda-microfibra']['Microfibra Rouge 21']='/includes/images/acabados/banda-microfibra/rouge.jpg';
$a_opciones['banda-microfibra']['Microfibra Silver 23']='/includes/images/acabados/banda-microfibra/silver.jpg';
$a_opciones['banda-microfibra']['Microfibra Steel 24']='/includes/images/acabados/banda-microfibra/steel.jpg';
$a_opciones['banda-microfibra']['Microfibra Stone 25']='/includes/images/acabados/banda-microfibra/stone.jpg';
$a_opciones['banda-microfibra']['Microfibra Syrah 22']='/includes/images/acabados/banda-microfibra/syrah.jpg';
$a_opciones['banda-microfibra']['Microfibra Toast 19']='/includes/images/acabados/banda-microfibra/toast.jpg';
$a_opciones['banda-microfibra']['Microfibra Tobacco 27']='/includes/images/acabados/banda-microfibra/tobacco.jpg';


$a_opciones['banda-piel-vuelta']['Pielvuelta Arena 32']='/includes/images/acabados/banda-piel-vuelta/Arena.jpg';
$a_opciones['banda-piel-vuelta']['Pielvuelta Ceniza 35']='/includes/images/acabados/banda-piel-vuelta/Ceniza.jpg';
$a_opciones['banda-piel-vuelta']['Pielvuelta Choco 33']='/includes/images/acabados/banda-piel-vuelta/Choco.jpg';
$a_opciones['banda-piel-vuelta']['Pielvuelta Conac 31']='/includes/images/acabados/banda-piel-vuelta/Conac.jpg';
$a_opciones['banda-piel-vuelta']['Pielvuelta Graf 70']='/includes/images/acabados/banda-piel-vuelta/Graf.jpg';
$a_opciones['banda-piel-vuelta']['Pielvuelta Lumi 40']='/includes/images/acabados/banda-piel-vuelta/Lumi.jpg';
$a_opciones['banda-piel-vuelta']['Pielvuelta Negro 30']='/includes/images/acabados/banda-piel-vuelta/Negro.jpg';
$a_opciones['banda-piel-vuelta']['Pielvuelta Nuez 80']='/includes/images/acabados/banda-piel-vuelta/Nuez.jpg';
$a_opciones['banda-piel-vuelta']['Pielvuelta Tundra 50']='/includes/images/acabados/banda-piel-vuelta/Tundra.jpg';
$a_opciones['banda-piel-vuelta']['Pielvuelta Vison 60']='/includes/images/acabados/banda-piel-vuelta/Vison.jpg';

$a_opciones['banda-kuero']['Kuero Belt']='/includes/images/acabados/banda-kuero/Belt.jpg';
$a_opciones['banda-kuero']['Kuero Boot']='/includes/images/acabados/banda-kuero/Boot.jpg';
$a_opciones['banda-kuero']['Kuero Desert Chocolate']='/includes/images/acabados/banda-kuero/Desert-Chocolate.jpg';
$a_opciones['banda-kuero']['Kuero Desert Negro']='/includes/images/acabados/banda-kuero/Desert-Negro.jpg';
$a_opciones['banda-kuero']['Kuero Horse']='/includes/images/acabados/banda-kuero/Horse.jpg';
$a_opciones['banda-kuero']['Kuero Mountain']='/includes/images/acabados/banda-kuero/Mountain.jpg';
$a_opciones['banda-kuero']['Kuero Nero']='/includes/images/acabados/banda-kuero/Nero.jpg';
$a_opciones['banda-kuero']['Kuero Top']='/includes/images/acabados/banda-kuero/Top.jpg';


$a_opciones['banda-single']['BANDA SINGLE A-00']='/includes/images/acabados/banda-single/A-00.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-01']='/includes/images/acabados/banda-single/A-01.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-02']='/includes/images/acabados/banda-single/A-02.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-03']='/includes/images/acabados/banda-single/A-03.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-04']='/includes/images/acabados/banda-single/A-04.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-05']='/includes/images/acabados/banda-single/A-05.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-06']='/includes/images/acabados/banda-single/A-06.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-07']='/includes/images/acabados/banda-single/A-07.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-08']='/includes/images/acabados/banda-single/A-08.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-09']='/includes/images/acabados/banda-single/A-09.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-10']='/includes/images/acabados/banda-single/A-10.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-11']='/includes/images/acabados/banda-single/A-11.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-12']='/includes/images/acabados/banda-single/A-12.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-13']='/includes/images/acabados/banda-single/A-13.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-14']='/includes/images/acabados/banda-single/A-14.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-15']='/includes/images/acabados/banda-single/A-15.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-16']='/includes/images/acabados/banda-single/A-16.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-17']='/includes/images/acabados/banda-single/A-17.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-18']='/includes/images/acabados/banda-single/A-18.jpg';
$a_opciones['banda-single']['BANDA SINGLE A-19']='/includes/images/acabados/banda-single/A-19.jpg';




// HAY UNA FOTO MAL, LA N-213 falta
$a_opciones['flecos']['Flekos N-023']='/includes/images/acabados/flecos/N-023.jpg';
$a_opciones['flecos']['Flekos N-035']='/includes/images/acabados/flecos/N-035.jpg';
$a_opciones['flecos']['Flekos N-086']='/includes/images/acabados/flecos/N-086.jpg';
$a_opciones['flecos']['Flekos N-087']='/includes/images/acabados/flecos/N-087.jpg';
$a_opciones['flecos']['Flekos N-117']='/includes/images/acabados/flecos/N-117.jpg';
$a_opciones['flecos']['Flekos N-127']='/includes/images/acabados/flecos/N-127.jpg';
$a_opciones['flecos']['Flekos N-169']='/includes/images/acabados/flecos/N-169.jpg';
$a_opciones['flecos']['Flekos N-213']='/includes/images/acabados/flecos/N-213.jpg'; // No es correcta
$a_opciones['flecos']['Flekos N-273']='/includes/images/acabados/flecos/N-273.jpg';
$a_opciones['flecos']['Flekos L-023']='/includes/images/acabados/flecos/L-023.jpg';
$a_opciones['flecos']['Flekos L-035']='/includes/images/acabados/flecos/L-035.jpg';
$a_opciones['flecos']['Flekos L-086']='/includes/images/acabados/flecos/L-086.jpg';
$a_opciones['flecos']['Flekos L-087']='/includes/images/acabados/flecos/L-087.jpg';
$a_opciones['flecos']['Flekos L-117']='/includes/images/acabados/flecos/L-117.jpg';
$a_opciones['flecos']['Flekos L-127']='/includes/images/acabados/flecos/L-127.jpg';
$a_opciones['flecos']['Flekos L-169']='/includes/images/acabados/flecos/L-169.jpg';
$a_opciones['flecos']['Flekos L-213']='/includes/images/acabados/flecos/L-213.jpg';
$a_opciones['flecos']['Flekos L-273']='/includes/images/acabados/flecos/L-273.jpg';


$a_opciones['banda-the-end']['THE-END 1']='/includes/images/acabados/banda-the-end/1.jpg';
$a_opciones['banda-the-end']['THE-END 2']='/includes/images/acabados/banda-the-end/2.jpg';
$a_opciones['banda-the-end']['THE-END 3']='/includes/images/acabados/banda-the-end/3.jpg';
$a_opciones['banda-the-end']['THE-END 4']='/includes/images/acabados/banda-the-end/4.jpg';
$a_opciones['banda-the-end']['THE-END 5']='/includes/images/acabados/banda-the-end/5.jpg';
$a_opciones['banda-the-end']['THE-END 6']='/includes/images/acabados/banda-the-end/6.jpg';
$a_opciones['banda-the-end']['THE-END 7']='/includes/images/acabados/banda-the-end/7.jpg';
$a_opciones['banda-the-end']['THE-END 8']='/includes/images/acabados/banda-the-end/8.jpg';
$a_opciones['banda-the-end']['THE-END 9']='/includes/images/acabados/banda-the-end/9.jpg';
$a_opciones['banda-the-end']['THE-END 10']='/includes/images/acabados/banda-the-end/10.jpg';
$a_opciones['banda-the-end']['THE-END 11']='/includes/images/acabados/banda-the-end/11.jpg';
$a_opciones['banda-the-end']['THE-END 12']='/includes/images/acabados/banda-the-end/12.jpg';
$a_opciones['banda-the-end']['THE-END 13']='/includes/images/acabados/banda-the-end/13.jpg';
$a_opciones['banda-the-end']['THE-END 14']='/includes/images/acabados/banda-the-end/14.jpg';
$a_opciones['banda-the-end']['THE-END 15']='/includes/images/acabados/banda-the-end/15.jpg';
$a_opciones['banda-the-end']['THE-END 16']='/includes/images/acabados/banda-the-end/16.jpg';
$a_opciones['banda-the-end']['THE-END 17']='/includes/images/acabados/banda-the-end/17.jpg';
$a_opciones['banda-the-end']['THE-END 18']='/includes/images/acabados/banda-the-end/18.jpg';

$a_opciones['banda-the-end']['THE-END 20']='/includes/images/acabados/banda-the-end/20.jpg';
$a_opciones['banda-the-end']['THE-END 21']='/includes/images/acabados/banda-the-end/21.jpg';
$a_opciones['banda-the-end']['THE-END 22']='/includes/images/acabados/banda-the-end/22.jpg';
$a_opciones['banda-the-end']['THE-END 23']='/includes/images/acabados/banda-the-end/23.jpg';
$a_opciones['banda-the-end']['THE-END 24']='/includes/images/acabados/banda-the-end/24.jpg';
$a_opciones['banda-the-end']['THE-END 25']='/includes/images/acabados/banda-the-end/25.jpg';
$a_opciones['banda-the-end']['THE-END 26']='/includes/images/acabados/banda-the-end/26.jpg';
$a_opciones['banda-the-end']['THE-END 27']='/includes/images/acabados/banda-the-end/27.jpg';
$a_opciones['banda-the-end']['THE-END 28']='/includes/images/acabados/banda-the-end/28.jpg';
$a_opciones['banda-the-end']['THE-END 29']='/includes/images/acabados/banda-the-end/29.jpg';
$a_opciones['banda-the-end']['THE-END 30']='/includes/images/acabados/banda-the-end/30.jpg';
$a_opciones['banda-the-end']['THE-END 31']='/includes/images/acabados/banda-the-end/31.jpg';
$a_opciones['banda-the-end']['THE-END 31']='/includes/images/acabados/banda-the-end/31.jpg';
$a_opciones['banda-the-end']['THE-END 36']='/includes/images/acabados/banda-the-end/36.jpg';
$a_opciones['banda-the-end']['THE-END 37']='/includes/images/acabados/banda-the-end/37.jpg';
$a_opciones['banda-the-end']['THE-END 38']='/includes/images/acabados/banda-the-end/38.jpg';
$a_opciones['banda-the-end']['THE-END 40']='/includes/images/acabados/banda-the-end/40.jpg';
$a_opciones['banda-the-end']['THE-END 43']='/includes/images/acabados/banda-the-end/43.jpg';
$a_opciones['banda-the-end']['THE-END 45']='/includes/images/acabados/banda-the-end/45.jpg';


$a_opciones['banda-the-end']['THE-END 47']='/includes/images/acabados/banda-the-end/47.jpg';
$a_opciones['banda-the-end']['THE-END 49']='/includes/images/acabados/banda-the-end/49.jpg';
$a_opciones['banda-the-end']['THE-END 50']='/includes/images/acabados/banda-the-end/50.jpg';
$a_opciones['banda-the-end']['THE-END 54']='/includes/images/acabados/banda-the-end/54.jpg';
$a_opciones['banda-the-end']['THE-END 56']='/includes/images/acabados/banda-the-end/56.jpg';
$a_opciones['banda-the-end']['THE-END 57']='/includes/images/acabados/banda-the-end/57.jpg';
$a_opciones['banda-the-end']['THE-END 58']='/includes/images/acabados/banda-the-end/58.jpg';
$a_opciones['banda-the-end']['THE-END 59']='/includes/images/acabados/banda-the-end/59.jpg';
$a_opciones['banda-the-end']['THE-END 60']='/includes/images/acabados/banda-the-end/60.jpg';
$a_opciones['banda-the-end']['THE-END 61']='/includes/images/acabados/banda-the-end/61.jpg';
$a_opciones['banda-the-end']['THE-END 62']='/includes/images/acabados/banda-the-end/62.jpg';
$a_opciones['banda-the-end']['THE-END 63']='/includes/images/acabados/banda-the-end/63.jpg';
$a_opciones['banda-the-end']['THE-END 64']='/includes/images/acabados/banda-the-end/64.jpg';
$a_opciones['banda-the-end']['THE-END 65']='/includes/images/acabados/banda-the-end/65.jpg';
$a_opciones['banda-the-end']['THE-END 66']='/includes/images/acabados/banda-the-end/66.jpg';
$a_opciones['banda-the-end']['THE-END 67']='/includes/images/acabados/banda-the-end/67.jpg';
$a_opciones['banda-the-end']['THE-END 68']='/includes/images/acabados/banda-the-end/68.jpg';
$a_opciones['banda-the-end']['THE-END 69']='/includes/images/acabados/banda-the-end/69.jpg';

$a_opciones['banda-the-end']['THE-END 70']='/includes/images/acabados/banda-the-end/70.jpg';
$a_opciones['banda-the-end']['THE-END 71']='/includes/images/acabados/banda-the-end/71.jpg';
$a_opciones['banda-the-end']['THE-END 72']='/includes/images/acabados/banda-the-end/72.jpg';
$a_opciones['banda-the-end']['THE-END 73']='/includes/images/acabados/banda-the-end/73.jpg';
$a_opciones['banda-the-end']['THE-END 74']='/includes/images/acabados/banda-the-end/74.jpg';
$a_opciones['banda-the-end']['THE-END 76']='/includes/images/acabados/banda-the-end/76.jpg';
$a_opciones['banda-the-end']['THE-END 77']='/includes/images/acabados/banda-the-end/77.jpg';
$a_opciones['banda-the-end']['THE-END 78']='/includes/images/acabados/banda-the-end/78.jpg';
$a_opciones['banda-the-end']['THE-END 79']='/includes/images/acabados/banda-the-end/79.jpg';
$a_opciones['banda-the-end']['THE-END 80']='/includes/images/acabados/banda-the-end/80.jpg';
$a_opciones['banda-the-end']['THE-END 81']='/includes/images/acabados/banda-the-end/81.jpg';
$a_opciones['banda-the-end']['THE-END 82']='/includes/images/acabados/banda-the-end/82.jpg';
$a_opciones['banda-the-end']['THE-END 83']='/includes/images/acabados/banda-the-end/83.jpg';
$a_opciones['banda-the-end']['THE-END 84']='/includes/images/acabados/banda-the-end/84.jpg';
$a_opciones['banda-the-end']['THE-END 85']='/includes/images/acabados/banda-the-end/85.jpg';
$a_opciones['banda-the-end']['THE-END 86']='/includes/images/acabados/banda-the-end/86.jpg';
$a_opciones['banda-the-end']['THE-END 87']='/includes/images/acabados/banda-the-end/87.jpg';
$a_opciones['banda-the-end']['THE-END 88']='/includes/images/acabados/banda-the-end/88.jpg';


$a_opciones['banda-the-end']['THE-END 90']='/includes/images/acabados/banda-the-end/90.jpg';
$a_opciones['banda-the-end']['THE-END 91']='/includes/images/acabados/banda-the-end/91.jpg';
$a_opciones['banda-the-end']['THE-END 92']='/includes/images/acabados/banda-the-end/92.jpg';
$a_opciones['banda-the-end']['THE-END 93']='/includes/images/acabados/banda-the-end/93.jpg';
$a_opciones['banda-the-end']['THE-END 94']='/includes/images/acabados/banda-the-end/94.jpg';
$a_opciones['banda-the-end']['THE-END 95']='/includes/images/acabados/banda-the-end/95.jpg';
$a_opciones['banda-the-end']['THE-END 96']='/includes/images/acabados/banda-the-end/96.jpg';
$a_opciones['banda-the-end']['THE-END 97']='/includes/images/acabados/banda-the-end/97.jpg';
$a_opciones['banda-the-end']['THE-END 98']='/includes/images/acabados/banda-the-end/98.jpg';
$a_opciones['banda-the-end']['THE-END 99']='/includes/images/acabados/banda-the-end/99.jpg';
$a_opciones['banda-the-end']['THE-END 100']='/includes/images/acabados/banda-the-end/100.jpg';
$a_opciones['banda-the-end']['THE-END 101']='/includes/images/acabados/banda-the-end/101.jpg';
$a_opciones['banda-the-end']['THE-END 102']='/includes/images/acabados/banda-the-end/102.jpg';
$a_opciones['banda-the-end']['THE-END 103']='/includes/images/acabados/banda-the-end/103.jpg';
$a_opciones['banda-the-end']['THE-END 104']='/includes/images/acabados/banda-the-end/104.jpg';
$a_opciones['banda-the-end']['THE-END 105']='/includes/images/acabados/banda-the-end/105.jpg';
$a_opciones['banda-the-end']['THE-END 106']='/includes/images/acabados/banda-the-end/106.jpg';
$a_opciones['banda-the-end']['THE-END 107']='/includes/images/acabados/banda-the-end/107.jpg';
$a_opciones['banda-the-end']['THE-END 108']='/includes/images/acabados/banda-the-end/108.jpg';
$a_opciones['banda-the-end']['THE-END 109']='/includes/images/acabados/banda-the-end/109.jpg';
$a_opciones['banda-the-end']['THE-END 110']='/includes/images/acabados/banda-the-end/110.jpg';
$a_opciones['banda-the-end']['THE-END 111']='/includes/images/acabados/banda-the-end/111.jpg';
$a_opciones['banda-the-end']['THE-END 112']='/includes/images/acabados/banda-the-end/112.jpg';
$a_opciones['banda-the-end']['THE-END 113']='/includes/images/acabados/banda-the-end/113.jpg';
$a_opciones['banda-the-end']['THE-END 114']='/includes/images/acabados/banda-the-end/114.jpg';
$a_opciones['banda-the-end']['THE-END 115']='/includes/images/acabados/banda-the-end/115.jpg';
$a_opciones['banda-the-end']['THE-END 116']='/includes/images/acabados/banda-the-end/116.jpg';
$a_opciones['banda-the-end']['THE-END 117']='/includes/images/acabados/banda-the-end/117.jpg';
$a_opciones['banda-the-end']['THE-END 118']='/includes/images/acabados/banda-the-end/118.jpg';
$a_opciones['banda-the-end']['THE-END 119']='/includes/images/acabados/banda-the-end/119.jpg';
$a_opciones['banda-the-end']['THE-END 120']='/includes/images/acabados/banda-the-end/120.jpg';
$a_opciones['banda-the-end']['THE-END 121']='/includes/images/acabados/banda-the-end/121.jpg';
$a_opciones['banda-the-end']['THE-END 122']='/includes/images/acabados/banda-the-end/122.jpg';
$a_opciones['banda-the-end']['THE-END 123']='/includes/images/acabados/banda-the-end/123.jpg';
$a_opciones['banda-the-end']['THE-END 124']='/includes/images/acabados/banda-the-end/124.jpg';
$a_opciones['banda-the-end']['THE-END 125']='/includes/images/acabados/banda-the-end/125.jpg';
$a_opciones['banda-the-end']['THE-END 126']='/includes/images/acabados/banda-the-end/126.jpg';
$a_opciones['banda-the-end']['THE-END 127']='/includes/images/acabados/banda-the-end/127.jpg';


$a_opciones['banda-the-end']['THE-END 130']='/includes/images/acabados/banda-the-end/130.jpg';
$a_opciones['banda-the-end']['THE-END 131']='/includes/images/acabados/banda-the-end/131.jpg';
$a_opciones['banda-the-end']['THE-END 132']='/includes/images/acabados/banda-the-end/132.jpg';
$a_opciones['banda-the-end']['THE-END 133']='/includes/images/acabados/banda-the-end/133.jpg';
$a_opciones['banda-the-end']['THE-END 134']='/includes/images/acabados/banda-the-end/134.jpg';
$a_opciones['banda-the-end']['THE-END 135']='/includes/images/acabados/banda-the-end/135.jpg';
$a_opciones['banda-the-end']['THE-END 136']='/includes/images/acabados/banda-the-end/136.jpg';
$a_opciones['banda-the-end']['THE-END 137']='/includes/images/acabados/banda-the-end/137.jpg';
$a_opciones['banda-the-end']['THE-END 138']='/includes/images/acabados/banda-the-end/138.jpg';
$a_opciones['banda-the-end']['THE-END 139']='/includes/images/acabados/banda-the-end/139.jpg';
$a_opciones['banda-the-end']['THE-END 140']='/includes/images/acabados/banda-the-end/140.jpg';
$a_opciones['banda-the-end']['THE-END 141']='/includes/images/acabados/banda-the-end/141.jpg';
$a_opciones['banda-the-end']['THE-END 142']='/includes/images/acabados/banda-the-end/142.jpg';

$ocultar_acabado['MINI FEST'][]=1909; //NINCASI
$ocultar_acabado['ANTELOOK-BLIND'][]=1909; //NINCASI
$ocultar_acabado['THE END'][]=1909; //NINCASI
$ocultar_acabado['BANDA SINGLE'][]=1909; //NINCASI
/*
$ocultar_acabado['SUPER FEST'][]=;
$ocultar_acabado['STRONG'][]=;
$ocultar_acabado['ANTELOOK-BANDA'][]=;
$ocultar_acabado['PREMIUM'][]=;
$ocultar_acabado['PREMIUM ULTRA'][]=;
$ocultar_acabado['BANDA NATUR'][]=;
$ocultar_acabado['MICROFIBRA 4 CM'][]=;
$ocultar_acabado['MICROFIBRA 8 CM'][]=;
$ocultar_acabado['PIEL VUELTA 2 CM'][]=;
$ocultar_acabado['PIEL VUELTA 6 CM'][]=;
$ocultar_acabado['PIEL VUELTA 12 CM'][]=;
$ocultar_acabado['KUERO 6 CM'][]=;
$ocultar_acabado['KUERO 12 CM'][]=;
$ocultar_acabado['FLECOS'][]=;
*/
echo '<div class="row">';
echo '  <div class="h6 destacado mt-3 mb-3 col-11">SELECCIONE LA FORMA: <span id="forma_seleccionada"></span></div>';
echo '</div>';

echo '<div class="" id="lista-opciones-formas">';
echo '<ul class="opciones-grecas row p-0">';
foreach ($a_forma_alfombra[4][276] as $txt_forma=>$datos_forma){
	$nombre=$txt_forma;
	$src=$datos_forma['img'];
	echo '<li class="item-opcion-greca col-3 col-lg-2">';
	echo '  <div class="img-opcion-greca">';
	echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-forma-kp" data-name-forma="'.$nombre.'" src="'.$src.'"/>';
	//echo '    <p class="name-opcion-greca text-center">'.$nombre.'</p>';
	echo '  </div>';
	echo '</li>';
}
echo '</ul>';
echo '</div>';

echo '<div id="div-acabados-kp">';
echo '<div class="row">';
echo '  <div class="h6 destacado mt-3 mb-3 col-11">SELECCIONE EL ACABADO: <span id="acabado_seleccionado"></span></div>';
//echo '  <button class="calc_collapsible col-1 py-0" data-toggle="collapse" data-target="#lista-opciones-grecas" aria-expanded="false" aria-controls="calc-colapsable" aria-label="Ver opcines grecas"></button>';
echo '</div>';

//echo '<div class="collapse" id="lista-opciones-grecas">';
echo '<div class="" id="lista-opciones-grecas">';
echo '<ul class="opciones-grecas row p-0">';
foreach ($a_acabados[4][276] as $txt_acabado=>$datos_acabado){
	if (!isset($ocultar_acabado[$txt_acabado]) || !in_array($key['item_coleccion_id'], $ocultar_acabado[$txt_acabado])){
		$nombre=$txt_acabado;
		$nombre_aux='ID_'.str_replace(' ', '_', $nombre);
		$precio_m_lineal=0;
		if (isset($datos_acabado['precio_m_lineal']))
			$precio_m_lineal=$datos_acabado['precio_m_lineal'];

		$precio_m_lineal_largo=0;
		if ($txt_acabado=='FLECOS')
			$precio_m_lineal_largo=$a_acabados[4][276]['THE END']['precio_m_lineal']; // El acabado franja va en el lado corto, lado largo LINE
		
		$precio_m_2=0;
		if (isset($datos_acabado['precio_m_2']))
			$precio_m_2=$datos_acabado['precio_m_2'];

		$txt_tit_opcion='';
		if (isset($datos_acabado['txt_opciones']))
			$txt_tit_opcion=$datos_acabado['txt_opciones'];

		$div_opciones='';
		if (isset($datos_acabado['opciones']))
			$div_opciones=$datos_acabado['opciones'];

		$src=$datos_acabado['img'];
		echo '<li class="item-opcion-greca col-2">';
		echo '  <div class="img-opcion-greca">';
		echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-acabado-kp" id="'.$nombre_aux.'" data-name-acabado="'.$nombre.'" data-div-opciones="'.$div_opciones.'" data-txt-opciones="'.$txt_tit_opcion.'" data-precio-ml="'.$precio_m_lineal.'" data-precio-ml_largo="'.$precio_m_lineal_largo.'" data-precio-m2="'.$precio_m_2.'" src="'.$src.'"/>';
		echo '    <p class="name-opcion-greca text-center">'.$nombre.'</p>';
		echo '  </div>';
		echo '</li>';
	}
}
echo '</ul>';
echo '</div>';
echo '</div>';

$a_generados=array();
foreach ($a_acabados[4][276] as $txt_acabado=>$datos_acabado){
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
			echo '<div class="opciones-kp d-none" id="opciones-'.$txt_opcion.'">';
			if (isset($datos_acabado['tipo_txt'])){
				echo '<div class="row">';
				echo '  <div class="h6 destacado mt-3 m3-2 col-11"><span class="txt_opcion_tipo">'.$datos_acabado['tipo_txt'].':</span> <span id="tipo-'.$txt_opcion.'" class="txt-tipo-seleccionado"></span></div>';
				//echo '  <button class="calc_collapsible col-1 py-0" data-toggle="collapse" data-target="#lista-colores-grecas" aria-expanded="false" aria-controls="calc-colapsable" aria-label="Ver opciones colores"></button>';
				echo '</div>';
				echo '<ul class="opciones-grecas row p-0">';
				foreach ($datos_acabado['tipo'] as $txt_tipo=>$img_tipo){
					$nombre=$txt_tipo;
					$src=$img_tipo;
					
					echo '<li class="item-opcion-greca col-2">';
					echo '  <div class="img-opcion-greca">';
					echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-opcion-tipo-kp" data-name-tipo="'.$nombre.'" data-txt-opcion="'.$txt_opcion.'" src="'.$src.'"/>';
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
				echo '<li class="item-opcion-greca col-2">';
				echo '  <div class="img-opcion-greca">';
				echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-opcion-kp" data-name-opcion="'.$nombre.'" data-txt-opcion="'.$txt_opcion.'" src="'.$src.'"/>';
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
$txt_p_ancho='Ancho en metros (max. 4m)';
$txt_p_alto='Largo en metros (max. 25m)';
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
		<div id='dimensiones_cuadrada' class="row" >
			<p class="col-12">Introduce las dimensiones necesarias en metros, ej: 3.8 x 2.5</p>
			<div class="col-6">
				<div class="pr-15">
				  <label for="p_alto"><?php echo $txt_p_ancho; ?></label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_ancho" name="p_ancho" class="w-75 metrs calcuinput" oninput="calcularKP();" /> m
				    </div>
				  </div>
				</div>
			</div>
			<div class="col-6">
				<div class="">
				  <label for="p_alto"><?php echo $txt_p_alto; ?></label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_alto" name="p_alto" class="w-75" oninput="calcularKP();" /> m
				    </div>
				  </div>
				</div>
			</div>
		</div>
		<div id='dimensiones_redonda' class="row d-none" >
			<p class="col-12">Introduce el diámetro de la alfombra, ej: 1.8</p>
			<div class="col-6">
				<div class="pr-15">
				  <label for="p_diametro">Diámetro en metros (max. 4m)</label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_diametro" name="p_diametro" class="w-75 metrs calcuinput" oninput="calcularKP();" /> m
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
						<input type="radio" id="val_2" name="ancho_rollo" value="2" onclick="calcularKP();" />
						<label for="val_2" class="mr-4">2 metros</label>
						<input type="radio" id="val_4" name="ancho_rollo" value="4" onclick="calcularKP();" />
						<label for="val_4">4 metros</label>
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
				      <input type="number" min="0" step="0.1" id="alto_rollo" name="alto_rollo" class="w-75" oninput="calcularKP();" /> m
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
	<div id='nota_dimensiones_cuadrada' class="mt-4">
		<small><strong>Se confeccionan a partir de rollos de 2 ó 4 metros de ancho en función de la medida final solicitada considerando siempre el mínimo desperdicio de material posible sin tener en cuenta el sentido de tramas o dibujos.</strong></small>
	</div>
    <?php 
    $this->load->view('frontend/info_opc_seleccionadas'); 
    ?>

</div>

<script>
<!--
function calcularKP(){
	forma_seleccionada=$("#informacion_extra_forma").val();

	faltan_datos=true;
    if (forma_seleccionada=='Redonda'){
        console.log("Redonda");
	    if(isNumeric($("#p_diametro").val()) && isNumeric($("#unidades").val())){
	    	// Para el cálculo de metros tomamos el cuadrado de la pieza que forma el círculo, por lo que alto=ancho=diametro
		    //p_ancho_orig= $("#p_diametro").val().replace(",",".");
		    p_ancho= $("#p_diametro").val().replace(",",".");
		    p_alto= $("#p_diametro").val().replace(",",".");
		    

		    //p_ancho=Math.ceil(p_ancho_prig*10)/10;
	        /*
			p_ancho=Math.ceil(p_ancho_orig*100)/100;
	        console.log("p_ancho_orig: "+p_ancho_orig);
	        console.log("p_ancho_orig 100: "+p_ancho_orig*100);
	        console.log("p_ancho_orig ceil: "+Math.ceil(p_ancho_orig*100));
	        console.log("p_ancho: "+p_ancho);
		    */
		    //p_ancho=Math.ceil(p_ancho*10)/10;
		    //p_alto=Math.ceil(p_alto*10)/10;
			p_ancho=Math.ceil(p_ancho*100)/100;
		    p_alto=Math.ceil(p_alto*100)/100;

			perimetro=p_ancho*3.1416; // 2 PI r, el ancho es igual al diametro= 2*r
		    //perimetro=Math.ceil(perimetro*10)/10;
		    perimetro=Math.ceil(perimetro*100)/100;
			lado_largo=0;
			lado_corto=0;

	        console.log("Diámetro: "+p_ancho+" - Perimetro: "+perimetro);
			
			faltan_datos=false;
		}
	}
    if (forma_seleccionada=='Rollo'){
        console.log("Rollo");
        ancho_rollo_seleccionado=$('input[name="ancho_rollo"]:checked').val();
        
	    if(isNumeric(ancho_rollo_seleccionado) && isNumeric($("#alto_rollo").val()) && isNumeric($("#unidades").val())){
		    p_ancho= ancho_rollo_seleccionado.replace(",",".");
		    p_alto= $("#alto_rollo").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

			perimetro=0; // Es rollo, no va a tener acabado en el perímetro
			lado_largo=0;
			lado_corto=0;
	        console.log("Ancho: "+p_ancho+" - Largo: "+p_alto);
			faltan_datos=false;
		}
	}
    if (forma_seleccionada=='Rectangular-cuadrada'){
        console.log("Cuadrada");
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

	        console.log("Ancho: "+p_ancho+" - Largo: "+p_alto);
			faltan_datos=false;
			/*
			if (p_ancho>4){
				$("#errorArtciluloModal .mensaje-modal-error").html('El ancho no puede sobrepasar los 4 metros. Compruebe que está introduciendo las medidas en metros.');
				$('#errorArtciluloModal').modal('toggle')
				//alert('El ancho no puede sobrepasar los 4 metros. Compruebe que está introduciendo las medidas en metros.');
				//faltan_datos=true;
			}
			if (p_alto>25){
				$("#errorArtciluloModal .mensaje-modal-error").html('El largo no puede sobrepasar los 25 metros. Compruebe que está introduciendo las medidas en metros.');
				$('#errorArtciluloModal').modal('toggle')
				//alert('El largo no puede sobrepasar los 25 metros. Compruebe que está introduciendo las medidas en metros.');
				//faltan_datos=true;
			}
			*/
		}
	}
	if (faltan_datos){
		return;
	}
	else{
		preciobase= parseFloat($("#preciobase").val()); // precio original`
		preciounitario= parseFloat($("#preciounitario").val()); // con descuento

	    precio_m_2= $("#calc_precio_m_2").val();
	    precio_m_lineal= $("#calc_precio_m_lineal").val();
	    precio_m_lineal_largo= $("#calc_precio_m_lineal_largo").val();

	    unidades= $("#unidades").val();

		//Si hay descuentos, tenemos que aplicarlos también a los acabados
	    metodo_descuento= $("#metodo_descuento").val();
	    valor_descuento= $("#valor_descuento").val();

		// Inicio precios desde rollos, probamos poniendo la alfombra en los dos sentidos de anchoy alto
		metros_pieza=9999;
		precio_alfombra_original=99999;
		precio_alfombra_final=99999;
		if(p_ancho<=4){
			if (p_ancho>2)
				metros_pieza=p_alto*4;
			else
				metros_pieza=p_alto*2;
		    
		    if ($("#acabado_seleccionado").text()=='FLECOS' && $(".txt-tipo-seleccionado").text()=='EN EL ANCHO' && lado_corto>0){
		    	// Si acabado es franja, no se aplica a ttodo el perímetro, solo al lado corto. Lado largo, LINE
			    precio_alfombra_original=metros_pieza*preciobase + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;		
			    precio_alfombra_final=metros_pieza*preciounitario + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;	
		        console.log("precio_alfombra_original: "+ (metros_pieza*preciobase_aux));
		        console.log("lado corto: "+ (lado_corto*2*precio_m_lineal));
		        console.log("lado largo: "+ (lado_largo*2*precio_m_lineal_largo));
		        console.log("precio final original: "+ precio_alfombra_original);
		    }
		    else{
				precio_alfombra_original=metros_pieza*preciobase + perimetro*precio_m_lineal + metros_pieza*precio_m_2;		
				precio_alfombra_final=metros_pieza*preciounitario + perimetro*precio_m_lineal + metros_pieza*precio_m_2;		
			}

			if (metodo_descuento==1){
				precio_alfombra_original=precio_alfombra_original.toFixed(2);
	            precio_alfombra_final=precio_alfombra_original*(100 - valor_descuento)/100;
		        console.log("valor_descuento: "+ valor_descuento);
		        console.log("precio_alfombra_original: "+ precio_alfombra_original);
		        console.log("precio_alfombra_final: "+ precio_alfombra_final);
			}
		}

		metros_pieza_2=9999;
		precio_alfombra_original_2=99999;
		precio_alfombra_final_2=99999;
		if(p_alto<=4){
			if (p_alto>2)
				metros_pieza_2=p_ancho*4;
			else
				metros_pieza_2=p_ancho*2;

		    if ($("#acabado_seleccionado").text()=='FRANJA' && lado_corto>0){
		    	// Si acabado es franja, no se aplica a ttodo el perímetro, solo al lado corto. Lado largo, LINE
			    precio_alfombra_original_2=metros_pieza_2*preciobase + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;		
			    precio_alfombra_final_2=metros_pieza_2*preciounitario + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;	
		        console.log("precio_alfombra_original 2: "+ (metros_pieza_2*preciobase_aux));
		        console.log("lado corto: "+ (lado_corto*2*precio_m_lineal));
		        console.log("lado largo: "+ (lado_largo*2*precio_m_lineal_largo));
		        console.log("precio final original 2: "+ precio_alfombra_original_2);
		    }
		    else{
			    precio_alfombra_original_2=metros_pieza_2*preciobase + perimetro*precio_m_lineal + metros_pieza_2*precio_m_2;		
			    precio_alfombra_final_2=metros_pieza_2*preciounitario + perimetro*precio_m_lineal + metros_pieza_2*precio_m_2;		
			}
			if (metodo_descuento==1){
				precio_alfombra_original_2=precio_alfombra_original_2.toFixed(2);
	            precio_alfombra_final_2=precio_alfombra_original_2*(100 - valor_descuento)/100;
		        console.log("valor_descuento: "+ valor_descuento);
		        console.log("precio_alfombra_original_2: "+ precio_alfombra_original_2);
		        console.log("precio_alfombra_final_2: "+ precio_alfombra_final_2);
			}
		}
		// Fin precios desde rollos
		if (metros_pieza_2==9999 && metros_pieza==9999){
			$("#errorArtciluloModal .mensaje-modal-error").html('El ancho no puede sobrepasar los 4 metros. Compruebe que está introduciendo las medidas en metros.');
			$('#errorArtciluloModal').modal('toggle')
		}
		
        console.log("metros_pieza_1: "+metros_pieza+" metros_pieza_2: "+metros_pieza_2);
        console.log("precio final rollo ( "+p_ancho+" x "+p_alto+" ): "+precio_alfombra_final.toFixed(2));
        console.log("precio final rollo ( "+p_alto+" x "+p_ancho+" ): "+precio_alfombra_final_2.toFixed(2));

	    /*
        console.log("previo precio_alfombra_original:  "+precio_alfombra_original);
		// Inicio seleccion precio más barato;
	    if((precio_alfombra_original_2 < precio_alfombra_original) && precio_alfombra_original_2!=0){
		    precio_alfombra_original=precio_alfombra_original_2;
	    }
	    if((precio_alfombra_original_2 < precio_alfombra_original)){
        	console.log("precio_alfombra_original_2 más barata");
	    }
	    else{
        	console.log("precio_alfombra_original_2 más cara");
	    }

        console.log("precio_alfombra_original:  "+precio_alfombra_original);
		*/
		
	    //informacion_extra_desperdicio='SD'; // Sin desperdicio, corte a medida
	    informacion_extra_desperdicio=''; // Sin desperdicio, corte a medida
	    if(precio_alfombra_final_2 < precio_alfombra_final && precio_alfombra_final_2!=0){
		    precio_alfombra_final=precio_alfombra_final_2;
		    precio_alfombra_original=precio_alfombra_original_2;
		    //informacion_extra_desperdicio='CD'; // Con desperdicio, corte a partir de rollos
	    }
		// Fin seleccion precio más barato, marcaremos;

		// 2025-02-05 Ponemos los portes extra a 0
		precio_extra_neto_dimensiones_alfombra=0;
		precio_extra_bruto_dimensiones_alfombra=0;
		/*
		//precio_extra_neto_dimensiones_alfombra=50;
		//precio_extra_bruto_dimensiones_alfombra=50;
		precio_extra_neto_dimensiones_alfombra=25;
		precio_extra_bruto_dimensiones_alfombra=25;

        if (p_ancho>=3 && p_alto>=3){
        	// Si las dimensiones exceden de 3 metros (incluidos)
			precio_extra_neto_dimensiones_alfombra=50;
			precio_extra_bruto_dimensiones_alfombra=50;
	        console.log("sumar 50 a " +precio_alfombra_final);
	        //precio_alfombra_final+=precio_extra_neto_dimensiones_alfombra;
	        //precio_alfombra_original+=precio_extra_bruto_dimensiones_alfombra;
        }
        */
		//Si tiene descuento hay que añadir el porcentaje para que el extra siempre quede en 50 euros netos
		if (metodo_descuento==1){
            precio_extra_bruto_dimensiones_alfombra=precio_extra_neto_dimensiones_alfombra*100/(100 - valor_descuento);
		}

        precio_alfombra_final+=precio_extra_neto_dimensiones_alfombra;
        precio_alfombra_original+=precio_extra_bruto_dimensiones_alfombra;

        console.log("precio final ( "+p_ancho+" x "+p_alto+" "+informacion_extra_desperdicio+"): "+precio_alfombra_final.toFixed(2));
        console.log("precio final ( "+p_ancho+" x "+p_alto+" "+informacion_extra_desperdicio+"): "+precio_alfombra_final);

		/*
	    alert(	'Precio final a medida: '+precio_alfombra_final_a_medida+'\n'+
	    		'Precio final a rollo ('+p_ancho+" x "+p_alto+'): '+precio_alfombra_final_rollo.toFixed(2)+'\n'+
	    		'Precio final a rollo ('+p_alto+" x "+p_ancho+'): '+precio_alfombra_final_rollo_2.toFixed(2));
		*/
		$("#total-current-price").html(parseFloat(precio_alfombra_final*unidades).toFixed(2).replace('.', ',')+" €");
		$("#total-regular-price").html(parseFloat(precio_alfombra_original*unidades).toFixed(2).replace('.', ',')+" €");
	   
		if ($("#ficha-total-price").length) {
			$("#ficha-total-price").html($("#total-current-price").html());
		}
		if ($("#ficha-total-price-base").length) {
			$("#ficha-total-price-base").html($("#total-regular-price").html());
		}
	    $("#precio_unitario_final").val(parseFloat(precio_alfombra_final).toFixed(2));
	    $("#precio_unitario_final_sin_desc").val(parseFloat(precio_alfombra_original).toFixed(2));

	    $("#informacion_extra_desperdicio").val(informacion_extra_desperdicio);
	}	
  }
-->
</script>

