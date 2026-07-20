<?php
$il_slider = isset($interlinks_slider) && !empty($interlinks_slider) ? $interlinks_slider : array();
$il_chips  = isset($interlinks_chips)  && !empty($interlinks_chips)  ? $interlinks_chips  : array();
// filtrar grupos de chips vacios
$il_chips_v = array();
foreach ($il_chips as $g) { if (!empty($g['enlaces'])) $il_chips_v[] = $g; }
if (!empty($il_slider) || !empty($il_chips_v)):
?>
<section class="catalogo-interlinks" aria-label="Explora más del catálogo">
  <div class="container">
    <?php if (!empty($interlinks_titulo)): ?>
      <h2 class="il-h2"><?php echo $interlinks_titulo; // contiene <span class="il-kw"> ya saneado ?></h2>
    <?php endif; ?>
    <?php if (!empty($interlinks_sub)): ?>
      <p class="il-sub"><?php echo htmlspecialchars($interlinks_sub); ?></p>
    <?php endif; ?>

    <?php if (!empty($il_slider)): ?>
    <div class="il-slider-wrap">
      <button type="button" class="il-nav prev" onclick="ilSlide(this,-1)" aria-label="Anterior">&lsaquo;</button>
      <div class="il-slider">
        <?php foreach ($il_slider as $c): ?>
          <a class="il-card" href="<?php echo $c['url']; ?>" title="<?php echo htmlspecialchars($c['nombre']); ?>">
            <div class="il-thumb"><img src="<?php echo $c['img']; ?>" alt="<?php echo htmlspecialchars($c['nombre']); ?>" loading="lazy"></div>
            <div class="il-cap"><?php echo htmlspecialchars($c['nombre']); ?></div>
          </a>
        <?php endforeach; ?>
      </div>
      <button type="button" class="il-nav next" onclick="ilSlide(this,1)" aria-label="Siguiente">&rsaquo;</button>
    </div>
    <?php endif; ?>

    <?php foreach ($il_chips_v as $grupo): ?>
      <div class="il-chips-block">
        <?php if (!empty($grupo['label'])): ?><p class="il-chips-label"><?php echo htmlspecialchars($grupo['label']); ?></p><?php endif; ?>
        <div class="il-chips">
          <?php foreach ($grupo['enlaces'] as $e): ?>
            <a class="il-chip" href="<?php echo $e['url']; ?>"><?php echo htmlspecialchars($e['texto']); ?></a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<style>
.catalogo-interlinks { background:#faf8f6; border-top:1px solid #ece6e2; padding:44px 0 52px; }
.catalogo-interlinks .il-h2 { font-family:'MoonCreme',Georgia,serif; font-size:25px; font-weight:400; color:#2e2a2c; margin:0 0 4px; }
.catalogo-interlinks .il-kw { color:#9c637f; font-style:italic; }
.catalogo-interlinks .il-sub { font-family:'Poppins',sans-serif; font-size:13px; color:#8a8288; margin:0 0 22px; }
.catalogo-interlinks .il-slider-wrap { position:relative; }
.catalogo-interlinks .il-slider { display:flex; gap:16px; overflow-x:auto; scroll-behavior:smooth; padding:4px 2px 14px; scrollbar-width:thin; }
.catalogo-interlinks .il-slider::-webkit-scrollbar { height:6px; }
.catalogo-interlinks .il-slider::-webkit-scrollbar-thumb { background:#ddd4ce; border-radius:10px; }
.catalogo-interlinks .il-slider.il-centered { justify-content:center; }
.catalogo-interlinks .il-slider.il-centered::-webkit-scrollbar { display:none; }
.catalogo-interlinks .il-slider.il-centered { scrollbar-width:none; }
.catalogo-interlinks .il-card { flex:0 0 185px; text-decoration:none; color:inherit; transition:transform .2s; }
.catalogo-interlinks .il-card:hover { transform:translateY(-3px); }
.catalogo-interlinks .il-thumb { aspect-ratio:1/1; border:1px solid #ece6e2; border-radius:2px; overflow:hidden; background:#f6f1ee; box-shadow:0 10px 26px -18px rgba(46,42,44,.3); }
.catalogo-interlinks .il-thumb img { width:100%; height:100%; object-fit:cover; transition:transform .5s; display:block; }
.catalogo-interlinks .il-card:hover .il-thumb img { transform:scale(1.06); }
.catalogo-interlinks .il-cap { font-family:'MoonCreme',Georgia,serif; font-size:16px; text-align:center; margin-top:11px; color:#2e2a2c; transition:color .2s; }
.catalogo-interlinks .il-card:hover .il-cap { color:#9c637f; }
.catalogo-interlinks .il-nav { position:absolute; top:calc(50% - 26px); transform:translateY(-50%); width:40px; height:40px; border-radius:50%; background:#fff; border:1px solid #ddd4ce; color:#2e2a2c; font-size:20px; line-height:1; cursor:pointer; display:none; align-items:center; justify-content:center; box-shadow:0 4px 14px -6px rgba(0,0,0,.3); z-index:2; }
.catalogo-interlinks .il-nav.prev { left:-8px; } .catalogo-interlinks .il-nav.next { right:-8px; }
.catalogo-interlinks .il-nav:hover { background:#2e2a2c; color:#fff; border-color:#2e2a2c; }
.catalogo-interlinks .il-chips-block { margin-top:30px; }
.catalogo-interlinks .il-chips-label { font-family:'Poppins',sans-serif; font-size:12px; font-weight:600; letter-spacing:2px; text-transform:uppercase; color:#9c637f; margin:0 0 12px; }
.catalogo-interlinks .il-chips { display:flex; flex-wrap:wrap; gap:9px; }
.catalogo-interlinks .il-chip { font-family:'Poppins',sans-serif; font-size:13.5px; color:#444; text-decoration:none; background:#fff; border:1px solid #ddd4ce; border-radius:100px; padding:7px 15px; transition:all .18s; }
.catalogo-interlinks .il-chip:hover { border-color:#BB8AA3; color:#9c637f; }
@media (max-width:575px){ .catalogo-interlinks { padding:32px 0 40px; } .catalogo-interlinks .il-card { flex-basis:150px; } }
</style>
<script>
(function(){
  function ilInit(){
    var wraps = document.querySelectorAll('.catalogo-interlinks .il-slider-wrap');
    for (var i=0;i<wraps.length;i++){
      var s = wraps[i].querySelector('.il-slider'); if(!s) continue;
      var overflow = s.scrollWidth > s.clientWidth + 4;
      var navs = wraps[i].querySelectorAll('.il-nav');
      for (var j=0;j<navs.length;j++) navs[j].style.display = overflow ? 'flex' : 'none';
      s.classList.toggle('il-centered', !overflow);
    }
  }
  ilInit();
  window.addEventListener('load', ilInit);
  window.addEventListener('resize', ilInit);
})();
function ilSlide(b,d){ var s=b.parentElement.querySelector('.il-slider'); if(s) s.scrollBy({left:d*(185+16)*2,behavior:'smooth'}); }
</script>
<?php endif; ?>
