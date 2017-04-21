<?php
if(isset($_GET['reloadNewList'])){
global $couchUrl;
$couchUrl = 'http://192.168.0.111:5984';
include "lib/couch.php";
include "lib/couchClient.php";
include "lib/couchDocument.php";
	$catogory = $_GET['reloadNewList'];
	$resources = new couchClient($couchUrl, "radio_resources");
	$start_key = array($catogory,"A");
	$end_key = array($catogory,"Z");
	$viewResults = $resources->include_docs(TRUE)->startkey($start_key)->endkey($end_key)->getView('api', 'allCatResTitle');
	$colorCnt=0;
	echo json_encode($viewResults);
} else if(isset($_GET['startPlay'])){
	$listArray = json_decode($_GET['startPlay']);
		///$arg1_array = explode(",",$arg1);
	for($cnt=0;$cnt<sizeof($listArray);$cnt++){
		$arg = $_GET['freq']." ".$listArray[$cnt]." 'oleghana' 2>&1";
		exec("python playitems.py ". $arg, $output, $return_var);
		///exec("python playitems.py ". $arg);
		//$command = escapeshellcmd("python playitems.py". $arg, $output, $return_var);
		//$output = shell_exec($command);
		//echo $output;
	}
	echo $arg;
	$obj['cmd_output'] = $output;
    echo json_encode($arg1);
}
?>
