<?php
// 2025-05-14 Para intentar evitar la verificación de robot que salta en algunos usuarios y navegadores, descargamos los ficheros del CDN a local
/*
//<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
//<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.8/popper.min.js"></script>
//<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
*/
?>
<script src="/js/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/js/ajax/libs/popper.js/1.0.8/popper.min.js"></script>
<script src="/js/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>

<!-- JS Includes -->
<?php
/*
<script src="js/jquery-3.6.3.min"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

<script src="/includes/js/jquery-172.min.js"></script>

<script src="<?php echo $includes_dir;?>js/jquery.tools.tooltips.min.js?v=1.0"></script>
*/
?>

<script src="<?php echo $includes_dir;?>js/global.js?v=1.0"></script>
<?php 
/* Los pasamos al footer
	<script src="/incudes/js/jquery.zoomy.min.js"></script>

*/
?>

<?php if (isset($current_url['admin_library']) || isset($current_url['user_guide'])) { ?>
<script src="<?php echo $includes_dir;?>js/admin_global.js?v=1.0"></script>
<?php } ?>

