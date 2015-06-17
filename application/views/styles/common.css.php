<style type="text/css">
#logo {
	background-color: #2EA2CC;
}
#closeSession {
	position: absolute;
	top: 6px;
	right: 15px;
	color: white;
}
#closeSession a {
	color: white;
	
}
#closeSession #user {
	font-weight: bold;
}
#container{
	width: 80%;
	height: auto;
	min-height: 95%;
	margin: 0 auto; /* Centrar */
	background-color: white;
	padding-left: 1px;
	padding-right: 1px;
	position: relative;
	font-size: 14px;
}
#container h1 {
	font-size: 28px;
	position: absolute;
	top: 1px;
	width: 99%;
	color: white;
	text-align: center;
}
#container h2 {
  color: #2EA2CC;
}
#container #success {
	margin-top: 7em;
	margin-left: 7em;
	font-size: 1.2em;
	color: green;
	font-weight: bold;
}
#container #error {
	margin-top: 7em;
	margin-left: 7em;
	font-size: 1.2em;
	color: red;
	font-weight: bold;
}
#container #actions {
	text-align: right;
	float: right;
	top: 0.5em;
	right: 0.5em;
	position: relative;
	margin-right: 0.7em;
	z-index: 1;
}
#actions div {
	display: inline;
}
#dataTable, #dataTable table {
	margin: 0 auto;
}
#dataTable table {
	width: 99%;
	border-collapse: collapse;
	border-color: #7FE3EB;
}
#dataTable table th {
	color: white;
	text-align: center;
	background: #2EA2CC;
	border-color: white;
}
#dataTable table tr:hover {
  background: #97F9FF;
}
#dataTable table td {
	max-width: 200px;
   white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
	border-color: #C2FCFF;
}
#dataTable table a i {
	font-size: 1.5em;
}
#pagination {
	margin-top: 10px;
	font-size: 16px;
	font-weight: bold;
	text-align: center;
}
#pagination a, #pagination strong {
	margin-left: 10px;
	margin-right: 10px;
}
#pagination a {
	color: blue;
}
html {
    background: none repeat scroll 0% 0% #F1F1F1;
}
body, form select, form input[type="text"], form .textLabel {
    font-family: "Open Sans","Helvetica Neue","Arial",sans;
}
body {
    background: none repeat scroll 0% 0% #F1F1F1;
    min-width: 0px;
    color: #444;
    font-family: "Open Sans",sans-serif;
    font-size: 13px;
    line-height: 1.4em;
    margin: 20px;
}
body, html {
    height: 100%;
    margin: 0px;
    padding: 0px;
}
a {
	text-decoration: none;
	color: #2EA2CC;
	transition-property: border, #F6F4F2, color;
	transition-duration: 0.05s;
	transition-timing-function: ease-in-out;
	outline: 0px none;
}
select, input {
	border: 1px solid #DDD;
	border-radius: 0px;
	box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.07) inset;
	background-color: #FFF;
	color: #333;
	outline: 0px none;
	transition: border-color 0.05s ease-in-out 0s;
	box-sizing: border-box;
	font-weight: inherit;
	font-size: 14px;
   padding: 3px;
   margin: 0.1em 0.2em 0.2em 0.1em;
}
select:disabled, input:disabled, textarea:disabled, input.disabled {
	color: black;
	border-color: grey;
	background-color: lightgrey;
}
input[type="submit"], .button {
	height: 30px;
	line-height: 28px;
	padding: 0px 12px 2px;
	vertical-align: baseline;
	background: none repeat scroll 0% 0% #2EA2CC;
	border-color: #0074A2;
	box-shadow: 0px 1px 0px rgba(120, 200, 230, 0.5) inset, 0px 1px 0px rgba(0, 0, 0, 0.15);
	color: #FFF;
	text-decoration: none;
	display: inline-block;
	font-size: 13px;
	cursor: pointer;
	border-width: 1px;
	border-style: solid;
	border-radius: 3px;
	white-space: nowrap;
	box-sizing: border-box;	
	font-family: inherit;
	font-weight: inherit;	
}
#buttonOff {
	border-color: grey;
	background-color: grey;
	text-decoration: line-through;
}
input[type="submit"]:active, .button:active {
	color: grey;
	background: white;
}
input[type="text"]:focus, select:focus, textarea:focus {
  border: 1px solid #2EA2CC;
  background: #C2FCFF;
}
label + a, fieldset label, label {
    vertical-align: middle;
}
label {
    cursor: pointer;
}
p {
    line-height: 1.5;
}
#footer {
	background-color: white;
	width: 80%;
	text-align: right;
	font-size: 10px;
	margin: 0 auto;
}
</style>