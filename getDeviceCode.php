<?php

	require_once('config.php');

	// Initializing curl
	$ch = curl_init( $apiCodeEndpoint."?client_id=".$client_id."&scope=".$scope );
	
	$fields = array( );
	$fields_string = json_encode($fields);
	
	// Configuring curl options
	$options = array(	
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => $fields_string,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array(
			'Accept: application/json; charset=utf-8',
			'Content-type: application/json; charset=utf-8',
			'Content-Length: ' . strlen($fields_string))
	);

	// Setting curl options
	curl_setopt_array( $ch, $options );	
	$ret = curl_exec($ch);
	
	curl_close($ch);	
	$data = json_decode($ret,true);
	
	echo json_encode($data);