<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki markdown text input
 *	Displays a markdown text input field that can use WYSIWYM editor
 *
 * @uses $vars['value']    The current value, if any - will be html encoded
 * @uses $vars['preview']  False to disable preview, toggle for toggled preview. defaut TRUE
 * @uses $vars['disabled'] Is the input field disabled?
 * @uses $vars['cansave']  Can we use crtl + s to save page?
 * @uses $vars['class']    Additional CSS class
 */

$preview = elgg_extract('preview', $vars, true);
$disabled = elgg_extract('disabled', $vars, false);
$cansave = elgg_extract('cansave', $vars, false);

if ($preview === false) {
	$vars['class'] = "{$vars['class']} allWidth";
} else if ($preview === 'toggle') {
	$vars['class'] = "{$vars['class']}";
} else {
	$preview = '';
	$vars['class'] = "{$vars['class']}";
}

if (isset($vars['class'])) {
	$vars['class'] = "input-markdown {$vars['class']}";
} else {
	$vars['class'] = "input-markdown";
}

$tabs['preview'] = array(
	'text' => elgg_echo('markdown_wiki:preview'),
	'href' => "#",
	'selected' => true,
	'priority' => 200,
);
$tabs['output'] = array(
	'text' => elgg_echo('markdown_wiki:HTML_output'),
	'href' => "#",
	'priority' => 300,
);
$tabs['help'] = array(
	'text' => elgg_echo('markdown_wiki:syntax'),
	'href' => "#",
	'priority' => 400,
);

foreach ($tabs as $name => $tab) {
	$tab['name'] = $name;
	elgg_register_menu_item('markdown', $tab);
}

?>

<div class="description-wrapper float<?php if ($cansave == true) echo ' cansave'; if ($preview === toggle) echo ' ' .$preview; ?>">
	<?php if ($preview === 'toggle') echo '<div class="toggle-preview gwf">y</div>'; ?>
	<div class="description">
	<?php
		if (!$disabled) $vars['class'] = "{$vars['class']} editor";

		echo '<textarea ' . elgg_format_attributes($vars) . '>' . $vars['value'] . '</textarea>';
	echo '</div>';

	if ($preview !== false) {
		echo elgg_view_menu('markdown', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz markdown-menu prs t25'));
	?>
		<div class="pane-markdown<?php if ($preview === 'toggle') echo ' hidden ' . $preview; ?>">
			<div class="pane preview-markdown markdown-body mlm pas"></div>
			<div class="pane output-markdown hidden mlm"></div>
			<div class="pane help-markdown hidden mlm pas"></div>
		</div>
	<?php }?>
</div>