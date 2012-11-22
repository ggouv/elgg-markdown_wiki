<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki object file
 **/

$full = elgg_extract('full_view', $vars, FALSE);
$markdown_wiki = elgg_extract('entity', $vars, FALSE);
$revision = elgg_extract('revision', $vars, FALSE);
$redirect_from = elgg_extract('redirect_from', $vars, FALSE);

if (!$markdown_wiki) {
	return TRUE;
}

if ($revision) {
	$annotation = $revision;
} else {
	$annotation = $markdown_wiki->getAnnotations('markdown_wiki', 1, 0, 'desc');
	if ($annotation) {
		$annotation = $annotation[0];
	}
}

$editor = get_entity($annotation->owner_guid);
$editor_link = elgg_view('output/url', array(
	'href' => "wiki/owner/$editor->username",
	'text' => $editor->name,
	'is_trusted' => true,
));

$date = elgg_view_friendly_time($annotation->time_created);
$container = $markdown_wiki->getContainerEntity();
$group_link = elgg_view('output/url', array(
	'href' => $container->getURL(),
	'text' => $container->name,
	'is_trusted' => true,
));


$editor_text = elgg_echo('markdown_wiki:strapline', array($date, $editor_link, $group_link));
$tags = elgg_view('output/tags', array('tags' => $markdown_wiki->tags));
$categories = elgg_view('output/categories', $vars);

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'wiki',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$editor_text $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full) {
	$value = unserialize($annotation->value);
	$content = format_markdown_wiki_hooks($value['text']);
	
	$body = '';
	if ($redirect_from) {
		$redirect_entity = get_entity($redirect_from);
		system_message(elgg_echo('markdown_wiki:redirected', array($redirect_entity->title)));
		$body .= "<div class='elgg-subtext'>(" . elgg_echo('markdown_wiki:redirect_from') ." <a href='{$redirect_entity->getURL()}'>{$redirect_entity->title}</a>)</div>";
	}
	$body .= elgg_view('output/markdown_wiki_text', array('value' => $content, 'class' => 'markdown-body'));

	$params = array(
		'entity' => $markdown_wiki,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'title' => false,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'entity' => $markdown_wiki,
		'summary' => $summary,
		'body' => $body,
	));

} else {	// brief view
	elgg_load_library('markdown_wiki:markdown');
	$value = unserialize($annotation->value);
	$excerpt = elgg_get_excerpt(Markdown($value['text']));

	$params = array(
		'entity' => $markdown_wiki,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
}
