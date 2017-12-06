<?php

function validate($name, $value, $type, $lenght1 = 0, $lenght2 = 0){
	$error = array();
	$arrayType = explode("|",$type);
	foreach ($arrayType as &$method) {
		switch ($method) {
			case 'required':
				if($value=="" OR empty($value)){
					$error[] = 'Pole "'.$name.'": jest wymagane';
				} else {}
				break;
			case "min":
				if ( strlen($value) >= $lenght1 ) {					
				} else {
					$error[] = 'Pole "'.$name.'": minimalna ilość znaków to '.$lenght1;
				}
				break;
			case "max":
				if ( strlen($value) <= $lenght1 ) {					
				} else {					
					$error[] = 'Pole "'.$name.'": maksymalna ilość znaków to '.$lenght1;
				}
			case "min&max":
				if ( strlen($value) <= $lenght2 && strlen($value) >= $lenght1 ) {					
				} else {
					$error[] = 'Pole "'.$name.'": minimalna ilość znaków to '.$lenght1.', maksymalna ilość znaków to '.$lenght2;
				}
				break;
			case "number":
				if (is_numeric($value)) {
				} else {
					$error[] = 'Pole "'.$name.'": niepoprawna wartość';
				}			
				break;						
			case "email":
				if(filter_var($value, FILTER_VALIDATE_EMAIL)) {					
				} else {
					$error[] = 'Pole "'.$name.'": błędny format e-mail';
				}
				break;
			case "nip":
				$value = preg_replace("/[^0-9]+/", "", $value);
				if (strlen($value) != 10){
					$error[] = 'Pole "'.$name.'": błędny format NIP';
				} else {}
				break;
			case "pesel":
				$value = preg_replace("/[^0-9]+/", "", $value);
				if (!preg_match('/^[0-9]{11}$/',$value)){
					$error[] = 'Pole "'.$name.'": błędny format PESEL';
				}
				$arrSteps = array(1, 3, 7, 9, 1, 3, 7, 9, 1, 3); // tablica z odpowiednimi wagami
				$intSum = 0;
				for ($i = 0; $i < 10; $i++){
					$intSum += $arrSteps[$i] * $value[$i];
				}
				$int = 10 - $intSum % 10; 
				$intControlNr = ($int == 10)?0:$int;
				if ($intControlNr == $value[10]){
				}else{
					$error[] = 'Pole "'.$name.'": błędny PESEL';
				}
				break;
			case "adult":
				$adult = date("Y-m-d", strtotime('-'.'18'.' years'));
				if ($value > $adult){
					$error[] = 'Pole "'.$name.'": Musisz być pełnoletni, aby się zarejestrować';
				} else {}
				break;
			case "kod_pocztowy":
				if ( !preg_match("/^([0-9]{2})(-[0-9]{3})?$/i", $value) ) {
					$error[] = 'Pole "'.$name.'": błędny format KOD POCZTOWY';
				} else {}
				break;	
			case "regon":
				if ( validateREGON($value) == true ) {					
				} else {
					$error[] = 'Pole "'.$name.'": błędny format REGON';
				}
				break;
			case "md5":
				if ( strlen($value) == 32 ) {					
				} else {
					$error[] = '"'.$name.'": błędny format';
				}
				break;	
			case "file-max-size":
				// 1 Megabyte = 1,048,576 Bytes ==> 1048576
				if(!empty($lenght1) AND $lenght1 >= 1 AND is_int($lenght1)){
				} else {
					$lenght1 = 1;
				}				
				// $value['name']; $value['type']; $value['size']; $value['tmp_name'];
				
				if ( $value['size'] <= $lenght1 * 1048576  ) {		
				} else {
					$error[] = 'Pole "'.$name.'": rozmiar pliku jest zbyt duży. Maksymalny rozmiar to '.$lenght1.' MB';
				}

				break;	
	
			case "file-image":
				if($value['type'] == 'image/jpeg' OR $value['type'] == 'image/png'  OR $value['type']=='image/bmp')	{
					$test_type = true;
				} else {
					$test_type = false;
				}	  
				if ($test_type){		
				} else {
					$error[] = 'Pole "'.$name.'": błędny format pliku. Akceptowane formaty pliku to jpeg, png, bmp';
				}
				break;
				
			case "file-image-gif":
				if($value['type'] == 'image/jpeg' OR $value['type'] == 'image/png'  OR $value['type']=='image/bmp' OR $value['type']=='image/gif')	{
					$test_type = true;
				} else {
					$test_type = false;
				}	 
				if ($test_type){		
				} else {
					$error[] = 'Pole "'.$name.'": błędny format pliku. Akceptowane formaty pliku to jpeg, png, bmp';
				}
				break;
				
				
			case 'empty-array':
				if(count($value) == 0){
					$error[] = 'Pole "'.$name.'": jest wymagane';
				} else {}
				break;	
			
			case 'nrb':
				// Usuniecie spacji
				$iNRB = str_replace(' ', '', $value);
				// Sprawdzenie czy przekazany numer zawiera 26 znaków
				if(strlen($iNRB) != 26){
					$error[] = 'Pole "'.$name.'": niepoprawna długość';
				}
				// Zdefiniowanie tablicy z wagami poszczególnych cyfr				
				$aWagiCyfr = array(1, 10, 3, 30, 9, 90, 27, 76, 81, 34, 49, 5, 50, 15, 53, 45, 62, 38, 89, 17, 73, 51, 25, 56, 75, 71, 31, 19, 93, 57);
				 
				// Dodanie kodu kraju (w tym przypadku dodajemy kod PL)		
				$iNRB = $iNRB.'2521';
				$iNRB = substr($iNRB, 2).substr($iNRB, 0, 2); 
				 
				// Wyzerowanie zmiennej
				$iSumaCyfr = 0;

				// Pćtla obliczająca sumć cyfr w numerze konta
				for($i = 0; $i < 30; $i++) 
					$iSumaCyfr += $iNRB[29-$i] * $aWagiCyfr[$i];
				 
				// Sprawdzenie czy modulo z sumy wag poszczegolnych cyfr jest rowne 1
				if($iSumaCyfr % 97 == 1){
				}else{
					$error[] = 'Pole "'.$name.'": niepoprawny numer konta';
				}
				break;	

			case 'dowod':
				//sprawdz dlugosc podanego numeru
				if(strlen($value)!=9){
					$error[] = 'Pole "'.$name.'": niepoprawna długość';
					break;
				}
				$identity_card = strtoupper($value);
				//tablica wartosci znakow
				$def_value = array('0'=>0,'1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9,
				'A'=>10, 'B'=>11, 'C'=>12, 'D'=>13, 'E'=>14, 'F'=>15, 'G'=>16, 'H'=>17, 'I'=>18, 'J'=>19,
				'K'=>20, 'L'=>21, 'M'=>22, 'N'=>23, 'O'=>24, 'P'=>25, 'Q'=>26, 'R'=>27, 'S'=>28, 'T'=>29,
				'U'=>30, 'V'=>31, 'W'=>32, 'X'=>33, 'Y'=>34, 'Z'=>35);
				//tablica wag
				$importance = array(7,  3,  1,  0,  7,  3,  1,  7,  3);
				//oblicz sume kontrolna
				$identity_card_sum = 0;
				 
				for($i=0;$i<9;$i++){
					if($i<3 && $def_value[$identity_card[$i]]<10){
						$error[] = 'Pole "'.$name.'": niepoprawna seria i numer';
						break;
					}else if($i>2 && $def_value[$identity_card[$i]]>9){
						$error[] = 'Pole "'.$name.'": niepoprawna seria i numer';
						break;
					}
					$identity_card_sum += ((int)$def_value[$identity_card[$i]]) * $importance[$i];
				}
				//sprawdz wartosc sumy kontrolnej
				if($identity_card_sum%10 != $identity_card[3]  ){
					$error[] = 'Pole "'.$name.'": niepoprawna seria i numer';
				}
			break;
			
			case 'phone_number':
				if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{3}$/", $value)) {
					break;
				}else{
					$error[] = 'Pole "'.$name.'": niepoprawny format'; 
				}
			break;
			
			case 'phone_number_stc':
				if(preg_match("/^[0-9]{2}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/", $value)) {
					break;
				}else{
					$error[] = 'Pole "'.$name.'": niepoprawny format'; 
				}
			break;
		}				
	}	
	
	return $error; 
	
}	

function validateREGON($value){
	if (strlen($value) == 9) {
		$weights = array(8, 9, 2, 3, 4, 5, 6, 7 );
		// wagi stosowane dla REGONów 9-znakowych
	}
	elseif (strlen($value) == 14) {
		$weights = array(2, 4, 8, 5, 0, 9, 7, 3, 6, 1, 2, 4, 8);
		// wagi stosowane dla REGONów 14-znakowych
	}
	else {
		return false;
	}
	$sum = 0;
	for ($i = 0; $i < count($weights); $i++) {
		$sum+= $weights[$i] * $value[$i];
	}
	$int = $sum % 11;
	// dzielnikiem dla sumy kontrolnej jest liczba 11
	$checksum = ($int == 10) ? 0 : $int;
	// jeśli liczba kontrolna wynosi 10, to sumą kontrolną jest zero
	// w przeciwnym wypadku jest to ta sama liczba
	if ($checksum == $value[count($weights) ]) {
		// jezeli suma kontrolna jest rowna przedostatniej cyfrze w numerze REGON
		// to numerek jest poprawny
		return true;
	}
	return false;
}




