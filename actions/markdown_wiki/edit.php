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

elgg_load_library('markdown_wiki:utilities');

$user_guid = elgg_get_logged_in_user_guid();

$variables = elgg_get_config('markdown_wiki');
$input = array();
foreach ($variables as $name => $type) {
	if ($name != 'summary') $input[$name] = get_input($name);
	if ($name == 'title') $input[$name] = strip_tags($input[$name]);
	if ($type == 'tags') $input[$name] = string_to_tag_array($input[$name]);
	if ($name == 'description') $input[$name] = strip_tags($_REQUEST[$name], '<div><span><br><table><th><tr><td>');
}

elgg_make_sticky_form('markdown_wiki');

if (!$input['container_guid']) {
	register_error(elgg_echo('markdown_wiki:error:no_group'));
	forward(elgg_get_site_url() . 'wiki/all');
}

if (!can_write_to_container($user_guid, $input['container_guid'], 'object', 'markdown_wiki')) {
	register_error(elgg_echo('markdown_wiki:error:no_access'));
	forward(REFERER);
}

if (!$input['title']) {
	register_error(elgg_echo('markdown_wiki:error:no_title'));
	forward(REFERER);
}

if (!$input['description']) {
	register_error(elgg_echo('markdown_wiki:error:no_description'));
	forward(REFERER);
}

if ($input['guid']) {
	$markdown_wiki = get_entity($input['guid']);
	if (!$markdown_wiki) {
		register_error(elgg_echo('markdown_wiki:error:no_entity'));
		forward(REFERER);
	}
	
	if (!$markdown_wiki->canEdit($user_guid)) {
		register_error(elgg_echo('markdown_wiki:error:no_access'));
		forward(REFERER);
	}
	
	$new_markdown_wiki = false;
	$old_markdown_wiki_annotations = $markdown_wiki->getAnnotations('markdown_wiki', 1, 0, 'desc');
	$value = unserialize($old_markdown_wiki_annotations[0]->value);
	$old_description = $value['text'];
} else {

	if ($page = search_markdown_wiki_by_title($input['title'], $input['container_guid'])) {
		register_error(elgg_echo('markdown_wiki:error:already_exist'));
		forward(elgg_get_site_url() ."wiki/group/{$input['container_guid']}/page/$page/{$input['title']}");
	}

	$markdown_wiki = new ElggObject();
	$markdown_wiki->subtype = 'markdown_wiki';
	$markdown_wiki->access_id = 2;
	$new_markdown_wiki = true;
	$old_description = '';
}

unset($input['guid']); // don't want to override guid cause if it's new page
if (sizeof($input) > 0) {
	foreach ($input as $name => $value) {
		$markdown_wiki->$name = $value;
	}
}

if ($markdown_wiki->save()) {

	elgg_clear_sticky_form('markdown_wiki');

	elgg_load_library('markdown_wiki:fineDiff');

	// set diff
	$compare = new FineDiff($old_description, $markdown_wiki->description, array(FineDiff::wordDelimiters));
	$compared['word'] = calc_diff_markdown_wiki($compare->renderDiffToHTML());
	$compare = new FineDiff($old_description, $markdown_wiki->description, array(FineDiff::sentenceDelimiters));
	$compared['sentence'] = calc_diff_markdown_wiki($compare->renderDiffToHTML());
	$compare = new FineDiff($old_description, $markdown_wiki->description, array(FineDiff::paragraphDelimiters));
	$compared['paragraph'] = calc_diff_markdown_wiki($compare->renderDiffToHTML());
	
	$array_change = array(
		'text' => $markdown_wiki->description,
		'diff' => $compared,
		'summary' => get_input('summary')
	);
	
	// Now save description as an annotation
	$annotation_id = create_annotation($markdown_wiki->guid, 'markdown_wiki', serialize($array_change), '', 0, $markdown_wiki->access_id);

	system_message(elgg_echo('markdown_wiki:saved'));

	if ($new_markdown_wiki) {
		add_to_river('river/object/markdown_wiki/create', 'create', $user_guid, $markdown_wiki->guid);
	} else {
		if (!get_input('minorchange', false)) {
			add_to_river('river/object/markdown_wiki/modified', 'modified', $user_guid, $markdown_wiki->guid, '', 0, $annotation_id);
		}
	}

	forward($markdown_wiki->getURL());
} else {
	register_error(elgg_echo('markdown_wiki:error:no_save'));
	forward(REFERER);
}
