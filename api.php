<?php


	require_once 'config/bootstrap.php';
	require_once __DIR__.'\src\Entities\Cliente.php';	
	require_once __DIR__.'\src\Entities\Billetera.php';	

	$GLOBALS['entityManager'];	

	function consultarCliente($id){
		global $entityManager;
		$em = $entityManager;

		if($id > 0){			
			$cliente = $em->find('Cliente', $id);
				$clienteA['id']     	    = $cliente->getId();
				$clienteA['documento']		= $cliente->getDocumento();
				$clienteA['primerNombre']   = $cliente->getPrimerNombre();
				$clienteA['primerApellido'] = $cliente->getPrimerApellido();
				$clienteA['email']    		= $cliente->getEmail();
				$clienteA['celular']  		= $cliente->getCelular();				
				return $clienteA;			
		}else{
			$entity = $em->getRepository('Cliente');
			$clientes = $entity->findAll();
			foreach ($clientes as $cliente) {
				$clienteX[] = [
						'id'       		 => $cliente->getId(),
						'documento'		 => $cliente->getDocumento(),
						'primerNombre'   => $cliente->getPrimerNombre(),
						'primerApellido' => $cliente->getPrimerApellido(),
						'email'    		 => $cliente->getEmail(),
						'celular'  		 => $cliente->getCelular()
				];
			}				
			return $clienteX;
		}

	}

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
	
	function recargarBilletera($data){
		global $entityManager;
		$em = $entityManager;

		//Buscar el documento según el número de celular
		$cliente = $em->getRepository('Cliente')->findOneBy(array("documento"=>$data[0], "celular"=>$data[1]));		
		//Recargar el saldo
		$billetera = $em->getRepository('Billetera')->findOneBy(array("documentoId"=>$cliente->getDocumento()));
			$saldoAnterior = $billetera->getSaldo();
			$billetera->setSaldo($saldoAnterior + $data[2]);
			$em->persist($billetera);
			$em->flush($billetera);

		$respuesta = [];
			$respuesta['respuesta']			= 'Ok';
			$respuesta['documento']			= $cliente->getDocumento();
			$respuesta['celular']  			= $cliente->getCelular();
			$respuesta['saldoAnterior']    	= $saldoAnterior;
			$respuesta['saldo']    			= $billetera->getSaldo();

		return $respuesta;
		
	}	

	function consultarSaldo($data){
		global $entityManager;
		$em = $entityManager;

		$entity = $em->getRepository('Billetera');
		$billetera = $entity->findBy(array("documentoId" => $data[0]));	
			$billeteraX = [];
			$billeteraX['documento'] = $billetera[0]->getDocumentoId();		
			$billeteraX['saldo']     = $billetera[0]->getSaldo();	
			$billeteraX['divisa']	 = "Pesos";
		return $billeteraX;		
	}


?>