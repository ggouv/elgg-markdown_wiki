<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki language_selector
 **/


// syntax guide
$user = elgg_get_logged_in_user_entity();
if (elgg_view_exists("markdown_wiki/syntax/{$user->language}")) {
	echo elgg_view("markdown_wiki/syntax/{$user->language}");
} else {
	echo elgg_view('markdown_wiki/syntax/en');
}