<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki view markdown_wiki page
 **/

$markdown_wiki_guid = get_input('guid');
$markdown_wiki = get_entity($markdown_wiki_guid);

$container = elgg_get_page_owner_entity();

if (!$markdown_wiki || !$container) {
	forward(REFERER);
}

elgg_load_js('markdown_wiki:view');
elgg_load_css('markdown_wiki:css');

elgg_set_page_owner_guid($markdown_wiki->getContainerGUID());

$title = $markdown_wiki->title;

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($container->name, "wiki/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "wiki/owner/$container->username");
}
elgg_push_breadcrumb($title);

$content = elgg_trigger_plugin_hook('markdown_wiki_view', 'header', $markdown_wiki, '');
$content .= elgg_view_entity($markdown_wiki, array('full_view' => true));
$content .= elgg_trigger_plugin_hook('markdown_wiki_view', 'footer', $markdown_wiki, '');

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('markdown_wiki/sidebar'),
));

echo elgg_view_page($title, $body);
