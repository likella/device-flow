<?php
	require_once('config.php');

	// Verifico dati utente
	$accessToken = $_GET['access'];						
		
	// Initializing curl
	$ch = curl_init( $apiHost.'/me' );
	
	$options = array(
		CURLOPT_SSL_VERIFYPEER => false,	
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array(
			'Accept: application/json; charset=utf-8',
			'Content-type: application/json; charset=utf-8',
			'Authorization: Bearer '.$accessToken)
	);
	
	// Setting curl options
	curl_setopt_array( $ch, $options );	
	$ret = curl_exec($ch);
	
	curl_close($ch);	
	$dataUser = json_decode($ret,true);
	
	
	// Verifico dati dei negozi
	
	// Initializing curl
	$ch = curl_init( $apiHost.'/me/shops' );
	
	$options = array(
		CURLOPT_SSL_VERIFYPEER => false,	
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array(
			'Accept: application/json; charset=utf-8',
			'Content-type: application/json; charset=utf-8',
			'Authorization: Bearer '.$accessToken)
	);
	
	// Setting curl options
	curl_setopt_array( $ch, $options );	
	$ret = curl_exec($ch);
	
	curl_close($ch);	
	$dataShops = json_decode($ret,true);
	$dataShops = $dataShops['data'];
	
	// Verifico dati delle raccolte punti

	// Initializing curl
	$ch = curl_init( $apiHost.'/me/scoreboards' );
	
	$options = array(
		CURLOPT_SSL_VERIFYPEER => false,	
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array(
			'Accept: application/json; charset=utf-8',
			'Content-type: application/json; charset=utf-8',
			'Authorization: Bearer '.$accessToken)
	);
	
	// Setting curl options
	curl_setopt_array( $ch, $options );	
	$ret = curl_exec($ch);
	
	curl_close($ch);	
	$dataScoreboards = json_decode($ret,true);
	$dataScoreboards = $dataScoreboards['data'];		
	
	echo json_encode( 
		array( 'resUser' => $dataUser,
			   'resShops' => $dataShops,
			   'resScoreboards' => $dataScoreboards )
	);
