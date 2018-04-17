<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Hello World</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.0/lux/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<!-- PHP Script Constants -->
	<?php
		$url = "http://0.0.0.0:4444/search/asdfasdfa/asdfasd";
	?>
</head>

<body>
	<div class="container">
		<h1 class="display-4 text-center" style="padding-top: 40px">F*ck Spam</h1>
		<p class="text-secondary text-center">
			Hello World! Let's find out who tweeted spams recently.
		</p>
		<form action="<?php echo $url; ?>" method = "POST" id="main-form">
			<div class="form-group">
    			<label for="usernameInput">Twitter username</label>
    			<input type="email" class="form-control" id="usernameInput" placeholder="example: @realDonaldTrump">
  			</div>

			<div class="form-group">
			    <label for="keywordsTextArea">Spam keywords</label>
			    <textarea class="form-control" id="keywordsTextArea" rows="3" placeholder="example: fuck, shit, trump"></textarea>
			</div>

			<div class="form-group">
			    <label for="algorithmSelect">Algorithm</label>
			    <select class="form-control" id="algorithmSelect">
					<option value="0">Boyer-Moore</option>
					<option value="1">KMP</option>
			    </select>
			</div>

			<div class="form-group form-check">
    			<input type="checkbox" class="form-check-input" id="caseSensitiveCheck">
    			<label class="form-check-label" for="caseSensitiveCheck">Case sensitive</label>
  			</div>
  			<br>

			<button type="submit" class="btn btn-primary btn-block">Go!</button>
      	</form>
	</div>
</body>

</html>