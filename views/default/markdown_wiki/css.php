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
.elgg-output.markdown-body a.new {
	color: red;
}
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
 /* hack Chrome / Safari */
@media screen and (-webkit-min-device-pixel-ratio:0) {
	.elgg-form-markdown-wiki-edit .description {
		margin-top: 5px;
	}
}
.elgg-form-markdown-wiki-edit .description, .previewPaneWrapper {
	float: left;
	width: 50%;
	clear: none;
}
.elgg-form-markdown-wiki-edit .elgg-input-markdown {
	overflow: hidden;
}
.previewPaneWrapper .elgg-input-dropdown {
	margin-left: 10px;
}
.elgg-input-markdown, .previewPaneWrapper .pane {
	resize: none;
}
.previewPaneWrapper .pane {
	border: 1px solid #CCCCCC;
	margin-top: 0px;
}
#previewPane {
	margin-right: -10px;
	min-height: 188px;
	overflow: auto;
}
#outputPane {
	color: black;
	background-color: #F0F0F0;
	font-size: 110%;
}
#outputPane > pre {
	margin: 0;
	padding: 0;
}
#outputPane > pre > code {
	padding: 0;
}
#outputPane > pre > code .tag {
	padding: 0;
	color: grey;
}
#outputPane > pre > code .title {
	color: grey;
}
#outputPane > pre > code .value {
	color: SlateGrey;
}
#syntaxPane {
	color: black;
	background-color: #FFC;
	font-size: 100%;
	background-color: #FFFFCC;
	border: medium none;
	overflow: auto;
}
#syntaxPane  h3 span {
	color: #999999;
	font-size: 0.8em;
	line-height: 2em;
	padding-left: 3px;
}
#syntaxPane a.elgg-widget-collapse-button {
	color: #555;
}
#syntaxPane pre {
	background-color: #FFF38B;
	line-height: 1.4em;
}
#syntaxPane .spaces {
	background-color: white;
	border-right: 2px solid #FFF38B;
}
#syntaxPane .bl {
	background-color: white;
	color: gray;
	float: left;
	padding: 0 10px;
}
#syntaxPane .hi {
	background-color: #CCCCCC;
	border-right: 2px solid #FFF38B;
}
.elgg-form-markdown-wiki-edit .summary {
	clear: both;
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