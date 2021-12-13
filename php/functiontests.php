<style>
    * { font-family: Consolas, monaco, monospace; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 20px; } 
    h1 { font-family: Consolas, monaco, monospace; font-size: 24px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px; }
    h2 { font-family: Consolas, monaco, monospace; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px; } 
</style>
<h1>Lehrerbewertungswebseite functiontest:</h1>
<?php

//////////////////////////////////////////  DEBUG  ////////////////////////////////////////////
/**
if (isset($_REQUEST['mode']) == false){
    session_unset();
    $_REQUEST['mode']           = 'getQuestions';

    $_SESSION['usermail']       = 'temp.dump@hotmail.com';
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
*/

include '../conf/config.php';

function schreib($string, $mode, $return){
    if ($mode == 'err'){
        echo '<a style="color:Red"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
      </svg> '.$string.'</a><br>';
      var_dump($return);
      exit();
    }
    if ($mode == 'ok'){
        echo '<a style="color:Green"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
      </svg> '.$string.'</a><br>';
      var_dump($return);
      echo '<br>';
    }
    if ($mode == 'warn'){
        echo '<a style="color:orange"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
      </svg> '.$string.'</a><br>';
      var_dump($return);
      echo '<br>';
    }
}

global $debug;
if (!$debug) {schreib('Debugmode off', 'warn', $debug);exit();}
else{schreib('Debugmode on', 'warn', $debug);}

echo '<h2>Testing UserAuthentification.php</h2>';

echo '----------------------------------------- UserAuthentification creation test ---------------------------<br>';
include 'UserAdministration.php';
$userAdministration = new UserAdministration();
schreib('Created new UserAdministration object', 'ok', true);

echo '----------------------------------------- Autentification Test: normal ---------------------------------<br>';
$lauthoriseUserResult1 = $userAdministration->authoriseUser('l.eerer@schule.de', 'Admin123');
if (
    $lauthoriseUserResult1['rc']&&
    $lauthoriseUserResult1['rv']===1
){
    schreib('Normal autentification test succsessfull.', 'ok', $lauthoriseUserResult1);
}
else{
    schreib('Normal autentification test fail.', 'err', $lauthoriseUserResult1);
}

echo '----------------------------------------- Autentification Test: root -----------------------------------<br>';
$lauthoriseUserResult2 = $userAdministration->authoriseUser('temp.dump@hotmail.com', 'Admin123');
if (
    $lauthoriseUserResult2['rc']&&
    $lauthoriseUserResult2['rv']===2
){
    schreib('Normal autentification test succsessfull.', 'ok', $lauthoriseUserResult2);
}
else{
    schreib('Normal autentification test fail.', 'err', $lauthoriseUserResult2);
}

echo '----------------------------------------- Autentification Test: No User --------------------------------<br>';
$lauthoriseUserResult3 = $userAdministration->authoriseUser('Nope!', 'Admin123');
if (
    $lauthoriseUserResult3['rc']&&
    $lauthoriseUserResult3['rv']===0
){
    schreib('Normal autentification test succsessfull.', 'ok', $lauthoriseUserResult3);
}
else{
    schreib('Normal autentification test fail.', 'err', $lauthoriseUserResult3);
}

echo '----------------------------------------- Autentification Test: Wrong Password -------------------------<br>';
$lauthoriseUserResult3 = $userAdministration->authoriseUser('temp.dump@hotmail.com', 'qwertz00');
if (
    $lauthoriseUserResult3['rc']&&
    $lauthoriseUserResult3['rv']===0
){
    schreib('Normal autentification test succsessfull.', 'ok', $lauthoriseUserResult3);
}
else{
    schreib('Normal autentification test fail.', 'err', $lauthoriseUserResult3);
}

echo '----------------------------------------- Login Test: normal -------------------------------------------<br>';
$loginResult1 = $userAdministration->loginUser('l.eerer@schule.de', 'Admin123');
if ($loginResult1['rc']&&$loginResult1['rv']['usermail']=='l.eerer@schule.de'&&!$loginResult1['rv']['userisroot']&&$loginResult1['rv']['logedIn']){
    schreib('Normal login test succsessfull', 'ok', $loginResult1);
}
else{schreib('Normal login test fail.', 'err', $loginResult1);}

echo '----------------------------------------- Logout Test: normal ------------------------------------------<br>';
$logoutResult1 = $userAdministration->logoutUser();
if (
    $logoutResult1['rc']&&
    $logoutResult1['rv']
){
    schreib('Normal logout test succsessfull', 'ok', $logoutResult1);
}
else{
    schreib('Normal logout test fail.', 'err', $logoutResult1);
}

echo '----------------------------------------- Login Test: root ---------------------------------------------<br>';
$loginResult2 = $userAdministration->loginUser('temp.dump@hotmail.com', 'Admin123');
if (
    $loginResult2['rc']&&
    $loginResult2['rv']['usermail']=='temp.dump@hotmail.com'&&
    $loginResult2['rv']['userisroot']&&
    $loginResult2['rv']['logedIn']
){
    schreib('Root login test succsessfull', 'ok', $loginResult2);
}
else{
    schreib('Root login test fail.', 'err', $loginResult2);
}

echo '----------------------------------------- Logout Test: root --------------------------------------------<br>';
$logoutResult2 = $userAdministration->logoutUser();
if (
    $logoutResult2['rc']&&
    $logoutResult2['rv']
){
    schreib('Root logout test succsessfull', 'ok', $logoutResult2);
}
else{
    schreib('Root logout test fail.', 'err', $logoutResult2);
}

