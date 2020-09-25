<?php
	require_once './api.php';
		

	header('Access-Controll-Allow-Origin: *');
	
	

	if($_SERVER['REQUEST_METHOD']=='POST'){	
		$accion 		= $_POST['accion'];		

		//REGISTRAR CLIENTE - REGISTRAR BILLETERA
		if($accion == 'registrar_cliente'){
			$documento 		= $_POST['documento'];
			$primerNombre 	= $_POST['primerNombre'];
			$primerApellido = $_POST['primerApellido'];
			$email 			= $_POST['email'];
			$celular 		= $_POST['celular'];
			registrarCliente($documento, $primerNombre, $primerApellido, $email, $celular);	
		}

		
	}

	

?>