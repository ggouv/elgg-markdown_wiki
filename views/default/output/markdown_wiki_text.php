<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 * Displays a large amount of text, with new lines converted to line breaks
 *
 * @uses $vars['value'] The text to display
 * @uses $vars['class']
 */

$class = 'elgg-output';
$additional_class = elgg_extract('class', $vars, '');
if ($additional_class) {
	$vars['class'] = "$class $additional_class";
} else {
	$vars['class'] = $class;
}

$text = $vars['value'];
unset($vars['value']);

//$text = filter_tags($text);

//$text = autop($text);

$attributes = elgg_format_attributes($vars);

echo "<div $attributes>$text</div>";
