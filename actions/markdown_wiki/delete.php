<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki delete action
 **/

$guid = get_input('guid');
$markdown_wiki = get_entity($guid);
if ($markdown_wiki) {
	if ($markdown_wiki->canEdit()) {
		$container = get_entity($markdown_wiki->container_guid);

		if ($markdown_wiki->delete()) {
			system_message(elgg_echo('markdown_wiki:delete:success'));
			if (elgg_instanceof($container, 'group')) {
				forward("markdown_wiki/group/$container->guid/all");
			} else {
				forward("markdown_wiki/owner/$container->username");
			}
		}
	}
}

register_error(elgg_echo('markdown_wiki:delete:failure'));
forward(REFERER);
