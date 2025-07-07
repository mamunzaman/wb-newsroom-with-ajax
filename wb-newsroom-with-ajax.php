<?php
/**
 * This plugin is for the REST API News retriver for Buddy from Messe Bremen newroom.
 *
 * @package Buddy Info. plugin.
 * @author Mamunuzzaman
 * @license GPL-2.0+ 
 * @copyright 2019 Whitebox GmbH. All rights reserved.
 *
 *            @wBuddy-info-plugin
 *            Plugin Name: Buddy Info by AJAX.
 *            Plugin URI: #
 *            Description: This plugin is for the REST API News retriver for Buddy from Messe Bremen newroom.
 *            Version: 1.2
 *            Author: Md Mamunuzzaman
 *            Author URI: #
 *            Text Domain: wb-mm
 *            Contributors: Whitebox
 *            License: GPL-2.0+
 *            License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */ 


/************************
GLOBAL VARIABLES
******************************/
 global $minumum_find_array;
 $minumum_find_array[0] = 0;

/***********
ADD ALL SCRIPTS AND CSS FILE NEEDED
*************************************/
add_action('wp_enqueue_scripts','wb_mm_pressemitteilungen_js_css_init_page_ajax');

function wb_mm_pressemitteilungen_js_css_init_page_ajax() { 
	wp_register_style( 'newsroom-messe-bremen',  plugins_url( '/css/newsroom.css', __FILE__ ), array(), '', 'all', false );
	wp_register_style( 'new-fancybox',  plugins_url( '/css/jquery.fancybox.min.css', __FILE__ ), array(), '', 'all', false );
	wp_register_style( 'new-slick-theme-css',  plugins_url( '/css/slick-theme.css', __FILE__ ), array(), '', 'all', false ); 
		
	wp_register_script('new-fancybox-js', plugins_url( '/js/jquery.fancybox.min.js', __FILE__ ), array('jquery'), '1.0', true );  
	wp_register_script('mm_readmore', plugins_url( '/js/readmore.min.js', __FILE__ ), array('jquery'), array('jquery'), '1.0', true );  
	wp_register_script('mm_equal-height', plugins_url( '/js/jquery.samesizr-min.js', __FILE__ ), array('jquery'), '1.0', true );
	
	wp_register_style( 'mm_slick-css',  plugins_url( '/css/slick.css', __FILE__ ), array(), '', 'all', false );
	wp_register_script('mm_slick-js', plugins_url( '/js/slick.min.js', __FILE__ ), array('jquery'), '1.0', true ); 
	
	wp_register_script('mm_pagination-js', plugins_url( '/js/loadMoreResults.js', __FILE__ ), array('jquery'), '1.0', true ); 
	
	
	wp_register_script('mm_press_script', plugins_url( '/js/press_script.js', __FILE__ ), array('jquery'), '1.0', true ); 
	 
}

/****************
THIS IS FOR MENU FOR SETTING IN SETTING PAGE IF NEEDED
********************/
/*
function wb_mm_pressemitteilungen_add_menu() {
	add_submenu_page("options-general.php", "Pressemitteilungen", "Pressemitteilungen", "manage_options", "wb-mb-messe-pressemitteilungen", "wb_mb_messe_pressemitteilungen_page");
}
add_action("admin_menu", "wb_mm_pressemitteilungen_add_menu");  
*/




