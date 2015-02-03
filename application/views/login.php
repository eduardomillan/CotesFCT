<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>FCT Cotes Baixes - Entrada</title>
	<?php $this->load->view('styles/login.css.php');?>
</head>
<body class="login">
<div id="login">
	<div style="text-align: center;">
	<img alt="FCT Cotes Baixes" src="<?php echo base_url('images/practiques15.jpg')?>" />
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
