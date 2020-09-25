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

		//RECARGAR BILLETERA
		if($accion == 'recargar_billetera'){
			$data = [];
				$data[0]= $_POST['documento'];				
				$data[1]= $_POST['celular'];
				$data[2]= $_POST['valor'];
			$respuesta = recargarBilletera($data);
			echo json_encode($respuesta, JSON_NUMERIC_CHECK);
		}

		//CONSULTAR SALDO
		if($accion == 'consultar_saldo'){			
			$data = [];
				$data[0] = $_POST['documento'];			
				$data[1] = $_POST['celular'];			
			$saldo 			= consultarSaldo($data);
			echo json_encode($saldo);
		}

		
	}

	if($_SERVER['REQUEST_METHOD']=='GET'){

		//CONSULTAR CLIENTE
		if($_GET['accion'] == 'consultar_cliente'){
			if(isset($_GET['id'])){		
				$id = $_GET['id'];						
				$cliente = consultarCliente($id);			
				echo json_encode($cliente, JSON_UNESCAPED_UNICODE);			
			}else{
				$clientes = consultarCliente(0);
				
				echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
			}
		}
	}

?>