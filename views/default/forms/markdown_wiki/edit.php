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

$vars['title'] = elgg_extract('query', $vars, $vars['title']);

$variables = elgg_get_config('markdown_wiki');
foreach ($variables as $name => $type) {
	if ($name == 'guid' && !$vars['guid']) continue;
	($name == 'summary' or $name == 'description') ? $class = " class=$name" : $class = "";
	
	if (in_array($name, array('title', 'container_guid', 'guid'))) {
		echo elgg_view("input/$type", array(
			'name' => $name,
			'value' => $vars[$name],
		));
	} else {
		echo "<div$class>";
		echo '<label>' . elgg_echo("markdown_wiki:$name") . '</label>';
		echo elgg_view("input/$type", array(
			'name' => $name,
			'value' => $vars[$name],
		));
		echo '</div>';
	}
	if ($name == 'description') {
		?>
			<div class='previewPaneWrapper'><div class='prm'>
				<?php echo elgg_view("input/dropdown", array(
					'name' => 'previewPaneDisplay',
					'value' => 'previewPane',
					'options_values' => array(
						'previewPane' => elgg_echo('markdown_wiki:preview'),
						'outputPane' => elgg_echo('markdown_wiki:HTML_output'),
						'syntaxPane' => elgg_echo('markdown_wiki:syntax')
					)
				));?>
				<div id='previewPane' class='elgg-output pane markdown-body mlm pas'></div>
				<textarea id="outputPane" class="pane hidden mlm pas" readonly="readonly"></textarea>
				<textarea id="syntaxPane" class="pane hidden mlm pas" readonly="readonly"><?php echo elgg_echo('markdown_wiki:syntax_guide'); ?></textarea>
			</div></div>
		<?php
	}
	if ($name == 'summary') echo elgg_trigger_plugin_hook('markdown_wiki_edit', 'summary', $vars['guid'], '');
}

$cats = elgg_view('input/categories', $vars);
if (!empty($cats)) echo $cats;

echo '<div class="elgg-foot">';

echo elgg_view('input/submit', array('value' => elgg_echo('save')));

echo '</div>';
