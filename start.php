<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki start file
 **/

elgg_register_event_handler('init', 'system', 'markdown_wiki_init');

/**
 * Initialize elgg-markdown_wiki plugin.
 */
function markdown_wiki_init() {

	// register libraries of helper functions
	$root = dirname(__FILE__);
	elgg_register_library('markdown_wiki:utilities', "$root/lib/utilities.php");
	elgg_register_library('markdown_wiki:fineDiff', "$root/vendors/PHP-FineDiff/finediff.php");

	// js and css
	elgg_register_js('showdown', "/mod/elgg-markdown_wiki/vendors/showdown/compressed/showdown.js");
	elgg_register_js('showdownggouv', "/mod/elgg-markdown_wiki/vendors/showdown/compressed/extensions/showdownggouv.js");
	elgg_load_js('showdown');
	elgg_load_js('showdownggouv');
	elgg_register_js('highlight', "/mod/elgg-markdown_wiki/vendors/highlight/highlight.pack.js", 'footer', 100);
	elgg_load_js('highlight');
	elgg_extend_view('js/elgg', 'markdown_wiki/js');
	elgg_extend_view('js/elgg', 'markdown_wiki/editor_js');
	elgg_extend_view('css/elgg', 'markdown_wiki/css');
	elgg_extend_view('css/elgg', 'markdown_wiki/markdown_css');
	elgg_extend_view('css/elgg', 'markdown_wiki/highlight_css');

	// Add a menu item to the main site menu
	$item = new ElggMenuItem('markdown_wiki_all', elgg_echo('markdown_wiki'), 'wiki/all');
	elgg_register_menu_item('site', $item);

	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'markdown_wiki_object_menu');

	// write permission plugin hooks
	elgg_register_plugin_hook_handler('permissions_check', 'object', 'markdown_wiki_write_permission_check');

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('wiki', 'markdown_wiki_page_handler');

	// Register entity type for search
	elgg_register_entity_type('object', 'markdown_wiki');

	// Register a url handler
	elgg_register_entity_url_handler('object', 'markdown_wiki', 'markdown_wiki_url');

	// Register a script to handle (usually) a POST request (an action)
	$base_dir = "$root/actions/markdown_wiki";
	elgg_register_action('markdown_wiki/edit', "$base_dir/edit.php");
	elgg_register_action('markdown_wiki/compare', "$root/pages/markdown_wiki/compare.php");
	elgg_register_action('markdown_wiki/settings', "$base_dir/settings.php");

	// add to groups
	add_group_tool_option('markdown_wiki', elgg_echo('groups:enable_markdown_wiki'), true);
	elgg_extend_view('groups/tool_latest', 'markdown_wiki/group_module');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'markdown_wiki_owner_block_menu');

	//add a widget
	elgg_register_widget_type('markdown_wiki', elgg_echo('markdown_wiki'), elgg_echo('markdown_wiki:widget:description'));

	// Language short codes must be of the form "markdown_wiki:key"
	// where key is the array key below
	elgg_set_config('markdown_wiki', array(
		'description' => 'markdown',
		'summary' => 'text',
		'tags' => 'tags',
		'write_access_id' => 'access',
		'title' => 'hidden',
		'guid' => 'hidden',
		'container_guid' => 'hidden',
	));

	// Parse link
	elgg_register_plugin_hook_handler('format_markdown', 'format', 'markdown_wiki_parse_link_plugin_hook', 600);
}


/**
 * Dispatcher for elgg-markdown_wiki plugin.
 * URLs take the form of :
 *  All:				wiki/all or wiki/world
 *  User's:				wiki/owner/<username>
 *  Friend's:			wiki/friends/<username>
 *  All Group's pages:	wiki/group/<guid>/all
 *  Group page:			wiki/group/<guid>/page/<guid>/<title> (title is ignored)
 *			or:			wiki/group/<guid>/page/<title> (title important !)
 *
 *  Edit/New page:		wiki/edit/<guid>/<title> (title is ignored)
 *  Discussion page: 	wiki/discussion/<guid>/<title> (title is ignored)
 *  History page:		wiki/history/<guid>/<title>?granularity=<granularity> (granularity default = character) (title is ignored)
 *  Compare page:		wiki/compare/<guid>/<title> (title is ignored)
 *		  result:		wiki/compare/<guid>/<title>?from=<annotation guid>&to=<annotation guid>&granularity=<granularity> (title is ignored)
 *
 * @param array $page
 */
