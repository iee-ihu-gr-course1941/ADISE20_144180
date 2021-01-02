var me={ username: null, token: null, piece_color: null };
var game_status= {};
var board= {};
var timer= null;

$(function () {
	fill_board();
	game_status_update();

});


function login_to_game() {
	if($('#username').val()=='') {
		alert('You have to set a username');
		return;
	}

	
	$.ajax({
		url: "connect4.php/players/",
		method: 'POST',
		dataType: "json",
		headers: {"X-Token": me.token},
		contentType: 'application/json',
		data: JSON.stringify( {username: $('#username').val(), piece_color: $('#piece_color').val()}),
		success: login_result,
		error: login_error});
}

function login_result(data) {
	me = data[0];
	update_info();
	game_status_update();
}

function login_error(data) {
	var x = data.responseJSON;
	alert(x.errormesg);
}

function game_status_update() {
	$.ajax({
		url: "connect4.php/status/",
		success: update_status,
		headers: {"X-Token": me.token} });
}

function update_status(data) {
	var game_stat_old = game_status;
	game_status=data[0];
	update_info();
	if(game_status.p_turn==me.piece_color &&  me.piece_color!=null) {
		x=0;

		if(game_stat_old.p_turn!=me.piece_color) {
			fill_board();
		}
		setTimeout(function() { game_status_update();}, 15000);
	} else {
		setTimeout(function() { game_status_update();}, 4000);
	}

}



function game_status_update() {

	clearTimeout(timer);
	$.ajax({url: "connect4.php/status/",
		success: update_status,
		headers: {"X-Token": me.token} });
}



function fill_board() {
	$.ajax({url: "connect4.php/board/",
		headers: {"X-Token": me.token},
		success: fill_board_by_data });

}

function move() {

	$.ajax({
		url: "connect4.php/board/move/",
		method: 'POST',
		dataType: 'json',
		headers: { "X-Token": me.token },
		contentType: 'application/json',
		data: JSON.stringify({ x: $x, y: $y, piece_color: me.piece_color }),
		success: result_move,
		error: login_error
	});

}

function move_result(data){
	game_status_update();
	fill_board_by_data(data);
}