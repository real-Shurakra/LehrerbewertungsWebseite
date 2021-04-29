<?php
include 'database_connect.php'; session_start();

class main {
    
    function aktivierungJS() {
        if      ($_REQUEST['mode'] == 'loginUser')          {echo json_encode(nutzerverwaltung::loginUser           ($_REQUEST['mail'],         $_REQUEST['passwort']                                                                           ));}
        elseif  ($_REQUEST['mode'] == 'askAlleFragen')      {echo json_encode(FragenVerwaltung::askAlleFragen       ($_SESSION['usermail']                                                                                                      ));}
        elseif  ($_REQUEST['mode'] == 'addFrage')           {echo json_encode(FragenVerwaltung::addFrage            ($_REQUEST['frage'],        $_SESSION['usermail'],      $_REQUEST['kategorie']                                              ));}
        elseif  ($_REQUEST['mode'] == 'getAlleKategorien')  {echo json_encode(FragenVerwaltung::getAlleKategorien   (                                                                                                                           ));}
        elseif  ($_REQUEST['mode'] == 'makeFragebogen')     {echo json_encode(FragenVerwaltung::makeFragebogen      ($_REQUEST['name'],         $_REQUEST['anzahl'],        $_REQUEST['klasse'],        $_REQUEST['fach'],  $_REQUEST['fragen'] ));}
        
        
        
        
        
        
        
        
        
        elseif  ($_REQUEST['mode'] == 'aecd587fdc09')       {echo json_encode(self::hilfe                           (                                                                                                                           ));}
        else{echo json_encode(array('returncode'=>1, 'Returnvalue'=>'<strong>Programmfehler Fehlercode: ##PHPMAIN_aktivierungJS_wv</strong><br>mode-Wert fehlerhaft. $_REQUEST[\'mode\'] = ' . strval($_REQUEST['mode'])));}
    }
    //elseif ($_REQUEST['mode'] == '')  {echo json_encode();}
    
    
    /**
     * @brief Ersetzt Umlaute durch HTML Unicode
     * @param string $string
     * @return string
     */
    public static function toDE
    (
        $string
    )
    {
        $string = str_replace('Ü', '&#220;', $string);
        $string = str_replace('ü', '&#252;', $string);
        $string = str_replace('Ö', '&#214;', $string);
        $string = str_replace('ö', '&#246;', $string);
        $string = str_replace('Ä', '&#196;', $string);
        $string = str_replace('ä', '&#228;', $string);
        $string = str_replace('ß', '&#223;', $string);
        return $string;
    }
    
    public static function hilfe() {
        return array
        (
            'SESSION'=>$_SESSION,
            'GET'=>$_GET,
            'POST'=>$_POST,
            'REQUEST'=>$_REQUEST,
            'COOCKIE'=>$_COOKIE,
            'ENV'=>$_ENV,
            'FILES'=>$_FILES,
            'SERVER'=>$_SERVER
        );
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
    function pass_encode
    (
        $passwort
    ) 
    {
        include 'save.php'; 
        $passwort = hash("sha512", $pepper . $passwort . $salt);
        return $passwort;}
}

class nutzerverwaltung {
    
//     public static function registerUser() // Funktion kann nur mit einem JS aufruf aufgerufen werden. 
//     {
//         try {
//             // abfrage ob sich diese Mailadresse bereits in der Datenbank befindet
//             $result = main::sendSQL("SELECT id FROM lehrer WHERE mail = '" . $_REQUEST['mail'] . "';");
//             if (count($result) == 0) {
//                 $sqlString_InsertNewUser = "
//                     INSERT INTO lehrer (
//                         id, 
//                         mail, 
//                         vorname, 
//                         nachname, 
//                         passwort, 
//                         istroot)
//                     VALUES (
//                         DEFAULT,
//                         '" . $_REQUEST['mail'] . "',
//                         '" . $_REQUEST['vornname'] . "',
//                         '" . $_REQUEST['nachname'] . "',
//                         '" . validation::pass_encode($_REQUEST['passwort']) . "',
//                         FALSE);";
//                 main::sendSQL($sqlString_InsertNewUser);
//                 return array('returncode'=>0, 'returnvalue'=>true);
//             }
//             elseif (count($result) == 1) {return array('returncode'=>-1, 'returnvalue'=>false);}
//             else {return array('returncode'=>1, 'returnvalue'=>'<strong>Datenbankfehler Fehlercode: ##PHPMAIN_registerUser_cue</strong>W&#228;rend der Verarbeitung ist ein Fehler aufgetreten.<br>count($result) = ' . count($result));}
//         } 
//         catch (Exception $e) {return array('returncode'=>1, 'returnvalue'=>'<strong>Unbekannter Fehler Fehlercode: ##PHPMAIN_registerUser_ue</strong>W&#228;rend der Verarbeitung ist ein Fehler aufgetreten.<br><br>' . $e);}
//     }
    
