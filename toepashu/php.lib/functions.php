<?php
class FUNCS {
	
	static function getFileName(){
		$name = $_SERVER['SCRIPT_NAME'];
		$s1 = strripos($name,'/')+1;
		$s2 = strlen($name)-strripos($name,'/')-1;
		return substr($name,$s1,$s2);
	}
	
	static function legalLink(){
		if($_SERVER['HTTP_REFERER'] == '' || $_SERVER['HTTP_REFERER'] == NULL){
			return false;
		}
		else{
			return true;
		}
	}
	
	static function runjs($query){
		echo '<script>'.$query.'</script>';
	}
	
	static function strToAry($aryVal,$stokTag){
		$tagAry = array();
		$stok   = strtok($aryVal,$stokTag);
		while($stok !== false){
			$tagAry[] = $stok;
			$stok = strtok($stokTag);
		}
		return $tagAry;
	}
	
	
	static function strHandler($str){
		$str = preg_replace("/(\015\012)|(\015)|(\012)/","<br/>",$str);
		$str = str_replace(" ","&nbsp;",$str);
		$str = str_replace('"','\"',$str);
		$str = str_replace("'","\'",$str);
		return $str;
	}
	
	
	static function br2nl($text) {
		return preg_replace( '!<br.*>!iU', "\n", $text );
	}
	
	static function transformStrHandler($str){
		$str = preg_replace( '!<br.*>!iU', "\n",$str);
		$str = str_replace("&nbsp;"," ",$str);
		$str = str_replace('\"','"',$str);
		$str = str_replace("\'","'",$str);
		return $str;
	}
	
	static function ace_substr($s,$start,$end){
		$index_1 = strripos($s,$start)+strlen($start);
		$index_2 = strripos($s,$end);
		$length = $index_2-$index_1;
		return substr($s, $index_1,$length);
	}
	
	
	
	/**************************************************時間計算***********************************************************/
	static function transformTimeStamp($str){
		if(strpos($str, '-')){
			list($y,$m,$d,$h,$i,$s) = sscanf($str,'%d-%d-%d %d:%d:%d');
			return mktime($h,$i,$s,$m,$d,$y);
		}
		elseif(strpos($str, '/')){
			list($y,$m,$d,$h,$i,$s) = sscanf($str,'%d/%d/%d %d:%d:%d');
			return mktime($h,$i,$s,$m,$d,$y);
		}
		else{
			return FALSE;
		}
	}
	static function calculatorTime($sec){
		$hour = floor($sec/3600);
		if($hour < 10){
			$hour = '0'.$hour;
		}
		$sec2 = $sec%3600;
		$minute = floor($sec2/60);
		if($minute < 10){
			$minute = '0'.$minute;
		}
		$sec3 = $sec2%60;
		if($sec3 < 10){
			$sec3 = '0'.$sec3;
		}
		return $hour.':'.$minute.':'.$sec3;
	}
	/**********************************************************取得IP**************************************************************/
	static function GetIP(){
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
		else
			$ip = "unknown";
		return($ip);
	}
	
