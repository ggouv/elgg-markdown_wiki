<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki edit action
 **/

$variables = elgg_get_config('markdown_wiki');
$input = array();
foreach ($variables as $name => $type) {
	$input[$name] = get_input($name);
	if ($name == 'title') {
		$input[$name] = strip_tags($input[$name]);
	}
	if ($type == 'tags') {
		$input[$name] = string_to_tag_array($input[$name]);
	}
}

// Get guids
$markdown_wiki_guid = (int)get_input('page_guid');
$container_guid = (int)get_input('container_guid');

elgg_make_sticky_form('markdown_wiki');

if (!$input['title']) {
	register_error(elgg_echo('markdown_wiki:error:no_title'));
	forward(REFERER);
}

if ($markdown_wiki_guid) {
	$markdown_wiki = get_entity($markdown_wiki_guid);
	if (!$markdown_wiki || !$markdown_wiki->canEdit()) {
		register_error(elgg_echo('markdown_wiki:error:no_save'));
		forward(REFERER);
	}
	$new_markdown_wiki = false;
} else {
	$markdown_wiki = new ElggObject();
	$markdown_wiki->subtype = 'markdown_wiki';
	$new_markdown_wiki = true;
}

if (sizeof($input) > 0) {
	foreach ($input as $name => $value) {
		$markdown_wiki->$name = $value;
	}
}

// need to add check to make sure user can write to container
$markdown_wiki->container_guid = $container_guid;

if ($parent_guid) {
	$markdown_wiki->parent_guid = $parent_guid;
}

if ($markdown_wiki->save()) {

	elgg_clear_sticky_form('markdown_wiki');

	// Now save description as an annotation
	$markdown_wiki->annotate('markdown_wiki', $markdown_wiki->description, $markdown_wiki->access_id);

	system_message(elgg_echo('markdown_wiki:saved'));

	if ($new_markdown_wiki) {
		add_to_river('river/object/markdown_wiki/create', 'create', elgg_get_logged_in_user_guid(), $markdown_wiki->guid);
	}

	forward($markdown_wiki->getURL());
} else {
	register_error(elgg_echo('markdown_wiki:error:no_save'));
	forward(REFERER);
}
