<div class="paginador">
<?php
    $itemsperpage=20;
    if($this->uri->segment(2)=="noimg")$curpage = $this->uri->segment(5);
    else $curpage = $this->uri->segment(3);
     if($curpage>4)
       if($this->uri->segment(2)=="noimg")echo anchor("admin_library/noimg/$curfab/$curcol/0/$curtodos/$curorder","<< ")."...";
       else{echo anchor("admin_library/".$this->uri->segment(2)."/0","<<");}
    for($i=0;$i<$count/$itemsperpage;$i++){
      if($i>$curpage-5 && $i<$curpage+5)
      if($curpage == $i)echo ($i+1)." - "; else {
        if($this->uri->segment(2)=="noimg") echo anchor("admin_library/noimg/$curfab/$curcol/$i/$curtodos/$curorder",($i+1))." - ";
        else{ echo anchor("admin_library/".$this->uri->segment(2)."/".$i,($i+1))." - ";}
      
      }
    }
    if($curpage<=$count-5){
     if($this->uri->segment(2)=="noimg") echo "...".anchor("admin_library/noimg/$curfab/$curcol/".floor($count/$itemsperpage)."/$curtodos/$curorder",">>");
     else echo anchor("admin_library/".$this->uri->segment(2)."/".floor($count/$itemsperpage),">>");
    }
      
    ?>
</div>
<div style="height: 20px;"></div>
