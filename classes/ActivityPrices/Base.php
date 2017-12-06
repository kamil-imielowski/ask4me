<?php namespace classes\ActivityPrices;

class Base{
    private $price;
    private $description;

    function __construct($price, $description){
        $this->price = $price;
        $this->description = $description;
    }

    protected function setPrice($price){
        $this->price = $price;
    }
    protected function setDescription($description){
        $this->description = $description;
    }

    function getPrice(){
        return $this->price;
    }
    function getDescription(){
        return $this->description;
    }
}