<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>

    <h3>Setting up...</h3>

<?php // Example 26-3: setup.php
  require_once 'functions.php';

  // Member ID is my own addition, I did not like the idea of members of a social media website without a primary key
  createTable('members',
              'id INT UNSIGNED NOT NULL AUTO_INCREMENT, 
              user VARCHAR(16),
              pass VARCHAR(16),
              PRIMARY KEY(id),
              INDEX(user(6))');

  createTable('messages', 
              'id INT UNSIGNED NOT NULL AUTO_INCREMENT,
              auth VARCHAR(16),
              recip VARCHAR(16),
              pm CHAR(1),
              time INT UNSIGNED,
              message VARCHAR(4096),
              PRIMARY KEY(id),
              INDEX(auth(6)),
              INDEX(recip(6))');

  // which means I need to change friend from VARCHAR to INT
  createTable('friends',
              'user VARCHAR(16),
              friend VARCHAR(16),
              INDEX(user(6)),
              INDEX(friend(6))');

  createTable('profiles',
              'user VARCHAR(16),
              text VARCHAR(4096),
              INDEX(user(6))');
?>

    <br>...done.
  </body>
</html>
