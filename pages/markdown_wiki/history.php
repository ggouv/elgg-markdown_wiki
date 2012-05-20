<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki history of a markdown_wiki page
 **/

elgg_load_library('markdown_wiki:fineDiff');

$markdown_wiki_guid = get_input('guid');

$markdown_wiki = get_entity($markdown_wiki_guid);
if (!$markdown_wiki) {

}

$container = $markdown_wiki->getContainerEntity();
if (!$container) {

}

elgg_set_page_owner_guid($container->getGUID());

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($container->name, "pages/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "pages/owner/$container->username");
}

elgg_push_breadcrumb($markdown_wiki->title, $markdown_wiki->getURL());
elgg_push_breadcrumb(elgg_echo('markdown_wiki:history'));

$title = $markdown_wiki->title . ": " . elgg_echo('markdown_wiki:history');

$annotations = elgg_get_annotations(array(
	'types' => 'object',
	'subtypes' => 'markdown_wiki',
	'annotation_names' => 'markdown_wiki',
	'guids' => $markdown_wiki_guid,
	'limit' => 20,
	));

$diffHTML = $diffOwner = '';
for($i=count($annotations)-1; $i>=0; $i--) {
	if ($i != 0) {
		$diff[$i] = new FineDiff($annotations[$i-1]->value, $annotations[$i]->value, array(
			FineDiff::paragraphDelimiters,
			FineDiff::sentenceDelimiters,
			FineDiff::wordDelimiters,
			FineDiff::characterDelimiters
			));
		$diffHTML .= "<div id='diff-$i' class='diff hidden'>" . $diff[$i]->renderDiffToHTML() . '</div>';
	} else {
		$diffHTML .= "<div id='diff-0' class='diff hidden'>" . $annotations[0]->value . '</div>';
	}
	$owner = get_entity($annotations[$i]->owner_guid);
	$icon = elgg_view_entity_icon($owner, 'tiny');
	$owner_link = "<a href=\"{$owner->getURL()}\">$owner->name</a>";
	$friendlytime = elgg_view_friendly_time($annotations[$i]->time_created);
$body = <<<HTML
<div class="mbn">
	$owner_link
	<span class="elgg-subtext">
		$friendlytime
	</span>
</div>
HTML;
	$diffOwner .= "<div id='owner-$i' class='owner'>" . elgg_view_image_block($icon, $body) . '</div>';
}

$diff_annotation = $annotations[count($annotations)-1];
$diff_annotation->value = $diffHTML;
$content = elgg_view_annotation($diff_annotation);
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('markdown_wiki/history_sidebar', array('diffOwner' => $diffOwner)),
	'class' => 'fixed-sidebar',
));

echo elgg_view_page($title, $body);
