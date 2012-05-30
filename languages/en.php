<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki English language
 **/

$english = array(

	/**
	 * Menu items and titles
	 */

	'markdown_wiki' => "Wikis",
	'markdown_wiki:owner' => "%s's wiki pages",
	'markdown_wiki:friends' => "Friends' wiki pages",
	'markdown_wiki:all' => "All site wiki pages",
	'wiki:add' => "Add wiki page",

	'markdown_wiki:none' => 'No wiki pages created yet',
	
	'markdown_wiki:granularity:character' => 'Character',
	'markdown_wiki:granularity:word' => 'Word',
	'markdown_wiki:granularity:sentence' => 'Sentence',
	'markdown_wiki:granularity:paragraph' => 'Paragraph',

	'markdown_wiki:del' => 'del',
	'markdown_wiki:ins' => 'ins',

	/**
	* River
	**/

	/**
	 * Form fields
	 */

	/**
	 * Status and error messages
	 */

	/**
	 * Object
	 */
	'item:object:markdown_wiki' => "Article",
    'river:create:object:markdown_wiki' => "%s submited article %s",
    'river:comment:object:markdown_wiki' => "%s commented on the article %s",
	'markdown_wiki:strapline' => "Last updated %s by %s",
	
	'markdown_wiki:history:date' => "By %s at",
	'markdown_wiki:history:date_format' => "%e %B %Y à %H:%M",

);

add_translation('en', $english);
