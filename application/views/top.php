<body>
<div id="container">

<div id="logo">
	<img alt="FCT Cotes Baixes" src="<?php echo base_url('images/practiques8.jpg')?>" />
</div>

<div id="closeSession">
	Usuario: <span id="user"><?php echo $this->session->userdata('user'); ?></span>
	<a href="<?php echo site_url('login/logout')?>" title="Salir">
		<i class="fa fa-sign-out fa-2x" style="z-index: 1"></i>
	</a>
</div>

