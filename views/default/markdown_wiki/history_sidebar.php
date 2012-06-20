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

$count = $vars['count'];
$diffOwner = $vars['diffOwner'];

$title = elgg_echo('markdown_wiki:sidebar:history');
if ($count > 50) $title .= '&nbsp;<span class="elgg-subtext">' . elgg_echo('markdown_wiki:sidebar:history:50max') . '</span>';

$body = <<<HTML
<div id="sliderContainer">
	<div id="slider"></div>
</div>
<div id="ownerContainer">
	$diffOwner
</div>
HTML;

echo elgg_view_module('aside', $title, $body, array('class' => 'history-module'));