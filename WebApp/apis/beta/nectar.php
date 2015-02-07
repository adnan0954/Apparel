<?php if (!defined('APPAREL')) exit();

//DATABASE CONNECTION
define("VERSION", "BETA");
define("DATABASE", "timay_apparel");
define("HOST", "127.0.0.1");

$hostname = HOST;
$database = DATABASE;
$username = "timay_ADMIN";
$password = "%?C5PzaLHUd@";


$dbcon = new PDO("mysql:host=localhost;dbname=$database;charset=utf8mb4", $username, $password, array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//DATABASE CONNECTION END



//CLEAN POST
foreach($_POST as $key => &$value)
{
	$value = htmlspecialchars(stripslashes(trim($value)));
}


//LOG ERROR IN QUERIES
function LogError($message, $status = "0x903")
{
	global $dbcon;
	
	$log = $dbcon->prepare("INSERT INTO log_error(useragent, status, message, filename, ip, datecreated, serverversion) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$log->execute(array($_SERVER['HTTP_USER_AGENT'], $status, $message, $_SERVER['REQUEST_URI'], $_SERVER['REMOTE_ADDR'], date('Y-m-d H:i:s'), VERSION));
	
	die(json_encode(array("response" => "9", "message" => "Server side error")));
}



//CREATE VERIFICATION TOKEN
function CreateToken()
{
	global $dbcon;
	global $handle;
	
	try
	{
		$hash = strtoupper(substr(hash('sha256', microtime()), 15, -10).substr(hash('ripemd256', $handle), 15, -10));
		
		$query = $dbcon->prepare("INSERT INTO log_token (handle, token, useragent, datecreated, ip) VALUES (?, ?, ?, ?, ?)  ON DUPLICATE KEY UPDATE token = ?, useragent = ?, datecreated = ?");
		$query->execute(array($handle, $hash, $_SERVER['HTTP_USER_AGENT'], date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR'], $hash, $_SERVER['HTTP_USER_AGENT'], date('Y-m-d H:i:s')));

		return $hash;
	}
	catch(PDOException $ex) 
	{
		LogError($ex->getMessage(), '0x911');
	}
}


//LOG ACCESS
function LogAccess($status)
{
	global $dbcon;
	global $handle;

	$log = $dbcon->prepare("INSERT INTO log_access(useragent, handle, status, ip, datecreated, serverversion) VALUES (?, ?, ?, ?, ?, ?)");
	$log->execute(array($_SERVER['HTTP_USER_AGENT'], $handle, $status, $_SERVER['REMOTE_ADDR'], date('Y-m-d H:i:s'), VERSION));
}


//PASSWORD ENCRYPTION
function ENCRYPTME($plain)
{
	return strtoupper(substr(hash('md5', $plain), 15, -10).substr(hash('ripemd256', $plain), 15, -10));
}

?>