<?php namespace classes\Chat;

class ChatToFile{
    private $fileName;

    function __construct($filename){
        $this->setFileName($filename);
    }
    
    function updateFile($userLogin, $message){
        $myfile = fopen($this->getFileName(), "a+");
        $date = date("Y-m-d H:i:s");
        $txt = "[$date]\"$userLogin\": $message \n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    private function setFileName(string $filename){
        $this->fileName = $filename;
    }
    function getFileName(){
        return $this->fileName;
    }
}