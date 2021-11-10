<?php
class LBWEncription {

    function __construct(){

    }

    /**
     * @brief Password encription Manager
     * @details 
     * @param string $cleanPassword = 
     * @return string $antwort = Sha512 verschluesselter String
     * @note In der Datei 'save.php' stehen die Variablen die bei der Verschluesselnug benoetigt werden.
     */
    function pass_encode($cleanPassword) {
        include 'save.php'; 
        $passwort = hash("sha512", $pepper . $passwort . $salt);
        return $passwort;}

    
}


$pepper = 'P1ct0';
$salt = 'R1u$';