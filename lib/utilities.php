<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki utilities library
 **/

/**
 * Prepare the add/edit form variables
 *
 * @param ElggObject $page
 * @return array
 */
function markdown_wiki_prepare_form_vars($markdown_wiki = null, $parent_guid = 0) {

	// input names => defaults
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'write_access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => elgg_get_page_owner_guid(),
		'guid' => null,
		'entity' => $markdown_wiki,
		'parent_guid' => $parent_guid,
	);

	if ($markdown_wiki) {
		foreach (array_keys($values) as $field) {
			if (isset($markdown_wiki->$field)) {
				$values[$field] = $markdown_wiki->$field;
			}
		}
	}

	if (elgg_is_sticky_form('markdown_wiki')) {
		$sticky_values = elgg_get_sticky_values('markdown_wiki');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('markdown_wiki');

	return $values;
}


/**
 * Get markdown_wiki by title
 *
 * @param string $title The title's markdown_wiki
 *
 * @return ElggObject|false Depending on success
 */
function get_markdown_wiki_guid_by_title($title) {
	global $CONFIG, $MARKDOWN_WIKI_TITLE_TO_GUID_MAP_CACHE;

	$title = sanitise_string($title);
	$access = get_access_sql_suffix('e');
$subtype_id = get_subtype_id('object', 'markdown_wiki');
/*
	// Caching
	if ((isset($MARKDOWN_WIKI_TITLE_TO_GUID_MAP_CACHE[$title]))
	&& (retrieve_cached_entity($MARKDOWN_WIKI_TITLE_TO_GUID_MAP_CACHE[$title]))) {
		return retrieve_cached_entity($MARKDOWN_WIKI_TITLE_TO_GUID_MAP_CACHE[$title]);
	}
*/
	$query = "SELECT e.* from {$CONFIG->dbprefix}objects_entity u
		join {$CONFIG->dbprefix}entities e on e.guid=u.guid
		where e.subtype='$subtype_id' and u.title='$title' and $access ";
/*
	$query = "SELECT e.* from {$CONFIG->dbprefix}users_entity u
		join {$CONFIG->dbprefix}entities e on e.guid=u.guid
		where u.username='$username' and $access ";
*/
	$entity = get_data($query);
	
/*	if ($entity) {
		$MARKDOWN_WIKI_TITLE_TO_GUID_MAP_CACHE[$title] = $entity->guid;
	} else {
		$entity = false;
	}
*/
	if ($entity) {
		return $entity;
	} else {
		return false;
	}
}


/**
 * Format a markdown_wiki text object to html
 *
 * @param string with markdown syntax
 *
 * @return html
 */
function markdown_wiki_to_html($text) {

	elgg_load_library('markdown_wiki:markdown');
	$params = array();
	
	$result = elgg_trigger_plugin_hook('format_markdown', 'all', $params, null);
	if ($result) {
		return $result;
	}

	$result = elgg_trigger_plugin_hook('format_markdown', 'before', $params, $text);

	$result = Markdown($result);

	$result = elgg_trigger_plugin_hook('format_markdown', 'after', $params, $result);

	return $result;
}


/**
 * Calcul diff when edit a markdown_wiki text object
 *
 * @param string a markdown_wiki description
 *
 * @return array(chars added, chars deleted)
 */
function calc_diff_markdown_wiki($text) {
	preg_match_all('#<ins>(.*)</ins>#sU', $text, $ins);
	
	preg_match_all('#<del>(.*)</del>#sU', $text, $del);

	return array(
		strlen(implode($ins[1])),
		strlen(implode($del[1])),
	);
}