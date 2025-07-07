// JavaScript Document
jQuery(document).ready(function(){ 
   jQuery(".accordion_holder").hide();  
   jQuery('.mm_plus_a').click(function(e){
	   e.preventDefault(); 
	   jQuery(this).hide();
	   var dataID = jQuery(this).data('id');
	   var showhide = jQuery(this).data('showhide'); 
	   	jQuery(this).closest('div').parent().parent().find('#'+dataID).slideDown('slow', function(){ });
	   	jQuery(this).closest('div').parent().parent().find('#'+dataID+' .capution_show_hide').show(); 
       
   });
	
	jQuery('.mm_plus_less').click(function(e){
	   e.preventDefault();  
		jQuery(window).resize();
	   var dataID = jQuery(this).data('id');
	   var showhide = jQuery(this).data('showhide'); 
	   var wrapperId = jQuery(this).data('wrapper'); 	 
	   jQuery('#'+dataID).slideUp('slow',function(){
		   jQuery('#'+wrapperId).find('.mm_plus_a').show(); 
		  jQuery(window).trigger('resize');  
	   });
	   jQuery(this).closest('div').parent().parent().find('#'+dataID+' .caption_show_hide').show(); 
       
   }); 
});


jQuery(function(){
	var imgurl; 
	jQuery(".mm_plus_img_link").click(function(){ 
		imgurl = jQuery(this).data('imgurl');  
	});
	
	jQuery(".mm_ok_button").click(function(){ 
		window.open(imgurl, '_blank'); 
	}); 
	
});

// CHECK WHEN IT HAS A HASH TAG TO SCROLL
jQuery(document).ready(function () { 
var hash = window.location.hash;  
if(hash !== ''){ 
    jQuery('html, body').animate({
        scrollTop: jQuery(hash).offset().top
    }, 'slow',function() {
  });
}  // ENDS HERE
 
	
	// SELECT BOX AND FILTER FOR THE PRESS PAGE 
	jQuery('#messe-news').prop('checked', true);
	jQuery(".mm_custom_select").on('change', function() { 
		var currId = this.value;  
		jQuery('#messe-news').prop('checked', true);
		jQuery('.mm_list_class li').each(function () { 
			var currDiv = jQuery(this).data('filter'); 
			if((currId === currDiv) && (currDiv !== 'aussteller-infos')) {  
				
				jQuery(this).fadeIn('fast');
			}else if((currId==='showall') && (currDiv !== 'aussteller-infos') ){  
				jQuery(this).fadeIn('fast');
			}else{ 
				jQuery(this).fadeOut('fast');
			} 
		});  
	});	// ENDS HERE 
	
	jQuery('#aussteller-infos').click(function(){
        var inputValue = jQuery(this).attr("value"); 
		jQuery('.mm_custom_select').val("showall"); 
		
		jQuery('.mm_list_class li').each(function () { 
			var currDiv = jQuery(this).attr('class'); 
			if(inputValue === currDiv){  
				jQuery(this).fadeIn('fast');
			}else{ 
				jQuery(this).fadeOut('fast');
			} 
		}); 
    });
	
	
	jQuery('#messe-news').click(function(){
        var inputValue = jQuery(this).attr("value"); 
		jQuery('.mm_custom_select').val("showall");  
		jQuery('.mm_list_class li').each(function () { 
			var currDiv = jQuery(this).data('messe'); 
			if((inputValue === currDiv) && (currDiv !== 'aussteller-infos')){  
				jQuery(this).fadeIn('fast');
			}else{ 
				jQuery(this).fadeOut('fast');
			} 
		}); 
    });
	
	
	
 
	// SELECT BOX AND FILTER CHECKBOX FOR THE PRESS PAGE 
	 jQuery(".checkbox_mm_form input:checkbox").change(function() {
		jQuery('.checkbox_mm_form input').not(this).prop('checked', false); 
		var ischecked= jQuery(this).is(':checked');
		var currClass = jQuery(this).val(); 
		if(!ischecked){ 
		  jQuery('.row_single_press_holder').show();	
		}else{ 
			if(currClass !== 'alles'){
				jQuery('.row_single_press_holder').not('.'+currClass).hide();
				jQuery('.row_single_press_holder').filter('.'+currClass).show();
			}else{
				jQuery('.row_single_press_holder').show(); 
			}
		}
	});	// ENDS HERE 
 
    
    jQuery(".automoreless a.mehr-less-for-page").click(function(){
            //jQuery(this).closest("p").addClass('excerpt_hide');
		
		    jQuery(this).parent().find('.except-text-div').addClass('excerpt_hide');
		
			jQuery(this).parent().parent().parent().addClass('one current-display-div');
		
            var accId = jQuery(this).data('newid');  
    		jQuery(this).closest('.automoreless').find('#'+accId).css('height','auto'); 
    		jQuery(this).hide();
			//jQuery(this).parent().parent().addClass('tt');
			/*
			jQuery(this).parent().parent().find('.cbp-li>div>div').samesizr({
			   	mobile: 481 
  			}); 
			*/
			//alert('Test');
    		return false;
        } 
    		
    );  
    
    
    //jQuery("a.less-mehr").click(function(){  
	jQuery("a.less-mehr").on('click', function(){	
		var accId = jQuery(this).data('newid');  
		jQuery(this).closest('#'+accId).css('height','0');  
		//jQuery(this).closest('#'+accId).prev().removeClass('excerpt_hide'); 
		jQuery(this).parent().parent().parent().find('.except-text-div').removeClass('excerpt_hide');
		
		jQuery(this).parent().parent().parent().parent().parent().removeClass('one');
		
		jQuery(this).parent().parent().parent().find('.mehr-less-for-page').show();
		
		//jQuery('a.mehr-less-for-page').show(); 
		return false;
    });  
	
 
	jQuery( ".mm-repeated-div" ).each( function(){
		jQuery('.acc_div_new').addClass('mm_verflow_div'); 
	}); 
  
}); 
 

