<?php
$db = pg_connect("host=ec2-54-235-193-0.compute-1.amazonaws.com port=5432 dbname=d6ccd2htpr3a7o user=hiaucjuwlowgrh password=2df3a048937c2f6a07847fb6816bf88582290e8249eac587eaf1c5b29e29998a");
echo $db;
//pg_query($db,"CREATE TABLE Customer1 (cus_id varchar(5) NOT NULL PRIMARY KEY, cus_name varchar(30) NOT NULL, cus_lastname varchar(30) NOT NULL, cus_pic varchar(30) NOT NULL)");
pg_query($db,"UPDATE Customer1 SET cus_id = 'C001' WHERE cus_name = 'Stamp' ");
pg_query($db,"INSERT INTO Customer1 (cus_id,cus_name,cus_lastname,cus_pic) VALUES ('C002','Pukky','Jungsiri','no')");
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
  if ( $event['type'] == 'message' ) 
  {
   if( $event['message']['type'] == 'text' )
   {
    $text = $event['message']['text'];
	
	$greeting = array('Hi','Hello','ดีจ้า','สวัสดี','สวัสดีครับ');
	
	$correct = 0;
	foreach ($greeting as $value)
	{
		if ($text == $value)
		{
			$correct = 1;
		}
	}
	if ($correct == 1)
	{
		$reply_message = 'Hi,what is you name';
	}
	elseif ($text=='button')
	{
		$reply_message = "1";

	}
	
	elseif ($text=='numcust')
	{
		$result = pg_query($db,"SELECT COUNT(*) FROM Customer1");
		$list = pg_fetch_row($result);
		$reply_message = " result = $list[0]";
	}
	elseif ($text=='showcust')
	{
		$result = pg_query($db,"SELECT cus_name FROM Customer1");
		while ($list = pg_fetch_row($result))
		{
			$cust = $list[0]."\n";
			$custlist .= $cust;
		}
		$reply_message = "$custlist";
	}
	elseif (substr($text,0,6) =='addcus')
	{
		list($order, $cusid, $cusname, $cuslast, $cuspic) = split(" ", $text, 5);
		//$cardata = explode(" ",$text);
		pg_query($db,"INSERT INTO Customer1 (cus_id,cus_name,cus_lastname,cus_pic) VALUES ($cusid,$cusname,$cuslast,$cuspic)");
		$result = pg_query($db,"SELECT cus_name FROM Customer1");
		while ($list = pg_fetch_row($result))
		{
			$cust = $list[0]."\n";
			$custlist .= $cust;
		}
		$reply_message = "$custlist";
	}
	else
	$reply_message = 'why dont you say hello to me';
   }
   else
    $reply_message = 'ระบบได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
	 
 
  if( strlen($reply_message) > 0 )
  {
   if($reply_message == '1')
   {
   //$data = ['replyToken' => $reply_token,
	//    'altText' => "This is Flex message",
	  //  'messages' => array('type' => 'flex', 'contents' => array('type' => 'bubble', 'body' => array('type' => 'box', 'layout' => 'vertical', 'contents' => array('type' => 'button', 'style' => 'primary', 'height' => 'sm', 'action' => array('type' => 'uri', 'label' => 'add', 'uri' => "https://developers.line.me")))))];
  // $data = ['type' => 'template', 'altText' => 'this is a button template', 'template' => array('type' => 'buttons', 'actions' => array('type'=> 'message', 'label' => 'Action1' , 'text' => 'click success ka'),'thumbnailImageUrl' => 'http://images6.fanpop.com/image/photos/38600000/Adventure-Time-cartoon-network-38672283-1600-900.jpg', 'title' => 'car', 'text' => 'mini')];
   $data = [
	'replyToken' => $reply_token,
	'messages' => [
		[
			'type' => 'flex', 
			'contents' => [
				'type' => 'bubble',
				'body' => [
					'type' => 'box',
					'layout' => 'vertical',
					'contents' => [
						[
							'type' => 'button',
							'style' => 'primary',
							'height' => 'sm',
							'action' => [
								'type' => 'uri',
								'label' => 'add',
								'uri' => "https://developers.line.me"
							]
						]
					]
				]
			]
		]
	]
];


   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
   file_put_contents("php://stderr", "POST REQUEST =====> ".$post_body);
   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
   file_put_contents("php://stderr", "POST RESULT =====> ".$send_result);

   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   }
   else
   {
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
