<?php
$nombres_tipo = array(0=>'Papel Pintado',1=>'Murales',2=>'Revestimientos',3=>'Telas',4=>'Alfombras',5=>'Herramientas',6=>'Complementos');
?>
<!doctype html>
<html lang="es" class="no-js">
<head>
	<meta charset="utf-8">
	<title>Textos SEO — Categorías</title>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <div style="height:20px"></div>
    <div style="font-size:34px;font-weight:300;color:#B05380;text-align:center;border-bottom:1px solid #B05380;">Textos SEO de las Categorías</div>
    <div style="height:20px"></div>

    <table style="width:100%;border-collapse:collapse;">
      <tr style="background:#f3eeea;text-align:left;">
        <th style="padding:10px;">Categoría</th>
        <th style="padding:10px;">Intro corta</th>
        <th style="padding:10px;">Descripción</th>
        <th style="padding:10px;width:110px;"></th>
      </tr>
      <?php foreach ($tipos as $t):
        $nom = isset($nombres_tipo[(int)$t->tipo_producto_id]) ? $nombres_tipo[(int)$t->tipo_producto_id] : ('Tipo '.$t->tipo_producto_id);
        $palabras = str_word_count(strip_tags($t->descripcion_tipo_producto));
      ?>
      <tr style="border-bottom:1px dotted #ccc;">
        <td style="padding:10px;"><strong><?php echo htmlspecialchars($nom); ?></strong></td>
        <td style="padding:10px;"><?php echo trim($t->intro_tipo_producto)!='' ? '<span style="color:green;">✔ puesta</span>' : '<span style="color:#c00;">— vacía</span>'; ?></td>
        <td style="padding:10px;"><?php echo $palabras>0 ? $palabras.' palabras' : '<span style="color:#c00;">— vacía</span>'; ?></td>
        <td style="padding:10px;">
          <a href="/admin_library/editar_tipo_producto_seo/<?php echo (int)$t->tipo_producto_id; ?>" style="display:inline-block;background:#B05380;color:#fff;text-decoration:none;padding:6px 16px;border-radius:4px;">Editar</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>
    <div style="height:50px"></div>
  </div>
</body>
</html>
