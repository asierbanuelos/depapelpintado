<nav>
  <ul>
    <li>ECONOMICOS</li>
    <li>MARCAS</li>
    <li>ESTILOS
      <ul>
        
        <?
        $count = 0;
        $first=0;
        $total=count($estilo);
        foreach ($estilo as $value) {
          if($categ==0){
          if($count==0){?>
          <ul class="estdest" style="width:200px; display:inline-block;background-color:#fff;">
            <b>
              <div>
                <div>Estilos Básicos
                </div>
              </div>
            </b><?}
          if($first==0 && $value->principal==0){
            ?>
          </ul>
          <ul style="width:200px; display:inline-block;background-color:#fff;">
            <b>
              <div>
                <div>&nbsp;
                </div>
              </div>
            </b>
            <?
          $first=$count;
          }
          if($count==ceil($first+(($total-$first)/3))){?>
          </ul>
          <ul style="width:200px; display:inline-block;background-color:#fff;">
            <b>
              <div>
                <div>Estilos Avanzados
                </div>
              </div>
            </b>
          <?}
          if($count==ceil($first+(($total-$first)/3)*2)){?>
          </ul>
          <ul style="width:200px; display:inline-block;background-color:#fff;">
            <b>
              <div>
                <div>&nbsp;
                </div>
              </div>
            </b><?
          
          }$count++;}
          ?>
          <li class="cell" style="width:200px;float:left;display:inline-block;">
            <a href="<?=base_url()?>tienda/<?=$this->uri->segment(2)?>//<?=$value->estilo_name?>/<?=($this->uri->total_segments()>3)?$this->uri->segment(4):""?>" id="est<?= $value->estilo_id ?>" /><?=$value->estilo_name?></a>
          </li>
          
        <?  } ?>
          </ul>
      </ul>
    </li>
    <li>COLORES
      <?
              $count = 0;
              $first=0;
              $total=count($gama);
             
              foreach ($gama as $value) {
                
                if($count==0){?>
      <ul style="width:200px; display:inline-block;background-color:#fff;">
        <div>
          <div >&nbsp;
          </div>
        </div><?
                }if($count==  ceil($total/3)){?>
      </ul>
      <ul style="width:200px; display:inline-block;background-color:#fff;">
        <div>
          <div>&nbsp;
          </div>
        </div>
          <?$first=$count;
                }if($count==  ceil($total/3)*2){?>
      </ul>
      <ul style="width:200px; display:inline-block;background-color:#fff;">
        <div>
          <div>&nbsp;
          </div>
        </div>
          <?
            
             }$count++;    
          ?>
        <li class="cell" style="float:left;width:100%">
          <a href="<?=base_url()?>tienda/<?=$this->uri->segment(2)?>//<?=$this->uri->segment(3)?>/<?=$value->gama_name?>" id="gama<?= $value->gama_id ?>" /><?=$value->gama_name?></a>
           <!--<input id="col<?= $value->gama_id ?>" type="checkbox" name="gama" value="<?= $value->gama_id ?>"/>
           <label title="<?= mb_strtolower($value->gama_name, 'UTF-8') ?>"  for="col<?= $value->gama_id ?>"><span style="background:<?=(strpos($value->rgb,'#') === false)?'url(\''.$includes_dir.'images/colores.jpg\') 0 '.(-($value->rgb*19)+20).'px':$value->rgb ?>"></span> <?= mb_strtolower($value->gama_name, 'UTF-8') ?></label>-->
        </li>   
              <? } ?>
      </ul>
    </li>
    <li>LOS MAS VENDIDOS</li>
  </ul>
</nav>
<ul>
  <?$this->load->view('frontend/prefichas', $this->data);?>
</ul>
