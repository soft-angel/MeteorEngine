<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/header.php");
echo $APPLICATION->httpResponseCode(404);
if(file_exists('404_content.php')){
	include('404_content.php');
}else{
?>
<div class="text-center text-danger">
	<p style="font-size: 50px;">404</p>
	<p style="font-size: 20px;">Страница не найдена</p>
</div>
<?}?>
<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/footer.php");?>