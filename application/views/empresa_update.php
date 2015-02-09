<?php $this->load->view('header'); ?>
<?php $this->load->view('styles/common.css.php');?>
<?php $this->load->view('styles/sheet.css.php');?>
</head>
<body>
<div id="container">
   <?php $this->load->view('top');?>

   <h1>Resultado</h1>
   
   <?php if ($updateResult == "success") { ?>
   <div id="success">
   	Los datos han sido guardados correctamente. <?php echo anchor('empresas', 'Continuar'); ?>.
   </div>
   <?php } ?>
   
   <?php if ($updateResult == "error") { ?>
   <div id="error">
   	No se han podido guardar los datos correctamente, espere unos minutos y vuelva a intentarlo. Si de esa forma
   	no es posible la operación, por favor, consulte con su administrador. <?php echo anchor('empresas', 'Continuar'); ?>.
   </div>
   <?php } ?>
   
   <div id="messages">
   	
   </div>
   
</div>
<script type="text/javascript" language="javascript">
	function continuar() {
		document.location.href = "<?php echo site_url('empresas') ?>";
	}
	setTimeout(continuar, 2000);
</script>
<?php $this->load->view('footer'); ?>
 