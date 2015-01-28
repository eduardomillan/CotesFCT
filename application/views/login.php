<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>FCT Cotes Baixes - Entrada</title>
	<link rel="stylsheet" type="text/css" href="<?php echo base_url();?>styles/codeigniter.css">
</head>

<style type="text/css">
html {
    background: none repeat scroll 0% 0% #F1F1F1;
}
body, form #username, form #password {
    font-family: "Open Sans","Helvetica Neue","Arial",sans;
}
body {
    background: none repeat scroll 0% 0% #F1F1F1;
    min-width: 0px;
    color: #444;
    font-family: "Open Sans",sans-serif;
    font-size: 13px;
    line-height: 1.4em;
}
body, html {
    height: 100%;
    margin: 0px;
    padding: 0px;
}
#login {
    width: 320px;
    padding: 8% 0px 0px;
    margin: auto;
}
.login form {
    margin-top: 20px;
    margin-left: 0px;
    padding: 26px 24px 46px;
    font-weight: 400;
    overflow: hidden;
    background: none repeat scroll 0% 0% #FFF;
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.13);
}
.login h1 {
    text-align: center;
}
.login * {
    margin: 0px;
    padding: 0px;
}
.login form #username, #login form #password {
    background: none repeat scroll 0% 0% #FBFBFB;
}
.login form .input, .login #username, .login #password {
    font-size: 24px;
    width: 100%;
    padding: 3px;
    margin: 2px 6px 16px 0px;
}
input {
	border: 1px solid #DDD;
	border-radius: 0px;
	box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.07) inset;
	background-color: #FFF;
	color: #333;
	outline: 0px none;
	transition: border-color 0.05s ease-in-out 0s;
	box-sizing: border-box;
	font-weight: inherit;
}
.login label {
    color: #777;
    font-size: 14px;
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
input[type="submit"]{
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
	margin: 0px;
	cursor: pointer;
	border-width: 1px;
	border-style: solid;
	border-radius: 3px;
	white-space: nowrap;
	box-sizing: border-box;	
	font-family: inherit;
	font-weight: inherit;	
}

a {
	text-decoration: none;
	color: #999;
	transition-property: border, #F6F4F2, color;
	transition-duration: 0.05s;
	transition-timing-function: ease-in-out;
	outline: 0px none;
}

</style>

<body class="login">
<div id="login">
	<div style="text-align: center;">
	<img alt="FCT Cotes Baixes" src="<?php echo base_url();?>images/practiques15.jpg" />
	</div>
	<div id="body">
		<p>
		<?php
			echo form_open("login/doLogin");
			
			//Usuario
			echo form_label('Usuario', 'username');
			echo br();
			$datos = array(
					'name'        => 'username',
					'id'          => 'username',
					'value'       => $this->input->post('username'),
					'size'        => '25',
			);			
			echo form_input($datos);
			echo br();
			
			//Password
			echo form_label('Clave', 'password');
			echo br();
			$datos = array(
					'name'        => 'password',
					'id'          => 'password',
					'value'       => '',
					'size'        => '25',
			);
			echo form_password($datos);
			echo br();
			
			echo form_submit('submit', 'Entrar');
			
			echo form_close(); 
		?>
			
		
		</p>
	</div>

</div>

</body>
</html>