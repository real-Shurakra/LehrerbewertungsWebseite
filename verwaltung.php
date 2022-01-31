<?php
	session_start();
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
    <script type="module" src="./js/verwaltung.js"></script>
	<!-- <script type="module" src="./js/pageCreateQuestions.js"></script> -->

	<body>
		<!-- main container -->
		<div id="main_container">
		
			<div id="container_pictorius_logo_header"></div>
			
			<div id="container_pictorius_foto">
				<img src="./fotos/Pictorius-Berufskolleg_in_Coesfeld.jpg" alt="Italian Trulli">
			</div>
			
			<!-- horizontales Menü --->
			<div id="container_horizontal_menu">
				<div class="button" id="horizontal_menu_button_teachers" onClick="window.open('./index.php', '_self');">
					<table>
						<tr>
							<td>
								<div>&#9650; Logout</div>
							</td>
							<td>

							</td>
						</tr>
					</table>
				</div>
			</div>
			
			<!--- vertikales Menü --->
			<div id="container_vertical_menu">

			</div>
			
			<!--- page container --->
			<div id="container_pages">
			</div>

			<div id="subMaskNotification_layer">
			</div>
		</div>
		<footer>
			<div id="git_address">
				<?php
				include './php/informationCenter.php';
				$informationCenter= new informationCenter();
				$response = $informationCenter->getGitShortCut();
				if($response["rc"])
				{
					echo $response["rv"];
				}
				?>
			</div>
		</footer>
	</body>
</html>
