
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki javascript file for editor
 *
 * Based on Simple Wysiwym Editor for jQuery (Michael Shepanski) http://pushingkarma.com/projects/jquery-wysiwym/
 * Version: 2.0 (2011-01-26)
 */

var BLANKLINE = '';
var Wysiwym = {};

$.fn.wysiwym = function(options) {
	this.EDITORCLASS = null;							// Class to use for the wysiwym editor
	this.BUTTONCLASS = 'markdown-editor hidden fly';	// Class to use for the wysiwym buttons
	this.textelem = this;								// Javascript textarea element
	this.textarea = $(this);							// jQuery textarea object
	this.markup = new Wysiwym.Markdown(this);			// Wysiwym Markup set to use
	this.defaults = {									// Default option values
		containerButtons: undefined					// jQuery elem to place buttons (makes one by default)
	};
	this.options = $.extend(this.defaults, options ? options : {});

	// Add the button container and all buttons
	this.initializeButtons = function() {
		var markup = this.markup;
		if (this.options.containerButtons == undefined)
			this.options.containerButtons = $('<div>', {'class': this.BUTTONCLASS}).insertBefore(this.textarea);
		for (var i=0; i<markup.buttons.length; i++) {
			// Create the button and apply first / last classes
			var button = markup.buttons[i];
			var jqbutton = button.create();
			if (i == 0) { jqbutton.addClass('first'); }
			if (i == markup.buttons.length-1) { jqbutton.addClass('last'); }
			// Bind the button data and click event callback
			var data = $.extend({markup:this.markup}, button.data);
			jqbutton.bind('click', data, button.callback).tipsy({
				live: true,
				offset: 8,
				fade: true,
				delayIn: 500,
				gravity: 's'
			});
			this.options.containerButtons.append(jqbutton);
		}
	};

	// Initialize the AutoIndent trigger
	this.initializeAutoIndent = function() {
		if (this.markup.autoindents) {
			var data = {markup:this.markup};
			this.textarea.bind('keydown', data, Wysiwym.autoIndent);
		}
	};

	// Initialize the Wysiwym Editor
	if (this.EDITORCLASS) this.textarea.wrap($('<div>', {'class': this.EDITORCLASS}));
	this.initializeButtons();
	this.initializeAutoIndent();
};


/*----------------------------------------------------------------------------------------------
 * Wysiwym Selection
 * Manipulate the textarea selection
 *--------------------------------------------------------------------------------------------- */
