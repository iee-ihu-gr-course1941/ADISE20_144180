<?php

function show_status() {

	global $mysqli;
	$sql = 'select * from ADISE20_144180.status';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

}


function read_status() {

    global $mysqli;
	$sql = 'select * from ADISE20_144180.status';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	$status = $res->fetch_assoc();
	return($status);
}

function game_status_update() {

    global $mysqli;
	$status = read_status();
	$new_status=null;
    $p_turn = null;
	$new_turn=null;

	$st3=$mysqli->prepare('select count(*) as aborted from ADISE20_144180.players WHERE last_action< (NOW() - INTERVAL 2 MINUTE)');
	$st3->execute();
	$res3 = $st3->get_result();
	$aborted = $res3->fetch_assoc()['aborted'];
	if($aborted>0) {
		$sql = "UPDATE ADISE20_144180.players SET username=NULL, token=NULL WHERE last_action< (NOW() - INTERVAL 2 MINUTE)";
		$st2 = $mysqli->prepare($sql);
		$st2->execute();
		if($status['status']=='started') {
			$new_status='aborted';
		}
	}


	$sql = 'select count(*) as c from ADISE20_144180.players where username is not null';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	$active_players = $res->fetch_assoc()['c'];


	switch($active_players) {

	    case 0: $new_status='not active'; break;

	    case 1: $new_status='initialized'; break;

	    case 2: $new_status='started';

			if($status['p_turn'] == null) {
				$new_turn='Y';
			}
			break;
	}

    $sql = 'update ADISE20_144180.status set status=?, p_turn=?';
    $st = $mysqli->prepare($sql);
    $st->bind_param('ss',$new_status,$new_turn);
    $st->execute();



}

?>