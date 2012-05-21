
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
		var nbrDiff = $('.diff-output .diff').length -1;
		$('#diff-'+nbrDiff + ', #owner-'+nbrDiff).removeClass('hidden');
		var lastVal = nbrDiff;

		// Create the slider:
		$("#slider").slider({
			orientation: 'vertical',
			value: nbrDiff,
			min: 0,
			max: nbrDiff,
			animate: true,
			change: function(event, ui) {
				$('#diff-'+lastVal + ', #owner-'+lastVal).addClass('hidden');
				$('#diff-'+ui.value + ', #owner-'+ui.value).removeClass('hidden');
				var OwnerOffset = $('#owner-'+ui.value).position();
				$('#ownerContainer').stop().animate({top: (nbrDiff-ui.value)*($('#slider').height()/nbrDiff) - OwnerOffset.top});
				lastVal = ui.value;
			},
			slide: function(event, ui) {
				$('#diff-'+lastVal + ', #owner-'+lastVal).addClass('hidden');
				$('#diff-'+ui.value + ', #owner-'+ui.value).removeClass('hidden');
				var OwnerOffset = $('#owner-'+ui.value).position();
				$('#ownerContainer').stop().animate({top: (nbrDiff-ui.value)*($('#slider').height()/nbrDiff) - OwnerOffset.top});
				lastVal = ui.value;
			}
		});
		
		$('.owner').click(function() {
			var valString = $(this).attr('id');
			$( "#slider" ).slider({
				value: valString.substr(valString.indexOf('owner-') + "owner-".length),
			});
		});
		
		$('#ownerContainer').bind('mousewheel DOMMouseScroll', function(e) {
			var delta = e.wheelDelta || -e.detail;
			var OwnerContainerOffset = $(this).position();
			var max = $(this).height() - $('.history-module .elgg-body').height();
			var top = OwnerContainerOffset.top + ( delta < 0 ? -1 : 1 ) * 30;
			if ( top > 0 ) top =0;
			if ( top < -max ) top = -max; 
			$(this).css({top: top});
			e.preventDefault();
		});
	});
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.init);

// End of js for elgg-markdown_wiki plugin

