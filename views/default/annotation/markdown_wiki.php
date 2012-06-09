<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki markdown_wiki annotation
 *
 * @note To add or remove from the annotation menu, register handlers for the menu:annotation hook.
 *
 * @uses $vars['annotation']
 */

$annotation = $vars['annotation'];
$class = $vars['class'];

$owner = get_entity($annotation->owner_guid);
if (!$owner) {
	return true;
}

$menu = elgg_view_menu('annotation', array(
	'annotation' => $annotation,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz float-alt',
));

$value = unserialize($annotation->value);

if (!$vars['summary_view']) {
	$icon = elgg_view_entity_icon($owner, 'tiny');
	global $fb; $fb->info($icon);
	$owner_link = "<a href=\"{$owner->getURL()}\">$owner->name</a>";

	$text = elgg_view("output/markdown_wiki_text", array("value" => $value['text'], "class" => "diff-output"));
	$friendlytime = elgg_view_friendly_time($annotation->time_created);

$body = <<<HTML
<div class="mbn $class">
	$menu
	$owner_link
	<span class="elgg-subtext">
		$friendlytime
	</span>
	$text
</div>
HTML;
echo elgg_view_image_block($icon, $body);

} else if ($vars['summary_view'] === true) {
	setlocale(LC_TIME, $owner->language, strtolower($owner->language) . '_' . strtoupper($owner->language));

	$summary = $value['summary'];
	$array_diff = $value['diff']['character'];

	$diff_text = '';
	if ( $array_diff[0] != 0 ) $diff_text .= '<ins class="elgg-subtext">&nbsp;+' . $array_diff[0] . '&nbsp;</ins>';
	if ( $array_diff[1] != 0 ) $diff_text .= '<del class="elgg-subtext">&nbsp;-' . $array_diff[1] . '&nbsp;</del>';
	
	$time = htmlspecialchars(strftime(elgg_echo('markdown_wiki:history:date_format'), $annotation->time_created));
	
$body = <<<HTML
<div class="mbm $class">
	$menu
	$summary<br/>
	<span class="elgg-subtext history-module">
		$diff_text $owner_link $time
	</span>
</div>
HTML;

echo $body;
}
