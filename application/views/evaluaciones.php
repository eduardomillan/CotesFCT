<?php
	//Nivel del usuario
	$nivel = (int) $this->session->userdata("nivel");
?>
<?php $this->load->view('header'); ?>
<?php $this->load->view('styles/common.css.php');?>
</head>
<body>
<div id="container">
	<?php $this->load->view('top');?>
	<h1>Evaluaciones</h1>

   	<div id="buttons">
   		<a id="buttonBack" class="button" href="<?php echo site_url('empresas/info/'.$empresaId); ?>">Volver ></a>
   	</div>

</div>

<?php $this->load->view('footer'); ?>
