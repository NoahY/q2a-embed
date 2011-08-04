<?php

	class qa_html_theme_layer extends qa_html_theme_base {

	// theme replacement functions

		function q_view_content($q_view)
		{
			if (!empty($q_view['content'])){
				$output = $this->embed_replace($q_view['content']);
				$this->output(
					'<DIV CLASS="qa-q-view-content">',
					$output,
					'</DIV>'
				);
			}
		}
		function a_item_content($a_item)
		{
			$output = $this->embed_replace($a_item['content']);
			$this->output(
				'<DIV CLASS="qa-a-item-content">',
				$output,
				'</DIV>'
			);
		}
		
		function embed_replace($text) {

			$types = array(
					'youtube'=>array('/(?<!["\'])http:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9\-_]+)/','<iframe width="425" height="349" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>')
				);
			
			foreach($types as $t => $r) {
				preg_match_all($r[0], $text, $urls);
				
				if(count($urls) > 0) {
					foreach($urls as $url) {
						$text = preg_replace($r[0],$r[1],$text);
					}
				}
			}
			return $text;
		}
	}

