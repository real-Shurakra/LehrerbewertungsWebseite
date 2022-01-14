<style>
    * { font-family: Consolas, monaco, monospace; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 20px; } 
    h1 { font-family: Consolas, monaco, monospace; font-size: 24px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 26.4px; }
    h2 { font-family: Consolas, monaco, monospace; font-size: 14px; font-style: normal; font-variant: normal; font-weight: 700; line-height: 15.4px; } 
</style>
<h1>Lehrerbewertungswebseite functiontest:</h1>
<?php

include "MainInterface.php";

session_start();
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

function schreib($string, $mode, $return){
    if ($mode == 'err'){
        echo '<a style="color:Red"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
      </svg> '.$string.'</a><br>';
      var_dump($return);
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
$jsablauf = new MainInterface();
$test = $jsablauf->executeOrder($_REQUEST['mode']);
if ($test['rc']) {
    schreib('Test erfolgreich', 'ok', $test);
}
elseif (!$test['rc']) {
    schreib('Test fehlgeschlagen', 'err', $test);
}
else {
    schreib('Unerwartetes Ergebniss', 'warn', $test);
}