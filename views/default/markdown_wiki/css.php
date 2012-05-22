/**
 *	Elgg-markdown_wiki plugin
 *	@package elgg-markdown_wiki
 *	@author Emmanuel Salomon @ManUtopiK
 *	@license GNU Affero General Public License, version 3 or late
 *	@link https://github.com/ManUtopiK/elgg-markdown_wiki
 *
 *	Elgg-markdown_wiki plugin CSS file
 **/
.diff-output {
	white-space: pre-line;
	overflow-y: auto;
}
.diff-output .numbers{
	padding-right: 8px;
	background-color: #CCCCCC;
}
.diff-output .text{
	padding-left: 2px;
}
.diff-output ins, .history-module ins {
	color: green;
	background-color: #dfd;
	text-decoration: none;
}
.diff-output del, .history-module del {
	color: red;
	background-color: #fdd;
	text-decoration: none;
	white-space: nowrap;
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
.ui-slider {
	position: relative;
}
.ui-slider .ui-slider-handle {
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
.ui-slider-vertical .ui-slider-handle {
	left: -3px;
	margin-bottom: -6px;
}
.ui-state-hover, .ui-state-active, .ui-state-focus {
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
