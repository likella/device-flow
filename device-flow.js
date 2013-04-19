$(function(){
	expires_in = 0
	interval = 0
	code = ''
	timerVerify = null
	access_token = ''
	
	$('a#connect').click(function(e){
		e.preventDefault();
				
		$.ajax({
				url: getDeviceCode,
				type: 'POST',
				dataType: 'json',
				success: function(data){				
					$('div.start').remove()
			    	item = $('<div class="doauth"></div>') 
			    	
			    	res = data
			    	
		            item.append($('<p>').text("Vai al link "))
		            item.append($('<a>').attr('href',res['verification_url']).attr('target','_blank').html(res['verification_url']))
		            item.append($('<p>').text("sul tuo pc e inserisci il codice "))
		            item.append($('<p>').attr('class','code').html(res['user_code']))
			    	
			    	$('div.deviceflow').append(item)
			    	
			    	expires_in = res['expires_in']
					interval = res['interval']
					code = res['device_code']
					
					
					timerVerify = setTimeout(verifyAuthDevice, parseInt(interval)*1000)
					logStack('Ricevuto codice device: '+res['device_code']+'... Authentication pending!')
				},
				error: function(data, ret){
					logStack('Richiesta codice di autenticazione device fallita. Riprova!')
				} 	
			})					
	})
	
	$('a#verify').click(deviceOk)
})

function verifyAuthDevice(){
	 
	expires_in = expires_in - interval
	
	if (expires_in > 0) {
		
		$.ajax({
			url: verifyDeviceAuth,
			type: 'POST',
			dataType: 'json',
			data: {'code':code},
			success: function(data){
				if (data['error']){
					var err = data['error']
					logStack('Device non verificato... Message: '+err['message'])
					setTimeout(verifyAuthDevice, parseInt(interval)*1000)
				}
				else {
					var r = data
					clearInterval(timerVerify)
					
					$('div.doauth').remove()
			    	item = $('<div class="connected"></div>') 
			    	
			    	res = data.res
			    	
		            item.append($('<p>').text("Il tuo device è connesso a Likella!"))
			    	
			    	$('div.deviceflow').append(item)
			    							
					logStack('Device verificato!')
					logStack('Dati ricevuti:')
					logStack('>> Access token: '+r['access_token'])
					logStack('>> Scope: '+r['scope'])
					
					access_token = r['access_token']
					
					deviceOk()
				}
			},
			error: function(obj){
				var err = data['error']
				logStack('Device non verificato... Message: '+err['message'])
				setTimeout(verifyAuthDevice, parseInt(interval)*1000)
			}
		})
	}
	else{		
		logStack('Il codice non è più valido!')
	}	
}

function deviceOk(){
	
	if (access_token) {
		$.getJSON(
			verifyUser,
			{'access' : access_token},
			function (data, textStatus) { //success
				if (textStatus == 'success'){
					if (data.resUser['error']){
						var err = data.resUser
						logStack('Errore server... Message: '+err['error_description'])			
					}
					else {
						var ru = data.resUser

						if (ru['guessedFirstName'] && ru['guessedLastName']) {
							if ($('div.connected #verify')){
								$('div.connected p').remove()
								$('div.connected #verify').remove()
							}
							$('div.connected').append($('<p>').text("Il tuo device è connesso a Likella!"))
					    	$('div.connected').append($('<p>').text("Benvenuto ").append($('<span>').text(ru['guessedFirstName']+" "+ru['guessedLastName']).attr('class','name')))
					    	
							logStack("Benvenuto "+ru['guessedFirstName']+" "+ru['guessedLastName']+"!")
							
							
						}
						// negozi
						var rshops = data.resShops						
						if (rshops.length){
							logStack("Lista negozi")
							$('div.connected').append($('<p>').text("Lista negozi:"))
							$.each(rshops, function(index,item){
								$('div.connected').append($('<p>').append($('<span>').text(item.shop['name']).attr('class','name')))
							})
						}
						
						// scoreboards
						var rscoreboards = data.resScoreboards					
						if (rscoreboards.length){
							logStack("Lista raccolte")
							$('div.connected').append($('<p>').text("Lista raccolte:"))
							$.each(rscoreboards, function(index,item){
								$('div.connected').append($('<p>').append($('<span>').text(item.scoreboard['name']).attr('class','name')))
							})
						}
					}
				}				
			})
	}
	else{		
		logStack('Device non connesso. Riprova!')
	}	
}

function logStack(mess){	
	var time = new Date()
	h = ('0'+time.getHours()).slice(-2)
	m = ('0'+time.getMinutes()).slice(-2)
	s = ('0'+time.getSeconds()).slice(-2)
	$('div.stackcall').append($('<p>').text(h+':'+m+':'+s+' - '+mess))	
}