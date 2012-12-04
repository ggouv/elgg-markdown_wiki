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
			echo '<div><label>' . elgg_echo("markdown_wiki:$name") . '</label>';
			echo elgg_view("input/$type", array(
				'name' => $name,
				'value' => $vars[$name],
				'cansave' => true,
				'class' => 'allWidth'
			)) . '</div>';
			break;
		
		case 'summary':
			echo '<div class="summary">';
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
					$list[0] = elgg_echo('markdown_wiki:access:private');
					unset($list[2]); // no public. 
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