function markdown_wiki_page_handler($page) {

	elgg_load_library('markdown_wiki:utilities');
	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	elgg_push_breadcrumb(elgg_echo('markdown_wiki'), 'wiki/all');

	$base_dir = dirname(__FILE__) . '/pages/markdown_wiki';

	switch ($page[0]) {
		default:
		case 'all':
		case 'world':
			include "$base_dir/world.php";
			break;
		case 'owner':
			set_input('guid', $page[1]);
			include "$base_dir/owner.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		case 'group':
			if ($page[2] == 'all' ) {
				include "$base_dir/owner.php";
			} else if ($page[2] == 'settings' ) {
				include "$base_dir/settings.php";
			} else if ($page[2] == 'page' ) {
				if (is_numeric($page[3])) {
					set_input('guid', $page[3]);
				} else {
					$query = search_markdown_wiki_by_title($page[3], elgg_get_page_owner_guid()); // @todo security ?
					if ($query) {
						set_input('guid', $query);
					} else {
						forward("/wiki/search?container_guid=$page[1]&q=$page[3]");
					}
				}
				include "$base_dir/view.php";
			} else {
				$group = get_entity((int)$page[1]);
				if ($group->markdown_wiki_all_enabled  == 'on') {
					forward("/wiki/group/$page[1]/all");
				} else {
					forward('/wiki/group/' . $page[1] . '/page/' . elgg_echo('markdown_wiki:home')); // go to the wiki page home of the group
				}
			}
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$base_dir/edit.php";
			break;
		case 'discussion':
			set_input('guid', $page[1]);
			include "$base_dir/discussion.php";
			break;
		case 'history':
			set_input('guid', $page[1]);
			include "$base_dir/history.php";
			break;
		case 'compare':
			set_input('guid', $page[1]);
			include "$base_dir/compare.php";
			break;
		case 'search':
			include "$base_dir/search.php";
			break;
	}

	elgg_pop_context();

	return true;
}


/**
 * Override the markdown_wiki url
 *
 * @param ElggObject $entity markdown_wiki object
 * @return string
 */
function markdown_wiki_url($entity) {
	$title = elgg_get_friendly_title($entity->title);
	return "wiki/group/$entity->container_guid/page/$entity->guid/$title";
}


/**
 * Add a menu item to the user ownerblock
 */
function markdown_wiki_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "wiki/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('markdown_wiki', elgg_echo('markdown_wiki'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->markdown_wiki_enable != "no") {
			if ($params['entity']->markdown_wiki_all_enabled == 'on') {
				$url = "/wiki/group/{$params['entity']->guid}/all";
			} else {
				$url = "wiki/group/{$params['entity']->guid}/page/" . elgg_echo('markdown_wiki:home');
			}
			$item = new ElggMenuItem('markdown_wiki', elgg_echo('markdown_wiki:group'), $url);
			if (elgg_in_context('wiki')) $item->setSelected();
			$return[] = $item;
		}
	}
	return $return;
}


/**
 * Delete menu item 'delete' to the object menu, parse entity menu and add edit if user can + add history
 */
function markdown_wiki_object_menu($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'wiki') {
		return $return;
	}

	// history link
	$options = array(
		'name' => 'history',
		'text' => elgg_echo('markdown_wiki:page:history'),
		'title' => elgg_echo('markdown_wiki:page:history'),
		'class' => 'gwfb tooltip s t',
		'href' => "wiki/history/{$params['entity']->guid}/{$params['entity']->title}",
		'priority' => 110,
	);
	$return[] = ElggMenuItem::factory($options);

	// discussion link
	$options = array(
		'name' => 'discussion',
		'text' => elgg_echo('markdown_wiki:page:discussion'),
		'title' => elgg_echo('markdown_wiki:page:discussion'),
		'class' => 'gwfb tooltip s t',
		'href' => "wiki/discussion/{$params['entity']->guid}/{$params['entity']->title}",
		'priority' => 130,
	);
	$return[] = ElggMenuItem::factory($options);

	foreach ($return as $index => $item) {
		if ($item->getName() == 'delete') {
			unset($return[$index]);
		}
	}

	return $return;
}


