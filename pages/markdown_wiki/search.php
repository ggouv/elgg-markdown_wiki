<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki search page
 **/

$query = stripslashes(get_input('q', ''));
$container_guid = (int)get_input('container_guid');

$limit = get_input('limit', 20);
$offset = get_input('offset', 0);

$display_query = htmlspecialchars(preg_replace("/[^\x01-\x7F]/", "", $query), ENT_QUOTES, 'UTF-8', false);

if ($container = get_entity($container_guid)) {
	elgg_push_breadcrumb($container->name, "wiki/group/$container_guid/all");
}
elgg_push_breadcrumb(elgg_echo('search'));

// search in text
$params = array(
	'query' => $query,
	'offset' => $offset,
	'limit' => $limit,
	'sort' => 'relevance',
	'order' => 'desc',
	'search_type' => 'entities',
	'type' => 'object',
	'subtype' => 'markdown_wiki',
	'pagination' => TRUE
);
if ($container_guid) $params['container_guid'] = $container_guid;

$results = elgg_trigger_plugin_hook('search', 'object:markdown_wiki', $params, NULL);
if ($results === FALSE) {
	// someone is saying not to display these types in searches.
	continue;
} elseif (is_array($results) && !count($results)) {
	// no results, but results searched in hook.
} elseif (!$results) {
	// no results and not hooked.  use default type search.
	// don't change the params here, since it's really a different subtype.
	// Will be passed to elgg_get_entities().
	$results = search_objects_hook('search', 'object:markdown_wiki', '',$params);
}

if ($container_guid) {
	// Search for article in group
	$url = elgg_get_site_url() . 'wiki/search';
	$body = '<div class="markdown-wiki-search-form mbm">' . elgg_echo('markdown_wiki:search_in_group', array(''));
	$body .= elgg_view_form('markdown_wiki/search', array(
		'action' => $url,
		'method' => 'get',
		'disable_security' => true,
	), array('container_guid' => $container_guid));
	$body .= '</div>';

	// forward to unique entity or unset entity that title match query
	foreach ($results['entities'] as $key => $entities) {
		if ($entities->title == $query ) {
			$results['count'] -= 1;
			if ($results['count'] == 0) forward($entities->getURL());
			$page_query = $entities;
			unset($results['entities'][$key]);
		}
	}

	if ($page_query) {
		$button = "<a href='" . $page_query->getURL() . "'>$query</a>";
		$body .= '<h2 class="markdown-wiki-create mtm">' . elgg_echo('markdown_wiki:search:result:found:page', array($button, $container->name)) . '</h2>';
	} else {
		$body .= elgg_echo('markdown_wiki:search:result:not_found');
		$button = "<a href='" . elgg_get_site_url() . "wiki/edit?q=$query&container_guid=$container_guid' class='elgg-button elgg-button-action'>$query</a>";
		if (can_write_to_container(elgg_get_logged_in_user_guid(), $container_guid, 'object', 'markdown_wiki')) {
			$body .= '<h2 class="markdown-wiki-create mtm">' . elgg_echo('markdown_wiki:search:result:not_found:create_it', array($button, $container->name)) . '</h2>';
		}
	}
}

if (is_array($results['entities']) && $results['count']) {

	if ($container_guid) {
		if (!$page_query) $body .= elgg_echo('markdown_wiki:search:result:not_found:similar');
		
		$searched_words = search_remove_ignored_words($display_query, 'array');
		$highlighted_query = search_highlight_words($searched_words, $display_query);
		$body .= elgg_view_title(elgg_echo('markdown_wiki:search:in_text:title', array("\"$highlighted_query\"")), array('class' => 'search-heading-category'));
	}

	$url = elgg_get_site_url() . "wiki/search?$query";

	// get any more links.
	$more_check = $results['count'] - ($params['offset'] + $params['limit']);
	$more = ($more_check > 0) ? $more_check : 0;

	$count = $results['count'] - count($results['entities']);

	if ($more) {
		$title_key = ($more == 1) ? 'comment' : 'comments';
		$more_str = elgg_echo('markdown_wiki:more', array($count, 'item:entities:markdown_wiki'));
		$more_url = elgg_http_remove_url_query_element($url, 'limit');
		$more_link = "<li class='elgg-item'><a href=\"$more_url\">$more_str</a></li>";
	} else {
		$more_link = '';
	}

	// get pagination
	if (array_key_exists('pagination', $params) && $params['pagination']) {
		$nav = elgg_view('navigation/pagination',array(
			'base_url' => $url,
			'offset' => $params['offset'],
			'count' => $results['count'],
			'limit' => $params['limit'],
		));
	} else {
		$nav = '';
	}

	$body .= '<ul class="elgg-list search-list">';
	foreach ($results['entities'] as $entity) {
		$id = "elgg-{$entity->getType()}-{$entity->getGUID()}";
		$body .= "<li id=\"$id\" class=\"elgg-item\">";
		$body .= elgg_view('search/entity', array(
			'entity' => $entity,
			'params' => $params,
			'results' => $results
		));
		$body .= '</li>';
	}
	$body .= $more_link;
	$body .= '</ul>';

}

$sidebar = elgg_view('markdown_wiki/sidebar/sidebar');

$title = elgg_echo('markdown_wiki:search:title', array("\"$display_query\""));

$params = array(
	'content' => $body,
	'sidebar' => $sidebar,
	'filter' => false,
	'title' => $title,
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);