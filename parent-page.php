<?php 
 $ch = curl_init(); 
// THIS IS POST BY CATEGORY QUERY
//$postURL = $a['url'] . "/wp-json/wp/v2/categories/?slug=fisch-feines";
//$postURL = $a['url'] . "/wp-json/wp/v2/posts?categories=".$singleCat['name']."&order=desc&orderby=date&per_page=1&_embed";
//$tag_check = $_GET["tags"];
$tag_check = 10;
//$current_cats = $_GET["categories"];

//$postURL = $a['url'] . "/wp-json/wp/v2/posts?categories=".$current_cats."&_embed"; 
$postURL = $a['url'] . "/wp-json/wp/v2/posts?categories=".$a['category']."&_embed"; 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$postURL);
		$post_result=curl_exec($ch);
		$allPosts = json_decode($post_result, true);

		$i=0;
	    $count_posts = count($allPosts);
		
		$checkAlreadyinArray = array();
	    $messe_post_html_data .='
		<!--<div class="column mcb-column one column_column ">
			<div class="column_attr clearfix align_center animate fadeIn" data-anim-type="fadeIn" style=" padding:20px 0px 0px 0px;">
				<h2>Pressemitteilungen</h2>
			</div>
		</div>-->
		<ul class="mm_list_class mm_list_class_child mm_list_class1">';
		//print_r($allPosts);
	     
		foreach($allPosts as $post):
		
		// Reformet DATE TIME for Sorting
 		$rest_year = substr($post['acf']['press_date'], 0, 4);
    	$rest_month = substr($post['acf']['press_date'], 5, 2);
    	$rest_day = substr($post['acf']['press_date'], 8,2); 
    	$newDateTime = $rest_day . '.' . $rest_month . '.' . $rest_year;
 		
		$postFilter = $post['acf']['absender'];
		//$all_content = wp_strip_all_tags($post['content']['rendered'],false);  
		$all_content = $post['content']['rendered']; 
		//$all_content = strip_tags( $post['content']['rendered'], '<p><br>' ); 
	    
		// STRIP SPECIFIC TAGS FUNCTION
	    $tags_to_strip = Array("div","font");
		foreach ($tags_to_strip as $tag):
			$all_content = preg_replace("/<\\/?" . $tag . "(.|\\s)*?>/",$replace_with,$all_content);
		endforeach;
		// ADD ALL LINK TAGS _blank TARGET 
		$all_content = preg_replace("/<a(.*?)>/", "<a$1 target=\"_blank\">", $all_content);

	
		$excpt_content = wp_strip_all_tags($post['excerpt']['rendered']);

		$totalImages = $post['acf']['pressemeldungen_images'];
		$pdf_file = $post['acf']['attachment_file'];
		$domain_to_publish_news = "";
		$domain_to_publish_news = $post['acf']['domain_to_publish_news'];

		$pdf_file_name = parse_url($pdf_file);
		$filename = basename($pdf_file_name["path"]); // this will return 'file.php'

		$news_title = strtolower($post['title']['rendered']);
		$news_title = str_replace(' ','-',$news_title);
	    
		$catName = $post['_embedded']['wp:term'][0][0]['name'];
		$catImage = $post['_embedded']['wp:term'][0][0]['acf']['category_photo']['url'];
		$catSlug = $post['_embedded']['wp:term'][0][0]['slug'];
		$catID = $post['_embedded']['wp:term'][0][0]['id'];
		$tagSlug = $post['_embedded']['wp:term'][1][0]['slug'];
		$catAlt = $post['_embedded']['wp:term'][0][0]['acf']['category_photo']['alt']; 
	    
		if($i== 0){
			$messe_post_html_data .='<li>
				<!--<p style="text-align:center;"><img src="'.$catImage.'" style="width:20%;"  alt="" /></p>-->
			</li>';
		}	
 
		//echo $post['tags'][0].'<br>';
	    	//switch($postFilter){
			//case 'messe-news':
			   // DOUBLE TIME CHECK NEWSPRESS CATEGORY AND HASHTAG CATEGORY SAME OR NOT.	
			   if($post['tags'][0] == $tag_check){
			   $pdf_new_data = '';
			   if(!empty($pdf_file)){
				   $pdf_new_data .='<div class="cbp-li"> 
										<div style="padding:10px; background:#f6f6f6;">
											<p class="aligncenter"> 
											<img src="'.plugin_dir_url( __FILE__ ).'/img/download-presssemitteilung.png" alt="" />
											</p>
											<h6>Druckversion Pressemitteilung</h6>
											<p class="mm-download-button-style"><a href="'.$pdf_file.'" target="_blank" style="text-decoration: underline; padding: 10px 10px; border: 1px solid #848484;">Herunterladen</a></p>
										</div>
									</div>';
			   }else{
				   $pdf_new_data .='';
			   }	   
			   $messe_post_html_data .='<li class="messe-news '.$catSlug.' '.$catName.' '.$i.' '.$catID.' " data-messe="messe-news" data-filter="'.$catSlug.'" data-event-date="'.$post['acf']['press_date'].'" datetime="'.$post['acf']['press_date'].'"> 
			   			 
						<div class="column mcb-column two-third column_column mm-repeated-div" > 
							<!--<div style="width:100%; height:10px;"></div>  
							<div class="column_attr clearfix" style="">
								<h6 style="color:#05326c; margin-bottom: 5px;">'.__($catName).' | '.$newDateTime.'</h6>
							</div>-->
							<div class="column_attr clearfix" style="">
								<div class="mcb-wrap-inner">
									<div class="">
										<div class="column_attr clearfix">
											<h6 style="color:#05326c; margin-bottom: 5px;">'.__($catName).' | '.$newDateTime.'</h6>
											<h2 style="margin: 5px 0 0px;">'.$post['title']['rendered'].'</h2>
										</div><!-- column_attr clearfix -->
									</div><!-- column mcb-column one column_column -->
									<div class="clearfix"></div>
								</div><!-- mcb-wrap-inner -->
								<div class="automoreless">
									<p class="except-text-div">'.wb_mm_limit_text_page_ajax($excpt_content, $a['text_limit'], $post['id']).'</p> 
									<div id="acc-'.$post['id'].'" class="acc_div_new">
									
									<!-- <div class="column mcb-column one column_column ">
										<div class="column_attr clearfix">
											<h3 style="margin-bottom: 0;">'.$post['acf']['press_sub_heading'].'</h3>
										</div> column_attr clearfix 
									</div> column mcb-column one column_column -->
									
									<div class="mcb-wrap-inner" style="margin-top:0px;">
										<div class="column mcb-column two-third column_column ">
											<div class="column_attr clearfix">
												<h3 style="margin-bottom: 15px;">'.$post['acf']['press_sub_heading'].'</h3>
												'.$all_content.'
											</div><!-- column_attr clearfix -->
										</div><!-- column mcb-column two-third column_column -->
										<div class="column mcb-column one-third column_column  " >
											<div class="column_attr mb-list-ul clearfix">
												<h5 style="border-bottom: 1px solid gray;">Pressematerial</h5>
												 '.$pdf_new_data.'
												'.wb_mm_get_all_image_press_page_ajax($totalImages,$j).'
											</div><!-- column_attr clearfix -->
										</div><!-- column mcb-column one-third column_column  -->
									</div><!-- mcb-wrap-inner -->
									
									<div class="clearfix"></div> 
									<div style="width:100%; height:8px; margin-top:15px; background:#c10a25;"></div>
									<p class="aligncenter" style="padding:10px 0; text-align: left;">
									<a href="#" data-newid="acc-'.$post['id'].'" class="button less-mehr" style="margin: 0; margin: 0;
    color: black;
    background: none;
    border: 1px solid black;
    padding: 5px 10px;"><span class="button_label" style="padding: 0; font-weight:400;">Schließen</span></a> &nbsp;
									<!--<a href="'.get_permalink(8880).'" target="_blank" class="button new-form-link" style="margin: 0; margin: 0;
    color: black;
    background: none;
    border: 1px solid black;
    padding: 5px 10px;"><span class="button_label" style="padding: 0; font-weight:400;">Anmeldung Presseverteiler</span></a>--></p>
									</div>
								</div><!-- automoreless -->
								<div class="'.$lastClass.'"><hr class="" style="margin: 0 auto 10px; border:0;"></div>
							</div><!-- column_attr clearfix -->
						</div>
						
						 
						<div class="clearfix"></div>
						</li>';
			   
			   
	   } 
	
	
	
	
		$i++;
		$j++;
		endforeach; 
		/********* POST LOOP ENDS HERE ********/
	   
	    $cat_wrap_space = '<div class="column mcb-column one column_column colum_force_width">
						<div class="column_attr colum_cat_space clearfix" style="">
						</div>'; 
	    $messe_post_html_data .='</ul>';
		$main_shortcode_HTML .= $cat_block . $filter_html . $cat_title_headline . $messe_post_html_data.$cat_wrap_space;
			
		$messe_post_html_data = '';
		$austaller_post_html_data= '';
	
	
	//endforeach;
	/********* CATEGORY LOOP ENDS HERE *********/ 
	 
	$main_shortcode_HTML .= '
	<div style="display: none;" id="hidden-content" class="animated-modal">
	<p>Urheberrechte liegen beim Fotografen, Nutzungs- und Verwertungsrechte liegen bei der MESSE BREMEN. Pressefotos, die redaktionell verwendet werden, müssen mit der Quellenangabe "MESSE BREMEN/[Urheber]" versehen werden.</p> 
	<p>Abdruck und Veröffentlichung der Pressefotos sind honorarfrei. Wir bitten Printmedien um ein Belegexemplar, elektronische Medien (Internet) um eine kurze Benachrichtigung. Für eine gewerbliche Nutzung der Pressefotos bedarf es der vorherigen schriftlichen Zustimmung der MESSE BREMEN.</p>
	<p style="margin:0;">
		<input type="submit" value="Ablehnen" data-fancybox-close class="mm_cancel_button" style="margin:0; text-transform:uppercase;">&nbsp;&nbsp;&nbsp;
		<input type="submit" value="Akzeptieren" data-fancybox-close class="mm_ok_button" style="margin:0; text-transform:uppercase;">
	</p>
</div>
</div><!-- mm_newsroom_wrapper -->';   
?>