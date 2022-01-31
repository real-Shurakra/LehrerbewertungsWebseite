<?php
class informationCenter{
    function __construct(){}

    private function _readFile($file){
        try{
            if (file_exists($file)){
                $myfile = fopen($file, "r");
                $fileContent = fread($myfile,filesize($file));
                fclose($myfile);
                $answer = array('rc'=>true, 'rv'=>$fileContent);
            }
            else {throw new ErrorException('File Not Found');}
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }
    
    function getGitShortCut(){
        try{
            $gitSymbol = $this->_readFile("./svg/git.svg");
            if (!$gitSymbol['rc']){throw new ErrorException($gitSymbol['rv']);}
            else{$gitSymbol = $gitSymbol['rv'];}

            $gitFullHash = $this->_readFile(".git/ORIG_HEAD");
            if (!$gitFullHash['rc']){$gitFullHash = '';}
            else{$gitFullHash = 'ver. '.$gitFullHash['rv'];}

            $gitShortHash = substr($gitFullHash, 0, 6);
            $answer = array('rc'=>true, 'rv'=>'<a href = "https://github.com/real-Shurakra/Lehrerbeurteilung" target="_blank" tooltip="Git Hash: '.$gitFullHash.'" style="color:black; text-decoration: none;">'.$gitSymbol.' '.$gitShortHash.'</a>');
        }
        catch(ErrorException $error){$answer = array('rc'=>false, 'rv'=>strval(debug_backtrace()[0]['line']).': '.debug_backtrace()[0]['class'].'.'.debug_backtrace()[0]['function'].debug_backtrace()[0]['type'].$error->getMessage());}
        finally{return $answer;}
    }
}
