<?php 
require_once("config.php");
$client = $ts3_VirtualServer->clientGetByUid("$client_uid");
$client_groups = explode(",",$client["client_servergroups"]);
$last_added = array();
$last_removed = array();
	foreach($games_groups as $game) {
		if(isset($_POST["game_".$game])) {
			try { $client->addServerGroup($game); array_push($last_added, $game);}
			catch (Exception $e) {}
		}
		if(!isset($_POST["game_".$game])) {
			try { $client->remServerGroup($game); array_push($last_removed, $game);}
			catch (Exception $e) {} 
		}
	}
?>
<html>
<head>
	<title><?php echo $community; ?> - Icons System</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.0.0/materia/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Do+Hyeon|Anton" rel="stylesheet">
	<style>
		body { background-color: #fafafa; }
		.title { margin-top: 50px; text-align: center; font-family: 'Do Hyeon', bold, italic; font-size: 50px;}
		form { margin-top: 30px; }
		.form-check { text-align: center; margin-top: 20px; }
		.form-check-label { margin-left: 15px; font-size: 25px; font-family: 'Anton', bold, italic; }
		input[type=checkbox]{ -ms-transform: scale(2); -moz-transform: scale(2); -webkit-transform: scale(2); -o-transform: scale(2); }
		.button { background-color: #0368ff; border: none; color: white; padding: 10px 55px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; -webkit-transition-duration: 0.4s; transition-duration: 0.4s; cursor: pointer; border-radius: 30px; border: 2px solid #008CBA; }
		.button:hover { background-color: #03bcff; color: white; }
	</style>
</head>
<body>
	<div>
		<h1 class="title"><?php if ($is_online < 1) { die("You are not Connected to the server, Please Connect by clicking <a href='ts3server://".$config['ip']."'>here</a>"); } echo $community; ?> - Icons System</h1>
		<form method="POST">
		<?php foreach($games_groups as $game) {?>
			<div class="form-check">
				<input type="checkbox" name="game_<?php echo $game; ?>" class="form-check-input" id="game_<?php echo $game; ?>" <?php foreach($client_groups as $client_group) { if (!in_array($game, $last_removed)) { if($client_group == $game || in_array($game, $last_added)) { echo "checked=\"\""; } } } ?> value="1">
				<label class="form-check-label" for="game_<?php echo $game; ?>"><?php echo $ts3_VirtualServer->serverGroupList()[$game]; ?></label>
			</div>
		<?php } ?>
			<div class="form-check">
				<input type="submit" name="set" value="Set My Games" class="button">
			</div>
		</form>
	</div>
</body>
</html>
