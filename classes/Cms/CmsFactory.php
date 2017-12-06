<?php namespace classes\Cms;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class CmsFactory{
    
    private $id;
    private $cms;

    function __construct($id){
        $this->setId($id);
        $this->loadCms();
    }

    private function loadCms(){
        $database = dbCon();
        if($database->has("cms_info", ['cms_id' => $this->id])){
            $sql = $database->select("cms_info", '*', ['cms_id' => $this->id]);
            foreach($sql as $k){
                $cms[] = new Cms($this->id, $k['language_code']);
            }
            $this->setCms($cms);
        }
    }

    private function setId($id){$this->id = $id;}
    private function setCms($cms){$this->cms = $cms;}

    function getCms(){return $this->cms;}
}