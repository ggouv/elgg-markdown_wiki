<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki JSON river modified
 **/

global $jsonexport;

$object = $vars['item']->getObjectEntity();

$annotation = elgg_get_annotation_from_id($vars['item']->annotation_id);
$value = unserialize($annotation->value);

$summary = $value['summary'];
$array_diff = $value['diff']['word'];
$diff_text = '';
if ( $array_diff[0] != 0 ) $diff_text .= '<ins class="elgg-subtext">&nbsp;+' . $array_diff[0] . '&nbsp;</ins>';
if ( $array_diff[1] != 0 ) $diff_text .= '<del class="elgg-subtext">&nbsp;-' . $array_diff[1] . '&nbsp;</del>';
	
$vars['item']->summary = elgg_view('river/elements/summary', array('item' => $vars['item']), FALSE, FALSE, 'default');
$vars['item']->message = $diff_text . '&nbsp;' . $summary;

$jsonexport['activity'][] = $vars['item'];

