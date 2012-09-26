<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki river create
 **/

$object = $vars['item']->getObjectEntity();
$excerpt = strip_tags($object->description);
$excerpt = elgg_get_excerpt($excerpt, 140);

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'message' => $excerpt,
));
