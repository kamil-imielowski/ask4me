<?php namespace classes\Invoices;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';
#dane do faktury od uzytkownika
class InvoiceData{
    private $id;
    private $userId;
    private $companyName;
    private $firstName;
    private $lastName;
    private $address;
    private $city;
    private $postalCode;
    private $country;

    function __construct($userId){
        $this->userId = $userId;
        $this->loadInvoiceData();
    }

    function saveToDB($data){
        $database = dbCon();
        $translate = new \classes\Languages\Translate();
        $date = date("Y-m-d H:i:s");
        if(!empty($this->id)){
            #update
            if(!$database->update("invoice_users_data", ["company_name" => $data['company_name'],
                                                        "first_name"    => $data['first_name'],
                                                        "last_name"     => $data['last_name'],
                                                        "address"       => $data['address'],
                                                        "city"          => $data['city'],
                                                        "postal_code"   => $data['postal_code'],
                                                        "country"       => $data['country'],
                                                        "date_updated"  => $date],
                                                        ["id" => $this->id]))
            {
                throw new \Exception($translate->getString("error-DBUpdate"));
            }
        }else{
            #insert
            if(!$database->insert("invoice_users_data", ["user_id"      => $this->userId,
                                                        "company_name"  => $data['company_name'],
                                                        "first_name"    => $data['first_name'],
                                                        "last_name"     => $data['last_name'],
                                                        "address"       => $data['address'],
                                                        "city"          => $data['city'],
                                                        "postal_code"   => $data['postal_code'],
                                                        "country"       => $data['country'],
                                                        "date_created"  => $date,
                                                        "date_updated"  => $date]))
            {
                throw new \Exception($translate->getString("error-DBInsert"));
            }
        }
    }

    private function loadInvoiceData(){
        $database = dbCon();
        $sql = $database->select("invoice_users_data", '*', ["user_id" => $this->userId]);
        if(!empty($sql)){
            foreach($sql as $v){
                $this->setId($v['id']);
                $this->setCompanyName($v['company_name']);
                $this->setFirstName($v['first_name']);
                $this->setLastName($v['last_name']);
                $this->setAddress($v['address']);
                $this->setCity($v['city']);
                $this->setPostalCode($v['postal_code']);
                $this->setCountry(new \classes\Country\Country($v['country']));
            }
        }
    }

    function getId(){
        return $this->id;
    }
    function getCompanyName(){
        return $this->companyName;
    }
    function getFirstName(){
        return $this->firstName;
    }
    function getLastName(){
        return $this->lastName;
    }
    function getAddress(){
        return $this->address;
    }
    function getCity(){
        return $this->city;
    }
    function getPostalCode(){
        return $this->postalCode;
    }
    function getCountry(){
        return $this->country;
    }

    private function setId($id){
        $this->id = $id;
    }
    private function setCompanyName($companyName){
        $this->companyName = $companyName;
    }
    private function setFirstName($firstName){
        $this->firstName = $firstName;
    }
    private function setLastName($lastName){
        $this->lastName = $lastName;
    }
    private function setAddress($address){
        $this->address = $address;
    }
    private function setCity($city){
        $this->city = $city;
    }
    private function setPostalCode($postalCode){
        $this->postalCode = $postalCode;
    }
    private function setCountry(\classes\Country\Country $country){
        $this->country = $country;
    }

}