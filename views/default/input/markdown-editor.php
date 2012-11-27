<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki markdown editor
 *	Displays a markdown WYSIWYM editor
 *
 * @uses $vars['toggle']    Add a button to toggle between textarea/preview
 * @uses $vars['disabled']  Is the editor disabled?
 * @uses $vars['class']     Additional CSS class
 */

if (isset($vars['class'])) {
	$vars['class'] = "markdown-editor hidden top {$vars['class']}";
} else {
	$vars['class'] = "markdown-editor hidden top";
}

$items = array('titleplus', 'titleminus', 'bold', 'emphasis', 'strike', 'sep', 'link', 'image', 'sep', 'bullet', 'numeric', 'sep', 'quote', 'code', 'sep', 'plus', 'zero', 'minus');

echo "<div class='{$vars['class']}'>";
foreach ($items as $item) {
	if ($item == 'sep') {
		echo "<span class='sep'></span>";
	} else {
		$title = elgg_echo("markdown:editor:btn:$item");
		echo "<span title='{$title}' class='btn gwfb t25 tooltip s o8 editor-$item'></span>";
	}
}
echo '</div>';

?>
