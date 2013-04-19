<?php

$apiHost = 'https://graph.likella.com';
$apiCodeEndpoint = $apiHost.'/oauth/device/code';
$apiTokenEndpoint = $apiHost.'/oauth/token';
$client_id = ""; // <=== Replace with your Client ID
$client_secret = ""; // <=== Replace with your Client Secret
$grant_type = urlencode("http://oauth.net/grant_type/device/1.0");
$scope = urlencode('SHOP,SHOPWRITE,SCOREBOARD,SCOREBOARDWRITE');

