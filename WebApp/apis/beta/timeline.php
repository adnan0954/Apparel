<?php define('APPAREL', TRUE);
require_once('nectar.php');

$email = $_POST['email'];

try 
{
	$posts = array();

    $query = $dbcon->prepare("SELECT * FROM posts WHERE email in ( SELECT follower from follow WHERE email = ?)");
    $query->execute(array($email));

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