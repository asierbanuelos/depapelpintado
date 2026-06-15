<?php
$estasmigas="";
$colest=" ";
$esmarcas=false;
?>
<div class="units-row nomargin">
  <div class="unit-100 breadcrumbs nomargin">
    <div class="tituloficha nomargin old-h2">
      <ul itemscope itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
          <meta itemprop="position" content="1" />
          <?php
          $estasmigas =anchor("tienda",'<span itemprop="name">Inicio</span>')." / ";
          echo anchor("tienda",'<span itemprop="name">Inicio</span>', 'itemprop="item"' );
          ?>
        </li>
        <?php
        if($this->uri->total_segments()>1){
          if ($this->uri->segment(3)=="economicos"){
            $estasmigas.=anchor("tienda/".$this->uri->segment(2)."/".$this->uri->segment(3), "OUTLET")." / ";
            ?>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
              <meta itemprop="position" content="2" />
              <?=anchor("tienda/".$this->uri->segment(2)."/".$this->uri->segment(3), "<span itemprop='name'>OUTLET</span>", 'itemprop="item"');?>
            </li>
            <?
          }
          else{
            if($this->uri->segment(2)!="herramientas"){
              $estasmigas.=anchor("tienda/".$this->uri->segment(2), ucwords(str_replace("_", " ", urldec($this->uri->segment(2)))))." / ";
            }
            ?>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
              <meta itemprop="position" content="2" />
              <?=anchor("tienda/".$this->uri->segment(2), ucwords(str_replace("_", " ", "<span itemprop='name'>".ucwords(urldec ($this->uri->segment(2)))))."</span>", 'itemprop="item"');?>
            </li>  
          <?
          }
        }
        if ($this->uri->segment(3)=="los_mas_vendidos"){?>
          <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <meta itemprop="position" content="3" />
            <?=anchor(current_url(),"<span itemprop='name'>LOS MÁS VENDIDOS</span>", 'itemprop="item"');?>
          </li>
          <?
        }
        if ($this->uri->total_segments()>2 && $this->uri->segment(3)=="marcas"){
          if($this->uri->segment(2)!="marcas"){?>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
              <meta itemprop="position" content="3" />
              <? $estasmigas.=anchor("tienda/".$this->uri->segment(2)."/marcas","Marcas")." / ";
              echo anchor("tienda/".$this->uri->segment(2)."/marcas","<span itemprop='name'>Marcas</span>", 'itemprop="item"');?>
            </li>     
            <?
          }
        }
        if ((isset($donde['marca']))){
          $esmarcas=true;
          if($this->uri->segment(2)!="marcas"){?>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
              <meta itemprop="position" content="3" />
              <? 
              $estasmigas.=anchor("tienda/".$this->uri->segment(2)."/marcas","Marcas")." / ";
              echo anchor("tienda/".$this->uri->segment(2)."/marcas","<span itemprop='name'>Marcas</span>", 'itemprop="item"');
              ?>
            </li>
            <?
          }
          if ($this->uri->total_segments()>4){?>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
              <meta itemprop="position" content="4" />
              <?$estasmigas.=anchor("tienda/".$this->uri->segment(2)."/marca/".$this->uri->segment(4)."/".urlenc($this->uri->segment(5))."/",urldec($this->uri->segment(5)))." / ";
              echo anchor("tienda/".$this->uri->segment(2)."/marca/".$this->uri->segment(4)."/".urlenc ($this->uri->segment(5))."/","<span itemprop='name'>".urldec($this->uri->segment(5))."</span>", 'itemprop="item"');?>
            </li>
            <?
          }
          if ($this->uri->total_segments()>6){?>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
              <meta itemprop="position" content="5" />
              <?$estasmigas.=anchor("tienda/".$this->uri->segment(2)."/marca/".$this->uri->segment(4)."/".urlenc($this->uri->segment(5))."/".$this->uri->segment(6)."/".urlenc($this->uri->segment(7)),urldec($this->uri->segment(7)))." / ";
              echo anchor("tienda/".$this->uri->segment(2)."/marca/".$this->uri->segment(4)."/".urlenc($this->uri->segment(5))."/".$this->uri->segment(6)."/".urlenc($this->uri->segment(7)),"<span itemprop='name'>".urldec($this->uri->segment(7))."</span>", 'itemprop="item"');?>
            </li>
            <?
          }
        }
        $position_miga_color=3;
        if ((isset($donde['estilo']))){
          $position_miga_color=4;
          ?>
          <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <meta itemprop="position" content="3" />
            <?$colest.=anchor("tienda/".$this->uri->segment(2)."/estilo/".$donde['estilo'],  urldec($donde['estilo']),'class="link_button2" style="padding:7px;text-decoration:none;"')." ";
            echo anchor("tienda/".$this->uri->segment(2)."/estilo/".$donde['estilo'],  "<span itemprop='name'>".urldec($donde['estilo'])."</span>", 'itemprop="item"');?>
          </li>
          <?
        }
        if ((isset($donde['color']) && trim($donde['color'])!='')){
          ?>
          <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <meta itemprop="position" content="<?php echo $position_miga_color; ?>" />
            <?$colest.=anchor("tienda/".$this->uri->segment(2)."/color/".$donde['color'],  urldec($donde['color']),'class="link_button2" style="padding:7px;text-decoration:none;"')." ";
            echo anchor("tienda/".$this->uri->segment(2)."/color/".$donde['color'],  "<span itemprop='name'>".urldec($donde['color'])."</span>", 'itemprop="item"');?>
          </li>
          <?
        }?>
      </ul>
    </div>
  </div>
</div>
<?
if($esmarcas)
  $estasmigas=anchor("tienda","Inicio")." / ";
$this->session->set_userdata(array('migas'=>$estasmigas,'busqueda'=>current_url(),'colest'=>$colest))
?>