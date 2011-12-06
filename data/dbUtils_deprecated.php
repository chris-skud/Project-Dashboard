<?php
require_once("dbConnInfo.php");
require_once("DataAccess.php");
require_once("Dao.php");
$dataAccess = new DataAccess($host,$user,$pass,$db);

//expensive perhaps but makes the interface to this data 
// feel more like an object than an array.
// only accepts a single dim array
// i should probably put this in the services or dao...
function array_to_object($array)
{
	return (object)$array[0];
}
?>