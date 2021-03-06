<!doctype html>
<?php
	error_reporting(0);
?>
<html lang="de">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="description" content="Website zur Erfassung, Kategorisierung und Transkription von Toiletten-Schmierereien und -Graffitis."/>
		<link rel="image_src" href="img/global/favicon.jpg"/>
		<link rel="stylesheet" type="text/css" href="css/plugins/build/production.plugins.min.css"/>
		<link rel="stylesheet" href="css/plugins/jcrop/jquery.Jcrop.min.css" type="text/css" />
		<link rel="stylesheet" type="text/css" href="css/global.css"/>
		<link rel="stylesheet" type="text/css" href="css/overlay.css"/>
		<link rel="stylesheet" type="text/css" href="css/pages/upload.css"/>
		<link rel="icon" type="image/x-icon" href="img/global/favicon.jpg"/>
		<script type="text/javascript" src="js/plugins/modernizr.js"></script>
		<title>Latrinalia - Bild Upload</title>
	</head>
	<body>
		<div id="index">
			<header id="mainheader">
				<div class="fixed mainnav-container">
					<nav id="mainnav" class="top-bar" data-topbar>
						<ul class="title-area">
							<li class="name">
							</li>
							<li class="toggle-topbar menu-icon"><a href="">Men&uuml;</a></li>
						</ul>
						<section class="top-bar-section">
							<ul class="left">
								<li class="li-home-container">
									<a id="link-home" href="index.php">
										<span></span><i class="icon-home"></i>
									</a>
								</li>
								<li class="li-upload-container">
									<a id="link-upload" href="javascript:void">
										<span></span><i class="icon-upload-cloud"></i>
									</a>
								</li>
							</ul>
							<ul class="right">
								<li class="li-search-container">
									<a id="link-search" href="javascript:void()" onClick="">
										<span>Suche</span><i class="icon-search"></i>
									</a>
								</li>
								<li class="li-login-container">
									<a id="link-login" href="javascript:void()" onClick="">
										<span>Login</span><i class="icon-user"></i>
									</a>
								</li>
							</ul>
						</section>
					</nav>
				</div>
			</header>
			<section id="maincontent">
				<div class="row">
					<div class="small-12 columns full-width">
						<label class="small-12 howto-label">
							<a href="howto.php" target="_blank"><i class="icon-info"></i>Wie mache ich das hier richtig?</a>
						</label>
						<div class="upload-forms-container">
							<form data-abide="ajax">
								<div class="add-image-container">
									<div>
										<div class="add-image-bg">

										</div>
										<div class="add-image-text">
											Bild</br>
											wählen
										</div>
									</div>
								</div>
								<input type="file" accept="image/*" class="file-input" 
										style="display:none">
								</input>
								<div class="small-12 columns image-error-container">
									<small class="error image-error">Bitte wähle noch ein Bild aus</small>
								</div>
								
								<div class="small-12 columns image-container">
									
								</div>
								<div class="small-12 columns add-title-container">
									<label>Titel<small>erforderlich</small></label>
							        	<input id="title" type="text" required>
							        	</input>
							    	
								</div>
								<div class="small-12 columns add-transcription-container">
									<label>Transkription<small>optional</small>
							        	<input id="transcription" type="text" placeholder="Schreibe die Wörter nieder, die du im Bild erkennst.">
							        	</input>
							    	</label>
								</div>
								<div class="small-12 columns add-type-container">
									<label for="type">Type<small>erforderlich</small>
								        <select id="type" class="medium" required>
								        	<option value>Bitte den Type des Bildes wählen...</option>
								        </select>
							      	</label>
								</div>
							    <div class="small-12 columns add-sex-container">
							    	<label>Geschlecht<small>erforderlich</small></label>
							    	<div class="small-5 medium-3 large-2 columns add-sex-container">
		      							<input type="radio" name="sex" value="M" id="men" required>
		      							<label for="men">Männertoilette</label>
		      						</div>
		      						<div class="small-7 medium-3 large-2 columns add-sex-container">
								    	<input type="radio" name="sex" value="W" id="women" required>
								      	<label for="women">Frauentoilette</label>
							      	</div>
							      	<div class="small-12 medium-3 large-2 columns add-sex-container left">
								      	<input type="radio" name="sex" value="U" id="unisex" required>
								      	<label for="unisex">Unisex-Toilette</label>
								    </div>
							    </div>
							    <div class="small-12 columns add-location-container">
									<label for="location">Ort<small>optional</small>
								        <select id="location" class="medium">
								        	<option value>Bitte wähle zuerst ein Bild aus...</option>
								        </select>
							      	</label>
								</div>
							    <div class="small-12 columns add-artist-container" hidden>
									<label>Künstler<small>optional</small>
							        	<input id="artist" type="text">
							        	</input>
							    	</label>
								</div>
								<div class="small-12 columns fieldset-container">
							    	<fieldset>
								    	<legend>Tags<small>optional</small></legend>
								    	<div class="entry-tags-container">
								    		<ul id="entry-tag-list">

								    		</ul>
								    	</div>
								    	<div class="custom-tags-container">
								    		<label>Eigene Tags wählen<small></small>
      											<input id="custom-tag" type="text" placeholder="">
    										</label>
								    	</div>
								  	</fieldset>
								  	<small class="error tag-error">
							    		Bitte wähle noch ein oder mehrer Tags
							    		für das Bild aus
							   		</small>
							    </div>
							    	<div class="small-12 columns fieldset-container" id="rights">
						        		<div class="small-1 columns rights-container center">
							        		<input type="checkbox" id="confirm-rights" required>
							        		</input>
							        	</div>
						        		<div class="small-11 columns rights-container">
							        		<label for="confirm-rights">
							        			Ich habe das ausgewählte Bild selbst aufgenommen 
							        			und der Urheber/ die Urheberin des darauf zu sehenden Motivs 
							        			ist mir nicht bekannt oder hat dem Heraufladen des Bildes zugestimmt. 
							        			Die Rechte an dem aufgenommenen Bild und den damit verknüpften Daten 
							        			werden mit dem Upload an Latrinalia.de abgetreten. 
							        			Latrinalia.de darf das Bild und die zugehörigen Daten 
							        			auswerten und nutzen.
							        		</label>
						        		</div>
						        	</div>
						        	<div class="small-12 columns fieldset-container" id="tou">
						        		<div class="small-1 columns tou-container center">
							        		<input type="checkbox" id="confirm-tou" required>
							        		</input>
							        	</div>
						        		<div class="small-11 columns tou-container">
							        		<label for="confirm-tou">
							        			Ich habe die <a target="_blank" href="tou.php">Nutzungsbedingungen</a>
												für Latrinalia gelesen und
												akzeptiert und erkläre hiermit
												meine Einwilligung in die Erhebung,
												Speicherung und Verarbeitung
												meiner personenbezogenen Daten zum
												Zwecke der Teilnahme an Latrinalia.
							        		</label>
						        		</div>
						        	</div>

							    <div class="small-12 columns">
							    	<button id="upload-submit"
							    		class="button medium right">
							    		Hochladen
							    	</button>
							    </div>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
		<script type="text/javascript">
			id=-1;

			<?php
			if(isset($_GET["id"])){
				echo "id=".mysql_escape_string(htmlspecialchars($_GET["id"])).";";
			}

			?>

		</script>
				<?php
			include("templates.html");
		?>
		<!--
		<script src="js/plugins/jquery.min.js"></script>
  		<script src="js/plugins/md5/jquery.md5.js"></script>
		<script src="js/plugins/underscore.js"></script>
		<script src="js/plugins/foundation/foundation.js"></script>
  		<script src="js/plugins/foundation/foundation.topbar.js"></script>
		<script src="js/plugins/jquery-ui-custom/jquery-ui.min.js"></script>
  		<script src="js/plugins/foundation/foundation.abide.js"></script>
  		<script src="js/plugins/exif/load-image.min.js"></script>
		<script src="js/plugins/exif/load-image-ios.js"></script>
		<script src="js/plugins/exif/load-image-orientation.js"></script>
		<script src="js/plugins/exif/load-image-meta.js"></script>
		<script src="js/plugins/exif/load-image-exif.js"></script>
		<script src="js/plugins/exif/load-image-exif-map.js"></script>
		-->
		<script src="js/plugins/build/production.plugins.min.js"></script>
		<script src="js/plugins/jcrop/jquery.Jcrop.min.js"></script>
		<script src="js/ImgurManager.js"></script>
  		<script src="js/StateManager.js"></script>
		<script src="js/global.js"></script>
		<script src="js/pages/search.js"></script>		
		<script src="js/pages/login.js"></script>
		<script src="js/pages/upload.js"></script>
	</body>
</html>