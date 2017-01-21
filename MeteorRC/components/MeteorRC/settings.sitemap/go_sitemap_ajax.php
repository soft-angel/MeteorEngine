<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
	usleep(10000);
	include('SitemapUrl.class.php');
	include('Sitemap.class.php');
	$startTime = (isset($_REQUEST['startTime']) and !empty($_REQUEST['startTime']))?$_REQUEST['startTime']:time();
	$step = isset($_REQUEST['step'])?(int)$_REQUEST['step']:0;
	$countUrl = isset($_REQUEST['countUrl'])?$_REQUEST['countUrl']:0;
	$countIblockGenerate = isset($_REQUEST['countIblockGenerate'])?$_REQUEST['countIblockGenerate']:0;

	$iblockList = array(
		array(
			"COMPONENT" => "shop",
			"IBLOCK" => "products",
		),
		array(
			"COMPONENT" => "shop",
			"IBLOCK" => "sections",
		),
	);

	$countIblocks = count($iblockList);

	$sitemap = new Sitemap();
	$sitemap->needPing = true;
	$sitemap->iblock = $iblockList[$step];
	$sitemap->XMLsitemapTemplateName = '/sitemap_#IBLOCK#.#EXT#';
	$sitemap->XMLsitemapFull = '/sitemap.xml';

	if(!$countIblocks <= $step and isset($iblockList[$step])){
		//$sitemap->priority = 0.9;
		//$sitemap->changefreq = 'weekly';
		$sitemap->CheckSitemapExist();
		$countUrl = $sitemap->getIblockUrlList();
		$sitemap->generate();
	}
	$_SESSION["SITEMAP_GO"] = $respond = array(
		"countIblocks" => $countIblocks,
		"step" => $step,
		"countUrl" => $countUrl,
		"time" => time(),
		"startTime" => $startTime,
	);

	if($countIblocks <= $step){
		// Уничтожаем сохраненные параметры запуска, так как все выполнилось
		unset($_SESSION["SITEMAP_GO"]);
		// генерируем основной сайтмап содержащий сайтмапы инфоблоков
		$respond["sitemapUrl"] = $sitemap->GenerateSitemapIndex($iblockList);
	}
	echo json_encode ($respond);
}
?>