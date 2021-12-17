<?php

include 'DatabaseControl.php';

class SchooldataAdministration {

    /**@brief contructor
     * @param string $dbipv4 Databaseserver IPv4 address
     * @param string $dbname Database name
     * @param string $dbuser Database user
     * @param string $dbpass Database user password
     */
    function __construct($dbipv4, $dbname, $dbuser, $dbpass){
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
     * @return array ('rc'=>true,'rv'=>int)
     *  - 0 - Class created
     *  - 1 - Class already exists
     *  - 2 - Class could not be created
     * @except array ('rc'=>false,'rv'=>string)
     */
    function addClass(string $className, string $studentCount){
        try{
            // Define SQL
            $sqlquery_addSubjectExists = "SELECT 1 FROM klasse WHERE name = '".$className."';";
            $sqlquery_addClass = "INSERT INTO klasse(name, schueleranzahl) VALUES ('".$className."', '".$studentCount."');";

            // Check if class is allready in database
            $sqlquery_addSubjectExists_Return = $this->_sendOneToDatabase($sqlquery_addSubjectExists);
            if (!$sqlquery_addSubjectExists_Return['rc']) {throw new ErrorException($sqlquery_addSubjectExists_Return['rv']);}
            if ($sqlquery_addSubjectExists_Return['rv'] != array()) {$answer= array('rc'=>true, 'rv'=>1);return;}

            // Add class
            $sqlquery_addClass_Result = $this->_sendOneToDatabase($sqlquery_addClass);
            if (!$sqlquery_addClass_Result['rc']) {throw new ErrorException($sqlquery_addClass_Result['rv']);}

            // check if class is in database
            $sqlquery_addSubjectExists_Return = $this->_sendOneToDatabase($sqlquery_addSubjectExists);
            if (!$sqlquery_addSubjectExists_Return['rc']) {throw new ErrorException($sqlquery_addSubjectExists_Return['rv']);}
            if ($sqlquery_addSubjectExists_Return['rv'] == array()) {$answer= array('rc'=>true, 'rv'=>2);return;}

            // Define answer
            $answer = array('rc'=>true,'rv'=>0);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all class names
     * @return array('rc'=>true,'rv'=>array(0,1,n))
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllClasses() {
        try{
            // Define SQL
            $sqlquery_getAllClasses = "SELECT name FROM getallclasses";

            // Get all Classes from Database
            $sqlquery_getAllClasses_Result = $this->_sendOneToDatabase($sqlquery_getAllClasses);
            if (!$sqlquery_getAllClasses_Result['rc']) {throw new ErrorException($sqlquery_getAllClasses['rv']);}

            // Processing data
            $classes = array();
            for ($i=0; $i < count($sqlquery_getAllClasses_Result['rv']); $i++) { 
                array_push($classes, $sqlquery_getAllClasses_Result['rv'][$i]['name']);
            }

            // Define answer
            $answer = array('rc'=>true,'rv'=>$classes);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all deleted class names
     * @return array('rc'=>true, 'rv'=>array(0,1,n))
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllDeletedClasses() {
        try{
            // Define SQL
            $sqlquery_getAllClasses = "SELECT name FROM getallclasses WHERE softdelete = 1";

            // Get deleted classes
            $sqlquery_getAllClasses_Result = $this->_sendOneToDatabase($sqlquery_getAllClasses);
            if (!$sqlquery_getAllClasses_Result['rc']) {throw new ErrorException($sqlquery_getAllClasses['rv']);}

            // Processing data
            $classes = array();
            for ($i=0; $i < count($sqlquery_getAllClasses_Result['rv']); $i++) { 
                array_push($classes, $sqlquery_getAllClasses_Result['rv'][$i]['name']);
            }

            // Define answer
            $answer = array('rc'=>true,'rv'=>$classes);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all not deleted class names
     * @return array('rc'=>true, 'rv'=>array())
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllNotDeletedClasses() {
        try{
            // Define SQL
            $sqlquery_getAllClasses = "SELECT name FROM getallclasses WHERE softdelete = 0";

            // Get data
            $sqlquery_getAllClasses_Result = $this->_sendOneToDatabase($sqlquery_getAllClasses);
            if (!$sqlquery_getAllClasses_Result['rc']) {throw new ErrorException($sqlquery_getAllClasses['rv']);}

            // Process data
            $classes = array();
            for ($i=0; $i < count($sqlquery_getAllClasses_Result['rv']); $i++) { 
                array_push($classes, $sqlquery_getAllClasses_Result['rv'][$i]['name']);
            }

            // Define answer
            $answer = array('rc'=>true,'rv'=>$classes);
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
            // Define SQL
            $sqlquery_switchSoftDeleteClasses = "UPDATE klasse SET softdelete =(CASE WHEN softdelete = 0 THEN 1 ELSE 0 END) WHERE name = '".$className."';";

            // Send SQL
            $sqlquery_switchSoftDeleteClasses_Result = $this->_sendOneToDatabase($sqlquery_switchSoftDeleteClasses);
            if (!$sqlquery_switchSoftDeleteClasses_Result['rc']) {throw new ErrorException($sqlquery_switchSoftDeleteClasses_Result['rv']);}

            // Define answer
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
     */
    function renameClass(string $oldClassName, string $newClassName) {
        try{
            // Define sql
            $sqlquery_renameClassLookupBefor = "SELECT 1 FROM klasse WHERE name = '".$oldClassName."'";
            $sqlquery_renameClass = "UPDATE klasse SET name='".$newClassName."' WHERE name='".$oldClassName."'";
            $sqlquery_renameClassLookupAfter = "SELECT 1 FROM klasse WHERE name = '".$newClassName."'";

            // Check class existence
            $sqlquery_renameClassLookupBefor_Result = $this->_sendOneToDatabase($sqlquery_renameClassLookupBefor);
            if (!$sqlquery_renameClassLookupBefor_Result['rc']) {throw new ErrorException($sqlquery_renameClassLookupBefor_Result['rv']);}
            if ($sqlquery_renameClassLookupBefor_Result['rv'] == array()) {$answer = array('rc'=>true,'rv'=>1);return;}

            // Rename class
            $sqlquery_renameClass_Result = $this->_sendOneToDatabase($sqlquery_renameClass);
            if (!$sqlquery_renameClass_Result['rc']) {throw new ErrorException($sqlquery_renameClass_Result['rv']);}

            // Check if rename successful
            $sqlquery_renameClassLookupAfter_Result = $this->_sendOneToDatabase($sqlquery_renameClassLookupAfter);
            if (!$sqlquery_renameClassLookupAfter_Result['rc']) {throw new ErrorException($sqlquery_renameClassLookupAfter_Result['rv']);}
            if ($sqlquery_renameClassLookupAfter_Result['rv'] != array()) {$answer = array('rc'=>true,'rv'=>2);return;}

            // Define answer
            $answer = array('rc'=>true,'rv'=>0);
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
            // Define SQL
            $sqlquery_editClassStudentCount_CheckExistence = "SELECT 1 FROM klasse WHERE name = '".$className."';";
            $sqlquery_editClassStudentCount_EditCount = "UPDATE klasse SET schueleranzahl=".$newStudentCount." WHERE name='".$className."'";
            $sqlquery_editClassStudentCount_CheckNewCount = "SELECT 1 FROM klasse WHERE name = '".$className."' AND schueleranzahl = ".$newStudentCount."";

            // Check class existence
            $sqlquery_editClassStudentCount_CheckExistence_Result = $this->_sendOneToDatabase($sqlquery_editClassStudentCount_CheckExistence);
            if (!$sqlquery_editClassStudentCount_CheckExistence_Result['rc']) {throw new ErrorException($sqlquery_editClassStudentCount_CheckExistence_Result['rv']);}
            if ($sqlquery_editClassStudentCount_CheckExistence_Result['rv'] == array()) {$answer = array('rc'=>true,'rv'=>1);return;}

            // Edit class student count
            $sqlquery_editClassStudentCount_EditCount_Result = $this->_sendOneToDatabase($sqlquery_editClassStudentCount_EditCount);
            if (!$sqlquery_editClassStudentCount_EditCount_Result['rc']) {throw new ErrorException($sqlquery_editClassStudentCount_EditCount_Result['rv']);}

            // Check new student count
            $sqlquery_editClassStudentCount_CheckNewCount_Result = $this->_sendOneToDatabase($sqlquery_editClassStudentCount_CheckNewCount);
            if (!$sqlquery_editClassStudentCount_CheckNewCount_Result['rc']) {throw new ErrorException($sqlquery_editClassStudentCount_CheckNewCount_Result['rv']);}
            if ($sqlquery_editClassStudentCount_CheckNewCount_Result['rv'] != array()) {$answer = array('rc'=>true,'rv'=>2);return;}

            // Define answer
            $answer = array('rc'=>true,'rv'=>0);
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
     * @return array('rc'=>true, 'rv'=>array())
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllSubjects(){
        try{
            // Define SQL
            $sqlquery_getAllSubjects = "SELECT name FROM getallsubjects";

            // Get data
            $sqlquery_getAllSubjects_Result = $this->_sendOneToDatabase($sqlquery_getAllSubjects);
            if (!$sqlquery_getAllSubjects_Result['rc']) {throw new ErrorException($sqlquery_getAllSubjects_Result['rv']);}

            // Process data
            $subjects = array();
            for ($i=0; $i < count($sqlquery_getAllSubjects_Result['rv']); $i++) { 
                array_push($subjects, $sqlquery_getAllSubjects_Result['rv'][$i]['name']);
            }

            // Define answer
            $answer = array('rc'=>true,'rv'=>$subjects);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all subjects
     * @return array('rc'=>true, 'rv'=>array())
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllDeletedSubjects(){
        try{
            // Define SQL
            $sqlquery_getAllSubjects = "SELECT name FROM getallsubjects WHERE softdelete = 1";

            // Get data
            $sqlquery_getAllSubjects_Result = $this->_sendOneToDatabase($sqlquery_getAllSubjects);
            if (!$sqlquery_getAllSubjects_Result['rc']) {throw new ErrorException($sqlquery_getAllSubjects_Result['rv']);}

            // Process data
            $subjects = array();
            for ($i=0; $i < count($sqlquery_getAllSubjects_Result['rv']); $i++) { 
                array_push($subjects, $sqlquery_getAllSubjects_Result['rv'][$i]['name']);
            }

            // Define answer
            $answer = array('rc'=>true,'rv'=>$subjects);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }

    /**@brief Get all not deleted subjects
     * @return array('rc'=>true, 'rv'=>array())
     * @except array ('rc'=>false,'rv'=>string)
     */
    function getAllNotDeletedSubjects(){
        try{
            // Define SQL
            $sqlquery_getAllNotDeletedSubjects = "SELECT name FROM getallsubjects WHERE softdelete = 0";

            // Get data
            $sqlquery_getAllNotDeletedSubjects_Result = $this->_sendOneToDatabase($sqlquery_getAllNotDeletedSubjects);
            if (!$sqlquery_getAllNotDeletedSubjects_Result['rc']) {throw new ErrorException($sqlquery_getAllNotDeletedSubjects_Result['rv']);}

            // Process data
            $subjects = array();
            for ($i=0; $i < count($sqlquery_getAllNotDeletedSubjects_Result['rv']); $i++) { 
                array_push($subjects, $sqlquery_getAllNotDeletedSubjects_Result['rv'][$i]['name']);
            }

            // Define answer
            $answer = array('rc'=>true,'rv'=>$subjects);
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
            // Define SQL
            $sqlquery_switchSoftDeleteClasses = "UPDATE fach SET softdelete =(CASE WHEN softdelete = 0 THEN 1 ELSE 0 END) WHERE name = '".$subjectName."';";

            // Execute SQL
            $sqlquery_switchSoftDeleteClasses_Result = $this->_sendOneToDatabase($sqlquery_switchSoftDeleteClasses);
            if (!$sqlquery_switchSoftDeleteClasses_Result['rc']) {throw new ErrorException($sqlquery_switchSoftDeleteClasses_Result['rv']);}

            // Define answer
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
            // Define sql
            $sqlquery_renameSubjectLookupBefor = "SELECT 1 FROM subject WHERE name = '".$oldSubjectName."'";
            $sqlquery_renameSubject = "UPDATE subject SET name='".$newSubjectName."' WHERE name='".$oldSubjectName."'";
            $sqlquery_renameSubjectLookupAfter = "SELECT 1 FROM subject WHERE name = '".$newSubjectName."'";

            // Check class existence
            $sqlquery_renameSubjectLookupBefor_Result = $this->_sendOneToDatabase($sqlquery_renameSubjectLookupBefor);
            if (!$sqlquery_renameSubjectLookupBefor_Result['rc']) {throw new ErrorException($sqlquery_renameSubjectLookupBefor_Result['rv']);}
            if ($sqlquery_renameSubjectLookupBefor_Result['rv'] == array()) {$answer = array('rc'=>true,'rv'=>1);return;}

            // Rename class
            $sqlquery_renameSubject_Result = $this->_sendOneToDatabase($sqlquery_renameSubject);
            if (!$sqlquery_renameSubject_Result['rc']) {throw new ErrorException($sqlquery_renameSubject_Result['rv']);}

            // Check if rename successful
            $sqlquery_renameSubjectLookupAfter_Result = $this->_sendOneToDatabase($sqlquery_renameSubjectLookupAfter);
            if (!$sqlquery_renameSubjectLookupAfter_Result['rc']) {throw new ErrorException($sqlquery_renameSubjectLookupAfter_Result['rv']);}
            if ($sqlquery_renameSubjectLookupAfter_Result['rv'] != array()) {$answer = array('rc'=>true,'rv'=>2);return;}

            // Define answer
            $answer = array('rc'=>true,'rv'=>0);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
        
    }
}


include '../conf/config.php';

global $dbipv4, $dbname, $dbuser, $dbpass;
$interface = new SchooldataAdministration($dbipv4, $dbname, $dbuser, $dbpass);
var_dump($interface->getAllSubjects());