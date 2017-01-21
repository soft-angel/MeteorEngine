<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
$FILE = new $FILE;
$stepCount = 30;
$result = array();
$step = isset($_REQUEST['step'])?(int)$_REQUEST['step']:0;
$getStepCount = ((int)$step * $stepCount);
$countAddFile = isset($_REQUEST['countAddFile'])?$_REQUEST['countAddFile']:0;
if(isset($_REQUEST['archiveTime']) and $_REQUEST['archiveTime']){
	$archiveTime = $_REQUEST['archiveTime'];
}else{
	$archiveTime = time();
}
// массив для исключений
$arExceptions = array(
	"/MeteorRC/backups/",
	"/MeteorRC/logs/",
	"/MeteorRC/cache/",
);
$fileList = $FILE->GetFileList();

$countFile = count($fileList);
$allStep = (int)($countFile / $stepCount);

$fileList = array_slice($fileList, $getStepCount, $stepCount);
//p($fileList);


///$ex = false;



if(!extension_loaded('zip')){
	$result = "В php не установлена библиотека \"zip\"";
}else{
	$zip = new ZipArchive();
	$backupName = PATCH_BACKUPS ."/backup_" . $archiveTime . ".zip";
	if($zip->open($backupName, ZIPARCHIVE::CREATE)!== TRUE){
		$result =  "Sorry ZIP creation failed at this time<br/>";
	}
	$countExceptions = 0;
	foreach ($fileList as $id => $file) {
			//if(!file_exists($file["patch"]) or $file["size"] > 5000 * 1024)
				//continue;
			$rootFileName = str_replace(DR . DS, "", $file["patch"]);
			//echo $rootFileName;
			$fileException = false;
			foreach ($arExceptions as $exception) {
				// Есть ли файл в исключении?
				if(stripos(DS . $rootFileName, $exception) === 0){
					$countExceptions++;
					$fileException = true;
					break;
				}
			}
			if(!$fileException){
				$countAddFile++;
				$zip->addFile($file["patch"], $rootFileName);
			}
	}
	$zip->close();
}
$respond = array(
	"countFile" => $countFile,
	"stepCount" => $stepCount,
	"getStepCount" => $getStepCount,
	"step" => $step,
	"archiveTime" => $archiveTime,
	"allStep" => $allStep,
	"result" => $result,
	"countAddFile" => $countAddFile,
	"backupName" => "backup_" . $archiveTime . ".zip",
	"time" => time(),
);
$_SESSION["BACKUP_GO"] = $respond;

if($allStep <= $step)
	unset($_SESSION["BACKUP_GO"]);
//print_r($fileList);
echo json_encode ($respond);
}
?>