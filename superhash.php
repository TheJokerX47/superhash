<?php
/*
This script is copyright Dustin A.K.A. Skare(tm) 2011
*/


$host = "localhost"; // Database host
$db = "keys"; // Database name
$user = "root"; // Database username
$pass = ""; // Database user's password


$len = 64;
$base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz0123456789!@#$%^&*()';
$max=strlen($base)-1;
$ranstr='';
mt_srand((double)microtime()*1000000);
while (strlen($ranstr)<$len+1)
  $ranstr.=$base{mt_rand(0,$max)};
  
 $len = 32;
$max=strlen($base)-1;
$ranstr2='';
mt_srand((double)microtime()*1000000);
while (strlen($ranstr2)<$len+1)
  $ranstr2.=$base{mt_rand(0,$max)}; 
  

$salt = hash('whirlpool', $ranstr2);
  
$hashed = hash('adler32', hash('whirlpool', hash('ripemd256', sha1(base64_encode(crypt(md5(hash('sha512', $ranstr))))))));

$suphash = md5($hashed . $salt);

echo $suphash;

// MySQL Connection
mysql_connect("$host", "$user", "$pass")or die("Connection to MySQL database server failed.");
mysql_select_db("$db")or die("Unable to select database.");


// Insert generated hashes into database
$sql = "INSERT INTO `keys` (`key`) VALUES ('$suphash')";
mysql_query("$sql");
die();

?>