    public static function loginUser
    (
        $mail,
        $passwort
    )
    {
        $passwort = validation::pass_encode($passwort);
        global $link;
        try {
            $sqlquary_FrageBenutzer = "SELECT isroot FROM lehrer WHERE mail = '" . $mail . "' AND passwort = '" . $passwort . "';";
            $sqlquary_FrageBenutzer_Result = mysqli_query($link, $sqlquary_FrageBenutzer);
            if ($sqlquary_FrageBenutzer_Result->num_rows == 1) {
                $sqlquary_FrageBenutzer_Result_Array = mysqli_fetch_array($sqlquary_FrageBenutzer_Result);
                $_SESSION['usermail'] = $_REQUEST['mail'];
                if ($sqlquary_FrageBenutzer_Result_Array['isroot'] == 1){$_SESSION['userisroot'] = true;}
                else{$_SESSION['userisroot'] = false;}
                return array ('returncode'=>0, 'returnvalue'=>true);
            }
            elseif ($sqlquary_FrageBenutzer_Result->num_rows == 0) {
                return array('returncode'=>-1, 'Returnvalue'=>false);
            }
            elseif ($sqlquary_FrageBenutzer_Result->num_rows > 1)
            {
                return array('returncode'=>1, 'Returnvalue'=>'<strong>Datenbankfehler Fehlercode: ##PHPMAIN_loginUser_tma</strong><br>Der Account mit der Mailadresse ' . $mail . ' befindet sich mehrmals in der Datenbank.');
            }
            elseif ($sqlquary_FrageBenutzer_Result->num_rows < 0)
            {
                return array('returncode'=>2, 'Returnvalue'=>'<strong>SQL Quary Fehler Fehlercode: ##PHPMAIN_loginUser_tla</strong><br>Das z&#228;hlen der SQL Resultate ergab einen negativen Wert.');
            }
            else 
            {
                return array ('returncode'=>3, 'Returnvalue'=>'<strong>Unbekannter Fehler Fehlercode: ##PHPMAIN_loginUser_cue</strong><br>Beim auswerten des SQL Ergebnisse ist ein Fehler aufgetreten.');
            }
        } 
        catch (Exception $e) 
        {
            return array ('returncode'=>4, 'Returnvalue'=>'<strong>Unbekannter Fehler Fehlercode: ##PHPMAIN_loginUser_ue</strong><br>Bei der ausf&#252;rung der Funktion ist folgender Fehler aufgetreten:<br><br>' . $e);
        }
    }

//     public static function changePassword() // Funktion kann nur mit einem JS aufruf aufgerufen werden. 
//     {
//         try {
//             $result = main::sendSQL("SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] . "' AND passwort = '" . validation::pass_encode($_REQUEST['oldpasswort']) . "';");
//             if (count($result) == 1){
//                 $sqlString_ChangePassword = "UPDATE lehrer SET passwort = '" . validation::pass_encode($_REQUEST['newpasswort']) . "' WHERE mail = '" . $_SESSION['usermail'] . "';";
//                 main::sendSQL($sqlString_ChangePassword);
//                 return array('returncode'=>0, 'returnvalue'=>true);
//             }
//             elseif (count($result) == 0) {
//                 return array('returncode'=>-1, 'returnvalue'=>false);
//             }
//             else {
//                 return array('returncode'=>1, 'returnvalue'=>'<strong>Datenbankfehler Fehlercode: ##PHPMAIN_changePassword_cue</strong>W&#228;rend der Verarbeitung ist ein Fehler aufgetreten.<br>count($result) = ' . count($result));
//             }
//         } catch (Exception $e) {
//             return array ('returncode'=>2, 'Returnvalue'=>'<strong>Unbekannter Fehler Fehlercode: ##PHPMAIN_loginUser_ue</strong><br>Bei der ausf&#252;rung der Funktion ist folgender Fehler aufgetreten:<br><br>' . $e);
//         }
//     }
}

class FragenVerwaltung {
    
