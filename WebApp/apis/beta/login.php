<?php define('APPAREL', TRUE);
require_once('nectar.php');

$handle = strtolower($_POST['handle']);
$password = ENCRYPTME($_POST['password']);

try 
{
    $query = $dbcon->prepare("SELECT * FROM `user` WHERE handle = ? LIMIT 1");
    $query->execute(array($handle));
    
    if ($query->rowCount() == 1) 
	{
        LogAccess("Sign In");
        $row = $query->fetch(PDO::FETCH_ASSOC);
		echo json_encode(array(
			"response" => "1",
			"token" => CreateToken(),
			"message" => "",
            "info" => array('name' => $row['name'],
                            'tags' => explode('/', $row['tags']),
                            'handle' => $row['handle'],
                            'email' => $row['email'],
                            'number' => $row['number'],
                            'address' => $row['address'],
                            'following' => $row['following'],
                            'followers' => $row['followers'],
                            'rating' => $row['rating'],
                            'picture' => $row['picture'],
                            )
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