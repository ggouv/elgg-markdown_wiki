<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki discussion markdown_wiki page
 **/

$markdown_wiki_guid = get_input('guid');
$markdown_wiki = get_entity($markdown_wiki_guid);

$container = $markdown_wiki->getContainerEntity();

if (!$markdown_wiki || !$container) {
	forward(REFERER);
}

elgg_load_js('markdown_wiki:discussion');

elgg_set_page_owner_guid($markdown_wiki->getContainerGUID());

elgg_register_menu_item('title', array(
	'name' => 'toggle-modification',
	'href' => "#",
	'text' => elgg_echo('markdown_wiki:toggle-modification'),
	'link_class' => 'elgg-button-toggle-modification active',
));

$title = elgg_echo('markdown_wiki:discussion', array($markdown_wiki->title));

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($container->name, "wiki/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "wiki/owner/$container->username");
}

elgg_push_breadcrumb($markdown_wiki->title, $markdown_wiki->getURL());
elgg_push_breadcrumb(elgg_echo('markdown_wiki:page:discussion'));

elgg_register_menu_item('page', array(
	'name' => 'compare',
	'href' => "wiki/compare/$markdown_wiki_guid/$markdown_wiki->title",
	'text' => elgg_echo('markdown_wiki:page:compare'),
));
elgg_register_menu_item('page', array(
	'name' => 'history',
	'href' => "wiki/history/$markdown_wiki_guid/$markdown_wiki->title",
	'text' => elgg_echo('markdown_wiki:page:history'),
));
if ($markdown_wiki->canEdit($user_guid)) {
	elgg_register_menu_item('page', array(
		'name' => 'edit-page',
		'href' => "wiki/edit/$markdown_wiki_guid/$markdown_wiki->title",
		'text' => elgg_echo('markdown_wiki:page:edit'),
	));
}

$content = elgg_trigger_plugin_hook('markdown_wiki_discussion', 'header', $markdown_wiki, '');

$form_vars = array('name' => 'elgg_add_comment');
$vars['entity'] = $markdown_wiki;
$content .= elgg_view_form('comments/add', $form_vars, $vars);
$content .= '<div class="comments_order hidden" value="desc"></div>';

$content .= elgg_list_annotations(array(
	'types' => 'object',
	'subtypes' => 'markdown_wiki',
	'annotation_names' => array('markdown_wiki', 'generic_comment'),
	'guids' => $markdown_wiki_guid,
	'order_by' => 'time_created desc',
	'summary_view' => true
	));

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('markdown_wiki/sidebar/sidebar_tagcloud_block', array(
		'subtypes' => array('markdown_wiki'),
		'container_guid' => $container_guid,
	)),
));

echo elgg_view_page($title, $body);
