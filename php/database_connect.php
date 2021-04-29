<?php
// Einlesen der Datenbankparametern
include 'save.php';

$link = mysqli_connect($dbipv4, $dbuser, $dbpass, $dbname);

if (!$link) {
    echo "Fehler: konnte nicht mit MySQL verbinden." . PHP_EOL;
    echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debug-Fehlermeldung: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
?>