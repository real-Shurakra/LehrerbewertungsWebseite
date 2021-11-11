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

    /**
     * @brief Connecting to database
     * @return array(rc:true,rv:string:"connected")
     * @except array(rc:false,rv:string)
     */
    function connectToDatabase() {
        try{
            $this->link = mysqli_connect(
                $this->dbIpv4, 
                $this->dbUser, 
                $this->dbPass, 
                $this->dbName
            );
            if (!$this->link) {throw new ErrorException(mysqli_connect_error());}
            $answer = array(
                'rc'=>true,
                'rv'=>'connected'
            );
        }
        catch (ErrorException $error) {
            $answer = array(
                'rc'=>false,
                'rv'=>$error->getMessage()
            );
        }
        finally{
            return $answer;
        }
    }

    /**
     * @brief sending sqlstring to database
     * @param $sqlString = Sql query
     * @return array(rc:true,rv:mixed)
     * @except array(rc:false,rv:string)
     */
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

    /**
     * @brief Disconnecting from database
     * @return array(rc:true,rv:string:"disconnected")
     * @except array(rc:false,rv:string)
     */
    function disconnectFromDatabase() {
        try{
            $this->link->close();
            $answer = array(
                'rc'=>true,
                'rv'=>'disconected'
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
}