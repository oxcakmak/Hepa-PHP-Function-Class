<?php
/*
* Title: Hepa PHP Function Class
* Description: Function class that contains useful and useful codes for applications you have developed with php
* Author: Osman CAKMAK
* Username: oxcakmak
* Email: info@oxcakmak.com
* Website: https://oxcakmak.com/
*/
/*
* # ABBREVIATION #
* s: String
* a: Array
* d: Date
* t: Type
* w: With
* f: Float
* fv: Float Value
* dt: Data Type
* db: Database
* val: Value
* cv: Convert
* cc: Calculate
* chk: Check
* clr: Clear
* del: Delete
* upd: Update
* ct: Custom
* rd: Random
* w: Way
* h: Hash
* cl: Color
* num: Number
* crt: Create
* gnt: Generate
* shr: Short
* fl: File
* sz: Size
* cnt: Count
* ctn: Contain
* cts: Contains
* addr: Address
* 
* 
* 

*/


/*
	* Description: String
	* Usage: $hepa->function(string);
	* Example: $hepa->function(string);
	*/
class hepa {
	
	/*
	* Description: Checks if a string starts with the specified target
	* Usage: $hepa->chkctStart($string, $target);
	* Example:  $hepa->chkctStart("abcde", "abc");
	*/
	public function chkctStart($str, $target, int $position = null){
		$length = strlen($str);
		$position = null === $position ? 0 : +$position;
		if ($position < 0) {
			$position = 0;
		} elseif ($position > $length) { $position = $length; }
		return $position >= 0 && substr($str, $position, strlen($target)) === $target;
	}
	/*
	* Description: Checks if a string ends with the specified target
	* Usage: $hepa->chkctEnd($string, $target);
	* Example:  $hepa->chkctEnd("abcde", "abc");
	*/
	public function chkctEnd($str, $target, int $position = null){
		$length = strlen($str);
		$position = null === $position ? $length : +$position;
		if ($position < 0) { $position = 0; } elseif ($position > $length) { $position = $length; }
		$position -= strlen($target);
		return $position >= 0 && substr($str, $position, strlen($target)) === $target;
	}
	/*
	* Description: Converts a string to UTF-8 encoding type accordingly.
	* Usage: $hepa->cvs2Utf8($string);
	* Example:  $hepa->cvs2Utf8("abcde");
	*/
	public function cvs2Utf8($str){ return iconv(mb_detect_encoding($str, mb_detect_order(), true), "UTF-8", $str); }
	/*
	* Description: Clears illegal characters in a string
	* Usage: $hepa->sclr($string);
	* Example:  $hepa->sclr("abcde");
	*/
	public function sclr($str){ return htmlspecialchars(strip_tags(stripslashes(trim($str))), ENT_QUOTES, 'UTF-8'); }
	/*
	* Description: Cleans up characters in a string that could lead to an invalid xss vulnerability
	* Usage: $hepa->sXssclr($string);
	* Example:  $hepa->sXssclr("<script>alert('test');</script>");
	*/
	public function sXssclr($str){ return htmlspecialchars($data, ENT_QUOTES, 'UTF-8'); }
	
	/*
	* Description: Random color hex code generation way 1
	* Usage: $hepa->rdwHexcl1();
	* Example:  $hepa->rdwHexcl1();
	*/
	public function rdwHexcl1(){ return str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT); }
	/*
	* Description: Random color hex code generation way 2
	* Usage: $hepa->rdwHexcl2();
	* Example: $hepa->rdwHexcl2();
	*/
	public function rdwHexcl2(){ return sprintf('%06X', mt_rand(0, 0xFFFFFF)); }
	/*
	* Description: Generate a random floating digit number.
	* Usage: $hepa->genRandNum(lower, upper, floating);
	* Example: $hepa->function(0, 100, true); 
	* ! You can specify true or false if you wish. !
	*/
	public function gntrndnumwf($lower = null, $upper = null, $floating = null){
		if (null === $floating) {
			if (is_bool($upper)) {
				$floating = $upper;
				$upper = null;
			} elseif (is_bool($lower)) {
				$floating = $lower;
				$lower = null;
			}
		}
		if (null === $lower && null === $upper) {
			$lower = 0;
			$upper = 1;
		} elseif (null === $upper) {
			$upper = $lower;
			$lower = 0;
		}
		if ($lower > $upper) {
			$temp = $lower;
			$lower = $upper;
			$upper = $temp;
		}
		$floating = $floating || (is_float($lower) || is_float($upper));
		if ($floating || $lower % 1 || $upper % 1) {
			$randMax = mt_getrandmax();
			return $lower + abs($upper - $lower) * mt_rand(0, $randMax) / $randMax;
		}
		return rand((int) $lower, (int) $upper);
    }
	/*
	* Description: Calculate file size
	* Usage: $hepa->ccflsz($size);
	* Example:  $hepa->ccflsz("1874080");
	*/
	public function ccflsz($size){
        if ($size < 1024){ return $size . ' B'; }else{
			$size = $size / 1024;
			$units = ["KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
			foreach ($units as $unit){ if(round($size, 2) >= 1024){ $size = $size / 1024; }else{ break; } }
			return round($size, 2) . ' ' . $unit;
		}
    }
	/*
	* Description: Checks the extensions of the entered e-mail addresses (Blocks temporary e-mail addresses)
	* Initialize: $domains = array('gmail.com','yahoo.com','hotmail.com','outlook.com','msn.com','yandex.com');
	* Usage: $hepa->ccEmailctn($email, $domains);
	* Example:  $hepa->ccEmailctn("info@oxcakmak.com", $domains);
	*/
    public function ccEmailctn($email, $domains){
		foreach ($domains as $domain) { 
			$pos = @strpos($email, $domain, strlen($email) - strlen($domain));
			if ($pos === false){ continue; } 
			if ($pos == 0 || $email[(int) $pos - 1] == "@" || $email[(int) $pos - 1] == "."){ return 1;  } 
		}
		return 0;
	}
	/*
	* Description: Get client IP Addresss
	* Usage: $hepa->function(string);
	* Example: $hepa->function(string);
	*/
	public function getClientIpaddr(){
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote = @$_SERVER['REMOTE_ADDR'];
		if(filter_var($client, FILTER_VALIDATE_IP)){ $ip = $client; }
		elseif(filter_var($forward, FILTER_VALIDATE_IP)){ $ip = $forward;
		}else{ $ip = $remote; }
		return $ip;
    }
	/*
	* Description: Random String Generator
	* Usage: $hepa->gntcts(minLength[Number], maxLength[Number], useLower[true/false], useUpper[true/false], useNumbers[true/false], useSpecial[true/false]);
	* Example: $hepa->gntcts(0, 12, true, false, true, false);
	*/
	public function gntcts($minLength = 20, $maxLength = 20, $useLower = true, $useUpper = true, $useNumbers = true, $useSpecial = false) {
		$charset = '';
		if($useLower) { $charset .= "abcdefghijklmnopqrstuvwxyz"; }
		if($useUpper){ $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; }
		if($useNumbers){ $charset .= "123456789"; }
		if($useSpecial){ $charset .= "~@#$%^*()_+-={}|]["; }
		if($minLength > $maxLength){ $length = mt_rand($maxLength, $minLength); }else{ $length = mt_rand($minLength, $maxLength); }
		$key = '';
		for($i = 0; $i < $length; $i++){ $key .= $charset[(mt_rand(0, strlen($charset) - 1))]; }
		return $key;
	}
}
?>
