<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>FCT Cotes Baixes - Entrada</title>
	<link rel="stylsheet" type="text/css" href="<?php echo base_url();?>styles/codeigniter.css">
</head>
<body>

<div id="container">
	<h1>Bienvenido a FCT Cotes Baixes</h1>

	<div id="body">
		<p>
		<?php
			echo form_open("login/doLogin");
			
			//Usuario
			echo form_label('Usuario', 'username');
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
		<p><a href="<?php echo site_url('login/logout'); ?>">Cerrar sesión</a></p>
	</div>

	<p class="footer">Página generada en <strong>{elapsed_time}</strong> segundos</p>
</div>

</body>
</html>