/* THIS IS ONLY FOR NEWSROOM EQUAL HEIGHT USE */
/*
jQuery(window).on("load resize",function(){
  jQuery('.mm_equal_height').samesizr({
    mobile: 481
  });
});
*/

// THIS IS THE FUNCTION TO USE PHOTO COPYRIGHT POPUP ONLY PRESS PAGE 
jQuery(document).ready(function(){  
  download_press_bild();
    function download_press_bild(){   
      jQuery('.link-verify').each(function (index, element) {
          var imgUrl_single = jQuery(this).find('img').attr('src');
          jQuery(this).find('a').attr("data-fancybox", "");
          jQuery(this).find('a').attr("data-animation-duration", "400");
          jQuery(this).find('a').attr("data-modal", "true");
          jQuery(this).find('a').attr("data-src", "#fotodownload-der-pressebilder");
          jQuery(this).find('a').attr("data-imgpress", imgUrl_single);
          jQuery(this).find('a').addClass('mm_plus_img_link_press');
          
      });
      
    var imgurl_press;  
		jQuery(document).on('click', '.mm_plus_img_link_press', function () { 
		imgurl_press = jQuery(this).data('imgpress');  
	});
	 
		jQuery(document).on('click', '.mm_ok_button_press', function () {
		window.open(imgurl_press,'_blank'); 
	});   
   // ENDS HERE COPYRIGHT POPUP ONLY PRESS PAGE

  }
});
 


/***********
ADD NEW NEWS DESIGN NEW JQUERYS
**************************************/
 

