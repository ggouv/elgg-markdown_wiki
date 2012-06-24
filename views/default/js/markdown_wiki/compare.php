
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki compare javascript file
 **/

/**
 * Elgg-markdown_wiki compare initialization
 *
 * @return void
 */
elgg.provide('elgg.markdown_wiki.compare');

elgg.markdown_wiki.compare.init = function() {
	/*$('.elgg-form-markdown-wiki-compare .history-module > li:first .elgg-input-radio[name=from], ' +
		'.elgg-form-markdown-wiki-compare .history-module > li:not(:first) .elgg-input-radio[name=to]').css('visibility', 'hidden');
	$('.elgg-form-markdown-wiki-compare .history-module > li:first .elgg-input-radio[name=to], ' +
		'.elgg-form-markdown-wiki-compare .history-module > li:nth-child(2) .elgg-input-radio[name=from]').attr("checked", "checked").css('visibility', 'visible');*/
	
	var updateDiffRadios = function() {
		if($(this).css('visibility') == 'hidden') return false;
		var i = $('.elgg-form-markdown-wiki-compare .history-module > li').index($(this).parents('li.elgg-item'))+1;
		var e = $('.elgg-form-markdown-wiki-compare .history-module > li:nth-child('+i+')');
		if ($(this).attr('name') == 'from') {
			e.prevAll().find('.elgg-input-radio[name=to]').css('visibility', 'visible')
			e.prev().nextAll().find('.elgg-input-radio[name=to]').css('visibility', 'hidden');
		} else {
			e.next().prevAll().find('.elgg-input-radio[name=from]').css('visibility', 'hidden');
			e.nextAll().find('.elgg-input-radio[name=from]').css('visibility', 'visible');
		}
	};
	
	$('.elgg-form-markdown-wiki-compare .history-module > li .elgg-input-radio').click(updateDiffRadios);
	$('.elgg-form-markdown-wiki-compare .history-module > li:nth-child(2) .elgg-input-radio[name=from]').click();
	$('.elgg-form-markdown-wiki-compare .history-module > li:first .elgg-input-radio[name=to]').click();
	
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.compare.init);

// End of compare js for elgg-markdown_wiki plugin

