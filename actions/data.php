<?php

require_once("utils/functions.php");
require_once("utils/errors.php");

$data_method = $_GET["method"]; //данные получаются через URL с использованием  документации $_GET. 

if(is_callable($data_method)){ $data_method(); } // может быть вызвано 
else { ErrorApi("This method is unreal !!! :( "); } // ошибка аpi

function correct_user(){ // функция существующего пользователя
	require_once("internal/avaible-users.php"); // файл откроется один раз
	$UserExists_1 = false; // существующий пользыватель 
	$id = $_SESSION['id']; // используется для получения или установки идентификатора текущей сесси
	$list_users1 = arr_users(); // массив пользователей
	for($i = 0; $i < count($list_users1); $i++){
		if($list_users1[$i] == $id){
			$UserExists_1 = true;
		}
	}
	return $UserExists_1;
}

function get(){
	$s_id = $_GET['session_id'];
	$id = $_SESSION['id'];
	$UserExists_1 = correct_user();

	if($UserExists_1){ $info = file("internal/data/$id.txt"); }
	else { ErrorApi("You do not have permission to this information!!! :("); }

	list($password, $value) = explode('#', $info[0]); //Функция explode() возвращает массив элементами которого являются строки, полученные разбиением строки (info) при помощи разделителя #

	if(sessionId() == $s_id) { Api_data_answer($value); } //Ответ данных Api
	else{ ErrorApi("Wrong session !!!"); }
}

	function set(){
		$s_id = $_GET['session_id'];
		$id = $_SESSION['id'];
		$somestring = $_GET['text'];
		$UserExists_2 = correct_user();
		if($s_id == sessionId()){
			if($UserExists_2){
				$file = file("internal/data/$id.txt");
				$f_f = "internal/data/$id.txt";

				list($password, $value) = explode('#', $file[0]);

				$content = "$password*$somestring";
				file_put_contents($f_f,$content);

				successful("String added !!!"); //вызывается после успешного завершения
			}
			else{ ErrorApi("Wrong session !!!"); }
		}
		else{ ErrorApi("Wrong session !!!"); }
	}
?>