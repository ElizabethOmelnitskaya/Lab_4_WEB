<?php
	//требуемые константы
	const OK_ID = 0;
	const INCORRECT_PASSWORD_ID = 1;
	const UNKNOWN_USERNAME_ID = 2;
	const UNKNOWN_SESSION_NAME_ID = 3;
	const UNKNOWN_ACTION_ID = 4;
	const UNKNOWN_METHOD_ID = 5;
	const INCORRECT_INPUT_ID = 6;

	const E_WARNING_STRING = "";
	const E_NOTICE_STRING = "";
	const E_USER_ERROR_STRING = "";
	const E_USER_WARNING_STRING = "";
	const E_USER_NOTICE_STRING = "";
	const E_RECOVERABLE_ERROR_STRING = "";
	const E_ALL_STRING = "";

	require_once("utils/functions.php");

	function unknown_data($input) { // неизвестные данные
		return "Unknown " . $input . "!";
	}

	function incorrect_data($input) { // неверные данные
		return "Incorrect " . $input . "!";
	}

	function handleException($exception) {
		echo "<p>Exception occured!<br>" . "Message:" . $exception->errorMessage() . "</p>";
	}

	function MessageCode($code) { // сообщение из кода
		switch ($code) {
			case INCORRECT_PASSWORD_ID:
				return incorrect_data(PASSWORD);
				break;

			case UNKNOWN_USERNAME_ID:
				return unknown_data(USERNAME);
				break;	

			case UNKNOWN_SESSION_NAME_ID:
					return unknown_data(SESSION);
					break;	

			case UNKNOWN_ACTION_ID:
				return unknown_data(ACTION_KEY);
				break;

			case UNKNOWN_METHOD_ID:
				return unknown_data(METHOD_KEY);
				break;

			case INCORRECT_INPUT_ID:
				return incorrect_data(INPUT_TEXT);
				break;

			default:
				return unknown_data(EXCEPTION_TEXT);
				break;
		}
	}

	function jsonError($code) { //Json ошибка из кода
		$responseString = MessageCode($code); // строка ответа в соответствии с функцией сообщения из кода
		return json_encode(array(ERROR_MESSAGE => $responseString));
	}

	function getStingFromErrorLevel($lvl) {
		switch ($lvl) {
			case E_WARNING:
				return E_WARNING_STRING;
				break;
		    case E_NOTICE:
				return E_NOTICE_STRING;
				break;
			case E_USER_ERROR:
				return E_USER_ERROR_STRING;
				break;
			case E_USER_WARNING:
				return E_USER_WARNING_STRING;
				break;
			case E_USER_NOTICE:
				return E_USER_NOTICE_STRING;
				break;
			case E_RECOVERABLE_ERROR:
				return E_RECOVERABLE_ERROR_STRING;
				break;
			case E_ALL:
				return E_ALL_STRING;
				break;
			default:
				return UNKNOWN_ERROR_STRING;
				break;
		}
	}

	function handleError($lvl, $message, $file = "Unknown", $line = -1, $context = "") {
		echo "<p>Error occured! Level: " . getStingFromErrorLevel($lvl) . "<br>" . "Message: " . $message . "<br>" . "File: " . $file . " , Line: " . $line . "</p>";
		die();
	}

 ?>