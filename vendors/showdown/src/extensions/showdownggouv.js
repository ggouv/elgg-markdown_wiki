//
//  Markdown ggouv Extension
//  @username   ->  <a title="username" href="#" class="user-info-popup">@username</a>
//  !group      ->  <a title="group" href="#" class="group-info-popup">!group</a>
//  #hashtag    ->  <a title="#hashtag" href="#" class="hashtag-info-popup">#hashtag</a>
//  ~~strike-through~~   ->  <del>strike-through</del>
//  pro/con

(function(){

	var showdownggouv = function(converter) {
		return [
			// Escape ! @ # in block code. We make \# and showdown add slashs only  in block code: \\\\#
			{ type: 'lang', regex: '@+', replace: '\\@'},
			{ type: 'lang', regex: '\!+([^[])', replace: '\\!$1'},
			{ type: 'lang', regex: '#+([^#\\s])', replace: '\\#$1'},

			// @username syntax
			{ type: 'html', regex: '\\B(\\\\)?@([\\w]+)\\b', replace: function(match, leadingSlash, username) {
				// Check if we matched the leading \ and return nothing changed if so
				if (leadingSlash === '\\') {
					return match;
				} else {
					return '<a title="' + username + '" href="#" class="user-info-popup">@' + username + '</a>';
				}
			}},

			// !group syntax
			{ type: 'html', regex: '\\B(\\\\)?!([\\w]+)\\b', replace: function(match, leadingSlash, group) {
				// Check if we matched the leading \ and return nothing changed if so
				if (leadingSlash === '\\') {
					return match;
				} else {
					return '<a title="' + group + '" href="#" class="group-info-popup">!' + group + '</a>';
				}
			}},

			// #hashtag syntax. Need to parse markdown and add \ on hashtag and reparse html output. This is done to skeep real \#tag and #tag in codeblock
			{ type: 'html', regex: '\\B(\\\\)?#(\\w*[^\\s\\d!-\\/:-@]+\\w*)\\b', replace: function(match, leadingSlash, tag) {
				// Check if we matched the leading \ and return nothing changed if so
				if (leadingSlash === '\\') {
					return '#' + tag;
				} else {
					return '<a title="#' + tag + '" href="#" class="hashtag-info-popup">#' + tag + '</a>';
				}
			}},

			//  ~~strike-through~~   ->  <del>strike-through</del> // NOTE: showdown already replaced "~" with "~T", so we need to adjust accordingly.
			{ type: 'lang', regex: '(~T){2}([^~]+)(~T){2}', replace: function(match, prefix, content, suffix) {
				return '<del>' + content + '</del>';
			}},

			// pro/con
			{ type: 'html', regex: '(?:|\\n){(\\d)(\\d)?([A-Za-z])?\\s(.*)\\n([\\s\\S]*?)}', replace: function(match, color, type, icon, title, content) {
				color = 'block color'+color;
				if (type) color += ' type'+type;
				if (icon) {
					icon = ' gwfb" aria-icon="'+icon+'">';
				} else {
					icon = '">';
				}
				return '%%%<div class="' + color + '@@@"><div class="header' + icon + title + '</div><div class="content">' + content + '</div></div>%%%';
			}},
			{ type: 'html', regex: '%%%%%%', replace: ''},
			{ type: 'html', regex: '%%%([\\s\\S]*?)%%%', replace: function(match, content) {
				var count = content.match(/@@@/g).length;
				return '<div class="row-fluid">' + content.replace(/@@@/g, " span" + 12/count) + '</div>';
			}},

			// unescape ! and @. Don't need #
			{ type: 'html', regex: '\\\\!', replace: '!'},
			{ type: 'html', regex: '\\\\@', replace: '@'},
			{ type: 'html', regex: '\\\\#', replace: '#'},
		];
	};

	// Client-side export
	if (typeof window !== 'undefined' && window.Showdown && window.Showdown.extensions) { window.Showdown.extensions.showdownggouv = showdownggouv; }
	// Server-side export
	if (typeof module !== 'undefined') module.exports = showdownggouv;

}());
