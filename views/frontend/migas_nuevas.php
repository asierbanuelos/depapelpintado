<?php
$estasmigas="";
$colest=" ";
$esmarcas=false;
?>
<div class="container">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-white px-0" itemscope itemtype="http://schema.org/BreadcrumbList">
      <li class="breadcrumb-item ml-auto" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
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
            $texto_miga='<strong>'.$texto_miga.'</strong>';
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
