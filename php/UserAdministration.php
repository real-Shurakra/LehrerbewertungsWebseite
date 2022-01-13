<?php
include 'DatabaseControl.php';

class UserAdministration {
    /**Secondary information about class 
     * 
     * Integer returns
     *  - 0 - User not found.
     *  - 1 - User is root.
     *  - 2 - User not root.
     *  - 3 - Password to short. Min 8 chars.
     *  - 4 - Password contains space char.
     *  - 5 - Password contains semicolon char.
     *  - 6 - Deleting user not found.
     *  - 7 - Deleting user found after deleting.
     */

    /**@brief contructor
     * @param string $dbipv4 Databaseserver IPv4 address
     * @param string $dbname Database name
     * @param string $dbuser Database user
     * @param string $dbpass Database user password
     */
    function __construct($dbipv4, $dbname, $dbuser, $dbpass){
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

    /**@brief String encription
     * @details This function provides encription functionallity for generating passwords or spice.
     * @param string $cleanPassword unencripted password
     * @param string $encription Encriptionalgorythm
     * @param string $pepper Password pepper
     * @param string $salt Password salt
     * @return string $antwort = with Sha512 encripted
     */
    protected function _encodeString($cleanPassword, $encription='sha512', $pepper='' ,$salt='') {
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
    protected function _getSpice($userName) {
        try{
            $result = $this->_sendOneToDatabase("SELECT pepper, salt FROM lehrer WHERE mail='".$userName."'");
            if (!$result['rc']) {throw new ErrorException($result['rv']);}
            elseif ($result['rv']==array()) {
                $answer = array(
                    'rc'=>true,
                    'rv'=>false
                );
                Return;}
            else {$answer = array(
                    'rc'=>true,
                    'rv'=>array(
                        'pepper'=>$result['rv'][0]['pepper'],
                        'salt'=>$result['rv'][0]['salt']
                    )
                );            
            }
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Create spice md5 hash
     * @return array(rc:true,rv:array(pepper:string,salt:string))
     * @except array(rc:false,rv:string)
     */
    protected function _makeSpice($userName){
        try{
            $numberMin = 10000000000000;
            $numberMax = 99999999999999;
            // Generating pepper hash
            $clearPepper = rand($numberMin, $numberMax) . $userName . rand($numberMin, $numberMax);
            $pepperhash = $this->_encodeString($clearPepper, 'md5');
            if (!$pepperhash['rc']) {throw new ErrorException($pepperhash['rv']);}
            $pepperhash = $pepperhash['rv'];
            // Generating salt hash
            $clearSalt = rand($numberMin, $numberMax) . $userName . rand($numberMin, $numberMax);
            $salthash = $this->_encodeString($clearSalt, 'md5');
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
    protected function _checkPassword($newPassword){
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
    protected function _changePassword($userName, $newPassword){
        try{
            // Checking password
            $passCheckup = $this->_checkPassword($newPassword);
            if (!$passCheckup['rc']) {throw new ErrorException($passCheckup['rv']);}
            if ($passCheckup['rv']===1) {$answer=array('rc'=>true,'rv'=>3);return;}
            if ($passCheckup['rv']===2) {$answer=array('rc'=>true,'rv'=>4);return;}
            if ($passCheckup['rv']===3) {$answer=array('rc'=>true,'rv'=>5);return;}
            #$this->debugNote($passCheckup);
            // Generating spice
            $spice = $this->_makeSpice($userName);
            if (!$spice['rc']) {throw new ErrorException($spice['rv']);}
            $pepper = $spice['rv']['pepper'];
            $salt = $spice['rv']['salt'];
            // Encripting password
            $password = $this->_encodeString($newPassword, 'sha512', $pepper, $salt);
            if (!$password['rc']) {throw new ErrorException($password['rv']);}
            $password = $password['rv'];
            // Save new password to DB
            $result = $this->_sendOneToDatabase("UPDATE lehrer SET passwort='".$password."', pepper='".$pepper."', salt='".$salt."' WHERE mail='".$userName."'");
            #$this->debugNote($result);
            if (!$result['rc']) {throw new ErrorException($result['rv']);}
            $answer = array('rc'=>true,'rv'=>true);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Checks if user exists
     * @param string $userName username of the user to check
     * @return array ('rc'=>true,'rv'=>false) if user don't exists
     * @return array ('rc'=>true,'rv'=>true) if user exists
     * @except array('rc'=>false, 'rv'=>string)
     */
    protected function _checkUserExistence($userName){
        try{
            $sqlCheckUserExixtence = "SELECT 1 FROM lehrer WHERE mail='".$userName."';";
            $sqlCheckUserExixtence_Result = $this->_sendOneToDatabase($sqlCheckUserExixtence);
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

    /**@brief Write entry to user history
     * @param string $userName username of the current user
     * @param string $clientIP current client ip adress. IPv4, IPv6 and IPv4-mapped IPv6 address are possible. Max 45 chars.
     * @param string $action short description of the users action
     * @return array ('rc'=>true,'rv'=>true)
     * @except array('rc'=>false,'rv'=>string)
     */
    function writeHistorie($userName, $clientIP, $action){
        try{
            $sqlInsertHistorie = "
                INSERT INTO userhistorie
                (userid, clientip, useraction)
                VALUES (
                    (SELECT id FROM lehrer WHERE mail='".$userName."'),
                    '".$clientIP."',
                    '".$action."'
                )";
            $sqlInsertHistorie_Result = $this->_sendOneToDatabase($sqlInsertHistorie);
            if (!$sqlInsertHistorie_Result['rc']){throw new ErrorException($sqlInsertHistorie_Result['rv']);}
            else{$answer = array('rc'=>true,'rv'=>true);}
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get last login time and machine of the given user
     * @param string $username The username
     * @return array('rc'=>true,'rv'=>array('timestamp', 'clientip')
     * @except array('rc'=>false,'rv'=>string)
     */
    function getLastLogin($userName){
        try{
            $sql_getLastLogin = "SELECT timestamp, clientip FROM getuserhistorie WHERE username = '".$userName."' AND useraction = 'Login'";
            $sql_getLastLogin_Result = $this->_sendOneToDatabase($sql_getLastLogin);
            if (!$sql_getLastLogin_Result['rc']) {throw new ErrorException($sql_getLastLogin_Result['rv']);}
            elseif($sql_getLastLogin_Result['rc']==array()){
                $answer = array(
                    'rc'=>true,
                    'rv'=>array(
                        'timestamp'=>false,
                        'clientip'=>false
                    )
                );
            }
            else{
                $answer = array(
                    'rc'=>true,
                    'rv'=>array(
                        'timestamp'=>$sql_getLastLogin_Result['rv'][0]['timestamp'], 
                        'clientip'=>$sql_getLastLogin_Result['rv'][0]['clientip']
                    )
                );
            }
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief get historie of current user
     * @param string $userName of the current user
     * @return array ('rc'=>true,'rv'=>array)
     * @except array('rc'=>false, 'rv'=>string)
     */
    function getUserHistorie($userName){
        try{
            $sqlGetUserHistorie = "SELECT * FROM getuserhistorie WHERE username='".$userName."'";
            $sqlGetUserHistorie_Result = $this->_sendOneToDatabase($sqlGetUserHistorie);
            if (!$sqlGetUserHistorie_Result['rc']){throw new ErrorException($sqlGetUserHistorie_Result['rv']);}
            else{$answer = array('rc'=>true,'rv'=>$sqlGetUserHistorie_Result['rv']);}
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief get historie of all users
     * @return array ('rc'=>true,'rv'=>array)
     * @except array('rc'=>false, 'rv'=>string)
     */
    function geAllUserHistorie(){
        try{
            $sqlGetUserHistorie = "SELECT * FROM getuserhistorie";
            $sqlGetUserHistorie_Result = $this->_sendOneToDatabase($sqlGetUserHistorie);
            if (!$sqlGetUserHistorie_Result['rc']){throw new ErrorException($sqlGetUserHistorie_Result['rv']);}
            else{$answer = array('rc'=>true,'rv'=>$sqlGetUserHistorie_Result['rv']);}
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
            $passCheckup = $this->_checkPassword($password);
            if (!$passCheckup['rc']) {throw new ErrorException($passCheckup['rv']);}
            if ($passCheckup['rv']===1) {$answer=array('rc'=>true,'rv'=>3);return;}
            if ($passCheckup['rv']===2) {$answer=array('rc'=>true,'rv'=>4);return;}
            if ($passCheckup['rv']===3) {$answer=array('rc'=>true,'rv'=>5);return;}
            // Encripting clean password
            $passEncodeOne = $this->_encodeString($password);
            if (!$passEncodeOne['rc']) {throw new ErrorException($passEncodeOne['rv']);}
            $password = $passEncodeOne['rv'];
            // Getting spice
            $spice = $this->_getSpice($userName);
            if (!$spice['rc']){throw new ErrorException($spice['rv']);}
            if (!$spice['rv']){$answer = array('rc'=>true,'rv'=>0);return;}
            $pepper = $spice['rv']['pepper'];
            $salt = $spice['rv']['salt'];
            // Encripting encripted password with spice
            $passEncodeTwo = $this->_encodeString($password, 'sha512', $pepper, $salt);
            if (!$passEncodeTwo['rc']) {throw new ErrorException($passEncodeTwo['rv']);}
            $password = $passEncodeTwo['rv'];
            // Check if user exists
            $sqlCheckUser = "SELECT isroot FROM lehrer WHERE mail='".$userName."' AND passwort='".$password."'";
            $result = $this->_sendOneToDatabase($sqlCheckUser);
            if (!$result['rc']) {throw new ErrorException($result['rv']);}
            if ($result['rv'] === array()) {$answer = array('rc'=>true,'rv'=>0);return;} // User not in database
            if ($result['rv'][0]['isroot'] === '1') {$answer=array('rc'=>true,'rv'=>2);} // User is root
            elseif ($result['rv'][0]['isroot'] === '0') {$answer=array('rc'=>true,'rv'=>1);} // User not root
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
                if ($checkUser['rv']===1){$answer =  array ('rc'=>true, 'rv'=>array('logedIn'=>true, 'usermail'=>$userName, 'userisroot'=>false, 'clientIP'=>$_SERVER['REMOTE_ADDR']));}
                elseif($checkUser['rv']===2){$answer =  array ('rc'=>true, 'rv'=>array('logedIn'=>true, 'usermail'=>$userName, 'userisroot'=>true, 'clientIP'=>$_SERVER['REMOTE_ADDR']));}
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
            $userExists = $this->_sendOneToDatabase("SELECT 1 FROM lehrer WHERE mail='".$mail."'");
            if (!$userExists['rc']) {throw new ErrorException($userExists['rv']);}
            if ($userExists['rv'] != array()) {$answer=array('rc' => true,'rv' =>false);return;}
            // Checking password
            $passCheckup = $this->_checkPassword($stdPassword);
            if (!$passCheckup['rc']) {throw new ErrorException($passCheckup['rv']);}
            // Generating spice
            $genSpice = $this->_makeSpice($mail);
            if (!$genSpice['rc']) {throw new ErrorException($genSpice['rv']);}
            $pepper = $genSpice['rv']['pepper'];
            $salt = $genSpice['rv']['salt'];
            // Encripting clean password
            $passEncodeOne = $this->_encodeString($stdPassword);
            if (!$passEncodeOne['rc']) {throw new ErrorException($passEncodeOne['rv']);}
            $password = $passEncodeOne['rv'];
            // Encripting encripted password with spice
            $genpass = $this->_encodeString($password, 'sha512', $pepper, $salt);
            if (!$genpass['rc']) {throw new ErrorException($genpass['rv']);}
            $password = $genpass['rv'];
            // User register
            $sqlquery_addUser1 = "
            INSERT INTO lehrer(id, mail, vorname, nachname, passwort, isroot, pepper, salt) 
            VALUES (DEFAULT,'".$mail."','".$firstname."','".$lastname."','".$password."',FALSE,'".$pepper."','".$salt."');";
            $sqlquery_addUser2 = "INSERT INTO fragen(frage, kategorie, lehrerid) 
            SELECT frage, kategorie, (SELECT id FROM lehrer WHERE mail = '".$mail."') FROM fragentemplate;";
            $sqlResult =$this->_sendOneToDatabase($sqlquery_addUser1);
            if (!$sqlResult['rc']) {throw new ErrorException($sqlResult['rv']);}
            $sqlResult =$this->_sendOneToDatabase($sqlquery_addUser2);
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
                    $checkUser = $this->_checkUserExistence($deleteThis);
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
                            $sqlResult = $this->_sendOneToDatabase($sqlquery_addUser, true);
                            if (!$sqlResult['rc']){throw new ErrorException($sqlResult['rv']);}
                            $checkUserAgain = $this->_checkUserExistence($deleteThis);
                            if ($checkUserAgain['rc']){
                                if (!$checkUserAgain['rv']){
                                    $answer = array('rc'=>true,'rv'=>true);
                                }
                                else{$answer = array('rc'=>true,'rv'=>7);}
                            }
                            else{throw new ErrorException($checkUser['rv']);} 
                        }
                        else{$answer = array('rc'=>true,'rv'=>6);}
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
                $chPwResult = $this->_changePassword($userName, $newPassword);
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
                    $chPwResult = $this->_changePassword($resetUser, $stdPassword);
                    if (!$chPwResult['rc']) {throw new ErrorException($chPwResult['rv']);}
                    elseif ($chPwResult['rv']) {$answer = array('rc'=>true,'rv'=>true);}
                    else{$answer = array('rc'=>true,'rv'=>$chPwResult['rv']);}
                }
                else{$answer=array('rc'=>true,'rv'=>false);}
            }
            else{throw new ErrorException($authResult['rv']);}
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Logs off current user
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

    /**@brief checks if the current user is still loged in
     * @param boolean $loginflag the login flag
     * @return array ('rc'=>true,'rv'=>true) if loged in
     * @return array ('rc'=>true,'rv'=>false) if not loged in
      */
    function checkLogin($loginflag){
        try{
            $answer = array('rc'=>true,'rv'=>$loginflag);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get user information
     * @param boolean $rootFlag The flag if user is root
     * @return array ('rc'=>true,'rv'=>array)
     * @return array ('rc'=>true,'rv'=>false)
     * @except array('rc'=>false, 'rv'=>string)
     */
    function getAllUser($rootFlag){
        try{
            if ($rootFlag) {
                $sqlGetUserHistorie = "SELECT * FROM getalluser;";
                $sqlGetUserHistorie_Result = $this->_sendOneToDatabase($sqlGetUserHistorie);
                if (!$sqlGetUserHistorie_Result['rc']){throw new ErrorException($sqlGetUserHistorie_Result['rv']);}
                else{$answer = array('rc'=>true,'rv'=>$sqlGetUserHistorie_Result['rv']);}
            }
            else{$answer = array('rc'=>true,'rv'=>false);}
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }
}