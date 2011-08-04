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
					'youtube'=>array('http:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9\-_]+)','<iframe width="425" height="349" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>')
				);
			
			foreach($types as $t => $r) {
				$text = preg_replace('/<a[^>]+>'.$r[0].'<\/a>/i',$r[1],$text);
				$text = preg_replace('/(?<![\'"])'.$r[0].'/i',$r[1],$text);
			}
			return $text;
		}
	}

