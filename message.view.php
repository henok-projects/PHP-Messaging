<?php
require_once 'test.php'; 
// Query messages 
$db = Database::getInstance(); 
$connection = $db->getConnection(); 
$stmt = $connection->prepare("SELECT * FROM messages"); 
$stmt->execute(); 
$messages = $stmt->fetchAll(); 

?>

<!DOCTYPE html> 
<html> 
<head> 
<title>Messaging App</title> 
</head> 
<body> 

<h1>Messages</h1> 

<ul> 
<?php foreach ($messages as $message) : ?> 

<?php endforeach; ?> 
</ul> 

</body> 
</html>