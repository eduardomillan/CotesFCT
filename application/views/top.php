<div id="logo">
	<img alt="FCT Cotes Baixes" src="<?php echo base_url('images/practiques8.jpg')?>" />
</div>
<div id="closeSession">
	<a href="<?php echo site_url('login/logout')?>">
		Cerrar sesión: <span id="user"><?php echo $this->session->userdata('user'); ?></span>
	</a>
</div>

