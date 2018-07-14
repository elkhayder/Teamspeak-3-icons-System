<?php
require_once("TeamSpeak3/TeamSpeak3.php");
session_start();
$is_online = 0;
/////////////////////////////////////////////
/* Teamspeak Config */
$community = "The Deathly Elite"; //Community name, Exemple : The Deathly Elite
$config = array(
	"ip" => "thedeathlyelite.xyz", // Teamspeak server ip or dns, don't put LocalHost
	"query_port" => 10011, // Query login port, Default : 10011
	"server_port" => 9987, // Server Port, Default : 9987
	"bot_nickname" => "Icons Bot", // Bot nick displayed at connect, you can put any thing u want
	"login_name" => "serveradmin", // Query login name 
	"login_password" => "*******" // Query login password 
	);
/////////////////////////////////////////////
/* games Config */
$games_groups = array(17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,41);
//////////////////////////////////////////////
try {
	$ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$config["login_name"].":".$config["login_password"]."@".$config["ip"].":".$config["query_port"]."/?server_port=".$config["server_port"]."&blocking=0&nickname=".urlencode($config["bot_nickname"]." - ".rand(1,1000)));
	foreach ($ts3_VirtualServer->clientList() as $client) {
		if ($client->getProperty('connection_client_ip') == $_SERVER["REMOTE_ADDR"]) {
			$_SESSION['client_nickname'] = $client->client_nickname;
			$_SESSION['client_uid'] = $client["client_unique_identifier"];
			$is_online++;
		}
	}
}
catch (Exception $e) { 
	die('<div style="background-color:red; color:white; display:block; font-weight:bold;">QueryError: ' . $e->getCode() . ' ' . $e->getMessage() . '</div>');
}
$client_uid = $_SESSION["client_uid"];
$client_nickname = $_SESSION["client_nickname"];
