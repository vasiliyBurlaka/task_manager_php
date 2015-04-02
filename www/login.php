<html>
<head>
	<title>Simple TODO list</title>
	<script src="lib/js/jquery-1.11.2.js"></script>
	<script src="lib/js/jquery-ui.js"></script>
	<script src="lib/bs/js/bootstrap.min.js"></script>
	<script src="lib/js/tasks.js"></script>

	<link rel="stylesheet" href="lib/css/jquery-ui.css">

	<link rel="stylesheet" href="lib/css/tasks.css">
	<link rel="stylesheet" href="lib/bs/css/bootstrap.css">
</head>

<body>
	<div class="container">
		<form class="form-signin" onsubmit="mu_submit(); return false;">
			<h2>Please, sign in...</h2>
			<h6>*auto registration for new user</h6>
			<input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
			<input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			<span class="alert-danger " id="message"></span>
		</form>
	</div>
</body>

