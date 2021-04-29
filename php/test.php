<?php
include 'main.php';
$_SESSION['usermail']       = 'temp.dump@hotmail.com';
$_REQUEST['mode']           = 'addFrage';


$_REQUEST['frage']          = 'Tafelbilder und Folien sind gut lesbar.2';
$_REQUEST['mail']           = 'temp.dump@hotmail.com';
$_REQUEST['passwort']       = 'Admin';
$_REQUEST['kategorie']      = 'Unterricht';


$fun = new main();
$fun->aktivierungJS();