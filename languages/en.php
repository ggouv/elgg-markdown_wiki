<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki English language
 **/

$english = array(

	/**
	 * Menu items and titles
	 */
	'markdown_wiki' => "Wikis",
	'markdown_wiki:owner' => "%s's edited wiki pages",
	'markdown_wiki:groupowner' => "Group %s's wiki pages",
	'markdown_wiki:friends' => "Wiki pages edited by your friends",
	'markdown_wiki:all' => "All site wiki pages",
	'markdown_wiki:group' => "Group wiki",
	'markdown_wiki:home' => "home", // If home paseg already created, don't change it !
	'wiki:edit' => "Add wiki page",

	'groups:enable_markdown_wiki' => "Enable group wiki",

	'markdown_wiki:none' => 'No wiki pages created yet',
	
	'markdown_wiki:edit' => "Edit page \"%s\"",
	'markdown_wiki:history' => "History of page \"%s\"",
	'markdown_wiki:discussion' => "Discussion of page \"%s\"",
	'markdown_wiki:compare' => "Compare revisions of page \"%s\"",
	'markdown_wiki:compare:result' => "Revisions differences of page \"%s\"",
	'markdown_wiki:page:edit' => "Edit page",
	'markdown_wiki:page:history' => "History",
	'markdown_wiki:page:discussion' => "Discussion",
	'markdown_wiki:page:compare' => "Compare",
	
	'markdown_wiki:search_in_group' => "Search page in this group %s",
	'markdown_wiki:search_in_group:or_create' => "or create it",
	'markdown_wiki:search_in_all_group' => "Search page in all groups",
	'markdown_wiki:search:title' => "Search results for %s",
	'markdown_wiki:search:in_text:title' => "Other pages containing %s:",

	'markdown_wiki:sidebar:granularity' => "Granularity",
	'markdown_wiki:sidebar:history' => "History",
	'markdown_wiki:sidebar:history:50max' => "50 max",
	'markdown_wiki:sidebar:compare:from' => "From",
	'markdown_wiki:sidebar:compare:to' => "To",
	'markdown_wiki:granularity:character' => "Character",
	'markdown_wiki:granularity:word' => "Word",
	'markdown_wiki:granularity:sentence' => "Sentence",
	'markdown_wiki:granularity:paragraph' => "Paragraph",
	'markdown_wiki:del' => 'del',
	'markdown_wiki:ins' => 'ins',
	'markdown_wiki:toggle-modification' => "Toggle modifications",
	'markdown_wiki:redirect_from' => "Redirected from",
	
	'markdown_wiki:compare:button' => "Compare these revisions",
	
	'markdown_wiki:settings' => "Wiki settings",
	'markdown_wiki:group:settings:title' => "Settings of wiki's group %s",
	'markdown_wiki:group:settings:option' => "Display all pages instead of home page",
	'markdown_wiki:group:settings:info' => "Turn on this option if you want that the link in the sidebar go to all pages instead of group's home page",

	/**
	* River
	**/
	'river:create:object:markdown_wiki' => "%s submited the page %s",
	'river:comment:object:markdown_wiki' => "%s commented on the page %s",
	'river:update:object:markdown_wiki' => "%s modified the page %s",

	/**
	* Widget
	**/
	'markdown_wiki:num' => "Number of pages to display:",
	'markdown_wiki:widget:description' => "Display your latest wiki pages.",
	'markdown_wiki:more' => "More",

	/**
	 * Form fields
	 */
	'markdown_wiki:description' => "Text",
	'markdown_wiki:summary' => "Summary",
	'markdown_wiki:minorchange' => "Minor change.",
	'markdown_wiki:tags' => "Tags",
	'markdown_wiki:write_access_id' => "Write access",

	'markdown_wiki:preview' => "Preview",
	'markdown_wiki:HTML_output' => "HTML output",
	'markdown_wiki:syntax' => "Syntax guide",
	'markdown_wiki:syntax:clicktoexpand' => "Cliquer pour déplier",

	'markdown_wiki:search:result:not_found' => "There were no result matching the query.",
	'markdown_wiki:search:result:not_found:create_it' => "Create the page %s in %s's wiki group.",
	'markdown_wiki:search:result:not_found:similar' => "Check before the search results below to see whether the topic is already covered.",
	'markdown_wiki:search:result:found:page' => "There is a page named %s in %s's wiki group.",
	'markdown_wiki:create' => "This page doesn't exist. Create it !",

	/**
	 * Status and error messages
	 */
	'markdown_wiki:no_access' => "You cannot edit this page.",
	'markdown_wiki:no_group' => "Group doesn't exist.",
	'markdown_wiki:error:no_access' => "You don't got permission to edit this page.",
	'markdown_wiki:delete:success' => "Page deleted.",
	'markdown_wiki:delete:failure' => "Page doesn't deleted.",
	'markdown_wiki:error:no_group' => "There was no group defined.",
	'markdown_wiki:error:no_title' => "There was no title defined.",
	'markdown_wiki:error:no_description' => "You have to write some text in the page.",
	'markdown_wiki:error:no_entity' => "Page cannot found.",
	'markdown_wiki:error:no_save' => "Page cannot be saved.",
	'markdown_wiki:error:already_exist' => "A page with the same name already exist.",
	'markdown_wiki:saved' => "Page edited.",
	'markdown_wiki:redirected' => "Page redirected from %s",
	'markdown_wiki:group:settings:save:success' => "Settings saved.",
	'markdown_wiki:group:settings:save:failed' => "Cannot save settings.",

	/**
	 * Object
	 */
	'item:object:markdown_wiki' => "Pages",
	'markdown_wiki:strapline' => "Last modified %s by %s in group %s",
	
	'markdown_wiki:history:date' => "By %s on",
	'markdown_wiki:history:date_format' => "%e %B %Y at %H:%M",

);

add_translation('en', $english);
