<?php

include 'UserAdministration.php';

class phpjsinterface{

function __construct($dbipv4, $dbname, $dbuser, $dbpass){
    $this->userAdministration = new UserAdministration($dbipv4, $dbname, $dbuser, $dbpass);
}

/**@brief Creates errorlog file
 * @param string $lognote string to write to error log
 */
private function _writeLog($lognote){
    $fileName = 'ErrorFile_'.date("Y-m-d-H-i-s-ms").'.txt';
    $myfile = fopen('../logs/'.$fileName, "w") or die($lognote);
    fwrite($myfile, $lognote);
    fclose($myfile);
    return $fileName;
}

/**@brief user login
 * @param string $userName the users username
 * @param string $password the users password
 * @return array ('returncode'=>true,'returnvalue'=>false)
 * @return array ('returncode'=>true, 'returnvalue'=>true)
 * @except array ('returncode'=>false, 'returnvalue'=>string)
 */
function userLogin($userName, $password){
    try{
        $userLogin_Result = $this->userAdministration->loginUser($userName, $password);
        if (!$userLogin_Result['rc']){throw new ErrorException($userLogin_Result['rv']);}
        else{
            if ($userLogin_Result['rv'] === null){$answer =  array('returncode'=>true,'returnvalue'=>false);return;}
            else{
                // Set session vars
                $_SESSION['usermail']   = $userLogin_Result['rv']['usermail'];
                $_SESSION['userisroot'] = $userLogin_Result['rv']['userisroot'];
                $_SESSION['logedIn']    = $userLogin_Result['rv']['logedIn'];
                $_SESSION['clientIp']   = $userLogin_Result['rv']['clientIP'];
                // get last login
                $lastLogin = $this->userAdministration->getLastLogin($_SESSION['usermail']);
                if (!$lastLogin['rc']){throw new ErrorException($lastLogin['rv']);}
                // write to historie
                $writeHistorie_Result = $this->userAdministration->writeHistorie($_SESSION['usermail'], $_SESSION['clientIp'], 'Login');
                if (!$writeHistorie_Result['rc']){throw new ErrorException($writeHistorie_Result['rv']);}
                $answer = array('returncode'=>true, 'returnvalue'=>$lastLogin['rv']);
            }
        }
    }
    catch(ErrorException $error){
        $logNote = strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage();
        $fileName = $this->_writeLog($logNote);
        $answer = array('returncode'=>false, 'returnvalue'=>$fileName);
    }
    finally{return $answer;}

}

/**@brief adding new user to database
 * @param string $userName new user username
 * @param string $firstName new user firstname
 * @param string $lastName new user lastname
 * @param string $password default password
 * @return array ('returncode'=>true,'returnvalue'=>true)
 * @return array ('returncode'=>true,'returnvalue'=>false)
 * @except array('returncode'=>false, 'returnvalue'=>string)
 */
function addUser($userName, $firstName, $lastName, $password){
    try{
        if (!$_SESSION['userisroot']){$answer = false;return;}
        include_once 'UserAdministration.php';
        $addUser_Result = $this->userAdministration->addUser($userName, $firstName, $lastName, $password);
        if (!$addUser_Result['rc']){throw new ErrorException($addUser_Result['rv']);}
        else{
            if (!$addUser_Result['rv']){$answer = array('returncode'=>true,'returnvalue'=>false);}
            elseif ($addUser_Result['rv']){
                // write to historie
                $writeHistorie_Result = $this->userAdministration->writeHistorie($_SESSION['usermail'], $_SESSION['clientIp'], 'Added user: '.$userName);
                if (!$writeHistorie_Result['rc']){throw new ErrorException($writeHistorie_Result['rv']);}
                $answer = array('returncode'=>true,'returnvalue'=>true);
            }
            else{throw new ErrorException($addUser_Result['rv']);}
        } 
    }
    catch(ErrorException $error){
        $logNote = strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage();
        $fileName = $this->_writeLog($logNote);
        $answer = array('returncode'=>false, 'returnvalue'=>$fileName);
    }
    finally{return $answer;}
}

/**@brief changing Password
 * @param string $oldPasswort The users old password
 * @param string $newPasswort The users new password
 * @return array ('returncode'=>true,'returnvalue'=>boolean)
 * @except array('returncode'=>false, 'returnvalue'=>string)
 */
function changePassword($oldPasswort, $newPasswort){
    try{
        include_once 'UserAdministration.php';
        $changePassword_Result = $this->userAdministration->changePassword($_SESSION['usermail'], $oldPasswort, $newPasswort);
        if (!$changePassword_Result['rc']) {throw new ErrorException($changePassword_Result['rv']);}
        else{
            if ($changePassword_Result['rv']==true){$answer = array('returncode'=>true,'returnvalue'=>true);}
            else{
                // write to historie
                $writeHistorie_Result = $this->userAdministration->writeHistorie($_SESSION['usermail'], $_SESSION['clientIp'], 'Changed password');
                if (!$writeHistorie_Result['rc']){throw new ErrorException($writeHistorie_Result['rv']);}
                $answer = array('returncode'=>true,'returnvalue'=>false);} 
        }
    }
    catch(ErrorException $error){
        $logNote = strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage();
        $fileName = $this->_writeLog($logNote);
        $answer = array('returncode'=>false, 'returnvalue'=>$fileName);
    }
    finally{return $answer;}
}

/**@brief Reseting a users password to given password
 * @param string $password Rootuser password
 * @param string $resetUser Username of reseting user
 * @param string $stdPassword New password for reseting user
 * @return array('returncode'=>true, 'returnvalue'=>true)
 * @return array('returncode'=>true, 'returnvalue'=>integer)
 * @except array('returncode'=>false, 'returnvalue'=>string)
 */
function resetPassword($password, $resetUser, $stdPassword){
    try{
        include_once 'UserAdministration.php';
        $resetPassword_Result = $this->userAdministration->resetPassword($_SESSION['usermail'], $password, $resetUser, $stdPassword);
        if (!$resetPassword_Result['rc']){throw new ErrorException($resetPassword_Result['rv']);}
        elseif ($resetPassword_Result['rv']!=true){$answer = array('returncode'=>true, 'returnvalue'=>$resetPassword_Result['rv']);}
        else{
            // write to historie
            $writeHistorie_Result = $this->userAdministration->writeHistorie($_SESSION['usermail'], $_SESSION['clientIp'], 'Reseted passwort for ' . $resetUser);
            if (!$writeHistorie_Result['rc']){throw new ErrorException($writeHistorie_Result['rv']);}
            $answer = array('returncode'=>true, 'returnvalue'=>true);
        }
    }
    catch(ErrorException $error){
        $logNote = strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage();
        $fileName = $this->_writeLog($logNote);
        $answer = array('returncode'=>false, 'returnvalue'=>$fileName);
    }
    finally{return $answer;}
}

/**@brief Checks if user is still loged in
 * @return array ('returncode'=>true, 'returnvalue'=>boolen)
 * @except array('returncode'=>false, 'returnvalue'=>string)
 */
function checkLogin(){
    try{
        include_once 'UserAdministration.php';
        $checkLogin_Result = $this->userAdministration->checkLogin($_SESSION['logedIn']);
        if (!$checkLogin_Result['rc']){throw new ErrorException($changePassword_Result['rv']);}
        elseif($checkLogin_Result['rv']){
            $answer = array('returncode'=>true,'returnvalue'=>true);
        }
        else{
            $answer = array('returncode'=>true,'returnvalue'=>false);
        }
    }
    catch(ErrorException $error){
        $logNote = strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage();
        $fileName = $this->_writeLog($logNote);
        $answer = array('returncode'=>false, 'returnvalue'=>$fileName);
    }
    finally{return $answer;}
}
/**@brief Reseting a users password to given password
 * @param string $password Rootuser password
 * @param string $deleteThis Username of deleting user
 * @return array('returncode'=>true, 'returnvalue'=>true)
 * @return array('returncode'=>true, 'returnvalue'=>int)
 * @except array('returncode'=>false, 'returnvalue'=>string)
 */
function deleteUser($password, $deleteThis){
    try{
        include_once 'UserAdministration.php';
        $deleteUser_Result = $this->userAdministration->deleteUser($_SESSION['usermail'], $password, $deleteThis);
        if (!$deleteUser_Result['rc']){throw new ErrorException($deleteUser_Result['rv']);}
        elseif ($deleteUser_Result['rv']!=true){$answer = array('returncode'=>true, 'returnvalue'=>$deleteUser_Result['rv']);}
        else{
            // write to historie
            $writeHistorie_Result = $this->userAdministration->writeHistorie($_SESSION['usermail'], $_SESSION['clientIp'], 'Deleted User ' . $deleteThis);
            if (!$writeHistorie_Result['rc']){throw new ErrorException($writeHistorie_Result['rv']);}
            $answer = array('returncode'=>true, 'returnvalue'=>true);
        }
    }
    catch(ErrorException $error){
        $logNote = strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage();
        $fileName = $this->_writeLog($logNote);
        $answer = array('returncode'=>false, 'returnvalue'=>$fileName);
    }
    finally{return $answer;}
}

/**@brief Checks if user is still loged in
 * @return array ('returncode'=>true, 'returnvalue'=>boolen)
 * @except array('returncode'=>false, 'returnvalue'=>string)
 */
function getAllUser(){
    try{
        include_once 'UserAdministration.php';
        $checkLogin_Result = $this->userAdministration->getAllUser();
        if (!$checkLogin_Result['rc']){throw new ErrorException($changePassword_Result['rv']);}
        else{$answer = array('returncode'=>true,'returnvalue'=>$checkLogin_Result['rv']);}
    }
    catch(ErrorException $error){
        $logNote = strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage();
        $fileName = $this->_writeLog($logNote);
        $answer = array('returncode'=>false, 'returnvalue'=>$fileName);
    }
    finally{return $answer;}
}
}