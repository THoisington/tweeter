<?php
	$dbhost = 'localhost';
	$dbname = 'tweeter';
	$dbuser = 'root';
	$dbpass = '';
	$appname = 'Tweeter';

	$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if($connection->connect_error) die($connection->connect_error);


	// checks whether or not a table exists and if not creates it
	function createTable($name,$query){
		queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
		echo "Table $name created or already exists. <br>";
	}

	function queryMysql($query){
		global $connection; //global? 
		$result = $connection->query($query);
		if(!result) die($connection->error); // checking if result is anything but 0?
		return $result;
	}

	function destroySession(){
		$_SESSION=array(); //empties browser session 

		if(session_id() != "" || isset($_COOKIE[session_name()])){ //deletes cookie
			setcookie(session_name(),'',time()-2592000,'/');
		}

		session_destroy();
	}

	function sanitizeString($var){
		global $connection; 
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return $connection->real_escape_string($var);
	}

	function showProfile($user){
		if(file_exists("$user.jpg")){
			echo "<img src='$user.jpg' style='float:left;'>"; //maybe replace inline style with a class
		}

		$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

		if($result->num_rows){
			$row = $result->fetch_array(MYSQLI_ASSOC);
			echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
		}
	}
?>