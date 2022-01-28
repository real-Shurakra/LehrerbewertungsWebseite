<?php
include '../php/UserAdministration.php';
include '../conf/config.php';
global $dbipv4, $dbname, $dbuser, $dbpass;

var_dump($_REQUEST);

$newuserUsername = $_REQUEST['username'];
$newuserFirstname = $_REQUEST['firstname'];
$newuserLastname = $_REQUEST['lastname'];
$newuserPassword = $_REQUEST['password'];

$userAdmin = new UserAdministration($dbipv4, $dbname, $dbuser, $dbpass);
var_dump($userAdmin->addUser($newuserUsername, $newuserFirstname, $newuserLastname, $newuserPassword));