Wysiwym.Selection = function(wysiwym) {
	this.lines = wysiwym.lines;				 // Reference to wysiwym.lines
	this.start = { line:0, position:0 },		// Current cursor start positon
	this.end = { line:0, position:0 },		  // Current cursor end position

	// Return a string representation of this object.
	this.toString = function() {
		var str = 'SELECTION: '+ this.length() +' chars\n';
		str += 'START LINE: '+ this.start.line +'; POSITION: '+ this.start.position +'\n';
		str += 'END LINE: '+ this.end.line +'; POSITION: '+ this.end.position +'\n';
		return str;
	};

	// Add a line prefix, reguardless if it's already set or not.
	this.addLinePrefixes = function(prefix) {
		for (var i=this.start.line; i <= this.end.line; i++) {
			this.lines[i] = prefix + this.lines[i];
		}
		this.start.position += prefix.length;
		this.end.position += prefix.length;
	};

	// Add the specified prefix to the selection
	this.addPrefix = function(prefix) {
		var numlines = this.lines.length;
		var line = this.lines[this.start.line];
		var newline = line.substring(0, this.start.position) +
			prefix + line.substring(this.start.position, line.length);
		this.lines[this.start.line] = newline;
		this.start.position += prefix.length;
		if (this.start.line == this.end.line)
			this.end.position += prefix.length;
	};

	// Add the specified suffix to the selection
	this.addSuffix = function(suffix) {
		var line = this.lines[this.end.line];
		var newline = line.substring(0, this.end.position) +
			suffix + line.substring(this.end.position, line.length);
		this.lines[this.end.line] = newline;
	};

	// Append the specified text to the selection
	this.append = function(text) {
		var line = this.lines[this.end.line];
		var newline = line.substring(0, this.end.position) +
			text + line.substring(this.end.position, line.length);
		this.lines[this.end.line] = newline;
		this.end.position += text.length;
	};

	// Return an array of lines in the selection
	this.getLines = function() {
		var selectedlines = [];
		for (var i=this.start.line; i <= this.end.line; i++)
			selectedlines[selectedlines.length] = this.lines[i];
		return selectedlines;
	};

	// Return true if selected text contains has the specified prefix
	this.hasPrefix = function(prefix) {
		var line = this.lines[this.start.line];
		var start = this.start.position - prefix.length;
		if ((start < 0) || (line.substring(start, this.start.position) != prefix))
			return false;
		return true;
	};

	// Return true if selected text contains has the specified suffix
	this.hasSuffix = function(suffix) {
		var line = this.lines[this.end.line];
		var end = this.end.position + suffix.length;
		if ((end > line.length) || (line.substring(this.end.position, end) != suffix))
			return false;
		return true;
	};

	// Insert the line before the selection to the specified text. If force is
	// set to false and the line is already set, it will be left alone.
	this.insertPreviousLine = function(newline, force) {
		force = force !== undefined ? force : true;
		var prevnum = this.start.line - 1;
		if ((force) || ((prevnum >= 0) && (this.lines[prevnum] != newline))) {
			this.lines.splice(this.start.line, 0, newline);
			this.start.line += 1;
			this.end.line += 1;
		}
	};

	// Insert the line after the selection to the specified text. If force is
	// set to false and the line is already set, it will be left alone.
	this.insertNextLine = function(newline, force) {
		force = force !== undefined ? force : true;
		var nextnum = this.end.line + 1;
		if ((force) || ((nextnum < this.lines.length) && (this.lines[nextnum] != newline)))
			this.lines.splice(nextnum, 0, newline);
	};

	// Return true if selected text is wrapped with prefix & suffix
	this.isWrapped = function(prefix, suffix) {
		return ((this.hasPrefix(prefix)) && (this.hasSuffix(suffix)));
	};

	// Return the selection length
	this.length = function() {
		return this.val().length;
	};

	// Return true if all lines have the specified prefix. Optionally
	// specify prefix as a regular expression.
	this.linesHavePrefix = function(prefix) {
		for (var i=this.start.line; i <= this.end.line; i++) {
			var line = this.lines[i];
			if ((typeof(prefix) == 'string') && (!line.startswith(prefix))) {
				return false;
			} else if ((typeof(prefix) != 'string') && (!line.match(prefix))) {
				return false;
			}
		}
		return true;
	};

	// Prepend the specified text to the selection
	this.prepend = function(text) {
		var line = this.lines[this.start.line];
		var newline = line.substring(0, this.start.position) +
			text + line.substring(this.start.position, line.length);
		this.lines[this.start.line] = newline;
		// Update Class Variables
		if (this.start.line == this.end.line)
			this.end.position += text.length;
	};

	// Remove the prefix from each line in the selection. If the line
	// does not contain the specified prefix, it will be left alone.
	// Optionally specify prefix as a regular expression.
	this.removeLinePrefixes = function(prefix) {
		for (var i=this.start.line; i <= this.end.line; i++) {
			var line = this.lines[i];
			var match = prefix;
			// Check prefix is a regex
			if (typeof(prefix) != 'string')
				match = line.match(prefix)[0];
			// Do the replace
			if (line.startswith(match)) {
				this.lines[i] = line.substring(match.length, line.length);
				if (i == this.start.line)
					this.start.position -= match.length;
				if (i == this.end.line)
					this.end.position -= match.length;
			}

		}
	};

	// Remove the previous line. If regex is specified, it will
	// only be removed if there is a match.
	this.removeNextLine = function(regex) {
		var nextnum = this.end.line + 1;
		var removeit = false;
		if ((nextnum < this.lines.length) && (regex) && (this.lines[nextnum].match(regex)))
			removeit = true;
		if ((nextnum < this.lines.length) && (!regex))
			removeit = true;
		if (removeit)
			this.lines.splice(nextnum, 1);
	};

	// Remove the specified prefix from the selection
	this.removePrefix = function(prefix) {
		if (this.hasPrefix(prefix)) {
			var line = this.lines[this.start.line];
			var start = this.start.position - prefix.length;
			var newline = line.substring(0, start) +
				line.substring(this.start.position, line.length);
			this.lines[this.start.line] = newline;
			this.start.position -= prefix.length;
			if (this.start.line == this.end.line)
				this.end.position -= prefix.length;
		}
	};

	// Remove the previous line. If regex is specified, it will
	// only be removed if there is a match.
	this.removePreviousLine = function(regex) {
		var prevnum = this.start.line - 1;
		var removeit = false;
		if ((prevnum >= 0) && (regex) && (this.lines[prevnum].match(regex)))
			removeit = true;
		if ((prevnum >= 0) && (!regex))
			removeit = true;
		if (removeit) {
			this.lines.splice(prevnum, 1);
			this.start.line -= 1;
			this.end.line -= 1;
		}
	};

	// Remove the specified suffix from the selection
	this.removeSuffix = function(suffix) {
		if (this.hasSuffix(suffix)) {
			var line = this.lines[this.end.line];
			var end = this.end.position + suffix.length;
			var newline = line.substring(0, this.end.position) +
				line.substring(end, line.length);
			this.lines[this.end.line] = newline;
		}
	};

	// Set the prefix of each selected line. If the prefix is already and
	// set, the line will be left alone.
	this.setLinePrefixes = function(prefix, increment, add) {
		increment = increment ? increment : false;
		for (var i=this.start.line; i <= this.end.line; i++) {
			if (add || !this.lines[i].startswith(prefix)) {
				// Check if prefix is incrementing
				if (increment) {
					var num = parseInt(prefix.match(/\d+/)[0]);
					prefix = prefix.replace(num, num+1);
				}
				// Add the prefix to the line
				var numspaces = this.lines[i].match(/^\s*/)[0].length;
				this.lines[i] = this.lines[i].lstrip();
				this.lines[i] = prefix + this.lines[i];
				if (i == this.start.line)
					this.start.position += prefix.length - numspaces;
				if (i == this.end.line)
					this.end.position += prefix.length - numspaces;
			}
		}
	};

	// Unwrap the selection prefix & suffix
	this.unwrap = function(prefix, suffix) {
		this.removePrefix(prefix);
		this.removeSuffix(suffix);
	};

	// Remove blank lines from before and after the selection.  If the
	// previous or next line is not blank, it will be left alone.
	this.unwrapBlankLines = function() {
		wysiwym.selection.removePreviousLine(/^\s*$/);
		wysiwym.selection.removeNextLine(/^\s*$/);
	};

	// Return the selection value
	this.val = function() {
		var value = '';
		for (var i=0; i < this.lines.length; i++) {
			var line = this.lines[i];
			if ((i == this.start.line) && (i == this.end.line)) {
				return line.substring(this.start.position, this.end.position);
			} else if (i == this.start.line) {
				value += line.substring(this.start.position, line.length) +'\n';
			} else if ((i > this.start.line) && (i < this.end.line)) {
				value += line +'\n';
			} else if (i == this.end.line) {
				value += line.substring(0, this.end.position)
			}
		}
		return value;
	};

	// Wrap the selection with the specified prefix & suffix
	this.wrap = function(prefix, suffix) {
		this.addPrefix(prefix);
		this.addSuffix(suffix);
	};

	// Wrap the selected lines with blank lines.  If there is already
	// a blank line in place, another one will not be added.
	this.wrapBlankLines = function() {
		if (wysiwym.selection.start.line > 0)
			wysiwym.selection.insertPreviousLine(BLANKLINE, false);
		if (wysiwym.selection.end.line < wysiwym.lines.length - 1)
			wysiwym.selection.insertNextLine(BLANKLINE, false);
	};

}


