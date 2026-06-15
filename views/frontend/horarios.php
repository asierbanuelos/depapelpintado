<?php 
$gaur=date('Y-m-d');
//~ $gaur='2021-08-28';
$hilabete_eguna=date('m-d');
//~ $hilabete_eguna='08-31';
global $horario;
if ($hilabete_eguna>='08-01' && $hilabete_eguna<='08-31'){
  $horario="Horario de verano: de lunes a viernes de 9:00h a 15:00h";
  //if ($gaur <= '2022-08-26')  
  //  echo "<br />Viernes 26 de agosto cerrado por festivo local \n";
}
else{
  $horario= "De 9:30h a 14:30h <span class='text-nowrap'>y de 16:30h a 18:30h</span> \n";
  $horario.= "<br />Viernes de 9:30h a 15:00h  \n";
}
if ($gaur <= '2022-08-26')  
  $horario= "<br />Viernes 26 de agosto cerrado por festivo local \n";
  
if ($hilabete_eguna=='07-25')
  $horario= "25 de julio cerrado por festivo \n";
if ($hilabete_eguna=='07-31')
  $horario= "31 de julio cerrado por festivo local \n";

echo $horario
?>
