<?php namespace classes\Video;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Video{

    private $id;
    private $name;
    private $dir;
    private $autoplay;
    private $controls;
    private $poster;
    private $thumbName;
    private $title;
    private $alt;

    function __construct($id = null){
        if(!empty($id)){
            $this->id = $id;
            $this->loadVideo();
        }
    }

    private function loadVideo(){
        $database = dbCon();

        $this->checkExist();

        $sql = $database -> select("videos", '*', ['id' => $this->id]);
        foreach($sql as $k){
            $this->setName($k['name']);
            $this->setDir($k['dir']);
            $this->setAutoplay($k['autoplay']);
            $this->setControls($k['controls']);
            $this->setPoster($k['poster']);
            $this->setThumbName($k['thumbName']);
        }
    }

    private function checkExist(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if(!$database -> has("videos", ['id' => $this->id])){
            throw new \Exception($translate->getString("nExist"));
        }
    }

    function deleteVideo(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if(!$database -> has("videos_to_user", ['video_id' => $this->id])){
            if(!$database ->has("user_model_info", ['default_video_id' => $this->id])){
                throw new \Exception($translate->getString("nExist"));
            }else{
                if(!$database -> update("user_model_info", ['default_video_id' => null] ,['default_video_id' => $this->id])){
                    throw new \Exception($translate->getString("delete-error"));
                }
            }
        }else{
            if(!$database -> delete("videos_to_user", ['video_id' => $this->id])){
                throw new \Exception($translate->getString("delete-error"));
            }
        }
        
        if(!$database -> has("videos", ['id' => $this->id])){
            throw new \Exception($translate->getString("nExist"));
        }
        if(!$database -> delete("videos", ['id' => $this->id])){
            throw new \Exception($translate->getString("delete-error"));
        }
        unlink(dirname(dirname(dirname(__FILE__))).$this->getSRCThumbVideo());
        unlink(dirname(dirname(dirname(__FILE__))).$this->getSRCVideo());
    }

    function upload($video, $dir){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if($video['type'] != "video/mp4"){
            throw new \Exception($translate->getString("invalidFormat"));
        }
        if($video['size'] > 10000000){
            throw new \Exception($translate->getString("tooBigSize"));
        }
        $fullDir = dirname(dirname(dirname(__FILE__))).$dir;
        $date = date("Y-m-d H:i:s:u");
        $md5_date = md5($date).uniqid();
        $type = '.mp4';
        $this->setName($md5_date . $type);
        $this->setThumbName($md5_date . '.jpg');

        if(move_uploaded_file($video['tmp_name'], $fullDir.$this->getName())){
            if(!$database -> insert("videos", ['name' => $this->getName(), 'thumbName' => $this->getThumbName(), 'dir' => $dir, 'autoplay' => 0, 'controls' => 0, 'poster' => 0, 'date_created' => $date])){
                throw new \Exception($translate->getString("error-DBInser"));
            }else{
                
                $video = $fullDir.$this->getName();
                $image= $fullDir."thumb/". $this->getThumbName();
                $size = "120x90";
                $interval = 5;
                $cmd="ffmpeg -i $video -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
                shell_exec($cmd);

                $this->setId($database->id());
            }
        } else {
            throw new \Exception($translate->getString('image-upload-error'));
        }
    }

    private function setId($id){$this->id = $id;}
    private function setName($name){$this->name = $name;}
    private function setDir($dir){$this->dir = $dir;}
    private function setAutoplay($autoplay){$this->autoplay = $autoplay;}
    private function setControls($controls){$this->controls = $controls;}
    private function setPoster($poster){$this->poster = $poster;}
    private function setThumbName($thumbName){$this->thumbName = $thumbName;}

    function getId(){return $this->id;}
    function getName(){return $this->name;}
    function getDir(){return $this->dir;}
    function getAutoplay(){return $this->autoplay;}
    function getControl(){return $this->control;}
    function getPoster(){return $this->poster;}
    function getThumbName(){return $this->thumbName;}
    function getSRCThumbVideo(){return $this->dir.'thumb/'.$this->thumbName;}
    function getSRCVideo(){return $this->dir . $this->name;}

    function getTitle(){return $this->title;} //nie zrobiłeś title xDDDD robie samą funkcje get :D 
    function getAlt(){return $this->alt;} //tego tez nie

}