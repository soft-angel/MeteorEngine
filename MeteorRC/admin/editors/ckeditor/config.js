/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' },
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';
	//config.colorButton_colors = '00923E,F8C100,28166F';
	config.extraPlugins = 'colorbutton,colordialog,tabletools';
	config.colorButton_enableMore = true;
	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;h4;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

    // File manager
    // CKFSYS_PATH — путь к файловому менеджеру у вас, чтото типа /path/to/ckeditor/filemanager,
    // путь указывать от DOCUMENT_ROOT
    config.filebrowserBrowseUrl = '/MeteorRC/admin/editors/ckfsys-master/browser/default/browser.html?Connector=/MeteorRC/admin/editors/ckfsys-master/connectors/php/connector.php';
    config.filebrowserImageBrowseUrl = '/MeteorRC/admin/editors/ckfsys-master/browser/default/browser.html?type=Image&Connector=/MeteorRC/admin/editors/ckfsys-master/connectors/php/connector.php';
};
