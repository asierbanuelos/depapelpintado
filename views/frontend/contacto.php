<div class="pagina-info wrapper">
  <div class="container">
    <h1 class="gris-34-300 text-center mb-4 pb-4">Contacto</h1>     
    <div class="row">
		</div>
	</div>
</div>

<div class="pagina-info wrapper">
  <div class="container" id="contact-form-box">
    <div class="row">
      <div id="left-column" class="col-xs-12 col-sm-4 col-md-4">
          <?php
          /*
          <span class="contact-text-1">PUEDES</span>
          */
          ?>
          <h2 class="contact-text-2 h5">CONTÁCTANOS DIRECTAMENTE</h2>
          <p class="contact-text-3">
            <?php 
            $this->load->view('frontend/horarios'); 
            ?>
          </p>
          <div class="contact-icons">
            <p>
              <span><a href="tel:+34692910240"><i class="fa fa-phone" aria-hidden="true"></i>692 91 02 40</a></span><br />
              <span><a href="mailto:info@depapelpintado.es"><i class="fa fa-envelope" aria-hidden="true"></i>info@depapelpintado.es</a></span>
            </p>
          </div>

          <div class="mapouter">
            <div class="gmap_canvas">
              <iframe width="450" height="380" id="gmap_canvas" src="https://maps.google.com/maps?q=Ekam&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            </div>
          </div>
      </div>

      <div id="content-wrapper" class=" left-column col-xs-12 col-sm-12 col-md-8 col-lg-8 contact-form">
        <section class="">
          <h2 class="contact-text-2 h5">DÉJANOS UN MENSAJE</h2>
          <span class="contact-subtitle">Te contestaremos con la mayor brevedad posible</span>
          <form action="/contacto" method="post" id='kontaktu-formularioa'>
            <section class="form-fields mt-4">
              <div class='row'>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-12 form-control-label" for="i-name">Nombre</label>
                    <div class="col-md-12">
                      <input type="text" name="i-name" id="i-name" class="form-control" required="">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-12 form-control-label" for="i-ape">Apellido</label>
                    <div class="col-md-12">
                    <input type="text" name="i-ape" id="i-ape" class="form-control" required="">
                    </div>
                  </div>
                </div>
              </div>

              <div class='row'>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-12 form-control-label" for="i-email">Correo</label>
                    <div class="col-md-12">
                      <input type="email" name="i-email" id="i-email" class="form-control" required="">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-md-12 form-control-label" for="i-tel">Teléfono (opcional)</label>
                    <div class="col-md-12">
                      <input type="tel" name="i-tel" id="i-tel" class="form-control">
                    </div>
                  </div>
                </div>
              </div>

              <div class='row'>
                <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-md-12 form-control-label" for="i-message">Mensaje</label>
                    <div class="col-md-12">
                      <textarea id="message" class="form-control" name="message" placeholder="¿Cómo podemos ayudar?" rows="5"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class='row'>
                <div class="col-12">
                  <p>
                    <input name="auth" type="checkbox" value="si"/> He leido y ACEPTO recibir publicidad o información promocional de depapelpintado.es
                  </p>
                  <?php
                  /*
                  <h4>Protección de datos</h4>
                  */
                  ?>
                  <p>
                    <small>Ver <?=anchor("aviso-legal-formulario",'Cláusula protección de datos');?></small>
                  </p>

                  <input class="boton-opciones" type="submit" name="submitMessage" value="Enviar">
                </div>
              </div>
            </section>
          </form>
        </section>
      </div>
    </div>
  </div>
</div>

