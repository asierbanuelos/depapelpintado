<?php
if (isset($col['null']))
  unset($col['null']);

if (isset($_GET['test']) && $_GET['test']=='eneko'){
  print '<pre><xmp>';
  print_r($col);
  print '</xmp></pre>';
}

// ---- SEO marca (PILOTO gated con ?preview_seo=1). Para activar en TODAS las marcas: poner true. ----
$preview_seo_marca = isset($_GET['preview_seo']);
$marca_nombre_seo  = isset($fab->cat_name) ? trim($fab->cat_name) : '';
$marca_slug_seo    = $marca_nombre_seo!=='' ? urlenc($marca_nombre_seo) : '';
$marca_id_seo      = isset($id_marca_seo) ? (int)$id_marca_seo : (isset($fab->cat_id)?(int)$fab->cat_id:0);
$tipos_marca_seo   = array(); // seg-url => etiqueta
if (isset($fab->cats) && trim($fab->cats)!==''){
  $map_seg_seo = array('papel pintado'=>'papel-pintado','foto murales'=>'murales','fotomurales'=>'murales','murales'=>'murales','revestimientos'=>'revestimientos','telas'=>'telas','alfombras'=>'alfombras');
  foreach (explode(',', $fab->cats) as $t){
    $t = trim($t); $k = mb_strtolower($t, 'UTF-8');
    if (isset($map_seg_seo[$k])) $tipos_marca_seo[$map_seg_seo[$k]] = $t;
  }
}
// nombre "bonito" + keyword de tipo para el hero
$marca_disp_seo = $marca_nombre_seo!=='' ? mb_convert_case(mb_strtolower($marca_nombre_seo,'UTF-8'), MB_CASE_TITLE, 'UTF-8') : '';
$primer_label_seo = count($tipos_marca_seo) ? reset($tipos_marca_seo) : 'Papel pintado';
$primer_label_lc  = mb_strtolower($primer_label_seo,'UTF-8');
$kw_seo = mb_strtoupper(mb_substr($primer_label_lc,0,1,'UTF-8'),'UTF-8').mb_substr($primer_label_lc,1,null,'UTF-8'); // "Papel pintado"
$n_colec_seo = (isset($col_flat) && is_array($col_flat)) ? count($col_flat) : 0;
// subtitulo del hero (extracto del texto de marca o generico)
$subtitulo_seo = '';
if (isset($fab->cat_text) && trim(strip_tags($fab->cat_text))!==''){
  $subtitulo_seo = trim(preg_replace('/\s+/',' ', strip_tags($fab->cat_text)));
  if (mb_strlen($subtitulo_seo,'UTF-8')>170) $subtitulo_seo = mb_substr($subtitulo_seo,0,167,'UTF-8').'&hellip;';
} elseif ($marca_disp_seo!=='') {
  $subtitulo_seo = 'Descubre todas las colecciones de '.$kw_seo.' '.$marca_disp_seo.' con env&iacute;o a toda Espa&ntilde;a. Dise&ntilde;os originales para vestir tus paredes con car&aacute;cter.';
}
?>

<div class="categ-breadcrumb-bar">
  <div class="container">
    <?php $this->load->view('frontend/migas_nuevas_small', $this->data); ?>
  </div>
</div>

