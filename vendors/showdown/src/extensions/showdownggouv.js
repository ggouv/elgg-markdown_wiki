//
//  Markdown ggouv Extension //
//
//  @username   ->  <a title="username" href="#" class="elgg-user-info-popup info-popup">@username</a>
//
//  !group      ->  <a title="group" href="#" class="group-info-popup info-popup">!group</a>
//
//  #hashtag    ->  <a title="#hashtag" href="#" class="hashtag-info-popup info-popup">#hashtag</a>
//
//  ~~strike-through~~   ->  <del>strike-through</del>
//
//  pro/con. Syntax : 
//  {XXX title
//  text
//  }
//  with :
//  first X     [0-9]     color of the box
//  second X    [0-9]     type of the box
//  third X     [a-ZA-Z]  icon in title (using ggouv webfont)
//
//  footnotes : [^1] with reference [^1]: thenote

(function(){
	var showdownggouv = function() {
		var footText = [],
			footnotes = [],
			t = {"@":"elgg-user","!":"group","#":"hashtag"};

		return [
			// footnotes
			{ type: 'lang', regex: '\\[\\^([A-Za-z0-9]+)\\](?!:)', replace: function(match, note) {
				footnotes.push(note);
				return '<sup>' + note + '</sup>';
			}},
			{ type: 'lang', regex: '\\n\\[\\^([A-Za-z0-9]+)\\]:\\s+(.+)', replace: function(match, note, text) {
				if (footnotes.indexOf(note) >= 0) footText.push({id: note, txt: text});
				return '\n';
			}},

			// Escape ! @ # in block code. We make \# and showdown add slashs only  in block code: \\\\#
			{ type: 'lang', regex: '\\B(@|\!(?!\\[)|#(?!#|\\s))', replace: '\\$1'},

			// @username syntax !group syntax #hashtag syntax.
			// Need to parse markdown and add \ on hashtag and reparse html output. This is done to skeep real \#tag and #tag in codeblock
			{ type: 'html', regex: '\\B(\\\\)?(@|!|#)([a-zA-Z0-9ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ_]+)', replace: function(match, leadingSlash, type, text) {
				// Check if we matched the leading \ and return nothing changed if so
				if (leadingSlash === '\\') {
					return match;
				} else {
					return '<a title="' + text + '" href="#" class="' + t[type] + '-info-popup info-popup">' + type + text + '</a>';
				}
			}},

			//  ~~strike-through~~   ->  <del>strike-through</del> // NOTE: showdown already replaced "~" with "~T", so we need to adjust accordingly.
			{ type: 'lang', regex: '~T', replace: '\\~T'},
			{ type: 'html', regex: '~{2}([^~]+)~{2}', replace: function(match, text) {
				return '<del>' + text + '</del>';
			}},

			// pro/con
			{ type: 'html', regex: '(?:|\\n){(\\d)(\\d)?([A-Za-z])?\\s(.*)\\n([\\s\\S]*?)}', replace: function(match, color, type, icon, title, content) {
				color = 'block color'+color;
				if (type) color += ' type'+type;
				icon = icon ? ' gwfb" aria-icon="'+icon+'">' : '">';
				return '%%%<div class="' + color + '@@@"><div class="header' + icon + title + '</div><div class="content">' + content + '</div></div>%%%';
			}},
			{ type: 'html', regex: '%%%%%%', replace: ''},
			{ type: 'html', regex: '%%%([\\s\\S]*?)%%%', replace: function(match, content) {
				return '<div class="row-fluid">' + content.replace(/@@@/g, " span" + 12 / content.match(/@@@/g).length) + '</div>';
			}},

			// unescape
			{ type: 'html', regex: '\\\\(@|!|#|~)', replace: '$1'},

			// add footnote at bottom
			{ type: 'output', filter: function(source){
				if (footText.length) {
					var count = 1,
						allNotes = '';

					$.each(footnotes, function(i,e) {
						var reg = new RegExp('<sup>'+e+'<\/sup>', 'gm'),
							txt = $.grep(footText, function(x) {
								return x.id == e;
							});

						if (source.match(reg) && txt.length) {
							source = source.replace(reg, '<sup id="fnref-' + count + '"><a href="'+window.location.href+'#fn-' + count + '" rel="footnote">' + count + '</a></sup>');
							allNotes += '<li id="fn-' + count + '"><p><a rev="footnote" href="'+window.location.href+'#fnref-' + count + '">↑</a> ' + txt[0].txt + '</p></li>';
							count++;
						}
					});

					footText = [];
					footnotes = [];
					return source + '<div class="footnotes"><ol>' + elgg.markdown_wiki.ShowdownConvert(allNotes) + '</ol></div>';
				} else return source;
			}}

		];
	};

	// Client-side export
	if (typeof window !== 'undefined' && window.Showdown && window.Showdown.extensions) { window.Showdown.extensions.showdownggouv = showdownggouv; }
	// Server-side export
	if (typeof module !== 'undefined') module.exports = showdownggouv;

}());
