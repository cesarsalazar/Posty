<?php

// Process Post page if username was declared.				
if( $_REQUEST['u'] ) {

	//Process Tweet when s (status) and p (password) are set as POST parameters
	
	if( $_REQUEST['s'] && $_REQUEST['p'] ) {
		
		$username = $_REQUEST['u'];
		$password = stripslashes($_REQUEST['p']);
		$status = urlencode(stripslashes(urldecode($_REQUEST['s'])));
		
		$tweetUrl = 'http://www.twitter.com/statuses/update.xml';
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "$tweetUrl");
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, "status=$status");
		curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
		
		$result = curl_exec($curl);
		$resultArray = curl_getinfo($curl);
		
		if ($resultArray['http_code'] == 200)
			$alert = '<p>Tweet enviado :)</p><hr/>';
		else
			$alert = '<p>Tweet no enviado :( <br/>Probablemente tu contrase&ntilde;a es incorrecta. </p><hr/>';

		curl_close($curl);
	}
	
	// Print plain web form, so the user can tweet from it.
	else{
			$alert = "";
			$user = urlencode(stripslashes(urldecode($_REQUEST['u'])));	
			$tweet = urlencode(stripslashes(urldecode($_REQUEST['s'])));	
		} ?> 

	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>Posty</title>
			<style>textarea{font-family:sans-serif;}</style>
		</head>
		<body>
			<?php echo $alert; ?>
			<form method="POST">
				<input type="hidden" name="u" value="<?php echo $user; ?>" />
				<p><label for="s">Tu tweet:</label></p>
				<textarea value="<?php echo $tweet; ?>" name="s" cols="20" rows="5" style="width:100%" maxlength=140></textarea>
				<p><label for="p">Tu contrase&ntilde;a:</label>
				<input type="password" name="p" value="" /></p>
				<input type="submit" value="Post" />
			</form>
		</body>
	</html>

<?php		
}

// Print error when user didn't provide username.
else { ?>

	<html>	
		<head>
			<title>Posty</title>
		</head>
		<body>
			<p>Usuario inv&aacute;lido!</p>
			<p>Escribe http://posty.us/tu_usuario en la barra de direcciones, donde "tu_usuario" representa TU nombre de usuario de Twitter.</p>	
		</body>
	</html>
	
<?php } ?>
