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


/*
markdown_wiki:add elgg-markdown_wiki/pages/markdown_wiki/new.php line 29
markdown_wiki:new elgg-markdown_wiki/pages/markdown_wiki/owner.php line 27
markdown_wiki:group elgg-markdown_wiki/start.php line 205
*/





$english = array(

	/**
	 * Menu items and titles
	 */

	'markdown_wiki' => "Wikis",
	'markdown_wiki:owner' => "%s's edited wiki pages",
	'markdown_wiki:friends' => "Friends' edited wiki pages",
	'markdown_wiki:all' => "All site wiki pages",
	'markdown_wiki:group' => "Group wiki",
	'markdown_wiki:home' => "home", // If home paseg already created, don't change it !
	'wiki:edit' => "Add wiki page",

	'groups:enable_markdown_wiki' => "Enable group wiki",
	'groups:enable_markdown_wiki:home' => "Group wiki:<br/>On: group wiki link go to all group's wiki pages. Off: group wiki link go to group's home page",

	'markdown_wiki:none' => 'No wiki pages created yet',
	
	'markdown_wiki:edit' => "Edit page \"%s\"",
	'markdown_wiki:page:edit' => "Edit page",
	'markdown_wiki:page:history' => "History",
	
	'markdown_wiki:search_in_group' => "Search page in this group %s",
	'markdown_wiki:search_in_group:or_create' => "or create it",
	'markdown_wiki:search_in_all_group' => "Search page in all groups",
	'markdown_wiki:search:title' => "Search results for %s",
	'markdown_wiki:search:in_text:title' => "Other pages containing %s:",

	'markdown_wiki:sidebar:granularity' => "Granularity",
	'markdown_wiki:sidebar:history' => "History",
	'markdown_wiki:sidebar:history:50max' => "50 max",
	'markdown_wiki:granularity:character' => 'Character',
	'markdown_wiki:granularity:word' => 'Word',
	'markdown_wiki:granularity:sentence' => 'Sentence',
	'markdown_wiki:granularity:paragraph' => 'Paragraph',
	'markdown_wiki:del' => 'del',
	'markdown_wiki:ins' => 'ins',

	/**
	* River
	**/
	
	/**
	* Widget
	**/

	'markdown_wiki:num' => "Number of pages to display:",

	/**
	 * Form fields
	 */

	'markdown_wiki:description' => "Text",
	'markdown_wiki:summary' => "Summary",
	'markdown_wiki:tags' => "Tags",
	'markdown_wiki:access_id' => "Access",

	'markdown_wiki:preview' => "Preview",
	'markdown_wiki:HTML_output' => "HTML output",
	'markdown_wiki:syntax' => "Syntax guide",

	'markdown_wiki:search:result:not_found' => "There were no results matching the query.",
	'markdown_wiki:search:result:not_found:create_it' => "Create the page %s in %s's wiki group.",
	'markdown_wiki:search:result:not_found:similar' => "Check before the search results below to see whether the topic is already covered.",
	'markdown_wiki:search:result:found:page' => "There is a page named %s in %s's wiki group.",

	'markdown_wiki:syntax_guide' => "Markdown Syntax Guide
=====================

This is an overview of Markdown's syntax.  For more information, visit the [Markdown web site].

 [Markdown web site]:
   http://daringfireball.net/projects/markdown/






Italics and Bold
================


*This is italicized*, and so is _this_.

**This is bold**, and so is __this__.

You can use ***italics and bold together*** if you ___have to___.






Links
=====


Simple links
------------

There are three ways to write links.  Each is easier to read than the last:

Here's an inline link to [Google](http://www.google.com/).
Here's a reference-style link to [Google] [1].
Here's a very readable link to [Yahoo!].

  [1]: http://www.google.com/
  [yahoo!]: http://www.yahoo.com/

The link definitions can appear anywhere in the document -- before or after the place where you use them.  The link definition names (`1` and `Yahoo!`) can be any unique string, and are case-insensitive; `[Yahoo!]` is the same as `[YAHOO!]`.


Advanced links: Title attributes
--------------------------------

You can also add a `title` attribute to a link, which will show up when the user holds the mouse pointer it.  Title attributes are helpful if your link text is not descriptive enough to tell users where they're going.  (In reference links, you can use optionally parentheses for the link title instead of quotation marks.)

Here's a [poorly-named link](http://www.google.com/ \"Google\").
Never write \"[click here][^2]\".
Trust [me].

  [^2]: http://www.w3.org/QA/Tips/noClickHere
        (Advice against the phrase \"click here\")
  [me]: http://www.attacklab.net/ \"Attacklab\"


Advanced links: Bare URLs
-------------------------

You can write bare URLs by enclosing them in angle brackets:

My web site is at &lt;http://www.attacklab.net&gt;.

If you use this format for email addresses, Showdown will encode the address to make it harder for spammers to harvest.  Try it and look in the *HTML Output* pane to see the results:

Humans can read this, but most spam harvesting robots can't: &lt;me@privacy.net&gt;






Headers
=======


There are two ways to do headers in Markdown.  (In these examples, Header 1 is the biggest, and Header 6 is the smallest.)

You can underline text to make the two top-level headers:

Header 1
========

Header 2
--------

The number of `=` or `-` signs doesn't matter; you can get away with just one.  But using enough to underline the text makes your titles look better in plain text.

You can also use hash marks for all six levels of HTML headers:

# Header 1 #
## Header 2 ##
### Header 3 ###
#### Header 4 ####
##### Header 5 #####
###### Header 6 ######

The closing `#` characters are optional.






Horizontal Rules
================


You can insert a horizontal rule by putting three or more hyphens, asterisks, or underscores on a line by themselves:

---

*******
___

You can also use spaces between the characters:

-  -  -  -

All of these examples produce the same output.






Lists
=====


Simple lists
------------

A bulleted list:

- You can use a minus sign for a bullet
+ Or plus sign
* Or an asterisk

A numbered list:

1. Numbered lists are easy
2. Markdown keeps track of the numbers for you
7. So this will be item 3.

A double-spaced list:

- This list gets wrapped in `&lt;p&gt;` tags

- So there will be extra space between items


Advanced lists: Nesting
-----------------------

You can put other Markdown blocks in a list; just indent four spaces for each nesting level.  So:

1. Lists in a list item:
    - Indented four spaces.
        * indented eight spaces.
    - Four spaces again.

2.  Multiple paragraphs in a list items:

    It's best to indent the paragraphs four spaces
    You can get away with three, but it can get
    confusing when you nest other things.
    Stick to four.

    We indented the first line an extra space to align
    it with these paragraphs.  In real use, we might do
    that to the entire list so that all items line up.

    This paragraph is still part of the list item, but it looks messy to humans.  So it's a good idea to wrap your nested paragraphs manually, as we did with the first two.

3. Blockquotes in a list item:

    &gt; Skip a line and
    &gt; indent the &gt;'s four spaces.

4. Preformatted text in a list item:

        Skip a line and indent eight spaces.
        That's four spaces for the list
        and four to trigger the code block.






Blockquotes
===========


Simple blockquotes
------------------

Blockquotes are indented:

&gt; The syntax is based on the way email programs
&gt; usually do quotations. You don't need to hard-wrap
&gt; the paragraphs in your blockquotes, but it looks much nicer if you do.  Depends how lazy you feel.


Advanced blockquotes: Nesting
-----------------------------

You can put other Markdown blocks in a blockquote; just add a `&gt;` followed by a space:

Parragraph breaks in a blockquote:

&gt; The &gt; on the blank lines is optional.
&gt; Include it or don't; Markdown doesn't care.
&gt;
&gt; But your plain text looks better to
&gt; humans if you include the extra `&gt;`
&gt; between paragraphs.


Blockquotes within a blockquote:

&gt; A standard blockquote is indented
&gt; &gt; A nested blockquote is indented more
&gt; &gt; &gt; &gt; You can nest to any depth.


Lists in a blockquote:

&gt; - A list in a blockquote
&gt; - With a &gt; and space in front of it
&gt;     * A sublist

Preformatted text in a blockquote:

&gt;     Indent five spaces total.  The first
&gt;     one is part of the blockquote designator.






Images
======


Images are exactly like links, but they have an exclamation point in front of them:

 ![Valid XHTML] (http://w3.org/Icons/valid-xhtml10).

The word in square brackets is the alt text, which gets displayed if the browser can't show the image.  Be sure to include meaningful alt text for blind users' screen-reader software.

Just like links, images work with reference syntax and titles:

 This page is ![valid XHTML][checkmark].

 [checkmark]: http://w3.org/Icons/valid-xhtml10
           \"What are you smiling at?\"


**Note:**

Markdown does not currently support the shortest reference syntax for images:

  Here's a broken ![checkmark].

But you can use a slightly more verbose version of implicit reference names:

  This ![checkmark][] works.

The reference name (`valid icon`) is also used as the alt text.






Inline HTML
===========


If you need to do something that Markdown can't handle, you can always just use HTML:

 Strikethrough humor is &lt;strike&gt;funny&lt;/strike&gt;.

Markdown is smart enough not to mangle your span-level HTML:

&lt;u&gt;Markdown works *fine* in here.&lt;/u&gt;

Block-level HTML elments have a few restrictions:

1. They must be separated from surrounding text by blank
   lines.
2. The begin and end tags of the outermost block element
   must not be indented.
3. You can't use Markdown within HTML blocks.

So:

&lt;div style=\"background-color: lightgray\"&gt;
    You can &lt;em&gt;not&lt;/em&gt; use Markdown in here.
&lt;/div&gt;






Preformatted Text
=================


You can include preformatted text in a Markdown document.

To make a code block, indent four spaces:

    printf(\"goodbye world!\");  /* his suicide note
                                  was in C */

The text will be wrapped in `&lt;pre&gt;` and `&lt;code&gt;` tags, and the browser will display it in a monospaced typeface.  The first four spaces will be stripped off, but all other whitespace will be preserved.

You cannot use Markdown or HTML within a code block, which makes them a convenient way to show samples of Markdown or HTML syntax:

    &lt;blink&gt;
       You would hate this if it weren't
       wrapped in a code block.
    &lt;/blink&gt;






Code Spans
==========


You can make inline `&lt;code&gt;` tags by using code spans.  Use backticks to make a code span:

 Press the `&lt;Tab&gt;` key, then type a `$`.

(The backtick key is in the upper left corner of most keyboards.)

Like code blocks, code spans will be displayed in a monospaced typeface.  Markdown and HTML will not work within them:

 Markdown italicizes things like this: `I *love* it.`

 Don't use the `&lt;font&gt;` tag; use CSS instead.",

	/**
	 * Status and error messages
	 */
	
	'markdown_wiki:no_access' => "You cannot edit this page.",
	'markdown_wiki:delete:success' => "Page deleted.",
	'markdown_wiki:delete:failure' => "Page doesn't deleted.",
	'markdown_wiki:error:no_group' => "There was no group defined.",
	'markdown_wiki:error:no_title' => "There was no title defined.",
	'markdown_wiki:error:no_description' => "You have to write some text in the page.",
	'markdown_wiki:error:no_entity' => "Page cannot found.",
	'markdown_wiki:error:no_save' => "Page cannot be saved.",
	'markdown_wiki:error:already_exist' => "A page with the same name already exist.",
	'markdown_wiki:saved' => "Page edited.",

	/**
	 * Object
	 */
	'item:object:markdown_wiki' => "Article",
    'river:create:object:markdown_wiki' => "%s submited article %s",
    'river:comment:object:markdown_wiki' => "%s commented on the article %s",
	'markdown_wiki:strapline' => "Last modified %s by %s in group %s",
	
	'markdown_wiki:history:date' => "By %s on",
	'markdown_wiki:history:date_format' => "%e %B %Y at %H:%M",

);

add_translation('en', $english);
