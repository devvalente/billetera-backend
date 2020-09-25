<?php


	require_once 'config/bootstrap.php';
	require_once __DIR__.'\src\Entities\Cliente.php';	
	require_once __DIR__.'\src\Entities\Billetera.php';	

	$GLOBALS['entityManager'];	

	

	function registrarCliente($documento, $primerNombre, $primerApellido, $email, $celular){
		global $entityManager;
		$em = $entityManager;

		$cliente = new Cliente();
		$cliente->setDocumento($documento);
		$cliente->setPrimerNombre($primerNombre);
		$cliente->setPrimerApellido($primerApellido);
		$cliente->setEmail($email);
		$cliente->setCelular($celular);

		$em->persist($cliente);
		$em->flush($cliente);

		//echo "Se ha realizado el registro con éxito. ".$cliente->getId();

		registrarBilletera($cliente);

	}

	function registrarBilletera($data){
		global $entityManager;
		$em = $entityManager;

		$billetera = new Billetera();
		$billetera->setDocumentoId($data->getDocumento());
		$billetera->setSaldo(0.00);

		$em->persist($billetera);
		$em->flush($billetera);

		echo "Se ha registrado la billetera y el usuario exitosamente.";
	}
	
	


?>