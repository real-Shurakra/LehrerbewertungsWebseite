<?php

include 'DatabaseControl.php';

class QuestionnaireAdministration {

    /**@brief contructor
     * @param string $dbipv4 Databaseserver IPv4 address
     * @param string $dbname Database name
     * @param string $dbuser Database user
     * @param string $dbpass Database user password
     */
    function _construct($dbipv4, $dbname, $dbuser, $dbpass){
        // Creating class DatabaseControl object
        $this->databaseConrtol = new DatabaseControl($dbipv4, $dbuser, $dbpass, $dbname);
    }

    /**@brief Database interface
     * @param string $sqlString SQL formated string
     * @param boolean $moreThanOne Set true if send more than one executives in
     * @return array ('rc'=>true,'rv'=>array)
     * @except array ('rc'=>false,'rv'=>string)
     */
    protected function _sendOneToDatabase($sqlString, $moreThanOne=false){
        try{
            if (!$moreThanOne) {
                $dbReturn = $this->databaseConrtol->sendOneToDatabase($sqlString);
            }
            else{
                $dbReturn = $this->databaseConrtol->sendMultipleToDatabase($sqlString);
            }
            if (!$dbReturn['rc']) {throw new ErrorException($dbReturn['rv']);}
            else{$answer = array('rc'=>true, 'rv'=>$dbReturn['rv']);}
            
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    
    
    public static function addFrage($frage, $kategorie) {
        try{
            $answer = array('returncode' =>1,'returnvalue'=>'<strong style="color:red;">Unknown Error</strong><br>/php/main.php -> FragenVerwaltung.addFrage()');
            global $link;
            $sqlquary_SucheFrage = "SELECT * FROM fragen WHERE frage = '" . $frage . "' AND lehrerid = (SELECT id FROM lehrer WHERE mail = '".$_SESSION['usermail']."');";
            $sqlquary_SucheFrage_Result = mysqli_query($link, $sqlquary_SucheFrage);
            if ($sqlquary_SucheFrage_Result->num_rows == 0) {
                $sqlquary_InsertFrage = "
                    INSERT INTO fragen (frage, kategorie, lehrerid) VALUES 
                    ('" . $frage . "', '" . $kategorie . "', (SELECT id FROM lehrer WHERE mail = '".$_SESSION['usermail']."'));";
                $sqlquary_InsertFrage_Result = mysqli_query($link, $sqlquary_InsertFrage);
                if ($sqlquary_InsertFrage_Result) {$answer = array('returncode' =>0,'returnvalue'=>'<strong style="color:green;">Die Frage wurde erfolgreich gespeichert.</strong>');}
            }
            else {$answer =  array('returncode' =>-1,'returnvalue'=>'<strong style="color:yellow;">Die Frage befand sich bereits in der Datenbank.</strong>');}
        }
        catch(Exception $error){
            $answer = array('returncode' =>1,'returnvalue'=>'<strong style="color:red;">Error</strong><br>/php/main.php -> FragenVerwaltung.addFrage() => '.$error);
        }
        finally{
            return $answer;
        }
        
    }
    
    public static function askAlleFragen() {
        try {
            $answer = array('returncode' =>1,'returnvalue'=>'<strong>Unknown Error</strong><br>/php/main.php -> FragenVerwaltung.askAlleFragen()');
            global $link;
            $sqlquary_AlleFragen_Result_Data = array();
            $sqlquary_AlleFragen = "
                SELECT id, frage, kategorie, softdelete FROM fragen 
                WHERE lehrerid = (SELECT id FROM lehrer WHERE mail = '".$_SESSION['usermail']."') ORDER BY kategorie ASC;";
            $sqlquary_AlleFragen_Result = mysqli_query($link, $sqlquary_AlleFragen);
            if (!$sqlquary_AlleFragen_Result) {throw new ErrorException($link->error);}
            $answerArray = array();
            for ($i = 0; $i < $sqlquary_AlleFragen_Result->num_rows; $i++){
                $sqlquary_AlleFragen_Result_Data[$i] = mysqli_fetch_array($sqlquary_AlleFragen_Result);
                $answerArray[$i]['id']          = MainInterface::toDE($sqlquary_AlleFragen_Result_Data[$i]['id']);
                $answerArray[$i]['frage']       = MainInterface::toDE($sqlquary_AlleFragen_Result_Data[$i]['frage']);
                $answerArray[$i]['kategorie']   = MainInterface::toDE($sqlquary_AlleFragen_Result_Data[$i]['kategorie']);
                $answerArray[$i]['softdelete']  = MainInterface::toDE($sqlquary_AlleFragen_Result_Data[$i]['softdelete']);
                $answerArray[$i][0]             = MainInterface::toDE($sqlquary_AlleFragen_Result_Data[$i][0]);
                $answerArray[$i][1]             = MainInterface::toDE($sqlquary_AlleFragen_Result_Data[$i][1]);
            }
            $kategorien = self::getAlleKategorien();
            if ($kategorien['rc']){
                $answer = array(
                    'returncode'=>0,
                    'returnvalue'=>array(
                        $kategorien['rv'],
                        $answerArray
                    )
                );
            }
            else {throw new ErrorException($kategorien['rv']);}
        } 
        catch (ErrorException $error) {$answer =  array('returncode'=>1,'returnvalue'=>$error->getMessage());}
        finally{return $answer;}
    }
    
    public static function getAlleKategorien() {
        try {
            global $link;
            $sqlquary_AlleKategorien_Result_Data = array();
            $sqlquary_AlleKategorien = "SELECT kategorie FROM fragen GROUP BY kategorie";
            $sqlquary_AlleKategorien_Result = mysqli_query($link, $sqlquary_AlleKategorien);
            if (!$sqlquary_AlleKategorien_Result) {throw new Exception($link->error);}
            for ($i = 0; $i < $sqlquary_AlleKategorien_Result->num_rows; $i++) {$sqlquary_AlleKategorien_Result_Data[$i] = mysqli_fetch_array($sqlquary_AlleKategorien_Result);}
            $answer =  array('rc'=>true,'rv'=>$sqlquary_AlleKategorien_Result_Data);
        }
        catch (Exception $error) {$answer = array('rc'=>false,'rv'=>$error);
        }
        finally{
            return $answer;
        }
    }

    public static function makeFragebogen($name, $anzahl, $klasse, $fach, $fragenids)  {
        try{
            $answer = array('returncode' =>1,'returnvalue'=>'<strong>Unknown Error</strong><br>/php/main.php -> FragenVerwaltung.makeFragebogen()');
            global $link;
            $fragen = explode(',', $fragenids);
            $sqlstring_MakeFragebogen = "
                INSERT INTO fragebogen 
                (name, schueleranzahl, klassename, fachid, lehrerid)
                VALUES
                (
                    '".$name."', 
                    '".$anzahl."',
                    '".$klasse."',
                    (SELECT id FROM fach WHERE name = '".$fach."'),
                    (SELECT id FROM lehrer WHERE mail = '".$_SESSION['usermail']."')
                );";
            $sqlstring_MakeFragebogen_Result = mysqli_query($link, $sqlstring_MakeFragebogen);
            if (!$sqlstring_MakeFragebogen_Result) {
                throw new ErrorException($link->error);
            }
            else{
                $sqlquery_GetLastFbId = "SELECT MAX(id) FROM fragebogen WHERE `lehrerid` = (SELECT id FROM lehrer WHERE mail = '" . $_SESSION['usermail'] ."');";
                $sqlquery_GetLastFbId_Result = mysqli_query($link, $sqlquery_GetLastFbId);
                $sqlquery_GetLastFbId_Result_Data = mysqli_fetch_array($sqlquery_GetLastFbId_Result);
                $fbId = $sqlquery_GetLastFbId_Result_Data['MAX(id)'];
                $row_sqlquery_InsertFbFragen = "INSERT INTO nm_frage_fragebogen (bogenid, frageid) VALUES ";
                for ($i = 0; $i < count($fragen); $i++) {
                    $row_sqlquery_InsertFbFragen .= "(".$fbId.", ".$fragen[$i]."),";
                }
                $sqlquery_InsertFbFragen = rtrim($row_sqlquery_InsertFbFragen, ",");
                $sqlquery_InsertFbFragen .= ";";
                mysqli_query($link, $sqlquery_InsertFbFragen);
                $genCodesResult = self::genCodes($anzahl, $fbId);
                if ($genCodesResult['rc'] != 0){
                    throw new ErrorException($genCodesResult['rv']);
                }
                $answer = array(
                    'retruncode' => 0,
                    'returnvalue' => '<strong>Erfolg.</strong><br>Fragebogen angelegt.'
                );
            }
        }
        catch(ErrorException $error) {
            $answer = array('returncode'=>1,
                            'returnvalue'=>'<strong>Error in /php/main.php -> FragenVerwaltung.makeFragebogen()</strong>'.$error->getMessage());
        }
        finally{return $answer;}
    }
    
    static function genCodes($anz, $fbId) {
        try{
            global $link;
            for ($i = 0; $i < $anz; $i++) {
                $counter = 0;
                while (true) {
                    $code = self::genNumber().'-'.self::genNumber().'-'.self::genNumber().'-'.self::genNumber();
                    $test = mysqli_query($link, "SELECT * FROM codes WHERE codehash = '".$code."'");
                    if ($test->num_rows == 0){
                        mysqli_query($link, "INSERT INTO codes (codehash, fragebogenid) VALUES ('".$code."', ".$fbId.");");
                        break;
                    }
                    else {
                        if ($counter == 100000000) {
                            return false;
                        }
                        $counter++;
                        continue;
                    }
                }
            }
            $answer = array('rc'=>0,'rv'=>NULL);
        }
        catch (ErrorException $error) {$answer = array('rc'=>1,'rv'=>$error->getMessage());}
        finally{return $answer;}
    }
    
    static function genNumber() {$numb = random_int(0, 99);if($numb<=9){$numb='0'.$numb;}return $numb;}
    
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
                'returnvalue' => MainInterface::toDE('<strong>Keine Bögen</srtong><br>Sie haben bisther keine Fragebögen angelegt.')
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
        $sqlquery_GetCodes = "SELECT codehash FROM codes WHERE fragebogenid = '".$fbId."'";
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
                    'returnvalue'=>MainInterface::toDE('<strong>SQL-Fehler.</strong><br>Der SQL-String von getFbFragen()-$sqlquery_GetFbFragen ist fehlerhaft.')
                );
            }
            if ($sqlquery_GetFbFragen_Result->num_rows == 0) {
                return array(
                    'returncode'=>-1,
                    'returnvalue'=>MainInterface::toDE('<strong>Keine Fragen gefunden.</strong><br>Es befinden sich keine Fragen in diesem Fragebogen.')
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
        catch(ErrorException $e){
            return array(
                'returncode'=>1,
                'returnvalue'=>MainInterface::toDE('<strong>Programmfehler</strong><br>Bitte melden Sie sich bei einem Andministrator und nennen Sie folgende Informationen:<br><br>'. $e)
            );
        }
    }

    public static function getFbFragenFromCode($code) {return self::getFbFragen("(SELECT fragebogenid FROM codes WHERE codehash = '" . $code . "')", True);}

    public static function insertRate($rates, $codehash) {
        global $link;
        $rates = json_decode($rates, true);
        $rates = json_decode($rates, true);
        $sqlquery_CheckValidation = "SELECT bewertung FROM codes WHERE codehash='" . $codehash . "'";
        if (mysqli_fetch_array(mysqli_query($link, $sqlquery_CheckValidation))['bewertung'] !== '0'){
            $antwort = array(
                'returncode'=>-3,
                'returnvalue'=>MainInterface::toDE('<strong>Bewertung vollständig.</strong><br>Sie haben Ihre Antworten bereits abgeschickt')
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
                            'returnvalue'=>MainInterface::toDE('<strong>Bewertung fehlerhaft</strong><br>Ihre Antwort ist nicht zulässig.')
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
                    'returnvalue'=>MainInterface::toDE('<strong>Gesendet</strong><br>Ihre Antworten wurden gespeichert.')
                );
            }
            else{
                $antwort = array(
                    'returncode'=>1,
                    'returnvalue'=>MainInterface::toDE('<strong>Programmfehler</strong><br>Es ist ein Programmfehler aufgetreten.<br>Bitte wenden Sie sich an Ihren Lehrer')
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
                'returnvalue'=>MainInterface::toDE('<strong>Kritik vollständig.</strong><br>Sie haben Ihre Kritik bereits abgeschickt.')
            );
        }
        else{
            if (strlen($kritik) > 65535){
                $antwort = array(
                    'returncode'=>-3,
                    'returnvalue'=>MainInterface::toDE('<strong>strong>Kritik zu lang.</strong><br>Bitte halten Sie sich kurz.')
                );
            }
            else{ 
                $sqlquery_insertKritik = "INSERT INTO `verbesserungen`(`id`, `bogenid`, `vorschlag`) VALUES (DEFAULT," . $fbId . ",'" . $kritik . "')";
                if (mysqli_query($link, $sqlquery_insertKritik)){
                    mysqli_query($link, "UPDATE codes SET kritik=1 WHERE codehash='" . $codehash . "'");
                    $antwort = array(
                        'returncode'=>0,
                        'returnvalue'=>MainInterface::toDE('<strong>Gesendet</strong><br>Vielen Dank, dass Sie den Fragebogen ausgefüllt haben.<br>Einen schönen Tag.')
                    );
                }
                else{
                    $antwort = array(
                        'returncode'=>1,
                        'returnvalue'=>MainInterface::toDE('<strong>Programmfehler</strong><br>Es ist ein Programmfehler aufgetreten.<br>Bitte wenden Sie sich an Ihren Lehrer')
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
                'returnvalue'=>MainInterface::toDE('<strong>Keine Vorschläge</strong><br>Dieser Fragebogen hat keine Verbesserungsvorschläge gespeichert.')
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

    

    public static function deleteCode($codehash) {
        global $link;
        $sqlquery_DelCodehash = "DELETE FROM codes WHERE codehash = '".$codehash."'";
        if (mysqli_query($link, $sqlquery_DelCodehash)) {return true;}
        else {return false;}
    }

    public static function deleteAllCodes($fbId) {
        global $link;
        $sqlquery_DelCodehash = "DELETE FROM codes WHERE fragebogenid = ".$fbId.";";
        if (mysqli_query($link, $sqlquery_DelCodehash)) {return true;}
        else {return false;}
    }

    

    public static function alterQuestion($frageId, $neuFrage) {
        try{
            $answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.alterQuestion()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            $sqlquery_deleteQuestions = "UPDATE fragen SET frage='".$neuFrage."' WHERE id = ".$frageId."";
            $sqlResult = mysqli_query($link, $sqlquery_deleteQuestions);
            if ($sqlResult == False) throw new ErrorException('<strong>SQL-Error</strong><br>Bitte wenden Sie sich an einen Administrator.');
            $answer = array('rc' => true,'rv' => NULL);
        }
        catch(ErrorException $error){$answer = array('rc' => false,'rv' => $error);}
        finally{return $answer;}
    }

    public static function delQuestionnaire($fbId) {
        try{
            //$answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.deleteQuestion()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            if(self::deleteAllCodes($fbId) == false)throw new ErrorException('<strong>SQL-Error at deleteAllCodes()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            $sqlResult = mysqli_query($link, "DELETE FROM bewertungen WHERE bogenid = ".$fbId.";");
            if ($sqlResult == False) throw new ErrorException('<strong>SQL-Error: bewertungen'.$sqlResult.'</strong><br>' . $link->error);
            $sqlResult = mysqli_query($link, "DELETE FROM verbesserungen WHERE bogenid = ".$fbId.";");
            if ($sqlResult == False) throw new ErrorException('<strong>SQL-Error: verbesserungen'.$sqlResult.'</strong><br>' . $link->error);
            $sqlResult = mysqli_query($link, "DELETE FROM nm_frage_fragebogen WHERE bogenid = ".$fbId.";");
            if ($sqlResult == False) throw new ErrorException('<strong>SQL-Error: nm_frage_fragebogen'.$sqlResult.'</strong><br>' . $link->error);
            $sqlResult = mysqli_query($link, "DELETE FROM fragebogen WHERE id = ".$fbId.";");
            if ($sqlResult == False) throw new ErrorException('<strong>SQL-Error: fragebogen'.$sqlResult.'</strong><br>' . $link->error);
            $answer = array('rc' => true,'rv' => NULL);}
        catch(ErrorException $error){$answer = array('rc' => false,'rv' => $error->getMessage());}
        finally{return $answer;}
    }

    public static function getQuestions() {
        try{
            $answer = array('returncode' => false,'returnvalue' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.getQuestions()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            $sqlquery_getQuestions = "SELECT frage, kategorie FROM getquestions WHERE mail = '".$_SESSION['usermail']."';";
            $sqlResult = mysqli_query($link, $sqlquery_getQuestions);
            if ($sqlResult == False) throw new ErrorException('<strong>SQL-Error</strong><br>Bitte wenden Sie sich an einen Administrator.');
            if ($sqlResult->num_rows == 0) throw new ErrorException('<strong>Keine Fragen gefunden</strong><br>Bitte tragen Sie Fragen ein.');
            $arrayRv = array();
            for ($i=0; $i < $sqlResult->num_rows; $i++) { 
                $sqlResult_Data[$i] = mysqli_fetch_array($sqlResult);
                array_push($arrayRv, array('frage' => $sqlResult_Data[$i]['frage'],'kategorie' => $sqlResult_Data[$i]['kategorie']));
            }
            $answer = array('returncode' => true,'returnvalue' => $arrayRv);}
        catch (ErrorException $error){$answer = array('returncode' => false,'returnvalue' => $error);}
        finally{return $answer;}
    }

    public static function changeQuestionDelete($frageId) {
        try{
            $answer = array('rc' => false,'rv' => '<strong>Unknown-Error at main.php -> FragenVerwaltung.deleteQuestion()</strong><br>Bitte wenden Sie sich an einen Administrator.');
            global $link;
            $sqlquery_deleteQuestions = "UPDATE fragen SET softdelete=IF (softdelete, 0, 1) WHERE id = ".$frageId."";
            $sqlResult = mysqli_query($link, $sqlquery_deleteQuestions);
            if ($sqlResult == False) throw new ErrorException('<strong>SQL-Error</strong><br>Bitte wenden Sie sich an einen Administrator.');
            $answer = array('rc' => true,'rv' => NULL);}
        catch(ErrorException $error){$answer = array('rc' => false,'rv' => $error);}
        finally{return $answer;}
    }
}