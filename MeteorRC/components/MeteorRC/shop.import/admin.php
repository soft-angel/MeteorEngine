<?
if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();
$FILE = new FILE;
$arParams = $APPLICATION->GetFileArray(__DIR__ . '/.parametrs.php');
?>
<?CJSCore::Init(array('fileinput', 'select'));?>




		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="/"><i class="fa fa-home"></i></a></li>
				<li><a href="javascript:;">Панель управления</a></li>
				<li class="active"><?=$arParams["NAME"]?></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header"><?=$arParams["ICON"]?> <?=$arParams["NAME"]?> <small><?=$arParams["COMPONENT"]?></small></h1>
			<!-- end page-header -->
			<!-- begin row -->
			<div class="row">
            <form action="/MeteorRC/shop.import/import_ajax.php" method="post" enctype="multipart/form-data">
             <label class="control-label">Выберите .xml файл для импорта</label>
             <input id="import" name="FILES[]" type="file">
            </form>


            <div id="table-import"></div>
            </div>
            <!-- end row -->
		</div>
		<!-- end #content -->
<script type="text/javascript">

$(document).on("ready", function() {
    $("#import").fileinput({
        uploadAsync: false,
        uploadUrl: "/MeteorRC/components/MeteorRC/shop.import/import_ajax.php" // your upload server url
    });
    $('#import').on('filebatchuploadsuccess', function(event, data) {
        
        if($("#table-import").html(data.response.table)){
            $.getScript( "/MeteorRC/components/MeteorRC/shop.import/js/import-form.js", function( data, textStatus, jqxhr ) {
            });
        }
    });
});
</script>


