<?php
    class qa_embed_admin {

	function option_default($option) {
		
		switch($option) {
			case 'embed_video_width':
				return 425;
			case 'embed_video_height':
				return 349;
			default:
			    return false;				
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

