<?php

function show_board() {
	
	global $mysqli;
	$sql = 'select * from con4.board';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);

}


function read_board()
{
    global $mysqli;
    $sql = 'select * from con4.board';
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    return ($res->fetch_all(MYSQLI_ASSOC));
}


function show_board_piece($x,$y) {
    show_board_pieces([[ 'x'=>$x, 'y'=>$y]]);
}

function move($input){
        $x = $input['x'];
        $y = $input['y'];
        $piece_color = $input['piece_color'];
        global $mysqli;
        $sql = 'call con4.move(?,?,?)';
        $st = $mysqli->prepare($sql);
        $st->bind_param('iis', $x, $y, $piece_color);
        $st->execute();
        header('Content-type: application/json');
        print json_encode(read_board(), JSON_PRETTY_PRINT);

}



?>