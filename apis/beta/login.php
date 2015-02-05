<?php define('APPAREL', TRUE);
require_once('nectar.php');

$handle = strtolower($postvalues['handle']);
$password = ENCRYPTME($postvalues['password']);

try 
{
    $queryCheckHandle = $dbcon->prepare("SELECT * FROM `user` WHERE handle = ? LIMIT 1");
    $queryCheckHandle->execute(array($handle));
    
    if ($queryCheckHandle->rowCount() == 1) 
	{
        $query = $dbcon->prepare("INSERT INTO `user` (email, handle, name, password, datecreated) VALUES (?, ?, ?, ?, ?)");
        $query->execute(array($email, $handle, $name, $password, date('Y-m-d H:i:s')));
		
        LogAccess("Sign In");
		echo json_encode(array(
			"response" => "1",
			"token" => CreateToken(),
			"message" => ""
			 ));
    } 
    else
    {
        echo json_encode(array(
			"response" => "0",
			"message" => "Wrong username or password"
			 ));
    }
} 
catch(Exception $ex) 
{
    LogError($ex->getMessage());
}
?>