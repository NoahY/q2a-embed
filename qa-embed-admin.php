<?php
    class qa_embed_admin {

	function option_default($option) {
		
	    switch($option) {
		case 'embed_video_width':
		case 'embed_image_width':
		case 'embed_gmap_width':
		    return 425;
		case 'embed_video_height':
		case 'embed_image_height':
		case 'embed_gmap_height':
		    return 349;
		case 'embed_thickbox_thumb':
		    return 64;
		default:
		    return null;				
	    }
		
	}
        
	function allow_template($template)
	{
		return ($template!='admin');
	}       
		
	function admin_form(&$qa_content)
	{                       
						
	// Process form input
		
		$ok = null;
		
		if (qa_clicked('embed_save')) {
			qa_opt('embed_enable',(bool)qa_post_text('embed_enable'));
			qa_opt('embed_video_width',qa_post_text('embed_video_width'));
			qa_opt('embed_video_height',qa_post_text('embed_video_height'));
			qa_opt('embed_enable_img',(bool)qa_post_text('embed_enable_img'));
			qa_opt('embed_image_width',qa_post_text('embed_image_width'));
			qa_opt('embed_image_height',qa_post_text('embed_image_height'));
			qa_opt('embed_enable_thickbox',(bool)qa_post_text('embed_enable_thickbox'));
			qa_opt('embed_enable_mp3',(bool)qa_post_text('embed_enable_mp3'));
			qa_opt('embed_enable_gmap',(bool)qa_post_text('embed_enable_gmap'));
			$ok = qa_lang('admin/options_saved');
		}
  
	    qa_set_display_rules($qa_content, array(
		    'embed_video_height' => 'embed_enable',
		    'embed_video_width' => 'embed_enable',
	    ));
                    
        // Create the form for display

            
		$fields = array();
		
		$fields[] = array(
			'label' => 'Enable video embedding',
			'tags' => 'NAME="embed_enable"',
			'value' => qa_opt('embed_enable'),
			'type' => 'checkbox',
		);
	    $fields[] = array(
			'label' => 'Embeded video width',
			'type' => 'number',
			'value' => qa_opt('embed_video_width'),
			'tags' => 'NAME="embed_video_width"',
	    );                    
	    $fields[] = array(
			'label' => 'Embeded video height',
			'type' => 'number',
			'value' => qa_opt('embed_video_height'),
			'tags' => 'NAME="embed_video_height"',
	    );                    
            
		$fields[] = array(
			'type' => 'blank',
		);
		
		
		$fields[] = array(
			'label' => 'Enable image embedding',
			'tags' => 'NAME="embed_enable_img"',
			'value' => qa_opt('embed_enable_img'),
			'type' => 'checkbox',
		);
            
 	    $fields[] = array(
		'label' => 'Image width',
		'type' => 'number',
		'value' => qa_opt('embed_image_width'),
		'tags' => 'NAME="embed_image_width"',
	    );                    
	    $fields[] = array(
		'label' => 'Image height',
		'type' => 'number',
		'value' => qa_opt('embed_image_height'),
		'tags' => 'NAME="embed_image_height"',
	    ); 
		$fields[] = array(
			'label' => 'Enable thickbox image effect',
			'tags' => 'NAME="embed_enable_thickbox"',
			'value' => qa_opt('embed_enable_thickbox'),
			'type' => 'checkbox',
		);
	               
		$fields[] = array(
			'type' => 'blank',
		);

		$fields[] = array(
			'label' => 'Enable mp3 embedding',
			'tags' => 'NAME="embed_enable_mp3"',
			'value' => qa_opt('embed_enable_mp3'),
			'type' => 'checkbox',
		);

		$fields[] = array(
			'type' => 'blank',
		);
		
		
		$fields[] = array(
			'label' => 'Enable Google maps embedding',
			'tags' => 'NAME="embed_enable_gmap"',
			'value' => qa_opt('embed_enable_gmap'),
			'type' => 'checkbox',
		);
            
 	    $fields[] = array(
		'label' => 'Map width',
		'type' => 'number',
		'value' => qa_opt('embed_gmap_width'),
		'tags' => 'NAME="embed_gmap_width"',
	    );                    
	    $fields[] = array(
		'label' => 'Map height',
		'type' => 'number',
		'value' => qa_opt('embed_gmap_height'),
		'tags' => 'NAME="embed_gmap_height"',
	    ); 

		return array(           
			'ok' => ($ok && !isset($error)) ? $ok : null,
				
			'fields' => $fields,
		 
			'buttons' => array(
				array(
					'label' => 'Save',
					'tags' => 'NAME="embed_save"',
				)
			),
		);
	}
}

