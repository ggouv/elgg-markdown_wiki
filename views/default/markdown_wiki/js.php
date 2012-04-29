
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
		var nbrDiff = $('.elgg-output .diff').length -1;
		$('#diff-'+nbrDiff).show();
		$('#owner-'+nbrDiff).css('opacity', '1');
		var lastVal = nbrDiff;

		// Create the slider:
		$("#slider").slider({
			orientation: 'vertical',
			value: nbrDiff,
			min: 0,
			max: nbrDiff,
			animate: true,
			slide: function(event, ui) {
				$('#diff-'+lastVal).hide();
				$('#diff-'+ui.value).show();
				$('#owner-'+lastVal).css('opacity', '0.5');
				$('#owner-'+ui.value).css('opacity', '1');
				lastVal = ui.value;
			}
		});

	});
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.init);

// End of js for elgg-markdown_wiki plugin

