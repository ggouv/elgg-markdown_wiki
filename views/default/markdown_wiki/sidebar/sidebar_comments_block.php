<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki comments block sidebar
 *
 * @uses $vars['subtypes']   Object subtype string or array of subtypes
 * @uses $vars['owner_guid'] The owner of the content being commented on
 * @uses $vars['limit']      The number of comments to display
 */

$container_guid = elgg_extract('container_guid', $vars, ELGG_ENTITIES_ANY_VALUE);
if (!$container_guid) {
	$container_guid = ELGG_ENTITIES_ANY_VALUE;
}

$options = array(
	'annotation_name' => 'generic_comment',
	'reverse_order_by' => true,
	'limit' => elgg_extract('limit', $vars, 4),
	'type' => 'object',
	'subtypes' => elgg_extract('subtypes', $vars, ELGG_ENTITIES_ANY_VALUE),
);

$container = get_entity($container_guid);
if ($container && elgg_instanceof($container, 'group')) {
	$options['container_guid'] = $container_guid;
} else {
	$options['owner_guid'] = $container_guid;
}

$title = elgg_echo('generic_comments:latest');
$comments = elgg_get_annotations($options);
if ($comments) {
	$body = elgg_view('page/components/list', array(
		'items' => $comments,
		'pagination' => false,
		'list_class' => 'elgg-latest-comments',
		'full_view' => false,
	));
} else {
	$body = '<p>' . elgg_echo('generic_comment:none') . '</p>';
}

echo elgg_view_module('aside', $title, $body);
