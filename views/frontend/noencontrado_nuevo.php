<style>
/* ===== ANIMACIONES ===== */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50%       { transform: translateY(-12px); }
}
@keyframes draw {
  to { stroke-dashoffset: 0; }
}
@keyframes scan {
  0%   { stroke-dashoffset: 0; }
  100% { stroke-dashoffset: -22; }
}
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(18px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes pulse-ring {
  0%   { r: 5;  opacity: 0.8; }
  60%  { r: 10; opacity: 0; }
  100% { r: 10; opacity: 0; }
}

/* ===== LAYOUT ===== */
.no-results-wrap {
  min-height: 60vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px 80px;
  text-align: center;
}

/* ===== ICONO ===== */
.no-results-icon {
  width: 120px;
  height: 120px;
  margin: 0 auto 36px;
  animation: float 3.6s ease-in-out infinite;
}

/* Contornos del muestrario: se dibujan al cargar */
.nr-outline {
  stroke-dasharray: 300;
  stroke-dashoffset: 300;
  animation: draw 1.2s ease forwards;
}
.nr-outline-2 { animation-delay: 0.2s; }
.nr-outline-3 { animation-delay: 0.35s; }
.nr-outline-4 { animation-delay: 0.5s; }
.nr-outline-5 { animation-delay: 0.6s; }

/* Líneas de patrón: se mueven como un scanner */
.nr-scan {
  stroke-dasharray: 11 5;
  animation: scan 0.8s linear infinite;
}
.nr-scan-2 { animation-delay: -0.27s; }
.nr-scan-3 { animation-delay: -0.54s; }

/* Círculo lupa: pulso */
.nr-lupa-ring {
  animation: pulse-ring 1.8s ease-out infinite;
  transform-origin: 79px 37px;
}

/* ===== TEXTO ===== */
.no-results-title {
  font-family: 'MoonCreme', Georgia, serif;
  font-size: clamp(24px, 4vw, 38px);
  font-weight: normal;
  letter-spacing: 3px;
  color: #222;
  margin: 0 0 12px;
  animation: fadeUp 0.7s ease 0.9s both;
}
.no-results-sub {
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  color: #999;
  font-weight: 300;
  letter-spacing: 0.5px;
  margin: 0 0 36px;
  animation: fadeUp 0.7s ease 1.05s both;
}

/* ===== BUSCADOR ===== */
.no-results-search {
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 500px;
  border: 1px solid #ccc;
  overflow: hidden;
  margin: 0 auto 48px;
  transition: border-color 0.2s, box-shadow 0.2s;
  animation: fadeUp 0.7s ease 1.2s both;
}
.no-results-search:focus-within {
  border-color: #333;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.no-results-search input {
  flex: 1;
  border: none;
  outline: none;
  padding: 14px 18px;
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  color: #333;
}
.no-results-search button {
  background: #333;
  color: #fff;
  border: none;
  padding: 14px 22px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.2s;
}
.no-results-search button:hover { background: #BB8AA3; }

/* ===== CATEGORÍAS ===== */
.no-results-cats-label {
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #ccc;
  margin-bottom: 16px;
  animation: fadeUp 0.7s ease 1.35s both;
}
.no-results-cats {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  justify-content: center;
  max-width: 600px;
  margin: 0 auto;
  animation: fadeUp 0.7s ease 1.5s both;
}
.no-results-cats a {
  font-family: 'Poppins', sans-serif;
  font-size: 11px;
  font-weight: 500;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: #555;
  text-decoration: none;
  border: 1px solid #ddd;
  padding: 8px 16px;
  transition: all 0.2s;
}
.no-results-cats a:hover { background: #333; color: #fff; border-color: #333; }
</style>

<div id="inicio" class="wrapper">
  <div class="no-results-wrap">

    <!-- SVG animado: muestrario de papel pintado con lupa -->
    <svg class="no-results-icon" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">

      <!-- Pulso lupa (fondo) -->
      <circle class="nr-lupa-ring" cx="79" cy="37" r="5" stroke="#BB8AA3" stroke-width="1.5" fill="none"/>

      <!-- Patas del muestrario -->
      <line class="nr-outline nr-outline-4" x1="35" y1="70" x2="35" y2="82" stroke="#555" stroke-width="3" stroke-linecap="round"/>
      <line class="nr-outline nr-outline-4" x1="65" y1="70" x2="65" y2="82" stroke="#555" stroke-width="3" stroke-linecap="round"/>
      <line class="nr-outline nr-outline-5" x1="30" y1="82" x2="70" y2="82" stroke="#555" stroke-width="3" stroke-linecap="round"/>

      <!-- Cuerpo principal del muestrario -->
      <rect class="nr-outline" x="18" y="30" width="64" height="40" rx="3" stroke="#333" stroke-width="3.5"/>

      <!-- Cabecera -->
      <rect class="nr-outline nr-outline-2" x="28" y="20" width="44" height="10" rx="2.5" stroke="#333" stroke-width="3"/>

      <!-- Líneas de patrón animadas -->
      <line class="nr-scan"   x1="28" y1="43" x2="72" y2="43" stroke="#BB8AA3" stroke-width="2" stroke-linecap="round"/>
      <line class="nr-scan nr-scan-2" x1="28" y1="52" x2="72" y2="52" stroke="#BB8AA3" stroke-width="2" stroke-linecap="round"/>
      <line class="nr-scan nr-scan-3" x1="28" y1="61" x2="72" y2="61" stroke="#BB8AA3" stroke-width="2" stroke-linecap="round"/>

      <!-- Lupa -->
      <circle class="nr-outline nr-outline-3" cx="79" cy="37" r="6" stroke="#333" stroke-width="3"/>
      <line   class="nr-outline nr-outline-3" x1="83.2" y1="41.2" x2="88" y2="46" stroke="#333" stroke-width="3" stroke-linecap="round"/>
    </svg>

    <h1 class="no-results-title">Este diseño no está en nuestro catálogo</h1>
    <p class="no-results-sub">Prueba con otra referencia o explora nuestras colecciones</p>

    <form class="no-results-search" action="/tienda/busqueda" method="post">
      <input type="text" name="search" placeholder="Busca por referencia, colección o estilo…" autocomplete="off" />
      <button type="submit" aria-label="Buscar"><i class="fa fa-search"></i></button>
    </form>

    <p class="no-results-cats-label">Explorar categorías</p>
    <div class="no-results-cats">
      <a href="/papel-pintado">Papel Pintado</a>
      <a href="/murales">Murales</a>
      <a href="/revestimientos">Revestimientos</a>
      <a href="/telas">Telas</a>
      <a href="/alfombras">Alfombras</a>
      <a href="/marcas">Marcas</a>
    </div>

  </div>
</div>
