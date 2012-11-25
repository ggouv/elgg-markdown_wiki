<?php
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki Syntax file
 **/
 
$clickToExpand = elgg_echo('markdown_wiki:syntax:clicktoexpand');

$body = <<<HTML
<div class="pane help-markdown hidden mlm pas">

<h2>Markdown syntax help</h2>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-text" title="$clickToExpand"> Text<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>for linebreak add 2 spaces at end, _italic_ or **bold**</span>
</h3>

<div id="link-text" style="display: none;">

	<h4 id="link-linebreaks">Linebreaks</h4>
	<p>End a line with two spaces to add a <code>&lt;br/&gt;</code> linebreak:</p>
	<pre>How do I love thee?<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><br/>Let me count the ways</pre>
	
	<h4 id="link-italics-bold">Italics and Bold</h4>
	<pre><span class="hi">*</span>This is italicized<span class="hi">*</span>, and so is <span class="hi">_</span>this<span class="hi">_</span>.
	<span class="hi">**</span>This is bold<span class="hi">**</span>, and so is <span class="hi">__</span>this<span class="hi">__</span>.
	Use <span class="hi">***</span>italics and bold together<span class="hi">***</span> if you <span class="hi">___</span>have to<span class="hi">___</span>.</pre>

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-headers" title="$clickToExpand"> Headers<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>underline by = and - or use #</span>
</h3>

<div id="link-headers" style="display: none;">

	<p>Underline text to make the two <code>&lt;h1&gt;</code> <code>&lt;h2&gt;</code> top-level headers :</p>
	<pre>Header 1
		<span class="hi">========</span>
		Header 2
		<span class="hi">--------</span>
	</pre>

	<p>The number of = or - signs doesn&#39;t matter; one will work. But using enough to underline the text makes your titles look better in plain text.</p>
	<p>Use hash marks for several levels of headers:</p>
	<pre><span class="hi">#</span> Header 1 <span class="hi">#</span>
		<span class="hi">##</span> Header 2 <span class="hi">##</span>
		<span class="hi">###</span> Header 3 <span class="hi">###</span>
		<span class="hi">####</span> Header 4 <span class="hi">####</span>
	</pre>
	<p>The closing # characters are optional.</p>
	&nbsp;

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-horizontal-rules" title="$clickToExpand"> Horizontal Rules<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>3 or more -, + or *</span>
</h3>

<div id="link-horizontal-rules" style="display: none;">

	<p>Insert a horizontal rule <code>&lt;hr/&gt;</code> by putting three or more hyphens, asterisks, or underscores on a line by themselves:</p>
	<pre><span class="hi">---</span></pre>
	<pre>Rule #1<br/><span class="hi">---</span>
		Rule #2<br/><span class="hi">*******</span>
		Rule #3<br/><span class="hi">___</span>
	</pre>
	<p>Using spaces between the characters also works:</p>
	<pre>Rule #4<br/><span class="hi">- - - -</span></pre>

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-lists" title="$clickToExpand"> Lists<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>bullet with -, + or * and list with 1.</span>
</h3>

