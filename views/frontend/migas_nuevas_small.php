<?php
$estasmigas="";
$colest=" ";
$esmarcas=false;
$class_separa_migas='';
if (isset($separa_migas))
  $class_separa_migas='mt-4';
?>
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-white px-0 small mb-0" itemscope itemtype="http://schema.org/BreadcrumbList">
      <li class="breadcrumb-item <?php /*ml-auto*/?>" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <meta itemprop="position" content="1" />
        <a href="/" itemprop="item"><span itemprop='name'>Inicio</span></a>
      </li>
      <?php
      if (isset($a_migas)){
        $position_miga=1;
        $num_migas=count($a_migas);
        foreach ($a_migas as $url_miga => $texto_miga) {
          $miga_activa='';
          $miga_aria_current='';
          if ($num_migas==$position_miga){
            $miga_aria_current=' aria-current="page" ';
            $miga_activa='active';
            // quitamos la negrita
            //$texto_miga='<strong>'.$texto_miga.'</strong>';
          }

          $position_miga++;
          // code...
          ?>
          <li class="breadcrumb-item <?php echo $miga_activa; ?>" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" <?php echo $miga_aria_current; ?>>
            <meta itemprop="position" content="<?php echo $position_miga; ?>" />
            <?php 
            echo "<a href='$url_miga' itemprop='item'><span itemprop='name'>$texto_miga</span></a>";
            ?>
          </li>
          <?php
        }
      }
      ?>
    </ol>
  </nav>
</div>
<?
if($esmarcas)
  $estasmigas=anchor("tienda","Inicio")." / ";
$this->session->set_userdata(array('migas'=>$estasmigas,'busqueda'=>current_url(),'colest'=>$colest))
?>

<style>
li.breadcrumb-item{
  font-size:14px;
  display: inline-flex;
  justify-content: center;
  position: relative;
  height: 100%;
  vertical-align: bottom;
  line-height: 30px;
  margin-bottom: 5px;
  z-index: 0;
}
li.breadcrumb-item:first-child {
    margin-right: 10px;
}
li.breadcrumb-item:not(:first-child) {
    margin-right: 5px;
}
li.breadcrumb-item:first-child:before {
  content: '';
  position: absolute;
  left: 0;
  height: 100%;
  width: 100%;
  border-radius: 4px 0 0 4px;
  background: grey;
  opacity: 0.15;
}
li.breadcrumb-item:first-child:after {
    content: '';
    opacity: 0.15;
    position: absolute;
    right: -9px;
    border-top: 16px solid transparent;
    border-left: 9px solid grey;
    border-bottom: 16px solid transparent;
}
li.breadcrumb-item a {
    padding: 0 10px 0 10px;
    z-index: 2;
    color: black;
    text-decoration: none;
    font-size: 14px;
    line-height: 22px;
    letter-spacing: -0.11px;
    padding: 5px 12px;
    white-space: nowrap;
}
li.breadcrumb-item a:hover {
    color: #000 !important;
}
li.breadcrumb-item:not(:first-child)::after {
    bottom: 0;
    transform: skew(-30deg);
}
li.breadcrumb-item:not(:first-child)::before {
    top: 0;
    transform: skew(30deg);
}

li.breadcrumb-item:not(:first-child)::before, li.breadcrumb-item:not(:first-child)::after {
    content: '';
    position: absolute;
    left: 0;
    height: 50%;
    width: 100%;
    background: grey;
    opacity: 0.15;
}
li.breadcrumb-item:not(:last-child):focus::before, li.breadcrumb-item:not(:last-child):hover::before, li.breadcrumb-item:not(:last-child):focus::after, li.breadcrumb-item:not(:last-child):hover::after {
    opacity: 0.3;
}
li.breadcrumb-item:last-child:before, li.breadcrumb-item:last-child:after {
    display: none;
}
</style>