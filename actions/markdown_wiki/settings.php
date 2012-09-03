<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki settings action
 **/

gatekeeper();
group_gatekeeper();

elgg_make_sticky_form('markdown_wiki_settings');

$markdown_wiki_all_enabled = get_input('markdown_wiki_all_enabled', false);

$group_guid = (int)get_input('guid', elgg_get_page_owner_guid());
$user_guid = elgg_get_logged_in_user_guid();

if (!$group_guid || !$user_guid ) {
	register_error(elgg_echo('markdown_wiki:group:settings:failed'));
	forward(REFERER);
}

$group = get_entity($group_guid);

if (!$group->canEdit()) {
	register_error(elgg_echo('markdown_wiki:group:settings:failed'));
	forward(REFERER);
}

$group->markdown_wiki_all_enabled = $markdown_wiki_all_enabled;

if ($group->save()) {

	elgg_clear_sticky_form('markdown_wiki_settings');

	system_message(elgg_echo('markdown_wiki:group:settings:save:success'));

	forward("wiki/group/$group_guid");
} else {
	register_error(elgg_echo('markdown_wiki:group:settings:failed'));
	forward(REFERER);
}