/*----------------------------------------------------------------------------------------------
 * Wysiwym Textarea
 * This can used used for some or all of your textarea modifications. It will keep track of
 * the the current text and selection positions. The general idea is to keep track of the
 * textarea in terms of Line objects.  A line object contains a lineType and supporting text.
 *--------------------------------------------------------------------------------------------- */
Wysiwym.Textarea = function(textarea) {
	this.textelem = textarea.get(0)					// Javascript textarea element
	this.textarea = textarea;						// jQuery textarea object
	this.lines = [];								// Current textarea lines
	this.selection = new Wysiwym.Selection(this);	// Selection properties & manipulation

	// Return a string representation of this object.
	this.toString = function() {
		var str = 'TEXTAREA: #'+ this.textarea.attr('id') +'\n';
		str += this.selection.toString();
		str += '---\n';
		for (var i=0; i<this.lines.length; i++)
			str += 'LINE '+ i +': '+ this.lines[i] +'\n';
		return str;
	};

	// Return the current text value of this textarea object
	this.getProperties = function() {
		var newtext = '';			// New textarea value
		var selectionStart = 0;		// Absolute cursor start position
		var selectionEnd = 0;		// Absolute cursor end position
		for (var i=0; i < this.lines.length; i++) {
			if (i == this.selection.start.line)
				selectionStart = newtext.length + this.selection.start.position;
			if (i == this.selection.end.line)
				selectionEnd = newtext.length + this.selection.end.position;
			newtext += this.lines[i];
			if (i != this.lines.length - 1)
				newtext += '\n';
		}
		return [newtext, selectionStart, selectionEnd];
	};

	// Return the absolute start and end selection postions
	// StackOverflow #1: http://goo.gl/2vSnF
	// StackOverflow #2: http://goo.gl/KHm0d
	this.getSelectionStartEnd = function() {
		if (typeof(this.textelem.selectionStart) == 'number') {
			var startpos = this.textelem.selectionStart;
			var endpos = this.textelem.selectionEnd;
		} else {
			this.textelem.focus();
			var text = this.textelem.value.replace(/\r\n/g, '\n');
			var textlen = text.length;
			var range = document.selection.createRange();
			var textrange = this.textelem.createTextRange();
			textrange.moveToBookmark(range.getBookmark());
			var endrange = this.textelem.createTextRange();
			endrange.collapse(false);
			if (textrange.compareEndPoints('StartToEnd', endrange) > -1) {
				var startpos = textlen;
				var endpos = textlen;
			} else {
				var startpos = -textrange.moveStart('character', -textlen);
				//startpos += text.slice(0, startpos).split('\n').length - 1;
				if (textrange.compareEndPoints('EndToEnd', endrange) > -1) {
					var endpos = textlen;
				} else {
					var endpos = -textrange.moveEnd('character', -textlen);
					//endpos += text.slice(0, endpos).split('\n').length - 1;
				}
			}
		}
		return [startpos, endpos];
	};

	// Update the textarea with the current lines and cursor settings
	this.update = function() {
		var properties = this.getProperties();
		var newtext = properties[0];
		var selectionStart = properties[1];
		var selectionEnd = properties[2];
		this.textarea.val(newtext);
		if (this.textelem.setSelectionRange) {
			this.textelem.setSelectionRange(selectionStart, selectionEnd);
		} else if (this.textelem.createTextRange) {
			var range = this.textelem.createTextRange();
			range.collapse(true);
			range.moveStart('character', selectionStart);
			range.moveEnd('character', selectionEnd - selectionStart);
			range.select();
		}
		this.textarea.focus().keyup();
	};

	// Initialize the Wysiwym.Textarea
	this.init = function() {
		var text = textarea.val().replace(/\r\n/g, '\n');
		var selectionInfo = this.getSelectionStartEnd(this.textelem);
		var selectionStart = selectionInfo[0];
		var selectionEnd = selectionInfo[1];
		var endline = 0;
		while (endline >= 0) {
			var endline = text.indexOf('\n');
			var line = text.substring(0, endline >= 0 ? endline : text.length);
			if ((selectionStart <= line.length) && (selectionEnd >= 0)) {
				if (selectionStart >= 0) {
					this.selection.start.line = this.lines.length;
					this.selection.start.position = selectionStart;
				}
				if (selectionEnd <= line.length) {
					this.selection.end.line = this.lines.length;
					this.selection.end.position = selectionEnd;
				}
			}
			this.lines[this.lines.length] = line;
			text = endline >= 0 ? text.substring(endline + 1, text.length) : '';
			selectionStart -= endline + 1;
			selectionEnd -= endline + 1;
		}
		// Tweak the selection end position if its on the edge
		if ((this.selection.end.position == 0) && (this.selection.end.line != this.selection.start.line)) {
			this.selection.end.line -= 1;
			this.selection.end.position = this.lines[this.selection.end.line].length;
		}
	};
	this.init();
};


