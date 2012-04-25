<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki friend's markdown_wiki page
 **/

$owner = elgg_get_page_owner_entity();
if (!$owner) {
	forward('markdown_wiki/all');
}

elgg_push_breadcrumb($owner->name, "markdown_wiki/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

elgg_register_title_button();

$title = elgg_echo('markdown_wiki:friends');

$content = list_user_friends_objects($owner->guid, 'markdown_wiki', 10, false);
if (!$content) {
	$content = elgg_echo('markdown_wiki:none');
}

$params = array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
