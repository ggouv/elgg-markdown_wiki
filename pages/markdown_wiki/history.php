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

$markdown_wiki_guid = get_input('guid');

$markdown_wiki = get_entity($markdown_wiki_guid);
if (!$markdown_wiki) {
	forward();
}

elgg_load_js('markdown_wiki:history');
elgg_load_library('markdown_wiki:fineDiff');

$granularity = get_input('granularity', 'character');
if (!in_array($granularity, array('character', 'word', 'sentence', 'paragraph'))) $granularity = 'character';
if ($granularity == 'character') $granularity_fine = array(FineDiff::characterDelimiters);
if ($granularity == 'word') $granularity_fine = array(FineDiff::wordDelimiters);
if ($granularity == 'sentence') $granularity_fine = array(FineDiff::sentenceDelimiters);
if ($granularity == 'paragraph') $granularity_fine = array(FineDiff::paragraphDelimiters);

$user = elgg_get_logged_in_user_entity();
setlocale(LC_TIME, $user->language, strtolower($user->language) . '_' . strtoupper($user->language));

$container = $markdown_wiki->getContainerEntity();
if (!$container) {
}

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($container->name, "wiki/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "wiki/owner/$container->username");
}

elgg_push_breadcrumb($markdown_wiki->title, $markdown_wiki->getURL());
elgg_push_breadcrumb(elgg_echo('markdown_wiki:page:history'));

elgg_register_menu_item('title', array(
	'name' => 'ins',
	'href' => "#",
	'text' => elgg_echo('markdown_wiki:ins'),
	'link_class' => 'elgg-button-ins active',
));
elgg_register_menu_item('title', array(
	'name' => 'del',
	'href' => "#",
	'text' => elgg_echo('markdown_wiki:del'),
	'link_class' => 'elgg-button-del active',
));

elgg_register_menu_item('page', array(
	'name' => 'edit',
	'href' => "wiki/edit/$markdown_wiki_guid",
	'text' => elgg_echo('markdown_wiki:page:edit'),
));

$title = $markdown_wiki->title . ": " . elgg_echo('markdown_wiki:history');

$annotations = elgg_get_annotations(array(
	'types' => 'object',
	'subtypes' => 'markdown_wiki',
	'annotation_names' => 'markdown_wiki',
	'guids' => $markdown_wiki_guid,
	'order_by' => 'time_created asc',
	'limit' => 50,
	));

foreach($annotations as $key => $annotation) {
	$values[] = unserialize($annotation->value);
}

$diffHTML = $diffOwner = '';
for($i=count($annotations)-1; $i>=0; $i--) {
	if ($i != 0) {
		$diff[$i] = new FineDiff(htmlspecialchars($values[$i-1]['text'], ENT_QUOTES, 'UTF-8', false), htmlspecialchars($values[$i]['text'], ENT_QUOTES, 'UTF-8', false), $granularity_fine);
		$diffHTML .= "<div id='diff-$i' class='diff hidden'>" . preg_replace('/ /', '&nbsp;', $diff[$i]->renderDiffToHTML()) . '</div>';
	} else {
		$diffHTML .= "<div id='diff-0' class='diff hidden'>" . htmlspecialchars($values[0]['text'], ENT_QUOTES, 'UTF-8', false) . '</div>';
	}
	$owner = get_entity($annotations[$i]->owner_guid);
	$owner_link = elgg_echo('markdown_wiki:history:date', array("<a href=\"{$owner->getURL()}\">$owner->name</a>"));
	$time = ucwords(htmlspecialchars(strftime(elgg_echo('markdown_wiki:history:date_format'), $annotations[$i]->time_created)));
	$summary = $values[$i]['summary'];
	$array_diff = $values[$i]['diff'][$granularity];
	$diff_text = '';
	if ( $array_diff[0] != 0 ) $diff_text .= '<ins class="elgg-subtext">&nbsp;+' . $array_diff[0] . '&nbsp;</ins>';
	if ( $array_diff[1] != 0 ) $diff_text .= '<del class="elgg-subtext">&nbsp;-' . $array_diff[1] . '&nbsp;</del>';
	
$diffOwner .= <<<HTML
<div id='owner-$i' class='owner pam hidden'>
	$summary<br/>
	<span class="elgg-subtext">
		$diff_text $owner_link $time
	</span>
</div>
HTML;
}

$content = "<div class='diff-output'>" . $diffHTML . '</div>';
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('markdown_wiki/history_sidebar', array('diffOwner' => $diffOwner, 'granularity' => $granularity)),
	'class' => 'fixed-sidebar',
));

echo elgg_view_page($title, $body);