<?php namespace classes\Blog;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class Blog{

    private $id;
    private $photo;
    private $title;
    private $content;
    private $dateUpdated;
    private $dateCreated;

    function __construct($id=null){
        if($id != null){
            $this->setId($id);
            $this->loadBlog();
        }
    }   

    function uploadBlog($data, $image, $user_id){
            $database = dbCon();
            $date = date("Y-m-d H:i:s");
            $translate = new \classes\Languages\Translate();

        if(empty($this->id)){
            $photo = new \classes\Photo\Photo();
            $photo->upload($image, '/img/blogs/');
            
            if(!$database -> insert("blogs", [
                                            'user_id' => $user_id,
                                            'title' => $data['title'],
                                            'content' => $data['content'],
                                            'photo_id' => $photo->getId(),
                                            'date_updated' => $date,
                                            'date_created' => $date
            ])){
                throw new \Exception($translate->getString('error-DBInsert'));
            }
            $this->setId($database->id());
            //notification
            $data = array("user_id"=>$user_id, "blog_id"=>$this->id);
            $notification = new \classes\Notification\NotificationBlog();
            $notification->saveToDB($data);
        }else{
            if(!empty($image['name'])){
                $photo = new \classes\Photo\Photo();
                $photo->upload($image, '/img/blogs/');
                if(!$database -> update("blogs", ['photo_id' => $photo->getId()], ['id' => $this->id])){
                    throw new \Exception($translate->getString('error-DBUpdate'));
                }
            }
            
            if(!$database -> update("blogs", [
                                            'title' => $data['title'],
                                            'content' => $data['content'],
                                            'date_updated' => $date
            ], ['id' => $this->id])){
                throw new \Exception($translate->getString('error-DBUpdate'));
            }
        }
    }

    function deleteBlog(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $sql = $database -> select("blogs", 'photo_id', ['id' => $this->id]);

        if(!$database->delete("blogs", ['id' => $this->id])){
            throw new \Exception($translate->getString('error-DBDelete'));
        }
        $photo = new \classes\Photo\Photo($sql[0]);
        $photo->deletePhoto();
    }

    private function loadBlog(){
        $databse = dbCon();
        $sql = $databse -> select("blogs", '*', ['id' => $this->id]);
        $this->setTitle($sql[0]['title']);
        $this->setContent($sql[0]['content']);
        $this->setDateUpdated($sql[0]['date_updated']);
        $this->setDateCreated($sql[0]['date_created']);

        $photo = new \classes\Photo\Photo($sql[0]['photo_id']);
        $this->setPhoto($photo);
    }

    private function setId($id){$this->id = $id;}
    private function setPhoto($photo){$this->photo = $photo;}
    private function setTitle($title){$this->title = $title;}
    private function setContent($content){$this->content = $content;}
    private function setDateUpdated($dateUpdated){$this->dateUpdated = $dateUpdated;}
    private function setDateCreated($dateCreated){$this->dateCreated = $dateCreated;}

    function getId(){return $this->id;}
    function getPhoto(){return $this->photo;}
    function getTitle(){return $this->title;}
    function getContent(){return $this->content;}
    function getDateUpdated(){return $this->dateUpdated;}
    function getDateCreated(){
        $date = new \DateTime($this->dateCreated);
        return $date->format('d.m.Y');
    }
    function getURLTitle(){
        $URLchars = new \classes\URLs\UrlChars($this->title);
        $name = $URLchars->convert();
        $name = strtolower($name);
        $name = str_replace(" ", "-", $name); 
        $name = str_replace(".", "", $name); 
        $name = str_replace(",", "", $name); 
        return $name;
    }
} 