/*----------------------------------------------------------------------------------------------
 * Wysiwym Button
 * Represents a single button in the Wysiwym editor.
 *--------------------------------------------------------------------------------------------- */
Wysiwym.Button = function(name, callback, data, cssclass) {
	this.name = name;				  // Button Name
	this.callback = callback;		  // Callback function for this button
	this.data = data ? data : {};	  // Callback arguments
	this.cssclass = cssclass;		  // CSS Class to apply to button

	// Create and return a new Button jQuery element
	this.create = function() {
		if (this.name == 'sep') {
			var button = $('<span>', {'class': 'sep mls'});
		} else {
			var button = $('<div>', {
				'class': 'btn gwfb t25 tooltip s o8 editor-'+ this.name + ' ' + this.cssclass,
				title: this.name,
				unselectable: 'on' // Make everything 'unselectable' so IE doesn't freak out
			});
		}
		return button;
	};
}


/*----------------------------------------------------------------------------------------------
 * Wysiwym Button Callbacks
 * Useful functions to help easily create Wysiwym buttons
 *--------------------------------------------------------------------------------------------- */
// Prefix each line in the selection with the specified text.
Wysiwym.title = function(event) {
	var markup = event.data.markup;	// (required) Markup Language
	var prefix = event.data.prefix;	// (required) Line prefix text
	var wrap = event.data.wrap;		// (optional) If true, wrap list with blank lines
	var regex = event.data.regex;	  // (optional) Set to regex matching prefix to increment num
	var add = event.data.add;	  // (optional) Char to add first time
	var wysiwym = new Wysiwym.Textarea(markup.textarea);
	if (wysiwym.selection.linesHavePrefix(regex?regex:prefix)) {
		wysiwym.selection.setLinePrefixes(prefix, regex, true);
		if (wrap) { wysiwym.selection.unwrapBlankLines(); }
	} else {
		//console.log('t'+prefix + add+'t');
		wysiwym.selection.setLinePrefixes(prefix + add, regex, true);
		if (wrap) { wysiwym.selection.wrapBlankLines(); }
	}
	wysiwym.update();
};

