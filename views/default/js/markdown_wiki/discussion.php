
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki discussion javascript file
 **/

/**
 * Elgg-markdown_wiki discussion initialization
 *
 * @return void
 */
elgg.provide('elgg.markdown_wiki.discussion');

elgg.markdown_wiki.discussion.init = function() {
	$(document).ready(function() {
		// toggle modification
		$('.elgg-button-toggle-modification').click(function() {
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$('.history-module ').parents('.elgg-item').hide();
			} else {
				$(this).addClass('active');
				$('.history-module ').parents('.elgg-item').show();
			}
		});
	});
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.discussion.init);

// End of discussion js for elgg-markdown_wiki plugin

