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
$container_guid = (int)get_input('container_guid', elgg_get_page_owner_guid());
$container = get_entity($container_guid);
if (!$container || !elgg_instanceof($container, 'group')) $container_guid = 0;

// Search for article in group
$url = elgg_get_site_url() . 'wiki/search';
$body = elgg_view_form('markdown_wiki/search', array(
	'action' => $url,
	'method' => 'get',
	'disable_security' => true
), array(
	'container_guid' => $container_guid
));


if ($container && elgg_instanceof($container, 'group')) {
	if (can_write_to_container(elgg_get_logged_in_user_guid(), $container_guid, 'object', 'markdown_wiki')) {
		$createit = '<span class="elgg-subtext">' . elgg_echo('markdown_wiki:search_in_group:or_create') . '</span>';
	}
	echo elgg_view_module('aside', elgg_echo('markdown_wiki:search_in_group', array($createit)), $body);
} else {
	echo elgg_view_module('aside', elgg_echo('markdown_wiki:search_in_all_group'), $body);
}

echo elgg_view('markdown_wiki/sidebar_comments_block', array(
	'subtypes' => array('markdown_wiki'),
	'container_guid' => $container_guid,
));

echo elgg_view('markdown_wiki/sidebar_tagcloud_block', array(
	'subtypes' => array('markdown_wiki'),
	'container_guid' => $container_guid,
));