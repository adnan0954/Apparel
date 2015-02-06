<?php define('APPAREL', TRUE);
require_once('nectar.php');

$user = $_POST['user'];

try 
{
	$posts = array();

    $query = $dbcon->prepare("SELECT * FROM posts WHERE email = ?");
    $query->execute(array($user));

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
    {
        array_push($posts, $row);
    }

    echo json_encode($posts);
} 
catch(Exception $ex) 
{
    LogError($ex->getMessage());
}
?>