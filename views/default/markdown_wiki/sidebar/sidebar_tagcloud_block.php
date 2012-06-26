<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki tagcloud sidebar
 *
 * @uses $vars['subtypes']   Object subtype string or array of subtypes
 * @uses $vars['owner_guid'] The owner of the content being tagged
 * @uses $vars['limit']      The maxinum number of tags to display
 */

$container_guid = elgg_extract('container_guid', $vars, ELGG_ENTITIES_ANY_VALUE);
if (!$container_guid) {
	$container_guid = ELGG_ENTITIES_ANY_VALUE;
}

$options = array(
	'type' => 'object',
	'subtype' => elgg_extract('subtypes', $vars, ELGG_ENTITIES_ANY_VALUE),
	'threshold' => 0,
	'limit' => elgg_extract('limit', $vars, 50),
	'tag_name' => 'tags',
);

$container = get_entity($container_guid);
if ($container && elgg_instanceof($container, 'group')) {
	$options['container_guid'] = $container_guid;
} else {
	$options['owner_guid'] = $container_guid;
}

$title = elgg_echo('tagcloud');
if (is_array($options['subtype']) && count($options['subtype']) > 1) {
	// we cannot provide links to tagged objects with multiple types
	$tag_data = elgg_get_tags($options);
	$cloud = elgg_view("output/tagcloud", array(
		'value' => $tag_data,
		'type' => $type,
	));
} else {
	$cloud = elgg_view_tagcloud($options);
}
if (!$cloud) {
	return true;
}

// add a link to all site tags
$cloud .= '<p class="small">';
$cloud .= elgg_view_icon('tag');
$cloud .= elgg_view('output/url', array(
	'href' => 'tags',
	'text' => elgg_echo('tagcloud:allsitetags'),
	'is_trusted' => true,
));
$cloud .= '</p>';


echo elgg_view_module('aside', $title, $cloud);
