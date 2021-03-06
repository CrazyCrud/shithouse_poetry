<!doctype html>
<?php
	error_reporting(0);
?>
<html lang="de">
	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="css/plugins/build/production.plugins.min.css"/>
		<link rel="stylesheet" type="text/css" href="css/global.css"/>
		<link rel="stylesheet" type="text/css" href="css/overlay.css"/>
		<link rel="stylesheet" type="text/css" href="css/pages/galleryview.css"/>
		<link rel="stylesheet" type="text/css" href="css/pages/home.css"/>
		<link rel="icon" type="image/x-icon" href="img/global/favicon.jpg"/>
		<link rel="image_src" href="img/global/favicon.jpg"/>
		<meta name="description" content="Website zur Erfassung, Kategorisierung und Transkription von Toiletten-Schmierereien und -Graffitis."/>
		<meta name="keywords" content="Latrinalia, Graffiti, Toilette, Klo, Universität, Regensburg, Medieninformatik, Schmiererei, Bad, Bathroom"/>
		<meta name="author" content="Franziska Hertlein, Bastian Hinterleitner, Constantin Lehenmeier, Thomas Spröd"/>
		<meta name="copyright" content="März 2014"/>
		<meta name="robots" content="index, follow"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		<script type="text/javascript" src="js/plugins/modernizr.js"></script>
		<title>Latrinalia - Eine Plattform für Toiletten-Graffiti</title>
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
									<a id="link-home" href="index.php" title="Startseite">
										<span></span><i class="icon-home"></i>
									</a>
								</li>
								<li class="li-upload-container"></li>
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
				<div class="row full-width">
					<div class="small-12 columns">
						<div id="upload">
							<div class="upload-image-container">
									
							</div>
							<div class="upload-button-container">
								<span id="upload-button"><a id="link-upload" href="upload.php" title="Bild hochladen" ><i class="icon-upload-cloud"></i></a></span>
							</div>
						</div>
					</div>
				</div>
			</header>
			<section class="home" id="maincontent">
				<div class="row">
					<div class="small-12 columns full-width">
						<dl class="tabs" data-tab>
							<dd><a id="tab-new" href="javascript:void(0)">New</a></dd>
							<dd><a id="tab-hot" href="javascript:void(0)">Hot</a></dd>
							<dd><a id="tab-vote" href="javascript:void(0)">Vote</a></dd>
							<dd><a id="tab-transcribe" class="show-for-medium-up" 
								href="javascript:void(0)">Transcribe</a></dd>
						</dl>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns full-width">
						<div class="infinite-container">
							<div id="images">

							</div>
							<div class="vote-container small-12 columns">
								<div class="vote-icon-container">
									<i id="up-vote" class="icon-thumbs-up-1"></i>
									<span id="outer-rating">
										<span id="inner-rating"></span>
									</span>
									<span id="rating-count"></span>
									<i id="down-vote" class="icon-thumbs-down-1"></i>
								</div>
							</div>
							<div class="transcribe-container small-12 columns">
								<div class="transcribe-input-container">
									<form>
										<input type="text" id="transcription-input" 
											placeholder="Schreibe die Wörter nieder, die du im Bild erkennst.">
										</input>
										<div id="transcription-tou">
											<input type="checkbox" required id="transcription-tou-checkbox"></input>
											<label>Ich akzeptiere die <a href="tou.php" target="_blank">Nutzungsbedingungen</a>.</label>
										</div>
									</form>
									<button id="transcription-submit" class="tiny">
										Speichern</button>
									<button id="skip-transcription" class="tiny">
										Überspringen</button>
									<label>
										<a href="howto.php#transcription" target="_blank"><i class="icon-info"></i>Wie transkribiere ich richtig?</a>
									</label>
								</div>
							</div>
							<div class="small-12 columns message-container">
								<img id="loading-spinner" src="img/global/loading.gif"/>
								<span class="message"></span>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php
			include("templates.html");
		?>
  		<script src="js/plugins/build/production.plugins.min.js"></script>
  		<script src="js/StateManager.js"></script>
  		<script src="js/ImgurManager.js"></script>
  		<script src="js/GalleryView.js"></script>
		<script src="js/global.js"></script>
		<script src="js/topbar.js"></script>
		<script src="js/pages/home.js"></script>
		<script src="js/pages/search.js"></script>		
		<script src="js/pages/login.js"></script>
	</body>
</html>