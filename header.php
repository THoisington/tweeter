<?php
  session_start();

  echo "<!DOCTYPE html>\n<html><head>";

  require_once 'functions.php';

  $userstr = '| (Guest)';

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  else $loggedin = FALSE;

  $head = <<<HTML
    <title>$appname$userstr</title>
    <link rel='stylesheet' href='styles.css' type='text/css'>
    <script src='javascript.js'></script>
    </head><body>
HTML;

  echo $head;

  if ($loggedin)
  {
      $nav = <<<HTML
        <nav>
            <ul class='menu'>
            <li><a href='members.php?view=$user'>Home</a></li>
            <li><a href='members.php'>Members</a></li>
            <li><a href='messages.php'>Messages</a></li>
            <li class="dropdownLabel">
                <a href="#">$user<span class="caret"></span></a>
                <ul class="dropdownMenu">
                    <li><a href='friends.php'>Friends</a></li>
                    <li><a href='profile.php'>Edit Profile</a></li>
                    <li><a href='logout.php'>Log out</a></li>
                </ul>
            </li>
            </ul>
        </nav>
HTML;

      echo $nav;
  } //change to drop down with name as base li 
  else
  {
      $nav = <<<HTML
      <nav>
        <ul class='menu'>
            <li><a href='index.php'>Home</a></li>
            <li><a href='signup.php'>Sign up</a></li>
            <li><a href='login.php'>Log in</a></li>
        </ul>
    </nav>
    <p>You must be logged in to view this page.</p>
HTML;
      echo $nav;

  }

    echo "<div class='contentWrapper'>";
?>
