<?php
	$mysqli = new mysqli("127.0.0.1","root","422YaleAveN"); /** Syntax ==> mysql_connect(SERVERNAME,USERNAME,PASSWORD); **/
	/* check connection */

	if (mysqli_connect_errno()) {
    	printf("Connect failed: %s\n", mysqli_connect_error());
    	exit();
	}

	$mysqli->select_db("Torino"); /** This will select the databasename **/
