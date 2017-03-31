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
		if(!$result) die($connection->error); // checking if result is anything but 0?
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

	function redirect($url){
	    if (headers_sent()){
	      die('<script type="text/javascript">window.location=\''. $url .'\';</script‌​>');
	    }
	    else{
	      header('Location: ' . $url);
	      die();
   	 	}    
	}

	function printMessages($result,$user,$view){
        $num    = $result->num_rows;

        for ($j = 0 ; $j < $num ; ++$j)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
            {
                echo date('M jS \'y g:ia:', $row['time']);
                echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a> ";

                if ($row['pm'] == 0)
                    echo "wrote: &quot;" . $row['message'] . "&quot; ";
                else
                    echo "whispered: <span class='whisper'>&quot;" .
                        $row['message']. "&quot;</span> ";

                if ($row['recip'] == $user)
                    echo "[<a href='messages.php?view=$view" .
                        "&erase=" . $row['id'] . "'>erase</a>]";

                echo "<br>";
            }
        }
    }
?>