// Wrap the selected text with a prefix and suffix string.
Wysiwym.span = function(event) {
	var markup = event.data.markup;	// (required) Markup Language
	var prefix = event.data.prefix;	// (required) Text wrap prefix
	var suffix = event.data.suffix;	// (required) Text wrap suffix
	var text = event.data.text;		// (required) Default wrap text (if nothing selected)
	var wysiwym = new Wysiwym.Textarea(markup.textarea);
	if (wysiwym.selection.isWrapped(prefix, suffix)) {
		wysiwym.selection.unwrap(prefix, suffix);
	} else if (wysiwym.selection.length() == 0) {
		wysiwym.selection.append(text);
		wysiwym.selection.wrap(prefix, suffix);
	} else {
		wysiwym.selection.wrap(prefix, suffix);
	}
	wysiwym.update();
};

// Prefix each line in the selection with the specified text.
Wysiwym.list = function(event) {
	var markup = event.data.markup;	// (required) Markup Language
	var prefix = event.data.prefix;	// (required) Line prefix text
	var wrap = event.data.wrap;		// (optional) If true, wrap list with blank lines
	var regex = event.data.regex;	  // (optional) Set to regex matching prefix to increment num
	var wysiwym = new Wysiwym.Textarea(markup.textarea);
	if (wysiwym.selection.linesHavePrefix(regex?regex:prefix)) {
		wysiwym.selection.removeLinePrefixes(regex?regex:prefix);
		if (wrap) { wysiwym.selection.unwrapBlankLines(); }
	} else {
		wysiwym.selection.setLinePrefixes(prefix, regex);
		if (wrap) { wysiwym.selection.wrapBlankLines(); }
	}
	wysiwym.update();
};

