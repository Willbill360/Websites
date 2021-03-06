<!DOCTYPE HTML>
<!--
	Spectral by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<?php
session_start();

include_once('config.php');

if($isLocal == true) {
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');
} else {
	$bdd = new PDO('mysql:host=mysql.hostinger.fr;dbname=u924407628_mbre', 'u924407628_geps', '0Otfk4rNnz');
}

include_once('cookieconnect.php');

$rapport = $bdd->query('SELECT pseudo_sender, id, type FROM rapport ORDER BY id DESC');
if(isset($_GET['q']) AND !empty($_GET['q'])) {
   $q = htmlspecialchars($_GET['q']);
   $rapport = $bdd->query('SELECT pseudo_sender, id, type FROM rapport WHERE pseudo_sender LIKE "%'.$q.'%" ORDER BY id DESC');
   if($rapport->rowCount() == 0) {
      $rapport = $bdd->query('SELECT pseudo_sender, id, type FROM rapport WHERE CONCAT(pseudo_sender, mail_sender) LIKE "%'.$q.'%" ORDER BY id DESC');
   }
}

?>
<?php
	if(isset($_SESSION['grade']) AND $_SESSION['grade'] == 1) {
?>
<html>
	<head>
		<title>G.E.P.S - Recherche de rédaction</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<link rel="icon" type="image/ico" href="images/favicon.ico"/>
		<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
	</head>
	<body>
		<?php include_once("analyticstracking.php") ?>
		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<!-- Header -->
					<header id="header">
						<h1><a href="index">G.E.P.S.</a></h1>
						<nav id="nav">
							<ul>
								<li class="special">
									<a href="#menu" class="menuToggle"><span>Menu</span></a>
									<div id="menu">
										<ul>
											<li><a href="index">Accueil</a></li>
											<li><a href="encore_plus">Encore plus !</a></li>
											<li><a href="nous_rejoindre">Nous rejoindre</a></li>
											<li><a href="le_project">Le project</a></li>
											<li><a href="#"></a></li>
											<li>-= Espace Membres =-</li>
											<li><a href="profil?id=<?php echo $_SESSION['id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;Retour au profil</a></li>
											<li><a href="boutique">&nbsp;&nbsp;&nbsp;&nbsp;Boutique</a></li>
											<li><a href="deconnexion">&nbsp;&nbsp;&nbsp;&nbsp;Déconnexion</a></li>
											<li><a href="#"></a></li>
											<li><a href="politiques">Politiques</a></li>
											<li><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=H4HEVACEMT6MW">Nous supporter</a></li>
											<div style="margin-top:30px;z-index:20000;position: fixed;"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
												<!-- Menu Big Rect -->
												<ins class="adsbygoogle"
												     style="display:inline-block;width:336px;height:280px"
												     data-ad-client="ca-pub-9083504882836474"
												     data-ad-slot="5881557940"></ins>
												<script>
												(adsbygoogle = window.adsbygoogle || []).push({});
											</script></div>
										</ul>
									</div>
								</li>
							</ul>
						</nav>
					</header>

				<!-- Main -->
					<article id="main">
						<header>
							<h2>Recherche de rédaction</h2>
						</header>
						<section class="wrapper style5">
							<div align="center" class="inner">
								<form method="GET">
									<div class="6u$ 12u$(xsmall)" style="float:none;">
								   		<input type="text" name="q" placeholder="Recherche..." value="<?php if(isset($q)){echo $q;} ?>"/><br/>
								   	</div>
								</form>
									<?php if($rapport->rowCount() > 0) { ?>
										<div class="12u$(medium)">
										   <ul class="actions">
										   <?php while($a = $rapport->fetch()) { ?>
										      <li><a style="width:800px;height:100px;" class="button fit" href="rapport-viewer?id=<?php echo $a['id']; ?>"><?= 'Par: '.$a['pseudo_sender'].'<br/>Type: '.$a['type'] ?></a></li>
										   <?php } ?>
										   </ul>
										</div>
									<?php } else { ?>
										Aucun résultat pour: <?= $q ?>...
									<?php } ?>
								<div style="margin-top:80px;" class="6u 12u$(medium)">
									<ul style="margin-bottom:0px;" class="actions fit">
										<li><a href="profil?id=<?= $_SESSION['id'] ?>" class="button fit special">Retour</a></li>
									</ul>
								</div>
							</div>
						</section>
					</article>

				<!-- Footer -->
					<footer id="footer">
						<ul class="icons">
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
							<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
						</ul>
						<ul class="copyright">
							<li>&copy; G.E.P.S.</li><li>Design: <a href="http://xxthegamecraft.xyz">XxTheGamecraftxX</a></li>
						</ul>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
			<script type="text/javascript">
				// create the back to top button
				$('body').prepend('<a href="#" style="text-decoration: none;" class="back-to-top">Back to Top</a>');

				var amountScrolled = 300;

				$(window).scroll(function() {
					if ( $(window).scrollTop() > amountScrolled ) {
						$('a.back-to-top').fadeIn('slow');
					} else {
						$('a.back-to-top').fadeOut('slow');
					}
				});

				$('a.back-to-top, a.simple-back-to-top').click(function() {
					$('html, body').animate({
						scrollTop: 0
					}, 700);
					return false;
				});
			</script>
	</body>
</html>
<?php
	} else {
		header("Location: connexion");
	}
?>