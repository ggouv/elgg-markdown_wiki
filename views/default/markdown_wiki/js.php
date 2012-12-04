
/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki javascript file
 **/


/**
 * Elgg-markdown_wiki view initialization
 *
 * @return void
 */
ShowdownConvert = function(textToConvert) {
	var converter = new Showdown.converter({ extensions: ['showdownggouv'] });
	return converter.makeHtml(textToConvert);
}



/**
 * Elgg-markdown_wiki view initialization
 *
 * @return void
 */
elgg.provide('elgg.markdown_wiki.view');

elgg.markdown_wiki.view.init = function() {
	// convert markdown to html
	var markdownOutput = $('.elgg-output.markdown-body');
	if (markdownOutput.length) {
		$.each(markdownOutput, function() {
			$(this).replaceWith($('<div>', {class: 'elgg-output markdown-body'}).html(ShowdownConvert($(this).html())));
			$('pre code').each(function(i, e) {
				if (e.className == '') $(e).addClass('no-highlight');
				hljs.highlightBlock(e);
			});
		});
	}
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.view.init);


/**
 * Elgg-markdown_wiki history initialization
 *
 * @return void
 */
elgg.provide('elgg.markdown_wiki.history');

elgg.markdown_wiki.history.init = function() {
	$(document).ready(function() {
		if ($('.history-module .elgg-body').height() > $('#ownerContainer').height()) {
			$("#slider").height($('#ownerContainer').height()-$('#owner-0').height()-20);
		}
		var nbrDiff = $('.diff-output .diff').length -1;
		$('#diff-'+nbrDiff + ', #owner-'+nbrDiff).removeClass('hidden');
		var lastVal = nbrDiff;

		if ( nbrDiff != 0 ) {
			var slideSidebar = function(ui) {
				$('#diff-'+lastVal + ', #owner-'+lastVal).addClass('hidden');
				$('#diff-'+ui.value + ', #owner-'+ui.value).removeClass('hidden');
				var OwnerOffset = $('#owner-'+ui.value).position();
				if ($('.history-module .elgg-body').height() < $('#ownerContainer').height()) {
					$('#ownerContainer').stop().animate({top: (nbrDiff-ui.value)*($('#slider').height()/nbrDiff) - OwnerOffset.top});
				} else {
					var OwnerOffset = $('#owner-'+ui.value).position();
					$('.ui-slider-handle').css('top', OwnerOffset.top - 6);
				}
				lastVal = ui.value;
			}
			// Create the slider:
			$("#slider").slider({
				orientation: 'vertical',
				value: nbrDiff,
				min: 0,
				max: nbrDiff,
				animate: true,
				change: function(event, ui) {
					slideSidebar(ui);
				},
				slide: function(event, ui) {
					slideSidebar(ui);
				}
			});
			
			$('.owner').click(function() {
				var valString = $(this).attr('id');
				$("#slider").slider({
					value: valString.substr(valString.indexOf('owner-') + "owner-".length),
				});
			});
			
			$('#ownerContainer').bind('mousewheel DOMMouseScroll', function(e) {
				if ($('.history-module .elgg-body').height() > $('#ownerContainer').height()) return;
				var delta = e.wheelDelta || -e.detail;
				var OwnerContainerOffset = $(this).position();
				var max = $(this).height() - $('.history-module .elgg-body').height();
				var top = OwnerContainerOffset.top + ( delta < 0 ? -1 : 1 ) * 30;
				if ( top > 0 ) top =0;
				if ( top < -max ) top = -max; 
				$(this).css({top: top});
				e.preventDefault();
			});
		}
		
		// toggle ins and delt
		$('.elgg-button-ins, .elgg-button-del').click(function() {
			x = $(this).hasClass('elgg-button-ins') ? 'ins' : 'del';
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$('.diff-output '+x).hide();
			} else {
				$(this).addClass('active');
				$('.diff-output '+x).show();
			}
		});
	});
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.history.init);


/**
 * Resize textarea and other block if there are
 */
