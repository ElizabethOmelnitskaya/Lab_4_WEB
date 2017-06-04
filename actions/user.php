<?php
	const TEMPLATE_SESSION = array(5, 4, 2, 10);

	require_once("utils/functions.php");
	require_once("utils/errors.php");

	function login($username, $password) {
		$response = array(ERROR_MESSAGE => null, SESSION => null);
		if (($code = checkPassword($username, $password)) != OK_ID) {
			$response[ERROR_MESSAGE] = MessageCode($code);
			return json_encode($response);
		}
		if (($code = checkUsername($username)) != OK_ID) {
			$response[ERROR_MESSAGE] = MessageCode($code);
			return json_encode($response);
		}
		try {
	        $sessionId = "";
	        $fileName = "";
	        do {
	        	$sessionId = generateSessionId();
	        	$fileName = "internal/sessions/" . $sessionId . ".txt";
	        } while (file_exists($fileName));

	        $file = fopen($fileName, "a+");
	        fwrite($file, $username);
	        $response[SESSION] = $sessionId;
		}
		catch (Exception $e) { $response[ERROR_MESSAGE] = $e->getMessage(); }
		finally { fclose($file); }
		return json_encode($response);
	}

	function logout($sessionId) {
		$response = array(ERROR_MESSAGE => null);
		if ($code = checkSessionId($sessionId) != OK_ID) {
			$response[ERROR_MESSAGE] = MessageCode($code);
			return json_encode($response);
		}
		try {
			$fileName = "internal/sessions/" . $sessionId . ".txt";
			unlink($fileName);
		} 
		catch (Exception $e) { $response[ERROR_MESSAGE] = $e->getMessage(); }
		return json_encode($response);
	}

	function generateSessionId() {
		$id = "";
		for ($i = 0; $i < count(TEMPLATE_SESSION); $i++) {
			for ($j = 0; $j < TEMPLATE_SESSION[$i]; $j++) { $id .= generateChar(); }
			if ($i != count(TEMPLATE_SESSION) - 1) $id .= '-';
		}
		return $id;
	}

	function generateChar() {
		if (rand(0, 1) == 0) { return chr(rand(ord('a'), ord('z'))); } 
		else { return rand(0, 9); }
	}

?>