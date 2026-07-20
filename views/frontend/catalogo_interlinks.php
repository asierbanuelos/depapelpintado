<?php if (!empty($interlinks)):
  // Filtrar grupos sin enlaces
  $grupos_validos = array();
  foreach ($interlinks as $g) { if (!empty($g['enlaces'])) $grupos_validos[] = $g; }
  if (!empty($grupos_validos)):
?>
<nav class="catalogo-interlinks" aria-label="Explora más del catálogo">
  <div class="container">
    <h2 class="interlinks-titulo"><?php echo isset($interlinks_titulo) ? htmlspecialchars($interlinks_titulo) : 'Explora más'; ?></h2>
    <div class="interlinks-grupos">
      <?php foreach ($grupos_validos as $grupo): ?>
        <div class="interlinks-grupo">
          <h3 class="interlinks-grupo-titulo"><?php echo htmlspecialchars($grupo['titulo']); ?></h3>
          <ul class="interlinks-lista">
            <?php foreach ($grupo['enlaces'] as $e): ?>
              <li><a href="<?php echo $e['url']; ?>"><?php echo htmlspecialchars($e['texto']); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</nav>
<style>
.catalogo-interlinks { background: #faf8f6; border-top: 1px solid #ece6e2; padding: 44px 0 52px; }
.catalogo-interlinks .interlinks-titulo {
  font-family: 'MoonCreme', Georgia, serif; font-size: 24px; font-weight: 400;
  color: #2e2a2c; text-align: center; margin: 0 0 30px;
}
.catalogo-interlinks .interlinks-grupos {
  display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 30px; max-width: 1100px; margin: 0 auto;
}
.catalogo-interlinks .interlinks-grupo-titulo {
  font-family: 'Poppins', sans-serif; font-size: 12px; font-weight: 600;
  letter-spacing: 2px; text-transform: uppercase; color: #9c637f;
  border-bottom: 1px solid #e8e0da; padding-bottom: 9px; margin: 0 0 13px;
}
.catalogo-interlinks .interlinks-lista { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 7px; }
.catalogo-interlinks .interlinks-lista a {
  font-family: 'Poppins', sans-serif; font-size: 14px; color: #555;
  text-decoration: none; transition: color 0.15s; line-height: 1.4;
}
.catalogo-interlinks .interlinks-lista a:hover { color: #BB8AA3; }
@media (max-width: 575px) { .catalogo-interlinks { padding: 32px 0 38px; } .catalogo-interlinks .interlinks-grupos { gap: 22px; } }
</style>
<?php endif; endif; ?>
