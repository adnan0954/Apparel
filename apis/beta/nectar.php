<?php if (!defined('APPAREL')) exit();

define("VERSION", "BETA");
define("DATABASE", "timay_apparel");
define("HOST", "127.0.0.1");

$hostname = HOST;
$database = DATABASE;
$username = "timay_ADMIN";
$password = ";#lX&I468IZD";

$dbcon = new PDO("mysql:host=localhost;dbname=$database;charset=utf8mb4", $username, $password, array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


function LogError($message, $status = "0x903")
{
	global $dbcon;
	
	$log = $dbcon->prepare("INSERT INTO log_error(useragent, status, message, filename, ip, datecreated, serverversion) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$log->execute(array($_SERVER['HTTP_USER_AGENT'], $status, $message, $_SERVER['REQUEST_URI'], $_SERVER['REMOTE_ADDR'], date('Y-m-d H:i:s'), VERSION));
	
	die(json_encode(array("response" => "9", "message" => "Server side error")));
}

function CreateToken()
{
	global $dbcon;
	global $email;
	global $deviceid;
	global $source;
	
	try
	{
		$hash = strtoupper(substr(hash('sha256', microtime()), 15, -10).substr(hash('ripemd256', $email.$deviceid), 15, -10));
		
		$query = $dbcon->prepare("INSERT INTO log_token (email, token, useragent, datecreated, ip) VALUES (?, ?, ?, ?, ?)  ON DUPLICATE KEY UPDATE token = ?, useragent = ?, datecreated = ? WHERE email = ?");
		$query->execute(array($email, $hash, $_SERVER['HTTP_USER_AGENT'], date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR'], $hash, $_SERVER['HTTP_USER_AGENT'], date('Y-m-d H:i:s'), $email));

		return $hash;
	}
	catch(PDOException $ex) 
	{
		LogError($ex->getMessage(), '0x911');
	}
}

function LogAccess($status)
{
	global $dbcon;
	global $email;

	$log = $dbcon->prepare("INSERT INTO log_access(useragent, email, status, ip, datecreated, serverversion) VALUES (?, ?, ?, ?, ?, ?)");
	$log->execute(array($_SERVER['HTTP_USER_AGENT'], $email, $status, $_SERVER['REMOTE_ADDR'], date('Y-m-d H:i:s'), VERSION));
}

?>