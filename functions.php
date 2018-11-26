<?php
	require("config.php");
	$database = "if17_riho_4";
	
	//alustan sessiooni
	session_start();
	
	//sisselogimise funktsioon
	function signIn($email, $password){
		$notice = "";
		//ühendus serveriga
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, firstname, lastname, email, password FROM TLUnder_users WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $firstnameFromDb, $lastnameFromDb, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		//kontrollime vastavust
		if ($stmt->fetch()){
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb){
				$notice = "Logisite sisse!";
				
				//Määran sessiooni muutujad
				$_SESSION["userId"] = $id;
				$_SESSION["firstname"] = $firstnameFromDb;
				$_SESSION["lastname"] = $lastnameFromDb;
				$_SESSION["userEmail"] = $emailFromDb;
				
				//liigume edasi pealehele (main.php)
				header("Location: main.php");
				exit();
			} else {
				$notice = "Vale salasõna!";
			}
		} else {
			$notice = 'Sellise kasutajatunnusega "' .$email .'" pole registreeritud!';
		}
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	//kasutaja salvestamise funktsioon
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword, $signupInstitute, $signupSchool, $Institute, $School){
		//loome andmebaasiühenduse
		
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette käsu andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO TLUnder_users (firstname, lastname, birthday, gender, email, password, School, Institute) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//s - string
		//i - integer
		//d - decimal
		$stmt->bind_param("sssissss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword, $School, $Institute);
		//$stmt->execute();
		if ($stmt->execute()){
			echo "\n Õnnestus!";
		} else {
			echo "\n Tekkis viga : " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();


		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id FROM TLUnder_users where email=$signupEmail");
		$stmt->bind_result($idBioks);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
		

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO TLUnder_user_profile (id, userid, bio) VALUES (?,?,?) ");
			echo $mysqli->error;
			 //AND deleted IS NULL
			$stmt->bind_param("iis", $idBioks,$idBioks , "Placeholder Bio");
			if ($stmt->execute()){
				echo "\n Õnnestus!";
			} else {
				echo "\n Tekkis viga : " .$stmt->error;
			}
			$stmt->close();
			$mysqli->close();
	}
	
	//Kõikide kasutajate list
	function allUsers(){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, lastname, id FROM TLUnder_users");	
	$stmt->bind_result($FirstName, $FamilyName, $id);
	$stmt->execute();
	while ($stmt->fetch()){
		echo "<a href=profiil.php?userId=" .$id .">" .$FirstName ." " .$FamilyName ."</a></br>";
		
	}
	$notice= $mysqli->error;
	$stmt->close();
	$mysqli->close();
	
	}



	
	function showEditPicture(){
		$images = ("uploads/");
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT filename FROM TLUnder_photo WHERE userid=?");
		$stmt->bind_param("i", $_SESSION["userId"]);
		$stmt->bind_result($showEditPicture);
		$stmt->execute();
		$stmt->fetch();
		echo '<img src="'.$images .$showEditPicture .'" alt="'.$showEditPicture .'">';
		$stmt->close();
		$mysqli->close();
		
		
	}
	
	function test_input($data){
		$data = trim($data);//ebavajalikud tühiku jms eemaldada
		$data = stripslashes($data);//kaldkriipsud jms eemaldada
		$data = htmlspecialchars($data);//keelatud sümbolid
		return $data;
	}
	
	
	
?>