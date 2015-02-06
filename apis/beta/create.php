<?php define('APPAREL', TRUE);
require_once('nectar.php');

$_handle = strtolower($_POST['handle']);
$handle = $_POST['handle'];
$name = $_POST['name'];
$password = ENCRYPTME($_POST['password']);
$email = strtolower($_POST['email']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) die('a');
if (!preg_match('/^[A-Za-z0-9_]{1,15}$/', $handle)) die ('b');
if (strlen($password) < 6) die ('c');

try 
{
    $queryCheckEmail = $dbcon->prepare("SELECT * FROM `user` WHERE email = ? LIMIT 1");
    $queryCheckEmail->execute(array($email));
    
    $queryCheckHandle = $dbcon->prepare("SELECT * FROM `user` WHERE handle = ? LIMIT 1");
    $queryCheckHandle->execute(array($_handle));
    
    if ($queryCheckEmail->rowCount() == 0 && $queryCheckHandle->rowCount() == 0) 
	{
        $query = $dbcon->prepare("INSERT INTO `user` (email, handle, name, password, datecreated) VALUES (?, ?, ?, ?, ?)");
        $query->execute(array($email, $handle, $name, $password, date('Y-m-d H:i:s')));
		
		echo json_encode(array(
			"response" => "1",
			"token" => CreateToken(),
			"message" => ""
			 ));
    } 
    else
    {
		$error = "";
    	
    	if($queryCheckEmail->rowCount() == 0)
    		$error .= "Email already exists";

    	if($queryCheckEmail->rowCount() == 0)
    		$error .= "\nHandle already exists";

        echo json_encode(array(
			"response" => "0",
			"message" => $error
			 ));
    }
} 
catch(Exception $ex) 
{
    LogError($ex->getMessage());
}
?>