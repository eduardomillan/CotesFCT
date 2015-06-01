<body>
<div id="container">

<div id="logo">
	<img alt="FCT Cotes Baixes" src="<?php echo base_url('images/practiques8.jpg')?>" />
</div>

<div id="closeSession">
	<a href="<?php echo site_url('login/logout')?>" title="Salir">
		Usuario: 	
		<span id="user"><?php echo $this->session->userdata('user'); ?></span>
		<i class="fa fa-sign-out fa-1x"></i>
	</a>
</div>

