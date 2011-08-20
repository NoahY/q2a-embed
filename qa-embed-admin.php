<?php
    class qa_embed_admin {

	function option_default($option) {
		
		switch($option) {
			case 'embed_video_width':
				return 425;
			case 'embed_video_height':
				return 349;
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
                qa_opt('embed_video_width',qa_post_text('embed_video_width'));
                qa_opt('embed_video_height',qa_post_text('embed_video_height'));
                qa_opt('embed_enable',qa_post_text('embed_enable'));
                $ok = 'Settings Saved.';
            }
            
                    
        // Create the form for display

            
            $fields = array();
            
            $fields[] = array(
                'label' => 'Enable Video Embedding',
                'tags' => 'NAME="embed_enable" onclick="if(this.checked) jQuery(\'#embed_options_container\').fadeIn(); else jQuery(\'#embed_options_container\').fadeOut();"',
                'value' => qa_opt('embed_enable'),
                'type' => 'checkbox',
                'note' => '<table id="embed_options_container" style="display:'.(qa_opt('embed_enable')?'block':'none').'"><tr><td>',
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
		'note' => '</td></tr></table>',
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

