<?php

	class qa_html_theme_layer extends qa_html_theme_base {

	// theme replacement functions

			function q_view_content($q_view)
			{
					if (!empty($q_view['content'])){
							$q_view['content'] = $this->embed_replace($q_view['content']);
							qa_html_theme_base::q_view_content($q_view);
					}
			}
			function a_item_content($a_item)
			{
					$a_item['content'] = $this->embed_replace($a_item['content']);
					qa_html_theme_base::a_item_content($a_item);
			}
			function c_item_content($c_item)
			{
					$c_item['content'] = $this->embed_replace($c_item['content']);
					qa_html_theme_base::c_item_content($c_item);

			}

			function embed_replace($text) {

					$types = array(
							'youtube'=>array('http:\/\/www\.youtube\.com\/watch\?\S*v=([A-Za-z0-9_-]+)[^< ]*','<iframe width="'.qa_opt('embed_video_width').'" height="'.qa_opt('embed_video_height').'" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>'),
							'vimeo'=>array('http:\/\/www\.vimeo\.com\/([0-9]+)[^< ]*','<iframe src="http://player.vimeo.com/video/22775189?title=0&amp;byline=0&amp;portrait=0" width="'.qa_opt('embed_video_width').'" height="'.qa_opt('embed_video_height').'" frameborder="0"></iframe>'),
					);

					foreach($types as $t => $r) {
							$text = preg_replace('/<a[^>]+>'.$r[0].'<\/a>/i',$r[1],$text);
							$text = preg_replace('/(?<![\'"])'.$r[0].'/i',$r[1],$text);
					}
					return $text;
			}
	}

