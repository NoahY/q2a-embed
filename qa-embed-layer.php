<?php

	class qa_html_theme_layer extends qa_html_theme_base {

	// theme replacement functions

			function q_view_content($q_view)
			{
				if (qa_opt('embed_enable') && isset($q_view['content'])){
					$q_view['content'] = $this->embed_replace($q_view['content']);
				}
				qa_html_theme_base::q_view_content($q_view);
			}
			function a_item_content($a_item)
			{
				if (qa_opt('embed_enable') && isset($a_item['content'])) {
					$a_item['content'] = $this->embed_replace($a_item['content']);
				}
				qa_html_theme_base::a_item_content($a_item);
			}
			function c_item_content($c_item)
			{
				if (qa_opt('embed_enable') && isset($c_item['content'])) {
					$c_item['content'] = $this->embed_replace($c_item['content']);
				}
				qa_html_theme_base::c_item_content($c_item);
			}

			function embed_replace($text) {
					
					$w  = qa_opt('embed_video_width');
					
					$h = qa_opt('embed_video_height');
					
					$types = array(
							'youtube'=>array('http:\/\/www\.youtube\.com\/watch\?\S*v=([A-Za-z0-9_-]+)[^< ]*','<iframe width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/$1?wmode=transparent" frameborder="0" allowfullscreen></iframe>'),
							'vimeo'=>array('http:\/\/www\.vimeo\.com\/([0-9]+)[^< ]*','<iframe src="http://player.vimeo.com/video/22775189?title=0&amp;byline=0&amp;portrait=0&wmode=transparent" width="'.$w.'" height="'.$h.'" frameborder="0"></iframe>'),
							'metacafe'=>array('http:\/\/www\.metacafe\.com\/watch\/([0-9]+)\/([a-z0-9_]+)[^< ]*','<embed flashVars="playerVars=showStats=no|autoPlay=no" src="http://www.metacafe.com/fplayer/$1/$2.swf" width="'.$w.'" height="'.$h.'" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_$1" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>'),
							'dailymotion'=>array('http:\/\/www\.dailymotion\.com\/video\/([A-Za-z0-9]+)[^< ]*','<iframe frameborder="0" width="'.$w.'" height="'.$h.'" src="http://www.dailymotion.com/embed/video/$1?wmode=transparent"></iframe>'),
							'image'=>array('(https*:\/\/[-\%_\/.a-zA-Z0-9]+\.(png|jpg|jpeg|gif|bmp))[^< ]*','<img src="$1" style="max-width:'.$w.'px;max-height:'.$h.'px" />'),
							'mp3'=>array('(https*:\/\/[-\%_\/.a-zA-Z0-9]+\.mp3)[^< ]*','<embed type="application/x-shockwave-flash" flashvars="audioUrl=$1" src="http://www.google.com/reader/ui/3523697345-audio-player.swf" width="400" height="27" quality="best"></embed>'),
					);

					foreach($types as $t => $r) {
							$text = preg_replace('/<a[^>]+>'.$r[0].'<\/a>/i',$r[1],$text);
							$text = preg_replace('/(?<![\'"=])'.$r[0].'/i',$r[1],$text);
					}
					return $text;
			}
	}

