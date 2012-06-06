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
if (!$markdown_wiki && !$container_guid) {
	register_error(elgg_echo('markdown_wiki:noaccess'));
	forward(REFERER);
}

if (!$container_guid) $container_guid = $markdown_wiki->getContainerEntity();

if (!$container_guid || !is_group_member($container_guid, elgg_get_logged_in_user_guid())) {
	register_error(elgg_echo('markdown_wiki:noaccess'));
	forward(REFERER);
} else {
	$vars = markdown_wiki_prepare_form_vars($markdown_wiki, $container_guid);
	$vars['query'] = $query;
	$content = elgg_view_form('markdown_wiki/edit', array('class' => 'mrm'), $vars);
}

elgg_load_js('markdown_wiki:edit');
elgg_load_js('showdown');
elgg_load_css('markdown_wiki:css');

elgg_set_page_owner_guid($container_guid);

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
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);