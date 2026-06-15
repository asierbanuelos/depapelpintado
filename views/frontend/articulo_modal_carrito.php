<?php 
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
$title_modal_th='';
if (isset($key['imgdettitle'])){
  $title_modal=$key['imgdettitle'];
  $title_modal_th=$key['imgdettitle'].' - th';
}

$alt_modal='';
$alt_modal_th='';
if (isset($key['imgdetalt'])){
  $alt_modal=$key['imgdetalt'];
  $alt_modal_th=$key['imgdetalt'].' - th';
}

$img_modal_th='';
$img_modal_full_size='';
if (trim($img_modal)!=''){
  $img_modal_th=$img_modal.'th.jpg';
  $img_modal_full_size=$img_modal.'med.jpg';
}
/*
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#carritoModal">
  Launch demo modal
</button>
*/
?>

<div class="modal fade" id="carritoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title h6" id="exampleModalLongTitle">Producto agregado a su carrito de compras</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body">
        <div class="row">
          <div class="col-sm-5 col-xs-12">
            <img id='imagen-modal' src="<?php echo $img_modal_th;?>" data-full-size-image-url="<?php echo $img_modal_full_size;?>" title="<?php echo $title_modal_th; ?>" alt="<?php echo $alt_modal_th; ?>" loading="lazy" class="product-image">
          </div>
          <div class="col-sm-7 col-xs-12">
            <h3 class="h6 product-name" id='nombre-prod-modal'><?php echo $nom_prod_modal; ?></h3>
            <p class="product-price"><span id='precio-unitario-modal'></span> €</p>
            <span class="product-quantity">Cantidad: <strong><span id='cantidad-modal'></span></strong></span>
          </div>
        </div>
      </div>


      <div class="modal-footer">
        <button type="button" class="boton-opciones" data-dismiss="modal">Seguir comprando</button>
        <a href="/tienda/carrito" type="button" class="boton-opciones" >Ir al carrito</a>
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