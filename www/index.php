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
		<div class="container-fluid" style="width:700px;">
			<div class="row header-content">
				<div class="text-center header-text">
					<span>SIMPLE TODO LISTS</span>
				</div>
				<div class="text-center">
					<span>FROM RUBY GARAGE</span>
				</div>
			</div>

			<div id="projects" class="draggable"></div>

			<div class="row text-center" style="margin-top: 20px">
				<button class="btn btn-large btn-primary" value="Add TODO List" onclick="addTodoList()"><img src="lib/img/blue_plus.png"><span class="btn-add-text">Add TODO List<span></button>
			</div>
		</div>
	</body>
</html>

<script>
	$(function () {
		init();
	});
</script>