<?php
include 'database_connect.php'; session_start(); session_unset();


class main {
    
    function aktivierungJS() {
        if ($_REQUEST['mode'] == 'registerUser')        {echo json_encode(nutzerverwaltung::registerUser());}
        elseif ($_REQUEST['mode'] == 'loginUser')       {echo json_encode(nutzerverwaltung::loginUser());}
        elseif ($_REQUEST['mode'] == 'changePassword')  {echo json_encode(nutzerverwaltung::changePassword());}
        //elseif ($_REQUEST['mode'] == 'askAlleFragen')   {echo json_encode(FragenVerwaltung::askAlleFragen());}
        //elseif ($_REQUEST['mode'] == 'addFrage')        {echo json_encode(FragenVerwaltung::addFrage());}
        
        else{echo json_encode(array('returncode'=>1, 'Returnvalue'=>'<strong>Programmfehler Fehlercode: ##PHPMAIN_aktivierungJS_wv</strong><br>mode-Wert fehlerhaft. $_REQUEST[\'mode\'] = ' . var_dump($_REQUEST['mode'])));}
    }
    //elseif ($_REQUEST['mode'] == '')  {echo json_encode();}
    /**
     * @param string $sqlString
     * @return NULL[]
     */
    function sendSQL($sqlString) {
        global $link;
        $counter = 0;
        $data = array();
        $result = mysqli_query($link, $sqlString);
        var_dump($result);
        if ($result){
            while ($result->num_rows > $counter) {
                $data[$counter] = mysqli_fetch_assoc($result);
                $counter++;
            }
        }
        
        return $data;
        
    }
}

class validation 
{
    /**
     * @brief Encode des Passworts
     * @details 
     * @param string $passwort =  String mit zu verschluessendem Inhalt
     * @return string $antwort = Sha512 verschluesselter String
     * @note In der Datei 'save.php' stehen die Variablen die bei der Verschlüsselnug benötigt werden.
     */
    function pass_encode($passwort) {include 'save.php'; return hash("sha512", $pepper . $passwort . $salt);}
}

class nutzerverwaltung {
    
    public static function registerUser() // Funktion kann nur mit einem JS aufruf aufgerufen werden. 
    {
        try {
            // abfrage ob sich diese Mailadresse bereits in der Datenbank befindet
            $result = main::sendSQL("SELECT id FROM lehrer WHERE mail = '" . $_REQUEST['mail'] . "';");
            if (count($result) == 0) {
                $sqlString_InsertNewUser = "
                    INSERT INTO lehrer (
                        id, 
                        mail, 
                        vorname, 
                        nachname, 
                        passwort, 
                        istroot)
                    VALUES (
                        DEFAULT,
                        '" . $_REQUEST['mail'] . "',
                        '" . $_REQUEST['vornname'] . "',
                        '" . $_REQUEST['nachname'] . "',
                        '" . validation::pass_encode($_REQUEST['passwort']) . "',
                        FALSE);";
                main::sendSQL($sqlString_InsertNewUser);
                return array('returncode'=>0, 'returnvalue'=>true);
            }
            elseif (count($result) == 1) {return array('returncode'=>-1, 'returnvalue'=>false);}
            else {return array('returncode'=>1, 'returnvalue'=>'<strong>Datenbankfehler Fehlercode: ##PHPMAIN_registerUser_cue</strong>W&#228;rend der Verarbeitung ist ein Fehler aufgetreten.<br>count($result) = ' . count($result));}
        } 
        catch (Exception $e) {return array('returncode'=>1, 'returnvalue'=>'<strong>Unbekannter Fehler Fehlercode: ##PHPMAIN_registerUser_ue</strong>W&#228;rend der Verarbeitung ist ein Fehler aufgetreten.<br><br>' . $e);}
    }
    
    public static function loginUser() // Funktion kann nur mit einem JS aufruf aufgerufen werden. 
    {
        try {
            $result = main::sendSQL("SELECT isroot FROM lehrer WHERE mail = '" . $_REQUEST['mail'] . "' AND passwort = '" . validation::pass_encode($_REQUEST['passwort']) . "';");
            if (count($result) == 0) {return array('returncode'=>-1, 'Returnvalue'=>false);}
            elseif (count($result) == 1) {
                $_SESSION['usermail'] = $_REQUEST['mail'];
                if ($result[0]['isroot'] == 1){$_SESSION['userisroot'] = true;}
                else{$_SESSION['userisroot'] = false;}
                return array ('returncode'=>0, 'returnvalue'=>true);
            }
            elseif (count($result) > 1) {return array('returncode'=>1, 'Returnvalue'=>'<strong>Datenbankfehler Fehlercode: ##PHPMAIN_loginUser_tma</strong><br>Der Account mit der Mailadresse ' . $_REQUEST['mail'] . ' befindet sich mehrmals in der Datenbank.');}
            elseif (count($result) < 0) {return array('returncode'=>2, 'Returnvalue'=>'<strong>SQL Quary Fehler Fehlercode: ##PHPMAIN_loginUser_tla</strong><br>Das z&#228;hlen der SQL Resultate ergab einen negativen Wert.');}
            else {return array ('returncode'=>3, 'Returnvalue'=>'<strong>Unbekannter Fehler Fehlercode: ##PHPMAIN_loginUser_cue</strong><br>Beim auswerten des SQL Ergebnisse ist ein Fehler aufgetreten.');}
        } catch (Exception $e) {
            return array ('returncode'=>4, 'Returnvalue'=>'<strong>Unbekannter Fehler Fehlercode: ##PHPMAIN_loginUser_ue</strong><br>Bei der ausf&#252;rung der Funktion ist folgender Fehler aufgetreten:<br><br>' . $e);
        }
    }

