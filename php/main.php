<?
include "MainInterface.php";
$jsablauf = new MainInterface();
echo $jsablauf->executeOrder($_REQUEST['mode']);