<?php define('APPAREL', TRUE);
require_once('nectar.php');

$caption = $_POST['caption'];
$tags = $_POST['tags'];
$gender = $_POST['gender'];
$handle = $_POST['handle'];

try 
{
	$posts = array();

    $query = $dbcon->prepare("INSERT INTO post (caption, gender, handle, datecreated, useragent) VALUES (?, ?, ?, ?, ?)");
    $query->execute(array($caption, $gender, $handle, , $_SERVER['HTTP_USER_AGENT']));

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