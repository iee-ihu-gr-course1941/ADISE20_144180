<?php

function show_board() {

	global $mysqli;
	$sql = 'select * from ADISE20_144180.board';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

}


function read_board()
{
    global $mysqli;
    $sql = 'select * from ADISE20_144180.board';
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    return ($res->fetch_all(MYSQLI_ASSOC));
}

function reset_board() {
    global $mysqli;
    $sql = 'call ADISE20_144180.cleaner()';
    $mysqli->query($sql);
    print json_encode(['mesg' => "Board Cleaned"]);
}


function move($input){
    $x = $input['x'];
    $y = $input['y'];
    $piece_color = $input['piece_color'];

        if($piece_color !== "R" and $piece_color !== "Y") {
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Invalid color, allowed only 'R' and 'Y'."]);
            exit;
        }

        if($x > 6 or $y >= 7) {
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Invalid numbers"]);
            exit;
        }

        if($x <= 0 or $y <= 0) {
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Invalid numbers"]);
            exit;
        }


    global $mysqli;
        $sql = 'call ADISE20_144180.move(?,?,?)';
        $st = $mysqli->prepare($sql);
        $st->bind_param('iis', $x, $y, $piece_color);
        $st->execute();
        header('Content-type: application/json');
        print json_encode(read_board(), JSON_PRETTY_PRINT);



}



?>
