<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?$APPLICATION->IncludeComponent("MeteorRC:settings.agents", "", 
	array(
		"COMPONENT" => "settings",
		"IBLOCK" => "agents",
	), 
	false
);?>