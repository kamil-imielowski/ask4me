<?php namespace classes\Blog;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
class BlogsFactory{

    private $blogs;

    function __construct(){
        $this->loadBlogs();
    }

    private function loadBlogs(){
        $database = dbCon();
        $sql = array();
        $blogs = array();
        $sql = $database -> select("blogs", '*');
        foreach($sql as $k){
            $blogs[] = new Blog($k['id']);
        }
        $this->setBlogs($blogs);
    }

    private function setBlogs($blogs){$this->blogs = $blogs;}

    function getBlogsByString(string $string){
        $database = dbCon();
        $sql = array();
        $blogs = array();

        $sql = $database->select("blogs", 'id', ["OR" => [
                                                            'title[~]' => $string,
                                                            'content[~]' => $string
        ]]);

        foreach($sql as $k){
            $blogs[] = new Blog($k);
        }
        return $blogs;
    }

    function getBlogs(){return $this->blogs;}
} 