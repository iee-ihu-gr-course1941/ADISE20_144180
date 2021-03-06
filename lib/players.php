<?php

function show_players() {

	global $mysqli;
	$sql = 'select * from ADISE20_144180.players';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

}


function show_player($r) {

    global $mysqli;
	$sql = 'select username, piece_color, token from ADISE20_144180.players where con4.piece_color=?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('s',$r);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}




function set_user($b, $input) {

	if(!isset($input['username'])) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"No username given."]);
		exit;
	}

	$username=$input['username'];

	global $mysqli;
	$sql = 'select count(*) as c from ADISE20_144180.players where piece_color=? and username is not null';
	$st = $mysqli->prepare($sql);
	$st->bind_param('s',$b);
	$st->execute();
	$res = $st->get_result();
	$r = $res->fetch_all(MYSQLI_ASSOC);
	if($r[0]['c']>0) {
		header("HTTP/1.1 400 Bad Request");
		print json_encode(['errormesg'=>"Player $b is already set. Please select another color."]);
		exit;
	}

	$sql = 'update ADISE20_144180.players set username=?, token=md5(CONCAT( ?, NOW()))  where piece_color=?';
	$st2 = $mysqli->prepare($sql);
	$st2->bind_param('sss',$username,$username,$b);
	$st2->execute();



    game_status_update();
	$sql = 'select * from ADISE20_144180.players where piece_color=?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('s',$b);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);


}

function handle_user($method, $b,$input) {
	if($method=='GET') {
		show_players($b);
	} else if($method=='POST') {
        set_user($b,$input);
    }
}




?>