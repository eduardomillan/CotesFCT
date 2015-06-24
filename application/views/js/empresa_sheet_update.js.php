<script type="text/javascript">
	
	var form1 = document.forms[0];
	document.getElementById("modo").textContent = "edición";
	
	<?php
	//Nivel del usuario
	$nivel = (int) $this->session->userdata("nivel");
	
	if ($nivel <> 1) { 
	?>	
	//Disable key fields, to other than administrators
	document.getElementById("cif").readOnly = true;
	document.getElementById("cif").className = "disabled";
	<?php } ?>	
	
	//Set focus
	form1['empresa'].focus();
	
</script>