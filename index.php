<?php
	session_start();
	session_unset();
	
	$_SESSION['usermail'] = null;
	$_SESSION['userisroot'] = null;
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<link rel="shortcut icon" href="">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lehrerbeurteilung</title>
	</head>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="./css/styles.css">

	<!--JavaScript -->
    <script type="module" src="./js/index.js"></script>

	<body>
		<!-- main container -->
		<div id="main_container">

			<div id="container_pictorius_logo_header"></div>
			
			<div id="container_pictorius_foto">
				<img src="./fotos/Pictorius-Berufskolleg_in_Coesfeld.jpg" alt="Italian Trulli">
			</div>
			
			<!-- horizontales Menü --->
			<div id="container_horizontal_menu">
				<div id="horizontal_menu_button_teachers">
					<div>&#9660; Lehrerbereich</div>
					<div id ="login_area_teacher">
					</div>
				</div>
				
				<div id="horizontal_menu_button_students">
					<div>&#9660; Schülerbereich</div>
					<div id ="login_area_student">
						<div>
						</div>
					</div>
				</div>
			</div>
			
			<!--- vertikales Menü --->
			<div id="container_vertical_menu">
			</div>
		</div>

		
		<!-- Fragebogen-Container -->
		<div id="students_questionnaire_container" style="opacity:0;"></div>
	</body>
</html>
