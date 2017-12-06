<?php namespace classes\Transmissions;
require_once dirname(dirname(dirname(__FILE__))).'/config/config.php';

class TransmissionsFactory{
    private $transmissions;

    function __construct($filters=null){
        if(empty($filters)){
            $this->__load();
        }else{
            $this->loadWithFilters($filters);
        }
    }

    private function __load(){
        $database = dbCon();
        $transmissions = array();
        $sql = $database->select("transmissions", '*', ["activity_date[>=]" => date("Y-m-d H:i:s", strtotime("-80 sec"))]);
        foreach($sql as $v){
            $user = new \classes\User\User($v['user_id']);
            $transmissions[] = new Transmission($user);
        }
        $this->setTransmissions($transmissions);
    }

    private function loadWithFilters(array $filters){
        $database = dbCon();
        $transmissions = array();
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
        $sql = $database->distinct()->select("transmissions",[  
                                                    "[>]customers" => ["transmissions.user_id" => "id"],
                                                    "[>]user_model_info" => ["transmissions.user_id" => "user_id"],
                                                    "[>]user_model_languages" => ["transmissions.user_id" => "user_id"],
                                                    "[>]users_to_categories" => ["transmissions.user_id" => "user_id"],
                                                    "[>]user_model_services_location" => ["transmissions.user_id" => "user_id"]],
                                                    ['transmissions.user_id'],
                                                    ["AND"=>[
                                                    "transmissions.activity_date[>=]" => date("Y-m-d H:i:s", strtotime("-80 sec")),
                                                    "customers.type" => 2,
                                                    "customers.sex".$sexNot => $filters['sex'],

                                                    "OR"=>[
                                                        "user_model_info.partner_preferences".$partnerPreferencesNot => $filters['partner_preferences'],
                                                        "user_model_info.partner_preferences" => !empty($partnerPreferencesNot) ? null : ''
                                                    ],
                                                    "OR"=>[
                                                        "user_model_info.looks_age".$looksAgeNot => $filters['looks_age'],
                                                        "user_model_info.looks_age" => !empty($looksAgeNot) ? null : ''
                                                    ],
                                                    "OR"=>[
                                                        "user_model_info.skin_color".$skinColorNot => $filters['skin_color'],
                                                        "user_model_info.skin_color" => !empty($skinColorNot) ? null : ''
                                                    ],
                                                    "OR"=>[
                                                        "user_model_info.eyes_color".$eyesColorNot => $filters['eyes_color'],
                                                        "user_model_info.eyes_color" => !empty($eyesColorNot) ? null : ''
                                                    ],
                                                    "OR"=>[
                                                        "user_model_info.hair_color".$hairColorNot => $filters['hair_color'],
                                                        "user_model_info.hair_color" => !empty($hairColorNot) ? null : ''
                                                    ],
                                                    "OR"=>[
                                                        "user_model_info.body_build".$bodyBuildNot => $filters['body_build'],
                                                        "user_model_info.body_build" => !empty($bodyBuildNot) ? null : ''
                                                    ],

                                                    'user_model_languages.language_code'.$languageNot => $filters['language'],
                                                    "users_to_categories.category_id".$categoryNot => $filters['category'],
                                                    "user_model_services_location.country_iso_code_2".$countryNot => $filters['country'],
                                                    ]] 

        );
        foreach($sql as $v){
            $user = new \classes\User\User($v['user_id']);
            $transmissions[] = new Transmission($user);
        }
        $this->setTransmissions($transmissions);
    }

    private function setTransmissions(array $transmissions){
        $this->transmissions = $transmissions;
    }

    function getTransmissions(){
        return $this->transmissions;
    }
}