<?php if ($preview_seo_marca): // ================= PLANTILLA MEJORADA (mockup) ================= ?>
<style>
.marca-seo-page{--msq-ground:#FAF6EF;--msq-surface:#fff;--msq-surface2:#F4EEE4;--msq-ink:#271f1f;--msq-muted:#666;--msq-faint:#9a9088;--msq-accent:#a36185;--msq-accent-ink:#8f3a63;--msq-accent-soft:#f3eaf0;--msq-line:#E9E0D6;--msq-line2:#DCD1C2;--msq-shadow:0 1px 3px rgba(42,38,34,.06),0 8px 26px rgba(42,38,34,.06);color:var(--msq-ink);background:var(--msq-ground);font-family:'Poppins',sans-serif;}
.marca-seo-page *{box-sizing:border-box;}
.marca-seo-page .msq-wrap{max-width:1120px;margin:0 auto;padding:0 22px;}
.marca-seo-page h1,.marca-seo-page h2,.marca-seo-page h3{font-family:'Poppins',sans-serif;font-weight:400;margin:0;color:var(--msq-ink);}
.marca-seo-page .msq-eyebrow{font-size:11px;letter-spacing:.22em;text-transform:uppercase;color:var(--msq-accent);font-weight:600;}
.marca-seo-page .msq-hero{position:relative;overflow:hidden;border-bottom:1px solid var(--msq-line);}
.marca-seo-page .msq-hero-bg{position:absolute;inset:0;background:radial-gradient(120% 120% at 80% 0%,var(--msq-accent-soft),transparent 55%),linear-gradient(160deg,var(--msq-surface2),var(--msq-ground));}
.marca-seo-page .msq-hero .msq-wrap{position:relative;padding:56px 22px 50px;text-align:center;}
.marca-seo-page .msq-hero .msq-eyebrow{display:block;margin-bottom:14px;}
.marca-seo-page .msq-hero h1{font-size:clamp(34px,6vw,64px);line-height:1.04;}
.marca-seo-page .msq-hero h1 .msq-brand{color:var(--msq-accent-ink);}
.marca-seo-page .msq-sub{max-width:60ch;margin:20px auto 0;color:var(--msq-muted);font-size:16px;line-height:1.6;}
.marca-seo-page .msq-cta{display:inline-flex;gap:10px;align-items:center;margin-top:26px;background:var(--msq-accent);color:#fff;text-decoration:none;font-size:13px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;padding:14px 30px;border-radius:999px;transition:.2s;}
.marca-seo-page .msq-cta:hover{background:var(--msq-accent-ink);transform:translateY(-2px);}
.marca-seo-page .msq-stat{margin-top:22px;font-size:12.5px;color:var(--msq-faint);letter-spacing:.03em;}
.marca-seo-page .msq-trust{background:var(--msq-surface);border-bottom:1px solid var(--msq-line);}
.marca-seo-page .msq-trust .msq-wrap{display:grid;grid-template-columns:repeat(4,1fr);gap:0;padding:0;}
.marca-seo-page .msq-cell{padding:16px 14px;text-align:center;border-right:1px solid var(--msq-line);}
.marca-seo-page .msq-cell:last-child{border-right:none;}
.marca-seo-page .msq-cell .t{font-size:13px;font-weight:700;}
.marca-seo-page .msq-cell .d{font-size:11.5px;color:var(--msq-muted);margin-top:2px;}
.marca-seo-page .msq-sec{padding:48px 0;}
.marca-seo-page .msq-alt{background:var(--msq-surface);}
.marca-seo-page .msq-sec-head{text-align:center;margin-bottom:30px;}
.marca-seo-page .msq-sec-head h2{font-size:clamp(24px,3.2vw,34px);}
.marca-seo-page .msq-sec-head p{color:var(--msq-muted);max-width:56ch;margin:10px auto 0;font-size:15px;}
.marca-seo-page .msq-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;}
.marca-seo-page .msq-card{background:var(--msq-surface);border:1px solid var(--msq-line);border-radius:12px;overflow:hidden;box-shadow:var(--msq-shadow);transition:.22s;display:block;text-decoration:none;color:inherit;}
.marca-seo-page .msq-card:hover{transform:translateY(-4px);box-shadow:0 14px 40px rgba(42,38,34,.14);}
.marca-seo-page .msq-thumb{aspect-ratio:1/1;position:relative;background:var(--msq-surface2);overflow:hidden;}
.marca-seo-page .msq-thumb img{width:100%;height:100%;object-fit:cover;display:block;}
.marca-seo-page .msq-badge{position:absolute;top:10px;left:10px;font-size:10px;font-weight:700;letter-spacing:.06em;text-transform:uppercase;padding:4px 9px;border-radius:999px;}
.marca-seo-page .msq-badge.nov{background:var(--msq-accent);color:#fff;}
.marca-seo-page .msq-badge.off{background:var(--msq-ink);color:var(--msq-ground);}
.marca-seo-page .msq-cardb{padding:14px 16px 18px;text-align:center;}
.marca-seo-page .msq-cardb h3{font-size:18px;}
.marca-seo-page .msq-cardb .n{font-size:12px;color:var(--msq-muted);margin-top:5px;}
.marca-seo-page .msq-prod{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;}
.marca-seo-page .msq-pcard{text-align:center;text-decoration:none;color:inherit;display:block;}
.marca-seo-page .msq-pthumb{aspect-ratio:3/4;border-radius:12px;position:relative;overflow:hidden;border:1px solid var(--msq-line);background:var(--msq-surface2);}
.marca-seo-page .msq-pthumb img{width:100%;height:100%;object-fit:cover;display:block;}
.marca-seo-page .msq-price{position:absolute;bottom:10px;right:10px;background:var(--msq-surface);color:var(--msq-ink);font-size:13px;font-weight:700;padding:5px 11px;border-radius:999px;box-shadow:var(--msq-shadow);}
.marca-seo-page .msq-pn{font-size:16px;margin-top:12px;}
.marca-seo-page .msq-pref{font-size:12px;color:var(--msq-muted);margin-top:3px;}
.marca-seo-page .msq-marquee{overflow:hidden;position:relative;-webkit-mask-image:linear-gradient(90deg,transparent,#000 6%,#000 94%,transparent);mask-image:linear-gradient(90deg,transparent,#000 6%,#000 94%,transparent);}
.marca-seo-page .msq-marquee-track{display:flex;gap:22px;width:max-content;animation:msqMarquee 70s linear infinite;}
.marca-seo-page .msq-marquee:hover .msq-marquee-track{animation-play-state:paused;}
.marca-seo-page .msq-marquee .msq-pcard{width:230px;flex:0 0 auto;}
@keyframes msqMarquee{from{transform:translateX(0);}to{transform:translateX(-50%);}}
@media (prefers-reduced-motion:reduce){.marca-seo-page .msq-marquee-track{animation:none;}}
.marca-seo-page .msq-rooms{display:flex;flex-wrap:wrap;gap:12px;justify-content:center;}
.marca-seo-page .msq-rooms a{text-decoration:none;font-size:13.5px;font-weight:600;background:var(--msq-surface);border:1px solid var(--msq-line2);color:var(--msq-ink);padding:11px 20px;border-radius:999px;transition:.18s;}
.marca-seo-page .msq-rooms a:hover{border-color:var(--msq-accent);color:var(--msq-accent-ink);}
.marca-seo-page .msq-seo{background:var(--msq-surface);border-top:1px solid var(--msq-line);border-bottom:1px solid var(--msq-line);}
.marca-seo-page .msq-box{max-width:760px;margin:0 auto;}
.marca-seo-page .msq-seo h2{font-size:26px;margin-bottom:14px;}
.marca-seo-page .msq-seo .msq-fade{position:relative;max-height:220px;overflow:hidden;transition:max-height .3s;}
.marca-seo-page .msq-seo .msq-fade.open{max-height:4000px;}
.marca-seo-page .msq-seo .msq-fade:not(.open)::after{content:"";position:absolute;inset:auto 0 0;height:80px;background:linear-gradient(transparent,var(--msq-surface));}
.marca-seo-page .msq-seo .texto-seo{color:var(--msq-muted);font-size:15px;line-height:1.7;}
.marca-seo-page .msq-more{display:block;margin:14px auto 0;background:none;border:none;color:var(--msq-accent-ink);font-weight:700;font-size:13px;letter-spacing:.06em;text-transform:uppercase;cursor:pointer;}
.marca-seo-page .msq-faqlist{max-width:760px;margin:0 auto;display:flex;flex-direction:column;gap:10px;}
.marca-seo-page .msq-faq{background:var(--msq-surface);border:1px solid var(--msq-line);border-radius:10px;overflow:hidden;}
.marca-seo-page .msq-faq summary{list-style:none;cursor:pointer;padding:16px 20px;font-weight:600;font-size:15px;display:flex;justify-content:space-between;gap:16px;align-items:center;}
.marca-seo-page .msq-faq summary::-webkit-details-marker{display:none;}
.marca-seo-page .msq-faq summary .pl{color:var(--msq-accent);font-size:22px;font-weight:300;transition:transform .2s;}
.marca-seo-page .msq-faq[open] summary .pl{transform:rotate(45deg);}
.marca-seo-page .msq-faq .a{padding:0 20px 18px;color:var(--msq-muted);font-size:14.5px;border-top:1px solid var(--msq-line);}
.marca-seo-page .msq-faq .a p{margin:12px 0 0;}
.marca-seo-page .msq-brands{display:flex;flex-wrap:wrap;gap:10px;justify-content:center;}
.marca-seo-page .msq-brands a{text-decoration:none;font-size:15px;color:var(--msq-muted);border:1px solid var(--msq-line);border-radius:8px;padding:12px 20px;transition:.18s;background:var(--msq-surface);}
.marca-seo-page .msq-brands a:hover{color:var(--msq-accent-ink);border-color:var(--msq-accent);}
@media (max-width:860px){.marca-seo-page .msq-grid,.marca-seo-page .msq-prod{grid-template-columns:repeat(2,1fr);}.marca-seo-page .msq-trust .msq-wrap{grid-template-columns:repeat(2,1fr);}.marca-seo-page .msq-cell:nth-child(2){border-right:none;}}
@media (max-width:480px){.marca-seo-page .msq-grid,.marca-seo-page .msq-prod{grid-template-columns:1fr;}}
</style>

<div class="marca-seo-page">

  <header class="msq-hero">
    <div class="msq-hero-bg"></div>
    <div class="msq-wrap">
      <span class="msq-eyebrow">Marca<?php if($kw_seo!==''):?> &middot; <?php echo htmlspecialchars($kw_seo, ENT_QUOTES, 'UTF-8');?><?php endif;?></span>
      <h1><?php echo htmlspecialchars($kw_seo, ENT_QUOTES, 'UTF-8');?> <span class="msq-brand"><?php echo htmlspecialchars($marca_disp_seo, ENT_QUOTES, 'UTF-8');?></span></h1>
      <?php if($subtitulo_seo!==''):?><p class="msq-sub"><?php echo $subtitulo_seo;?></p><?php endif;?>
      <a href="#msq-col" class="msq-cta">Ver colecciones &rarr;</a>
      <?php if($n_colec_seo):?><div class="msq-stat"><?php echo $n_colec_seo;?> colecciones &middot; env&iacute;o a toda Espa&ntilde;a &middot; muestras a domicilio</div><?php endif;?>
    </div>
  </header>

  <div class="msq-trust">
    <div class="msq-wrap">
      <div class="msq-cell"><div class="t">Env&iacute;o a toda Espa&ntilde;a</div><div class="d">gestionamos tu pedido</div></div>
      <div class="msq-cell"><div class="t">Muestras a casa</div><div class="d">antes de decidir</div></div>
      <div class="msq-cell"><div class="t">Asesoramiento</div><div class="d">experto por tel&eacute;fono</div></div>
      <div class="msq-cell"><div class="t">Compra segura</div><div class="d">pago protegido</div></div>
    </div>
  </div>

  <?php // ---- Colecciones ---- ?>
  <section class="msq-sec" id="msq-col">
    <div class="msq-wrap">
      <div class="msq-sec-head">
        <span class="msq-eyebrow">El cat&aacute;logo</span>
        <h2>Colecciones de <?php echo htmlspecialchars($marca_disp_seo, ENT_QUOTES, 'UTF-8');?></h2>
        <p>Explora las colecciones de la firma. Cada una con su car&aacute;cter y su paleta.</p>
      </div>
      <div class="msq-grid">
        <?php
        if (isset($col_flat) && is_array($col_flat)):
          foreach($col_flat as $c):
            if ($c['ccats']=='null') continue;
            $url_coleccion='/marcas/'.urlenc($fab->cat_name).'/'.urlenc($c['coleccion_name']);
            $img_col='/includes/'.str_replace('../','',$c['col_img'].'th.jpg');
            $n_prod = (isset($conteo_colecciones[$c['coleccion_id']])) ? (int)$conteo_colecciones[$c['coleccion_id']] : 0;
        ?>
        <a class="msq-card" href="<?php echo $url_coleccion;?>" title="<?php echo htmlspecialchars($c['coleccion_name'], ENT_QUOTES, 'UTF-8');?>">
          <div class="msq-thumb">
            <?php if(!empty($c['novedad_bool']) && $c['novedad_bool']==1):?><span class="msq-badge nov">Novedad</span><?php endif;?>
            <?php if(!empty($c['cdisc']) && $c['cdisc']==1):?><span class="msq-badge off">Oferta</span><?php endif;?>
            <img class="img-fluid" height="316" width="316" loading="lazy" src="<?php echo $img_col;?>" alt="<?php echo htmlspecialchars($c['coleccion_name'], ENT_QUOTES, 'UTF-8');?>">
          </div>
          <div class="msq-cardb">
            <h3><?php echo htmlspecialchars($c['coleccion_name'], ENT_QUOTES, 'UTF-8');?></h3>
            <?php if($n_prod):?><div class="n"><?php echo $n_prod;?> producto<?php echo $n_prod==1?'':'s';?></div><?php endif;?>
          </div>
        </a>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </section>

  <?php // ---- Productos destacados (con precio, respeta precio oculto) ---- ?>
  <?php if (!empty($destacados_marca)): ?>
  <section class="msq-sec msq-alt">
    <div class="msq-wrap">
      <div class="msq-sec-head">
        <span class="msq-eyebrow">Lo m&aacute;s destacado</span>
        <h2>Productos destacados de <?php echo htmlspecialchars($marca_disp_seo, ENT_QUOTES, 'UTF-8');?></h2>
        <p>Entra directamente a algunos de sus dise&ntilde;os m&aacute;s populares.</p>
      </div>
      <div class="msq-marquee" aria-label="Productos destacados de <?php echo htmlspecialchars($marca_disp_seo, ENT_QUOTES, 'UTF-8');?>">
        <div class="msq-marquee-track">
          <?php ob_start(); foreach($destacados_marca as $p): ?>
          <a class="msq-pcard" href="<?php echo $p['url'];?>" title="<?php echo htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8');?>">
            <div class="msq-pthumb">
              <img loading="lazy" src="<?php echo $p['img'];?>" alt="<?php echo htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8');?>">
              <?php if($p['price']!==''):?><span class="msq-price"><?php echo $p['price'];?></span><?php endif;?>
            </div>
            <div class="msq-pn"><?php echo htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8');?></div>
            <?php if(trim($p['ref'])!==''):?><div class="msq-pref">ref. <?php echo htmlspecialchars($p['ref'], ENT_QUOTES, 'UTF-8');?></div><?php endif;?>
          </a>
          <?php endforeach;
          $msq_cards = ob_get_clean();
          echo $msq_cards; // set original
          echo str_replace('<a class="msq-pcard"', '<a class="msq-pcard" aria-hidden="true" tabindex="-1"', $msq_cards); // copia para bucle continuo sin salto
          ?>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php // ---- Por estancia (enlaces a estancias generales, rastreables) ---- ?>
  <?php if (!empty($estancias_marca)): ?>
  <section class="msq-sec">
    <div class="msq-wrap">
      <div class="msq-sec-head">
        <span class="msq-eyebrow">Encuentra por espacio</span>
        <h2><?php echo htmlspecialchars($kw_seo, ENT_QUOTES, 'UTF-8');?> para cada estancia</h2>
        <p>Ideas para cada rinc&oacute;n de tu hogar.</p>
      </div>
      <div class="msq-rooms">
        <?php foreach($estancias_marca as $e): if(trim($e['nueva_categoria_name_url'])===''){continue;} ?>
          <a href="/<?php echo $e['nueva_categoria_name_url'];?>"><?php echo htmlspecialchars($e['nueva_categoria_name'], ENT_QUOTES, 'UTF-8');?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php // ---- Sobre la marca (texto SEO plegable) ---- ?>
  <?php if (isset($fab->cat_text) && trim($fab->cat_text)!==''): ?>
  <section class="msq-sec msq-seo">
    <div class="msq-wrap">
      <div class="msq-box">
        <span class="msq-eyebrow">Sobre la marca</span>
        <div class="msq-fade" id="msqSeoText">
          <div class="texto-seo"><?php echo $fab->cat_text;?></div>
        </div>
        <button class="msq-more" type="button" id="msqMore">Ver m&aacute;s &#9662;</button>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php // ---- FAQs de marca ---- ?>
  <?php if (!empty($faqs_marca)): ?>
  <section class="msq-sec msq-alt">
    <div class="msq-wrap">
      <div class="msq-sec-head">
        <span class="msq-eyebrow">Dudas frecuentes</span>
        <h2>Preguntas frecuentes sobre <?php echo htmlspecialchars($marca_disp_seo, ENT_QUOTES, 'UTF-8');?></h2>
      </div>
      <div class="msq-faqlist">
        <?php foreach($faqs_marca as $f): ?>
        <details class="msq-faq">
          <summary><?php echo htmlspecialchars($f->pregunta, ENT_QUOTES, 'UTF-8');?> <span class="pl">+</span></summary>
          <div class="a"><?php echo (strip_tags($f->respuesta)===$f->respuesta) ? '<p>'.htmlspecialchars($f->respuesta, ENT_QUOTES, 'UTF-8').'</p>' : $f->respuesta;?></div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php // ---- Otras marcas ---- ?>
  <?php if (!empty($marcas_relacionadas)): ?>
  <section class="msq-sec">
    <div class="msq-wrap">
      <div class="msq-sec-head">
        <span class="msq-eyebrow">Sigue explorando</span>
        <h2>Otras marcas que te pueden gustar</h2>
      </div>
      <div class="msq-brands">
        <?php foreach($marcas_relacionadas as $mr): ?>
          <a href="/marcas/<?php echo urlenc($mr->cat_name);?>"><?php echo htmlspecialchars(mb_convert_case(mb_strtolower($mr->cat_name,'UTF-8'), MB_CASE_TITLE, 'UTF-8'), ENT_QUOTES, 'UTF-8');?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

</div>

<?php
// ---- Datos estructurados: BreadcrumbList + ItemList (colecciones) + FAQPage ----
$ld_blocks = array();
$ld_blocks[] = '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":['
  .'{"@type":"ListItem","position":1,"name":"Inicio","item":'.json_encode(base_url(),JSON_UNESCAPED_UNICODE).'},'
  .'{"@type":"ListItem","position":2,"name":"Marcas","item":'.json_encode(base_url().'marcas',JSON_UNESCAPED_UNICODE).'},'
  .'{"@type":"ListItem","position":3,"name":'.json_encode($marca_disp_seo,JSON_UNESCAPED_UNICODE).',"item":'.json_encode(base_url().'marcas/'.$marca_slug_seo,JSON_UNESCAPED_UNICODE).'}]}';
if (isset($col_flat) && is_array($col_flat) && count($col_flat)){
  $li=array(); $pos=1;
  foreach($col_flat as $c){
    if ($c['ccats']=='null') continue;
    $u=base_url().'marcas/'.urlenc($fab->cat_name).'/'.urlenc($c['coleccion_name']);
    $li[]='{"@type":"ListItem","position":'.$pos++.',"name":'.json_encode($c['coleccion_name'],JSON_UNESCAPED_UNICODE).',"url":'.json_encode($u,JSON_UNESCAPED_UNICODE).'}';
  }
  if(count($li)) $ld_blocks[]='{"@context":"https://schema.org","@type":"ItemList","name":'.json_encode('Colecciones de '.$marca_disp_seo,JSON_UNESCAPED_UNICODE).',"itemListElement":['.implode(',',$li).']}';
}
if (!empty($faqs_marca)){
  $qs=array();
  foreach($faqs_marca as $f){
    $qs[]='{"@type":"Question","name":'.json_encode(trim(strip_tags($f->pregunta)),JSON_UNESCAPED_UNICODE).',"acceptedAnswer":{"@type":"Answer","text":'.json_encode(trim(strip_tags($f->respuesta)),JSON_UNESCAPED_UNICODE).'}}';
  }
  $ld_blocks[]='{"@context":"https://schema.org","@type":"FAQPage","mainEntity":['.implode(',',$qs).']}';
}
foreach($ld_blocks as $blk) echo '<script type="application/ld+json">'.$blk.'</script>'."\n";
?>

<script>
(function(){
  var m=document.getElementById('msqMore'), t=document.getElementById('msqSeoText');
  if(m&&t){ if(t.scrollHeight<=220){m.style.display='none';}
    m.addEventListener('click',function(){ var op=t.classList.toggle('open'); m.innerHTML=op?'Ver menos ▴':'Ver más ▾'; });
  }
})();
</script>

<?php else: // ================= PLANTILLA ORIGINAL (intacta) ================= ?>
<div class="wrapper">
  <h1 class="titulo-1-grande pt-2 pb-4 text-center"><?php echo $texto_h1_seccion; ?></h1>
  <div class="container">
    <?php
    if (trim($fab->cat_text)!=''){
      ?>
      <div class='col-12'>
        <div class="contenido-colapsable texto-seo"><?php echo $fab->cat_text;?></div>
        <button class="my_collapsible " aria-label="Ver más"></button>
      </div>
      <?php
    }
    ?>
    <h2 class='titulo-1 text-center pb-4 '><?php echo $texto_h2_seccion; ?></h2>

    <?php

    echo "<div class='row listado prefichas prefichas prefichas-nuevas'> \n";
    $count=0;

    // ---- Pagina de marca (todos los tipos): UNA sola lista de colecciones, sin agrupar por tipo ----
    if ($categ==-1 && isset($col_flat)){
      foreach($col_flat as $c){
        if ($c['ccats']=='null') continue;
        $url_coleccion='/marcas/'.urlenc($fab->cat_name).'/'.urlenc($c['coleccion_name']);
        ?>
        <div class="subcategory-block col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 col-sp-12">
          <div class="preficha subcategory-image">
            <a href="<?php echo $url_coleccion;?>" title="<?php echo $c['coleccion_name']; ?>" >
              <img class="img-fluid" height="316" width="316" src="/includes/<?php echo str_replace('../', '', $c['col_img'].'th.jpg'); ?>" alt="<?php echo $c['coleccion_name']; ?>" title='<?php echo $c['coleccion_name']; ?>' />
            </a>
          </div>
          <div class="subcategory-meta tit-centrado-imagen text-center">
            <h4>
              <a href="<?php echo $url_coleccion;?>" title="<?php echo $c['coleccion_name']; ?>" >
                <?php echo $c['coleccion_name']; ?>
              </a>
            </h4>
            <div class="subcategory-description"></div>
          </div>
        </div>
        <?php
      }
    }
    else
    foreach($col as $tipo_producto_aux => $colecciones_tipo_producto){
      if ($categ==-1){
        switch ($tipo_producto_aux) {
          case 0: $categ_aux = "Papel Pintado";
                  $seccionbase="papel_pintado";
                  break;
          case 1: $categ_aux = "Murales";
                  $seccionbase="murales";
                  break;
          case 2: $categ_aux = "Revestimientos";
                  $seccionbase="revestimientos";
                  break;
          case 3: $categ_aux = "Telas";
                  $seccionbase="telas";
                  break;
          case 4: $categ_aux = "Alfombras";
                  $seccionbase="alfombras";
                  break;
          case 5: $categ_aux = "Herramientas";
                  $seccionbase="Herramientas";
                  break;
          default: break;
        }
        $url_marca = '/tienda/'.$seccionbase.'/marca/'.$url_marca_aux;
        echo "<div class='col-12'><h3 class='h4 mb-4'>Colecciones de $categ_aux </h3></div>  \n";
      }
      foreach($colecciones_tipo_producto as $c){

        if($c['ccats']!='null' && ($categ==-1 || $categ==$tipo_producto_aux)){
          $url_coleccion=$url_marca.'/'.urlenc($c['coleccion_id']).'/'.urlenc($c['coleccion_name']);
          ?>
          <div class="subcategory-block col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 col-sp-12">
            <div class="preficha subcategory-image">
              <a href="<?php echo $url_coleccion;?>" title="<?php echo $c['coleccion_name']; ?>" >
                <img class="img-fluid" height="316" width="316" src="/includes/<?php echo str_replace('../', '', $c['col_img'].'th.jpg'); ?>" alt="<?php echo $c['coleccion_name']; ?>" title='<?php echo $c['coleccion_name']; ?>' />
              </a>
            </div>
            <div class="subcategory-meta tit-centrado-imagen text-center">
              <?php
              if (count($col)>1){
              ?>
              <h4>
                <a href="<?php echo $url_coleccion;?>" title="<?php echo $c['coleccion_name']; ?>" >
                  <?php echo $c['coleccion_name']; ?>
                </a>
              </h4>
              <?php
              }
              else{
              ?>
              <h3>
                <a href="<?php echo $url_coleccion;?>" title="<?php echo $c['coleccion_name']; ?>" >
                  <?php echo $c['coleccion_name']; ?>
                </a>
              </h3>
              <?php
              }
              ?>
              <div class="subcategory-description"></div>
            </div>
          </div>
          <?php
        }
      }
    }
      ?>
  </div>
</div>

<script>
  var botones_collapse = document.getElementsByClassName("my_collapsible");
  var i;
  for (i = 0; i < botones_collapse.length; i++) {
    var content = botones_collapse[i].previousElementSibling;
    if(content.scrollHeight<50)
      botones_collapse[i].style.display = "none";
  }

  for (i = 0; i < botones_collapse.length; i++) {
    botones_collapse[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var content = this.previousElementSibling;
      if (content.style.maxHeight){
        content.style.maxHeight = null;
      } else {
        content.style.maxHeight = content.scrollHeight + "px";
      }
    });
  }
</script>

<?php endif; // ================= /branch ================= ?>
