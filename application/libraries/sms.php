<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

	class SMS{
		function __construct(){
		}
		
		function send($phonelist, $message){
			$username = "olinhall";
			$password = "o1234";
			$Sender = "OlinSchool";
			$message = @iconv("UTF-8","TIS-620",$message);
			$param = "User=$username&Password=$password&Msnlist=$phonelist&Msg=$message&Sender=$Sender";
			//echo $param;
			$API_URL = "http://member.smsmkt.com/SMSLink/SendMsg/index.php";
			
			$ch = curl_init();
// 			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
// 						'Content-Type: application/text',
// 						'charset=TIS-620',
// 					));
			
			//curl_setopt($ch, CURLOPT_HTTPHEADER,array("Expect:  "));
			
			curl_setopt($ch, CURLOPT_URL, $API_URL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
			
			$Result = curl_exec($ch);
			curl_close($ch);
			return $Result;
		}

	}

?>