<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <title>Artículos</title>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <?php $this->load->view('includes/admin_head'); ?>
  </head>
  <body>
    <?php
     $this->load->view('includes/demo_header');
    ?>
    <div class="container">
      <div style="height: 20px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">Configuración PayPal</div>
      <?= form_open('admin_library/paypal');?>
      <br><span style="width:200px; display:inline-block">Usuario</span><?= form_input('usr',$pago->user)?>
      <br><span style="width:200px; display:inline-block">Password</span><?= form_input('pass',$pago->pass)?>
      <br><span style="width:200px; display:inline-block">Token</span><?= form_input('token',$pago->token)?>
      <br><span style="width:200px; display:inline-block">Modo </span><?= form_dropdown('test', array('REAL','PRUEBAS'),$pago->test)?>
      
      <br><span style="width:200px; display:inline-block">IP Pruebas</span><?= form_input('test_ip',$pago->test_ip)?>
      <br><?= form_submit('send', "Actualizar",'class="button orange-button twelve m-full send"');?>
      <?= form_close()?>
      <div style="height: 20px"></div>
    </div>
</body>
</html>
