<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki compare form
 **/

$markdown_wiki = elgg_extract('markdown_wiki', $vars);
$annoff = elgg_extract('annoff', $vars, false);

$annotations = elgg_list_annotations(array(
	'types' => 'object',
	'subtypes' => 'markdown_wiki',
	'annotation_names' => 'markdown_wiki',
	'guids' => $markdown_wiki->guid,
	'order_by' => 'time_created desc',
	'limit' => $annoff ? 10 : 15,
	'summary_view' => true,
	'list_class' => 'history-module',
	'compare' => true,
));

if ($annoff) {
	$recent = elgg_list_annotations(array(
		'types' => 'object',
		'subtypes' => 'markdown_wiki',
		'annotation_names' => 'markdown_wiki',
		'guids' => $markdown_wiki->guid,
		'order_by' => 'time_created desc',
		'limit' => 5,
		'summary_view' => true,
		'list_class' => 'history-module',
		'compare' => true,
		'pagination' => false,
		'offset' => 0
	));
	
	// dumby hack to merge both lists
	$posR = strrpos($recent, '</ul>');
	$posA = strpos($annotations, '<li id="item-annotation');
	echo substr($recent, 0, $posR) . '<li>...</li>' . substr($annotations, $posA);

} else {
	echo $annotations;
}

echo elgg_view('input/hidden', array(
	'name' => 'markdown_wiki',
	'value' => $markdown_wiki->guid,
));

echo elgg_view('input/submit', array('value' => elgg_echo('markdown_wiki:compare:button'), 'class' => 'elgg-button-submit mtm'));
