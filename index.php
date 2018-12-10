<?php

$db = pg_connect("host=ec2-54-235-193-0.compute-1.amazonaws.com port=5432 dbname=d6ccd2htpr3a7o user=hiaucjuwlowgrh password=2df3a048937c2f6a07847fb6816bf88582290e8249eac587eaf1c5b29e29998a");
echo $db;

//pg_query($db,"CREATE TABLE Customer1 (cus_id varchar(5) NOT NULL PRIMARY KEY, cus_name varchar(30) NOT NULL, cus_lastname varchar(30) NOT NULL, cus_pic varchar(30) NOT NULL)");


//pg_query($db,"INSERT INTO Customer1 (cus_id,cus_name,cus_lastname,cus_pic) VALUES ('C003','AAA','ABC','no')");
$result = pg_query($db,"SELECT COUNT(*) FROM Customer1");
$list = pg_fetch_row($result);
echo  "result = $list[0] <br>";

$result = pg_query($db,"SELECT * FROM Customer1");
while ($list = pg_fetch_row($result))
echo  "result = $list[0].$list[1].$list[2].$list[3]<br>";

/*
pg_query($db,"CREATE TABLE Garage (
gar_id varchar(10) NOT NULL,
gar_name varchar(40) NOT NULL),
gar_tel varchar(10) NOT NULL");


pg_query($db,"INSERT INTO Garage VALUES ('g01','อู่คุณ A','0812223333')");

$result = pg_query($db,"SELECT * FROM Garage");
$list = pg_fetch_row($result);
echo "result = $list[0]";

*/

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'L0246N0Dd1KuwHuzqr88jOCehjzvrytHUf+Yrdq5cD6omLdxDQGGFcvQBIMemj5NzlLRmgGiFA2sTLoxwN5PVxXN2QMwMf3Y45fLcYsi6wI2Sw7BoqUzGU4kCU6I9NJwsVlnibO8YL6Id1U9rHEkowdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);
$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array
if ( sizeof($request_array['events']) > 0 )
{
 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];
if ( sizeof($request_array['events']) > 0 )
{
 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];
  if ( $event['type'] == 'message' ) 
  {
   if( $event['message']['type'] == 'text' )
   {
    $text = $event['message']['text'];
	$car = array('"1"',"1","ค้นหารถ","รถ","หารถ","ยี่ห้อรถ");
	$tel = array("tel","เบอร์","หาเบอร์","2",'"2"',"โทร","เบอร์โทร");
	   
	$check = 0;
	
	foreach ($car as $value)
	{
		if($text == $value)
		{
			$check=1;
		}
	}
	foreach ($tel as $value)
	{
		if($text == $value)
		{
			$check=2;
		}
	}
	
	/*if($check ==1)
	{
		$result = pg_query($db,"SELECT COUNT(*) FROM Customer");
		$list = pg_fetch_row($result);
		$reply_message = " result = $list[0]";
	}
	elseif($check ==2)
	{
		pg_query($db,"INSERT INTO Customer VALUES ('c01','Somkit')");
		$reply_message = 'อู่คุณวิชัย 023334444';
	}*/
	elseif($text==3)
	{
		$reply_message = 'บัญชีประจำเดือน ธันวาคม 2561, ค่าใช้จ่าย 3,000 บาท, เงินสดหมุนเวียน 400,000 บาท ต้องการเพิ่มข้อมูล กด "4"';
	}
	/*elseif($text==4)
	{
		$result = pg_query($db,"SELECT Customer1.cus_name FROM Customer1");
		$custlist ='';
		while ($list = pg_fetch_row($result))
		$custlist += $list
		$reply_message = "$custlist";
	}*/
	
		
	   
	else
		$reply_message = 'พิมพ์ "1" เมื่อต้องการค้นหารถ, พิมพ์ "2" เมื่อต้องการค้นหาเบอร์ติดต่อของบริษัท, พิมพ์ "3" เมื่อต้องการตรวจสอบการเงิน,พิมพ์ "4" เมื่อต้องการเรียกดูข้อมูลลูกค้า' ;
   }
   else
    $reply_message = 'ระบบได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}

echo "OK";
	 
function send_reply_message($url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 curl_close($ch);
 return $result;
}
?>
