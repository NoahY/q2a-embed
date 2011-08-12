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
					
					$w  = qa_opt('embed_video_width');
					
					$h = qa_opt('embed_video_height');
					
					$types = array(
							'youtube'=>array('http:\/\/www\.youtube\.com\/watch\?\S*v=([A-Za-z0-9_-]+)[^< ]*','<iframe width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>'),
							'vimeo'=>array('http:\/\/www\.vimeo\.com\/([0-9]+)[^< ]*','<iframe src="http://player.vimeo.com/video/22775189?title=0&amp;byline=0&amp;portrait=0" width="'.$w.'" height="'.$h.'" frameborder="0"></iframe>'),
							'metacafe'=>array('http:\/\/www\.metacafe\.com\/watch\/([0-9]+)\/([a-z0-9_]+)[^< ]*','<embed flashVars="playerVars=showStats=no|autoPlay=no" src="http://www.metacafe.com/fplayer/$1/$2.swf" width="'.$w.'" height="'.$h.'" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_$1" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>'),
					);

					foreach($types as $t => $r) {
							$text = preg_replace('/<a[^>]+>'.$r[0].'<\/a>/i',$r[1],$text);
							$text = preg_replace('/(?<![\'"])'.$r[0].'/i',$r[1],$text);
					}
					return $text;
			}
	}
http://www.metacafe.com/watch/6906261/coin_symbolizes_strength_and_power/
<embed flashVars="playerVars=showStats=no|autoPlay=no" src="http://www.metacafe.com/fplayer/5941379/metaminute_marvel_vs_capcom_3.swf" width="440" height="272" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_5941379" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
