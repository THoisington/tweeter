<?php // Example 26-9: members.php
  require_once 'header.php';

  if (!$loggedin) die();
  $view = "";

  echo "<div class='main'>";

//  I will change this to print public messages and reconsider whatever the code is doing below.
  if (isset($_GET['view']))
  {
    $view = sanitizeString($_GET['view']);
    
    if ($view == $user) $name = "Your";
    else                $name = "$view's";
    
    echo "<h3>$name Profile</h3>";
    showProfile($view);

      $query  = "SELECT * FROM messages WHERE recip='$view' AND pm='0' ORDER BY time DESC"; //change this query to only be private
      $result = queryMysql($query);
      $num    = $result->num_rows;

      if($num){
          printMessages($result,$user,$view);
      }
  }
  //This is the code for actually listing the members at the moment. I don't want it to show up on home page
  if($view!=$user){
      if (isset($_GET['add']))
      {
        $add = sanitizeString($_GET['add']);

        $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
        if (!$result->num_rows)
          queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
      }
      elseif (isset($_GET['remove']))
      {
        $remove = sanitizeString($_GET['remove']);
        queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
      }

      $result = queryMysql("SELECT user FROM members ORDER BY user");
      $num    = $result->num_rows;

      echo "<h3>Other Members</h3><ul>";

      for ($j = 0 ; $j < $num ; ++$j)
      {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row['user'] == $user) continue;

        echo "<li><a href='members.php?view=" .
          $row['user'] . "'>" . $row['user'] . "</a>";
        $follow = "follow";

        $result1 = queryMysql("SELECT * FROM friends WHERE
          user='" . $row['user'] . "' AND friend='$user'");
        $t1      = $result1->num_rows;
        $result1 = queryMysql("SELECT * FROM friends WHERE
          user='$user' AND friend='" . $row['user'] . "'");
        $t2      = $result1->num_rows;

        if (($t1 + $t2) > 1) echo " &harr; is a mutual friend";
        elseif ($t1)         echo " &larr; you are following";
        elseif ($t2)       { echo " &rarr; is following you";
          $follow = "recip"; }

        if (!$t1) echo " [<a href='members.php?add="   .$row['user'] . "'>$follow</a>]";
        else      echo " [<a href='members.php?remove=".$row['user'] . "'>drop</a>]";
      }
    }
?>
    <!-- We need to style this up a bit, replacing the arrow system to indicate friendship and making each profile a box and not a li item -->
    </ul></div>
    </div>
  </body>
</html>
