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

function markdow_wiki_to_html($text) {
	$text = Markdown($text);
global $fb; $fb->info($text);
	$text = preg_replace_callback("/(<h([1-9])>)([^<]*)/", '_title_id_callback', $text);
$fb->info($text);
	return $text;
}
function _title_id_callback($matches) {
	global $fb;
$fb->info($matches);

	$title = strip_tags($matches[3]);
	$title = preg_replace("`\[.*\]`U", "", $title);
	$title = preg_replace('`&(amp;)?#?[a-z0-9]+;`i', '-', $title);
	$title = htmlentities($title, ENT_COMPAT, 'utf-8');
	$title = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i", "\\1", $title );
	$title = preg_replace( "`&([a-z])(elig);`i", "\\1e", $title );
	$title = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $title);
	$title = strtolower($title);

	return "<h{$matches[2]}><span id='$title'>{$matches[3]}</span>";
}