echo '----------------------------------------- Login Test: No user ------------------------------------------<br>';
$loginResult3 = $userAdministration->loginUser('Nope!', '123456789');
if (
    $loginResult3['rc']&&
    $loginResult3['rv']==null
){
    schreib('No user login test succsessfull.', 'ok', $loginResult3);
}
else{
    schreib('No user login test fail.', 'err', $loginResult3);
}

echo '----------------------------------------- Login Test: Wrong password -----------------------------------<br>';
$loginResult3 = $userAdministration->loginUser('temp.dump@hotmail.com', '123456789');
if (
    $loginResult3['rc']&&
    $loginResult3['rv']==null
){
    schreib('No user login test succsessfull.', 'ok', $loginResult3);
}
else{
    schreib('No user login test fail.', 'err', $loginResult3);
}

echo '----------------------------------------- Add user: User exists ----------------------------------------<br>';
$addUserResult1 = $userAdministration->addUser('l.eerer@schule.de', 'Larry', 'Eerer', $stdPassword = 'Administrator');
if (
    $addUserResult1['rc']&&
    !$addUserResult1['rv']
){
    schreib('Add existing user test succsessfull.', 'ok', $addUserResult1);
}
else{
    schreib('Add existing user test fail.', 'err', $addUserResult1);
}

echo '----------------------------------------- Add User Test: Adding new user -------------------------------<br>';
$addUserResult1 = $userAdministration->addUser('test', 'test', 'test', $stdPassword = 'Administrator');
if (
    $addUserResult1['rc']&&
    $addUserResult1['rv']=='Administrator'
){
    schreib('Add new user test succsessfull.', 'ok', $addUserResult1);
}
else{
    schreib('Add new user test fail.', 'err', $addUserResult1);
}

echo '----------------------------------------- Add User Test: Login -----------------------------------------<br>';
$loginResult1 = $userAdministration->loginUser('test', 'Administrator');
if (
    $loginResult1['rc']&&
    $loginResult1['rv']['usermail']=='test'&&
    !$loginResult1['rv']['userisroot']&&
    $loginResult1['rv']['logedIn']
){
    schreib('New user login test succsessfull', 'ok', $loginResult1);
}
else{schreib('New user login test fail.', 'err', $loginResult1);}

echo '----------------------------------------- change Password Test: Wrong Password -------------------------<br>';
$changePassword_WrongOldPassword_Result = $userAdministration->changePassword('test', '12345678', 'Admin123');
if (
    $changePassword_WrongOldPassword_Result['rc']&&
    $changePassword_WrongOldPassword_Result['rv'] === 0
){
    schreib('Wrong password test succsessfull', 'ok', $changePassword_WrongOldPassword_Result);
}
else{schreib('Wrong password test failed', 'err', $changePassword_WrongOldPassword_Result);}

echo '----------------------------------------- change Password Test: Bad Password. To short -----------------<br>';
$changePassword_ToShort_Result = $userAdministration->changePassword('test', 'Administrator', 'Admin');
if (
    $changePassword_ToShort_Result['rc']&&
    $changePassword_ToShort_Result['rv']===3
){
    schreib('Password to short test succsessfull', 'ok', $changePassword_ToShort_Result);
}
else{schreib('Password to short test failed', 'err', $changePassword_ToShort_Result);}

echo '----------------------------------------- change Password Test: Bad Password. Space --------------------<br>';
$changePassword_Space_Result = $userAdministration->changePassword('test', 'Administrator', 'Admi 123');
if (
    $changePassword_Space_Result['rc']&&
    $changePassword_Space_Result['rv']===4
){
    schreib('Password space test succsessfull', 'ok', $changePassword_Space_Result);
}
else{schreib('Password space test failed', 'err', $changePassword_Space_Result);}

echo '----------------------------------------- change Password Test: Bad Password. Semicolon ----------------<br>';
$changePassword_Semicolon_Result = $userAdministration->changePassword('test', 'Administrator', 'Admi;123');
if (
    $changePassword_Semicolon_Result['rc']&&
    $changePassword_Semicolon_Result['rv']===5
){
    schreib('Password semicolon test succsessfull', 'ok', $changePassword_Semicolon_Result);
}
else{schreib('Password semicolon test failed', 'err', $changePassword_Semicolon_Result);}

echo '----------------------------------------- change Password Test: Password ok ----------------------------<br>';
$changePassword_OK_Result = $userAdministration->changePassword('test', 'Administrator', 'Admin123');
if (
    $changePassword_OK_Result['rc']&&
    $changePassword_OK_Result['rv']
){
    schreib('Password ok test succsessfull', 'ok', $changePassword_OK_Result);
}
else{schreib('Password ok test failed', 'err', $changePassword_OK_Result);}

echo '----------------------------------------- Delete User Test: Deleting user no permission ----------------<br>';
$deleteUser_Result = $userAdministration->deleteUser('temp.dump@hotmail.com', 'Admin223', 'Test');
if (
    $deleteUser_Result['rc'] &&
    $deleteUser_Result['rv'] === 0
){
    schreib('Delete user no permission test succsessfull', 'ok', $deleteUser_Result);
}
else{schreib('Delete user no permission test failed', 'err', $deleteUser_Result);}

echo '----------------------------------------- Delete User Test: Deleting user ------------------------------<br>';
$deleteUser_Result = $userAdministration->deleteUser('temp.dump@hotmail.com', 'Admin123', 'Test');
if (
    $deleteUser_Result['rc'] &&
    $deleteUser_Result['rv']
){
    schreib('Delete user test succsessfull', 'ok', $deleteUser_Result);
}
else{schreib('Delete user test failed', 'err', $deleteUser_Result);}