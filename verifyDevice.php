<?php
	
	require_once('config.php');

	$code = $_POST['code'];
		   			
	$curUri = $apiTokenEndpoint."?client_id=".$client_id."&client_secret=".$client_secret."&grant_type=".$grant_type."&code=".$code;
	
	// Initializing curl
	$ch = curl_init( $curUri );

	// Configuring curl options
	$options = array(
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array(
			'Accept: application/json; charset=utf-8',
			'Content-type: application/json; charset=utf-8')
	);

	// Setting curl options
	curl_setopt_array( $ch, $options );	
	$ret = curl_exec($ch);
	
	curl_close($ch);	
	$data = json_decode($ret,true);
	
	if (array_key_exists('access_token', $data))
		$_SESSION['accessToken'] = $data['access_token'];
		
	
	echo json_encode($data);