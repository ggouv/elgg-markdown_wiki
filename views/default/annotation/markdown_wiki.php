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

$value = unserialize($annotation->value);

if (!$vars['summary_view']) {
	$icon = elgg_view_entity_icon($owner, 'tiny');
	$owner_link = "<a href=\"{$owner->getURL()}\">$owner->name</a>";

	$text = elgg_view("output/markdown_wiki_text", array("value" => $value['text'], "class" => "diff-output"));
	$friendlytime = elgg_view_friendly_time($annotation->time_created);

$body = <<<HTML
<div class="mbn $class">
	$owner_link
	<span class="elgg-subtext">
		$friendlytime
	</span>
	$text
</div>
HTML;
echo elgg_view_image_block($icon, $body);

} else if ($vars['summary_view'] === true) {

	$owner_link = "<a href=\"{$owner->getURL()}\">$owner->name</a>";

	$summary = $value['summary'];
	$array_diff = $value['diff']['word'];

	$diff_text = '';
	if ( $array_diff[0] != 0 ) $diff_text .= '<ins class="elgg-subtext">&nbsp;+' . $array_diff[0] . '&nbsp;</ins>';
	if ( $array_diff[1] != 0 ) $diff_text .= '<del class="elgg-subtext">&nbsp;-' . $array_diff[1] . '&nbsp;</del>';
	
	$time = htmlspecialchars(strftime(elgg_echo('markdown_wiki:history:date_format'), $annotation->time_created));

	if ($vars['compare']) {
		$compare = elgg_view("input/radio", array(
			'name' => 'from',
			'options' => array('' => "$annotation->id"),
			'value' => '',
			'class' => 'float'
		));
		$compare .= elgg_view("input/radio", array(
			'name' => 'to',
			'options' => array('' => "$annotation->id"),
			'value' => '',
			'class' => 'float mrm'
		));
			
		$by = elgg_echo('by');

$body = <<<HTML
$compare $time $by $owner_link $diff_text $summary
HTML;

	} else {
	
$body = <<<HTML
$compare
<div class="mbm $class">
	$summary<br/>
	<span class="elgg-subtext history-module">
		$diff_text $owner_link $time
	</span>
</div>
HTML;

	}

echo $body;
}
