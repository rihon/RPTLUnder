<?php
require("functions.php");
require("aboutfunction.php");
require("config.php");
$database = "if17_riho_4";

	$notice = "";
	$allIdeas = "";
	//kui pole sisseloginud, siis sisselogimise lehele
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	//kui logib välja
	if (isset($_GET["logout"])){
		//lõpetame sessiooni
		session_destroy();
		header("Location: login.php");
	}
	
	//kui soovitakse iseloomustust salvestada
	if(isset($_POST["aboutBtn"])){
		if(isset($_POST["BioNew"])and !empty($_POST["BioNew"])){
			$myAbout = test_input($_POST["BioNew"]);
			updateBio($_SESSION["userId"],$myAbout);
		}
	}



?>





<?php require ("header.php")?>
<h2>Siin on võimalik enda profiili muuta</h2>


<!--<h2>Enda huvid</h2>
<p><?//php getSingleAboutData();?></p>-->

	
<h2>Iseloomustus</h2>
<?php showBio($_SESSION["userId"]) ?>

<h2>Iseloomustuse muutmine</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input type="hidden" name="id" value="<?php echo $_GET["'id'"];?>">
		<textarea name="BioNew" rows="5" cols="40"></textarea>
		<br>
		<input name="aboutBtn" type="submit" value="Muuda">
		<span><?php echo $notice; ?></span>
	
</form>


	<p><?php echo $notice;?></p>


<?php require("footer.php") ?>