elgg.markdown_wiki.resizePanes = function(textarea, previewPane, outputPane, syntaxPane) {
	var textareaHeight = $.browser.mozilla ? textarea.get(0).scrollHeight + 10 : textarea.get(0).scrollHeight,
		previewHeight = previewPane.hasClass('hidden') ? 0 : previewPane.get(0).scrollHeight,
		outputHeight = outputPane.hasClass('hidden') ? 0 : outputPane.innerHeight(),
		maxHeight = Math.max(outputHeight, previewHeight, textareaHeight, 188); // min-height: 188px
	
	if (previewPane.innerHeight() < maxHeight) previewPane.innerHeight(maxHeight);
	
	textarea.innerHeight(maxHeight + 10 + 2); // padding (cannot set to textarea) + border
	outputPane.innerHeight(maxHeight);
	syntaxPane.innerHeight(maxHeight);
}



/**
 * Elgg-markdown_wiki_ edit initialization
 *
 * @return void
 */
elgg.provide('elgg.markdown_wiki.edit');

elgg.markdown_wiki.edit.init = function() {

	$(document).ready(function() {
		$.each($('textarea.input-markdown'), function() {
			if ($(this).hasClass('triggered')) return true;
			var textarea = $(this).addClass('triggered'),
				wrapper = textarea.parents('.description-wrapper'),
				menu = wrapper.find('.markdown-menu'),
				previewPane = wrapper.find('.preview-markdown'),
				outputPane = wrapper.find('.output-markdown'),
				syntaxPane = wrapper.find('.help-markdown'),
				converter = new Showdown.converter({ extensions: ['showdownggouv'] }).makeHtml;
			
			if (textarea.hasClass('editor')) textarea.wysiwym();
			
			// livepreview: convert markdown at each keyup !
			textarea.keyup(function() {
				wrapper.find('.markdown-editor').stop(true, true);
				menu.stop(true, true);
				var textVal = textarea.val().replace(/<iframe/g, '<table class="iframe"').replace(/<\/iframe/g, '</table'),
					text_md = converter(convertCodeBlocks(normalizeLineBreaks(textVal)));
				
				previewPane.html(text_md);
				if (outputPane.length && !outputPane.hasClass('hidden')) { // perform html output only if output-markdown exist and not hidden. Performance.
					outputPane.html( convertCodeBlocks(normalizeLineBreaks('```html\r\n' + text_md + '\r\n```')) );
				}
				elgg.markdown_wiki.resizePanes(textarea, previewPane, outputPane, syntaxPane);
			})
			.trigger('keyup')
			.click(function(e) { // Buttons
				var liveeditor = $(this).parents('.description-wrapper').find('.markdown-editor'),
					pos = e.pageY - textarea.offset().top,
					opa = 1;
					oldpos = parseInt(liveeditor.css('top'));
				
				if (!wrapper.hasClass('toggle')) menu.stop(true, true).fadeIn(500);
				$('.markdown-editor').not(liveeditor).addClass('hidden').removeClass('fly').css({top: 0, opacity: 0});
				$('.markdown-menu').not(menu).stop(true).fadeOut(500);
				if (pos < 190) {
					pos = 31;
				} else {
					opa = 0.3;
				}
				if (Math.abs(oldpos - pos+50) > 10) {
					liveeditor.stop(true).removeClass('hidden').css({display: 'block'}).animate({top: pos -50, opacity: opa}, '', function() {
						if (pos > 190) {
							liveeditor.addClass('fly');
						} else {
							liveeditor.removeClass('fly');
						}
					});
				}
			})
			.focusout(function() {
				menu.delay(1000).fadeOut(500);
				wrapper.find('.markdown-editor').delay(1000).fadeOut(500, function(){$(this).css({top: 0, opacity: 0}).removeClass('fly').addClass('hidden')});
			});
			
			// menus
			menu.find('li').click(function() {
				$(this).parent().find('li').removeClass('elgg-state-selected');
				var pane = $(this).addClass('elgg-state-selected').last().attr('class').split(' ')[0].split('-').pop(-1), // get pane name
					paneS = wrapper.find('.'+pane+'-markdown');

				wrapper.find('.pane').removeClass('hidden').not(paneS).addClass('hidden');
				textarea.click().keyup();
			});
			wrapper.find('.toggle-preview').click(function() {
				if ($(this).html() == 'e') {
					$(this).html('y');
					wrapper.find('.pane-markdown').addClass('hidden');
					wrapper.find('.description').removeClass('hidden');
					menu.hide();
				} else {
					$(this).html('e');
					wrapper.find('.description').addClass('hidden');
					wrapper.find('.pane-markdown').removeClass('hidden');
					menu.stop(true, true).fadeIn(500);
				}
			});
			if (textarea.val() != '') {
				wrapper.find('.toggle-preview').click();
			}
		});
		
		function normalizeLineBreaks(str, lineEnd) {
			var lineEnd = lineEnd || '\n';
			return str
				.replace(/\r\n/g, lineEnd) // DOS
				.replace(/\r/g, lineEnd) // Mac
				.replace(/\n/g, lineEnd); // Unix
		}
		
		function wrapCode(match, lang, code) {
			var hl;
			if (lang) {
				try {
					hl = hljs.highlight(lang, code).value;
				} catch(err) {}
			}
			hl = hl || hljs.highlightAuto(code).value;
			return '<pre><code class="' + lang + '">' + $.trim(hl) + '</code></pre>';
		}
		
		function convertCodeBlocks(mdown){
			var re = /^```\s*(\w+)\s*$([\s\S]*?)^```$/gm;
			return mdown.replace(re, wrapCode);
		}
	});

}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.edit.init);


