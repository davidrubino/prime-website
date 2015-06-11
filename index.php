<!DOCTYPE html>
<html>

	<head>
		<link href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/shift.css" rel="stylesheet">
		<link rel="stylesheet" href="http://s3.amazonaws.com/codecademy-content/courses/ltp/css/bootstrap.css">
		<link rel="stylesheet" href="main.css">

		<meta name="keywords" content="Milwaukee, Wisconsin, Agency, Staffing, Recruiting, Placement, Firm, Prime Resources LLC, Temporary, Engineering, IT, CAD, Proe, Design, Service">

		<title>Home</title>

	</head>

	<body>
		<?php
		include 'menu.php';
		?>
		<div class="jumbotron" id="index">
			<div class="container" id="logo">
				<img src="logo.png">
			</div>
			<div class="container" id="whatwedo">
				<h1>What We Do</h1>
			</div>
		</div>

		<div class="main-object">
			<div class="container">
				<div class="description">
					Prime Resources LLC provides top-notch professional and technical talent on a contract, contract-to-hire, and
					direct hire basis. As an industry leader that is a certified woman-owned small business with over 25 years of
					experience, Prime Resources focus on professional and technical disciplines has solidified the in-depth
					knowledge, industry expertise, and robust employee pipeline it takes to rapidly deliver ideal candidates for even
					the most difficult to fill requirements.
				</div>
				<div class="motto" id="ourpeople">
					Our people. Your projects.
				</div>
			</div>
		</div>

		<div class="info">
			<div class="container">
				<?php
				include 'bottom.php';
				?>
			</div>
		</div>
	</body>
</html>