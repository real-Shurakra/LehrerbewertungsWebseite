<?php

use FFI\Exception;
session_start();
include 'phpjsinterface.php';
include 'infomationCenter.php';
include '../conf/config.php';
include 'QuestionnaireAdministration.php';
include 'SchooldataAdministration.php';

class MainInterface {

    function __construct(){
        $_REQUEST = $this->checkSemicolon($_REQUEST);
        global $dbipv4, $dbname, $dbuser, $dbpass;
        $this->interface = new phpjsinterface($dbipv4, $dbname, $dbuser, $dbpass);
        $this->infoCenter = new infomationCenter();
        $this->schoolDataAdministration = new SchooldataAdministration($dbipv4, $dbname, $dbuser, $dbpass);
    }

    function executeOrder($requestMode){
        switch ($requestMode) {
            // This functions allready got updated
            // phpjsinterface.php
            case  'loginUser':
                return json_encode($this->interface->userLogin(
                    $_REQUEST['mail'], 
                    $_REQUEST['passwort']
                ));
                break;
            case  'addUser':
                return json_encode($this->interface->addUser(
                    $_REQUEST['mail'], 
                    $_REQUEST['firstname'], 
                    $_REQUEST['lastname'], 
                    $_SESSION['defaultPassword']
                ));
                break;
            case  'changePasswort':
                return json_encode($this->interface->changePassword(
                    $_REQUEST['oldPasswort'], 
                    $_REQUEST['newPasswort']
                ));
                break;
            case  'resetPassword':
                return json_encode($this->interface->resetPassword(
                    $_REQUEST['password'], 
                    $_REQUEST['resetUser'],
                    $_REQUEST['stdPassword']
                ));
                break;
            case  'checkLogin':
                return json_encode($this->interface->checkLogin());
                break;
            case  'deleteUser':
                return json_encode($this->interface->deleteUser(
                    $_REQUEST['passwort'], 
                    $_REQUEST['deleteThis']
                ));
                break;
            case  'getAllUser':
                return json_encode($this->interface->getAllUser(
                    $_SESSION['userisroot']
                ));
                break;
            



            // infomationCenter.php
            case  'getGitShortCut':
                return json_encode($this->infoCenter->getGitShortCut());
                break;


            
            // This functions still need upgrade
            ## Modes for FragenVerwaltung
            case  'addSubject':             if ($_SESSION['usermail'] != Null) {return json_encode($this->schoolDataAdministration->addSubject($_REQUEST['subjectName']));}                                                                                  break;
            case  'changeSubjectDelete':    if ($_SESSION['usermail'] != Null) {return json_encode($this->schoolDataAdministration->softdeleteKlassenUndFaecher(false, $_REQUEST['subjectName']));}                                                          break;
            case  'addClass':               if ($_SESSION['usermail'] != Null) {return json_encode($this->schoolDataAdministration->addClass($_REQUEST['className'], $_REQUEST['studentCount']));}                                                           break;
            case  'changeClassDelete':      if ($_SESSION['usermail'] != Null) {return json_encode($this->schoolDataAdministration->softdeleteKlassenUndFaecher(true, $_REQUEST['className']));}                                                                                       break;
            case  'getAlleSchulklassen':    if ($_SESSION['usermail'] != Null) {return json_encode($this->schoolDataAdministration->getAllClasses());}                                                                                                 break;
            case  'getAllSubjects':         if ($_SESSION['usermail'] != Null) {return json_encode($this->schoolDataAdministration->getAllSubjects());}                                                                break;

            case  'askAlleFragen':          if ($_SESSION['usermail'] != Null) {return json_encode(QuestionnaireAdministration::askAlleFragen());}                                                                                                       break;
            case  'addFrage':               if ($_SESSION['usermail'] != Null) {return json_encode(QuestionnaireAdministration::addFrage($_REQUEST['frage'], $_REQUEST['kategorie']));}                                                                  break;
            case  'getAlleKategorien':      if ($_SESSION['usermail'] != Null) {return json_encode(QuestionnaireAdministration::getAlleKategorien());}                                                                                                   break;
            case  'makeFragebogen':         if ($_SESSION['usermail'] != Null) {return json_encode(QuestionnaireAdministration::makeFragebogen($_REQUEST['name'], $_REQUEST['anzahl'], $_REQUEST['klasse'], $_REQUEST['fach'], $_REQUEST['fragen']));}   break;
            case  'getFragebogens':         if ($_SESSION['usermail'] != Null) {return json_encode(QuestionnaireAdministration::getFragebogens());}                                                                                                      break;
            case  'getCodes':               if ($_SESSION['usermail'] != Null) {return json_encode(QuestionnaireAdministration::getCodes($_REQUEST['fbId']));}                                                                                           break;
            case  'getFbFragen':            if ($_SESSION['usermail'] != Null) {return json_encode(QuestionnaireAdministration::getFbFragen($_REQUEST['fbId']));}                                                                                        break;
            case  'insertRate':                                                 return json_encode(QuestionnaireAdministration::insertRate($_REQUEST['rate'], $_REQUEST['codehash']));                                                                   break;
            case  'insertkritik':                                               return json_encode(QuestionnaireAdministration::insertkritik($_REQUEST['fbId'], $_REQUEST['kritik'], $_REQUEST['codehash']));                                            break;
            case  'getkritik':              if ($_SESSION['usermail'] != Null) {return json_encode(QuestionnaireAdministration::getkritik($_REQUEST['fbId']));}                                                                                                      break;
            case  'getFbFragenFromCode':                                        return json_encode(QuestionnaireAdministration::getFbFragenFromCode($_REQUEST['codehash']));                                                                             break;
            case  'alterQuestion':          if ($_SESSION['usermail'] != Null) {return json_encode(QuestionnaireAdministration::alterQuestion($_REQUEST['frageId'], $_REQUEST['neuFrage']));}                                                            break;
            case  'delQuestionnaire':       if ($_SESSION['usermail'] != Null) {return json_encode(QuestionnaireAdministration::delQuestionnaire($_REQUEST['fbId']));}                                                                                   break;
            case  'deleteAllCodes':         if ($_SESSION['usermail'] != NULL) {return json_encode(QuestionnaireAdministration::deleteAllCodes($_REQUEST['fbId']));}                                                                                     break;
            case  'getQuestions':           if ($_SESSION['usermail'] != NULL) {return json_encode(QuestionnaireAdministration::getQuestions());}                                                                                                        break;
            ## Other modes
            ##case  'aecd587fdc09':                                               return json_encode($this->_phpHelp);break;
            default:                                                            return json_encode(array('returncode'=>1, 'Returnvalue'=>'<strong>Programmfehler Fehlercode: ##PHPMAIN_aktivierungJS_wv</strong><br>mode-Wert fehlerhaft. $_REQUEST[\'mode\'] = ' . strval($_REQUEST['mode'])));break;
        }
    }

