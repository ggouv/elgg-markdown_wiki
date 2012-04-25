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

	// register a library of helper functions
	$root = dirname(__FILE__);
	elgg_register_library('markdown_wiki:utilities', "$root/lib/utilities.php");

	// Extend the main CSS and JS file
	elgg_extend_view('css/elgg', 'markdown_wiki/css');
	elgg_extend_view('js/elgg', 'markdown_wiki/js');

	// Add a menu item to the main site menu
	$item = new ElggMenuItem('markdown_wiki', elgg_echo('markdown_wiki'), 'markdown_wiki/all');
	elgg_register_menu_item('site', $item);

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('markdown_wiki', 'markdown_wiki_page_handler');

	// Register entity type for search
	elgg_register_entity_type('object', 'markdown_wiki');

	// Register a url handler
	elgg_register_entity_url_handler('object', 'markdown_wiki', 'markdown_wiki_url');

	// Register a script to handle (usually) a POST request (an action)
	$base_dir = "$root/actions/markdown_wiki";
	elgg_register_action('markdown_wiki/edit', "$base_dir/edit.php");

	// Language short codes must be of the form "markdown_wiki:key"
	// where key is the array key below
	elgg_set_config('markdown_wiki', array(
		'title' => 'text',
		'description' => 'longtext',
		'tags' => 'tags',
		'access_id' => 'access',
	));

}

/**
 * Dispatcher for elgg-markdown_wiki plugin.
 * URLs take the form of :
 *  All:			markdown_wiki/all
 *  User's:			markdown_wiki/owner/<username>
 *  Friend's:		markdown_wiki/friends/<username>
 *  View page:		markdown_wiki/view/<guid>/<title>
 *  New page:		markdown_wiki/add/<guid> (container: user, group, parent)
 *  Edit page:		markdown_wiki/edit/<guid>
 *  Group:			markdown_wiki/group/<guid>
 *
 * @param array $page
 */
function markdown_wiki_page_handler($page) {

	elgg_load_library('markdown_wiki:utilities');

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	elgg_push_breadcrumb(elgg_echo('markdown_wiki'), 'markdown_wiki/all');

	$base_dir = dirname(__FILE__) . '/pages/markdown_wiki';

	switch ($page[0]) {
		default:
		case 'all':
			include "$base_dir/world.php";
			break;
		case 'owner':
			include "$base_dir/owner.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		case 'view':
			set_input('guid', $page[1]);
			include "$base_dir/view.php";
			break;
		case 'add':
			include "$base_dir/new.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$base_dir/edit.php";
			break;
		case 'group':
			include "$base_dir/group.php";
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
	return "markdown_wiki/view/$entity->guid/$title";
}
