<?php
/**
 * @brief MySQL database connection 
 * @details 
 * @param string $dbIpv4 = IPv4 Adress of the database server
 * @param string $dbUser = User for database
 * @param string $dbPass = Userpassword
 * @param string $dbName = Database name
 */
class DatabaseControl {
    function __construct($dbIpv4, $dbUser, $dbPass, $dbName){
        $this->dbIpv4 = $dbIpv4;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->dbName = $dbName;
    }

    private function debugNote($note){
        echo'<br>';
        echo '<a style="color:orange"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
      </svg> '.debug_backtrace()[1]['class'].'.'.debug_backtrace()[1]['function'].' at '.debug_backtrace()[0]['file'].' line '.debug_backtrace()[0]['line'].': ';
        var_dump($note);
        echo'</a><br>';
    }

    /**
     * @brief Connecting to database
     * @return array(rc:true,rv:string:"connected")
     * @except array(rc:false,rv:string)
     */
    protected function _connectToDatabase() {
        try{
            $this->link = mysqli_connect($this->dbIpv4, $this->dbUser, $this->dbPass, $this->dbName);
            if (!$this->link) {throw new ErrorException(mysqli_connect_error());}
            $answer = array('rc'=>true,'rv'=>'connected');
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**
     * @brief sending sqlstring to database
     * @param $sqlString = Sql query
     * @return array(rc:true,rv:mixed)
     * @except array(rc:false,rv:string)
     */
    protected function _sendOneToDB($sqlString) {
        try{
            $sqlquaryResultData=array();
            ##var_dump($sqlString);
            $sqlquaryResult = mysqli_query($this->link, $sqlString);
            #var_dump($sqlquaryResult);
            if (!$sqlquaryResult) {throw new ErrorException($this->link->error);}
            if ($sqlquaryResult===true) {$answer=array('rc'=>true,'rv'=>true);return;}
            for ($i = 0; $i < $sqlquaryResult->num_rows; $i++) {$sqlquaryResultData[$i] = mysqli_fetch_array($sqlquaryResult);}
            $answer = array('rc'=>true,'rv'=>$sqlquaryResultData);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    protected function _sendMoreToDB($sqlString) {
        try{
            $sqlquaryResultData=array();
            ##var_dump($sqlString);
            $sqlquaryResult = mysqli_multi_query($this->link, $sqlString);
            #var_dump($sqlquaryResult);
            if (!$sqlquaryResult) {throw new ErrorException($this->link->error);}
            if ($sqlquaryResult===true) {$answer=array('rc'=>true,'rv'=>true);return;}
            for ($i = 0; $i < $sqlquaryResult->num_rows; $i++) {$sqlquaryResultData[$i] = mysqli_fetch_array($sqlquaryResult);}
            $answer = array('rc'=>true,'rv'=>$sqlquaryResultData);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**
     * @brief Disconnecting from database
     * @return array(rc:true,rv:string:"disconnected")
     * @except array(rc:false,rv:string)
     */
    protected function _disconnectFromDatabase() {
        try{
            $this->link->close();
            $answer = array('rc'=>true,'rv'=>'disconected');
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Database interface
     * @param string $sqlString SQL formated string
     * @return array(rc:true,rv:array(mixed))||array(rc:false,rv:string)
     */
    function sendOneToDatabase($sqlString){
        try{
            // Geting DB information
            // Connecting to DB
            $connectionResult = $this->_connectToDatabase();
            if (!$connectionResult['rc']) {throw new ErrorException($connectionResult['rv']);}
            // Sending sql querry
            $SendResult = $this->_sendOneToDB($sqlString);
            if ($SendResult['rc'] == false) {throw new ErrorException($SendResult['rv']);}
            // Disconnecting DB
            $this->_disconnectFromDatabase();
            // Formating answer
            $answer = array('rc'=>true, 'rv'=>$SendResult['rv']);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    function sendMultipleToDatabase($sqlString){
        try{
            // Geting DB information
            // Connecting to DB
            $connectionResult = $this->_connectToDatabase();
            if (!$connectionResult['rc']) {throw new ErrorException($connectionResult['rv']);}
            // Sending sql querry
            $SendResult = $this->_sendMoreToDB($sqlString);
            if ($SendResult['rc'] == false) {throw new ErrorException($SendResult['rv']);}
            // Disconnecting DB
            $this->_disconnectFromDatabase();
            // Formating answer
            $answer = array('rc'=>true, 'rv'=>$SendResult['rv']);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }
}