<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki edit form
 **/

$variables = elgg_get_config('markdown_wiki');
foreach ($variables as $name => $type) {
	($name == 'summary' or $name == 'description') ? $class = " class=$name" : $class = "";
	echo "<div$class>";
	echo '<label>' . elgg_echo("markdown_wiki:$name") . '</label>';

			echo elgg_view("input/$type", array(
				'name' => $name,
				'value' => $vars[$name],
			));
	echo '</div>';
	if ($name == 'description') {
		?>
			<div class='previewPaneWrapper'>
				<label class="mlm"><?php echo elgg_echo('markdown_wiki:preview'); ?></label>
				<div id='previewPane' class='elgg-output markdown-body mlm plm'></div>
			</div>
		<?php
	}
}

$cats = elgg_view('input/categories', $vars);
if (!empty($cats)) {
	echo $cats;
}


echo '<div class="elgg-foot">';
if ($vars['guid']) {
	echo elgg_view('input/hidden', array(
		'name' => 'markdown_wiki_guid',
		'value' => $vars['guid'],
	));
}
echo elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => $vars['container_guid'],
));

echo elgg_view('input/submit', array('value' => elgg_echo('save')));

echo '</div>';
