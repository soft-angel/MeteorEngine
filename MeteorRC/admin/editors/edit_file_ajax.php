<?require_once($_SERVER["DOCUMENT_ROOT"]."/MeteorRC/main/include/before.php");?>
<link rel="stylesheet" href="/MeteorRC/admin/editors/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="/MeteorRC/admin/editors/codemirror/theme/monokai.css">
<link rel="stylesheet" href="/MeteorRC/admin/editors/codemirror/addon/fold/foldgutter.css">
<link rel="stylesheet" href="/MeteorRC/admin/editors/codemirror/addon/dialog/dialog.css">


<script src="/MeteorRC/admin/editors/codemirror/lib/codemirror.js" type="text/javascript"></script>
<script src="/MeteorRC/admin/editors/codemirror/keymap/sublime.js" type="text/javascript"></script>
<!--
<script src="/MeteorRC/admin/editors/codemirror/addon/scroll/simplescrollbars.js"></script>
<link href="/MeteorRC/admin/editors/codemirror/addon/scroll/simplescrollbars.css">
-->
<!-- Tabs -->
<script src="/MeteorRC/admin/editors/codemirror/mode/markdown/markdown.js"></script>
<!-- Active Line -->
<script src="/MeteorRC/admin/editors/codemirror/addon/selection/active-line.js"></script>
<!--
<script src="/MeteorRC/admin/editors/codemirror/mode/scheme/scheme.js"></script>
-->
<!-- Close Tag -->
<script src="/MeteorRC/admin/editors/codemirror/addon/edit/closetag.js"></script>

<!-- Auto Complete 
<script src="/MeteorRC/admin/editors/codemirror/addon/hint/show-hint.js"></script>
<script src="/MeteorRC/admin/editors/codemirror/addon/hint/javascript-hint.js"></script>
-->

<!-- Lazy Mode Loading -->
<script src="/MeteorRC/admin/editors/codemirror/addon/mode/loadmode.js"></script>
<script src="/MeteorRC/admin/editors/codemirror/mode/meta.js"></script>


<script src="/MeteorRC/admin/editors/codemirror/addon/search/searchcursor.js"></script>
<script src="/MeteorRC/admin/editors/codemirror/addon/search/search.js"></script>
<script src="/MeteorRC/admin/editors/codemirror/addon/dialog/dialog.js"></script>
<script src="/MeteorRC/admin/editors/codemirror/addon/edit/matchbrackets.js"></script>
<script src="/MeteorRC/admin/editors/codemirror/addon/edit/closebrackets.js"></script>
<script src="/MeteorRC/admin/editors/codemirror/addon/comment/comment.js"></script>
<script src="/MeteorRC/admin/editors/codemirror/addon/wrap/hardwrap.js"></script>
<script src="/MeteorRC/admin/editors/codemirror/addon/fold/foldcode.js"></script>
<script src="/MeteorRC/admin/editors/codemirror/addon/fold/brace-fold.js"></script>
<?$fileUrl = $FIREWALL->GetString("FILE");?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 style="color: #fff;" class="modal-title">Редактирование файла: <?=$fileUrl?></h4>
</div>

<textarea style="display: none;" id="managerCode" name="CODE"><?
if($fileUrl){
  $filePatch = $_SERVER["DOCUMENT_ROOT"] . $fileUrl;
  if(file_exists($filePatch)){
    if(!is_writable($filePatch)){
      chmod($filePatch, $CONFIG['FILE_PERMISSIONS']);
    }
    echo file_get_contents($filePatch);
  } 
  file_get_contents($filePatch);
}?></textarea>

<style type="text/css">
  .cm-tab {
    background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAMCAYAAAAkuj5RAAAAAXNSR0IArs4c6QAAAGFJREFUSMft1LsRQFAQheHPowAKoACx3IgEKtaEHujDjORSgWTH/ZOdnZOcM/sgk/kFFWY0qV8foQwS4MKBCS3qR6ixBJvElOobYAtivseIE120FaowJPN75GMu8j/LfMwNjh4HUpwg4LUAAAAASUVORK5CYII=);
    background-position: right;
    background-repeat: no-repeat;
  }
  .CodeMirror {
      font-size: 17px;
      min-height: 500px;
      max-height: 100%;
  }
  button .fa-spinner, button.load i {
    display: none;
  }
  button.load .fa-spinner {
    display: inline-block;
  }
</style>
<div class="text-center" style="padding: 10px 0">
  <button id="file-save" type="button" class="btn btn-success m-r-5">
    <i class="fa fa-spinner fa-pulse fa-fw margin-bottom"></i>
    <i class="fa fa-floppy-o"></i> Сохранить</button>
  <button id="file-apply" type="button" class="btn btn-white m-r-5">
    <i class="fa fa-spinner fa-pulse fa-fw margin-bottom"></i>
    <i class="fa fa-check"></i> Применить</button>
</div>
<script>
$('#modal-editor').on('shown.bs.modal', function () {
  function change(fileName) {
    var val = fileName, m, mode, spec;
    if (m = /.+\.([^.]+)$/.exec(val)) {
      var info = CodeMirror.findModeByExtension(m[1]);
      if (info) {
        mode = info.mode;
        spec = info.mime;
      }
    } else if (/\//.test(val)) {
      var info = CodeMirror.findModeByMIME(val);
      if (info) {
        mode = info.mode;
        spec = val;
      }
    } else {
      mode = spec = val;
    }
    if (mode) {
      editor.setOption("mode", spec);
      CodeMirror.autoLoadMode(editor, mode);
      //document.getElementById("modeinfo").textContent = spec;
    } else {
      //alert("Could not find a mode corresponding to " + val);
    }
  }
  change("<?=$fileUrl?>");
});

$("#modal-editor .close").click(function() {
  closeBtn = true;
  $('#modal-editor').modal("hide");
});

$("#file-save").click(function(e) {
  $(this).addClass("load");
  SaveFile(this, '<?=$fileUrl?>', editor.getValue(), true)
});

$("#file-apply").click(function(e) {
  $(this).addClass("load");
  SaveFile(this, '<?=$fileUrl?>', editor.getValue());
});

function SaveFile(btn, file, code, close = false) {
    $.post( "/MeteorRC/admin/editors/save_file_ajax.php", {FILE:file, CODE:code}).done(function( respond ){
      var arRespond = JSON.parse(respond);
      setTimeout(function() {
        $(btn).removeClass("load");
      }, 300);
      if(arRespond.ERROR) {
        alert(arRespond.ERROR);
        return false;
      }else{
        if(close)
          $("#modal-editor .close").click();
        return true;
      }
    });
}
</script>