    /**@brief Get the Value of a given session var
     * @param string $infoKey Varname to get
     * @return mixed Value or false
     */
    private function _getInfoVar($infoKey){
        if (
            isset($_SESSION[$infoKey])&&
            $_SESSION['usermail'] != Null
        ){
            return array('returncode'=>true, 'returnvalue'=>$_SESSION[$infoKey]);
        }
        else{
            return array('returncode'=>false, 'returnvalue'=>$infoKey);
        }
    }

    /**
     * @brief Ersetzt Umlaute durch HTML Unicode
     * @param string $string
     * @return string
     */
    public static function toDE($string) {
        $string = str_replace('Ü', '&#220;', $string);
        $string = str_replace('ü', '&#252;', $string);
        $string = str_replace('Ö', '&#214;', $string);
        $string = str_replace('ö', '&#246;', $string);
        $string = str_replace('Ä', '&#196;', $string);
        $string = str_replace('ä', '&#228;', $string);
        $string = str_replace('ß', '&#223;', $string);
        return $string;
    }
     
    #private function _phpHelp() {
    #    return array
    #    (
    #        'SESSION'=>$_SESSION,
    #        'GET'=>$_GET,
    #        'POST'=>$_POST,
    #        'REQUEST'=>$_REQUEST,
    #        'COOCKIE'=>$_COOKIE,
    #        'ENV'=>$_ENV,
    #        'FILES'=>$_FILES,
    #        'SERVER'=>$_SERVER
    #    );
    #}

    function checkSemicolon($var) {
        
        if (is_string($var))
        {
            return str_replace(';', '', $var);
        }
        elseif (is_array($var))
        {
            $var_Keys = array_keys($var);
            for ($i = 0; $i < count($var); $i++) {
                $var[$var_Keys[$i]] = $this->checkSemicolon($var[$var_Keys[$i]]);
            }
            return $var;
        }
        else
        {
            return $var;
        }
    }
}