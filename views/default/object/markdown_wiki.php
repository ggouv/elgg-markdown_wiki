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
	'href' => "markdown_wiki/owner/$editor->username",
	'text' => $editor->name,
	'is_trusted' => true,
));

$date = elgg_view_friendly_time($annotation->time_created);
$editor_text = elgg_echo('markdown_wiki:strapline', array($date, $editor_link));
$tags = elgg_view('output/tags', array('tags' => $markdown_wiki->tags));
$categories = elgg_view('output/categories', $vars);

$comments_count = $markdown_wiki->countComments();
//only display if there are commments
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $markdown_wiki->getURL() . '#markdown_wiki-comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'wiki',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$editor_text $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

if ($full) {
	$value = unserialize($annotation->value);
	$content = markdown_wiki_to_html($value['text']);
	
	$body = elgg_view('output/markdown_wiki_text', array('value' => $content, 'class' => 'markdown-body'));

	$params = array(
		'entity' => $markdown_wiki,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'entity' => $markdown_wiki,
		'title' => false,
		'summary' => $summary,
		'body' => $body,
	));

} else {
	// brief view

	$excerpt = elgg_get_excerpt($markdown_wiki->description);

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
