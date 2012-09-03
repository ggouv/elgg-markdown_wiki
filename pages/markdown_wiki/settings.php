<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki settings page
 **/

gatekeeper();
group_gatekeeper();

$page_owner = elgg_get_page_owner_entity();

elgg_push_breadcrumb($page_owner->name, "wiki/group/$page_owner->guid/all");
elgg_push_breadcrumb(elgg_echo('markdown_wiki:settings'));

$vars = markdown_wiki_group_settings_prepare_form_vars($page_owner);

$content = elgg_view_form('markdown_wiki/settings', array(), $vars);

$title = elgg_echo('markdown_wiki:group:settings:title', array($page_owner->name));

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);