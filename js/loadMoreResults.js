/**
	*	Load More Results v1.0.0
	* Author: Cenk Çalgan
	* 
	* Options:
	* - tag (object):
	*		- name (string)
	*		- class (string)
	* - displayedItems (int)
	*	- showItems (int)
	* - button (object):
	*		- class (string)
	*		- text (string)
*/

(function ($) {
	'use strict';

	$.fn.loadMoreResults = function (options) {

		var defaults = {
			tag: {
				name: 'div',
				'class': 'item'
			},
			displayedItems: 5,
			showItems: 5,
			button: {
				'class': 'btn-load-more',
				text: 'Load More'
			}
		};

		var opts = $.extend(true, {}, defaults, options);

		var alphaNumRE = /^[A-Za-z][-_A-Za-z0-9]+$/;
		var numRE = /^[0-9]+$/;

		$.each(opts, function validateOptions(key, val) {
			if (key === 'tag') {
				formatCheck(key, val, 'name', 'string');
				formatCheck(key, val, 'class', 'string');
			}
			if (key === 'displayedItems') {
				formatCheck(key, val, null, 'number');
			}
			if (key === 'showItems') {
				formatCheck(key, val, null, 'number');
			}
			if (key === 'button') {
				formatCheck(key, val, 'class', 'string');
			}
		});

		function formatCheck(key, val, prop, typ) {
			if (prop !== null && typeof prop !== 'object') {
				if (typeof val[prop] !== typ || String(val[prop]).match(typ == 'string' ? alphaNumRE : numRE) === null) {
					opts[key][prop] = defaults[key][prop];
				}
			} else {
				if (typeof val !== typ || String(val).match(typ == 'string' ? alphaNumRE : numRE) === null) {
					opts[key] = defaults[key];
				}
			}
		};

		return this.each(function (index, element) {
			var $list = $(element),
					lc = $list.find(' > ' + opts.tag.name + '.' + opts.tag.class).length,
					dc = parseInt(opts.displayedItems),
					sc = parseInt(opts.showItems);
			//alert(lc);
			
			
			$list.find(' > ' + opts.tag.name + '.' + opts.tag.class + ':lt(' + dc + ')').css("display", "inline-block");
			$list.find(' > ' + opts.tag.name + '.' + opts.tag.class + ':gt(' + (dc - 1) + ')').css("display", "none");
			
			/*********
			CUSTOM JS ADDED BY MAMUN
			******************************/
			$list.parent().parent().find('.mm_list_class').append('<p style="text-align: center;"><a href="#" class="button btn-view" style="margin:0; padding:0; overflow: inherit;"><span class=" button_label ' + opts.button.class + '" style="padding:10px 20px 0; margin:0;">' + opts.button.text + '</span></a></p>');
			
			
			if(dc>=lc){
				jQuery('.btn-view').hide();
				//alert(dc);
			}
			
			/*************
			CUSTOM JS ADDED ENDS HERE 
			***************************/

			//$list.parent().append('<button class="btn-view ' + opts.button.class + '">' + opts.button.text + '</button>');
			$list.parent().on("click", ".btn-view", function (e) {
				e.preventDefault();
				dc = (dc + sc <= lc) ? dc + sc : lc;
				
				$list.find(' > ' + opts.tag.name + '.' + opts.tag.class + ':lt(' + dc + ')').fadeIn();
				if (dc == lc) {
					$(this).hide();
				}
			});
		});

	};
})(jQuery);