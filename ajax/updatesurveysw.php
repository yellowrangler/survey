<?php


$surveysw = '';
if( isset($_POST['surveysw']) )
{
     $surveysw = $_POST['surveysw'];
} 
else if isset($_GET['surveysw'])
{
	$surveysw = $_GET['surveysw'];
}

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
$DBschema = "ddd";
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
if ($surveysw != "")
{
	$sql = "SELECT surveysw  FROM surveyswtbl";
}
else
{
	$rv = "No .";
	exit($rv);
}

// print $sql;

$sql_result = @mysql_query($sql, $dbConn);
if (!$sql_result)
{
    $log = new ErrorLog("logs/");
    $sqlerr = mysql_error();
    $log->writeLog("SQL error: $sqlerr - Error doing select to db Unable to get member $membername information.");
    $log->writeLog("SQL: $sql");

    $status = -100;
    $msgtext = "System Error: $sqlerr";
}

//
// get the member information
//
$r = mysql_fetch_assoc($sql_result);
$member = $r;

//
// close db connection
//
mysql_close($dbConn);

//
// pass back info
//
exit(json_encode($member));

?>
