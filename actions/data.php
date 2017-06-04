<?php 
    require_once("utils/functions.php");
    require_once("utils/errors.php");

    function getUserName($sessionId) {
        $fileName = "internal/sessions/" . $sessionId . ".txt";
        $file = fopen($fileName, "r"); //Открывает файл только для чтения
        $name = fgets($file); //Читает строку из файла
        fclose($file); //Закрывает файла, на который указывает дескриптор file
        return $name;
    }

    function getUserText($sessionId) {
    	$response = array(ERROR_MESSAGE => null, TEXT => null);
        if (($code = checkSessionId($sessionId)) != OK_ID) {
        	$response[ERROR_MESSAGE] = MessageCode($code);
        	return json_encode($response);
        }
        try {
            $username = getUserName($sessionId);
            if (($code = checkUsername($username)) != OK_ID) {
                $response[ERROR_MESSAGE] = MessageCode($code);
        	    return json_encode($response);    
            }
            $fileName = "internal/data/" . $username . ".txt";
            if (file_exists($fileName)) {
            	$file = fopen($fileName, "r");
            	$response[TEXT] = fread($file, filesize($fileName)); // читает до fileName байт из файлового указателя file и смещает указатель
            	fclose($file);
            } 
        } 
        catch(Error $e) { $response[ERROR_MESSAGE] = $e->getMessage(); }
        return json_encode($response);
    }

    function setUserText($sessionId, $text) {
        $response = array(ERROR_MESSAGE => null);
        if (($code = checkSessionId($sessionId)) != OK_ID) {
        	$response[ERROR_MESSAGE] = MessageCode($code);
        	return json_encode($response);
        }
        try {
            $username = getUserName($sessionId);

            if (($code = checkUsername($username)) != OK_ID) {
                $response[ERROR_MESSAGE] = MessageCode($code);
        	    return json_encode($response);    
            }
            $fileName = "internal/data/" . $username . ".txt";
            $file = fopen($fileName, "a+");
            fwrite($file, $text); // записывает text в содержимое file
        } 
        catch(Exception $e) { $response[ERROR_MESSAGE] = $e->getMessage(); }
        finally { fclose($file); }
        return json_encode($response);
    }

?>