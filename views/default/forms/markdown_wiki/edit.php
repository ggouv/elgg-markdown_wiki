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
$user = elgg_get_logged_in_user_entity();

elgg_set_page_owner_guid($vars['container_guid']);

$variables = elgg_get_config('markdown_wiki');

foreach ($variables as $name => $type) {

	switch ($name) {
		case 'description': ?>
			<div class="description">
				<label><?php echo elgg_echo("markdown_wiki:$name"); ?></label>
				<?php echo elgg_view("input/$type", array(
					'name' => $name,
					'value' => $vars[$name],
				)); ?>
			</div>
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
				<div id="outputPane" class="pane hidden mlm pas"></div>
				<?php
					if ( elgg_view_exists("markdown_wiki/syntax/$user->language") ) {
						echo elgg_view('markdown_wiki/syntax/' . $user->language);
					} else {
						echo elgg_view('markdown_wiki/syntax/en');
					}
						?>
			</div></div>
			<?php
			break;
		case 'summary':
			echo '<div class="summary">';
			echo elgg_trigger_plugin_hook('markdown_wiki_edit', 'summary', $vars['guid'], '');
			echo '<label>' . elgg_echo("markdown_wiki:$name") . '</label>';
			echo elgg_view("input/$type", array(
				'name' => $name,
				'value' => $vars[$name],
			));
			echo '</div>';
			break;
		case 'tags':
			break;
		case 'write_access':
			if ($user && $vars['guid']) {
				$entity = get_entity($vars['guid']);
				if ($user->isAdmin() || $user->getGUID() == $entity->owner_guid) {
					echo '<div>';
					echo '<label>' . elgg_echo("markdown_wiki:$name") . '</label>';
					echo elgg_view("input/$type", array(
						'name' => $name,
						'value' => $vars[$name],
					));
					echo '</div>';
				}
			}
			break;
		case 'title';
			echo elgg_view("input/$type", array(
				'name' => $name,
				'value' => $vars[$name],
			));
			break;
		case 'guid':
			if ($vars['guid']) {
				echo elgg_view("input/$type", array(
					'name' => $name,
					'value' => $vars[$name],
				));
			}
			break;
		default:
			$viewInput = elgg_view("input/$type", array(
				'name' => $name,
				'value' => $vars[$name],
			));
			if ($type != 'hidden') {
				echo '<div><label>' . elgg_echo("markdown_wiki:$name") . '</label>' .$viewInput . '</div>';
			} else {
				echo $viewInput;
			}
	}

}

$cats = elgg_view('input/categories', $vars);
if (!empty($cats)) echo $cats;

echo '<div class="elgg-foot">';

echo elgg_view('input/submit', array('value' => elgg_echo('save')));

echo '</div>';
