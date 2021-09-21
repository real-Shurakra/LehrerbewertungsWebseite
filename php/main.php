<?php

use FFI\Exception;

include 'database_connect.php'; session_start();



class main {

    function __construct(){
        $_REQUEST = self::checkSemicolon($_REQUEST);
        switch ($_REQUEST['mode']) {
            ## Modes for "nutzerverwaltung
            case  'loginUser':                                                  echo json_encode(nutzerverwaltung::loginUser($_REQUEST['mail'], $_REQUEST['passwort']));break;
            case  'changePasswort':         if ($_SESSION['usermail'] != NULL) {echo json_encode(nutzerverwaltung::changePasswort($_REQUEST['oldPasswort'], $_REQUEST['newPasswort']));}break;
            case  'addUser':                                                    echo json_encode(nutzerverwaltung::addUser($_REQUEST['mail'], $_REQUEST['firstname'], $_REQUEST['lastname']));break;
            case  'checkPermission':                                            echo json_encode(nutzerverwaltung::checkPermission($_REQUEST['passwort']));break;
            case  'deleteUser':             if ($_SESSION['usermail'] != NULL) {echo json_encode(nutzerverwaltung::deleteUser($_REQUEST['passwort'], $_REQUEST['mail']));}break;
            ## Modes for FragenVerwaltung
            case  'askAlleFragen':          if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::askAlleFragen($_SESSION['usermail']));}break;
            case  'addFrage':               if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::addFrage($_REQUEST['frage'], $_SESSION['usermail'], $_REQUEST['kategorie']));}break;
            case  'getAlleKategorien':      if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::getAlleKategorien());}break;
            case  'makeFragebogen':         if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::makeFragebogen($_REQUEST['name'], $_REQUEST['anzahl'], $_REQUEST['klasse'], $_REQUEST['fach'], $_REQUEST['fragen']));}break;
            case  'getFragebogens':         if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::getFragebogens());}break;
            case  'getCodes':               if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::getCodes($_REQUEST['fbId']));}break;
            case  'getFbFragen':            if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::getFbFragen($_REQUEST['fbId']));}break;
            case  'insertRate':                                                 echo json_encode(FragenVerwaltung::insertRate($_REQUEST['rate'], $_REQUEST['codehash']));break;
            case  'insertkritik':                                               echo json_encode(FragenVerwaltung::insertkritik($_REQUEST['fbId'], $_REQUEST['kritik'], $_REQUEST['codehash']));break;
            case  'getkritik':              if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::getkritik($_REQUEST['fbId']));}break;
            case  'getAlleSchulklassen':    if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::getAlleSchulklassen());}break;
            case  'getAllSubjects':         if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::getAllSubjects());}break;
            case  'getFbFragenFromCode':                                        echo json_encode(FragenVerwaltung::getFbFragenFromCode($_REQUEST['codehash']));break;
            case  'alterQuestion':          if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::alterQuestion($_REQUEST['frageId'], $_REQUEST['neuFrage']));}break;
            case  'delQuestionnaire':       if ($_SESSION['usermail'] != Null) {echo json_encode(FragenVerwaltung::delQuestionnaire($_REQUEST['fbId']));}break;
            case  'deleteAllCodes':         if ($_SESSION['usermail'] != NULL) {echo json_encode(FragenVerwaltung::deleteAllCodes($_REQUEST['fbId']));}break;
            case  'getQuestions':           if ($_SESSION['usermail'] != NULL) {echo json_encode(FragenVerwaltung::getQuestions());break;}
            ## Other modes
            case  'aecd587fdc09':                                               echo json_encode(self::hilfe());
            default:                                                            echo json_encode(array('returncode'=>1, 'Returnvalue'=>'<strong>Programmfehler Fehlercode: ##PHPMAIN_aktivierungJS_wv</strong><br>mode-Wert fehlerhaft. $_REQUEST[\'mode\'] = ' . strval($_REQUEST['mode'])));break;
        }
    }

    /**
     * @brief Ersetzt Umlaute durch HTML Unicode
     * @param string $string
     * @return string
     */
    public static function toDE($string) {
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
       
    static function checkSemicolon($var) {
        
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
    static function pass_encode($passwort) {
        include 'save.php'; 
        $passwort = hash("sha512", $pepper . $passwort . $salt);
        return $passwort;}
}

class nutzerverwaltung {
    
    public static function loginUser($mail, $passwort) {
        try {
            $answer = array(
                'returncode'=>false,
                'returnvalue'=>'<strong>Unknown Error</strong>
                                <br>Unbekannter Fehler in /php/main.php -> nutzerverwaaltung.loginUser()<br>
                                Bitte wenden Sie sich an einen Administrator.'
            );
            $passwort = validation::pass_encode($passwort);
            global $link;
            $sqlquary_FrageBenutzer = "SELECT isroot FROM lehrer WHERE mail = '" . $mail . "' AND passwort = '" . $passwort . "';";
            $sqlquary_FrageBenutzer_Result = mysqli_query($link, $sqlquary_FrageBenutzer);
            if (!$sqlquary_FrageBenutzer_Result) {throw new Exception('Es ist ein SQL-Fehler aufgetreten.');}
            if ($sqlquary_FrageBenutzer_Result->num_rows == 1) {
                $sqlquary_FrageBenutzer_Result_Array = mysqli_fetch_array($sqlquary_FrageBenutzer_Result);
                $_SESSION['usermail'] = $_REQUEST['mail'];
                if ($sqlquary_FrageBenutzer_Result_Array['isroot'] == 1){$_SESSION['userisroot'] = true;}
                else{$_SESSION['userisroot'] = false;}
                $answer =  array ('returncode'=>true, 'returnvalue'=>true);
            }
            elseif ($sqlquary_FrageBenutzer_Result->num_rows == 0) {$answer =  array('returncode'=>true,'Returnvalue'=>false);}
            elseif ($sqlquary_FrageBenutzer_Result->num_rows > 1) {throw new Exception('Der Account mit der Mailadresse '.$mail.' befindet sich mehrmals in der Datenbank.');}
            elseif ($sqlquary_FrageBenutzer_Result->num_rows < 0) {throw new Exception('Das z&#228;hlen der SQL Resultate ergab einen negativen Wert.');}
            else {throw new Exception('Beim auswerten des SQL Ergebnisse ist ein Fehler aufgetreten.');}
        } 
        catch (Exception $error) {
             $answer = array (
                'returncode'=>false, 
                'Returnvalue'=>'<strong>Error!</strong><br>'.$error.'<br>Bitte wenden Sie sich an einen Administrator');
        }
        finally{
            return $answer;
        }
    }

    public static function addUser($mail, $firstname, $lastname){
        try{
            $answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.deleteQuestion()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            ## User register
            $sqlquery_addUser = "
            INSERT INTO lehrer(id, mail, vorname, nachname, passwort, isroot) 
            VALUES (DEFAULT,'".$mail."','".$firstname."','".$lastname."',Default,FALSE);

            SELECT @userid := id FROM lehrer WHERE mail = '".$mail."';

            INSERT INTO fragen(frage, kategorie, lehrerid) 
            SELECT frage, kategorie, @userid FROM fragentemplate;";
            $sqlResult = mysqli_query($link, $sqlquery_addUser);
            if ($sqlResult == False) throw new Exception('<strong>SQL-Error at nutzerverwaltung.addUser()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            
            $answer = array(
                'rc' => true,
                'rv' => '<strong>Neuer Benutzer angelegt</strong><br>Nutzername: '.$mail.'<br>Passwort: Admin'
            );
        }catch(Exception $error){
            $answer = array(
                'rc' => false,
                'rv' => $error
            );
        }finally{
            return $answer;
        }
    }

    public static function changePasswort($oldPasswort, $newPasswort){
        if (self::checkPermission($oldPasswort)['rc'] <= 0) {throw new Exception('<strong>Permission denied!</strong><br>Sie haben keine Zugriffsberechtigung.');}
        try{
            $answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.deleteQuestion()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            $sqlquery_addUser = "UPDATE lehrer SET passwort=".validation::pass_encode($newPasswort)." WHERE mail = ".$_SESSION['usermail'].";";
            $sqlResult = mysqli_query($link, $sqlquery_addUser);
            if ($sqlResult == False) throw new Exception('<strong>SQL-Error at nutzerverwaltung.changePasswort()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            
            $answer = array(
                'rc' => true,
                'rv' => '<strong>Erfolgreich</strong><br>Ihr Passwort wurde gändert.'
            );
        }catch(Exception $error){
            $answer = array(
                'rc' => false,
                'rv' => $error
            );
        }finally{
            return $answer;
        }
    }

    public static function checkPermission($Password){
        $Password = validation::pass_encode($Password);
        try{
            $answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.deleteQuestion()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            ## User register
            $sqlquery_addUser = "SELECT isroot FROM lehrer WHERE passwort = ".$Password." AND mail = ".$_SESSION['usermail'].";";
            $sqlResult = mysqli_query($link, $sqlquery_addUser);
            if ($sqlResult == False) throw new Exception('<strong>SQL-Error at nutzerverwaltung.checkPermission() #1</strong><br>Bitte wenden Sie sich an einen Administrator.');
            if ($sqlResult->num_rows != 1) throw new Exception('<strong>Permission denied!</strong><br>Sie haben keine Zugriffsberechtigung.');
            for ($i = 0; $i < $sqlResult->num_rows; $i++) {
                $sqlResult_Data[$i] = mysqli_fetch_array($sqlResult);
            }
            if ($sqlResult_Data[0][0]) {$answer = array('rc'=>-1, 'rv'=>NULL);}
            else                       {$answer = array('rc'=> 0, 'rv'=>NULL);}
        }catch(Exception $error){
            $answer = array(
                'rc' => 1,
                'rv' => $error
            );
        }finally{
            return $answer;
        }
    }

    public static function deleteUser($rootPassword, $userMail) {
        try{
            $answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.deleteQuestion()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            ## Check permission
            if (self::checkPermission($rootPassword)['rc'] != -1) {throw new Exception('<strong>Permission denied!</strong><br>Sie haben keine Zugriffsberechtigung.');}
            $sqlquery_addUser = "
            SELECT @userid := id FROM lehrer WHERE mail = '".$userMail."';

            DELETE nm_frage_fragebogen FROM nm_frage_fragebogen LEFT JOIN fragebogen ON nm_frage_fragebogen.bogenid = fragebogen.id WHERE lehrerid = @userid;
            DELETE bewertungen FROM bewertungen LEFT JOIN fragebogen ON bewertungen.bogenid = fragebogen.id WHERE lehrerid = @userid;
            DELETE nm_frage_fragebogen FROM nm_frage_fragebogen LEFT JOIN  fragebogen ON nm_frage_fragebogen.bogenid = fragebogen.id WHERE lehrerid = @userid;
            DELETE verbesserungen FROM verbesserungen LEFT JOIN fragebogen ON verbesserungen.bogenid = fragebogen.id WHERE lehrerid = @userid;
            DELETE codes FROM codes LEFT JOIN fragebogen ON codes.fragebogenid = fragebogen.id WHERE lehrerid = @userid;
            DELETE FROM fragebogen WHERE lehrerid = @userid;
            DELETE FROM fragen WHERE lehrerid = @userid;
            DELETE FROM lehrer WHERE id = @userid;";
            $sqlResult = mysqli_query($link, $sqlquery_addUser);
            if ($sqlResult == False) throw new Exception('<strong>SQL-Error at nutzerverwaltung.deleteUser()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            
            $answer = array(
                'rc' => true,
                'rv' => '<strong>Erfolgreich</strong><br>Ihr Passwort wurde gändert.'
            );
        }catch(Exception $error){
            $answer = array(
                'rc' => false,
                'rv' => $error
            );
        }finally{
            return $answer;
        }
    }
}

class FragenVerwaltung {
    
    public static function addFrage($frage, $mail, $kategorie) {
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
    
    public static function askAlleFragen($mail) {
        try 
        {
            global $link;
            $sqlquary_AlleFragen_Result_Data = array();
            $sqlquary_AlleFragen = "SELECT id, frage, kategorie FROM fragen WHERE lehrerid = (SELECT id FROM lehrer WHERE mail = '" . $mail ."') OR lehrerid IS NULL ORDER BY kategorie ASC;";
            //var_dump($sqlquary_AlleFragen);
            //echo('<br><br>');
            $sqlquary_AlleFragen_Result = mysqli_query($link, $sqlquary_AlleFragen);
            //var_dump($sqlquary_AlleFragen_Result);
            //echo('<br><br>');
            $answer = array();
            for ($i = 0; $i < $sqlquary_AlleFragen_Result->num_rows; $i++) {
                $sqlquary_AlleFragen_Result_Data[$i]                = mysqli_fetch_array($sqlquary_AlleFragen_Result);
                $answer[$i]['id']          = main::toDE($sqlquary_AlleFragen_Result_Data[$i]['id']);
                $answer[$i]['frage']       = main::toDE($sqlquary_AlleFragen_Result_Data[$i]['frage']);
                $answer[$i]['kategorie']   = main::toDE($sqlquary_AlleFragen_Result_Data[$i]['kategorie']);
                $answer[$i][0]             = main::toDE($sqlquary_AlleFragen_Result_Data[$i][0]);
                $answer[$i][1]             = main::toDE($sqlquary_AlleFragen_Result_Data[$i][1]);
            }
            
            $kategorien = self::getAlleKategorien();
            if ($kategorien['returncode'] == 0){
                $antwort = array(
                    'returncode'=>0,
                    'returnvalue'=>array(
                        $kategorien['returnvalue'],
                        $answer
                    )
                );
                return $antwort;
            }
            else {
                return array
                (
                    'returncode'=>$kategorien['returncode'],
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
    
    public static function getAlleKategorien() {
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

    public static function makeFragebogen($name, $anzahl, $klasse, $fach, $fragenids)  {
        #var_dump($fragenids);
        $fragen = explode(',', $fragenids);
        $sqlstring_MakeFragebogen = "
            INSERT INTO fragebogen 
            (zeitstempel, id, name, schueleranzahl, klassename, fachid, lehrerid)
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
            $sqlquery_GetLastFbId = "SELECT MAX(id) FROM fragebogen WHERE `lehrerid` = (SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] ."');";
            $sqlquery_GetLastFbId_Result = mysqli_query($link, $sqlquery_GetLastFbId);
            $sqlquery_GetLastFbId_Result_Data = mysqli_fetch_array($sqlquery_GetLastFbId_Result);
            $fbId = $sqlquery_GetLastFbId_Result_Data['MAX(id)'];
            $row_sqlquery_InsertFbFragen = "INSERT INTO nm_frage_fragebogen (bogenid, frageid) VALUES";
            for ($i = 0; $i < count($fragen); $i++) {
                $row_sqlquery_InsertFbFragen .= "
                    (" . $fbId . ", " . $fragen[$i] ."),";
            }
            $sqlquery_InsertFbFragen = rtrim($row_sqlquery_InsertFbFragen, ",");
            $sqlquery_InsertFbFragen .= ";";
            #var_dump($sqlquery_InsertFbFragen);
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
    
    static function genCodes($anz, $fbId) {
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
                    mysqli_query($link, "INSERT INTO codes (codehash, fragebogenid) VALUES ('" . $code . "', " . $fbId . ");");
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
    
    static function genNumber() {
        $numb = random_int(0, 99);
        if ($numb <= 9){
            $numb = '0' . $numb;
        }
        return $numb;
    }
    
    public static function getFragebogens() {
        // hole DB Link
        global $link;
        // Abrufen aller Frageboegen eines Lehrers
        $sqlquery_GetFragebogens = "SELECT * FROM getfragebogen WHERE mail = '" . $_SESSION['usermail'] . "'";
        $sqlquery_GetFragebogens_Result = mysqli_query($link, $sqlquery_GetFragebogens);
        if ($sqlquery_GetFragebogens_Result->num_rows == 0) {
            // Return wenn keine Frageboegen vorhanden sind
            return array(
                'returncode' => -1,
                'returnvalue' => main::toDE('<strong>Keine Bögen</srtong><br>Sie haben bisther keine Fragebögen angelegt.')
            );
        }

        // Wenn Frageboegen vorhanden sind werden diese in ein Array geschrieben
        for ($i = 0; $i < $sqlquery_GetFragebogens_Result->num_rows; $i++) {
            $sqlquery_GetFragebogens_Result_Data[$i] = mysqli_fetch_array($sqlquery_GetFragebogens_Result); // Antwort teil 1: $sqlquery_GetFragebogens_Result_Data
        }

        // Abrufen der Summer aller Antworten der Frageboegen
        $sqlquery_GetBewertungen = "SELECT * FROM getbewertungen WHERE mail = '" . $_SESSION['usermail'] . "'";
        $sqlquery_GetBewertungen_Result = mysqli_query($link, $sqlquery_GetBewertungen);
        for ($i = 0; $i < $sqlquery_GetBewertungen_Result->num_rows; $i++) {
            $sqlquery_GetBewertungen_Result_Data[$i] = mysqli_fetch_array($sqlquery_GetBewertungen_Result); // Antwort teil 2: $sqlquery_GetBewertungen_Result_Data
        }

        // Abrufen der Anzahl an Fragen der Frageboegen
        $sqlquery_GetFragenAnzahl = "SELECT * FROM getfragenanzahl WHERE mail = '" . $_SESSION['usermail'] . "'";
        $sqlquery_GetFragenAnzahl_Result = mysqli_query($link, $sqlquery_GetFragenAnzahl);
        for ($i = 0; $i < $sqlquery_GetFragenAnzahl_Result->num_rows; $i++) {
            $sqlquery_GetFragenAnzahl_Result_Data[$i] = mysqli_fetch_array($sqlquery_GetFragenAnzahl_Result); // Antwort teil 3: $sqlquery_GetFragenAnzahl_Result_Data
        }

        // Zusammenfuegen aller Antwortteile
        if (
            count($sqlquery_GetFragebogens_Result_Data) == count($sqlquery_GetBewertungen_Result_Data) AND
            count($sqlquery_GetBewertungen_Result_Data) == count($sqlquery_GetFragenAnzahl_Result_Data) AND
            count($sqlquery_GetFragebogens_Result_Data) == count($sqlquery_GetFragenAnzahl_Result_Data)
        ) {
            $answer = array();
            for ($i=0; $i < count($sqlquery_GetFragebogens_Result_Data); $i++) { 
                $answer[$i] = array();
                $answer[$i]['id']               = $sqlquery_GetFragebogens_Result_Data[$i]['id'];
                $answer[$i]['name']             = $sqlquery_GetFragebogens_Result_Data[$i]['name'];
                $answer[$i]['zeitstempel']      = $sqlquery_GetFragebogens_Result_Data[$i]['zeitstempel'];
                $answer[$i]['fach']             = $sqlquery_GetFragebogens_Result_Data[$i]['fach'];
                $answer[$i]['klassenname']      = $sqlquery_GetFragebogens_Result_Data[$i]['klassename'];
                $answer[$i]['schueleranzahl']   = $sqlquery_GetFragebogens_Result_Data[$i]['schueleranzahl'];
                for ($i2=0; $i2 < count($sqlquery_GetBewertungen_Result_Data); $i2++) { 
                    if ($sqlquery_GetBewertungen_Result_Data[$i2]['id'] == $answer[$i]['id']) {
                        $answer[$i]['bewertungsumme'] = $sqlquery_GetBewertungen_Result_Data[$i2]['sum(bewertungen.bewertung)'];
                    }
                }
                for ($i2=0; $i2 < count($sqlquery_GetFragenAnzahl_Result_Data); $i2++) { 
                    if ($sqlquery_GetFragenAnzahl_Result_Data[$i2]['id'] == $answer[$i]['id']) {
                        $answer[$i]['anzfragen'] = $sqlquery_GetFragenAnzahl_Result_Data[$i2]['count(nm_frage_fragebogen.frageid)'];
                    }
                }
            }
        }
        return $answer;
    }

    public static function getCodes($fbId) {
        global $link;
        $sqlquery_GetCodes = "SELECT codehash FROM codes WHERE fragebogenid = '" . $fbId . "'";
        $sqlquery_GetCodes_Result = mysqli_query($link, $sqlquery_GetCodes);
        if($sqlquery_GetCodes_Result->num_rows == 0){
            return array(
                'retruncode' => -1,
                'returnvalue' =>'<strong>Keine Codes vorhanden</strong>Bitte geben Sie den Fragebogen frei um die Codes erzeugen zu lassen'
            );
        }
        for ($i = 0; $i < $sqlquery_GetCodes_Result->num_rows; $i++) {
            $sqlquery_GetCodes_Result_Data[$i] = mysqli_fetch_array($sqlquery_GetCodes_Result);
        }
        return array(
            'retruncode' => 0,
            'returnvalue' => $sqlquery_GetCodes_Result_Data
        ) ;
    }

    public static function getFbFragen($fbId, $code=False) {
        try{
            global $link;
            if($code == False){
                $fbId = "'" . $fbId . "'";
            }
            $sqlquery_GetFbFragen = "SELECT * FROM getfbfragen WHERE bogenid = " . $fbId . " ORDER BY `getfbfragen`.`kategorie` ASC, `getfbfragen`.`frage` ASC;";
            $sqlquery_GetFbFragen_Result = mysqli_query($link, $sqlquery_GetFbFragen);
            if ($sqlquery_GetFbFragen_Result == FALSE){
                return array(
                    'returncode'=>1,
                    'returnvalue'=>main::toDE('<strong>SQL-Fehler.</strong><br>Der SQL-String von getFbFragen()-$sqlquery_GetFbFragen ist fehlerhaft.')
                );
            }
            if ($sqlquery_GetFbFragen_Result->num_rows == 0) {
                return array(
                    'returncode'=>-1,
                    'returnvalue'=>main::toDE('<strong>Keine Fragen gefunden.</strong><br>Es befinden sich keine Fragen in diesem Fragebogen.')
                );
            }
            $antwort = array();
            for ($i = 0; $i < $sqlquery_GetFbFragen_Result->num_rows; $i++) {
                $sqlquery_GetFbFragen_Result_Data[$i] = mysqli_fetch_array($sqlquery_GetFbFragen_Result);
                array_push($antwort, array('frageid'=>$sqlquery_GetFbFragen_Result_Data[$i]['frageid'], 
                                           array('fragestring'      =>  $sqlquery_GetFbFragen_Result_Data[$i]['frage'],
                                                 'fragekategorie'   =>  $sqlquery_GetFbFragen_Result_Data[$i]['kategorie'],
                                                 'fragebewertung'   =>  $sqlquery_GetFbFragen_Result_Data[$i]['bewertung'],
                                                 'zeitstempel'      =>  $sqlquery_GetFbFragen_Result_Data[$i]['zeitstempel'],
                                                 'thema'            =>  $sqlquery_GetFbFragen_Result_Data[$i]['thema'],
                                                 'klassename'       =>  $sqlquery_GetFbFragen_Result_Data[$i]['klassename'],
                                                 'fachname'         =>  $sqlquery_GetFbFragen_Result_Data[$i]['fachname'],
                                                 'bogenid'          =>  $sqlquery_GetFbFragen_Result_Data[$i]['bogenid'],
                                                 '-2'               =>  $sqlquery_GetFbFragen_Result_Data[$i]['bew110'],
                                                 '-1'               =>  $sqlquery_GetFbFragen_Result_Data[$i]['bew101'],
                                                 '0'                =>  $sqlquery_GetFbFragen_Result_Data[$i]['bew000'],
                                                 '1'                =>  $sqlquery_GetFbFragen_Result_Data[$i]['bew001'],
                                                 '2'                =>  $sqlquery_GetFbFragen_Result_Data[$i]['bew010']
                                                )
                                          )
                          );
            }
            $antwort['zeitstempel']      =  $sqlquery_GetFbFragen_Result_Data[0]['zeitstempel'];
            $antwort['thema']            =  $sqlquery_GetFbFragen_Result_Data[0]['thema'];
            $antwort['klassename']       =  $sqlquery_GetFbFragen_Result_Data[0]['klassename'];
            $antwort['fachname']         =  $sqlquery_GetFbFragen_Result_Data[0]['fachname'];
            $antwort['bogenid']          =  $sqlquery_GetFbFragen_Result_Data[0]['bogenid'];
            return array(
                'returncode'=>0,
                'returnvalue'=>$antwort
            );
        }
        catch(Exception $e){
            return array(
                'returncode'=>1,
                'returnvalue'=>main::toDE('<strong>Programmfehler</strong><br>Bitte melden Sie sich bei einem Andministrator und nennen Sie folgende Informationen:<br><br>'. $e)
            );
        }
    }

    public static function getFbFragenFromCode($code) {
        return self::getFbFragen("(SELECT fragebogenid FROM codes WHERE codehash = '" . $code . "')", True);
    }

    public static function insertRate($rates, $codehash) {
        global $link;
        $rates = json_decode($rates, true);
        $rates = json_decode($rates, true);
        $sqlquery_CheckValidation = "SELECT bewertung FROM codes WHERE codehash='" . $codehash . "'";
        if (mysqli_fetch_array(mysqli_query($link, $sqlquery_CheckValidation))['bewertung'] !== '0'){
            $antwort = array(
                'returncode'=>-3,
                'returnvalue'=>main::toDE('<strong>Bewertung vollständig.</strong><br>Sie haben Ihre Antworten bereits abgeschickt')
            );
        }
        else{
            $sqlquary_insertRate = 'INSERT INTO bewertungen(id, frageid, bogenid, bewertung) VALUES ';
            $temp_sqlquary_insertRate = '';
            foreach ($rates as $key => $value) {
                foreach($value as $key2 => $value2){
                    $bewertung = 0;
                    $bogenid = 0;
                    $frageid = 0;
                    foreach($value2 as $key3 => $value3){
                        switch ($key3) {
                            case 'bewertung':$bewertung = $value3;break;
                            case 'bogenid':$bogenid = $value3;break;
                            case 'frageid':$frageid = $value3;break;
                            default:break;
                        }
                    }
                    if ((int)$bewertung < -2 || (int)$bewertung > 2){
                        return array(
                            'returncode'=>-2,
                            'returnvalue'=>main::toDE('<strong>Bewertung fehlerhaft</strong><br>Ihre Antwort ist nicht zulässig.')
                        );
                    } 
                    $temp_sqlquary_insertRate .= "(DEFAULT," . $frageid . "," . $bogenid . "," . $bewertung . "),";
                }
            }
            $sqlquary_insertRate .= rtrim($temp_sqlquary_insertRate, ',');
            if (mysqli_query($link, $sqlquary_insertRate)) {
                mysqli_query($link, "UPDATE codes SET bewertung=1 WHERE codehash='" . $codehash . "'");
                $antwort = array(
                    'returncode'=>0,
                    'returnvalue'=>main::toDE('<strong>Gesendet</strong><br>Ihre Antworten wurden gespeichert.')
                );
            }
            else{
                $antwort = array(
                    'returncode'=>1,
                    'returnvalue'=>main::toDE('<strong>Programmfehler</strong><br>Es ist ein Programmfehler aufgetreten.<br>Bitte wenden Sie sich an Ihren Lehrer')
                );
            }
        }
        self::checkanddeleteCode($codehash);
        return $antwort;
    }

    public static function insertkritik($fbId, $kritik, $codehash) {
        global $link;
        $sqlquery_CheckValidation = "SELECT kritik FROM codes WHERE codehash='" . $codehash . "'";
        $sqlquery_CheckValidation_Result = mysqli_fetch_array(mysqli_query($link, $sqlquery_CheckValidation))['kritik'];
        if ($sqlquery_CheckValidation_Result === '1'){
            $antwort = array(
                'returncode'=>-3,
                'returnvalue'=>main::toDE('<strong>Kritik vollständig.</strong><br>Sie haben Ihre Kritik bereits abgeschickt.')
            );
        }
        else{
            if (strlen($kritik) > 65535){
                $antwort = array(
                    'returncode'=>-3,
                    'returnvalue'=>main::toDE('<strong>strong>Kritik zu lang.</strong><br>Bitte halten Sie sich kurz.')
                );
            }
            else{ 
                $sqlquery_insertKritik = "INSERT INTO `verbesserungen`(`id`, `bogenid`, `vorschlag`) VALUES (DEFAULT," . $fbId . ",'" . $kritik . "')";
                if (mysqli_query($link, $sqlquery_insertKritik)){
                    mysqli_query($link, "UPDATE codes SET kritik=1 WHERE codehash='" . $codehash . "'");
                    $antwort = array(
                        'returncode'=>0,
                        'returnvalue'=>main::toDE('<strong>Gesendet</strong><br>Vielen Dank, dass Sie den Fragebogen ausgefüllt haben.<br>Einen schönen Tag.')
                    );
                }
                else{
                    $antwort = array(
                        'returncode'=>1,
                        'returnvalue'=>main::toDE('<strong>Programmfehler</strong><br>Es ist ein Programmfehler aufgetreten.<br>Bitte wenden Sie sich an Ihren Lehrer')
                    );
                }
            }
        }
        self::checkanddeleteCode($codehash);
        return $antwort;
    }

    static function checkanddeleteCode($strCode){
        global $link;
        $arrayCodeCheck = mysqli_fetch_array(mysqli_query($link, "SELECT kritik, bewertung FROM codes WHERE codehash='". $strCode . "'"));
        if ($arrayCodeCheck['kritik'] === '1' && $arrayCodeCheck['bewertung'] === '1'){
            mysqli_query($link, "DELETE FROM codes WHERE codehash = '" . $strCode . "'");
        }
        return;
    }

    public static function getkritik($fbId) {
        global $link;
        $sqlquery_GetKritik = "SELECT vorschlag FROM verbesserungen WHERE bogenid = " . $fbId . "";
        $sqlquery_GetKritik_Result = mysqli_query($link, $sqlquery_GetKritik);
        if ($sqlquery_GetKritik_Result->num_rows == 0) {
            return array(
                'returncode'=>-1,
                'returnvalue'=>main::toDE('<strong>Keine Vorschläge</strong><br>Dieser Fragebogen hat keine Verbesserungsvorschläge gespeichert.')
            );
        }
        $sqlquery_GetKritik_Result_Data = array();
        $answer = array();
        for ($i=0; $i < $sqlquery_GetKritik_Result->num_rows; $i++) { 
            $sqlquery_GetKritik_Result_Data[$i] = mysqli_fetch_array($sqlquery_GetKritik_Result);
            array_push($answer, $sqlquery_GetKritik_Result_Data[$i]['vorschlag']);
        }
        return array(
            'returncode'=>0,
            'returnvalue'=>$answer
        );
    }

    public static function getAlleSchulklassen($var = null) {
        global $link;
        $sqlquery_getAlleSchulklassen = "SELECT name FROM klasse";
        $sqlquery_getAlleSchulklassen_Result = mysqli_query($link, $sqlquery_getAlleSchulklassen);
        if ($sqlquery_getAlleSchulklassen_Result->num_rows == 0) {
            return array(
                'returncode'=>-1,
                'returnvalue'=>main::toDE('<strong>Keine Klassen gefunden</strong><br>Es wurden keine Schulklassen in der Datenbank gefunden.')
            );
        }
        $answer = array();
        for ($i=0; $i < $sqlquery_getAlleSchulklassen_Result->num_rows; $i++) { 
            $sqlquery_getAlleSchulklassen_Result_Data[$i] = mysqli_fetch_array($sqlquery_getAlleSchulklassen_Result);
            array_push($answer, $sqlquery_getAlleSchulklassen_Result_Data[$i]['name']);
        }
        return array(
            'returncode'=>0,
            'returnvalue'=>$answer
        );
    }

    public static function deleteCode($codehash) {
        global $link;
        $sqlquery_DelCodehash = "DELETE FROM codes WHERE codehash = '" . $codehash . "'";
        if (mysqli_query($link, $sqlquery_DelCodehash)) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function deleteAllCodes($fbId) {
        global $link;
        $sqlquery_DelCodehash = "DELETE FROM codes WHERE fragebogenid = " . $fbId . ";";
        if (mysqli_query($link, $sqlquery_DelCodehash)) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function getAllSubjects(){
        global $link;
        $sqlquery_getAlleSchulklassen = "SELECT name FROM fach";
        $sqlquery_getAlleSchulklassen_Result = mysqli_query($link, $sqlquery_getAlleSchulklassen);
         {
            return array(
                'returncode'=>-1,
                'returnvalue'=>main::toDE('<strong>Keine Fächer gefunden</strong><br>Es wurden keine Fächer in der Datenbank gefunden.')
            );
        }
        $answer = array();
        for ($i=0; $i < $sqlquery_getAlleSchulklassen_Result->num_rows; $i++) { 
            $sqlquery_getAlleSchulklassen_Result_Data[$i] = mysqli_fetch_array($sqlquery_getAlleSchulklassen_Result);
            array_push($answer, $sqlquery_getAlleSchulklassen_Result_Data[$i]['name']);
        }
        return array(
            'returncode'=>0,
            'returnvalue'=>$answer
        );
    }

    public static function alterQuestion($frageId, $neuFrage) {
        try{
            $answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.alterQuestion()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            $sqlquery_deleteQuestions = "UPDATE fragen SET frage='".$neuFrage."' WHERE id = ".$frageId."";
            $sqlResult = mysqli_query($link, $sqlquery_deleteQuestions);
            if ($sqlResult == False) throw new Exception('<strong>SQL-Error</strong><br>Bitte wenden Sie sich an einen Administrator.');
            $answer = array(
                'rc' => true,
                'rv' => NULL
            );
        }catch(Exception $error){
            $answer = array(
                'rc' => false,
                'rv' => $error
            );
        }finally{
            return $answer;
        }
    }

    public static function delQuestionnaire($fbId) {
        try{
            $answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.deleteQuestion()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            if(self::deleteAllCodes($fbId) == false)throw new Exception('<strong>SQL-Error at deleteAllCodes()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            $sqlquery_deleteQuestions = "
                DELETE FROM bewertungen WHERE bogenid = ".$fbId.";
                DELETE FROM verbesserungen WHERE bogenid = ".$fbId.";
                DELETE FROM fragebogen WHERE id = ".$fbId.";";
            $sqlResult = mysqli_query($link, $sqlquery_deleteQuestions);
            if ($sqlResult == False) throw new Exception('<strong>SQL-Error</strong><br>Bitte wenden Sie sich an einen Administrator.');
            $answer = array(
                'rc' => true,
                'rv' => NULL
            );
        }catch(Exception $error){
            $answer = array(
                'rc' => false,
                'rv' => $error
            );
        }finally{
            return $answer;
        }
    }

    public static function getQuestions() {
        try{
            $answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.getQuestions()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            $sqlquery_getQuestions = "SELECT frage, kategorie FROM getquestions WHERE mail = '".$_SESSION['usermail']."';";
            $sqlResult = mysqli_query($link, $sqlquery_getQuestions);
            if ($sqlResult == False) throw new Exception('<strong>SQL-Error</strong><br>Bitte wenden Sie sich an einen Administrator.');
            if ($sqlResult->num_rows == 0) throw new Exception('<strong>Keine Fragen gefunden</strong><br>Bitte tragen Sie Fragen ein.');
            $arrayRv = array();
            for ($i=0; $i < $sqlResult->num_rows; $i++) { 
                $sqlResult_Data[$i] = mysqli_fetch_array($sqlResult);
                array_push($arrayRv, array(
                        'question' => $sqlResult_Data[$i]['frage'],
                        'category' => $sqlResult_Data[$i]['kategorie']
                        )
                    );
                }
            $answer = array(
                'rc' => true,
                'rv' => $arrayRv
            );
        } catch (Exception $error){
            $answer = array(
                'rc' => false,
                'rv' => $error
            );
        }finally{
            return $answer;
        }
    }

    public static function changeQuestionDelete($frageId) {
        try{
            $answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.deleteQuestion()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            $sqlquery_deleteQuestions = "UPDATE fragen SET softdelete=IF (softdelete, 0, 1) WHERE id = ".$frageId."";
            $sqlResult = mysqli_query($link, $sqlquery_deleteQuestions);
            if ($sqlResult == False) throw new Exception('<strong>SQL-Error</strong><br>Bitte wenden Sie sich an einen Administrator.');
            $answer = array(
                'rc' => true,
                'rv' => NULL
            );
        }catch(Exception $error){
            $answer = array(
                'rc' => false,
                'rv' => $error
            );
        }finally{
            return $answer;
        }
    }
}
//////////////////////////////////////////  DEBUG  /////////////////////////////////////////////
if (isset($_REQUEST['mode']) == false){
    session_unset();
    $_REQUEST['mode']           = 'getQuestions';

    $_SESSION['usermail']       = 'temp.dump@hotmail.com';
    $_REQUEST['mode']           = 'getQuestions';
    $_REQUEST['frage']          = 'Tafelbilder und Folien sind gut lesbar.';
    $_REQUEST['mail']           = 'temp.dump@hotmail.com';
    $_REQUEST['passwort']       = 'Admin';
    $_REQUEST['kategorie']      = 'Unterricht';
    $_REQUEST['name']           = 'BogenX';
    $_REQUEST['anzahl']         = '1';
    $_REQUEST['klasse']         = 'ITB1-19';
    $_REQUEST['fach']           = 'ITS';
    $_REQUEST['fbId']           = '124';
    $_REQUEST['fragen']         = array('Die Beurteilungskriterien sind nachvollziehbar.', 'Die Unterrichtsinhalte sind praxisbezogen.');
    $_REQUEST['rate']           = json_encode(array(array('frageid'=>'7','bogenid'=>'112','bewertung'=>2),array('frageid'=>'35','bogenid'=>'112','bewertung'=>1)));
    $_REQUEST['codehash']       = '00-48-40-00';
    $_REQUEST['kritik']         = 'Alles Gefixt! Garkein Problem!';
    $_REQUEST['frageId']        = '124';
    $_REQUEST['neuFrage']       = array('frage' => 'Der Unterricht ist gut vorbereitet und sorgfaltig geplant.','lehrerId' => 'NULL','kategorie' => 'Unterricht');
    
}
//////////////////////////////////////////  DEBUG END  /////////////////////////////////////////
$jsablauf = new main();
