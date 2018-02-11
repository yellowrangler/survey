<?php

//
// get date time for this transaction
//
$datetime = date("Y-m-d H:i:s");

// print_r($_POST);
// die();

// set variables
$enterdate = $datetime;

//------------------------------------------------------
// get admin user info
//------------------------------------------------------
// open connection to host
$DBhost = "localhost";
$DBschema = "mos";
$DBuser = "tarryc";
$DBpassword = "tarryc";

//
// connect to db
//
$dbConn = @mysql_connect($DBhost, $DBuser, $DBpassword);
if (!$dbConn) 
{
	$dberr = mysql_error();
	$rv = "DB error: $dberr - Error mysql connect. Unable to get survey switch information.";
	exit($rv);
}

if (!mysql_select_db($DBschema, $dbConn)) 
{
	$dberr = mysql_error();
	$rv = "DB error: $dberr - Error selecting db Unable to get survey switch information.";
	exit($rv);
}

//---------------------------------------------------------------
// get mos survey sw information
//---------------------------------------------------------------
$sql = "SELECT surveysw  FROM surveyswtbl";

// print $sql;

$sql_result = @mysql_query($sql, $dbConn);
if (!$sql_result)
{
    $sqlerr = mysql_error();
    $rv = "SQL error: $sqlerr - Error doing select to db Unable to get survey switch information.";
	exit($rv);
}

//
// get the member information
//
$r = mysql_fetch_assoc($sql_result);
$surveysw = $r[surveysw];

//
// close db connection
//
mysql_close($dbConn);

//
// pass back info
//
exit($surveysw);

?>