    public static function changePassword() // Funktion kann nur mit einem JS aufruf aufgerufen werden. 
    {
        try {
            $result = main::sendSQL("SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] . "' AND passwort = '" . validation::pass_encode($_REQUEST['oldpasswort']) . "';");
            if (count($result) == 1){
                $sqlString_ChangePassword = "UPDATE lehrer SET passwort = '" . validation::pass_encode($_REQUEST['newpasswort']) . "' WHERE mail = '" . $_SESSION['usermail'] . "';";
                main::sendSQL($sqlString_ChangePassword);
                return array('returncode'=>0, 'returnvalue'=>true);
            }
            elseif (count($result) == 0) {
                return array('returncode'=>-1, 'returnvalue'=>false);
            }
            else {
                return array('returncode'=>1, 'returnvalue'=>'<strong>Datenbankfehler Fehlercode: ##PHPMAIN_changePassword_cue</strong>W&#228;rend der Verarbeitung ist ein Fehler aufgetreten.<br>count($result) = ' . count($result));
            }
        } catch (Exception $e) {
            return array ('returncode'=>2, 'Returnvalue'=>'<strong>Unbekannter Fehler Fehlercode: ##PHPMAIN_loginUser_ue</strong><br>Bei der ausf&#252;rung der Funktion ist folgender Fehler aufgetreten:<br><br>' . $e);
        }
    }
}

class FragenVerwaltung {
    
    public static function addFrage() 
    {
        try {
            if (count("SELECT id FROM fragen WHERE frage = '" . $_REQUEST['frage'] . "' AND lehrerid = (SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] ."')") == 0)
            {
                $sqlsring_AddFrage = "INSERT INTO fragen (frage, id, kategorie, lehrerid) VALUES ('" . $_REQUEST['frage'] . "', DEFAULT, '" . $_REQUEST['kategorie'] . "', (SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] ."'));";
                main::sendSQL($sqlsring_AddFrage);
                $antwort = array
                (
                    'returncode'=>0,
                    'returnvalue'=>'<strong>Gespeichert.</strong><br>Die Frage wurde gespeichert'
                );
            }
            else 
            {
                $antwort = array
                (
                    'returncode'=>-1,
                    'returnvalue'=>'<strong>Nicht gespeichert.</strong><br>Die Frage existiert bereits.'
                );
            }
        } catch (Exception $e) {
            $antwort = array
            (
                'returncode'=>1,
                'returnvalue'=>$e
            );
        }
        return $antwort;
    }
    
    public static function askAlleFragen() 
    {
        try 
        {
            return array
            (
                'returncode'=>0,
                'returnvalue'=>main::sendSQL("SELECT frage, kategorie FROM fragen WHERE lehrerid = (SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] ."') OR lehrerid IS NULL")
            );
        } catch (Exception $e) 
        {
            return array
            (
                'returncode'=>1,
                'returnvalue'=>$e
            );
        };
    }
/*
    public static function makeFragebogen() 
    {
        $sqlstring_MakeFragebogen = "(SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] ."')
INSERT INTO fragebogen 
(
    zeitstempel, 
    id, 
    name, 
    schueleranzahl, 
    klassenname,
    fachid 
    lehrerid)
VALUES
(
    CURRENT_TIMESTAMP,
    DEFAULT,
    '" . $_REQUEST['name'] ."', 
    '" . $_REQUEST['anzahl'] ."',
    '" . $_REQUEST['klasse'] ."',
    (SELECT id FROM fach WHERE name = '" . $_REQUEST['fach'] ."'),
    (SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] ."')
)
RETURNING fragebogen.id;";
        $fragebogenID = main::sendSQL($sqlstring_MakeFragebogen)[0][0]['id'];
        $sqlstring_InsertFragebogen = "INSERT INTO nm_frage_fragebogen (bogenid, fragenid) VALUES";
        for ($i = 0; $i < $_REQUEST['fragen']; $i++) {
            $sqlstring_InsertFragebogen .= "(" . $fragebogenID . ", (SELECT id FROM fragen WHERE frage = " . $_REQUEST['fragen'][$i] . " AND lehrerid = (SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] ."'))";
        }
        $sqlstring_InsertFragebogen .= ";";
        main::sendSQL($sqlstring_InsertFragebogen);
        
    }
    
    public static function genCodes($anz, $id) {
        for ($i = 0; $i < $anz; $i++) {
            while (true) {
                $code = self::genNumber() . '-' . self::genNumber() . '-' . self::genNumber() . '-' . self::genNumber();
                if (count(main::sendSQL("SELECT * FROM codes WHERE codehash = '" . $code . "'")) == 0){
                    main::sendSQL("INSERT INTO codes (codehash, fragebogenid) VALUES ('" . $code . "', " . $id . ");");
                    echo $code;
                    continue;
                }
            }
        }
    }
    
    function genNumber() {
        $numb = random_int(0, 99);
        if ($numb <= 9){
            $numb = '0' . $numb;
        }
        return $numb;
    }
*/
}

if (isset($_REQUEST['mode'])){main::aktivierungJS();}

//$_SESSION['usermail'] = 'temp.dunp@hotmail.com';
//var_dump(FragenVerwaltung::genCodes(5, 1));