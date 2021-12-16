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
     * @return array ('rc'=>true,'rv'=>integer)
     *  - 0 = New class added
     *  - 1 = Class allready exists
     *  - 2 = Could nor add class
     * @except array ('rc'=>false,'rv'=>string)
     */
    protected function _sendOneToDatabase(string $sqlString, bool $moreThanOne=false){
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

    // Class functions

    /**@brief Adding new class to database
     * @param string $className
     * @param string $studentCount
     * @return array ('rc'=>true,'rv'=>true)
     * @except array ('rc'=>false,'rv'=>string)
     */
    function addClass(string $className, string $studentCount){
        try{
            // Check if class is allready in database
            $sqlquery_addSubjectExists = "SELECT 1 FROM klasse WHERE name = '".$className."';";
            $sqlquery_addSubjectExists_Return = $this->_sendOneToDatabase($sqlquery_addSubjectExists);
            if (!$sqlquery_addSubjectExists_Return['rc']) {throw new ErrorException($sqlquery_addSubjectExists_Return['rv']);}
            if ($sqlquery_addSubjectExists_Return['rv'] != array()) {$answer= array('rc'=>true, 'rv'=>1);Return;}

            $sqlquery_addClass = "INSERT INTO klasse(name, schueleranzahl) VALUES ('".$className."', '".$studentCount."');";
            $sqlquery_addClass_Result = $this->_sendOneToDatabase($sqlquery_addClass);
            if (!$sqlquery_addClass_Result['rc']) {throw new ErrorException($sqlquery_addClass_Result['rv']);}

            // check if class is in database
            $sqlquery_addSubjectExists = "SELECT 1 FROM klasse WHERE name = '".$className."';";
            $sqlquery_addSubjectExists_Return = $this->_sendOneToDatabase($sqlquery_addSubjectExists);
            if (!$sqlquery_addSubjectExists_Return['rc']) {throw new ErrorException($sqlquery_addSubjectExists_Return['rv']);}
            if ($sqlquery_addSubjectExists_Return['rv'] == array()) {$answer= array('rc'=>true, 'rv'=>2);Return;}

            $answer = array('rc'=>true,'rv'=>0);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>$error->getMessage());}
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

    /**@brief Get all deleted class names
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

    /**@brief Get all not deleted class names
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
    function switchSoftDeleteClasses(string $className){
        try{
            $sqlquery_switchSoftDeleteClasses = "UPDATE klasse SET softdelete =(CASE WHEN softdelete = 0 THEN 1 ELSE 0 END) WHERE name = '".$className."';";
                $sqlquery_switchSoftDeleteClasses_Result = $this->_sendOneToDatabase($sqlquery_switchSoftDeleteClasses);
            if (!$sqlquery_switchSoftDeleteClasses_Result['rc']) {throw new ErrorException($sqlquery_switchSoftDeleteClasses_Result['rv']);}
            $answer = array('rc'=>true,'rv'=>true);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}

    }

    /**@brief Renameing exsisting class
     * @param string $oldClassName The class to rename
     * @param string $newClassName The new name for class
     * @return array ('rc'=>true,'rv'=>int)
     *  - 0 = Class renamed
     *  - 1 = Class not found
     *  - 2 = Class could not be renamed
     * @except array ('rc'=>false,'rv'=>string)
     * @todo programming
     */
    function renameClass(string $oldClassName, string $newClassName) {
        try{
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
        
    }

    /**@brief editing the classes student count
     * @param string $className The class
     * @param int $newStudentCount 
     * @return array ('rc'=>true,'rv'=>int)
     *  - 0 = Student count edited
     *  - 1 = Class not found
     *  - 2 = Student count could not be edited
     * @except array ('rc'=>false,'rv'=>string)
     * @todo programming
     */
    function editClassStudentCount(string $className, int $newStudentCount) {
        try{
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
        
    }

    // Subject functions

    /**@brief Adding new subject
     * @param string $subjectName
     * @return array ('rc'=>true, 'rv'=>integer)
     *  - 0 = New subject added
     *  - 1 = Subject allready exists
     *  - 2 = Could nor add subject
     * @except array ('rc'=>false,'rv'=>string)
     */
    function addSubject(string $subjectName){
        try{
            // Check if subject is allready in database
            $sqlquery_addSubjectExists = "SELECT 1 FROM fach WHERE name = '".$subjectName."';";
            $sqlquery_addSubjectExists_Return = $this->_sendOneToDatabase($sqlquery_addSubjectExists);
            if (!$sqlquery_addSubjectExists_Return['rc']) {throw new ErrorException($sqlquery_addSubjectExists_Return['rv']);}
            if ($sqlquery_addSubjectExists_Return['rv'] != array()) {$answer= array('rc'=>true, 'rv'=>1);Return;}

            // Insert new subject
            $sqlquery_addSubject = "INSERT INTO fach(name) VALUES('".$subjectName."');";
            $sqlquery_addSubject_Return = $this->_sendOneToDatabase($sqlquery_addSubject);
            if (!$sqlquery_addSubject_Return['rc']) {throw new ErrorException($sqlquery_addSubject_Return['rv']);}

            // check if subject is in database
            $sqlquery_addSubjectCheck = "SELECT 1 FROM fach WHERE name = '".$subjectName."';";
            $sqlquery_addSubjectCheck_Return = $this->_sendOneToDatabase($sqlquery_addSubjectCheck);
            if (!$sqlquery_addSubjectCheck_Return['rc']) {throw new ErrorException($sqlquery_addSubjectCheck_Return['rv']);}
            if ($sqlquery_addSubjectExists_Return['rv'] == array()) {$answer= array('rc'=>true, 'rv'=>2);Return;}

            $answer = array('rc'=>true, 'rv'=>0);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all deleted subjects
     * @return array('rc'=>0, 'rv'=>array())
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllSubjects(){
        try{
            $sqlquery_getAllSubjects = "SELECT name FROM getallsubjects";
            $sqlquery_getAllSubjects_Result = $this->_sendOneToDatabase($sqlquery_getAllSubjects);
            if (!$sqlquery_getAllSubjects_Result['rc']) {throw new ErrorException($sqlquery_getAllSubjects_Result['rv']);}
            $answer = array('rc'=>0, 'rv'=>$sqlquery_getAllSubjects_Result['rv']);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all subjects
     * @return array('rc'=>0, 'rv'=>array())
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllDeletedSubjects(){
        try{
            $sqlquery_getAllSubjects = "SELECT name FROM getallsubjects WHERE softdelete = 1";
            $sqlquery_getAllSubjects_Result = $this->_sendOneToDatabase($sqlquery_getAllSubjects);
            if (!$sqlquery_getAllSubjects_Result['rc']) {throw new ErrorException($sqlquery_getAllSubjects_Result['rv']);}
            $answer = array('rc'=>0, 'rv'=>$sqlquery_getAllSubjects_Result['rv']);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all not deleted subjects
     * @return array('rc'=>0, 'rv'=>array())
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllNotDeletedSubjects(){
        try{
            $sqlquery_getAllSubjects = "SELECT name FROM getallsubjects WHERE softdelete = 0";
            $sqlquery_getAllSubjects_Result = $this->_sendOneToDatabase($sqlquery_getAllSubjects);
            if (!$sqlquery_getAllSubjects_Result['rc']) {throw new ErrorException($sqlquery_getAllSubjects_Result['rv']);}
            $answer = array('rc'=>0, 'rv'=>$sqlquery_getAllSubjects_Result['rv']);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Change value of soft delete flag of subjects
     * @param string $subjectName Name of subject
     * @return array ('rc'=>true,'rv'=>true)
     * @except array ('rc'=>false,'rv'=>string)
     */
    function switchSoftDeleteSubjects(string $subjectName){
        try{
            $sqlquery_switchSoftDeleteClasses = "UPDATE fach SET softdelete =(CASE WHEN softdelete = 0 THEN 1 ELSE 0 END) WHERE name = '".$subjectName."';";
                $sqlquery_switchSoftDeleteClasses_Result = $this->_sendOneToDatabase($sqlquery_switchSoftDeleteClasses);
            if (!$sqlquery_switchSoftDeleteClasses_Result['rc']) {throw new ErrorException($sqlquery_switchSoftDeleteClasses_Result['rv']);}
            $answer = array('rc'=>true, 'rv'=>true);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}

    }

    /**@brief Renameing exsisting subject
     * @param string $oldsubjectName The subject to rename
     * @param string $newsubjectName The new name for subject
     * @return array ('rc'=>true,'rv'=>int)
     *  - 0 = Subject renamed
     *  - 1 = Subject not found
     *  - 2 = Subject could not be renamed
     * @except array ('rc'=>false,'rv'=>string)
     * @todo programming
     */
    function renameSubject(string $oldSubjectName, string $newSubjectName) {
        try{
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
        
    }
}