	static function get_real_ip()
	{
		$ip=false;
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if($ip){
				array_unshift($ips, $ip); $ip = FALSE;
			}
			for($i = 0; $i < count($ips); $i++){
				if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])){
					$ip = $ips[$i];
					break;
				}
			}
		}
		return($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}
	
	static function GetIP_2(){
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip=$_SERVER['REMOTE_ADDR'];
	
		return $ip;
	}
	
	/*
	 * email 驗證
	 */
	static function validateEmail($email){
		$isValid = true;
		$atIndex = strrpos($email, "@");
		if (is_bool($atIndex) && !$atIndex)
		{
			$isValid = false;
		}
		else
		{
			$domain = substr($email, $atIndex+1);
			$local = substr($email, 0, $atIndex);
			$localLen = strlen($local);
			$domainLen = strlen($domain);
			if ($localLen < 1 || $localLen > 64)
			{
				// local part length exceeded
				$isValid = false;
			}
			else if ($domainLen < 1 || $domainLen > 255)
			{
				// domain part length exceeded
				$isValid = false;
			}
			else if ($local[0] == '.' || $local[$localLen-1] == '.')
			{
				// local part starts or ends with '.'
				$isValid = false;
			}
			else if (preg_match('/\\.\\./', $local))
			{
				// local part has two consecutive dots
				$isValid = false;
			}
			else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
			{
				// character not valid in domain part
				$isValid = false;
			}
			else if (preg_match('/\\.\\./', $domain))
			{
				// domain part has two consecutive dots
				$isValid = false;
			}
			else if
			(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
					str_replace("\\\\","",$local)))
			{
				// character not valid in local part unless
				// local part is quoted
				if (!preg_match('/^"(\\\\"|[^"])+"$/',
						str_replace("\\\\","",$local)))
				{
					$isValid = false;
				}
			}
			if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
			{
				// domain not found in DNS
				$isValid = false;
			}
		}
		return $isValid;
	}
	
	
	/*
	 * 得到檔案類型
	 */
	static function Get_file_kind($fn) {
		$fn = strtolower($fn);
		if (preg_match("(.jpg|.jpeg|.gif)", $fn))
			$mode = "photo" ;
		elseif (preg_match("(.png)", $fn))
			$mode = "png" ;
		elseif (preg_match("(.sxw|.sxc|.sxd|.sxi)", $fn))
			$mode = "f-ooo" ;
		elseif (preg_match("(.doc|.xls|.ppt|.docx|.pptx|.xlsx|.pdf)", $fn))
			$mode = "f-mso" ;
		elseif (preg_match("(.zip|.rar|.tar|.gz)", $fn))
			//$mode = "f-zip" ;
		$mode = "f-none" ;
		elseif (preg_match("(.exe|.com|.bat)", $fn))
			//$mode = "f-exe" ;
		$mode = "f-none" ;
		elseif (preg_match("(.txt|.inf|.csv)", $fn))
			$mode = "f-txt" ;
		elseif (preg_match("(.swf)", $fn))
			$mode = "f-swf" ;
		elseif (preg_match("(.htm|.html|.shtml)", $fn))
			$mode = "f-htm" ;
		elseif (preg_match("(.flv)", $fn))
			$mode = "flv" ;
		elseif (preg_match("(.php3|.php)", $fn))  //特定格式無法上傳
			$mode = "f-none" ;
		else
			$mode = "f-data" ;
	
		return  $mode ;
	}
	
	
	
	/*
	 * filter
	 */
	static function _getenv($name){
		if(getenv($name)){
			if($name=="HTTP_REFERER"){
		  return filter_var(getenv($name), FILTER_SANITIZE_URL);
			}else{
		  return filter_var(getenv($name), FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}else{
			return '';
		}
	}
	
	static function get($str, $type=0)
	{
		$gstr=trim($_GET[$str]);
		switch($type)
		{
			case 0:{
				$gstr=filter_var($gstr, FILTER_SANITIZE_NUMBER_INT);
				return intval($gstr);
		 		break;
			}				
		 	case 1:{
		 		return $gstr=filter_var($gstr, FILTER_SANITIZE_SPECIAL_CHARS);			 
			 	break;
		 	}
		 	case 2:{
		 		return $gstr=filter_var($gstr, FILTER_SANITIZE_NUMBER_FLOAT);
		 		break;
		 	}
		}
	}
	static function post($str, $type=0)
	{
		$gstr=trim($_POST[$str]);
		switch($type)
		{
			case 0:{
				$gstr=filter_var($gstr, FILTER_SANITIZE_NUMBER_INT);
				return intval($gstr);
		 		break;
			}				
			case 1:{
			 	$gstr=filter_var($gstr, FILTER_SANITIZE_SPECIAL_CHARS);
				return $gstr;
				break;
			}
		 	
		 	case 2:{                      //fck
				return $gstr;
			 	break;
			}			 
		 	case 3:{
		 		if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
			 		return $gstr;
			 	}
			 	else{
			 		return "";			 		
			 	}
			 	break;
		 	}
		 	case 4:{
		 		return $gstr=filter_var($gstr, FILTER_SANITIZE_NUMBER_FLOAT);
		 		break;
		 	}
		}
	}
	
	static function inputFilter($var,$input_type='GET',$type=1,$min_range=0,$max_range=0){
		switch($input_type){
			case 'GET':{
				$input_type = INPUT_GET;
				break;
			}
			case 'POST':{
				$input_type = INPUT_POST;
				break;
			}
			case 'COOKIE':{
				$input_type = INPUT_COOKIE;
				break;
			}
			case 'SERVER':{
				$input_type = INPUT_SERVER;
				break;
			}
			case 'SESSION':{
				$input_type = INPUT_SESSION;
				break;
			}
			default:{
				$input_type = INPUT_GET;
				break;
			}
		}
		
		switch($type){
			case 1:{                        //過濾整數
				return filter_input($input_type, $var, FILTER_SANITIZE_NUMBER_INT);
				break;
			}
			case 2:{                        //過濾浮點數
				return filter_input($input_type, $var, FILTER_SANITIZE_NUMBER_FLOAT);
				break;
			}
			case 3:{                        //過濾字串
				$str = filter_input($input_type, $var, FILTER_SANITIZE_STRING);
				$str = iconv('utf-8','utf-8//IGNORE',$str);
				return $str;
				break;
			}
			case 4:{                        //過濾email
				$email = filter_input($input_type, $var, FILTER_VALIDATE_EMAIL);
				if(FUNCS::validateEmail($email)){
					return $email;
				}
				else{
					return false;
				}
				break;
			}
			case 5:{                        //驗證布林值
				return filter_input($input_type, $var, FILTER_VALIDATE_BOOLEAN);
				break;
			}
			case 6:{                        //驗證URL
				return filter_input($input_type, $var, FILTER_VALIDATE_URL);
				break;
			}
			case 7:{                        //驗證日期
				$options = array('options'=>array("regexp"=>"((^((1[8-9]\d{2})|([2-9]\d{3}))([-\/\._])(10|12|0?[13578])([-\/\._])(3[01]|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))([-\/\._])(11|0?[469])([-\/\._])(30|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))([-\/\._])(0?2)([-\/\._])(2[0-8]|1[0-9]|0?[1-9])$)|(^([2468][048]00)([-\/\._])(0?2)([-\/\._])(29)$)|(^([3579][26]00)([-\/\._])(0?2)([-\/\._])(29)$)|(^([1][89][0][48])([-\/\._])(0?2)([-\/\._])(29)$)|(^([2-9][0-9][0][48])([-\/\._])(0?2)([-\/\._])(29)$)|(^([1][89][2468][048])([-\/\._])(0?2)([-\/\._])(29)$)|(^([2-9][0-9][2468][048])([-\/\._])(0?2)([-\/\._])(29)$)|(^([1][89][13579][26])([-\/\._])(0?2)([-\/\._])(29)$)|(^([2-9][0-9][13579][26])([-\/\._])(0?2)([-\/\._])(29)$))"));				
				filter_input($input_type, $var, FILTER_VALIDATE_REGEXP , $options);
				
				break;
			}
			case 8:{                        //驗證範圍整數
				$options = array('options'=>array("min_range"=>$min_range,"max_range"=>$max_range));
				return filter_input($input_type, $var, FILTER_VALIDATE_INT , $options);
				break;
			}
		}
	}
	
	static function time_handler(){
		$current_time = mktime();
		$current_date = getdate($current_time);
		$pass_day = $current_date['wday'];
		$one_day = 60*60*24;
		$week_begin_date = date('Y-m-d 00:00:00',$current_time-($one_day*$pass_day));
		$week_end_date = date('Y-m-d 23:59:59',$current_time+($one_day*(6-$pass_day)));
		
		$day_begin_date = date('Y-m-d 00:00:00');
		$day_end_date = date('Y-m-d 23:59:59');
		
		return array(
			'current_time' => $current_time,
			'current_date' => date('Y-m-d H:i:s',$current_time),
			'week_begin_date' => $week_begin_date,
			'week_end_date' => $week_end_date,
			'day_begin_date' => $day_begin_date,
			'day_end_date' => $day_end_date,
			'week_begin_time' => strtotime($week_begin_date),
			'week_end_time' => strtotime($week_end_date),
			'day_begin_time' => strtotime($day_begin_date),
			'day_end_time' => strtotime($day_end_date)
		);
	}
	
	static function get_award($probability,$awards,$normal_prize = null){
		$prize_ary = array();	
		foreach ($awards as $key => $value){
			for($idx = 0 ; $idx < $value ; $idx++){
				$tmp = rand(1, $probability);
				while($prize_ary[$tmp]){				
					$tmp = rand(1, $probability);
				}
				$prize_ary[$tmp] = $key;
			}
		}	
		$get_prize = rand(1, $probability);	
		if($prize_ary[$get_prize]){
			return $prize_ary[$get_prize];
		}
		elseif($normal_prize != null){		
			return $normal_prize;
		}
		else{
			return false;
		}	
	}
	
	
	static function checkImgFiles($type,$tmp_name){
		if (strstr($type, "jp")) {           /*上傳圖片類型為jpg */
			if(!($source = @ imageCreatefromjpeg($tmp_name))){
				return false;
			}
			else{
				return true;
			}
		}
		elseif(strstr($type, "png")) {       /*上傳圖片類型為png */
			if(!($source = @ imagecreatefrompng($tmp_name))){
				return false;
			}
			else{
				return true;
			}
		}
		elseif(strstr($type, "gif")) {       /*上傳圖片類型為gif */
			if(!($source = @ imagecreatefromgif($tmp_name))){
				return false;
			}
			else{
				return true;
			}
		}
		else {
			return false;
		}
	}
	
	static function replaceSpecialChars($contens){
		$rules = array(
				'^A','^B','^C','^D','^E','^F','^G','^H','^I','^J','^K','^L','^M','^N','^O','^P','^Q','^R','^S','^T','^U','^V','^W','^X','^Y','^Z',
				'^a','^b','^c','^d','^e','^f','^g','^h','^i','^j','^k','^l','^m','^n','^o','^p','^q','^r','^s','^t','^u','^v','^w','^x','^y','^z',
				'&hellip;'
		);
	
		foreach($rules as $key => $value){
			$contens = str_replace($value,"",$contens);
		}
		$contens = preg_replace('/[(\x00-\x1F)]*/','', $contens);
		$contens = preg_replace('/[(\x7F)]*/','', $contens);
		return $contens;
	}
	
}

function smb_substr($str,$len,$text='...',$encode='UTF-8'){
	if(mb_strlen($str,$encode)>$len)
		return mb_substr($str,0,$len,$encode).$text;
	else
		return $str;
}

function toascii($s){
	$s=$s>=62?rand(0,61):$s;
	if($s<10)
		$ascii = 48+$s;
	else if($s>=10 && $s<36)
		$ascii = 55+$s;
	else
		$ascii = 61+$s;
	return chr($ascii);
}