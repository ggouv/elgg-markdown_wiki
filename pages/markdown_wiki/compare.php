<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki compare markdown_wiki page
 **/

$markdown_wiki_guid = (int)get_input('guid');
$annoff = (int)get_input('annoff');
$from = (int)get_input('from');
$to = (int)get_input('to');
$granularity = get_input('granularity', 'word');
if (!in_array($granularity, array('character', 'word', 'sentence', 'paragraph'))) $granularity = 'character';

$markdown_wiki = get_entity($markdown_wiki_guid);
if (!$markdown_wiki) {
	forward();
}

elgg_load_js('markdown_wiki:compare');

$container = $markdown_wiki->getContainerEntity();

elgg_set_page_owner_guid($markdown_wiki->getContainerGUID());

if (elgg_instanceof($container, 'group')) {
	elgg_push_breadcrumb($container->name, "wiki/group/$container->guid/all");
} else {
	elgg_push_breadcrumb($container->name, "wiki/owner/$container->username");
}

elgg_push_breadcrumb($markdown_wiki->title, $markdown_wiki->getURL());
elgg_push_breadcrumb(elgg_echo('markdown_wiki:compare'));

elgg_register_menu_item('page', array(
	'name' => 'compare',
	'href' => "wiki/compare/$markdown_wiki_guid/$markdown_wiki->title",
	'text' => elgg_echo('markdown_wiki:page:compare'),
	'item_class' => 'elgg-state-selected'
));
elgg_register_menu_item('page', array(
	'name' => 'history',
	'href' => "wiki/history/$markdown_wiki_guid/$markdown_wiki->title",
	'text' => elgg_echo('markdown_wiki:page:history'),
));
elgg_register_menu_item('page', array(
	'name' => 'discussion',
	'href' => "wiki/discussion/$markdown_wiki_guid/$markdown_wiki->title",
	'text' => elgg_echo('markdown_wiki:page:discussion'),
));
if (can_write_to_container(elgg_get_logged_in_user_guid(), $container->guid, 'object', 'markdown_wiki')) {
	elgg_register_menu_item('page', array(
		'name' => 'edit-page',
		'href' => "wiki/edit/$markdown_wiki_guid/$markdown_wiki->title",
		'text' => elgg_echo('markdown_wiki:page:edit'),
	));
}

$sidebar = elgg_view('markdown_wiki/granularity_sidebar', array('granularity' => $granularity, 'from' => $from, 'to' => $to));

if ($from && $to && $to > $from) {

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
	
	elgg_load_library('markdown_wiki:fineDiff');

	if ($granularity == 'character') $granularity_fine = array(FineDiff::characterDelimiters);
	if ($granularity == 'word') $granularity_fine = array(FineDiff::wordDelimiters);
	if ($granularity == 'sentence') $granularity_fine = array(FineDiff::sentenceDelimiters);
	if ($granularity == 'paragraph') $granularity_fine = array(FineDiff::paragraphDelimiters);

	$annotations = elgg_get_annotations(array(
		'types' => 'object',
		'subtypes' => 'markdown_wiki',
		'annotation_names' => 'markdown_wiki',
		'annotation_ids' => array($from, $to),
	));
	
	$user = elgg_get_logged_in_user_entity();
	setlocale(LC_TIME, $user->language, strtolower($user->language) . '_' . strtoupper($user->language));
	
	foreach($annotations as $key => $annotation) {
		$values[] = unserialize($annotation->value);
		
		$owner = get_entity($annotations[$key]->owner_guid);
		$owner_link = elgg_echo('markdown_wiki:history:date', array("<a href=\"{$owner->getURL()}\">$owner->name</a>"));
		$time = htmlspecialchars(strftime(elgg_echo('markdown_wiki:history:date_format'), $annotations[$key]->time_created));
		$summary = $values[$key]['summary'];
		$array_diff = $values[$key]['diff'][$granularity];
		$diff_text = '';
		if ( $array_diff[0] != 0 ) $diff_text .= '<ins class="elgg-subtext">&nbsp;+' . $array_diff[0] . '&nbsp;</ins>';
		if ( $array_diff[1] != 0 ) $diff_text .= '<del class="elgg-subtext">&nbsp;-' . $array_diff[1] . '&nbsp;</del>';
		
$annotationSummary[$key] = <<<HTML
<div id='owner-$key' class='owner'>
	$summary<br/>
	<span class="elgg-subtext">
		$diff_text $owner_link $time
	</span>
</div>
HTML;
	}

	$diff[$i] = new FineDiff(htmlspecialchars($values[0]['text'], ENT_QUOTES, 'UTF-8', false), htmlspecialchars($values[1]['text'], ENT_QUOTES, 'UTF-8', false), $granularity_fine);
	$diffHTML = "<div id='diff-from' class='diff'>" . preg_replace('/ /', '&nbsp;', $diff[$i]->renderDiffToHTML()) . '</div>';
	
	$content = "<div class='diff-output'>" . $diffHTML . '</div>';
	$title = elgg_echo('markdown_wiki:compare:result', array('$markdown_wiki->title'));
	
	$sidebar .= elgg_view('markdown_wiki/compare_sidebar', array('from' => $annotationSummary[0], 'to' => $annotationSummary[1]));
	
	
} else {

	$content = elgg_view_form('markdown_wiki/compare', array(
		'disable_security' => true,
		'action' => "wiki/compare/$markdown_wiki_guid/$markdown_wiki->title"
	), array(
		'markdown_wiki' => $markdown_wiki,
		'annoff' => $annoff
	));
	$title = elgg_echo('markdown_wiki:compare', array('$markdown_wiki->title'));

}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
	'class' => 'fixed-sidebar',
));
echo elgg_view_page($title, $body);