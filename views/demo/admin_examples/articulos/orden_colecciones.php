<!doctype html>
<html lang="es" class="no-js">
<head>
	<meta charset="utf-8">
	<title>Orden de Colecciones</title>
	<meta name="description" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
	<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>
<body>
  <style>
    .container{max-width: 1200px;}
    h1{text-align:center;background-color: #fff;margin:0;padding:20px 0;}
    .selector-marca{padding:10px;font-size:16px;margin:10px 0;}
    .msg-ok{background-color:#dff0d8;color:#3c763d;padding:15px;border-radius:4px;margin:10px 0;}
    .tabla-orden{width:100%;border-collapse:collapse;margin-bottom:20px;}
    .tabla-orden thead th{background-color:#333;color:#fff;padding:10px;text-align:left;}
    .tabla-orden tbody tr{cursor:grab;border-bottom:1px solid #ddd;transition:background-color 0.2s;}
    .tabla-orden tbody tr:nth-child(even){background-color:#f9f9f9;}
    .tabla-orden tbody tr:hover{background-color:#e8e8e8;}
    .tabla-orden tbody tr.sortable-chosen{background-color:#fff3cd;cursor:grabbing;}
    .tabla-orden tbody tr.sortable-ghost{opacity:0.4;}
    .tabla-orden td{padding:10px 12px;vertical-align:middle;}
    .tabla-orden td img{max-height:40px;max-width:60px;margin-right:10px;vertical-align:middle;}
    .drag-handle{color:#999;font-size:20px;margin-right:8px;cursor:grab;}
    .num-orden{display:inline-block;background:#eee;border-radius:50%;width:28px;height:28px;line-height:28px;text-align:center;font-weight:bold;font-size:13px;color:#555;}
    .btn-guardar{background-color:#4CAF50;color:white;padding:12px 30px;border:none;cursor:pointer;font-size:16px;border-radius:4px;margin:20px 0;}
    .btn-guardar:hover{background-color:#45a049;}
    .info-box{background-color:#d9edf7;color:#31708f;padding:15px;border-radius:4px;margin:10px 0;}
    .nombre-marca{font-weight:bold;font-size:18px;margin:15px 0;}
  </style>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class='container'>

    <?php if (isset($mensaje)) { ?>
      <div class="msg-ok"><?php echo $mensaje; ?></div>
    <?php } ?>

    <h1>Orden de Colecciones por Marca</h1>

    <div class="info-box">
      Arrastra las filas para reordenar las colecciones. Pulsa "Guardar orden" cuando termines.
    </div>

    <form method="get" action="/admin_library/orden_colecciones">
      <label>Selecciona marca: </label>
      <select name="marca" class="selector-marca" onchange="this.form.submit()">
        <?php foreach ($marcas as $m) { ?>
          <option value="<?php echo $m->cat_id; ?>" <?php if($marca_seleccionada == $m->cat_id) echo 'selected'; ?>>
            <?php echo $m->cat_name; ?> (<?php echo $m->total_colecciones; ?> colecciones)
          </option>
        <?php } ?>
      </select>
    </form>

    <?php if (!empty($colecciones)) { ?>

    <p class="nombre-marca"><?php echo $nombre_marca; ?> - <?php echo count($colecciones); ?> colecciones</p>

    <?php echo form_open('admin_library/update_orden_colecciones'); ?>
    <input type="hidden" name="marca_id" value="<?php echo $marca_seleccionada; ?>" />

    <table class="tabla-orden">
      <thead>
        <tr>
          <th style="width:50px;"></th>
          <th style="width:50px;">#</th>
          <th>Imagen</th>
          <th>Coleccion</th>
          <th>Productos activos</th>
        </tr>
      </thead>
      <tbody id="sortable-body">
        <?php $pos = 1; foreach ($colecciones as $col) { ?>
        <tr data-id="<?php echo $col->coleccion_id; ?>">
          <td><span class="drag-handle">&#9776;</span></td>
          <td><span class="num-orden"><?php echo $pos; ?></span></td>
          <td>
            <?php if ($col->col_img) { ?>
              <img src="/includes/<?php echo str_replace('../', '', $col->col_img); ?>th.jpg" alt="<?php echo $col->coleccion_name; ?>" />
            <?php } ?>
          </td>
          <td><?php echo $col->coleccion_name; ?></td>
          <td><?php echo $col->total_items; ?></td>
          <input type="hidden" class="orden-input" name="orden[<?php echo $col->coleccion_id; ?>]" value="<?php echo $pos; ?>" />
        </tr>
        <?php $pos++; } ?>
      </tbody>
    </table>

    <button type="submit" class="btn-guardar">Guardar orden</button>
    <?php echo form_close(); ?>

    <?php } else { ?>
      <p>No hay colecciones activas para esta marca.</p>
    <?php } ?>

  </div>

  <script>
  var sortable = new Sortable(document.getElementById('sortable-body'), {
    handle: '.drag-handle',
    animation: 150,
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    onEnd: function() {
      // Actualizar numeros de orden despues de arrastrar
      var rows = document.querySelectorAll('#sortable-body tr');
      rows.forEach(function(row, index) {
        row.querySelector('.num-orden').textContent = index + 1;
        row.querySelector('.orden-input').value = index + 1;
      });
    }
  });
  </script>
</body>
</html>
