<?

$arUrlRewrite = array(

	array(

		"CONDITION" => "#^/work/#",

		"PATH" => "/work/index.php",

	),

	array(

		"CONDITION" => "#^/services/#",

		"PATH" => "/services/index.php",

	),

	array(

		"CONDITION" => "#^/articles/#",

		"PATH" => "/articles/index.php",

	),

	array(

		"CONDITION" => "#^/personal/orders/#",

		"PATH" => "/personal/orders/index.php",

	),

);

	foreach($arUrlRewrite as $val)

	{

		

		if(preg_match($val["CONDITION"], $_SERVER['REQUEST_URI']))

		{

				$_SERVER["REAL_FILE_PATH"] = $val["PATH"];

				$APPLICATION->RestartBuffer(); 

				require($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/header.php");

				include($_SERVER['DOCUMENT_ROOT'] . $val["PATH"]);

				include($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/footer.php");

				die;

		}

	}