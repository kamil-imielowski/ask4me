<?php namespace classes\User;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class EscortFactory{
    private $users;

    function __construct($filters = null){
        if(!empty($filters)){
            $this->loadUsersWithFilters($filters);
        }else{
            $this->loadUsers();
        }
    }   

    private function loadUsers(){
        $database = dbCon();
        $users = array();
        $sql = array();

        $sql = $database->select("customers", '*', ["type" => 2]);
        foreach($sql as $v){
            $user = new \classes\User\ModelUser($v['id']);
            $user->loadCountry();
            $users[] = $user;
            unset($user);
        }

        $this->users = $users;
    }

    private function loadUsersWithFilters(array $filters){
        $database = dbCon();
        $users = array();
        $sql = array();
        $sexNot = $filters['sex'] == 'all' ? '[!]' : '';
        $countryNot = $filters['country'] == 'all' ? '[!]' : '';
        $partnerPreferencesNot = $filters['partner_preferences'] == 'all' ? '[!]' : '';
        $looksAgeNot = $filters['looks_age'] == 'all' ? '[!]' : '';
        $skinColorNot = $filters['skin_color'] == 'all' ? '[!]' : '';
        $eyesColorNot = $filters['eyes_color'] == 'all' ? '[!]' : '';
        $hairColorNot = $filters['hair_color'] == 'all' ? '[!]' : '';
        $bodyBuildNot = $filters['body_build'] == 'all' ? '[!]' : '';
        $languageNot = $filters['language'] == 'all' ? '[!]' : '';
        $categoryNot = $filters['category'] == 'all' ? '[!]' : '';

        $sql = $database->distinct()->select("customers", [
                                                                "[>]user_model_info" => ["id" => "user_id"],
                                                                "[>]user_model_languages" => ["id" => "user_id"],
                                                                "[>]users_to_categories" => ["id" => "user_id"],
                                                                "[>]user_model_services_location" => ["id" => "user_id"]],
                                                                ['customers.id'], 
                                                                ["AND" => [
                                                                "customers.type" => 2,
                                                                "customers.sex".$sexNot => $filters['sex'],
                                                                "user_model_info.partner_preferences".$partnerPreferencesNot => $filters['partner_preferences'],
                                                                "user_model_info.looks_age".$looksAgeNot => $filters['looks_age'],
                                                                "user_model_info.skin_color".$skinColorNot => $filters['skin_color'],
                                                                "user_model_info.eyes_color".$eyesColorNot => $filters['eyes_color'],
                                                                "user_model_info.hair_color".$hairColorNot => $filters['hair_color'],
                                                                "user_model_info.body_build".$bodyBuildNot => $filters['body_build'],
                                                                'user_model_languages.language_code'.$languageNot => $filters['language'],
                                                                "users_to_categories.category_id".$categoryNot => $filters['category'],
                                                                "user_model_services_location.country_iso_code_2".$countryNot => $filters['country'],

                ]]);
        foreach($sql as $v){
            $user = new \classes\User\ModelUser($v['id']);
            $user->loadCountry();
            $users[] = $user;
            unset($user);
        }

        $this->users = $users;
    }

    function getUsers(){
        return $this->users;
    }
}