function wb_mm_messe_bremen_pressemitteilungen_shortcode_page_ajax( $atts ) { 
	// This is the area where url query get the query value.
    $original_request_link = $_SERVER['REQUEST_URI'];
	$link_hash_tag = $_SERVER['QUERY_STRING']; 
	
	$a = shortcode_atts( array(
      'url' 			=> '',
	  'category' 		=> '-1',
	  'domain_name' 	=> 'whitebox',
	  'text_limit' 		=> '-',
	  'number' 			=> '1', 
   ), $atts );
	$dataAll .="";
	$listOfImage = array();
	$dataAll ="";
	
	if(empty($link_hash_tag)){
		include 'parent-page.php';
	}else{	
		include 'child-page.php';
	}
/******* INCLUDE ALL CSS AND JS FILE WHEN SHORTCODE CALL ******/
wp_enqueue_style( 'newsroom-messe-bremen' );
wp_enqueue_style( 'new-fancybox' );
wp_enqueue_script('new-fancybox-js');
wp_enqueue_script('mm_readmore');
wp_enqueue_script('mm_equal-height');

wp_enqueue_style( 'new-slick-theme-css' );	
wp_enqueue_style( 'mm_slick-css' );
wp_enqueue_script('mm_slick-js');
wp_enqueue_script('mm_pagination-js');
	
wp_enqueue_script('mm_press_script'); 	
/****** END ALL JS AND CSS CALL ********/ 	
	//$filter_html = '';
	return $main_shortcode_HTML;
	
	//return $all_url;
}

add_shortcode( 'mess-buddy-info-ajax-page', 'wb_mm_messe_bremen_pressemitteilungen_shortcode_page_ajax' ); 



/*

function wb_mm_messe_bremen_pressemitteilungen_shortcode_p_p( $atts ) { 
	// This is the area where url query get the query value.
    $original_request_link = $_SERVER['REQUEST_URI'];
	$link_hash_tag = $_SERVER['QUERY_STRING']; 	
	
   $a = shortcode_atts( array(
      'url' 			=> '',
	  'category' 		=> '-1',
	  'domain_name' 	=> 'whitebox',
	  'text_limit' 		=> '-',
	  'number' 			=> '1', 
   ), $atts );
	$dataAll .="";
	$listOfImage = array();
	$dataAll ="";
	//$url= $a['url'] . "/wp-json/wp/v2/categories?slug=jazzahead&exclude=1&hide_empty=1";
	$url= $a['url'] . "/wp-json/wp/v2/categories?slug=".$link_hash_tag;
	$media_url= $a['url'] . "/wp-json/wp/v2/media/";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	$result=curl_exec($ch);
	$allCats = json_decode($result, true); 
	  
 
	//$filter_html = '';
	return $main_shortcode_HTML="test". $link_hash_tag;
	
	//return $all_url;
}

add_shortcode( 'mess-buddy-info-single-page', 'wb_mm_messe_bremen_pressemitteilungen_shortcode_p_p' ); 

*/



function wb_mm_limit_text_page_ajax($text, $limit, $id) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          //$text = substr($text, 0, $pos[$limit]) . '... <a href="#" data-newid="acc-'.$id.'" class="mehr-less">+ mehr</a>';
		  $text = substr($text, 0, $pos[$limit]) . '... <div style="clear:both; width:100%;"></div><a href="#" data-newid="acc-'.$id.'" class="button mehr-less-for-page"><span class="button_label" style="padding:0; font-weight: 400; ">Mehr erfahren</span></a>';
      }
      return $text;
    }


function wb_mm_limit_text_for_page_page_ajax($text, $limit, $id, $param_slug, $cat_img_link) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          //$text = substr($text, 0, $pos[$limit]) . '... <a href="#" data-newid="acc-'.$id.'" class="mehr-less">+ mehr</a>';
		  $text = substr($text, 0, $pos[$limit]) . '... <div style="clear:both; width:100%;"></div><br/><a href="'.$param_slug.'" data-newid="acc-'.$id.'" class="button submit-form-on-click"><span class="button_label" style="padding:0; font-weight: 400; ">Mehr erfahren</span></a>';
      }
      return $text;
    }



