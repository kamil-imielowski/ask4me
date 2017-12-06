<?php namespace classes\Languages;
class Translate{
    private $langId;
    private $phraseId;
	private $phrase;

    function __construct($langId=null){
        if(empty($langId)){
            $langId = $this->lang_id();
        }
        $this->langId = $langId;
    } 
	
	function getString($id){
        $xml=simplexml_load_file(dirname(dirname(dirname(__FILE__))).'/language/'.$this->langId.'.xml') or die("Error: Cannot create object");
		return (string)$xml->$id;
	}
	
	private function lang_id() {
		if(isset($_COOKIE['lang'])){
			$lang_id = $_COOKIE['lang'];
		}else{
			/* if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
			$lang_id = $details->country;
			$lang_id = strtolower($lang_id); */
			$expiration_date=time()+3600*24*365;
			setcookie('lang',"en",$expiration_date,'/');
			$lang_id = 'en';
		}
		return $lang_id;
	}

	public function change_lang($lang_id){
		$expiration_date=time()+3600*24*365;
		setcookie('lang',$lang_id,$expiration_date,'/');  
	}
}