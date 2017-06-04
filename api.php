<?php 
	require_once("utils/functions.php");
	require_once("utils/errors.php");
	require_once("actions/data.php");
	require_once("actions/user.php");

	echo handleQuery();
		
	function handleQuery() {
		set_exception_handler('handleException');
		set_error_handler('handleError');

		if ($_SERVER["REQUEST_METHOD"] == "GET") {

			$method = $_GET[METHOD_KEY];
			if (($code = checkMethod($method)) != OK_ID) { return jsonError($code); }

			$action = $_GET[ACTION_KEY];
			$code = checkAction($action);
			if (($code = checkAction($action)) != OK_ID) { return jsonError($code); }

			switch ($method) {
				case LOGIN:
					$username = $_GET[USERNAME];
					$password = $_GET[PASSWORD];
					return login($username, $password);
					break;

				case LOGOUT:
					$sessionId = $_GET[SESSION];
					return logout($sessionId);
					break;

				case SET_USER_DATA_METHOD:
					$sessionId = $_GET[SESSION];
					$text = $_GET[TEXT];
	                return setUserText($sessionId, $text);
					break;

				case GET_USER_DATA_METHOD:
					$sessionId = $_GET[SESSION];
	                return getUserText($sessionId);
					break;

				default:
					throw new Exception(UNKNOWN_EXCEPTION);
					break;
			}
		}
	}

?>