<?php namespace classes\Product;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class Product{
    
    private $id;
    private $name;
    private $description;
    private $price;
    private $type;
    private $photo;
    private $fileName;
    private $userProduct;
    private $dateCreated;
    private $solds;
    private $tokens;


    function __construct($id=null){
        if($id != null){
            $this->setId($id);
            $this->loadProduct();
            $this->loadSolds();
        }
    }

    function uploadProduct($data, $file){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();
        if(isset($file['img']) && !empty($file['img']['name'])){
            $photo = new \classes\Photo\Photo();
            $photo -> upload($file['img'], '/img/products/');
        }
        if(isset($file['product_file']) && !empty($file['product_file']['name'])){
            switch ($file['product_file']['type']) {
                case 'video/mp4':
                    $product = new \classes\Video\Video();
                    $product -> upload($file['product_file'], '/product_file/');
                    break;
                
                default:
                    $product = new \classes\Photo\Photo();
                    $product -> upload($file['product_file'], '/product_file/');
                    break;
            }
        }
       
        if(empty($this->id)){
            if(!$database -> insert("products", [
                                                    'name' => $data['name'],
                                                    'description' => $data['description'],
                                                    'price' => $data['price'],
                                                    'type' => 4,
                                                    'photo_id' => $photo->getId(),
                                                    'file_name' => $product->getName(),
                                                    'date_created' => $date
            ])){
                throw new \Exception($translate->getString("error-DBInsert"));
            }
            $this->setId($database->id());
        }else{
            if(!$database -> update("products", [
                                                    'name' => $data['name'],
                                                    'description' => $data['description'],
                                                    'price' => $data['price'],
                                                    'type' => 4,
                                                    'date_updated' => $date
            ], ['id'=>$this->id])){
                throw new \Exception($translate->getString("error-DBUpdate"));
            }

            if(isset($file['img']) && !empty($file['img']['name'])){
                if(!$database->update("products", ['photo_id' => $photo->getId()], ['id'=>$this->getId()])){
                    throw new \Exception($translate->getString("error-DBUpdate"));
                }
            }
            if(isset($file['product_file']) && !empty($file['product_file']['name'])){
                if(!$database->update("products", ['file_name' => $product->getName()], ['id'=>$this->getId()])){
                    throw new \Exception($translate->getString("error-DBUpdate"));
                }
            }
        }
    }


    function uploadMembership($data, $file){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $date = date("Y-m-d H:i:s");
        if(isset($file['img-basic']) && !empty($file['img-basic']['name'])){
            $photo = new \classes\Photo\Photo();
            $photo -> upload($file['img-basic'], '/img/products/');
        }
        if($database->has("products", ['type' => 1])){//isset basic
            if(!$database->update("products",[
                                                'name' => $data['name-basic'],
                                                'description' => $data['description-basic'],
                                                'price' => $data['price-basic'],
                                                'date_updated' => $date
                ], ['type' => 1])){
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
            if(isset($photo)){
                if(!$database->update("products", ['photo_id' => $photo->getId()], ['type' => 1])){
                    throw new \Exception($translate->getString("error-DBUpdate"));
                }
            }
        }else{
            if(!$database->insert("products",[
                                                'name' => $data['name-basic'],
                                                'description' => $data['description-basic'],
                                                'price' => $data['price-basic'],
                                                'type' => 1,
                                                'photo_id' => isset($photo) ? $photo->getId() : null,
                                                'date_created' => $date
                ])){
                throw new \Exception($translate->getString("error-DBInsert"));
            }
        }

        if(isset($file['img-vip']) && !empty($file['img-vip']['name'])){
            $photo_vip = new \classes\Photo\Photo();
            $photo_vip -> upload($file['img-vip'], '/img/products/');
        }
        if($database->has("products", ['type' => 2])){//isset VIP
            if(!$database->update("products",[
                                                'name' => $data['name-vip'],
                                                'description' => $data['description-vip'],
                                                'price' => $data['price-vip'],
                                                'date_updated' => $date
                ], ['type' => 2])){
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
            if(isset($photo_vip)){
                if(!$database->update("products", ['photo_id' => $photo_vip->getId()], ['type' => 2])){
                    throw new \Exception($translate->getString("error-DBUpdate"));
                }
            }
        }else{
            if(!$database->insert("products",[
                                                'name' => $data['name-vip'],
                                                'description' => $data['description-vip'],
                                                'price' => $data['price-vip'],
                                                'type' => 2,
                                                'photo_id' => isset($photo_vip) ? $photo_vip->getId() : null,
                                                'date_created' => $date
                ])){
                throw new \Exception($translate->getString("error-DBInsert"));
            }
        }
    }

    function uploadTokens($data, $file){
        $database = dbCon();
        $date = date("Y-m-d H:i:s");
        $translate = new \classes\Languages\Translate();
        if(isset($file['img']) && !empty($file['img']['name'])){
            $photo = new \classes\Photo\Photo();
            $photo -> upload($file['img'], '/img/products/');
        }
        if(isset($this->id)){
            if(!$database->update('products', [
                                                'name' => $data['name'],
                                                'description' => $data['description'],
                                                'price' => $data['price'],
                                                'date_updated' => $date    
                ], ['id' => $this->id])){
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
            if(!$database->update("tokens", ['tokens' => $data['tokens'], 'date_updated' => $date], ['product_id' => $this->id])){
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
            if(isset($photo)){
                if(!$database->update('products', ['photo_id' => $photo->getId()], ['id' => $this->id])){
                    throw new \Exception($translate->getString("error-DBUpdate"));
                }
            }
        }else{
            if(!$database->insert('products', [
                                                'name' => $data['name'],
                                                'description' => $data['description'],
                                                'price' => $data['price'],
                                                'type' => 3,
                                                'photo_id' => isset($photo) ? $photo->getId() : null,
                                                'date_created' => $date    
                ])){
                throw new \Exception($translate->getString("error-DBInsert"));
            }
            $this->setId($database->id());

            if(!$database->insert('tokens', [
                                                'product_id' => $this->id,
                                                'tokens' => $data['tokens']
                ])){
                throw new \Exception($translate->getString("error-DBInsert"));
            }
        }
    }

    function deleteProduct(){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        if($database->has("user_products", ['product_id' => $this->id])){
            if(!$database->delete("user_products", ['product_id' => $this->id])){
                throw new \Exception($translate->getString("error-DBDelete"));
            }
        }
        if($database->has("tokens", ['product_id' => $this->id])){
            if(!$database->delete("tokens", ['product_id' => $this->id])){
                throw new \Exception($translate->getString("error-DBDelete"));
            }
        }
        if(!$database->delete("products", ['id' => $this->id])){
            throw new \Exception($translate->getString("error-DBDelete"));
        }
    }

    function loadSolds(){
        $database = dbCon();
        $count = $database -> count("order_info", ['product_id' => $this->id]);
        $this->setSolds($count);
    }

    private function loadProduct(){
        $database = dbCon();
        $sql = $database ->select("products", '*', ['id' => $this->id]);

        $this->setName($sql[0]['name']);
        $this->setDescription($sql[0]['description']);
        $this->setPrice($sql[0]['price']);
        $this->setType($sql[0]['type']);
        $this->setFileName($sql[0]['file_name']);
        $this->setDateCreated($sql[0]['date_created']);

        $photo = new \classes\Photo\Photo($sql[0]['photo_id'], 'product');
        $this->setPhoto($photo);

        if($database ->has("user_products", ['product_id' => $this->id])){
            $sql = $database ->select("user_products", 'user_id', ['product_id' => $this->id]);
            $userProduct = new \classes\User\User($sql[0]);
            $this->setUserProduct($userProduct);
        }

        if($this->type == 3){
            $sql = $database->select("tokens", 'tokens', ['product_id' => $this->id]);
            $this->setTokens($sql[0]);
        }
    }

    private function setId($id){$this->id = $id;}
    private function setName($name){$this->name = $name;}
    private function setDescription($description){$this->description = $description;}
    private function setPrice($price){$this->price = $price;}
    private function setType($type){$this->type = $type;}
    private function setPhoto(\classes\Photo\Photo $photo){$this->photo = $photo;}
    private function setUserProduct(\classes\User\User $userProduct){$this->userProduct = $userProduct;}
    private function setFileName($fileName){$this->fileName = $fileName;}
    private function setDateCreated($dateCreated){$this->dateCreated = $dateCreated;}
    private function setSolds($solds){$this->solds = $solds;}
    private function setTokens($tokens){$this->tokens = $tokens;}

    function getId(){return $this->id;}
    function getName(){return $this->name;}
    function getDescription(){return $this->description;}
    function getPrice(){return $this->price;}
    function getType(){return $this->type;}
    function getPhoto(){return $this->photo;}
    function getUserProduct(){return $this->userProduct;}
    function getFileName(){return $this->fileName;}
    function getSRCFile(){return '/product_file/orginal/'.$this->fileName;}
    function getDateCreated(){return date("d-m-Y", strtotime($this->dateCreated));}
    function getSolds(){return $this->solds;}
    function getTokens(){return $this->tokens;}

    function getURLName(){
        $URLchars = new \classes\URLs\UrlChars($this->name);
        $name = $URLchars->convert();
        $name = strtolower($name);
        $name = str_replace(" ", "-", $name); 
        $name = str_replace(".", "", $name); 
        $name = str_replace(",", "", $name); 
        return $name;
    }
}