// Prefix each line in the selection according based off the first selected line.
Wysiwym.block = function(event) {
	var markup = event.data.markup;	// (required) Markup Language
	var prefix = event.data.prefix;	// (required) Line prefix text
	var wrap = event.data.wrap;		// (optional) If true, wrap list with blank lines
	var wysiwym = new Wysiwym.Textarea(markup.textarea);
	var firstline = wysiwym.selection.getLines()[0];
	if (firstline.startswith(prefix)) {
		wysiwym.selection.removeLinePrefixes(prefix);
		if (wrap) { wysiwym.selection.unwrapBlankLines(); }
	} else {
		wysiwym.selection.addLinePrefixes(prefix);
		if (wrap) { wysiwym.selection.wrapBlankLines(); }
	}
	wysiwym.update();
};


/*----------------------------------------------------------------------------------------------
 * Wysiwym AutoIndent
 * Handles auto-indentation when enter is pressed
 *--------------------------------------------------------------------------------------------- */
Wysiwym.autoIndent = function(event) {

	// ctrl or command key
	if (event.metaKey) {
		var wrapper = $(event.currentTarget).parents('.description-wrapper');
		if (event.keyCode == 66) {
			wrapper.find('.editor-bold').click();
			return false;
		}
		if (event.keyCode == 73) {
			wrapper.find('.editor-italic').click();
			return false;
		}
		if (event.keyCode == 83) {
			if (wrapper.hasClass('cansave')) {
				var fieldset = $(event.currentTarget).parents('fieldset');
				fieldset.find('.elgg-button-submit').click();
				return false;
			}
			return true;
		}
	}

	// Only continue if keyCode == 13 or 9
	if (event.keyCode == 13 || event.keyCode == 9 ) {
		// ReturnKey pressed, lets indent!
		var markup = event.data.markup;	// Markup Language
		var wysiwym = new Wysiwym.Textarea(markup.textarea);
		var linenum = wysiwym.selection.start.line;
		var line = wysiwym.lines[linenum];
		var postcursor = line.substring(wysiwym.selection.start.position, line.length);

		if (event.keyCode == 9) {
			if (event.shiftKey) {
				wysiwym.selection.removeLinePrefixes('    ');
			} else {
				wysiwym.selection.addLinePrefixes('    ');
			}
			wysiwym.update();
			return false;
		} else if (event.shiftKey) {
			wysiwym.selection.addPrefix('  \n');
			wysiwym.update();
			return false;
		}


		// Make sure nothing is selected & there is no text after the cursor
		if ((wysiwym.selection.length() != 0) || (postcursor))
			return true;
		// So far so good; check for a matching indent regex
		for (var i=0; i < markup.autoindents.length; i++) {
			var regex = markup.autoindents[i];
			var matches = line.match(regex);
			if (matches) {
				var prefix = matches[0];
				var suffix = line.substring(prefix.length, line.length);
				// NOTE: If a selection is made in the regex, it's assumed that the
				// matching text is a number should be auto-incremented (ie: #. lists).
				if (matches.length == 2) {
					var num = parseInt(matches[1]);
					prefix = prefix.replace(matches[1], num+1);
				}
				if (suffix) {
					// Regular auto-indent; Repeat the prefix
					wysiwym.selection.addPrefix('\n'+ prefix);
					wysiwym.update();
					return false;
				} else {
					// Return on blank indented line (clear prefix)
					wysiwym.lines[linenum] = BLANKLINE;
					wysiwym.selection.start.position = 0;
					wysiwym.selection.end.position = wysiwym.selection.start.position;
					if (markup.exitindentblankline) {
						wysiwym.selection.addPrefix('\n');
					}
					wysiwym.update();
					return false;
				}
			}
		}
	}
	return true;
}


