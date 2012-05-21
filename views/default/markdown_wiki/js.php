
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki javascript file
 **/

/**
 * Elgg-markdown_wiki initialization
 *
 * @return void
 */
elgg.provide('elgg.markdown_wiki');

elgg.markdown_wiki.init = function() {
	$(document).ready(function() {
		if ($('.history-module .elgg-body').height() > $('#ownerContainer').height()) {
			$("#slider").height($('#ownerContainer').height()-$('#owner-0').height()-20);
		}
		var nbrDiff = $('.diff-output .diff').length -1;
		$('#diff-'+nbrDiff + ', #owner-'+nbrDiff).removeClass('hidden');
		var lastVal = nbrDiff;

		if ( nbrDiff != 0 ) {
			var slideSidebar = function(ui) {
				$('#diff-'+lastVal + ', #owner-'+lastVal).addClass('hidden');
				$('#diff-'+ui.value + ', #owner-'+ui.value).removeClass('hidden');
				var OwnerOffset = $('#owner-'+ui.value).position();
				if ($('.history-module .elgg-body').height() < $('#ownerContainer').height()) {
					$('#ownerContainer').stop().animate({top: (nbrDiff-ui.value)*($('#slider').height()/nbrDiff) - OwnerOffset.top});
				} else {
					var OwnerOffset = $('#owner-'+ui.value).position();
					$('.ui-slider-handle').css('top', OwnerOffset.top - 6);
				}
				lastVal = ui.value;
			}
			// Create the slider:
			$("#slider").slider({
				orientation: 'vertical',
				value: nbrDiff,
				min: 0,
				max: nbrDiff,
				animate: true,
				change: function(event, ui) {
					slideSidebar(ui);
				},
				slide: function(event, ui) {
					slideSidebar(ui);
				}
			});
			
			$('.owner').click(function() {
				var valString = $(this).attr('id');
				$("#slider").slider({
					value: valString.substr(valString.indexOf('owner-') + "owner-".length),
				});
			});
			
			$('#ownerContainer').bind('mousewheel DOMMouseScroll', function(e) {
				if ($('.history-module .elgg-body').height() > $('#ownerContainer').height()) return;
				var delta = e.wheelDelta || -e.detail;
				var OwnerContainerOffset = $(this).position();
				var max = $(this).height() - $('.history-module .elgg-body').height();
				var top = OwnerContainerOffset.top + ( delta < 0 ? -1 : 1 ) * 30;
				if ( top > 0 ) top =0;
				if ( top < -max ) top = -max; 
				$(this).css({top: top});
				e.preventDefault();
			});
		}
	});
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.init);

// End of js for elgg-markdown_wiki plugin

