<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki history sidebar
 **/

$granularity = $vars['granularity'];
$from = $vars['from'];
$to = $vars['to'];

if ($from && $to) {
	$fromto = "&from=$from&to=$to";
} else {
	$fromto = '';
}

$title = elgg_echo('markdown_wiki:sidebar:granularity');
$granularityTypes = array(
	'character' => elgg_echo('markdown_wiki:granularity:character'),
	'word' => elgg_echo('markdown_wiki:granularity:word'),
	'sentence' => elgg_echo('markdown_wiki:granularity:sentence'),
	'paragraph' => elgg_echo('markdown_wiki:granularity:paragraph'),
);
$body = '<ul class="elgg-menu elgg-menu-owner-block elgg-menu-history-granularity">';
foreach($granularityTypes as $granularityType => $granularityType_title) {
	if ($granularityType == $granularity) {
		$class = ' elgg-state-selected';
	} else {
		$class = '';
	}
	$body .= "<li class='mrm$class'><a href='?granularity={$granularityType}{$fromto}'>$granularityType_title</a></li>";
}
$body .= '</ul>';

echo elgg_view_module('aside', $title, $body, array('class' => 'mbm'));