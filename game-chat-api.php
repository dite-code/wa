<?php
include("packet_class.php");
$servername = "localhost";
$username = "root";
$password = "camelia";
$dbname = "pw";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



function nama($no){
	$data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM users inner join rank on users.id=rank.userid where users.mobilenumber='$no' order by rank.time desc"));
	//echo $data['rolename'];
	return $data['rolename'];
}

function chat($from, $content){
	//$from = nama($from);
	$data = mysqli_fetch_assoc(mysqli_query($GLOBALS['conn'],"SELECT * FROM users inner join rank on users.id=rank.userid where users.mobilenumber='$from' order by rank.time desc"));
	//$from = $data['rolename'];
	$txt = "^ffdd99".$from.": ^ffdd00".$content;
	$ChatBroadCast = new WritePacket();
	$ChatBroadCast -> WriteUByte(9); 	//0:Umum, 1:Shout, 2:Party, 3:Guild, 7:Trade, 9:Sistem
	$ChatBroadCast -> WriteUByte(0); 				//Emotion
	$ChatBroadCast -> WriteUInt32(0);		//Roleid	but if offline then need to use 0
	$ChatBroadCast -> WriteUString($txt); 	//Text
	$ChatBroadCast -> WriteOctets(""); 				//Data
	$ChatBroadCast -> Pack(0x78); 					//Opcode
	$ChatBroadCast -> Send("localhost", 29300);
	//echo $txt;
}

//echo nama('6285373887411');
?>
