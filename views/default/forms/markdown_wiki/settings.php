<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki settings form
 **/

$markdown_wiki_all_enabled = elgg_extract('markdown_wiki_all_enabled', $vars, false);

$group_guid = elgg_get_page_owner_guid();

?>

<div>
	<label><?php echo elgg_echo('markdown_wiki:group:settings:option'); ?></label><br/>
	<?php
		echo elgg_view('input/checkbox', array(
			'name' => 'markdown_wiki_all_enabled',
			'checked' => $markdown_wiki_all_enabled ? $markdown_wiki_all_enabled : false
		)); ?>
	<?php echo elgg_echo('markdown_wiki:group:settings:info'); ?>
</div>

<div class="elgg-foot">
	<?php
	
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $group_guid));
	
	echo elgg_view('input/submit', array('value' => elgg_echo("save")));
	
	?>
</div>