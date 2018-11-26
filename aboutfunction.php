<?php
	require("config.php");
	$database = "if17_riho_4";
/*	//ühe konkreetse mõtte lugemine
	function getSingleAboutData(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT text FROM TLUnder_user_profile WHERE id=?");
		$stmt->bind_param("i", $_SESSION["userId"]);
		$stmt->bind_result($aboutText);
		$stmt->execute();
		$stmt->fetch();
		echo $aboutText;		
		$stmt->close();
		$mysqli->close();
*/	
		
	
	
	//UUENDA HUVE
	function updateBio($id, $idea){
		//echo $id;
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE TLUnder_user_profile SET bio=$idea WHERE userid=$id");
		echo $mysqli->error;
		 //AND deleted IS NULL
		$stmt->execute();
		$stmt->fetch();
			
		$stmt->close();
		$mysqli->close();
	}

	function showBio($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT bio FROM TLUnder_user_profile where id=$id");
		$stmt->bind_result($Bio);
		$stmt->execute();
		while ($stmt->fetch()){
			echo "<p>" .$Bio ."</p>";
		}
		$stmt->close();
		$mysqli->close();
	}
?>