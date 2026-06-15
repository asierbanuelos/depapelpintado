<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
</style>
<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
	<?php $this->load->view('includes/demo_header'); ?>
	<div class="container">
	<div>
		<a href='<?php echo site_url('admin_library/mkt_usr')?>'>Usuarios</a> |
		<a href='<?php echo site_url('admin_library/mkt_ord')?>'>Pedidos</a> |
		<a href='<?php echo site_url('admin_library/mkt_fab')?>'>Fabricantes</a> |
		<a href='<?php echo site_url('admin_library/mkt_col')?>'>Colecciones</a> 
		
	</div>
	<div style='height:20px;'> </div>  
	</div>
    <div class="container-fluid">
		<?php echo $output; ?>
    </div>

</body>
</html>
