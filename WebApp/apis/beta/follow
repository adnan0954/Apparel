<?php define('APPAREL', TRUE);
require_once('nectar.php');

$user = $_POST['user'];
$email = $_POST['email'];
try 
{
    $query = $dbcon->prepare("INSERT INTO follow (email, follower, datecreated) VALUES (?, ?, ?)");
    $query->execute(array($email, $user, date('Y-m-d H:i:s')));

    $row = $query->fetch(PDO::FETCH_ASSOC);
    echo json_encode($row);
} 
catch(Exception $ex) 
{
    LogError($ex->getMessage());
}
?>