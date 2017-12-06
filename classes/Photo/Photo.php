<?php namespace classes\Photo;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Photo{
    private $id;
    private $name;
    private $dir;
    private $title;
    private $alt;

    function __construct($id = null, $default = null){
        if(!empty($id)){
            $this->id = $id;
            $this->loadImage();
        }else{
            switch($default){
                case 'user-profile':
                    $this->setName("default-user.jpg");
                    $this->setDir("/img/customers/");
                    break;

                case 'user-model-cover':
                    $this->setName("default-cover.jpg");
                    $this->setDir("/img/customers/");
                    break;

                case 'product':
                    $this->setName("default-tokens.jpg");
                    $this->setDir("/img/products/");
                    break;
            }
        }
    }

    private function loadImage(){
        $database = dbCon();

        $this->checkDBExist();

        $sql = $database->select("photos", '*', ["id" => $this->id]);
        foreach($sql as $v){
            $this->setName($v['name']);
            $this->setDir($v['dir']);
            $this->setTitle($v['title']);
            $this->setAlt($v['alt']);
        }

        $this->checkFileExist();
    }

    private function checkDBExist(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if(!$database->has("photos", ["id" => $this->id])){
            throw new \Exception($translate->getString('nExist'));
        }
    }
    private function checkFileExist(){
        $translate = new \classes\Languages\Translate();
        if(!file_exists(dirname(dirname(dirname(__FILE__))).$this->getSRCThumbImage()) && !file_exists(dirname(dirname(dirname(__FILE__))).$this->getSRCOrginalImage())){
            throw new \Exception($translate->getString('nExist'));
        }
    }

    function deletePhoto(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if($database -> has("photos_to_user", ['photo_id' => $this->id])){
            if(!$database -> delete("photos_to_user", ['photo_id' => $this->id])){
                throw new \Exception($translate->getString("delete-error"));    
            }
        }
        
        if(!$database -> has("photos", ['id' => $this->id])){
            throw new \Exception($translate->getString("nExist"));
        }
        if(!$database -> delete("photos", ['id' => $this->id])){
            throw new \Exception($translate->getString("delete-error"));
        }
        unlink(dirname(dirname(dirname(__FILE__))).$this->getSRCThumbImage());
        unlink(dirname(dirname(dirname(__FILE__))).$this->getSRCOrginalImage());
    } 

    function upload($image, $dir, $alt="", $title=""){
        $date = date("Y-m-d H:i:s:u");
        $translate = new \classes\Languages\Translate();
        $this->setDir($dir);
        $orginalDir = dirname(dirname(dirname(__FILE__))).$this->getDir().'orginal/';

        $md5_date = md5($date).uniqid();
        
        $type = $image["type"];
        switch ($type) {
            case 'image/jpeg' :
                $type = '.jpg';
                break;
            case 'image/gif' :
                $type = '.gif';
                break;
            case 'image/png' :
                $type = '.png';
                break;
            case 'image/tiff' :
                $type = '.tiff';
                break;
            case 'image/bmp' :    
                $type = '.bmp';
                break;
            default :
                $type = '.jpg';
        }

        $this->setName($md5_date . $type);
        if(move_uploaded_file( $image['tmp_name'], $orginalDir.basename($image['name']) )){		
            $image = basename($image['name']);
            $this->setName($md5_date . $type);
            if(!rename( $orginalDir.$image, $orginalDir.$this->getName() )){
                throw new \Exception($translate->getString('image-upload-error'));
            } 
        } else {
            throw new \Exception($translate->getString('image-upload-error'));
        }
        
        if($this->createThumbImage($orginalDir.$this->getName(), $this->getName(), dirname(dirname(dirname(__FILE__))).$this->getDir().'thumb/')){
            $database = dbCon();
            if(!$database->insert("photos", ["name" => $this->getName(),"dir" => $this->getDir(), "alt" => $alt, "title" => $title, "date_created" => date("Y-m-d H:i:s")])){
                throw new \Exception($translate->getString('image-upload-error'));
            }
            $this->setId($database->id());
        }
    }

    function getId(){
        return $this->id;
    }
    function getName(){
        return $this->name;
    }
    function getDir(){
        return $this->dir;
    }
    function getTitle(){
        return $this->title;
    }
    function getAlt(){
        return $this->alt;
    }
    function getSRCThumbImage(){
        return $this->dir.'thumb/'.$this->name;
    }
    function getSRCOrginalImage(){
        return $this->dir.'orginal/'.$this->name;
    }


    private function setId($id){
        $this->id = $id;
    }
    private function setName($name){
        $this->name = $name;
    }
    private function setDir($dir){
        $this->dir = $dir;
    }
    private function setTitle($title){
        $this->title = $title;
    }
    private function setAlt($alt){
        $this->alt = $alt;
    }

    private function createThumbImage($file, $name, $target, $value=200, $type_value='szer', $quality=100){
        $translate = new \classes\Languages\Translate();
        $newfile = $target.$name;
        if (!copy($file, $newfile)) {
            throw new \Exception($translate->getString('image-upload-error'). 2);
        } else {
                    
            # Ustawienie wartości (wymiar docelowy obrazka) --> szerokość lub wysokość
            if( $type_value == "szer" OR $type_value=="wys"){
                // parametr typu wartości OK
            }else {
                $type_value="szer";
            } 

            # Ustawienie typu wartości: czy zmiana wymiaru obrazka ma być do szerokości lub do wysokości
            if( $type_value == "szer" OR $type_value=="wys"){
                // parametr typu wartości OK
            }else {
                $type_value="szer";
            } 

            # Ustawienie jakości zdjęcia
            if( $quality >= 50 AND $quality <= 100){
                // parametr jakości zdjęcia OK
            }else if($quality > 100){
                $quality=99;
            } else if($quality < 50){
                $quality=50;
            } else {
                $quality=80;
            }
            
            if (!$this->resize($newfile, $value, $type_value, $quality)) {
                throw new \Exception($translate->getString('image-upload-error'). 3);
            } else {
                return true;
            }
        }	
    }

    private function resize($plik, $wartosc = 500, $typ_wartosci = 'wys', $jakosc = 100){
        // pobieramy rozszerzenie pliku, na tej podstawie
        // korzystamy potem z odpowiednich funkcji GD
        $i = explode('.', $plik);
        
        // rozszerzeniem pliku jest ostatni element tablicy $i
        $rozszerzenie = end($i);
        
        // jeśli nie mamy jpega, gifa lub png zwracamy false.
        if($rozszerzenie !== 'jpg' &&
            $rozszerzenie !== 'gif' &&
            $rozszerzenie !== 'png') {
            return false;
        }
        
        // pobieramy rozmiary obrazka
        list($img_szer, $img_wys) = getimagesize($plik);	 
        
        // obliczamy proporcje boków
        $proporcje = $img_wys / $img_szer;
        
        // na tej podstawie obliczamy wysokość
        if($typ_wartosci=='wys'){
            $wysokosc = $wartosc; 
            $szerokosc = $wysokosc / $proporcje;					
        } else if($typ_wartosci=='szer'){
            $szerokosc = $wartosc; 
            $wysokosc = $szerokosc * $proporcje;
        } else {
            $wysokosc = $wartosc; 
            $szerokosc = $wysokosc / $proporcje;	
        }
            
        // tworzymy nowy obrazek o zadanym rozmiarze
        // korzystamy tu z funkcji biblioteki GD
        // która musi być dołączona do twojej instalacji PHP,
        // najpierw tworzymy canvas.
        $canvas = imagecreatetruecolor($szerokosc, $wysokosc);
        switch($rozszerzenie) {
            case 'jpg':
            $org = imagecreatefromjpeg($plik);
            break;
            case 'gif':
            $org = imagecreatefromgif($plik);
            break;
            case 'png':
            $org = imagecreatefrompng($plik);
            break;
        }
        
        // kopiujemy obraz na nowy canvas
        imagecopyresampled($canvas, $org, 0, 0, 0, 0,
                            $szerokosc, $wysokosc, $img_szer, $img_wys);
        
        // zapisujemy jako jpeg, jakość 70/100
        if(imagejpeg($canvas, $plik, $jakosc)) {
            return true;
        } else {
            return false;
        }
    }
}