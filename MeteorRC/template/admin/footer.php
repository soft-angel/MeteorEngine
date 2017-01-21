<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true) die();?>
	<!-- ================== BEGIN BASE JS ================== -->
	
	<?$APPLICATION->AddHeadScript("/MeteorRC/js/plugins/jquery/jquery-migrate-1.1.0.min.js");?>
	<!--[if lt IE 9]>
		<script src="<?=SITE_TEMPLATE_PATH?>js/crossbrowserjs/html5shiv.js"></script>
		<script src="<?=SITE_TEMPLATE_PATH?>js/crossbrowserjs/respond.min.js"></script>
		<script src="<?=SITE_TEMPLATE_PATH?>js/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . "js/admin.apps.min.js");?>
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>

</body>
</html>