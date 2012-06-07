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
$owner_guid = elgg_get_page_owner_guid();

// Search for article in group
$url = elgg_get_site_url() . 'wiki/search';
$body = elgg_view_form('markdown_wiki/search', array(
	'action' => $url,
	'method' => 'get',
	'disable_security' => true,
));
if ($owner_guid) {
	$createit = '<span class="elgg-subtext">' . elgg_echo('markdown_wiki:search_in_group:or_create') . '</span>';
	echo elgg_view_module('aside', elgg_echo('markdown_wiki:search_in_group', array($createit)), $body);
} else {
	echo elgg_view_module('aside', elgg_echo('markdown_wiki:search_in_all_group'), $body);
}

echo elgg_view('page/elements/comments_block', array(
	'subtypes' => array('markdown_wiki'),
	'owner_guid' => $owner_guid,
));

echo elgg_view('page/elements/tagcloud_block', array(
	'subtypes' => array('markdown_wiki'),
	'owner_guid' => $owner_guid,
));