/**
 * Extend permissions checking to extend can-edit for write users.
 *
 * @param unknown_type $hook
 * @param unknown_type $entity_type
 * @param unknown_type $returnvalue
 * @param unknown_type $params
 */
function markdown_wiki_write_permission_check($hook, $entity_type, $returnvalue, $params) {
	if ($params['entity']->getSubtype() == 'markdown_wiki') {
		$write_permission = $params['entity']->write_access_id;
		$user = $params['user'];
		if (($write_permission) && ($user)) {
			$list_access = get_access_array($user->guid);
			if ( can_write_to_container($user, $params['entity']->container_guid, 'object', 'markdown_wiki') || in_array($write_permission, $list_access)) {
				return true;
			}
		}
	}
}



/**
 * Plugin hook hander that parse for link and return intern link of non exist wiki page,
 * exist page or external link
 *
 * @return string
 */
function markdown_wiki_parse_link_plugin_hook($hook, $entity_type, $returnvalue, $params) {

	// escape all markdown link in code block
	if (!function_exists('_escape_link_in_block')) {
		function _escape_link_in_block($matches) {
			if (substr($matches[0], -1) == '`') { // do this because 4 spaces regex eat last char, and it could be `
				$last = true;
				$matches[0] = substr_replace($matches[0], "", -1);
			}
			if ($matches[0][0] == '`') { // escape if first char is `
				$first = true;
				$matches[0] = substr($matches[0], 1);
			}
			$return = preg_replace('/`/', '„„', $matches[0]); // used with 4 spaces code block to escape ` inside block
			if ($last) $return .= '`';
			if ($first) $return = '`' . $return;
			return preg_replace('/\]\(/U', '=]=(=', $return);
		}
	}
	$returnvalue = preg_replace('{\r\n?}', "\n", $returnvalue); // 	# Standardize line endings: # DOS to Unix and Mac to Unix
	$returnvalue = preg_replace_callback('/(?:^|\n)```.*\n```/Us', '_escape_link_in_block', $returnvalue); // github style code block (seems we don't need it because span code block do same thing
	$returnvalue = preg_replace_callback('/\n\n(?:(?:[ ]{4}|\t).*\n+)+\n*[ ]{0,3}[^ \t\n]|(?=~0)/Um', '_escape_link_in_block', $returnvalue); // 4 spaces code block
	$returnvalue = preg_replace_callback('/`+.*`/Um', '_escape_link_in_block', $returnvalue); // span style code block
	$returnvalue = preg_replace('/\!\[(.*)\]\((.*)\)/U', '![$1=]=(=$2)', $returnvalue); // escape image in link
	$returnvalue = preg_replace('/„„/', '`', $returnvalue);

	// search wiki page link
	if (!function_exists('_parse_link_callback')) {
		function _parse_link_callback($matches) {
			// link
			$array_match = explode('#', $matches[2]);
			$link = rtrim($array_match[0], '/');
			$html_link = urlencode($link);
			$hash = $array_match[1] ? '\#' . $array_match[1] : ''; // check if link is like (apage#aparagraph)
			// title
			$word = strip_tags(rtrim($matches[1], '/'));
			$html_word = strpos($word, '=]=(=') ? $word : urlencode($word); // check if title contain link (eg: wrap link on image)

			$group = elgg_get_page_owner_guid();
			//if ($group == 0) $group = elgg_get_logged_in_user_guid(); no wiki for user ?
			$site_url = elgg_get_site_url();
			$info = elgg_echo('markdown_wiki:create');

			if ( strpos($link, '://') !== false ){
				if ( strpos($link, $site_url) === false ) { // external link
					return "<a rel='nofollow' target='_blank' href='" . $link . "' class='external'>$matches[1]</a><span class='elgg-icon external'></span>";
				} else { // internal link with http://
					return '<a href="' . $link .'">' . $matches[1] . '</a>';
				}
			} else {
				if (!$link) { // markdown syntax like [a link]() or [a link](#paragraph)
					if ( $page_guid = search_markdown_wiki_by_title(rtrim($matches[1], '/'), $group) ) { // page exists
						$page = get_entity($page_guid);
						return "<a href='{$page->getUrl()}{$hash}'>{$matches[1]}</a>";
					} else { // page doesn't exists
						return "<a href='{$site_url}wiki/search?container_guid={$group}&q={$html_word}' class='tooltip s new' title=\"{$info}\">{$matches[1]}</a>";
					}
				} else if (preg_match('/^wiki\/group\/(\\w+)\/page\/(.*)/', $link, $relative) || preg_match('/^(\\w+):(.*)/', $link, $relative)) {
					if ( is_numeric($relative[1]) ) {
						if ( is_numeric($relative[2]) ) {
							$page = get_entity($relative[2]);
							return "<a href='{$page->getUrl()}{$hash}'>{$matches[1]}</a>";
						} elseif ( $page_guid = search_markdown_wiki_by_title($relative[2], $relative[1]) ) { // page exists
							$page = get_entity($page_guid);
							return "<a href='{$page->getUrl()}{$hash}'>{$matches[1]}</a>";
						} else { // page doesn't exists
							$relative[2] = urlencode($relative[2]);
							return "<a href='{$site_url}wiki/search?container_guid={$relative[1]}&q={$relative[2]}' class='tooltip s new' title=\"{$info}\">{$matches[1]}</a>";
						}
					} else if ($gtitle = search_group_by_title($relative[1])) {
						if ( $page_guid = search_markdown_wiki_by_title($relative[2], $gtitle) ) { // page exists
							$page = get_entity($page_guid);
							return "<a href='{$page->getUrl()}{$hash}'>{$matches[1]}</a>";
						} else { // page doesn't exists
							$relative[2] = urlencode($relative[2]);
							return "<a href='{$site_url}wiki/search?container_guid={$gtitle}&q={$relative[2]}' class='tooltip s new' title=\"{$info}\">{$matches[1]}</a>";
						}
					} else {
						return "<a href='{$site_url}wiki/search?container_guid={$group}&q={$relative[2]}' class='tooltip s new' title=\"{$info}\">{$matches[1]}</a>";
					}
				} elseif ( $page_guid = search_markdown_wiki_by_title($link, $group) ) { // page exists
					$page = get_entity($page_guid);
					return "<a href='{$page->getUrl()}{$hash}'>{$matches[1]}</a>";
				} else { // page doesn't exists
					return "<a href='{$site_url}wiki/search?container_guid={$group}&q={$html_link}' class='tooltip s new' title=\"{$info}\">{$matches[1]}</a>";
				}
			}
		}
	}
	$return = preg_replace_callback("/(?<!\!)\[(.*)\]\((.*)\)/U", '_parse_link_callback', $returnvalue);
	// unescape link =]=(=
	return preg_replace('/=\]=\(=/U', '](', $return);
}



/**
 * Wrapper for markdown_wiki_parse_link_plugin_hook
 * @param  [type] $text The markdown text to parse
 * @return text         Return markdown text with link formated for wiki (ie: red link = page doesn't exist, blue link = page exist)
 */
function markdown_wiki_parse_link($text) {
	elgg_load_library('markdown_wiki:utilities');
	return markdown_wiki_parse_link_plugin_hook('', '', $text, '');
}



/**
 * Function to replace get_input. Skip htmlawed, so we use strips_tags.
 * Markdown use link like <http://example.com>
 *
 * @return string
 */
function get_markdown_input($text) {
	$text = preg_replace('/<(https?|ftp|dict):/U', '%%%$1:', $text);
	$text = strip_tags($text, '<iframe><img><div><span><br><table><th><tr><td>');
	$text = str_replace(array('\r\n', '\n'), chr(13), $text);
	$text = preg_replace('/%%%/U', '<', $text);
	return $text;
}