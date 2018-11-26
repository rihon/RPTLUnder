<?php
require("functions.php");
require("aboutfunction.php");
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
		
		if(isset($_POST["about"])and !empty($_POST["about"])){
			$myAbout = test_input($_POST["about"]);
			$notice = saveIseloom($myAbout);
		}
	}	

?>





<?php require ("header.php")?>
<h2>Siin on võimalik enda huvisid muuta</h2>


<h2>Enda huvid</h2>
<p><?php getSingleAboutData();?></p>

	
<h2>Iseloomustuse muutmine</h2>


<select multiple>
  <?php allInterests()?>
  <input name="aboutBtn" type="submit" value="Muuda">
</select>


	<p><?php echo $notice;?></p>


<?php require("footer.php") ?>