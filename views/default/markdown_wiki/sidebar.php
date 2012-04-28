<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki sidebar
 **/

echo elgg_view('page/elements/comments_block', array(
	'subtypes' => array('markdown_wiki'),
	'owner_guid' => elgg_get_page_owner_guid(),
));

echo elgg_view('page/elements/tagcloud_block', array(
	'subtypes' => array('markdown_wiki'),
	'owner_guid' => elgg_get_page_owner_guid(),
));
