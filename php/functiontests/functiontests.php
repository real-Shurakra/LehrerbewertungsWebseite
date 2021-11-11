<?php
if ($_GET['functiontests'] == 'DatabaseControl'){
    include '../DatabaseControl.php';
    $databaseControl = new DatabaseControl("localhost", "root", "", "functiontest");
    echo 'Created new DatabaseControl object<br>';
    echo '--------------------------------------------------------------------------------------------------------<br>';
    $testConnectResult = $databaseControl->connectToDatabase();
    if ($testConnectResult['rc'] != true){echo 'Error while connecting to database:<br>';}
    else{echo 'Database connection established. Status:<br>';}
    var_dump($testConnectResult['rv']);
    echo '<br>';
    echo '--------------------------------------------------------------------------------------------------------<br>';
    $testSendResult = $databaseControl->sendToDB('SELECT * FROM test');
    if ($testSendResult['rc'] != true){echo 'Error while sending to database:<br>';}
    else{echo 'Database send succsessfully. Result:<br>';}
    var_dump($testSendResult['rv']);
    echo '<br>';
    echo '--------------------------------------------------------------------------------------------------------<br>';
    $testDisconnectResult = $databaseControl->disconnectFromDatabase();
    if ($testDisconnectResult['rc'] != true){echo 'Error while disconnecting from database:<br>';}
    else{echo 'Database succsessfully disconected. Result:<br>';}
    var_dump($testDisconnectResult['rv']);
    echo '<br>';
    echo '--------------------------------------------------------------------------------------------------------<br>';
}