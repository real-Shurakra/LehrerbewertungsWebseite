<style>
    * { font-family: Consolas, monaco, monospace; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 20px; } 
    h1 { font-family: Consolas, monaco, monospace; font-size: 24px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px; }
    h2 { font-family: Consolas, monaco, monospace; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px; } 
</style>
<h1>Lehrerbewertungswebseite functiontest:</h1>
<?php
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

echo '<h2>Testing DatabaseControl.php</h2>';
echo '----------------------------------------- DatabaseControl creation test --------------------------------<br>';
include 'DatabaseControl.php';
$databaseControl = new DatabaseControl("localhost", "root", "", "lehrerbewertungsdatenbank");
schreib('Created new DatabaseControl object.', 'ok', true);

echo '----------------------------------------- Database connection test -------------------------------------<br>';
$testConnectResult = $databaseControl->connectToDatabase();
if ($testConnectResult['rc'] != true){schreib('Error while connecting to database:', 'err', $testConnectResult);}
else{schreib('Database connection established.', 'ok', $testConnectResult);}

echo '----------------------------------------- Database send test -------------------------------------------<br>';
$testSendResult = $databaseControl->sendToDB('SELECT * FROM fach');
if ($testSendResult['rc'] != true){schreib('Error while sending to database:', 'err', $testSendResult);}
else{schreib('Database send succsessfully.','ok', $testSendResult);}

echo '----------------------------------------- Database disconnetion test -----------------------------------<br>';
$testDisconnectResult = $databaseControl->disconnectFromDatabase();
if ($testDisconnectResult['rc'] != true){schreib('Error while disconnecting from database:', 'err', $testDisconnectResult);}
else{schreib('Database succsessfully disconected.', 'ok', $testDisconnectResult);}

echo '--------------------------------------------------------------------------------------------------------<br>';
echo '<h2>Testing UserAuthentification.php</h2>';

echo '----------------------------------------- UserAuthentification creation test ---------------------------<br>';
include 'UserAdministration.php';
$userAdministration = new UserAdministration();
schreib('Created new UserAdministration object', 'ok', true);

echo '----------------------------------------- Autentification Test: normal ---------------------------------<br>';
$lauthoriseUserResult1 = $userAdministration->authoriseUser('l.eerer@schule.de', 'Admin123');
if ($lauthoriseUserResult1['rc']&&!$lauthoriseUserResult1['rv']){schreib('Normal autentification test succsessfull.', 'ok', $lauthoriseUserResult1);}
else{schreib('Normal autentification test fail.', 'err', $lauthoriseUserResult1);}

echo '----------------------------------------- Autentification Test: root -----------------------------------<br>';
$lauthoriseUserResult2 = $userAdministration->authoriseUser('temp.dump@hotmail.com', 'Admin123');
if ($lauthoriseUserResult2['rc']&&$lauthoriseUserResult2['rv']){schreib('Normal autentification test succsessfull.', 'ok', $lauthoriseUserResult2);}
else{schreib('Normal autentification test fail.', 'err', $lauthoriseUserResult2);}

echo '----------------------------------------- Autentification Test: No User --------------------------------<br>';
$lauthoriseUserResult3 = $userAdministration->authoriseUser('Nope!', 'Admin123');
if (!$lauthoriseUserResult3['rc']&&!$lauthoriseUserResult3['rv']){schreib('Normal autentification test succsessfull.', 'ok', $lauthoriseUserResult3);}
else{schreib('Normal autentification test fail.', 'err', $lauthoriseUserResult3);}

echo '----------------------------------------- Login Test: normal -------------------------------------------<br>';
$loginResult1 = $userAdministration->loginUser('l.eerer@schule.de', 'Admin123');
if ($loginResult1['rc']&&!$loginResult1['rv']&&$_SESSION['usermail']=='l.eerer@schule.de'&&!$_SESSION['userisroot']&&$_SESSION['logedIn']){
    schreib('Normal login test succsessfull', 'ok', array($loginResult1, $_SESSION));
}
else{schreib('Normal login test fail.', 'err', array($loginResult1, $_SESSION));}

