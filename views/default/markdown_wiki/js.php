
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

	});
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.init);

// End of js for elgg-markdown_wiki plugin

