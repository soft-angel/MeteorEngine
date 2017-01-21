<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<?
if($USER->IsAdmin()){
$FILE = new $FILE;
$arSignature = include(__DIR__ . "/signature_reg.php");
$stepCount = 10;
$getStepCount = isset($_REQUEST['step'])?((int)$_REQUEST['step'] * (int)$stepCount):$stepCount;


$aMask = array("*.js");
include("signature.php");
$signatures = getSignatures();

$fileList = $FILE->GetFileList();

$countFile = count($fileList);
$allStep = (int)($countFile / $stepCount);


function multiexplode ($delimiters,$string) {
    
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}
function checkSpacesCnt($str){
  if(!is_string($str)) return false;
  foreach (multiexplode(array(PHP_EOL,'\n','\r\n', ' '), $str) as $key => $value) {
      if(500 < strlen($value))
        return $value;
  }

  return false;
}




$fileList = array_slice($fileList, $getStepCount, $stepCount);
//p($fileList);

$i = 0;
///$ex = false;
$result = array();
foreach ($fileList as $id => $file) {
		
		if(!file_exists($file["patch"]) or $file["size"] > 500 * 1024)
			continue;
		$i++;
		$content = file_get_contents($file["patch"]);
		//foreach ($aMask as $v) 
			//if (!fnmatch($v, basename($file))){
			//break;
			 //$ex = true;
			//}
			//if(!$ex)
		//if($matches = checkSpacesCnt($content)){
		//	$result[$id]["desc"] = $file["patch"];
		//    $result[$id]["color"] = "danger";
		//	  $result[$id]["id"] = $id;
		//    $result[$id]["matches"][0] = $matches;
		//    continue;
		//}
		foreach ($arSignature as $signature) {
			if($signature["f"] == "filename")continue;
				//$pos = strpos($content, $signature["s"]);
			//echo $signature["s"];
				if ($pos = preg_match($signature["s"], $content, $matches)) {
						$result[$id]["desc"] = $signature["d"] . ' найдено в (' . $file['patch'] . ')';
						$result[$id]["id"] = $id;
						if(isset($signature["l"]))
							$result[$id]["color"] = $signature["l"];
						if(isset($matches[0]))
							$result[$id]["matches"][] = $matches[0];
				}

		}
		unset($content, $pos);
}
//print_r($fileList);
echo json_encode (
	array(
		"countFile" => $countFile,
		"stepCount" => $stepCount,
		"getStepCount" => $getStepCount,
		"allStep" => $allStep,
		"result" => $result,
	)
);
}
?>