/**
 * Elgg-markdown_wiki discussion initialization
 *
 * @return void
 */
elgg.provide('elgg.markdown_wiki.discussion');

elgg.markdown_wiki.discussion.init = function() {

	$('.elgg-button-toggle-modification').click(function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('.history-module ').parents('.elgg-item').hide();
		} else {
			$(this).addClass('active');
			$('.history-module ').parents('.elgg-item').show();
		}
	});
	
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.discussion.init);



// hook for galliComments plugin
elgg.markdown_wiki.discussion.submit = function() {
	if ($('.elgg-main .comments_order').attr('value') == 'desc') return 'desc';
}
elgg.register_hook_handler('getOptions', 'galliComments.submit', elgg.markdown_wiki.discussion.submit);



/**
 * Elgg-markdown_wiki compare initialization
 *
 * @return void
 */
elgg.provide('elgg.markdown_wiki.compare');

elgg.markdown_wiki.compare.init = function() {
	
	var updateDiffRadios = function() {
		if($(this).css('visibility') == 'hidden') return false;
		var i = $('.elgg-form-markdown-wiki-compare .history-module > li').index($(this).parents('li.elgg-item'))+1;
		var e = $('.elgg-form-markdown-wiki-compare .history-module > li:nth-child('+i+')');
		if ($(this).attr('name') == 'from') {
			e.prevAll().find('.elgg-input-radio[name=to]').css('visibility', 'visible')
			e.prev().nextAll().find('.elgg-input-radio[name=to]').css('visibility', 'hidden');
		} else {
			e.next().prevAll().find('.elgg-input-radio[name=from]').css('visibility', 'hidden');
			e.nextAll().find('.elgg-input-radio[name=from]').css('visibility', 'visible');
		}
	};
	
	$('.elgg-form-markdown-wiki-compare .history-module > li .elgg-input-radio').click(updateDiffRadios);
	$('.elgg-form-markdown-wiki-compare .history-module > li:nth-child(2) .elgg-input-radio[name=from]').click();
	$('.elgg-form-markdown-wiki-compare .history-module > li:first .elgg-input-radio[name=to]').click();
	
}
elgg.register_hook_handler('init', 'system', elgg.markdown_wiki.compare.init);



/**
 * Elgg-markdown_wiki re-initialization for ajax call
 *
 * @return void
 */
elgg.markdown_wiki.reload = function() {
	elgg.markdown_wiki.view.init();
	elgg.markdown_wiki.edit.init();
	elgg.markdown_wiki.history.init();
	elgg.markdown_wiki.discussion.init();
	elgg.markdown_wiki.compare.init();
}



// End of js for elgg-markdown_wiki plugin