<div id="link-lists" style="display: none;">

	<h4 id="link-simple-lists">Simple lists</h4>
	<p>A bulleted <code>&lt;ul&gt;</code> list:</p>
	<pre><div class="bl">a linebreak</div>
		<span class="hi">-</span><span class="spaces">&nbsp;</span>Use a minus sign for a bullet
		<span class="hi">+</span><span class="spaces">&nbsp;</span>Or plus sign
		<span class="hi">*</span><span class="spaces">&nbsp;</span>Or an asterisk
		<div class="bl">a linebreak</div>
	</pre>
	<p>A numbered <code>&lt;ol&gt;</code> list:</p>
	<pre><div class="bl">a linebreak</div>
		<span class="hi">1.</span><span class="spaces">&nbsp;</span>Numbered lists are easy
		<span class="hi">2.</span><span class="spaces">&nbsp;</span>Markdown keeps track of the numbers for you
		<span class="hi">7.</span><span class="spaces">&nbsp;</span>So this will be item 3.
		<div class="bl">a linebreak</div>
	</pre>

	<h4 id="link-advanced-lists">Advanced lists: Nesting</h4>
	<p>To put other Markdown blocks in a list; just indent four spaces for each nesting level:</p>
	<pre><div class="bl">a linebreak</div>
		<span class="hi">1.</span><span class="spaces">&nbsp;</span>Bulleted lists in a numered list item:
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="hi">-</span><span class="spaces">&nbsp;</span>Indented.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="hi">*</span><span class="spaces">&nbsp;</span>indented height spaces.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="hi">-</span><span class="spaces">&nbsp;</span>Four spaces again.
		<span class="hi">2.</span><span class="spaces">&nbsp;</span>Multiple paragraphs in a list items:
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>It&#39;s best to indent the paragraphs four spaces
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>You can get away with three, but it can get
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>confusing when you nest other things.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>Stick to four.<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>You can do multiple paragraphs in a list.
		This paragraph is still part of the list item, but it looks messy to humans.  So it&#39;s a good idea to wrap your nested paragraphs manually.
		<span class="hi">3.</span><span class="spaces">&nbsp;</span>Code block in a list item:
		<div class="bl">a linebreak</div>
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>Skip a line and indent eight spaces.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>That&#39;s four spaces for the list
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>and four to trigger the code block.
		<span class="hi">4.</span><span class="spaces">&nbsp;</span>Blockquotes in a list item:
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="hi">&gt;</span> indent the &gt; by four spaces.
	</pre>

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#blockquotes" title="$clickToExpand"> Simple blockquotes</a>
	<span class="expander-arrow-small-hide expander-arrow-small-show">
</h3>

<div id="blockquotes" style="display: none;">

	<p>Add a <code>&gt;</code> to the beginning of any line to create a <code>&lt;blockquote&gt;</code>.</p>
	<pre><span class="hi">&gt;</span> The syntax is based on the way email programs
		<span class="hi">&gt;</span> usually do quotations. You don&#39;t need to hard-wrap
		<span class="hi">&gt;</span> the paragraphs in your blockquotes, but it looks much nicer if you do.  Depends how lazy you feel.
	</pre>

	<h4>Advanced blockquotes: Nesting</h4>
	<p>To put other Markdown blocks in a <code>&lt;blockquote&gt;</code>, just add a <code>&gt;</code> followed by a space:</p>
	<pre><span class="hi">&gt;</span> The &gt; on the blank lines is optional.
		<span class="hi">&gt;</span> Include it or don&#39;t; Markdown doesn&#39;t care.
		<span class="hi">&gt;</span><span class="spaces">&nbsp;</span>
		<span class="hi">&gt;</span> But your plain text looks better to
		<span class="hi">&gt;</span> humans if you include the extra `&gt;`
		<span class="hi">&gt;</span> between paragraphs.
	</pre>
	<p>Blockquotes within a blockquote:</p>
	<pre><span class="hi">&gt;</span> A standard blockquote is indented
		<span class="hi">&gt;</span> <span class="hi">&gt;</span> A nested blockquote is indented more
		<span class="hi">&gt;</span> <span class="hi">&gt;</span> <span class="hi">&gt;</span> <span class="hi">&gt;</span><span class="spaces">&nbsp;</span>You can nest to any depth.
	</pre>
	<p>Lists in a blockquote:</p>
	<pre><span class="hi">&gt;</span><span class="hi">-</span><span class="spaces">&nbsp;</span>A list in a blockquote
		<span class="hi">&gt;</span><span class="hi">-</span><span class="spaces">&nbsp;</span>With a &gt; and space in front of it
		<span class="hi">&gt;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="hi">*</span><span class="spaces">&nbsp;</span>A sublist
	</pre>
	<p>Code block in a blockquote:</p>
	<pre><div class="bl">a linebreak</div>
		<span class="hi">&gt;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>Indent five spaces total.  The first
		<span class="hi">&gt;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>one is part of the blockquote designator.
	</pre>
	
</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-links" title="$clickToExpand"> Links<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>[foo](http://foo.com)</span>
</h3>

