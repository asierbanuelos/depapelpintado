<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <title>Factura</title>


        <style>	@media only screen and (max-width: 300px){ 
                body {
                    width:218px !important;
                    margin:auto !important;
                }
                .table {width:195px !important;margin:auto !important;}
                .logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto !important;display: block !important;}		
                span.title{font-size:20px !important;line-height: 23px !important}
                span.subtitle{font-size: 14px !important;line-height: 18px !important;padding-top:10px !important;display:block !important;}		
                td.box p{font-size: 12px !important;font-weight: bold !important;}
                .table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr { 
                    display: block !important; 
                }
                .table-recap{width: 200px!important;}
                .table-recap tr td, .conf_body td{text-align:center !important;}	
                .address{display: block !important;margin-bottom: 10px !important;}
                .space_address{display: none !important;}	
            }
            @media only screen and (min-width: 301px) and (max-width: 500px) { 
                body {width:425px!important;margin:auto!important;}
                .table {width:400px!important;margin:auto!important;}	
                .logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}	
                .table-recap table, .table-recap tbody, .table-recap td, .table-recap tr { 
                    display: block !important; 
                }
                .table-recap{width: 295px !important;}
                .table-recap tr td, .conf_body td{text-align:center !important;}

            }
            @media only screen and (min-width: 501px) and (max-width: 768px) {
                body {width:478px!important;margin:auto!important;}
                .table {width:450px!important;margin:auto!important;}	
                .logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}			
            }
            @media only screen and (max-device-width: 480px) { 
                body {width:425px!important;margin:auto!important;}
                .table {width:285px;margin:auto!important;}	
                .logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}

                .table-recap{width: 295px!important;}
                .table-recap tr td, .conf_body td{text-align:center!important;}	
                .address{display: block !important;margin-bottom: 10px !important;}
                .space_address{display: none !important;}	
            }
        
        
      
	  
	  .contenedor {
		  width:100%;
		  height:100%;
		  margin:0;
		  padding:0;
		  box-sizing:border-box;
		 
	  }
	  .contenido {
		   width:100%;
		   min-height:768px;
		   max-width:700px;
		   margin-left:auto;
		   margin-right:auto;
		  
	  }
	  h2 {
		  font-size:15px;
	  }
	  a {
		  color: #87074c;
	  }
	  td {
		  padding-left:5px;
	  }
	  hr {
		  width:80%;
		  margin-left:10%;
		  border:1px solid #CCC;
		  height:2px;
	  }
	  .caja100 {
		  width:100%;
	  }
	  .caja100:after {
		  clear:both;
	  }
	  .logo1, .dire1, .logo2 {
		  float:left;
		  width:30%;
		  padding:1%;
		  text-align:center;
	  }
	  .dire1 p{
		  margin-top:0;
		  margin-bottom:0;
	  }
	  .logo1 img, logo2 img {
		  width:95%;
		  max-width:95%;
		  margin-left:2%;
		 
	  }
	  .limpiar {
		  clear:both;
		  width:100%;
		  height:1px;
	  }
	  .facturatitulo {
		  background-color:#CCC;
		  color:#333;
		  text-align:center;
	  }
	  .facturatitulo h1 {
		  text-transform:uppercase;
	  }
	  .datosfactura {
		  width:30%;
		  color:#999;
	  }
	  .borde-gral {
		  border:thin solid #CCC;
	  }
	  .borde-top {
		  border-top: thin solid #CCC;
	  }
	  .borde-bottom {
		   border-bottom: thin solid #CCC;
	  }
	  .borde-right {
		   border-right: thin solid #CCC;
	  }
	  .borde-left {
		   border-left: thin solid #CCC;
	  }
	  .fondocelda {
		  background-color:#dedede;
	  }
	  .datospie1 {
		  font-size:smaller;
		  text-align:center;
		     color:#666666;
	  }
	  .datospie2 {
		   text-align:center;
		   color:#999;
	  }
	  .izq {
		  float:left;
	  }
	   .der {
		   float:right;
	  }
	  
	  
	  </style>
      <!--fin custom css maider-->

    </head>
    <body style="-webkit-text-size-adjust:none;background-color:#fff;width:650px;font-family:Open-sans, sans-serif;color:#555454;font-size:13px;line-height:18px;margin:auto">
        <div class="table table-mail" style="width:100%;margin-top:10px;-moz-box-shadow:0 0 5px #afafaf;-webkit-box-shadow:0 0 5px #afafaf;-o-box-shadow:0 0 5px #afafaf;box-shadow:0 0 5px #afafaf;filter:progid:DXImageTransform.Microsoft.Shadow(color=#afafaf,Direction=134,Strength=5)">
            <font size="2" face="Open-sans, sans-serif" color="#555454">
                
<?= $pedido ?>

            </font>

        </div>
    </body>
</html>
