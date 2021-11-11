<?php
class UserAdministration {
    function __construct(){}

    /**
     * @brief String encription
     * @details This function provides encription functionallity for generating passwords or spice.
     * @param string $cleanPassword unencripted password
     * @param string $encription Encriptionalgorythm
     * @param string $pepper Password pepper
     * @param string $salt Password salt
     * @return string $antwort = with Sha512 encripted
     */
    protected function __encodeString($cleanPassword, $encription='sha512', $pepper='' ,$salt='') {
        try{
            $hash = hash($encription, $pepper . $cleanPassword . $salt);
            $answer = array(
                'rc'=>true,
                'rv'=>$hash
            );
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>$error->getMessage());}
        finally{return $answer;}
    }

    /**
     * @brief Get user spice
     * @param $userName User mail address
     * @return array(rc:true,rv:array(0:string,pepper:string,1:string,salt:string))
     * @except array(rc:false,rv:string)
     */
    protected function __getSpice($userName) {
        try{
            include 'DatabaseControl.php';
            include '../conf/config.php';
            $database = new DatabaseControl($dbipv4, $dbuser, $dbpass, $dbname);
            $result = $database->connectToDatabase();
            if ($result['rc'] == false) {return $result;}
            $result = $database->sendToDB("SELECT pepper, salt FROM lehrer WHERE mail='".$userName."'");
            if ($result['rc'] == false) {return $result;}
            $database->disconnectFromDatabase();
            $answer = array(
                'rc'=>true,
                'rv'=>$result['rv']
            );
        }
        catch(ErrorException $error){$answer = array('rc'=>true, 'rv'=>$error->getMessage());}
        finally{return $answer;}
    }

    /**
     * @brief Create spice md5 hash
     * @return array(rc:true,rv:array(pepper:string,salt:string))
     * @except array(rc:false,rv:string)
     */
    protected function __makeSpice(){
        try{
            $numberMin = 10000000000000;
            $numberMax = 99999999999999;
            $pepperhash = $this->__encodeString(rand($numberMin, $numberMax), 'md5');
            if ($pepperhash['rc'] == false) {return $pepperhash;}
            $pepperhash = $pepperhash['rv'];
            $salthash = $this->__encodeString(rand($numberMin, $numberMax), 'md5');
            if ($salthash['rc'] == false) {return $salthash;}
            $salthash = $salthash['rv'];
            $answer = array(
                'rc'=>true,
                'rv'=>array(
                    'pepper'=>$pepperhash,
                    'salt'=>$salthash
                )
            );
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>$error->getMessage());}
        finally{return $answer;}
    }

    protected function __checkPassword($newPassword){
        try{
            if (strlen($newPassword) <= 8) {throw new ErrorException('Password to short');}
            if (strpos($newPassword, ' ')) {throw new ErrorException('Password contains space characters');}
            if (strpos($newPassword, ';')) {throw new ErrorException('Password contains semicolon');}
            $answer=array('rc'=>true, 'rv'=>'Password ok');
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>$error->getMessage());}
        finally{return $answer;}
    }

    function __generatePassword($newPassword){
        try{
            $passCheckup = $this->__checkPassword($newPassword);
            if (!$passCheckup['rc']) {throw new ErrorException($passCheckup['rv']);}
            $passEncodeOne = $this->__encodeString($newPassword);
            if (!$passEncodeOne['rc']) {throw new ErrorException($passEncodeOne['rv']);}
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>$error->getMessage());}
        finally{return $answer;}
    }

    
    public function loginUser($mail, $passwort) {
        try {
            $answer = array(
                'returncode'=>false,
                'returnvalue'=>'<strong>Unknown Error</strong><br>Unbekannter Fehler in /php/main.php -> nutzerverwaaltung.loginUser()<br>Bitte wenden Sie sich an einen Administrator.'
            );
            include 'LBWEncription.php';
            $passwort = LBWEncription::pass_encode($passwort);
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
            include 'LBWEncription.php';
            $sqlquery_addUser = "UPDATE lehrer SET passwort=".LBWEncription::pass_encode($newPasswort)." WHERE mail = ".$_SESSION['usermail'].";";
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
        include 'LBWEncription.php';
        $Password = LBWEncription::pass_encode($Password);
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
            
            $answer = array('rc' => true,'rv' => '<strong>Erfolgreich</strong><br>Ihr Passwort wurde gändert.');
        }
        catch(Exception $error){$answer = array('rc' => false,'rv' => $error);}
        finally{return $answer;}
    }
}