    public static function addFrage
    (
        $frage,
        $mail,
        $kategorie
    )
    {
        global $link;
        $sqlquary_SucheFrage = "SELECT * FROM fragen WHERE frage = '" . $frage . "' AND (lehrerid IS NULL OR lehrerid = (SELECT id FROM lehrer WHERE mail = '" . $mail . "'));";
        $sqlquary_SucheFrage_Result = mysqli_query($link, $sqlquary_SucheFrage);
        if ($sqlquary_SucheFrage_Result->num_rows == 0) {
            $sqlquary_InsertFrage = "INSERT INTO fragen (id, frage, kategorie, lehrerid) VALUES (DEFAULT, '" . $frage . "', '" . $kategorie . "', (SELECT id FROM lehrer WHERE mail = '" . $mail . "'));";
            $sqlquary_InsertFrage_Result = mysqli_query($link, $sqlquary_InsertFrage);
            if ($sqlquary_InsertFrage_Result) {
                return array
                (
                    'returncode' =>0,
                    'returnvalue'=>'<strong style="color:green;">Die Frage wurde erfolgreich gespeichert.</strong>'
                );
            }
            
        }
        else 
        {
            return array
            (
                'returncode' =>-1,
                'returnvalue'=>'<strong style="color:red;">Die Frage befand sich bereits in der Datenbank.</strong>'
            );
        }
    }
    
    public static function askAlleFragen
    (
        $mail
    ) 
    {
        try 
        {
            global $link;
            $sqlquary_AlleFragen_Result_Data = array();
            $sqlquary_AlleFragen = "SELECT frage, kategorie FROM fragen WHERE lehrerid = (SELECT id FROM lehrer WHERE mail = '" . $mail ."') OR lehrerid IS NULL;";
            $sqlquary_AlleFragen_Result = mysqli_query($link, $sqlquary_AlleFragen);
            for ($i = 0; $i < $sqlquary_AlleFragen_Result->num_rows; $i++) {
                $sqlquary_AlleFragen_Result_Data[$i] = mysqli_fetch_array($sqlquary_AlleFragen_Result);
                $sqlquary_AlleFragen_Result_Data[$i]['frage'] = main::toDE($sqlquary_AlleFragen_Result_Data[$i]['frage']);
                $sqlquary_AlleFragen_Result_Data[$i]['kategorie'] = main::toDE($sqlquary_AlleFragen_Result_Data[$i]['kategorie']);
                $sqlquary_AlleFragen_Result_Data[$i][0] = main::toDE($sqlquary_AlleFragen_Result_Data[$i][0]);
                $sqlquary_AlleFragen_Result_Data[$i][1] = main::toDE($sqlquary_AlleFragen_Result_Data[$i][1]);
            }
            $kategorien = self::getAlleKategorien();
            if ($kategorien['returncode'] == 0){
                return array(
                    'returncode'=>0,
                    'returnvalue'=>array(
                        $kategorien['returnvalue'],
                        $sqlquary_AlleFragen_Result_Data
                    )
                );
            }
            else {
                return array
            (
                'returncode'=>1,
                'returnvalue'=>$kategorien['returnvalue']
            );
            }
        } 
        catch (Exception $e) 
        {
            return array
            (
                'returncode'=>1,
                'returnvalue'=>$e
            );
        };
    }
    
