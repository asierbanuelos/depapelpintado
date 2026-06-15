<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>De Papel Pintado</title>
  <?php $this->load->view('includes/admin_head'); ?>
  <style>
  .home-section { margin: 30px 0 40px; }
  .home-section-title {
    font-size: 22px; font-weight: 300; color: #B05380;
    border-bottom: 1px solid #B05380; padding-bottom: 8px; margin-bottom: 20px;
  }
  .home-card {
    background: #fff; border: 1px solid #e0e0e0;
    border-radius: 4px; padding: 20px; margin-bottom: 16px;
  }
  .home-card-title {
    font-size: 15px; font-weight: 600; color: #444; margin-bottom: 14px;
  }
  .home-card-body { display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap; }
  .home-card-img { flex: 0 0 220px; }
  .home-card-img img {
    width: 220px; height: 120px; object-fit: cover;
    border: 1px solid #ddd; background: #f5f5f5; display: block;
  }
  .home-card-fields { flex: 1; min-width: 260px; }
  .home-field { margin-bottom: 10px; }
  .home-field label { display: block; font-size: 11px; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
  .home-field input[type=text], .home-field textarea {
    width: 100%; padding: 7px 10px; border: 1px solid #ddd;
    font-size: 13px; color: #333; box-sizing: border-box;
  }
  .home-field input[type=file] { font-size: 13px; }
  .home-btn {
    background: #B05380; color: #fff; border: none;
    padding: 8px 22px; font-size: 13px; cursor: pointer; border-radius: 2px;
    margin-top: 6px;
  }
  .home-btn:hover { background: #934468; }
  .home-btn-outline {
    background: transparent; color: #B05380; border: 1px solid #B05380;
    padding: 7px 18px; font-size: 12px; cursor: pointer; border-radius: 2px; margin-left: 8px;
  }
  .home-btn-outline:hover { background: #B05380; color: #fff; }
  .categ-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
  .preview-msg { font-size: 11px; color: #aaa; margin-top: 4px; }
  </style>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>

  <div class="container pb-5">
    <div style="height:30px"></div>
    <div style="font-size:36px;font-weight:300;color:#B05380;text-align:center;border-bottom:1px solid #B05380;padding-bottom:10px">
      DE PAPEL PINTADO
    </div>

    <!-- ===== BANNER ===== -->
    <div class="home-section">
      <div class="home-section-title">Banner principal</div>
      <div class="home-card">
        <div class="home-card-body">

          <!-- Preview imagen actual -->
          <div class="home-card-img">
            <?php
            // Siempre mostrar el banner2.webp que es el que usa la home
            $bw = $_SERVER['DOCUMENT_ROOT'] . '/images/banner2.webp';
            $bj = $_SERVER['DOCUMENT_ROOT'] . '/images/banner2.jpg';
            if (file_exists($bw))      $banner_img_src = '/images/banner2.webp?' . filemtime($bw);
            elseif (file_exists($bj))  $banner_img_src = '/images/banner2.jpg?' . filemtime($bj);
            else                       $banner_img_src = '';
            ?>
            <img id="banner-preview" src="<?= $banner_img_src ?>" onerror="this.style.opacity=0.3">
            <p class="preview-msg">Imagen actual del banner</p>
          </div>

          <!-- Upload -->
          <div class="home-card-fields">
            <?php echo form_open_multipart('admin_library/upload_home_banner'); ?>
            <p style="color:#888;font-size:13px;margin-top:0;">Sube una nueva foto para reemplazar el banner de la home.</p>
            <div class="home-field">
              <label>Nueva imagen (JPG / WEBP recomendado)</label>
              <input type="file" name="imagen" accept="image/*" onchange="previewImg(this,'banner-preview')">
            </div>
            <button type="submit" class="home-btn">Guardar banner</button>
            <?php echo form_close(); ?>
          </div>

        </div>
      </div>
    </div>

    <!-- ===== CATEGORÍAS ===== -->
    <?php
    // Mapa: título → archivo real en /images/images home/
    $img_map_admin = [
      'papel pintado'        => 'papel pitnafo_1_11zon.webp',
      'fotomurales'          => 'murales_10_11zon.webp',
      'murales'              => 'murales_10_11zon.webp',
      'revestimientos'       => 'revestimiento_2_11zon.webp',
      'telas'                => 'ultimo_3_11zon.webp',
      'alfombras vinilic'    => 'alformas viniladas_5_11zon.webp',
      'alfombras vinilicas'  => 'alformas viniladas_5_11zon.webp',
      'alfombras vinílicas'  => 'alformas viniladas_5_11zon.webp',
      'alfombras'            => 'alfomas_4_11zon.webp',
      'complementos'         => '',
    ];

    // Categorías estáticas (sin registro en BD) — solo imagen
    $static_categs = [
      ['slug' => 'alfombras-a-medida', 'titulo' => 'Alfombras a medida'],
      ['slug' => 'complementos', 'titulo' => 'Complementos'],
    ];
    // Títulos de DB que se gestionan ahora como estáticos (se omiten del bucle)
    $omitir_db = ['alfombras vinilicas', 'alfombras vinílicas', 'alfombras vinilic'];
    $vistos = [];
    ?>
    <div class="home-section">
      <div class="home-section-title">Imágenes de categorías</div>
      <div class="categ-grid">
        <?php foreach ($categorias_home as $cat):
          $titulo_lower = mb_strtolower(trim($cat->titulo));
          if (in_array($titulo_lower, $vistos)) continue;
          // Ocultar las vinílicas (ahora gestionadas como "Alfombras a medida")
          $omitir = false;
          foreach ($omitir_db as $om) { if (strpos($titulo_lower, $om) !== false) { $omitir = true; break; } }
          if ($omitir) continue;
          $vistos[] = $titulo_lower;

          $slug = urlenc($cat->titulo);
          // Buscar primero imagen subida desde admin
          $root = $_SERVER['DOCUMENT_ROOT'];
          $img_src = '';
          foreach (['webp','jpg','jpeg','png'] as $ext) {
            if (file_exists($root . '/images/home-categories/' . $slug . '.' . $ext)) {
              $img_src = '/images/home-categories/' . $slug . '.' . $ext . '?' . filemtime($root . '/images/home-categories/' . $slug . '.' . $ext);
              break;
            }
          }
          // Fallback al mapa original
          if (!$img_src) {
            $target_file = '';
            foreach ($img_map_admin as $k => $v) {
              if (strpos($titulo_lower, $k) !== false) { $target_file = $v; break; }
            }
            $img_src = $target_file ? '/images/images home/' . $target_file : '';
          }
          $preview_id = 'categ-prev-' . $cat->id;
        ?>
        <div class="home-card">
          <div class="home-card-title"><?= htmlspecialchars($cat->titulo) ?></div>
          <div class="home-card-body" style="flex-direction:column;gap:12px;">
            <img id="<?= $preview_id ?>"
                 src="<?= htmlspecialchars($img_src) ?>"
                 style="width:100%;height:140px;object-fit:cover;border:1px solid #ddd;background:#f5f5f5;"
                 onerror="this.style.opacity=0.15">
            <?php echo form_open_multipart('admin_library/upload_categ_home/' . $cat->id); ?>
              <?php echo form_hidden('img_clean_name', $slug); ?>
              <div class="home-field" style="margin-top:8px;">
                <label>Título</label>
                <input type="text" name="titulo" value="<?= htmlspecialchars($cat->titulo) ?>">
              </div>
              <div class="home-field">
                <label>Enlace</label>
                <input type="text" name="enlace" value="<?= htmlspecialchars($cat->enlace) ?>">
              </div>
              <div class="home-field">
                <label>Nueva imagen</label>
                <input type="file" name="imagen" accept="image/*" onchange="previewImg(this,'<?= $preview_id ?>')">
              </div>
              <button type="submit" class="home-btn" style="width:100%;">Guardar</button>
            <?php echo form_close(); ?>
          </div>
        </div>
        <?php endforeach; ?>

        <?php foreach ($static_categs as $sc):
          $slug = $sc['slug'];
          $root = $_SERVER['DOCUMENT_ROOT'];
          $img_src_static = '';
          foreach (['webp','jpg','jpeg','png'] as $ext) {
            if (file_exists($root . '/images/home-categories/' . $slug . '.' . $ext)) {
              $img_src_static = '/images/home-categories/' . $slug . '.' . $ext . '?' . filemtime($root . '/images/home-categories/' . $slug . '.' . $ext);
              break;
            }
          }
          $preview_id_s = 'categ-prev-static-' . $slug;
        ?>
        <div class="home-card">
          <div class="home-card-title"><?= htmlspecialchars($sc['titulo']) ?></div>
          <div class="home-card-body" style="flex-direction:column;gap:12px;">
            <img id="<?= $preview_id_s ?>"
                 src="<?= htmlspecialchars($img_src_static) ?>"
                 style="width:100%;height:140px;object-fit:cover;border:1px solid #ddd;background:#f5f5f5;"
                 onerror="this.style.opacity=0.15">
            <?php echo form_open_multipart('admin_library/upload_categ_static/' . $slug); ?>
              <div class="home-field" style="margin-top:8px;">
                <label>Nueva imagen</label>
                <input type="file" name="imagen" accept="image/*" onchange="previewImg(this,'<?= $preview_id_s ?>')">
              </div>
              <button type="submit" class="home-btn" style="width:100%;">Guardar</button>
            <?php echo form_close(); ?>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
    </div>

  </div>

  <?php $this->load->view('includes/scripts'); ?>
  <script>
  function previewImg(input, previewId) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var el = document.getElementById(previewId);
        if (el) { el.src = e.target.result; el.style.opacity = 1; }
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
  </script>
</body>
</html>