<div id="link-links" style="display: none;">

	<h4 id="link-basic-links">Basic Links</h4>
	<p>There are three ways to write links. Each is easier to read than the last:</p>
	<pre>Here&#39;s a direct link to <span class="hi">[http://www.google.com/]()</span>.
		Here&#39;s an inline link to <span class="hi">[Google](http://www.google.com/)</span>.
		Here&#39;s a reference-style link to <span class="hi">[Google][1]</span>.
		Here&#39;s a very readable link to <span class="hi">[Yahoo!][yahoo]</span>.
		Here&#39;s an implicite link to <span class="hi">[Wikipedia][]</span>.<br/>
		<span class="hi">[1]:</span> http://www.google.com/
		<span class="hi">[yahoo]:</span> http://www.yahoo.com/
		<span class="hi">[Wikipedia]:</span> http://www.wikipedia.org/
	</pre>
	<p>The link definitions can appear anywhere in the document -- before or after the place where you use them. The link definition names <code>[1]</code> and <code>[yahoo]</code>
		can be any unique string, and are case-insensitive; <code>[yahoo]</code> is the same as <code>[YAHOO]</code>.</p>

	<h4 id="link-relative-links">Relative Links</h4>
	<p>We have modified our Markdown parser to support "relative" links and wiki style.</p>
	<pre>Here&#39;s a direct link to <span class="hi">[a page]()</span>.
		Here&#39;s an inline link to <span class="hi">[an another page](the link)</span>.
		Here&#39;s a reference-style link to <span class="hi">[an another page][1]</span>.<br/>
		<span class="hi">[1]:</span> the link
	</pre>
	<p>The link will be blue or red depending if the page exist in the group of the current page, but not in the preview.</p>
	<p>You can also made a link to a page in another group.
	The link must start like <code>/wiki/group/GUID/page/</code>, where GUID is the id of the group. Take a look:</p>
	<pre>Here&#39;s a link to the home page of <span class="hi">[the group](/wiki/group/42/page/home)</span>.
		Here&#39;s a link to <span class="hi">[a page of another group][1]</span>.<br/>
		<span class="hi">[1]:</span> /wiki/group/42/page/the page
	</pre>

	<h4 id="link-advanced-links">Advanced Links</h4>
	<p>Links can have a title attribute, which will show up on hover. Title attributes
		can also be added; they are helpful if the link itself is not descriptive enough
		to tell users where they&#39;re going.</p>
	<pre>Here&#39;s a <span class="hi">[poorly-named link](http://www.google.com/ "Google")</span>.
		Visit <span class="hi">[us][web]</span>.<br/>
		<span class="hi">[web]:</span> http://elgg.org/ "Elgg"
	</pre>
	<p>You can also use standard HTML hyperlink syntax.</p>
	<pre>&lt;a href="http://example.com" title="example"&gt;example&lt;/a&gt;</pre>

	<h4 id="link-bare-links">Bare URLs</h4>
	<p>Force URLs by enclosing them in angle brackets:</p>
	<pre>Have you seen <span class="hi">&lt;</span>http://example.com<span class="hi">&gt;</span>?</pre>

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-image" title="$clickToExpand"> Images<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>![foo](http://foo.com/img.jpeg)</span>
</h3>

