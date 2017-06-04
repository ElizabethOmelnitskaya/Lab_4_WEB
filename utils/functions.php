<?php 
	//требуемые константы
	const USERNAME = "username";
	const PASSWORD = "password";
	const SESSION = "sessionId";

	const USER = "user";
	const DATA = "data";

	const LOGIN = "login";
	const LOGOUT = "logout";

	const SET_USER_DATA_METHOD = "set";
	const GET_USER_DATA_METHOD = "get";

	const ACTION_KEY = "action";
	const METHOD_KEY = "method";
	
	const TEXT = "text";
	const ERROR_MESSAGE = "errorMessage";
	const ERROR_TEXT = "error";
	const EXCEPTION_TEXT = "exception";

	const INPUT_TEXT = "input data";

	require_once("internal/available-users.php");
	require_once("utils/errors.php");

	function checkUsername($username) { //проверка имени пользователя
		if (empty($username)) { return INCORRECT_INPUT_ID; }
		if (!userExist($username)) { return UNKNOWN_USERNAME_ID; }
		return OK_ID;
	}

	function checkPassword($username, $password) {//проверить пароля
	    if (empty($username) || empty($password)) { return INCORRECT_INPUT_ID; }
	    if (!correctPassword($username, $password)) { return INCORRECT_PASSWORD_ID; }
	    return OK_ID;
	}

	function checkSessionId($sessionId) { //проверка сесии
	    if (empty($sessionId)) { return INCORRECT_INPUT_ID; }
	    $fileName = "internal/sessions/" . $sessionId . ".txt";
	    if (!file_exists($fileName)) { return UNKNOWN_SESSION_NAME_ID; }
	    return OK_ID;
	}

	function checkAction($action) { //проверка действия
		if (empty($action)) { return INCORRECT_INPUT_ID; }
		if ($action != USER && $action != DATA) { return UNKNOWN_ACTION_ID; }
		return OK_ID;
	}

	function checkMethod($method) { // проверка метода
		if (empty($method)) { return INCORRECT_INPUT_ID; }
		if ($method != LOGIN && $method != LOGOUT && $method != SET_USER_DATA_METHOD && $method != GET_USER_DATA_METHOD) { return UNKNOWN_METHOD_ID; }
		return OK_ID;
	}
 ?>