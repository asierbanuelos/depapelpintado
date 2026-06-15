<div id="menu_usuario_movil" class="d-inline-flex mr-2">
  <a class="ver-submenu" href="/tienda/mi_cuenta" id="miCuentaDropdown" role="button" aria-haspopup="true" aria-expanded="false">
    <span class="precio-minicarro sombra cartdisplay">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="18" width="18" >
        <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/>
      </svg>
    </span>
  </a>
  <div class="dropdown-usuario" id='capa-usuario_movil'>
    <ul class="">
      <?php
      if ($usuario->user_id<=1){
      ?>
        <li>
            <a href="/tienda/mi_cuenta" class="">Iniciar sesión</a>
        </li>
        <li>
            <a href="/tienda/mi_cuenta/nueva" class="">Registrarse</a>
        </li>
      <?php
      }
      else{
      ?>
        <li><?=anchor("tienda/mi_cuenta","Mis datos",'class=""');?></li>
        <li><?=anchor("tienda/mis_pedidos","Mis Pedidos",'class=""');?></li>
        <li><?=anchor("tienda/clave","Cambiar Contraseña",'class=""');?></li>
        <li><?=anchor("tienda/logout","Cerrar Sesión",'class=""');?></li>
      <?php
      }
      ?>
    </ul>
  </div>
</div>