echo '----------------------------------------- Logout Test: normal ------------------------------------------<br>';
$logoutResult1 = $userAdministration->logoutUser();
if ($logoutResult1['rc']&&$logoutResult1['rv']&&$_SESSION['usermail']==null&&!$_SESSION['userisroot']&&!$_SESSION['logedIn']){
    schreib('Normal logout test succsessfull', 'ok', array($logoutResult1, $_SESSION));
}
else{schreib('Normal logout test fail.', 'err', array($logoutResult1, $_SESSION));}

echo '----------------------------------------- Login Test: root ---------------------------------------------<br>';
$loginResult2 = $userAdministration->loginUser('temp.dump@hotmail.com', 'Admin123');
if ($loginResult2['rc']&&$loginResult2['rv']&&$_SESSION['usermail']=='temp.dump@hotmail.com'&&$_SESSION['userisroot']&&$_SESSION['logedIn']){
    schreib('Root login test succsessfull', 'ok', array($loginResult2, $_SESSION));
}
else{schreib('Root login test fail.', 'err', array($loginResult2, $_SESSION));}

echo '----------------------------------------- Logout Test: root --------------------------------------------<br>';
$logoutResult2 = $userAdministration->logoutUser();
if ($logoutResult2['rc']&&$logoutResult2['rv']&&$_SESSION['usermail']==null&&!$_SESSION['userisroot']&&!$_SESSION['logedIn']){
    schreib('Root logout test succsessfull', 'ok', array($logoutResult2, $_SESSION));
}
else{schreib('Root logout test fail.', 'err', array($logoutResult2, $_SESSION));}

echo '----------------------------------------- Login Test: No user ------------------------------------------<br>';
$loginResult3 = $userAdministration->loginUser('Nope!', '123456789');
if (!$loginResult3['rc']&&!$loginResult3['rv']&&$_SESSION['usermail']==null&&!$_SESSION['userisroot']&&!$_SESSION['logedIn']){
    schreib('No user login test succsessfull.', 'ok', array($loginResult3, $_SESSION));
}
else{schreib('No user login test fail.', 'err', array($loginResult3, $_SESSION));}

echo '----------------------------------------- Add user: User exists--------------------------------------------------------------<br>';
$addUserResult1 = $userAdministration->addUser('l.eerer@schule.de', 'Larry', 'Eerer', $stdPassword = 'Administrator');
if ($addUserResult1['rc']&&!$addUserResult1['rv']){
    schreib('Add existing user test succsessfull.', 'ok', $addUserResult1);
}
else{schreib('Add existing user test fail.', 'err', $addUserResult1);}

echo '----------------------------------------- Add User Test: Adding new user -------------------------------<br>';
$addUserResult1 = $userAdministration->addUser('test', 'test', 'test', $stdPassword = 'Administrator');
if ($addUserResult1['rc']&&$addUserResult1['rv']=='Administrator'){
    schreib('Add new user test succsessfull.', 'ok', $addUserResult1);
}
else{schreib('Add new user test fail.', 'err', $addUserResult1);}

echo '----------------------------------------- Add User Test: Login -----------------------------------------<br>';
$loginResult1 = $userAdministration->loginUser('test', 'Administrator');
if ($loginResult1['rc']&&!$loginResult1['rv']&&$_SESSION['usermail']=='test'&&!$_SESSION['userisroot']&&$_SESSION['logedIn']){
    schreib('New user login test succsessfull', 'ok', array($loginResult1, $_SESSION));
}
else{schreib('New user login test fail.', 'err', array($loginResult1, $_SESSION));}

echo '----------------------------------------- change Password Test: Wrong Password -------------------------<br>';
echo '----------------------------------------- change Password Test: Bad Password. To short -----------------<br>';
echo '----------------------------------------- change Password Test: Bad Password. Space --------------------<br>';
echo '----------------------------------------- change Password Test: Bad Password. Semicolon ----------------<br>';
echo '----------------------------------------- change Password Test: Password ok ----------------------------<br>';
echo '----------------------------------------- Delete User Test: Deleting user ------------------------------<br>';
echo '----------------------------------------- Delete User Test: Login --------------------------------------<br>';