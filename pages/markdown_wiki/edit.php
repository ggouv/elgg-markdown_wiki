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
$markdown_wiki = get_entity($markdown_wiki_guid);
if (!$markdown_wiki) {
	register_error(elgg_echo('markdown_wiki:noaccess'));
	forward(REFERER);
}

elgg_load_js('markdown_wiki:edit');
elgg_load_js('showdown');
elgg_load_css('markdown_wiki:css');

$container = $markdown_wiki->getContainerEntity();
if (!$container) {
	register_error(elgg_echo('markdown_wiki:noaccess'));
	forward(REFERER);
}

elgg_set_page_owner_guid($container->getGUID());

elgg_push_breadcrumb($markdown_wiki->title, $markdown_wiki->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

$title = elgg_echo("markdown_wiki:edit");

if ($markdown_wiki->canEdit()) {
	$vars = markdown_wiki_prepare_form_vars($markdown_wiki);
	$content = elgg_view_form('markdown_wiki/edit', array('class' => 'mrm'), $vars);
} else {
	$content = elgg_echo("markdown_wiki:noaccess");
}

$body = elgg_view_layout('one_column', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);