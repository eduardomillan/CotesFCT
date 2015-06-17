<script type="text/javascript">
	
	var form1 = document.forms[0];
	document.getElementById("modo").textContent = "edición";
	
	//Disable key fields
	document.getElementById("cif").readOnly = true;
	document.getElementById("cif").className = "disabled";
	
	//Set focus
	form1['empresa'].focus();
	
</script>