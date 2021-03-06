<?php

/*
    Check captcha code
*/

class modModcaptchaWebCheckProcessor extends modprocessor{
    
    public function initialize(){
        
        $this->setDefaultProperties(array(
            "captcha_key"       => $this->modx->getOption('modcaptcha.session_id', null, 'php_captcha'),
            "method"            => "REQUEST",   // REQUEST|GET|POST
            "case_sensitive"    => false,
        ));
        
        return parent::initialize();
    }
    
    public function process(){
        $key = $this->getProperty('captcha_key'); 
        
        if(!$code = $this->getProperty('code')){
            return $this->failure("Code is empty", array(
                "code"  => 2,
            )); 
        }
        
        $session_code = (!empty($_SESSION[$key]) ? $_SESSION[$key] : '');
        
        if(!$case_sensitive = $this->getProperty('case_sensitive')){
            $code = strtolower($code);
            $session_code = strtolower($session_code);
        }
         
        if($code != $session_code){
            return $this->failure("Wrong code", array(
                "code"  => 1,
            ));
        }
        
        // else
        return $this->success('');
        
    }
}

return 'modModcaptchaWebCheckProcessor';
