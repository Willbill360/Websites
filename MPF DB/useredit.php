<?php
  session_start();
  include_once('config.php');

  if(isset($_SESSION['id'])) {
    if($_SESSION['matricule'] == "ADMIN") {
        if(isset($_GET['id']) AND !empty($_GET['id'])) {
            if($_GET['id'] == 1) {
                header('Location: dashboard?id='.$_SESSION['id']);
            }
            $userid = htmlspecialchars($_GET['id']);
            $reqcuruser = $bdd->prepare("SELECT * FROM users WHERE id = ?");
            $reqcuruser->execute(array($userid));
            $unit = $reqcuruser->fetch();
        }
    if(isset($_POST['user_cancel'])) {
        header('Location: dashboard?id='.$_SESSION['id']);
    } elseif (isset($_POST['user_submit'])) {
        if(isset($_POST['user_division']) && isset($_POST['user_grade']) && isset($_POST['user_matchif']) && !empty($_POST['user_division']) && !empty($_POST['user_grade']) && !empty($_POST['user_matchif'])) {
            if(strlen($_POST['user_division']) <= 255 && strlen($_POST['user_grade']) <= 255 && strlen($_POST['user_matchif']) == 5) {
                $division = htmlspecialchars($_POST['user_division']);
                $grade = htmlspecialchars($_POST['user_grade']);
                $chiffres = htmlspecialchars($_POST['user_matchif']);
                $fullmat = "CCA-C17-".$division."-".$grade."-".$chiffres;
                if($grade == "RCT") {
                    $numericalgrade = 1;
                } elseif ($grade == "05") {
                    $numericalgrade = 2;
                } elseif ($grade == "04") {
                    $numericalgrade = 3;
                } elseif ($grade == "03") {
                    $numericalgrade = 4;
                } elseif ($grade == "02") {
                    $numericalgrade = 5;
                } elseif ($grade == "01") {
                    $numericalgrade = 6;
                } elseif ($grade == "AdJ") {
                    $numericalgrade = 7;
                } elseif ($grade == "SqL") {
                    $numericalgrade = 8;
                } elseif ($grade == "DeL") {
                    $numericalgrade = 9;
                } elseif ($grade == "DeC") {
                    $numericalgrade = 10;
                }

                if(isset($userid)) {
                    if(isset($_POST['user_password']) && !empty($_POST['user_password'])) {
                        $pass = sha1(htmlspecialchars($_POST['user_password']));
                    } else {
                        $pass = $unit['password'];
                    }
                    $upateuser = $bdd->prepare("UPDATE users SET matricule = ?, password = ?, grade = ?, numericalgrade = ?, division = ? WHERE id = ?");
                    $upateuser->execute(array($fullmat, $pass, $grade, $numericalgrade, $division, $userid));
                    header('Location: dashboard?id='.$_SESSION['id']);
                } else {
                    if(isset($_POST['user_password']) && !empty($_POST['user_password'])) {
                        $pass = sha1(htmlspecialchars($_POST['user_password']));
                        $insertuser = $bdd->prepare("INSERT INTO users(matricule, password, grade, numericalgrade, division, p_service) VALUES(?, ?, ?, ?, ?, ?)");
                        $insertuser->execute(array($fullmat, $pass, $grade, $numericalgrade, $division, "0"));
                        header('Location: dashboard?id='.$_SESSION['id']);
                    }
                }
            }
        }
    }
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> 
<![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en"> 
<![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <title>Data Milice UWG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
<!--
Genius Template
http://www.templatemo.com/tm-402-genius
Modified and PHP by: William Gagnon | wilgagnon@hotmail.com
-->
    <meta name="author" content="templatemo">
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700,800' rel='stylesheet' type='text/css'>
    
    <!-- CSS Bootstrap & Custom -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="css/templatemo_misc.css">
    <link rel="stylesheet" href="css/animate.css">
    <link href="css/templatemo_style.css" rel="stylesheet" media="screen">
    
    <!-- Favicons -->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    
    <!-- JavaScripts -->
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/modernizr.js"></script>
    <!--[if lt IE 8]>
	<div style=' clear: both; text-align:center; position: relative;'>
            <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" alt="" /></a>
        </div>
    <![endif]-->
</head>
<body>
    
    
    <div class="bg-image"></div>
    <div class="overlay-bg"></div>

    
    <!-- <div class="container language-select visible-md visible-lg">
        <div class="row">
            <div class="col-md-12">
                <select name="cat2" id="cat2" class="postform">
                    <option value="0">-> Language Selection <-</option>
                    <option class="level-0" value="1">English</option>
                    <option class="level-0" value="2">Français</option>
                </select>
            </div>  /.col-md-12
        </div>  /.row
    </div>  /.language-select -->

    <!-- This one in here is responsive menu for tablet and mobiles -->
    <div class="responsive-navigation visible-sm visible-xs" style="visibility: hidden;">
        <a href="#" class="menu-toggle-btn">
            <i class="fa fa-bars fa-2x"></i>
        </a>
        <div class="responsive_menu">
            <ul class="main_menu">
                <li><a class="show-1 homebutton" href="#"><i class="fa fa-home"></i>Home</a></li>
                <div class="menu-connected">
                <li><a class="show-2" href="#"><i class="fa fa-archive"></i>Mon Casier</a></li>
                <li><a class="show-3" href="#"><i class="fa fa-list"></i>Liste MPF</a></li>
                <li><a class="show-5" href="#"><i class="fa fa-sign-out"></i>Déconnexion</a></li>
                </div>
            </ul> <!-- /.main_menu -->
        </div> <!-- /.responsive_menu -->
    </div> <!-- /responsive_navigation -->

    <div class="main-content" style="font-size: 16px;">
        <div class="container">
            <div class="row">

                <!-- Static Menu -->
                <div class="col-md-2 visible-md visible-lg" style="visibility: hidden;">
                    <div class="main_menu">
                        <ul class="menu">
                            <li><a class="show-1 homebutton" href="#" data-toggle="tooltip" data-original-title="Home"><i class="fa fa-home"></i></a></li>
                            <div class="menu-connected">
                            <li><a class="show-2" href="#" data-toggle="tooltip" data-original-title="Mon Casier"><i class="fa fa-user fa-archive"></i></a></li>
                            <li><a class="show-3" href="#" data-toggle="tooltip" data-original-title="Liste MPF"><i class="fa fa-list"></i></a></li>
                            <li><a class="show-5" href="#" data-toggle="tooltip" data-original-title="Déconnexion"><i class="fa fa-sign-out"></i></a></li>
                            </div>
                        </ul>
                    </div> <!-- /.main-menu -->
                </div> <!-- /.col-md-2 -->

                <!-- Begin Content -->
                <div class="col-md-8">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="templatemo_logo">
                                <a href="#">
                                    <img src="images/Logo-1.png" alt="Civil Protection">
                                </a>
                            </div> <!-- /.logo -->
                        </div> <!-- /.col-md-12 -->
                    </div> <!-- /.row -->


                    <div id="menu-container">

                        <div id="menu-1" class="content home indexMenu" style="display: none;">
                            <div class="page-header">
                                <h2 class="page-title"><?php if(isset($userid)) { echo "Modifier l'unité ".$unit['matricule'];} else { echo "Ajouter une unité";} ?></h2>
                            </div> <!-- /.page-header -->
                            <div class="content-inner" style="padding-top: 0px;">
                                <div class="row">
                                <form class="contact-form" method="POST">
                                    <label>Maticule</label>
                                    <p><b>CCA-C17-
                                        <select name="user_division">
                                            <option value="CMB" <?php if(isset($userid) AND $unit['division'] == "CMB") { echo 'selected'; } ?> >CMB</option>
                                            <option value="HAMMER" <?php if(isset($userid) AND $unit['division'] == "HAMMER") { echo 'selected'; } ?> >HAMMER</option>
                                            <option value="MACE" <?php if(isset($userid) AND $unit['division'] == "MACE") { echo 'selected'; } ?> >MACE</option>
                                            <option value="SPEAR" <?php if(isset($userid) AND $unit['division'] == "SPEAR") { echo 'selected'; } ?> >SPEAR</option>
                                            <option value="JURY" <?php if(isset($userid) AND $unit['division'] == "JURY") { echo 'selected'; } ?> >JURY</option>
                                            <option value="VICE" <?php if(isset($userid) AND $unit['division'] == "VICE") { echo 'selected'; } ?> >VICE</option>
                                        </select>
                                        -
                                        <select name="user_grade">
                                            <option value="RCT" <?php if(isset($userid) AND $unit['grade'] == "RCT") { echo 'selected'; } ?> >RCT</option>
                                            <option value="05" <?php if(isset($userid) AND $unit['grade'] == "05") { echo 'selected'; } ?> >05</option>
                                            <option value="04" <?php if(isset($userid) AND $unit['grade'] == "04") { echo 'selected'; } ?> >04</option>
                                            <option value="03" <?php if(isset($userid) AND $unit['grade'] == "03") { echo 'selected'; } ?> >03</option>
                                            <option value="02" <?php if(isset($userid) AND $unit['grade'] == "02") { echo 'selected'; } ?> >02</option>
                                            <option value="01" <?php if(isset($userid) AND $unit['grade'] == "01") { echo 'selected'; } ?> >01</option>
                                            <option value="AdJ" <?php if(isset($userid) AND $unit['grade'] == "AdJ") { echo 'selected'; } ?> >AdJ</option>
                                            <option value="SqL" <?php if(isset($userid) AND $unit['grade'] == "SqL") { echo 'selected'; } ?> >SqL</option>
                                            <option value="DeL" <?php if(isset($userid) AND $unit['grade'] == "DeL") { echo 'selected'; } ?> >DeL</option>
                                            <option value="SeC" <?php if(isset($userid) AND $unit['grade'] == "SeC") { echo 'selected'; } ?> >SeC</option>
                                        </select>
                                        -
                                        <input type="text" name="user_matchif" placeholder="00000" maxlength="5" style="width:15%" value="<?php if(isset($userid) AND $unit['matricule'] != "ADMIN") { $explodedmat = explode("-", $unit['matricule']); echo $explodedmat[4];} ?>" /></b>
                                    </p>
                                    <label>Mot de passe</label>
                                    <input type="text" name="user_password" placeholder="<?php if(isset($userid)) { echo "Laissez vide pour ne pas modifier";} else { echo "123456";} ?>" maxlength="255" />
                                    <!--
                                    <label>Qualifications de l'unité</label><br/>
                                    <label>
                                        <input type="checkbox" name="user_qual_ing1" style="margin-bottom:0;height:inherit;width:30px;" />
                                        Qualification en Ingénierie Niveau 1
                                    </label><br/>
                                    <label>
                                        <input type="checkbox" name="user_qual_ing2" style="margin-bottom:0;height:inherit;width:30px;"/>
                                        Qualification en Ingénierie Niveau 2
                                    </label><br/>
                                    <label>
                                        <input type="checkbox" name="user_qual_mec1" style="margin-bottom:0;height:inherit;width:30px;"/>
                                        Qualification en Mécanique Niveau 1
                                    </label><br/>
                                    <label>
                                        <input type="checkbox" name="user_qual_mec2" style="margin-bottom:0;height:inherit;width:30px;"/>
                                        Qualification en Mécanique Niveau 1
                                    </label><br/>
                                    <label>
                                        <input type="checkbox" name="user_qual_tir" style="margin-bottom:0;height:inherit;width:30px;"/>
                                        Qualification de Tireur d'Élite
                                    </label><br/>
                                    -->
                                    <input type="submit" name="user_cancel" id="user_cancel" class="mainBtn" style="width: 49%;" value="Annuler/Retour">
                                    <input type="submit" name="user_submit" id="user_submit" class="mainBtn" style="width: 49%; float: right;" value="<?php if(isset($userid)) { echo "Modifier";} else { echo "Ajouter";} ?>">
                                </form>
                                </div> <!-- /.row -->
                            </div> <!-- /.content-inner -->
                        </div> <!-- /.homepage -->

                        <div class="site-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <p align="center" class="copyright-text">Copyright &copy; 2017 William Gagnon et Union War Gaming 
                                    </p>
                                </div>
                            </div>
                        </div> <!-- /.site-footer -->

                    </div> <!-- /.content-holder -->
                
                </div> <!-- /.col-md-10 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </div> <!-- /.main-content -->

    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="js/jquery.mixitup.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.lightbox.js"></script>
    <script src="js/templatemo_custom.js"></script>
    <script>
        function initialize() {
          var mapOptions = {
            zoom: 15,
            center: new google.maps.LatLng(16.832179,96.134976)
          };

          var map = new google.maps.Map(document.getElementById('map-canvas'),
              mapOptions);
        }

        function loadScript() {
          var script = document.createElement('script');
          script.type = 'text/javascript';
          script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' +
              'callback=initialize';
          document.body.appendChild(script);
        }

    </script>
<!-- templatemo 402 genius -->
</body>
</html>
<?php
    } else {
    header('Location: dashboard?id='.$_SESSION['id']);
 }
 } else {
    header('Location: index');
 }
?>