function wb_mm_get_all_image_press_page_ajax($allImageData,$k){
	$addImage="";
	if(!empty($allImageData)){
		$total= count($allImageData);
	}else{
		$total= 0;
	}	
	$j=0;
	for($j=0;$j<$total; $j++){
		$addImage.="<div class='cbp-li'><div style='padding:5px;'>
		<div style='padding:10px; background:#f6f6f6;'>
		<p style='margin:0; padding:0; text-align:center;'><a data-fancybox data-animation-duration='400' data-modal='true' data-src='#hidden-content' href='javascript:;' data-imgurl='".$allImageData[$j]['url']."' class='mm_plus_img_link'><img src='".$allImageData[$j]['sizes']['medium']."'  alt='".$allImageData[$j]['alt']."' /></a></p> 
			<div class='caption_show_hide' >
				<!--<p style='line-height: 1; font-size: 14px;'>Herunterladen:<br>
				<b><a data-fancybox data-animation-duration='400' data-modal='true' data-src='#hidden-content' href='javascript:;' data-imgurl='".$allImageData[$j]['url']."' class='mm_plus_img_link'>".$allImageData[$j]['title']."</a></b></p>-->
				<h6 class='alignleft'>".$allImageData[$j]['description']."</h6>
				<p class='alignleft'><a data-fancybox data-animation-duration='400' data-modal='true' data-src='#hidden-content' href='javascript:;' data-imgurl='".$allImageData[$j]['url']."' class='mm_plus_img_link mm-download-button-style'>Herunterladen</a></p>
				<div class='clearfix'></div>
			</div>	
		</div>
		</div><!-- caption_show_hide -->
		</div><!-- column mcb-column one-fifth column_column -->";
	$k++;	
	} 
	return $addImage;
}


// THIS FUNCTION CREATE THE RIGHT SIDE MENU BASED ON CATEGORY AND TAGS
	function menu_by_category_id_page_ajax($category_key, $array_of_data,$siteUrl){
		$menuData ='<ul style="margin:0; margin-top:0px;">';
		foreach($array_of_data as $key => $value):
			if($category_key == $key){  
				//MAKE COMMA SEPERATION TO ARRAY OF TAGS
				$all_tag_ids = explode(',', $value); 
				
				sort($all_tag_ids);
				//print_r($all_tag_ids); echo '<br>';
				// LOOP OF TAGS NAME AND SLUG RETRIVER LOOP
				foreach($all_tag_ids as $single_tag):
					if(!empty($single_tag)){
						$ch = curl_init();
						$tagsURL = $siteUrl . "/wp-json/wp/v2/tags/".$single_tag; 
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_URL,$tagsURL);
						$tag_result=curl_exec($ch);
						$singleTags = json_decode($tag_result, true);

						//$menuData .= '<li style="border: 1px solid #626262; padding: 2px 10px;">'.do_shortcode('[fancy_link title="'.$singleTags['name'].'" link="'.$original_request_link.'?categories='.$key.'&tags='.$single_tag.'" target="" style="3" class="new-color" download=""]').'</li>'; 
						$menuData .= '<li style="line-height: 1; margin-bottom: 3px; text-align: center;"><a href="'.esc_url( get_page_link( 41 ) ) . $original_request_link.'?categories='.$key.'&tags='.$single_tag.'" class="button new-color" style="border: 1px solid #626262; padding: 5px 5px !important; display: block;">'.$singleTags['name'].'</a></li>'; 
					}	
				endforeach; 	// END THE LOOP   
			} // KEY AND CURRENT CATEGORY CHECKED.
		endforeach;
		$menuData .='</ul>';
		return $menuData;
		
	} 	// END FUNCTION


function wb_mm_get_lower_id_page_ajax($array_of_data){
	 
	foreach($array_of_data as $single_data):
		$all_tag_ids = explode(',', $single_data);
		sort($all_tag_ids);
		$minumum_find_array[1] = $all_tag_ids[0];
		//print_r($all_tag_ids);
		//echo $all_tag_ids[0];
	if($minumum_find_array[0] > $minumum_find_array[1]){
		$minumum_find_array[0] = $minumum_find_array[1];
	}
	endforeach;
	echo $minumum_find_array[0];
	return $minumum_find_array[0];
}

// END NEW NEWS FUNCTIONS HERE 