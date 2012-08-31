<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki search form
 **/

$container_guid = elgg_extract('container_guid', $vars, elgg_get_page_owner_guid());
if (!$container_guid) $container_guid = (int)get_input('container_guid');

echo elgg_view('input/text', array(
	'name' => 'q',
	'class' => 'elgg-input-search mbm',
));

echo elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => $container_guid,
));

echo elgg_view('input/submit', array('value' => elgg_echo('search:go')));
