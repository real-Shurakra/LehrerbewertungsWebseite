<?
class SchoolDataAdministration{
    function _construct(){}

    /**@brief Database interface
     * @param string $sqlString SQL formated string
     * @return array(rc:true,rv:array(mixed))||array(rc:false,rv:string)
     */
    protected function _sendOneToDatabase($sqlString){
        try{
            include_once 'DatabaseControl.php';
            include_once '../conf/config.php';
            global $dbipv4, $dbuser, $dbpass, $dbname;
            // Creating class DatabaseControl object
            $databaseConrtol = new DatabaseControl($dbipv4, $dbuser, $dbpass, $dbname);
            return $databaseConrtol->sendOneToDatabase($sqlString);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>'SchoolDataAdministration._sendOneToDatabase->'.$error->getMessage());}
        finally{return $answer;}
    }

    function getAllClasses() {
        try{
            $sqlResult = $this->_sendOneToDatabase("SELECT name FROM klasse");
            if ($sqlResult->num_rows == 0) {
                return array(
                    'returncode'=>-1,
                    'returnvalue'=>main::toDE('<strong>Keine Klassen gefunden</strong><br>Es wurden keine Schulklassen in der Datenbank gefunden.')
                );
            }
            $answer = array();
            for ($i=0; $i < $sqlResult->num_rows; $i++) { 
                $sqlquery_getAlleSchulklassen_Result_Data[$i] = mysqli_fetch_array($sqlResult);
                array_push($answer, $sqlquery_getAlleSchulklassen_Result_Data[$i]['name']);
            }
            $answer = array(
                'rc'=>0,
                'rv'=>$answer
            );
        }
        catch (ErrorException $error) {$answer = array ('rc'=>false,'rv'=>'SchoolDataAdministration.getAllClasses->'.$error->getMessage());}
        finally{return $answer;}
    }

    function getAllSubjects(){
        global $link;
        $sqlquery_getAlleSchulklassen = "SELECT name FROM fach";
        $sqlquery_getAlleSchulklassen_Result = mysqli_query($link, $sqlquery_getAlleSchulklassen);
        if ($sqlquery_getAlleSchulklassen_Result->num_rows == 0) {
            return array(
                'returncode'=>-1,
                'returnvalue'=>main::toDE('<strong>Keine Fächer gefunden</strong><br>Es wurden keine Fächer in der Datenbank gefunden.')
            );
        }
        $answer = array();
        for ($i=0; $i < $sqlquery_getAlleSchulklassen_Result->num_rows; $i++) { 
            $sqlquery_getAlleSchulklassen_Result_Data[$i] = mysqli_fetch_array($sqlquery_getAlleSchulklassen_Result);
            array_push($answer, $sqlquery_getAlleSchulklassen_Result_Data[$i]['name']);
        }
        return array(
            'returncode'=>0,
            'returnvalue'=>$answer
        );
    }
}