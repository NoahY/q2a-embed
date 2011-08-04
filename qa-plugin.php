<?php

/*
        Plugin Name: Embed YouTube
        Plugin URI: 
        Plugin Description: Embed YouTube links
        Plugin Version: 0.2
        Plugin Date: 2011-07-30
        Plugin Author: NoahY
        Plugin Author URI: 
        Plugin License: GPLv2
        Plugin Minimum Question2Answer Version: 1.3
*/


	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
			header('Location: ../../');
			exit;
	}

	qa_register_plugin_module('widget', 'qa-embed-admin.php', 'qa_embed_admin', 'Embed Admin');
	
	if (qa_opt('embed_enable')) {
		qa_register_plugin_layer('qa-embed-layer.php', 'Embed Replacement Layer');	
	}


/*
	Omit PHP closing tag to help avoid accidental output
*/

