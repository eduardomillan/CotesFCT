<?php $this->load->view('header'); ?>
<?php $this->load->view('styles/common.css.php');?>
<?php $this->load->view('styles/sheet.css.php');?>
</head>
<body>
<div id="container">
   <?php $this->load->view('top');?>

   <h1>Resultado</h1>
   
   <div id="success">
   	Los datos han sido guardados correctamente. <?php echo anchor('empresas', 'Continuar'); ?>.
   </div>
   
   <div id="error">
   	No se han podido guardar los datos correctamente, espere unos minutos y vuelva a intentarlo. Si de esa forma
   	no es posible la operación, por favor, consulte con su administrador. <?php echo anchor('empresas', 'Continuar'); ?>.
   </div>
   
   <div id="messages">
   	<?php echo anchor('form', 'Try it again!'); ?>
   </div>
   
</div>
<?php $this->load->view('footer'); ?>
 