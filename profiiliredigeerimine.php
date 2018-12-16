<?php
require("functions.php");
require("aboutfunction.php");
require("config.php");
require("classes/Photoupload.class.php");
$database = "if17_riho_4";

	$notice = "";
	$allIdeas = "";
	$target_dir = "uploads/";
	$target_file;
	$uploadOk = 1;
	$imageFileType;
	$maxWidth = 600;
	$maxHeight = 400;
	$marginBottom = 10;
	$marginRight = 10;
	
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

	if(isset($_POST["InstituteBTN"])){
		if(isset($_POST["Institute"])and !empty($_POST["Institute"])){
			$myAbout1 = test_input($_POST["Institute"]);
			updateInstitute($_SESSION["userId"],$myAbout1);
		}
	}

	
	if(isset($_POST["SchoolBTN"])){
		if(isset($_POST["School"])and !empty($_POST["School"])){
			$myAbout1 = test_input($_POST["School"]);
			updateSchool($_SESSION["userId"],$myAbout1);
		}
	}

	//Kas on pildi failitüüp
	if(isset($_POST["UploadPhoto"])) {
		
		//kas mingi fail valiti
		if(!empty($_FILES["fileToUpload"]["name"])){
			
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]))["extension"]);
			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			//tekitame failinime koos ajatempliga
			//$target_file = $target_dir .pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .(microtime(1) * 10000) ."." .$imageFileType;
			$target_file = $_SESSION["userId"].".".$imageFileType;
			//$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$notice .= "Fail on pilt - " . $check["mime"] . ". ";
				$uploadOk = 1;
			} else {
				$notice .= "See pole pildifail. ";
				$uploadOk = 0;
			}
			
			//Kas selline pilt on juba üles laetud
			if (file_exists($target_file)) {
				$notice .= "Kahjuks on selle nimega pilt juba olemas. ";
				$uploadOk = 0;
			}
			
			/*Piirame faili suuruse
			if ($_FILES["fileToUpload"]["size"] > 1000000) {
				$notice .= "Pilt on liiga suur! ";
				$uploadOk = 0;
			}*/
			
			//Piirame failitüüpe
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$notice .= "Vabandust, vaid jpg, jpeg, png ja gif failid on lubatud! ";
				$uploadOk = 0;
			}
			
			//Kas saab laadida?
			/*if ($uploadOk == 0) {
				$notice .= "Vabandust, pilti ei laetud üles! ";
			//Kui saab üles laadida
			} else {		
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					$notice .= "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti üles! ";
				} else {
					$notice .= "Vabandust, üleslaadimisel tekkis tõrge! ";
				}
			}*/
			if ($uploadOk == 0) {
				$notice .= "Vabandust, pilti ei laetud üles! ";
			//Kui saab üles laadida
			} else {
				
				
				photoToDatabase($target_file);
				//kasutan klassi
				$myPhoto = new Photoupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
				$myPhoto->readExif();
				$myPhoto->resizeImage($maxWidth, $maxHeight);
				//$myPhoto->addWatermark();
				//$myPhoto->addTextWatermark($myPhoto->exifToImage);
				//$myPhoto->addTextWatermark("hmv_foto");
				$myPhoto->savePhoto($target_dir, $target_file);
				$myPhoto->clearImages();
				unset($myPhoto);
				//header("Location: profiiliredigeerimine.php");
				$notice = "Laetud";
				
			}
		
		} else {
			$notice = "Palun valige kõigepealt pildifail!";
		} //kas üldse mõni fail valiti, lõppeb
	}
?>





<?php require ("header.php")?>
<h2>Siin on võimalik enda profiili muuta</h2>


<!--<h2>Enda huvid</h2>
<p><?//php getSingleAboutData();?></p>-->

<h2>Iseloomustus</h2>
<?php showBio($_SESSION["userId"]) ?>
<h2>Instituut</h2>
<?php showInstitute($_SESSION["userId"]) ?>
<h2>Kool</h2>
<?php showSchool($_SESSION["userId"]) ?>

<h2>Muuda pilti</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
		<label>Valige pildifail:</label>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Lae üles" name="UploadPhoto" id="UploadPhoto"><span id="fileSizeError"></span>
</form>

<h2>Iseloomustuse muutmine</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input type="hidden" name="id" value="<?php echo $_GET["'id'"];?>">
		<textarea name="BioNew" rows="5" cols="40"></textarea>
		<br>
		<input name="aboutBtn" type="submit" value="Muuda">
		
	
</form>
<br>
<br>


<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<select name="Institute">
		<option value="valik">Valik</option> <?php if ($signupInstitute == "Valik") {echo 'checked';} ?>
		<option value="DTI">DTI</option>	<?php if ($signupInstitute == "DTI") {echo 'checked';} ?>
		<option value="HTI">HTI</option>	<?php if ($signupInstitute == "HTI") {echo 'checked';} ?>
		<option value="BFM">BFM</option>	<?php if ($signupInstitute == "BFM") {echo 'checked';} ?>
		<option value="LTI">LTI</option>	<?php if ($signupInstitute == "LTI") {echo 'checked';} ?>
		<option value="YTI">YTI</option>	<?php if ($signupInstitute == "YTI") {echo 'checked';} ?>
	</select>
	<br>
	<input name="InstituteBTN" type="submit" value="Muuda">
</form>
<br>
<br>


<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<select name="School">
		<option value="TLU">Tallinna Ülikool</option> <?php if ($signupSchool == "TLU") {echo 'checked';} ?>
		<option value="TTU">Tallinna Tehnikaülikool</option> <?php if ($signupSchool == "TTU") {echo 'checked';} ?>
		<option value="TTK">Tallinna Tehnikakõrgkool</option> <?php if ($signupSchool == "TTK") {echo 'checked';} ?>
	</select>
	<br>
	<input name="SchoolBTN" type="submit" value="Muuda">
</form>
<br>
<br>


<?php require("footer.php") ?>