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
	
	// register js for object history
	elgg_register_simplecache_view('js/markdown_wiki/discussion');
	$url = elgg_get_simplecache_url('js', 'markdown_wiki/discussion');
	elgg_register_js('markdown_wiki:discussion', $url);

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
	$item = new ElggMenuItem('markdown_wiki_all', elgg_echo('markdown_wiki'), 'wiki/all');
	elgg_register_menu_item('site', $item);

	elgg_register_plugin_hook_handler('prepare', 'menu:entity', 'markdown_wiki_object_menu');

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

	// add to groups
	add_group_tool_option('markdown_wiki', elgg_echo('groups:enable_markdown_wiki'), true);
	add_group_tool_option('markdown_wiki_all', elgg_echo('groups:enable_markdown_wiki:home'), false);
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
		'access_id' => 'access',
		'title' => 'hidden',
		'guid' => 'hidden',
		'container_guid' => 'hidden',
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
			set_input('guid', $page[1]);
			include "$base_dir/owner.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		case 'group':
			if ($page[2] == 'all' ) {
				include "$base_dir/owner.php";
			} else if ($page[2] == 'page' ) {
				if (is_numeric($page[3])) {
					set_input('guid', $page[3]);
				} else {
					$query = search_markdown_wiki_by_title($page[3], elgg_get_page_owner_guid());
					if ($query) {
						set_input('guid', $query[0]->guid);
					} else {
						forward("/wiki/search?q=$page[3]&container_guid=$page[1]");
					}
				}
				include "$base_dir/view.php";
			} else {
				$group = get_input($page[1]);
				if ($group->markdown_wiki_all_enable  == 'yes') {
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
			if ($params['entity']->markdown_wiki_all_enable  == 'yes') {
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

	if ($params['handler'] == 'wiki') {
		foreach($params['menu']['default'] as $key => $menu) {
			if ( in_array($menu->getName(), array('edit', 'delete')) ) unset($params['menu']['default'][$key]);
		}

		if (can_write_to_container('', $params['entity']->container_guid, 'object', 'markdown_wiki')) {
			// edit link
			$options = array(
				'name' => 'edit',
				'text' => elgg_echo('edit'),
				'title' => elgg_echo('edit:this'),
				'href' => "wiki/edit/{$params['entity']->guid}/{$params['entity']->title}",
				'priority' => 300,
			);
			$params['menu']['default'][] = ElggMenuItem::factory($options);
		}

		// history link
		$options = array(
			'name' => 'history',
			'text' => elgg_echo('markdown_wiki:page:history'),
			'title' => elgg_echo('markdown_wiki:page:history'),
			'href' => "wiki/history/{$params['entity']->guid}/{$params['entity']->title}",
			'priority' => 200,
		);
		$params['menu']['default'][] = ElggMenuItem::factory($options);

		$sort_by = elgg_extract('sort_by', $params, 'text');
	
		$builder = new ElggMenuBuilder($params['menu']['default']);
		$return = $builder->getMenu($sort_by);

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
		$user = $params['user'];
		if ($user && can_write_to_container($user, $params['entity']->container_guid, 'object', 'markdown_wiki')) {
				return true;
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

	if (!function_exists('_parse_link_callback')) {
		function _parse_link_callback($matches) {
			// external link
			$title = rtrim($matches[1], '/');
			$group = elgg_get_page_owner_guid();
			$site_url = elgg_get_site_url();
			
			if ( strpos($title, 'http://') !== false ){
				if ( strpos($title, $site_url) === false ) { // external link
					return "<a href='$title' class='external'>$matches[2]</a><span class='elgg-icon external'></span>";
				} else { // internal link with http://
					return "<a href='$title'>$matches[2]</a>";
				}
			} else {
				if (!$title) { // markdown syntax like [a link]()
					if ( $page = search_markdown_wiki_by_title(end(explode('/', rtrim($matches[2], '/'))), $group) ) { // page exists
						return "<a href='{$site_url}wiki/group/$group/page/{$page[0]->guid}/$matches[2]'>$matches[2]</a>";
					} else { // page doesn't exists
						return "<a href='{$site_url}wiki/search?q=$matches[2]&container_guid=$group' class='new'>$matches[2]</a>";
					}
				} else if ( $page = search_markdown_wiki_by_title(end(explode('/', $title)), $group) ) { // page exists
					return "<a href='{$site_url}wiki/group/$group/page/{$page[0]->guid}/$title'>$matches[2]</a>";
				} else { // page doesn't exists
					return "<a href='{$site_url}wiki/search?q=$matches[2]&container_guid=$group' class='new'>$matches[2]</a>";
				}
			}
		}
	}

	/* markdown skip syntax with whitespace in the link like [a link](a link)
	 * So if we want to do local link only with the title of a page, we need to parse this kind of syntax.
	 * Note: with markdown we can do link with deported reference like [a link][1]		and far away [1]: thelink
	 * This kind of parsing is too hard to do again here because it can have multiple reference in a text and we have to store url.
	 * So I have modified original file to do that.
	 * See on elgg-markdown_wiki/vendors/php-markdown/markdown.php line 338
	 * Also on elgg-markdown_wiki/vendors/showdown/compressed/showdown.js line 64 at var c=c.replace close to the begining.
	 * Note2: this kind of link work. [a link][1]		and far away [1]: <the link>
	 */
	if (!function_exists('_parse_whitespace_link_callback')) {
		function _parse_whitespace_link_callback($matches) {
			$title = rtrim($matches[2], '/');
			return "<a href=\"$title\">$matches[1]</a>";
		}
	}
	$result = preg_replace_callback("/\[(.*)\]\((.*)\)/U", '_parse_whitespace_link_callback', $returnvalue);

	$result = preg_replace_callback("/<a href=\"(.*)\">(.*)<\/a>/U", '_parse_link_callback', $result);
	return $result;

}


/**
 * Plugin hook hander that add id for each title (h1, h2...) at the markdown output
 * So, we can do url like http://YourElgg/wiki/view/EntityGuid/EntityTitle#idTitle
 * 
 * @return string
 */
function markdown_wiki_id_title_plugin_hook($hook, $entity_type, $returnvalue, $params) {

	if (!function_exists('_title_id_callback')) {
		function _title_id_callback($matches) {
			$title = strip_tags(trim($matches[3]));
			$title = strtolower($title);
			$title = preg_replace('/\//', '-', $title);
			$title = preg_replace('/\s+/', '-', $title);
			$title = rawurlencode($title);
	
			return "<h{$matches[2]}><span id='$title'>{$matches[3]}</span>";
		}
	}

	$result = preg_replace_callback("/(<h([1-9])>)([^<]*)/", '_title_id_callback', $returnvalue);
	return $result;

}