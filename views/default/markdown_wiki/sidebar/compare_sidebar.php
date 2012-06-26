<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki compare sidebar
 **/

$from = $vars['from'];
$to = $vars['to'];

$title = elgg_echo('markdown_wiki:sidebar:compare:from');

echo elgg_view_module('aside', $title, $from, array('class' => 'mbm mtl compare-module'));

$title = elgg_echo('markdown_wiki:sidebar:compare:to');

echo elgg_view_module('aside', $title, $to, array('class' => 'mbm compare-module'));