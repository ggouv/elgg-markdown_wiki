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
$user = elgg_get_logged_in_user_entity();

$preview = elgg_extract('preview', $vars, true);
$disabled = elgg_extract('disabled', $vars, false);
$cansave = elgg_extract('cansave', $vars, false);

if ($preview === false) {
	$vars['class'] = "{$vars['class']} allWidth";
} else if ($preview === 'toggle') {
	$vars['class'] = "{$vars['class']} allWidth hidden";
} else {
	$preview = '';
	$vars['class'] = "{$vars['class']}";
}

if (isset($vars['class'])) {
	$vars['class'] = "pane input-markdown {$vars['class']}";
} else {
	$vars['class'] = "pane input-markdown";
}

echo elgg_view_menu('markdown', array(
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
	'id' => $vars['id'],
));

?>

<div class="description-wrapper float<?php if ($cansave == true) echo ' cansave'; ?>">
	<div class="description">
		<?php if ($preview === 'toggle') {
			echo '<div class="toggle-preview gwf">e</div>';
		} else {
			if (!$disabled) $vars['class'] = "{$vars['class']} editor";
		}
		echo '<textarea ' . elgg_format_attributes($vars) . '>' . $vars['value'] . '</textarea>';
	echo '</div>';
	
	if ($preview !== false) { ?>
		<div class="pane-markdown<?php if ($preview !== true) echo ' ' . $preview; ?>">
			<div class="pane preview-markdown markdown-body mlm pas"></div>
			<div class="pane output-markdown hidden mlm pas"></div>
			<?php
				if ( elgg_view_exists("markdown_wiki/syntax/$user->language") ) {
					echo elgg_view('markdown_wiki/syntax/' . $user->language);
				} else {
					echo elgg_view('markdown_wiki/syntax/en');
				}
			?>
		</div>
	<?php }?>
</div>