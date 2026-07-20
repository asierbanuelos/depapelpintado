<div id="bs-canvas-right" class="bs-canvas bs-canvas-anim bs-canvas-right position-fixed bg-light h-100">
  <header class="bs-canvas-header px-3 py-2 overflow-auto" style="background:#333;">
    <button type="button" class="bs-canvas-close float-left close" aria-label="Close"><span aria-hidden="true" class="text-light">&times;</span></button>
    <span class="d-inline-block text-light mb-0" style="font-family:'Poppins',sans-serif;font-size:13px;letter-spacing:2px;text-transform:uppercase;font-weight:400;">Filtrar</span>
  </header>

  <div class="columna-filtros bs-canvas-content px-3 py-3" style="overflow-y:auto;height:calc(100% - 52px);">
    <?php $this->load->view('frontend/cuerposeccion-filtros', $this->data); ?>
  </div>
</div>
