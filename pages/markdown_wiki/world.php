<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki world page
 **/

$title = elgg_echo('markdown_wiki:all');

elgg_push_breadcrumb(elgg_echo('markdown_wiki:all'));

$content = elgg_list_entities(array(
	'types' => 'object',
	'subtypes' => 'markdown_wiki',
	'full_view' => false,
));
if (!$content) {
	$content = '<p>' . elgg_echo('markdown_wiki:none') . '</p>';
}

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('markdown_wiki/sidebar/sidebar'),
));

echo elgg_view_page($title, $body);
