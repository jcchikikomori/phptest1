<?php

/** USER-DEFINED CONSTANTS **/

// define('URL', 'http://'.$_SERVER['HTTP_HOST'].'/'); // for virtual hosts only!
define('STARTING_PAGE', 1);
define('ITEM_PER_PAGE', 10);

/** END OF USER-DEFINED CONSTANTS **/

// include classes/libs first before the main event
include_once('libraries/view.php'); // for rendering single view or templates

// run by using requiring main class
require_once('inventory.php');

// run the application
$inventory = new Inventory();

// echo "<h4>DEBUG: Class info</h4>";
// var_dump($inventory);
