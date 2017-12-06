<?php 
function generateCode($length){
	$sal = "abcdefghijklmnopqrstuwxyz";
	$lal = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
	$int = "0123456789";
		
	$alLen = strlen($sal) - 1;
	$intLen = strlen($int) - 1;
		
	for ($i = 0; $i < $length; $i++) {
		if($i % 3 == 0){
			$n = rand(0, $alLen);
			$pass[] = $sal[$n];
		}
		if($i % 3 == 1){
			$n = rand(0, $alLen);
			$pass[] = $lal[$n];
		}
		if($i % 3 == 2){
			$n = rand(0, $intLen);
			$pass[] = $int[$n];
		}
	}
		
	return implode($pass);
}