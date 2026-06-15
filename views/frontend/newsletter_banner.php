<div class="">
  <div class='row bg-newsletter text-white mt-4 py-4'>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-sp-12 align-items-center text-center">
      <div class="title-newsletter mb-4">
        <h3 class="title_block">Newsletter</h3>
        <?php
        /*
        <p class="sub-letter">Suscríbete para estar al día de todas las novedades y ofertas</p>
        */
        ?>
        <p class="sub-letter">Suscríbete y tendrás un cupón de descuento en tu próxima compra</p>
      </div>
      <div class="block_content">
        <form id='newsletter' action="/" method="post">
          <input id="email_newsletter" type="text" name="email_newsletter" placeholder="Tu correo electrónico"/><button id="submitNewsletter" name="submitNewsletter" type="submit" value="Suscribir" aria-label="Suscribir"><span>SUSCRIBIR</span></button>
        </form>
      </div>
      </div>
    </div>
  </div>  
<?php 
if (isset($notificacion_modal) && $notificacion_modal=='ok') 
  $this->load->view('frontend/notificacion_modal', $this->data);
?>
