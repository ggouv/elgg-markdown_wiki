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
	elgg_register_library('markdown_wiki:markdown', "$root/vendors/php-markdown/markdown.php");
	
	// register js and css
	elgg_register_js('showdown', "/mod/elgg-markdown_wiki/vendors/showdown/compressed/showdown.js");

	// register js for object view
	elgg_register_simplecache_view('js/markdown_wiki/view');
	$url = elgg_get_simplecache_url('js', 'markdown_wiki/view');
	elgg_register_js('markdown_wiki:view', $url);
	
	// register js for object history
	elgg_register_simplecache_view('js/markdown_wiki/history');
	$url = elgg_get_simplecache_url('js', 'markdown_wiki/history');
	elgg_register_js('markdown_wiki:history', $url);

	// register js when edit object
	elgg_register_simplecache_view('js/markdown_wiki/edit');
	$url = elgg_get_simplecache_url('js', 'markdown_wiki/edit');
	elgg_register_js('markdown_wiki:edit', $url);

	// Register css
	elgg_extend_view('css/elgg', 'markdown_wiki/css');
	elgg_register_simplecache_view('css/markdown_wiki/markdown');
	$url = elgg_get_simplecache_url('css', 'markdown_wiki/markdown');
	elgg_register_css('markdown_wiki:css', $url);

	// Add a menu item to the main site menu
	$item = new ElggMenuItem('markdown_wiki', elgg_echo('markdown_wiki'), 'wiki/all');
	elgg_register_menu_item('site', $item);

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('wiki', 'markdown_wiki_page_handler');

	// Register entity type for search
	elgg_register_entity_type('object', 'markdown_wiki');

	// Register a url handler
	elgg_register_entity_url_handler('object', 'markdown_wiki', 'markdown_wiki_url');

	// Register a script to handle (usually) a POST request (an action)
	$base_dir = "$root/actions/markdown_wiki";
	elgg_register_action('markdown_wiki/edit', "$base_dir/edit.php");

	// add to groups
	add_group_tool_option('markdown_wiki', elgg_echo('groups:enable_markdown_wiki'), true);
	elgg_extend_view('groups/tool_latest', 'markdown_wiki/group_module');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'markdown_wiki_owner_block_menu');

	// Language short codes must be of the form "markdown_wiki:key"
	// where key is the array key below
	elgg_set_config('markdown_wiki', array(
		'title' => 'text',
		'description' => 'markdown',
		'summary' => 'text',
		'tags' => 'tags',
		'access_id' => 'access',
	));

	// Parse link
	elgg_register_plugin_hook_handler('format_markdown', 'after', 'markdown_wiki_parse_link_plugin_hook', 600);
	// Add id for each title anchor
	elgg_register_plugin_hook_handler('format_markdown', 'after', 'markdown_wiki_id_title_plugin_hook', 601);

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
			include "$base_dir/owner.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		case 'group':
			if ($page[2] == 'all' ) {
				include "$base_dir/group.php";
			} else if ($page[2] == 'page' ) {
				if (is_numeric($page[3])) {
					set_input('guid', $page[1]);
				} else {
					$query = get_markdown_wiki_guid_by_title($page[3]);
					set_input('guid', '223');
					global $fb; $fb->info($query);
				}
				include "$base_dir/view.php";
			} else {
				forward('/wiki/group/' . $page[1] . '/page/home'); // go to home page of the group
			}
			break;
		case 'add':
			include "$base_dir/new.php";
			break;
		case 'edit':
		global $fb; $fb->info($page[1]);
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
	return "wiki/view/$entity->guid/$title";
}


/**
 * Add a menu item to the user ownerblock
 */
function markdown_wiki_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "wiki/owner/{$params['entity']->username}/home";
		$item = new ElggMenuItem('markdown_wiki', elgg_echo('markdown_wiki'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->markdown_wiki_enable != "no") {
			$url = "wiki/group/{$params['entity']->guid}/home";
			$item = new ElggMenuItem('markdown_wiki', elgg_echo('markdown_wiki:group'), $url);
			if (elgg_in_context('markdown_wiki')) $item->setSelected();
			$return[] = $item;
		}
	}
	return $return;
}


/**
 * Plugin hook hander that parse for link and return intern link of non exist wiki page,
 * exist page or external link
 * 
 * @return string
 */
function markdown_wiki_parse_link_plugin_hook($hook, $entity_type, $returnvalue, $params) {

	function _parse_link_callback($matches) {
		// external link
		global $fb; $fb->info(elgg_get_page_owner_entity());
		if ( strpos($matches[1], 'http://') !== false && strpos($matches[1], elgg_get_site_url()) === false ) {
		$fb->info($matches[1], 'if');
			return "<a href='$matches[1]' class='external'>$matches[2]</a><span class='elgg-icon external'></span>";
		} else { // internal link
		$fb->info(rtrim($matches[1], '/'), 'else');
			if ( get_markdown_wiki_guid_by_title(rtrim($matches[1], '/')) ) {
				return $matches[0];
			} else {
				return "<a href='$matches[1]' class='new'>$matches[2]</a>";
			}
		}
	}

	$result = preg_replace_callback("/<a href=\"(.*)\">(.*)<\/a>/U", '_parse_link_callback', $returnvalue);
	return $result;

}


/**
 * Plugin hook hander that add id for each title (h1, h2...) at the markdown output
 * So, we can do url like http://YourElgg/wiki/view/EntityGuid/EntityTitle#idTitle
 * 
 * @return string
 */
function markdown_wiki_id_title_plugin_hook($hook, $entity_type, $returnvalue, $params) {

	function _title_id_callback($matches) {
		$title = strip_tags(trim($matches[3]));
		$title = strtolower($title);
		$title = preg_replace('/\//', '-', $title);
		$title = preg_replace('/\s+/', '-', $title);
		$title = utf8_encode(rawurlencode($title));

		return "<h{$matches[2]}><span id='$title'>{$matches[3]}</span>";
	}

	$result = preg_replace_callback("/(<h([1-9])>)([^<]*)/", '_title_id_callback', $returnvalue);
	return $result;

}
