<?php

include 'DatabaseControl.php';

class SchooldataAdministration {

    /**@brief contructor
     * @param string $dbipv4 Databaseserver IPv4 address
     * @param string $dbname Database name
     * @param string $dbuser Database user
     * @param string $dbpass Database user password
     */
    function _construct($dbipv4, $dbname, $dbuser, $dbpass){
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

    /**@brief Adding new class to database
     * @param string $className
     * @param string $studentCount
     * @return array ('rc'=>true,'rv'=>true)
     * @except array ('rc'=>false,'rv'=>string)
     */
    function addClass($className, $studentCount){
        try{
            $sqlquery_addClass = "INSERT INTO klasse(name, schueleranzahl) VALUES ('".$className."', '".$studentCount."');";
            $sqlquery_addClass_Result = $this->_sendOneToDatabase($sqlquery_addClass);
            if (!$sqlquery_addClass_Result['rc']) {throw new ErrorException($sqlquery_addClass_Result['rv']);}
            $answer = array('rc'=>true,'rv'=>true);
        }
        catch(ErrorException $error){$answer = array('returncode'=>false, 'returnvalue'=>$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all class names
     * @return array('rc'=>0,'rv'=>array)
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllClasses() {
        try{
            $sqlquery_getAllClasses = "SELECT name FROM getallclasses";
            $sqlquery_getAllClasses_Result = $this->_sendOneToDatabase($sqlquery_getAllClasses);
            if (!$sqlquery_getAllClasses_Result['rc']) {throw new ErrorException($sqlquery_getAllClasses['rv']);}
            $answer = array('rc'=>0, 'rv'=>$sqlquery_getAllClasses['rv']);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all class names
     * @return array('rc'=>0, 'rv'=>array())
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllDeletedClasses() {
        try{
            $sqlquery_getAllClasses = "SELECT name FROM getallclasses WHERE softdelete = 1";
            $sqlquery_getAllClasses_Result = $this->_sendOneToDatabase($sqlquery_getAllClasses);
            if (!$sqlquery_getAllClasses_Result['rc']) {throw new ErrorException($sqlquery_getAllClasses['rv']);}
            $answer = array('rc'=>0, 'rv'=>$sqlquery_getAllClasses['rv']);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all class names
     * @return array('rc'=>0, 'rv'=>array())
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllNotDeletedClasses() {
        try{
            $sqlquery_getAllClasses = "SELECT name FROM getallclasses WHERE softdelete = 0";
            $sqlquery_getAllClasses_Result = $this->_sendOneToDatabase($sqlquery_getAllClasses);
            if (!$sqlquery_getAllClasses_Result['rc']) {throw new ErrorException($sqlquery_getAllClasses['rv']);}
            $answer = array('rc'=>0, 'rv'=>$sqlquery_getAllClasses['rv']);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Change value of soft delete flag of classes
     * @param string $className Name of class
     * @return array ('rc'=>true,'rv'=>true)
     * @except array ('rc'=>false,'rv'=>string)
     */
    function switchSoftDeleteClasses($className){
        try{
            $sqlquery_switchSoftDeleteClasses = "UPDATE klasse SET softdelete =(CASE WHEN softdelete = 0 THEN 1 ELSE 0 END) WHERE name = '".$className."';";
                $sqlquery_switchSoftDeleteClasses_Result = $this->_sendOneToDatabase($sqlquery_switchSoftDeleteClasses);
            if (!$sqlquery_switchSoftDeleteClasses_Result['rc']) {throw new ErrorException($sqlquery_switchSoftDeleteClasses_Result['rv']);}
            $answer = array('rc'=>true,'rv'=>true);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}

    }

    function addSubject($subjectName){
        try{
            if($_SESSION['userisroot']){
                include_once 'DatabaseControl.php';
                include_once '../conf/config.php';
                global $dbipv4, $dbuser, $dbpass, $dbname;
                // Creating class DatabaseControl object
                $databaseConrtol = new DatabaseControl($dbipv4, $dbuser, $dbpass, $dbname);
                $sqlString = "INSERT INTO fach(name) VALUES('".$subjectName."');";
                $dbReturn = $databaseConrtol->sendOneToDatabase($sqlString);
                if (!$dbReturn['rc']) {throw new ErrorException($dbReturn['rv']);}
                $answer = array('returncode'=>true, 'returnvalue'=>true);
            }
            else{$answer = array('returncode'=>true, 'returnvalue'=>false);}
        }
        catch(ErrorException $error){$answer = array('returncode'=>false, 'returnvalue'=>$error->getMessage());}
        finally{return $answer;}
    }

    function getAllSubjects(){
        global $link;
        $sqlquery_getAlleSchulklassen = "SELECT name FROM fach";
        $sqlquery_getAlleSchulklassen_Result = mysqli_query($link, $sqlquery_getAlleSchulklassen);
        if ($sqlquery_getAlleSchulklassen_Result->num_rows == 0) {
            return array(
                'returncode'=>-1,
                'returnvalue'=>MainInterface::toDE('<strong>Keine Fächer gefunden</strong><br>Es wurden keine Fächer in der Datenbank gefunden.')
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

    function switchSoftDeleteSubjects($subjectName){
        try{
            $sqlquery_switchSoftDeleteClasses = "UPDATE fach SET softdelete =(CASE WHEN softdelete = 0 THEN 1 ELSE 0 END) WHERE name = '".$subjectName."';";
                $sqlquery_switchSoftDeleteClasses_Result = $this->_sendOneToDatabase($sqlquery_switchSoftDeleteClasses);
            if (!$sqlquery_switchSoftDeleteClasses_Result['rc']) {throw new ErrorException($sqlquery_switchSoftDeleteClasses_Result['rv']);}
            $answer = array('returncode'=>true, 'returnvalue'=>true);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}

    }
}