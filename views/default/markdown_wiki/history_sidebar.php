<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki history sidebar
 **/
$diffOwner = $vars['diffOwner'];
echo <<<HTML
<div id="sliderContainer">
	<div id="slider"></div>
	<div class="clear"></div>
</div>
<div id="ownerContainer" class="mll">
	$diffOwner
</div>
HTML;
