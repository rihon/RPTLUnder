<?php

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
	TLUnder
	</title>
</head>
<body>
<img src="https://i.imgur.com/sjoCdMn.png?1" alt="TLUnderi logo">
</body>
<h3><?php echo $_SESSION["firstname"] ." " .$_SESSION["lastname"]; ?></h3>
<p><a id="avaleht" href="main.php">Avalehele</a>!</p>
<p><a id="logout" href="?logout=1">Logi välja</a>!</p>
