<?php namespace classes\Product;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class ProductsFactory{

    private $products;
    private $type;
    private $userNick;
    private $userProducts;

    function __construct($type=null, $userNick=null){
        if($type !== null){
            $this->setType($type);
        }
        if($userNick != null){
            $this->setUserNick($userNick);
            
            $this->loadUserProduct();
        }
        $this->loadProducts();
    }

    function loadNewItems($limit=null){
        $database = dbCon();
        $date = date("Y-m-d", strtotime('-30 days'));
        $sql = array();
        $products = array();
        $sql = $database -> select("products", 'id', [
                                                        "date_created[>]" => $date,
                                                        "LIMIT"=>$limit
            ]);
        foreach($sql as $k){
            $products[] = new Product($k);
        }

        $this->setProducts($products);
    }

    function loadBestsellers($limit=null){
        $database = dbCon();
        $sql = $database -> select("order_info", 'product_id', ["LIMIT"=>$limit]);
        $bestsellers = array_count_values($sql);
        arsort($bestsellers);
        foreach ($bestsellers as $key => $value) {
            $products[] = new Product($key);
        }
        $this->setProducts($products);
    }

    function loadFeatured($limit=null){
        $database = dbCon();
        $sql = array();
        $products = array();
        $sql = $database->select("products", 'id', ['type'=>[1,2,3], "LIMIT"=>$limit]);//admin products at the moment
        foreach($sql as $k){
            $products[] = new Product($k);
        }
        $this->setProducts($products);
    }

    function loadMembershipAndTokens($limit=null){
        $database = dbCon();
        $sql = array();
        $products = array();
        $sql = $database->select("products", 'id', ['type'=>[1,2,3], "LIMIT"=>$limit]);
        foreach($sql as $k){
            $products[] = new Product($k);
        }
        $this->setProducts($products);
    }

    private function loadProducts(){
        $database = dbCon();
        $sql = array();
        $products = array();

        switch ($this->type) {
            case null:
                $sql = $database ->select("products", 'id');
                break;
            
            case '1'://Membership-basic
                $sql = $database ->select("products", 'id', ['type' => 1,"ORDER" => ['id'=>"DESC"]]);
                break;

            case '2'://Membership-vip
                $sql = $database ->select("products", 'id', ['type' => 2,"ORDER" => ['id'=>"DESC"]]);
                break;

            case '3'://Tokens            
                $sql = $database ->select("products", 'id', ['type' => 3,"ORDER" => ['id'=>"DESC"]]);
                break;

            case '4'://Users products
                $sql = $database ->select("products", 'id', ['type' => 4, "ORDER" => ['id'=>"DESC"]]);
                break;
        }

        foreach($sql as $k){
            $products[] = new Product($k);
        }
        $this->setProducts($products);
    }

    private function loadUserProduct(){
        $database = dbCon();
        $sql = array();
        $userProducts = array();
        $sql = $database -> select("customers", 'id', ['login' => $this->userNick]);
        $sql = $database -> select("user_products", 'product_id', ['user_id' => $sql[0]]);

        foreach($sql as $k){
            $userProducts[] = new Product($k);
        }
        $this->setUserProducts($userProducts);
    }

    function getProductsByString(string $string){
        $database = dbCon();
        $sql = array();
        $products = array();

        $sql = $database->select("products", 'id', ["OR" => [
                                                            'name[~]' => $string,
                                                            'description[~]' => $string
        ]]);

        foreach($sql as $k){
            $products[] = new Product($k);
        }
        return $products;
    }

    private function setType($type){$this->type = $type;}
    private function setProducts($products){$this->products = $products;}
    private function setUserNick($userNick){$this->userNick = $userNick;}
    private function setUserProducts($userProducts){$this->userProducts = $userProducts;}

    function getType(){return $this->type;}
    function getProducts(){return $this->products;}
    function getUserProducts(){return $this->userProducts;}
}