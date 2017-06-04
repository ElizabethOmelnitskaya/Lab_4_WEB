<?php

$availableUsers = array(array(USERNAME => "viktor", PASSWORD => "xampp324"), // массив существующих пользователей
	                    array(USERNAME => "july", PASSWORD => "1tadam34"),
	                    array(USERNAME => "kate", PASSWORD => "banana185"),
	                    array(USERNAME => "elizabeth", PASSWORD => "elizabeth3852"));


require_once("utils/functions.php");

function userExist($username) { // функция проверки существующего пользователя
	foreach ($GLOBALS['availableUsers'] as $user) { if ($username === $user[USERNAME]) return TRUE; }
	return FALSE;
}

function correctPassword($username, $password) { // функция проверки корректного пароля
	if (!userExist($username)) return FALSE;
	foreach ($GLOBALS['availableUsers'] as $user) {
		if ($username === $user[USERNAME] && $password === $user[PASSWORD]) return TRUE;
	}
	return FALSE;
}


 ?>