<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki edit page
 **/

gatekeeper();

$markdown_wiki_guid = (int)get_input('guid');
$container_guid = (int)get_input('container_guid');
$query = get_input('q');

$markdown_wiki = get_entity($markdown_wiki_guid);

if (!$container_guid) $container_guid = $markdown_wiki->getContainerGUID();
$container = get_entity($container_guid);

if (!$container) {
	register_error(elgg_echo('markdown_wiki:no_group'));
	forward(REFERER);
}

if ($markdown_wiki == '0' && !$query || !$container->canWritetoContainer()) {
	register_error(elgg_echo('markdown_wiki:no_access'));
	forward(REFERER);
} else {
	$vars = markdown_wiki_prepare_form_vars($markdown_wiki, $container_guid);
	$vars['query'] = $query;
	$content = elgg_trigger_plugin_hook('markdown_wiki_edit', 'header', $markdown_wiki, '');
	$content .= elgg_view_form('markdown_wiki/edit', array('class' => 'mrm mtm'), $vars);
}

elgg_set_page_owner_guid($container_guid);

elgg_push_breadcrumb($container->name, $container->getURL());

elgg_register_menu_item('title', array(
	'name' => 'history',
	'href' => "wiki/history/$markdown_wiki_guid/$markdown_wiki->title",
	'text' => elgg_echo('markdown_wiki:page:history'),
	'link_class' => 'elgg-button elgg-button-action'
));
elgg_register_menu_item('title', array(
	'name' => 'compare',
	'href' => "wiki/compare/$markdown_wiki_guid/$markdown_wiki->title",
	'text' => elgg_echo('markdown_wiki:page:compare'),
	'link_class' => 'elgg-button elgg-button-action'
));
elgg_register_menu_item('title', array(
	'name' => 'discussion',
	'href' => "wiki/discussion/$markdown_wiki_guid/$markdown_wiki->title",
	'text' => elgg_echo('markdown_wiki:page:discussion'),
	'link_class' => 'elgg-button elgg-button-action'
));

if ($query) {
	elgg_push_breadcrumb($query);
	$title = elgg_echo("markdown_wiki:edit", array($query));
} else {
	elgg_push_breadcrumb($markdown_wiki->title, $markdown_wiki->getURL());
	$title = elgg_echo("markdown_wiki:edit", array($markdown_wiki->title));
}
elgg_push_breadcrumb(elgg_echo('edit'));

$body = elgg_view_layout('one_column', array(
	'filter' => '',
	'content' => elgg_view('page/layouts/content/header', array('title' => $title)) . $content,
	'title' => ''
));

echo elgg_view_page($title, $body);