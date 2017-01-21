<?if(!defined("PROLOG_INCLUDED") || PROLOG_INCLUDED!==true)die();?>
<?
$arParams = $APPLICATION->GetComponentsParams($component["COMPONENT"], $component["IBLOCK"]);
$arElements = $APPLICATION->GetFileArray(FOLDER_BD . $arParams["COMPONENT"] . DS . $arParams["IBLOCK"] . SFX_BD);

if(!isset($_GET["edit_element"])){
    // Stata
    if(isset($arParams["STATA_TRACKING"]) and $arParams["STATA_TRACKING"] == 'Y'){
        $bdFile = STATA_PATCH . DS . $arParams["COMPONENT"] . DS . $arParams["IBLOCK"] . DS . date("Y.m") . SFX_BD;
        $arStata = $APPLICATION->GetFileArray($bdFile);
        // Stata
        foreach ($arStata as $id => $arDate) {
            foreach ($arDate as $key => $value) {
                $arElements[$id]['STATA_TRACKING'][] = $value['WIEWS'];
            }
        }
    }
}
?>
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
            <h1 class="page-header"><?=$arParams["ICON"]?> <?=$arParams["NAME"]?> <small><?=$arParams["DESCRIPTION"]?></small></h1>
            <!-- end page-header -->
            <!-- begin row -->
            <div class="row">
<?
if(!isset($_GET["edit_element"])){?>
<?
// Filter
if(isset($_REQUEST['FILTER'])){
    $arFilterValue = $FIREWALL->GetArrayString('FILTER');
    $_SESSION['FILTER']['ELEMENTS'][$arParams["COMPONENT"]][$arParams["IBLOCK"]] = $arFilterValue;
}else{
    $arFilterValue = $_SESSION['FILTER']['ELEMENTS'][$arParams["COMPONENT"]][$arParams["IBLOCK"]];
}
//p($arFilterValue);
foreach($arParams["FIELDS"] as $code => $field){
    if($field['TYPE'] == 'SELECT')
        $arFilterFields[$code] = $field;
    if($field['TYPE'] == 'SELECT_BD'){
        CJSCore::Init(array('select'));
        $component = (isset($field["COMPONENT_BD"]))?$field["COMPONENT_BD"]:$arParams["COMPONENT"];
        $arElementFilter = $APPLICATION->GetFileArray(FOLDER_BD . $component . DS . $field["BD"] . SFX_BD);
        foreach ($arElementFilter as $key => $value) {
            $field['SELECT'][$key] = $value['NAME'];
        }
        $arFilterFields[$code] = $field;
    }
}
?>
<?foreach ($arElements as $id => $product) {
    // Filter
    foreach ($arFilterValue as $code => $value) {
        if(!isset($arElements[$id][$code])){
            unset($arElements[$id]);
            break;
        }

        if(is_array($arElements[$id][$code])){
            if(!in_array($value, $arElements[$id][$code])){
                unset($arElements[$id]);
                break;
            }
        }elseif($value != $arElements[$id][$code]){
            unset($arElements[$id]);
            break;
        }
    }
}?>
<div class="panel panel-inverse" data-sortable-id="index-chat-history">
    <div class="panel-heading ui-sortable-handle">
        <h4 class="panel-title"><i class="fa fa-filter" aria-hidden="true"></i> Фильтр</h4>
    </div>
    <div class="panel-body bg-silver">
        <div id="filterElements">
            <div class="row">
                <div class="col-sm-12">
                    <form action="" method="POST" class="form-horizontal">
                        <div class="row">
        <?foreach ($arFilterFields as $code => $select) {?>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email"><?=$select['NAME']?>:</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select onchange="this.form.submit()" name="FILTER[<?=$code?>]" class="form-control selectpicker">
                                                <option value="">Не выбрано</option>
                                                <?foreach ($select['SELECT'] as $id => $name) {?>?>
                                                <option <?if($arFilterValue[$code] == $id){?>selected="selected"<?}?> value="<?=$id?>"><?=$name?></option>
                                                <?}?>
                                            </select>
                                             <span class="input-group-addon"><?=$arParams["FIELDS"][$code]["ICON"]?></span>
                                         </div>
                                    </div>
                                </div>
                            </div>
        <?}?>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-theme m-r-5"><i class="fa fa-search" aria-hidden="true"></i> Показать</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?}?>

                    <!-- begin panel -->
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            </div>
                            <h4 class="panel-title">
                            <?if(isset($arParams["TEXT_ADD"])){?>
                                <a href="?component=<?=$arParams["COMPONENT"]?>&amp;iblock=<?=$arParams["IBLOCK"]?>&amp;edit_element" class="btn btn-sm btn-theme m-r-5"><i class="fa fa-plus"></i> <?=$arParams["TEXT_ADD"]?></a>
                            <?}?>
                            </h4>
                        </div>
                        <div class="panel-body">
<?
if(isset($_GET["edit_element"])){
    include('elements_detail.php');
}else{
    include('elements_list.php');
}?>
                        </div>
                    </div>
                    <!-- end panel -->
            </div>
            <!-- end row -->
        </div>
        <!-- end #content -->