    public static function getAlleKategorien
    (
    )
    {
        try 
        {
            global $link;
            $sqlquary_AlleKategorien_Result_Data = array();
            $sqlquary_AlleKategorien = "SELECT kategorie FROM fragen GROUP BY kategorie";
            $sqlquary_AlleKategorien_Result = mysqli_query($link, $sqlquary_AlleKategorien);
            for ($i = 0; $i < $sqlquary_AlleKategorien_Result->num_rows; $i++) {
                $sqlquary_AlleKategorien_Result_Data[$i] = mysqli_fetch_array($sqlquary_AlleKategorien_Result);
            }
            return array
            (
                'returncode'=>0,
                'returnvalue'=>$sqlquary_AlleKategorien_Result_Data
            );
        }
        catch (Exception $e) 
        {
            return array
            (
                'returncode'=>1,
                'returnvalue'=>$e
            );
        };
    }

    public static function makeFragebogen
    (
        $name,
        $anzahl,
        $klasse,
        $fach,
        $fragen
    ) 
    {
        $sqlstring_MakeFragebogen = "
INSERT INTO fragebogen 
(
    zeitstempel, 
    id, 
    name, 
    schueleranzahl, 
    klassename,
    fachid, 
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
)";
        global $link;
        $sqlstring_MakeFragebogen_Result = mysqli_query($link, $sqlstring_MakeFragebogen);
        if (!$sqlstring_MakeFragebogen_Result) {
            return array
            (
                'returncode'=>-1,
                'returnvalue'=>'Konnte Fragebogen nicht erstellen.'
            );
        }
        $sqlstring_MakeFragebogen_Result_Data = mysqli_fetch_array($sqlstring_MakeFragebogen_Result);
        var_dump($sqlstring_MakeFragebogen_Result_Data);
        
//         $sqlstring_InsertFragebogen = "INSERT INTO nm_frage_fragebogen (bogenid, fragenid) VALUES";
//         for ($i = 0; $i < $_REQUEST['fragen']; $i++) {
//             $sqlstring_InsertFragebogen .= "(" . $fragebogenID . ", (SELECT id FROM fragen WHERE frage = " . $_REQUEST['fragen'][$i] . " AND lehrerid = (SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] ."'))";
//         }
//         $sqlstring_InsertFragebogen .= ";";
//         main::sendSQL($sqlstring_InsertFragebogen);
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
}

if (isset($_REQUEST['mode'])){main::aktivierungJS();}
//////////////////////////////////////////  DEBUG  /////////////////////////////////////////////
// session_unset();

// $_SESSION['usermail']       = 'temp.dump@hotmail.com';

// $_REQUEST['mode']           = 'askAlleFragen';

// $_REQUEST['frage']          = 'Tafelbilder und Folien sind gut lesbar.';
// $_REQUEST['mail']           = 'temp.dump@hotmail.com';
// $_REQUEST['passwort']       = 'Admin';
// $_REQUEST['kategorie']      = 'Unterricht';
// $_REQUEST['name']           = 'BogenX';
// $_REQUEST['anzahl']         = '10';
// $_REQUEST['klasse']         = 'ITB1-19';
// $_REQUEST['fach']           = 'ITS';
// $_REQUEST['fragen']         = array('Tafelbilder und Folien sind gut lesbar.', 'Die Unterrichtsinhalte sind praxisbezogen.');


// $fun = new main();
// $fun->aktivierungJS();