jQuery(document).ready(function () {
    
	/*
	jQuery('.mm_list_class').loadMoreResults({
	  tag: {
		'name': 'li',
		'class': 'messe-news'
	  },
	  displayedItems: 3,
	  showItems: 3,
	  button: {
				'class': 'button',
				text: 'Mehr laden'
			}	
	});
	*/
	
	
	
	
	
	/*
	var container = jQuery(".mm_list_class_parent");
    var items = jQuery(".messe-news"); 
    //if ( jQuery( ".mm_newsroom_wrapper" ).is( ".mm_list_class_parent" ) ) {
    //var classStatus = jQuery( ".mm_newsroom_wrapper" ).hasClass("mm_list_class_parent")
    
    //if(classStatus == true){
    items.each(function() {
       // Convert the string in 'data-event-date' attribute to a more
       // standardized date format
       var BCDate = jQuery(this).attr("data-event-date").split(".");
       var standardDate = BCDate[1]+" "+BCDate[0]+" "+BCDate[2];
       standardDate = new Date(standardDate).getTime();
       jQuery(this).attr("data-event-date", standardDate);
 
    });
    

    items.sort(function(a,b){
        a = parseFloat(jQuery(a).attr("data-event-date"));
        b = parseFloat(jQuery(b).attr("data-event-date"));
        return a<b ? -1 : a>b ? 1 : 0;
    }).each(function(){
        container.prepend(this);
    }).promise().done(function () { 
    jQuery('.mm_list_class').loadMoreResults({
    	  tag: {
    		'name': 'li',
    		'class': 'messe-news'
    	  },
    	  displayedItems: 3,
    	  showItems: 3,
    	  button: {
    				'class': 'button',
    				text: 'Mehr laden'
    			}	
    	}).promise().done(function () {
    	    //console.log('done');
    	    //jQuery("ul.mm_list_class_child li:first-child").addClass("background-color");
    	    //jQuery('ul.mm_list_class_child li:eq(1)').addClass("background-color");
    	    
    	    // THIS IS THE FIRST LI MAKE ACTIVE AREA
    	    jQuery('ul.mm_list_class_child li:eq(1) .mehr-less-for-page').hide();
    	    jQuery('ul.mm_list_class_child li:eq(1)').find('.mm-repeated-div').addClass('one');
    	    
    	   jQuery('ul.mm_list_class_child li:eq(1) .automoreless').find('.except-text-div').addClass('excerpt_hide');
    	    jQuery('ul.mm_list_class_child li:eq(1) .mm_verflow_div').css("height","auto");
    	    
    	});
    });
    
    //}
	
	
*/

jQuery.fn.sortMyData = function() {
      var elements = jQuery(this).find('> *');
      
      // Create an array for the content
      var arr = [];
      
      for (var i = 0; i < elements.length; i++) {
        arr.push(elements.eq(i));
      }
      
      arr.sort(function(a, b) {
          var dateA = new Date(a.attr('datetime').replace(/([0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}) /, '$1T'))
        var dateB = new Date(b.attr('datetime').replace(/([0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}) /, '$1T'))
        
        if (dateA > dateB) {
          return -1;
        }
        
        if (dateA < dateB) {
          return 1;
        }
        
        return 0;
      });
      
      for (i = 0; i < arr.length; i++) {
        jQuery(this).append(arr[i]);
      }
       
       
       jQuery('.mm_list_class').loadMoreResults({
    	  tag: {
    		'name': 'li',
    		'class': 'messe-news'
    	  },
    	  displayedItems: 3,
    	  showItems: 3,
    	  button: {
    				'class': 'button',
    				text: 'Mehr laden'
    			}	
    	}).promise().done(function () {
    	    //console.log('done');
    	    //jQuery("ul.mm_list_class_child li:first-child").addClass("background-color");
    	    //jQuery('ul.mm_list_class_child li:eq(1)').addClass("background-color");
    	    
    	    // THIS IS THE FIRST LI MAKE ACTIVE AREA
    	    /*jQuery('ul.mm_list_class_child li:eq(1) .mehr-less-for-page').hide();
    	    jQuery('ul.mm_list_class_child li:eq(1)').find('.mm-repeated-div').addClass('one');
    	    
    	   jQuery('ul.mm_list_class_child li:eq(1) .automoreless').find('.except-text-div').addClass('excerpt_hide');
    	    jQuery('ul.mm_list_class_child li:eq(1) .mm_verflow_div').css("height","auto");*/
    	    
    	});
    	
    	
    }
    
    jQuery('ul.mm_list_class_parent').sortMyData(); 

	

});



 


 




 
 