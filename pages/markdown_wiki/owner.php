<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki owner page
 **/

$owner = elgg_get_page_owner_entity();

if (!$owner) {
	forward('wiki/all');
}

// access check for closed groups
group_gatekeeper();

if (elgg_instanceof($owner, 'group')) {

	if ($owner->canEdit() || elgg_is_admin_logged_in()) {
		elgg_register_menu_item('title', array(
			'name' => 'settings',
			'href' => "wiki/group/$owner->guid/settings",
			'text' => elgg_echo('markdown_wiki:settings'),
			'link_class' => 'elgg-button elgg-button-action edit-button gwfb group_admin_only',
		));
	}

	$title = elgg_echo('markdown_wiki:groupowner', array($owner->name));
	$content = elgg_list_entities(array(
		'types' => 'object',
		'subtypes' => 'markdown_wiki',
		'container_guid' => $owner->guid,
		'full_view' => false,
	));
} else {
	$title = elgg_echo('markdown_wiki:owner', array($owner->name));
	$content = elgg_list_entities_from_annotations(array(
		'types' => 'object',
		'subtypes' => 'markdown_wiki',
		'annotation_owner_guids' => $owner->guid,
		'full_view' => false,
	));
}

elgg_push_breadcrumb($owner->name);

if (!$content) {
	$content = '<p>' . elgg_echo('markdown_wiki:none') . '</p>';
}

$filter_context = '';
if ($owner->guid == elgg_get_logged_in_user_guid()) {
	$filter_context = 'mine';
}

$sidebar = elgg_view('markdown_wiki/sidebar/sidebar');

$params = array(
	'sidebar' => $sidebar,
	'filter_context' => $filter_context,
	'content' => $content,
	'title' => $title,
);

if (elgg_instanceof($owner, 'group')) {
	$params['filter'] = '';
}

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
