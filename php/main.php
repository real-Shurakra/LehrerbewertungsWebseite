<?php
include 'database_connect.php'; session_start();



class main {
    
    function aktivierungJS() {
        if      ($_REQUEST['mode'] == 'loginUser')          {echo json_encode(nutzerverwaltung::loginUser           ($_REQUEST['mail'],         $_REQUEST['passwort']                                                                           ));}
        elseif  ($_REQUEST['mode'] == 'askAlleFragen')      {echo json_encode(FragenVerwaltung::askAlleFragen       ($_SESSION['usermail']                                                                                                      ));}
        elseif  ($_REQUEST['mode'] == 'addFrage')           {echo json_encode(FragenVerwaltung::addFrage            ($_REQUEST['frage'],        $_SESSION['usermail'],      $_REQUEST['kategorie']                                              ));}
        elseif  ($_REQUEST['mode'] == 'getAlleKategorien')  {echo json_encode(FragenVerwaltung::getAlleKategorien   (                                                                                                                           ));}
        elseif  ($_REQUEST['mode'] == 'makeFragebogen')     {echo json_encode(FragenVerwaltung::makeFragebogen      ($_REQUEST['name'],         $_REQUEST['anzahl'],        $_REQUEST['klasse'],        $_REQUEST['fach'],  $_REQUEST['fragen'] ));}
        elseif  ($_REQUEST['mode'] == 'getFragebogens')     {echo json_encode(FragenVerwaltung::getFragebogens      (                                                                                                                           ));}
        elseif  ($_REQUEST['mode'] == 'getCodes')           {echo json_encode(FragenVerwaltung::getCodes            ($_REQUEST['fbId']                                                                                                          ));}
        
        
        
        
        
        
        
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
        $string = str_replace('�', '&#220;', $string);
        $string = str_replace('�', '&#252;', $string);
        $string = str_replace('�', '&#214;', $string);
        $string = str_replace('�', '&#246;', $string);
        $string = str_replace('�', '&#196;', $string);
        $string = str_replace('�', '&#228;', $string);
        $string = str_replace('�', '&#223;', $string);
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
       
    public static function checkSemicolon($var)
    {
        if (is_string($var))
        {
            return str_replace(';', '', $var);
        }
        elseif (is_array($var))
        {
            $var_Keys = array_keys($var);
            for ($i = 0; $i < count($var); $i++) {
                $var[$var_Keys[$i]] = self::checkSemicolon($var[$var_Keys[$i]]);
            }
            return $var;
        }
        else
        {
            return $var;
        }
    }
}

class validation {
    /**
     * @brief Encode des Passworts
     * @details 
     * @param string $passwort =  String mit zu verschluessendem Inhalt
     * @return string $antwort = Sha512 verschluesselter String
     * @note In der Datei 'save.php' stehen die Variablen die bei der Verschl�sselnug ben�tigt werden.
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
}

class FragenVerwaltung {
    
    public static function addFrage ($frage, $mail, $kategorie) {
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
    
    public static function askAlleFragen ($mail) {
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
    
    public static function getAlleKategorien () {
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

    public static function makeFragebogen ($name, $anzahl, $klasse, $fach, $fragen)  {
        $sqlstring_MakeFragebogen = "
            INSERT INTO fragebogen 
            (
                zeitstempel, 
                id, 
                name, 
                schueleranzahl, 
                klassename,
                fachid, 
                lehrerid
            )
            VALUES
            (
                CURRENT_TIMESTAMP,
                DEFAULT,
                '" . $name ."', 
                '" . $anzahl ."',
                '" . $klasse ."',
                (SELECT id FROM fach WHERE name = '" . $fach ."'),
                (SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] ."')
            );";
        global $link;
        $sqlstring_MakeFragebogen_Result = mysqli_query($link, $sqlstring_MakeFragebogen);
        if (!$sqlstring_MakeFragebogen_Result) {
            $antwort = array
            (
                'returncode'=>-1,
                'returnvalue'=>'<strong>Fehler</strong><br>Konnte Fragebogen nicht erstellen.'
            );
        }
        else{
            $sqlquery_GetLastFbId = "SELECT MAX(id) FROM fragebogen WHERE `lehrerid` = (SELECT id FROM lehrer WHERE mail = 'temp.dump@hotmail.com');";
            $sqlquery_GetLastFbId_Result = mysqli_query($link, $sqlquery_GetLastFbId);
            $sqlquery_GetLastFbId_Result_Data = mysqli_fetch_array($sqlquery_GetLastFbId_Result);
            $fbId = $sqlquery_GetLastFbId_Result_Data['MAX(id)'];
            $row_sqlquery_InsertFbFragen = "INSERT INTO nm_frage_fragebogen (bogenid, frageid) VALUES";
            for ($i = 0; $i < count($fragen); $i++) {
                $row_sqlquery_InsertFbFragen .= "
                    (" . $fbId . ", 
                    (   
                        SELECT id FROM fragen WHERE 
                            (
                                frage = '" . $fragen[$i] ."' 
                                AND 
                                lehrerid = 
                                ( 
                                    SELECT id 
                                    FROM lehrer 
                                    WHERE mail = '" . $_SESSION['usermail'] ."' 
                                ) 
                            )
                            OR
                            (
                                frage = '" . $fragen[$i] ."' 
                                AND 
                                lehrerid IS NULL)
                        )
                    ),";
            }
            $sqlquery_InsertFbFragen = rtrim($row_sqlquery_InsertFbFragen, ",");
            $sqlquery_InsertFbFragen .= ";";
            mysqli_query($link, $sqlquery_InsertFbFragen);
            if (self::genCodes($anzahl, $fbId) == 1){
                $antwort = array(
                    'retruncode' => 1,
                    'returnvalue' => '<strong>WARNUNG!</strong><br>Die maximale Anzahl an Codes ist bereits erreicht.'
                );
            }
            $antwort = array(
                'retruncode' => 0,
                'returnvalue' => '<strong>Erfolg.</strong><br>Fragebogen angelegt.'
            );
        }
        return $antwort; 
    }
    
    function genCodes($anz, $fbid) {
        global $link;
        for ($i = 0; $i < $anz; $i++) {
            $memcode = array();
            $counter = 0;
            while (true) {
                $memcode = array();
                $code = self::genNumber() . '-' . self::genNumber() . '-' . self::genNumber() . '-' . self::genNumber();
                if (in_array($code, $memcode)){
                    array_push($memcode, $code);
                    continue;
                }
                array_push($memcode, $code);
                $test = mysqli_query($link, "SELECT * FROM codes WHERE codehash = '" . $code . "'");
                if ($test->num_rows == 0){
                    mysqli_query($link, "INSERT INTO codes (codehash, fragebogenid) VALUES ('" . $code . "', " . $fbid . ");");
                    break;
                }
                else{
                    if ($counter == 100000000){
                        return 1;
                        break;
                    }
                    $counter++;
                    continue;
                }
            }
        }
    }
    
    function genNumber () {
        $numb = random_int(0, 99);
        if ($numb <= 9){
            $numb = '0' . $numb;
        }
        return $numb;
    }
    
    public static function getFragebogens () {
        global $link;
        $sqlquery_GetFragebogens = "SELECT `id`,`zeitstempel`,`name`,`fach`,`klassename`,`schueleranzahl` FROM `getfragebogen` WHERE lehrerid = (SELECT lehrer.id FROM lehrer WHERE lehrer.mail = '" . $_SESSION['usermail'] ."')";
        $sqlquery_GetFragebogens_Result = mysqli_query($link, $sqlquery_GetFragebogens);
        for ($i = 0; $i < $sqlquery_GetFragebogens_Result->num_rows; $i++) {
            $sqlquery_GetFragebogens_Result_Data[$i] = mysqli_fetch_array($sqlquery_GetFragebogens_Result);
        }
        $sqlquery_GetFBAnswers = "SELECT bogenid, bewertung FROM bewertungen";
        $sqlquery_GetFBAnswers_Result = mysqli_query($link, $sqlquery_GetFBAnswers);
        if ($sqlquery_GetFBAnswers_Result['num_rows'] == 0){
            $antwort = $sqlquery_GetFragebogens_Result_Data;
            for ($i=0; $i < count($antwort; $i++) { 
                
                $antwort[$i]->append(array('punkzahl'=>0))
                $antwort[$i]->append(array('punkzahl'=>0))
            }
            return ;
        };
        for ($i=0; $i < count($sqlquery_GetFBAnswers_Result); $i++) { 
            $sqlquery_GetFBAnswers_Result_Data[$i] = mysqli_fetch_array($sqlquery_GetFBAnswers_Result);
        }
        var_dump(key($sqlquery_GetFragebogens_Result_Data[0]['id']));

        //for count($sqlquery_GetFragebogens_Result_Data){
        //    
        //}
        return $sqlquery_GetFragebogens_Result_Data;
        
    }

    public static function getCodes ($fbId) {
        global $link;
        $sqlquery_GetCodes = "SELECT codehash FROM codes WHERE fragebogenid = '" . $fbId . "'";
        $sqlquery_GetCodes_Result = mysqli_query($link, $sqlquery_GetCodes);
        for ($i = 0; $i < $sqlquery_GetCodes_Result->num_rows; $i++) {
            $sqlquery_GetCodes_Result_Data[$i] = mysqli_fetch_array($sqlquery_GetCodes_Result);
        }
        return $sqlquery_GetCodes_Result_Data;
    }
}


//////////////////////////////////////////  DEBUG  /////////////////////////////////////////////
session_unset();
$_SESSION['usermail']       = 'temp.dump@hotmail.com';
$_REQUEST['mode']           = 'getFragebogens';
$_REQUEST['frage']          = 'Tafelbilder und Folien sind gut lesbar.';
$_REQUEST['mail']           = 'temp.dump@hotmail.com';
$_REQUEST['passwort']       = 'Admin';
$_REQUEST['kategorie']      = 'Unterricht';
$_REQUEST['name']           = 'BogenX';
$_REQUEST['anzahl']         = '1';
$_REQUEST['klasse']         = 'ITB1-19';
$_REQUEST['fach']           = 'ITS';
$_REQUEST['fbId']           = '80';
$_REQUEST['fragen']         = array('Die Beurteilungskriterien sind nachvollziehbar.', 'Die Unterrichtsinhalte sind praxisbezogen.');
//////////////////////////////////////////  DEBUG END  /////////////////////////////////////////

if (isset($_REQUEST['mode'])){
    $_REQUEST = main::checkSemicolon($_REQUEST);
    $jsablauf = new main();
    $jsablauf->aktivierungJS();
}

