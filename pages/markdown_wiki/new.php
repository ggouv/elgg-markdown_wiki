<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki new page
 **/

gatekeeper();

$container_guid = (int) get_input('guid');
$container = get_entity($container_guid);
if (!$container) {

}

$parent_guid = 0;
$markdown_wiki_owner = $container;
if (elgg_instanceof($container, 'object')) {
	$parent_guid = $container->getGUID();
	$markdown_wiki_owner = $container->getContainerEntity();
}

//elgg_set_page_owner_guid($markdown_wiki_owner->getGUID());

$title = elgg_echo('markdown_wiki:add');
elgg_push_breadcrumb($title);

$vars = markdown_wiki_prepare_form_vars(null, $parent_guid);
$content = elgg_view_form('markdown_wiki/edit', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
