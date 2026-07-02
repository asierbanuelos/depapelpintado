<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
  <meta charset="utf-8">
  <title>Redirecciones 301</title>
  <meta name="description" content=""/>
  <?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <div style="height:20px"></div>
    <div style="font-size:40px;font-weight:300;color:#B05380;text-align:center;border-bottom:1px solid #B05380;">REDIRECCIONES 301</div>
    <div style="height:20px"></div>

    <?php if ($this->session->flashdata('msg')): ?>
    <div style="background:#dff0d8;border:1px solid #d6e9c6;color:#3c763d;padding:10px 16px;margin-bottom:16px;border-radius:4px">
      <?= $this->session->flashdata('msg') ?>
    </div>
    <?php endif; ?>

    <!-- Añadir redirección individual -->
    <?= form_open('admin_library/add_redirect') ?>
    <div style="background:#f9f9f9;padding:14px;border-radius:6px;margin-bottom:20px;border:1px solid #e0e0e0">
      <div style="font-weight:bold;margin-bottom:10px;font-size:16px">Añadir redirección</div>
      <div class="sec row">
        <div class="col two t-six m-six" style="padding-top:6px">URL origen (desde):</div>
        <div class="col four t-six m-six"><?= form_input('url_from', '', 'placeholder="/url-antigua" class="twelve"') ?></div>
      </div>
      <div class="sec row">
        <div class="col two t-six m-six" style="padding-top:6px">URL destino (hacia):</div>
        <div class="col four t-six m-six"><?= form_input('url_to', '', 'placeholder="/url-nueva" class="twelve"') ?></div>
      </div>
      <div class="sec row">
        <div class="col two t-six m-six" style="padding-top:6px">Notas (opcional):</div>
        <div class="col four t-six m-six"><?= form_input('notas', '', 'placeholder="Descripción del cambio" class="twelve"') ?></div>
      </div>
      <div class="sec row">
        <?= form_submit('submit', 'Añadir redirección', 'class="button orange-button"') ?>
      </div>
    </div>
    <?= form_close() ?>

    <!-- Importar en bloque -->
    <?= form_open('admin_library/import_redirects') ?>
    <div style="background:#f9f9f9;padding:14px;border-radius:6px;margin-bottom:28px;border:1px solid #e0e0e0">
      <div style="font-weight:bold;margin-bottom:6px;font-size:16px">Importar en bloque</div>
      <div style="color:#888;font-size:12px;margin-bottom:8px">Una por línea: <code>/url-antigua /url-nueva</code></div>
      <?= form_textarea('bulk_redirects', '', 'rows="5" placeholder="/papel-pintado-antigua /papel-pintado-nueva" class="twelve" style="font-family:monospace;font-size:12px"') ?>
      <div class="sec row" style="margin-top:8px">
        <?= form_submit('submit', 'Importar', 'class="button orange-button"') ?>
      </div>
    </div>
    <?= form_close() ?>

    <!-- Listado -->
    <div style="font-size:22px;font-weight:300;color:#B05380;margin-bottom:10px">
      Redirecciones activas (<?= count($redirects) ?>)
    </div>
    <div style="overflow-x:auto">
      <table style="width:100%;border-collapse:collapse;font-size:13px">
        <thead>
          <tr style="background:#B05380;color:#fff">
            <th style="padding:8px 10px;text-align:left">Desde</th>
            <th style="padding:8px 10px;text-align:left">Hacia</th>
            <th style="padding:8px 10px;text-align:left">Notas</th>
            <th style="padding:8px 10px;text-align:center;white-space:nowrap">Hits</th>
            <th style="padding:8px 10px;text-align:center;white-space:nowrap">Fecha</th>
            <th style="padding:8px 10px;text-align:center">Acción</th>
          </tr>
        </thead>
        <tbody>
        <?php if (empty($redirects)): ?>
          <tr><td colspan="6" style="padding:16px;text-align:center;color:#999">No hay redirecciones configuradas</td></tr>
        <?php else: ?>
          <?php foreach ($redirects as $i => $r): ?>
          <tr class="redir-row" id="redir-<?= $r['id'] ?>" style="border-bottom:1px solid #ddd;background:<?= ($i % 2 === 0) ? '#fff' : '#f7f7f7' ?>">
            <td style="padding:8px 10px;font-family:monospace;font-size:12px;word-break:break-all"><?= htmlspecialchars($r['url_from']) ?></td>
            <td style="padding:8px 10px;font-family:monospace;font-size:12px;word-break:break-all"><?= htmlspecialchars($r['url_to']) ?></td>
            <td style="padding:8px 10px;color:#666"><?= htmlspecialchars($r['notas']) ?></td>
            <td style="padding:8px 10px;text-align:center;font-weight:bold"><?= intval($r['hits']) ?></td>
            <td style="padding:8px 10px;text-align:center;white-space:nowrap;color:#888;font-size:12px"><?= $r['created_at'] ?></td>
            <td style="padding:8px 10px;text-align:center">
              <span class="del-redir btn" data-id="<?= $r['id'] ?>" style="cursor:pointer">Del</span>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div style="height:40px"></div>
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script>
  $('.del-redir').click(function(){
    if (!confirm('¿Eliminar esta redirección?')) return;
    var id = $(this).data('id');
    var row = $('#redir-' + id);
    $.post('<?= site_url('admin_library/del_redirect') ?>', {id: id}, function(data){
      if (data == '1') row.fadeOut(300);
    });
  });
  </script>
</body>
</html>
