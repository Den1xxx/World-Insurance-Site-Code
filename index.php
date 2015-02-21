<?php
	// Starts a new session
	ob_start();
	session_start();
	
	// Determine site content root
	$webroot = dirname(__FILE__);
	
	require_once( $webroot . "/config.php");
	require_once( $webroot . "/includes/database.php");

	$dbObject = new Database;
	$db = $dbObject->createDatabaseConnection();
	
	// Fetch the Site Name from the database
	$SQLQuery = "SELECT * FROM `" . DB_NAME . "`.`" . TBL_CONFIG . 
						"` WHERE `configName` = 'siteName';";

	$result = $db->query($SQLQuery);
	
	// Fetch returned row
	$row = $result->fetch_row();

	// Close the returned result
	$result->close();
	
	$siteName = "$row[2]";
	
	// Fetch the slogan from the database
	$SQLQuery = "SELECT * FROM `" . DB_NAME . "`.`" . TBL_CONFIG . 
						"` WHERE `configName` = 'sloganHTML';";

	$result = $db->query($SQLQuery);
	
	// Fetch returned row
	$row = $result->fetch_row();

	// Close the returned result
	$result->close();
	
	$slogan = "$row[2]";
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?php echo $siteName ?></title>

		<!-- Bootstrap CSS 3.3.2 -->
		<link href="css/bootstrap.min.css" rel="stylesheet" />

		<!-- Bootstrap Theme CSS 3.3.2 -->
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" />

		<!-- Sticky Footer CSS -->
		<link rel="stylesheet" href="css/sticky-footer.css" />

		<!-- Jumbotron CSS -->
		<link rel="stylesheet" href="css/jumbotron.css" />

		<!-- Form CSS -->
		<link rel="stylesheet" href="css/form.css" />

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!-- HTML5 Shiv 3.7.2 -->
		<!-- Respond 1.4.2 -->
		<!--[if lt IE 9]>
			<script src="js/html5shiv.min.js"></script>
			<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<?php
				require_once($webroot . "/includes/header.php");
		?>

		<!-- Main jumbotron for a primary marketing message or call to action -->
		<div class="jumbotron">
			<div class="container">
				<h1><?php echo $siteName ?></h1>
				<p>
					<?php
					
						echo $slogan;
					
						if( $_SESSION['isAdmin'] == TRUE ) {
							
							echo 
								" <button type=\"button\" class=\"btn btn-xs " .
								"btn-info\" data-toggle=\"modal\" " .
								"data-target=\"#editSloganModal\">" .
								"	<span class=\"glyphicon glyphicon-pencil\" " .
										"aria-hidden=\"true\"></span>" .
								"</button>";
					
						}
					?>
				</p>
				<p>
					<a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a>
				</p>
			</div>
		</div>

		<!-- Three columns of info -->
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<h2>Heading</h2>
					<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
					<p>
						<a class="btn btn-default" href="#" role="button">View details &raquo;</a>
					</p>
				</div>
				<div class="col-md-4">
					<h2>Heading</h2>
					<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
					<p>
						<a class="btn btn-default" href="#" role="button">View details &raquo;</a>
					</p>
				</div>
				<div class="col-md-4">
					<h2>Heading</h2>
					<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
					<p>
						<a class="btn btn-default" href="#" role="button">View details &raquo;</a>
					</p>
				</div>
			</div>
			
			<?php
			
				if( $_SESSION['isAdmin'] == TRUE ) {
					echo
						"<!-- Edit Slogan Modal -->\r\n" .
							"<div class=\"modal fade\" id=\"editSloganModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"editSloganModalLabel\"
			                 aria-hidden=\"true\">
			                <div class=\"modal-dialog\">
			                    <div class=\"modal-content\">
			                        <div class=\"modal-header\">
			                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
			                                <span aria-hidden=\"true\">&times;</span>
			                            </button>
			                            <h4 class=\"modal-title\" id=\"editSloganModalLabel\">Edit Slogan</h4>
			                        </div>
			                        <div class=\"modal-body\">
			                            <form class=\"form-signin\" id=\"editFrontPageForm\" onsubmit=\"return false;\">
													<input type=\"text\" id=\"inputFrontPageSlogan\" name=\"inputFrontPageSlogan\" value=\"$slogan\" autocomplete=\"off\" />
												</form>
			                        </div>
			                        <div class=\"modal-footer\">
			                            <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Cancel</button>
			                            <button id=\"loginButton\" type=\"submit\" class=\"btn btn-primary\">Save</button>
			                        </div>
			                    </div>
			                </div>
			            </div>";
				}
			?>

		<footer class="footer">
			<div class="container">
				<p class="text-muted footer-center">&copy; World Insurance 2014 Site Created &amp; Managed by techsym</p>
			</div>
		</footer>

		<!-- jQuery 1.11.2 -->
		<script src="js/jquery.min.js"></script>

		<!-- jQuery JSON 2.5.1 -->
		<script src="js/jquery.json.min.js"></script>

		<!-- Main JS 0.0.1 -->
		<script src="js/main.js"></script>

		<!-- Bootstrap JS 3.3.2 -->
		<script src="js/bootstrap.min.js"></script>

		<!-- Bootstrap Switch JS 3.3.1 -->
		<script src="js/bootstrap-switch.min.js"></script>

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="js/ie10-viewport-bug-workaround.js"></script>
		
		<!-- TinyMCE -->
		<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript" src="js/tinymce/jquery.tinymce.min.js"></script>
		<script type="text/javascript">
			tinymce.init({
				selector: "input",
				setup: function (editor) {
					editor.on("change", function () {
						tinymce.triggerSave();
					});
				}
			});
		</script>
		
		<?php $db->close(); ?>
		
	</body>
</html>