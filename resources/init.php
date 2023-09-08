<?php
/* Error Message: Deprecated: mysql_connect(): The mysql extension is deprecated and will be removed in the future: use mysqli or PDO instead in C:\wamp64\www\kblog\resources\init.php on line 4 */

error_reporting(E_ALL); // Handle errors including deprecated functions

include_once('config.inc.php');

// Establish a MySQLi connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

include_once('functions/blog.php');
?>