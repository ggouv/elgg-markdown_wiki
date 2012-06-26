<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki friend's markdown_wiki page
 **/

$offset = (int)get_input('offset', 0);
$timelower = (int)get_input('timelower', 0);
$timeupper = (int)get_input('timeupper', 0);

$owner = elgg_get_logged_in_user_entity();
if (!$owner) {
	forward('markdown_wiki/all');
}

elgg_push_breadcrumb($owner->name, "markdown_wiki/owner/$owner->username");
elgg_push_breadcrumb(elgg_echo('friends'));

$title = elgg_echo('markdown_wiki:friends');

//$content = list_user_friends_objects($owner->guid, 'markdown_wiki', 10, false);
/* list_user_friends_objects check for friend object with strange config with container_guid.
 * We have to rewrite it
 */
if ($friends = get_user_friends($owner->guid, "", 999999, 0)) {
	$friendguids = array();
	foreach ($friends as $friend) {
		$friendguids[] = $friend->getGUID();
	}
	$content = elgg_list_entities_from_annotations(array(
		'type' => 'object',
		'subtype' => 'markdown_wiki',
		'annotation_owner_guids' => $friendguids,
		'full_view' => false,
		'limit' => '20',
		'offset' => $offset,
		//'container_guids' => $friendguids,		So, skipped from original function
		'created_time_lower' => $timelower,
		'created_time_upper' => $timeupper
	));
}

if (!$content) {
	$content = elgg_echo('markdown_wiki:none');
}

$sidebar = elgg_view('markdown_wiki/sidebar/sidebar');

$params = array(
	'filter_context' => 'friends',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
