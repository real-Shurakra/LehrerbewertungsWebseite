<?php
/**
 * @brief MySQL database connection 
 * @details 
 * @param string $dbIpv4 = IPv4 Adress of the database server
 * @param string $dbUser = User for database
 * @param string $dbPass = Userpassword
 * @param string $dbName = 
 * @note In der Datei 'save.php' stehen die Variablen die bei der Verschluesselnug benoetigt werden.
 */
class DatabaseControl {
    function __construct($dbIpv4, $dbUser, $dbPass, $dbName){
        $this->dbIpv4 = $dbIpv4;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
    }

    function connectToDatabase() {
        try{
            $this->link = mysqli_connect(
                $this->dbIpv4, 
                $this->dbUser, 
                $this->dbPass, 
                $this->dbName
            );
            if (!$this->link) {
                echo "Error: Can't connect to MySQL database." . PHP_EOL;
                echo "Errornnumber: " . mysqli_connect_errno() . PHP_EOL;
                echo "Errormassage: " . mysqli_connect_error() . PHP_EOL;
                throw new ErrorException('no connection');
            }
            $answer = array(
                'rc'=>true,
                'rv'=>'connected'
            );
        }
        catch (ErrorException $error) {
            $answer = array(
                'rc'=>true,
                'rv'=>$error->getMessage()
            );
        }
        finally{
            return $answer;
        }
    }

    function sendToDB($sqlString) {
        try{
            $sqlquaryResultData=array();
            $sqlquaryResult = mysqli_query($this->link, $sqlString);
                if (!$sqlquaryResult) {throw new Exception($this->link->error);}
            for ($i = 0; $i < $sqlquaryResult->num_rows; $i++) {$sqlquaryResultData[$i] = mysqli_fetch_array($sqlquaryResult);}
            $answer = array(
                'rc'=>true,
                'rv'=>$sqlquaryResultData
            );
        }
        catch(ErrorException $error){
            $answer = array(
                'rc'=>false,
                'rv'=>$error->getMessage()
            );
        }
        finally{
            return $answer;
        }
    }

    function disconnectFromDatabase() {
        try{
            $this->link->close();
            try{
                $this->link->ping();
                $answer = array(
                    'rc'=>false,
                    'rv'=>'connected'
                ); 
            }
            catch(ErrorException $error){
                $answer = array(
                    'rc'=>true,
                    'rv'=>'disconected'
                );
            }
        }
        catch(ErrorException $error){
            $answer = array(
                'rc'=>false,
                'rv'=>$error->getMessage()
            );
        }
        finally{
            return $answer;
        }
    }
}

if ($_GET['functiontest'] = 'yes'){
    $databaseControl = new DatabaseControl("localhost", "root", "", "functiontest");
    echo 'Created new DatabaseControl object<br>';
    echo '--------------------------------------------------------------------------------------------------------<br>';
    $testConnectResult = $databaseControl->connectToDatabase();
    if ($testConnectResult['rc'] != true){
        echo 'Error while connecting to database:<br>';
        var_dump($testConnectResult['rv']);
        echo '<br>';
    }
    else{
        echo 'Database connection established. Status:<br>';
        var_dump($testConnectResult['rv']);
        echo '<br>';
    }
    echo '--------------------------------------------------------------------------------------------------------<br>';

    $testSendResult = $databaseControl->sendToDB('SELECT * FROM test');
    if ($testSendResult['rc'] != true){
        echo 'Error while sending to database:<br>';
        var_dump($testSendResult['rv']);
        echo '<br>';
    }
    else{
        echo 'Database send succsessfully. Result:<br>';
        var_dump($testSendResult['rv']);
        echo '<br>';
    }
    echo '--------------------------------------------------------------------------------------------------------<br>';
    $testDisconnectResult = $databaseControl->disconnectFromDatabase();
    if ($testDisconnectResult['rc'] != true){
        echo 'Error while disconnecting from database: ' . $testDisconnectResult['rv'] . '<br>';
    }
    else{
        echo 'Database succsessfully disconected. Result:<br>';
        var_dump($testDisconnectResult['rv']);
        echo '<br>';
    }
    echo '--------------------------------------------------------------------------------------------------------<br>';

}

// Die Adresse des Datenbankservers
$dbipv4 = "localhost";
// Name des Benutzerkontos 
$dbuser = "root";
// Passwort des Benutzerkontos (Leerer String wenn keins vergeben wurde.)
$dbpass = "";
// Name der Datenbank
$dbname = "lehrerbewertungsdatenbank";