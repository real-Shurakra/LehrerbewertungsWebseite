<?php
class UserAdministration {
    function __construct(){}

    private function debugNote($note){
        echo'<br>';
        echo '<a style="color:orange"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
      </svg> '.debug_backtrace()[1]['class'].'.'.debug_backtrace()[1]['function'].' at '.debug_backtrace()[0]['file'].' line '.debug_backtrace()[0]['line'].': ';
        var_dump($note);
        echo'</a><br>';
    }

    /**@brief Database interface
     * @param string $sqlString SQL formated string
     * @return array(rc:true,rv:array(mixed))||array(rc:false,rv:string)
     */
    protected function __sendOneToDatabase($sqlString, $moreThanOne=false){
        try{
            include_once 'DatabaseControl.php';
            include_once '../conf/config.php';
            global $dbipv4, $dbuser, $dbpass, $dbname;
            // Creating class DatabaseControl object
            $databaseConrtol = new DatabaseControl($dbipv4, $dbuser, $dbpass, $dbname);
            if (!$moreThanOne) {$dbReturn = $databaseConrtol->sendOneToDatabase($sqlString);}
            else{$dbReturn = $databaseConrtol->sendMultipleToDatabase($sqlString);}
            if (!$dbReturn['rc']) {throw new ErrorException($dbReturn['rv']);}
            $answer = array('rc'=>true, 'rv'=>$dbReturn['rv']);
            ##$this->debugNote($sqlString);
            ##$this->debugNote($answer);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief String encription
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
            $answer = array('rc'=>true, 'rv'=>$hash);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get user spice
     * @param string $userName User mail address
     * @return array(rc:true,rv:array(0:string,pepper:string,1:string,salt:string))||array(rc:true,rv:false)
     * @except array(rc:false,rv:string)
     */
    protected function __getSpice($userName) {
        try{
            $result = $this->__sendOneToDatabase("SELECT pepper, salt FROM lehrer WHERE mail='".$userName."'");
            if (!$result['rc']) {throw new ErrorException($result['rv']);}
            if ($result['rv']==array()) {$answer = array('rc'=>true,'rv'=>false);Return;}
            $answer = array(
                'rc'=>true,
                'rv'=>array(
                    'pepper'=>$result['rv'][0]['pepper'],
                    'salt'=>$result['rv'][0]['salt']
                )
            );            
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Create spice md5 hash
     * @return array(rc:true,rv:array(pepper:string,salt:string))
     * @except array(rc:false,rv:string)
     */
    protected function __makeSpice($userName){
        try{
            $numberMin = 10000000000000;
            $numberMax = 99999999999999;
            // Generating pepper hash
            $clearPepper = rand($numberMin, $numberMax) . $userName . rand($numberMin, $numberMax);
            $pepperhash = $this->__encodeString($clearPepper, 'md5');
            if (!$pepperhash['rc']) {throw new ErrorException($pepperhash['rv']);}
            $pepperhash = $pepperhash['rv'];
            // Generating salt hash
            $clearSalt = rand($numberMin, $numberMax) . $userName . rand($numberMin, $numberMax);
            $salthash = $this->__encodeString($clearSalt, 'md5');
            if (!$salthash['rc']) {throw new ErrorException($salthash['rv']);}
            $salthash = $salthash['rv'];
            $answer = array(
                'rc'=>true,
                'rv'=>array(
                    'pepper'=>$pepperhash,
                    'salt'=>$salthash
                )
            );
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Checks if the new password meets the password conventions
     * @param string $newPassword The new password
     * @return array(rc:bool,rv:string)
     */
    protected function __checkPassword($newPassword){
        try{
            ##$this->debugNote($newPassword);
            ##$this->debugNote(strlen($newPassword));
            // Password need min 8 chars
            if (strlen($newPassword) < 8) {$answer=array('rc'=>true, 'rv'=>1);return;}
            // Password must not contain spaces
            if (strpos($newPassword, ' ')) {$answer=array('rc'=>true, 'rv'=>2);return;}
            // Password must not contain semicolon
            if (strpos($newPassword, ';')) {$answer=array('rc'=>true, 'rv'=>3);return;}
            $answer=array('rc'=>true, 'rv'=>0);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Changes user password
     * @param $userName The username
     * @param $newPassword The new password
     * @return array(rc:true,rv:true)||array(rc:false,rv:string)
     */
    protected function __changePassword($userName, $newPassword){
        try{
            // Checking password
            $passCheckup = $this->__checkPassword($newPassword);
            if (!$passCheckup['rc']) {throw new ErrorException($passCheckup['rv']);}
            if ($passCheckup['rv']===1) {$answer=array('rc'=>true,'rv'=>3);return;}
            if ($passCheckup['rv']===2) {$answer=array('rc'=>true,'rv'=>4);return;}
            if ($passCheckup['rv']===3) {$answer=array('rc'=>true,'rv'=>5);return;}
            #$this->debugNote($passCheckup);
            // Generating spice
            $spice = $this->__makeSpice($userName);
            if (!$spice['rc']) {throw new ErrorException($spice['rv']);}
            $pepper = $spice['rv']['pepper'];
            $salt = $spice['rv']['salt'];
            // Encripting password
            $password = $this->__encodeString($newPassword, 'sha512', $pepper, $salt);
            if (!$password['rc']) {throw new ErrorException($password['rv']);}
            $password = $password['rv'];
            // Save new password to DB
            $result = $this->__sendOneToDatabase("UPDATE lehrer SET passwort='".$password."', pepper='".$pepper."', salt='".$salt."' WHERE mail='".$userName."'");
            #$this->debugNote($result);
            if (!$result['rc']) {throw new ErrorException($result['rv']);}
            $answer = array('rc'=>true,'rv'=>true);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    protected function __checkUserExistence($userName){
        try{
            $sqlCheckUserExixtence = "SELECT 1 FROM lehrer WHERE mail='".$userName."';";
            $sqlCheckUserExixtence_Result = $this->__sendOneToDatabase($sqlCheckUserExixtence);
            if (
                $sqlCheckUserExixtence_Result['rc']&&
                $sqlCheckUserExixtence_Result['rv']===array()
            ){
                $answer = array('rc'=>true,'rv'=>false);
            }
            else{
                $answer = array('rc'=>true,'rv'=>true);
            }
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@breif Returns the user authorisation level
     * @param string $userName The user name
     * @param string $password The user password
     * @return array(rc:true,rv:integer)
     *  0: User not found
     *  1: User not root
     *  2: User is root
     *  3: Password to short
     *  4: Password contains space characters
     *  5: Password contains semicolon
     * @except array(rc:false,rv:string) rv contains further information
     */
    function authoriseUser($userName, $password){
        try{
            // Checking password
            $passCheckup = $this->__checkPassword($password);
            if (!$passCheckup['rc']) {throw new ErrorException($passCheckup['rv']);}
            if ($passCheckup['rv']===1) {$answer=array('rc'=>true,'rv'=>3);return;}
            if ($passCheckup['rv']===2) {$answer=array('rc'=>true,'rv'=>4);return;}
            if ($passCheckup['rv']===3) {$answer=array('rc'=>true,'rv'=>5);return;}
            // Encripting clean password
            $passEncodeOne = $this->__encodeString($password);
            if (!$passEncodeOne['rc']) {throw new ErrorException($passEncodeOne['rv']);}
            $password = $passEncodeOne['rv'];
            // Getting spice
            $spice = $this->__getSpice($userName);
            if (!$spice['rc']){throw new ErrorException($spice['rv']);}
            if (!$spice['rv']){$answer = array('rc'=>true,'rv'=>0);return;}
            $pepper = $spice['rv']['pepper'];
            $salt = $spice['rv']['salt'];
            // Encripting encripted password with spice
            $passEncodeTwo = $this->__encodeString($password, 'sha512', $pepper, $salt);
            if (!$passEncodeTwo['rc']) {throw new ErrorException($passEncodeTwo['rv']);}
            $password = $passEncodeTwo['rv'];
            // Check if user exists
            $sqlCheckUser = "SELECT isroot FROM lehrer WHERE mail='".$userName."' AND passwort='".$password."'";
            $result = $this->__sendOneToDatabase($sqlCheckUser);
            if (!$result['rc']) {throw new ErrorException($result['rv']);}
            if ($result['rv'] === array()) {$answer = array('rc'=>true,'rv'=>0);return;}
            if ($result['rv'][0]['isroot'] === '1') {$answer=array('rc'=>true,'rv'=>2);}
            elseif ($result['rv'][0]['isroot'] === '0') {$answer=array('rc'=>true,'rv'=>1);}
            else {throw new ErrorException('DB answer not mySQL boolean. Is: '.strval($result['rv'][0]['isroot']));}
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief User login
     * @param string $userName The user name
     * @param string $password The user password
     * @return array(rc:boolean,rv:boolean)  00 = User Not found, 10 = User not root, 11 = User root
     * @except array(rc:false,rv:string)
     */
    function loginUser($userName, $password) {
        try {
            $checkUser = $this->authoriseUser($userName, $password);
            #$this->debugNote($checkUser);
            if ($checkUser['rc']) {
                if ($checkUser['rv']===1){$answer =  array ('rc'=>true, 'rv'=>array('logedIn'=>true, 'usermail'=>$userName, 'userisroot'=>false));}
                elseif($checkUser['rv']===2){$answer =  array ('rc'=>true, 'rv'=>array('logedIn'=>true, 'usermail'=>$userName, 'userisroot'=>true));}
                else{$answer =  array ('rc'=>true, 'rv'=>null);}
            }
            else{throw new ErrorException($checkUser['rv']);}
        } 
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Adding a new user
     * @param string $mail New user mail address
     * @param string $firstname New user firsname
     * @param string $lastname New user lastname
     * @param string stdPassword Password for new user in cleartext
     * @return  array(rc:boolean,rv:string)
     */
    function addUser($mail, $firstname, $lastname, $stdPassword = 'Administrator'){
        try{
            // Check if allready exists
            $userExists = $this->__sendOneToDatabase("SELECT 1 FROM lehrer WHERE mail='".$mail."'");
            if (!$userExists['rc']) {throw new ErrorException($userExists['rv']);}
            if ($userExists['rv'] != array()) {$answer=array('rc' => true,'rv' =>false);return;}
            // Checking password
            $passCheckup = $this->__checkPassword($stdPassword);
            if (!$passCheckup['rc']) {throw new ErrorException($passCheckup['rv']);}
            // Generating spice
            $genSpice = $this->__makeSpice($mail);
            if (!$genSpice['rc']) {throw new ErrorException($genSpice['rv']);}
            $pepper = $genSpice['rv']['pepper'];
            $salt = $genSpice['rv']['salt'];
            // Encripting clean password
            $passEncodeOne = $this->__encodeString($stdPassword);
            if (!$passEncodeOne['rc']) {throw new ErrorException($passEncodeOne['rv']);}
            $password = $passEncodeOne['rv'];
            // Encripting encripted password with spice
            $genpass = $this->__encodeString($password, 'sha512', $pepper, $salt);
            if (!$genpass['rc']) {throw new ErrorException($genpass['rv']);}
            $password = $genpass['rv'];
            // User register
            $sqlquery_addUser1 = "
            INSERT INTO lehrer(id, mail, vorname, nachname, passwort, isroot, pepper, salt) 
            VALUES (DEFAULT,'".$mail."','".$firstname."','".$lastname."','".$password."',FALSE,'".$pepper."','".$salt."');";
            $sqlquery_addUser2 = "INSERT INTO fragen(frage, kategorie, lehrerid) 
            SELECT frage, kategorie, (SELECT id FROM lehrer WHERE mail = '".$mail."') FROM fragentemplate;";
            $sqlResult =$this->__sendOneToDatabase($sqlquery_addUser1);
            if (!$sqlResult['rc']) {throw new ErrorException($sqlResult['rv']);}
            $sqlResult =$this->__sendOneToDatabase($sqlquery_addUser2);
            if (!$sqlResult['rc']) {throw new ErrorException($sqlResult['rv']);}
            $answer = array('rc' => true,'rv' => $stdPassword);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    } 

    /**@brief Deleting a user
     * @param string $userName Root username
     * @param string $password Root password
     * @param string $deleteThis Username of deleting user
     * @return array(rc:true,rv:boolean)||array(rc:false,rv:string)
     */
    function deleteUser($userName, $password, $deleteThis) {
        try{
            ## Check permission
            $authUser = $this->authoriseUser($userName, $password);
            if ($authUser['rc']) {
                if ($authUser['rv'] === 2){
                    $checkUser = $this->__checkUserExistence($deleteThis);
                    if ($checkUser['rc']){
                        if ($checkUser['rv']){
                            $sqlquery_addUser = "
                                SELECT @userid := id FROM lehrer WHERE mail = '".$deleteThis."';
                                DELETE nm_frage_fragebogen FROM nm_frage_fragebogen LEFT JOIN fragebogen ON nm_frage_fragebogen.bogenid = fragebogen.id WHERE lehrerid = @userid;
                                DELETE bewertungen FROM bewertungen LEFT JOIN fragebogen ON bewertungen.bogenid = fragebogen.id WHERE lehrerid = @userid;
                                DELETE nm_frage_fragebogen FROM nm_frage_fragebogen LEFT JOIN  fragebogen ON nm_frage_fragebogen.bogenid = fragebogen.id WHERE lehrerid = @userid;
                                DELETE verbesserungen FROM verbesserungen LEFT JOIN fragebogen ON verbesserungen.bogenid = fragebogen.id WHERE lehrerid = @userid;
                                DELETE codes FROM codes LEFT JOIN fragebogen ON codes.fragebogenid = fragebogen.id WHERE lehrerid = @userid;
                                DELETE FROM fragebogen WHERE lehrerid = @userid;
                                DELETE FROM fragen WHERE lehrerid = @userid;
                                DELETE FROM lehrer WHERE id = @userid;";
                            $sqlResult = $this->__sendOneToDatabase($sqlquery_addUser, true);
                            if (!$sqlResult['rc']){throw new ErrorException($sqlResult['rv']);}
                            $checkUser = $this->__checkUserExistence($deleteThis);
                            if ($checkUser['rc']){
                                if (!$checkUser['rv']){
                                    $answer = array('rc'=>true,'rv'=>true);
                                }
                            }
                            else{throw new ErrorException($checkUser['rv']);} 
                        }
                        else{$answer = array('rc'=>true,'rv'=>false);}
                    }
                    else{throw new ErrorException($checkUser['rv']);} 
                }
                else{$answer=array('rc'=>true,'rv'=>$authUser['rv']);}
            }
            else{throw new ErrorException($authUser['rv']);}
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    } 

    /**@brief Changes user password
     * @param $userName The username
     * @param $oldPassword The old password
     * @param $newPassword The new password
     * @return array(rc:true,rv:true)||array(rc:false,rv:string)
     */
    function changePassword($userName, $oldPassword, $newPassword){
        try{
            $checkAutUser = $this->authoriseUser($userName, $oldPassword);
            #$this->debugNote($checkAutUser);
            if (!$checkAutUser['rc']) {throw new ErrorException($checkAutUser['rv']);}
            if ($checkAutUser['rv'] == 1 || $checkAutUser['rv'] == 2){
                $chPwResult = $this->__changePassword($userName, $newPassword);
                #$this->debugNote($chPwResult);
                if (!$chPwResult['rc']){throw new ErrorException($chPwResult['rv']);}
                if ($chPwResult['rv'] == 3 || $chPwResult['rv'] == 4 || $chPwResult['rv'] ==5){$answer=array('rc'=>true,'rv'=>$chPwResult['rv']);return;}
                else {$answer = array('rc'=>true,'rv'=>true);}
            }
            else{
                $answer=array('rc'=>true,'rv'=>$checkAutUser['rv']);
            }
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Root password reset
     * @param string $username The root username
     * @param string $password The root password
     * @param string $resetUser The username of the user you want to reset the password
     * @param string $stdPassword The new password of the user
     */
    function resetPassword($username, $password, $resetUser, $stdPassword = 'Administrator'){
        try{
            $authResult = $this->authoriseUser($username, $password);
            if ($authResult['rc']){
                if ($authResult['rv']){
                    $chPwResult = $this->__changePassword($resetUser, $stdPassword);
                    if (!$chPwResult['rc']) {throw new ErrorException($chPwResult['rv']);}
                    $answer = array('rc'=>true,'rv'=>true);
                }
                else{$answer=array('rc'=>true,'rv'=>false);}
            }
            else{throw new ErrorException($authResult['rv']);}
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@details Logs off current user
     * @return array('rc'=>true,'rv'=>true)
     * @except array('rc'=>false,'rv'=>string)
     */
    function logoutUser(){
        try{
            $answer = array('rc'=>true,'rv'=>true);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    function checkLogin($loginflag){
        try{
            $answer = array('rc'=>true,'rv'=>$loginflag);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }
}

// ---------------------------  Legacy  ----------------------------------------------------------------
/** 
    public function loginUserL($mail, $passwort) {
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
    } O

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
    } O

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
    } O

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
    } O

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
    } O

    set std password (root)
*/