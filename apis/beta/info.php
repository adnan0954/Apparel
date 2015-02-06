<?php define('APPAREL', TRUE);
require_once('nectar.php');

$user = $_POST['user'];

try 
{
    $query = $dbcon->prepare("SELECT * FROM user WHERE email = ?");
    $query->execute(array($user));

    $row = $query->fetch(PDO::FETCH_ASSOC)
    echo json_encode($row);
} 
catch(Exception $ex) 
{
    LogError($ex->getMessage());
}
?>