<div id="link-image" style="display: none;">

	<p>Images are exactly like links, but they have an exclamation point in front of them:</p>
	<pre>![foo](http://foo.com/img.jpeg).</pre>
	<p>The word in square brackets is the alt text, which gets displayed if the browser can&#39;t show the image. Be sure to include meaningful alt text for screen-reading software.</p>
	<p>Just like links, images work with reference syntax and titles:</p>
	<pre>This page is <span class="hi">![foo][foo]</span>.
	<span class="hi">[foo]:</span> http://foo.com/img.jpeg
			 "Image foo"
	</pre>
	<p>You can use a slightly more verbose version of implicit reference names:</p>
	<pre>This <span class="hi">![foo][]</span> works.</pre>
	<p>The reference name is also used as the alt text.</p>
	<p>You can also use standard HTML image syntax, which allows you to scale the width and height of the image.</p>
	<pre>&lt;img src="http://foo.com/img.jpeg" width="100" height="100"&gt;</pre>
	<p>URLs can be relative or full.</p>
	&nbsp;

</div>

<h3>
	<a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-code" title="$clickToExpand"> Code<span class="expander-arrow-small-hide expander-arrow-small-show"></a>
	<span>indent by 4 spaces</span>
</h3>

<div id="link-code" style="display: none;">

	<h4 id="link-block-code">Block Code</h4>
	<p>Indent four spaces to create an escaped <code>&lt;pre&gt;</code><code>&lt;code&gt;</code> block:</p>
	<pre>
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>printf("Hello world!");  /* his suicide note
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>                              was in C */
	</pre>

	<p>The text will be wrapped in tags, and displayed in a monospaced font. The first four spaces will be stripped off, but all other whitespace will be preserved.</p>
	<p>Markdown and HTML is ignored within a code block:</p>
	<pre>
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>&lt;blink&gt;
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>   You would hate this if it weren&#39;t
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>   wrapped in a code block.
		<span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span><span class="spaces">&nbsp;</span>&lt;/blink&gt;
	</pre>
	
	<p>An other way is to wrap your code by three backticks. You can also specify the type of code in the block-code:
	<pre>```php
			echo = 'Hello World!';
		```
	</pre>

	<h4 id="link-code-spans">Code Spans</h4>
	<p>Use backticks to create an inline <code>&lt;code&gt;</code> span:</p>
	<pre>Press the <span class="hi">`</span>&lt;Tab&gt;<span class="hi">`</span> key, then type a <span class="hi">`</span>$<span class="hi">`</span>.</pre>
	<p>(The backtick key is in the upper left corner of most keyboards.)</p>
	<p>Like code blocks, code spans will be displayed in a monospaced font. Markdown and HTML will not work within them. Note that, <i>unlike</i> code blocks, code spans require you to manually escape any HTML within!</p>
	&nbsp;

</div>

<h3><a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-html" title="$clickToExpand">
	Inline HTML<span class="expander-arrow-small-hide expander-arrow-small-show">
</a></h3>

<div id="link-html" style="display: none;">

	<p>If you need to do something that Markdown can&#39;t handle, use HTML. Note that only a very strict subset of HTML are supported!</a></p>
	<pre> To reboot your computer, press <span class="hi">&lt;kbd&gt;</span>ctrl<span class="hi">&lt;/kbd&gt;</span>+&lt;kbd&gt;alt&lt;/kbd&gt;+&lt;kbd&gt;del&lt;/kbd&gt;.
	</pre>
	<p>Markdown is smart enough not to mangle your span-level HTML:</p>
	<pre><span class="hi">&lt;b&gt;</span>Markdown works <span class="hi">*</span>fine<span class="hi">*</span> in here.<span class="hi">&lt;/b&gt;</span>
	</pre>
	<p>Block-level HTML elements have a few restrictions:</p>
	<ol>
		<li>They must be separated from surrounding text by blank lines.</li>
		<li>The begin and end tags of the outermost block element must not be indented.</li>
		<li>Markdown can&#39;t be used within HTML blocks.</li>
	</ol>
	<pre><span class="hi">&lt;pre&gt;</span>You can <span class="hi">&lt;em&gt;</span>not<span class="hi">&lt;/em&gt;</span> use Markdown in here.<span class="hi">&lt;/pre&gt;</span>
	</pre>

</div>

<h3><a rel="toggle" class="elgg-widget-collapse-button elgg-state-active elgg-widget-collapsed" href="#link-need-more-detail" title="$clickToExpand">
	Need More Detail?<span class="expander-arrow-small-hide expander-arrow-small-show">
</a></h3>

<div id="link-need-more-detail" style="display: none;">

	<p>Visit the <a target="_blank" href="http://daringfireball.net/projects/markdown/syntax">official Markdown syntax reference page</a>.</p><br/>

</div>

</div>
HTML;

echo str_replace("\t",'',$body);