<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Estilos</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>

<body>
  <style>
    .container{max-width: none;}
    h1{text-align:center;background-color: #fff;margin:0;padding:20px 0;}
    table thead th,table tbody td{text-align:center;}
    table tbody th {font-weight: bold;background-color: #e1e1e1;color: #333;}
    table th, table td {padding: 8px;text-align: left;vertical-align: top;border: 1px solid #666;}
    .bakoitia {background-color: #eee;}
    .bikoitia {background-color: #fff;}
    
    input[type="text"]{margin:0;text-align: right;}

    </style>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class='container'>
    <?php
    /*
    print '<pre><xmp>';
    print_r($a_precios);
    print '</xmp></pre>';

    */
    echo form_open('admin_library/update_precios_santos_monteiro');
    $a_zatiak=array_chunk($a_acabados, 10, true);
    if ($opcion=='m_cuadrado'){
      $campo_precio='precio_m_cuadrado';
      echo "<h1>Precios de Santos Monteiro por metro cuadrado cuando ancho<br>NO coincide con el rollo</h1>";
    }
    else{
      $campo_precio='precio_m_cuadrado_exacto';
      echo "<h1>Precios de Santos Monteiro por metro cuadrado cuando ancho<br>COINCIDE con el rollo</h1>";
    }
    echo " <input type='hidden' name='campo_precio' value='$campo_precio' />";
    echo " <input type='hidden' name='opcion' value='$opcion' />";
    foreach ($a_zatiak as $a_acabados_aux) {
    ?>
      <table>
        <thead>
          <tr>
            <th></th>
            <?php 
              foreach ($a_acabados_aux as $idacabado => $txt) {
                echo "<th>$txt</th>";
              }
            ?>
          </tr>
        </thead>
        <tbody>
            <?php 
              $par=true;
              $clase=array('bakoitia','bikoitia');
              foreach ($a_colecciones as $idcol => $txt) {
                $par = !$par;
                echo "<tr class='{$clase[$par]}'>";
                echo "<th>$txt</th>";
                foreach ($a_acabados_aux as $idacabado => $txt) {
                  echo "<td>";
                  if (isset($a_precios[$idcol][$idacabado])){
                    foreach ($a_precios[$idcol][$idacabado] as $idprecio => $datos) {
                      $precio=$datos[$campo_precio];
                      echo "<input type='text' name='a_precios[$idcol][$idacabado][$idprecio][$campo_precio]' value='$precio' size='5' />";
                      //echo "<input type='text' name='a_precios[$idcol][$idacabado][$idprecio][precio_m_cuadrado]' value='$m_cuadrado' size='3' /> m&sup2;";
                      //echo "<input type='text' name='a_precios[$idcol][$idacabado][$idprecio][precio_m_cuadrado_exacto]' value='$m_exacto' size='2' />m rollo";
                    }
                  }
                  else{
                    echo "<input type='text' name='a_precios[$idcol][$idacabado][0][$campo_precio]' value='0' size='5' />";
                    //echo "<input type='text' name='a_precios[$idcol][$idacabado][0][precio_m_cuadrado]' value='0' size='3' /> m&sup2;";
                    //echo "<input type='text' name='a_precios[$idcol][$idacabado][0][precio_m_cuadrado]' value='0' size='2' />m rollo";
                  }
                  if (isset($a_agrupados[$idacabado])){
                    foreach ($a_agrupados[$idacabado] as $id_acabado_aux) {
                      if (isset($a_precios[$idcol][$id_acabado_aux])){
                        foreach ($a_precios[$idcol][$id_acabado_aux] as $idprecio => $datos) {
                          $precio=$datos[$campo_precio];
                          echo "<input type='hidden' name='a_agrupado[$idacabado][$idcol][$id_acabado_aux][$idprecio][$campo_precio]' value='$precio' />";
                        }
                      }
                      else{
                        echo "<input type='hidden' name='a_agrupado[$idacabado][$idcol][$id_acabado_aux][0][$campo_precio]' value='0'/>";
                      }

                    }
                  }

                  echo "</td>";
                }
                echo "</tr>";
              }
            ?>
        </tbody>
      </table>
      <br>
    <?php 
    }
    ?>
    <div style="text-align:center;padding:20px 0;">
      <?php 
      echo form_submit("test", "Actualizar precios",'class="button orange-button twelve t-full m-full send"');
      echo form_close();
      ?>
    </div>
  </div>
  <?php 
  $this->load->view('includes/scripts'); 
  ?> 
</body>
</html>