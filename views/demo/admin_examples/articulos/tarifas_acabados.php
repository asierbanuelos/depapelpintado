<!doctype html>
<html lang="es" class="no-js">
<head>
	<meta charset="utf-8">
	<title>Tarifas Acabados Alfombras</title>
	<meta name="description" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <style>
    .container{max-width: 1400px;}
    h1{text-align:center;background-color: #fff;margin:0;padding:20px 0;}
    table thead th,table tbody td{text-align:center;}
    table th, table td {padding: 8px;text-align: left;vertical-align: middle;border: 1px solid #ccc;}
    .tabla-tarifas {width:100%;border-collapse:collapse;margin-bottom:20px;}
    .tabla-tarifas thead th {background-color:#333;color:#fff;padding:10px;}
    .tabla-tarifas tbody tr:nth-child(even) {background-color:#f9f9f9;}
    .tabla-tarifas tbody tr:hover {background-color:#f0f0f0;}
    input[type="text"], input[type="number"]{margin:0;text-align:right;width:90px;padding:4px;}
    input[type="text"].input-nombre{text-align:left;width:180px;}
    input[type="text"].input-imagen{text-align:left;width:250px;}
    .btn-guardar{background-color:#4CAF50;color:white;padding:12px 30px;border:none;cursor:pointer;font-size:16px;border-radius:4px;margin:20px 0;}
    .btn-guardar:hover{background-color:#45a049;}
    .btn-anadir{background-color:#2196F3;color:white;padding:8px 20px;border:none;cursor:pointer;font-size:14px;border-radius:4px;margin:10px 0;}
    .btn-anadir:hover{background-color:#1976D2;}
    .btn-eliminar{background-color:#f44336;color:white;padding:4px 10px;border:none;cursor:pointer;font-size:12px;border-radius:3px;}
    .btn-eliminar:hover{background-color:#d32f2f;}
    .selector-marca{padding:10px;font-size:16px;margin:10px 0;}
    .msg-ok{background-color:#dff0d8;color:#3c763d;padding:15px;border-radius:4px;margin:10px 0;}
    img.preview-acabado{max-height:40px;max-width:60px;}
  </style>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class='container'>

    <?php if (isset($mensaje)) { ?>
      <div class="msg-ok"><?php echo $mensaje; ?></div>
    <?php } ?>

    <h1>Tarifas de Acabados - Alfombras</h1>

    <form method="get" action="/admin_library/tarifas_acabados">
      <label>Selecciona marca: </label>
      <select name="marca" class="selector-marca" onchange="this.form.submit()">
        <?php foreach ($marcas_alfombras as $m) { ?>
          <option value="<?php echo $m->cat_id; ?>" <?php if($marca_seleccionada == $m->cat_id) echo 'selected'; ?>>
            <?php echo $m->cat_name; ?>
          </option>
        <?php } ?>
      </select>
    </form>

    <?php echo form_open('admin_library/update_tarifas_acabados'); ?>
    <input type="hidden" name="marca_id" value="<?php echo $marca_seleccionada; ?>" />

    <table class="tabla-tarifas">
      <thead>
        <tr>
          <th>Orden</th>
          <th>Imagen</th>
          <th>Nombre acabado</th>
          <th>Precio m/lineal</th>
          <th>Precio m/lineal largo</th>
          <th>Precio m2</th>
          <th>Opciones (grupo)</th>
          <th>Texto opciones</th>
          <th>Ruta imagen</th>
          <th>Activo</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (!empty($acabados)) {
          foreach ($acabados as $a) { ?>
          <tr>
            <td><input type="number" name="acabados[<?php echo $a->id; ?>][orden]" value="<?php echo $a->orden; ?>" style="width:50px;" /></td>
            <td>
              <?php if ($a->imagen) { ?>
                <img src="<?php echo $a->imagen; ?>" class="preview-acabado" />
              <?php } ?>
            </td>
            <td><input type="text" class="input-nombre" name="acabados[<?php echo $a->id; ?>][nombre_acabado]" value="<?php echo htmlspecialchars($a->nombre_acabado); ?>" /></td>
            <td><input type="text" name="acabados[<?php echo $a->id; ?>][precio_m_lineal]" value="<?php echo $a->precio_m_lineal; ?>" /></td>
            <td><input type="text" name="acabados[<?php echo $a->id; ?>][precio_m_lineal_largo]" value="<?php echo $a->precio_m_lineal_largo; ?>" /></td>
            <td><input type="text" name="acabados[<?php echo $a->id; ?>][precio_m2]" value="<?php echo $a->precio_m2; ?>" /></td>
            <td><input type="text" name="acabados[<?php echo $a->id; ?>][opciones]" value="<?php echo htmlspecialchars($a->opciones); ?>" style="width:120px;" /></td>
            <td><input type="text" name="acabados[<?php echo $a->id; ?>][txt_opciones]" value="<?php echo htmlspecialchars($a->txt_opciones); ?>" style="width:160px;" /></td>
            <td><input type="text" class="input-imagen" name="acabados[<?php echo $a->id; ?>][imagen]" value="<?php echo htmlspecialchars($a->imagen); ?>" /></td>
            <td><input type="checkbox" name="acabados[<?php echo $a->id; ?>][activo]" value="1" <?php if($a->activo) echo 'checked'; ?> /></td>
            <td><input type="submit" name="eliminar[<?php echo $a->id; ?>]" value="X" class="btn-eliminar" onclick="return confirm('Eliminar este acabado?');" /></td>
          </tr>
        <?php }
        } else { ?>
          <tr><td colspan="11">No hay acabados para esta marca. Usa el boton de abajo para anadir.</td></tr>
        <?php } ?>
      </tbody>
    </table>

    <button type="submit" name="guardar" value="1" class="btn-guardar">Guardar cambios</button>
    <?php echo form_close(); ?>

    <hr />
    <?php echo form_open('admin_library/add_tarifa_acabado'); ?>
    <input type="hidden" name="marca_id" value="<?php echo $marca_seleccionada; ?>" />
    <h3>Anadir nuevo acabado</h3>
    <table>
      <tr>
        <td>Nombre: <input type="text" name="nombre_acabado" value="" class="input-nombre" required /></td>
        <td>Precio m/lineal: <input type="text" name="precio_m_lineal" value="0" /></td>
        <td>Precio m2: <input type="text" name="precio_m2" value="0" /></td>
        <td>Imagen: <input type="text" name="imagen" value="" class="input-imagen" /></td>
        <td><button type="submit" class="btn-anadir">Anadir</button></td>
      </tr>
    </table>
    <?php echo form_close(); ?>

  </div>
</body>
</html>
