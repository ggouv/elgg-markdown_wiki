<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki edit widget
 **/

// set default value
if (!isset($vars['entity']->markdown_wiki_num)) {
	$vars['entity']->markdown_wiki_num = 4;
}

$params = array(
	'name' => 'params[markdown_wiki_num]',
	'value' => $vars['entity']->markdown_wiki_num,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
);
$dropdown = elgg_view('input/dropdown', $params);

?>
<div>
	<?php echo elgg_echo('markdown_wiki:num'); ?>
	<?php echo $dropdown; ?>
</div>
