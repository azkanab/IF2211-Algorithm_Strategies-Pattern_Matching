<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SPAM!</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<?php
		// Route requests while ignoring any queries
		$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
		switch ($request_uri[0]) {
			// Home page
			case '/':
				require 'templates/home.php';
				break;
			// About page
			case '/about':
				require 'templates/about.php';
				break;
			// Everything else
			default:
				require 'templates/not_found.php';
				break;
		}
	?>
</body>
</html>