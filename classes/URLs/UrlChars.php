<?php namespace classes\URLs;

class UrlChars{
    private $chars;

    function __construct($chars){
        $this->chars = $chars;
    }

    function convert(){
        $transliterationTable = array(  "Ą" => 'a', "ą" => 'a', 
        
                                        'ć' => 'c', "Ć" => 'C', 
    
                                        "Ę" => 'E', 'ę' => 'e', 
    
                                        "Ł" => 'L', 'ł' => 'l', 
    
                                        'Ń' => 'N', 'ń' => 'n', 
    
                                        'Ó' => 'O', 'ó' => 'o', 
    
                                        'Ś' => 'S', 'ś' => 's', 
    
                                        'Ż' => 'Z', 'ż' => 'z', 
    
                                        'Ź' => 'z', 'ź' => 'z');
        
        return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $this->chars);
    }
}