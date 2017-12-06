/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'pl';
	config.protectedSource.push( /<i class[\s\S]*?\>/g );
    config.protectedSource.push( /<\/i>/g );
	
	
	

	config.allowedContent = true; 
	
	config.extraPlugins = 'fontawesome';
	config.contentsCss = 'css/font-awesome.css';
	
	config.extraPlugins = 'widget';
	config.extraPlugins = 'lineutils';
	config.extraPlugins = 'colordialog';
	window.CKEDITOR.dtd.$removeEmpty['span'] = false;


};
