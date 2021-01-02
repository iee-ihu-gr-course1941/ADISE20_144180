<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

 
require_once "lib/dbconnect.php";
require_once "lib/board.php";
require_once "lib/game.php";
require_once "lib/players.php";



$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);



switch ($r = array_shift($request)) {
	
//check if board exists
    case 'board' :
        switch ($b=array_shift($request)) {
            case '':
            case null: handle_board($method);
                break;
            case 'piece': handle_piece($method, $input);
                break;
            case 'player': handle_player($method, $input);
                break;
            default: header("HTTP/1.1 404 Not Found");
                break;
        }
        break;

//check if status exists
    case 'status':
		if(sizeof($request)==0) {show_status();}
		else {header("HTTP/1.1 404 Not Found");}
		break;
    
//check if players exists
	case 'players':		
		handle_player($method, $request,$input);
        break;
    
    default:
        header("HTTP/1.1 404 Not Found");
        exit;
}

function handle_board($method) {
 
        if($method=='GET') {
                show_board();
        } else if ($method=='POST') {
                reset_board();
       }
		
}


//player validation
function handle_player($method, $request, $input) {
	switch ($r=array_shift($request)) {
		case '':
		case null: if($method=='GET') {show_players($method);}
				   else {header("HTTP/1.1 400 Bad Request"); 
						 print json_encode(['errormesg'=>"Method $method not allowed here."]);}
                    break;
        case 'R': 
		case 'Y': handle_user($method, $r, $input);
				  break;		
		default: header("HTTP/1.1 404 Not Found");
				 print json_encode(['errormesg'=>"Player $r not found."]);
                 break;
	}
}


function handle_piece($method, $input) {
    if($method=='GET') {
        show_board_piece();
    }else if($method=='POST') {
        move($input);
    }
}

?>