<?php
$gaur=date('Y-m-d');
$urtea=date('Y');

//if (isset($_GET['sello'])){
if ($gaur > $urtea.'-01-10' && $gaur < $urtea.'-02-17'){
  echo "<div id='sello-esquina'>REBAJAS</div>";
  ?>
  <style>
    #sello-esquina{transform: rotate(-45deg);background-color: #b47c9a;color: white;position: absolute;top: 50px;left: -110px;width: 350px;text-align: center;padding: 2px;z-index: 1;}
  </style>
<?php
}
?>