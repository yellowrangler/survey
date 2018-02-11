<?php

// Built by Tarry Cutler 02/09/2018 
// For the Museum of Science Boston, MA
// 
// This module receives:
//	 action: What action to perform 
//	 surveyid: What surveys are to use this action [each survey must have unique number]
// from a MOS Survey Gizmo Wehook.
// 
// The action tells us what to do for the particular survey identified by the surveyid.
// The survey id represents a singular survey of which there will be multiple survey instances. 
// In this way multiple different Surveys can be using different actions with out interfeering with each other.
// This service uses a state variable stored on a table to determine what to
// send back to the Survey Gizmo. It is that value that will be acted on in the 
// Survey to show/hide/branch etc.

// If the action on the table is not the action passed in then this signifies a new action for this survey id 
// as a result state and survey switch are reset to 0
// 
// Actions:
// p50 - every other request toogles the vaue sent back to 1
// p33 - after 3 the return value is set to 1
// For the current actions a surveysw of 1 = hide 0 = show [do not hide] 


// 
// get passed information
// 
$action = '';
if ( isset($_POST['action']) )
{
     $action = $_POST['action'];
} 
else
{
	if ( isset($_GET['action']) )
	{
		$action = $_GET['action'];
	}
} 

$surveyid = 0;
if ( isset($_POST['surveyid']) )
{
     $surveyid = $_POST['surveyid'];
} 
else
{
	if ( isset($_GET['surveyid']) )
	{
		$surveyid = $_GET['surveyid'];
	}
} 
	
//
// get date time for this transaction
//
$datetime = date("Y-m-d H:i:s");

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
$sql = "SELECT *  FROM surveytbl WHERE surveyid = $surveyid";

// print $sql;

$sql_result = @mysql_query($sql, $dbConn);
if (!$sql_result)
{
    $sqlerr = mysql_error();
    $rv = "SQL error: $sqlerr - Error doing select to db Unable to get survey switch information.";
	exit($rv);
}

// 
// If the record is not there then we add new survey record
// 
$count = mysql_num_rows($sql_result);
if ($count < 1)
{
	//---------------------------------------------------------------
	// insert mos survey sw information
	//---------------------------------------------------------------
	$sql = "INSERT INTO  surveytbl 
		( surveyid, action, state, createdate ) 
		VALUES ( $surveyid, '$action', 0, '$enterdate' )";

	// print $sql;

	$sql_result = @mysql_query($sql, $dbConn);
	if (!$sql_result)
	{
	    $sqlerr = mysql_error();
	    $rv = "SQL error: $sqlerr - Error doing insert to db Unable to get survey switch information.";
		exit($rv);
	}

	//---------------------------------------------------------------
	// now get mos survey sw information again for id
	//---------------------------------------------------------------
	$sql = "SELECT *  FROM surveytbl WHERE surveyid = $surveyid";

	// print $sql;

	$sql_result = @mysql_query($sql, $dbConn);
	if (!$sql_result)
	{
	    $sqlerr = mysql_error();
	    $rv = "SQL error: $sqlerr - Error doing select to db Unable to get survey switch information 2.";
		exit($rv);
	}

	//
	// put the survey action information into our array
	//
	$r = mysql_fetch_assoc($sql_result);

	$surveystate = $r[state];
	$surveyid = $r[surveyid];
	$surveyrecordid = $r[id];

}
else
{
	// Must check to see if new action being introduced. If so then reset state and switch 
	$r = mysql_fetch_assoc($sql_result);

	$prevaction = $r[action];

	$surveystate = $r[state];
	$surveyid = $r[surveyid];
	$surveyrecordid = $r[id];

	if ($prevaction != $action)
	{
		$surveystate = 0;
	}
}

switch ($action) {
	case 'p50':
		// 0 = show. 1 = hide 
		switch ($surveystate) {
			case '1':
				$surveysw = 0;
				$surveystate = 0;
				break;

			case '0':
				$surveysw = 1;
				$surveystate = 1;
				break;	
			
			default:
				$surveysw = 1;
				$surveystate = 1;
				break;
		}
		break;

	case 'p33':
		// 0 = show. 1 = hide 
		if ( $surveystate > 2 )
		{
			$surveysw = 1;
			$surveystate = 0;
		}
		else
		{
			$surveysw = 0;
			$surveystate += 1;
		}
		break;	
	
	default:
		break;
}


//---------------------------------------------------------------
// set mos survey sw information
//---------------------------------------------------------------
$sql = "UPDATE surveytbl 
set action = '$action', state = '$surveystate', surveysw = $surveysw, createdate = '$enterdate' 
WHERE id = $surveyrecordid";

// print $sql;

$sql_result = @mysql_query($sql, $dbConn);
if (!$sql_result)
{
    $sqlerr = mysql_error();
    $rv = "SQL error: $sqlerr - Error doing update to db Unable to update survey switch information.";
	exit($rv);
}

//
// close db connection
//
mysql_close($dbConn);

//
// pass back info
//
exit("surveysw=$surveysw");

?>
