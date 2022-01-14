<?php
class infomationCenter{
    function __construct(){}

    private function _readFile($file){
        try{
        
        $myfile = fopen($file, "r") or die("Unable to open file!");
        $fileContent = fread($myfile,filesize($file));
        fclose($myfile);
         $answer = array('rc'=>true, 'rv'=>$fileContent);
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }
    
    function getGitShortCut(){
        try{
            $gitSymbol = $this->_readFile("../svg/git.svg");
            if (!$gitSymbol['rc']){throw new ErrorException($gitSymbol['rv']);}
            else{$gitSymbol = $gitSymbol['rv'];}
            $gitFullHash = $this->_readFile("../.git/ORIG_HEAD");
            if (!$gitFullHash['rc']){throw new ErrorException($gitFullHash['rv']);}
            else{$gitFullHash = $gitFullHash['rv'];}
            $gitShortHash = substr($gitFullHash, 0, 6);
            $answer = array('rc'=>true, 'rv'=>'<a href = "https://github.com/real-Shurakra/LehrerbewertungsWebseite" tooltip="Git Hash: '.$gitFullHash.'" style="color:black; text-decoration: none;">'.$gitSymbol.' ver. '.$gitShortHash.'</a>');
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }
}