<?
class Main{

    function __construct(){
        $_REQUEST = $this->checkSemicolon($_REQUEST);
    }

    function executeOrder($orderRequest){
        switch ($orderRequest['mode']) {
            case 'value':
                # code...
                break;
            
            default: echo json_encode(array('rc'=>1,'rv'=>'Error: Wrong mode parameter. Mode Parameter is: '. strval($orderRequest['mode']))); break;
        }
    }

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