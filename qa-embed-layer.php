<?php

	class qa_html_theme_layer extends qa_html_theme_base {

	// theme replacement functions

		function head_custom()
		{
			qa_html_theme_base::head_custom();
			if(qa_opt('embed_enable_thickbox')) { 
				$this->output('<script type="text/javascript" src="'.QA_HTML_THEME_LAYER_URLTOROOT.'thickbox.js"></script>');
				$this->output('<link rel="stylesheet" href="'.QA_HTML_THEME_LAYER_URLTOROOT.'thickbox.css" type="text/css" media="screen" />');
			}
		}
		function q_view_content($q_view)
		{
			if (isset($q_view['content'])){
				$q_view['content'] = $this->embed_replace($q_view['content']);
			}
			qa_html_theme_base::q_view_content($q_view);
		}
		function a_item_content($a_item)
		{
			if (isset($a_item['content'])) {
				$a_item['content'] = $this->embed_replace($a_item['content']);
			}
			qa_html_theme_base::a_item_content($a_item);
		}
		function c_item_content($c_item)
		{
			if (isset($c_item['content'])) {
				$c_item['content'] = $this->embed_replace($c_item['content']);
			}
			qa_html_theme_base::c_item_content($c_item);
		}

		function embed_replace($text) {
			
			$w  = qa_opt('embed_video_width');
			
			$h = qa_opt('embed_video_height');
			
			$w2 = qa_opt('embed_image_width');
			
			$h2 = qa_opt('embed_image_height');
			
			$types = array(
				'youtube'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*youtube\.com\/watch\?\S*v=([A-Za-z0-9_-]+)[^< ]*',
						'<iframe width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/$1?wmode=transparent" frameborder="0" allowfullscreen></iframe>'
					),
					array(
						'https{0,1}:\/\/w{0,3}\.*youtu\.be\/([A-Za-z0-9_-]+)[^< ]*',
						'<iframe width="'.$w.'" height="'.$h.'" src="http://www.youtube.com/embed/$1?wmode=transparent" frameborder="0" allowfullscreen></iframe>'
					)
				),
				'vimeo'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*vimeo\.com\/([0-9]+)[^< ]*',
						'<iframe src="http://player.vimeo.com/video/$1?title=0&amp;byline=0&amp;portrait=0&amp;wmode=transparent" width="'.$w.'" height="'.$h.'" frameborder="0"></iframe>')
				),
				'metacafe'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*metacafe\.com\/watch\/([0-9]+)\/([a-z0-9_]+)[^< ]*',
						'<embed flashVars="playerVars=showStats=no|autoPlay=no" src="http://www.metacafe.com/fplayer/$1/$2.swf" width="'.$w.'" height="'.$h.'" wmode="transparent" allowFullScreen="true" allowScriptAccess="always" name="Metacafe_$1" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>'
					)
				),
				'dailymotion'=>array(
					array(
						'https{0,1}:\/\/w{0,3}\.*dailymotion\.com\/video\/([A-Za-z0-9]+)[^< ]*',
						'<iframe frameborder="0" width="'.$w.'" height="'.$h.'" src="http://www.dailymotion.com/embed/video/$1?wmode=transparent"></iframe>'
					)
				),
				'image'=>array(
					array(
						'(https*:\/\/[-\%_\/.a-zA-Z0-9+]+\.(png|jpg|jpeg|gif|bmp))[^< ]*',
						'<img src="$1" style="max-width:'.$w2.'px;max-height:'.$h2.'px" />','img'
					)
				),
				'mp3'=>array(
					array(
						'(https*:\/\/[-\%_\/.a-zA-Z0-9]+\.mp3)[^< ]*',qa_opt('embed_mp3_player_code'),'mp3'
					)
				),
				'gmap'=>array(
					array(
						'(https*:\/\/maps.google.com\/?[^< ]+)',
						'<iframe width="'.qa_opt('embed_gmap_width').'" height="'.qa_opt('embed_gmap_height').'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="$1&amp;ie=UTF8&amp;output=embed"></iframe><br /><small><a href="$1&amp;ie=UTF8&amp;output=embed" style="color:#0000FF;text-align:left">View Larger Map</a></small>','gmap'
					)
				),
			);

			foreach($types as $t => $ra) {
				foreach($ra as $r) {
					if( (!isset($r[2]) && !qa_opt('embed_enable')) || (isset($r[2]) && !qa_opt('embed_enable_'.$r[2])) ) continue;
					
					if(isset($r[2]) && @$r[2] == 'img' && qa_opt('embed_enable_thickbox') && preg_match('/MSIE [5-7]/',$_SERVER['HTTP_USER_AGENT']) == 0) {
						preg_match_all('/'.$r[0].'/',$text,$imga);
						if(!empty($imga)) {
							foreach($imga[1] as $img) {
								$replace = '<a href="'.$img.'" class="thickbox"><img  src="'.$img.'" style="max-width:'.$w2.'px;max-height:'.$h2.'px" /></a>';
								$text = preg_replace('|<a[^>]+>'.$img.'</a>|i',$replace,$text);
								$text = preg_replace('|(?<![\'"=])'.$img.'|i',$replace,$text);
							}
						}
						continue;
					}
					$text = preg_replace('/<a[^>]+>'.$r[0].'<\/a>/i',$r[1],$text);
					$text = preg_replace('/(?<![\'"=])'.$r[0].'/i',$r[1],$text);
				}
			}
			
			/* Files that were uploaded to q2a get a URL like: ./?qa=blob&qa_blobid=14985201715764609123
			 * The regex-checks above cannot find the filetype as it is not specified in the URL.
			 * However, we can extract the blobid and request the filetype from the DB,
			 * according to the filetype we can set the correct html embed tags.
			 * Filetype of interest: PDF
			 * Note: The PDF-embed is added to the end of the post.
			 * by q2apro.com
			 */
			 
			/* Important: With q2a v1.6.3 and lower, the qa-include/qa-blob.php must be changed 
			 * to achieve correct serving of the PDF file.
			 * See here for details: http://www.question2answer.org/qa/33645/
			 * Probably this will be solved with q2a v1.7
			 */
			 
			 
			if(qa_opt('embed_pdf_from_blob')) {
				// do we have a bloburl in the post text
				if(strpos($text,'qa_blobid=') !== false) {
					$allBlobURLs = array();
					
					// get all URLs
					$urls = $this->q2apro_getUrlsFromString($text);
					foreach($urls as $urln) {
						if(strpos($urln,'qa_blobid=') !== false) {
							// found blobid add link to array
							$allBlobURLs[] = $urln;
						}
					}
					
					// @NoahY: for later language file needed
					$lang_nopdfplugin = 'Your browser does not have a PDF plugin installed.';
					$lang_downloadpdf = 'Download the PDF:';
					
					// we found blobURLs
					if(count($allBlobURLs)>0) {
						// remove duplicates from array and go over all items
						foreach(array_unique($allBlobURLs) as $blobURL) {
							// extract the blobid from the blobURL
							$urlArray = explode('=',$blobURL);
							$blobid = $urlArray[sizeof($urlArray)-1];
							
							if($blobid!='') {
								// query the filetype
								$blobFF = qa_db_read_one_assoc( qa_db_query_sub('SELECT format,filename FROM `^blobs` 
																					WHERE blobid = # 
																					', $blobid), true );
								if(isset($blobFF['format']) && $blobFF['format']=='pdf') {
									$pdfname = $blobFF['filename']; 
									if(is_null($pdfname)) {
										$pdfname = 'Document';
									}
									// we have a pdf, add embed to the end of the post
									$text .= '<object data="'.$blobURL.'" type="application/pdf" style="width:100%;height:600px;border:1px solid #DDD;"> 
									<embed src="'.$blobURL.'" />
									<p>'.$lang_nopdfplugin.'</p>
									</object>
									<p style="margin:10px 0 50px 0;">'.$lang_downloadpdf.' <a href="'.$blobURL.'">'.$pdfname.'</a></p>';
								}
							}
						}
					}
				}
			}
			return $text;
		}
		
		function q2apro_getUrlsFromString($string) {
			$regex = '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i';
			preg_match_all($regex, $string, $matches);
			return $matches[0];
		}
 
	}

