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
		case 'description': 
			echo '<div class="description-wrapper"><div class="description"><label>' . elgg_echo("markdown_wiki:$name") . '</label>';
				echo elgg_view("input/$type", array(
					'name' => $name,
					'value' => $vars[$name],
					'class' => 'allWidth'
				));
			echo '</div><div class="pane-markdown"><div class="prm">';
				echo elgg_view("input/dropdown", array(
					'name' => 'swich-pane',
					'value' => 'preview-markdown',
					'options_values' => array(
						'preview-markdown' => elgg_echo('markdown_wiki:preview'),
						'output-markdown' => elgg_echo('markdown_wiki:HTML_output'),
						'help-markdown' => elgg_echo('markdown_wiki:syntax')
					)
				));
				echo '<div class="pane preview-markdown markdown-body mlm pas"></div>';
				echo '<div class="pane output-markdown hidden mlm pas"></div>';
				if ( elgg_view_exists("markdown_wiki/syntax/$user->language") ) {
					echo elgg_view('markdown_wiki/syntax/' . $user->language);
				} else {
					echo elgg_view('markdown_wiki/syntax/en');
				}
				echo '</div></div></div>';
			break;
		
		case 'summary':
			echo '<div class="summary ptl">';
			echo elgg_trigger_plugin_hook('markdown_wiki_edit', 'summary', $vars['guid'], '');
			echo '<label>' . elgg_echo("markdown_wiki:$name") . '</label>';
			echo elgg_view("input/$type", array(
				'name' => $name,
				'value' => $vars[$name],
			));
			echo elgg_view("input/checkbox", array(
				'name' => 'minorchange'
			));
			echo elgg_echo('markdown_wiki:minorchange');
			echo '</div>';
			break;
		
		case 'tags':
			break;
		
		case 'write_access_id':
			if ($user) {
				$entity = get_entity($vars['guid']);
				if (!$vars['guid'] && can_write_to_container($user, $vars['container_guid'], 'object', 'markdown_wiki') || $entity && $entity->canEdit($user_guid) ) {
					$list = get_write_access_array();
					$list = array($list[1], $list[2]);
					$group_access_collections = get_user_access_collections($vars['container_guid']);
					$list[$group_access_collections[0]->id] = $group_access_collections[0]->name;
					echo '<div>';
					echo '<label>' . elgg_echo("markdown_wiki:$name") . '</label><br/>';
					echo elgg_view("input/$type", array(
						'name' => $name,
						'value' => $vars[$name],
						'options_values' => $list,
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
			break;
	}

}

$cats = elgg_view('input/categories', $vars);
if (!empty($cats)) echo $cats;

echo '<div class="elgg-foot">';

echo elgg_view('input/submit', array('value' => elgg_echo('save')));

echo '</div>';
