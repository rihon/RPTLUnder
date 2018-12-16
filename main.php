<style>
<?php include 'style.css';?>
</style>
<?php
	require("functions.php");
	
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
		exit();
	}
	?>
	<div class='xd'>
	<?php require ("header.php")?>
	
	<?php echo "<div class='main-grid'>"; allUsers(); echo "</div";  ?>
	<p><a id="editprofile" href="profiiliredigeerimine.php">Kasutajakonto redigeerimine</a></p><!--Kasutajakonto redigeerimine, muuta saab tutvustust ja pilte-->
	</div>
<?php require("footer.php") ?>