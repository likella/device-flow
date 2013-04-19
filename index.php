<?php session_start(); ?>
<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="utf-8"/>    
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Likella - API test page</title>
	<link href="style.css" rel="stylesheet">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<script src="device-flow.js" type="text/javascript"></script>
	<script type="text/javascript">
		var getDeviceCode = "getDeviceCode.php"
		var verifyDeviceAuth = "verifyDevice.php"
		var verifyUser = "deviceOk.php"	
	</script>
</head>
<body>
	<header>		
		<h1><img src="logo.png" alt="Likella" width="189" height="73" align="middle" /> API - Device Flow</h1>
	</header>
	<div class="pos">
		<div class="deviceflow">
				<?php if ( !isset($access_token) ) {?>
					<div class="start">
						<p>Collega la tua raccolta punti Likella!</p>
						<a id="connect" href="javascript:;" title="Connettiti a Likella" >Connettiti a Likella</a>
					</div>
				<?php } else { ?>
					<div class="connected">
						<p>Il tuo device risulta già connesso a Likella!</p>
						<a id="verify" href="javascript:;" title="Verifica" >Verifica</a>
					</div>
				<?php } ?>		
		</div>				
	</div>
	<h2>Wire Log</h2>
	<div class="stackcall">
			<?php if ( !isset($access_token) ) {?>
				<p>Connettiti a Likella!</p>
			<?php } else { ?>
				<p>Il tuo device risulta già connesso a Likella!</p>
			<?php } ?>			
	</div>
	<div>
		<p>
			Per maggiori informazioni <a href="https://graph.likella.com">https://graph.likella.com</a>
		</p>
		<p>
			info@likella.com
		</p>
	</div>
</body>
</html>
