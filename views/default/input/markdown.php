<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki markdown text input
 *	Displays a markdown text input field that can use WYSIWYG editor
 *
 * @uses $vars['value']    The current value, if any - will be html encoded
 * @uses $vars['disabled'] Is the input field disabled?
 * @uses $vars['class']    Additional CSS class
 */

if (isset($vars['class'])) {
	$vars['class'] = "input-markdown {$vars['class']}";
} else {
	$vars['class'] = "input-markdown";
}

$value = $vars['value'];
unset($vars['value']);

?>

<textarea <?php echo elgg_format_attributes($vars); ?>>
<?php echo $value; ?>
</textarea>
