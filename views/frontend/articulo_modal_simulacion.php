<?php 
/*
$nom_prod_modal='';
if (isset($key['cat_name']) && $key['item_tipo']!=5)
  $nom_prod_modal=$key['cat_name'];
elseif (isset($key['item_name']))
  $nom_prod_modal=$key['item_name'];

if (isset($key['coleccion_name']) && $key['item_tipo']!=5)
  $nom_prod_modal.=' - '.$key['coleccion_name'];

if (isset($key['item_ref']))
  $nom_prod_modal.=' - '.$key['item_ref'];

$title_modal='';
if (isset($key['imgdettitle']))
  $title_modal=$key['imgdettitle'];

$alt_modal='';
if (isset($key['imgdetalt']))
  $alt_modal=$key['imgdetalt'];
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#carritoModal">
  Launch demo modal
</button>
*/
?>

<div class="modal fade" id="visualizacionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style='width: 200px;'>
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title h6" id="exampleModalLongTitle">Vista previa</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body p-0">
        <div class="m-2 fondo-visualizacion" style='background-size: cover;'>
          <img id='imagen-modal' src="<?php echo $img_modal;?>" title="vista previa" alt="vista previa" loading="lazy" class="product-image p-4">
        </div>
      </div>

      <div class="text-center p-2">
        <button type="button" class="boton-opciones m-0" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<?php
/*

  <div class="modal-body">
    <div class="row">
      <div class="col-xs-12 divide-right">
        <div class="row">
          <div class="col-sm-5 col-xs-12">
                              <img src="https://presta.depapelpintado.es/177754-small_default/Cola-VD-50g.jpg" data-full-size-image-url="https://presta.depapelpintado.es/177754-large_default/Cola-VD-50g.jpg" title="" alt="" loading="lazy" class="product-image">
                          </div>
          <div class="col-sm-7 col-xs-12">
            <h6 class="h6 product-name">Cola VD 50g</h6>
            <p class="product-price">4,90&nbsp;€</p>
            
                            <span class="product-quantity">Cantidad:&nbsp;<strong>4</strong></span>
          </div>
        </div>
      </div>
      <div class="col-xs-12">
        <div class="cart-content">
                          <p class="cart-products-count">Hay 5 artículos en su carrito.</p>
                        <p><span class="label">Total parcial:</span>&nbsp;<span class="subtotal value">30,62&nbsp;€</span></p>
                          <p><span>Transporte:</span>&nbsp;<span class="shipping value">Gratis </span></p>
          
                          <p class="product-total"><span class="label">Total&nbsp;(impuestos inc.)</span>&nbsp;<span class="value">30,62&nbsp;€</span></p>
          
                        
          <div class="cart-content-btn">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Seguir comprando</button>
            <a href="//presta.depapelpintado.es/carrito?action=show" class="btn btn-primary"><i class="material-icons rtl-no-flip"></i>Pasar por la caja</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
*/
?>