/* ---------------------------------------------------------------------------
 * Wysiwym Markdown
 * Markdown markup language for the Wysiwym editor
 * Reference: http://daringfireball.net/projects/markdown/syntax
 *---------------------------------------------------------------------------- */
Wysiwym.Markdown = function(textarea) {
	this.textarea = textarea;	// jQuery textarea object

	// Initialize the Markdown Buttons
	this.buttons = [  //array('titleplus', 'titleminus', 'bold', 'italic', 'strike', 'sep', 'link', 'image', 'sep', 'bullet', 'numeric', 'sep', 'quote', 'code', 'sep', 'plus', 'zero', 'minus');
		new Wysiwym.Button('title', Wysiwym.title, {prefix:'#', wrap:true, add:' '}),
		new Wysiwym.Button('bold', Wysiwym.span, {prefix:'**', suffix:'**', text:'strong text'}),
		new Wysiwym.Button('italic', Wysiwym.span, {prefix:'_', suffix:'_',  text:'italic text'}),
		new Wysiwym.Button('strike', Wysiwym.span, {prefix:'~~', suffix:'~~',  text:'strike text'}),
		new Wysiwym.Button('sep'),
		new Wysiwym.Button('link', Wysiwym.span, {prefix:'[', suffix:']()', text:'link text'}),
		new Wysiwym.Button('image', Wysiwym.span, {prefix:'![', suffix:']()', text:'image text'}),
		new Wysiwym.Button('sep'),
		new Wysiwym.Button('bullet', Wysiwym.list, {prefix:'* ', wrap:true}),
		new Wysiwym.Button('numeric', Wysiwym.list, {prefix:'0. ', wrap:true, regex:/^\s*\d+\.\s/}),
		new Wysiwym.Button('sep'),
		new Wysiwym.Button('quote', Wysiwym.list, {prefix:'> ', wrap:true}),
		new Wysiwym.Button('code', Wysiwym.block, {prefix:'    ', wrap:true}),
		new Wysiwym.Button('sep'),
		new Wysiwym.Button('plus', Wysiwym.span, {prefix:'{+ **Pour :**\n', suffix:'\n}', text:' '}),
		new Wysiwym.Button('zero', Wysiwym.span, {prefix:'{0 **Neutre :**\n', suffix:'\n}', text:' '}),
		new Wysiwym.Button('minus', Wysiwym.span, {prefix:'{- **Contre :**\n', suffix:'\n}', text:' '}),
	];

	// Configure auto-indenting
	this.exitindentblankline = true;	// True to insert blank line when exiting auto-indent ;)
	this.autoindents = [				// Regex lookups for auto-indent
		/^\s*\*\s/,						// Bullet list
		/^\s*(\d+)\.\s/,				// Number list (number selected for auto-increment)
		/^\s*\>\s/,						// Quote list
		/^\s{4}\s*/						// Code block
	];
};



/*----------------------------------------------------------------------
 * Additional Javascript Prototypes
 *-------------------------------------------------------------------- */
String.prototype.strip = function() { return this.replace(/^\s+|\s+$/g, ''); };
String.prototype.lstrip = function() { return this.replace(/^\s+/, ''); };
String.prototype.rstrip = function() { return this.replace(/\s+$/, ''); };
String.prototype.startswith = function(str) { return this.substring(0, str.length) == str; };
String.prototype.endswith = function(str) { return this.substring(str.length, this.length) == str; };