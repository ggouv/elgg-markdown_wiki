/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki plugin CSS file
 **/
 
 /*
  * view and search
  */
.elgg-icon.external {
	background-position: 0 -252px;
	background-size: 8px auto;
	height: 8px;
	margin: 0 2px;
	width: 8px;
}
.markdown-wiki-create {
	font-size: 1.2em;
	color: #333;
}
.markdown-wiki-search-form {
	width: 35%;
}

 /*
  * history
  */
.elgg-button-ins, .elgg-button-del {
	background-color: #EEE;
	border-radius: 5px 5px 5px 5px;
	cursor: pointer;
	padding: 3px 6px;
	color: #555555;
}
.elgg-button-ins:hover {
	text-decoration: none;
	color: green;
}
.elgg-button-ins.active {
	background-color: #dfd;
}
.elgg-button-del:hover {
	text-decoration: none;
	color: red;
} .elgg-button-del.active {
	background-color: #fdd;
}
.diff-output {
	overflow-y: auto;
}
.diff-output ins, ins.elgg-subtext {
	color: green;
	background-color: #dfd;
	text-decoration: none;
}
.diff-output del, del.elgg-subtext {
	color: red;
	background-color: #fdd;
	text-decoration: none;
	white-space: nowrap;
}

.elgg-menu-history-granularity > li {
	float: left;
}

#slider{
	background-color: #AAAAAA;
	border-radius: 6px 6px 6px 6px;
	box-shadow: 1px 2px 2px 0 #666 inset;
		-webkit-box-shadow: inset 1px 2px 2px 0px #666;
	float: left;
	height: 400px;
	width: 6px;
}
#sliderContainer{
	float: left;
	margin: 16px 0 40px 10px;
}
#sliderContainer .ui-slider {
	position: relative;
}
#sliderContainer .ui-slider .ui-slider-handle {
	position: absolute;
	width: 12px;
	height: 12px;
	cursor: pointer;
	background-color: white;
	border-radius: 7px; 
		-webkit-border-radius: 7px;
	box-shadow: 0px 0px 2px 1px rgba(100, 100, 100, 0.8); 
		-webkit-box-shadow: 0px 0px 2px 1px rgba(100, 100, 100, 0.8);
}
#sliderContainer .ui-slider-vertical .ui-slider-handle {
	left: -3px;
	margin-bottom: -6px;
}
#sliderContainer .ui-state-hover, .ui-state-active, .ui-state-focus {
	box-shadow: 0px 0px 2px 1px #4690D6 !important;
		-webkit-box-shadow: 0px 0px 2px 1px !important;
}
.history-module .elgg-body {
	position: relative;
	overflow: hidden;
}
#ownerContainer {
	position: absolute;
	margin-left: 32px;
	width: 100%;
}
#ownerContainer .owner {
	background-color: #ccc;
	position: relative;
}
#ownerContainer .owner:before {
	content: " x x x ";
	color: transparent;
	border-color:transparent #ccc;
	left:-10px;
	border-style: solid;
	border-width: 10px 10px 10px 0;
	height: 0;
	position: absolute;
	top: 6px;
	width: 0;
}
#ownerContainer .owner.hidden {
	opacity: 0.5;
	display: block;
	background-color: transparent;
}
#ownerContainer .owner.hidden:before {
	content: none;
}
#ownerContainer .owner.hidden:hover {
	background-color: #DEDEDE;
	opacity: 0.8;
	cursor: pointer;
}

/*
 * Editor
 */
.description-wrapper {
	width: 100%;
	margin: 1px 0 15px 0;
}
fieldset .description {
	float: left;
	width: 50%;
	clear: none;
	position: relative;
}
@-moz-document url-prefix() { /* hack Firefox */
	fieldset .description {
		margin-top: -1px !important;
	}
}
.input-markdown {
	overflow: hidden;
	resize: none;
}

.elgg-menu-markdown {
	border: medium none;
	float: right;
	font-size: 90%;
	margin: -20px 10px 0 0;
	width: auto;
	display: none;
}
.elgg-menu-markdown > li {
	float: left;
	border: 1px solid #ccc;
	border-bottom: 0;
	background: #eee;
	margin: 0 0 0 10px;
	-webkit-border-radius: 5px 5px 0 0;
	-moz-border-radius: 5px 5px 0 0;
	border-radius: 5px 5px 0 0;
}
.elgg-menu-markdown > li:hover {
	background: #dedede;
}
.elgg-menu-markdown > .elgg-state-selected {
	border-color: #ccc;
	background: white;
	z-index: 1;
}
.elgg-menu-markdown > li > a {
	color: #999999;
	display: block;
	height: 19px;
	padding: 0 8px;
	text-align: center;
	text-decoration: none;
	transition: all 0.25s ease 0s;
}
.elgg-menu-markdown > li > a:hover {
	background: inherit;
	color: #4690D6;
}
.elgg-menu-markdown > .elgg-state-selected > a {
	background: inherit;
	top: 1px;
	border-radius: 2px 2px 0 0;
}
.elgg-menu-markdown > .elgg-menu-item-output.elgg-state-selected {
	background-color: #F8F8FF;
}
.elgg-menu-markdown > .elgg-menu-item-help.elgg-state-selected {
	background-color: #FFFFCC;
}
.pane-markdown {
	float: left;
	width: 50%;
}
.pane-markdown .elgg-input-dropdown {
	margin-left: 10px;
}
.pane-markdown .pane {
	border: 1px solid #CCCCCC;
	margin-top: 0px;
	resize: none;
}
.preview-markdown {
	overflow: auto;
}
.output-markdown {
	min-height: 188px;
	overflow: auto;
	background-color: #F8F8FF;
}
.output-markdown.hidden {
	display: none;
}
.output-markdown > pre {
	margin: 0;
	padding: 0;
}
.output-markdown > pre > code .tag {
	padding: 0;
	color: grey;
}
.output-markdown > pre > code .title {
	color: grey;
}
.output-markdown > pre > code .value {
	color: SlateGrey;
}
.help-markdown {
	color: black;
	background-color: #FFC;
	font-size: 100%;
	background-color: #FFFFCC;
	border: medium none;
	overflow: auto;
}
.help-markdown h3 span {
	color: #999999;
	font-size: 0.8em;
	line-height: 2em;
	padding-left: 3px;
}
.help-markdown a.elgg-widget-collapse-button {
	color: #555;
}
.help-markdown pre {
	background-color: #FFF38B;
	line-height: 1.4em;
}
.help-markdown .spaces {
	background-color: white;
	border-right: 2px solid #FFF38B;
}
.help-markdown .bl {
	background-color: white;
	color: gray;
	float: left;
	padding: 0 10px;
}
.help-markdown .hi {
	background-color: #CCCCCC;
	border-right: 2px solid #FFF38B;
}
.elgg-form-markdown-wiki-edit .summary {
	clear: both;
}
.markdown-body a.new, .preview-markdown a.new {
	color: red;
}



/*
 * Discussion
 */
.elgg-button-toggle-modification {
	background-color: #EEE;
	border-radius: 5px 5px 5px 5px;
	cursor: pointer;
	padding: 3px 6px;
	color: #4690D6;
}
.elgg-button-toggle-modification.active {
	background-color: #4690D6;
	color: white;
}
.elgg-button-toggle-modification:hover {
	text-decoration: none;
	color: white;
	background-color: #0054A7;
}

/*
 * Compare
 */
.compare-module .elgg-head {
	border: none;
}
.compare-module .elgg-head h3 {
	color: #555;
}