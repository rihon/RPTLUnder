<?php
	require("config.php");
	$database = "if17_riho_4";
	
	//UUENDA HUVE
	function updateBio($id, $idea){
		//echo $id;
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE TLUnder_user_profile SET bio='$idea' WHERE userid=$id");
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

	function showInstitute($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT institute FROM TLUnder_users where id=$id");
		$stmt->bind_result($Bio);
		$stmt->execute();
		while ($stmt->fetch()){
			echo "<p>" .$Bio ."</p>";
		}
		$stmt->close();
		$mysqli->close();
	}

	function updateInstitute($id, $idea1){
		//echo $id;
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE TLUnder_users SET institute='$idea1' WHERE id=$id");
		echo $mysqli->error;
		 //AND deleted IS NULL
		$stmt->execute();
		$stmt->fetch();
			
		$stmt->close();
		$mysqli->close();
	}


	function showSchool($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT school FROM TLUnder_users where id=$id");
		$stmt->bind_result($Bio);
		$stmt->execute();
		while ($stmt->fetch()){
			echo "<p>" .$Bio ."</p>";
		}
		$stmt->close();
		$mysqli->close();
	}

	function updateSchool($id, $idea2){
		//echo $id;
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE TLUnder_users SET school='$idea2' WHERE id=$id");
		echo $mysqli->error;
		 //AND deleted IS NULL
		$stmt->execute();
		$stmt->fetch();
			
		$stmt->close();
		$mysqli->close();
	}
?>