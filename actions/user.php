<?php
$method_name = $_GET["method"];
require_once("utils/errors.php");
require_once("utils/functions.php");

	session_save_path("internal/sessions");
    session_start();
  
if(is_callable($method_name)) { $method_name(); }
else {
	    session_destroy();
		ErrorApi("This method is unreal !!! :( "); 
	}


function login() {
// добавляем исключение, если пользователь не дал логин!
	require_once("internal/avaible-users.php");
	$id = $_GET["id"];
	$pass = $_GET["pass"];
	$this_user_exists = false;
	$list_users = arr_users();
	
	for($i = 0;$i < count($list_users);$i++){
		if($list_users[$i] == $id){
			$this_user_exists = true;
		}
	}

 	if($this_user_exists){
 		$data = file("internal/data/$id.txt");
		list($password, $value) = explode('#', $data[0]);
		if($pass == $password){
	
			$_SESSION['id'] = $id;
			api_login_response(session_id()); //Ответ пользователя api
			successful_logout(); //Успешный выход из системы
		}
		else{ ErrorApi("Incorrect password"); }
	}

	else { user_doesnt_exists(); } //Пользователь не существует
}

function logout($login = NULL, $s_id = NULL){
	$s_id = $_GET['session_id'];
	if($_SESSION) {
	    session_destroy(); // Сессия уничтожена
	    successful("Logout successful");
	}
	else {
		api_response(array(ERROR_MSG => "You can not destroy the session !!!" ));
	}
}

?>